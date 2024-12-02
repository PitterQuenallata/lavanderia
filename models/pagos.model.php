<?php

require_once "conexion.php";

class ModeloPagos {

    /*=============================================
OBTENER PAGOS COMPLETADOS POR ORDEN
=============================================*/
public static function mdlObtenerPagosOrden($id_orden)
{
    try {
        $stmt = Conexion::conectar()->prepare("
            SELECT monto
            FROM pagos
            WHERE id_orden = :id_orden AND estado = 'Completado'
        ");

        $stmt->bindParam(":id_orden", $id_orden, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error en mdlObtenerPagosOrden: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
    }
}
/*=============================================
OBTENER MONTO TOTAL DE UNA ORDEN
=============================================*/
public static function mdlObtenerMontoTotalOrden($id_orden)
{
    try {
        $stmt = Conexion::conectar()->prepare("
            SELECT monto_total_orden
            FROM ordenes
            WHERE id_orden = :id_orden
        ");

        $stmt->bindParam(":id_orden", $id_orden, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error en mdlObtenerMontoTotalOrden: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
    }
}


    public static function mdlObtenerOrdenPorMovimientoId($tabla, $movimiento_id)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT id_orden 
                FROM $tabla 
                WHERE movimiento_id = :movimiento_id
            ");
            $stmt->bindParam(":movimiento_id", $movimiento_id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function mdlObtenerQrBase64($tabla, $movimiento_id) {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT qr_base64 FROM $tabla WHERE movimiento_id = :movimiento_id");
            $stmt->bindParam(":movimiento_id", $movimiento_id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($resultado) {
                    return $resultado['qr_base64'];
                } else {
                    throw new Exception("No se encontró el QR para el movimiento_id: $movimiento_id");
                }
            } else {
                throw new Exception("Error al ejecutar la consulta.");
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }
    /*=============================================
    Obtener datos del pago con información de la orden
    =============================================*/
    public static function mdlObtenerPagoConOrden($tablaPagos, $tablaOrdenes, $movimiento_id) {
        try {
            // Preparar la consulta SQL con JOIN
            $stmt = Conexion::conectar()->prepare("
                SELECT 
                    p.id_pago,
                    p.id_metodo_pago,
                    p.id_orden,
                    p.monto,
                    p.estado,
                    p.qr_base64,
                    p.movimiento_id,
                    p.fecha_creacion,
                    o.numero_orden,
                    o.monto_total_orden
                FROM $tablaPagos AS p
                INNER JOIN $tablaOrdenes AS o ON p.id_orden = o.id_orden
                WHERE p.movimiento_id = :movimiento_id
            ");

            // Asignar el parámetro
            $stmt->bindParam(":movimiento_id", $movimiento_id, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado ? $resultado : null;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // En caso de error, devolver un mensaje
            return "Error: " . $e->getMessage();
        } finally {
            $stmt->closeCursor();
            $stmt = null; // Cerrar la conexión
        }
    }

    public static function mdlActualizarEstadoPago($tabla, $movimiento_id, $estado, $nombre, $banco, $documento, $cuenta) {
        try {
            $stmt = Conexion::conectar()->prepare("
                UPDATE $tabla
                SET estado = :estado,
                    remitente_nombre = :nombre,
                    remitente_banco = :banco,
                    remitente_documento = :documento,
                    remitente_cuenta = :cuenta,
                    fecha_actualizacion = NOW()
                WHERE movimiento_id = :movimiento_id
            ");
    
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":banco", $banco, PDO::PARAM_STR);
            $stmt->bindParam(":documento", $documento, PDO::PARAM_STR);
            $stmt->bindParam(":cuenta", $cuenta, PDO::PARAM_STR);
            $stmt->bindParam(":movimiento_id", $movimiento_id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
}
