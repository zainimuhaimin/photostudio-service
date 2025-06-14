<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAuthenticationModel extends Model
{
    protected $table            = 'user_authentication';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'id_role', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted'];

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

    public function getUserByUserId($id)
    {
        $this->select('user_authentication.*, table_pelanggan.*');
        $this->join('table_pelanggan', 'table_pelanggan.id_user = user_authentication.id_user');
        return $this->where('user_authentication.id_user', $id)->first();
    }
}
