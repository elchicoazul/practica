<?php namespace App\Models;
use CodeIgniter\Model;
class ProductosM extends Model {
    
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock'];

    public function insertar($datos)
    {
        $this->insert($datos);
        return $this->insertID();
    }

    public function obtenerTodos()
    {
        $query = $this->db->table('product')
                          ->get();
        return $query->getResultArray();
    }

    public function obtenerProductos($searchTerm)
    {
        $builder = $this->builder();
        $query = $builder->like('name', $searchTerm)
                        ->select($this->primaryKey . ', name as text, stock, price')
                        ->limit(10)
                        ->get();

        return $query->getResult();
    }

    //eliminar productos
    public function eliminar($data) {
        $query = $this->db->table('product');
        $query->where($data);
        return $query->delete();
    }
    public function actualizar($id, $datos){
        $query = $this->db->table('product'); // Asegúrese de que $this->table esté definido correctamente en su modelo
    
        // Actualizar el registro con el ID especificado
        $query->where('id', $id); // Asegúrese de que $this->primaryKey esté definido correctamente
        $result = $query->update($datos);
    
        // Si desea devolver algo específico, como el estado de la operación, puede hacerlo aquí
        // $result será verdadero si la actualización fue exitosa
        return $result;
    }
}