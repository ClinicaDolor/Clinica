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
    </head>

    <body>
    <div class="LoaderPage"></div>
    <div id="app">
    <?=$data['sidebar'];?>

    <div id="main">
    <!----- BUSCADOR DE LA BARRA DE NAVEGACION ---------->
    <?php include_once __DIR__ . '/../components/search-bar-doctor.php';?>
            
    <div class="main-content container-fluid">
    <div class="page-title">
    <h3><?=$data['title'];?></h3>
    </div>
            
    <section class="section mt-4">
    <?php 
    /*print_r($data);
    echo "</br>".$data['datos']['rol'];*/
    ?>
            
    <div class="card">
    <div class="card-header text-light pb-1">
    <h5 class="fw-bold text-primary mt-2 "><?=$data['nombre_paciente'];?></h5>
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
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-start">Nombre del modulo</th>
                            <th class="text-center">% de cumplimiento</th>
                            <th class="text-center" width="20"><i data-feather="edit" width="20"></i> </th>
                            <th class="text-center" width="20"><i data-feather="download-cloud" width="20"></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registros as $registro): ?>
                    <tr>
                    <td class="text-center"><?=$registro['id']?></td>
                    <td class="text-start"><b><?=$registro['nombre']?></b></td>
                    <td  class="text-center">
                    <div class="progress bg-light rounded-pill" style="height: 15px;">
    <div class="progress-bar bg-success rounded-pill text-white fw-bold" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
    </div>

                    </td>
                    <td class="text-center"><a href=""><i data-feather="edit" width="20"></i></a></td>
                    <td class="text-center"><a href=""><i data-feather="download-cloud" width="20"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

            </section>
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
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1,{
	searchable: true,
    fixedHeight: true,
    columns: [
    { select: [2,3], sortable: false },
	]
});

    </script>
</body>
</html>

