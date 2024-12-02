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
        $this->Cell(0, 10, 'Listado de Alquileres por Propietario', 0, 1, 'C');
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

// Obtener el ID del propietario desde la URL
$idPropietario = $_GET['id_propietario'];

// Crear nueva instancia de PDF
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ALTAMAR');
$pdf->SetTitle('Listado de Alquileres por Propietario - ALTAMAR');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Obtener datos de alquileres y detalles del propietario
$alquileres = reportes::mdlObtenerAlquileresPorPropietario('alquiler', 'detalle_alquiler', 'area_social', 'usuario', 'propietario', $idPropietario);

// Mostrar datos del propietario en la parte superior
if (!empty($alquileres)) {
    $propietario = $alquileres[0]; // Obtener información del propietario una sola vez
    $html = '
    <h3>Datos del Propietario</h3>
    <p><strong>Nombre Completo:</strong> ' . $propietario['nombre_propietario'] . '</p>
    <p><strong>Nro Carnet:</strong> ' . $propietario['nroCarnet'] . '</p>
    <p><strong>Nro Departamento:</strong> ' . $propietario['nroDpto'] . '</p>
    <p><strong>Teléfono:</strong> ' . $propietario['telefono'] . '</p>
    <br><br>';
} else {
    $html = '<p>No se encontraron alquileres para este propietario.</p>';
}

$html .= '
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

// Variable para rastrear el ID del alquiler actual y evitar duplicados
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

        // Encabezado para áreas sociales alquiladas
        $html .= '
        <tr class="area-row">
            <td colspan="3" style="font-weight: bold; text-align: center;">Área Social</td>
            <td colspan="4" style="font-weight: bold; text-align: center;">Costo</td>
        </tr>';
        
        $currentAlquilerId = $alquiler['id_alquiler'];
    }

    // Filas de áreas sociales alquiladas
    $html .= '
    <tr class="area-row">
        <td colspan="3" style="text-align: center;">' . $alquiler['area_social'] . '</td>
        <td colspan="4" style="text-align: center;">' . number_format($alquiler['costo_area'], 2) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Imprimir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('alquileres_por_propietario.pdf', 'I');
