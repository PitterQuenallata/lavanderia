<?php

require_once "conexion.php";

class ModeloOrdenes
{

        /*=============================================
    OBTENER ORDEN POR ID
    =============================================*/
    public static function mdlObtenerOrdenPorId($idOrden)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
                SELECT * FROM ordenes WHERE id_orden = :idOrden
            ");
            $stmt->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error en mdlObtenerOrdenPorId: " . $e->getMessage());
            return false;
        } finally {
            $stmt = null;
        }
    }
/*=============================================
Buscar o Crear Cliente
=============================================*/
public static function mdlCrearClienteyRegresarId($tabla, $datos)
{
    try {
        $link = Conexion::conectar();

        // Verificar si el cliente ya existe basado en el dni_cliente
        $stmt = $link->prepare("
            SELECT id_cliente 
            FROM $tabla 
            WHERE dni_cliente = :dni_cliente
        ");
        $stmt->bindParam(":dni_cliente", $datos["dni_cliente"], PDO::PARAM_STR);
        $stmt->execute();
        $clienteExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($clienteExistente) {
            // Si el cliente ya existe, devolver su ID
            return intval($clienteExistente["id_cliente"]);
        } else {
            // Si el cliente no existe, insertar un nuevo cliente
            $stmt = $link->prepare("
                INSERT INTO $tabla (nombre_cliente, apellido_cliente, telefono_cliente, direccion_cliente, email_cliente, dni_cliente) 
                VALUES (:nombre_cliente, :apellido_cliente, :telefono_cliente, :direccion_cliente, :email_cliente, :dni_cliente)
            ");
            $stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
            $stmt->bindParam(":apellido_cliente", $datos["apellido_cliente"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono_cliente", $datos["telefono_cliente"], PDO::PARAM_STR);
            $stmt->bindParam(":direccion_cliente", $datos["direccion_cliente"], PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $datos["email_cliente"], PDO::PARAM_STR);
            $stmt->bindParam(":dni_cliente", $datos["dni_cliente"], PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Devolver el ID del cliente recién creado
                return $link->lastInsertId();
            } else {
                return false;
            }
        }
    } catch (Exception $e) {
        error_log("Error en mdlCrearClienteyRegresarId: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
        $link = null;
    }
}


/*=============================================
MOSTRAR ÓRDENES (PRIORIZAR ÚLTIMO PAGO)
=============================================*/
public static function mdlMostrarOrdenes($tabla, $item, $valor)
{
    try {
        $link = Conexion::conectar(); // Establecer conexión

        // Consulta principal ajustada
        $query = "
        SELECT 
            o.id_orden, 
            o.numero_orden, 
            DATE(o.fecha_recepcion_orden) AS fecha_recepcion_orden, -- Extraer solo la fecha
            DATE(o.fecha_entrega_orden) AS fecha_entrega_orden, -- Extraer solo la fecha
            o.monto_total_orden, 
            o.estado_orden,
            o.estado_pago_orden, -- Estado de la orden
            c.nombre_cliente AS nombre_cliente, 
            c.apellido_cliente AS apellido_cliente, 
            c.dni_cliente AS dni_cliente,
            p.monto AS monto_pagado, -- Último monto pagado
            p.estado AS estado_pago, -- Estado de la transacción
            p.movimiento_id AS movimiento_id, -- Movimiento ID del pago
            p.id_metodo_pago AS id_metodo_pago, -- Método de pago utilizado
            m.nombre AS metodo_pago -- Nombre del método de pago
        FROM ordenes o
        INNER JOIN clientes c ON o.id_cliente = c.id_cliente
        LEFT JOIN pagos p ON p.id_pago = (
            SELECT id_pago 
            FROM pagos 
            WHERE id_orden = o.id_orden 
            ORDER BY id_pago DESC -- Siempre tomar el último pago asociado
            LIMIT 1
        )
        LEFT JOIN metodo_pago m ON p.id_metodo_pago = m.id_metodo_pago
        ";

        // Si hay una condición específica
        if ($item !== null) {
            $query .= " WHERE o.$item = :$item"; // Filtrar por la columna especificada
            $stmt = $link->prepare($query);
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        } else {
            $stmt = $link->prepare($query); // Consulta sin filtros
        }

        $query .= " ORDER BY o.id_orden"; // Ordenar por id_orden
        $stmt = $link->prepare($query);

        $stmt->execute(); // Ejecutar consulta

        // Retornar todos los registros
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error en mdlMostrarOrdenes: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
        $link = null; // Cerrar conexión
    }
}










    /*=============================================
 Guardar el pago y devolver el ID del pago registrado
=============================================*/


    public static function mdlGuardarPagoEfectivo($datosPago)
    {
        try {
            $stmt = Conexion::conectar()->prepare("
            INSERT INTO pagos (id_metodo_pago, id_orden, monto, estado, detalle)
            VALUES (:id_metodo_pago, :id_orden, :monto, :estado, :detalle)
        ");

            // Vincular parámetros
            $stmt->bindParam(":id_metodo_pago", $datosPago["id_metodo_pago"], PDO::PARAM_INT);
            $stmt->bindParam(":id_orden", $datosPago["id_orden"], PDO::PARAM_INT);
            $stmt->bindParam(":monto", $datosPago["monto"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datosPago["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":detalle", $datosPago["detalle"], PDO::PARAM_STR);

            // Ejecutar y verificar
            if ($stmt->execute()) {
                return true; // Devolver true si se inserta correctamente
            } else {
                return false; // Error en la ejecución
            }
        } catch (Exception $e) {
            error_log("Error en mdlGuardarPagoEfectivo: " . $e->getMessage());
            return false; // Error en el bloque try-catch
        } finally {
            $stmt = null; // Liberar la memoria
        }
    }

        /*=============================================
 Guardar el pago y devolver el IDmovimiento
=============================================*/
    public static function mdlGuardarPagoQR($datosPago)
    {
        try {
            $tabla = "pagos";

            // Preparar la consulta SQL
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO $tabla (id_metodo_pago, id_orden, monto, detalle, estado, qr_base64, movimiento_id, fecha_creacion)
                VALUES (:id_metodo_pago, :id_orden, :monto, :detalle, :estado, :qr_base64, :movimiento_id, NOW())"
            );

            // Asignar los valores
            $stmt->bindParam(":id_metodo_pago", $datosPago["id_metodo_pago"], PDO::PARAM_INT);
            $stmt->bindParam(":id_orden", $datosPago["id_orden"], PDO::PARAM_INT);
            $stmt->bindParam(":monto", $datosPago["monto"], PDO::PARAM_STR);
            $stmt->bindParam(":detalle", $datosPago["detalle"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datosPago["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":qr_base64", $datosPago["qr_base64"], PDO::PARAM_STR);
            $stmt->bindParam(":movimiento_id", $datosPago["movimiento_id"], PDO::PARAM_STR);

            // Ejecutar y retornar el resultado
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }

        $stmt = null; // Cerrar conexión
    }
    
    /*=============================================
Guardar la orden y devolver el ID de la orden registrada
=============================================*/

    public static function mdlGuardarOrden($datosOrden)
    {
        try {
            $link = Conexion::conectar(); // Conexión persistente
            $stmt = $link->prepare("
              INSERT INTO ordenes 
              (id_cliente, id_usuario, numero_orden, fecha_recepcion_orden, fecha_entrega_orden, monto_total_orden, estado_pago_orden)
              VALUES 
              (:id_cliente, :id_usuario, :numero_orden, :fecha_recepcion, :fecha_entrega, :monto, :estado)
          ");

            $stmt->bindParam(":id_cliente", $datosOrden["id_cliente"], PDO::PARAM_INT);
            $stmt->bindParam(":id_usuario", $datosOrden["id_usuario"], PDO::PARAM_INT);
            $stmt->bindParam(":numero_orden", $datosOrden["numero_orden"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_recepcion", $datosOrden["fecha_recepcion"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_entrega", $datosOrden["fecha_entrega"], PDO::PARAM_STR);
            $stmt->bindParam(":monto", $datosOrden["monto_total_orden"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datosOrden["estado_pago_orden"], PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Retornar el ID de la orden registrada
                return $link->lastInsertId();
            } else {
                return false; // Error en la ejecución
            }
        } catch (Exception $e) {
            // Registrar el error para depuración (opcional)
            error_log("Error en mdlGuardarOrden: " . $e->getMessage());
            return false; // Error en el bloque try-catch
        }

        $stmt = null;
    }

    /*=============================================
Guardar los detalles de las prendas
=============================================*/

    public static function mdlGuardarDetallesPrendas($datosDetalle)
    {
        try {
            $link = Conexion::conectar(); // Conexión persistente
            $stmt = $link->prepare("
            INSERT INTO ordenes_prendas 
            (id_orden, id_prenda, id_color, id_lavado, cantidad, planchado, ojal, manualidad, total_precio_prenda) 
            VALUES 
            (:id_orden, :id_prenda, :id_color, :id_lavado, :cantidad, :planchado, :ojal, :manualidad, :precio_total)
        ");

            // Asignar parámetros
            $stmt->bindParam(":id_orden", $datosDetalle["id_orden"], PDO::PARAM_INT);
            $stmt->bindParam(":id_prenda", $datosDetalle["id_prenda"], PDO::PARAM_INT);
            $stmt->bindParam(":id_color", $datosDetalle["id_color"], PDO::PARAM_INT);
            $stmt->bindParam(":id_lavado", $datosDetalle["id_lavado"], PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $datosDetalle["cantidad"], PDO::PARAM_INT);
            $stmt->bindParam(":planchado", $datosDetalle["planchado"], PDO::PARAM_STR);
            $stmt->bindParam(":ojal", $datosDetalle["ojal"], PDO::PARAM_STR);
            $stmt->bindParam(":manualidad", $datosDetalle["manualidad"], PDO::PARAM_STR);
            $stmt->bindParam(":precio_total", $datosDetalle["precio_total"], PDO::PARAM_STR); // Nuevo campo agregado

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true; // Inserción exitosa
            } else {
                return false; // Error en la ejecución
            }
        } catch (Exception $e) {
            // Registrar el error para depuración (opcional)
            error_log("Error en mdlGuardarDetallesPrendas: " . $e->getMessage());
            return false; // Error general
        } finally {
            $stmt = null;
            $link = null; // Cerrar conexión
        }
    }

// /*=============================================
// MOSTRAR DETALLES ÓRDENES (SOLO PAGOS COMPLETADOS) anterior que estaba bien 
// =============================================*/
// public static function mdlMostrarDetallesOrden($idOrden)
// {
//     try {
//         // Conexión a la base de datos
//         $link = Conexion::conectar();

//         // Preparar la consulta SQL
//         $stmt = $link->prepare("
//             SELECT 
//                 o.id_orden, 
//                 o.numero_orden, 
//                 DATE(o.fecha_recepcion_orden) AS fecha_recepcion_orden, -- Extraer solo la fecha
//                 DATE(o.fecha_entrega_orden) AS fecha_entrega_orden, -- Extraer solo la fecha
//                 o.estado_orden, 
//                 o.monto_total_orden, 
//                 o.estado_pago_orden,
//                 c.nombre_cliente, 
//                 c.apellido_cliente, 
//                 c.dni_cliente,
//                 SUM(CASE WHEN p.estado = 'Completado' THEN p.monto ELSE 0 END) AS total_pagado, -- Sumar solo los pagos completados
//                 GROUP_CONCAT(CASE WHEN p.estado = 'Completado' THEN p.estado ELSE NULL END SEPARATOR ', ') AS estado_pago, -- Concatenar solo los estados de los pagos completados
//                 GROUP_CONCAT(CASE WHEN p.estado = 'Completado' THEN m.nombre ELSE NULL END SEPARATOR ', ') AS metodos_pago, -- Concatenar los métodos de pago utilizados (solo completados)
//                 op.id_prenda, 
//                 pr.descripcion_prenda, 
//                 op.id_color, 
//                 col.nombre_color, 
//                 op.id_lavado, 
//                 lav.descripcion_lavado, 
//                 op.cantidad, 
//                 op.planchado, 
//                 op.ojal, 
//                 op.manualidad, 
//                 op.total_precio_prenda -- Detalle de prendas
//             FROM ordenes o
//             INNER JOIN clientes c ON o.id_cliente = c.id_cliente
//             LEFT JOIN pagos p ON o.id_orden = p.id_orden -- Relación con la tabla de pagos
//             LEFT JOIN metodo_pago m ON p.id_metodo_pago = m.id_metodo_pago
//             INNER JOIN ordenes_prendas op ON o.id_orden = op.id_orden
//             LEFT JOIN prendas pr ON op.id_prenda = pr.id_prenda
//             LEFT JOIN colores col ON op.id_color = col.id_color
//             LEFT JOIN lavados lav ON op.id_lavado = lav.id_lavado
//             WHERE o.id_orden = :idOrden
//             GROUP BY op.id_prenda, op.id_color, op.id_lavado -- Agrupar por detalles de prendas
//         ");

//         // Vincular el parámetro de la consulta
//         $stmt->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);

//         // Ejecutar la consulta
//         $stmt->execute();

//         // Devolver los resultados en formato asociativo
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (Exception $e) {
//         // En caso de error, devolver false y loguear el error
//         error_log("Error en mdlMostrarDetallesOrden: " . $e->getMessage());
//         return false;
//     } finally {
//         $stmt = null;
//         $link = null; // Cerrar conexión
//     }
// }

/*=============================================
MOSTRAR DETALLES ÓRDENES (CONTROL DE PAGOS Y ESTADO) // aparte calular el estado de la orden y actualiza
=============================================*/
public static function mdlMostrarDetallesOrden($idOrden)
{
    try {
        // Conexión a la base de datos
        $link = Conexion::conectar();

        // Consulta para obtener detalles de la orden
        $stmt = $link->prepare("
            SELECT 
                o.id_orden, 
                o.numero_orden, 
                DATE(o.fecha_recepcion_orden) AS fecha_recepcion_orden, -- Extraer solo la fecha
                DATE(o.fecha_entrega_orden) AS fecha_entrega_orden, -- Extraer solo la fecha
                o.estado_orden, 
                o.monto_total_orden, 
                o.estado_pago_orden,
                c.nombre_cliente, 
                c.apellido_cliente, 
                c.dni_cliente,
                -- Sumar solo los pagos completados
                SUM(CASE WHEN p.estado = 'Completado' THEN p.monto ELSE 0 END) AS total_pagado,
                -- Concatenar estados de los pagos completados
                GROUP_CONCAT(CASE WHEN p.estado = 'Completado' THEN p.estado ELSE NULL END SEPARATOR ', ') AS estado_pago,
                -- Concatenar métodos de pago utilizados (solo completados)
                GROUP_CONCAT(CASE WHEN p.estado = 'Completado' THEN m.nombre ELSE NULL END SEPARATOR ', ') AS metodos_pago,
                -- Último pago realizado (independientemente de su estado)
                MAX(p.id_pago) AS ultimo_pago_id,
                MAX(p.fecha_creacion) AS fecha_ultimo_pago,
                MAX(p.estado) AS estado_ultimo_pago,
                op.id_prenda, 
                pr.descripcion_prenda, 
                op.id_color, 
                col.nombre_color, 
                op.id_lavado, 
                lav.descripcion_lavado, 
                op.cantidad, 
                op.planchado, 
                op.ojal, 
                op.manualidad, 
                op.total_precio_prenda -- Detalle de prendas
            FROM ordenes o
            INNER JOIN clientes c ON o.id_cliente = c.id_cliente
            LEFT JOIN pagos p ON o.id_orden = p.id_orden -- Relación con la tabla de pagos
            LEFT JOIN metodo_pago m ON p.id_metodo_pago = m.id_metodo_pago
            INNER JOIN ordenes_prendas op ON o.id_orden = op.id_orden
            LEFT JOIN prendas pr ON op.id_prenda = pr.id_prenda
            LEFT JOIN colores col ON op.id_color = col.id_color
            LEFT JOIN lavados lav ON op.id_lavado = lav.id_lavado
            WHERE o.id_orden = :idOrden
            GROUP BY o.id_orden, op.id_prenda, op.id_color, op.id_lavado -- Agrupar por detalles de prendas
        ");

        // Vincular el parámetro de la consulta
        $stmt->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se encontró información
        if (!$resultados) {
            return false;
        }

        // Calcular el estado de la orden basado en los pagos completados
        $montoTotal = floatval($resultados[0]['monto_total_orden']);
        $totalPagado = floatval($resultados[0]['total_pagado']);
        $estadoPagoOrden = $totalPagado >= $montoTotal ? 1 : 0;

        // Actualizar el estado de pago de la orden si es necesario
        $actualizarEstado = $link->prepare("
            UPDATE ordenes 
            SET estado_pago_orden = :estado_pago_orden 
            WHERE id_orden = :idOrden
        ");
        $actualizarEstado->bindParam(":estado_pago_orden", $estadoPagoOrden, PDO::PARAM_INT);
        $actualizarEstado->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);
        $actualizarEstado->execute();

        // Retornar los detalles actualizados de la orden
        return $resultados;
    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error en mdlMostrarDetallesOrden: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
        $link = null; // Cerrar conexión
    }
}





/*=============================================
actualizar estado de la orden
=============================================*/
    public static function mdlActualizarEstadoOrden($idOrden, $estadoOrden)
    {
        try {
            $stmt = Conexion::conectar()->prepare(
                "UPDATE ordenes 
                 SET estado_orden = :estado_orden 
                 WHERE id_orden = :id_orden"
            );

            // Vincular los parámetros
            $stmt->bindParam(":estado_orden", $estadoOrden, PDO::PARAM_INT);
            $stmt->bindParam(":id_orden", $idOrden, PDO::PARAM_INT);

            // Ejecutar la consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            // Registrar el error para depuración
            error_log("Error en mdlActualizarEstadoOrden: " . $e->getMessage());
            return false;
        }
    }



/*=============================================
Controlar los pagos de una orden (solo pagos Completados)
=============================================*/
public static function mdlControlPagos($idOrden)
{
    try {
        // Conexión a la base de datos
        $link = Conexion::conectar();

        // Calcular la suma de los pagos realizados para una orden con estado Completado
        $stmt = $link->prepare("
            SELECT SUM(monto) AS total_pagado
            FROM pagos
            WHERE id_orden = :idOrden AND estado = 'Completado'
        ");
        $stmt->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);

        $stmt->execute();

        // Obtener el resultado de la suma
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver la suma total pagada
        return $resultado["total_pagado"] ? floatval($resultado["total_pagado"]) : 0;
    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error en mdlControlPagos: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
        $link = null;
    }
}

    /*=============================================
Actualizar el estado de pago de una orden
=============================================*/
    public static function mdlActualizarEstadoPagoOrden($idOrden, $estadoPago)
    {
        try {
            // Conexión a la base de datos
            $link = Conexion::conectar();

            // Actualizar el estado de pago de la orden
            $stmt = $link->prepare("
            UPDATE ordenes
            SET estado_pago_orden = :estadoPago
            WHERE id_orden = :idOrden
        ");
            $stmt->bindParam(":estadoPago", $estadoPago, PDO::PARAM_INT);
            $stmt->bindParam(":idOrden", $idOrden, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error en mdlActualizarEstadoPagoOrden: " . $e->getMessage());
            return false;
        } finally {
            $stmt = null;
            $link = null;
        }
    }
}
