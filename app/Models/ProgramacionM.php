<?php namespace App\Models;
use CodeIgniter\Model;
class ProgramacionM extends Model {
    
    public function insertar($datos)
    {
        $query = $this->db->table('scheduling');
        $query->insert($datos);
        return $this->db->InsertId();
    }


    public function obtenerTodos()
    {
        $query = $this->db->table('scheduling')
                          ->get();
        return $query->getResultArray();
    }

}