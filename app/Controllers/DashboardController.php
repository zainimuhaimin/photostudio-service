<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;
use App\Models\UserAuthenticationModel;
use Constants;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        return view('pages/dashboard');
    }

    public function profile()
    {
        $userAuthModel = new UserAuthenticationModel();
        try {
            //code...
            $userId = session()->get('user_id');
            error_log("user id: " . $userId);
            $userData = [];
            if (session()->get('role_name') == Constants::ROLE_ADMIN) {
                $userData = $userAuthModel->where('is_deleted', 0)->where('id_user', $userId)->first();
                error_log("user data : " . json_encode($userData));
                $data = [
                    'userData' => $userData,
                ];
                return view('pages/profile_admin', $data);
            } else {
                $userData = $userAuthModel->getUserByUserId($userId);
                error_log("user data : " . json_encode($userData));
                $data = [
                    'userData' => $userData,
                ];
                return view('pages/profile', $data);
            }
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error when edit profile : " . $th->getMessage());
            throw $th;
        }
    }

    public function updateProfile()
    {
        $userAuthModel = new UserAuthenticationModel();
        $pelangganModel = new PelangganModel();
        try {
            db_connect()->transStart();
            $userId = $this->request->getPost('id_user');
            $idPelanggan = $this->request->getPost('id_pelanggan');
            error_log("id user : " . $userId);
            error_log("id pelanggan : " . $idPelanggan);
            error_log("password : " . $this->request->getPost('password'));
            $dataUserAuth = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
            ];
            error_log("data user auth : " . json_encode($dataUserAuth));
            $userAuthModel->update($userId, $dataUserAuth);
            $dataPelanggan = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'no_telp' => $this->request->getPost('phoneNumber'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('user_id'),
            ];
            error_log("data pelanggan : " . json_encode($dataPelanggan));
            $pelangganModel->update($idPelanggan, $dataPelanggan);
            db_connect()->transComplete();
            return redirect()->to('/dashboard');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error when update profile : " . $th->getMessage());
            throw $th;
        }
    }

    public function updateProfileAdmin()
    {
        $userAuthModel = new UserAuthenticationModel();
        try {
            db_connect()->transStart();
            $userId = $this->request->getPost('id_user');
            error_log("id user : " . $userId);
            error_log("password : " . $this->request->getPost('password'));
            $dataUserAuth = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('username'),
            ];
            error_log("data user auth : " . json_encode($dataUserAuth));
            $userAuthModel->update($userId, $dataUserAuth);
            db_connect()->transComplete();
            return redirect()->to('/dashboard');
        } catch (\Throwable $th) {
            //throw $th;
            db_connect()->transRollback();
            error_log("error when update profile : " . $th->getMessage());
            throw $th;
        }
    }
}
