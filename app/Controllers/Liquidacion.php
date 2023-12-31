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
            $element = isset($analisisData['element']) ? $analisisData['element'] : null;
            $element_law = isset($analisisData['element_law']) ? $analisisData['element_law'] : null;
            $element_to_deliver = isset($analisisData['element_to_deliver']) ? $analisisData['element_to_deliver'] : null;
            $accion_inter_onza = isset($analisisData['accion_inter_onza']) ? $analisisData['accion_inter_onza'] : null;
            $descuento = isset($analisisData['descuento']) ? $analisisData['descuento'] : null;

            if ($element !== null) {
                if($descuento !== null) {
                    $result = $liquidacionmodel->actualizarFinal([
                        'accion_inter_onza' => $accion_inter_onza,
                        'descuento' => $descuento
                    ], $id, $element);
                } else {
                    $result = $liquidacionmodel->actualizarLey([
                        'element_law' => $element_law,
                        'element_to_deliver' => $element_to_deliver
                    ], $id, $element);
                }
            } else {
                $result = $liquidacionmodel->actualizar([
                    'dry_weight' => $seco,
                    'office_law' => $officeLaw,
                    'client_law' => $clientLaw,
                    'difference' => $difference,
                    'final_law' => $final,
                    'net_kg' => $neto,
                ], $id);
            }

            if ($result) {
                $datos = [
                    'success' => true,
                    'message' => 'Actualización exitosa',
                ];
            } else {
                $datos = [
                    'success' => false,
                    'message' => 'Error al actualizar', 
                ];
            }

            return $this->response->setJSON($datos);
        }
    }
    
    public function obtenerTotalValores() {
        $liquidacionmodel = new LiquidacionModel();
        $datos = $liquidacionmodel->obtenerTotalValores();
        return $this->response->setJSON($datos);
    }
    
}
