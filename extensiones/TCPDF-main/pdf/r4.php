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
        $this->Cell(0, 10, 'Reporte de Alquileres con Detalles de Áreas Sociales', 0, 1, 'C');
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'ALTAMAR - Gestión de Alquileres', 0, 1, 'C');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Obtener rango de fechas desde la URL
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fechaFinal = isset($_GET['fecha_final']) ? $_GET['fecha_final'] : null;

// Crear nueva instancia de PDF
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Lista de Alquileres - ALTAMAR');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Obtener datos de alquileres con el rango de fechas aplicado
$alquileres = reportes::mdlObtenerListaAlquileresConDetalles('alquiler', 'detalle_alquiler', 'area_social', 'usuario', $fechaInicio, $fechaFinal);

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
        padding: 8px;
        text-align: center;
        border: 1px solid #004165;
    }
    td {
        padding: 6px;
        border: 1px solid #cccccc;
    }
    .area-row {
        background-color: #f9f9f9;
    }
</style>
<table>
    <thead>
        <tr>
            <th>ID Alquiler</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Costo Total</th>
            <th>Usuario que Gestionó</th>
        </tr>
    </thead>
    <tbody>';

// Variable para rastrear el ID del alquiler actual
$currentAlquilerId = null;

foreach ($alquileres as $alquiler) {
    if ($currentAlquilerId !== $alquiler['id_alquiler']) {
        // Fila principal con datos del alquiler
        $html .= '
        <tr>
            <td>' . $alquiler['id_alquiler'] . '</td>
            <td>' . $alquiler['fecha_inicio'] . '</td>
            <td>' . $alquiler['fecha_final'] . '</td>
            <td>' . $alquiler['hora_inicio'] . '</td>
            <td>' . $alquiler['hora_final'] . '</td>
            <td>' . number_format($alquiler['monto_total'], 2) . '</td>
            <td>' . $alquiler['usuario_gestion'] . '</td>
        </tr>';

        // Encabezado para detalles de áreas sociales alquiladas
        $html .= '
        <tr class="area-row">
            <td colspan="3" style="font-weight: bold; text-align: center;">Área Social</td>
            <td colspan="4" style="font-weight: bold; text-align: center;">Costo</td>
        </tr>';
        
        $currentAlquilerId = $alquiler['id_alquiler'];
    }

    // Fila de cada área social alquilada
    $html .= '
    <tr class="area-row">
        <td colspan="3" style="text-align: center;">' . $alquiler['area_social'] . '</td>
        <td colspan="4" style="text-align: center;">' . number_format($alquiler['costo_area'], 2) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Imprimir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('lista_alquileres_con_detalles.pdf', 'I');
