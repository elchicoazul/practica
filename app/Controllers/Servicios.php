<?php

namespace App\Controllers;

use App\Models\ServicioM;

class Servicios extends BaseController
{
    public function servicio(): string
    {
        return view('/registro/Servicio');
    }

    public function registrar() {

        $model = new ServicioM();

        $datos = [
            "name" => $this->request->getPost('name'),
            "price" => $this->request->getPost('price'),
        ];

        $rpta = $model->insertar($datos);
        
        if ($rpta>0) {
            log_message('info', 'Entrando en el método registrar.');
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Configuracion registrado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Configuracion no registrada']);
        }
    }

}
