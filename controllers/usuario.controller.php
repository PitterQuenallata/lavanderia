<?php


class ControladorUsuarios
{

    /*=============================================
    NUEVO PASSWORD AL INGRESAR
    =============================================*/
    static public function ctrNuevoPassLogin()
    {
        if (isset($_POST["nuevoPassLogin"])) {

            // Validar la nueva contraseña
            if (preg_match('/^[*\\$\\!\\¡\\?\\¿\\.\\_\\#\\-\\0-9A-Za-z]{1,}$/', $_POST["nuevoPassLogin"])) {

                // Encriptar la nueva contraseña
                $crypt = crypt($_POST["nuevoPassLogin"], '$2a$07$azybxcags23425sdg23sdfhsd$');
                $idUsuario= $_SESSION["users"]["id_usuario"];
                // Preparar los datos para enviar al modelo
                $tabla = "usuarios";
                $datos = array(
                    "id_usuario" => $idUsuario, // Asume que tienes el ID del usuario en la sesión
                    "password_usuario" => $crypt
                );

                // Llamar al modelo para actualizar la contraseña
                $respuesta = ModeloUsuarios::mdlNuevoPassLogin($tabla, $datos);

                // Verificar la respuesta del modelo
                if ($respuesta == "ok") {
                    date_default_timezone_set('America/La_Paz');

                    $fecha = date('Y-m-d');
                    $hora = date('H:i:s');

                    $fechaActual = $fecha . ' ' . $hora;

                    $item1 = "ultimo_login_usuario";
                    $valor1 = $fechaActual;

                    $item2 = "id_usuario";
                    $valor2 = $idUsuario;

                    $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
                    if ($ultimoLogin == "ok") {
                        $_SESSION["users"]["ultimo_login_usuario"] = $fechaActual;
                        
                        // Redirección según el rol del usuario
                        $rolUsuario = $_SESSION["users"]["rol_usuario"];

                        if ($rolUsuario == "administrador") {
                            echo '<script>window.location = "dashboard";</script>';
                        } elseif ($rolUsuario == "promotor" || $rolUsuario == "secretaria") {
                            echo '<script>window.location = "orden";</script>';
                        } else {
                            // Redirección por defecto en caso de un rol desconocido
                            echo '<script>window.location = "login";</script>';
                        }
                    }
                } else {

                    echo '<div class="alert alert-danger mt-3">Hubo un error al actualizar la contraseña.</div>
                    <script>
                        fncMatPreloader("off");
                        fncFormatInputs();
                        fncToastr("error", "Hubo un error al actualizar la contraseña.");

                    </script>';
                }
            } else {
                echo '<div class="alert alert-danger mt-3">La contraseña no cumple con los requisitos</div>
                <script>
                    fncMatPreloader("off");
                    fncFormatInputs();
                    fncToastr("error", "La contraseña no cumple con los requisitos");

                </script>';
            }
        }
    }

/*=============================================
INGRESO DE USUARIO
=============================================*/
static public function ctrIngresoUsuario()
{
    if (isset($_POST["ingUsuario"])) {


        if (
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
        ) {
            $crypt = crypt($_POST["ingPassword"], '$2a$07$azybxcags23425sdg23sdfhsd$');

            $tabla = "usuarios";
            $item = "user_usuario";
            $valor = $_POST["ingUsuario"];
            //var_dump($crypt);
            $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
            //var_dump($respuesta);

            if (is_array($respuesta) && isset($respuesta["user_usuario"]) && isset($respuesta["password_usuario"])) {
                if ($respuesta["user_usuario"] == $_POST["ingUsuario"] && $respuesta["password_usuario"] == $crypt) {
                    if ($respuesta["estado_usuario"] == 1) { // Verificar si el usuario está activo

                            date_default_timezone_set('America/La_Paz');

                            $fecha = date('Y-m-d');
                            $hora = date('H:i:s');
                            $fechaActual = $fecha . ' ' . $hora;

                            $item1 = "ultimo_login_usuario";
                            $valor1 = $fechaActual;

                            $item2 = "id_usuario";
                            $valor2 = $respuesta["id_usuario"];

                            $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

                            if ($ultimoLogin == "ok") {
                                // Usar el ID real del usuario autenticado
                                $_SESSION['id_usuario'] = $respuesta["id_usuario"];
                                $_SESSION["users"] = $respuesta;
                            
                                // Redirección según el rol del usuario
                                $rolUsuario = $_SESSION["users"]["rol_usuario"];
                            
                                if ($rolUsuario == "administrador") {
                                    echo '<script>window.location = "dashboard";</script>';
                                } elseif ($rolUsuario == "promotor" || $rolUsuario == "secretaria") {
                                    echo '<script>window.location = "orden";</script>';
                                } else {
                                    // Redirección por defecto en caso de un rol desconocido
                                    echo '<script>window.location = "login";</script>';
                                }
                            }
                            
                        
                    } else {
                        echo '<div class="alert alert-danger mt-3">El usuario está inactivo</div>
                        <script>
                            
                            //fncFormatInputs();
                            fncToastr("error", "El usuario está inactivo");
                        </script>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-3">Usuario y contraseña incorrectos</div>
                    <script>
                        
                        //fncFormatInputs();
                        fncToastr("error", "Usuario y contraseña incorrectos");
                    </script>';
                }
            } else {
                //var_dump($respuesta);
                echo '<div class="alert alert-danger mt-3">Usuario y contraseña incorrectos</div>
                <script>
               
                    //fncFormatInputs();
                    fncToastr("error", "Usuario y contraseña incorrectos");
                </script>';
            }
        }
    }
}



/*=============================================
Crear Usuario
=============================================*/
    static public function ctrCrearUsuario()
    {
        //var_dump($_POST);
        if (isset($_POST["user_usuario"])) {

            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["user_usuario"]) &&
                preg_match('/^[*\\$\\!\\¡\\?\\¿\\.\\_\\#\\-\\0-9A-Za-z]{1,}$/', $_POST["password_usuario"]) &&
                preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_usuario"])
            ) {

                /*=============================================
            VALIDAR IMAGEN
            =============================================*/

                // Asignar una imagen predeterminada si no se selecciona ninguna
                $defaultImagePath = 'views/assets/media/avatars/avatar0.jpg';
                $ruta = $defaultImagePath;

                // CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                $directorio = "views/assets/media/avatars/usuarios/" . $_POST["user_usuario"];
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0755);
                }

