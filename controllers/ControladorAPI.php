<?php
class ControladorAPI
{
    private static $apiUrlGenerarQR = "https://veripagos.com/api/bcp/generar-qr";
    private static $apiUrlVerificarQR = "https://veripagos.com/api/bcp/verificar-estado-qr";
    private static $usuario = "AutomotivosCris"; // Usuario de autenticación básica
    private static $password = "xAU+8G%z+e"; // Contraseña de autenticación básica

    /*=============================================
    GENERAR QR
    =============================================*/
    public static function ctrGenerarQR($monto, $vigencia = "0/00:15", $usoUnico = true)
    {
        // Preparar los datos para la solicitud
        $postData = [
            "secret_key" => "9cbacd0a-85a7-4bba-a9a1-2efa77712fbc", // Reemplaza con tu clave secreta
            "monto" => $monto,
            "vigencia" => $vigencia,
            "uso_unico" => $usoUnico,
            "detalle" => "Pago" // Detalle por defecto
        ];

        // Realizar la solicitud a la API
        $response = self::makePostRequest(self::$apiUrlGenerarQR, $postData);

        if ($response && $response["Codigo"] === 0) {
            return [
                "success" => true,
                "qr" => "data:image/png;base64," . $response["Data"]["qr"], // QR en formato base64
                "movimiento_id" => $response["Data"]["movimiento_id"]
            ];
        } else {
            return [
                "success" => false,
                "message" => $response["Mensaje"] ?? "Error desconocido al generar el QR."
            ];
        }
    }

    /*=============================================
    VERIFICAR ESTADO QR
    =============================================*/
    public static function ctrVerificarEstadoQR($movimientoId)
    {
        // Preparar los datos para la solicitud
        $postData = [
            "secret_key" => "9cbacd0a-85a7-4bba-a9a1-2efa77712fbc", // Reemplaza con tu clave secreta
            "movimiento_id" => $movimientoId
        ];

        // Realizar la solicitud a la API
        $response = self::makePostRequest(self::$apiUrlVerificarQR, $postData);

        if ($response && $response["Codigo"] === 0) {
            return [
                "success" => true,
                "data" => $response["Data"], // Datos del estado del QR
            ];
        } else {
            return [
                "success" => false,
                "message" => $response["Mensaje"] ?? "Error desconocido al verificar el estado del QR."
            ];
        }
    }

    /*=============================================
    FUNCIÓN GENÉRICA PARA HACER PETICIONES POST
    =============================================*/
    private static function makePostRequest($url, $postData)
    {
        try {
            // Configurar la solicitud cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_USERPWD, self::$usuario . ":" . self::$password); // Autenticación básica

            // Ejecutar la solicitud
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                return json_decode($response, true); // Decodificar la respuesta JSON
            } else {
                return [
                    "Codigo" => 1,
                    "Mensaje" => "Error en la solicitud HTTP. Código: $httpCode"
                ];
            }
        } catch (Exception $e) {
            return [
                "Codigo" => 1,
                "Mensaje" => "Excepción al realizar la solicitud: " . $e->getMessage()
            ];
        }
    }
}
