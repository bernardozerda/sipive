<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["clases"] . "ProyectoVivienda.class.php" );
    //include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );

	//include( "../desembolso/datosComunes.php" );	
	
	$txtParametro = ereg_replace( " " , "%" , trim( $_GET["query"] ) );
	while( strpos( $txtParametro , "%%" ) !== false ){
		$txtParametro = ereg_replace( "%%" , "%" , $txtParametro );
	}

	$claProyectoVivienda = new ProyectoVivienda();
	$arrProyectoVivienda = $claProyectoVivienda->buscarNombreProyecto( $txtParametro ); 
/*
	if( ! empty( $arrProyectoVivienda ) ){
		foreach( $arrProyectoVivienda as $seqProyecto => $arrInformacion ){
			//echo implode( "\t" , $arrInformacion ) . "\n";
			echo $seqProyecto . "\t" . $arrInformacion . "\n";
		}
	}else{
		echo "No se encontraron resultados para \"". ereg_replace( "%" , " " , $txtParametro ) ."\"\t\n";
	}
*/
	// GRUPO GESTION ADMINISTRADOR
	$arrGrupoGestionAdministrador[] = 15;
	$arrGrupoGestionAdministrador[] = 5;
	$arrGrupoGestionAdministrador[] = 10;
	$arrGrupoGestionAdministrador[] = 12;
	$arrGrupoGestionAdministrador[] = 17;
	$arrGrupoGestionAdministrador[] = 20;
	$arrGrupoGestionAdministrador[] = 14;

	// Grupos de gestion
	$sql = "
			SELECT
				seqGrupoGestion,
				txtGrupoGestion
			FROM
				T_SEG_GRUPO_GESTION_PROYECTOS
			WHERE
				seqGrupoGestion NOT IN (" . implode(',', $arrGrupoGestionAdministrador) . ")
			ORDER BY
				txtGrupoGestion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrGrupoGestion[$objRes->fields['seqGrupoGestion']] = $objRes->fields['txtGrupoGestion'];
		$objRes->MoveNext();
	}

	// Estados del proceso
	$sql = "
			SELECT
				seqPryEstadoProceso,
				txtPryEstadoProceso
			FROM
				T_PRY_ESTADO_PROCESO
			ORDER BY
				seqPryEstadoProceso
			";

	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrPryEstados[ $objRes->fields['seqPryEstadoProceso'] ] = $objRes->fields['txtPryEstadoProceso'];
		$objRes->MoveNext();
	}

	$claSmarty->assign("arrGrupos", 		$_SESSION['arrGrupos']);
	$claSmarty->assign("arrGrupoGestion", 	$arrGrupoGestion);
	$claSmarty->assign( "arrPryEstados" , $arrPryEstados );
	$claSmarty->display( "proyectos/cambioEstadosProyecto.tpl" );
?>