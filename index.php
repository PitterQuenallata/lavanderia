<?php

require_once 'controllers/template.controller.php';
require_once "controllers/usuario.controller.php";
require_once "controllers/proveedores.controller.php";
require_once "controllers/cat.productos.controller.php";

require_once "controllers/cat.prendas.controller.php";
require_once "controllers/prendas.controller.php";
require_once "controllers/colores.controller.php";
require_once "controllers/lavados.controller.php";
require_once "controllers/clientes.controller.php";

require_once "models/user.model.php";
require_once "models/proveedores.model.php";
require_once "models/cat.productos.model.php";

require_once "models/cat.prendas.model.php";
require_once "models/prendas.model.php";
require_once "models/colores.model.php";
require_once "models/lavados.model.php";
require_once "models/clientes.model.php";


$index = new TemplateController();
$index->index();

?>
