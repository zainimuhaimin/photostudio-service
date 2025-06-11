<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use App\Models\UserAuthenticationModel;
use Constants;

class PelangganController extends BaseController
{
    public function index()
    {
        // $cache = \Config\Services::cache();
        // $role = $cache->get(Constants::ROLE_KEY);
        // $userRole = $role[Constants::ROLE_USER];

        $pelanggnModel = new PelangganModel();
        $userRole = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
        $userId = session()->get('user_id');
        $pelanggan = cache()->get(Constants::PELANGGAN_KEY.$userId);
        $dataPelanggan = [];
        if(session()->get('role') == $userRole['id_role']){
            $dataPelanggan = $pelanggnModel->where('is_deleted', '0')->where('id_pelanggan', $pelanggan['id_pelanggan'])->findAll();

        } else {
            $dataPelanggan = $pelanggnModel->where('is_deleted', '0')->findAll();
        }
        $data = [
            'pelanggans' => $dataPelanggan,
            'rola_name' => session()->get('role_name'),
        ];
        return view('pages/pelanggan', $data);
    }

    public function add()
    {
        $cache = getCache(Constants::ROLE_KEY);
        error_log("role di add pelanggan");
        error_log(json_encode($cache));
        $data = [
            'roles' => $cache,
        ];
        return view('pages/pelanggan_add', $data);
    }

    public function save()
    {
        error_log("start save pelanggan");
        $pelangganModel = new PelangganModel();
        $userAuthModel = new UserAuthenticationModel();
        // get validated data pelanggan
        $roleRequest = $this->request->getPost('role');
        $dataUserAuth = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_role' => $roleRequest,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session('username'),
        ];
        $idUser = $userAuthModel->insert($dataUserAuth);

        //get role user
        $cache = getCache(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
        $roleCache = $cache[Constants::ROLE_USER];
        if ($roleRequest == $roleCache['id_role']) {
                $dataPelanggan = [
                'nama' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'no_telp' => $this->request->getPost('phoneNumber'),
                'id_user' => $idUser,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => session('username'),
            ];
            $pelangganModel->insert($dataPelanggan);
            
        }
        return redirect()->to('/pelanggan-table')->with('success', 'Pelanggan berhasil ditambahkan');;
    }
}
