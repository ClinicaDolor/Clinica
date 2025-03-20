<?php
namespace App\Models;
use App\Config\Database;

class AntecedenteFamiliarModel{
private $bd;

public function __construct(){
$this->bd = Database::getInstance();

}

    public function agregarEnfermedadPaciente($data){

    $sql = "INSERT INTO pc_antecedentes_familiares (
    id_paciente,
    detalle
    ) VALUES (
    :id_paciente,
    :detalle
    )";

    $stmt = $this->bd->prepare($sql);                    
    
    $datos = [
    ':id_paciente' => $data['idPaciente'],
    ':detalle' => "Si"
    ];

    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se habilito una nueva enfermedad correctamente!');

    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al agregar la nueva enfermedad a la lista!');
    }

    }
   
    public function editarEnfermedadPaciente($data){
    $opcionEdicion = $data['edicion'];

    $consulta2 = "";
    if($opcionEdicion == 1){
    $consulta = "enfermedad";
    }else if($opcionEdicion == 2){
    $consulta = "detalle";
    if($data['detalle'] == "No"){
    $consulta2 = ",tipo = '', especificar = ''";
    }
    }else if($opcionEdicion == 3){
    $consulta = "tipo";
    }else if($opcionEdicion == 4){
    $consulta = "especificar";
    }


    $sql = "UPDATE pc_antecedentes_familiares SET 
    $consulta = :detalle $consulta2 WHERE id = :id_enfermedad";

    $stmt = $this->bd->prepare($sql);                    
            
    $datos = [
    ':id_enfermedad' => $data['idEnfermedad'],
    ':detalle' => $data['detalle']
    ];
        
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la informacion correctamente!');
        
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la enfermedad de la lista!');
    }
        
    }

    public function eliminarEnfermedadPaciente($data){

    $sql = "DELETE FROM pc_antecedentes_familiares WHERE id = :id_enfermedad";
    $stmt = $this->bd->prepare($sql);                    
        
    $datos = [
    ':id_enfermedad' => $data['idEnfermedad']
    ];
    
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se elimino la enfermedad correctamente!');
    
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al eliminar la enfermedad de la lista!');
    }
    
    }


}