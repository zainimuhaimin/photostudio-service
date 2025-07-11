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
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY . $user_id);
            $roleUser = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            error_log("get pelanggan from cache" . json_encode($pelanggan));
            error_log("get role user from cache" . json_encode($roleUser));
            if (session()->get('role') == $roleUser['id_role']) {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPelanggan($pelanggan['id_pelanggan']);
            } else {
                $dataPembayaran = $pembayaranModel->getAllPembayaran();
            }

            error_log("get data pembayaran by id_pelanggan" . json_encode($dataPembayaran));
            $data = [
                'pembayarans' => $dataPembayaran,
                'roleUser' => $roleUser,
            ];
            return view('pages/pembayaran', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get pembayaran pages" . $th);
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
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY . $user_id);
            if (session()->get('role_name') == Constants::ROLE_ADMIN) {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($id);
            } else {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPelangganAndIdPembayaran($pelanggan['id_pelanggan'], $id);
            }
            error_log("get data pembayaran by id_pelanggan and id_pembayaran" . json_encode($dataPembayaran));
            error_log("nama jasa pembayaran");
            error_log("data pembayaran : " . json_encode($dataPembayaran));
            $data = [
                'pembayaran' => $dataPembayaran,
            ];
            return view('pages/detail_pembayaran', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get detail pembayaran pages" . $th);
            throw $th;
        }
    }
    public function getImageRequest()
    {
        $imagePath = null;
        $base64 = "";
        try {
            $fotoAlat = $this->request->getFile('file');
            error_log("fotoAlat luar if : " . json_encode($fotoAlat));
            if ($fotoAlat && $fotoAlat->isValid() && !$fotoAlat->hasMoved()) {
                error_log("fotoAlat : " . json_encode($fotoAlat));
                // Ambil konten file asli
                $originalContent = file_get_contents($fotoAlat->getTempName());

                // Kompres jika gambar
                $mime = $fotoAlat->getMimeType();
                $compressed = $originalContent;

                if (str_starts_with($mime, 'image/')) {
                    // Buat gambar dari fotoAlat
                    $image = imagecreatefromstring($originalContent);

                    // Kompres ke JPEG (80% quality) ke output buffer
                    ob_start();
                    imagejpeg($image, null, 80); // Kompres
                    $compressed = ob_get_clean();
                    imagedestroy($image);
                }
                //TODO better jangan save as base64 karna makan storage db
                $filename = 'bukti_tf_image_' . time();
                $imagePath = 'uploads/bukti_tf/' . $filename . '.' . $fotoAlat->getExtension();
                $filepath = FCPATH .  $imagePath;
                error_log("filepath : " . $filepath);
                file_put_contents($filepath, $compressed);
                $base64 = base64_encode($compressed);
            }
            $data = [
                'image' => $base64,
                'image_path' => $imagePath,
            ];
            return $data;
        } catch (\Throwable $th) {
            error_log("error when get image : " . $th->getMessage());
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
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY . $user_id);
            $buktiPembayaran = $this->request->getFile('file');
            error_log("buktiPembayaran luar if : " . json_encode($buktiPembayaran));
            $imageData = $this->getImageRequest();
            $base64 = $imageData['image'];
            $idPembayaran = $this->request->getPost('id_pembayaran');
            $dataPembayaran = [
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'status_pembayaran' => StatusPembayaranEnum::PAID->value,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bukti_pembayaran' => $imageData['image_path'],
            ];
            $pembayaranModel->update($idPembayaran, $dataPembayaran);
            db_connect()->transComplete();
            return redirect()->to('/pembayaran-receipt/' . $idPembayaran)->with('success', 'Pembayaran berhasil diupdate');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error when update pembayaran pages" . $th);
            throw $th;
        } finally {
            $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($idPembayaran);
            error_log("data notif pembayaran : " . json_encode($dataPembayaran));
            $notif = [
                'metode_pembayaran' => $this->request->getPost('pembayaran-metode'),
                'status_pembayaran' => StatusPembayaranEnum::PAID->value,
                'nama_pelanggan' => session()->get('username'),
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'bukti_pembayaran' => $base64,
                'phone_number' => $pelanggan['no_telp'],
                'pesanan_atau_penyewaan' => $dataPembayaran->nama_jasa == null ? "[SEWA] " . $dataPembayaran->nama_alat : "[JASA] " . $dataPembayaran->nama_jasa,
                'jadwal_pesanan_atau_penyewaan' => $dataPembayaran->tanggal_penyewaan == null ? $dataPembayaran->tanggal_pemesanan_jasa : $dataPembayaran->tanggal_penyewaan,
                'transaction_id' => $dataPembayaran->transaction_id,
            ];
            $this->sendNotif($notif);
        }
    }

    public function invoice($idPembayaran)
    {
        $pembayaranModel = new PembayaranModel();
        $cacheRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
        $dataPembayaran = [];
        try {
            $user_id = session()->get('user_id');
            $pelanggan = cache()->get(Constants::PELANGGAN_KEY . $user_id);
            if (session()->get('role') == $cacheRole['id_role']) {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPelangganAndIdPembayaran($pelanggan['id_pelanggan'], $idPembayaran, StatusPembayaranEnum::PAID->value);
            } else {
                $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($idPembayaran);
            }
            error_log("data pembayaran : " . json_encode($dataPembayaran));
            $data = [
                'pembayaran' => $dataPembayaran,
            ];
            return view('pages/pembayaran_receipt', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get detail pembayaran pages" . $th);
            throw $th;
        }
    }

    public function sendNotif($notifData): void
    {
        error_log("start send notification wa");
        try {

            $text = "*Pembayaran Masuk* \n" .
                "Nama Pelanggan: " . $notifData['nama_pelanggan'] . "\n" .
                "Transaksi ID : " . $notifData['transaction_id'] . "\n" .
                "Pesanan atau Penyewaan: " . $notifData['pesanan_atau_penyewaan'] . "\n" .
                "Jadwal: " . $notifData['jadwal_pesanan_atau_penyewaan'] . "\n" .
                "Tanggal Pembayaran: " . $notifData['tanggal_pembayaran'] . "\n" .
                "Metode Pembayaran: " . $notifData['metode_pembayaran'];
            sendTelegramText($text);

            $base64 = $notifData['bukti_pembayaran'];
            if (!empty($base64)) {
                // Ekstrak base64
                $data = base64_decode($base64);
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($data);
                error_log("mimeType : " . $mimeType);
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
                $filename = 'wa_image_' . time() . "." . $ext;
                $filepath = FCPATH . 'uploads/notif-wa/' . $filename;
                error_log("filepath : " . $filepath);
                file_put_contents($filepath, $data);

                sendTelegramPhotoFile($filepath, "Bukti Pembayaran");
            }
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when send notification wa" . $th);
            throw $th;
        }
    }

    public function confirm()
    {
        error_log("start confirm payment");
        $pembayaranModel = new PembayaranModel();
        db_connect()->transStart();
        $id = $this->request->getPost('id');
        error_log("id : " . $id);
        try {
            // Get payment data
            $dataPembayaran = $pembayaranModel->getPembayaranByIdPembayaran($id);
            error_log("dataPembayaran : " . json_encode($dataPembayaran));
            if (!$dataPembayaran) {
                throw new \Exception('Payment data not found');
            }

            // Update payment status to VALID
            $updateData = [
                'status_pembayaran' => StatusPembayaranEnum::VALID->value,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username')
            ];

            error_log("updateData : " . json_encode($updateData));
            $pembayaranModel->update($id, $updateData);

            // Send email notification
            $email = \Config\Services::email();
            $to = empty($dataPembayaran->email_pesan_jasa) ? $dataPembayaran->email_sewa_alat : $dataPembayaran->email_pesan_jasa;
            error_log("to : " . $to);
            $email->setFrom('ngadmin@mail.com', 'Studio Service');
            $email->setTo($to);
            $email->setSubject('Konfirmasi Pembayaran');

            $emailBody = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                    .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 5px 5px; }
                    .details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .footer { text-align: center; margin-top: 20px; color: #666; }
                    .amount { font-size: 24px; color: #4CAF50; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>✅ Pembayaran Dikonfirmasi</h1>
                    </div>
                    
                    <div class='content'>
                        <h2>Hai {$dataPembayaran->nama}! 👋</h2>
                        <p>Pembayaran Anda telah berhasil dikonfirmasi. Berikut adalah detail transaksi:</p>
                        
                        <div class='details'>
                            <p><strong>🔖 ID Transaksi:</strong> {$dataPembayaran->transaction_id}</p>
                            <p><strong>💰 Total Pembayaran:</strong><br>
                                <span class='amount'>Rp " . number_format(empty($dataPembayaran->harga_jasa) ? $dataPembayaran->harga_alat : $dataPembayaran->harga_jasa, 0, ',', '.') . "</span>
                            </p>
                            <p><strong>💳 Metode Pembayaran:</strong> {$dataPembayaran->metode_pembayaran}</p>
                            <p><strong>📅 Tanggal Pembayaran:</strong> {$dataPembayaran->tanggal_pembayaran}</p>
                        </div>
                        
                        <div class='footer'>
                            <p>Terima kasih telah mempercayakan layanan kami! 🙏</p>
                            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>
                            <hr>
                            <small>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</small>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ";

            $email->setMessage($emailBody);
            error_log("emailBody : " . $emailBody);

            if (!$email->send()) {
                error_log('Failed to send email: ' . $email->printDebugger(['headers']));
            }

            db_connect()->transComplete();
            return $this->response->setJSON([
                'status' => '200',
                'message' => 'Payment confirmed successfully'
            ]);
        } catch (\Throwable $th) {
            db_connect()->transRollback();
            error_log("Error when confirming payment: " . $th->getMessage());
            return $this->response->setJSON([
                'status' => '500',
                'message' => 'Payment Confirm Failed'
            ])->setStatusCode(500);
        }
    }
}
