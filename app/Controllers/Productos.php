<?php

namespace App\Controllers;


use App\Models\ProductosM;

class Productos extends BaseController
{
    public function producto(): string
    {
        return view('/registro/Productos');
    }
    public function registrar() {

        $model = new ProductosM();

        $datos = [
            "name" => $this->request->getPost('name'),
            "price" => $this->request->getPost('price'),
            "stock" => $this->request->getPost("stock"),
        ];

        $rpta = $model->insertar($datos);
        
        if ($rpta>0) {
            log_message('info', 'Entrando en el método registrar.');
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Producto no registrado']);
        }
    }


}
