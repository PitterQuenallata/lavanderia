<?php

require_once "conexion.php";

class ModeloClientes
{
    /*=============================================
    MOSTRAR CLIENTES
    =============================================*/
    static public function mdlMostrarClientes($tabla, $item, $valor)
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

        $stmt = null;
    }

    /*=============================================
    CREAR CLIENTE
    =============================================*/
    static public function mdlCrearCliente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla (nombre_cliente, apellido_cliente, telefono_cliente, direccion_cliente, email_cliente, dni_cliente) 
            VALUES (:nombre_cliente, :apellido_cliente, :telefono_cliente, :direccion_cliente, :email_cliente, :dni_cliente)"
        );
    
        $stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido_cliente", $datos["apellido_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_cliente", $datos["telefono_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_cliente", $datos["direccion_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":email_cliente", $datos["email_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":dni_cliente", $datos["dni_cliente"], PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    
        $stmt = null;
    }
    

    /*=============================================
    EDITAR CLIENTE
    =============================================*/
    static public function mdlEditarCliente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET 
                nombre_cliente = :nombre_cliente,
                apellido_cliente = :apellido_cliente,
                telefono_cliente = :telefono_cliente,
                direccion_cliente = :direccion_cliente,
                email_cliente = :email_cliente,
                dni_cliente = :dni_cliente
            WHERE id_cliente = :id_cliente"
        );
    
        $stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido_cliente", $datos["apellido_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono_cliente", $datos["telefono_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion_cliente", $datos["direccion_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":email_cliente", $datos["email_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":dni_cliente", $datos["dni_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    
        $stmt->closeCursor();
        $stmt = null;
    }
    

    /*=============================================
    ELIMINAR CLIENTE
    =============================================*/
    static public function mdlEliminarCliente($tabla, $valor)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_cliente = :idCliente");
        $stmt->bindParam(":idCliente", $valor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }
}
