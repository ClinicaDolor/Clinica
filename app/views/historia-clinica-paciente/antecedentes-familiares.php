<?php 
use App\Config\Database;
use App\Models\AntecedenteFamiliarModel;
$bd = Database::getInstance();

$enfermedades_fijas = [
    "Enfermedades del corazón",
    "Hipertensión arterial sistémica",
    "Enfermedad cerebrovascular",
    "Diabetes Mellitus",
    "Cáncer"
];

$model = new AntecedenteFamiliarModel();
foreach ($enfermedades_fijas as $enf) {
echo $model->antecedentesFamiliares($data['idPaciente'], $enf);
}

try {
$stmt = $bd->query("SELECT * FROM pc_antecedentes_familiares WHERE id_paciente = '".$data['idPaciente']."'");
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
die("Error en la consulta: " . $e->getMessage());
}

try {
$stmt = $bd->query("SELECT * FROM pac_historia_clinica_finalizar WHERE id_modulo = 2 AND id_paciente = '".$data['idPaciente']."'");
$modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
die("Error en la consulta: " . $e->getMessage());
}
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
    #preguntas-container { display: block; }
    .pregunta-container { display: none; }
    .pregunta-container.active { display: block; }
    /* Sección de comentarios oculta inicialmente */
    #comentarios-container { display: none; }
    </style>

    <script>
    let preguntas = [];
    let indiceActual = 0;

    document.addEventListener("DOMContentLoaded", function() {
    // Se recogen todos los contenedores de preguntas
    preguntas = Array.from(document.querySelectorAll(".pregunta-container"));
    
    if(preguntas.length > 0) {
    preguntas[0].classList.add("active");
    }

    // Manejo de cambio en los select para respuestas
    document.querySelectorAll(".tipo-enfermedad").forEach(select => {
    select.addEventListener("change", function() {
    let row = this.closest(".pregunta-container");
    let inputEspecificar = row.querySelector(".especificar-enfermedad");
    inputEspecificar.disabled = this.value !== "Si";
    if (this.value !== "Si") {
    inputEspecificar.value = "";
    }
    // Actualiza vía AJAX (función ya implementada)
    editarEnfermedad(row.dataset.id, this, 3, row.dataset.rol);
    });
    });
    });


    // Función para manejar cambios de respuesta en el select principal
    function respuestaPregunta(select, id) {
    let row = select.closest('.pregunta-container');
    let tipoSelect = row.querySelector(".detalle-enfermedad");
    let inputEspecificar = row.querySelector(".especificar-enfermedad");
    let divTipoEnfermedad = row.querySelector(".divTipoEnfermedad");

    if (select.value === "No") {
    tipoSelect.value = "";
    tipoSelect.disabled = true;
    inputEspecificar.value = "";
    inputEspecificar.disabled = true;
    divTipoEnfermedad.style.display = 'none';

    } else {
    // Para Diabetes Mellitus, si se responde 'Si', habilita detalle de tipo
    if (row.dataset.enfermedad.trim() === "Diabetes Mellitus" && select.value === "Si") {
    tipoSelect.disabled = false;
    divTipoEnfermedad.style.display = 'block';

    } else {
    tipoSelect.value = "";
    tipoSelect.disabled = true;
    divTipoEnfermedad.style.display = 'none';

    }
    // Habilita el campo de especificar solo si se responde 'Si'
    inputEspecificar.disabled = (select.value !== "Si");
    if(select.value !== "Si") {
    inputEspecificar.value = "";
    }
    }
    editarEnfermedad(id, select, 2, row.dataset.rol);
    }


    function agregarEnfermedadPaciente(idPaciente,idRol){

    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idPaciente : idPaciente,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/agregar-enfermedad-antecedentes', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    location.reload()
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });
            
    }

    function eliminarEnfermedadPaciente(idEnfermedad,idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idEnfermedad : idEnfermedad,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/eliminar-enfermedad-antecedentes', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    location.reload()
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });
        
    }

    function editarEnfermedad(idEnfermedad, elemento, parametro, idRol) {
    let valor = elemento.value; 
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idEnfermedad : idEnfermedad,
    detalle : valor,
    edicion : parametro,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/editar-enfermedad-antecedentes', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    //location.reload()
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });

    }

    function agregarComentario(idModulo, idPaciente, idRol){
    const comentarioModulos = document.getElementById('comentarioModulos').value;
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idModulo : idModulo,
    idPaciente : idPaciente,
    comentarioModulos : comentarioModulos,
    idRol : idRol
    };


    if(comentarioModulos != ""){
    $('#comentarioModulos').css('border',''); 
    
    fetch('/' + val + '/paciente/agregar-comentario-modulo', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    location.reload()
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });

    }else{
    $('#comentarioModulos').css('border','2px solid #A52525'); 
    }


    }


    function eliminarComentario(idComentario, idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idComentario : idComentario,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/eliminar-comentario-modulo', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    location.reload()
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });

    }


    //---------- MOSTRAR CONTENEDORES ----------
    function finalizarPreguntas() {
    document.getElementById("preguntas-container").style.display = "none";
    document.getElementById("comentarios-container").style.display = "block";
    }

    function seccionPreguntas() {
    document.getElementById("preguntas-container").style.display = "block";
    document.getElementById("comentarios-container").style.display = "none";
    }

    //---------- FINALIZAR MODULOS ----------//
    function FinalizarModuloPaciente(idModulo, idPaciente){

    const parametros = {
    idModulo : idModulo,
    idPaciente : idPaciente
    };

    fetch('/historia-clinica/paciente/finalizar-modulo-paciente', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

    if (data.resultado) {
    window.location.href = '/historia-clinica';
    } else {
    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
    }

    });

    }

    </script>
    </head>

    <body>
    <div class="LoaderPage"></div>
    <div id="app">
        
    <!---------- SIDEBAR ---------->
    <?=$data['sidebar'];?>
    
    <div id="main"> 
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
    <h3>Antecedentes familiares</h3>
    </div>
    
    <section class="section">

    <div class="card">

    <div id="preguntas-container">
    <div class="card-header pb-0">
    <div class="row">

    <div id="seccion1" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-3">
    <img src="<?=RUTA_IMAGES ?>/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion1">
      
    <!-- Texto -->
    <h8 class="text-primary fw-bold texto">
    <b>A continuación, le preguntaremos si existen antecedentes familiares de alguna de las siguientes enfermedades. <br>Por favor, mencione si alguno de sus familiares cercanos, como abuelos, padres, hermanos, etc., ha padecido alguna de ellas:</b>
    </h8>
    </div>

    <!-- Sección del botón (en una columna separada) -->
    <div class="col-12 col-md-1 d-flex justify-content-end align-items-center">
    <button onclick="agregarEnfermedadPaciente(<?=$data['idPaciente'];?>,'<?=$data['idRol'];?>')" class="btn icon btn-success float-end">
    <i data-feather="plus" width="20"></i>
    </button>
    </div>

    <!-- Mensaje de error -->
    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>
    </div>
    </div>


    <div class="card-body">
    <!---------- PREGUNTAS ------------>

    <?php foreach ($preguntas as $index => $pregunta): 
    $idEnfermedad = $pregunta['id'];
    $enfermedad = $pregunta['enfermedad'];
    $tipo = $pregunta['tipo'];
    $detalle = $pregunta['detalle'];
    $especificar = $pregunta['especificar'];
    ?>
                             
    <div class="pregunta-container" data-id="<?=$idEnfermedad;?>" data-enfermedad="<?=$enfermedad;?>" data-rol="<?=$data['idRol'];?>">
    <div class="text-secondary fw-bold mb-1">Nombre de la enfermedad:</div>

    <?php if (in_array($enfermedad, $enfermedades_fijas)): ?>
    <h4 class="mb-3"><?=$enfermedad;?></h4>
    <div class="text-secondary fw-bold mb-1">¿Alguno de tus familiares ha sido diagnosticado con esta enfermedad?</div>
    <select class="form-select tipo-enfermedad mb-3" onchange="respuestaPregunta(this, <?=$idEnfermedad;?>)">
    <option value="" disabled selected>Selecciona una opción...</option>
    <option value="Si" <?php if ($detalle == 'Si') echo 'selected'; ?>>Sí</option>
    <option value="No" <?php if ($detalle == 'No') echo 'selected'; ?>>No</option>
    <!--<option value="Se ignora" <?php if ($detalle == 'Se ignora') echo 'selected'; ?>>Se ignora</option>-->
    </select>                     
    <?php else: ?>    
    <div class="row">
    <div class="col-11">
    <input onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 1, '<?=$data['idRol'];?>')" class="form-control mb-3" value="<?= $enfermedad ?>" placeholder="Escribe la enfermedad...">
    </div>

    <div class="col-1">
    <button class="btn btn-danger float-end" onclick="eliminarEnfermedadPaciente(<?=$idEnfermedad?>,'<?=$data['idRol'];?>')"><i data-feather="trash-2"></i></button>

    </div>
    </div>
    <?php endif; ?>

    <div id="divTipoDiabetes_<?=$idEnfermedad;?>" class="divTipoEnfermedad" style="display: <?= ($enfermedad == 'Diabetes Mellitus' && $detalle == 'Si') ? 'block' : 'none'; ?>;">
    <div class="text-secondary fw-bold mb-1">¿Qué tipo de diabetes?</div>
    <select class="form-select detalle-enfermedad mb-3" onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 3, '<?=$data['idRol'];?>')"
        <?= ($enfermedad == 'Diabetes Mellitus' && $detalle == 'Si') ? '' : 'disabled'; ?>>
        <option value="" disabled selected>Selecciona una opción...</option>
        <option value="Tipo 1" <?php if ($tipo === 'Tipo 1') echo 'selected'; ?>>Tipo 1</option>
        <option value="Tipo 2" <?php if ($tipo === 'Tipo 2') echo 'selected'; ?>>Tipo 2</option>
        <option value="Gestacional" <?php if ($tipo === 'Gestacional') echo 'selected'; ?>>Gestacional</option>
        <option value="Otro" <?php if ($tipo === 'Otro') echo 'selected'; ?>>Otro</option>
    </select>
    </div>
                     
    <div>
    <div class="text-secondary fw-bold mb-1">¿Cual enfermedad?:</div>
    <input class="form-control especificar-enfermedad" onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 4, '<?=$data['idRol'];?>')" value="<?=$especificar?>" placeholder="Especifica aquí la enfermedad..." <?php if($detalle !== 'Si') echo 'disabled'; ?>>
    </div>
                                                    
    <div class="mt-3 d-flex justify-content-between">
    <?php if($index > 0): ?>
        <button class="btn btn-secondary" onclick="anteriorPregunta()"><i data-feather="chevron-left"></i> Anterior</button>
    <?php else: ?>
        <div></div>
    <?php endif; ?>
                                    
    <?php if($index < count($preguntas)-1): ?>
        <button class="btn btn-primary" onclick="siguientePregunta()">Siguiente <i data-feather="chevron-right"></i></button>
    <?php else: ?>
    <!-- Al estar en la última pregunta, se muestra el botón Finalizar -->
    <button class="btn btn-success" onclick="finalizarPreguntas()">Comentario <i data-feather="message-circle"></i></button>
    <?php endif; ?>
    </div>

    </div>
    <?php endforeach; ?>
    </div>
    </div>

    <div id="comentarios-container">

    <div class="card-header pb-0">
    <div class="row">

    <div id="seccion2" data-autoplay="false" class="col-12 col-md-11 d-flex align-items-center sectionQuestion mb-3">
    <img src="<?=RUTA_IMAGES ?>/iconos/audio.png" class="img-fluid btnLeer pointer" style="max-height: 30px; margin-right: 10px;" data-target="seccion2">
      
    <!-- Texto -->
    <h8 class="text-primary fw-bold texto">
    <b>Si tiene alguna otra información o comentarios que desee compartir, por favor, indíquelo:</b>
    </h8>
    </div>

    <!-- Mensaje de error -->
    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>
    </div>
    </div>

    <div class="card-body">
    <div class="text-secondary fw-bold mb-1">Comentario:</div>
    <div class="input-group mb-3">
    <input type="text" class="form-control" id="comentarioModulos" placeholder="Ingresa aquí tu comentario...">
    <button class="btn btn-outline-secondary" type="button" onclick="agregarComentario(2,<?=$data['idPaciente']?>,'<?=$data['idRol'];?>')">Agregar comentario</button>
    </div>
    <?php
    $num = 1;
    try {
    $stmt_2 = $bd->query("SELECT id, comentario FROM pac_historia_clinica_comentario WHERE id_modulo = 2 AND id_paciente = '".$data['idPaciente']."'");
    $comentarios = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }
    ?>
                            
    <div class="table-responsive">
    <table class="table table-striped" id="table_comentarios">
    <thead>
    <tr>
    <th class="text-center align-middle" width="30px">#</th>
    <th class="text-start align-middle">Comentario</th>
    <th class="text-center align-middle" width="30px"><i data-feather="trash-2"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($comentarios as $comentario): 
        $idComentario = $comentario['id'];
        $moduloComentario = $comentario['comentario'];
    ?>
    <tr>
        <td class="text-center align-middle"><?=$num?></td>
        <td class="text-start align-middle"><?=$moduloComentario?></td>
        <td class="text-center align-middle"><i class="pointer" data-feather="trash-2" onclick="eliminarComentario(<?=$idComentario?>,'<?=$data['idRol'];?>')"></i></td>
    </tr>
    <?php $num++; endforeach; ?>
    </tbody>
    </table>
    </div>
 
    <div class="mt-3 d-flex justify-content-between">
    <button class="btn btn-secondary" onclick="seccionPreguntas()"><i data-feather="chevron-left"></i> Preguntas</button>

    <?php
    if (empty($modulos)): 
    ?>

    <button class="btn btn-success" onclick="FinalizarModuloPaciente(2, <?=$data['idPaciente'];?>)">Finalizar</button>
    <?php endif; 
    ?>


    </div>

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
