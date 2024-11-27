<div class="px-3">
  <!-- Start Content-->
  <div class="container-fluid">
    <!-- start page title -->
    <div class="py-3 py-lg-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 text-center">
      <h4 class="page-title mb-0">Categoria Productos</h4>
    </div>
  </div>
</div>

    <!-- end page title -->

    <div class="row justify-content-center">
      <div class="col-8 col-lg-6">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-agregar-categoria-producto">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Categoria
            </button>
            <h4 class="header-title">Lista de categorias productos</h4>

            <div class="table-responsive">
              <table id="tablaCatProductos" class="table dt-responsive nowrap w-100">
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
                  $proveedores = ControladorCatProductos::ctrMostrarCatProductos($item, $valor);

                  foreach ($proveedores as $key => $value) {
                    echo '
                      <tr>
                          <th class="text-center" scope="row">' . ($key + 1) . '</th>
                          <td>' . mb_strtoupper($value["nombre_categoria_producto"], 'UTF-8') . '</td>
                        
                          <td class="text-center">
                              <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEditarCatProducto" idCatProductos="' . $value["id_categoria_producto"] . '" data-bs-target="#modal-editar-categoria-producto" data-bs-toggle="modal" aria-label="Edit" data-bs-original-title="Edit">
                                      <i class="fa fa-pencil-alt"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEliminarCatProducto" idCatProductos="' . $value["id_categoria_producto"] . '" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
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


<!-- modal crear -->
<div id="modal-agregar-categoria-producto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Categoria producto</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation">
        <div class="modal-body p-4">

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_categoria_producto" name="nombre_categoria_producto" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $crearCatProductos = new ControladorCatProductos();
        $crearCatProductos->ctrCrearCatProductos();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->


<!-- modal editar -->
<div id="modal-editar-categoria-producto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Categoria producto</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
        <input type="hidden" id="idCatProductos" name="idCatProductos">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="editarNombreCatProducto" name="editarNombreCatProducto" oninput="validateJS(event,'text')" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>
          
          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarCatProductos = new ControladorCatProductos();
        $editarCatProductos->ctrEditarCatProductos();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->




<?php
$eliminarCatProductos = new ControladorCatProductos();
$eliminarCatProductos->ctrEliminarCatProductos();
