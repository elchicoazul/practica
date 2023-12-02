<?php namespace App\Models;
use CodeIgniter\Model;
class ProductosM extends Model {
    
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock'];

    public function insertar($datos)
    {
        $this->insert($datos);
        return $this->insertID();
    }

    public function obtenerTodos()
    {
        $query = $this->select('name, price, stock')->findAll();
        return $query;
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
}