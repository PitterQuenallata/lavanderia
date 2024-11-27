<div class="container min-vh-100 d-flex align-items-center justify-content-center">
  <div class="row justify-content-center w-100">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-lg rounded">
        <div class="card-body">
          <h1 class="h5 text-center mb-2">Bienvenido!</h1>
          <p class="text-muted text-center mb-4">Registre su nueva contraseña para nuevo usuario</p>

          <form method="post" class="needs-validation was-validated" novalidate="">
            <div class="mb-3">
              <ul id="password-requirements" class="list-unstyled mb-3">
                <li class="requirement text-danger" id="require-lowercase">Debe tener al menos una letra minúscula</li>
                <li class="requirement text-danger" id="require-uppercase">Debe tener al menos una letra mayúscula</li>
                <li class="requirement text-danger" id="require-number">Debe tener al menos un número</li>
                <li class="requirement text-danger" id="require-length">Debe tener al menos 8 caracteres</li>
              </ul>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="nuevoPassLogin">Nueva Contraseña</label>
              <div class="row g-0 align-items-center">
                <div class="col-10">
                  <input type="password" class="form-control" id="nuevoPassLogin" name="nuevoPassLogin" required
                    autocomplete="current-password" placeholder="Nueva contraseña de usuario">
                </div>
                <div class="col-2 text-end">
                  <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="form-label" for="repetirNuevoPassLogin">Repetir contraseña</label>
              <div class="row g-0 align-items-center">
                <div class="col-10">
                  <input type="password" class="form-control" id="repetirNuevoPassLogin" name="repetirNuevoPassLogin" required
                    autocomplete="current-password" placeholder="Repetir contraseña">
                </div>
                <div class="col-2 text-end">
                  <button type="button" class="btn btn-outline-secondary toggle-password">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>

            <div id="password-error" style="color: red; display: none;">Las contraseñas no coinciden.</div>

            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary w-100" disabled>Guardar e ingresar</button>
            </div>

            <?php
            require_once "controllers/usuario.controller.php";
            $nuevoPass = new ControladorUsuarios();
            $nuevoPass->ctrNuevoPassLogin();
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    const passwordInput = $('#nuevoPassLogin');
    const confirmPasswordInput = $('#repetirNuevoPassLogin');
    const submitButton = $('button[type="submit"]');
    const passwordError = $('#password-error');

    const requirements = {
      length: $('#require-length'),
      lowercase: $('#require-lowercase'),
      uppercase: $('#require-uppercase'),
      number: $('#require-number'),
    };

    // Validar contraseñas
    function validatePassword() {
      const password = passwordInput.val();
      const confirmPassword = confirmPasswordInput.val();
      let valid = true;

      // Validar longitud
      if (password.length >= 8) {
        requirements.length.removeClass('text-danger').addClass('text-success');
      } else {
        requirements.length.removeClass('text-success').addClass('text-danger');
        valid = false;
      }

      // Validar minúscula
      if (/[a-z]/.test(password)) {
        requirements.lowercase.removeClass('text-danger').addClass('text-success');
      } else {
        requirements.lowercase.removeClass('text-success').addClass('text-danger');
        valid = false;
      }

      // Validar mayúscula
      if (/[A-Z]/.test(password)) {
        requirements.uppercase.removeClass('text-danger').addClass('text-success');
      } else {
        requirements.uppercase.removeClass('text-success').addClass('text-danger');
        valid = false;
      }

      // Validar número
      if (/\d/.test(password)) {
        requirements.number.removeClass('text-danger').addClass('text-success');
      } else {
        requirements.number.removeClass('text-success').addClass('text-danger');
        valid = false;
      }

      // Validar coincidencia de contraseñas
      if (password !== confirmPassword || password === '' || confirmPassword === '') {
        passwordError.show();
        valid = false;
      } else {
        passwordError.hide();
      }

      // Habilitar/deshabilitar botón de envío
      submitButton.prop('disabled', !valid);
    }

    // Mostrar/Ocultar contraseña
    $('.toggle-password').on('click', function () {
      const input = $(this).closest('.row').find('input');
      const icon = $(this).find('i');

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });

    // Validar mientras se escribe
    passwordInput.on('input', validatePassword);
    confirmPasswordInput.on('input', validatePassword);
  });
</script>
