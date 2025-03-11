<?php
namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\ClinicaModel;
use App\Helpers\Sidebar;

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
        
        $result = $authMiddleware->authPermisos();
        $countPacientes = $model->countPacientes();

        $sidebar->addItemList('Inicio', '', 'home');
        $sidebar->addItemList('Pacientes', 'clinica/pacientes', 'users');
        $sidebar->addItemList('Clinica', 'clinica/info', 'zap');
        $sidebar->setActivarItem('Inicio');
        $sidebarHtml = $sidebar->render();

        $data = ['title' => 'Clinica', 'datos' => $result,  'total_pacientes' => $countPacientes, 'sidebar' => $sidebarHtml];
        $this->view('/clinica/index.php', $data);
       
    }

    public function indexPaciente(){

        $authMiddleware = new AuthMiddleware('historia-clinica');
        $result = $authMiddleware->authPermisos();

        $data = ['title' => 'Clinica', 'datos' => $result];
        $this->view('/paciente/index.php', $data);
    }

}