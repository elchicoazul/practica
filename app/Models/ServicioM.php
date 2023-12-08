<?php namespace App\Models;
use CodeIgniter\Model;
class ServicioM extends Model {
    
    public function insertar($datos){
        $Public = $this->db->table('service');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
    public function obtenerTodosServicios()
    {
        $query = $this->db->table('service')
                          ->get();
        return $query->getResultArray();
    }
    public function eliminar($data) {
        $query = $this->db->table('service');
        $query->where($data);
        return $query->delete();
    }
    public function actualizar($id, $datos){
        $query = $this->db->table('service'); // Asegúrese de que $this->table esté definido correctamente en su modelo
    
        // Actualizar el registro con el ID especificado
        $query->where('id', $id); // Asegúrese de que $this->primaryKey esté definido correctamente
        $result = $query->update($datos);
    
        // Si desea devolver algo específico, como el estado de la operación, puede hacerlo aquí
        // $result será verdadero si la actualización fue exitosa
        return $result;
    }
}