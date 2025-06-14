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
        error_log("alats : " . json_encode($data));
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
            $imagePath = $this->getImageRequest();
            error_log("imagePath : " . $imagePath);
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
            error_log("error when save alat : " . $th);
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
                error_log("response get alat image : " . json_encode($response));
                return $response;
            } else {
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            error_log("error when get alat image : " . $th->getMessage());
            throw $th;
        }
    }

    public function getAlatByIdJoinTransaction($id)
    {
        error_log("start get alat by id join transaction");
        error_log("id : " . $id);
        $alatModel = new AlatModel();
        try {
            $data = $alatModel->getAlatByIdJoinPenyewaanAlatJoinPembayaran($id);
            error_log("data : " . json_encode($data));
            if (empty($data)) {
                return $this->response->setJSON([
                    'status' => 404,
                    'message' => 'not found',
                    'data' => []
                ]);
            }
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when get alat by id join transaction : " . $th->getMessage());
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'error',
                'error_desc' => $th->getMessage(),
                'data' => []
            ]);
        }
    }

    public function delete($id)
    {
        error_log("start delete alat");
        $alatModel = new AlatModel();
        try {
            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
                'is_deleted' => 1
            ];
            $alatModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Customer deleted successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when delete alat : " . $th->getMessage());
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Failed to delete alat: ' . $th->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function edit($id)
    {
        error_log("start edit alat");
        $alatModel = new AlatModel();
        try {
            $dataAlat = $alatModel->find($id);
            error_log("data : " . json_encode($dataAlat));
            $data = [
                'dataAlat' => $dataAlat
            ];
            return view('pages/alat_edit', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when edit alat : " . $th->getMessage());
            throw $th;
        }
    }

    public function update()
    {
        error_log("start update alat");
        $alatModel = new AlatModel();
        try {
            $id = $this->request->getPost('idalat');
            $data = [
                'nama_alat' => $this->request->getPost('namaalat'),
                'harga_alat' => $this->request->getPost('hargasewa'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
            ];
            $imagePath = $this->getImageRequest();
            error_log("imagePath : " . $imagePath);
            if ($imagePath) {
                $data['image_path'] = $imagePath;
            }
            error_log("data : " . json_encode($data));
            $alatModel->update($id, $data);
            return redirect()->to('/alat-table')->with('success', 'Alat berhasil diupdate');
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when update alat : " . $th->getMessage());
            throw $th;
        }
    }

    public function getImageRequest()
    {
        $imagePath = null;
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
                $filename = 'alat_image_' . time();
                $imagePath = 'uploads/alat/' . $filename . '.' . $fotoAlat->getExtension();
                $filepath = FCPATH .  $imagePath;
                error_log("filepath : " . $filepath);
                file_put_contents($filepath, $compressed);
            }
        } catch (\Throwable $th) {
            error_log("error when get image : " . $th->getMessage());
            throw $th;
        }

        return $imagePath;
    }
}
