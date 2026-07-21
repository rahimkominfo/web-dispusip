<?php

namespace App\Controllers;

class Ipus extends BaseController
{
    public function index()
    {
        $data = [
            'title'    => 'iPusSinjai (Perpustakaan Digital)',
            'ipusUrl'  => 'https://web-ipussinjai.moco.co.id/login'
        ];

        return view('ipus/index', $data);
    }
}
