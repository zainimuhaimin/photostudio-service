<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'table_pembayaran';
    protected $primaryKey       = 'id_pembayaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_penyewaan', 'id_pemensanan', 'metode_pembayaran', 'tanggal_pembayaran', 'bukti_pembayaran', 'status_pembayaran', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'transaction_id'];

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

    public function getPembayaranByIdPelanggan($idPelanggan)
    {
        $builder = $this->db->table('table_pembayaran tp');
        $builder->select('tp.*, tpa.*, ta.*, tpj.*, tj.*');

        $builder->join('table_penyewaan_alat tpa', 'tp.id_penyewaan = tpa.id_penyewaan', 'left');
        $builder->join('table_alat ta', 'ta.id_alat = tpa.id_alat', 'left');
        $builder->join('table_pemensanan_jasa tpj', 'tpj.id_pemensanan = tp.id_pemensanan', 'left');
        $builder->join('table_jasa tj', 'tj.id_jasa = tpj.id_jasa', 'left');

        $builder->groupStart();
        $builder->where('tpa.id_pelanggan', $idPelanggan);
        $builder->orWhere('tpj.id_pelanggan', $idPelanggan);
        $builder->groupEnd();
        $builder->where('tp.is_deleted', 0);
        $builder->orderBy('tp.id_pembayaran', 'DESC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAllPembayaran()
    {
        $builder = $this->db->table('table_pembayaran tp');
        $builder->select('tp.*, tpa.*, ta.*, tpj.*, tj.*');

        $builder->join('table_penyewaan_alat tpa', 'tp.id_penyewaan = tpa.id_penyewaan', 'left');
        $builder->join('table_alat ta', 'ta.id_alat = tpa.id_alat', 'left');
        $builder->join('table_pemensanan_jasa tpj', 'tpj.id_pemensanan = tp.id_pemensanan', 'left');
        $builder->join('table_jasa tj', 'tj.id_jasa = tpj.id_jasa', 'left');

        $builder->where('tp.is_deleted', 0);
        $builder->orderBy('tp.id_pembayaran', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPembayaranByIdPelangganAndIdPembayaran($idPelanggan, $idPembayaran, $status = null)
    {
        error_log("ID Pelanggan: $idPelanggan, ID Pembayaran: $idPembayaran, Status: $status");
        $builder = $this->db->table('table_pembayaran tp');
        $builder->select('tp.id_pembayaran as id_pembayaran, tp.metode_pembayaran as metode_pembayaran , tp.status_pembayaran as status_pembayaran, tpa.*, ta.*, tpj.*, tj.*, tp2.*, tp3.*, tp2.nama as nama_pelanggan_sewa_alat, tp3.nama as nama_pelanggan_pemesan_jasa, tp2.email as email_sewa_alat, tp3.email as email_pesan_jasa, tpa.tanggal as tanggal_penyewaan, tpj.tanggal as tanggal_pemesanan_jasa');

        $builder->join('table_penyewaan_alat tpa', 'tp.id_penyewaan = tpa.id_penyewaan', 'left');
        $builder->join('table_alat ta', 'ta.id_alat = tpa.id_alat', 'left');
        $builder->join('table_pemensanan_jasa tpj', 'tpj.id_pemensanan = tp.id_pemensanan', 'left');
        $builder->join('table_jasa tj', 'tj.id_jasa = tpj.id_jasa', 'left');
        $builder->join('table_pelanggan tp2', 'tp2.id_pelanggan = tpa.id_pelanggan', 'left');
        $builder->join('table_pelanggan tp3', 'tp3.id_pelanggan = tpj.id_pelanggan', 'left');

        $builder->where('tp.id_pembayaran', $idPembayaran);
        if (!empty($status)) {
            $builder->where('tp.status_pembayaran', $status);
        }

        $builder->groupStart();
        $builder->where('tpa.id_pelanggan', $idPelanggan);
        $builder->orWhere('tpj.id_pelanggan', $idPelanggan);
        $builder->groupEnd();

        $query = $builder->get();
        return $query->getFirstRow();
    }

    public function getPembayaranByIdPembayaran($idPembayaran)
    {
        error_log("ID Pembayaran: $idPembayaran");
        $builder = $this->db->table('table_pembayaran tp');
        $builder->select('tp.tanggal_pembayaran as tanggal_pembayaran, tp.transaction_id as transaction_id, tp.id_pembayaran as id_pembayaran, tp.metode_pembayaran as metode_pembayaran , tp.status_pembayaran as status_pembayaran, tpa.*, ta.*, tpj.*, tj.*, tp2.*, tp3.*, tp2.nama as nama_pelanggan_sewa_alat, tp3.nama as nama_pelanggan_pemesan_jasa, tp2.email as email_sewa_alat, tp3.email as email_pesan_jasa, tpa.tanggal as tanggal_penyewaan, tpj.tanggal as tanggal_pemesanan_jasa');

        $builder->join('table_penyewaan_alat tpa', 'tp.id_penyewaan = tpa.id_penyewaan', 'left');
        $builder->join('table_alat ta', 'ta.id_alat = tpa.id_alat', 'left');
        $builder->join('table_pemensanan_jasa tpj', 'tpj.id_pemensanan = tp.id_pemensanan', 'left');
        $builder->join('table_jasa tj', 'tj.id_jasa = tpj.id_jasa', 'left');
        $builder->join('table_pelanggan tp2', 'tp2.id_pelanggan = tpa.id_pelanggan', 'left');
        $builder->join('table_pelanggan tp3', 'tp3.id_pelanggan = tpj.id_pelanggan', 'left');

        $builder->where('tp.id_pembayaran', $idPembayaran);

        $query = $builder->get();
        return $query->getFirstRow();
    }
}
