<div class="px-3">
  <!-- Start Content-->
  <div class="container-fluid">
    <!-- start page title -->
    <div class="py-3 py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h4 class="page-title mb-0">Categoría de Prendas</h4>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
      <div class="col-8 col-lg-6">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-agregar-categoria-prenda">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Categoría
            </button>
            <h4 class="header-title">Lista de Categorías de Prendas</h4>

            <div class="table-responsive">
              <table id="tablaCatPrendas" class="table dt-responsive nowrap w-100">
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
                  $categoriasPrendas = ControladorCatPrendas::ctrMostrarCatPrendas($item, $valor);

                  foreach ($categoriasPrendas as $key => $value) {
                    echo '
                      <tr>
                          <th class="text-center" scope="row">' . ($key + 1) . '</th>
                          <td>' . mb_strtoupper($value["nombre_categoria_prenda"], 'UTF-8') . '</td>
                          <td class="text-center">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-secondary btnEditarCatPrenda" idCatPrenda="' . $value["id_categoria_prenda"] . '" data-bs-target="#modal-editar-categoria-prenda" data-bs-toggle="modal">
                                      <i class="fa fa-pencil-alt"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-secondary btnEliminarCatPrenda" idCatPrenda="' . $value["id_categoria_prenda"] . '">
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
<div id="modal-agregar-categoria-prenda" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Categoría de Prenda</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="nombre_categoria_prenda" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre_categoria_prenda" name="nombre_categoria_prenda" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $crearCatPrenda = new ControladorCatPrendas();
        $crearCatPrenda->ctrCrearCatPrenda();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div id="modal-editar-categoria-prenda" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Categoría de Prenda</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <input type="hidden" id="idCatPrenda" name="idCatPrenda">
          <div class="mb-3">
            <label for="editarNombreCatPrenda" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="editarNombreCatPrenda" name="editarNombreCatPrenda" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarCatPrenda = new ControladorCatPrendas();
        $editarCatPrenda->ctrEditarCatPrenda();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
$eliminarCatPrenda = new ControladorCatPrendas();
$eliminarCatPrenda->ctrEliminarCatPrenda();
?>
