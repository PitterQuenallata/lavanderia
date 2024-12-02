<?php
require_once('../tcpdf.php');
require_once('../../../modelos/conexion.php');
require_once('../../../modelos/reportes.modelo.php');

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'ALTAMAR', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Ganancias Generales hasta la Fecha', 0, 1, 'C');
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Fecha de Reporte: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'ALTAMAR - Gestión Financiera', 0, 1, 'C');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Crear nueva instancia de PDF en tamaño carta
$pdf = new MYPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Ganancias Generales hasta la Fecha - ALTAMAR');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Obtener el detalle de ingresos hasta la fecha actual
$ingresosDetalle = reportes::mdlObtenerGananciasGeneralesHastaHoy('alquiler', 'pago_mensualidad');
$totalGanancias = 0;

// Construir el HTML para la tabla
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
        padding: 8px;
        text-align: center;
        border: 1px solid #004165;
    }
    td {
        padding: 6px;
        border: 1px solid #cccccc;
        text-align: center;
    }
    .total-row td {
        font-weight: bold;
        background-color: #f5f5f5;
    }
</style>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo de Ingreso</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>';

// Agregar filas de la tabla con los datos de cada ingreso y calcular el total
foreach ($ingresosDetalle as $ingreso) {
    $html .= '
    <tr>
        <td>' . $ingreso['fecha'] . '</td>
        <td>' . $ingreso['tipo'] . '</td>
        <td>' . number_format($ingreso['monto'], 2) . '</td>
    </tr>';
    $totalGanancias += $ingreso['monto'];
}

// Fila de total en la parte inferior derecha
$html .= '
    <tr class="total-row">
        <td colspan="2" style="text-align: right;">Total de Ganancias Generales:</td>
        <td>' . number_format($totalGanancias, 2) . ' Bs</td>
    </tr>';

$html .= '</tbody></table>';

// Imprimir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('ganancias_generales_hasta_fecha.pdf', 'I');
