<?php

namespace App\Controllers;

use App\Models\PagesModel;

class Page extends BaseController
{
    protected $pagesModel;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
    }

    public function view($slug)
    {
        $page = $this->pagesModel->where('slug', $slug)
                                 ->where('status', 'Diterbitkan')
                                 ->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $page['judul'],
            'page'  => $page
        ];

        return view('pages/view', $data);
    }
}
