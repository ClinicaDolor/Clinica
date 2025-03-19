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
    <script>

    document.addEventListener("DOMContentLoaded", function() {
        tableLaboratorio()
        tableRecetas()
    });

     function tableRecetas(){

        const usuarioDiv = document.getElementById('main');
        const idPaciente = usuarioDiv.getAttribute('data-paciente');

        fetch(`/buscar/tabla-recetas/${encodeURIComponent(idPaciente)}`)
            .then(response => {
            if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.text();
            })
            .then(data => {

                const resultsContainer = document.getElementById('conteRecetas');
                resultsContainer.innerHTML = data;

                const tabla = document.querySelector("#tableRecetas");
                if (tabla) {
                    dataTable = new simpleDatatables.DataTable(tabla,{
                        searchable: true,
                        fixedHeight: true,
                        perPageSelect: false,
                        searchable: false,
                        columns: [
                        {
                            select: 1, sort: "desc"
                        }
                        ]
                    });
                }          
        });
    }

    function tableLaboratorio(){
        const usuarioDiv = document.getElementById('main');
        const idPaciente = usuarioDiv.getAttribute('data-paciente');

        fetch(`/buscar/tabla-laboratorio/${encodeURIComponent(idPaciente)}`)
            .then(response => {
            if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.text();
            })
            .then(data => {

                const resultsContainer = document.getElementById('conteLaboratorio');
                resultsContainer.innerHTML = data;

                const tabla = document.querySelector("#tableLaboratorio");
                if (tabla) {
                    dataTable = new simpleDatatables.DataTable(tabla,{
                        searchable: true,
                        fixedHeight: true,
                        perPageSelect: false,
                        searchable: false,
                        columns: [
                        {
                            select: 1, sort: "desc"
                        }
                        ]
                    });
                }          
        });
    }

        function NuevoPin(idPaciente){

        const parametros = {
        idPaciente : idPaciente
        };

        fetch('/clinica/paciente/insert-pin', {
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

        function NuevaNotaSubsecuente(idPaciente){
            window.location.href = '/clinica/nota-subsecuente/paciente/' + idPaciente;
        }

        function DetalleNota(idNota){
            window.location.href = '/clinica/nota-subsecuente/' + idNota;
        }

        function NuevaReceta(idPaciente){
            window.location.href = '/clinica/receta/paciente/' + idPaciente;
        }

        function DetalleReceta(idReceta){
            window.location.href = '/clinica/receta/' + idReceta;
        }

        function NuevoLaboratorio(idPaciente){
            window.location.href = '/clinica/laboratorio/paciente/' + idPaciente;
        }

        function DetalleLaboratorio(idLaboratorio){
            window.location.href = '/clinica/laboratorio/' + idLaboratorio;
        }
    </script>


 </head>

    <body>

   <div id="app">
        
    <?=$data['sidebar'];?>

    <div id="main" data-paciente="<?=$data['idPaciente'];?>">
    <!----- BUSCADOR DE LA BARRA DE NAVEGACION ---------->
    <?php include_once __DIR__ . '/../components/search-bar-doctor.php';?>
            
    <div class="main-content container-fluid">

    <div class="page-title">
    <h3><?=$data['title'];?></h3>
    </div>

    <div class="row mt-4">

    <div class="col-12 col-sm-6">
    <div class="card">
        
    <div class="card-header">
    <h5 class="card-title">Información del paciente</h5>
    </div>
    <div class="card-body">

    <div class="row">
    <div class="col-12 mb-3">
    <div class="text-secondary">Nombre Paciente:</div>
    <h4><?=$data['nombre_paciente'];?></h4>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">Fecha Alta:</div>
    <h5 class=""><?=(new DateTime($data['fecha_alta']))->format('d/m/Y');[0];?></h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">Fecha Nacimiento:</div>
    <h5 class=""><?=date("d/m/Y", strtotime($data['fecha_nacimiento']));?></h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">Edad:</div>
    <h5 class=""><?=$data['edad'];?> años</h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">Sexo:</div>
    <h5 class=""><?=($data['sexo'] == 'M')? 'Masculino': 'Femenino';?></h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">Estado Civil:</div>
    <h5 class=""><?=$data['estado_civil'];?></h5>
    </div>

    <div class="col-12 col-sm-4 mb-3">
    <div class="text-secondary">CURP:</div>
    <h5 class=""><?=$data['curp'];?></h5>
    </div>

    </div>

    <h5 class="text-success mt-2">Contacto del paciente</h5>

    <div class="row">

    <div class="col-12 col-sm-4">
    <div class="text-secondary">Email:</div>
    <h5 class=""><?=$data['email'];?></h5>
    </div>

    <div class="col-12 col-sm-4">
    <div class="text-secondary">Telefono:</div>
    <h5 class=""><?=$data['telefono'];?></h5>
    </div>

    <div class="col-12 col-sm-4">
    <div class="text-secondary">Celular:</div>
    <h5 class=""><?=$data['celular'];?></h5>
    </div>

    </div>

    </div>
    </div>
    
    <!-- Inicio motivo -->
    <div class="card">

        <div class="card-header">
        <h5 class="card-title">Motivo por el que Solicita Atención en la Clinica de Dolor y Cuidados Paliativos</h5>
        </div>

    <div class="card-body">
    <h5><?=empty($data['motivo_atencion'])? 'S/I': $data['motivo_atencion'];?></h5>
    </div>                    
    </div>
    <!-- Fin motivo -->
    
    <!-- Inicio PIN -->
    <div class="card">   
    <div class="card-header">

    <div class="row">
    <div class="col-10">
    <h5 class="card-title">Pin de Acceso para Pacientes</h5>
    </div>

    <div class="col-2">
    <button class="btn icon btn-success float-end" onclick="NuevoPin(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
    </div>
    </div>
                   
    </div>
                        <div class="card-body">
                      
                        <?php
                        $hoy = new DateTime();
                        try {
                            $stmt = $bd->query("SELECT * FROM pc_paciente_acceso WHERE paciente_id = '".$data['idPaciente']."' ORDER BY fecha_creacion DESC");
                            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            die("Error en la consulta: " . $e->getMessage());
                        }
                        ?>

                        <table class="table table-sm table-striped pb-0 mb-0" id="tablePin">
                            <thead>
                                <tr>
                                    <th class="text-center">PIN</th>
                                    <th class="text-center">Fecha creación</th>
                                    <th class="text-center">Fecha expiración</th>
                                    <th class="text-center">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            
                            foreach ($registros as $registro): 
                            $fechaExpiracion = new DateTime($registro['fecha_expiracion']);
                            if ($hoy > $fechaExpiracion){
                                $pin = '******';
                                $estatus = '<span class="badge bg-danger">Cancelado</span>';
                            }else{
                                $pin = '<label class="text-primary fw-bold">cdp'.$data['idPaciente'].'</label>';
                                $estatus = '<span class="badge bg-success">Activo</span>';
                            }
                            ?>
                                <tr>
                                    <td class="text-center align-middle"><?=$pin;?></td>
                                    <td class="text-center align-middle"><?=(new DateTime($registro['fecha_creacion']))->format('d/m/Y');?></td>
                                    <td class="text-center align-middle"><b><?=(new DateTime($registro['fecha_expiracion']))->format('d/m/Y');?></b></td>
                                    <td class="text-center align-middle"><?=$estatus;?></td>
                                </tr>
                            <?php endforeach; ?> 
                            </tbody>
                        </table>
                            
                        </div>
    </div>
    <!-- Fin PIN -->

    </div>
    <!-- Inicio Clinica -->
    <div class="col-12 col-sm-6">
    
    <div class="card">
        <div class="card-header">

        <div class="row">
            <div class="col-10">
            <h5 class="card-title">Nota Subsecuente</h5>
            </div>

            <div class="col-2">
            <button class="btn icon btn-success float-end" onclick="NuevaNotaSubsecuente(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
            </div>
            </div>

        </div>
        <div class="card-body">

        <?php
            try {
                $query_notas = $bd->query("SELECT * FROM nota_subsecuente WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha_hora DESC");
                $nota_registros = $query_notas->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error en la consulta: " . $e->getMessage());
            }
        ?>
        <table class="table table-sm table-striped table-hover pb-0 mb-0" id="tableNota">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nota_registros as $data_nota): ?>
                <tr onclick="DetalleNota(<?=$data_nota['id']?>)">
                    <td class="text-center"><?=$data_nota['id']?></td>
                    <td><?=(new DateTime(datetime: $data_nota['fecha_hora']))->format('d/m/Y h:i a');?></td>
                </tr>
                <?php endforeach; ?>    
            </tbody>
        </table>

        </div>                    
        </div>

        <div class="card">
        <div class="card-header">

        <div class="row">
            <div class="col-10">
            <h5 class="card-title">Laboratorio</h5>
            </div>

            <div class="col-2">
            <button class="btn icon btn-success float-end" onclick="NuevoLaboratorio(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
            </div>
            </div>

        </div>
        <div class="card-body">
        <div id="conteLaboratorio"></div>
        </div>                    
        </div>
        
        <!-- Inicio Recetas -->
        <div class="card">
        <div class="card-header">

        <div class="row">
            <div class="col-10">
            <h5 class="card-title">Receta Medica</h5>
            </div>

            <div class="col-2">
            <button class="btn icon btn-success float-end" onclick="NuevaReceta(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
            </div>
            </div>

        </div>
        <div class="card-body">

        <div id="conteRecetas"></div>

        </div>                    
        </div>
        <!-- Fin Recetas -->

    </div>
    <!-- Fin Clinica -->

    <div class="col-12">   
    
    </div>

    <div class="col-12">
                    <!-- Card Modulos --->
                    <div class="card">
                    
                    <div class="card-header">
                    <h5 class="card-title">Historia Clinica</h5>
                    
                    </div>
                    <div class="card-body">
                    <?php
                        try {
                            $stmt = $bd->query("SELECT * FROM historia_clinica_modulos");
                            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            die("Error en la consulta: " . $e->getMessage());
                        }
                        ?>
                        <table class='table table-sm table-striped pb-0 mb-0' id="table2">
                            <thead>
                                <tr>
                                    <th>Nombre del modulo</th>
                                    <th>Estatus</th>
                                    <th class="text-center" width="20px"><i data-feather="edit" width="20"></i> </th>
                                    <th class="text-center" width="20px"><i data-feather="download-cloud" width="20"></i> </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($registros as $registro): 
                            
                            ?>
                            <tr>
                            <td><b><?=$registro['nombre']?></b></td>
                            <td>

                            <div class="progress bg-light rounded-pill" style="height: 15px;">
    <div class="progress-bar bg-success rounded-pill text-white fw-bold" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
    </div>

                            </td>
                            <td class="text-center"><a href="<?=$registro['url'].$data['idPaciente']?>"><i data-feather="edit" width="20"></i></a></td>
                            <td class="text-center"><a href=""><i data-feather="download-cloud" width="20"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
            </div>
        
        </div>

            </div>

        <!----- FOOTER ---------->
        <?php include_once __DIR__ . '/../components/footer-mvsd.php';?>

        </div>
   
        </div>
        
    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script>    
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_JS;?>main.js"></script>
    <script src="<?=RUTA_JS?>search-main.js"></script>
    
    <script>

let tablePin = document.querySelector('#tablePin');
let dataTablePin = new simpleDatatables.DataTable(tablePin,{
    fixedHeight: true,
    perPageSelect: false,
    searchable: false,
    columns: [
    {
        select: 1, sort: "desc"
    }
    ]
});

let tableNota = document.querySelector('#tableNota');
let dataTableNota = new simpleDatatables.DataTable(tableNota,{
    fixedHeight: true,
    perPageSelect: false,
    searchable: false,
    columns: [
    {
        select: 1, sort: "desc"
    }
    ]
});




</script>
    
</body>
</html>

