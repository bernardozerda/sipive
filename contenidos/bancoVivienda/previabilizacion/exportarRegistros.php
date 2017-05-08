<?php

	/**
 	 * EXPORTA LOS ARCHIVOS DEL BANCO DE VIVIENDA
 	 * @author Bernardo Zerda
 	 * @version 1.0 Dec 15, 2010 
	 **/

	$txtPrefijoRuta = "../../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "BancoVivienda.class.php" );

	$txtSeparador = "\t";
	$txtSalto     = "\r\n";
	
	$bolCondiciones = ( isset( $_POST['condiciones'] ) )? false : true;
	
	$claInmueble = new Inmueble;
	$arrViviendas = $claInmueble->obtenerViviendas( $_POST['seqEstadoProceso'] , $_POST['fchCreacionDesde'] , $_POST['fchCreacionHasta'] , $bolCondiciones );

	$txtArchivo = "";
	foreach( $arrViviendas as $seqVivienda => $arrDatos ){
		$txtArchivo = ( trim( $txtArchivo ) == "" )? implode( $txtSeparador , array_keys( $arrDatos ) ) . $txtSalto : $txtArchivo;
		$txtArchivo.= implode( $txtSeparador , $arrDatos ) . $txtSalto;
	}

	header("Content-disposition: attachment; filename=BV_" . date("Ymd_His") . ".xls");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");	
	
	echo $txtArchivo;	

?>
