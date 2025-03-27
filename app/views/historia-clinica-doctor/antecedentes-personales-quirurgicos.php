<?php 
use App\Config\Database;
$bd = Database::getInstance();
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

    function agregarCirugiaPaciente(idPaciente, idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idPaciente : idPaciente,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/agregar-cirugia-antecedentes', {
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


    function editarCirugia(idCirugia, elemento, parametro, idRol) {
    let valor = elemento.value; 
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idCirugia : idCirugia,
    detalle : valor,
    edicion : parametro,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/editar-cirugia-antecedentes', {
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


    function eliminarCirugiaPaciente(idQuirurgico, idRol){
    const val = (idRol == "Paciente") ? "historia-clinica" : "clinica";

    const parametros = {
    idQuirurgico : idQuirurgico,
    idRol : idRol
    };

    fetch('/' + val + '/paciente/eliminar-cirugia-antecedentes', {
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
    <h3>Antecedentes Personales Quirúrgicos</h3>
    </div>
    
    <section class="section">
    <div class="card">
    <div class="card-body pb-0">

    <div class="row">
    <div class="col-11">
    <h8 class="text-primary">
    <b>Indique si le han realizado alguna cirugía y mencione las fechas, comenzando por la más reciente hasta la más antigua.</b>
    </h8>
    </div>

    <div class="col-1">
    <button onclick="agregarCirugiaPaciente(<?=$data['idPaciente'];?>,'<?=$data['idRol'];?>')" class="btn icon btn-success float-end"> <i data-feather="plus" width="20"></i> </button>
    </div>

    <div class="col-12">
    <div id="mensaje" class="text-center text-danger mt-2"></div>
    </div>

    <div class="col-12">
    <div class="table-responsive">
    <table class="table table-striped" id="table_cirugia">
    <thead>
    <tr>
    <th class="text-center align-middle" width="60px">Fecha</th>
    <th class="text-center align-middle">Cirugía</th>
    <th class="text-center align-middle">Observaciónes</th>
    <th class="text-center align-middle" width="30px"><i data-feather="trash-2"></i></th>
    </tr>
    </thead>
    <tbody>
    <?php
    try {
    $stmt = $bd->query("SELECT * FROM pc_antecedentes_quirurgicos WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha DESC");
    $quirurgicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

    foreach ($quirurgicos as $quirurgico): 
    $idQuirurgico = $quirurgico['id'];
    $fecha = $quirurgico['fecha'];
    $cirugia = $quirurgico['cirugia'];
    $observaciones = $quirurgico['observaciones'];
    ?>
    <tr>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="date" onchange="editarCirugia(<?=$idQuirurgico?>, this, 1,'<?=$data['idRol'];?>')" value="<?=$fecha ?? ''?>">
    </td>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="text" onchange="editarCirugia(<?=$idQuirurgico?>, this, 2,'<?=$data['idRol'];?>')" value="<?=$cirugia ?? ''?>" placeholder="Escribe la cirugía...">
    </td>

    <td class="text-center align-middle p-2">
    <input class="form-control text-center" type="text" onchange="editarCirugia(<?=$idQuirurgico?>, this, 3,'<?=$data['idRol'];?>')" value="<?=$observaciones ?? ''?>" placeholder="Escribe las observaciones...">
    </td>
    
    <td class="text-center align-middle p-2">
    <i data-feather="trash-2" class="pointer" onclick="eliminarCirugiaPaciente(<?=$idQuirurgico?>,'<?=$data['idRol'];?>')"></i>
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
    $stmt = $bd->query("SELECT * FROM pac_historia_clinica_finalizar WHERE id_modulo = 4 AND id_paciente = '".$data['idPaciente']."'");
    $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }

  
    if (empty($modulos)): 
    ?>
    <div class="card-footer">
    <button class="btn btn-success float-end fs-5" onclick="FinalizarModuloPaciente(4, <?=$data['idPaciente'];?>)">Finalizar</button>
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
    let table1 = document.querySelector('#table_cirugia');
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
    </script>

    </body>
    </html>
