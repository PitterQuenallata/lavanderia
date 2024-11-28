<div class="px-3">

  <!-- Start Content-->
  <div class="container-fluid">

    <!-- start page title -->
    <div class="py-3 py-lg-4">
      <div class="row">
        <div class="col-lg-6">
          <h4 class="page-title mb-0">Usuarios</h4>
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
            <h4 class="header-title">Tabla de usuarios</h4>
            <button type="button" class="btn btn-success waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#modal-agregar-usuario">
              <i class="fa fa-plus opacity-50 me-1"></i>Añadir Usuario</button>
            <table id="tablaUsuarios" class="table dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;"></th>
                  <th class="text-center" style="width: 50px;"></th>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Correo</th>
                  <th>Rol</th>
                  <th>Celular</th>
                  <th>Estado</th>
                  <th>Ultimo Ingreso</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <?php
              $item = null;
              $valor = null;
              $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

              foreach ($usuarios as $key => $value) {
                echo '
              <tr>
                  <th class="text-center" scope="row">' . ($key + 1) . '</th>
                  <td class="text-center" scope="row">
                      <img class="img-fluid avatar-xs rounded-circle" src="' . $value["foto_usuario"] . '" alt="">
                  </td>
                  <td>' . mb_strtoupper($value["nombre_usuario"] . " " . $value["apellido_paterno_usuario"] . " " . $value["apellido_materno_usuario"], 'UTF-8') . '</td>
                  <td>' . $value["user_usuario"] . '</td>
                  <td>' . $value["email_usuario"] . '</td>
                  <td>' . $value["rol_usuario"] . '</td>
                  <td>' . $value["telefono_usuario"] . '</td>';

                if ($value["estado_usuario"] != 0) {
                  echo '
                  <td class="d-none d-sm-table-cell">
                      <button type="button" class="btnActivar badge btn btn-success" idUsuario="' . $value["id_usuario"] . '" estadoUsuario="0">Activo</button>
                  </td>';
                } else {
                  echo '
                  <td class="d-none d-sm-table-cell">
                      <button type="button" class="btnActivar badge btn btn-danger" idUsuario="' . $value["id_usuario"] . '" estadoUsuario="1">Inactivo</button>
                  </td>';
                }

                echo '
                  <td>' . $value["ultimo_login_usuario"] . '</td>
                  <td >
                      <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnEditarUsuario" idUsuario="' . $value["id_usuario"] . '" data-bs-target="#editar-modal-user" data-bs-toggle="modal" aria-label="Edit" data-bs-original-title="Edit">
                              <i class="fa fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn btn-sm btn-secondary js-bs-tooltip-enabled btnElininarUsuario" idUsuario="' . $value["id_usuario"] . '" fotoUsuario="' . $value["foto_usuario"] . '" usuario="' . $value["user_usuario"] . '" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
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

          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->
    </div>
    <!-- end row-->

  </div> <!-- container -->

</div> <!-- content -->

<!-- modal crear -->
<div id="modal-agregar-usuario" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Usuario</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        <div class="modal-body p-4">

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombres <span class="text-danger">*</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" oninput="validateJS(event,'text')" required="" style="text-transform: uppercase;">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-2" class="form-label">Apellido Paterno <span class="text-danger">*</label>
                <input type="text" class="form-control" id="apellido_usuario" name="apellido_usuario" oninput="validateJS(event,'text')" required autocomplete="userapellido" style="text-transform: uppercase;">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-2" class="form-label">Apellido Materno <span class="text-danger">*</label>
                <input type="text" class="form-control" id="apellido_materno_usuario" name="apellido_materno_usuario" required oninput="validateJS(event,'text')" autocomplete="userapellidom" style="text-transform: uppercase;">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-4" class="form-label">Usuario <span class="text-danger">*</label>
                <input type="text" class="form-control" id="nuevoUsuario" name="user_usuario" oninput="validateJS(event,'complete')" required autocomplete="username">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-5" class="form-label">Contraseña <span class="text-danger">*</label>
                <input type="password" class="form-control" id="password_usuario" name="password_usuario" onchange="validateJS(event,'password')" required autocomplete="current-password">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="roles" class="form-label">Roles<span class="text-danger">*</span></label>
                <select class="form-select" name="rol_usuario" id="rol_usuario" required>
                  <option value="" selected disabled>Elije un rol</option>
                  <option value="administrador">Administrador</option>
                  <option value="promotor">Promotor</option>
                  <option value="secretaria">Secretaria</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione un rol válido.</div>
              </div>
            </div>

          </div>


          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-4" class="form-label">Celular <span class="text-danger">*</label>
                <input type="text" class="form-control" id="celular_usuario" name="celular_usuario" onchange="validateJS(event,'phone')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-5" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_usuario" name="email_usuario" onchange="validateJS(event,'email')" autocomplete="email">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="field-5" class="form-label">Foto</label>

              <div class="input-group d-flex align-items-center">
                <div class="me-3">
                  <input class="form-control nuevaFoto" name="nuevaFoto" type="file" id="example-file-input" style="width: 300px">
                  <input class="form-control" type="hidden" name="defaultFoto" value="views/assets/media/avatars/avatar0.jpg">
                </div>
                <div class="ms-4 mt-2">
                  <img class="img-fluid avatar-md rounded  previsualizar" src="views/assets/media/avatars/avatar0.jpg" alt="fotoUser">
                </div>
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
        $crearUsuario = new ControladorUsuarios();
        $crearUsuario->ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->


<!-- modal Editar -->
<div id="editar-modal-user" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Usuario</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post"  enctype="multipart/form-data" class="needs-validation" novalidate>

        <input type="hidden" id="passwordActual" name="passwordActual" value="">
        <input type="hidden" id="fotoActual" name="fotoActual" value="">

        <div class="modal-body p-4">

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-1" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="editarNombre" name="editarNombre" oninput="validateJS(event,'text')" required autocomplete="username" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-2" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="editarApellido" name="editarApellido" oninput="validateJS(event,'text')" required autocomplete="username" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-2" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="editarApellidoMaterno" name="editarApellidoMaterno" oninput="validateJS(event,'text')" required autocomplete="username" style="text-transform: uppercase;" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-4" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" oninput="validateJS(event,'text')" required autocomplete="username" required readonly>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="field-5" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="editarPassword" onchange="validateJS(event,'password')" autocomplete="current-password" placeholder="Ingresar nueva contraseña">
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select class="form-select" id="editarPerfil" name="editarPerfil">
                  <option selected="">Elije un rol</option>
                  <option value="administrador">Administrador</option>
                  <option value="promotor">Promotor</option>
                  <option value="secretaria">Secretaria</option>
                </select>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-4" class="form-label">Celular</label>
                <input type="number" class="form-control" id="editarCelular" name="editarCelular" onchange="validateJS(event,'phone')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="field-5" class="form-label">Email</label>
                <input type="email" class="form-control" id="editarEmail" name="editarEmail" onchange="validateJS(event,'email')" required>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor llena este campo correctamente.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="field-5" class="form-label">Foto</label>

              <div class="input-group d-flex align-items-center">
                <div class="me-3">
                  <input class="form-control nuevaFoto" name="editarFoto" type="file" style="width: 300px">
                </div>
                <div class="ms-4 mt-2">
                  <img class="img-fluid avatar-md rounded  previsualizar" src="path_a_foto" alt="fotoUser">
                </div>
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
        $editarUsuario = new ControladorUsuarios();
        $editarUsuario->ctrEditarUsuario();

        ?>
      </form>
    </div>
  </div>
</div><!-- /.modal -->


<?php
$eliminarUsuario = new ControladorUsuarios();
$eliminarUsuario->ctrBorrarUsuario();
