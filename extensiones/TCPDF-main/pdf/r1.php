<?php
require_once('../tcpdf.php');
require_once('../../../controladores/propietarios.controlador.php');
require_once('../../../modelos/conexion.php');
require_once('../../../modelos/propietarios.modelo.php');

class MYPDF extends TCPDF {
    public function Header() {
        // Logo - You can add your company logo here
        // $this->Image('path_to_logo.png', 10, 10, 30);
        
        // Company Name
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'ALTAMAR', 0, 1, 'C');
        
        // Report Title
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Propietarios - Datos de Contacto', 0, 1, 'C');
        
        // Date
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 5, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        
        $this->Ln(5);
    }

    public function Footer() {
        // Footer with page number and company info
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'ALTAMAR - Gestión de Propietarios', 0, 1, 'C');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create new PDF document
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Reporte de Propietarios - ALTAMAR');

// Set margins
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);

// Add page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Get data
$propietarios = ControladorPropietarios::ctrMostrarPropietarios(null, null);

// Create table with styling
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

<table>
    <thead>
        <tr class="header-row">
            <th width="8%" style="text-align: center;">ID</th>
            <th width="25%" style="text-align: left;">Nombre Completo</th>
            <th width="12%" style="text-align: center;">Nro Carnet</th>
            <th width="12%" style="text-align: center;">Teléfono</th>
            <th width="10%" style="text-align: center;">Estado</th>
            <th width="23%" style="text-align: center;">Correo</th>
            <th width="10%" style="text-align: center;">Nro Dpto</th>
        </tr>
    </thead>
    <tbody>';

foreach ($propietarios as $propietario) {
    $estado = ($propietario["estado"] == 1) ? '<span class="active">Activo</span>' : '<span class="inactive">Inactivo</span>';
    $html .= '
        <tr>
            <td class="td-center" width="8%">' . $propietario["id"] . '</td>
            <td class="td-left" width="25%">' . mb_strtoupper($propietario["nombre"] . ' ' . $propietario["apellido_paterno"] . ' ' . $propietario["apellido_materno"], 'UTF-8') . '</td>
            <td class="td-center" width="12%">' . $propietario["nroCarnet"] . '</td>
            <td class="td-center" width="12%">' . $propietario["telefono"] . '</td>
            <td class="td-center" width="10%">' . $estado . '</td>
            <td class="td-left" width="23%">' . $propietario["correo"] . '</td>
            <td class="td-center" width="10%">' . $propietario["nroDpto"] . '</td>
        </tr>';
}
$html .= '</tbody></table>';

// Write HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('reporte_propietarios_altamar.pdf', 'I');
?>