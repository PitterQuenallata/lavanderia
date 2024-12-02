<?php
// Incluye el archivo TCPDF y la conexión a la base de datos
require_once('../tcpdf.php');
require_once('../../../controladores/reservasAreaSocial.controlador.php');
require_once('../../../modelos/conexion.php');
require_once('../../../modelos/reservasAreaSocial.modelo.php');

// Obtener el idReserva del parámetro GET
if (isset($_GET['idReserva'])) {
    $idReserva = $_GET['idReserva'];

    // Consultar los detalles de la reserva utilizando el idReserva
    $reservaDetalles = ControladorReservasAreaSocial::ctrMostrarReservaPorId($idReserva);

    // Si no se encuentran los detalles, mostrar error
    if (empty($reservaDetalles)) {
        die("Error: No se encontró información para la reserva con ID: $idReserva");
    }

    // Crear instancia de TCPDF
    class MYPDF extends TCPDF {
        public function Header() {}
        public function Footer() {}
    }

    // Crear instancia con tamaño pequeño
    $pdf = new MYPDF('P', 'mm', array(80, 200), true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Mi Sistema');
    $pdf->SetTitle('Comprobante de Reserva');

    // Reducir márgenes
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetAutoPageBreak(TRUE, 5);

    // Añadir página y fuente
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    // Obtener los detalles de la reserva
    $nombreCompleto = $reservaDetalles["nombre_completo"];
    $carnet = $reservaDetalles["carnet_propietario"];
    $fechaInicio = $reservaDetalles["fecha_inicio"];
    $horaInicio = $reservaDetalles["hora_inicio"];
    $fechaFinal = $reservaDetalles["fecha_final"];
    $horaFinal = $reservaDetalles["hora_final"];
    $montoTotal = $reservaDetalles["monto_total"];

    // Obtener las áreas reservadas
    $areasReservadas = ControladorReservasAreaSocial::ctrMostrarDetalleReservaPorId($idReserva);

    // Generar el contenido del comprobante
    $html = '
    <style>
        h1 {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1px;
            border-bottom: 1px solid #000;
        }
        .info-row {
            margin: 3px 0;
            font-size: 9pt;
            line-height: 1.2;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            margin-top: 5px;
            color: #000;
        }
        .dashed-line {
            border-top: 1px dashed #000;
            margin: 0; 
            padding: 0;

        }
        .h3 {
            font-size: 10pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
    </style>

    <h1>Comprobante de Reserva</h1>
    <br>
    <div class="info-row">
    <strong>Propietario:</strong> ' . mb_strtoupper($nombreCompleto, 'UTF-8') . '
    </div>
    <div class="info-row">
    <strong>Carnet:</strong> ' . $carnet . '
    </div>
    <div class="info-row">
    <strong>Fecha de Inicio:</strong> ' . $fechaInicio . ' ' . $horaInicio . '
    </div>
    <div class="info-row">
    <strong>Fecha de Fin:</strong> ' . $fechaFinal . ' ' . $horaFinal . '
    </div>
    <div class="dashed-line"></div>
    <h3>Áreas Reservadas</h3>';

    // Agregar las áreas reservadas al contenido del comprobante
    foreach ($areasReservadas as $area) {
        $html .= '
        <div class="info-row">
        <strong>Área:</strong> ' . mb_strtoupper($area['descripcion'], 'UTF-8') . '
        </div>
        <div class="info-row">
        <strong>Precio:</strong> BOB ' . number_format($area['costo'], 2) . '
        </div>';
    }

    // Agregar el total de la reserva
    $html .= '
    <div class="info-row">
    <strong>Total:</strong> BOB ' . number_format($montoTotal, 2) . '
    </div>

    <div class="dashed-line"></div>

    <div class="footer">
    ¡Gracias por su reserva!<br>
    Este comprobante es válido como recibo de reserva
    </div>
    ';

    // Escribir el HTML en el PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Mostrar el PDF en el navegador
    $pdf->Output('comprobante_reserva.pdf', 'I');
} else {
    die("Error: No se ha proporcionado un ID de reserva.");
}
