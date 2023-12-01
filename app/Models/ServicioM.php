<?php namespace App\Models;
use CodeIgniter\Model;
class ServicioM extends Model {
    
    public function insertar($datos){
        $Public = $this->db->table('servicio');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
}