<?php 
use App\Config\Database;
use App\Models\NotaSubsecuenteModel;
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
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/quill/quill.snow.css">
    <style>
        .editor{
            font-size: 20px;
            height: 250px;
        }
    </style>
    <script>
        function AgregarNota(idPaciente){

            const contenidoNota = document.querySelector('.ql-editor').innerHTML;
            document.querySelector('.ql-editor').style.border = "";

            if(contenidoNota != '<p><br></p>'){

            const parametros = {
            idPaciente : idPaciente,
            contenidoNota : contenidoNota
            };

            fetch('/clinica/paciente/insert-nota-subsecuente', {
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
        document.querySelector('.ql-editor').style.border = "2px solid #d44e31";
    }
    }

    function DetalleNota(idNota){

        fetch(`/buscar/nota-subsecuente/${encodeURIComponent(idNota)}`)
                .then(response => {
                if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
                })
                .then(data => {

                    const resultsContainer = document.getElementById('detalleNota');
                    resultsContainer.innerHTML = data;

                });

    } 
    </script>

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

            <section>
            <div class="row mt-3">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body pb-0">


                        <h5 class="fw-bold text-primary mt-2 ">Información del paciente</h5>

                            <div class="row">
                                <div class="col-12 col-sm-4">
                                <div class="text-secondary">Nombre Paciente:</div>
                                <h4><?=$data['nombre_paciente'];?></h4>
                                </div>
                            
                                <div class="col-12 col-sm-2">
                                <div class="text-secondary">Fecha Alta:</div>
                                <h4><?=(new DateTime($data['fecha_alta']))->format('d/m/Y');[0];?></h4>

                                </div>

                                <div class="col-12 col-sm-2">
                                <div class="text-secondary">Fecha Nacimiento:</div>
                                <h4><?=date("d/m/Y", strtotime($data['fecha_nacimiento']));?></h4>

                                <label class="text-primary"><small></small></label>
                                </div>

                                <div class="col-12 col-sm-2">
                                <div class="text-secondary">Edad:</div>
                                <h4><?=$data['edad'];?> años</h4>

                                </div>
                            
                            <div class="col-12 col-sm-2">
                            <div class="text-secondary">Sexo:</div>
                            <h4><?=($data['sexo'] == 'M')? 'Masculino': 'Femenino';?></h4>

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
                <h5 class="fw-bold text-primary mt-2 ">Notas Subsecuentes</h5>
                </div>
                <div class="card-body">

                <?php
                        try {
                            $stmt = $bd->query("SELECT * FROM nota_subsecuente WHERE id_paciente = '".$data['idPaciente']."' ORDER BY fecha_hora DESC");
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
                        <tr onclick="DetalleNota(<?=$registro['id']?>)">
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
                    <h5 class="fw-bold text-primary mt-2 ">Detalle de la Nota</h5>

                    </div>
                    <div class="card-body">
                        <div id="detalleNota">
                        <?php
                            $model = new NotaSubsecuenteModel();
                            echo $model->ultimaNota($data['idPaciente']);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                <div class="card-header text-light">
                <h5 class="fw-bold text-primary mt-2 ">Nueva Nota</h5>
                </div>
                <div class="card-body">

                <div id="snow" class="editor"></div>
                <div class="text-end mt-3"><button class="btn btn-success" onclick="AgregarNota(<?=$data['idPaciente'];?>)">Agregar Nota</button></div>
                <div id="mensaje"></div>
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
    <script src="<?=RUTA_PUBLIC;?>libs/simple-datatables/simple-datatables.js"></script>
    <script src="<?=RUTA_PUBLIC;?>libs/quill/quill.min.js"></script>
    <script src="<?=RUTA_JS?>search-main.js"></script>
    <script src="<?=RUTA_JS?>search-main.js"></script>

    
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

    </script>
</body>
</html>

