<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\ClinicaModel;
use App\Models\PacienteModel;
use App\Helpers\Sidebar;
use App\Core\HttpMethod;
use App\Helpers\CalculadoraEdad;
use App\Models\NotaSubsecuenteModel;
use App\Controllers\SidebarController;
use App\Models\LaboratorioModel;
use App\Models\RecetaModel;

class ClinicaController extends BaseController{

    public function pacientesIndex(){
    $authMiddleware = new AuthMiddleware('clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();

    $authMiddleware->authPermisos();

    $sidebarController->configureSidebar('DOCTOR', 'clinica', $sidebar);
    $sidebar->setActivarItem('Pacientes');
    $sidebarHtml = $sidebar->render();

    $data = ['title' => 'Pacientes', 'sidebar' => $sidebarHtml];
    $this->view('/clinica/pacientes.php', $data);
    }

    public function pacientesModulos($idPaciente){

    $authMiddleware = new AuthMiddleware('clinica');
    $paciente = new PacienteModel($idPaciente);
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();

    $authMiddleware->authPermisos();        
    $nombreCompleto = $paciente->getNombreCompleto();

    $sidebarController->configureSidebar('DOCTOR', 'clinica-modulos-paciente', $sidebar, $idPaciente);
    $sidebar->setActivarItem('Historia Clinica');
    $sidebarHtml = $sidebar->render();
        
    $data = ['title' => 'Historia Clinica', 'id_paciente' => $idPaciente, 'nombre_paciente' => $nombreCompleto, 'sidebar' => $sidebarHtml];
    $this->view('/clinica/pacientes-modulos.php', $data);
    }

    public function pacienteNuevo($idPaciente = 0){ 
    $authMiddleware = new AuthMiddleware('clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();

    $authMiddleware->authPermisos();

    $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-nuevo', $sidebar, $idPaciente);
    $sidebar->setActivarItem('Paciente Nuevo');
    $sidebarHtml = $sidebar->render();
  
    $data = ['title' => 'Paciente Nuevo', 'titulo_boton' => 'Guardar Paciente', 'idPaciente' => $idPaciente, 'sidebar' => $sidebarHtml];
    $this->view('/clinica/paciente-nuevo-editar.php', $data);
    }

    public function pacienteEditar($idPaciente){

    $authMiddleware = new AuthMiddleware('clinica');
    $sidebar = new Sidebar();
    $paciente = new PacienteModel($idPaciente);
    $sidebarController = new SidebarController();

    $authMiddleware->authPermisos();

        $nombreCompleto = $paciente->getNombreCompleto();
        $edad = $paciente->getEdad();
        $fechaNacimiento = $paciente->getFechaNacimiento();
        $sexo = $paciente->getSexo();
        $estado_civil = $paciente->getEstadoCivil();
        $curp = $paciente->getCurp();
        $lugar_origen = $paciente->getLugarOrigen();
        $lugar_residencia = $paciente->getLugarResidencia();
        $ocupacion = $paciente->getOcupacion();
        $num_hijos = $paciente->getNumHijos();
        $edad_hijos = $paciente->getEdadHijos();
        $quien_recomienda = $paciente->getRecomienda();
        $redes_sociales = $paciente->getRedesSociales();
        $motivo_atencion = $paciente->getMotivoAtencion();
        $calle = $paciente->getCalle();
        $num_interior = $paciente->getNumInterior();
        $num_exterior = $paciente->getNumExterior();
        $colonia = $paciente->getColonia();
        $delegacion = $paciente->getDelegacion();
        $cp = $paciente->getCp();
        $municipio = $paciente->getMunicipio();
        $distancia = $paciente->getDistancia();
        $email = $paciente->getEmail();
        $telefono = $paciente->getTelefono();
        $celular = $paciente->getCelular();
        $cuidador = $paciente->getCuidador();
        $cuidador_telefono = $paciente->getCuidadorTelefono();
        $res_nombre = $paciente->getResNombre();
        $res_telefono = $paciente->getResTelefono();
      

        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-editar', $sidebar, $idPaciente);
        $sidebar->setActivarItem('Paciente Editar');
        $sidebarHtml = $sidebar->render();
       
        $data = ['title' => 'Paciente Editar', 
        'titulo_boton' => 'Editar Paciente',
        'idPaciente' => $idPaciente, 

        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp,  
        'lugar_origen' => $lugar_origen,
        'lugar_residencia' => $lugar_residencia,
        'ocupacion' => $ocupacion,
        'num_hijos' => $num_hijos,
        'edad_hijos' => $edad_hijos,
        'quien_recomienda' => $quien_recomienda,
        'redes_sociales' => $redes_sociales,
        'motivo_atencion' => $motivo_atencion,
        'calle' => $calle,
        'num_interior' => $num_interior,
        'num_exterior' => $num_exterior,
        'colonia' => $colonia,
        'delegacion' => $delegacion,
        'cp' => $cp,
        'municipio' => $municipio,
        'distancia' => $distancia,
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,  
        'cuidador' => $cuidador,  
        'cuidador_telefono' => $cuidador_telefono,  
        'res_nombre' => $res_nombre, 
        'res_telefono' => $res_telefono,  
        
        'sidebar' => $sidebarHtml];
        $this->view('/clinica/paciente-nuevo-editar.php', $data);

    }

    public function pacienteInsertEdit(){

        $authMiddleware = new AuthMiddleware('clinica');
        $result = $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        $model = new ClinicaModel();
        $data = json_decode(file_get_contents('php://input'), true);

        if($data['idPaciente'] == 0){

            $resultModelo = $model->insertPaciente($data,$result);

            if ($resultModelo['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200,true,$resultModelo['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModelo['mensaje']);
            }

        }else{

            $resultModelo = $model->editPaciente($data);

            if ($resultModelo['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200,true,$resultModelo['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModelo['mensaje']);
            }

        }        
        
    }

    public function pacienteDetalle($idPaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idPaciente);
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();

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

        $motivo_atencion = $paciente->getMotivoAtencion();

        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-detalle', $sidebar, $idPaciente);
        $sidebar->setActivarItem('Paciente');
        $sidebarHtml = $sidebar->render();

        $referencia = uniqid('', true);
        
        $data = ['title' => 'Expediente', 
        'idPaciente' => $idPaciente,
        'fecha_alta' => $fechaAlta, 
        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp, 
        'motivo_atencion' => $motivo_atencion,  
        
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,  
        'referencia' => $referencia,  

        'sidebar' => $sidebarHtml];

        if (is_null($fechaAlta)) {
            $this->view('/errors/404.php');
        }else{
            $this->view('/clinica/pacientes-detalle.php', $data);
        }

    }

    public function pacientePin($idPaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idPaciente);
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();

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

        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-pin', $sidebar, $idPaciente);
        $sidebar->setActivarItem('Paciente Pin');
        $sidebarHtml = $sidebar->render();


        $data = ['title' => 'Paciente Pin', 
        'idPaciente' => $idPaciente,
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
        $this->view('/clinica/paciente-pin.php', $data);

    }

    public function pacienteInsertPin(){

        $authMiddleware = new AuthMiddleware('clinica');
        $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        $model = new ClinicaModel();
        $data = json_decode(file_get_contents('php://input'), true);
        $resultModel = $model->insertPacientePin($data);

            if ($resultModel['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
            }

    }

    public function pacienteReceta($idPaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idPaciente);
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();

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

        $motivo_atencion = $paciente->getMotivoAtencion();

        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-recetas', $sidebar, $idPaciente);
        $sidebar->setActivarItem('Paciente Recetas');
        $sidebarHtml = $sidebar->render();
        
        $data = ['title' => 'Recetas', 
        'idPaciente' => $idPaciente,
        'fecha_alta' => $fechaAlta, 
        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp, 
        'motivo_atencion' => $motivo_atencion,  
        
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,  

        'sidebar' => $sidebarHtml];
        $this->view('/clinica/pacientes-recetas.php', $data);

    }

    public function pacienteInsertReceta(){

        $authMiddleware = new AuthMiddleware('clinica');
        $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        $model = new ClinicaModel();
        $data = json_decode(file_get_contents('php://input'), true);
        $resultModel = $model->insertPacienteReceta($data);

            if ($resultModel['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
            }

    }

    public function pacienteNotaSubsecuente($idPaciente,$referencia){
        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idPaciente);
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();
        $nota = new NotaSubsecuenteModel();
        $id_nota_subsecuente = $nota->codigoReferencia($idPaciente, $referencia);
        $nota->NotaSubsecuente($id_nota_subsecuente);
        $receta = new RecetaModel();
        $idReceta = $receta->idRecetaReferencia($idPaciente,$referencia);
        $receta->receta($idReceta);

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

        $motivo_atencion = $paciente->getMotivoAtencion();
        
        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-notas', $sidebar, $idPaciente, $referencia);
        $sidebar->setActivarItem('Paciente Notas');
        $sidebarHtml = $sidebar->render();

        $title = ($id_nota_subsecuente == 0)? 'Nueva Nota Subsecuente' : 'Editar Nota Subsecuente';
                
        $data = ['title' => $title, 
        'idPaciente' => $idPaciente,
        'fecha_alta' => $fechaAlta, 
        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp, 
        'motivo_atencion' => $motivo_atencion,  
        
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular, 
        'referencia' => $referencia,
        'id_nota_subsecuente' => $id_nota_subsecuente,  

        'fecha_hora' => $nota->getFechaHora(),
        'ta' => $nota->getTa(),
        'frec_cardiaca' => $nota->getFrecCardiaca(),
        'pulso' => $nota->getPulso(),
        'spo2' => $nota->getSpo2(),
        'fio2' => $nota->getFio2(),
        'ecog' => $nota->getEcog(),
        'karnovsky' => $nota->getKarnovsky(),
        'peso' => $nota->getPeso(),
        'talla' => $nota->getTalla(),
        'contenido' => $nota->getContenido(),

        'idreceta' => $idReceta,
        'diagnostico' => $receta->getDiagnostico(),
        'medicamento' => $receta->getMedicamento(),
            
        'sidebar' => $sidebarHtml];
        $this->view('/clinica/pacientes-nota-subsecuente.php', $data);
    }

    public function pacienteInsertNotaSubsecuente(){
        $authMiddleware = new AuthMiddleware('clinica');
        $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        $model = new NotaSubsecuenteModel();
        $data = json_decode(file_get_contents('php://input'), true);

        if($data['idNota'] == 0){
            $resultModel = $model->insertNotaSubsecuente($data);
        }else{
            $resultModel = $model->editarNotaSubsecuente($data);   
        }
        

            if ($resultModel['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
            }
    }

    public function pacienteLaboratorio($idPaciente){

        $authMiddleware = new AuthMiddleware('clinica');
        $paciente = new PacienteModel($idPaciente);
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();

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

        $motivo_atencion = $paciente->getMotivoAtencion();

        $sidebarController->configureSidebar('DOCTOR', 'clinica-paciente-laboratorio', $sidebar, $idPaciente);
        $sidebar->setActivarItem('Paciente Laboratorio');
        $sidebarHtml = $sidebar->render();
        
        $data = ['title' => 'Laboratorio', 
        'idPaciente' => $idPaciente,
        'fecha_alta' => $fechaAlta, 
        'nombre_paciente' => $nombreCompleto, 
        'fecha_nacimiento' => $fechaNacimiento,
        'edad' => $edad,
        'sexo' => $sexo, 
        'estado_civil' => $estado_civil,
        'curp' => $curp, 
        'motivo_atencion' => $motivo_atencion,  
        
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,  

        'sidebar' => $sidebarHtml];
        $this->view('/clinica/pacientes-laboratorio.php', $data);

    }

    public function pacienteInsertLaboratorio(){

        $authMiddleware = new AuthMiddleware('clinica');
        $authMiddleware->authPermisos();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
            return;
        }

        if (isset($_FILES['file'])) {

            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];

            $fileParts = explode('.', $fileName);
            $fileExtension = strtolower(end($fileParts));

            $model = new LaboratorioModel();
            $resultModel = $model->insertArchivo($_POST['idPaciente'],$_POST['contenidoLaboratorio'],$fileName, $fileTmpName, $fileSize, $fileExtension,$_POST['referencia'],$_POST['titulo']);

            if ($resultModel['resultado'] == 200) {
                echo HttpMethod::jsonResponse(200, true,$resultModel['mensaje']);
            } else {
                echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
            }

        } else {
            echo HttpMethod::jsonResponse(200,true,'No se recibió ningún archivo');
        }

    }

    public function perfil(){

    $authMiddleware = new AuthMiddleware('clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();

    $permisos = $authMiddleware->authPermisos();
    $idClinica = $permisos['id_clinica'];

    $sidebarController->configureSidebar('DOCTOR', 'perfil', $sidebar);
    $sidebar->setActivarItem('Perfil');
    $sidebarHtml = $sidebar->render();
        
    $data = ['title' => 'Perfil', 'sidebar' => $sidebarHtml, 'idClinica' => $idClinica];
    $this->view('/clinica/perfil.php', $data);

    }

}