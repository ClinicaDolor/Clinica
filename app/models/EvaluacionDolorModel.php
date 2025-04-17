<?php
namespace App\Models;
use App\Config\Database;

class EvaluacionDolorModel{

    private $bd;

    public function __construct(){
    $this->bd = Database::getInstance();
    
    }

    public function cuestionarioModulo9($idPaciente){
    $sql = "SELECT COUNT(*) FROM pc_paciente_evaluacion_dolor WHERE id_paciente = ?";
    $stmt = $this->bd->prepare($sql);
    $stmt->execute([$idPaciente]);
    $numero = $stmt->fetchColumn();
                        
    if ($numero == 0) {
    $sql_insert = "INSERT INTO pc_paciente_evaluacion_dolor (id_paciente) 
    VALUES (?)";
    $stmt_insert = $this->bd->prepare($sql_insert);
    $stmt_insert->execute(params: [$idPaciente]);
    }
    }
    
    public function mostrarPreguntasM9($idPaciente, $idRol){
    $result = "";
    $stmt = $this->bd->query("SELECT * FROM pc_paciente_evaluacion_dolor WHERE id_paciente = '".$idPaciente."' ORDER BY id ASC");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($preguntas as $index => $pregunta) :
    $idEvaluacion = $pregunta['id'];
    $dolor = $pregunta['dolor'];
    $tiempo_dolor = $pregunta['tiempo_dolor'];
    $descripcion = $pregunta['descripcion'];
    $incremento = $pregunta['incremento'];
    endforeach;


    if($idRol == "Paciente"){
    $model = new PacienteModulosModelo();
    $botonFinalizar = $model->botonFinalizarModulo(9,$idPaciente,$idRol);

    $result .= '<div class="card-header pb-0">
    <div id="seccion111" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-4">
    <img src="'.RUTA_IMAGES.'/iconos/audio.png" onclick="readQuestion()" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion111">
      
    <p class="text-primary fw-bold texto mb-0">
    <b>A continuación, deberás responder las siguientes preguntas con base en la evaluación de dolor previamente realizada.</b>
    Por favor, asegúrate de responder con la mayor claridad y detalle posible para facilitar una mejor comprensión de tu malestar.
    </p>
    </div>
    </div>';
      

    $result .= '<div class="card-body">';
    $result .= '<div class="col-12">
    <div class="text-secondary fw-bold mb-1">¿Tiene dolor actualmente?:</div>
    <select class="form-select mb-3" onchange="editarEvaluacionDolor('.$idEvaluacion.', this, 1, \''.$idRol.'\')">
    <option value="" disabled selected>Selecciona una opción...</option>
    <option value="Si" ' . ($dolor == 'Si' ? 'selected' : '') . '>Si</option>
    <option value="No" ' . ($dolor == 'No' ? 'selected' : '') . '>No</option>
    </select>
    </div>';

    if($dolor == "Si"){
    $result .= '
    <div class="col-12">
    <div class="text-secondary fw-bold mb-1">¿Desde hace cuánto tiempo tiene dolor?:</div>
    <input type="text" onchange="editarEvaluacionDolor('.$idEvaluacion.', this, 2, \''.$idRol.'\')" class="form-control mb-3" value="'.$tiempo_dolor.'">
    </div>';

    $result .= '
    <div class="col-12">
    <div class="text-secondary fw-bold mb-1">Describa cómo inició el dolor, características y todo lo relacionado al dolor:</div>
    <textarea class="form-control mb-3" rows="6" onchange="editarEvaluacionDolor('.$idEvaluacion.', this, 3, \''.$idRol.'\')">'.$descripcion.'</textarea>
    </div>';

    $result .= '
    <div class="col-12">
    <div class="text-secondary fw-bold mb-1">¿Se ha incrementado el dolor o permanece igual desde el inicio?:</div>
    <input type="text" onchange="editarEvaluacionDolor('.$idEvaluacion.', this, 4, \''.$idRol.'\')" class="form-control mb-3" value="'.$incremento.'">
    </div>';
    }

    $result .= '<div class="col-12">
    <div class="mt-3 d-flex justify-content-between">';

    $result .= '<button class="btn btn-success" onclick="seccionEspalda()"><i data-feather="chevron-left"></i> Imagen de Espalda</button>';

    if (!empty($dolor)) {
    $result .= $botonFinalizar;
    }

    $result .= '</div>
    </div>';


    $result .= '</div>';

    }else{
    //---------- Doctor
    }


    return $result;
    }

