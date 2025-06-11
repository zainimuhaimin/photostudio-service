<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserAuthenticationModel;
use App\Models\PelangganModel;
use Constants;

class LoginController extends BaseController
{
    public function index()
    {
        return view('pages/login');
    }

    public function authenticate()
    {
        $session = session();
        $cache = \Config\Services::cache();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserAuthenticationModel();
        $user = $userModel
        ->join('role', 'role.id_role = user_authentication.id_role')
        ->where('username', $username)
        ->where('is_deleted', 0)->first();

        error_log("validasi password");
        if ($user && password_verify($password, $user['password'])) {
            $pelangganModel = new PelangganModel();
            $session->set([
                'user_id' => $user['id_user'],
                'username' => $user['username'],
                'role' => $user['id_role'],
                'role_name' => $user['value'],
                'logged_in' => true
            ]);

            $cache->save('user_' . $user['id_user'], $user, 0);

            error_log("ambil cache dari helper untuk role user");
            error_log($user['id_user']);
            $roleCache = getCacheHashMap(Constants::ROLE_KEY_HASHMAP, Constants::ROLE_USER);
            if ($roleCache['id_role'] == $user['id_role']){
                $pelanggan = $pelangganModel->where('id_user', $user['id_user'])->first();
                $cache->save('pelanggan_' . $user['id_user'], $pelanggan, 0);
            }
            error_log("success login");
            return redirect()->to('/dashboard');
        } else {
            error_log("failed login");
            $session->setFlashdata('error', 'Username atau password salah');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        $cache = \Config\Services::cache();
        $cache->delete('user_'. $session->get('user_id'));
        $cache->delete('pelanggan_'. $session->get('user_id'));
        return redirect()->to('/login');
    }
}
