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
    <link rel="stylesheet" href="<?=RUTA_CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/simple-datatables/style.css">
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">

    <script>
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

        function NuevaReceta(idPaciente){
        window.location.href = '/clinica/receta/paciente/' + idPaciente;
        }
    </script>


 </head>
<body>
    <div id="app">
        
        <?=$data['sidebar'];?>

        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success me-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown nav-icon me-2">
                            <a href="" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="mail"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" >
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    <img src="assets/images/avatar/avatar-s-1.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, Saugi</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <div class="main-content container-fluid">
            <div class="page-title">
                <h3><?=$data['title'];?></h3>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-6">
                    <div class="card">
                    <div class="card-header">
                    <h4 class="card-title">Información del Paciente</h4>
                </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-sm-12">
                                <label class="text-primary"><small>Nombre Paciente:</small></label>
                                <div class="fs-4"><?=$data['nombre_paciente'];?></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 col-sm-4">
                                <label class="text-primary"><small>Fecha Alta:</small></label>
                                <div class="fs-5"><?=(new DateTime($data['fecha_alta']))->format('d/m/Y');[0];?></div>
                                </div>

                                <div class="col-12 col-sm-4">
                                <label class="text-primary"><small>Fecha Nacimiento:</small></label>
                                <div class="fs-5"><?=date("d/m/Y", strtotime($data['fecha_nacimiento']));?></div>
                                </div>

                                <div class="col-12 col-sm-4">
                                <label class="text-primary"><small>Edad:</small></label>
                                <div class="fs-5"><?=$data['edad'];?> años</div>
                                </div>

                            </div>

                            <div class="row mt-2">

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>Sexo:</small></label>
                            <div class="fs-5"><?=($data['sexo'] == 'M')? 'Masculino': 'Femenino';?></div>
                            </div>

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>Estado Civil:</small></label>
                            <div class="fs-5"><?=$data['estado_civil'];?></div>
                            </div>

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>CURP:</small></label>
                            <div class="fs-5"><?=$data['curp'];?></div>
                            </div>

                            </div>

                            <div class="mt-3 fs-6 text-success">Contacto del paciente:</div>

                            <div class="row mt-3">

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>Email:</small></label>
                            <div class="fs-5"><?=$data['email'];?></div>
                            </div>

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>Telefono:</small></label>
                            <div class="fs-5"><?=$data['telefono'];?></div>
                            </div>

                            <div class="col-12 col-sm-4">
                            <label class="text-primary"><small>Celular:</small></label>
                            <div class="fs-5"><?=$data['celular'];?></div>
                            </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">
                    
                    <div class="card-header">
                    <h4 class="card-title">Pin de Acceso para Pacientes
                    <button class="btn icon btn-success float-end" onclick="NuevoPin(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
                    </h4>
                    
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

                        <table class="table table-sm table-striped pb-0 mb-0" id="table1">
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

                    <!-- Card Modulos --->

                    <div class="card">
                    
                    <div class="card-header">
                    <h4 class="card-title">Historia Clinica</h4>
                    
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
                        <table class='table table-sm table-striped' id="table2">
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

                            <div class="progress progress-link">
                            <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
                <div class="col-12 col-sm-6">

                    <div class="card">
                    <div class="card-body">

                    <label class="text-primary"><small>Motivo por el que Solicita Atención en la Clinica de Dolor y Cuidados Paliativos</small></label>
                    <div class="fs-5"><?=empty($data['motivo_atencion'])? 'S/I': $data['motivo_atencion'];?></div>

                    </div>                    
                    </div>

                    <div class="card">
                    <div class="card-header">

                    <h4 class="card-title">Nota Subsecuente
                    <button class="btn icon btn-success float-end" onclick="NuevaNotaSubsecuente(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
                    </h4>                        
                    
                    </div>
                    <div class="card-body">

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>

                    </div>                    
                    </div>

                    <div class="card">
                    <div class="card-header">
                    <h4 class="card-title">Receta Medica
                        <button class="btn icon btn-success float-end" onclick="NuevaReceta(<?=$data['idPaciente'];?>)"> <i data-feather="plus" width="20"></i> </button>
                    </h4>
                    </div>
                    <div class="card-body">
                    <?php
                        try {
                            $query_receta = $bd->query("SELECT * FROM receta_medica WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha_hora DESC");
                            $receta_registros = $query_receta->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            die("Error en la consulta: " . $e->getMessage());
                        }
                ?>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($receta_registros as $data_receta): ?>
                            <tr>
                                <td class="text-center"><?=$data_receta['id']?></td>
                                <td><?=(new DateTime(datetime: $data_receta['fecha_hora']))->format('d/m/Y h:i a');?></td>
                            </tr>
                            <?php endforeach; ?>    
                        </tbody>
                    </table>

                    </div>                    
                    </div>

                </div>
            </div>

        </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; tratamientosdeldolor.org</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script>    
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_JS;?>main.js"></script>
    
</body>
</html>

