<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PeranModel;

class Users extends BaseController
{
    protected $userModel;
    protected $peranModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->peranModel = new PeranModel();
    }

    public function index()
    {
        // Join dengan tabel sys_peran untuk menampilkan nama peran
        $users = $this->userModel->select('sys_users.*, sys_peran.nama_peran')
                                ->join('sys_peran', 'sys_peran.peran_id = sys_users.peran_id', 'left')
                                ->findAll();

        $data = [
            'users' => $users
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $roles = $this->peranModel->findAll();

        $data = [
            'roles' => $roles
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username'    => 'required|min_length[3]|max_length[50]|is_unique[sys_users.username]',
            'email'       => 'required|valid_email|is_unique[sys_users.email]',
            'password'    => 'required|min_length[6]',
            'nama_publik' => 'required|min_length[3]|max_length[100]',
            'peran_id'    => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate UUID v4 standar
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $this->userModel->save([
            'user_uuid'   => $uuid,
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'nama_publik' => $this->request->getPost('nama_publik'),
            'peran_id'    => $this->request->getPost('peran_id')
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        $roles = $this->peranModel->findAll();

        $data = [
            'user'  => $user,
            'roles' => $roles
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        $rules = [
            'username'    => "required|min_length[3]|max_length[50]|is_unique[sys_users.username,user_id,{$id}]",
            'email'       => "required|valid_email|is_unique[sys_users.email,user_id,{$id}]",
            'password'    => 'permit_empty|min_length[6]',
            'nama_publik' => 'required|min_length[3]|max_length[100]',
            'peran_id'    => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'nama_publik' => $this->request->getPost('nama_publik'),
            'peran_id'    => $this->request->getPost('peran_id')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        $this->userModel->delete($id);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil dihapus.');
    }
}
