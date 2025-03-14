<?php 
use App\Config\Database;
use App\Models\RecetaModel;
$bd = Database::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['title'];?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="<?=RUTA_CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/simple-datatables/style.css">
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/quill/quill.snow.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    
    <style>
        .editor{
            font-size: 20px;
            height: 250px;
        }
    </style>
    <script>
        function AgregarReceta(idPaciente){

            const contenidoReceta = document.querySelector('.ql-editor').innerHTML;
            document.querySelector('.ql-editor').style.border = "";

            if(contenidoReceta != '<p><br></p>'){

            const parametros = {
            idPaciente : idPaciente,
            contenidoReceta : contenidoReceta
            };

            fetch('/clinica/paciente/insert-receta', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(parametros)
            })
            .then(response => response.json())
            .then(data => {

            if (data.resultado) {

                idReceta = data.mensaje;
                DetalleReceta(idReceta)
                document.querySelector('.ql-editor').value = "";

                window.open('/pdf/receta/' + idReceta, '_blank');
                
            
            } else {
                document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
            }
          
        });

    }else{
        document.querySelector('.ql-editor').style.border = "2px solid #d44e31";
    }
    }

    function DetalleReceta(idReceta){

        fetch(`/buscar/receta/${encodeURIComponent(idReceta)}`)
                .then(response => {
                if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
                })
                .then(data => {

                    const resultsContainer = document.getElementById('detalleReceta');
                    resultsContainer.innerHTML = data;

                    feather.replace();

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

            <section>
            <div class="row mt-3">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-sm-4">
                                <label class="text-primary"><small>Nombre Paciente:</small></label>
                                <div class="fs-5"><?=$data['nombre_paciente'];?></div>
                                </div>
                            
                                <div class="col-12 col-sm-2">
                                <label class="text-primary"><small>Fecha Alta:</small></label>
                                <div class="fs-5"><?=(new DateTime($data['fecha_alta']))->format('d/m/Y');[0];?></div>
                                </div>

                                <div class="col-12 col-sm-2">
                                <label class="text-primary"><small>Fecha Nacimiento:</small></label>
                                <div class="fs-5"><?=date("d/m/Y", strtotime($data['fecha_nacimiento']));?></div>
                                </div>

                                <div class="col-12 col-sm-2">
                                <label class="text-primary"><small>Edad:</small></label>
                                <div class="fs-5"><?=$data['edad'];?> años</div>
                                </div>
                            
                            <div class="col-12 col-sm-2">
                            <label class="text-primary"><small>Sexo:</small></label>
                            <div class="fs-5"><?=($data['sexo'] == 'M')? 'Masculino': 'Femenino';?></div>
                            </div>

                            </div>                

                        </div>
                    </div>

                </div>
            </div>
            </section>

            <section>

            <div class="row">
                <div class="col-12 col-sm-5">

                <div class="card">
                <div class="card-header text-light">
                <h4 class="card-title">Recetas</h4>
                </div>
                <div class="card-body">

                <?php
                        try {
                            $stmt = $bd->query("SELECT * FROM receta_medica WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha_hora DESC");
                            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            die("Error en la consulta: " . $e->getMessage());
                        }
                ?>

                <table class="table table-striped table-hover table-sm pb-0 mb-0" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registros as $registro): ?>
                        <tr onclick="DetalleReceta(<?=$registro['id']?>)">
                            <td class="text-center"><?=$registro['id']?></td>
                            <td><?=(new DateTime(datetime: $registro['fecha_hora']))->format('d/m/Y h:i a');?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                </div>
                </div>

                </div>
                <div class="col-12 col-sm-7">
                        
                <div class="card">
                    <div class="card-header text-light">
                    <h4 class="card-title">Detalle de la Receta</h4>
                    </div>
                    <div class="card-body">

                        <div id="detalleReceta">
                            <?php
                            $model = new RecetaModel();
                            echo $model->ultimaReceta($data['idPaciente']);
                            ?>
                        </div>
                        
                    </div>
                </div>

                <div class="card">
                <div class="card-header text-light">
                <h4 class="card-title">Nueva Receta</h4>
                </div>
                <div class="card-body">

                <div id="snow" class="editor"></div>
                <div class="text-end mt-3"><button class="btn btn-success" onclick="AgregarReceta(<?=$data['idPaciente'];?>)">Agregar Receta</button></div>
                <div id="mensaje"></div>
                </div>
                </div>

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
    <script src="<?=RUTA_JS;?>main.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/quill/quill.min.js"></script>
    <script>

    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1,{
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

        var snow = new Quill('#snow', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic'], 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ],
        },
        bounds: '#snow',
        height: '500px',
        });

        function Imprimir(){

        var myModal = new bootstrap.Modal(document.getElementById('modalReceta'), {
        keyboard: false
        });
        myModal.show();

        }

    </script>
</body>
</html>

