<?php
namespace App\Controllers;
use App\Middleware\AuthMiddleware;
use App\Helpers\Sidebar;
use App\Models\RecetaModel;
use App\Models\PacienteModel;
use App\Helpers\CalculadoraEdad;

class RecetaController extends BaseController{

    public function receta($idReceta){

        $authMiddleware = new AuthMiddleware('clinica');
        $sidebar = new Sidebar();
        $modelNota = new RecetaModel();

        $authMiddleware->authPermisos();
        $modelNota->receta($idReceta);
        
        $paciente = new PacienteModel($modelNota->getIdPaciente());

        $fechaAlta = $paciente->getFechaAlta();
        $nombreCompleto = $paciente->getNombreCompleto();
        $fechaNacimiento = $paciente->getFechaNacimiento();
        $sexo = $paciente->getSexo();
        $estado_civil = $paciente->getEstadoCivil();
        $curp = $paciente->getCurp();

        $email = $paciente->getEmail();
        $telefono = $paciente->getTelefono();
        $celular = $paciente->getCelular();

        $edad = CalculadoraEdad::calcularEdad($fechaNacimiento);        

        $motivo_atencion = $paciente->getMotivoAtencion();

        $sidebar->addItemList('Inicio', '/clinica', 'home');
        $sidebar->addItemList('Receta', '/clinica/receta/'.$idReceta, 'file-text');
        $sidebar->setActivarItem('Receta');
        $sidebarHtml = $sidebar->render();


        $data = ['title' => 'Receta', 

        'fecha_hora_nota' => $modelNota->getFechaHora(),
        'contenido_nota' => $modelNota->getContenido(),

        'fecha_alta' => $fechaAlta, 
        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp,          
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,  

        'sidebar' => $sidebarHtml];
        $this->view('/clinica/receta.php', $data);

    }

}