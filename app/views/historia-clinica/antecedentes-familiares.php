<?php 
use App\Config\Database;
$bd = Database::getInstance();

function antecedentesFamiliares($idPaciente, $enfermedad, $pdo) {
$sql = "SELECT COUNT(*) FROM pc_antecedentes_familiares WHERE id_paciente = ? AND enfermedad = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$idPaciente, $enfermedad]);
$numero = $stmt->fetchColumn();

if ($numero == 0) {
$sql_insert = "INSERT INTO pc_antecedentes_familiares (id_paciente, enfermedad, tipo, detalle, especificar) 
                       VALUES (?, ?, '', '', '')";
$stmt_insert = $pdo->prepare($sql_insert);
$stmt_insert->execute([$idPaciente, $enfermedad]);
}
}


antecedentesFamiliares($data['idPaciente'],"Enfermedades del corazón",$bd);
antecedentesFamiliares($data['idPaciente'],"Hipertensión arterial sistémica",$bd);
antecedentesFamiliares($data['idPaciente'],"Enfermedad cerebrovascular",$bd);
antecedentesFamiliares($data['idPaciente'],"Diabetes Mellitus",$bd);
antecedentesFamiliares($data['idPaciente'],"Cáncer",$bd);

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

    <script>
        
    function mostrarDetalle(select, id) {
    var inputDetalle = document.getElementById("detalle_" + id);
    var selectDiabetes = document.getElementById("diabetes_tipo_" + id);
            
    if (select.value === "Si") {
    if (selectDiabetes) selectDiabetes.style.display = "inline";
    } else {        
    if (selectDiabetes) selectDiabetes.style.display = "none";
    }
    }

    function agregarEnfermedadPaciente(idPaciente){
 
    const parametros = {
    idPaciente : idPaciente
    };

    fetch('/historia-clinica/paciente/agregar-enfermedad-antecedentes', {
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

    function eliminarEnfermedadPaciente(idEnfermedad){
    
    const parametros = {
    idEnfermedad : idEnfermedad
    };

    fetch('/historia-clinica/paciente/eliminar-enfermedad-antecedentes', {
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

    function editarEnfermedad(idEnfermedad, elemento, parametro) {
    let valor = elemento.value; 

    const parametros = {
    idEnfermedad : idEnfermedad,
    detalle : valor,
    edicion : parametro
    };

    fetch('/historia-clinica/paciente/editar-enfermedad-antecedentes', {
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

    function agregarComentario(idModulo, idPaciente){
    const comentarioModulos = document.getElementById('comentarioModulos').value;

    const parametros = {
    idModulo : idModulo,
    idPaciente : idPaciente,
    comentarioModulos : comentarioModulos
    };

    
    if(comentarioModulos != ""){
    $('#comentarioModulos').css('border',''); 

    fetch('/historia-clinica/paciente/agregar-comentario-modulo', {
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


    function eliminarComentario(idComentario){

    const parametros = {
    idComentario : idComentario
    };

    fetch('/historia-clinica/paciente/eliminar-comentario-modulo', {
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
    <div class="card-body pb-0">

    <div class="row">
    <div class="col-11">
    <h8 class="text-primary">
    <b>A continuación, le preguntaremos si existen antecedentes familiares de alguna de las siguientes enfermedades. <br>Por favor, mencione si alguno de sus familiares cercanos, como abuelos, padres, hermanos, etc., ha padecido alguna de ellas:</b>
    </h8>
    </div>

    <div class="col-1">
    <button onclick="agregarEnfermedadPaciente(<?=$data['idPaciente'];?>)" class="btn icon btn-success float-end"> <i data-feather="plus" width="20"></i> </button>
    </div>

    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>

    </div>

    <div class="row mt-3">

    <div class="col-12">
    <div class="table-responsive">
    <table class="table table-striped" id="table_enfermedades">
    <thead>
    <tr>
    <th class="text-start align-middle" width="250px">Nombre de la enfermedad</th>
    <th class="text-center align-middle" width="250px">Si/No/Se ignora</th>
    <th class="text-center align-middle" width="250px">Tipo</th>
    <th class="text-center align-middle">Especificar enfermedad</th>
    <th class="text-center align-middle" width="30px"></th>

    </tr>
    </thead>
    <tbody>
        
    <?php
    try {
    $stmt = $bd->query("SELECT * FROM pc_antecedentes_familiares WHERE id_paciente = '".$data['idPaciente']."'");
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

    $enfermedades_fijas = [
    "Enfermedades del corazón",
    "Hipertensión arterial sistémica",
    "Enfermedad cerebrovascular",
    "Diabetes Mellitus",
    "Cáncer"
    ];

    foreach ($preguntas as $pregunta): 
    $idEnfermedad = $pregunta['id'];
    $enfermedad = $pregunta['enfermedad'];
    $tipo = $pregunta['tipo'];
    $detalle = $pregunta['detalle'];
    $especificar = $pregunta['especificar'];
    ?>
    <tr>
    <td class="text-start align-middle p-1">
    <?php if (in_array($enfermedad, $enfermedades_fijas)): ?>
    <?= $enfermedad; ?>
    <?php else: ?>
    <input onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 1)" class="form-control nombre-enfermedad" value="<?= $enfermedad ?? '' ?>" placeholder="Escribe la enfermedad...">
    <?php endif; ?>
    </td>

    <td class="text-center align-middle">
    <select class="form-select tipo-enfermedad" onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 2)" <?= in_array($enfermedad, $enfermedades_fijas) ? '' : 'disabled'; ?>>
    <option value="" disabled selected <?php if ($detalle === '') echo 'selected'; ?>>Selecciona una opción...</option>
    <option value="Si" <?php if ($detalle == 'Si') echo 'selected'; ?>>Sí</option>
    <option value="No" <?php if ($detalle == 'No') echo 'selected'; ?>>No</option>
    <option value="Se ignora" <?php if ($detalle == 'Se ignora') echo 'selected'; ?>>Se ignora</option>
    </select>
    </td>

    <td class="text-center align-middle tipo-detalle">
    <select class="form-select detalle-enfermedad" onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 3)" <?= ($enfermedad == "Diabetes Mellitus" && $detalle == "Si") ? '' : 'disabled'; ?>>
    <option value="" disabled selected <?php if($tipo === '') echo 'selected'; ?>>Selecciona una opción...</option>
    <option value="Tipo 1" <?php if($tipo === 'Tipo 1') echo 'selected'; ?>>Tipo 1</option>
    <option value="Tipo 2" <?php if($tipo === 'Tipo 2') echo 'selected'; ?>>Tipo 2</option>
    <option value="Gestacional" <?php if($tipo === 'Gestacional') echo 'selected'; ?>>Gestacional</option>
    <option value="Otro" <?php if($tipo === 'Otro') echo 'selected'; ?>>Otro</option>
    </select>
    </td>

    <td class="text-center align-middle">
    <input class="form-control especificar-enfermedad" onchange="editarEnfermedad(<?=$idEnfermedad?>, this, 4)" value="<?=$especificar ?? ''?>" placeholder="Especifica aquí la enfermedad..." <?= ($detalle == 'Si') ? '' : 'disabled'; ?>>
    </td>


    <td class="text-start align-middle">
    <?php if (in_array($enfermedad, $enfermedades_fijas)): ?>
        
    <?php else: ?>
    <i data-feather="trash-2" class="pointer" onclick="eliminarEnfermedadPaciente(<?=$idEnfermedad?>)"></i>
    <?php endif; ?>
    </td>

    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>  

    <div class="col-12">
    <div class="fw-bold text-primary mt-2 mb-1">Si tiene alguna otra información o comentario que desee compartir, por favor, indíquelo:</div>

    <div class="input-group mb-3">
    <input type="text" class="form-control" id="comentarioModulos" placeholder="Ingresa aquí tu información o comentario...">
    <button class="btn btn-outline-secondary" type="button" onclick="agregarComentario(2,<?=$data['idPaciente']?>)">Agregar comentario</button>
    </div>

    <div class="table-responsive">
    <table class="table table-striped" id="table_comentarios">
    <thead>
    <tr>
    <th class="text-center align-middle" width="30px">#</th>
    <th class="text-start align-middle" width="">Comentario</th>
    <th class="text-center align-middle" width="30px"><i data-feather="trash-2"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $num = 1;
    try {
    $stmt_2 = $bd->query("SELECT id, comentario FROM pac_historia_clinica_comentario WHERE id_modulo = 2 AND id_paciente = '".$data['idPaciente']."'");
    $comentarios = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

    foreach ($comentarios as $comentario): 
    $idComentario = $comentario['id'];
    $moduloComentario = $comentario['comentario'];
    ?>
    <tr>
    <td class="text-center align-middle"><?=$num?></td>
    <td class="text-start align-middle"><?=$moduloComentario?></td>
    <th class="text-center align-middle"><i class="pointer" data-feather="trash-2" onclick="eliminarComentario(<?=$idComentario?>)"></i></th>
    </tr>
    <?php 
    $num++;
    endforeach; 
    ?>
    </tbody>
    </table>
    </div>
    </div>

    </div>
    </div>

    <?php
    try {
    $stmt = $bd->query("SELECT * FROM pac_historia_clinica_finalizar WHERE id_modulo = 2 AND id_paciente = '".$data['idPaciente']."'");
    $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

  
    if (empty($modulos)): 
    ?>
    <div class="card-footer">
    <button class="btn btn-success float-end fs-5" onclick="FinalizarModuloPaciente(2, <?=$data['idPaciente'];?>)">Finalizar</button>
    </div>
    <?php endif; ?>

    </div>
    </section>
    </div>
    </div>
    </div>

    <!----- FOOTER ---------->
    <?php include_once __DIR__ . '/../components/footer-mvsd.php';?>

    </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".tipo-enfermedad").forEach(select => {
            select.addEventListener("change", function() {
                let row = this.closest("tr");
                let enfermedad = row.querySelector("td:first-child").innerText.trim();
                let tipoSelect = row.querySelector(".detalle-enfermedad");
                let inputEspecificar = row.querySelector(".especificar-enfermedad");

                // Si el usuario elige "No", vaciar y deshabilitar los otros campos
                if (this.value === "No") {
                    tipoSelect.value = "";
                    tipoSelect.disabled = true;
                    inputEspecificar.value = "";
                    inputEspecificar.disabled = true;
                    return; // Detener la ejecución aquí
                }

                // Si la enfermedad es "Diabetes Mellitus" y selecciona "Sí", habilitar detalle
                if (enfermedad === "Diabetes Mellitus" && this.value === "Si") {
                    tipoSelect.disabled = false;
                } else {
                    tipoSelect.value = "";
                    tipoSelect.disabled = true;
                }

                // Habilitar campo "Especificar enfermedad" solo si el select tiene "Si"
                inputEspecificar.disabled = this.value !== "Si";
                if (this.value !== "Si") {
                    inputEspecificar.value = "";
                }
            });
        });
    });
    </script>

    
    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script>    
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_JS;?>main.js"></script>

    <script>
    let table1 = document.querySelector('#table_enfermedades');
    let dataTable = new simpleDatatables.DataTable(table1,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
	select: 1, sort: "desc"
	},
    { select: [1,2,3,4], sortable: false },

	]
    });

    let table2 = document.querySelector('#table_comentarios');
    let dataTable2 = new simpleDatatables.DataTable(table2,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
	select: 1, sort: "desc"
	},
    { select: [2], sortable: false },

	]
    });

    </script>

    </body>
    </html>
