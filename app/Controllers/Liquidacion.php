<?php

namespace App\Controllers;

use App\Models\LiquidacionModel;

class Liquidacion extends BaseController
{
    public function index(): string
    {
        return view('Liquidacion/Index');
    }

    public function buscarDatosCliente($id)
    {
        log_message('info', 'id' . $id);
        $liquidacion = new LiquidacionModel();
        // $searchTerm = $this->request->getVar('q');
        $data = $liquidacion->obtenerClienteGuiaData($id);
        echo json_encode($data);
    }

    public function registrarAnalisisTemp() {
        $liquidacionmodel = new LiquidacionModel();
    
        $analisisDataTemp = $this->request->getPost('analisisData');

        foreach ($analisisDataTemp as $analisisArray) {
            foreach ($analisisArray as $userData) {
                $client_id = $userData['client_id'];
                $element = $userData['element'];
                $office_law = $userData['office_law'];
                $client_law = $userData['client_law'];
                $difference = $userData['difference'];
                $final_law = $userData['final_law'];
                $net_kg = $userData['net_kg'];
                $dry_weight = $userData['dry_weight'];

                $resultado = $liquidacionmodel->guardarTemp([
                    'client_id' => $client_id,
                    'element' => $element,
                    'office_law' => $office_law,
                    'client_law' => $client_law,
                    'difference' => $difference,
                    'final_law' => $final_law,
                    'net_kg' => $net_kg,
                    'dry_weight' => $dry_weight
                ]);
            }
        }

        if ($resultado>0) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'Producto no registrado con éxito']);
        }
    }

    public function obtenerTodosLosDatos($id) {
        $liquidacionmodel = new LiquidacionModel();
        $datos = $liquidacionmodel->obtenerDatos($id); // Asumiendo que este método está definido en su modelo
        return $this->response->setJSON($datos);
    }

    public function actualizarAnalisis($id) {
        $liquidacionmodel = new LiquidacionModel();
        $analisisData = $this->request->getPost('analisisData');

        if ($analisisData !== null && is_array($analisisData)) {
            $seco = isset($analisisData['seco']) ? $analisisData['seco'] : null;
            $officeLaw = isset($analisisData['officeLaw']) ? $analisisData['officeLaw'] : null;
            $clientLaw = isset($analisisData['clientLaw']) ? $analisisData['clientLaw'] : null;
            $difference = isset($analisisData['difference']) ? $analisisData['difference'] : null;
            $final = isset($analisisData['final']) ? $analisisData['final'] : null;
            $neto = isset($analisisData['neto']) ? $analisisData['neto'] : null;
    
            log_message('info', 'data' .  $seco);
            $liquidacionmodel->actualizar([
                'dry_weight' => $seco,
                'office_law' => $officeLaw,
                'client_law' => $clientLaw,
                'difference' => $difference,
                'final_law' => $final,
                'net_kg' => $neto,
            ], $id);
        }
    }
    
}
