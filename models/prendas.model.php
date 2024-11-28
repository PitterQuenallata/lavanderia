<?php
require_once "conexion.php";

class ModeloPrendas
{

    /*=============================================
    MOSTRAR PRENDAS POR CATEGORÍA
    =============================================*/
    static public function mdlMostrarPrendasPorCategoria($tabla, $item, $valor) {
        $stmt = Conexion::conectar()->prepare("
            SELECT 
                p.id_prenda, 
                p.descripcion_prenda, 
                c.nombre_categoria_prenda
            FROM $tabla AS p
            INNER JOIN categorias_prendas AS c ON p.id_categoria_prenda = c.id_categoria_prenda
            WHERE p.$item = :$item
        ");

        $stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;
    }
    /*=============================================
    MOSTRAR PRENDAS
    =============================================*/
    static public function mdlMostrarPrendas($tabla, $tablaCategoria, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT $tabla.*, $tablaCategoria.nombre_categoria_prenda 
                 FROM $tabla
                 INNER JOIN $tablaCategoria ON $tabla.id_categoria_prenda = $tablaCategoria.id_categoria_prenda
                 WHERE $tabla.$item = :$item"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT $tabla.*, $tablaCategoria.nombre_categoria_prenda 
                 FROM $tabla
                 INNER JOIN $tablaCategoria ON $tabla.id_categoria_prenda = $tablaCategoria.id_categoria_prenda"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    CREAR PRENDA
    =============================================*/
    static public function mdlIngresarPrenda($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(descripcion_prenda, id_categoria_prenda, fecha_creacion) 
             VALUES (:descripcion_prenda, :id_categoria_prenda, NOW())"
        );

        $stmt->bindParam(":descripcion_prenda", $datos["descripcion_prenda"], PDO::PARAM_STR);
        $stmt->bindParam(":id_categoria_prenda", $datos["id_categoria_prenda"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    EDITAR PRENDA
    =============================================*/
    static public function mdlEditarPrenda($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla 
             SET descripcion_prenda = :descripcion_prenda, id_categoria_prenda = :id_categoria_prenda, fecha_actualizacion = NOW() 
             WHERE id_prenda = :idPrenda"
        );

        $stmt->bindParam(":descripcion_prenda", $datos["descripcion_prenda"], PDO::PARAM_STR);
        $stmt->bindParam(":id_categoria_prenda", $datos["id_categoria_prenda"], PDO::PARAM_INT);
        $stmt->bindParam(":idPrenda", $datos["idPrenda"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    ELIMINAR PRENDA
    =============================================*/
    static public function mdlEliminarPrenda($tabla, $item, $valor)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }
}
