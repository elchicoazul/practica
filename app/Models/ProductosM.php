<?php namespace App\Models;
use CodeIgniter\Model;
class ProductosM extends Model {
    
    public function insertar($datos){
        $Public = $this->db->table('productos');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
}