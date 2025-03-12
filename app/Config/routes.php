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
                $r->addRoute('GET', '/paciente/pin/{idPaciente}', ['ClinicaController', 'pacientePin']);
                $r->addRoute('POST', '/paciente/insert-edit', ['ClinicaController', 'pacienteInsertEdit']);

                $r->addRoute('GET', '/paciente/{idPaciente}', ['ClinicaController', 'pacienteDetalle']);

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
    
};

?>