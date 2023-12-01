<?php namespace App\Models;
use CodeIgniter\Model;
class ConfiguracionM extends Model {
    
    public function insertar($datos){
        $Public = $this->db->table('configuracion');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
}