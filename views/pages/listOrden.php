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
                <a href="verOrden.php?id=' . $orden["id_orden"] . '" class="btn btn-info btn-sm">Ver</a>
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