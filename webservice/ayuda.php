<?php

    /**
	 * ELABORACION DE LA DOCUMENTACION DE LA AYUDA
	 * @author Bernardo Zerda
     * @author Camilo Bernal
	 * @version 1.0 Septiembre de 2013
	 */

   // Esta variable de usa para ubicar los archivos a incluir
   $txtPrefijoRuta = "../";
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   
   $arrAyuda = array();

   // ayuda para la funcion validarUsuario
   $arrAyuda['validarUsuario']['nombre']                            = "Validar Usuario";
   $arrAyuda['validarUsuario']['descripcion']                       = "Verifica la autenticidad de un usuario";
   $arrAyuda['validarUsuario']['entrada']['usuario']['nombre']      = "Usuario";
   $arrAyuda['validarUsuario']['entrada']['usuario']['tipo']        = "Cadena de caracteres";
   $arrAyuda['validarUsuario']['entrada']['usuario']['descripcion'] = "Digitado en el campo de usuario en el formulario de registro";
   $arrAyuda['validarUsuario']['entrada']['clave']['nombre']        = "Clave";
   $arrAyuda['validarUsuario']['entrada']['clave']['tipo']          = "Cadena de caracteres";
   $arrAyuda['validarUsuario']['entrada']['clave']['descripcion']   = "Digitado en el campo de usuario en el formulario de registro";
   $arrAyuda['validarUsuario']['salida']['cadena']['nombre']        = "Cadena";
   $arrAyuda['validarUsuario']['salida']['cadena']['tipo']          = "tns:Cadena";
   $arrAyuda['validarUsuario']['salida']['cadena']['descripcion']   = "<br>tns:Cadena->texto: Resultados<br>tns:Cadena->Error: String Errores";

   // ayuda para la funcion ciudadanoRegistrado
   $arrAyuda['ciudadanoRegistrado']['nombre']                                  = "Ciudadano Registrado";
   $arrAyuda['ciudadanoRegistrado']['descripcion']                             = "Verifica la existencia de un ciudadano por el numero de documento de identidad";
   $arrAyuda['ciudadanoRegistrado']['entrada']['documento']['nombre']          = "Documento";
   $arrAyuda['ciudadanoRegistrado']['entrada']['documento']['tipo']            = "Número";
   $arrAyuda['ciudadanoRegistrado']['entrada']['documento']['descripcion']     = "Número de documento sin espacios, puntos ni comas Ej. 123456789";
   $arrAyuda['ciudadanoRegistrado']['entrada']['identificador']['nombre']      = "Identificador";
   $arrAyuda['ciudadanoRegistrado']['entrada']['identificador']['tipo']        = "Cadena de caracteres";
   $arrAyuda['ciudadanoRegistrado']['entrada']['identificador']['descripcion'] = "Obtenido en la identificacion";
   $arrAyuda['ciudadanoRegistrado']['salida']['cadena']['nombre']              = "Booleano";
   $arrAyuda['ciudadanoRegistrado']['salida']['cadena']['tipo']                = "tns:Boleano";
   $arrAyuda['ciudadanoRegistrado']['salida']['cadena']['descripcion']         = "<br>tns:Boleano->estado: Verdadero / Falso<br>tns:Boleano->Error: String Errores";
   
   $claSmarty->assign( "arrAyuda" , $arrAyuda );
   $claSmarty->display( "webservice/ayuda.tpl" );
   
?>
