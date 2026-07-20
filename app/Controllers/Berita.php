<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\TagsModel;
use App\Models\KomentarModel;

class Berita extends BaseController
{
    public function index()
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();
        $tagsModel = new TagsModel();

        // Ambil parameter filter, pencarian, dan pengurutan
        $cari = $this->request->getGet('cari');
        $kategoriSlug = $this->request->getGet('kategori');
        $urutkan = $this->request->getGet('urutkan');

        // Bangun kueri artikel
        $builder = $artikelModel->select('trn_artikel.*, sys_users.nama_publik as author_name, GROUP_CONCAT(mst_kategori.nama SEPARATOR ", ") as categories_list')
                                ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id', 'left')
                                ->join('trn_artikel_kategori', 'trn_artikel_kategori.artikel_id = trn_artikel.artikel_id', 'left')
                                ->join('mst_kategori', 'mst_kategori.kategori_id = trn_artikel_kategori.kategori_id', 'left')
                                ->where('trn_artikel.status', 'Ditayangkan');

        if (!empty($cari)) {
            $builder->groupStart()
                    ->like('trn_artikel.judul', $cari)
                    ->orLike('trn_artikel.konten', $cari)
                    ->groupEnd();
        }

        if (!empty($kategoriSlug)) {
            $builder->where('mst_kategori.slug', $kategoriSlug);
        }

        if ($urutkan === 'terlama') {
            $builder->orderBy('trn_artikel.tanggal_publikasi', 'ASC');
        } elseif ($urutkan === 'terpopuler') {
            $builder->orderBy('trn_artikel.jumlah_tayang', 'DESC');
        } else {
            $builder->orderBy('trn_artikel.tanggal_publikasi', 'DESC');
        }

        $builder->groupBy('trn_artikel.artikel_id');

        // Paginate dengan limit 3 per halaman
        $articles = $builder->paginate(3, 'default');
        $pager = $artikelModel->pager;

        // Ambil data sidebar
        $categories = $kategoriModel->getCategoriesWithCount();
        $tags = $tagsModel->findAll();
        $popularArticles = $artikelModel->orderBy('jumlah_tayang', 'DESC')->limit(2)->findAll();

        $data = [
            'articles'         => $articles,
            'pager'            => $pager,
            'categories'       => $categories,
            'tags'             => $tags,
            'popular_articles' => $popularArticles,
            'cari'             => $cari,
            'kategori_slug'    => $kategoriSlug,
            'urutkan'          => $urutkan
        ];

        return view('berita/index', $data);
    }

    public function detail($slug)
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();
        $tagsModel = new TagsModel();
        $komentarModel = new KomentarModel();

        // Ambil satu artikel berdasarkan slug
        $article = $artikelModel->getArtikelWithUser($slug);
        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan.");
        }

        // Tambah jumlah tayang
        $artikelModel->update($article['artikel_id'], [
            'jumlah_tayang' => $article['jumlah_tayang'] + 1
        ]);

        $db = \Config\Database::connect();
        
        // Ambil kategori dari artikel ini
        $articleCategory = $db->table('trn_artikel_kategori')
                              ->select('mst_kategori.nama, mst_kategori.slug')
                              ->join('mst_kategori', 'mst_kategori.kategori_id = trn_artikel_kategori.kategori_id')
                              ->where('trn_artikel_kategori.artikel_id', $article['artikel_id'])
                              ->get()
                              ->getRowArray();

        // Ambil tags dari artikel ini
        $articleTags = $db->table('trn_artikel_tags')
                          ->select('mst_tags.nama, mst_tags.slug')
                          ->join('mst_tags', 'mst_tags.tag_id = trn_artikel_tags.tag_id')
                          ->where('trn_artikel_tags.artikel_id', $article['artikel_id'])
                          ->get()
                          ->getResultArray();

        // Ambil komentar disetujui
        $comments = $komentarModel->where('artikel_id', $article['artikel_id'])
                                  ->where('status', 'Disetujui')
                                  ->orderBy('created_at', 'ASC')
                                  ->findAll();

        // Kelompokkan komentar bersarang (parent-child)
        $parentComments = [];
        $replies = [];
        foreach ($comments as $comment) {
            if ($comment['komentar_induk_id'] === null) {
                $parentComments[] = $comment;
            } else {
                $replies[$comment['komentar_induk_id']][] = $comment;
            }
        }

        // Data sidebar
        $categories = $kategoriModel->getCategoriesWithCount();
        $latestArticles = $artikelModel->where('status', 'Ditayangkan')->orderBy('tanggal_publikasi', 'DESC')->limit(3)->findAll();
        $popularArticles = $artikelModel->where('status', 'Ditayangkan')->orderBy('jumlah_tayang', 'DESC')->limit(3)->findAll();

        $data = [
            'article'          => $article,
            'category'         => $articleCategory,
            'tags'             => $articleTags,
            'parent_comments'  => $parentComments,
            'replies'          => $replies,
            'categories'       => $categories,
            'latest_articles'  => $latestArticles,
            'popular_articles' => $popularArticles
        ];

        return view('berita/detail', $data);
    }

    public function tambahKomentar()
    {
        $komentarModel = new \App\Models\KomentarModel();
        
        $artikelId = $this->request->getPost('artikel_id');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $isi = $this->request->getPost('komentar');
        $indukId = $this->request->getPost('komentar_induk_id');
        $slug = $this->request->getPost('slug');

        if (!empty($nama) && !empty($isi)) {
            $komentarModel->save([
                'artikel_id'        => $artikelId,
                'nama_pengunjung'   => $nama,
                'email_pengunjung'  => $email,
                'isi_komentar'      => $isi,
                'status'            => 'Menunggu',
                'komentar_induk_id' => empty($indukId) ? null : $indukId
            ]);
            
            return redirect()->to(base_url('berita/' . $slug))->with('success', 'Komentar Anda sedang menunggu persetujuan admin.');
        }

        return redirect()->to(base_url('berita/' . $slug))->with('error', 'Nama dan komentar tidak boleh kosong.');
    }
}
