<?php

namespace App\Models;

use CodeIgniter\Model;

class JasaModel extends Model
{
    protected $table            = 'table_jasa';
    protected $primaryKey       = 'id_jasa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_jasa', 'harga_jasa', 'deskripsi', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted'];

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

    public function getJasaByIdJoinPemesananJasaJoinPembayaran($id_jasa)
    {
        $builder = $this->db->table('table_jasa as tj');
        $builder->select('tj.nama_jasa, tj.harga_jasa, tj.deskripsi, tj.id_jasa');
        $builder->join('table_pemensanan_jasa as tpj', 'tj.id_jasa = tpj.id_jasa');
        $builder->join('table_pembayaran as tp', 'tpj.id_pemensanan = tp.id_pemensanan');
        $builder->where('tj.id_jasa', $id_jasa);
        $builder->where('tj.is_deleted', 0);
        $builder->where('tpj.is_deleted', 0);
        $builder->where('tp.is_deleted', 0);
        $query = $builder->get();
        return $query->getFirstRow();
    }
}
