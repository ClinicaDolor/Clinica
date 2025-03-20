<?php
namespace App\Controllers;

class SidebarController {

    public function __construct() {
        
    }

    public function configureSidebar($role, $view, $sidebar, $id = null, $referencia = null) {
        
    //----- Definir menu de inicio segun el rol -----
    $homeElements = [
    'DOCTOR' => ['titulo' => 'Inicio', 'url' => SERVIDOR . 'clinica', 'icono' => 'home'],
    'PACIENTE' => ['titulo' => 'Inicio', 'url' => SERVIDOR . 'historia-clinica', 'icono' => 'home']
    ];

    //----- Elementos que siempre estaran presentes -----
    $comunElements = [
    'perfil' => ['titulo' => 'Perfil', 'url' => '', 'icono' => 'user'],
    'logout' => ['titulo' => 'Cerrar Sesión', 'url' => SERVIDOR . 'cerrar-sesion', 'icono' => 'log-out']
    ];

        
    //----- Listado de elementos segun el rol y su vista ----- 
    $viewRolElements = [

    'DOCTOR' => [
    'clinica' => [
    ['titulo' => 'Pacientes', 'url' => SERVIDOR . 'clinica/pacientes', 'icono' => 'users'],
    ['titulo' => 'Clinica', 'url' => SERVIDOR .  'clinica/info', 'icono' => 'zap']
    ],
                
    'clinica-modulos-paciente' => [
    ['titulo' => 'Historia Clinica', 'url' => SERVIDOR . 'clinica/modulos/paciente/' . $id, 'icono' => 'users']
    ],

    'clinica-paciente-nuevo' => [
    ['titulo' => 'Paciente Nuevo', 'url' => SERVIDOR . 'clinica/paciente/nuevo', 'icono' => 'users']
    ],

    'clinica-paciente-editar' => [
    ['titulo' => 'Paciente Editar', 'url' => SERVIDOR . 'clinica/paciente/editar/'.$id, 'icono' => 'users']
    ],
    
    'clinica-paciente-detalle' => [
    ['titulo' => 'Paciente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'users']
    ],

    'clinica-paciente-recetas' => [
    ['titulo' => 'Paciente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'users'],
    ['titulo' => 'Paciente Recetas', 'url' => SERVIDOR . 'clinica/receta/paciente/'.$id, 'icono' => 'file-text']
    ],
    
    'clinica-paciente-notas' => [
    ['titulo' => 'Paciente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'users'],
    ['titulo' => 'Paciente Notas', 'url' => SERVIDOR . 'clinica/nota-subsecuente/paciente/'.$id.'/referencia/'.$referencia, 'icono' => 'file-text']
    ],

    'clinica-paciente-laboratorio' => [
    ['titulo' => 'Paciente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'users'],
    ['titulo' => 'Paciente Laboratorio', 'url' => SERVIDOR . 'clinica/laboratorio/paciente/'.$id, 'icono' => 'file-text']
    ],

    'clinica-paciente-pin' => [
    ['titulo' => 'Paciente Pin', 'url' => SERVIDOR . 'clinica/paciente/pin/'.$id, 'icono' => 'users']
    ],

    'clinica-receta' => [
    ['titulo' => 'Receta', 'url' => SERVIDOR . 'clinica/receta/'.$id, 'icono' => 'users']
    ],

    'clinica-laboratorio' => [
    ['titulo' => 'Laboratorio', 'url' => SERVIDOR . 'clinica/laboratorio/'.$id, 'icono' => 'users']
    ],

    'nota-subsecuente' => [
    ['titulo' => 'Nota Subsecuente', 'url' => SERVIDOR . 'clinica/nota-subsecuente/'.$id, 'icono' => 'users']
    ]

    ],

                
    'PACIENTE' => [
    'historia-clinica' => []
    ]

    ];

    //----- Configuracion de listado de elementos ----------
    $finalItems = array_merge(
    [$homeElements[$role]], // ----- Menu de Inicio de acuerdo al Rol
    $viewRolElements[$role][$view] ?? [], // Elementos específicos de la vista
    [
    $comunElements['perfil'], 
    $comunElements['logout']
    ]
    );
        

    // ----- Agregar los elementos al sidebar -----
    foreach ($finalItems as $item) {
    $sidebar->addItemList($item['titulo'], $item['url'], $item['icono']);
    }
    
}
}
