<?php

	/**
	 * EXPORTA A UN ARCHIVO EL CONTENIDO
	 * DEL ACTO ADMINISTRATIVO QUE VIENE POR PARAMETRO
	 * @author Bernardo Zerda
	 * @param POST => numActo
	 * @param POST => fchActo
	 * @version 1.0 Abril 2010 
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );	 

	$claActo = new ActoAdministrativo;
	$arrListadoActos = $claActo->listarActos();
	
	// Nombre del archivo exportable
	$txtNombreArchivo = ""; 
	foreach( $arrListadoActos as $arrActo ){
		if( $_POST['numActo'] == $arrActo[ 'numActo' ] and $_POST['fchActo'] == $arrActo[ 'fchActo' ] ){
			$seqTipoActo = $arrActo[ 'seqTipoActo' ];
			$txtNombreArchivo = ereg_replace( " " , "" , $arrActo[ 'txtTipoActo' ] ) . "_" . $arrActo[ 'numActo' ] . "_" . $arrActo[ 'fchActo' ] . ".xls";
			break;  
		}
	}
	
	header("Content-disposition: attachment; filename=$txtNombreArchivo");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");	
	
	$txtArchivo = "";
	if( $txtNombreArchivo != "" ){
		
		$arrActo = $claActo->cargarActoAdministrativoNumero( $seqTipoActo , $_POST['numActo'] , $_POST['fchActo'] );
		
		$txtArchivo = "";
		foreach( $arrActo as $arrLinea ){
			$txtArchivo .= implode( "\t" , $arrLinea ) . "\r\n";
		}
		
	} else {
		$txtArchivo = "No se encuentra el acto administrativo " . $_POST['numActo'] . " con fecha " . $_POST['fchActo'] ."\r\n";
	}	 
	
	echo $txtArchivo;
	
?>
