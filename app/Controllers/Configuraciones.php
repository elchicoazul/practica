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

    public function obtenerTodasConfiguraciones()
    {
        $ConfiguracionModel = new ConfiguracionM();
        log_message('info', 'estamos en controlador configuracion');
        $configuraciones = $ConfiguracionModel->obtenerTodasConfiguraciones();
        return $this->response->setJSON($configuraciones);
    }
    
    public function eliminar($id)
    {
        $model = new ConfiguracionM();
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
        $model = new ConfiguracionM();
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
