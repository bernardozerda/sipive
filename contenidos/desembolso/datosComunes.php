<?php
    
	// Lenguaje para la conversion de fechas
    date_default_timezone_set("America/Bogota");
	setlocale(LC_TIME, 'spanish');

	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FlujoDesembolsos.class.php" );


	// Modalidades de subsidio
	$sql = "
		SELECT 
			seqModalidad,
			txtModalidad
		FROM 
			T_FRM_MODALIDAD
		ORDER BY
			txtModalidad
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrModalidad[ $objRes->fields['seqModalidad'] ] = $objRes->fields['txtModalidad'];
		$objRes->MoveNext();
	}		

	// Soluciones 
	$sql = "
		SELECT
			seqModalidad, 
			seqSolucion,
			txtSolucion
		FROM 
			T_FRM_SOLUCION
		
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSolucion[ $objRes->fields['seqModalidad'] ][ $objRes->fields['seqSolucion'] ] = $objRes->fields['txtSolucion'];
		$objRes->MoveNext();
	}		

	// Solucion con Descripcion
	$sql = "
		SELECT
			seqModalidad, 
			seqSolucion,
			ucwords(txtDescripcion) as txtDescripcion
		FROM 
			T_FRM_SOLUCION
		
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSolucionDescripcion[ $objRes->fields['seqModalidad'] ][ $objRes->fields['seqSolucion'] ] = $objRes->fields['txtDescripcion'];
		$objRes->MoveNext();
	}	

	// Localidad
	$sql = "
		SELECT 
			seqLocalidad,
			txtLocalidad
		FROM 
			T_FRM_LOCALIDAD
		WHERE seqLocalidad > 1
		ORDER BY 
			txtLocalidad
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrLocalidad[ $objRes->fields['seqLocalidad'] ] = $objRes->fields['txtLocalidad'];
		$objRes->MoveNext();
	}
    
    //Barrio
    $sql = "
			SELECT 
				seqBarrio,
				txtBarrio
			FROM 
				T_FRM_BARRIO
			ORDER BY 
				txtBarrio
		";
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrBarrio[$objRes->fields['seqBarrio']] = $objRes->fields['txtBarrio'];
        $objRes->MoveNext();
    }
    
	// Tipos de documento
	$sql = "
		SELECT 
			seqTipoDocumento,
			txtTipoDocumento
		FROM 
			T_CIU_TIPO_DOCUMENTO
		WHERE
			seqTipoDocumento NOT IN (8)
		ORDER BY
			txtTipoDocumento
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrTipoDocumento[ $objRes->fields['seqTipoDocumento'] ] = $objRes->fields['txtTipoDocumento'];
		$objRes->MoveNext();
	}

	// Parentesco
//	$sql = "
//		SELECT
//			seqParentesco,
//			txtParentesco
//		FROM
//			T_CIU_PARENTESCO
//	";
//	$objRes = $aptBd->execute( $sql );
//	while( $objRes->fields ){
//		$arrParentesco[ $objRes->fields['seqParentesco'] ] = $objRes->fields['seqParentesco'] . " - " .$objRes->fields['txtParentesco'];
//		$objRes->MoveNext();
//	}
	$arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "bolActivo DESC, txtParentesco");

	// Bancos
	$sql = "
		SELECT 
			seqBanco,
			txtBanco
		FROM 
			T_FRM_BANCO
		ORDER BY
			txtBanco
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrBanco[ $objRes->fields['seqBanco'] ] = $objRes->fields['txtBanco'];
		$objRes->MoveNext();
	}

	// Empresas donantes
	$sql = "
		SELECT
			seqEmpresaDonante,
			txtEmpresaDonante
		FROM 
			T_FRM_EMPRESA_DONANTE
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrDonantes[ $objRes->fields['seqEmpresaDonante'] ] = $objRes->fields['txtEmpresaDonante'];
		$objRes->MoveNext();
	}

	// periodos
	$sql = "
	SELECT 
		seqPeriodo,
		numResolucionIndependientes,
		fchResolucionIndependietnes,
		numResolucionDesplazados,
		fchResolucionDesplazados
	FROM 
		T_FRM_PERIODO
	";	
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrPeriodos[ $objRes->fields['seqPeriodo'] ]['independientes']['numero'] = $objRes->fields['numResolucionIndependientes'];
		$arrPeriodos[ $objRes->fields['seqPeriodo'] ]['independientes']['fecha']  = $objRes->fields['fchResolucionIndependietnes'];
		$arrPeriodos[ $objRes->fields['seqPeriodo'] ]['desplazado']['numero']     = $objRes->fields['numResolucionDesplazados'];
		$arrPeriodos[ $objRes->fields['seqPeriodo'] ]['desplazado']['fecha']      = $objRes->fields['fchResolucionDesplazados'];
		$objRes->MoveNext();
	}
	
	// estos son identificadores de los grupos de gestion
	// reservador para el grupo de administracion que no 
	// se deben mostrar como opcion para los usuarios
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

