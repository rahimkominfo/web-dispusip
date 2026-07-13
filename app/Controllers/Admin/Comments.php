<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomentarModel;
use App\Models\ArtikelModel;

class Comments extends BaseController
{
    protected $komentarModel;
    protected $artikelModel;

    public function __construct()
    {
        $this->komentarModel = new KomentarModel();
        $this->artikelModel = new ArtikelModel();
    }

    public function index()
    {
        // Fetch comments and join with articles to display post title
        $comments = $this->komentarModel->select('trn_komentar.*, trn_artikel.judul as artikel_judul')
                                         ->join('trn_artikel', 'trn_artikel.artikel_id = trn_komentar.artikel_id', 'left')
                                         ->where('trn_komentar.deleted_at IS NULL')
                                         ->orderBy('trn_komentar.created_at', 'DESC')
                                         ->findAll();

        $data = [
            'comments' => $comments
        ];

        return view('admin/comments/index', $data);
    }

    public function approve($id)
    {
        $comment = $this->komentarModel->find($id);
        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar tidak ditemukan.");
        }

        $this->komentarModel->update($id, ['status' => 'Disetujui']);

        return redirect()->back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function spam($id)
    {
        $comment = $this->komentarModel->find($id);
        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar tidak ditemukan.");
        }

        $this->komentarModel->update($id, ['status' => 'Spam']);

        return redirect()->back()->with('success', 'Komentar ditandai sebagai spam.');
    }

    public function edit($id)
    {
        $comment = $this->komentarModel->find($id);
        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar tidak ditemukan.");
        }

        $data = [
            'comment' => $comment
        ];

        return view('admin/comments/edit', $data);
    }

    public function update($id)
    {
        $comment = $this->komentarModel->find($id);
        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar tidak ditemukan.");
        }

        $rules = [
            'nama_pengunjung'  => 'required|min_length[2]|max_length[100]',
            'email_pengunjung' => 'permit_empty|valid_email|max_length[100]',
            'isi_komentar'     => 'required|min_length[3]',
            'status'           => 'required|in_list[Disetujui,Menunggu,Spam]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->komentarModel->update($id, [
            'nama_pengunjung'  => $this->request->getPost('nama_pengunjung'),
            'email_pengunjung' => $this->request->getPost('email_pengunjung'),
            'isi_komentar'     => $this->request->getPost('isi_komentar'),
            'status'           => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/comments'))->with('success', 'Komentar berhasil diperbarui.');
    }

    public function reply($id)
    {
        $parentComment = $this->komentarModel->find($id);
        if (!$parentComment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar induk tidak ditemukan.");
        }

        $rules = [
            'reply_content' => 'required|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Get admin user name or use default
        $adminName = session()->get('nama_publik') ?: 'Admin Dispusip';

        $this->komentarModel->save([
            'artikel_id'        => $parentComment['artikel_id'],
            'nama_pengunjung'  => $adminName,
            'email_pengunjung' => 'admin@sinjaikab.go.id',
            'isi_komentar'     => $this->request->getPost('reply_content'),
            'status'           => 'Disetujui',
            'komentar_induk_id'=> $id
        ]);

        return redirect()->to(base_url('admin/comments'))->with('success', 'Balasan komentar berhasil dikirim.');
    }

    public function delete($id)
    {
        $comment = $this->komentarModel->find($id);
        if (!$comment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Komentar tidak ditemukan.");
        }

        // Delete children replies as well
        $this->komentarModel->where('komentar_induk_id', $id)->delete();

        $this->komentarModel->delete($id);

        return redirect()->to(base_url('admin/comments'))->with('success', 'Komentar berhasil dihapus.');
    }
}
