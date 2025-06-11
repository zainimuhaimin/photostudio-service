<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananJasaModel extends Model
{
    protected $table            = 'table_pemensanan_jasa';
    protected $primaryKey       = 'id_pemensanan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jasa', 'id_pelanggan', 'tanggal', 'total', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted'];

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

    public function getTransaksiPemesananJasaJoinPembayaranByIdPelanggan($id_pelanggan){
        $builder = $this->db->table('table_pemensanan_jasa');
        $builder->select('table_pemensanan_jasa.*, table_pembayaran.*, table_jasa.*');
        $builder->join('table_pembayaran', 'table_pembayaran.id_pemensanan = table_pemensanan_jasa.id_pemensanan');
        $builder->join('table_jasa', 'table_jasa.id_jasa = table_pemensanan_jasa.id_jasa');
        $builder->where('table_pemensanan_jasa.id_pelanggan', $id_pelanggan);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTransaksiPemesananJasaJoinPembayaran(){
        $builder = $this->db->table('table_pemensanan_jasa');
        $builder->select('table_pemensanan_jasa.*, table_pembayaran.*, table_jasa.*');
        $builder->join('table_pembayaran', 'table_pembayaran.id_pemensanan = table_pemensanan_jasa.id_pemensanan');
        $builder->join('table_jasa', 'table_jasa.id_jasa = table_pemensanan_jasa.id_jasa');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
