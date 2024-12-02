<script src="views/assets/js/js/confirmarOrden.js"></script>


<div class="px-3">
  <!-- Start Content -->
  <div class="container-fluid">
    <!-- Start Page Title -->
    <div class="py-3 py-lg-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h4 class="page-title mb-0">Confirmar Orden</h4>
        </div>
      </div>
    </div>
    <!-- End Page Title -->

    <!-- Detalles de la Orden -->
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Datos del Cliente</h5>
            <ul>
              <li><strong>Nombre:</strong> <span id="nombre_cliente_pO"></span></li>
              <li><strong>Apellido:</strong> <span id="apellido_cliente_pO"></span></li>
              <li><strong>DNI:</strong> <span id="dni_cliente_pO"></span></li>
              <li><strong>Teléfono:</strong> <span id="telefono_cliente_pO"></span></li>
              <li><strong>Dirección:</strong> <span id="direccion_cliente_pO"></span></li>
              <li><strong>Correo:</strong> <span id="email_cliente_pO"></span></li>
            </ul>

            <h5 class="card-title">Detalles de Prendas</h5>
            <table class="table table-sm">
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
                </tr>
              </thead>
              <tbody id="tablaPreOrden_pO">
                <!-- Las filas se generarán dinámicamente -->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="7" class="text-end"><strong>Total General:</strong></td>
                  <td id="totalGeneralPreOrden_pO" class="text-end">0.00 Bs.</td>
                </tr>
              </tfoot>
            </table>

            <h5 class="card-title mt-4 text-center">Confirmar Pago</h5>
            <div class="d-flex justify-content-center">
              <form id="confirmarPagoForm_pO" method="post" class="w-50">
                <!-- Row para Fecha de Entrega y Método de Pago -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="fecha_entrega_pO" class="form-label">Fecha de Entrega</label>
                    <input type="date" class="form-control" id="fecha_entrega_pO" name="fecha_entrega_pO" required>
                    <div class="invalid-feedback">Por favor, seleccione una fecha válida.</div>
                  </div>
                  <div class="col-md-6">
                    <label for="metodoPago_pO" class="form-label">Método de Pago</label>
                    <select id="metodoPago_pO" name="metodoPago_pO" class="form-select" required>
                      <option value="">Selecciona un método de pago</option>
                      <option value="qr">QR</option>
                      <option value="efectivo">Efectivo</option>
                    </select>
                  </div>
                </div>

                <!-- Row para Monto Pagado y Monto Pendiente -->
                <div class="row">
                  <div class="col-md-6">
                    <label for="montoPagado_pO" class="form-label">Monto Pagado</label>
                    <input type="number" id="montoPagado_pO" name="montoPagado_pO" class="form-control" placeholder="Monto Pagado" required>
                  </div>
                  <div class="col-md-6">
                    <label for="montoPendiente_pO" class="form-label">Monto Pendiente</label>
                    <input type="number" id="montoPendiente_pO" name="montoPendiente_pO" class="form-control" placeholder="Monto Pendiente" readonly>
                  </div>
                </div>

                <!-- Botón para Guardar Orden -->
                <div class="text-center mt-4">
                  <button type="submit" id="confirmarOrden_pO"  class="btn btn-info">Confirmar Orden</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container -->
</div>



<!-- Modal para Esperar Pago -->
<div id="modalQr" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Esperando Pago</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Mensaje de Espera -->
        <p id="qrCodeMessage">Se ha generado un ticket con el QR. Espere el pago o verifíquelo manualmente.</p>
        <!-- Indicador de Estado del Pago -->
        <div id="paymentStatusMessage" class="alert alert-info d-none">
          Verificando el estado del pago...
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <!-- Botón para verificar el pago -->
        <button id="btnVerifyPayment" type="button" class="btn btn-primary">Verificar Pago</button>
        <!-- Botón para cancelar el proceso -->
        <button id="btnCancelPayment" type="button" class="btn btn-danger">Cancelar Pago QR</button>
      </div>
    </div>
  </div>
</div>




