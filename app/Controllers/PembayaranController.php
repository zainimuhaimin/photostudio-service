<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enum\StatusPembayaranEnum;
use App\Models\PembayaranModel;
use CodeIgniter\HTTP\ResponseInterface;
use Constants;

class PembayaranController extends BaseController
{
    public function index()
    {
        error_log("start get pembayaran pages");
        // get data pembayaran by id_pelanggan
        $pembayaranModel = new PembayaranModel();

        try {
            //code...
            $user_id = session()->get('user_id');
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY.$user_id);
            $roleUser = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            error_log("get pelanggan from cache".json_encode($pelanggan));
            error_log("get role user from cache".json_encode($roleUser));
            if(session()->get('role') == $roleUser['id_role']){
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPelanggan($pelanggan['id_pelanggan']);
            } else {
                $dataPembayaran = $pembayaranModel->getAllPembayaran();
            }
            
            error_log("get data pembayaran by id_pelanggan".json_encode($dataPembayaran));
            $data = [
                'pembayarans' => $dataPembayaran,
                'roleUser' => $roleUser,
            ];
            return view('pages/pembayaran', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get pembayaran pages".$th);
            throw $th;
        }
    }

    public function detail($id)
    {
        error_log("start get detail pembayaran pages");
        // get data pembayaran by id
        $pembayaranModel = new PembayaranModel();

        try {
            $user_id = session()->get('user_id');
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY.$user_id);
            $dataPembayaran = $pembayaranModel->getPembayaranByIdPelangganAndIdPembayaran($pelanggan['id_pelanggan'], $id);
            error_log("get data pembayaran by id_pelanggan and id_pembayaran".json_encode($dataPembayaran));
            error_log("nama jasa pembayaran");
            error_log(null == $dataPembayaran->nama_jasa ? "kosong" : $dataPembayaran->nama_jasa );
            $data = [
                'pembayaran' => $dataPembayaran,
            ];
            return view('pages/detail_pembayaran', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get detail pembayaran pages".$th);
            throw $th;
        }
    }

    public function update()
    {
        // update data pembayaran by id
        $pembayaranModel = new PembayaranModel();
        $base64 = "";
        db_connect()->transStart();
        try {
            //code...
            $buktiPembayaran = $this->request->getFile('file');
            error_log("buktiPembayaran : ".json_encode($buktiPembayaran));
            if ($buktiPembayaran && $buktiPembayaran->isValid() && !$buktiPembayaran->hasMoved()) {
            // Ambil konten file asli
            $originalContent = file_get_contents($buktiPembayaran->getTempName());

            // Kompres jika gambar
            $mime = $buktiPembayaran->getMimeType();
            $compressed = $originalContent;

            if (str_starts_with($mime, 'image/')) {
                // Buat gambar dari buktiPembayaran
                $image = imagecreatefromstring($originalContent);

                // Kompres ke JPEG (80% quality) ke output buffer
                ob_start();
                imagejpeg($image, null, 80); // Kompres
                $compressed = ob_get_clean();
                imagedestroy($image);
            }
            //TODO better jangan save as base64 karna makan storage db
            // Encode ke base64
            $base64 = base64_encode($compressed);
        }
        error_log("base64 : ".$base64);

            $idPembayaran = $this->request->getPost('id_pembayaran');
            $dataPembayaran = [
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'status_pembayaran' => StatusPembayaranEnum::PAID->value,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bukti_pembayaran' => $base64,

            ];
            $pembayaranModel->update($idPembayaran, $dataPembayaran);
            db_connect()->transComplete();
            return redirect()->to('/pembayaran-table')->with('success', 'Pembayaran berhasil diupdate');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error when update pembayaran pages".$th);
            throw $th;
        }
    }
}
