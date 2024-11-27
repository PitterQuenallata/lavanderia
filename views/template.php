<?php

// Iniciar buffering y sesiones
ob_start();
session_start();

// Lista de páginas válidas
$validPages = [
    "inicio",
    "usuarios",
    "proveedores",
    "productos",
    "cat-productos",
    "dashboard",
    "salir"
];

// Obtener la página solicitada
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$basePath = "lavanderia";
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
$segments = explode('/', $requestUri);
$route = !empty($segments[0]) ? $segments[0] : "inicio";

// Incluye la cabecera
include "modules/head.php";

// Página contenedora
echo '<input type="hidden" id="urlPath" value="/lavanderia/">';

// Función para cargar la página solicitada
function loadPage($route, $validPages)
{
    // Contenedor principal Begin page
    echo '<div class="layout-wrapper">';

    // Incluye la barra lateral
    include "modules/sidebar.php";

    // Contenedor de contenido
    echo '<div class="page-content">';

    // Incluye la cabecera
    include "modules/header.php";

    // Verifica si la página es válida y si existe el archivo
    if (in_array($route, $validPages) && file_exists("views/pages/{$route}.php")) {
        include "views/pages/{$route}.php";
    } else {
        include "views/pages/404.php"; // Página de error 404
    }

    // Cierra el contenedor de contenido
    echo '</div>'; // Fin de page-content

    // Cierra el contenedor principal
    echo '</div>'; // Fin de layout-wrapper
}

// Cargar la página
loadPage($route, $validPages);

// Incluye scripts y pie de página
include "modules/scripts.php";
include "modules/footerEnd.php";
