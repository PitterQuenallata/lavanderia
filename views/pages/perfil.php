<div class="px-3">
    <!-- Start Content -->
    <div class="container-fluid">
        <!-- Start Page Title -->
        <div class="py-3 py-lg-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h4 class="page-title mb-0">Editar Perfil</h4>
                    <p class="text-muted">Actualice sus datos personales y de acceso.</p>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" id="passwordActual" name="passwordActual" value="<?php echo $_SESSION['users']['password_usuario']; ?>">
                    <input type="hidden" id="fotoActual" name="fotoActual" value="<?php echo $_SESSION['users']['foto_usuario']; ?>">

                    <!-- Card for Profile Information -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Información del Usuario</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarNombre" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="<?php echo $_SESSION['users']['nombre_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarApellido" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="editarApellido" name="editarApellido" value="<?php echo $_SESSION['users']['apellido_paterno_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su apellido paterno.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="editarApellidoMaterno" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" id="editarApellidoMaterno" name="editarApellidoMaterno" value="<?php echo $_SESSION['users']['apellido_materno_usuario']; ?>" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese su apellido materno.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarUsuario" class="form-label">Usuario</label>
                                        <input type="text" class="form-control" id="editarUsuario" name="editarUsuario" value="<?php echo $_SESSION['users']['user_usuario']; ?>" readonly>
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Este campo no puede ser editado.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarPassword" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="editarPassword" name="editarPassword" oninput="validateJS(event,'password')" placeholder="Opcional: Cambiar contraseña">
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese una contraseña válida.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarCelular" class="form-label">Celular</label>
                                        <input type="text" class="form-control" id="editarCelular" name="editarCelular" value="<?php echo $_SESSION['users']['telefono_usuario']; ?>" oninput="validateJS(event,'phone')" required>
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese un número de celular válido.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editarEmail" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="editarEmail" name="editarEmail" value="<?php echo $_SESSION['users']['email_usuario']; ?>" oninput="validateJS(event,'email')" required>
                                        <div class="valid-feedback">Válido.</div>
                                        <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="editarFoto" class="form-label">Foto de Perfil</label>
                                    <div class="input-group d-flex align-items-center">
                                        <div class="me-3">
                                            <input class="form-control nuevaFoto" name="editarFoto" type="file" style="width: 300px">
                                        </div>
                                        <div class="ms-4 mt-2">
                                            <img class="img-fluid avatar-md rounded previsualizar" src="<?php echo $_SESSION['users']['foto_usuario']; ?>" alt="Foto de usuario">
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
                </form>
            </div>
        </div>
    </div> <!-- Container -->
</div> <!-- Content -->
