<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="d-flex align-items-center min-vh-100">
        <div class="w-100 d-block card shadow-lg rounded my-5 overflow-hidden">
          <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-login rounded-left"></div>
            <div class="col-lg-7">
              <div class="p-5">
                <div class="text-center w-75 mx-auto auth-logo mb-4">
                  <a href="/dashboard" class="logo-dark">
                    <span><img src="<?php echo $path ?>views/assets/images/logo-dark.png" alt="" height="32"></span>
                  </a>

                  <a href="/dashboard" class="logo-light">
                    <span><img src="<?php echo $path ?>views/assets/images/logo-light.png" alt="" height="32"></span>
                  </a>
                </div>


                <h1 class="h5 mb-1">Bienvenido!</h1>

                <p class="text-muted mb-4">Inicio de Sesion </p>

                <form method="post">

                  <div class="form-group mb-3">
                    <label class="form-label" for="emailaddress">Usuario</label>
                    <input class="form-control" type="text" id="" required=""
                      name="ingUsuario"
                      autocomplete="userUsuario"
                      placeholder="Ingrese usuario">
                  </div>

                  <div class="form-group mb-3">
                    <a href="pages-recoverpw.html"
                      class="text-muted float-end"><small></small></a>
                    <label class="form-label" for="password">Contraseña</label>
                    <input class="form-control" type="password" required="" id=""
                      name="ingPassword"
                      placeholder="Ingrese contraseña">
                  </div>

                  <div class="form-group mb-3">
                    <div class="">
                      <input class="form-check-input" type="checkbox" id="checkbox-signin"
                        checked>
                      <label class="form-check-label ms-2" for="checkbox-signin">Recordar</label>
                    </div>
                  </div>

                  <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary w-100" type="submit"> Ingresar </button>
                  </div>

                <?php
                $loginAdmins = new ControladorUsuarios();
                $loginAdmins->ctrIngresoUsuario();
                ?>
                </form>



                <!-- <div class="row mt-4">
                  <div class="col-12 text-center">
                    <p class="text-muted mb-2">
                      <a class="text-muted font-weight-medium ms-1"
                        href='pages-recoverpw.html'>Forgot your password?</a>
                    </p>
                    <p class="text-muted mb-0">Don't have an account?
                      <a class="text-muted font-weight-medium ms-1"
                        href='pages-register.html'><b>Sign Up</b></a>
                    </p>
                  </div>
                </div> -->
                <!-- end row -->
              </div> <!-- end .padding-5 -->
            </div> <!-- end col -->
          </div> <!-- end row -->
        </div> <!-- end .w-100 -->
      </div> <!-- end .d-flex -->
    </div> <!-- end col-->
  </div> <!-- end row -->
</div>