<?php

namespace App\Controllers;

use CodeIgniter\Controller;
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
}
