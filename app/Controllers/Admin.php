<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KomentarModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function index()
    {
        $artikelModel = new ArtikelModel();
        $komentarModel = new KomentarModel();
        $userModel = new UserModel();

        // Hitung statistik dashboard
        $totalArticles = $artikelModel->countAllResults();
        $totalPendingComments = $komentarModel->where('status', 'Menunggu')->countAllResults();
        $totalUsers = $userModel->countAllResults();

        // Ambil data tabel artikel terbaru
        $recentArticles = $artikelModel->orderBy('tanggal_publikasi', 'DESC')->limit(5)->findAll();

        // Ambil data komentar yang menunggu moderasi (join artikel untuk menampilkan judul)
        $pendingComments = $komentarModel->select('trn_komentar.*, trn_artikel.judul as artikel_judul')
                                         ->join('trn_artikel', 'trn_artikel.artikel_id = trn_komentar.artikel_id')
                                         ->where('trn_komentar.status', 'Menunggu')
                                         ->orderBy('trn_komentar.created_at', 'DESC')
                                         ->findAll();

        $data = [
            'total_articles'         => $totalArticles,
            'total_pending_comments' => $totalPendingComments,
            'total_users'            => $totalUsers,
            'recent_articles'        => $recentArticles,
            'pending_comments'       => $pendingComments
        ];

        return view('admin/dashboard', $data);
    }

    public function approveKomentar($id)
    {
        $komentarModel = new \App\Models\KomentarModel();
        $komentarModel->update($id, ['status' => 'Disetujui']);
        return redirect()->to(base_url('admin'))->with('success', 'Komentar berhasil disetujui.');
    }

    public function spamKomentar($id)
    {
        $komentarModel = new \App\Models\KomentarModel();
        $komentarModel->update($id, ['status' => 'Spam']);
        return redirect()->to(base_url('admin'))->with('success', 'Komentar ditandai sebagai spam.');
    }
}
