<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Categories extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        helper('url');
    }

    public function index()
    {
        // Join self to get parent name, and count associated articles
        $categories = $this->kategoriModel->select('mst_kategori.*, parent.nama as parent_nama, COUNT(trn_artikel_kategori.artikel_id) as artikel_count')
                                          ->join('mst_kategori parent', 'parent.kategori_id = mst_kategori.kategori_induk_id', 'left')
                                          ->join('trn_artikel_kategori', 'trn_artikel_kategori.kategori_id = mst_kategori.kategori_id', 'left')
                                          ->join('trn_artikel', 'trn_artikel.artikel_id = trn_artikel_kategori.artikel_id AND trn_artikel.deleted_at IS NULL AND trn_artikel.status = "Ditayangkan"', 'left')
                                          ->where('mst_kategori.deleted_at IS NULL')
                                          ->groupBy('mst_kategori.kategori_id')
                                          ->orderBy('mst_kategori.created_at', 'DESC')
                                          ->findAll();

        $data = [
            'categories' => $categories
        ];

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        // Retrieve top-level categories as parent options
        $parentCategories = $this->kategoriModel->where('kategori_induk_id', null)->findAll();

        $data = [
            'parentCategories' => $parentCategories
        ];

        return view('admin/categories/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama'              => 'required|min_length[2]|max_length[100]',
            'kategori_induk_id' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate dynamic SEO slug from category name
        $slug = url_title($this->request->getPost('nama'), '-', true);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while ($this->kategoriModel->where('slug', $slug)->first() !== null) {
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

        $parentId = $this->request->getPost('kategori_induk_id');
        $parentId = ($parentId === '' || $parentId === '0') ? null : $parentId;

        $this->kategoriModel->save([
            'kategori_uuid'     => $uuid,
            'nama'              => $this->request->getPost('nama'),
            'slug'              => $slug,
            'kategori_induk_id' => $parentId
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->kategoriModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori tidak ditemukan.");
        }

        // Get potential parent categories (excluding self to avoid hierarchy loops)
        $parentCategories = $this->kategoriModel->where('kategori_induk_id', null)
                                               ->where('kategori_id !=', $id)
                                               ->findAll();

        $data = [
            'category'         => $category,
            'parentCategories' => $parentCategories
        ];

        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $category = $this->kategoriModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori tidak ditemukan.");
        }

        $rules = [
            'nama'              => 'required|min_length[2]|max_length[100]',
            'slug'              => "required|max_length[100]|is_unique[mst_kategori.slug,kategori_id,{$id}]",
            'kategori_induk_id' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parentId = $this->request->getPost('kategori_induk_id');
        $parentId = ($parentId === '' || $parentId === '0') ? null : $parentId;

        // Prevent setting self as parent
        if ($parentId == $id) {
            return redirect()->back()->withInput()->with('errors', ['kategori_induk_id' => 'Kategori tidak dapat menjadi induk dari dirinya sendiri.']);
        }

        // Clean user input slug format
        $slug = url_title($this->request->getPost('slug'), '-', true);

        $this->kategoriModel->update($id, [
            'nama'              => $this->request->getPost('nama'),
            'slug'              => $slug,
            'kategori_induk_id' => $parentId
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->kategoriModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori tidak ditemukan.");
        }

        // Set child categories' parent to null before deletion
        $this->kategoriModel->where('kategori_induk_id', $id)->set(['kategori_induk_id' => null])->update();

        $this->kategoriModel->delete($id);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil dihapus.');
    }
}
