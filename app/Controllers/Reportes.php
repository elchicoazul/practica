<?php

namespace App\Controllers;
use App\Models\GuiaM;
use App\Models\LiquidacionModel;

class Reportes extends BaseController
{
    public function index(): string
    {
        return view('Reporte/ReporteGuias');
    }

    public function ReporteGL()
    {

        // Retrieve data from the AJAX request
        $filtro = $this->request->getPost('filtro');
        $cliente = $this->request->getPost('cliente');
        $fechaInicio = $this->request->getPost('fechaInicio');
        $fechaFin = $this->request->getPost('fechaFin');
        $codigoGuia = $this->request->getPost('codigoGuia');

        $data = [
            'id' => $cliente,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'guide_code' => $codigoGuia
        ];

        if ($filtro=='guia') {

            log_message('error', 'reporte');
            log_message('info', 'estamos en controlador reportes');
            
            $Guia = new GuiaM();
            $rpta = $Guia->FiltrarGuia($data);

            if ($rpta>0) {
                return $this->response->setJSON($rpta);
            } else {
                return $this->response->setJSON(['estado' => 400, 'mssg' => 'Producto no registrado con éxito']);
            }

        }/*else {
            $Liquidacion = new LiquidacionModel();
            $rpta = $Liquidacion->FiltrarLiquidacion($data);
        }*/

    }
}
