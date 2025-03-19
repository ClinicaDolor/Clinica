<?php

namespace App\Models;

use App\Config\Database;

class RecetaModel{

    private $bd;
    private $fecha;
    private $hora;
    private $id_paciente;
    private $diagnostico;
    private $medicamento;
    public function __construct(){

        $this->bd = Database::getInstance();

    }

    public function receta($idReceta){

        $query = "SELECT * FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($query);
        $stmt->bindParam(':id', $idReceta);
        $stmt->execute();
        $registros = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->fecha = (new \DateTime($registros['fecha_hora']))->format('d/m/Y');
        $this->hora = (new \DateTime($registros['fecha_hora']))->format('h:i a');

        $this->id_paciente = $registros['id_paciente'];
        $this->diagnostico = $registros['diagnostico'];
        $this->medicamento = $registros['medicamento'];

    
    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function getIdPaciente()
    {
        return $this->id_paciente;
    }

    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    public function getMedicamento()
    {
        return $this->medicamento;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------

    public function mostrarTablaRecetas($idPaciente){
        $result = '';
        $stmt = $this->bd->query("SELECT * FROM receta_medica WHERE id_paciente = '".$idPaciente."' ORDER BY fecha_hora DESC");
        $registros = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $result .= '<table class="table table-striped table-hover table-sm pb-0 mb-0" id="tableRecetas">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($registros as $registro):

            $fecha_hora = (new \DateTime(datetime: $registro['fecha_hora']))->format('d/m/Y h:i a');

            $result .= '<tr onclick="DetalleReceta('.$registro['id'].')">
                        <td class="text-center">'.$registro['id'].'</td>
                        <td>'.$fecha_hora.'</td>
                        </tr>';

        endforeach;

        $result .= '</tbody>
        </table>';
    
    return $result;
    }

    public function ultimaReceta($idPaciente){

        $result = '';
 
        $sql = "SELECT id, fecha_hora, diagnostico, medicamento FROM receta_medica WHERE id_paciente = :id ORDER BY id DESC LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idPaciente]);
 
        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha = (new \DateTime($data['fecha_hora']))->format('d/m/Y');
            $hora = (new \DateTime($data['fecha_hora']))->format('h:i a');
            $result .= '
            <div class="float-end"><a target="_blank" href="/pdf/receta/'.$data['id'].'" class="btn icon btn-primary"><i data-feather="printer"></i></a></div>
            <div><small class="text-primary">Fecha: </small> <label class="fs-5">' . $fecha . '</label>, <small class="text-primary">Hora: </small> <label class="fs-5">' . $hora . '</label></div>
            <div class="mt-3"><small class="text-primary">Diagnostico:</small> <label class="fs-5">' . $data['diagnostico'] . '</label></div>

            <label class="mt-3"><small class="text-primary">Medicamento: </small></label>
            <div class="fs-5">'.$data['medicamento'].'</div>';
            
        } else {
            $result = '<div class="text-center p-4 text-primary">No se encontró información.</div>';
        }
       
        return $result;

    }

    public function getReceta($idReceta){
        $result = '';
 
        $sql = "SELECT id, fecha_hora, diagnostico, medicamento FROM receta_medica WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->execute([':id' => $idReceta]);  

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $fecha = (new \DateTime($data['fecha_hora']))->format('d/m/Y');
            $hora = (new \DateTime($data['fecha_hora']))->format('h:i a');
            $result .= '
            <div class="float-end"><a target="_blank" href="/pdf/receta/'.$data['id'].'" class="btn icon btn-primary"><i data-feather="printer"></i></a></div>
            <div><small class="text-primary">Fecha: </small> <label class="fs-5">' . $fecha . '</label>, <small class="text-primary">Hora: </small> <label class="fs-5">' . $hora . '</label></div>
            <div class="mt-3"><small class="text-primary">Diagnostico:</small> <label class="fs-5">' . $data['diagnostico'] . '</label></div>

            <label class="mt-3"><small class="text-primary">Medicamento: </small></label>
            <div class="fs-5">'.$data['medicamento'].'</div>';
            
        } else {
            $result = '<div class="text-center p-4 text-primary">No se encontró información.</div>';
        }
       
        return $result;
    }


}