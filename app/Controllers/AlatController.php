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
        $data['alats'] = $alatModel->findAll();
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
        $data = [
            'nama_alat' => $this->request->getPost('namaalat'),
            'harga_alat' => $this->request->getPost('hargasewa'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'created_by' => session()->get('username'),
        ];
        error_log("request save alat to db");
        error_log(json_encode($data));
        $alatModel->insert($data);
        return redirect()->to('/alat-table')->with('success', 'Alat berhasil ditambahkan');
    }
}
