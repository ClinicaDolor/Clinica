<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\ClinicaModel;
use App\Helpers\Sidebar;
use App\Controllers\SidebarController;

class HomeController extends BaseController{

    public function __construct(){

    }

    public function index(){
        $data = ['title' => 'Tratamientos del dolor y cuidados paleativos'];
        $this->view('/home/index.php', $data);
    }
    
    public function indexClinica(){

        $authMiddleware = new AuthMiddleware('clinica');
        $model = new ClinicaModel();
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();

        $result = $authMiddleware->authPermisos();
        $countPacientes = $model->countPacientes();
        
        $sidebarController->configureSidebar('DOCTOR', 'clinica', $sidebar);
        $sidebar->setActivarItem('Inicio');
        $sidebarHtml = $sidebar->render();

        $data = ['title' => 'Clinica', 'datos' => $result,  'total_pacientes' => $countPacientes, 'sidebar' => $sidebarHtml];
        $this->view('/clinica/index.php', $data);
       
    }

    public function indexPaciente(){

        $authMiddleware = new AuthMiddleware('historia-clinica');
        $sidebar = new Sidebar();
        $sidebarController = new SidebarController();
        $result = $authMiddleware->authPermisos();

        $sidebarController->configureSidebar('PACIENTE', 'historia-clinica', $sidebar);
        $sidebar->setActivarItem('Inicio');
        $sidebarHtml = $sidebar->render();

        $data = ['title' => 'Clinica', 'datos' => $result, 'sidebar' => $sidebarHtml];
        $this->view('/paciente/index.php', $data);
    }

}