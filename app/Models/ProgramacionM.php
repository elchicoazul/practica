<?php namespace App\Models;
use CodeIgniter\Model;
class ProgramacionM extends Model {
    
    public function insertar($datos)
    {
        log_message('info','estamos en registrar programaciones');

        // Insertar datos en la tabla scheduling
        $query = $this->db->table('scheduling');
        $query->insert($datos);
    
        $insertId = $this->db->insertID();

        // Obtener el stock actual del producto
        $productQuery = $this->db->table('product');
        $productQuery->select('stock');
        $productQuery->where('id', $datos['product_id']);
        $product = $productQuery->get()->getRow();
    
        // Sumar la cantidad al stock
        $newStock = $product->stock - $datos['amount'];
    
        // Actualizar el stock en la tabla producto
        $updateData = ['stock' => $newStock];
        $this->db->table('product')
                 ->where('id', $datos['product_id'])
                 ->update($updateData);
    
        // Devolver el ID de la inserción
        return $insertId;
    }


    public function obtenerTodos($id)
    {

        
        $query = $this->db->table('scheduling')
                            ->where('client_id', $id)
                            ->where('estado',0)
                            ->get();
        return $query->getResultArray();
    }

    public function eliminar($id) {

        log_message('info','estamos en eliminar programaciones');
        // Obtener los valores de id_producto y cantidad de la tabla scheduling
        $query = $this->db->table('scheduling');
        $query->select('product_id, amount');
        $query->where('id', $id);
        $result = $query->get()->getResult();

        // Iterar sobre los resultados para actualizar la tabla producto
        foreach ($result as $row) {
            // Obtener el total actual de la tabla producto
            $productQuery = $this->db->table('product');
            $productQuery->select('stock');
            $productQuery->where('id', $row->product_id);
            $product = $productQuery->get()->getRow();

            // Sumar la cantidad al total
            $newTotal = $product->stock + $row->amount;

            // Actualizar el total en la tabla producto
            $updateData = ['stock' => $newTotal];
            $this->db->table('product')
                    ->where('id', $row->product_id)
                    ->update($updateData);
        }

        return $this->db->table('scheduling')->where('id', $id)->delete();
    }
}