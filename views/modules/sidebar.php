<!-- ========== Left Sidebar ========== -->
<div class="main-menu">
	<!-- Brand Logo -->
	<div class="logo-box">
		<!-- Brand Logo Light -->
		<a href="index.html" class="logo-light">
			<img src="views/assets/images/logo-light.png" alt="logo" class="logo-lg" height="32">
			<img src="views/assets/images/logo-light-sm.png" alt="small logo" class="logo-sm" height="32">
		</a>

		<!-- Brand Logo Dark -->
		<a href="index.html" class="logo-dark">
			<img src="views/assets/images/logo-dark.png" alt="dark logo" class="logo-lg" height="32">
			<img src="views/assets/images/logo-dark-sm.png" alt="small logo" class="logo-sm" height="32">
		</a>
	</div>

	<!--- Menu -->
	<div data-simplebar>
		<ul class="app-menu">

			<li class="menu-title">Navegación</li>
			<!--! ============================ 				Dashboard 		============================== !-->
			<li class="menu-item">
				<a href="/dashboard" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="airplay "></i></span>
					<span class="menu-text"> Dashboard </span>
				</a>
			</li>

			<!--! ============================ 				ordenes 		============================== !-->

			<li class="menu-item">
				<a href="#menuComponentsui" data-bs-toggle="collapse" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="clipboard"></i></span>
					<span class="menu-text"> Ordenes </span>
					<span class="menu-arrow"></span>
				</a>
				<div class="collapse" id="menuComponentsui">
					<ul class="sub-menu">
						<li class="menu-item">
							<a href="/orden" class="menu-link">
								<span class="menu-text">Nueva orden</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/listOrden" class="menu-link">
								<span class="menu-text">Ver orden</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/colores" class="menu-link">
								<span class="menu-text">Colores</span>
							</a>
						</li>

					</ul>
				</div>
			</li>

			<!--! ============================ 				Prendas 		============================== !-->
			<li class="menu-item">
				<a href="#menuExtendedui2" data-bs-toggle="collapse" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="shopping-bag"></i></span>
					<span class="menu-text"> Prendas </span>
					<span class="menu-arrow"></span>
				</a>
				<div class="collapse" id="menuExtendedui2">
					<ul class="sub-menu">
						<li class="menu-item">
							<a href="/prendas" class="menu-link">
								<span class="menu-text">Prendas</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/categoriaP" class="menu-link">
								<span class="menu-text">Categoria Prendas</span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			<!--! ============================ 				Compras / proveedores 		============================== !-->

			<li class="menu-item">
				<a href="#menuIcons" data-bs-toggle="collapse" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="clipboard"></i></span>
					<span class="menu-text"> Compras / Proveedores </span>
					<span class="menu-arrow"></span>
				</a>
				<div class="collapse" id="menuIcons">
					<ul class="sub-menu">
						<li class="menu-item">
							<a href="/compra" class="menu-link">
								<span class="menu-text">Nueva compra</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/listCompra" class="menu-link">
								<span class="menu-text">Lista de compras</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/proveedores" class="menu-link">
								<span class="menu-text">Proveedores</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
			<!--! ============================ 				productos 		============================== !-->
			<li class="menu-item">
				<a href="#menuExtendedui" data-bs-toggle="collapse" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="book-open"></i></span>
					<span class="menu-text"> Productos </span>
					<span class="menu-arrow"></span>
				</a>
				<div class="collapse" id="menuExtendedui">
					<ul class="sub-menu">
						<li class="menu-item">
							<a href="/productos" class="menu-link">
								<span class="menu-text">Productos</span>
							</a>
						</li>
						<li class="menu-item">
							<a href="/cat-productos" class="menu-link">
								<span class="menu-text">Categoria Productos</span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			<!--! ============================ 				usuarios 		============================== !-->
			<li class="menu-item">
				<a href="/usuarios" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="user"></i></span>
					<span class="menu-text"> Usuarios </span>
				</a>
			</li>

			<!--! ============================ 				Pagos 		============================== !-->
			<li class="menu-item">
				<a href="/pagos" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="dollar-sign"></i></span>
					<span class="menu-text"> Pagos </span>
				</a>
			</li>

			<!--! ============================ 				reportes 		============================== !-->

			<li class="menu-item">
				<a href="/reportes" class="menu-link waves-effect">
					<span class="menu-icon"><i data-lucide="sidebar"></i></span>
					<span class="menu-text"> Reportes </span>
				</a>
			</li>

		</ul>
	</div>
</div>



