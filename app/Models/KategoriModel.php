<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'mst_kategori';
    protected $primaryKey       = 'kategori_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kategori_uuid', 'nama', 'slug', 'kategori_induk_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Mengambil kategori beserta jumlah artikel terkait.
     */
    public function getCategoriesWithCount()
    {
        return $this->select('mst_kategori.*, COUNT(trn_artikel_kategori.artikel_id) as artikel_count')
                    ->join('trn_artikel_kategori', 'trn_artikel_kategori.kategori_id = mst_kategori.kategori_id', 'left')
                    ->join('trn_artikel', 'trn_artikel.artikel_id = trn_artikel_kategori.artikel_id AND trn_artikel.deleted_at IS NULL AND trn_artikel.status = "Ditayangkan"', 'left')
                    ->where('mst_kategori.deleted_at IS NULL')
                    ->groupBy('mst_kategori.kategori_id')
                    ->findAll();
    }
}
