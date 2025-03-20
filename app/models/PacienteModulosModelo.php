<?php
namespace App\Models;
use App\Config\Database;

class PacienteModulosModelo{
    private $bd;

    public function __construct(){
    $this->bd = Database::getInstance();
    
    }

    public function agregarComentariosModulo($data){

    $sql = "INSERT INTO pac_historia_clinica_comentario (
    id_modulo,
    id_paciente,
    comentario
    ) VALUES (
    :id_modulo,
    :id_paciente,
    :comentario
    )";
    
    $stmt = $this->bd->prepare($sql);                    
        
    $datos = [
    ':id_modulo' => $data['idModulo'],
    ':id_paciente' => $data['idPaciente'],
    ':comentario' => $data['comentarioModulos']
    ];
    
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se agrego el comentario correctamente!');
    
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al agregar el comentario la lista!');
    }
    
    }

    public function eliminarComentariosModulo($data){

    $sql = "DELETE FROM pac_historia_clinica_comentario WHERE id = :id_comentario";
    $stmt = $this->bd->prepare($sql);                    
            
    $datos = [
    ':id_comentario' => $data['idComentario']
    ];
        
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se elimino el comentario correctamente!');
        
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al eliminar el comentario de la lista!');
    }
        
    }


    //---------- FINALIZAR MODULO ----------
    public function finalizarModulos($data){

    $sql = "INSERT INTO pac_historia_clinica_finalizar (
    id_modulo,
    id_paciente
    ) VALUES (
    :id_modulo,
    :id_paciente
    )";
        
    $stmt = $this->bd->prepare($sql);                    
            
    $datos = [
    ':id_modulo' => $data['idModulo'],
    ':id_paciente' => $data['idPaciente']
    ];
        
    if ($stmt->execute($datos)) {
    return array('resultado' => 200,'mensaje' => '¡Se finalizo el modulo correctamente!');
        
    } else {
    return array('resultado' => 401,'mensaje' => '¡Error al finalizar el modulo!');
    }
        
    }
    

}