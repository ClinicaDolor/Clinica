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


    //---------- VALIDACION STATUS DE MODULO ----------

    public function statusModulo($idPaciente, $idModulo){
    $stmt = $this->bd->query("SELECT id, comentario FROM pac_historia_clinica_comentario WHERE id_modulo = '".$idModulo."' AND id_paciente = '".$idPaciente."' ORDER BY id DESC LIMIT 1");
    $comentarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $comentarios;
    }

    //---------- COMENTATIOS DE LOS MODULOS ----------
    public function mostrarComentariosModulo($idPaciente, $idRol, $idModulo) {
    $result = '';
    
    $comentarios = $this->statusModulo($idPaciente, $idModulo);
        
    if ($idRol == "Doctor"){
    $moduloComentario = "Sin comentarios";
    $deshabilitar = "disabled";
    }else{


    $deshabilitar = "";
    if (!empty($comentarios)) {
    $num = 1;
    foreach ($comentarios as $comentario): 
    $moduloComentario = $comentario['comentario'];
    $num++;
    endforeach; 
    $deshabilitar = "disabled";
    }else{
    $moduloComentario = "";
    }
    }

    $result .= '
    <textarea class="form-control" id="comentarioModulos" placeholder="Ingresa aquí tu comentario..." style="height: 200px;" '.$deshabilitar.'>'.$moduloComentario.'</textarea>';
    return $result;
    }


   


    //---------- FINALIZAR MODULO ----------
    public function botonFinalizarModulo($idModulo, $idPaciente, $idRol){
    $result = '';

    $stmt = $this->bd->query("SELECT * FROM pac_historia_clinica_finalizar WHERE id_modulo = '".$idModulo."' AND id_paciente = '".$idPaciente."' ORDER BY id ASC");
    $preguntas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (!empty($preguntas)) {
    $result .= '';
    }else{

    if($idModulo == 2 || $idModulo == 3){
    $result .= '<button class="btn btn-success" onclick="agregarComentario('.$idModulo.', '.$idPaciente.',\''.$idRol.'\')">Finalizar</button>';
    } else{
    $result .= '<button class="btn btn-success" onclick="finalizarModuloPAC('.$idModulo.', '.$idPaciente.',\''.$idRol.'\')">Finalizar</button>';
    }   
    }

    return $result;
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