<?php

namespace App\Models;

use App\Config\Database;

class RecetaModel{

    
    private $bd;
    public function __construct(){

        $this->bd = Database::getInstance();

    }

    public function ultimaReceta($idPaciente){

        $result = '';
 
        $sql = "SELECT fecha_hora, contenido FROM receta_medica WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);     

        $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
        $result .= '
        <label class="text-primary"><small>Fecha y Hora:</small></label>
        <div class="fs-5">' . $fecha_hora . '</div>
        <div class="fs-5 mt-3">'.$data['contenido'].'</div>';
       
        return $result;

    }

    public function getReceta($idReceta){
        $result = '';
 
        $sql = "SELECT fecha_hora, contenido FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idReceta]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);     

        $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
        $result .= '
        <label class="text-primary"><small>Fecha y Hora:</small></label>
        <div class="fs-5">' . $fecha_hora . '</div>
        <div class="fs-5 mt-3">'.$data['contenido'].'</div>';
       
        return $result;
    }

}