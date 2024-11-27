<div class="px-3">
    <!-- Start Content -->
    <div class="container-fluid">
        <!-- Start Page Title -->
        <div class="py-3 py-lg-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h4 class="page-title mb-0">Crear Nueva Orden</h4>
                    <p class="text-muted">Complete los detalles de la orden para generar la nota para el cliente.</p>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form method="post" class="needs-validation" novalidate>
                    <div class="row">

                        <!-- Información General -->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Información General</h5>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="dni_cliente" class="form-label">DNI <span class="text-danger">*</label>
                                                <input type="text" class="form-control" id="dni_cliente" name="dni_cliente" oninput="validateJS(event,'integer')" required>
                                                <div class="invalid-feedback">Por favor, ingrese un DNI válido.</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nombre_cliente" class="form-label">Nombre <span class="text-danger">*</label>
                                                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                                <div class="invalid-feedback">Por favor, ingrese un nombre válido.</div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="apellido_cliente" class="form-label">Apellido <span class="text-danger">*</label>
                                                <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente" oninput="validateJS(event,'text')" required style="text-transform: uppercase;">
                                                <div class="invalid-feedback">Por favor, ingrese un apellido válido.</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="telefono_cliente" class="form-label">Teléfono <span class="text-danger">*</label>
                                                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" oninput="validateJS(event,'phone')" required>
                                                <div class="invalid-feedback">Por favor, ingrese un teléfono válido.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="email_cliente" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email_cliente" name="email_cliente" oninput="validateJS(event,'email')">
                                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="direccion_cliente" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" oninput="validateJS(event,'complete')">
                                                <div class="invalid-feedback">Por favor, ingrese una dirección válida.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="peso_orden" class="form-label">Peso (Kg)</label>
                                                <input type="number" step="0.01" class="form-control" id="peso_orden" name="peso_orden">
                                                <div class="invalid-feedback">Por favor, ingrese el peso.</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                                                <div class="invalid-feedback">Por favor, seleccione una fecha válida.</div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row g-3">

                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="comentario" class="form-label">Comentarios</label>
                                                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Detalles de Prendas -->
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Detalles de Prendas</h5>
                                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarPrenda">
                                        <i class="fa fa-plus"></i> Agregar Prenda
                                    </button>
                                    <div class="table-responsive">
                                        <table id="tablaDetallesPrendas" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Prenda</th>
                                                    <th>Color</th>
                                                    <th>Tipo de Lavado</th>
                                                    <th>Cantidad</th>
                                                    <th>Planchado</th>
                                                    <th>Ojal</th>
                                                    <th>Manualidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Las filas se agregarán dinámicamente con JS -->
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para Crear Orden -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Guardar Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- Container -->
</div> <!-- Content -->


<!-- Modal para Agregar Prenda -->
<div id="modalAgregarPrenda" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Prenda</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formAgregarPrenda" class="needs-validation" novalidate>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="prenda" class="form-label">Prenda</label>
                                <select id="prenda" name="prenda" class="form-control" required>
                                    <option value="">Seleccionar Prenda</option>
                                    <?php
                                    $prendas = ControladorPrendas::ctrMostrarPrendas(null, null);
                                    foreach ($prendas as $prenda) {
                                        echo '<option value="' . $prenda["id_prenda"] . '">' . $prenda["descripcion_prenda"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="valid-feedback">Válido.</div>
                                <div class="invalid-feedback">Por favor selecciona una prenda.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <select id="color" name="color" class="form-control" required>
                                    <option value="">Seleccionar Color</option>
                                    <?php
                                    $colores = ControladorColores::ctrMostrarColores(null, null);
                                    foreach ($colores as $color) {
                                        echo '<option value="' . $color["id_color"] . '">' . $color["nombre_color"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="valid-feedback">Válido.</div>
                                <div class="invalid-feedback">Por favor selecciona un color.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="lavado" class="form-label">Tipo de Lavado</label>
                                <select id="lavado" name="lavado" class="form-control" required>
                                    <option value="">Seleccionar Lavado</option>
                                    <?php
                                    $lavados = ControladorLavados::ctrMostrarLavados(null, null);
                                    foreach ($lavados as $lavado) {
                                        echo '<option value="' . $lavado["id_lavado"] . '">' . $lavado["descripcion_lavado"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="valid-feedback">Válido.</div>
                                <div class="invalid-feedback">Por favor selecciona un tipo de lavado.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                                <div class="valid-feedback">Válido.</div>
                                <div class="invalid-feedback">Por favor ingresa una cantidad válida.</div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <label class="mb-3" for="">Opcional</label>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="planchado" name="planchado">
                                <label class="form-check-label" for="planchado">Planchado</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ojal" name="ojal">
                                <label class="form-check-label" for="ojal">Ojales</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="manualidad" name="manualidad">
                                <label class="form-check-label" for="manualidad">Manualidad</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnGuardarPrenda" class="btn btn-info waves-effect waves-light">Agregar Prenda</button>
                </div>
            </form>
        </div>
    </div>
</div>