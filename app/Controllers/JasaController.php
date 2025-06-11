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
        $data['jasas'] = $jasaModel->findAll();
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
}
