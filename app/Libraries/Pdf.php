<?php
/*
* Author: onlinecode
* start Pdf.php file
* Location: ./application/libraries/Pdf.php
*/
namespace APP\Libraries;

require_once APPPATH.'/Libraries/tcpdf/tcpdf.php';
class pdf extends TCPDF {
    public $titulo_reporte = ""; //variable publica para setear el titulo del reporte
    public function __construct() {
        parent::__construct();
    }
    //header del reporte
    public function Header_Reporte() {
        //tipo de letra
        $this->SetFont('courier', 'B', 10);
        $this->Cell(0,5,'CRUD CODEIGNITER 4',0,1,'C');
        $this->Cell(0,5, $this->titulo_reporte, 0,1,'C');
        $this->Image("./images/nombre_imagen.png",165,8,28,'','PNG','',false,300,'',false,false,0,false,false,false);
    }
    //...
}
