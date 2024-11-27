<?php
class ControladorColores
{
  /*=============================================
  MOSTRAR COLORES
  =============================================*/
  static public function ctrMostrarColores($item, $valor)
  {
    $tabla = "colores";
    $respuesta = ModeloColores::mdlMostrarColores($tabla, $item, $valor);
    return $respuesta;
  }

  /*=============================================
  CREAR COLOR
  =============================================*/
  static public function ctrCrearColor()
  {
    if (isset($_POST["nombre_color"])) {
      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["nombre_color"])) {
        $tabla = "colores";

        $datos = array(
          "nombre_color" => mb_strtolower(trim($_POST["nombre_color"]), 'UTF-8')
        );

        $respuesta = ModeloColores::mdlIngresarColor($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "El color ha sido agregado correctamente", "colores");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al agregar el color", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡El color no puede ir vacío o llevar caracteres especiales!");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  EDITAR COLOR
  =============================================*/
  static public function ctrEditarColor()
  {
    if (isset($_POST["idColor"])) {
      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["editarNombreColor"])) {
        $tabla = "colores";

        $datos = array(
          "idColor" => $_POST["idColor"],
          "nombre_color" => mb_strtolower(trim($_POST["editarNombreColor"]), 'UTF-8')
        );

        $respuesta = ModeloColores::mdlEditarColor($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "El color ha sido actualizado correctamente", "colores");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al actualizar el color", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡El color no puede llevar caracteres especiales inválidos!", "");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  ELIMINAR COLOR
  =============================================*/
  public function ctrEliminarColor()
  {
    if (isset($_GET["idColor"])) {
      $tabla = "colores";
      $item = "id_color";
      $valor = $_GET["idColor"];

      $respuesta = ModeloColores::mdlEliminarColor($tabla, $item, $valor);

      if ($respuesta == "ok") {
        echo '<script>
                fncSweetAlert("success", "El color ha sido eliminado correctamente", "colores");
              </script>';
      } else {
        echo '<script>
                fncSweetAlert("error", "Error al eliminar el color", "");
              </script>';
      }
    }
  }
}
