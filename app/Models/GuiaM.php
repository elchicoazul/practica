<?php namespace App\Models;
use CodeIgniter\Model;
class GuiaM extends Model { 
    
    public function guardar($datos){
        $query = $this->db->table('IngressGuideTemp');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function guardarguia($datos){
        $query = $this->db->table('Guide');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function insertar($datos){
        $query = $this->db->table('IngressGuide');
        $query->insert($datos);
        return $this->db->InsertId();
    }

    public function obtenerDatos($userId) {
        // Utilizar el query builder del modelo con una condición where
        $query = $this->db->table('IngressGuideTemp')
                          ->where('user_id', $userId)
                          ->get();
        return $query->getResultArray();
    }
    public function eliminar($data) {
        $query = $this->db->table('IngressGuideTemp');
        $query->where($data);
        return $query->delete();
    }
   
}

?>