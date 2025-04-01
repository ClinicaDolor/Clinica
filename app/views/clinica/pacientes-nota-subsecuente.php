<?php 
use App\Config\Database;
use App\Models\NotaSubsecuenteModel;
$bd = Database::getInstance();
$model = new NotaSubsecuenteModel();
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?=RUTA_JS;?>loader.js"></script>
    <style>
        .editor1{
            font-size: 20px;
            height: 393px;
        }

        .editor2{
            font-size: 20px;
            height: 250px;
        }
    </style>
    <script>

document.addEventListener("DOMContentLoaded", function() {
        tableLaboratorio()
    });

function tableLaboratorio(){
        const usuarioDiv = document.getElementById('main');
        const idPaciente = usuarioDiv.getAttribute('data-paciente');
        const referencia = usuarioDiv.getAttribute('data-referencia');

        fetch(`/buscar/tabla-laboratorio/${encodeURIComponent(idPaciente)}/${encodeURIComponent(referencia)}`)
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

    function DetalleLaboratorio(idLaboratorio){

        fetch(`/buscar/laboratorio/${encodeURIComponent(idLaboratorio)}`)
        .then(response => {
        if (!response.ok) {
        throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.text();
        })
        .then(data => {

            const resultsContainer = document.getElementById('detalleLaboratorio');
            resultsContainer.innerHTML = data;
            feather.replace();

        });

        } 

        function AgregarNota(){

            const usuarioDiv = document.getElementById('main');
            const idPaciente = usuarioDiv.getAttribute('data-paciente');
            const referencia = usuarioDiv.getAttribute('data-referencia');

            const contenidoNota = document.querySelector('#snow1 .ql-editor').innerHTML;
            const Diagnostico = document.getElementById('Diagnostico').value;
            const contenidoReceta = document.querySelector('#snow2 .ql-editor').innerHTML;

            document.querySelector('#snow1 .ql-editor').style.border = "";
            document.querySelector('#Diagnostico').style.border = "";
            document.querySelector('#snow2 .ql-editor').style.border = "";

            if(contenidoNota != '<p><br></p>'){
                if(Diagnostico != ""){
                    if(contenidoReceta != '<p><br></p>'){

            const parametros = {
            idPaciente : idPaciente,
            referencia : referencia,
            contenidoNota : contenidoNota,
            diagnostico : Diagnostico,
            medicamento : contenidoReceta
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

                idReceta = data.mensaje.idReceta;
                idNota = data.mensaje.idNota;

                document.getElementById('Diagnostico').value = "";
                document.querySelector('#snow1 .ql-editor').innerHTML = "";
                document.querySelector('#snow2 .ql-editor').innerHTML = "";
                
                window.open('/pdf/receta/' + idReceta, '_blank');
                window.location.href = '/clinica/nota-subsecuente/' + idNota;
                
            } else {
                document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
            }
          
        });

            }else{
                document.querySelector('#snow2 .ql-editor').style.border = "2px solid #d44e31";
            }

        }else{
            document.querySelector('#Diagnostico').style.border = "2px solid #d44e31";
        }
    }else{
        document.querySelector('#snow1 .ql-editor').style.border = "2px solid #d44e31";
    }

    }

    function AgregarLaboratorio() {
    
    const usuarioDiv = document.getElementById('main');
    const idPaciente = usuarioDiv.getAttribute('data-paciente');
    const referencia = usuarioDiv.getAttribute('data-referencia');

    const fileInput = document.getElementById('Archivo');
    const file = fileInput.files[0];
    const contenidoLaboratorio = document.querySelector('#snow3 .ql-editor').innerHTML;

    document.getElementById('Archivo').style.border = "";
    document.querySelector('#snow3 .ql-editor').style.border = "";


    if (file) {
        if (contenidoLaboratorio !== '<p><br></p>') {

            const formData = new FormData();
            formData.append('idPaciente', idPaciente);
            formData.append('file', file);
            formData.append('contenidoLaboratorio', contenidoLaboratorio);
            formData.append('referencia', referencia);
               
            fetch('/clinica/laboratorio/insert-laboratorio', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {

                if (data.resultado) {

                    document.getElementById('Archivo').value = "";
                    document.querySelector('#snow3 .ql-editor').innerHTML = "";

                    tableLaboratorio()
                            
                } else {
                    
                    document.getElementById('mensaje').textContent = 'Error: ' + data.mensaje;
                }

                });
               

        } else {
            document.querySelector('#snow3 .ql-editor').style.border = "2px solid #d44e31";
        }
    } else {
        document.getElementById('Archivo').style.border = "2px solid #d44e31";
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
                    feather.replace();

                });

    }
    </script>

 </head>
