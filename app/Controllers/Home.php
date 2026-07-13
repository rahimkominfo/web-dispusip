<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\FlyerModel;
use App\Models\GaleriModel;
use App\Models\GaleriGambarModel;

class Home extends BaseController
{
    public function index()
    {
        $artikelModel = new ArtikelModel();
        $flyerModel = new FlyerModel();

        // Ambil artikel terbaru yang ditayangkan (limit 3 untuk homepage)
        $latestArticles = $artikelModel->getArtikelWithUser();
        $latestArticles = array_slice($latestArticles, 0, 3);

        // Ambil flyer promosi aktif
        $flyers = $flyerModel->where('status', 'Aktif')->orderBy('urutan', 'ASC')->findAll();

        // Ambil Galeri Kegiatan (limit 4 untuk homepage)
        $galeriModel = new GaleriModel();
        $galeriGambarModel = new GaleriGambarModel();
        $galleries = $galeriModel->orderBy('created_at', 'DESC')->limit(4)->findAll();
        
        // Ambil gambar untuk tiap galeri
        foreach ($galleries as &$gallery) {
            $gallery['photos'] = $galeriGambarModel->where('galeri_id', $gallery['galeri_id'])->findAll();
        }

        $data = [
            'latest_articles' => $latestArticles,
            'flyers'          => $flyers,
            'galleries'       => $galleries
        ];

        return view('home/index', $data);
    }
}
