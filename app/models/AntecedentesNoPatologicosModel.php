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
public function obtenerPreguntasTabaquismo($idPaciente, $idRol) {
    $result = '';
    
    // Obtener las respuestas del paciente
    $stmt = $this->bd->query("SELECT * FROM pc_paciente_tabaquismo WHERE id_paciente = '".$idPaciente."'");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    if (!empty($preguntas)) {
        foreach ($preguntas as $pregunta): 
            $idTabaquismo = $pregunta['id'];
            $fuma = $pregunta['fuma'];
            $edad_inicio  = $pregunta['edad'];
            $tiempo_fumando  = $pregunta['tiempo'];
            $cigarrillos_por_dia  = $pregunta['promedio'];
            $tiempo_suspension  = $pregunta['suspendido'];
            
        $result .= '<div id="seccion2" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-1">
        <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion2">
        <h8 class="text-secondary fw-bold mb-1 texto"><b>¿Usted fuma cigarros de nicotina?:</b></h8>
        </div>
            
        <select class="form-select mb-4" onchange="respuestaPregunta(this, '.$idTabaquismo.',1)">
        <option value="" disabled selected>Selecciona una opción...</option>
        <option value="Si" ' . ($fuma == 'Si' ? 'selected' : '') . '>Sí</option>
        <option value="No" ' . ($fuma == 'No' ? 'selected' : '') . '>No</option>
        </select>
            
        <div id="seccion3" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-1">
        <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion3">
        <h8 class="text-secondary fw-bold mb-1 texto"><b>¿Desde qué edad empezó a fumar?</b></h8>
        </div>
        <input type="number" class="form-control mb-4" value="' . ($edad_inicio == 0 ? '' : $edad_inicio) . '" placeholder="Ingresa la edad en que empezaste a fumar..." onchange="respuestaPregunta(this, '.$idTabaquismo.',2)">

        <div id="seccion4" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-1">
        <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion4">
        <h8 class="text-secondary fw-bold mb-1 texto"><b>¿Durante cuánto tiempo ha fumado?</b></h8>
        </div>
        <input type="number" class="form-control mb-4" value="' . ($tiempo_fumando == 0 ? '' : $tiempo_fumando) . '" placeholder="Ingresa los años en los que has fumado..." onchange="respuestaPregunta(this, '.$idTabaquismo.',3)">

        <div id="seccion5" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-1">
        <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion5">
        <h8 class="text-secondary fw-bold mb-1 texto"><b>¿Cuántos cigarrillos consume en promedio por día?</b></h8>
        </div>
        <input type="number" class="form-control mb-4" value="' . ($cigarrillos_por_dia == 0 ? '' : $cigarrillos_por_dia) . '" placeholder="Ingresa los cigarros que consumes al día..." onchange="respuestaPregunta(this, '.$idTabaquismo.',4)">

        <div id="seccion6" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-1">
        <img src="'.RUTA_IMAGES.'/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 20px; margin-right: 10px;" data-target="seccion6">
        <h8 class="text-secondary fw-bold mb-1 texto"><b>Si ya dejó de fumar, ¿hace cuánto tiempo lo suspendió?</b></h8>
        </div>
        <input type="text" class="form-control" value="' . ($tiempo_suspension == 0 ? '' : $tiempo_suspension) . '" onchange="respuestaPregunta(this, '.$idTabaquismo.',5)">';
        
    endforeach;
    }
    
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