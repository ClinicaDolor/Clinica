<?php 
use App\Config\Database;
$bd = Database::getInstance();

function guardarTratamiento($idPaciente, $idTratamiento, $pdo) {
    // Verificar si el tratamiento ya existe para este paciente
    $sql = "SELECT COUNT(*) FROM respuestas_procedimientos_dolor WHERE id_paciente = ? AND id_tratamiento = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idPaciente, $idTratamiento]);
    $num_lista = $stmt->fetchColumn();

    if ($num_lista == 0) {
        // Insertar nuevo registro si no existe
        $sql_insert = "INSERT INTO respuestas_procedimientos_dolor (id_paciente, id_tratamiento) VALUES (?, ?)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([$idPaciente, $idTratamiento]); 
    }
}

// Obtener los tratamientos disponibles
$sql = "SELECT id FROM modulo_procedimientos_dolor"; // Solo necesitamos el ID de cada tratamiento
$stmt = $bd->prepare($sql);
$stmt->execute();
$tratamientos = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtiene solo los IDs

// Insertar solo los tratamientos que aún no existen para este paciente
foreach ($tratamientos as $idTratamiento) {
    guardarTratamiento($data['idPaciente'], $idTratamiento, $bd);
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

    <script>
        
    //---------- PROCEDIMIENTOS ----------
    function agregarProcedimientosDolor(idPaciente, idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idPaciente : idPaciente,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/agregar-procedimiento-dolor', {
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

    function editarProcedimientosDolor(idProcedimiento, elemento, parametro, idRol) {
    let valor = elemento.value; 
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idProcedimiento : idProcedimiento,
    detalle : valor,
    edicion : parametro,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/editar-procedimiento-dolor', {
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

    function eliminarProcedimientosDolor(idProcedimiento, idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idProcedimiento : idProcedimiento,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/eliminar-procedimiento-dolor', {
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

    //---------- TRATAMIENTOS ----------
    function editarTratamientosPAC(idRespuesta, elemento, parametro, idRol) {
    let valor = elemento.value; 
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idRespuesta : idRespuesta,
    detalle : valor,
    edicion : parametro,
    idRol : idRol
    };
 
    fetch('/' + val + '/paciente/editar-tratamientos-pacientes', {
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
    <h3>Procedimientos que ha utilizado para controlar el dolor</h3>
    </div>
    
    <section class="section">
    <div class="card">
    <div class="card-body pb-0">

    <div class="row">
    <div class="col-11">
    <h8 class="text-primary">
    <b>Por favor, registre los procedimientos que ha recibido para el control del dolor, como bloqueos, cirugías u otros tratamientos.
    Incluya la fecha aproximada de cada procedimiento, los resultados que experimentó y cualquier efecto adverso que haya notado.</b>
    </h8>
    </div>

    <div class="col-1">
    <button onclick="agregarProcedimientosDolor(<?=$data['idPaciente'];?>,'<?=$data['idRol'];?>')" class="btn icon btn-success float-end"> <i data-feather="plus" width="20"></i> </button>
    </div>

    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>

    <div class="col-12">
    <div class="table-responsive">
    <table class="table table-striped" id="table_procedimientos">
    <thead>
    <tr>
    <th class="text-center align-middle" >Procedimiento</th>
    <th class="text-center align-middle">Fecha</th>
    <th class="text-center align-middle">Resultados (Funciono, no funciono, efectos adversos...)</th>
    <th class="text-center align-middle" width="30px"><i data-feather="trash-2"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php
    try {
    $stmt = $bd->query("SELECT * FROM pac_procedimientos_dolor WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha DESC");
    $procedimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

    foreach ($procedimientos as $procedimiento): 
    $idProcedimiento = $procedimiento['id'];
    $nombreProcedimiento = $procedimiento['procedimiento'];
    $fecha = $procedimiento['fecha'];
    $resultados = $procedimiento['resultados'];
    ?>
    <tr>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="text" onchange="editarProcedimientosDolor(<?=$idProcedimiento?>, this, 1,'<?=$data['idRol'];?>')" value="<?=$nombreProcedimiento ?? ''?>" placeholder="Escribe la cirugía...">
    </td>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="date" onchange="editarProcedimientosDolor(<?=$idProcedimiento?>, this, 2,'<?=$data['idRol'];?>')" value="<?=$fecha ?? ''?>">
    </td>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="text" onchange="editarProcedimientosDolor(<?=$idProcedimiento?>, this, 3,'<?=$data['idRol'];?>')" value="<?=$resultados ?? ''?>" placeholder="Escribe los resultados...">
    </td>
    
    <td class="text-center align-middle p-2">
    <i data-feather="trash-2" class="pointer" onclick="eliminarProcedimientosDolor(<?=$idProcedimiento?>,'<?=$data['idRol'];?>')"></i>
    </td>

    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>



    <div class="col-12">
    <hr>
    <h8 class="text-primary">
    <b>¿Ha recibido alguno de los siguientes tratamientos?
    <br>
    Por favor, registre los procedimientos que ha recibido para el control del dolor, como bloqueos, cirugías u otros.
    Incluya la fecha aproximada de cada procedimiento, los resultados obtenidos y cualquier efecto adverso que haya experimentado.</b>
    </h8>
    </div>

    <div class="col-12 pb-0">
    <div class="table-responsive">
    <table class="table table-striped" id="table_tratamientos">
    <thead>
    <tr>
    <th class="text-start align-middle" width="160px">Tratamiento</th>
    <th class="text-center align-middle" width="220px">Utilizó (Sí/No)</th>
    <th class="text-center align-middle" width="220px">Resultado</th>
    <th class="text-start align-middle">Comentarios</th>
    </tr>
    </thead>
    <tbody>
    <?php
    try {

    $stmt2 = $bd->prepare("SELECT 
    respuestas_procedimientos_dolor.id AS idRespuesta,
    modulo_procedimientos_dolor.procedimiento AS nombre_tratamiento, 
    respuestas_procedimientos_dolor.utilizo,
    respuestas_procedimientos_dolor.resultado,
    respuestas_procedimientos_dolor.comentarios
    FROM respuestas_procedimientos_dolor
    INNER JOIN modulo_procedimientos_dolor 
    ON respuestas_procedimientos_dolor.id_tratamiento = modulo_procedimientos_dolor.id
    WHERE respuestas_procedimientos_dolor.id_paciente = :idPaciente");
    
    $stmt2->execute(['idPaciente' => $data['idPaciente']]); 
    $procedimientotb = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

    foreach ($procedimientotb as $procedimientostb): 
    $idRespuesta = $procedimientostb['idRespuesta'];
    $nombreProcedimiento = $procedimientostb['nombre_tratamiento'];
    $utilizoOP = $procedimientostb['utilizo'];
    $resultadoOP = $procedimientostb['resultado'];
    $comentariosOP = $procedimientostb['comentarios'];

    ?>
    <tr>

    <td class="text-start align-middle p-2">
    <?=$nombreProcedimiento ?? ''?> 
    </td>
 
    <td class="text-center align-middle p-2">
    <select class="form-select opcion-tratamiento" onchange="editarTratamientosPAC(<?=$idRespuesta?>, this, 1,'<?=$data['idRol'];?>')" >
    <option value="" disabled selected <?php if ($utilizoOP === '') echo 'selected'; ?>>Selecciona una opción...</option>
    <option value="Si" <?php if ($utilizoOP == 'Si') echo 'selected'; ?>>Sí</option>
    <option value="No" <?php if ($utilizoOP == 'No') echo 'selected'; ?>>No</option>
    </select>
    </td>

    <td class="text-center align-middle p-2">
    <select class="form-select opcion-resultado" onchange="editarTratamientosPAC(<?=$idRespuesta?>, this, 2,'<?=$data['idRol'];?>')" <?= $utilizoOP == "Si" ? '' : 'disabled' ?>>
    <option value="" disabled selected <?php if ($resultadoOP === '') echo 'selected'; ?>>Selecciona una opción...</option>
    <option value="Mejoro" <?php if ($resultadoOP == 'Mejoro') echo 'selected'; ?>>Mejoro</option>
    <option value="Sin cambios" <?php if ($resultadoOP == 'Sin cambios') echo 'selected'; ?>>Sin cambios</option>
    <option value="Empeoro" <?php if ($resultadoOP == 'Empeoro') echo 'selected'; ?>>Empeoro</option>
    </select>
    </td>

    <td class="text-center align-middle p-2">
    <input class="form-control text-start opcion-comentarios" type="text" onchange="editarTratamientosPAC(<?=$idRespuesta?>, this, 3,'<?=$data['idRol'];?>')" value="<?=$comentariosOP ?? ''?>"  <?= $utilizoOP == "Si" ? '' : 'disabled' ?> placeholder="Escribe aqui tus comentario...">
    </td>
 
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>

    </div>
    </div>

    <?php
    if($data['idRol'] == "Paciente"){
    try {
    $stmt = $bd->query("SELECT * FROM pac_historia_clinica_finalizar WHERE id_modulo = 8 AND id_paciente = '".$data['idPaciente']."'");
    $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

  
    if (empty($modulos)): 
    ?>
    <div class="card-footer">
    <button class="btn btn-success float-end fs-5" onclick="FinalizarModuloPaciente(8, <?=$data['idPaciente'];?>)">Finalizar</button>
    </div>
    <?php endif; 
    }
    ?>

    </div>
    </section>
    </div>

    <!----- FOOTER ---------->
    <?php include_once __DIR__ . '/../components/footer-mvsd.php';?>

    </div>
    </div>

    </div>
    </div>

    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script>    
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_JS;?>main.js"></script>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".opcion-tratamiento").forEach(select => {
            select.addEventListener("change", function() {
                let row = this.closest("tr");
                let tratamiento = row.querySelector("td:first-child").innerText.trim();
                let tipoResultado = row.querySelector(".opcion-resultado");
                let inputComentario = row.querySelector(".opcion-comentarios");

                // Si el usuario elige "No", vaciar y deshabilitar los otros campos
                if (this.value === "No") {
                    tipoResultado.value = "";
                    tipoResultado.disabled = true;
                    inputComentario.value = "";
                    inputComentario.disabled = true;
                    return; // Detener la ejecución aquí
                }

                tipoResultado.disabled = this.value !== "Si";
                inputComentario.disabled = this.value !== "Si";

            });
        });
    });
    </script>


    <script>
    let table1 = document.querySelector('#table_procedimientos');
    let dataTable = new simpleDatatables.DataTable(table1,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
	select: 1, sort: "desc"
	},
    { select: [0,1,2,3], sortable: false },

	]
    });


    let table2 = document.querySelector('#table_tratamientos');
    let dataTabl2 = new simpleDatatables.DataTable(table2,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
	select: 1, sort: "desc"
	},
    { select: [1,2,3], sortable: false },

	]
    });
    </script>

    </body>
    </html>
