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
        log_message('info', 'estamos en controlador programaciones');
        $model = new ProgramacionM();
    
        $datos = [
            "client_id" => $this->request->getPost('search_cliente'),
            "product_id" => $this->request->getPost('search_product'),
            "amount" => $this->request->getPost("cantidad"),
            "price" => $this->request->getPost("price"),
            "total" => $this->request->getPost("total"),
            "status" => 0, // Asumiendo que estos son valores predeterminados
            "temp" => 0
        ];
    
        $rpta = $model->insertar($datos);
        log_message('info',$rpta);
        
        if ($rpta > 0) {
            $programacionModel = new ProgramacionM();
            $programaciones = $programacionModel->obtenerTodosTemp($this->request->getPost('search_cliente'));
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito', 'productos' => $programaciones]);
        } else {
            log_message('info','estamos aqui :(');
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Producto no registrado']);
        }
    }

    public function obtenerTodasProgramacionesTemp($id)
    {
        $ProgramacionModel = new ProgramacionM();
        $programaciones = $ProgramacionModel->obtenerTodosTemp($id);
        return $this->response->setJSON($programaciones);
    }

    //para obtener los datos de las liquidaciones (podemos cambiar al controlador y modelo de liquidar)
    public function obtenerTodasLiquidacionesTemp($id)
    {
        log_message('info','estamos en obtener liquidaciones controlador');
        $ProgramacionModel = new ProgramacionM();
        $liquidaciones = $ProgramacionModel->obtenerTodosLiqTemp($id);
        return $this->response->setJSON($liquidaciones);
    }
    

    public function eliminar($id)
    {
        
        $model = new ProgramacionM();

        if ($model->eliminar($id)) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Registro eliminado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 500, 'mssg' => 'Error al eliminar el registro']);
        }
    }



}