    public function mostrarPreguntasFrenteM9($idPaciente, $idRol){
    $result = '';

    $result .= '<div class="card-header pb-0">
    <div id="seccion1" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-4">
    <img src="'.RUTA_IMAGES.'/iconos/audio.png" onclick="readQuestion()" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion1">

    <h8 class="text-primary fw-bold texto">
    <b >A continuación, debera de indicar las zonas donde siente malestar utilizando los siguientes colores:</b>
    Rojo: Área con Dolor, Amarillo</span>: Área Dormida y con Dolor, Verde: Área con Molestia al tacto y roce de la ropa, 
    Azul: Área sin Sensibilidad y sin Dolor, Morado : Área con Punzadas y Calambres.
    <br>
    Evite marcar la zona con una "X". En su lugar, cúbrala por completo utilizando el color que corresponda.
    </h8>
    </div>
    </div>';


    $result .= '
    <div class="card-body">
    <div class="row">
    <div class="col-12"><h8 class="text-success fw-bold texto">Imagen de frente</h8></div>
    
    <div class="col-10 col-sm-8">    
    <select class="form-select mt-1 mb-3" id="colorFrente">
    <option value="#FFFFFF">Selecciona una color...</option>
    <option value="#ff0000">🟥 Dolor (Rojo)</option>
    <option value="#0000ff">🟦 Adormecido (Azul)</option>
    <option value="#00ff00">🟩 Molestia al roce (Verde)</option>
    <option value="#ffff00">🟨 Sin sensibilidad (Amarillo)</option>
    <option value="#ff00ff">🟪 Punzadas y Calambres (Magenta)</option>
    </select>
    </div>

    <div class="col-2 col-sm-4"> 
    <button class="btn btn-danger float-end" onclick="cleanFrenteImg()">Limpiar <i data-feather="trash-2"></i></button>
    </div>

    <div class="col-12 mb-3"><canvas id="painFrente" width="1200px" height="1800px"></canvas></div>
    
    <div class="col-12">
    <button class="btn btn-success float-end" onclick="seccionEspalda()">Imagen de Espalda <i data-feather="chevron-right"></i></button>
    </div>
    </div>
    </div>';


    return $result;
    }


    public function mostrarPreguntasEspaldaM9($idPaciente, $idRol){
    $result = '';
    
    $result .= '<div class="card-header pb-0">
    <div id="seccion1" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-4">
    <img src="'.RUTA_IMAGES.'/iconos/audio.png" onclick="readQuestion()" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion1">

    <h8 class="text-primary fw-bold texto">
    <b >A continuación, debera de indicar las zonas donde siente malestar utilizando los siguientes colores:</b>
    Rojo: Área con Dolor, Amarillo</span>: Área Dormida y con Dolor, Verde: Área con Molestia al tacto y roce de la ropa, 
    Azul: Área sin Sensibilidad y sin Dolor, Morado : Área con Punzadas y Calambres.
    <br>
    Evite marcar la zona con una "X". En su lugar, cúbrala por completo utilizando el color que corresponda.
    </h8>
    </div>
    </div>';

    $result .= '
    <div class="card-body">
    <div class="row">
    <div class="col-12"><h8 class="text-success fw-bold texto">Imagen de espalda</h8></div>
        
    <div class="col-10 col-sm-8">    
    <select class="form-select mt-1 mb-3" id="colorEspalda">
    <option value="#FFFFFF">Selecciona una color...</option>
    <option value="#ff0000">🟥 Dolor (Rojo)</option>
    <option value="#0000ff">🟦 Adormecido (Azul)</option>
    <option value="#00ff00">🟩 Molestia al roce (Verde)</option>
    <option value="#ffff00">🟨 Sin sensibilidad (Amarillo)</option>
    <option value="#ff00ff">🟪 Punzadas y Calambres (Magenta)</option>
    </select>
    </div>
    
    <div class="col-2 col-sm-4"> 
    <button class="btn btn-danger float-end" onclick="cleanEspaldaImg()">Limpiar <i data-feather="trash-2"></i></button>
    </div>
    
    <div class="col-12 mb-3"><canvas id="painEspalda" width="1200px" height="1800px"></canvas></div>
        
    <div class="col-6">
    <button class="btn btn-success" onclick="seccionFrente()"><i data-feather="chevron-left"></i> Imagen de Frente </button>
    </div>

    <div class="col-6">
    <button class="btn btn-success float-end" onclick="seccionCuestionario()">Cuestionario <i data-feather="chevron-right"></i></button>
    </div>
    </div>
    </div>';
    
    return $result;
    }

