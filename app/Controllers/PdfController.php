<?php 
namespace App\Controllers;

use TCPDF;
use App\Models\RecetaModel;
use App\Models\PacienteModel;
use App\Helpers\CalculadoraEdad;

class PdfController{

    public function pdfReceta($idReceta){

        $model = new RecetaModel();
        $model->receta($idReceta);

        $paciente = new PacienteModel($model->getIdPaciente());      
        $edad = CalculadoraEdad::calcularEdad($paciente->getFechaNacimiento());
        $textoFormateado = $this->htmlToMultiCell($model->getMedicamento());

        $pdf = new TCPDF('L', 'mm', array(216, 140), true, 'UTF-8', false);

        $pdf->SetCreator('Clinica');
        $pdf->SetTitle('Receta');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(5, 0, 5);
        $pdf->SetAutoPageBreak(false, 0); 
        
        $pdf->AddPage();

        $imagePath = '../public/assets/images/receta.jpeg';

        // Obtener el tamaño de la página (ancho y alto)
        $pageWidth = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();

        // Colocar la imagen de fondo en las coordenadas (0, 0) y ajustarla al tamaño de la página
        //$pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight, '', '', '', false, 10);

        $pdf->SetFont('courier', '', 12);
        $pdf->SetY(24.5);
        $pdf->SetX(100);
        $pdf->Cell(0, 0, $paciente->getNombreCompleto(), 0, 1, 'L');
        $pdf->Ln(0);

        
        $pdf->SetFont('courier', '', 10);
        $pdf->SetY(32.5);
        $pdf->SetX(96.5);
        $pdf->Cell(0, 0, $paciente->getFechaNacimiento(), 0, 1, 'L');
        $pdf->Ln(0);

        $pdf->SetFont('courier', '', 10);
        $pdf->SetY(32.5);
        $pdf->SetX(128);
        $pdf->Cell(0, 0, $edad.' años', 0, 1, 'L');
        $pdf->Ln(0);

        $pdf->SetFont('courier', '', 10);

        if($paciente->getSexo() == 'M'){
        $pdf->SetY(32.5);
        $pdf->SetX(162);
        }else{
        $pdf->SetY(32.5);
        $pdf->SetX(183);
        }

        $pdf->Cell(0, 0, 'X', 0, 1, 'L');
        $pdf->Ln(0);

        $pdf->SetFont('courier', '', 12);
        $pdf->SetY(40);
        $pdf->SetX(71);
        $pdf->Cell(0, 0, 'Fecha: '.$model->getFecha().', Hora: '.$model->getHora(), 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('courier', '', 11);
        $pdf->MultiCell(0, 10, $model->getDiagnostico());
        $pdf->Ln(5);

        $pdf->SetFont('courier', '', 11);
        $pdf->MultiCell(0, 10, $textoFormateado);

        $pdf->Output($paciente->getNombreCompleto().' '.$model->getFecha().'.pdf', 'I');

    }

    function htmlToMultiCell($html) {
        // Cargamos el HTML en DOMDocument para procesarlo
        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    
        $result = "";
    
        // Recorremos cada nodo y procesamos las etiquetas importantes
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $node) {
            if ($node->nodeType === XML_TEXT_NODE) {
                // Si es texto directo, lo añadimos tal cual
                $result .= trim($node->textContent) . " ";
            } elseif ($node->nodeName === 'p') {
                // Si es un párrafo <p>, agregamos el contenido seguido de una línea nueva
                $result .= trim($node->textContent) . "\n";
            } elseif ($node->nodeName === 'br') {
                // Si es un salto de línea <br>, añadimos una línea nueva
                $result .= "\n";
            } elseif ($node->nodeName === 'ul' || $node->nodeName === 'ol') {
                // Si es una lista (ul o ol), procesamos los elementos <li>
                foreach ($node->childNodes as $li) {
                    if ($li->nodeName === 'li') {
                        $result .= "• " . trim($li->textContent) . "\n";
                    }
                }
                $result .= "\n";
            }
        }
    
        return $result;
    }
}