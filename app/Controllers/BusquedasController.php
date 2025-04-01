<?php
namespace App\Controllers;

use App\Models\BusquedasModel;
use App\Models\RecetaModel;
use App\Models\NotaSubsecuenteModel;
use App\Models\LaboratorioModel;
//--------- MODULOS ----------
use App\Models\AntecedenteFamiliarModel;
use App\Models\AntecedentesNoPatologicosModel;

use App\Models\PacienteModulosModelo;

class BusquedasController{

    public function buscarPacientes(){

        $query = $_GET['query'] ?? '';
        $model = new BusquedasModel();
        $suggestions = $model->getPacientes($query);
        header('Content-Type: application/json');
        echo json_encode($suggestions);

    }

    public function buscarReceta($idReceta){
        
        $model = new RecetaModel();
        echo $model->getReceta($idReceta);

    }

    public function buscarNotaSubsecuente($idNota){

        $model = new NotaSubsecuenteModel();
        echo $model->getNotaSubsecuente($idNota);

    }

    public function buscarLaboratorio($idLaboratorio){

        $model = new LaboratorioModel();
        echo $model->getLaboratorio($idLaboratorio);

    }

    public function tableRecetas($idPaciente){

        $model = new RecetaModel();
        echo $model->mostrarTablaRecetas($idPaciente);

    }

    public function tableLaboratorio($idPaciente,$referencia){

        $model = new LaboratorioModel();
        echo $model->mostrarTablaLaboratorio($idPaciente,$referencia);

    }

    public function tableNotasSubsecuentes($idPaciente,$referencia){
        $model = new NotaSubsecuenteModel();
        echo $model->mostrarTablaNotas($idPaciente,$referencia);
    }

    //---------- CONTENIDO DE LOS MODULOS ----------
    public function contenidoPreguntasM2($idPaciente,$idRol){
        $model = new AntecedenteFamiliarModel();
        echo $model->mostrarPreguntasM2($idPaciente,$idRol);
    }

    public function contenidoPreguntasM3($idPaciente,$idRol,$idCuestionario){
        $model = new AntecedentesNoPatologicosModel();
        echo $model->mostrarPreguntasM3($idPaciente,$idRol,$idCuestionario);
    }

    //---------- CONTENIDO COMENTARIOS ----------
    public function contenidoComentariosModulo($idPaciente,$idRol,$idModulo){
        $model = new PacienteModulosModelo();
        echo $model->mostrarComentariosModulo($idPaciente,$idRol,$idModulo);
    }


}