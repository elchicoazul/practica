<?php

namespace App\Controllers;
use App\Models\GuiaM;

class Guia extends BaseController
{
    public function index(): string
    {
        
        return view('Guia/Index');
    }
    public function registrartemp()
    {
        $model = new GuiaM();
        
        // Obtención de los datos enviados desde el formulario
        $pesoBruto = $this->request->getPost('pesoBruto');
        $tara = $this->request->getPost('tara');
        $pesoMuestra = $this->request->getPost('pesoMuestra');
        $pesoHumedo = $this->request->getPost('pesoHumedo');
        $humedad = $this->request->getPost('humedad');
        $pesoSeco = $this->request->getPost('pesoSeco');
        $codigo = $this->request->getPost('codigo');
        log_message('info', 'Precio recibido: ' . $pesoSeco);
        $resultado = $model->guardar([
            'user_id' => $codigo, 
            'gross_weight' => $pesoBruto,
            'tare_weight' => $tara,
            'sample_weight' => $pesoMuestra,
            'wet_weight' => $pesoHumedo,
            'moisture_percentage' => $humedad,
            'dry_weight' => $pesoSeco
        ]);

        // Verificación de si la operación fue exitosa
        if ($resultado>0) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Producto registrado con éxito']);
        } else {
            // En caso de error
            return $this->response->setJSON(['estado' => 400, 'mssg' => 'Producto no registrado con éxito']);
        }
    }
    public function obtenerTodosLosDatos($id) {
        $model = new GuiaM();
       
        // Obtener los datos desde la base de datos
        log_message('info', 'Guardar XD');
        $datos = $model->obtenerDatos($id); // Asumiendo que este método está definido en su modelo
        log_message('info', 'hola mundo cruel:');
        return $this->response->setJSON($datos);
    }
    public function eliminar($id)
    {
        $model = new GuiaM();
        $data = ["id" =>$id ];
        if ($model->eliminar($data)) {
            return $this->response->setJSON(['estado' => 200, 'mssg' => 'Registro eliminado con éxito']);
        } else {
            return $this->response->setJSON(['estado' => 500, 'mssg' => 'Error al eliminar el registro']);
        }
    }
    public function transferirDatos()
    {
        $temporalModel = new GuiaM();
        $guia = new GuiaM();
        $codigo_cliente = $this->request->getPost('codigo');
        $codigo_guia = $this->request->getPost('codigo_guia');
        $fecha = $this->request->getPost('fecha');
        $guia_remision = $this->request->getPost('guia');
        $guias = new GuiaM();
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
                $dato['guide_id'] = $rpta; 
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
    
    public function obtenerGuia()
    {
        $guiaModel = new GuiaM();
        log_message('info','obtenerguia controller');
        $searchTerm = $this->request->getVar('q');

        $data = $guiaModel->obtenerGuias($searchTerm);

        echo json_encode($data);
    }
}
