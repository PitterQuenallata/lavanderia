<div class="px-3">
    <!-- Start Content -->
    <div class="container-fluid">
        <!-- Start Page Title -->
        <div class="py-3 py-lg-4">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="page-title mb-0">Lista de Órdenes</h4>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Tabla de Órdenes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Órdenes Registradas</h5>
                        <table id="tablaOrdenes" class="table table-ms table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Número de Orden</th>
                                    <th>Cliente</th>
                                    <th>Fecha Recepción</th>
                                    <th>Fecha Entrega</th>
                                    <th>Monto Total</th>
                                    <th>Estado</th>
                                    <th>Estado Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $ordenes = ControladorOrdenes::ctrMostrarOrdenes($item, $valor);

                                if (!empty($ordenes)) {
                                    foreach ($ordenes as $key => $orden) {
                                        // Estado de la orden (Recepcionado, En Proceso, Entregado)
                                        $estadoOrden = "";
                                        switch ($orden["estado_orden"]) {
                                            case 0:
                                                $estadoOrden = '<span class="badge bg-primary">Recepcionado</span>';
                                                break;
                                            case 1:
                                                $estadoOrden = '<span class="badge bg-info">En Proceso</span>';
                                                break;
                                            case 2:
                                                $estadoOrden = '<span class="badge bg-success">Entregado</span>';
                                                break;
                                            default:
                                                $estadoOrden = '<span class="badge bg-secondary">Desconocido</span>';
                                        }

                                        // Estado del pago (Pendiente, Completado, Cancelado)
                                        $estadoPago = "";
                                        switch ($orden["estado_pago"]) {
                                            case "Pendiente":
                                                $estadoPago = '<span class="badge bg-warning">Pendiente</span>';
                                                break;
                                            case "Completado":
                                                $estadoPago = '<span class="badge bg-success">Completado</span>';
                                                break;
                                            case "Cancelado":
                                                $estadoPago = '<span class="badge bg-danger">Cancelado</span>';
                                                break;
                                            default:
                                                $estadoPago = '<span class="badge bg-secondary">Desconocido</span>';
                                        }

                                        // Generar las filas de la tabla
                                        echo '
        <tr>
            <td>' . ($key + 1) . '</td>
            <td>' . $orden["numero_orden"] . '</td>
            <td>' . $orden["nombre_cliente"] . '</td>
            <td>' . $orden["fecha_recepcion_orden"] . '</td>
            <td>' . $orden["fecha_entrega_orden"] . '</td>
            <td>' . number_format($orden["monto_total_orden"], 2) . ' Bs.</td>
            <td>' . $estadoOrden . '</td>
            <td>' . $estadoPago . '</td>
<td>
    <button 
        class="btn btn-info btn-sm btnVerOrden" 
        data-id="' . $orden["id_orden"] . '" 
        data-bs-toggle="modal" 
        data-bs-target="#modalVerOrden">Ver</button>
    <a href="imprimirOrden.php?id=' . $orden["id_orden"] . '" class="btn btn-primary btn-sm" target="_blank">Imprimir</a>
    <a href="editarOrden.php?id=' . $orden["id_orden"] . '" class="btn btn-warning btn-sm">Editar</a>
</td>

                    </tr>
                    ';
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">No se encontraron órdenes registradas.</td></tr>';
                                }
                                ?>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container -->

</div>
<!-- Content -->

<!-- Modal Ver Detalles de la Orden -->
<div id="modalVerOrden" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles de la Orden</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <!-- Información de la Orden -->
        <div class="mb-3">
          <p><strong>Número de Orden:</strong> <span id="detalleNumeroOrden"></span></p>
          <p><strong>Cliente:</strong> <span id="detalleCliente"></span></p>
          <p><strong>Fecha Recepción:</strong> <span id="detalleFechaRecepcion"></span></p>
          <p><strong>Fecha Entrega:</strong> <span id="detalleFechaEntrega"></span></p>
          <p><strong>Estado:</strong> <span id="detalleEstadoOrden"></span></p>
          <p><strong>Estado Pago:</strong> <span id="detalleEstadoPago"></span></p>
          <p><strong>Monto Total:</strong> <span id="detalleMontoTotal"></span></p>
        </div>

        <!-- Tabla de Detalles de Prendas -->
        <div class="table-responsive">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Prenda</th>
                <th>Color</th>
                <th>Lavado</th>
                <th>Cantidad</th>
                <th>Planchado</th>
                <th>Ojal</th>
                <th>Manualidad</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody id="detallePrendas">
              <!-- Las filas se generan dinámicamente -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

