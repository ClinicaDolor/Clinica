<?php
namespace App\Models;

use App\Config\Database;

class NotaSubsecuenteModel{

    private $fecha_hora;
    private $id_paciente;
    private $contenido;

    private $bd;
    public function __construct(){

        $this->bd = Database::getInstance();

    }

    public function NotaSubsecuente($idNota){

        $query = "SELECT * FROM nota_subsecuente WHERE id = :id";
        $stmt = $this->bd->prepare($query);
        $stmt->bindParam(':id', $idNota);
        $stmt->execute();
        $registros = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->fecha_hora = $registros['fecha_hora'];
        $this->id_paciente = $registros['id_paciente'];
        $this->contenido = $registros['contenido'];

    }

    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    
    public function getFechaHora()
    {
        return $this->fecha_hora;
    }

    public function getIdPaciente()
    {
        return $this->id_paciente;
    }

    public function getContenido()
    {
        return $this->contenido;
    }

    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------

    public function insertNotaSubsecuente($data){

        $sql = "INSERT INTO nota_subsecuente (
            id_paciente,
            contenido
        ) VALUES (
            :id_paciente,
            :contenido
        )";

        $stmt = $this->bd->prepare($sql);         

        $datos = [
            ':id_paciente' => $data['idPaciente'],
            ':contenido' => $data['contenidoNota']
            ];
        
            if ($stmt->execute($datos)) {
                return array('resultado' => 200,'mensaje' => '¡Se creo la nota subsecuente Correctamente!');
    
            } else {
                return array('resultado' => 401,'mensaje' => '¡Error al agregar nueva nota subsecuente a la lista!');
            }
     

    }

    public function ultimaNota($idPaciente){

        $result = '';
 
        $sql = "SELECT fecha_hora, contenido FROM nota_subsecuente WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
            $result .= '
            <label class="text-primary"><small>Fecha y Hora:</small></label>
            <div class="fs-5">' . $fecha_hora . '</div>
            <div class="fs-5 mt-3">'.$data['contenido'].'</div>';
           
        } else {
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
               
        return $result;        

    }

    public function getNotaSubsecuente($idNota){

        $result = '';
 
        $sql = "SELECT fecha_hora, contenido FROM nota_subsecuente WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idNota]);
        
        if($data = $stmt->fetch(\PDO::FETCH_ASSOC)){

            $fecha_hora = (new \DateTime($data['fecha_hora']))->format('d/m/Y h:i a');
            $result .= '
            <label class="text-primary"><small>Fecha y Hora:</small></label>
            <div class="fs-5">' . $fecha_hora . '</div>
            <div class="fs-5 mt-3">'.$data['contenido'].'</div>';
            
        }else{
            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';
        }
       
        return $result;

    }

}