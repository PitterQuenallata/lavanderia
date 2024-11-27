<div class="px-3">

  <!-- Start Content-->
  <div class="container-fluid">

    <!-- start page title -->
    <div class="py-3 py-lg-4">
      <div class="row">
        <div class="col-lg-6">
          <h4 class="page-title mb-0">Productos</h4>
        </div>
        <!-- <div class="col-lg-6">
               <div class="d-none d-lg-block">
                <ol class="breadcrumb m-0 float-end">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
               </div>
            </div> -->
      </div>
    </div>
    <!-- end page title -->


    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title">Lista de Productos</h4>
            <button type="button" class="btn btn-success waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#modal-agregar-proveedor">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Productos</button>
            <table id="tablaProductos" class="table dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th>Descripcion</th>
                  <th>Unidad medida</th>
                  <th>Stock</th>
                  <th>Precio</th>
                  <th class="text-center" style="width: 100px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $item = null;
                $valor = null;
                $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                foreach ($proveedores as $key => $value) {
                  echo '
                    <tr>
                        <th class="text-center" scope="row">' . ($key + 1) . '</th>
                        <td>' . mb_strtoupper($value["nombre_proveedor"], 'UTF-8') . '</td>
                        <td>' . $value["telefono_proveedor"] . '</td>
                        <td>' . $value["nit_ci_proveedor"] . '</td>
                        <td>' . $value["email_proveedor"] . '</td>
                        <td>' . $value["direccion_proveedor"] . '</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEditarProveedores" idProveedor="' . $value["id_proveedor"] . '" data-bs-target="#modal-editar-proveedor" data-bs-toggle="modal" aria-label="Edit" data-bs-original-title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEliminarProveedor" idProveedor="' . $value["id_proveedor"] . '" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>';
                }
                ?>
              </tbody>
            </table>

          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->
    </div>
    <!-- end row-->

  </div> <!-- container -->

</div> <!-- content -->

<!-- modal crear -->
<div id="modal-agregar-proveedor" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Proveedor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation">
        <div class="modal-body p-4">

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" onchange="validateJS(event,'complete')" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-4" class="form-label">Celular</label>
                <input type="text" class="form-control" id="telefono_proveedor" name="telefono_proveedor" onchange="validateJS(event,'phone')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-5" class="form-label">DNI o NIT</label>
                <input type="text" class="form-control" id="nit_ci_proveedor" name="nit_ci_proveedor" onchange="validateJS(event,'integer')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-4" class="form-label">Direccion</label>
                <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor" onchange="validateJS(event,'complete')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-4" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_proveedor" name="email_proveedor" onchange="validateJS(event,'email')" required>
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
        $crearProveedor = new ControladorProveedores();
        $crearProveedor->ctrCrearProveedor();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->


<!-- modal ediotar -->
<div id="modal-editar-proveedor" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Proveedor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation">
        <div class="modal-body p-4">

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="editarNombreProveedor" name="editarNombreProveedor" onchange="validateJS(event,'complete')" style="text-transform: uppercase;" requerid>
                <input type="hidden" id="nombreActual" name="nombreActual">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-4" class="form-label">Celular</label>
                <input type="text" class="form-control" id="editarTelefonoProveedor" name="editarTelefonoProveedor" onchange="validateJS(event,'phone')" required>
                <input type="hidden" id="telefonoActual" name="telefonoActual">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-5" class="form-label">DNI o NIT</label>
                <input type="text" class="form-control" id="edit_nit_ci_proveedor" name="edit_nit_ci_proveedor" onchange="validateJS(event,'integer')" required>
                <input type="hidden" id="edit_nit_ci_proveedor_actual" name="nit_ci_proveedor_actual">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-4" class="form-label">Direccion</label>
                <input type="text" class="form-control" id="editarDireccionProveedor" name="editarDireccionProveedor" onchange="validateJS(event,'complete')" required>
                <input type="hidden" id="direccionActual" name="direccionActual">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="field-4" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit_email_proveedor" name="edit_email_proveedor" onchange="validateJS(event,'email')" required>
                <input type="hidden" id="emailActual" name="emailActual">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <input type="hidden" id="idProveedor" name="idProveedor">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarProveedor = new ControladorProveedores();
        $editarProveedor->ctrEditarProveedor();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->

<?php
$eliminarProveedor = new ControladorProveedores();
$eliminarProveedor->ctrEliminarProveedor();
