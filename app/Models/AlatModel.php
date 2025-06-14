<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'table_alat';
    protected $primaryKey       = 'id_alat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = ['nama_alat', 'harga_alat', 'deskripsi', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'image_path'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllAlat()
    {
        $builder = $this->db->table('table_alat as ta');
        $builder->select('ta.nama_alat, ta.harga_alat, ta.deskripsi, ta.id_alat');
        $builder->where('is_deleted', 0);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAlatByIdJoinPenyewaanAlatJoinPembayaran($id_alat)
    {
        $builder = $this->db->table('table_alat as ta');
        $builder->select('ta.nama_alat, ta.harga_alat, ta.deskripsi, ta.id_alat');
        $builder->join('table_penyewaan_alat as tpa', 'ta.id_alat = tpa.id_alat');
        $builder->join('table_pembayaran as tp', 'tpa.id_penyewaan = tp.id_penyewaan');
        $builder->where('ta.id_alat', $id_alat);
        $builder->where('ta.is_deleted', 0);
        $builder->where('tpa.is_deleted', 0);
        $builder->where('tp.is_deleted', 0);
        $query = $builder->get();
        return $query->getResult();
    }
}