                if (isset($_FILES["nuevaFoto"]["tmp_name"]) && !empty($_FILES["nuevaFoto"]["tmp_name"])) {

                    print_r($_FILES["nuevaFoto"]);
                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                    DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                    =============================================*/

                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {

                        /*=============================================
                    GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                    =============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "views/assets/media/avatars/usuarios/" . $_POST["user_usuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    } elseif ($_FILES["nuevaFoto"]["type"] == "image/png") {

                    /*=============================================
                    GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                    =============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "views/assets/media/avatars/usuarios/" . $_POST["user_usuario"] . "/" . $aleatorio . ".png";

                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                } else {
                    // Copiar la imagen predeterminada al directorio del usuario
                    $aleatorio = mt_rand(100, 999);
                    $ruta = $directorio . "/" . $aleatorio . ".jpg";
                    copy($defaultImagePath, $ruta);
                }

                $nombreUsuario = mb_strtolower(trim($_POST["nombre_usuario"]), 'UTF-8');
                $apellidoUsuario = mb_strtolower(trim($_POST["apellido_usuario"]), 'UTF-8');
                $apellidoMaterno = mb_strtolower(trim($_POST["apellido_materno_usuario"]), 'UTF-8');

                $crypt = crypt($_POST["password_usuario"], '$2a$07$azybxcags23425sdg23sdfhsd$');

                $tabla = "usuarios";
                $datos = array(
                    "nombre_usuario" => $nombreUsuario,
                    "apellido_paterno_usuario" => $apellidoUsuario,
                    "apellido_materno_usuario" => $apellidoMaterno,
                    "user_usuario" => $_POST["user_usuario"],
                    "password_usuario" => $crypt,
                    "email_usuario" => $_POST["email_usuario"],
                    "rol_usuario" => $_POST["rol_usuario"],
                    "telefono_usuario" => $_POST["celular_usuario"],
                    "foto_usuario" => $ruta
                );
                //print_r($datos);

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
                //print_r($respuesta);
                if ($respuesta == "ok") {
                    echo '<script>
                    fncSweetAlert("success", "Usuario guardado correctamente", "usuarios");
                </script>';
                } else {
                    echo '<script>
                    fncSweetAlert("error", "Error al guardar el usuario");
                </script>';
                }
            } else {
                echo '<script>
                fncSweetAlert("error", "El usuario no debe estar vacio o llevar caracteres especiales");
                fncFormatInputs();
            </script>';
            }
        }
    }

/*=============================================
CONTROLADOR PARA OBTENER USUARIO POR ID
=============================================*/

static public function ctrObtenerUsuarioPorId()
{
    if (isset($_SESSION["id_usuario"])) {
        $tabla = "usuarios";
        $id_usuario = $_SESSION["id_usuario"];

        $respuesta = ModeloUsuarios::mdlObtenerUsuarioPorId($tabla, $id_usuario);

        return $respuesta;
    } else {
        return null;
    }
}


    /*=============================================
	MOSTRAR USUARIO
	=============================================*/

    static public function ctrMostrarUsuarios($item, $valor)
    {

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

        return $respuesta;
    }


    /*=============================================
	EDITAR USUARIO
	=============================================*/

    static public function ctrEditarUsuario()
    {

        if (isset($_POST["editarUsuario"])) {

            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
                filter_var($_POST["editarEmail"], FILTER_VALIDATE_EMAIL)
            ) {



                //print_r($_FILES);
                /*=============================================
            VALIDAR IMAGEN
            =============================================*/

                $ruta = $_POST["fotoActual"];

                if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {
                    echo 'entro';
                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
                CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                =============================================*/

                    $directorio = "views/assets/media/avatars/usuarios/" . $_POST["editarUsuario"];

                    /*=============================================
                PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                =============================================*/

                    if (!empty($_POST["fotoActual"])) {
                        unlink($_POST["fotoActual"]);
                    } else {
                        if (!file_exists($directorio)) {
                            mkdir($directorio, 0755);
                        }
                    }

                    /*=============================================
                DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                =============================================*/

                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {

                        /*=============================================
                    GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                    =============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "views/assets/media/avatars/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    } else if ($_FILES["editarFoto"]["type"] == "image/png") {

                        /*=============================================
                    GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                    =============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "views/assets/media/avatars/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".png";

                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "usuarios";

                if ($_POST["editarPassword"] != "") {

                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {

                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$azybxcags23425sdg23sdfhsd$');
                    } else {

                        echo '<script>
                            fncSweetAlert("error", "¡La contraseña no puede ir vacía o llevar caracteres especiales!");
                            fncFormatInputs();
                            </script>';
                        return;
                    }
                } else {

                    $encriptar = $_POST["passwordActual"];
                }

                $nombreUsuario = mb_strtolower(trim($_POST["editarNombre"]), 'UTF-8');
                $apellidoUsuario = mb_strtolower(trim($_POST["editarApellido"]), 'UTF-8');
                $apellidoMaterno = mb_strtolower(trim($_POST["editarApellidoMaterno"]), 'UTF-8');
                $datos = array(
                    "nombre_usuario" => $nombreUsuario,
                    "apellido_paterno_usuario" => $apellidoUsuario,
                    "apellido_materno_usuario" => $apellidoMaterno,
                    "email_usuario" => $_POST["editarEmail"],
                    "user_usuario" => $_POST["editarUsuario"],
                    "password_usuario" => $encriptar,
                    "rol_usuario" => $_POST["editarPerfil"],
                    "telefono_usuario" => $_POST["editarCelular"],
                    "foto_usuario" => $ruta
                );
                //print_r($datos);
                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '<script>
                fncSweetAlert("success", "El usuario ha sido editado correctamente", "usuarios");
                </script>';
                } else {

                    echo '<script>
                fncSweetAlert("error", "¡Error al editar el usuario!");
                fncFormatInputs();
                </script>';
                }
            } else {

                echo '<script>
            fncSweetAlert("error", "¡El nombre no puede ir vacío o llevar caracteres especiales!");
            fncFormatInputs();
            </script>';
            }
        }
    }


/*=============================================
CONTROLADOR PARA EDITAR PERFIL
=============================================*/
static public function ctrEditarPerfil()
{
    if (isset($_POST["editarNombrePerfil"])) {

        if (
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombrePerfil"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellidoPerfil"]) &&
            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellidoMaternoPerfil"]) &&
            preg_match('/^[0-9]+$/', $_POST["editarCelularPerfil"]) &&
            filter_var($_POST["editarEmailPerfil"], FILTER_VALIDATE_EMAIL)
        ) {

            /*=============================================
            VALIDAR IMAGEN
            =============================================*/
            $ruta = $_POST["fotoActualPerfil"];

            if (isset($_FILES["editarFotoPerfil"]["tmp_name"]) && !empty($_FILES["editarFotoPerfil"]["tmp_name"])) {

                list($ancho, $alto) = getimagesize($_FILES["editarFotoPerfil"]["tmp_name"]);
                $nuevoAncho = 500;
                $nuevoAlto = 500;

                $directorio = "views/assets/media/avatars/usuarios/" . $_POST["editarUsuarioPerfil"];

                if (!empty($_POST["fotoActualPerfil"])) {
                    unlink($_POST["fotoActualPerfil"]);
                } else {
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755);
                    }
                }

                $aleatorio = mt_rand(100, 999);
                if ($_FILES["editarFotoPerfil"]["type"] == "image/jpeg") {
                    $ruta = "$directorio/$aleatorio.jpg";
                    $origen = imagecreatefromjpeg($_FILES["editarFotoPerfil"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $ruta);
                } else if ($_FILES["editarFotoPerfil"]["type"] == "image/png") {
                    $ruta = "$directorio/$aleatorio.png";
                    $origen = imagecreatefrompng($_FILES["editarFotoPerfil"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $ruta);
                }
            }

            /*=============================================
            VALIDAR CONTRASEÑA
            =============================================*/
            $encriptar = !empty($_POST["editarPasswordPerfil"])
                ? crypt($_POST["editarPasswordPerfil"], '$2a$07$azybxcags23425sdg23sdfhsd$')
                : $_POST["passwordActualPerfil"];

            /*=============================================
            PREPARAR DATOS PARA EL MODELO
            =============================================*/
            $tabla = "usuarios";
            $datos = array(
                "id_usuario" => $_SESSION["id_usuario"],
                "nombre_usuario" => mb_strtolower(trim($_POST["editarNombrePerfil"]), 'UTF-8'),
                "apellido_paterno_usuario" => mb_strtolower(trim($_POST["editarApellidoPerfil"]), 'UTF-8'),
                "apellido_materno_usuario" => mb_strtolower(trim($_POST["editarApellidoMaternoPerfil"]), 'UTF-8'),
                "email_usuario" => $_POST["editarEmailPerfil"],
                "telefono_usuario" => $_POST["editarCelularPerfil"],
                "password_usuario" => $encriptar,
                "foto_usuario" => $ruta
            );

            /*=============================================
            LLAMAR AL MODELO
            =============================================*/
            $respuesta = ModeloUsuarios::mdlEditarPerfil($tabla, $datos);

            if ($respuesta == "ok") {
                echo '<script>
                    fncSweetAlert("success", "El perfil ha sido actualizado correctamente", "perfil");
                </script>';
            } else {
                echo '<script>
                    fncSweetAlert("error", "¡Error al actualizar el perfil!");
                </script>';
            }
        } else {
            echo '<script>
                fncSweetAlert("error", "¡Por favor, revise los datos ingresados!");
            </script>';
        }
    }
}


    /*=============================================
	BORRAR USUARIO
	=============================================*/

    static public function ctrBorrarUsuario()
    {
        if (isset($_GET["idUsuario"])) {
    
            $idUsuario = $_GET["idUsuario"];
    
            // Verificar si el usuario a eliminar es el administrador principal
            if ($idUsuario == 1) {
                echo '<script>
                    fncSweetAlert("error", "No puedes eliminar al usuario administrador principal", "");
                </script>';
                return;
            }
    
            $tabla = "usuarios";
            $datos = $idUsuario;
    
            // Decodificar la URL para obtener la ruta correcta de la foto
            $fotoUsuario = urldecode($_GET["fotoUsuario"]);
            $usuario = $_GET["usuario"];
    
            if (!empty($fotoUsuario)) {
                unlink($fotoUsuario);
                rmdir('views/assets/media/avatars/usuarios/' . $usuario);
            }
    
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
    
            if ($respuesta == "ok") {
                echo '<script>
                    fncSweetAlert("success", "El usuario ha sido borrado correctamente", "usuarios");
                </script>';
            } else {
                echo '<script>
                    fncSweetAlert("error", "Error al borrar el usuario", "");
                </script>';
            }
        }
    }
    
}
