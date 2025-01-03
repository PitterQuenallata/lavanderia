<?php
require_once('../tcpdf.php');
require_once('../../../modelos/conexion.php');
require_once('../../../modelos/reportes.modelo.php');

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'ALTAMAR', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Reporte de las 10 Áreas Sociales Más Alquiladas', 0, 1, 'C');
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'ALTAMAR - Gestión de Áreas Sociales', 0, 1, 'C');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Crear nueva instancia de PDF en tamaño carta
$pdf = new MYPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Áreas Sociales Más Alquiladas - ALTAMAR');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Obtener datos de las áreas sociales más alquiladas
$areasSociales = reportes::mdlObtenerAreasSocialesMasAlquiladas('detalle_alquiler', 'area_social');

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
</style>
<table>
    <thead>
        <tr>
            <th>Área Social</th>
            <th>Precio</th>
            <th>Veces Alquilada</th>
        </tr>
    </thead>
    <tbody>';

// Agregar filas de la tabla con los datos de las áreas sociales
foreach ($areasSociales as $area) {
    $html .= '
    <tr>
        <td>' . $area['area_social'] . '</td>
        <td>' . number_format($area['precio'], 2) . '</td>
        <td>' . $area['veces_alquilada'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Imprimir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('areas_sociales_mas_alquiladas.pdf', 'I');
