<?php
require_once('../tcpdf.php');
require_once('../../../controladores/propietarios.controlador.php');
require_once('../../../modelos/conexion.php');
require_once('../../../modelos/reportes.modelo.php');

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'ALTAMAR', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Resumen de Pagos de Mensualidades por Propietario', 0, 1, 'C');
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'ALTAMAR - Gestión de Propietarios', 0, 1, 'C');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Obtener el ID del propietario y fecha de registro desde la URL
$idPropietario = $_GET['id_propietario'];
$fechaRegistro = $_GET['fecha_registro'];

$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Resumen de Pagos de Mensualidades - ALTAMAR');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Obtener datos del propietario y pagos
$resumenPagos = reportes::mdlResumenPagosPorPropietario('mensualidad', 'pago_mensualidad', 'propietario', $idPropietario, $fechaRegistro);

$html = '
<style>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }
    th {
        background-color: #004165;
        color: white;
        font-weight: bold;
        padding: 10px 4px;
        text-align: center;
        border: 1px solid #004165;
        font-size: 11px;
        line-height: 1.2;
        vertical-align: middle;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    td {
        padding: 12px 6px;
        border: 1px solid #cccccc;
        line-height: 1.5;
        vertical-align: middle;
        min-height: 30px;
        font-size: 10px;
    }
    tr {
        min-height: 40px;
        page-break-inside: avoid;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .active {
        color: #008000;
        font-weight: bold;
        display: block;
        text-align: center;
        margin: 3px 0;
    }
    .inactive {
        color: #FF0000;
        font-weight: bold;
        display: block;
        text-align: center;
        margin: 3px 0;
    }
    .header-row th {
        position: relative;
        text-align: center !important;
        vertical-align: middle !important;
    }
    .td-center {
        text-align: center !important;
        vertical-align: middle !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
    .td-left {
        text-align: left !important;
        vertical-align: middle !important;
        padding-left: 8px !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
    tbody td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 5px 0;
    }
</style>
</style>
<table>
    <thead>
        <tr class="header-row">
            <th width="10%" style="text-align: center;">ID Propietario</th>
            <th width="25%" style="text-align: left;">Nombre Completo</th>
            <th width="12%" style="text-align: center;">Nro Carnet</th>
            <th width="12%" style="text-align: center;">Periodo (Mes/Año)</th>
            <th width="15%" style="text-align: center;">Monto Pagado</th>
            <th width="26%" style="text-align: left;">Estado</th>
        </tr>
    </thead>
    <tbody>';

// Generar filas de la tabla
foreach ($resumenPagos as $pago) {
    $estado = ($pago["estado"] === "Pendiente") ? '<span style="color: red;">Deuda Pendiente</span>' : '<span style="color: green;">Pagado</span>';
    $html .= '
        <tr>
            <td class="td-center" width="10%">' . $pago["id_propietario"] . '</td>
            <td class="td-left" width="25%">' . mb_strtoupper($pago["nombre_completo"], 'UTF-8') . '</td>
            <td class="td-center" width="12%">' . $pago["nroCarnet"] . '</td>
            <td class="td-center" width="12%">' . $pago["mes"] . '/' . $pago["gestion"] . '</td>
            <td class="td-center" width="15%">' . number_format($pago["monto_pagado"], 2) . '</td>
            <td class="td-left" width="26%">' . $estado . '</td>
        </tr>';
}
$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('resumen_pagos_propietario.pdf', 'I');
?>
