<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AlatModel;

class AlatController extends BaseController
{
    public function index()
    {
        $alatModel = new AlatModel();
        $data['alats'] = $alatModel->getAllAlat();
        return view('pages/alat', $data);
    }

    public function add()
    {
        return view('pages/alat_add');
    }

    public function save()
    {
        error_log("start save alat");
        $alatModel = new AlatModel();
        try {
            $fotoAlat = $this->request->getFile('file');
            error_log("fotoAlat luar if : ".json_encode($fotoAlat));
            if ($fotoAlat && $fotoAlat->isValid() && !$fotoAlat->hasMoved()) {
                error_log("fotoAlat : ".json_encode($fotoAlat));
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
                $filename = 'alat_image_' . time();
                $imagePath = 'uploads/alat/'. $filename . '.' . $fotoAlat->getExtension();
                $filepath = FCPATH .  $imagePath;
                error_log("filepath : " . $filepath);
                file_put_contents($filepath, $compressed);
                
            } else {
                throw new \Exception('File tidak valid atau sudah dipindahkan sebelumnya.');
            }
            $data = [
                'nama_alat' => $this->request->getPost('namaalat'),
                'harga_alat' => $this->request->getPost('hargasewa'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'image_path' => $imagePath,
                'created_by' => session()->get('username'),
            ];
            error_log("request save alat to db");
            error_log(json_encode($data));
            $alatModel->insert($data);
            return redirect()->to('/alat-table')->with('success', 'Alat berhasil ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when save alat : ".$th);
            throw $th;
        }
        
    }

    public function getImage($id)
    {
        error_log("start get alat image");
        $alatModel = new AlatModel();
        try {
            $image = $alatModel->find($id);
            if ($image) {
                $imagePath = $image['image_path'];
                $response = $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'imagePath' => $imagePath
                    ]
                ]);
                error_log("response get alat image : ".json_encode($response));
                return $response;
            } else {
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            error_log("error when get alat image : ". $th->getMessage());
            throw $th;
        }
        
    }
}
