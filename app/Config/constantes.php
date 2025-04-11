<?php
define("HOST", $_SERVER["HTTP_HOST"]);
define("SERVIDOR", "http://".HOST."/");

define("RUTA_PUBLIC", SERVIDOR . "public/assets/");

define("RUTA_CSS", RUTA_PUBLIC . "css/");
define("RUTA_WEB_CSS", RUTA_CSS . "web.1.1/");
define("RUTA_JS", RUTA_PUBLIC . "js/");
define("RUTA_WEB_JS", RUTA_JS . "web.1.1/");
define("RUTA_IMAGES", RUTA_PUBLIC . "images/");
define("RUTA_IMG_ICONOS", value: RUTA_IMAGES . "iconos/");
define("RUTA_IMG_FONDO", RUTA_IMAGES . "fondo/");

define("RUTA_STORAGE", SERVIDOR . "public/storage/");
//--------------------------------------------------------------------------//

define("LINK_HOME", SERVIDOR);
define("LINK_QUIENES_SOMOS", SERVIDOR . "quienes-somos");
define("LINK_QUEES_DOLOR", SERVIDOR . "que-es-dolor");
define("LINK_TIPOS_DOLOR", SERVIDOR . "tipos-dolor");
define("LINK_DOLOR_AGUDO", SERVIDOR . "dolor-agudo");
define("LINK_DOLOR_CRONICO", SERVIDOR . "dolor-cronico");
define("LINK_DOLOR_PERIOPERATORIO", SERVIDOR . "dolor-perioperatorio");
define("LINK_NEUROESTIMULACION", SERVIDOR . "neuroestimulacion");
define("LINK_EVALUACION_DOLOR", SERVIDOR . "evaluacion-dolor");
define("LINK_CUIDADORES", SERVIDOR . "cuidadores");
define("LINK_INYECCION_EPIDURAL", SERVIDOR . "inyeccion-epidural");
define("LINK_ESTRENIMIENTO", SERVIDOR . "estrenimiento");
define("LINK_TRATAMIENTO_OPIOIDES", SERVIDOR . "como-se-inicia-un-tratamiento-con-opioides");
define("LINK_DOLOR_CANCER", SERVIDOR . "dolor-cancer");
define("LINK_DOLOR_CANCER_FRECUENCIA", SERVIDOR . "dolor-cancer-frecuencia");
define("LINK_DOLOR_CANCER_CAUSAS", SERVIDOR . "dolor-cancer-causas");
define("LINK_DOLOR_CANCER_PREGUNTAS_MEDICO", SERVIDOR . "dolor-cancer-preguntas-medico-decidir-tratamiento");
define("LINK_DOLOR_CANCER_SEGUIMIENTO_TRATAMIENTO_DOLOR", SERVIDOR . "seguimiento-tratamiento-dolor");
define("LINK_DOLOR_CANCER_CINCO_PRIORIDADES", SERVIDOR . "dolor-cancer-cinco-prioridades");
define("LINK_DOLOR_CANCER_ENDOSCOPIA_PALIATIVA", SERVIDOR . "dolor-cancer-endoscopia-paliativa");

define("LINK_DOLOR_NEURALGIA_POSTHERPETICA", SERVIDOR . "neuralgia-postherpetica");

define("LINK_PACIENTE_ACCESO", SERVIDOR . "historia-clinica");
define("LINK_PACIENTE_CLINICA", SERVIDOR . "paciente/clinica");
define("LINK_NUEVO_PACIENTE", SERVIDOR . "paciente/nuevo");
define("LINK_FICHA_IDENTIFICACION_PACIENTE", SERVIDOR . "paciente/ficha-identificacion");
define("LINK_EDITAR_FICHA_IDENTIFICACION_PACIENTE", SERVIDOR . "paciente/editar-ficha-identificacion");

define("LINK_PACIENTE_ANTECEDENTES_FAMILIARES", SERVIDOR . "paciente/antecedentes-familiares/");
define("LINK_PACIENTE_ANTECEDENTES_PERSONALES_NOPATOLOGICOS", SERVIDOR . "paciente/antecedentes-personales-no-patologicos/");
define("LINK_PACIENTE_ANTECEDENTES_PERSONALES_QUIRURGICO", SERVIDOR . "paciente/antecedentes-personales-quirurgicos/");
define("LINK_PACIENTE_ANTECEDENTES_PERSONALES_PATOLOGICOS", SERVIDOR . "paciente/antecedentes-personales-patologicos/");
define("LINK_PACIENTE_ANTECEDENTES_MEDICACION_ACTUAL", SERVIDOR . "paciente/antecedentes-medicacion-actual/");

define("LINK_PACIENTE_MEDICAMENTO_CONTROL_DOLOR", SERVIDOR . "paciente/medicamentos-controlar-dolor/");

define("LINK_PACIENTE_PROCEDIMIENTOS_CONTROLAR_DOLOR", SERVIDOR . "paciente/procedimientos-controlar-dolor/");

define("LINK_PACIENTE_EVALUACION_DOLOR", SERVIDOR . "paciente/evaluacion-del-dolor/");
define("LINK_PACIENTE_CUESTIONARIO_MCGUILL", SERVIDOR . "paciente/cuestionario-mcguill/");

define("LINK_CURSOS", SERVIDOR . "cursos");
define("LINK_CUIDADOS_PALIATIVOS", SERVIDOR . "cuidados-paliativos");
