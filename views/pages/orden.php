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
                                                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" onchange="validateJS(event,'phone')" required>
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
                                    <!-- <div class="row g-3">

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                                                <div class="invalid-feedback">Por favor, seleccione una fecha válida.</div>
                                            </div>
                                        </div>

                                    </div> -->

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
                                                    <th>Costo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Las filas se agregarán dinámicamente con JS -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" class="text-end"><strong>Total General:</strong></td>
                                                    <td id="totalGeneral" class="text-end">0.00 Bs.</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <!-- <div class="row justify-content-center my-4">
                        <div class="col-lg-2 text-center">
                            <label for="metodoPago" class="form-label">Seleccionar un método de pago</label>
                            <select id="metodoPago" name="metodoPago" class="form-select" required>
                                <option value="">Selecciona un método</option>
                                <option value="1">Efectivo</option>
                                <option value="2">Pagos por QR</option>
                            </select>
                        </div>
                    </div> -->


                    <!-- Botón para Crear Orden -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="guardarOrden">Guardar Orden</button>
                    </div>
                    <?php
                    // $guardarOrden = new ControladorOrdenes();
                    // $guardarOrden->ctrGuardarOrden();
                    ?>

                </form>
            </div>
        </div>
    </div> <!-- Container -->
</div> <!-- Content -->



<!-- Modal para Agregar Prenda -->
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
                    <!-- Primera fila: Categoría y Prenda -->
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prenda" class="form-label">Prenda</label>
                                <select id="prenda" name="prenda" class="form-select" required>
                                    <option value="">Selecciona una prenda</option>
                                </select>
                                <div class="valid-feedback">Válido.</div>
                                <div class="invalid-feedback">Por favor selecciona una prenda.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: Color, Tipo de Lavado y Cantidad -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">Color</label>
                            <select id="color" name="color" class="form-select" required>
                                <option value="">Selecciona un color</option>
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
                        <div class="col-md-4">
                            <label for="lavado" class="form-label">Tipo de Lavado</label>
                            <select id="lavado" name="lavado" class="form-select" required>
                                <option value="">Selecciona un tipo de lavado</option>
                                <?php
                                $lavados = ControladorLavados::ctrMostrarLavados(null, null);
                                foreach ($lavados as $lavado) {
                                    echo '<option value="' . $lavado["id_lavado"] . '" data-costo="' . $lavado["costo_lavado"] . '">' . $lavado["descripcion_lavado"] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="valid-feedback">Válido.</div>
                            <div class="invalid-feedback">Por favor selecciona un tipo de lavado.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" required min="1" value="1">
                            <div class="valid-feedback">Válido.</div>
                            <div class="invalid-feedback">La cantidad debe ser al menos 1.</div>
                        </div>
                    </div>

                    <!-- Tercera fila: Opciones adicionales -->
                    <div class="row align-items-center gy-2">

                        <!-- Planchado -->
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="planchado" name="planchado">
                                <label class="form-check-label" for="planchado">Planchado</label>
                            </div>
                        </div>
                        <!-- Ojales -->
                        <div class="col-md-4 d-flex align-items-center">
                            <label for="cantidadOjales" class="form-label me-2 mb-0">Ojales</label>
                            <input type="number" class="form-control" id="cantidadOjales" name="cantidadOjales" placeholder="Cantidad">
                        </div>

                        <!-- Manualidad -->
                        <div class="col-md-6 d-flex align-items-center">
                            <label for="observacion" class="form-label me-2 mb-0">Manualidad</label>
                            <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observación">
                        </div>


                    </div>



                    <!-- Cuarta fila: Precio unitario y Total -->
                    <div class="row mt-4">
                        <div class="col-md-6 text-start">
                            <h5>Precio Unitario: <span id="precioUnitario">0.00</span> Bs.</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Total: <span id="totalCosto">0.00</span> Bs.</h5>
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

<script>
    // //MODAL Y IMPUTS
    // // Validar cantidad mínima
    // $('#cantidad').on('input', function () {
    //     if ($(this).val() < 1) {
    //         $(this).val(1);
    //     }
    // });

    // // Actualizar precio unitario y costo total
    // $('#lavado, #cantidad').on('change keyup', function () {
    //     const costoLavado = parseFloat($('#lavado option:selected').data('costo')) || 0;
    //     const cantidad = Math.max(parseInt($('#cantidad').val()) || 0, 1); // Asegurar mínimo 1
    //     const total = costoLavado * cantidad;

    //     // Actualizar precio unitario y total
    //     $('#precioUnitario').text(costoLavado.toFixed(2));
    //     $('#totalCosto').text(total.toFixed(2));
    // });

    // // Mostrar u ocultar input de ojales
    // function toggleOjalInput(checkbox) {
    //     $('#ojalesInput').toggle(checkbox.checked);
    // }

    // // Mostrar u ocultar input de manualidad
    // function toggleManualidadInput(checkbox) {
    //     $('#manualidadInput').toggle(checkbox.checked);
    // }
</script>