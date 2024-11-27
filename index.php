<?php

require_once 'controllers/template.controller.php';
require_once "controllers/usuario.controller.php";
require_once "controllers/proveedores.controller.php";
require_once "controllers/cat.productos.controller.php";

require_once "models/user.model.php";
require_once "models/proveedores.model.php";
require_once "models/cat.productos.model.php";


$index = new TemplateController();
$index->index();

?>
