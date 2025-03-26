<?php
namespace App\Models;
use App\Config\Database;

class ProcedimientosDolorModel{

    private $bd;

    public function __construct(){
    $this->bd = Database::getInstance();
    
    }

    public function agregarProcedimientosPaciente($data){

    $sql = "INSERT INTO pac_procedimientos_dolor (
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

