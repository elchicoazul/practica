<?php

namespace App\Controllers;

use App\Models\ConfiguracionM;

class Configuraciones extends BaseController
{
    public function configuracion(): string
    {
        return view('/registro/Configuracion');
    }

    public function registrar() {

        $model = new ConfiguracionM();

        $datos = [
            "name" => $this->request->getPost('name'),
            "value" => $this->request->getPost('value'),
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
