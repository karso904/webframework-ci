<?php

namespace App\Controllers;

use App\Models\LoginModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('login', $data);
    }
    public function login_action()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('login', $data);
        } else {
            $session = session();
            $loginModel = new LoginModel;

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $cekusername = $loginModel->where('username', $username)->first();

            if ($cekusername) {
                $password_db = trim($cekusername['password']);
                $cek_password = password_verify($password, $password_db);
                if ($cek_password) {
                    switch ($cekusername['role']) {
                        case "Admin":
                            return redirect()->to('Admin/home');
                        case "Pegawai":
                            return redirect()->to('Pegawai/home');
                        default:
                            $session->setFlashdata('pesan', 'Username Salah, Silakan coba lagi!');
                            return redirect()->to('/');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Password Salah, Silakan coba lagi!');
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('pesan', 'Username Salah, Silakan coba lagi!');
                return redirect()->to('/');
            }
        }
    }
}
