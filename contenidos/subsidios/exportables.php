<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	setlocale(LC_TIME, 'spanish');
	
	$sql = "
		SELECT SUBSTRING(fchPostulacion,1,10) as fecha
		FROM T_FRM_FORMULARIO
		GROUP BY 1
		ORDER BY 1 desc
	";
	
	
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		
		list($ano, $mes, $dia ) = split( '[/.-]',$objRes->fields['fecha'] );
		
		$unixTime = mktime(0,0,0,$mes,$dia,$ano);
		
		$txtDia = utf8_encode( strftime( "%A" , $unixTime ) );
		$arrPostulacion[ $objRes->fields['fecha'] ] = $objRes->fields['fecha']. " [ " . $txtDia . " ]";
		
		$objRes->MoveNext();
	}
	
	$sql = "
		SELECT SUBSTRING(fchInscripcion,1,10) as fecha
		FROM T_FRM_FORMULARIO
		WHERE seqEstadoProceso = 1
		GROUP BY 1
		ORDER BY 1 DESC
	";
	
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		
		list($ano, $mes, $dia ) = split( '[/.-]',$objRes->fields['fecha'] );
		$unixTime = mktime(0,0,0,$mes,$dia,$ano);
		
		$txtDia = utf8_encode( strftime( "%A" , $unixTime ) );
		$arrInscripcion[ $objRes->fields['fecha'] ] = $objRes->fields['fecha']. " [ " . $txtDia . " ]";
		
		$objRes->MoveNext();
	}
	
	$arrGrupoGestionAdministrador[] = 15;
	$arrGrupoGestionAdministrador[] = 5;
	$arrGrupoGestionAdministrador[] = 10;
	$arrGrupoGestionAdministrador[] = 12;
	
		
	// Grupos de gestion
	$sql = "
		SELECT 
			seqGrupoGestion,
			txtGrupoGestion
		FROM 
			T_SEG_GRUPO_GESTION
		WHERE 
			seqGrupoGestion not in (". implode(',', $arrGrupoGestionAdministrador) .")
		ORDER BY 
			txtGrupoGestion
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrGrupoGestion[ $objRes->fields['seqGrupoGestion'] ] = $objRes->fields['txtGrupoGestion'];
		$objRes->MoveNext();
	}
	
	$claSmarty->assign( "arrGrupoGestion", $arrGrupoGestion );
	$claSmarty->assign( "arrPostulacion" , $arrPostulacion );
	$claSmarty->assign( "arrInscripcion" , $arrInscripcion );
	$claSmarty->display( "subsidios/exportables.tpl" );

?>
