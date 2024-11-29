<?php

class ControladorClientes
{
    /*=============================================
    MOSTRAR CLIENTES
    =============================================*/
    static public function ctrMostrarClientes($item, $valor)
    {
        $tabla = "clientes";
        $respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    CREAR CLIENTE
    =============================================*/
    static public function ctrCrearCliente()
    {
        if (isset($_POST["nuevoNombre"])) { // Actualizado el name del campo
            if (
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoApellido"]) &&
                preg_match('/^[67][0-9]{7}$/', $_POST["nuevoTelefono"])
            ) {
                $tabla = "clientes";
    
                // Asignar valores NULL para los campos opcionales si están vacíos
                $direccion = !empty($_POST["nuevaDireccion"]) ? $_POST["nuevaDireccion"] : null;
                $email = !empty($_POST["nuevoEmail"]) ? $_POST["nuevoEmail"] : null;
                $dni = !empty($_POST["nuevoDNI"]) ? $_POST["nuevoDNI"] : null;
    
                $datos = array(
                    "nombre_cliente" => $_POST["nuevoNombre"],
                    "apellido_cliente" => $_POST["nuevoApellido"],
                    "telefono_cliente" => $_POST["nuevoTelefono"],
                    "direccion_cliente" => $direccion,
                    "email_cliente" => $email,
                    "dni_cliente" => $dni,
                );
    
                $respuesta = ModeloClientes::mdlCrearCliente($tabla, $datos);
    
                if ($respuesta == "ok") {
                    echo '<script>
                            fncSweetAlert("success", "El cliente ha sido agregado correctamente", "clientes");
                          </script>';
                } else {
                    echo '<script>
                            fncSweetAlert("error", "Error al agregar el cliente", "");
                          </script>';
                }
            } else {
                echo '<script>
                        fncSweetAlert("error", "¡Por favor llene los campos correctamente!", "");
                      </script>';
            }
        }
    }
    
    

    /*=============================================
    EDITAR CLIENTE
    =============================================*/
    static public function ctrEditarCliente()
    {
        if (isset($_POST["idCliente"])) {
            if (
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombreCliente"]) &&
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellidoCliente"]) &&
                preg_match('/^[67][0-9]{7}$/', $_POST["editarTelefonoCliente"])
            ) {
                $tabla = "clientes";
    
                // Asignar valores NULL para los campos opcionales si están vacíos
                $direccion = empty($_POST["editarDireccionCliente"]) ? null : $_POST["editarDireccionCliente"];
                $email = empty($_POST["editarEmailCliente"]) ? null : $_POST["editarEmailCliente"];
                $dni = empty($_POST["editarDniCliente"]) ? null : $_POST["editarDniCliente"];
    
                $datos = array(
                    "id_cliente" => $_POST["idCliente"],
                    "nombre_cliente" => $_POST["editarNombreCliente"],
                    "apellido_cliente" => $_POST["editarApellidoCliente"],
                    "telefono_cliente" => $_POST["editarTelefonoCliente"],
                    "direccion_cliente" => $direccion,
                    "email_cliente" => $email,
                    "dni_cliente" => $dni,
                );
    
                $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
    
                if ($respuesta == "ok") {
                    echo '<script>
                            fncSweetAlert("success", "El cliente ha sido actualizado correctamente", "clientes");
                        </script>';
                } else {
                    echo '<script>
                            fncSweetAlert("error", "Error al actualizar el cliente", "");
                        </script>';
                }
            } else {
                echo '<script>
                        fncSweetAlert("error", "¡Por favor llene los campos correctamente!");
                    </script>';
            }
        }
    }
    

    /*=============================================
    ELIMINAR CLIENTE
    =============================================*/
    static public function ctrEliminarCliente()
    {
        if (isset($_GET["idCliente"])) {
            $tabla = "clientes";
            $valor = $_GET["idCliente"];

            $respuesta = ModeloClientes::mdlEliminarCliente($tabla, $valor);

            if ($respuesta == "ok") {
                echo '<script>
                        fncSweetAlert("success", "El cliente ha sido eliminado correctamente", "clientes");
                      </script>';
            } else {
                echo '<script>
                        fncSweetAlert("error", "Error al eliminar el cliente", "");
                      </script>';
            }
        }
    }
}
