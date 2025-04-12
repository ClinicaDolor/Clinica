<?php
namespace App\Models;
use App\Config\Database;

class ProcedimientosDolorModel{

    private $bd;

    public function __construct(){
    $this->bd = Database::getInstance();
    
    }



    //---------- MOSTRAR PREGUNTAS DEL MODULO 4 ----------/
    public function mostrarPreguntasM8($idPaciente,$idRol){
    $result = "";
    $stmt = $this->bd->query("SELECT * FROM pac_procedimientos_dolor_modulo_8 WHERE id_paciente = '".$idPaciente."' ORDER BY id ASC");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if($idRol == "Paciente"){

    if (!empty($preguntas)) {

    }else{
  
    $result .= '
    <div class="card-header pb-0">
    <div class="row">

    <div id="seccion100" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-2">
    <img src="'.RUTA_IMAGES.'/iconos/audio.png" onclick="readQuestion()" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion100">

    <h8 class="text-primary fw-bold texto">
    <b>Si usted ha tenido algun procedimiento para controlar el dolor, presione el botón verde para agregarlo. Si no ha sido sometido a ningun tipo de procedimiento, seleccione el boton de "Tratamientos":</b>
    </h8>
    </div>

    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>

    </div>
    </div>

    <div class="card-body">
    <div class="row">
    <div class="col-12 text-center pb-0">
    <img src="'.RUTA_IMAGES.'/iconos/agregar-icon.png" onclick="agregarProcedimientosDolor('.$idPaciente.',\''.$idRol.'\')" class="img-fluid btnLeer pointer" style="max-height: 90%;"></div>
    </div> 
    <div class="col-12 text-end">
    <button class="btn btn-success" onclick="seccionTratamientos()">Tratamientos</button>
    </div>
    
    </div>';
    
    }

    }else{
    //---------- Apartado del doctor ----------
    }

    return $result;
    }






    public function agregarProcedimientosPaciente($data){

    $sql = "INSERT INTO pac_procedimientos_dolor_modulo_8 (
    id_paciente
    ) VALUES (
    :id_paciente
    )";
        
    $stmt = $this->bd->prepare($sql);                    
            
    $datos = [
    ':id_paciente' => $data['idPaciente']
    ];
    
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se agrego el procedimiento correctamente!');
            
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al agregar el procedimiento la lista!');
    }
        
    }

    public function editarProcedimientoPaciente($data){
    $opcionEdicion = $data['edicion'];
    
    if($opcionEdicion == 1){
    $consulta = "procedimiento";
    }else if($opcionEdicion == 2){
    $consulta = "fecha";
    }else if($opcionEdicion == 3){
    $consulta = "resultados";
    }
        
    $sql = "UPDATE pac_procedimientos_dolor SET 
    $consulta = :detalle WHERE id = :id_procedimiento";
    
    $stmt = $this->bd->prepare($sql);                    
                    
    $datos = [
    ':id_procedimiento' => $data['idProcedimiento'],
    ':detalle' => $data['detalle']
    ];
                
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la informacion correctamente!');
                
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la cirugia de la lista!');
    }
                
    }

    public function eliminarProcedimientoPaciente($data){

    $sql = "DELETE FROM pac_procedimientos_dolor WHERE id = :id_procedimiento";
    $stmt = $this->bd->prepare($sql);                    
                
    $datos = [
    ':id_procedimiento' => $data['idProcedimiento']
    ];
            
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se elimino el procedimiento correctamente!');
            
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al eliminar el procedimiento de la lista!');
    }
            
    }
    

    public function editarTratamientoPaciente($data){
    $opcionEdicion = $data['edicion'];
    
    $consulta2 = "";
   
    if($opcionEdicion == 1){
    $consulta = "utilizo";
    if($data['detalle'] == "No"){
    $consulta2 = ",resultado = '', comentarios = ''";
    }
    }else if($opcionEdicion == 2){
    $consulta = "resultado";
    }else if($opcionEdicion == 3){
    $consulta = "comentarios";
    }
    
    
    $sql = "UPDATE respuestas_procedimientos_dolor SET 
    $consulta = :detalle $consulta2 WHERE id = :id_respuesta";
    $stmt = $this->bd->prepare($sql);                    
                
    $datos = [
    ':id_respuesta' => $data['idRespuesta'],
    ':detalle' => $data['detalle']
    ];
            
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la informacion correctamente!');
            
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la enfermedad de la lista!');
    }
            
    }

}

