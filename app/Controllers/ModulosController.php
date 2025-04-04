<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\AntecedenteFamiliarModel;
use App\Models\AntecedentesNoPatologicosModel;
use App\Models\AntecedentesQuirurgicos;
use App\Models\AntecedentesPatologicosModel;
use App\Models\ProcedimientosDolorModel;
use App\Models\PacienteModulosModelo;
use App\Models\PacienteModel;
use App\Helpers\Sidebar;
use App\Controllers\SidebarController;
use App\Core\HttpMethod;

class ModulosController extends BaseController {

    public function __construct(){

    }

    
    private function nombreModulo($modulo){
    $elementoModulo = "";
    if($modulo == "ficha-identificiacion"){
    $elementoModulo = "Ficha de identificación del paciente";
    
    }else if($modulo == "antecedentes-familiares"){
    $elementoModulo = "Antecedentes familiares";
       
    }else if($modulo == "antecedentes-personales-no-patologicos"){
    $elementoModulo = "Antecedentes Personales no patológicos";
       
    }else if($modulo == "antecedentes-personales-quirurgicos"){
    $elementoModulo = "Antecedentes Personales Quirúrgicos";
       
    }else if($modulo == "antecedentes-personales-patologicos"){
    $elementoModulo = "Antecedentes Personales Patológicos";
       
    }else if($modulo == "medicacion-actual"){
    $elementoModulo = "Medicación Actual";
       
    }else if($modulo == "medicacion-control-dolor"){
    $elementoModulo = "Medicamentos que ha utilizado para controlar el dolor";
       
    }else if($modulo == "procedimientos-control-dolor"){
    $elementoModulo = "Procedimientos que ha utilizado para controlar el dolor";
    
    }else if($modulo == "evaluacion-dolor"){
    $elementoModulo = "Evaluación del dolor";
    }

    return $elementoModulo;
    }


    //---------- VISTA DEL DOCTOR ----------
    public function moduloVistaDoctor($modulo, $idPaciente): void {
         
    $authMiddleware = new AuthMiddleware('clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();
    $authMiddleware = $authMiddleware->authPermisos();
    $rolUsuario = $authMiddleware['rol'];
    
    $paciente = new PacienteModel($idPaciente);
    
    $sidebarController->configureSidebar('DOCTOR', $modulo, $sidebar, $idPaciente);
    $elementoModulo = $this->nombreModulo($modulo);
    
    $sidebar->setActivarItem($elementoModulo);
    $sidebarHtml = $sidebar->render();
    
    $data = ['title' => $elementoModulo, 
    'idPaciente' => $idPaciente, 
    'nombre' => $paciente->getNombreCompleto(), 
    'idRol' => $rolUsuario, 
    'sidebar' => $sidebarHtml
    ];
    
    $this->view("/historia-clinica-doctor/$modulo.php", $data);
    }

    //---------- VISTA DEL PACIENTE ----------
    public function moduloVistaPaciente($modulo, $idPaciente): void {
    $authMiddleware = new AuthMiddleware('historia-clinica');
    $sidebar = new Sidebar();
    $sidebarController = new SidebarController();
    $authMiddleware = $authMiddleware->authPermisos();
    $rolUsuario = $authMiddleware['rol'];

    $paciente = new PacienteModel($idPaciente);

    $sidebarController->configureSidebar('PACIENTE', $modulo, $sidebar, $idPaciente);
    $elementoModulo = $this->nombreModulo($modulo);

    $sidebar->setActivarItem($elementoModulo);
    $sidebarHtml = $sidebar->render();

    $data = ['title' => $elementoModulo, 
    'idPaciente' => $idPaciente, 
    'nombre' => $paciente->getNombreCompleto(), 
    'idRol' => $rolUsuario, 
    'sidebar' => $sidebarHtml
    ];

    $this->view("/historia-clinica-paciente/$modulo.php", $data);
    }

 
    //---------- 2. ANTECEDENTES FAMILIARES ----------
    public function pacienteInsertEnfermedad(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
    
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }

    $model = new AntecedenteFamiliarModel();
    $resultModel = $model->agregarEnfermedadPaciente($data);

    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }

    }

    public function pacienteEditEnfermedad(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
            
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new AntecedenteFamiliarModel();
    $resultModel = $model->editarEnfermedadPaciente($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }
    
    public function pacienteDeleteEnfermedad(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
        
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
    
    $model = new AntecedenteFamiliarModel();
    $resultModel = $model->eliminarEnfermedadPaciente($data);
    
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
    
    }

   //----- 3. ANTECEDENTES NO PATOLOGICOS ----------
   public function pacienteEditarCuestionarioM3(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
            
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new AntecedentesNoPatologicosModel();
    $resultModel = $model->editarCuestionarioModulo($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }
    
    //---------- 4. ANTECEDENTES PERSONALES QUIRURGICOS ----------
    public function pacienteInsertCirugia(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                            
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
    
    $model = new AntecedentesQuirurgicos();
    $resultModel = $model->agregarCirugiaPaciente($data);
    
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
    
    }

    public function pacienteEditCirugia(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                        
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
            
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new AntecedentesQuirurgicos();
    $resultModel = $model->editarCirugiaPaciente($data);
            
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }
 
    public function pacienteDeleteCirugia(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                    
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
        
    $model = new AntecedentesQuirurgicos();
    $resultModel = $model->eliminarCirugiaPaciente($data);
        
     if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
        
    }

    
   //----- 3. ANTECEDENTES NO PATOLOGICOS ----------
   public function pacienteEditarCuestionarioV1M5(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
            
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new AntecedentesPatologicosModel();
    $resultModel = $model->editarCuestionarioV1Modulo($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }




    //---------- 8. PROCEFIMIENTOS PARA CONTROLAR EL DOLOR ----------
    public function pacienteInsertProcedimientos(){

    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                    
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
          
    $model = new ProcedimientosDolorModel();
    $resultModel = $model->agregarProcedimientosPaciente($data);
        
     if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
       
    }

    
    public function pacienteEditProcedimiento(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                            
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
                
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
                
    $model = new ProcedimientosDolorModel();
    $resultModel = $model->editarProcedimientoPaciente($data);
                
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
                
    }

    public function pacienteDeleteProcedimiento(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                        
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
            
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }

    $model = new ProcedimientosDolorModel();
    $resultModel = $model->eliminarProcedimientoPaciente($data);
            
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
            
    }

    

    public function pacienteEditTratamiento(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                                
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
                    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
                    
    $model = new ProcedimientosDolorModel();
    $resultModel = $model->editarTratamientoPaciente($data);
                    
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }
                    
    }

    //---------- COMENTARIOS MODULO ----------
    public function pacienteComentarioModulo(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
        
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
        
    $model = new PacienteModulosModelo();
    $resultModel = $model->agregarComentariosModulo($data);
        
    if ($resultModel['resultado'] == 200) {
    echo HttpMethod::jsonResponse(200,true,$resultModel['mensaje']);
    } else {
    echo HttpMethod::jsonResponse(401, false, $resultModel['mensaje']);
    }

    }


    public function pacienteDeleteComentario(){
    $data = json_decode(file_get_contents('php://input'), true);
    $idRol = $data['idRol'];  // Obtener el idRol
    $idRol == "Paciente" ? $view = "historia-clinica" : $view = "clinica";
                
    $authMiddleware = new AuthMiddleware($view);
    $authMiddleware->authPermisos();
    header('Content-Type: application/json');
            
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo HttpMethod::jsonResponse(405, false, "Método no permitido. Usa POST.");
    return;
    }
            
    $model = new PacienteModulosModelo();
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
