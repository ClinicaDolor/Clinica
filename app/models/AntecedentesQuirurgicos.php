<?php
namespace App\Models;
use App\Config\Database;

class AntecedentesQuirurgicos{

    private $bd;

    public function __construct(){
    $this->bd = Database::getInstance();
    
    }

    public function agregarCirugiaPaciente($data){

    $sql = "INSERT INTO pc_antecedentes_quirurgicos (
    id_paciente
    ) VALUES (
    :id_paciente
    )";
    
    $stmt = $this->bd->prepare($sql);                    
        
    $datos = [
    ':id_paciente' => $data['idPaciente']
    ];
    
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se habilito una nueva cirugia correctamente!');
    
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al agregar la nueva cirugia a la lista!');
    }
    
    }


    public function editarCirugiaPaciente($data){
    $opcionEdicion = $data['edicion'];

    if($opcionEdicion == 1){
    $consulta = "fecha";
    }else if($opcionEdicion == 2){
    $consulta = "cirugia";
    }else if($opcionEdicion == 3){
    $consulta = "observaciones";
    }
    
    
    $sql = "UPDATE pc_antecedentes_quirurgicos SET 
    $consulta = :detalle WHERE id = :id_cirugia";
    
    $stmt = $this->bd->prepare($sql);                    
                
    $datos = [
    ':id_cirugia' => $data['idCirugia'],
    ':detalle' => $data['detalle']
    ];
            
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se actualizo la informacion correctamente!');
            
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al actualizar la cirugia de la lista!');
    }
            
    }


    public function eliminarCirugiaPaciente($data){

    $sql = "DELETE FROM pc_antecedentes_quirurgicos WHERE id = :idQuirurgico";
    $stmt = $this->bd->prepare($sql);                    
            
    $datos = [
    ':idQuirurgico' => $data['idQuirurgico']
    ];
        
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se elimino la cirugia correctamente!');
        
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al eliminar la cirugia de la lista!');
    }
        
    }


}

