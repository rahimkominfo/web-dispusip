<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\TagsModel;

class News extends BaseController
{
    protected $artikelModel;
    protected $kategoriModel;
    protected $tagsModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategoriModel = new KategoriModel();
        $this->tagsModel = new TagsModel();
        helper('url');
    }

    public function index()
    {
        // Join with users and compile category names using GROUP_CONCAT
        $articles = $this->artikelModel->select('trn_artikel.*, sys_users.nama_publik as author_name, GROUP_CONCAT(mst_kategori.nama SEPARATOR ", ") as categories_list')
                                       ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id', 'left')
                                       ->join('trn_artikel_kategori', 'trn_artikel_kategori.artikel_id = trn_artikel.artikel_id', 'left')
                                       ->join('mst_kategori', 'mst_kategori.kategori_id = trn_artikel_kategori.kategori_id', 'left')
                                       ->where('trn_artikel.deleted_at IS NULL')
                                       ->groupBy('trn_artikel.artikel_id')
                                       ->orderBy('trn_artikel.tanggal_publikasi', 'DESC')
                                       ->findAll();

        $data = [
            'articles' => $articles
        ];

        return view('admin/news/index', $data);
    }

    public function create()
    {
        $categories = $this->kategoriModel->findAll();
        $tags = $this->tagsModel->findAll();

        $data = [
            'categories' => $categories,
            'tags'       => $tags
        ];

        return view('admin/news/create', $data);
    }

    public function store()
    {
        $rules = [
            'judul'             => 'required|min_length[5]|max_length[255]',
            'konten'            => 'required',
            'abstrak'           => 'permit_empty',
            'status'            => 'required|in_list[Draf,Ditayangkan,Diarsipkan]',
            'tanggal_publikasi' => 'required',
            'gambar_url'        => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar_utama');
        $hasFile = $file && $file->isValid() && !$file->hasMoved();

        if ($hasFile) {
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['gambar_utama' => 'Format gambar utama tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($file->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['gambar_utama' => 'Ukuran gambar utama terlalu besar. Maksimum 8MB.']);
            }
        }

        $gambarUrl = $this->request->getPost('gambar_url');

        // Handle Image Upload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/articles';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);
            $gambarUrl = base_url('uploads/articles/' . $newName);
        }

        // Generate UUID v4
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        // Generate SEO Slug
        $slug = url_title($this->request->getPost('judul'), '-', true);
        $baseSlug = $slug;
        $counter = 1;
        while ($this->artikelModel->where('slug', $slug)->first() !== null) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $userId = session()->get('user_id') ?: 1;

        $this->artikelModel->save([
            'artikel_uuid'      => $uuid,
            'judul'             => $this->request->getPost('judul'),
            'slug'              => $slug,
            'konten'            => $this->request->getPost('konten'),
            'gambar_utama'      => $gambarUrl,
            'abstrak'           => $this->request->getPost('abstrak'),
            'user_id'           => $userId,
            'status'            => $this->request->getPost('status'),
            'jumlah_tayang'     => 0,
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi')
        ]);

        $artikelId = $this->artikelModel->insertID();

        // Sync Categories
        $db = \Config\Database::connect();
        $categories = $this->request->getPost('categories');
        if (!empty($categories)) {
            foreach ($categories as $catId) {
                $db->table('trn_artikel_kategori')->insert([
                    'artikel_id'  => $artikelId,
                    'kategori_id' => $catId
                ]);
            }
        }

        // Sync Tags
        $tags = $this->request->getPost('tags');
        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $db->table('trn_artikel_tags')->insert([
                    'artikel_id' => $artikelId,
                    'tag_id'     => $tagId
                ]);
            }
        }

        return redirect()->to(base_url('admin/news'))->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $article = $this->artikelModel->find($id);
        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Artikel tidak ditemukan.");
        }

        $categories = $this->kategoriModel->findAll();
        $tags = $this->tagsModel->findAll();

        // Fetch selected categories and tags
        $db = \Config\Database::connect();
        $selectedCategories = array_column($db->table('trn_artikel_kategori')->where('artikel_id', $id)->get()->getResultArray(), 'kategori_id');
        $selectedTags = array_column($db->table('trn_artikel_tags')->where('artikel_id', $id)->get()->getResultArray(), 'tag_id');

        $data = [
            'article'            => $article,
            'categories'         => $categories,
            'tags'               => $tags,
            'selectedCategories' => $selectedCategories,
            'selectedTags'       => $selectedTags
        ];

        return view('admin/news/edit', $data);
    }

    public function update($id)
    {
        $article = $this->artikelModel->find($id);
        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Artikel tidak ditemukan.");
        }

        $rules = [
            'judul'             => 'required|min_length[5]|max_length[255]',
            'slug'              => "required|max_length[255]|is_unique[trn_artikel.slug,artikel_id,{$id}]",
            'konten'            => 'required',
            'abstrak'           => 'permit_empty',
            'status'            => 'required|in_list[Draf,Ditayangkan,Diarsipkan]',
            'tanggal_publikasi' => 'required',
            'gambar_url'        => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar_utama');
        $hasFile = $file && $file->isValid() && !$file->hasMoved();

        if ($hasFile) {
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['gambar_utama' => 'Format gambar utama tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($file->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['gambar_utama' => 'Ukuran gambar utama terlalu besar. Maksimum 8MB.']);
            }
        }

        $gambarUrl = $this->request->getPost('gambar_url');
        if (empty($gambarUrl)) {
            $gambarUrl = $article['gambar_utama'];
        }

        // Handle Image Replacement
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/articles';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);

            // Delete old file physically
            if (!empty($article['gambar_utama']) && strpos($article['gambar_utama'], base_url('uploads/articles/')) === 0) {
                $oldFilename = str_replace(base_url('uploads/articles/'), '', $article['gambar_utama']);
                $oldFilePath = FCPATH . 'uploads/articles/' . $oldFilename;
                if (is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $gambarUrl = base_url('uploads/articles/' . $newName);
        }

        $slug = url_title($this->request->getPost('slug'), '-', true);

        $this->artikelModel->update($id, [
            'judul'             => $this->request->getPost('judul'),
            'slug'              => $slug,
            'konten'            => $this->request->getPost('konten'),
            'gambar_utama'      => $gambarUrl,
            'abstrak'           => $this->request->getPost('abstrak'),
            'status'            => $this->request->getPost('status'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi')
        ]);

        $db = \Config\Database::connect();

        // Sync Categories
        $db->table('trn_artikel_kategori')->where('artikel_id', $id)->delete();
        $categories = $this->request->getPost('categories');
        if (!empty($categories)) {
            foreach ($categories as $catId) {
                $db->table('trn_artikel_kategori')->insert([
                    'artikel_id'  => $id,
                    'kategori_id' => $catId
                ]);
            }
        }

        // Sync Tags
        $db->table('trn_artikel_tags')->where('artikel_id', $id)->delete();
        $tags = $this->request->getPost('tags');
        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $db->table('trn_artikel_tags')->insert([
                    'artikel_id' => $id,
                    'tag_id'     => $tagId
                ]);
            }
        }

        return redirect()->to(base_url('admin/news'))->with('success', 'Berita berhasil diperbarui.');
    }

    public function delete($id)
    {
        $article = $this->artikelModel->find($id);
        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Artikel tidak ditemukan.");
        }

        // Soft deletes as configured in model (but let's physically delete file anyway or keep it since soft deleted?)
        // Standard soft-delete usually keeps files, but if user explicitly deletes, let's keep it to support restore, or delete to save space. Let's delete to save space or leave it. We can leave it for soft deletes.
        $this->artikelModel->delete($id);

        return redirect()->to(base_url('admin/news'))->with('success', 'Berita berhasil dihapus.');
    }
}
