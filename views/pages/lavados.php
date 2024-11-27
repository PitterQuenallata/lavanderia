<div class="px-3">
  <!-- Start Content -->
  <div class="container-fluid">
    <!-- Start Page Title -->
    <div class="py-3 py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h4 class="page-title mb-0">Lavados</h4>
        </div>
      </div>
    </div>
    <!-- End Page Title -->

    <div class="row justify-content-center">
      <div class="col-8 col-lg-8">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-agregar-lavado">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Lavado
            </button>
            <h4 class="header-title">Lista de Lavados</h4>

            <div class="table-responsive">
              <table id="tablaLavados" class="table dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Costo</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $lavados = ControladorLavados::ctrMostrarLavados($item, $valor);

                  foreach ($lavados as $key => $value) {
                    echo '
                      <tr>
                        <th class="text-center" scope="row">' . ($key + 1) . '</th>
                        <td>' . ucfirst($value["descripcion_lavado"]) . '</td>
                        <td>' . ucfirst($value["tipo_lavado"]) . '</td>
                        <td>' . number_format($value["costo_lavado"], 2) . '</td>
                        <td class="text-center">
                          <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEditarLavado" idLavado="' . $value["id_lavado"] . '" data-bs-target="#modal-editar-lavado" data-bs-toggle="modal" aria-label="Edit" data-bs-original-title="Edit">
                              <i class="fa fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEliminarLavado" idLavado="' . $value["id_lavado"] . '" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
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

          </div> <!-- End Card Body -->
        </div> <!-- End Card -->
      </div><!-- End Col -->
    </div>
    <!-- End Row -->

  </div> <!-- Container -->
</div> <!-- Content -->

<!-- Modal Crear -->
<div id="modal-agregar-lavado" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Lavado</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="descripcion_lavado" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion_lavado" name="descripcion_lavado" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label for="tipo_lavado" class="form-label">Tipo</label>
                <select class="form-control" id="tipo_lavado" name="tipo_lavado" required>
                  <option value="básico">Básico</option>
                  <option value="premium">Premium</option>
                  <option value="especial">Especial</option>
                </select>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor selecciona un tipo.</div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label for="costo_lavado" class="form-label">Costo</label>
                <input type="number" step="0.01" class="form-control" id="costo_lavado" name="costo_lavado" required>
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
        $crearLavado = new ControladorLavados();
        $crearLavado->ctrCrearLavado();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.Modal -->

<!-- Modal Editar -->
<div id="modal-editar-lavado" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Lavado</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body p-4">
          <input type="hidden" id="idLavado" name="idLavado">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="editarDescripcionLavado" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="editarDescripcionLavado" name="editarDescripcionLavado" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label for="editarTipoLavado" class="form-label">Tipo</label>
                <select class="form-control" id="editarTipoLavado" name="editarTipoLavado" required>
                  <option value="básico">Básico</option>
                  <option value="premium">Premium</option>
                  <option value="especial">Especial</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label for="editarCostoLavado" class="form-label">Costo</label>
                <input type="number" step="0.01" class="form-control" id="editarCostoLavado" name="editarCostoLavado" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
        </div>
        <?php
        $editarLavado = new ControladorLavados();
        $editarLavado->ctrEditarLavado();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.Modal -->

<?php
$eliminarLavado = new ControladorLavados();
$eliminarLavado->ctrEliminarLavado();
?>
