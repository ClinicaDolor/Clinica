<?php 
use App\Config\Database;
use App\Models\PacienteModulosModelo;
$bd = Database::getInstance();

$model2 = new PacienteModulosModelo();
$botonFinalizar = $model2->botonFinalizarModulo(3,$data['idPaciente'],$data['idRol']);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['title'];?></title>
    <link rel="shortcut icon" href="<?=RUTA_IMAGES ?>/logo-clinica.png">
    <link rel="apple-touch-icon" href="<?=RUTA_IMAGES ?>/logo-clinica.png">
    <link rel="stylesheet" href="<?=RUTA_CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/simple-datatables/style.css">
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?=RUTA_JS;?>loader.js"></script>

    <style>
    /* Contenedor de preguntas visible inicialmente */
    #preguntas-container-1 { display: block; }
    .pregunta-container-1 { display: none; }
    .pregunta-container-1.active { display: block; }
    </style>

    <script>

    document.addEventListener("DOMContentLoaded", function() {
    const seccionActual = localStorage.getItem("seccionPreguntas");

    if (!seccionActual || seccionActual === "tabaquismo") {
    contenidoPreguntas(1);
    }else if(seccionActual === "alcoholismo"){
    contenidoPreguntas(2);
    }else if(seccionActual === "ejercicio"){
    contenidoPreguntas(3);
    }else if(seccionActual === "estres"){
    contenidoPreguntas(4);
    }else if(seccionActual === "drogas"){
    contenidoPreguntas(5);
    }else if(seccionActual === "dormir"){
    contenidoPreguntas(6);
    }else if(seccionActual === "grupoRH"){
    contenidoPreguntas(7);
    }
    
    });
 

// ---------- CONTENIDO DE LAS PREGUNTAS ----------

// Función para cargar el contenido con fetch y reiniciar el IntersectionObserver
function contenidoPreguntas(idCuestionario) {
  const usuarioDiv = document.getElementById('main');
  const idPaciente = usuarioDiv.getAttribute('data-paciente');
  const idRol = usuarioDiv.getAttribute('data-rol');
  
  fetch(`/buscar/contenido-preguntas-modulo-3/${idPaciente}/${idRol}/${idCuestionario}`)
    .then(response => response.text())
    .then(data => {
      // Insertar el contenido en el DOM
      document.getElementById('contePreguntas_' + idCuestionario).innerHTML = data;

      // Reactivar el IntersectionObserver para las nuevas secciones
      document.querySelectorAll('.sectionQuestion').forEach(section => {
        observer.observe(section);
      });
    });
}



    </script>
    </head>

    <body>
    <div class="LoaderPage"></div>
    <div id="app">
        
    <!---------- SIDEBAR ---------->
    <?=$data['sidebar'];?>
    
    <div id="main" data-rol="<?=$data['idRol'];?>" data-paciente="<?=$data['idPaciente'];?>">
    <nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
                
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
    </ul>
    </div>
    </nav>

    <!---------- CONTENIDO DE LA PAGINA ---------->
    <div class="main-content container-fluid">

    <div class="page-title mb-4">     
    <h8><?=$data['nombre'];?></h8>
    <h3>Antecedentes Personales No Patológicos</h3>
    </div>
    
    <section class="section">

    <div class="card">
    <div id="preguntas-container-1">

    <div class="card-header pb-0">
    <div class="row">

    <div id="seccion1" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-3">
    <img src="<?=RUTA_IMAGES ?>/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion1">

    <h8 class="text-primary fw-bold texto">
    <b>A continuacion, responda las siguientes preguntas indicando si presenta alguna de estas conductas o hábitos:</b>
    </h8>
    </div>

    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>

    </div>
    </div>

    <div class="card-body">
    <div id="contePreguntas_1"></div>
    </div>

    </div>
    </div>

    </section>

    </div>
    <!----- FOOTER ---------->
    <?php include_once __DIR__ . '/../components/footer-mvsd.php';?>
    </div>
    </div>

    </div>
    </div>

    <script src="<?=RUTA_JS;?>voice-utilities.js"></script>
    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script>    
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_JS;?>main.js"></script>
    </body>
    </html>
