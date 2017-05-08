<?php
   /**
    * CONTENIDO DEL POPUP DE AYUDA. OBTIENE CODIGO DE PROYECTO Y UNIDAD HABITACIONAL
    * @author Jaison Ospina
    * @version 1.0 Mayo de 2015
    **/

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );
	
	print_r("<iframe src='contenidos/actosAdministrativos/iframeProyectoUnidadHabitacional.php' frameborder='0' scrolling='auto' width='630' height='400'></iframe>");
?>