<?php

// Iniciar buffering y sesiones
ob_start();
session_start();

// Incluye la cabecera
include "modules/head.php";

if (isset($_SESSION["users"])) {

    // Verifica si el usuario debe actualizar la contraseña
    if (!isset($_SESSION["users"]["ultimo_login_usuario"]) || trim($_SESSION["users"]["ultimo_login_usuario"]) === '') {
        include "pages/nuevoPassword.php";
        exit(); // Detener ejecución
    }

    // Define rutas válidas
    $validRoutes = [
        "dashboard",
        "usuarios",
        "orden",
        "preorden",
        "listOrden",
        "colores",
        "prendas",
        "cat-prendas",
        "compras",
        "listCompras",
        "proveedores",
        "productos",
        "pagos",
        "reportes",
        "cat-productos",
        "lavados",
        "clientes",
        "perfil",
        "salir",
        "login"
    ];

    // Define accesos permitidos por rol
    $accessByRole = [
        "administrador" => [
            "dashboard",
            "usuarios",
            "orden",
            "preorden",
            "listOrden",
            "colores",
            "prendas",
            "cat-prendas",
            "compras",
            "listCompras",
            "proveedores",
            "productos",
            "pagos",
            "reportes",
            "lavados",
            "cat-productos",
            "clientes",
            "perfil",
            "salir"
        ],
        "promotor" => [
            "orden",
            "preorden",
            "listOrden",
            "colores",
            "prendas",
            "lavados",
            "cat-prendas",
            "perfil",
            "salir"
        ],
        "secretaria" => [
            "orden",
            "preorden",
            "listOrden",
            "lavados",
            "pagos",
            "perfil",
            "salir"
        ]
    ];

    // Contenedor principal Begin page
    echo '<div class="layout-wrapper">';

    // Incluye la barra lateral
    include "modules/sidebar.php";

    // Contenedor de contenido
    echo '<div class="page-content">';

    // Incluye la cabecera
    include "modules/header.php";
    //print_r($_SESSION["users"]["rol_usuario"]);
    // Manejador de rutas
    if (isset($_GET["ruta"])) {
        $ruta = $_GET["ruta"];
        $rolUsuario = $_SESSION["users"]["rol_usuario"]; // Asume que este campo contiene el rol del usuario

        // Verifica si la ruta es válida y si el rol tiene acceso
        if (in_array($ruta, $validRoutes) && in_array($ruta, $accessByRole[$rolUsuario])) {
            include "pages/" . $ruta . ".php";
        } else {
            // Si la ruta no es válida o el rol no tiene acceso
            include "pages/404.php";
        }
    } else {
        // Página predeterminada (dashboard)
        include "pages/dashboard.php";
    }

    // Cierra el contenedor de contenido
    echo '</div>'; // Fin de page-content

    // Cierra el contenedor principal
    echo '</div>'; // Fin de layout-wrapper

} else {
    // Página de inicio de sesión
    echo '<body class="hold-transition login-page">';
    include "pages/login.php";
    echo '</body>';
}

// Incluye scripts y pie de página
include "modules/scripts.php";
include "modules/footerEnd.php";
