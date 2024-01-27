<?php namespace App\Models;
use CodeIgniter\Model;
class Usuario extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

    public function insertar($datos){
        $Public = $this->db->table('user');
        $Public->insert($datos);
        //$this->db->insert('usuarios', $data);
        return $this->db->insertID();
    }
    
    public function obtenerUsuarios($searchTerm)
    {
        $builder = $this->builder();
        $query = $builder->like('username', $searchTerm)
                        ->select(
                            'id, 
                            username as text,
                            dni_ruc, 
                            gold_law, 
                            tailings_law, 
                            fine_gold_to_deliver, 
                            pine_silver_to_deliver, 
                            gold_discount, 
                            silver_discount')
                        ->limit(10)
                        ->get();

        return $query->getResult();
    }
    public function obtenerTodosUsuarios()
    {
        $query = $this->db->table('user')
                          ->get();
        return $query->getResultArray();
    }

    public function obtenerusuariobyid($id){
        $query = $this->db->table('user')
        ->where('id',$id)
        ->get();
        return $query->getResultArray();
    }

    //eliminar Usuarios
    public function eliminar($data) {
        $query = $this->db->table('user');
        $query->where($data);
        return $query->delete();
    }
    public function actualizar($id, $datos){
        $query = $this->db->table('user'); // Asegúrese de que $this->table esté definido correctamente en su modelo
    
        // Actualizar el registro con el ID especificado
        $query->where('id', $id); // Asegúrese de que $this->primaryKey esté definido correctamente
        $result = $query->update($datos);
    
        return $result;
    }

    public function authenticateUser($username, $password)
    {
        $Public = $this->db->query("SELECT * FROM  user WHERE username='$username' AND password='$password' ");
        return $Public->getResult();
    }

}