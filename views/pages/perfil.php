<?php
$usuario = ControladorUsuarios::ctrObtenerUsuarioPorId();
?>

<div class="px-3">
    <div class="container-fluid">
        <div class="py-3 py-lg-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h4 class="page-title mb-0">Editar Perfil</h4>
                    <p class="text-muted">Actualice sus datos personales y de acceso.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" id="passwordActualPerfil" name="passwordActualPerfil" value="<?php echo $usuario['password_usuario']; ?>">
                    <input type="hidden" id="fotoActualPerfil" name="fotoActualPerfil" value="<?php echo $usuario['foto_usuario']; ?>">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Información del Usuario</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarNombrePerfil" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="editarNombrePerfil" name="editarNombrePerfil" value="<?php echo $usuario['nombre_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarApellidoPerfil" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="editarApellidoPerfil" name="editarApellidoPerfil" value="<?php echo $usuario['apellido_paterno_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su apellido paterno.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarApellidoMaternoPerfil" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" id="editarApellidoMaternoPerfil" name="editarApellidoMaternoPerfil" value="<?php echo $usuario['apellido_materno_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su apellido materno.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarUsuarioPerfil" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" id="editarUsuarioPerfil" name="editarUsuarioPerfil" value="<?php echo $usuario['user_usuario']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarPasswordPerfil" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="editarPasswordPerfil" name="editarPasswordPerfil" oninput="validateJS(event,'password')" placeholder="Opcional: Cambiar contraseña">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarCelularPerfil" class="form-label">Celular</label>
                                        <input type="text" class="form-control" id="editarCelularPerfil" name="editarCelularPerfil" value="<?php echo $usuario['telefono_usuario']; ?>" oninput="validateJS(event,'phone')" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarEmailPerfil" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="editarEmailPerfil" name="editarEmailPerfil" value="<?php echo $usuario['email_usuario']; ?>" oninput="validateJS(event,'email')" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección para la foto -->
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="editarFotoPerfil" class="form-label">Foto de Perfil</label>
                                    <div class="input-group d-flex align-items-center">
                                        <div class="me-3">
                                            <input class="form-control nuevaFoto" name="editarFotoPerfil" id="editarFotoPerfil" type="file" style="width: 300px">
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <img class="img-fluid avatar-md rounded previsualizar" src="<?php echo $usuario['foto_usuario']; ?>" alt="Foto de usuario">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para Guardar Cambios -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Guardar Cambios</button>
                    </div>

                    <?php
                        $editarUsuario = new ControladorUsuarios();
                        $editarUsuario->ctrEditarPerfil();
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
