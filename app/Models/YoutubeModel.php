<?php

namespace App\Models;

use CodeIgniter\Model;

class YoutubeModel extends Model
{
    protected $table            = 'trn_video_youtube';
    protected $primaryKey       = 'video_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul', 'youtube_id', 'deskripsi', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
