<?php

require_once "conexion.php";

class ModeloLavados
{
    /*=============================================
    MOSTRAR LAVADOS
    =============================================*/
    static public function mdlMostrarLavados($tabla, $item, $valor)
    {
        if ($item != null) {
            // Consulta para un solo registro
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } else {
            // Consulta para todos los registros
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null;
    }

    /*=============================================
    CREAR LAVADO
    =============================================*/
    static public function mdlCrearLavado($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (descripcion_lavado, tipo_lavado, costo_lavado) VALUES (:descripcion_lavado, :tipo_lavado, :costo_lavado)");

        $stmt->bindParam(":descripcion_lavado", $datos["descripcion_lavado"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_lavado", $datos["tipo_lavado"], PDO::PARAM_STR);
        $stmt->bindParam(":costo_lavado", $datos["costo_lavado"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }

    /*=============================================
    EDITAR LAVADO
    =============================================*/
    static public function mdlEditarLavado($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion_lavado = :descripcion_lavado, tipo_lavado = :tipo_lavado, costo_lavado = :costo_lavado WHERE id_lavado = :idLavado");

        $stmt->bindParam(":descripcion_lavado", $datos["descripcion_lavado"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_lavado", $datos["tipo_lavado"], PDO::PARAM_STR);
        $stmt->bindParam(":costo_lavado", $datos["costo_lavado"], PDO::PARAM_STR);
        $stmt->bindParam(":idLavado", $datos["idLavado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }

    /*=============================================
    ELIMINAR LAVADO
    =============================================*/
    static public function mdlEliminarLavado($tabla, $valor)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_lavado = :idLavado");

        $stmt->bindParam(":idLavado", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }
}