<body>
<div class="LoaderPage"></div>
    <div id="app">
        
        <?=$data['sidebar'];?>

    <div id="main" data-referencia="<?=$data['referencia'];?>" data-paciente="<?=$data['idPaciente'];?>">
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
                        <div class="card-header">
                            <h4 class="card-title">Información del paciente</h4>
                        </div>
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
                <div class="col-12 col-sm-4">

                <div class="card">
                <div class="card-header">
                <h4 class="card-title">Notas Subsecuentes</h4>
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
                    <?php 
                    foreach ($registros as $registro): 
                    $primer = ($model->primerNota() == $registro['id'])? '<i class="text-info text-end" data-feather="star" width="20"></i>': '';
                    ?>
                        <tr onclick="DetalleNota(<?=$registro['id']?>)">
                            <td class="text-center"><?=$registro['id']?></td>
                            <td><?=(new DateTime(datetime: $registro['fecha_hora']))->format('d/m/Y h:i a');?> <?=$primer;?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                </div>
                </div>

                </div>
                <div class="col-12 col-sm-8">
                        
                <div class="card">
                    <div class="card-header">
                    <h4 class="card-title">Detalle Nota Subsecuente</h4>

                    </div>
                    <div class="card-body">
                        <div id="detalleNota">
                        <?php
                            echo $model->ultimaNota($data['idPaciente']);
                            ?>
                        </div>
                    </div>
                </div>

               </div>
            </div>

                
            </section>

            <hr>

            <small class="text-light">Crear nueva Nota Subsecuente</small>

            <section class="mt-3">

            <div class="row">
            <div class="col-12 col-sm-6">

            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Agregar Nota Subsecuente</h4>
                </div>
                <div class="card-body">

                <div id="snow1" class="editor1"></div>
                </div>
                </div>

                <div class="card">
                <div class="card-header text-primary">
                <h4 class="card-title">Agregar Receta</h4>
                </div>
                <div class="card-body">
                <div class="">
                <label class="text-primary mb-1"><smallal>Diagnostico:</smallal></label>
                <textarea class="form-control fs-5" id="Diagnostico" rows="2"></textarea>
                </div>
                    
                <label class="text-primary mt-3 mb-1"><smallal>Medicamento:</smallal></label>
                <div id="snow2" class="editor2"></div>
                </div>
                </div>
                <div id="mensaje"></div>
                <div class="text-end"><button class="btn btn-success fs-5" onclick="AgregarNota()">Guardar Nota Subsecuente <i data-feather="chevron-right"></i> </button></div>

            </div>
            <div class="col-12 col-sm-6">

            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Laboratorio</h4>
                </div>
                <div class="card-body">

                <div id="conteLaboratorio"></div>
                <div class="p-2 border">
                    <div id="detalleLaboratorio">
                        <div class="text-center text-light">No se encontro información</div>
                    </div>
                </div>
                
                <hr>

                <label class="text-primary"><small>Archivo:</small></label>
                <div class="mb-3"><input type="file" class="form-control" id="Archivo"></div>
                
                <label class="text-primary"><small>Descripción:</small></label>

                <div id="snow3" class="editor2"></div>
                <div class="text-end mt-3"><button class="btn btn-primary" onclick="AgregarLaboratorio()">Agregar <i data-feather="chevron-right"></i></button></div>

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

        var snow = new Quill('#snow1', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic'], 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ],
        },
        bounds: '#snow1',
        height: '500px',
        });

        var snow2 = new Quill('#snow2', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic'], 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ],
        },
        bounds: '#snow2',
        height: '500px',
        });

        var snow3 = new Quill('#snow3', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic'], 
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ],
        },
        bounds: '#snow3',
        height: '500px',
        });

    </script>
</body>
</html>

