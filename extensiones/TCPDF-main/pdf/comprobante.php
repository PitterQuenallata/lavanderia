<?php
require_once '../tcpdf.php';
require_once '../../../controllers/ordenes.controller.php';
require_once '../../../models/ordenes.model.php';

// Obtener el movimiento_id desde el parámetro GET
$idOrden = isset($_GET['idOrden']) ? $_GET['idOrden'] : null;

if (!$idOrden) {
    die("Error: No se proporcionó el numero de orden.");
}


$respuesta = ControladorOrdenes::ctrMostrarDetallesOrden($idOrden);
if (!$respuesta || !$respuesta["success"]) {
    die("Error: No se encontraron detalles para la orden especificada.");
}
// Datos de la orden
$orden = $respuesta["data"][0];
$detallesPrendas = $respuesta["data"]; // Si hay varias prendas, estarán aquí
//var_dump($respuesta);

// Crear una nueva instancia de TCPDF
$pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);


// Configuración del PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Lavandería Jeans Rimer');
$pdf->SetTitle('Orden de Trabajo');
$pdf->SetMargins(10, 10, 10);

// Eliminar encabezado y pie de página automáticos
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Añadir página
$pdf->AddPage();

// Encabezado
$pdf->SetFont('helvetica', 'B', 9.6); // Reducido al 80% de 12
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, 'ORDEN DE TRABAJO', 0, 1, 'C');

// Información de la orden (alineada verticalmente a la izquierda)
$pdf->SetFont('helvetica', '', 7.2); // Reducido al 80% de 9
$pdf->Cell(0, 2, 'Nro: ' . $orden["numero_orden"], 0, 1);
$pdf->Cell(0, 2, 'Fecha: ' . date('d-m-Y', strtotime($orden["fecha_recepcion_orden"])), 0, 1);
$pdf->Cell(0, 2, 'Cliente: ' . $orden["nombre_cliente"] . ' ' . $orden["apellido_cliente"], 0, 1);
$pdf->Cell(0, 2, 'Estado de Pago: ' . ($orden["estado_pago_orden"] ? 'Pagado' : 'Pendiente'), 0, 1);
$pdf->Cell(0, 2, 'Tipo de Pago: ' . $orden["metodos_pago"], 0, 1);

$pdf->Ln(5); // Añade un pequeño espacio extra después de estos datos


// Construir HTML para la tabla
$html = '
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }
    th {
        background-color: #004165;
        color: white;
        text-align: center;
        padding: 6px; /* Reducido al 80% de 8px */
        border: 1px solid #004165;
        font-size: 7.2px; /* Reducido al 80% de 9px */
    }
    td {
        text-align: center;
        padding: 4.8px; /* Reducido al 80% de 6px */
        border: 1px solid #cccccc;
        font-size: 7.2px; /* Reducido al 80% de 9px */
    }
</style>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>PRENDA</th>
            <th>COLOR</th>
            <th>LAVADO</th>
            <th>CANTIDAD</th>
            <th>PLANCHADO</th>
            <th>OJAL</th>
            <th>MANUAL</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>';


// Generar filas dinámicamente desde detalles de prendas
$totalPrendas = 0;
$totalPrecio = 0;

foreach ($detallesPrendas as $index => $detalle) {
    $html .= '<tr>
        <td>' . ($index + 1) . '</td>
        <td>' . $detalle["descripcion_prenda"] . '</td>
        <td>' . $detalle["nombre_color"] . '</td>
        <td>' . $detalle["descripcion_lavado"] . '</td>
        <td>' . $detalle["cantidad"] . '</td>
        <td>' . ($detalle["planchado"] ? 'Sí' : 'No') . '</td>
        <td>' . ($detalle["ojal"] ? 'Sí' : 'No') . '</td>
        <td>' . $detalle["manualidad"] . '</td>
        <td>' . number_format($detalle["total_precio_prenda"], 2) . '</td>
    </tr>';
    $totalPrendas += $detalle["cantidad"];
    $totalPrecio += $detalle["total_precio_prenda"];
}

$html .= '</tbody></table>';

// Añadir tabla al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Totales
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 7.2); // Reducido al 80% de 9
$pdf->Cell(176, 5, 'Total Prendas:', 0, 0, 'R');
$pdf->SetFont('helvetica', '', 7.2);
$pdf->Cell(30, 5, $totalPrendas, 0, 1, 'L');

