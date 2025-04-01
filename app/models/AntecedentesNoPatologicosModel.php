<?php
namespace App\Models;
use App\Config\Database;

class AntecedentesNoPatologicosModel{
private $bd;

public function __construct(){
$this->bd = Database::getInstance();

}


//---------- AGREGA PREGUNTAS AL INICIAR ----------//


//---------- OBTENER LAS PREGUNTAS ----------//
    public function obtenerPreguntasTabaquismo($idPaciente, $idRol){
    $result = '';

    // Obtener las respuestas del paciente
    $stmt = $this->bd->query("SELECT * FROM pc_paciente_tabaquismo WHERE id_paciente = '".$idPaciente."'");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    // Iterar sobre las respuestas y construir el HTML para visualizarlas
    foreach ($preguntas as $pregunta):
    $idTabaquismo = $pregunta['id'];
    $fuma = $pregunta['fuma'];
    $edad_inicio  = $pregunta['edad'];
    $tiempo_fumando  = $pregunta['tiempo'];
    $cigarrillos_por_dia  = $pregunta['promedio'];
    $tiempo_suspension  = $pregunta['suspendido'];
    endforeach;

    $result .= '<div class="text-success fw-bold mb-3">TABAQUISMO</div>
    
    <div id="seccion2" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-3">
    <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion2">

    <h8 class="text-secondary fw-bold mb-1 texto"><b>¿Usted fuma cigarros de nicotina?:</b></h8>
    </div>
    
    <select class="form-select tipo-enfermedad mb-3" onchange="respuestaPregunta(this, '.$idTabaquismo.',1)">
    <option value="" disabled selected>Selecciona una opción...</option>
    <option value="Si" '.($fuma == 'Si' ? 'selected' : '').'>Sí</option>
    <option value="No" '.($fuma == 'No' ? 'selected' : '').'>No</option>
    </select>';

    

    return $result;
    }


//---------- AGREGA PREGUNTAS AL INICIAR ----------//
public function mostrarPreguntasM3($idPaciente,$idRol,$idCuestionario){
$result = '';

if($idCuestionario == 1){
$result = $this->obtenerPreguntasTabaquismo($idPaciente,$idRol);
}


return $result;
}


}