    //---------- CARGAR IMAGEN DE FRENTE ----------
    public function imagenFrenteModulo9($idPaciente, $idSexo){
    // Ruta en el sistema de archivos (para PHP)
    $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/frente/";
        
    // Ruta pública (para el navegador)
    $rutaBaseUrl = RUTA_IMAGES;
    
    // Nombres de archivos según sexo
    $nombreImagenPaciente = ($idSexo === 'F') ? "Frente_F_{$idPaciente}.png" : "Frente_M_{$idPaciente}.png";
    $nombreImagenDefault = ($idSexo === 'F')  ? "Frente_F.png" : "Frente_M.png";
    
    // Rutas locales (físicas) para trabajar con archivos
    $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
    $imagenDefaultLocal = $rutaBaseLocal . $nombreImagenDefault;
    
    // Ruta URL para el navegador
    $imagenPacienteUrl = $rutaBaseUrl . $nombreImagenPaciente;
    
    // Si la imagen del paciente ya existe, devolver la URL
    if (file_exists($imagenPacienteLocal)) {
    //return $imagenPacienteUrl;
    }else{
    if (copy($imagenDefaultLocal, $imagenPacienteLocal)) {
    //return $imagenPacienteUrl;
    }
    }

    // Si algo falla, retorna error o lanza excepción
    //return 'No se pudo generar la imagen de frente del paciente.';
    }
 
    //---------- CARGAR IMAGEN DE FRENTE ----------
    public function imagenEspaldaModulo9($idPaciente, $idSexo){
    // Ruta en el sistema de archivos (para PHP)
    $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/espalda/";
            
    // Ruta pública (para el navegador)
    $rutaBaseUrl = RUTA_IMAGES;
        
    // Nombres de archivos según sexo
    $nombreImagenPaciente = ($idSexo === 'F') ? "Espalda_F_{$idPaciente}.png" : "Espalda_M_{$idPaciente}.png";
    $nombreImagenDefault = ($idSexo === 'F')  ? "Espalda_F.png" : "Espalda_M.png";
        
    // Rutas locales (físicas) para trabajar con archivos
    $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
    $imagenDefaultLocal = $rutaBaseLocal . $nombreImagenDefault;
        
    // Ruta URL para el navegador
    $imagenPacienteUrl = $rutaBaseUrl . $nombreImagenPaciente;
        
    // Si la imagen del paciente ya existe, devolver la URL
    if (file_exists($imagenPacienteLocal)) {
    //return $imagenPacienteUrl;
    }else{
    if (copy($imagenDefaultLocal, $imagenPacienteLocal)) {
    //return $imagenPacienteUrl;
    }
    }
    
    // Si algo falla, retorna error o lanza excepción
    //return 'No se pudo generar la imagen de frente del paciente.';
    }   

    public function editarImgFrente($data){
    $idPaciente = $data['idPaciente'];
    $img = $data['imgFrente']; // Se espera que sea base64 (ej: data:image/png;base64,...)
    $sexo = $data['idSexo'];
    
    $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/frente/";
    $nombreImagenPaciente = ($sexo === 'F') ? "Frente_F_{$idPaciente}.png" : "Frente_M_{$idPaciente}.png";
    $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
    
    // Quitar encabezado base64
    if (strpos($img, 'data:image') === 0) {
    $img = preg_replace('#^data:image/\w+;base64,#i', '', $img);
    }
    
    // Decodificar
    $fileBin = base64_decode($img);
    
    if ($fileBin && file_put_contents($imagenPacienteLocal, $fileBin)) {
    return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
    } else {
    return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
    }
    }