// $pdf->SetFont('helvetica', 'B', 7.2);
// $pdf->Cell(176, 5, 'Subtotal:', 0, 0, 'R');
// $pdf->SetFont('helvetica', '', 7.2);
// $pdf->Cell(30, 5, '50.00', 0, 1, 'L');

$pdf->SetFont('helvetica', 'B', 7.2);
$pdf->Cell(176, 5, 'Total:', 0, 0, 'R');
$pdf->SetFont('helvetica', '', 7.2);
$pdf->Cell(30, 5, number_format($totalPrecio, 2), 0, 1, 'L');

// Nota de entrega
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 9.6); // Reducido al 80% de 12
$pdf->Cell(0, 6, 'NOTA DE ENTREGA', 0, 1, 'C');

// Logo
$pdf->Image('images/logoJSblack.png', 10, $pdf->GetY() + 5, 31); // Ajustar tamaño del logo

// Ajustar posición inicial para los datos (al lado derecho del logo)
$pdf->SetY($pdf->GetY() + 5); // Mantener altura inicial en relación con el logo
$pdf->SetX(45); // Ajustar la posición horizontal después del logo

// Detalles de la nota de entrega
$pdf->SetFont('helvetica', '', 7.2); // Reducido al 80% de 9

// Cliente
$pdf->Cell(10, 5, 'Cliente:', 0, 0, 'L');
$pdf->Cell(36, 5, $orden["nombre_cliente"] . ' ' . $orden["apellido_cliente"], 0, 1, 'L');
$pdf->SetX(45); // Mantener alineación a la derecha del logo


// Crear un array para almacenar las descripciones de las prendas
$descripcionPrendas = [];
// Llenar el array con las descripciones de las prendas
foreach ($detallesPrendas as $detalle) {
    $descripcionPrendas[] = $detalle["descripcion_prenda"];
}
// Convertir el array a un string con separador
$nombresPrendas = implode(', ', $descripcionPrendas);
// Prendas
$pdf->Cell(12, 5, 'Prendas:', 0, 0, 'L');
$pdf->Cell(60, 5, $nombresPrendas, 0, 1, 'L');
$pdf->SetX(45); // Mantener alineación a la derecha del logo



// Cantidad
$pdf->Cell(13, 5, 'Cantidad:', 0, 0, 'L');
$pdf->Cell(60, 5, $totalPrendas, 0, 1, 'L');
$pdf->SetX(45); // Mantener alineación a la derecha del logo


// Calcular cuánto falta para completar el pago
$montoFaltante = $orden["monto_total_orden"] - $orden["total_pagado"];
// Estado de Pago
$pdf->Cell(20, 5, 'Estado de Pago:', 0, 0, 'L');
if ($orden["estado_pago_orden"] == 1) { // Si está pagado
    $pdf->Cell(60, 5, 'Pagado', 0, 1, 'L');
} else { // Si está pendiente
    $pdf->Cell(60, 5, 'Pendiente', 0, 1, 'L');
    $pdf->SetX(45); // Mantener alineación a la derecha del logo

    // Mostrar cuánto falta por pagar
    $pdf->Cell(20, 5, 'Faltante:', 0, 0, 'L');
    $pdf->Cell(60, 5, number_format($montoFaltante, 2) . ' Bs.', 0, 1, 'L');
}
$pdf->SetX(45); // Mantener alineación para las siguientes líneas



// Tipo de Pago
$pdf->Cell(20, 5, 'Tipo de Pago:', 0, 0, 'L');

// Obtener todos los métodos de pago en un array
$tiposDePago = [];
foreach ($respuesta["data"] as $pago) {
    if (!empty($pago["metodos_pago"])) {
        $tiposDePago[] = $pago["metodos_pago"];
    }
}

// Concatenar los métodos de pago separados por comas
$tiposDePagoConcatenados = implode(', ', array_unique($tiposDePago));

// Imprimir los métodos de pago en el PDF
$pdf->Cell(60, 5, $tiposDePagoConcatenados, 0, 1, 'L');
$pdf->SetX(45); // Mantener alineación para las siguientes líneas





// Pie de página
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'I', 7.2); // Reducido al 80% de 9
$pdf->Cell(0, 5, '¡Gracias por confiar en nosotros!', 0, 1, 'C');

// Salida del PDF
$pdf->Output('orden_trabajo.pdf', 'I');
?>
