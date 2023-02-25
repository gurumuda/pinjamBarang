<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDataPinjamBarang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'dataPinjamBarang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    function dataKu()
    {
        return $this->select('*, dataPinjamBarang.id as idP')
            ->join('dataBarang', 'dataBarang.id = dataPinjamBarang.idBarang')
            ->orderBy('status', 'ASC')
            ->orderBy('dataPinjamBarang.id', 'DESC');
    }
}
