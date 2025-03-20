<?php
namespace App\Models;

use App\Config\Database;
use App\Models\ClinicaModel;
use App\Models\RecetaModel;

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

    //-------------------------------------------------------------------------
    //--------------- PRIMERA NOTA SUBSECUENTE DEL PACIENTE -------------------

    public function primerNota(){

        $query = "SELECT id FROM nota_subsecuente ORDER BY id ASC LIMIT 1";
        $stmt = $this->bd->prepare($query);
        $stmt->execute();
        $registros = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $registros['id'];

    }

    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------

    function mostrarTablaNotas($idPaciente,$referencia){

        $result = '';

        $qry_referencia = ($referencia == 0)? ' id_paciente = "'.$idPaciente.'"' : ' id_paciente = "'.$idPaciente.'" AND codigo_referencia = "'.$referencia.'" ';
        $query = $this->bd->query("SELECT * FROM nota_subsecuente WHERE $qry_referencia ORDER BY fecha_hora DESC");
        $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

        $result .= '<table class="table table-striped table-hover table-sm pb-0 mb-0" id="tableNotasSubsecuentes">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($registros as $registro): 

        $primer = ($this->primerNota() == $registro['id'])? '<i class="text-info text-end" data-feather="star" width="20"></i>': '';
        $fecha_hora = (new \DateTime(datetime: $registro['fecha_hora']))->format('d/m/Y h:i a');

            $result .= '<tr onclick="DetalleNota('.$registro['id'].')">
                <td class="text-center">'.$registro['id'].'</td>
                <td>'.$fecha_hora.' '.$primer.'</td>
            </tr>';
        endforeach;
        $result .= '</tbody>
        </table>';

        return $result;
    }
    public function insertNotaSubsecuente($data){

        $model = new ClinicaModel();
        
        $sql_nota = "INSERT INTO nota_subsecuente (
            id_paciente,
            contenido,
            codigo_referencia
        ) VALUES (
            :id_paciente,
            :contenido,
            :codigo_referencia
        )";

        $stmt = $this->bd->prepare($sql_nota);         

            $datos = [
            ':id_paciente' => $data['idPaciente'],
            ':contenido' => $data['contenidoNota'],
            ':codigo_referencia' => $data['referencia']
            ];
        
            if ($stmt->execute($datos)) {
            
                $idNota = $this->bd->lastInsertId();
                $receta = $model->insertPacienteReceta($data);
                $idReceta = $receta['mensaje'];
            
                return array('resultado' => 200,'mensaje' => array('idNota' => $idNota, 'idReceta' => $idReceta));

            } else {
                return array('resultado' => 401,'mensaje' => '¡Error al agregar nueva nota subsecuente a la lista!');
            }
            

    }

    public function ultimaNota($idPaciente){

        $result = '';
 
        $sql = "SELECT id FROM nota_subsecuente WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        $idNota = isset($data['id']) && !empty($data['id']) ? $data['id'] : 0;
        $result .= $this->getNotaSubsecuente($idNota);
               
        return $result;        

    }

    public function getNotaSubsecuente($idNota){

        $model = new RecetaModel();
        $result = '';
 
        $sql = "SELECT id_paciente, fecha_hora, contenido, codigo_referencia FROM nota_subsecuente WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idNota]);
        
        if($data = $stmt->fetch(\PDO::FETCH_ASSOC)){

            $idPaciente = $data['id_paciente'];
            $referencia = $data['codigo_referencia'];

            $idReceta = $model->idRecetaReferencia($idPaciente,$referencia);

            $fecha = (new \DateTime($data['fecha_hora']))->format('d/m/Y');
            $hora = (new \DateTime($data['fecha_hora']))->format('h:i a');

            $result .= '
            <div><label class="text-primary"><small>Fecha:</small></label> <label class="fs-5"> '.$fecha.'</label>, <label class="text-primary"><small>Hora:</small></label> <label class="fs-5">'.$hora.'</label></div>

            <label class="text-primary mt-3"><small>Nota:</small></label>
            <div class="fs-5">'.$data['contenido'].'</div>
            
            <hr>
            
            <div>
            <h5>Receta:</h5>
            '.$model->getReceta($idReceta,false).'</div>

            <hr>

            <div>
            <h5>Laboratorio:</h5>
            '.$this->mostrarTablaLaboratorio($idPaciente,$referencia).'</div>

            ';

        }else{

            $result = '<div class="text-center p-4 text-light">No se encontró información.</div>';

        }
                      
        return $result;

    }

    public function mostrarTablaLaboratorio($idPaciente,$referencia){

        $result = '';

        $qry_referencia = ($referencia == 0)? ' id_paciente = "'.$idPaciente.'"' : ' id_paciente = "'.$idPaciente.'" AND codigo_referencia = "'.$referencia.'" ';
        $query = $this->bd->query("SELECT * FROM laboratorio WHERE $qry_referencia ORDER BY fecha_hora DESC");
        $registros = $query->fetchAll(\PDO::FETCH_ASSOC);

        $result .= '<table class="table table-sm table-striped table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Descripción</th>
                <th></th>
            </tr>
        </thead>
        <tbody>';
        if (!empty($registros)) {
           foreach ($registros as $data_laboratorio):

            $fecha_hora = (new \DateTime(datetime: $data_laboratorio['fecha_hora']))->format('d/m/Y h:i a');

            $result .= '<tr>
                <td>'.$fecha_hora.'</td>
                <td>'.$data_laboratorio['descripcion'].'</td>
                <td class="text-center"><a download="'.$data_laboratorio['nombre'].'" href="/storage/public/'.$data_laboratorio['ruta'].'/'.$data_laboratorio['nombre'].'" class="btn btn-sm icon btn-primary"><i data-feather="download"></i></a></td>
            </tr>';
            endforeach;  
        }else{
            $result .= '<tr><td colspan="3" class="text-center text-light">No se encontro información</td></tr>';
        }
    $result .= '</tbody>
    </table>';
    
    return $result;
    }

}