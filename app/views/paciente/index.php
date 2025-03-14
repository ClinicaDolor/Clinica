<?php 
use App\Config\Database;
$bd = Database::getInstance();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=RUTA_IMAGES ?>/logo-clinica.png">
    <link rel="apple-touch-icon" href="<?=RUTA_IMAGES ?>/logo-clinica.png">
    <title><?=$data['title'];?></title>
    <link rel="stylesheet" href="<?=RUTA_CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?=RUTA_PUBLIC;?>libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=RUTA_CSS;?>app.css">
    </head>

    <body>
    <div id="app">
        
    <!---------- SIDEBAR ---------->
    <?=$data['sidebar'];?>
    
    <div id="main">
            
    <nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
                
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
    </ul>
    </div>
    </nav>
        
    <!---------- CONTENIDO DE LA PAGINA ---------->
    <div class="main-content container-fluid">

    <!--
    <div class="search float-end">
    <div class="search-input">
    <a href="" target="_blank" hidden></a>
    <input type="text" class="form-control round" placeholder="Buscar...">
    <div class="autocom-box"></div>
    <div class="icon"><i data-feather="search"></i></div>
    </div>
    </div>
    -->

    <div class="page-title mb-4">     
    <h8><?= $data['datos']['nombre']; ?></h8>
    <h3>Historia Clinica</h3>
    </div>
    
    <section class="section">

    <?php
    try {
    $stmt = $bd->query("SELECT * FROM historia_clinica_modulos ORDER BY id ASC");
    $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
    }
    ?>

    <div class="row">
    <?php foreach ($modulos as $modulo): ?>
        
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
    <div class="card border-0 rounded-4 position-relative">

    <div class="card-header">
    <span class="badge bg-primary fs-6">
    <?=$modulo['id']?>
    </span>
    </div>

    <div class="card-body text-center pb-1">
    <!-- Nombre del módulo -->
    <h5 class="fw-bold text-primary mb-3"><?=$modulo['nombre']?></h5>
            
    <!-- Imagen centrada -->
    <div class="col-12 mb-3">
    <img src="<?=RUTA_IMAGES ?>/iconos/<?=$modulo['imagen']?>" class="img-fluid" style="max-height: 90px;">
    </div>

    <!-- Barra de progreso mejorada -->
    <div class="col-12">
    <h6 class="fw-bold text-secondary">Porcentaje de cumplimiento:</h6>
    <div class="progress bg-light rounded-pill" style="height: 15px;">
    <div class="progress-bar bg-success rounded-pill text-white fw-bold" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
    </div>
    </div>
    </div>

    <!-- Footer con botón mejorado -->
    <div class="card-footer ">
    <a href="<?=SERVIDOR?><?=$modulo['url']?>" class="btn btn-secondary float-end"> 
    Ver más <i data-feather="chevron-right"></i> 
    </a>
    </div>

    </div>
    </div>

    <?php endforeach; ?>
    </div>

    </section>
    </div>

    <!---------- CONTENIDO DE LA PAGINA ---------->
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
            listData = 'No hay resultados';
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
