<?php

require_once "conexion.php";

class ModeloOrdenes {

/*=============================================
MOSTRAR ÓRDENES
=============================================*/
public static function mdlMostrarOrdenes($tabla, $item, $valor)
{
    try {
        $link = Conexion::conectar(); // Establecer conexión
        // Consulta principal
        $query = "
            SELECT 
                o.id_orden, 
                o.numero_orden, 
                o.fecha_recepcion_orden, 
                o.fecha_entrega_orden, 
                o.monto_total_orden, 
                o.estado_orden, 
                c.nombre_cliente AS nombre_cliente, 
                c.apellido_cliente AS apellido_cliente, 
                c.dni_cliente AS dni_cliente,
                p.estado AS estado_pago,
                p.monto AS monto_pagado,
                m.nombre AS metodo_pago
            FROM ordenes o
            INNER JOIN clientes c ON o.id_cliente = c.id_cliente
            INNER JOIN pagos p ON o.id_pago = p.id_pago
            INNER JOIN metodo_pago m ON p.id_metodo_pago = m.id_metodo_pago
        ";

        // Si hay una condición específica
        if ($item !== null) {
            $query .= " WHERE o.$item = :$item"; // Filtrar por la columna especificada
            $stmt = $link->prepare($query);
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        } else {
            $stmt = $link->prepare($query); // Consulta sin filtros
        }

        $stmt->execute(); // Ejecutar consulta

        // Retornar todos los registros
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        // Manejo de errores
        return false;
    } finally {
        $stmt = null;
        $link = null; // Cerrar conexión
    }
}



    // Guardar el pago y devolver el ID del pago registrado
    public static function mdlGuardarPagoEfectivo($datosPago) {
        try {
            $link = Conexion::conectar(); // Conexión persistente
            $stmt = $link->prepare("
                INSERT INTO pagos (id_metodo_pago, monto, estado, detalle)
                VALUES (:id_metodo_pago, :monto, :estado, :detalle)
            ");

            $stmt->bindParam(":id_metodo_pago", $datosPago["id_metodo_pago"], PDO::PARAM_INT);
            $stmt->bindParam(":monto", $datosPago["monto"], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $datosPago["estado"], PDO::PARAM_STR);
            $stmt->bindParam(":detalle", $datosPago["detalle"], PDO::PARAM_STR);

            if ($stmt->execute()) {
                // Retornar el ID del pago registrado
                return $link->lastInsertId(); 
            } else {
                return false; // Error en la ejecución
            }
        } catch (Exception $e) {
            return false; // Error en el bloque try-catch
        }

        $stmt = null;
    }

    // Guardar la orden y devolver el ID de la orden registrada
    public static function mdlGuardarOrden($datosOrden) {
      try {
          $link = Conexion::conectar(); // Conexión persistente
          $stmt = $link->prepare("
              INSERT INTO ordenes 
              (id_cliente, id_usuario, id_pago, numero_orden, fecha_recepcion_orden, fecha_entrega_orden, monto_total_orden)
              VALUES 
              (:id_cliente, :id_usuario, :id_pago, :numero_orden, :fecha_recepcion, :fecha_entrega, :monto)
          ");
  
          $stmt->bindParam(":id_cliente", $datosOrden["id_cliente"], PDO::PARAM_INT);
          $stmt->bindParam(":id_usuario", $datosOrden["id_usuario"], PDO::PARAM_INT);
          $stmt->bindParam(":id_pago", $datosOrden["id_pago"], PDO::PARAM_INT);
          $stmt->bindParam(":numero_orden", $datosOrden["numero_orden"], PDO::PARAM_STR);
          $stmt->bindParam(":fecha_recepcion", $datosOrden["fecha_recepcion"], PDO::PARAM_STR);
          $stmt->bindParam(":fecha_entrega", $datosOrden["fecha_entrega"], PDO::PARAM_STR);
          $stmt->bindParam(":monto", $datosOrden["monto_total_orden"], PDO::PARAM_STR);
  
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
  

    // Guardar los detalles de las prendas
    public static function mdlGuardarDetallesPrendas($datosDetalle) {
        try {
            $link = Conexion::conectar(); // Conexión persistente
            $stmt = $link->prepare("
                INSERT INTO ordenes_prendas (id_orden, id_prenda, id_color, id_lavado, cantidad, planchado, ojal, manualidad)
                VALUES (:id_orden, :id_prenda, :id_color, :id_lavado, :cantidad, :planchado, :ojal, :manualidad)
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
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true; // Inserción exitosa
            } else {
                return false; // Error en la ejecución
            }
        } catch (Exception $e) {
            return false; // Error general
        } finally {
            $stmt = null;
            $link = null; // Cerrar conexión
        }
    }
    
    
}

