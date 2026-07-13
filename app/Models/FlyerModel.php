<?php

namespace App\Models;

use CodeIgniter\Model;

class FlyerModel extends Model
{
    protected $table            = 'mst_flyer';
    protected $primaryKey       = 'flayer_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'uuid', 'judul', 'gambar_url', 'label', 'status', 'urutan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
