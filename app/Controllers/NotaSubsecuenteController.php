<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Helpers\Sidebar;
use App\Models\NotaSubsecuenteModel;
use App\Models\PacienteModel;
use App\Helpers\CalculadoraEdad;

class NotaSubsecuenteController extends BaseController{

    public function notaSubsecuente($idNota){

        $authMiddleware = new AuthMiddleware('clinica');
        $sidebar = new Sidebar();
        $modelNota = new NotaSubsecuenteModel();

        $authMiddleware->authPermisos();
        $modelNota->NotaSubsecuente($idNota);
        
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
        $sidebar->addItemList('Nota Subsecuente', '/clinica/nota-subsecuente/'.$idNota, 'file-text');
        $sidebar->setActivarItem('Nota Subsecuente');
        $sidebarHtml = $sidebar->render();


        $data = ['title' => 'Nota Subsecuente', 

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
        $this->view('/clinica/nota-subsecuente.php', $data);

    }
}