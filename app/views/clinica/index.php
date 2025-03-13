<?php
use App\Controllers\ClinicaController;
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

    <style>
    .search{
    max-width: 300px;
    }

    .search .search-input{
    width: 100%;
    position: relative;
    
  }
  .search-input input{
    height: 45px;
    width: 100%;
    border-radius: 50px;
    padding: 0 60px 0 20px;
    font-size: 16px;
 
  }
  
  .search-input .autocom-box{
    background: white;
    padding: 0;
    opacity: 0;
    pointer-events: none;
    width: 260px;
    max-height: 200px;
    margin-top: 10px;
    border-radius: 0px 0px 0px 0px;
    position: absolute;
    z-index: 1;
    border-radius: 10px;
    overflow: auto;
  }
  
  .search-input.active .autocom-box{
    padding: 10px 8px;
    opacity: 1;
    pointer-events: auto;
  }
  
  .autocom-box li{
    list-style: none;
    padding: 8px 10px;
    display: none;
    width: 100%;
    cursor: default;
    border-radius: 3px;
    font-size: 16px;
  }

  .autocom-box li a{ 
    text-decoration: none;
    color: black;
  }
  
  .search-input.active .autocom-box li{
    display: block;
  }
  .autocom-box li:hover{
    background: #efefef;
  }
  
  .search-input .icon{
    position: absolute;
    right: 0px;
    top: 0px;
    height: 55px;
    width: 55px;
    text-align: center;
    line-height: 45px;
    color: #644bff;
  }

    </style>
</head>
<body>
    <div id="app">
        
      <?=$data['sidebar'];?>
    
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler"><span class="navbar-toggler-icon"></span></a>
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

        <div class="search float-end">
        <div class="search-input">
        <a href="" target="_blank" hidden></a>
        <input type="text" class="form-control round" placeholder="Buscar...">
        <div class="autocom-box">
        </div>
        <div class="icon"><i data-feather="search"></i></div>
        </div>
        </div>
            <div class="page-title">
                  
                <h3>Tratamientos del dolor y cuidados paleativos</h3>

            </div>
            <section class="section mt-4">
                <?php 
                /*print_r($data);
                echo "</br>".$data['datos']['rol'];*/
                ?>

                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <h3>Lista de Pacientes</h3>
                                </div>
                                <div class="text-center"><label class="fs-1 text-primary fw-bold"><?=$data['total_pacientes'];?></label> <small>TOTAL</small> </div>

                                <div class="text-end">
                                <a href="clinica/pacientes" class='btn btn-primary' > Ver más <i data-feather="chevron-right" width="20"></i> </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <section>

                

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
    <script>
    const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");

// Evento cuando el usuario escribe
inputBox.onkeyup = async (e) => {
    let userData = e.target.value; // Datos ingresados por el usuario
    if (userData) {
        try {
            // Realiza una solicitud fetch al servidor
            const response = await fetch(`/buscar?query=${encodeURIComponent(userData)}`);
            const suggestions = await response.json(); // Obtén las sugerencias en JSON
            const domainName = window.location.hostname;

            // Muestra las sugerencias
            showSuggestions(suggestions.map(suggestion => `<li><a href="clinica/paciente/${suggestion.id}">${suggestion.nombre}</a></li>`));
            searchWrapper.classList.add("active");
        } catch (error) {
            console.error("Error fetching suggestions:", error);
        }
    } else {
        searchWrapper.classList.remove("active"); // Oculta el cuadro de sugerencias
    }
};

// Función para mostrar sugerencias
function showSuggestions(list) {

    let listData;
    if (!list.length) {
        listData = '<li><a href="clinica/paciente/nuevo" class="text-primary">Agregar Paciente</a></li>';
    } else {
        listData = list.join('');
    }
    suggBox.innerHTML = listData;
}

// Evento para cerrar el cuadro de sugerencias al hacer clic fuera
document.addEventListener("click", (e) => {

    if (!searchWrapper.contains(e.target)) {
        inputBox.value = "";
        searchWrapper.classList.remove("active");
    }
});

    </script>

</body>
</html>
