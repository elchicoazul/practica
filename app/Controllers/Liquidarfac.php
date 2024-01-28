<?php

namespace App\Controllers;

use App\Models\LiquidacionModel;
use App\Models\ProgramacionM;

class Liquidarfac extends BaseController
{
    public function index(): string
    {
        return view('Liquidarfac/liquidarfac');
    }

    public function tempadd($id){
        log_message('info','tempadd controlador');
        $model = new ProgramacionM();

        $respuesta = $model->obtenerbyid($id);
        //log_message('info',$respuesta['product.name']);

        $datos = [
            "id_scheduling"=>$id,
            "id_user"=>$respuesta[0]->client_id,
            "nombre" => $respuesta[0]->name,
            "precio" => $respuesta[0]->price,
            "cantidad" => $respuesta[0]->amount,
            "total"=>$respuesta[0]->total,
            "identification"=>'P'
        ];

        $envdatos = $model->inserttemp($datos);

        $model->updatetemp($id);
        
        return $this->response->setJSON($datos);
    }

    //para liquidaciones
    public function tempAddLiq($id){
        $model = new ProgramacionM();

        $respuesta = $model->obtenerLiqbyid($id);
        //log_message('info',$respuesta['product.name']);

        $datos = [
            "id_liquidation"=>$id,
            "id_user"=>$respuesta[0]->client_id,
            //"nombre" => $respuesta[0]->name,
            //"precio" => $respuesta[0]->price,
            //"cantidad" => $respuesta[0]->amount,
            "total"=>$respuesta[0]->total_liquidation,
            "identification"=>'L'
        ];

        $envdatos = $model->inserttemp($datos);

        $model->updatetempliq($id);
        
        return $this->response->setJSON($datos);
    }

    public function tempDelete($id,$identi){
        $model = new ProgramacionM();

        $validador=$model->obtenertempid($id);

        log_message('info',$validador[0]->identification);

        if ($validador[0]->identification=='P') {

            $datos = $model->obtenerbyid($identi);
            $respuesta = $model->deletebyid($id);
            $model->updatetempcero($identi);
        }else{
            $datos = $model->obtenerLiqbyid($identi);
            $respuesta = $model->deletebyid($id);
            $model->updatetempceroliq($identi);
        }
        
        return $this->response->setJSON($datos);
    }

    //para liquidaciones
    public function obtenerDatosTemporalesFac($id)
    {
        $ProgramacionModel = new ProgramacionM();
        $programaciones = $ProgramacionModel->obtenerTemporalFac($id);
        return $this->response->setJSON($programaciones);
    }

    //transfiere los datos de la tabla temporalfac a liquidarfac y detail 
    public function transferirDatos($id_client)
    {

        $temporalModel = new ProgramacionM();
        $liquidacion = new LiquidacionModel();
        $liquidaciones = new LiquidacionModel();

        $data=[
            'id_client'=>$id_client,
            'date'=>date('Y-m-d')
        ];
        $rpta = $liquidaciones->guardarliquidacionfac($data);

        // Obtener todos los registros de la tabla temporal para el user_id específico
        $datosTemporales = $temporalModel->obtenerTemporalFac($id_client);

        // Verificar si hay datos para transferir
        if (!empty($datosTemporales)) {
            foreach ($datosTemporales as $dato) {
                $dataid=$dato['id'];
                unset($dato['id']);
                $dato['id_liquidarfac'] = $rpta; 
                $liquidacion->insertar($dato);
                // Opcional: Eliminar el registro de la tabla temporal después de la transferencia
                $temporalModel->deletebyid($dataid);
            }

            return $this->response->setJSON(['estado' => 200, 'mensaje' => 'Datos transferidos con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mensaje' => 'No hay datos para transferir']);
        }
    }

}