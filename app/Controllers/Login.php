<?php

namespace App\Controllers;

use App\Models\Usuario;

class Login extends BaseController
{
    public function index(): string
    {
        return view('Login/index');
    }

    public function authenticate()
    {
        log_message('info', 'Estamos en el controlador de LoginUser');
    
        $session = session();
        $modeloUsuario = new Usuario();
    
        // Verificar si email y password están presentes en POST
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            // Redirigir a la página de error o login con un mensaje de error
            log_message('error', 'Faltan credenciales');
            return redirect()->to(base_url('LoginUser'))->with('error', 'Faltan credenciales');
        }
    
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        log_message('info', 'Intento de inicio de sesión para el usuario: ' . $username);
    
        $respuesta = $modeloUsuario->authenticateUser($username, $password);
    
        if (count($respuesta) > 0) {
            $session->set(['LoginUser' => true]);
            log_message('info', 'Autenticación exitosa para el usuario: ' . $username);
            return redirect()->to(base_url('Guia'));
        } else {
            // Redirigir a la página de login con un mensaje de error
            log_message('error', 'Credenciales incorrectas para el usuario: ' . $username);
            return redirect()->to(base_url('LoginUser'))->with('error', 'Credenciales incorrectas');
        }
    }
    
    public function salir(){
        $session = session();
        session('LoginUser')==false;
        $session->destroy();

        return redirect()->to(base_url('LoginUser'));
    }
}
