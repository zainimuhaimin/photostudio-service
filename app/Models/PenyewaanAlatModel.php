<?php

namespace App\Models;

use App\Enum\StatusPembayaranEnum;
use CodeIgniter\Model;

class PenyewaanAlatModel extends Model
{
    protected $table            = 'table_penyewaan_alat';
    protected $primaryKey       = 'id_penyewaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_alat', 'id_pelanggan', 'tanggal', 'total', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted'];

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

    public function getTransaksiSewaJoinPembayaranByIdPelanggan($id_pelanggan){
        $builder = $this->db->table('table_penyewaan_alat');
        $builder->select('table_penyewaan_alat.*, table_pembayaran.*, table_alat.*');
        $builder->join('table_pembayaran', 'table_pembayaran.id_penyewaan = table_penyewaan_alat.id_penyewaan');
        $builder->join('table_alat', 'table_alat.id_alat = table_penyewaan_alat.id_alat');
        $builder->where('table_penyewaan_alat.id_pelanggan', $id_pelanggan);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTransaksiSewaJoinPembayaran(){
        $builder = $this->db->table('table_penyewaan_alat');
        $builder->select('table_penyewaan_alat.*, table_pembayaran.*, table_alat.*');
        $builder->join('table_pembayaran', 'table_pembayaran.id_penyewaan = table_penyewaan_alat.id_penyewaan');
        $builder->join('table_alat', 'table_alat.id_alat = table_penyewaan_alat.id_alat');
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function getDataBooked($requestedAlatId, $requestedDate){
        $builder = $this->db->table('table_penyewaan_alat tpa');
        $builder->select('tpa.*');
        $builder->join('table_pembayaran tp', 'tp.id_penyewaan = tpa.id_penyewaan');
        $builder->where('tpa.id_alat', $requestedAlatId);
        $builder->groupStart();
        $builder->orWhere('tpa.tanggal', $requestedDate);
        $builder->orWhere('tp.status_pembayaran', StatusPembayaranEnum::BOOKED->value);
        $builder->groupEnd();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getBookedPenyewaanAlat($startDate, $endDate, $idAlat){
        error_log("start get booked pemesanan jasa");
        error_log("id alat : ".$idAlat);
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');
        $builder = $this->db->table('table_penyewaan_alat');
        $builder->select('table_penyewaan_alat.*');
        $builder->where('table_penyewaan_alat.id_alat', $idAlat);
        $builder->where('table_penyewaan_alat.is_deleted', 0);
        $builder->where('table_penyewaan_alat.tanggal >=', $startDate);
        $builder->where('table_penyewaan_alat.tanggal <= ', $endDate);
        $query = $builder->get();
        return $query->getResultArray();
    }
}
