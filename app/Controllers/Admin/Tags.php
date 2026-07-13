<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagsModel;

class Tags extends BaseController
{
    protected $tagsModel;

    public function __construct()
    {
        $this->tagsModel = new TagsModel();
        helper('url');
    }

    public function index()
    {
        // Fetch tags and count how many published articles are linked to each tag
        $tags = $this->tagsModel->select('mst_tags.*, COUNT(trn_artikel_tags.artikel_id) as artikel_count')
                                ->join('trn_artikel_tags', 'trn_artikel_tags.tag_id = mst_tags.tag_id', 'left')
                                ->join('trn_artikel', 'trn_artikel.artikel_id = trn_artikel_tags.artikel_id AND trn_artikel.deleted_at IS NULL AND trn_artikel.status = "Ditayangkan"', 'left')
                                ->where('mst_tags.deleted_at IS NULL')
                                ->groupBy('mst_tags.tag_id')
                                ->orderBy('mst_tags.created_at', 'DESC')
                                ->findAll();

        $data = [
            'tags' => $tags
        ];

        return view('admin/tags/index', $data);
    }

    public function create()
    {
        return view('admin/tags/create');
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[2]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate dynamic SEO slug from tag name
        $slug = url_title($this->request->getPost('nama'), '-', true);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while ($this->tagsModel->where('slug', $slug)->first() !== null) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $this->tagsModel->save([
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug
        ]);

        return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tag = $this->tagsModel->find($id);
        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tag tidak ditemukan.");
        }

        $data = [
            'tag' => $tag
        ];

        return view('admin/tags/edit', $data);
    }

    public function update($id)
    {
        $tag = $this->tagsModel->find($id);
        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tag tidak ditemukan.");
        }

        $rules = [
            'nama' => 'required|min_length[2]|max_length[50]',
            'slug' => "required|max_length[50]|is_unique[mst_tags.slug,tag_id,{$id}]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Clean user input slug format
        $slug = url_title($this->request->getPost('slug'), '-', true);

        $this->tagsModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug
        ]);

        return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil diperbarui.');
    }

    public function delete($id)
    {
        $tag = $this->tagsModel->find($id);
        if (!$tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tag tidak ditemukan.");
        }

        $this->tagsModel->delete($id);

        return redirect()->to(base_url('admin/tags'))->with('success', 'Tag berhasil dihapus.');
    }
}
