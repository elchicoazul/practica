<?php

namespace App\Controllers;


use App\Models\ProgramacionM;

class Programaciones extends BaseController
{
    public function programacion(): string
    {
        return view('programa/Programacion');
    }

    public function registrar()
    {
        log_message('info','estaos en controlado programaciones');
        $model = new ProgramacionM();

        $datos = [
            "client_id" => $this->request->getPost('search_cliente'),
            "product_id" => $this->request->getPost('search_product'),
            "amount" => $this->request->getPost("cantidad"),
            "price" => $this->request->getPost("price"),
            "total" => $this->request->getPost("total"),
            "estado" => 0,
        ];

        $rpta = $model->insertar($datos);

        if ($rpta > 0) {
            $programacionModel = new ProgramacionM();
            $programaciones = $programacionModel->obtenerTodos();

            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito', 'productos' => $programaciones]);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Producto no registrado']);
        }

    }

}
