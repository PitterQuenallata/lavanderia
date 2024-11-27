<div class="px-3">
  <!-- Start Content-->
  <div class="container-fluid">
    <!-- start page title -->
    <div class="py-3 py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h4 class="page-title mb-0">Gestión de Prendas</h4>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
      <div class="col-8 col-lg-10">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-agregar-prenda">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Prenda
            </button>
            <h4 class="header-title">Lista de Prendas</h4>

            <div class="table-responsive">
              <table id="tablaPrendas" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $prendas = ControladorPrendas::ctrMostrarPrendas($item, $valor);

                  foreach ($prendas as $key => $value) {
                    echo '
                      <tr>
                          <th class="text-center" scope="row">' . ($key + 1) . '</th>
                          <td>' . mb_strtoupper($value["descripcion_prenda"], 'UTF-8') . '</td>
                          <td>' . mb_strtoupper($value["nombre_categoria_prenda"], 'UTF-8') . '</td>
                          <td class="text-center">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-secondary btnEditarPrenda" idPrenda="' . $value["id_prenda"] . '" data-bs-target="#modal-editar-prenda" data-bs-toggle="modal">
                                      <i class="fa fa-pencil-alt"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-secondary btnEliminarPrenda" idPrenda="' . $value["id_prenda"] . '">
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
<div id="modal-agregar-prenda" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Prenda</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="descripcion_prenda" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion_prenda" name="descripcion_prenda" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
          <div class="mb-3">
            <label for="categoria_prenda" class="form-label">Categoría</label>
            <select class="form-select" id="categoria_prenda" name="categoria_prenda" required>
              <option value="">Selecciona una categoría</option>
              <?php
              $categorias = ControladorCatPrendas::ctrMostrarCatPrendas(null, null);
              foreach ($categorias as $categoria) {
                echo '<option value="' . $categoria["id_categoria_prenda"] . '">' . mb_strtoupper($categoria["nombre_categoria_prenda"], 'UTF-8') . '</option>';
              }
              ?>
            </select>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor selecciona una categoría.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $crearPrenda = new ControladorPrendas();
        $crearPrenda->ctrCrearPrenda();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div id="modal-editar-prenda" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Prenda</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <input type="hidden" id="idPrenda" name="idPrenda">
          <div class="mb-3">
            <label for="editarDescripcionPrenda" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="editarDescripcionPrenda" name="editarDescripcionPrenda" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
          <div class="mb-3">
            <label for="editarCategoriaPrenda" class="form-label">Categoría</label>
            <select class="form-select" id="editarCategoriaPrenda" name="editarCategoriaPrenda" required>
              <option value="">Selecciona una categoría</option>
              <?php
              $categorias = ControladorCatPrendas::ctrMostrarCatPrendas(null, null);
              foreach ($categorias as $categoria) {
                echo '<option value="' . $categoria["id_categoria_prenda"] . '">' . mb_strtoupper($categoria["nombre_categoria_prenda"], 'UTF-8') . '</option>';
              }
              ?>
            </select>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor selecciona una categoría.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarPrenda = new ControladorPrendas();
        $editarPrenda->ctrEditarPrenda();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$eliminarPrenda = new ControladorPrendas();
$eliminarPrenda->ctrEliminarPrenda();
?>
