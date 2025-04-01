<?php

namespace App\Controllers;

class DownloadController{

    private $uploadPath = __DIR__ . "../../../public/storage/";

    public function download($ruta, $archivo){

        $filePath = $this->uploadPath . $ruta . '/' . basename($archivo);
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "Archivo no encontrado.";
            return;
        }
        
        // Obtener tipo MIME
        $fileMime = mime_content_type($filePath);
        
        // Configurar cabeceras para la descarga
        header("Content-Description: File Transfer");
        header("Content-Type: " . $fileMime);
        header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($filePath));
        
        // Leer el archivo y enviarlo al output buffer
        readfile($filePath);
        exit;
    }
}