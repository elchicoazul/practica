<?php

namespace App\Controllers;

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
        log_message('info','tempaddliq controlador');
        $model = new ProgramacionM();

        $respuesta = $model->obtenerLiqbyid($id);
        //log_message('info',$respuesta['product.name']);

        $datos = [
            "id_liquidation"=>$id,
            "id_user"=>$respuesta[0]->client_id,
            //"nombre" => $respuesta[0]->name,
            //"precio" => $respuesta[0]->price,
            //"cantidad" => $respuesta[0]->amount,
            "total"=>$respuesta[0]->price,
            "identification"=>'L'
        ];

        $envdatos = $model->inserttemp($datos);

        $model->updatetempliq($id);
        
        return $this->response->setJSON($datos);
    }

    public function tempDelete($id,$identi){
        $model = new ProgramacionM();

        $validador=$model->obtenertempid($id);

        if ($validador[0]->identification=='P') {
            $datos = $model->obtenerbyid($identi);
            $respuesta = $model->deletebyid($id);
            $model->updatetempcero($identi);
        }else{
            $datos = $model->obtenerbyid($identi);
            $respuesta = $model->deletebyid($id);
            $model->updatetempceroliq($identi);
        }
        
        return $this->response->setJSON($datos);
    }

    //para liquidaciones
    public function obtenerDatosTemporalesFac($id)
    {
        log_message('info','estmaos en el contralador de la tabla temp');
        $ProgramacionModel = new ProgramacionM();
        $programaciones = $ProgramacionModel->obtenerTemporalFac($id);
        return $this->response->setJSON($programaciones);
    }

    //transfiere los datos de la tabla temporalfac a liquidarfac y detail 
    public function transferirDatos()
    {
        $temporalModel = new ProgramacionM();
        $guia = new ProgramacionM();
        $codigo_cliente = $this->request->getPost('codigo');
        $codigo_guia = $this->request->getPost('codigo_guia');
        $fecha = $this->request->getPost('fecha');
        $guia_remision = $this->request->getPost('guia');
        $guias = new ProgramacionM();
        $data=[
            'client_id'=>$codigo_cliente,
            'date'=>$fecha,
            'guide_code'=>$codigo_guia,
            'shipment_guide'=>$guia_remision,
            'guideStatus'=>0
        ];
        $rpta = $guias->guardarguia($data);

        // Obtener todos los registros de la tabla temporal para el user_id específico
        $datosTemporales = $temporalModel->obtenerDatos($codigo_cliente);

        // Verificar si hay datos para transferir
        if (!empty($datosTemporales)) {
            foreach ($datosTemporales as $dato) {
                $dataid=$dato['id'];
                unset($dato['id']);
                $dato['guide_id'] = $codigo_cliente; 
                $guia->insertar($dato);
                $data = ["id" =>$dataid];
                $dato['guide_id'] = $rpta;
                // Opcional: Eliminar el registro de la tabla temporal después de la transferencia
                $temporalModel->eliminar($data);
            }

            return $this->response->setJSON(['estado' => 200, 'mensaje' => 'Datos transferidos con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 400, 'mensaje' => 'No hay datos para transferir']);
        }
    }

}