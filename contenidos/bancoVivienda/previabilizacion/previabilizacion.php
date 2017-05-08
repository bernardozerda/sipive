<?php

	/**
 	 * FORMULARIO PARA LA PREVIABILIZACION
 	 * DE LAS VIVIENDAS DEL BVU
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

	$claGenerales = new Generales;
	
	try {
		$sql = "
			SELECT
			  numVisitasInicio,
			  numVisitasBusqueda,
			  ( 
			    SELECT COUNT(1)
			    FROM T_BVU_INTERESADO
			  ) as numInteresados
			FROM T_BVU_VISITAS
		";
		$objRes = $aptBd->execute( $sql );
		if( $objRes->fields ){
			$numVisitasInicio = $objRes->fields['numVisitasInicio'];
			$numVisitasBusqueda = $objRes->fields['numVisitasBusqueda'];
			$numInteresados = $objRes->fields['numInteresados'];
		}
	} catch ( Exception $objError ){
		$numVisitasInicio = 0;
		$numVisitasBusqueda = 0;
		$numInteresados = 0;
	}
	
	$claSmarty->assign( "numVisitasInicio" , $numVisitasInicio );
	$claSmarty->assign( "numVisitasBusqueda" , $numVisitasBusqueda );
	$claSmarty->assign( "numInteresados" , $numInteresados );
	
	$claSmarty->assign( "claGenerales" , $claGenerales );
	$claSmarty->display( "bancoVivienda/previabilizacion/previabilizacion.tpl" );
	
	
?>
