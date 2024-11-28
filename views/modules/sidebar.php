<?php
$rolUsuario = $_SESSION["users"]["rol_usuario"] ?? null;

// Definir las opciones del menú para cada rol
$menuByRole = [
	"administrador" => [
		[
			"title" => "Inicio",
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
			"title" => "Reportes",
			"icon" => "sidebar",
			"link" => "reportes"
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

            <?php
            // Agrupar los elementos del menú en secciones
            $sections = [
                "Inicio" => array_filter($menuItems, fn($item) => $item['title'] === "Inicio"),
                "Usuarios / Clientes" => array_filter($menuItems, fn($item) => in_array($item['title'], ["Usuarios", "Clientes"])),
                "Ordenes y Servicios" => array_filter($menuItems, fn($item) => in_array($item['title'], ["Ordenes", "Prendas", "Servicios", "Pagos"])),
                "Compras y Productos" => array_filter($menuItems, fn($item) => in_array($item['title'], ["Compras / Proveedores", "Productos"])),
                "Reportes" => array_filter($menuItems, fn($item) => $item['title'] === "Reportes")
            ];

            // Renderizar las secciones y manejar las líneas divisorias dinámicamente
            $firstSection = true; // Bandera para controlar la primera sección (sin línea antes)
            foreach ($sections as $sectionName => $items) {
                if (!empty($items)) { // Solo imprimir secciones con elementos
                    if (!$firstSection) {
                        // Imprimir línea divisoria antes de cada sección (excepto la primera)
                        echo '<li class="menu-divider" style="list-style: none; margin: 0px 0;">
                                <hr style="border: 2; height: 1px; background: #ddd;">
                              </li>';
                    }

                    // Renderizar los elementos del menú en la sección actual
                    foreach ($items as $item) {
                        $menuId = preg_replace('/[^a-zA-Z0-9]/', '', $item['title']);
                        echo '<li class="menu-item">';
                        if (isset($item['submenu'])) {
                            echo '<a href="#menu' . $menuId . '" data-bs-toggle="collapse" class="menu-link waves-effect">';
                            echo '<span class="menu-icon"><i data-lucide="' . $item['icon'] . '"></i></span>';
                            echo '<span class="menu-text"> ' . htmlspecialchars($item['title']) . ' </span>';
                            echo '<span class="menu-arrow"></span></a>';
                            echo '<div class="collapse" id="menu' . $menuId . '">';
                            echo '<ul class="sub-menu">';
                            foreach ($item['submenu'] as $subItem) {
                                echo '<li class="menu-item">';
                                echo '<a href="' . htmlspecialchars($subItem['link']) . '" class="menu-link">';
                                echo '<span class="menu-text">' . htmlspecialchars($subItem['title']) . '</span>';
                                echo '</a></li>';
                            }
                            echo '</ul></div>';
                        } else {
                            echo '<a href="' . htmlspecialchars($item['link']) . '" class="menu-link waves-effect">';
                            echo '<span class="menu-icon"><i data-lucide="' . $item['icon'] . '"></i></span>';
                            echo '<span class="menu-text"> ' . htmlspecialchars($item['title']) . ' </span>';
                            echo '</a>';
                        }
                        echo '</li>';
                    }

                    // Marcar que la primera sección ya se procesó
                    $firstSection = false;
                }
            }
            ?>
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