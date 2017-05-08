<?php

	/**
	 * DENTRO DE SU CODIGO FUENTE INCLUYA ESTE ARCHIVO PARA
	 * DECLARAR E INSTANCIAR LO QUE RESPECTA A LA LIBRERIA SMARTY
	 * 
	 * REQUIERE QUE ANTES INCLUYA LA LECTURA DEL ARCHIVO DE CONFIGURACION
	 * 
	 * @author Bernardo Zerda
	 * @version 0.1 Marzo de 2009
	 */
	
	// Si la configuracion esta vacia sale de inmediato
	if( ( ! isset( $arrConfiguracion ) ) or empty( $arrConfiguracion ) ){
		exit(0);
	}
	
	// La ruta por defecto es la local
	if( ! isset( $txtPrefijoRuta ) or $txtPrefijoRuta == "" ){
		$txtPrefijoRuta = "./";
	}
	
	// Inclusion de la libreria
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['smarty'] . $arrConfiguracion['archivos']['smarty'] );
	
	// Configuracion de la clase
	$claSmarty = new Smarty();
	$claSmarty->template_dir = $txtPrefijoRuta . "plantillas";
	$claSmarty->compile_dir  = $txtPrefijoRuta . $arrConfiguracion['librerias']['smarty'] . "templates_c";
	$claSmarty->cache_dir    = $txtPrefijoRuta . $arrConfiguracion['librerias']['smarty'] . "cache";
	$claSmarty->config_dir   = $txtPrefijoRuta . $arrConfiguracion['librerias']['smarty'] . "configs";
	 
?>
