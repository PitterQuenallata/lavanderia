<?php
// Iniciar buffering y sesiones
ob_start();
session_start();




//ruta
$path = TemplateController::path();

// Capturar rutas de la URL limpiando las queries
$routesArray = explode("/", $_SERVER["REQUEST_URI"]);
array_shift($routesArray);
foreach ($routesArray as $key => $value) {
    $routesArray[$key] = explode("?", $value)[0];
}

// Incluye la cabecera
include "modules/head.php";

// Página contenedora
echo '<input type="hidden" id="urlPath" value="' . $path . '">';

// Modificar la función para cargar directamente desde `pages`
function loadPage($route, $path, $routesArray)
{
    // Contenedor principal Begin page 
    echo '<div class="layout-wrapper">';

    include "modules/sidebar.php";

    echo '<div class="page-content">';

    include "modules/header.php";


    // Incluye la página solicitada
    include("pages/{$route}.php");
    // cierra el contenedor de la página
    echo '</div>';
    // Cierra el contenedor principal
    echo '</div>';
}

//echo var_dump($_SESSION["users"]["registro_sesion_usuario"]);
// Verifica si el usuario está en sesión
if (isset($_SESSION["users"])) {

    // Verifica si el usuario debe actualizar la contraseña
    if (!isset($_SESSION["users"]["ultimo_login_usuario"]) || trim($_SESSION["users"]["ultimo_login_usuario"]) === '') {
        // Redirige a la página nuevoPassword.php en la carpeta pages si está vacío o no está definido
        include "pages/nuevoPassword.php";
        exit(); // Asegúrate de detener la ejecución del script
    }

    // Determina la ruta solicitada
    $route = !empty($routesArray[0]) ? $routesArray[0] : "inicio";
    $validRoutes = ["dashboard", "usuarios", "proveedores","productos","cat-productos", "salir"]; // Añadir rutas válidas aquí

    // Verifica si la ruta es válida y carga la página correspondiente
    if (in_array($route, $validRoutes)) {
        loadPage($route, $path, $routesArray); // Llama a la función `loadPage`
    } else {
        include('pages/404.php'); // Página de error 404
    }
} else {
    include "pages/login.php"; // Página de login
}











include "modules/scripts.php";
include "modules/footerEnd.php";
