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
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    </head>

    <body>
    <div id="app">
    <?=$data['sidebar'];?>

    <div id="main">
    <!----- BUSCADOR DE LA BARRA DE NAVEGACION ---------->
    <?php include_once __DIR__ . '/../components/search-bar-doctor.php';?>
            <div class="main-content container-fluid">
            <div class="page-title">
                <h3><?=$data['title'];?></h3>
            </div>

            <section class="mt-3">

            <div class="row">
                <div class="col-12 col-sm-7">

                    <div class="card">
        
                    <div class="card-header text-light pb-1">
    <h5 class="fw-bold text-primary mt-2 ">Información del paciente</h5>
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

    <h5 class="fw-bold text-primary mt-2">Contacto del paciente</h5>

    <div class="row ">

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

                </div>
                <div class="col-12 col-sm-5">
                        
                <div class="card">
                    <div class="card-header">
                    <h5 class="fw-bold text-primary mt-2">Detalle de la Nota</h5>
                    </div>
                    <div class="card-body">

                    <div class="text-secondary">Fecha y Hora:</div>
                    <h5 class="mb-3"><?=(new \DateTime($data['fecha_hora_nota']))->format('d/m/Y h:i a');?></h5>

                    <div class="text-secondary">Nota subsecuente:</div>
                    <h5 class=""><?=$data['contenido_nota'];?></h5>
                       
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
    <script src="<?=RUTA_JS;?>/feather-icons/feather.min.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=RUTA_JS;?>app.js"></script> 
    <script src="<?=RUTA_JS;?>main.js"></script>
    <script src="<?=RUTA_JS?>search-main.js"></script>

</body>
</html>

