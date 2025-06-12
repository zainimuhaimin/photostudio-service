<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enum\StatusPembayaranEnum;
use App\Models\PembayaranModel;
use CodeIgniter\HTTP\ResponseInterface;
use Constants;
use finfo;

use function PHPUnit\Framework\objectEquals;

class PembayaranController extends BaseController
{

    private $apiKey;
    private $apiUrl;
    private $apiSecret;
    public function __construct()
    {
        $this->apiUrl = getenv('WA_API_URL');
        $this->apiKey = getenv('WA_API_KEY');
        $this->apiSecret = getenv('WA_API_SECRET');
    }


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
            $user_id = session()->get('user_id');
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY.$user_id);
            $buktiPembayaran = $this->request->getFile('file');
            error_log("buktiPembayaran luar if : ".json_encode($buktiPembayaran));
            if ($buktiPembayaran && $buktiPembayaran->isValid() && !$buktiPembayaran->hasMoved()) {
                error_log("buktiPembayaran : ".json_encode($buktiPembayaran));
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
            return redirect()->to('/pembayaran-receipt/'.$idPembayaran)->with('success', 'Pembayaran berhasil diupdate');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error when update pembayaran pages".$th);
            throw $th;
        } finally {
            $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($idPembayaran);
            error_log("data notif pembayaran : ".json_encode($dataPembayaran));
            $notif = [
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'status_pembayaran' => StatusPembayaranEnum::PAID->value,
                'nama_pelanggan' => session()->get('username'),
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bukti_pembayaran' => $base64,
                'phone_number' => $pelanggan['no_telp'],
                'pesanan_atau_penyewaan' => $dataPembayaran->nama_jasa == null ? "[SEWA] ". $dataPembayaran->nama_alat : "[JASA] ". $dataPembayaran->nama_jasa,
                'jadwal_pesanan_atau_penyewaan' => $dataPembayaran->tanggal_penyewaan == null? $dataPembayaran->tanggal_pemesanan_jasa : $dataPembayaran->tanggal_penyewaan,
                'transaction_id' => $dataPembayaran->transaction_id,
            ];
            $this->sendNotif($notif);
        }
    }

    public function invoice($idPembayaran){
        $pembayaranModel = new PembayaranModel();
        $cacheRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
        $dataPembayaran = [];
        try {
            $user_id = session()->get('user_id');
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY.$user_id);
            if(session()->get('role') == $cacheRole['id_role']){
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPelangganAndIdPembayaran($pelanggan['id_pelanggan'], $idPembayaran, StatusPembayaranEnum::PAID->value);
            } else {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($idPembayaran);
            }
            error_log("data pembayaran : ".json_encode($dataPembayaran));
            $data = [
                'pembayaran' => $dataPembayaran,
            ];
        return view('pages/pembayaran_receipt', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get detail pembayaran pages".$th);
            throw $th;
        }
        
    }

    

    public function sendText()
    {
        $client = \Config\Services::curlrequest();

        $response = $client->request('POST', 'https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => $this->apiKey
            ],
            'form_params' => [
                'target' => '6281234567890', // Nomor tujuan (gunakan kode negara, tanpa +)
                'message' => 'Halo, ini pesan dari CodeIgniter 4 🎉',
            ]
        ]);

        return $this->response->setJSON([
            'status' => 'ok',
            'response' => json_decode($response->getBody())
        ]);
    }

    public function sendNotif($notifData) : void
    {
        error_log("start send notification wa");
        try {
            
            $text = "*Pembayaran Masuk* \n".
            "Nama Pelanggan: ".$notifData['nama_pelanggan']."\n".
            "Transaksi ID : ".$notifData['transaction_id']."\n".
            "Pesanan atau Penyewaan: ".$notifData['pesanan_atau_penyewaan']."\n".
            "Jadwal: ".$notifData['jadwal_pesanan_atau_penyewaan']."\n".
            "Tanggal Pembayaran: ".$notifData['tanggal_pembayaran']."\n".
            "Metode Pembayaran: ".$notifData['metode_pembayaran'];
            sendTelegramText($text);

            $base64 = $notifData['bukti_pembayaran'];
            if(!empty($base64)){
                // Ekstrak base64
            $data = base64_decode($base64);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($data);
            error_log("mimeType : ".$mimeType);
            // Mapping mime ke ekstensi
            $map = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp',
                'image/bmp'  => 'bmp',
            ];

            $ext = $map[$mimeType] ?? 'jpg';
            // Simpan sementara ke public folder
            $filename = 'wa_image_' . time() .".". $ext;
            $filepath = FCPATH . 'uploads/notif-wa/' . $filename;
            error_log("filepath : ".$filepath);
            file_put_contents($filepath, $data);

            sendTelegramPhotoFile($filepath, "Bukti Pembayaran");
            }
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when send notification wa".$th);
            throw $th;
        }
        
    }
}
