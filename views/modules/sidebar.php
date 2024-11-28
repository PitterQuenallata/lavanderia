<?php
$rolUsuario = $_SESSION["users"]["rol_usuario"] ?? null;

// Definir las opciones del menú para cada rol
$menuByRole = [
	"administrador" => [
		[
			"title" => "Dashboard",
			"icon" => "airplay",
			"link" => "dashboard"
		],
		[
			"title" => "Ordenes",
			"icon" => "clipboard",
			"submenu" => [
				["title" => "Nueva orden", "link" => "orden"],
				["title" => "Ver orden", "link" => "listOrden"],
				["title" => "Colores", "link" => "colores"],
			]
		],
		[
			"title" => "Prendas",
			"icon" => "shopping-bag",
			"submenu" => [
				["title" => "Prendas", "link" => "prendas"],
				["title" => "Categoria Prendas", "link" => "cat-prendas"],
			]
		],
		[
			"title" => "Servicios",
			"icon" => "droplet",
			"submenu" => [
				["title" => "Lista de lavados", "link" => "lavados"],
			]
		],
		[
			"title" => "Compras / Proveedores",
			"icon" => "clipboard",
			"submenu" => [
				["title" => "Nueva compra", "link" => "compras"],
				["title" => "Lista de compras", "link" => "listCompras"],
				["title" => "Proveedores", "link" => "proveedores"],
			]
		],
		[
			"title" => "Productos",
			"icon" => "book-open",
			"submenu" => [
				["title" => "Productos", "link" => "productos"],
				["title" => "Categoria Productos", "link" => "cat-productos"],
			]
		],
		[
			"title" => "Usuarios",
			"icon" => "user",
			"link" => "usuarios"
		],
		[
			"title" => "Clientes",
			"icon" => "user",
			"link" => "clientes"
		],
		[
			"title" => "Pagos",
			"icon" => "dollar-sign",
			"link" => "pagos"
		],
		[
			"title" => "Reportes",
			"icon" => "sidebar",
			"link" => "reportes"
		],
		[
			"title" => "Perfil",
			"icon" => "settings ",
			"link" => "perfil"
		],
		[
			"title" => "Salir",
			"icon" => "log-out",
			"link" => "salir"
		]
	],
	"promotor" => [
		[
			"title" => "Ordenes",
			"icon" => "clipboard",
			"submenu" => [
				["title" => "Nueva orden", "link" => "orden"],
				["title" => "Ver orden", "link" => "listOrden"],
				["title" => "Colores", "link" => "colores"],
			]
		],
		[
			"title" => "Prendas",
			"icon" => "shopping-bag",
			"submenu" => [
				["title" => "Prendas", "link" => "prendas"],
				["title" => "Categoria Prendas", "link" => "cat-prendas"],
			]
		],
		[
			"title" => "Servicios",
			"icon" => "droplet",
			"submenu" => [
				["title" => "Lista de lavados", "link" => "lavados"],
			]
		],
		[
			"title" => "Perfil",
			"icon" => "settings ",
			"link" => "perfil"
		],
		[
			"title" => "Salir",
			"icon" => "log-out",
			"link" => "salir"
		]

	],
	"secretaria" => [
		[
			"title" => "Ordenes",
			"icon" => "clipboard",
			"submenu" => [
				["title" => "Nueva orden", "link" => "orden"],
				["title" => "Ver orden", "link" => "listOrden"],
			]
		],
		[
			"title" => "Servicios",
			"icon" => "droplet",
			"submenu" => [
				["title" => "Lista de lavados", "link" => "lavados"],
			]
		],
		[
			"title" => "Pagos",
			"icon" => "dollar-sign",
			"link" => "pagos"
		],
		[
			"title" => "Perfil",
			"icon" => "settings ",
			"link" => "perfil"
		],
		[
			"title" => "Salir",
			"icon" => "log-out",
			"link" => "salir"
		]

	]
];

// Obtener el menú del rol actual
$menuItems = $menuByRole[$rolUsuario] ?? [];
?>

<!-- ========== Left Sidebar ========== -->
<div class="main-menu">
    <!-- Brand Logo -->
    <div class="logo-box">
        <a href="dashboard" class="logo-light">
            <img src="views/assets/media/logoJSdark.png" alt="logo" class="logo-lg" height="60">
            <img src="views/assets/images/logo-light-sm.png" alt="small logo" class="logo-sm" height="32">
        </a>
        <a href="dashboard" class="logo-dark">
            <img src="views/assets/media/logoJSblack.png" alt="dark logo" class="logo-lg" height="60">
            <img src="views/assets/images/logo-dark-sm.png" alt="small logo" class="logo-sm" height="32">
        </a>
    </div>

    <!-- Menu -->
    <div data-simplebar>
        <ul class="app-menu">
            <li class="menu-title">Navegación</li>
            <?php foreach ($menuItems as $item): ?>
                <?php 
                // Generar un ID único para los submenús
                $menuId = preg_replace('/[^a-zA-Z0-9]/', '', $item['title']); 
                ?>
                <li class="menu-item">
                    <?php if (isset($item['submenu'])): ?>
                        <a href="#menu<?= $menuId ?>" data-bs-toggle="collapse" class="menu-link waves-effect">
                            <span class="menu-icon"><i data-lucide="<?= $item['icon'] ?>"></i></span>
                            <span class="menu-text"> <?= $item['title'] ?> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="menu<?= $menuId ?>">
                            <ul class="sub-menu">
                                <?php foreach ($item['submenu'] as $subItem): ?>
                                    <li class="menu-item">
                                        <a href="<?= $subItem['link'] ?>" class="menu-link">
                                            <span class="menu-text"><?= $subItem['title'] ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= $item['link'] ?>" class="menu-link waves-effect">
                            <span class="menu-icon"><i data-lucide="<?= $item['icon'] ?>"></i></span>
                            <span class="menu-text"> <?= $item['title'] ?> </span>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    // Asegúrate de que los menús colapsables se abren al primer clic
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            var target = document.querySelector(toggle.getAttribute('href'));
            if (target.classList.contains('show')) {
                target.classList.remove('show');
            } else {
                document.querySelectorAll('.collapse.show').forEach(function (openMenu) {
                    openMenu.classList.remove('show');
                });
                target.classList.add('show');
            }
            e.preventDefault();
        });
    });
</script>