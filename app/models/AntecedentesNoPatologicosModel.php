<?php
namespace App\Models;
use App\Config\Database;

class AntecedentesNoPatologicosModel{
private $bd;

public function __construct(){
$this->bd = Database::getInstance();

}


//---------- AGREGA PREGUNTAS AL INICIAR ----------//




public function mostrarPreguntasV1($idPaciente, $idRol){
$result = '';





return $result;
}




}