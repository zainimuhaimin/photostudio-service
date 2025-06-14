<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JasaModel;

class JasaController extends BaseController
{
    public function index()
    {
        //
        $jasaModel = new JasaModel();
        $data['jasas'] = $jasaModel->where('is_deleted', 0)->findAll();
        return view('pages/jasa', $data);
    }

    public function add()
    {
        //
        return view('pages/jasa_add');
    }

    public function save()
    {
        //
        $jasaModel = new JasaModel();
        $data = [
            'nama_jasa' => $this->request->getVar('namajasa'),
            'harga_jasa' => $this->request->getVar('hargajasa'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'created_by' => session()->get('username'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $jasaModel->insert($data);
        return redirect()->to('/jasa-table')->with('success', 'Data Jasa Berhasil Ditambahkan');
    }

    public function getJasaByIdJoinTransaction($id)
    {
        error_log("start get jasa by id join transaction");
        error_log("id : " . $id);
        $jasaModel = new jasaModel();
        try {
            $data = $jasaModel->getJasaByIdJoinPemesananJasaJoinPembayaran($id);
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
            error_log("error when get jasa by id join transaction : " . $th->getMessage());
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
        error_log("start delete jasa");
        $jasaModel = new JasaModel();
        try {
            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
                'is_deleted' => 1
            ];
            $jasaModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Customer deleted successfully'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when delete jasa : " . $th->getMessage());
            return $this->response->setJSON([
                'status' => 500,
                'message' => 'Failed to delete jasa: ' . $th->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function edit($id)
    {
        //
        $jasaModel = new JasaModel();
        try {
            //code...
            $data['jasa'] = $jasaModel->where('id_jasa', $id)->first();
            return view('pages/jasa_edit', $data);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when edit jasa : " . $th->getMessage());
            throw $th;
        }
    }

    public function update()
    {
        error_log("start update jasa");
        $jasaModel = new JasaModel();
        try {
            $idJasa = $this->request->getPost('idjasa');
            $data = [
                'nama_jasa' => $this->request->getPost('namajasa'),
                'harga_jasa' => $this->request->getPost('hargajasa'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $jasaModel->update($idJasa, $data);
            return redirect()->to('/jasa-table')->with('success', 'Data Jasa Berhasil Diubah');
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when update jasa : " . $th->getMessage());
            throw $th;
        }
    }
}
