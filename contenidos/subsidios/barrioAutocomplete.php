<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	// Obtiene los datos 
	$seqLocalidad = $_GET['seqLocalidad'];
	$txtConsulta = strtolower( trim( $_GET['query'] ) );
	unset( $_GET );
	
	// resultados para el autocomplete
	$arrResultados = array();

	// consulta los barrios segun localidad
	try {
		$sql = "
			SELECT txtBarrio 
			FROM T_FRM_BARRIO 
			WHERE seqLocalidad = $seqLocalidad 
			  AND txtBarrio LIKE '%$txtConsulta%' 
			ORDER BY txtBarrio
		";
		$objRes = $aptBd->execute( $sql );		
		while( $objRes->fields ){
			$arrResultados[] = $objRes->fields['txtBarrio'];
			$objRes->MoveNext();	
		}
	} catch (  Exception $objError ){
		$arrResultados = array();
	}	
	
	// Despliega los resultados
	echo implode( "\n" , $arrResultados );
		
?>
