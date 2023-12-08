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
            $programaciones = $programacionModel->obtenerTodos($this->request->getPost('search_cliente'));

            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito', 'productos' => $programaciones]);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Producto no registrado']);
        }

    }
    public function obtenerTodasProgramaciones($id)
    {

        $ProgramacionModel = new ProgramacionM();
        log_message('info', 'estamos en controlador configuracion');
        $programaciones = $ProgramacionModel->obtenerTodos($id);
        return $this->response->setJSON($programaciones);

    }

    public function eliminar($id)
    {
        log_message('info','estamos en eliminar programaciones control');
        
        $model = new ProgramacionM();

        if ($model->eliminar($id)) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Registro eliminado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 500, 'mssg' => 'Error al eliminar el registro']);
        }
    }



}



