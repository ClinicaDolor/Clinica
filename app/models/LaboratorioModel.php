<?php

namespace App\Models;
use App\Config\Database;

class LaboratorioModel{
    private $bd;
    public function __construct(){
    $this->bd = Database::getInstance();
    }

    public function ultimoLaboratorio($idPaciente){

        $result = '';
 
        $sql = "SELECT id, fecha_hora, nombre, ruta, tipo, descripcion FROM laboratorio WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);
 

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
            $result .= '
            <div class="float-end"><a download="'.$data['nombre'].'" href="/storage/public/'.$data['ruta'].'/'.$data['nombre'].'" class="btn icon btn-primary"><i data-feather="download"></i></a></div>
            <div class="fs-5">' . $fecha_hora . '</div>
            <div class="fs-5 mt-3">'.$data['descripcion'].'</div>';
            
        } else {
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
       
        return $result;

    }

    public function insertArchivo($idPaciente,$contenidoLaboratorio,$fileName, $fileData, $fileSize, $fileExtension){

        $uploadDir = '../storage/public/laboratorio/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . basename($fileName);
        if (move_uploaded_file($fileData, $filePath)) {

            $query = "INSERT INTO laboratorio (id_paciente, nombre, ruta, tipo, tamano, descripcion) 
                  VALUES (:id_paciente, :nombre, :ruta, :tipo, :tamano, :descripcion)";
            $stmt = $this->bd->prepare($query);     

            $datos = [
                ':id_paciente' => $idPaciente, 
                ':nombre' => basename($fileName), 
                ':ruta' => 'laboratorio', 
                ':tipo' => $fileExtension, 
                ':tamano' => $fileSize, 
                ':descripcion' => $contenidoLaboratorio
                ];

                if ($stmt->execute($datos)) {

                    return array('resultado' => 200,'mensaje' => $this->bd->lastInsertId());
        
                } else {
                    return array('resultado' => 401,'mensaje' => '¡Error al guardar el archivo!');
                }

        }else{
            return array('resultado' => 200,'mensaje' => '¡Error al guardar el archivo!');
        }
        
    }

    public function getLaboratorio($idLaboratorio){

        $result = '';
 
        $sql = "SELECT id, fecha_hora, nombre, ruta, tipo, descripcion FROM laboratorio WHERE id = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idLaboratorio]);
 

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
            $result .= '
            <div class="float-end"><a download="'.$data['nombre'].'" href="/storage/public/'.$data['ruta'].'/'.$data['nombre'].'" class="btn icon btn-primary"><i data-feather="download"></i></a></div>
            <div class="fs-5">' . $fecha_hora . '</div>
            <div class="fs-5 mt-3">'.$data['descripcion'].'</div>';
            
        } else {
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
       
        return $result;

    }
}