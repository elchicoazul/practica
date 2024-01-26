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
                $element_law= $userData['element_law'];
                $element_to_deliver= $userData['element_to_deliver'];
                $descuento= $userData['descuento'];
                $accion_inter_onza = $userData['accion_inter_onza'];
                $resultado = $liquidacionmodel->guardarTemp([
                    'client_id' => $client_id,
                    'element' => $element,
                    'office_law' => $office_law,
                    'client_law' => $client_law,
                    'difference' => $difference,
                    'final_law' => $final_law,
                    'net_kg' => $net_kg,
                    'dry_weight' => $dry_weight,
                    'element_law' => $element_law,
                    'element_to_deliver' => $element_to_deliver,
                    'accion_inter_onza' => $accion_inter_onza,
                    'descuento' => $descuento,
                ]);
            }
        }
        $userId = $this->request->getPost('userId');
        $serviceDataTemp = $this->request->getPost('services');
        foreach ($serviceDataTemp as $service) {
          $name = $service['name'];
          $price = $service['price'];
          $resultado = $liquidacionmodel->guardarTempService([
              'client_id' => $userId,
              'name' => $name,
              'price' => $price,
          ]);
        }
        if ($resultado>0) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Se Genero los Datos con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'Error al generar los datos']);
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

    public function guardarLiquidacion($id) {
        $data = $this->request->getPost('data');
        $total = $this->request->getPost('total');
        $liquidacionmodel = new LiquidacionModel();
        $guia = $liquidacionmodel->obtenerGuiaActualCliente($id);
        $result = $liquidacionmodel->guardarLiquidacion($id,$guia[0]['id'],$total);
        foreach ($data as $userData) {
          $id_liquidation= $result;
          $client_id = $userData['client_id'];
          $element = $userData['element'];
          $office_law = $userData['office_law'];
          $client_law = $userData['client_law'];
          $difference = $userData['difference'];
          $final_law = $userData['final_law'];
          $net_kg = $userData['net_kg'];
          $dry_weight = $userData['dry_weight'];
          $element_law= $userData['element_law'];
          $element_to_deliver= $userData['element_to_deliver'];
          $descuento= $userData['descuento'];
          $accion_inter_onza = $userData['accion_inter_onza'];
          $liquidacionmodel->guardarLiquidacionDetail([
              'id_liquidation' => $id_liquidation,
              'client_id' => $client_id,
              'element' => $element,
              'office_law' => $office_law,
              'client_law' => $client_law,
              'difference' => $difference,
              'final_law' => $final_law,
              'net_kg' => $net_kg,
              'dry_weight' => $dry_weight,
              'element_law' => $element_law,
              'element_to_deliver' => $element_to_deliver,
              'accion_inter_onza' => $accion_inter_onza,
              'descuento' => $descuento,
          ]);
      }
      $services = $liquidacionmodel->obtenerServicios($id);
      foreach ($services as $service) {
        $liquidationId =  $result;
        $name = $service['name'];
        $price = $service['price'];
        $resultado = $liquidacionmodel->guardarServiceLiquidation([
            'id_liquidation' => $liquidationId,
            'name' => $name,
            'price' => $price,
        ]);
      }
      $liquidacionmodel->eliminarTemp($id);
      $liquidacionmodel->cambiarEstadoGuide($guia[0]['id']);
      if ($result) {
        $datos = ['estado' => 200, 'mssg' => 'Se Registro la Liquidación con éxito : '.$result];
    } else {
        $datos =['estado' => 400, 'mssg' => 'Error Al Registrar la Liquidación'];
    }
        return $this->response->setJSON($datos);
    }
    public function obtenerDetalleLiquidacion($id) {
      $liquidacionmodel = new LiquidacionModel();
      $detalle = $liquidacionmodel->obtenerDetalleLiquidacion($id);
      $servicios = $liquidacionmodel->obtenerServiciosLiquidacion($id);
      $liquidation = $liquidacionmodel->obtenerLiquidacionBase($id);
      $guia = $liquidacionmodel->obtenerDatosGuiaLiquidation($liquidation[0]['id_guide']);
      $datos = [
        'liquidation' => $liquidation,
        'detalle' => $detalle,
        'servicios' => $servicios,
        'guia' => $guia,
      ];
      return $this->response->setJSON($datos);
    }
}
