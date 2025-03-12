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
                    <div class="card-header text-light">Información del paciente</div>
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
                </div>
                <div class="col-12 col-sm-6">
                    <div class="card">
                    <div class="card-header text-light">Pin de acceso para pacientes</div>
                        <div class="card-body">

                        <div class="text-end"><button class="btn icon btn-success" onclick="NuevoPin(<?=$data['idPaciente'];?>)"><i data-feather="plus" width="20"></i> PIN </button></div>
                        <div id="mensaje" class="text-center text-danger"></div>
                        <?php
                        $hoy = new DateTime();
                        try {
                            $stmt = $bd->query("SELECT * FROM pc_paciente_acceso WHERE paciente_id = '".$data['idPaciente']."' ");
                            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            die("Error en la consulta: " . $e->getMessage());
                        }
                        ?>

                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>PIN</th>
                                    <th>Fecha creación</th>
                                    <th>Fecha expiración</th>
                                    <th>Estatus</th>
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
                                $pin = 'cdp'.$data['idPaciente'];
                                $estatus = '<span class="badge bg-success">Activo</span>';
                            }
                                
                            ?>
                                <tr>
                                    <td><?=$pin;?></td>
                                    <td><?=(new DateTime($registro['fecha_creacion']))->format('d/m/Y');?></td>
                                    <td><b><?=(new DateTime($registro['fecha_expiracion']))->format('d/m/Y');?></b></td>
                                    <td><?=$estatus;?></td>
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
    <script src="<?=RUTA_JS;?>main.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
		select: 1, sort: "desc"
	}
	]
});


    </script>
</body>
</html>

