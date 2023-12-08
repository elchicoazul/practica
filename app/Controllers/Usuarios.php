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
    public function obtenerTodosUsuarios()
    {
        $usuariosModel = new Usuario();
        $usuarios = $usuariosModel->obtenerTodosUsuarios();
        return $this->response->setJSON($usuarios);
    }

    public function obtenerUsuario()
    {
        $usuarioModel = new Usuario();
        $searchTerm = $this->request->getVar('q');
        $data = $usuarioModel->obtenerUsuarios($searchTerm);

        echo json_encode($data);
    }

    public function eliminar($id)
    {
        $model = new Usuario();
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
        $model = new Usuario();
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
