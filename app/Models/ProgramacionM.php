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

    //liquidarfac
    public function obtenerTodosTemp($id){
        $query = $this->db->table('scheduling')
                        ->select('*,scheduling.id as ids')
                        ->join('product','product.id=scheduling.product_id')
                        ->where('client_id', $id)
                        ->where('temp', 0) // Agregar esta condición para obtener solo registros con temp = 0
                        ->get();

        return $query->getResultArray();
    }

    public function obtenerbyid($id){
        $query = $this->db->table('scheduling');
        $query->join('product', 'product.id = scheduling.product_id');

        $query->select('scheduling.client_id,scheduling.id,name,scheduling.price,scheduling.amount,scheduling.total');
        $query->where('scheduling.id',$id);

        return $query->get()->getResult(); 
    }

    //lo usaremos para los dos (prog & liq)
    public function inserttemp($datos){
        $query = $this->db->table('temporalfac');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function deletebyid($id) {
        $query = $this->db->table('temporalfac');
        $query->where('id',$id);
        return $query->delete();
    } 

    //-----------------------

    public function updatetemp($id) {
        // Actualizar el campo temp a 1 en la tabla scheduling
        $this->db->table('scheduling')
                 ->where('id', $id)
                 ->update(['temp' => 1]);
    }

    public function updatetempcero($id_scheduling) {
        // Actualizar el campo temp a 1 en la tabla scheduling
        $this->db->table('scheduling')
                 ->where('id', $id_scheduling)
                 ->update(['temp' => 0]);
    }

    public function obtenerTemporalFac($id)
    {
        $query = $this->db->table('temporalfac')
                            ->where('id_user', $id)
                            ->get();
        return $query->getResultArray();
    }


    //metodos para liquidaciones

    public function obtenerTodosLiqTemp($id){
        //esto es para la consulta de la tabal liquidar (liquidation)
        $query = $this->db->table('liquidation')
                        //->select('*,liquidation.id as ids')
                        //->join('product','product.id=scheduling.product_id')
                        ->where('client_id', $id)
                        ->where('temp', 0) // Agregar esta condición para obtener solo registros con temp = 0
                        ->get();

        return $query->getResultArray();
    }
    public function updatetempceroliq($id_liquidation) {
        // Actualizar el campo temp a 1 en la tabla scheduling
        $this->db->table('liquidation')
                 ->where('id', $id_liquidation)
                 ->update(['temp' => 0]);
    }
    public function updatetempliq($id) {
        // Actualizar el campo temp a 1 en la tabla liquidation
        $this->db->table('liquidation')
                    ->where('id', $id)
                    ->update(['temp' => 1]);
    }
    public function obtenerLiqbyid($id){
        $query = $this->db->table('liquidation');
        //$query->join('product', 'product.id = scheduling.product_id');
        //$query->select('scheduling.client_id,scheduling.id,name,scheduling.price,scheduling.amount,scheduling.total');
        $query->select('client_id,id,reception_id,price');
        $query->where('liquidation.id',$id);

        return $query->get()->getResult(); 
    }

    public function obtenertempid($id){
        $query = $this->db->table('temporalfac');
        $query->select('identification');
        $query->where('id',$id);

        return $query->get()->getResult();
    }

    

    //metodos para la tranferencia de datos de temporalfac
    public function guardarguia($datos){
        $query = $this->db->table('Guide');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function insertar1($datos){
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
    public function eliminar1($data) {
        $query = $this->db->table('IngressGuideTemp');
        $query->where($data);
        return $query->delete();
    }
}