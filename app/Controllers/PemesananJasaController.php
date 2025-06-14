<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enum\StatusPembayaranEnum;
use App\Models\JasaModel;
use App\Models\PembayaranModel;
use App\Models\PemesananJasaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Constants;
use DateInterval;
use DatePeriod;
use DateTime;

class PemesananJasaController extends BaseController
{
    public function index()
    {
        error_log("start get all pemesanan jasa");
        $pemesananJasaModel = new PemesananJasaModel();
        try {
            $cacheRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            error_log("cache role : " . json_encode($cacheRole));
            //validasi jika user rolenya USER maka ambil data current user
            $result = [];
            if (session()->get('role') == $cacheRole['id_role']) {
                $idUser = session()->get('user_id');
                $cachePelanggan = getCache(Constants::PELANGGAN_KEY . $idUser);
                error_log("cache pelanggan : " . json_encode($cachePelanggan));
                //role user ambil transaksi pemesanan yang current user saja
                $result = $pemesananJasaModel->getTransaksiPemesananJasaJoinPembayaranByIdPelanggan($cachePelanggan['id_pelanggan']);
                error_log("result : " . json_encode($result));
            } else {
                //role admin ambil semua transaksi pemesanan
                $result = $pemesananJasaModel->getTransaksiPemesananJasaJoinPembayaran();
            }
            error_log("result : " . json_encode($result));
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error get data pemesanan : " . $th->getMessage());
        }
        $data = [
            'transaksi' => $result,
            'role' => $cacheRole,
        ];
        return view('pages/pemesanan_jasa', $data);
    }

    public function add()
    {
        error_log("start get page pemesanan jasa");
        $jasaModel = new JasaModel();
        try {
            //code...
            $jasaData = $jasaModel->where('is_deleted', 0)->findAll();
            $data = [
                'jasas' => $jasaData
            ];
            return view('pages/pemesanan_jasa_add', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error get data jasa : " . $th->getMessage());
            throw $th;
        }
    }

    public function save()
    {
        error_log("start save pemesanan jasa");
        $pesanJasaModel = new PemesananJasaModel();
        $pembayaranModel = new PembayaranModel();
        $idUser = session()->get('user_id');


        db_connect()->transStart(); // Start transaction
        try {
            // todo validasi data terbooking yang jadwalnya bentrok
            // Validate if equipment is already booked for the requested date
            // $requestedDate = parseAndFormatDate($this->request->getPost('jadwal'));
            // $requestedAlatId = $this->request->getPost('alat');

            // error_log("requested date : ".$requestedDate);
            // error_log("requested alat id : ".$requestedAlatId);
            // // Get existing bookings for the requested equipment and date
            // $existingBookings = $pesanJasaModel->getDataBooked($requestedAlatId, $requestedDate);
            // error_log("existing bookings : ".json_encode($existingBookings));
            // if (!empty($existingBookings)) {
            //     error_log("equipment is already booked or not available");
            //     return redirect()->to('/penyewaan-table')->with('error', 'Alat sudah terbooking atau tidak tersedia');
            // }

            $cachePelanggan = getCache(Constants::PELANGGAN_KEY . $idUser);
            $dataPemesanan = [
                'id_jasa' => $this->request->getPost('jasa'),
                'id_pelanggan' => $cachePelanggan['id_pelanggan'],
                'tanggal' => $this->request->getPost('jadwal'),
                'total' => $this->request->getPost('hargasewa'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('username'),
            ];
            error_log("data pemesanan");
            error_log(json_encode($dataPemesanan));
            $idPemesananJasa = $pesanJasaModel->insert($dataPemesanan);
            if ($idPemesananJasa === false || $idPemesananJasa === null) {
                error_log("error insert pemesanan");
                $errors = $pesanJasaModel->errors(); // Ambil pesan error validasi
                throw new \RuntimeException("Gagal save data pemesanan alat: " . implode(', ', $errors));
            }
            $dataPembayaran = [
                'id_pemensanan' => $idPemesananJasa,
                'transaction_id' => generateTransactionId(),
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'status_pembayaran' => StatusPembayaranEnum::BOOKED->value,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('username'),
            ];
            error_log("data pembayaran");
            error_log(json_encode($dataPembayaran));
            $pemayaran = $pembayaranModel->insert($dataPembayaran);
            if ($pemayaran === false || $pemayaran === null) {
                error_log("error insert pembayaran");
                $errors = $pembayaranModel->errors(); // Ambil pesan error validasi
                throw new \RuntimeException("Gagal save table pembayaran: " . implode(', ', $errors));
            }
            db_connect()->transComplete(); // Commit transaction
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback(); // Rollback transaction
            error_log("error save Pemesanan : " . $th->getMessage());
            // return redirect()->to('/Pemesanan-table')->with('error', 'Pemesanan gagal ditambahkan');
        }


        return redirect()->to('/pemesanan-table')->with('success', 'Pemesanan berhasil ditambahkan');
    }

    public function getJadwal()
    {
        error_log("start get jadwal booked");
        $pemesananJasaModel = new PemesananJasaModel();
        try {
            $idJasa = $this->request->getPost('id_jasa');
            error_log("id jasa : " . $idJasa);
            $startDate = new DateTime('now');
            $endDate = new DateTime('+10 day');

            // Get all booked slots between start and end date
            $booked = $pemesananJasaModel->getBookedPemesananJasa($startDate, $endDate, $idJasa);

            $bookedSlots = [];
            foreach ($booked as $b) {
                list($tanggal, $waktu) = explode(' ', $b['tanggal']);
                $jam = substr($waktu, 0, 5);
                $bookedSlots[$tanggal][$jam] = true;
            }

            // Generate available time slots
            $availableSlots = [];
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

            foreach ($period as $date) {
                $tanggal = $date->format('Y-m-d');
                for ($hour = 9; $hour <= 18; $hour++) {
                    $waktu = sprintf('%02d:00', $hour);
                    $slot = $tanggal . ' ' . $waktu;

                    $availableSlots[$tanggal][] = [
                        'time' => $waktu,
                        'booked' => isset($bookedSlots[$tanggal][$waktu])
                    ];
                }
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'booked_slots' => $bookedSlots,
                    'available_slots' => $availableSlots
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error get jadwal : " . $th->getMessage());
            throw $th;
        }
    }
}
