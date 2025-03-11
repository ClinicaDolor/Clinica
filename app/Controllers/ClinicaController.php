<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\ClinicaModel;
use App\Models\PacienteModel;
use App\Helpers\Sidebar;
use App\Core\HttpMethod;
use App\Helpers\CalculadoraEdad;

class ClinicaController extends BaseController{

    public function pacientesIndex(){

        $authMiddleware = new AuthMiddleware('clinica');
        $sidebar = new Sidebar();

        $authMiddleware->authPermisos();

        $sidebar->addItemList('Inicio', '/clinica', 'home');
        $sidebar->addItemList('Pacientes', 'clinica/pacientes', 'users');
        $sidebar->addItemList('Clinica', 'clinica/info', 'zap');
        $sidebar->setActivarItem('Pacientes');
        $sidebarHtml = $sidebar->render();


        $data = ['title' => 'Pacientes', 'sidebar' => $sidebarHtml];
        $this->view('/clinica/pacientes.php', $data);
    }

    public function pacientesModulos($idpaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idpaciente);
        $sidebar = new Sidebar();

        $authMiddleware->authPermisos();        
        $nombreCompleto = $paciente->getNombreCompleto();

        $sidebar->addItemList('Inicio', '/clinica', 'home');
        $sidebar->addItemList('Historia Clinica', '/clinica/modulos/paciente/'.$idpaciente, 'users');
        $sidebar->setActivarItem('Historia Clinica');
        $sidebarHtml = $sidebar->render();
        
        $data = ['title' => 'Historia Clinica', 'nombre_paciente' => $nombreCompleto, 'sidebar' => $sidebarHtml];
        $this->view('/clinica/pacientes-modulos.php', $data);
    }

    public function pacienteNuevo($idPaciente = 0){
        
        $authMiddleware = new AuthMiddleware('clinica');
        $sidebar = new Sidebar();

        $authMiddleware->authPermisos();

        $sidebar->addItemList('Inicio', '/clinica', 'home');
        $sidebar->addItemList('Paciente Nuevo', '/clinica/paciente/nuevo', 'users');
        $sidebar->setActivarItem('Paciente Nuevo');
        $sidebarHtml = $sidebar->render();


        $data = ['title' => 'Paciente Nuevo', 'idPaciente' => $idPaciente, 'sidebar' => $sidebarHtml];
        $this->view('/clinica/paciente-nuevo-editar.php', $data);

    }

    public function pacienteInsert(){

        $authMiddleware = new AuthMiddleware('clinica');
        $result = $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $model = new ClinicaModel();
        $result = $model->insertPaciente($data,$result);

        if ($result['resultado'] == 200) {
            echo HttpMethod::jsonResponse(200,true,$result['mensaje']);
        } else {
            echo HttpMethod::jsonResponse(401, false, $result['mensaje']);
        }
    }

    public function pacienteDetalle($idpaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idpaciente);
        $sidebar = new Sidebar();

        $authMiddleware->authPermisos();        
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
        

        $sidebar->addItemList('Inicio', '/clinica', 'home');
        $sidebar->addItemList('Paciente', '/clinica/paciente/'.$idpaciente, 'users');
        $sidebar->setActivarItem('Paciente');
        $sidebarHtml = $sidebar->render();
        
        $data = ['title' => 'Paciente', 
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
        $this->view('/clinica/pacientes-detalle.php', $data);
    }

}