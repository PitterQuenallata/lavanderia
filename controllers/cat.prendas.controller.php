<?php
class ControladorCatPrendas
{

  /*=============================================
  MOSTRAR CATEGORÍAS DE PRENDAS
  =============================================*/
  static public function ctrMostrarCatPrendas($item, $valor)
  {
    $tabla = "categorias_prendas";
    $respuesta = ModeloCatPrendas::mdlMostrarCatPrendas($tabla, $item, $valor);
    return $respuesta;
  }

  /*=============================================
  CREAR CATEGORÍA DE PRENDA
  =============================================*/
  static public function ctrCrearCatPrenda()
  {
    if (isset($_POST["nombre_categoria_prenda"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["nombre_categoria_prenda"])
      ) {

        $tabla = "categorias_prendas";

        $nombreCatPrenda = mb_strtolower(trim($_POST["nombre_categoria_prenda"]), 'UTF-8');

        $datos = array(
          "nombre_categoria_prenda" => $nombreCatPrenda
        );

        $respuesta = ModeloCatPrendas::mdlIngresarCatPrenda($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "La categoría ha sido agregada correctamente", "cat-prendas");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al agregar la categoría", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡La categoría no puede ir vacía o llevar caracteres especiales!", "");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  EDITAR CATEGORÍA DE PRENDA
  =============================================*/
  static public function ctrEditarCatPrenda()
  {
    if (isset($_POST["idCatPrenda"])) {

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["editarNombreCatPrenda"])) {

        $tabla = "categorias_prendas";

        $nombreCatPrenda = mb_strtolower(trim($_POST["editarNombreCatPrenda"]), 'UTF-8');

        $datos = array(
          "idCatPrenda" => $_POST["idCatPrenda"],
          "nombre_categoria_prenda" => $nombreCatPrenda
        );

        $respuesta = ModeloCatPrendas::mdlEditarCatPrenda($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "La categoría ha sido actualizada correctamente", "cat-prendas");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al actualizar la categoría", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡La categoría no puede ir vacía o llevar caracteres especiales inválidos!", "");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  ELIMINAR CATEGORÍA DE PRENDA
  =============================================*/
  public function ctrEliminarCatPrenda()
  {
    if (isset($_GET["idCatPrenda"])) {

      $tabla = "categorias_prendas";
      $item = "id_categoria_prenda";
      $valor = $_GET["idCatPrenda"];

      $respuesta = ModeloCatPrendas::mdlEliminarCatPrenda($tabla, $item, $valor);

      if ($respuesta == "ok") {
        echo '<script>
                fncSweetAlert("success", "La categoría ha sido eliminada correctamente", "cat-prendas");
              </script>';
      } else {
        echo '<script>
                fncSweetAlert("error", "Error al eliminar la categoría", "");
              </script>';
      }
    }
  }
}
