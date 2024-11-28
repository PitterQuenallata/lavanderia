<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
OBTENER USUARIO POR ID
=============================================*/

static public function mdlObtenerUsuarioPorId($tabla, $id_usuario)
{
    $stmt = Conexion::conectar()->prepare(
        "SELECT * FROM $tabla WHERE id_usuario = :id_usuario"
    );

    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = null;
}

/*=============================================
    MODELO PARA ACTUALIZAR LA CONTRASEÑA
    =============================================*/
    static public function mdlNuevoPassLogin($tabla, $datos) {
			try {
					$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET password_usuario = :password_usuario WHERE id_usuario = :id_usuario");

					$stmt->bindParam(":password_usuario", $datos["password_usuario"], PDO::PARAM_STR);
					$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

					if ($stmt->execute()) {
							return "ok";
					} else {
							return "error";
					}

					$stmt->close();
					$stmt = null;
			} catch (Exception $e) {
					return "error: " . $e->getMessage();
			}
	}
	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/


	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		$stmt = null;
	}

/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(foto_usuario, nombre_usuario, apellido_paterno_usuario, apellido_materno_usuario, user_usuario, password_usuario, email_usuario, rol_usuario, telefono_usuario) VALUES (:foto_usuario, :nombre_usuario, :apellido_paterno_usuario, :apellido_materno_usuario,:user_usuario, :password_usuario, :email_usuario, :rol_usuario, :telefono_usuario)");
		
		$stmt->bindParam(":foto_usuario", $datos["foto_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":user_usuario", $datos["user_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_usuario", $datos["nombre_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido_paterno_usuario", $datos["apellido_paterno_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido_materno_usuario", $datos["apellido_materno_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password_usuario", $datos["password_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":email_usuario", $datos["email_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":rol_usuario", $datos["rol_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono_usuario", $datos["telefono_usuario"], PDO::PARAM_STR);

		

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){

    $stmt = Conexion::conectar()->prepare(
        "UPDATE $tabla 
        SET nombre_usuario = :nombre_usuario, 
            apellido_paterno_usuario = :apellido_paterno_usuario,
						apellido_materno_usuario = :apellido_materno_usuario,
            email_usuario = :email_usuario, 
            user_usuario = :user_usuario, 
            password_usuario = :password_usuario, 
            rol_usuario = :rol_usuario, 
            foto_usuario = :foto_usuario,
						telefono_usuario = :telefono_usuario
        WHERE user_usuario = :user_usuario"
    );

    $stmt -> bindParam(":nombre_usuario", $datos["nombre_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":apellido_paterno_usuario", $datos["apellido_paterno_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":apellido_materno_usuario", $datos["apellido_materno_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":email_usuario", $datos["email_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":user_usuario", $datos["user_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":password_usuario", $datos["password_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":rol_usuario", $datos["rol_usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono_usuario", $datos["telefono_usuario"], PDO::PARAM_STR);
    $stmt -> bindParam(":foto_usuario", $datos["foto_usuario"], PDO::PARAM_STR);

    if($stmt -> execute()){
        return "ok";
    } else {
        return "error";    
    }

    $stmt = null;
}
/*=============================================
MODELO PARA EDITAR PERFIL
=============================================*/
static public function mdlEditarPerfil($tabla, $datos)
{
    $stmt = Conexion::conectar()->prepare(
        "UPDATE $tabla 
        SET nombre_usuario = :nombre_usuario, 
            apellido_paterno_usuario = :apellido_paterno_usuario,
            apellido_materno_usuario = :apellido_materno_usuario,
            email_usuario = :email_usuario, 
            telefono_usuario = :telefono_usuario, 
            password_usuario = :password_usuario, 
            foto_usuario = :foto_usuario
        WHERE id_usuario = :id_usuario"
    );

    $stmt->bindParam(":nombre_usuario", $datos["nombre_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":apellido_paterno_usuario", $datos["apellido_paterno_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":apellido_materno_usuario", $datos["apellido_materno_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":email_usuario", $datos["email_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":telefono_usuario", $datos["telefono_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":password_usuario", $datos["password_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":foto_usuario", $datos["foto_usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

    if ($stmt->execute()) {
        return "ok";
    } else {
        return "error";
    }

    $stmt = null;
}




	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
				return "ok";
		} else {
				return "error";    
		}

		$stmt = null;
}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}


		$stmt = null;


	}

}