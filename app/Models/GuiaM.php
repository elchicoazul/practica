<?php namespace App\Models;
use CodeIgniter\Model;
use Kint\Parser\ToStringPlugin;

class GuiaM extends Model { 
    
    protected $table = 'guide';
    public function FiltrarGuia($data){
    $builder = $this->db->table('Guide');
    $builder->select('Guide.guide_code, Guide.date, Guide.shipment_guide, Guide.guideStatus, User.username');
    $builder->join('User', 'Guide.client_id = User.id');

    // Construir condiciones de búsqueda
    if (!empty($data['id'])) {
        $builder->where('Guide.client_id', $data['id']);
    }

    if (!empty($data['codigo'])) {
        $builder->where('Guide.guide_code', $data['codigo']);
    }

    if (!empty($data['fechaInicio']) && !empty($data['fechaFin'])) {
        $fechaInicio = date('Y-m-d', strtotime($data['fechaInicio']));
        $fechaFin = date('Y-m-d', strtotime($data['fechaFin']));
        $builder->where('Guide.date BETWEEN "' . $fechaInicio . '" AND "' . $fechaFin . '"');
    }

    // Realizar la consulta
    $query = $builder->get();

    return $query->getResultArray();
}

    public function guardar($datos){
        $query = $this->db->table('IngressGuideTemp');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function guardarguia($datos){
        $query = $this->db->table('Guide');
        $query->insert($datos);
        return $this->db->InsertId();
    }
    public function insertar($datos){
        $query = $this->db->table('IngressGuide');
        $query->insert($datos);
        return $this->db->InsertId();
    }

    public function obtenerDatos($userId) {
        // Utilizar el query builder del modelo con una condición where
        $query = $this->db->table('IngressGuideTemp')
                          ->where('user_id', $userId)
                          ->get();
        return $query->getResultArray();
    }
    public function eliminar($data) {
        $query = $this->db->table('IngressGuideTemp');
        $query->where($data);
        return $query->delete();
    }
   
    public function obtenerGuias($searchTerm)
    {
        $builder = $this->builder();
        $query = $builder->like('guide_code', $searchTerm)
                        ->select(
                            'id, 
                            client_id,
                            date,
                            guide_code as text,
                            shipment_guide, 
                            guideStatus')
                        ->limit(10)
                        ->get(); // Agregar el nombre de la tabla 'Guide' aquí
        return $query->getResult();
    }
    
}

?>