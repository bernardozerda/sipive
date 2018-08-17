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
   
   
   $claSmarty->display( "webservice/terminos.tpl" );
?>
