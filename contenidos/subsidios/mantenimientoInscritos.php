<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
	
    // Todas las modalidades
    $sql = "
    	SELECT seqModalidad, txtModalidad
    	FROM T_FRM_MODALIDAD
    	ORDER BY txtModalidad
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['nombre'] = $objRes->fields['txtModalidad'];
    	$objRes->MoveNext();
    }
    
    // Soluciones 
    $sql = " 
    	SELECT seqModalidad, seqSolucion, txtSolucion
    	FROM T_FRM_SOLUCION
    	ORDER BY seqSolucion
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['soluciones'][ $objRes->fields['seqSolucion'] ]['nombre'] = $objRes->fields['txtSolucion'];
    	$objRes->MoveNext();
    }
    
    // Valores del subsidio
    $sql = " 
    	SELECT seqModalidad, seqSolucion, valSubsidio
    	FROM T_FRM_VALOR_SUBSIDIO
    ";
	$objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrModalidad[ $objRes->fields['seqModalidad'] ]['soluciones'][ $objRes->fields['seqSolucion'] ]['valor'] = $objRes->fields['valSubsidio'];
    	$objRes->MoveNext();
    }   
    
    // Vaor del cierre financiero
    $claReportes = new Reportes();
    foreach( $arrModalidad as $seqModalidad => $arrSoluciones ){
    	foreach( $arrSoluciones['soluciones'] as $seqSolucion => $arrValores ){
    		$arrModalidad[ $seqModalidad ]['soluciones'][ $seqSolucion ]['cierre'] = $claReportes->valorCierreFinanciero( $seqModalidad , $seqSolucion );
    	}
    }
    
    // Cuantos hogares hay para repartir
    $sql = " 
    	SELECT
    		moa.seqModalidad,
			moa.txtModalidad,
			COUNT(1) as cuenta
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
		WHERE frm.seqEstadoProceso = 1
			AND hog.seqParentesco = 1
		GROUP BY moa.txtModalidad
		ORDER BY moa.txtModalidad
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
    	$arrInscritos[ $objRes->fields['seqModalidad'] ]['nombre'] = $objRes->fields['txtModalidad'];
    	$arrInscritos[ $objRes->fields['seqModalidad'] ]['inscritos'] = $objRes->fields['cuenta'];
    	$objRes->MoveNext();
    }  

    $claSmarty->assign( "arrInscritos" , $arrInscritos );
    $claSmarty->assign( "arrModalidad" , $arrModalidad );
    $claSmarty->assign( "valSalarioMinimo" , $arrConfiguracion['constantes']['salarioMinimo'] );
	$claSmarty->display( "subsidios/mantenimientoInscritos.tpl" );

?>
