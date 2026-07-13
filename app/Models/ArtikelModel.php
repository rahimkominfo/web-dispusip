<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'trn_artikel';
    protected $primaryKey       = 'artikel_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'artikel_uuid', 'judul', 'slug', 'konten', 'gambar_utama', 
        'abstrak', 'user_id', 'status', 'jumlah_tayang', 'tanggal_publikasi'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Mengambil artikel yang ditayangkan beserta nama publik pembuatnya.
     */
    public function getArtikelWithUser($slug = null)
    {
        if ($slug === null) {
            return $this->select('trn_artikel.*, sys_users.nama_publik as author_name')
                        ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id')
                        ->where('trn_artikel.status', 'Ditayangkan')
                        ->orderBy('tanggal_publikasi', 'DESC')
                        ->findAll();
        }

        return $this->select('trn_artikel.*, sys_users.nama_publik as author_name')
                    ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id')
                    ->where('trn_artikel.slug', $slug)
                    ->where('trn_artikel.status', 'Ditayangkan')
                    ->first();
    }
}
