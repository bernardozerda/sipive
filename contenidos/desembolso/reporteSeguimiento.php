<?php


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

	// Tipos de documento
	$sql = "
		SELECT 
			seqTipoDocumento,
			txtTipoDocumento
		FROM 
			T_CIU_TIPO_DOCUMENTO
		ORDER BY
			txtTipoDocumento
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrTipoDocumento[ $objRes->fields['seqTipoDocumento'] ] = $objRes->fields['txtTipoDocumento'];
		$objRes->MoveNext();
	}

	// Parentesco
	$sql = "
		SELECT 
			seqParentesco,
			txtParentesco
		FROM 
			T_CIU_PARENTESCO
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrParentesco[ $objRes->fields['seqParentesco'] ] = $objRes->fields['seqParentesco'] . " - " .$objRes->fields['txtParentesco'];
		$objRes->MoveNext();
	}

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
	
	// Orden de las fases de desembolso
	$arrOrdenFases['Busqueda de la Oferta']   = 1;
	$arrOrdenFases['Revisión Jurídica']       = 2;
	$arrOrdenFases['Revisión Técnica']	      = 3;
	$arrOrdenFases['Escrituración']           = 4;
	$arrOrdenFases['Estudio de Titulos']      = 5;
	$arrOrdenFases['Solicitud de Desembolso'] = 6;
	
	// Para cada fase del proceso existe una posibilidad de regreso en el proceso
	// los numeros son los identificadores del estado del proceso correspondiente
	// $arrFasesRetorno['Fase Desembolso'][] = 19; <-- Identificador (seqEstadoProceso) de retorno
	$arrFasesRetorno['Revisión Jurídica'][]       = 15; // Asignado - Asignado
	$arrFasesRetorno['Revisión Jurídica'][]       = 19; // Desembolso - Busqueda Oferta
	$arrFasesRetorno['Revisión Técnica'][]        = 15; // Asignado - Asignado
	$arrFasesRetorno['Revisión Técnica'][]        = 19; // Desembolso - Busqueda Oferta
	$arrFasesRetorno['Escrituración'][]           = 15; // Asignado - Asignado
	$arrFasesRetorno['Estudio de Titulos'][]      = 15; // Asignado - Asignado
	$arrFasesRetorno['Estudio de Titulos'][] 	  = 19; // Desembolso - Busqueda Oferta
	$arrFasesRetorno['Estudio de Titulos'][]      = 27; // Desembolso - Escrituracion
	$arrFasesRetorno['Solicitud de Desembolso'][] = 19; // Desembolso - Busqueda Oferta
	$arrFasesRetorno['Solicitud de Desembolso'][] = 28; // Desembolso - Estudio de Titulos
	
	// Aqui para cada fase de desembolso se definen los estados hacia los cuales se puede
	// avanzar, la plantilla smaty que se usa para mostrar los datos, el codigo php que responde 
	// la peticion y la funcion que imprime el formulario
	$arrFasesDesembolso['Busqueda de la Oferta']['estados'][] = 15; // Asignacion - Asignado
	$arrFasesDesembolso['Busqueda de la Oferta']['estados'][] = 19; // Desembolso - Busqueda Oferta
	$arrFasesDesembolso['Busqueda de la Oferta']['estados'][] = 22; // Desembolso - Estudio de Predio
	$arrFasesDesembolso['Busqueda de la Oferta']['estados'][] = 28; // Desembolso - Estudio de Titulos
	$arrFasesDesembolso['Busqueda de la Oferta']['estados'][] = 30; // Desembolso - Solicitud de desembolso
	$arrFasesDesembolso['Busqueda de la Oferta']['plantilla'] = "desembolso/busquedaOferta.tpl";
	$arrFasesDesembolso['Busqueda de la Oferta']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
	$arrFasesDesembolso['Busqueda de la Oferta']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario );";
	
	$arrFasesDesembolso['Revisión Jurídica']['estados'][] = 22; // Desembolso - Estudio de Predio
	$arrFasesDesembolso['Revisión Jurídica']['estados'][] = 24; // Desembolso - Revision juridica aprovada
	$arrFasesDesembolso['Revisión Jurídica']['plantilla'] = "desembolso/revisionJuridica.tpl";
	$arrFasesDesembolso['Revisión Jurídica']['codigo']    = "./contenidos/desembolso/revisionJuridica.php";
	$arrFasesDesembolso['Revisión Jurídica']['imprimir']  = "desembolsoRevisionJuridica( $seqFormulario )";
	
	$arrFasesDesembolso['Revisión Técnica']['estados'][] = 24; // Desembolso - Revision juridica aprovada
	$arrFasesDesembolso['Revisión Técnica']['estados'][] = 26; // Desembolso - Revision tecnica aprovada
	$arrFasesDesembolso['Revisión Técnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
	$arrFasesDesembolso['Revisión Técnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
	$arrFasesDesembolso['Revisión Técnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario )"; 
	
	$arrFasesDesembolso['Escrituración']['estados'][] = 26; // Desembolso - Revision tecnica aprovada
	$arrFasesDesembolso['Escrituración']['estados'][] = 27; // Desembolso - Escrituracion
	$arrFasesDesembolso['Escrituración']['estados'][] = 28; // Desembolso - Estudio de Titulos
	$arrFasesDesembolso['Escrituración']['plantilla'] = "desembolso/busquedaOferta.tpl";
	$arrFasesDesembolso['Escrituración']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
	$arrFasesDesembolso['Escrituración']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario )";
	
	$arrFasesDesembolso['Estudio de Titulos']['estados'][] = 28; // Desembolso - Estudio de Titulos
	$arrFasesDesembolso['Estudio de Titulos']['estados'][] = 29; // Desembolso - Estudio de Titulos aprobado
	$arrFasesDesembolso['Estudio de Titulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
	$arrFasesDesembolso['Estudio de Titulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
	$arrFasesDesembolso['Estudio de Titulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario )";
	
	$arrFasesDesembolso['Solicitud de Desembolso']['estados'][] = 29; // Desembolso - Estudio de Titulos aprobado
	$arrFasesDesembolso['Solicitud de Desembolso']['estados'][] = 30; // Desembolso - Solicitud de desembolso
	$arrFasesDesembolso['Solicitud de Desembolso']['estados'][] = 32; // Desembolso - Parcial
	$arrFasesDesembolso['Solicitud de Desembolso']['estados'][] = 33; // Desembolso - Total
	$arrFasesDesembolso['Solicitud de Desembolso']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
	$arrFasesDesembolso['Solicitud de Desembolso']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
	
	$arrEstadosAvance 	= &$arrFasesDesembolso[ "Busqueda de la Oferta" ][ "estados" ];
	$seqModalidad 		= $claFormulario->seqModalidad;
	
	// Estados de Avance para "Busqueda de la Oferta"
	switch( $seqModalidad ){
		
		case 1: // ADQUISICION
			foreach( $arrEstadosAvance as $numLlave => $seqEstadoProceso ){
				if( 
					$seqEstadoProceso == 28 	// Desembolso - Estudio de Titulos
					or $seqEstadoProceso == 30 	// Desembolso - Solicitud de desembolso
				){
					unset( $arrEstadosAvance[ $numLlave ] );
				}
			}
			break;
		
		case 3: // MEJORAMIENTO
		case 4:
			foreach( $arrEstadosAvance as $numLlave => $seqEstadoProceso ){
				if( $seqEstadoProceso == 28 ){ // Desembolso - Estudio de Titulos
					unset( $arrEstadosAvance[ $numLlave ] );
				}
			}
			break;
		
		case 5: // ARRENDAMIENTO
			foreach( $arrEstadosAvance as $numLlave => $seqEstadoProceso ){
				if( 
					$seqEstadoProceso == 22 	// Desembolso - Estudio de Predio
					or $seqEstadoProceso == 30 	// Desembolso - Solicitud de desembolso
				){
					unset( $arrEstadosAvance[ $numLlave ] );
				}
			}
			break;
	}
	
	
	$arrFasesRetornoEstudioTitulos = &$arrFasesRetorno[ "Estudio de Titulos" ];
	switch( $seqModalidad ){
		
		case 5: // ARRENDAMIENTO
			foreach( $arrFasesRetornoEstudioTitulos as $numLlave => $seqEstadoProceso ){
				if( $seqEstadoProceso == 27 ){ // Desembolso - Escrituracion
					unset( $arrFasesRetornoEstudioTitulos[ $numLlave ] );
				}
			}
			break;
		
	}
	
	// todas las variables recogidas se pasan directamente al smarty para ser usadas
	$claSmarty->assign( "arrFasesRetorno"        , $arrFasesRetorno   					);
	$claSmarty->assign( "arrOrdenFases"          , $arrOrdenFases     					);
	$claSmarty->assign( "arrModalidad"           , $arrModalidad      					);
	$claSmarty->assign( "arrSolucion"            , $arrSolucion       					);
	$claSmarty->assign( "arrLocalidad"           , $arrLocalidad      					);
	$claSmarty->assign( "arrTipoDocumento"       , $arrTipoDocumento  					);
	$claSmarty->assign( "arrParentesco"          , $arrParentesco     					);
	$claSmarty->assign( "arrBanco"               , $arrBanco          					);
	$claSmarty->assign( "arrDonantes"            , $arrDonantes       					);	
	$claSmarty->assign( "arrFasesDesembolso"     , $arrFasesDesembolso 					);
	$claSmarty->assign( "arrGrupoGestion"        , $arrGrupoGestion      			  	);
	$claSmarty->assign( "arrProyectos"           , $arrProyectos       				  	);
	$claSmarty->assign( "arrSolucionDescripcion" , $arrSolucionDescripcion 			  	);
	$claSmarty->assign( "bolPermisoEditar"       , $_SESSION['privilegios']['editar'] 	);

?>
