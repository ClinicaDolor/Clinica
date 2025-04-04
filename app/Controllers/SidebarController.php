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
    'perfil' => ['titulo' => 'Perfil', 'url' => SERVIDOR . 'clinica/perfil', 'icono' => 'user'],
    'logout' => ['titulo' => 'Cerrar Sesión', 'url' => SERVIDOR . 'cerrar-sesion', 'icono' => 'log-out']
    ];

        
    //----- Listado de elementos segun el rol y su vista ----- 
    $viewRolElements = [

    'DOCTOR' => [
    'clinica' => [
    ['titulo' => 'Pacientes', 'url' => SERVIDOR . 'clinica/pacientes', 'icono' => 'users']
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
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'folder'],
    ['titulo' => 'Paciente Recetas', 'url' => SERVIDOR . 'clinica/receta/paciente/'.$id, 'icono' => 'file-text']
    ],
    
    'clinica-paciente-notas' => [
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'folder'],
    ['titulo' => 'Paciente Notas', 'url' => SERVIDOR . 'clinica/nota-subsecuente/paciente/'.$id.'/referencia/'.$referencia, 'icono' => 'file-text']
    ],

    'clinica-paciente-laboratorio' => [
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$id, 'icono' => 'folder'],
    ['titulo' => 'Paciente Laboratorio', 'url' => SERVIDOR . 'clinica/laboratorio/paciente/'.$id, 'icono' => 'file-text']
    ],

    'clinica-paciente-pin' => [
    ['titulo' => 'Paciente Pin', 'url' => SERVIDOR . 'clinica/paciente/pin/'.$id, 'icono' => 'users']
    ],
 
    'clinica-receta' => [
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$referencia, 'icono' => 'folder'],
    ['titulo' => 'Receta', 'url' => SERVIDOR . 'clinica/receta/'.$id, 'icono' => 'file-text']
    ],

    'clinica-laboratorio' => [
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$referencia, 'icono' => 'folder'],
    ['titulo' => 'Laboratorio', 'url' => SERVIDOR . 'clinica/laboratorio/'.$id, 'icono' => 'file-text']
    ],

    'nota-subsecuente' => [
    ['titulo' => 'Expediente', 'url' => SERVIDOR . 'clinica/paciente/'.$referencia, 'icono' => 'folder'],
    ['titulo' => 'Nota Subsecuente', 'url' => SERVIDOR . 'clinica/nota-subsecuente/'.$id, 'icono' => 'file-text']
    ],

    //---------- MODULOS DE HISTORIA CLINICA ----------
   'antecedentes-familiares' => [
    ['titulo' => 'Antecedentes familiares', 'url' => SERVIDOR . 'clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],


    'antecedentes-personales-no-patologicos' => [
    ['titulo' => 'Antecedentes personales no patologicos', 'url' => SERVIDOR . 'clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],

    'perfil' => [
    ['titulo' => 'Paciente', 'url' => SERVIDOR . 'clinica/pacientes', 'icono' => 'users']
    ],

    'antecedentes-personales-quirurgicos' => [
    ['titulo' => 'Antecedentes Personales Quirúrgicos', 'url' => SERVIDOR . 'clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],

    'procedimientos-control-dolor' => [
    ['titulo' => 'Procedimientos que ha utilizado para controlar el dolor', 'url' => SERVIDOR . 'clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ]

    ],

    'PACIENTE' => [
    'historia-clinica' => [],

    'antecedentes-familiares' => [
    ['titulo' => 'Antecedentes familiares', 'url' => SERVIDOR . 'historia-clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],

    'antecedentes-personales-no-patologicos' => [
    ['titulo' => 'Antecedentes personales no patologicos', 'url' => SERVIDOR . 'historia-clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],

    'antecedentes-personales-quirurgicos' => [
    ['titulo' => 'Antecedentes Personales Quirúrgicos', 'url' => SERVIDOR . 'historia-clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ],

    'procedimientos-control-dolor' => [
    ['titulo' => 'Procedimientos que ha utilizado para controlar el dolor', 'url' => SERVIDOR . 'historia-clinica/'.$view.'/paciente/'.$id, 'icono' => 'file-text']
    ]
    
    
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
