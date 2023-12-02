<?php

namespace App\Controllers;


use App\Models\ProductosM;

class Productos extends BaseController
{
    public function producto(): string
    {
        return view('/registro/Productos');
    }
    public function registrar()
    {
        
        log_message('info', 'estamos en registraer controlador .');
        $model = new ProductosM();

        $datos = [
            "name" => $this->request->getPost('name'),
            "price" => $this->request->getPost('price'),
            "stock" => $this->request->getPost("stock"),
        ];

        $rpta = $model->insertar($datos);

        if ($rpta > 0) {
            $productosModel = new ProductosM();
            $productos = $productosModel->obtenerTodos();

            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito', 'productos' => $productos]);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Producto no registrado']);
        }

    }

    public function obtenerTodos()
    {
        $productosModel = new ProductosM();
        $productos = $productosModel->obtenerTodos();
        log_message('info', 'estamos en obtenerTodos .');
        return $this->response->setJSON($productos);
    }

    public function obtenerProductos()
    {
        $productosModel = new ProductosM();
        $searchTerm = $this->request->getVar('q');
        $data = $productosModel->obtenerProductos($searchTerm);

        echo json_encode($data);
    }

}
