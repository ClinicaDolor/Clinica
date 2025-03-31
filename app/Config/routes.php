<?php
use FastRoute\RouteCollector;

return function(RouteCollector $r) {

        
        //-----------------------------------------------------------------------------------
        //--- Inicio Configuración de Rutas para la pagina web ------------------------------

        $r->addRoute('GET', '/', ['WebController', 'index']);
        $r->addRoute('GET', '/quienes-somos', ['WebController', 'quienesSomos']);
        $r->addRoute('GET', '/cursos', ['WebController', 'cursos']);

        $r->addRoute('GET', '/que-es-dolor', ['WebController', 'queEsDolor']);
        $r->addRoute('GET', '/tipos-dolor', ['WebController', 'tiposDolor']);
        $r->addRoute('GET', '/dolor-agudo', ['WebController', 'dolorAgudo']);
        $r->addRoute('GET', '/dolor-cronico', ['WebController', 'dolorCronico']);
        $r->addRoute('GET', '/dolor-perioperatorio', ['WebController', 'dolorPerioperatorio']);
        $r->addRoute('GET', '/dolor-cancer', ['WebController', 'dolorCancer']);
        $r->addRoute('GET', '/dolor-cancer-frecuencia', ['WebController', 'dolorCancerFrecuencia']);
        $r->addRoute('GET', '/dolor-cancer-causas', ['WebController', 'dolorCancerCausas']);
        $r->addRoute('GET', '/dolor-cancer-preguntas-medico-decidir-tratamiento', ['WebController', 'dolorCancerPreguntasMedicoDecidirTratamiento']);
        $r->addRoute('GET', '/seguimiento-tratamiento-dolor', ['WebController', 'seguimientoTratamientoDolor']);
        $r->addRoute('GET', '/dolor-cancer-cinco-prioridades', ['WebController', 'dolorCancerCincoPrioridades']);
        $r->addRoute('GET', '/dolor-cancer-endoscopia-paliativa', ['WebController', 'dolorCancerEndoscopiaPaliativa']);
        $r->addRoute('GET', '/neuralgia-postherpetica', ['WebController', 'neuralgiaPostherpetica']);

        $r->addRoute('GET', '/evaluacion-dolor', ['WebController', 'evaluacionDolor']);
        $r->addRoute('GET', '/cuidadores', ['WebController', 'cuidadores']);
        $r->addRoute('GET', '/inyeccion-epidural', ['WebController', 'inyeccionEpidural']);
        $r->addRoute('GET', '/neuroestimulacion', ['WebController', 'neuroestimulacion']);
        $r->addRoute('GET', '/como-se-inicia-un-tratamiento-con-opioides', ['WebController', 'comoIniciaTratamientoOpioides']);

        //-----------------------------------------------------------------------------------
        //--- Fin Configuración de Rutas para la pagina web ---------------------------------

        



        //---------- FUNCION PARA AGREGAR LAS RUTAS EN LOS DOS GRUPOS ----------
        $registrarRutasComunes = function (RouteCollector $r) {
        //----- 2. ANTECEDENTES FAMILIARES
        $r->addRoute('POST', '/paciente/agregar-enfermedad-antecedentes', ['ModulosController', 'pacienteInsertEnfermedad']);
        $r->addRoute('POST', '/paciente/editar-enfermedad-antecedentes', ['ModulosController', 'pacienteEditEnfermedad']);
        $r->addRoute('POST', '/paciente/eliminar-enfermedad-antecedentes', ['ModulosController', 'pacienteDeleteEnfermedad']);

        //----- 4. ANTECEDENTES PERSONALES QUIRÚRGICOS
        $r->addRoute('POST', '/paciente/agregar-cirugia-antecedentes', ['ModulosController', 'pacienteInsertCirugia']);
        $r->addRoute('POST', '/paciente/editar-cirugia-antecedentes', ['ModulosController', 'pacienteEditCirugia']);
        $r->addRoute('POST', '/paciente/eliminar-cirugia-antecedentes', ['ModulosController', 'pacienteDeleteCirugia']);

        //----- 8. AGREGAR PROCEDIMIENTO DOLOR
        $r->addRoute('POST', '/paciente/agregar-procedimiento-dolor', ['ModulosController', 'pacienteInsertProcedimientos']);
        $r->addRoute('POST', '/paciente/editar-procedimiento-dolor', ['ModulosController', 'pacienteEditProcedimiento']);
        $r->addRoute('POST', '/paciente/eliminar-procedimiento-dolor', ['ModulosController', 'pacienteDeleteProcedimiento']);
        
        $r->addRoute('POST', '/paciente/editar-tratamientos-pacientes', ['ModulosController', 'pacienteEditTratamiento']);

        //----- COMENTARIOS MODULOS
        $r->addRoute('POST', '/paciente/agregar-comentario-modulo', ['ModulosController', 'pacienteComentarioModulo']);
        $r->addRoute('POST', '/paciente/eliminar-comentario-modulo', ['ModulosController', 'pacienteDeleteComentario']);

        //----- FINALIZACIÓN DE MÓDULOS
        $r->addRoute('POST', '/paciente/finalizar-modulo-paciente', ['ModulosController', 'pacienteFinalizarModulo']);
        };

        //-------------------- VISTAS DEL DOCTOR --------------------
        $r->addGroup('/clinica', function (RouteCollector $r) use ($registrarRutasComunes) {

        $r->addRoute('GET', '', ['HomeController', 'indexClinica']);
        $r->addRoute('GET', '/acceso', ['LoginController', 'accesoClinica']);
        $r->addRoute('POST', '/login', ['LoginController', 'loginClinica']);
                
        $r->addGroup('/pacientes', function (RouteCollector $r) {
        $r->addRoute('GET', '', ['ClinicaController', 'pacientesIndex']);
        }
        );

        $r->addRoute('GET', '/paciente/nuevo', ['ClinicaController', 'pacienteNuevo']);
        $r->addRoute('GET', '/paciente/editar/{idPaciente}', ['ClinicaController', 'pacienteEditar']);
        $r->addRoute('POST', '/paciente/insert-edit', ['ClinicaController', 'pacienteInsertEdit']);

        $r->addRoute('GET', '/paciente/pin/{idPaciente}', ['ClinicaController', 'pacientePin']);
        $r->addRoute('POST', '/paciente/insert-pin', ['ClinicaController', 'pacienteInsertPin']);

        $r->addRoute('GET', '/paciente/{idPaciente}', ['ClinicaController', 'pacienteDetalle']);

        $r->addRoute('GET', '/nota-subsecuente/{idNota}', ['NotaSubsecuenteController', 'notaSubsecuente']);
        $r->addRoute('GET', '/nota-subsecuente/paciente/{idPaciente}/referencia/{referencia}', ['ClinicaController', 'pacienteNotaSubsecuente']);
        $r->addRoute('POST', '/paciente/insert-nota-subsecuente', ['ClinicaController', 'pacienteInsertNotaSubsecuente']);

        $r->addRoute('GET', '/receta/{idReceta}', ['RecetaController', 'receta']);
        $r->addRoute('GET', '/receta/paciente/{idPaciente}', ['ClinicaController', 'pacienteReceta']);
        $r->addRoute('POST', '/paciente/insert-receta', ['ClinicaController', 'pacienteInsertReceta']);

        $r->addRoute('GET', '/laboratorio/{idLaboratorio}', ['LaboratorioController', 'laboratorio']);
        $r->addRoute('GET', '/laboratorio/paciente/{idPaciente}', ['ClinicaController', 'pacienteLaboratorio']);
        $r->addRoute('POST', '/laboratorio/insert-laboratorio', ['ClinicaController', 'pacienteInsertLaboratorio']);
             
        //----- VISTAS DE LOS 9 MODULOS
        $r->addRoute('GET', '/modulos/paciente/{idPaciente}', ['ClinicaController', 'pacientesModulos']);
        $r->addRoute('GET', '/{modulo}/paciente/{idPaciente}', ['ModulosController', 'moduloVistaDoctor']);
        //----- FUNCIONALIDADES MODULOS PACIENTE 

        //--------- OTROS
        $r->addRoute('GET', '/perfil', ['ClinicaController', 'perfil']);
        //---------------
        $registrarRutasComunes($r);

        });


        //-------------------- VISTAS DEL PACIENTE --------------------
        $r->addGroup('/historia-clinica', function (RouteCollector $r) use ($registrarRutasComunes) {
        $r->addRoute('GET', '', ['HomeController', 'indexPaciente']);
        $r->addRoute('GET', '/acceso', ['LoginController', 'accesoPaciente']);
        $r->addRoute('POST', '/login', ['LoginController', 'loginPaciente']);

        //----- VISTAS DE LOS 9 MODULOS
        $r->addRoute('GET', '/{modulo}/paciente/{idPaciente}', ['ModulosController', 'moduloVistaPaciente']);
        //----- FUNCIONALIDADES MODULOS PACIENTE 
        $registrarRutasComunes($r);
        });
  
        //-----------------------------------------//
        //Ruta para crear las diferentes busquedas
        //----------------------------------------//
        $r->addRoute('GET', '/buscar', ['BusquedasController', 'buscarPacientes']);
        $r->addRoute('GET', '/buscar/tabla-recetas/{idPaciente}', ['BusquedasController', 'tableRecetas']);
        $r->addRoute('GET', '/buscar/receta/{idReceta}', ['BusquedasController', 'buscarReceta']);
        $r->addRoute('GET', '/buscar/nota-subsecuente/{idNota}', ['BusquedasController', 'buscarNotaSubsecuente']);
        $r->addRoute('GET', '/buscar/laboratorio/{idLaboratorio}', ['BusquedasController', 'buscarLaboratorio']);
        $r->addRoute('GET', '/buscar/tabla-laboratorio/{idPaciente}/{referencia}', ['BusquedasController', 'tableLaboratorio']);
        $r->addRoute('GET', '/buscar/tabla-notas-subsecuentes/{idPaciente}/{referencia}', ['BusquedasController', 'tableNotasSubsecuentes']);
    
        //-----------------------------------------//
        //Ruta para crear las diferentes busquedas de los Modulos
        //----------------------------------------//
        $r->addRoute('GET', '/buscar/contenido-preguntas-modulo-2/{idPaciente}/{idRol}', ['BusquedasController', 'contenidoPreguntasAF']);
        $r->addRoute('GET', '/buscar/contenido-preguntasV1-modulo-3/{idPaciente}/{idRol}', ['BusquedasController', 'contenidoPreguntasAPNP1']);

        $r->addRoute('GET', '/buscar/contenido-comentarios-modulos/{idPaciente}/{idRol}/{idModulo}', ['BusquedasController', 'contenidoComentariosModulo']);

        //-----------------------------------------//
        //Cerrar sesion
        //----------------------------------------//

        $r->addRoute('GET', '/cerrar-sesion', ['LoginController', 'cerrarSesion']);
        $r->addRoute('GET', '/pdf/receta/{idReceta}', ['PdfController', 'pdfReceta']);
};

?>