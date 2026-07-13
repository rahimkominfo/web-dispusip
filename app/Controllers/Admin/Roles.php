<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeranModel;

class Roles extends BaseController
{
    protected $peranModel;

    public function __construct()
    {
        $this->peranModel = new PeranModel();
    }

    public function index()
    {
        $roles = $this->peranModel->findAll();

        $data = [
            'roles' => $roles
        ];

        return view('admin/roles/index', $data);
    }

    public function create()
    {
        return view('admin/roles/create');
    }

    public function store()
    {
        $rules = [
            'nama_peran' => 'required|min_length[3]|max_length[50]|is_unique[sys_peran.nama_peran]',
            'deskripsi'  => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->peranModel->save([
            'nama_peran' => $this->request->getPost('nama_peran'),
            'deskripsi'  => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to(base_url('admin/roles'))->with('success', 'Peran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $role = $this->peranModel->find($id);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Peran tidak ditemukan.");
        }

        $data = [
            'role' => $role
        ];

        return view('admin/roles/edit', $data);
    }

    public function update($id)
    {
        $role = $this->peranModel->find($id);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Peran tidak ditemukan.");
        }

        $rules = [
            'nama_peran' => "required|min_length[3]|max_length[50]|is_unique[sys_peran.nama_peran,peran_id,{$id}]",
            'deskripsi'  => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->peranModel->update($id, [
            'nama_peran' => $this->request->getPost('nama_peran'),
            'deskripsi'  => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to(base_url('admin/roles'))->with('success', 'Peran berhasil diperbarui.');
    }

    public function delete($id)
    {
        $role = $this->peranModel->find($id);
        if (!$role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Peran tidak ditemukan.");
        }

        $this->peranModel->delete($id);

        return redirect()->to(base_url('admin/roles'))->with('success', 'Peran berhasil dihapus.');
    }
}
