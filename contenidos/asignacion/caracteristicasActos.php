<?php

	/**
	 * INICIO DE LA PANTALLA DE ASIGNACION
	 * @author Bernardo Zerda
	 * @version 1.0 Febrero de 2010
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );

 	// Clase de actos administrativos ( para los tipos de actos)
 	$claTipoActo = new TipoActoAdministrativo;
	
	// Carga el tipo de acto seleccionado
	$claTipoActo->cargarTipoActo( $_POST['tipo'] );
	
	// Platillas y variables
 	$claSmarty->assign( "claTipoActo" , $claTipoActo );
	$claSmarty->display( "asignacion/caracteristicasActos.tpl" );
	
?>
