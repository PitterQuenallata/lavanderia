<?php

require_once '../tcpdf.php';
require_once '../../../controllers/pagos.controller.php';
require_once '../../../models/pagos.model.php';

// Obtener el movimiento_id desde el parámetro GET
$movimiento_id = isset($_GET['movimientoId']) ? $_GET['movimientoId'] : null;

if (!$movimiento_id) {
    die("Error: No se proporcionó el movimiento_id.");
}

// Obtener los datos del pago y la orden asociada
$datosPago = ControladorPagos::ctrObtenerPagoConOrden($movimiento_id);

if (!$datosPago) {
    die("Error: No se encontraron datos para el movimiento_id: " . $movimiento_id);
}

// Decodificar el QR Base64
list($type, $data) = explode(';', $datosPago['qr_base64']); // Divide la cadena en tipo y datos
list(, $data) = explode(',', $data); // Separa los datos de la cabecera
$imageData = base64_decode($data); // Decodificar el contenido en base64

if (!$imageData) {
    die("Error: No se pudo decodificar el QR.");
}

// Crear un archivo temporal para la imagen QR
$tempFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
file_put_contents($tempFile, $imageData);

// Crear el PDF con TCPDF
$pdf = new TCPDF('P', 'mm', [80, 130], true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Encabezado
$pdf->Cell(0, 5, 'Lavandería Jeans Rimer', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->Ln(3);

// Detalles del Ticket
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Ticket de Pago', 0, 1, 'C');
$pdf->Ln(3);

// Información del Pago
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(40, 5, 'Número de Orden:', 0, 0);
$pdf->Cell(40, 5, $datosPago['numero_orden'], 0, 1);
// $pdf->Cell(40, 5, 'Monto Total:', 0, 0);
// $pdf->Cell(40, 5, 'Bs. ' . number_format($datosPago['monto_total_orden'], 2), 0, 1);
$pdf->Cell(40, 5, 'Monto', 0, 0);
$pdf->Cell(40, 5, 'Bs. ' . number_format($datosPago['monto'], 2), 0, 1);
// $pdf->Cell(40, 5, 'Estado del Pago:', 0, 0);
// $pdf->Cell(40, 5, $datosPago['estado'], 0, 1);
$pdf->Cell(40, 5, 'Fecha de Pago:', 0, 0);
$pdf->Cell(40, 5, date('d-m-Y H:i:s', strtotime($datosPago['fecha_creacion'])), 0, 1);
$pdf->Ln(3);

// Mostrar el QR Code en el PDF
$pdf->Image($tempFile, 15, $pdf->GetY(), 50, 50, 'PNG');
$pdf->Ln(55);

// Pie de página
$pdf->SetFont('helvetica', 'I', 7);
$pdf->Cell(0, 5, 'Gracias por su preferencia', 0, 1, 'C');
$pdf->Cell(0, 5, 'No se acepta devoluciones', 0, 1, 'C');

// Eliminar el archivo temporal
unlink($tempFile);

// Salida del PDF
$pdf->Output('ticket_pago.pdf', 'I');
