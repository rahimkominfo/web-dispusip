<?php

namespace App\Controllers;

use App\Models\FlyerModel;

class Flyers extends BaseController
{
    public function index()
    {
        $flyerModel = new FlyerModel();
        
        // Fetch all active flyers ordered by sequence
        $flyers = $flyerModel->where('status', 'Aktif')
                             ->orderBy('urutan', 'ASC')
                             ->findAll();
        
        $data = [
            'flyers' => $flyers,
        ];
        
        return view('flyers/index', $data);
    }
}
