<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enum\StatusPembayaranEnum;
use App\Models\PenyewaanAlatModel;
use App\Models\AlatModel;
use App\Models\PembayaranModel;
use App\Models\TransactionTempModel;
use CodeIgniter\HTTP\ResponseInterface;
use Constants;
use DateInterval;
use DatePeriod;
use DateTime;

class PenyewaanAlatController extends BaseController
{
    public function index()
    {
        error_log("get page penyewaan");
        $sewaAlatModel = new PenyewaanAlatModel();
        try {
            $cacheRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            error_log("cache role : " . json_encode($cacheRole));
            //validasi jika user rolenya USER maka ambil data current user
            $result = [];
            if (session()->get('role') == $cacheRole['id_role']) {
                $idUser = session()->get('user_id');
                $cachePelanggan = getCache(Constants::PELANGGAN_KEY . $idUser);
                error_log("cache pelanggan : " . json_encode($cachePelanggan));
                //role user ambil transaksi penyewaan yang current user saja
                $result = $sewaAlatModel->getTransaksiSewaJoinPembayaranByIdPelanggan($cachePelanggan['id_pelanggan']);
            } else {
                $result = $sewaAlatModel->getTransaksiSewaJoinPembayaran();
            }
            error_log("result : " . json_encode($result));
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error get data penyewaan : " . $th->getMessage());
        }
        $data = [
            'transaksi' => $result,
            'role' => $cacheRole,
        ];
        return view('pages/penyewaan', $data);
    }

    public function add()
    {
        $alatModel = new AlatModel();
        $alatData = $alatModel->where('is_deleted', 0)->findAll();
        error_log("alat data : " . json_encode($alatData));
        $data = [
            'alats' => $alatData,
        ];
        return view('pages/penyewaan_add', $data);
    }

    public function save()
    {
        error_log("start save penyewaan alat");
        $sewaAlatModel = new PenyewaanAlatModel();
        $pembayaranModel = new PembayaranModel();
        $idUser = session()->get('user_id');


        db_connect()->transStart();
        try {
            $cachePelanggan = getCache(Constants::PELANGGAN_KEY . $idUser);
            $dataAlat = [
                'id_alat' => $this->request->getPost('alat'),
                'id_pelanggan' => $cachePelanggan['id_pelanggan'],
                'tanggal' => $this->request->getPost('jadwal'),
                'total' => $this->request->getPost('hargasewa'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session()->get('username'),
            ];
            error_log("data penyewaan");
            error_log(json_encode($dataAlat));
            $idPenyewaan = $sewaAlatModel->insert($dataAlat);
            if ($idPenyewaan === false || $idPenyewaan === null) {
                error_log("error insert penyewaan");
                $errors = $sewaAlatModel->errors();
                throw new \RuntimeException("Gagal save data penyewaan alat: " . implode(', ', $errors));
            }
            $dataPembayaran = [
                'id_penyewaan' => $idPenyewaan,
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
            db_connect()->transComplete();
        } catch (\Throwable $th) {
            db_connect()->transRollback();
            error_log("error save penyewaan : " . $th->getMessage());
            throw $th;
        }


        return redirect()->to('/penyewaan-table')->with('success', 'Penyewaan berhasil ditambahkan');
    }

    public function getJadwal()
    {
        error_log("start get jadwal booked");
        $sewaAlatModel = new PenyewaanAlatModel();
        try {
            $idAlat = $this->request->getPost('id_alat');
            $idPenyewaan = $this->request->getPost('id_penyewaan');
            error_log("id alat : " . $idAlat);
            $startDate = new DateTime('now');
            $endDate = new DateTime('+10 day');
            $dataPenyewaan = [];
            if ($idPenyewaan) {
                $dataPenyewaan = $sewaAlatModel->where('id_penyewaan', $idPenyewaan)->first();
                error_log("data penyewaan : " . json_encode($dataPenyewaan));
            }

            // Get all booked slots between start and end date
            $booked = $sewaAlatModel->getBookedPenyewaanAlat($startDate, $endDate, $idAlat);
            $bookedSlots = [];
            foreach ($booked as $b) {
                list($tanggal, $waktu) = explode(' ', $b['tanggal']);
                $jam = substr($waktu, 0, 5);
                if (!empty($dataPenyewaan) && $dataPenyewaan['id_penyewaan'] == $b['id_penyewaan']) {
                    // do nothing
                } else {
                    $bookedSlots[$tanggal][$jam] = true;
                }
            }
            error_log("booked slots : " . json_encode($bookedSlots));

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

    public function edit($id)
    {
        $sewaAlatModel = new PenyewaanAlatModel();
        $alatModel = new AlatModel();
        try {
            $dataPenyewaan = $sewaAlatModel->getPenyewaanJoinPembayaranByIdPenyewaan($id);
            error_log("penyewaan data : " . json_encode($dataPenyewaan));
            $alatData = $alatModel->where('is_deleted', 0)->findAll();
            error_log("alat data : " . json_encode($alatData));
            $data = [
                'penyewaan' => $dataPenyewaan,
                'alats' => $alatData,
            ];
            return view('pages/penyewaan_edit', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get page edit penyewaan : " . $th->getMessage());
            throw $th;
        }
    }

    public function update()
    {
        error_log("start update penyewaan");
        $sewaAlatModel = new PenyewaanAlatModel();
        $pembayaranModel = new PembayaranModel();
        $idPenyewaan = $this->request->getPost('id_penyewaan');
        $idPembayaran = $this->request->getPost('id_pembayaran');
        error_log("id penyewaan : " . $idPenyewaan);
        error_log("id pembayaran : " . $idPembayaran);
        db_connect()->transStart();
        try {
            $dataPembayaran = [
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
            ];
            error_log("data pembayaran : " . json_encode($dataPembayaran));
            $pembayaranModel->update($idPembayaran, $dataPembayaran);
            $dataPenyewaan = [
                'id_alat' => $this->request->getPost('alat'),
                'tanggal' => $this->request->getPost('jadwal'),
                'total' => $this->request->getPost('hargasewa'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
            ];
            error_log("data penyewaan : " . json_encode($dataPenyewaan));
            $sewaAlatModel->update($idPenyewaan, $dataPenyewaan);
            db_connect()->transComplete();
            return redirect()->to('/penyewaan-table')->with('success', 'Penyewaan berhasil diupdate');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error update penyewaan : " . $th->getMessage());
            throw $th;
        }
    }
}
