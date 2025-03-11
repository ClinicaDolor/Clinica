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
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <script>
        function GuardarPaciente(){

        const NombreCompleto = document.getElementById('NombreCompleto').value;
        const Edad = document.getElementById('Edad').value;
        const Sexo = document.getElementById('Sexo').value;
        const EstadoCivil = document.getElementById('EstadoCivil').value;
        const FeNacimiento = document.getElementById('FeNacimiento').value;
        const CURP = document.getElementById('CURP').value;
        const LuOrigen = document.getElementById('LuOrigen').value;
        const LuResidencia = document.getElementById('LuResidencia').value;
        const Ocupacion = document.getElementById('Ocupacion').value;
        const NumHijos = document.getElementById('NumHijos').value;
        const EdadHijos = document.getElementById('EdadHijos').value;
        const personaRecomienda = document.getElementById('personaRecomienda').value;
        const RedesSociales = document.getElementById('RedesSociales').value;
        const motivoAtencionClinica = document.getElementById('motivoAtencionClinica').value;
        const DACalle = document.getElementById('DACalle').value;
        const DANI = document.getElementById('DANI').value;
        const DANE = document.getElementById('DANE').value;
        const DAColonia = document.getElementById('DAColonia').value;
        const DADelegacion = document.getElementById('DADelegacion').value;
        const DACP = document.getElementById('DACP').value;
        const DAMunicipio = document.getElementById('DAMunicipio').value;
        const Distancia = document.getElementById('Distancia').value;
        const Email = document.getElementById('Email').value;
        const Telefono = document.getElementById('Telefono').value;
        const Celular = document.getElementById('Celular').value;
        const Cuidador = document.getElementById('Cuidador').value;
        const CuiNombre = document.getElementById('CuiNombre').value;
        const CuiTelefono = document.getElementById('CuiTelefono').value;
        const ResNombre = document.getElementById('ResNombre').value;
        const ResTelefono = document.getElementById('ResTelefono').value;

        const parametros = {

        NombreCompleto : NombreCompleto,
        Edad : Edad,
        Sexo : Sexo,
        EstadoCivil : EstadoCivil,
        FeNacimiento : FeNacimiento,
        CURP : CURP,
        LuOrigen : LuOrigen,
        LuResidencia : LuResidencia,
        Ocupacion : Ocupacion,
        NumHijos : NumHijos,
        EdadHijos : EdadHijos,
        personaRecomienda : personaRecomienda,
        RedesSociales : RedesSociales,
        motivoAtencionClinica : motivoAtencionClinica,
        DACalle : DACalle,
        DANI : DANI,
        DANE : DANE,
        DAColonia : DAColonia,
        DADelegacion : DADelegacion,
        DACP : DACP,
        DAMunicipio : DAMunicipio,
        Distancia : Distancia,
        Email : Email,
        Telefono : Telefono,
        Celular : Celular,
        Cuidador : Cuidador,
        CuiNombre : CuiNombre,
        CuiTelefono : CuiTelefono,
        ResNombre : ResNombre,
        ResTelefono : ResTelefono

        }

        fetch('/clinica/paciente/insert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(parametros)
    })
    .then(response => response.json())
    .then(data => {

        if (data.resultado) {
            window.location.href = '/clinica/paciente/' + data.mensaje;
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
                <h3><?=$data['nombre_paciente'];?></h3>
            </div>
            <section class="section mt-4">

            <div class="card">
               <div class="card-body">
               
                <div class="row">

                    <div class="col-12 col-sm-6">
                    <label class="text-light"><small>Fecha Alta:</small></label>
                    <div class="fs-5"><?=(new DateTime($data['fecha_alta']))->format('d/m/Y');[0];?></div>
                    </div>

                    <div class="col-12 col-sm-6">
                    <label class="text-light"><small>Fecha Nacimiento:</small></label>
                    <div class="fs-5"><?=date("d/m/Y", strtotime($data['fecha_nacimiento']));?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Edad:</small></label>
                    <div class="fs-5"><?=$data['edad'];?> años</div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Sexo:</small></label>
                    <div class="fs-5"><?=($data['sexo'] == 'M')? 'Masculino': 'Femenino';?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Estado civil:</small></label>
                    <div class="fs-5"><?=$data['estado_civil'];?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>CURP:</small></label>
                    <div class="fs-5"><?=$data['curp'];?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Email:</small></label>
                    <div class="fs-5"><?=$data['email'];?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Telefono:</small></label>
                    <div class="fs-5"><?=$data['telefono'];?></div>
                    </div>

                    <div class="col-12 col-sm-4">
                    <label class="text-light"><small>Celular:</small></label>
                    <div class="fs-5"><?=$data['celular'];?></div>
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

</body>
</html>

