<?php namespace App\Models;
use CodeIgniter\Model;
class Usuario extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';

    public function insertar($datos){
        $Public = $this->db->table('user');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
    
    public function obtenerUsuarios($searchTerm)
    {
        $builder = $this->builder();
        $query = $builder->like('username', $searchTerm)
                        ->select('id, username as text,dni_ruc')
                        ->limit(10)
                        ->get();

        return $query->getResult();
    }
}