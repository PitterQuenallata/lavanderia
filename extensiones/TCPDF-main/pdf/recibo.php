<?php
ob_start();

require_once "../../../controladores/pago_mensualidades.controlador.php";
require_once "../../../modelos/pago_mensualidades.modelo.php";

class ImprimirRecibo {

  public $id_pago;

  public function traerImpresionRecibo() {

    // TRAEMOS LA INFORMACIÓN DEL PAGO
    $itemPago = "id";
    $valorPago = $this->id_pago;

    $respuestaPago = "hola";

    if (!$respuestaPago) {
      die('No se encontró el pago solicitado.');
    }

    $fecha = substr($respuestaPago["fecha"], 0, 10);
    $monto = number_format($respuestaPago["monto"], 2);
    $codigoPago = $respuestaPago["id"];
    $estado = $respuestaPago["estado"] == 1 ? "Pagado" : "No Pagado";

    // Información del Propietario
    $nombrePropietario = $respuestaPago['nombre_propietario'];
    $apellidoPropietario = $respuestaPago['apellido_propietario'];
    $nroCarnet = $respuestaPago['nroCarnet'];
    $telefono = $respuestaPago['telefono'];

    // Información del Usuario que Registró el Pago
    $nombreUsuario = $respuestaPago['nombre_usuario'];

    // REQUERIMOS LA CLASE TCPDF
    require_once('tcpdf_include.php');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->startPageGroup();
    $pdf->AddPage();

    // ---------------------------------------------------------
    $bloque1 = <<<EOF
    <table>
      <tr>
        <td style="width:150px"><img src="images/logo_example.png"></td>
        <td style="background-color:white; width:140px">
          <div style="font-size:8.5px; text-align:right; line-height:15px;">
            <br>NIT: 71.759.963-9
            <br>Dirección: Calle 44B 92-11
          </div>
        </td>
        <td style="background-color:white; width:140px">
          <div style="font-size:8.5px; text-align:right; line-height:15px;">
            <br>Teléfono: 65139423
            <br>email@example.com
          </div>
        </td>
        <td style="background-color:white; width:110px; text-align:center; color:red"><br><br>RECIBO N.<br>$codigoPago</td>
      </tr>
    </table>
    EOF;

    $pdf->writeHTML($bloque1, false, false, false, false, '');

    // ---------------------------------------------------------
    $bloque2 = <<<EOF

    <table style="font-size:10px; padding:5px 10px;">
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:390px">
          Propietario: {$nombrePropietario} {$apellidoPropietario}
        </td>
        <td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
          Fecha: $fecha
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:540px">Carnet: {$nroCarnet}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:540px">Teléfono: {$telefono}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:540px">Estado: {$estado}</td>
      </tr>
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:540px">Registrado por: {$nombreUsuario}</td>
      </tr>
    </table>
    EOF;

    $pdf->writeHTML($bloque2, false, false, false, false, '');

    // ---------------------------------------------------------
    $bloque3 = <<<EOF
    <table style="font-size:10px; padding:5px 10px;">
      <tr>
        <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Monto</td>
      </tr>
      <tr>
        <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
          $ $monto
        </td>
      </tr>
    </table>
    EOF;

    $pdf->writeHTML($bloque3, false, false, false, false, '');

    // ---------------------------------------------------------
    $bloque4 = <<<EOF
    <table style="font-size:10px; padding:5px 10px;">
      <tr>
        <td style="color:#333; background-color:white; width:340px; text-align:center"></td>
        <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
        <td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
      </tr>
      <tr>
        <td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
        <td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
          Total:
        </td>
        <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
          $ $monto
        </td>
      </tr>
    </table>
    EOF;

    $pdf->writeHTML($bloque4, false, false, false, false, '');

    // SALIDA DEL ARCHIVO
    ob_end_clean();
    $pdf->Output('recibo.pdf', 'I');
  }
}

$recibo = new ImprimirRecibo();
$recibo->id_pago = $_GET["codigo"];
$recibo->traerImpresionRecibo();

?>
