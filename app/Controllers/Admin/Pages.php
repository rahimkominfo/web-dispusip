<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PagesModel;

class Pages extends BaseController
{
    protected $pagesModel;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
        helper('url');
    }

    public function index()
    {
        $pages = $this->pagesModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'pages' => $pages
        ];

        return view('admin/pages/index', $data);
    }

    public function create()
    {
        return view('admin/pages/create');
    }

    public function store()
    {
        $rules = [
            'judul'  => 'required|min_length[3]|max_length[255]',
            'konten' => 'permit_empty',
            'status' => 'required|in_list[Draf,Diterbitkan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate dynamic SEO slug from title
        $slug = url_title($this->request->getPost('judul'), '-', true);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while ($this->pagesModel->where('slug', $slug)->first() !== null) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Generate UUID v4
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $this->pagesModel->save([
            'page_uuid' => $uuid,
            'judul'     => $this->request->getPost('judul'),
            'slug'      => $slug,
            'konten'    => $this->request->getPost('konten'),
            'status'    => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/pages'))->with('success', 'Halaman statis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page = $this->pagesModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Halaman tidak ditemukan.");
        }

        $data = [
            'page' => $page
        ];

        return view('admin/pages/edit', $data);
    }

    public function update($id)
    {
        $page = $this->pagesModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Halaman tidak ditemukan.");
        }

        $rules = [
            'judul'  => 'required|min_length[3]|max_length[255]',
            'slug'   => "required|max_length[255]|is_unique[mst_pages.slug,page_id,{$id}]",
            'konten' => 'permit_empty',
            'status' => 'required|in_list[Draf,Diterbitkan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Clean user input slug format
        $slug = url_title($this->request->getPost('slug'), '-', true);

        $this->pagesModel->update($id, [
            'judul'  => $this->request->getPost('judul'),
            'slug'   => $slug,
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/pages'))->with('success', 'Halaman statis berhasil diperbarui.');
    }

    public function delete($id)
    {
        $page = $this->pagesModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Halaman tidak ditemukan.");
        }

        $this->pagesModel->delete($id);

        return redirect()->to(base_url('admin/pages'))->with('success', 'Halaman statis berhasil dihapus.');
    }
}
