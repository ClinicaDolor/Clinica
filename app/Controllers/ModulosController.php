<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\AntecedenteFamiliarModel;
use App\Models\PacienteModulosModelo;
use App\Models\PacienteModel;
use App\Helpers\Sidebar;
use App\Controllers\SidebarController;
use App\Core\HttpMethod;

class ModulosController extends BaseController {

    public function __construct(){

    }

    public function moduloPaciente($modulo, $idPaciente): void {
        
    $authMiddleware = new AuthMiddleware('historia-clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();
    $authMiddleware = $authMiddleware->authPermisos();
 
    $paciente = new PacienteModel($idPaciente);

    $sidebarController->configureSidebar('PACIENTE', $modulo, $sidebar, $idPaciente);
    
    $elementoModulo = "";
    if($modulo == "antecedentes-familiares"){
    $elementoModulo = "Antecedentes familiares";
    }
    
    $sidebar->setActivarItem($elementoModulo);
    $sidebarHtml = $sidebar->render();

    $data = ['title' => $elementoModulo, 
    'idPaciente' => $idPaciente, 
    'nombre' => $paciente->getNombreCompleto(), 
    'sidebar' => $sidebarHtml
    ];

    $this->view("/historia-clinica/$modulo.php", $data);
    }

 
    //---------- 1. ANTECEDENTES FAMILIARES ----------
    public function pacienteInsertEnfermedad(){

    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }

    $model = new AntecedenteFamiliarModel();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->agregarEnfermedadPaciente($data);

    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }

    }


    public function pacienteEditEnfermedad(){

    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new AntecedenteFamiliarModel();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->editarEnfermedadPaciente($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }
    
    
    public function pacienteDeleteEnfermedad(){

    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
    
    $model = new AntecedenteFamiliarModel();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->eliminarEnfermedadPaciente($data);
    
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
    
    }
   

    //---------- COMENTARIOS MODULO ----------
    public function pacienteComentarioModulo(){

    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
        
    $model = new PacienteModulosModelo();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->agregarComentariosModulo($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }

    }


    public function pacienteDeleteComentario(){
    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
            
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new PacienteModulosModelo();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->eliminarComentariosModulo($data);
            
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    } 

    }


    //---------- FINALIZAR MODULO ----------
    public function pacienteFinalizarModulo(){
    $authMiddleware = new AuthMiddleware('historia-clinica');
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
                
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
                
    $model = new PacienteModulosModelo();
    $data = json_decode(file_get_contents('php://input'), true);
    $resultModel = $model->finalizarModulos($data);
                
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    } 
    
    }

}
