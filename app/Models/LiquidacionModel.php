<?php namespace App\Models;
use CodeIgniter\Model;
class LiquidacionModel extends Model { 

    protected $table = 'user';
    protected $primaryKey = 'id';

    public function FiltrarLiquidacion($data)
    {
        $builder = $this->db->table('liquidation');
        $builder->select('liquidation.id,liquidation.id_guide, liquidation.fecha_create, User.username,total_liquidation');
        $builder->join('user', 'liquidation.client_id = user.id');
    
        // Construir condiciones de búsqueda
        if (!empty($data['id'])) {
            $builder->where('liquidation.client_id', $data['id']);
        }
    
        if (!empty($data['codigo'])) {
            $builder->where('liquidation.id_guide', $data['codigo']);
        }
    
        if (!empty($data['fechaInicio']) && !empty($data['fechaFin'])) {
            $fechaInicio = date('Y-m-d', strtotime($data['fechaInicio']));
            $fechaFin = date('Y-m-d', strtotime($data['fechaFin']));
            $builder->where('liquidation.fecha_create BETWEEN "' . $fechaInicio . '" AND "' . $fechaFin . '"');
        }
    
        // Realizar la consulta
        $query = $builder->get();
    
        return $query->getResultArray();
    }
    

    public function obtenerClienteGuiaData($clientId)
    {
        $builder = $this->db->table('Guide');
        $builder->select('Guide.guide_code, IngressGuide.wet_weight, IngressGuide.moisture_percentage, IngressGuide.dry_weight');
        $builder->join('IngressGuide', 'Guide.id = IngressGuide.guide_id');
        $builder->where('Guide.client_id', $clientId);
        $builder->where('Guide.guideStatus', 0);

        $query = $builder->get();
        
        return $query->getResultArray();
    } 

    public function guardarTemp($datos)
    {
        $query = $this->db->table('LiquidationDetailTemp');
        $query->insert($datos);
        return $this->db->InsertId();
    }

    public function obtenerDatos($id) {
        $query = $this->db->table('LiquidationDetailTemp')
                          ->select('*')
                          ->where('client_id', $id)
                          ->get();
        return $query->getResultArray();
    }

    public function actualizar($analisisData, $id) {
        return $this->db->table('LiquidationDetailTemp')
                 ->where('id', $id)
                 ->update($analisisData);
    }

    public function actualizarLey($analisisData, $id, $element) {
        return $this->db->table('LiquidationDetailTemp')
                 ->where('client_id', $id)
                 ->where('element', $element)
                 ->update($analisisData);
    }

    public function obtenerTotalValores() {
        $query1 = $this->db->table('service')->select('*')->get();
        $query2 = $this->db->table('configuration')->select('*')->get();
        return array($query1->getResultArray(), $query2->getResultArray());
    }

    public function actualizarFinal($analisisData, $id, $element) {
        return $this->db->table('LiquidationDetailTemp')
                 ->where('client_id', $id)
                 ->where('element', $element)
                 ->update($analisisData);
    }
    public function guardarLiquidacion($id, $id_guia, $total){
        $query = $this->db->table('Liquidation');
        $query->insert([
          'client_id' => $id,
          'id_guide'=> $id_guia,
          'fecha_create' => date('Y-m-d H:i:s'),
          'total_liquidation'=>$total
      ]);
      return $this->db->InsertId();
    }
    public function guardarLiquidacionDetail($datos)
    {
        $query = $this->db->table('LiquidationDetail');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function eliminarTemp($id) {
      $query1 = $this->db->table('LiquidationDetailTemp')
                 ->where('client_id', $id)
                 ->delete();
      $quer2=  $this->db->table('ServiceTemp')
                 ->where('client_id', $id)
                 ->delete();
        return $quer2;
    }
    public function guardarTempService($datos)
    {
        $query = $this->db->table('ServiceTemp');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function obtenerServicios($id) {
        $query = $this->db->table('ServiceTemp')
                          ->select('*')
                          ->where('client_id', $id)
                          ->get();
        return $query->getResultArray();
    }
    public function guardarServiceLiquidation($datos)
    {
        $query = $this->db->table('ServiceLiquidation');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function obtenerDetalleLiquidacion($id) {
        $query = $this->db->table('LiquidationDetail')
                          ->select('*')
                          ->where('id_liquidation', $id)
                          ->get();
        return $query->getResultArray();
    }
    public function obtenerServiciosLiquidacion($id) {
        $query = $this->db->table('ServiceLiquidation')
                          ->select('*')
                          ->where('id_liquidation', $id)
                          ->get();
        return $query->getResultArray();
    }
    public function obtenerLiquidacionBase($id) {
      $query = $this->db->table('Liquidation')
                        ->select('*')
                        ->where('id', $id)
                        ->get();
      return $query->getResultArray();
    }
      public function obtenerGuiaActualCliente($id){
      $query = $this->db->table('Guide')
                        ->select('*')
                        ->where('client_id', $id)
                        ->where('guideStatus', 0)
                        ->get();
        return $query->getResultArray();
    } 
    public function cambiarEstadoGuide($id){
      $query = $this->db->table('Guide')
                        ->where('id', $id)
                        ->update(['guideStatus' => 1]);
        return $query;
    }
    public function obtenerDatosGuiaLiquidation($id){
        $builder = $this->db->table('Guide');
        $builder->select('Guide.client_id,Guide.guide_code, IngressGuide.wet_weight, IngressGuide.moisture_percentage, IngressGuide.dry_weight');
        $builder->join('IngressGuide', 'Guide.id = IngressGuide.guide_id');
        $builder->where('Guide.id', $id);;

        $query = $builder->get();

        return $query->getResultArray();
    }
    
    //liquidar fac

    public function guardarliquidacionfac($datos){
        $query = $this->db->table('liquidarfac');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function insertar($datos){
        $query = $this->db->table('liquidarfacdetail');
        $query->insert($datos);
        return $this->db->InsertId();
    }
}
?>