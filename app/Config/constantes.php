<?php
define("HOST", $_SERVER["HTTP_HOST"]);
define("SERVIDOR", "http://".HOST."/");

define("RUTA_PUBLIC", SERVIDOR . "public/assets/");
define("RUTA_CSS", RUTA_PUBLIC . "css/");
define("RUTA_JS", RUTA_PUBLIC . "js/");
define("RUTA_IMAGES", RUTA_PUBLIC . "images/");
