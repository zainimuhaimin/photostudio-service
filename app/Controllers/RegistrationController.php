<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\UserAuthenticationModel;
use App\Models\RoleModel;
use Constants;

class RegistrationController extends BaseController
{
    public function index(): string
    {
        return view('pages/registration');
    }

    public function save()
    {
        error_log('Start saving registration data');
        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email is required'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password is required'
                ]
            ],
            'phoneNumber' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Phone number is required'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Address is required'
                ]
            ],

        ]);
        // Check if validation fails
        if (!$validation->withRequest($this->request)->run()) {
            // TODO redirect validate error with message
            error_log('Validation failed');
            error_log(print_r($validation->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        error_log('Validation passed');

        // Save to databse using model
        $userAuthModel = new UserAuthenticationModel();
        $pelangganModel = new PelangganModel();
        try {
            // Get validated data
            $cache = \Config\Services::cache();
            $masterRole = $cache->get(Constants::ROLE_KEY_HASHMAP);
            $roleUser = $masterRole[Constants::ROLE_USER];
            $dataUserAuth = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'id_role' => $roleUser['id_role']
            ];

            error_log("data user auth");
            error_log(print_r($dataUserAuth, true));
            // insert user auth
            $idUser = $userAuthModel->insert($dataUserAuth);
            error_log("id user");
            error_log(print_r($idUser, true));

            // get validated data pelanggan
            $dataPelanggan = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'alamat' => $this->request->getPost('alamat'),
                'no_telp' => $this->request->getPost('phoneNumber'),
                'id_user' => $idUser
            ];

            error_log("data pelanggan");
            error_log(print_r($dataPelanggan, true));
            $pelangganModel->insert($dataPelanggan);
            return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            error_log(print_r($e));
            return redirect()->back()->withInput()->with('error', 'Failed to register. Please try again.');
        }
    }
}
