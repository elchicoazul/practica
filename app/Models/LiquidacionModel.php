<?php namespace App\Models;
use CodeIgniter\Model;
class LiquidacionModel extends Model { 

    protected $table = 'user';
    protected $primaryKey = 'id';

    public function obtenerClienteGuiaData($clientId)
    {
        $builder = $this->db->table('Guide');
        $builder->select('Guide.guide_code, IngressGuide.wet_weight, IngressGuide.moisture_percentage, IngressGuide.dry_weight');
        $builder->join('IngressGuide', 'Guide.client_id = IngressGuide.guide_id');
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
}

?>