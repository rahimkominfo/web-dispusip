<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriGambarModel extends Model
{
    protected $table            = 'trn_galeri_gambar';
    protected $primaryKey       = 'galeri_gambar_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'galeri_id', 'gambar_url', 'caption'
    ];
}
