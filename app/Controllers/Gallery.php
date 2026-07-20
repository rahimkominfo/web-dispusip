<?php

namespace App\Controllers;

use App\Models\GaleriModel;
use App\Models\GaleriGambarModel;
use App\Models\YoutubeModel;

class Gallery extends BaseController
{
    public function index()
    {
        $galeriModel = new GaleriModel();
        $galeriGambarModel = new GaleriGambarModel();
        
        // Fetch all galleries, newest first
        $galleries = $galeriModel->orderBy('created_at', 'DESC')->findAll();
        
        // Fetch photos for each gallery
        foreach ($galleries as &$gallery) {
            $gallery['photos'] = $galeriGambarModel->where('galeri_id', $gallery['galeri_id'])->findAll();
        }

        $data = [
            'galleries' => $galleries
        ];

        return view('gallery/index', $data);
    }

    public function video()
    {
        $youtubeModel = new YoutubeModel();
        
        // Fetch active videos, newest first
        $videos = $youtubeModel->where('status', 'Aktif')->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'videos' => $videos
        ];

        return view('gallery/video', $data);
    }
}
