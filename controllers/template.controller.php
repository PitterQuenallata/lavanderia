<?php

class TemplateController
{
  static public function index()
  {
    include 'views/template.php';
  }

  //ruta principal o dominio del sitio
  static public function path()
  {
    if (!empty($_SERVER["HTTPS"]) && ("on" == $_SERVER["HTTPS"])) {
      return "https://" . $_SERVER["SERVER_NAME"] . "/";
    } else {
      return "http://" . $_SERVER["SERVER_NAME"] . "/";
    }
  }

/*=============================================
		Funciuon limpiar html
		=============================================*/
    static public function htmlClean($code)
    {
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>','<','\\1');
        $code = preg_replace($search, $replace, $code);
        $code = str_replace("> <", "><", $code);
        return $code;
    }
    /*=============================================
		Gestion administradores
	=============================================*/
    public function adminManage(){
        if (isset($_POST["name_admin"])) {
            
        
        }
    }

    /*=============================================
	Función para mayúscula inicial
	=============================================*/

	static public function capitalize($value){

		$value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
	    return $value;

	}
    /*=============================================
	Función Reducir texto
	=============================================*/

	static public function reduceText($value, $limit){

		if(strlen($value) > $limit){

			$value = substr($value, 0, $limit)."...";

		}

		return $value;

	}

}
