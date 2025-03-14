<?php

namespace App\Models;

use App\Config\Database;

class RecetaModel{

    
    private $bd;
    private $fecha_hora;
    private $id_paciente;
    private $contenido;
    public function __construct(){

        $this->bd = Database::getInstance();

    }

    public function receta($idReceta){

        $query = "SELECT * FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($query);
        $stmt->bindParam(':id', $idReceta);
        $stmt->execute();
        $registros = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->fecha_hora = $registros['fecha_hora'];
        $this->id_paciente = $registros['id_paciente'];
        $this->contenido = $registros['contenido'];

    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getFechaHora()
    {
        return $this->fecha_hora;
    }

    public function getIdPaciente()
    {
        return $this->id_paciente;
    }

    public function getContenido()
    {
        return $this->contenido;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------

    public function ultimaReceta($idPaciente){

        $result = '';
 
        $sql = "SELECT id, fecha_hora, contenido FROM receta_medica WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);
 

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
            $result .= '
            <div class="float-end"><a target="_blank" href="/pdf/receta/'.$data['id'].'" class="btn icon btn-primary"><i data-feather="printer"></i></a></div>
            <div class="fs-5">' . $fecha_hora . '</div>
            <div class="fs-5 mt-3">'.$data['contenido'].'</div>';
            
        } else {
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
       
        return $result;

    }

    public function getReceta($idReceta){
        $result = '';
 
        $sql = "SELECT id, fecha_hora, contenido FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idReceta]);  

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            
        $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
        $result .= '
        <div class="float-end"><a target="_blank" href="/pdf/receta/'.$data['id'].'" class="btn icon btn-primary"><i data-feather="printer"></i></a></div>
        <label class="text-primary"><small>Fecha y Hora:</small></label>
        <div class="fs-5">' . $fecha_hora . '</div>
        <div class="fs-5 mt-3">'.$data['contenido'].'</div>';

        } else {
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
       
        return $result;
    }

    public function getRecetaPdf($idReceta){

        $result = '';
  
        $sql = "SELECT id, fecha_hora, contenido FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idReceta]);  

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);                 
        $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d-m-Y h:i a');


        $result .= '

        <table width="100%">
        <tr>
        <td height="4cm">
        <div style="text-align: center;line-height: 55px;">Fecha: ' . $fecha_hora . '</div>
        </td>
        </tr>
        </table>

        <table width="100%">
        <tr>
        <td height="8cm">

        '.$data['contenido'].'
        
        </td>
        </tr>
        </table>


        ';

    
        return $result;

    }

}