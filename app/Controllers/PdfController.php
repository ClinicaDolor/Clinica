<?php 
namespace App\Controllers;

use TCPDF;
use App\Models\RecetaModel;

class PdfController{

    public function pdfReceta($idReceta){

        $model = new RecetaModel();
        $view = $model->getRecetaPdf($idReceta);

    $pdf = new TCPDF('L', 'mm', array(216, 140), true, 'UTF-8', false);

    $pdf->SetCreator('Clinica');
    $pdf->SetTitle('Receta');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->SetMargins(5, 0, 5);
    $pdf->SetAutoPageBreak(false, 0); 
    
    $pdf->SetFont('courier', '', 13);

    $pdf->AddPage();
    $html = $view;

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Receta.pdf', 'I');

    }
}