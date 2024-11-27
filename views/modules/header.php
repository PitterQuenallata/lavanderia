<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
	<div class="topbar">
		<div class="topbar-menu d-flex align-items-center gap-lg-2 gap-1">

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

			<!-- Sidebar Menu Toggle Button -->
			<button class="button-toggle-menu waves-effect waves-light rounded-circle">
				<i class="mdi mdi-menu"></i>
			</button>
		</div>

		<ul class="topbar-menu d-flex align-items-center gap-2">

			<li class="d-none d-md-inline-block">
				<a class="nav-link waves-effect waves-light" href="#" data-bs-toggle="fullscreen">
					<i class="mdi mdi-fullscreen font-size-24"></i>
				</a>
			</li>

		

		
			

			<li class="nav-link waves-effect waves-light" id="theme-mode">
				<i class="bx bx-moon font-size-24"></i>
			</li>

			<li class="dropdown">
				<a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
					href="#" role="button" aria-haspopup="false" aria-expanded="false">
					<img src="<?php echo $_SESSION["users"]["foto_usuario"] ?>" alt="user-image" class="rounded-circle">
					<span class="ms-1 d-none d-md-inline-block">
					<?php 
                  // Obtener el nombre y el apellido de la sesión
                  $nombre = mb_convert_case(mb_strtolower($_SESSION["users"]["nombre_usuario"], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                  $apellido = mb_convert_case(mb_strtolower($_SESSION["users"]["apellido_paterno_usuario"], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');

                  // Mostrar el nombre y apellido con la primera letra en mayúscula
                  echo $nombre . " " . $apellido;
                  ?>

					</span>
				</a>

				<div class="dropdown-menu dropdown-menu-end profile-dropdown ">
					<!-- item-->
					<div class="dropdown-header noti-title">
						<h6 class="text-overflow m-0">Bienvenido!</h6>
					</div>

					<!-- item-->
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i data-lucide="user" class="font-size-16 me-2"></i>
						<span>Mi cuenta</span>
					</a>

					<!-- item-->
					<!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
						<i data-lucide="settings" class="font-size-16 me-2"></i>
						<span>Ajustes</span>
					</a> -->

					<!-- item-->
					<!-- <a href="pages-lock-screen.html" class="dropdown-item notify-item">
						<i data-lucide="lock" class="font-size-16 me-2"></i>
						<span>Lock Screen</span>
					</a> -->

					<div class="dropdown-divider"></div>

					<!-- item-->
					<a href="salir" class="dropdown-item notify-item">
						<i data-lucide="log-out" class="font-size-16 me-2"></i>
						<span>Salir</span>
					</a>

				</div>
			</li>

		</ul>
	</div>
</div>
<!-- ========== Topbar End ========== -->