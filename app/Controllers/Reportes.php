<?php

namespace App\Controllers;
class Reportes extends BaseController
{
    public function index(): string
    {
        
        log_message("info","index report");
        require_once './vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        echo 'mPDF instanciado con éxito';

        return view('welcome_message');
    }
}
