<?php

use FastRoute\RouteCollector;

return function(RouteCollector $r) {

        $r->addRoute('GET', '/', ['HomeController', 'index']);

        $r->addGroup('/clinica', function (RouteCollector $r) {
                $r->addRoute('GET', '', ['HomeController', 'indexClinica']);
                $r->addRoute('GET', '/acceso', ['LoginController', 'accesoClinica']);
                $r->addRoute('POST', '/login', ['LoginController', 'loginClinica']);
                
                $r->addGroup('/pacientes', function (RouteCollector $r) {
                        $r->addRoute('GET', '', ['ClinicaController', 'pacientesIndex']);
                });

                $r->addRoute('GET', '/modulos/paciente/{idPaciente}', ['ClinicaController', 'pacientesModulos']);

                $r->addRoute('GET', '/paciente/nuevo', ['ClinicaController', 'pacienteNuevo']);
                $r->addRoute('GET', '/paciente/editar/{idPaciente}', ['ClinicaController', 'pacienteEditar']);
                $r->addRoute('POST', '/paciente/insert-edit', ['ClinicaController', 'pacienteInsertEdit']);

                $r->addRoute('GET', '/paciente/pin/{idPaciente}', ['ClinicaController', 'pacientePin']);
                $r->addRoute('POST', '/paciente/insert-pin', ['ClinicaController', 'pacienteInsertPin']);

                
                $r->addRoute('GET', '/paciente/{idPaciente}', ['ClinicaController', 'pacienteDetalle']);

                $r->addRoute('GET', '/nota-subsecuente/{idNota}', ['NotaSubsecuenteController', 'notaSubsecuente']);
                $r->addRoute('GET', '/nota-subsecuente/paciente/{idPaciente}', ['ClinicaController', 'pacienteNotaSubsecuente']);
                $r->addRoute('POST', '/paciente/insert-nota-subsecuente', ['ClinicaController', 'pacienteInsertNotaSubsecuente']);

                $r->addRoute('GET', '/receta/{idReceta}', ['RecetaController', 'receta']);
                $r->addRoute('GET', '/receta/paciente/{idPaciente}', ['ClinicaController', 'pacienteReceta']);
                $r->addRoute('POST', '/paciente/insert-receta', ['ClinicaController', 'pacienteInsertReceta']);

                $r->addRoute('GET', '/laboratorio/paciente/{idPaciente}', ['ClinicaController', 'pacienteLaboratorio']);
                $r->addRoute('POST', '/laboratorio/insert-laboratorio', ['ClinicaController', 'pacienteInsertLaboratorio']);

        });

        $r->addGroup('/historia-clinica', function (RouteCollector $r) {
                $r->addRoute('GET', '', ['HomeController', 'indexPaciente']);
                $r->addRoute('GET', '/acceso', ['LoginController', 'accesoPaciente']);
                $r->addRoute('POST', '/login', ['LoginController', 'loginPaciente']);
        });

        //-----------------------------------------//
        //Ruta para crear las diferentes busquedas
        //----------------------------------------//
        $r->addRoute('GET', '/buscar', ['BusquedasController', 'buscarPacientes']);
        $r->addRoute('GET', '/buscar/tabla-recetas/{idPaciente}', ['BusquedasController', 'tableRecetas']);
        $r->addRoute('GET', '/buscar/receta/{idReceta}', ['BusquedasController', 'buscarReceta']);
        $r->addRoute('GET', '/buscar/nota-subsecuente/{idNota}', ['BusquedasController', 'buscarNotaSubsecuente']);
        $r->addRoute('GET', '/buscar/laboratorio/{idLaboratorio}', ['BusquedasController', 'buscarLaboratorio']);
    
        //-----------------------------------------//
        //Cerrar sesion
        //----------------------------------------//

        $r->addRoute('GET', '/cerrar-sesion', ['LoginController', 'cerrarSesion']);

        $r->addRoute('GET', '/pdf/receta/{idReceta}', ['PdfController', 'pdfReceta']);
};

?>