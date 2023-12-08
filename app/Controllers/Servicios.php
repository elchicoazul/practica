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
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Configuracion registrado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Configuracion no registrada']);
        }
    }

    public function obtenerTodosServicios()
    {
        $servicioModel = new ServicioM();
        $servicios = $servicioModel->obtenerTodosServicios();
        return $this->response->setJSON($servicios);
    }
    public function eliminar($id)
    {
        $model = new ServicioM();
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
        $model = new ServicioM();
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
