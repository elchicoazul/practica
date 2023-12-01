<?php

namespace App\Controllers;

use App\Models\Usuario;

class Usuarios extends BaseController
{
    public function usuario(): string
    {
        return view('/registro/RegisterUsuario');
    }

    public function registrar()
    {
        log_message('info', 'estamos en registrar');
        // Crear una instancia del modelo de usuario
        $model = new Usuario();

        // Obtener datos del formulario
        $datos = [
            "username" => $this->request->getPost('username'),
            "role" => $this->request->getPost('rol'),
            "dni_ruc" => $this->request->getPost('dni_ruc'),
            // Añade otros campos según sea necesario
            "password" => $this->request->getPost('password'),
        ];

            // Añadir otros campos para roles no administrativos
            $datos['gold_law'] = $this->request->getPost('gold_law');
            $datos['tailings_law'] = $this->request->getPost('tailings_law');
            $datos['fine_gold_to_deliver'] = $this->request->getPost('fine_gold_to_deliver');
            $datos['pine_silver_to_deliver'] = $this->request->getPost('pine_silver_to_deliver');
            $datos['gold_discount'] = $this->request->getPost('gold_discount');
            $datos['silver_discount'] = $this->request->getPost('silver_discount');


        // Insertar datos en la base de datos utilizando el modelo
        $rpta = $model->insertar($datos);

        // Manejar la respuesta
        if ($rpta > 0) {
            log_message('info', 'Entrando en el método registrar.');
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Usuario registrado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 202, 'mssg' => 'Usuario no registrado']);
        }
    }
}
