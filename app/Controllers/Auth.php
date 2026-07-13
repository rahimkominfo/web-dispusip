<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, langsung ke admin dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('admin'));
        }

        return view('auth/login');
    }

    /**
     * Proses login
     */
    public function proses()
    {
        // Validasi input
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan Password wajib diisi.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username atau email
        $user = $this->userModel->where('username', $username)
                               ->orWhere('email', $username)
                               ->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session
                session()->set([
                    'user_id'     => $user['user_id'],
                    'user_uuid'   => $user['user_uuid'],
                    'username'    => $user['username'],
                    'nama_publik' => $user['nama_publik'],
                    'email'       => $user['email'],
                    'peran_id'    => $user['peran_id'],
                    'isLoggedIn'  => true
                ]);

                return redirect()->to(base_url('admin'))->with('success', 'Selamat datang kembali, ' . esc($user['nama_publik']) . '!');
            }
        }

        // Jika gagal
        return redirect()->back()->withInput()->with('error', 'Username/Email atau Password salah.');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Anda telah berhasil logout.');
    }
}
