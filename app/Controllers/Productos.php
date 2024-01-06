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
        return $this->response->setJSON($productos);
    }

    public function obtenerProductos()
    {
        $productosModel = new ProductosM();
        $searchTerm = $this->request->getVar('q');
        $data = $productosModel->obtenerProductos($searchTerm);

        echo json_encode($data);
    }

    //eliminar productos controlador
    public function eliminar($id)
    {
        $model = new ProductosM();
        $data = ["id" =>$id ];
        if ($model->eliminar($data)) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Registro eliminado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 500, 'mssg' => 'Error al eliminar el registro']);
        }
    }

    public function guardar($id)
    {
        // Aquí su lógica para procesar y guardar los datos
        $model = new ProductosM();
        // Por ejemplo, obteniendo los datos del POST
        $datos = $this->request->getJSON();
        $operacion_exitosa = $model->actualizar($id, $datos);
        // Lógica para guardar los datos en la base de datos
        
        // Responder con un mensaje de éxito o error
        if ($operacion_exitosa) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto actualizado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'Error al actualizar el producto']);
        }
    }
}
