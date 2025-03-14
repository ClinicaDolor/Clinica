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
                <h3>Pacientes</h3>
            </div>
            <section class="section">
                <?php 
                /*print_r($data);
                echo "</br>".$data['datos']['rol'];*/
                ?>

            <div class="card">
            <div class="card-header">
               Lista de pacientes
               <div class="float-end">
                <a href="paciente/nuevo" class="btn icon btn-success"> <i data-feather="plus" width="20"></i> Nuevo </a>
               </div>
            </div>
            <div class="card-body">
                <?php
                try {
                    $stmt = $bd->query("SELECT * FROM pc_paciente");
                    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die("Error en la consulta: " . $e->getMessage());
                }
                ?>
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha Alta</th>
                            <th>Nombre Completo</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Fecha nacimiento</th>
                            <th class="text-center" width="20"><i data-feather="clipboard" width="20"></i> </th>
                            <th class="text-center" width="20"><i data-feather="key" width="20"></i> </th>
                            <th class="text-center" width="20"><i data-feather="grid" width="20"></i> </th>
                            <th class="text-center" width="20"><i data-feather="edit" width="20"></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registros as $registro): ?>
                    <tr>
                    <td><?=$registro['id']?></td>
                    <td><?=$registro['fecha_alta']?></td>
                    <td><b><?=$registro['nombre_completo']?></b></td>
                    <td><?=$registro['edad']?> años</td>
                    <td><?=$registro['sexo']?></td>
                    <td><?=$registro['fecha_nacimiento']?></td>
                    <td class="text-center"><a href="<?=SERVIDOR?>clinica/paciente/<?=$registro['id']?>"><i data-feather="clipboard" width="20"></i></a></td>
                    <td class="text-center"><a href="<?=SERVIDOR?>clinica/paciente/pin/<?=$registro['id']?>"><i data-feather="key" width="20"></i></a></td>
                    <td class="text-center"><a href="<?=SERVIDOR?>clinica/modulos/paciente/<?=$registro['id']?>"><i data-feather="grid" width="20"></i></a></td>
                    <td class="text-center"><a href="<?=SERVIDOR?>clinica/paciente/editar/<?=$registro['id']?>"><i data-feather="edit" width="20"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

            </section>
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
    

    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1,{
	searchable: true,
    fixedHeight: true,
	columns: [
	{
		select: 1, sort: "desc"
	},
    { select: [6,7,8], sortable: false },
	],
});


    </script>
</body>
</html>

