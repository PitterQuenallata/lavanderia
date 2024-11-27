<?php
require_once "conexion.php";

class ModeloCatPrendas
{
    /*=============================================
    MOSTRAR CATEGORÍAS DE PRENDAS
    =============================================*/
    static public function mdlMostrarCatPrendas($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    CREAR CATEGORÍA DE PRENDA
    =============================================*/
    static public function mdlIngresarCatPrenda($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_categoria_prenda, fecha_creacion) VALUES (:nombre_categoria_prenda, NOW())");

        $stmt->bindParam(":nombre_categoria_prenda", $datos["nombre_categoria_prenda"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    EDITAR CATEGORÍA DE PRENDA
    =============================================*/
    static public function mdlEditarCatPrenda($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_categoria_prenda = :nombre_categoria_prenda, fecha_actualizacion = NOW() WHERE id_categoria_prenda = :idCatPrenda");

        $stmt->bindParam(":nombre_categoria_prenda", $datos["nombre_categoria_prenda"], PDO::PARAM_STR);
        $stmt->bindParam(":idCatPrenda", $datos["idCatPrenda"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    ELIMINAR CATEGORÍA DE PRENDA
    =============================================*/
    static public function mdlEliminarCatPrenda($tabla, $item, $valor)
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
