<div class="px-3">
  <!-- Start Content-->
  <div class="container-fluid">
    <!-- start page title -->
    <div class="py-3 py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h4 class="page-title mb-0">Gestión de Colores</h4>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
      <div class="col-8 col-lg-10">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-agregar-color">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Color
            </button>
            <h4 class="header-title">Lista de Colores</h4>

            <div class="table-responsive">
              <table id="tablaColores" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Nombre</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $colores = ControladorColores::ctrMostrarColores($item, $valor);

                  foreach ($colores as $key => $value) {
                    echo '
                      <tr>
                          <th class="text-center" scope="row">' . ($key + 1) . '</th>
                          <td>' . mb_strtoupper($value["nombre_color"], 'UTF-8') . '</td>
                          <td class="text-center">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-secondary btnEditarColor" idColor="' . $value["id_color"] . '" data-bs-target="#modal-editar-color" data-bs-toggle="modal">
                                      <i class="fa fa-pencil-alt"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-secondary btnEliminarColor" idColor="' . $value["id_color"] . '">
                                      <i class="fa fa-times"></i>
                                  </button>
                              </div>
                          </td>
                      </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->
    </div>
    <!-- end row-->

  </div> <!-- container -->
</div> <!-- content -->

<!-- Modal Crear -->
<div id="modal-agregar-color" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Color</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="nombre_color" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre_color" name="nombre_color" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $crearColor = new ControladorColores();
        $crearColor->ctrCrearColor();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div id="modal-editar-color" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Color</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <input type="hidden" id="idColor" name="idColor">
          <div class="mb-3">
            <label for="editarNombreColor" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="editarNombreColor" name="editarNombreColor" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarColor = new ControladorColores();
        $editarColor->ctrEditarColor();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$eliminarColor = new ControladorColores();
$eliminarColor->ctrEliminarColor();
?>
