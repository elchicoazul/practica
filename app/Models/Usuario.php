<?php namespace App\Models;
use CodeIgniter\Model;
class Usuario extends Model {
    public function insertar($datos){
        $Public = $this->db->table('user');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
}