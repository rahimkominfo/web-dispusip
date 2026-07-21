<?php

namespace App\Controllers;

class Opac extends BaseController
{
    public function index()
    {
        $data = [
            'title'   => 'OPAC (Katalog Perpustakaan)',
            'opacUrl' => 'https://apl.sinjaikab.go.id/inlislite5/opac/'
        ];

        return view('opac/index', $data);
    }
}
