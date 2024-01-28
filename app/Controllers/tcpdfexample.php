<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LiquidacionModel;
use App\Models\Usuario;
use App\Libraries\Pdf;
use TCPDF;

class TcpdfExample extends BaseController
{
   
    
    function index()
{
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->AddPage();
    $pdf->WriteHTML("Lo mejor de la vida");

    $this->response->setContentType('applicaction/pdf');
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output('example_001.pdf', 'I');

    }
    function imprimirguia($id)
    {
        $liquidacionmodel = new LiquidacionModel();
        $guia = $liquidacionmodel->obtenerDatosGuiaLiquidation($id);
        $usuario = new usuario();
        $user = $usuario->obtenerusuariobyid($guia[0]['client_id']);
    
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
    
        // Estilos
        $style = "<style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                  </style>";
    
        // Encabezado
        $html = $style . '<h2>Korintigold</h2><p>Dirección: Calle Falsa 123</p><p>Teléfono: 555-1234</p>';
        
        $html .= '<h3>Datos del Cliente</h3><p>Nombre: ' . $user[0]['username'] . '</p><p>ID: ' . $user[0]['id'] . '</p>';
    
        // Tabla de datos
        $html .= '<table><thead><tr><th>Item</th><th>N° Guía</th><th>Código</th><th>Peso Hum (KG)</th><th>Humedad (%)</th><th>Peso Seco (KG)</th></tr></thead><tbody>';
        
        // Datos de la guía
        foreach ($guia as $index => $item) {
            $html .= "<tr>
                        <td>" . ($index + 1) . "</td>
                        <td>{$id}</td>
                        <td>{$item['guide_code']}</td>
                        <td>{$item['wet_weight']}</td>
                        <td>{$item['moisture_percentage']}</td>
                        <td>{$item['dry_weight']}</td>
                      </tr>";
        }
    
        // Totales
        $totalWetWeight = array_reduce($guia, function ($carry, $item) {
            return $carry + $item['wet_weight'];
        }, 0);
    
        $totalDryWeight = array_reduce($guia, function ($carry, $item) {
            return $carry + $item['dry_weight'];
        }, 0);
    
        $html .= "<tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td>" . number_format($totalWetWeight, 2) . "</td>
                    <td></td>
                    <td>" . number_format($totalDryWeight, 2) . "</td>
                  </tr>";
        $html .= '</tbody></table>';
    
        // Escribir el HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Definir el tipo de respuesta
        $this->response->setContentType('application/pdf');
    
        // Enviar el PDF al navegador
        $pdf->Output('guia.pdf', 'I');
    }

    function imprimirliquidacion($id) {
        $liquidacionmodel = new LiquidacionModel();
        $detalle = $liquidacionmodel->obtenerDetalleLiquidacion($id);
        $servicios = $liquidacionmodel->obtenerServiciosLiquidacion($id);
        $liquidation = $liquidacionmodel->obtenerLiquidacionBase($id);
        $guia = $liquidacionmodel->obtenerDatosGuiaLiquidation($liquidation[0]['id_guide']);
    
        // Inicializar TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TuNombre');
        $pdf->SetTitle('Liquidación');
        $pdf->SetSubject('Detalle de Liquidación');
        $pdf->SetKeywords('TCPDF, PDF, liquidación, guía, detalle');
    
        // Añadir página
        $pdf->AddPage();
    
        // Estilos
        $style = "<style>
                    * { text-align: center; font-size: 13px; }
                    table, td, th { border: 1px solid; border-spacing: 0; border-collapse: collapse; }
                    table { width: 100%; margin-bottom: 20px; }
                    th, td { padding: 8px; }
                    th { background-color: #f2f2f2; }
                  </style>";
    
        // Comenzar a generar el contenido HTML para los datos de la guía
        $html = $style . '<h4>Datos de la Guía</h4>';
        $html .= '<table><thead><tr><th>Item</th><th>Guía</th><th>Código</th><th>Peso Hum (KG)</th><th>Humedad (%)</th><th>Peso Seco (KG)</th></tr></thead><tbody>';

        // Iterar sobre los datos de la guía para crear las filas de la tabla
        foreach ($guia as $index => $item) {
            $html .= "<tr>
                        <td>" . ($index + 1) . "</td>
                        <td>Guía #1</td>
                        <td>{$item['guide_code']}</td>
                        <td>{$item['wet_weight']}</td>
                        <td>{$item['moisture_percentage']}</td>
                        <td>{$item['dry_weight']}</td>
                    </tr>";
        }

        // Calcular totales para peso húmedo y seco
        $totalWetWeight = array_sum(array_column($guia, 'wet_weight'));
        $totalDryWeight = array_sum(array_column($guia, 'dry_weight'));

        // Agregar fila de totales a la tabla
        $html .= "<tr>
                    <td>Tot</td>
                    <td></td>
                    <td></td>
                    <td>" . number_format($totalWetWeight, 2) . "</td>
                    <td></td>
                    <td>" . number_format($totalDryWeight, 2) . "</td>
                </tr>";

        $html .= '</tbody></table>';

        // Filtrar detalles para AU
        $analisisAU = array_filter($detalle, function($item) {
            return $item['element'] == 'AU';
        });


        // Escribir el HTML en el documento PDF
        $pdf->writeHTML($html, true, false, true, false, '');


        $this->response->setContentType('application/pdf');
        // Cerrar y enviar el documento PDF
        $pdf->Output('liquidacion.pdf', 'I');
    }
}
