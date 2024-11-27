<?php

class ControladorLavados
{
    /*=============================================
    MOSTRAR LAVADOS
    =============================================*/
    static public function ctrMostrarLavados($item, $valor)
    {
        $tabla = "lavados";
        $respuesta = ModeloLavados::mdlMostrarLavados($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
    CREAR LAVADO
    =============================================*/
    static public function ctrCrearLavado()
    {
        if (isset($_POST["descripcion_lavado"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .]+$/', $_POST["descripcion_lavado"]) &&
                preg_match('/^[0-9.]+$/', $_POST["costo_lavado"]) &&
                in_array($_POST["tipo_lavado"], ["básico", "premium", "especial"])
            ) {
                $tabla = "lavados";

                $datos = array(
                    "descripcion_lavado" => trim($_POST["descripcion_lavado"]),
                    "tipo_lavado" => $_POST["tipo_lavado"],
                    "costo_lavado" => $_POST["costo_lavado"]
                );

                $respuesta = ModeloLavados::mdlCrearLavado($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                            fncSweetAlert("success", "El lavado ha sido agregado correctamente", "lavados");
                          </script>';
                } else {
                    echo '<script>
                            fncSweetAlert("error", "Error al agregar el lavado", "");
                          </script>';
                }
            } else {
                echo '<script>
                        fncSweetAlert("error", "Los datos ingresados no son válidos", "");
                      </script>';
            }
        }
    }

    /*=============================================
    EDITAR LAVADO
    =============================================*/
    static public function ctrEditarLavado()
    {
        if (isset($_POST["idLavado"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .]+$/', $_POST["editarDescripcionLavado"]) &&
                preg_match('/^[0-9.]+$/', $_POST["editarCostoLavado"]) &&
                in_array($_POST["editarTipoLavado"], ["básico", "premium", "especial"])
            ) {
                $tabla = "lavados";

                $datos = array(
                    "idLavado" => $_POST["idLavado"],
                    "descripcion_lavado" => trim($_POST["editarDescripcionLavado"]),
                    "tipo_lavado" => $_POST["editarTipoLavado"],
                    "costo_lavado" => $_POST["editarCostoLavado"]
                );

                $respuesta = ModeloLavados::mdlEditarLavado($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                            fncSweetAlert("success", "El lavado ha sido actualizado correctamente", "lavados");
                          </script>';
                } else {
                    echo '<script>
                            fncSweetAlert("error", "Error al actualizar el lavado", "");
                          </script>';
                }
            } else {
                echo '<script>
                        fncSweetAlert("error", "Los datos ingresados no son válidos", "");
                      </script>';
            }
        }
    }

    /*=============================================
    ELIMINAR LAVADO
    =============================================*/
    static public function ctrEliminarLavado()
    {
        if (isset($_GET["idLavado"])) {
            $tabla = "lavados";
            $valor = $_GET["idLavado"];

            $respuesta = ModeloLavados::mdlEliminarLavado($tabla, $valor);

            if ($respuesta == "ok") {
                echo '<script>
                        fncSweetAlert("success", "El lavado ha sido eliminado correctamente", "lavados");
                      </script>';
            } else {
                echo '<script>
                        fncSweetAlert("error", "Error al eliminar el lavado", "");
                      </script>';
            }
        }
    }
}