/*	
	// Proyectos de la CVP para hogares de mejoramiento
	$sql = "
		SELECT 
		  pro.seqModalidad,
		  pro.seqProyecto,
		  pro.txtNombre
		FROM T_FRM_PROYECTO pro	
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$seqModalidad = $objRes->fields['seqModalidad'];
		$seqProyecto  = $objRes->fields['seqProyecto'];
		$txtProyecto  = $objRes->fields['txtNombre'];
		$arrProyectos[ $seqModalidad ][ $seqProyecto ] = $txtProyecto;
		$objRes->MoveNext();
	}
*/

// Proyectos para la impresion de estudios tecnicos 16FEB2016 JCBR
	$sql = "
		SELECT seqProyecto, txtNombreComercial FROM t_pry_proyecto";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){		
		$seqProyecto  = $objRes->fields['seqProyecto'];
		$txtProyecto  = $objRes->fields['txtNombreComercial'];
		$arrProyectos[ $seqProyecto ] = $txtProyecto;
		$objRes->MoveNext();
	}

    // Ciudad
    $sql = "
		(SELECT 
		  seqCiudad,
		  concat(txtDepartamento ,' - ', txtCiudad) as txtCiudad
		FROM T_FRM_CIUDAD
		WHERE seqCiudad = 149
		ORDER BY txtCiudad)
		UNION
		(SELECT 
			seqCiudad,
			concat(txtDepartamento ,' - ', txtCiudad) as txtCiudad
		FROM T_FRM_CIUDAD
		WHERE seqCiudad <> 149
		ORDER BY txtCiudad)
	";
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrCiudad[$objRes->fields['seqCiudad']] = $objRes->fields['txtCiudad'];
        $objRes->MoveNext();
    }
    

	// Estados del proceso para desembolsos	
	$arrEstadosDesembolso = estadosProceso( 15 );
	$arrEstados = $arrEstadosDesembolso + estadosProceso( 0 , 5 );
	
/************************************************************************************************************
 * EN LA CLASE FLUJODESEMBOLSOS ESTA LA SECUENCIA DE LOS FLUJOS
 ************************************************************************************************************/
    if( ( intval( $seqFormulario ) != 0 ) or ( class_exists( "FormularioSubsidios" ) and intval( $_POST['seqFormulario'] ) != 0 ) ){
        $seqFormulario = ( intval( $seqFormulario ) == 0 )? $_POST['seqFormulario'] : $seqFormulario;
        $claFlujoDesembolsos = new FlujoDesembolso( $seqFormulario );
    }
/*
	$claSmarty->assign( "arrDonantes"            , $arrDonantes       					);	
	$claSmarty->assign( "arrFasesDesembolso"     , $arrFasesDesembolso 					);	
	$claSmarty->assign( "arrProyectos"           , $arrProyectos       				  	);
*/
    
	$claSmarty->assign( "arrGrupoGestion"        , $arrGrupoGestion );
	$claSmarty->assign( "arrBarrio"              , $arrBarrio );
	$claSmarty->assign( "arrEstados"             , $arrEstados );
	$claSmarty->assign( "arrModalidad"           , $arrModalidad );
	$claSmarty->assign( "arrSolucion"            , $arrSolucion );
	$claSmarty->assign( "arrLocalidad"           , $arrLocalidad );
	$claSmarty->assign( "arrParentesco"          , $arrParentesco );
	$claSmarty->assign( "arrTipoDocumento"       , $arrTipoDocumento );
	$claSmarty->assign( "arrSolucionDescripcion" , $arrSolucionDescripcion );
    $claSmarty->assign( "arrBanco"               , $arrBanco ); // para la plantilla de solicitud de desembolso
    $claSmarty->assign( "arrCiudad"              , $arrCiudad ); // Ciudades para las direcciones
	$claSmarty->assign( "claFlujoDesembolsos"    , $claFlujoDesembolsos ); // Determina las fases y el flujo de los datos
	$claSmarty->assign( "arrProyectos"           , $arrProyectos);//para el formato de impresion tecnica.
?>
