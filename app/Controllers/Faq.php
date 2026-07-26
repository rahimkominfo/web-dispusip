<?php

namespace App\Controllers;

class Faq extends BaseController
{
    public function index()
    {
        $data = [
            'title'  => 'FAQ - Pertanyaan Umum',
            'faqUrl' => 'https://kb.sinjaikab.go.id/dilan/embed/faq/11'
        ];

        return view('faq/index', $data);
    }
}
