<?php
  
  /**
   * ESTE ES EL ARCHIVO PRINCIPAL DEL PANEL DE CONTROL
   * A ESTE SITIO ES REDIRECCIONADO EL USUARIO SUPERADMINISTRADOR
   * Y NINGUNO OTRO. ( ver autenticacion.php )
   * @author Bernardo Zerda
   * @version 1.0 Abril 2009
   */
  
  // Inclusiones necesarias
	include( "./recursos/archivos/verificarSesion.php" );
	include( "./recursos/archivos/lecturaConfiguracion.php" );
	include( $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	
	$claSmarty->assign( "txtRutaImagenes"  , $arrConfiguracion['carpetas']['imagenes'] );

    // Plantilla a mostrar
	$claSmarty->display( "panelControl.tpl" );
	
?>
