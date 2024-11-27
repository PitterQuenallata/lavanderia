<?php
require_once "conexion.php";

class ModeloColores
{
    /*=============================================
    MOSTRAR COLORES
    =============================================*/
    static public function mdlMostrarColores($tabla, $item, $valor)
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
    CREAR COLOR
    =============================================*/
    static public function mdlIngresarColor($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_color, fecha_creacion) VALUES (:nombre_color, NOW())");

        $stmt->bindParam(":nombre_color", $datos["nombre_color"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    EDITAR COLOR
    =============================================*/
    static public function mdlEditarColor($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_color = :nombre_color, fecha_actualizacion = NOW() WHERE id_color = :idColor");

        $stmt->bindParam(":nombre_color", $datos["nombre_color"], PDO::PARAM_STR);
        $stmt->bindParam(":idColor", $datos["idColor"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null; // Cerrar conexión
    }

    /*=============================================
    ELIMINAR COLOR
    =============================================*/
    static public function mdlEliminarColor($tabla, $item, $valor)
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