    public function editarImgEspalda($data){
    $idPaciente = $data['idPaciente'];
    $img = $data['imgEspalda']; // Se espera que sea base64 (ej: data:image/png;base64,...)
    $sexo = $data['idSexo'];
    
    $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/espalda/";
    $nombreImagenPaciente = ($sexo === 'F') ? "Espalda_F_{$idPaciente}.png" : "Espalda_M_{$idPaciente}.png";
    $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
    
    // Quitar encabezado base64
    if (strpos($img, 'data:image') === 0) {
    $img = preg_replace('#^data:image/\w+;base64,#i', '', $img);
    }
    
    // Decodificar
    $fileBin = base64_decode($img);
    
    if ($fileBin && file_put_contents($imagenPacienteLocal, $fileBin)) {
    return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
    } else {
    return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
    }
    }
    
    public function eliminarImgFrente($data){
    $idPaciente = $data['idPaciente'];
    $sexo = $data['idSexo'];
            
    // Ruta en el sistema de archivos (para PHP)
    $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/frente/";
            
    // Nombres de archivos según sexo
    $nombreImagenPaciente = ($sexo === 'F') ? "Frente_F_{$idPaciente}.png" : "Frente_M_{$idPaciente}.png";
    $nombreImagenDefault = ($sexo === 'F')  ? "Frente_F.png" : "Frente_M.png";
        
    // Rutas locales (físicas) para trabajar con archivos
    $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
    $imagenDefaultLocal = $rutaBaseLocal . $nombreImagenDefault;
    
    if (file_exists($imagenPacienteLocal)) {
    if (copy($imagenDefaultLocal, $imagenPacienteLocal)){
    return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
    }else{
    return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
    }
    
    }else{
    if (copy($imagenDefaultLocal, $imagenPacienteLocal)){
    return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
    }else{
    return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
    }  
    }
    
    }

    public function eliminarImgEspalda($data){
        $idPaciente = $data['idPaciente'];
        $sexo = $data['idSexo'];
                
        // Ruta en el sistema de archivos (para PHP)
        $rutaBaseLocal = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/images/evaluacion-dolor/espalda/";
                
        // Nombres de archivos según sexo
        $nombreImagenPaciente = ($sexo === 'F') ? "Espalda_F_{$idPaciente}.png" : "Espalda_M_{$idPaciente}.png";
        $nombreImagenDefault = ($sexo === 'F')  ? "Espalda_F.png" : "Espalda_M.png";
            
        // Rutas locales (físicas) para trabajar con archivos
        $imagenPacienteLocal = $rutaBaseLocal . $nombreImagenPaciente;
        $imagenDefaultLocal = $rutaBaseLocal . $nombreImagenDefault;
        
        if (file_exists($imagenPacienteLocal)) {
        if (copy($imagenDefaultLocal, $imagenPacienteLocal)){
        return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
        }else{
        return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
        }
        
        }else{
        if (copy($imagenDefaultLocal, $imagenPacienteLocal)){
        return array('resultado' => 200, 'mensaje' => '¡Se actualizó la imagen correctamente!');
        }else{
        return array('resultado' => 401, 'mensaje' => '¡Error al guardar la imagen!');
        }  
        }
        
        }


    public function editarEvaluacion($data) {
    
    $opcionEdicion = $data['edicion'];
        
    $consulta2 = "";
    if($opcionEdicion == 1){
    $consulta = "dolor";
    if($data['detalle'] == "No"){
    $consulta2 = ",tiempo_dolor = '', descripcion = '', incremento = ''";
    }
    }else if($opcionEdicion == 2){
    $consulta = "tiempo_dolor";
    }else if($opcionEdicion == 3){
    $consulta = "descripcion";
    }else if($opcionEdicion == 4){
    $consulta = "incremento";
    }
            
     $sql = "UPDATE pc_paciente_evaluacion_dolor SET 
    $consulta = :detalle $consulta2 WHERE id = :idEvaluacion";
            
    $stmt = $this->bd->prepare($sql);                    
                        
    $datos = [
    ':idEvaluacion' => $data['idEvaluacion'],
    ':detalle' => $data['detalle']
    ];
                    
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la informacion correctamente!');
                    
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la enfermedad de la lista!');
    }
    }

  
}
