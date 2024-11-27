<div class="px-3">

  <!-- Start Content-->
  <div class="container-fluid">

    <!-- Start Page Title -->
    <div class="py-3 py-lg-4">
      <div class="row">
        <div class="col-lg-6">
          <h4 class="page-title mb-0">Clientes</h4>
        </div>
      </div>
    </div>
    <!-- End Page Title -->

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title">Tabla de Clientes</h4>
            <button type="button" class="btn btn-success waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#modal-agregar-cliente">
              <i class="fa fa-plus opacity-50 me-1"></i>Nuevo Cliente</button>
            <table id="tablaClientes" class="table dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Teléfono</th>
                  <th>Dirección</th>
                  <th>Email</th>
                  <th>DNI</th>
                  <th>Acciones</th>
                </tr>
              </thead>

              <?php
              $clientes = ControladorClientes::ctrMostrarClientes(null, null);

              foreach ($clientes as $key => $value) {
                echo '
              <tr>
                  <th class="text-center" scope="row">' . ($key + 1) . '</th>
                  <td>' . mb_strtoupper($value["nombre_cliente"], 'UTF-8') . '</td>
                  <td>' . mb_strtoupper($value["apellido_cliente"], 'UTF-8') . '</td>
                  <td>' . $value["telefono_cliente"] . '</td>
                  <td>' . $value["direccion_cliente"] . '</td>
                  <td>' . $value["email_cliente"] . '</td>
                  <td>' . $value["dni_cliente"] . '</td>
                  <td>
                      <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-secondary btnEditarCliente" idCliente="' . $value["id_cliente"] . '" data-bs-toggle="modal" data-bs-target="#modal-editar-cliente">
                              <i class="fa fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn btn-sm btn-secondary btnEliminarCliente" idCliente="' . $value["id_cliente"] . '">
                              <i class="fa fa-times"></i>
                          </button>
                      </div>
                  </td>
              </tr>';
              }
              ?>
              <tbody>
              </tbody>
            </table>

          </div> <!-- End Card Body-->
        </div> <!-- End Card -->
      </div> <!-- End Col -->
    </div>
    <!-- End Row -->

  </div> <!-- Container -->

</div> <!-- Content -->

<!-- Modal Crear -->
<div id="modal-agregar-cliente" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Cliente</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="nombre_cliente" class="form-label">Nombre <span class="text-danger">*</label>
            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" oninput="validateJS(event, 'text')" required style="text-transform: uppercase;">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
          <div class="mb-3">
            <label for="apellido_cliente" class="form-label">Apellido <span class="text-danger">*</label>
            <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente" oninput="validateJS(event, 'text')" required style="text-transform: uppercase;" > 
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
          <div class="mb-3">
            <label for="telefono_cliente" class="form-label">Teléfono <span class="text-danger">*</label>
            <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" onchange="validateJS(event, 'phone')" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
          <div class="mb-3">
            <label for="direccion_cliente" class="form-label">Dirección</label>
            <textarea class="form-control" id="direccion_cliente" name="direccion_cliente" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="email_cliente" class="form-label">Email</label>
            <input type="email" class="form-control" id="email_cliente" name="email_cliente" onchange="validateJS(event, 'email')">
          </div>
          <div class="mb-3">
            <label for="dni_cliente" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni_cliente" name="dni_cliente" maxlength="20">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $crearCliente = new ControladorClientes();
        $crearCliente->ctrCrearCliente();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div id="modal-editar-cliente" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Cliente</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <input type="hidden" id="idCliente" name="idCliente">
          <div class="mb-3">
            <label for="editarNombreCliente" class="form-label">Nombre <span class="text-danger">*</label>
            <input type="text" class="form-control" id="editarNombreCliente" name="editarNombreCliente" oninput="validateJS(event, 'text')" required style="text-transform: uppercase;">
          </div>
          <div class="mb-3">
            <label for="editarApellidoCliente" class="form-label">Apellido <span class="text-danger">*</label>
            <input type="text" class="form-control" id="editarApellidoCliente" name="editarApellidoCliente" oninput="validateJS(event, 'text')" required style="text-transform: uppercase;">
          </div>
          <div class="mb-3">
            <label for="editarTelefonoCliente" class="form-label">Teléfono <span class="text-danger">*</label>
            <input type="text" class="form-control" id="editarTelefonoCliente" name="editarTelefonoCliente" oninput="validateJS(event, 'phone')" required>
          </div>
          <div class="mb-3">
            <label for="editarDireccionCliente" class="form-label">Dirección</label>
            <textarea class="form-control" id="editarDireccionCliente" name="editarDireccionCliente" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="editarEmailCliente" class="form-label">Email</label>
            <input type="email" class="form-control" id="editarEmailCliente" name="editarEmailCliente" oninput="validateJS(event, 'email')">
          </div>
          <div class="mb-3">
            <label for="editarDniCliente" class="form-label">DNI</label>
            <input type="text" class="form-control" id="editarDniCliente" name="editarDniCliente" maxlength="20">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarCliente = new ControladorClientes();
        $editarCliente->ctrEditarCliente();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$eliminarUsuario = new ControladorClientes();
$eliminarUsuario->ctrEliminarCliente();