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

class PenyewaanAlatController extends BaseController
{
    public function index()
    {
        error_log("get page penyewaan");
        $sewaAlatModel = new PenyewaanAlatModel();
        try {
            $cacheRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            error_log("cache role : ".json_encode($cacheRole));
            //validasi jika user rolenya USER maka ambil data current user
            $result = [];
            if (session()->get('role') == $cacheRole['id_role']) {
                $idUser = session()->get('user_id');
                $cachePelanggan = getCache(Constants::PELANGGAN_KEY.$idUser);
                error_log("cache pelanggan : ".json_encode($cachePelanggan));
                //role user ambil transaksi penyewaan yang current user saja
                $result = $sewaAlatModel->getTransaksiSewaJoinPembayaranByIdPelanggan($cachePelanggan['id_pelanggan']);
            } else {
                $result = $sewaAlatModel->getTransaksiSewaJoinPembayaran();
            }
            error_log("result : ".json_encode($result));
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error get data penyewaan : ".$th->getMessage());
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
        $alatData = $alatModel->findAll();
        $data = [
            'alats' => $alatData,
        ];
        return view('pages/penyewaan_add', $data);
    }

    public function save(){
        error_log("start save penyewaan alat");
        $sewaAlatModel = new PenyewaanAlatModel();
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
            // $existingBookings = $sewaAlatModel->getDataBooked($requestedAlatId, $requestedDate);
            // error_log("existing bookings : ".json_encode($existingBookings));
            // if (!empty($existingBookings)) {
            //     error_log("equipment is already booked or not available");
            //     return redirect()->to('/penyewaan-table')->with('error', 'Alat sudah terbooking atau tidak tersedia');
            // }

            $cachePelanggan = getCache(Constants::PELANGGAN_KEY.$idUser);
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
                $errors = $sewaAlatModel->errors(); // Ambil pesan error validasi
                throw new \RuntimeException("Gagal save data penyewaan alat: " . implode(', ', $errors));
            }
            $dataPembayaran = [
                'id_penyewaan' => $idPenyewaan,
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
                throw new \RuntimeException("Gagal save table pembayaran: ". implode(', ', $errors));
            }
            db_connect()->transComplete(); // Commit transaction
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback(); // Rollback transaction
            error_log("error save penyewaan : ".$th->getMessage());
            // return redirect()->to('/penyewaan-table')->with('error', 'Penyewaan gagal ditambahkan');
        }

        
        return redirect()->to('/penyewaan-table')->with('success', 'Penyewaan berhasil ditambahkan');
    }
}
