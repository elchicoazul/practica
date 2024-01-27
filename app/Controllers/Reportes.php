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
        log_message('info','reportesGL');
        // Retrieve data from the AJAX request
        $filtro = $this->request->getPost('filtro');
        $cliente = $this->request->getPost('cliente');
        $fechaInicio = $this->request->getPost('fechaInicio');
        $fechaFin = $this->request->getPost('fechaFin');
        $codigo = $this->request->getPost('codigo');
    
        $data = [
            'id' => $cliente,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'codigo' => $codigo
        ];
    
        if ($filtro == 'guia') {
            $Guia = new GuiaM();
            $rpta = $Guia->FiltrarGuia($data);
        } elseif ($filtro == 'liquidacion') {
            $Liquidacion = new LiquidacionModel();
            $rpta = $Liquidacion->FiltrarLiquidacion($data);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'Filtro no válido']);
        }
    
        if ($rpta) {
            return $this->response->setJSON($rpta);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'No se encontraron datos']);
        }
    }
    
}
