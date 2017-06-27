<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );	
    
	setlocale(LC_TIME, 'America/Bogota');
	$txtFecha = ucwords( strftime("%A %#d de %B del %Y") ) ." " . date( "H:i:s" ); 
	
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
		$arrParentesco[ $objRes->fields['seqParentesco'] ] = $objRes->fields['txtParentesco'];
		$objRes->MoveNext();
	}
	
	// Condicion Especial
	$sql = "
		SELECT 
			seqCondicionEspecial,
			txtCondicionEspecial
		FROM 
			T_CIU_CONDICION_ESPECIAL
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrCondicionEspecial[ $objRes->fields['seqCondicionEspecial'] ] = $objRes->fields['txtCondicionEspecial'];
		$objRes->MoveNext();
	}	

	// Estado Civil
	$sql = "
		SELECT 
			seqEstadoCivil,
			txtEstadoCivil
		FROM 
			T_CIU_ESTADO_CIVIL
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrEstadoCivil[ $objRes->fields['seqEstadoCivil'] ] = $objRes->fields['txtEstadoCivil'];
		$objRes->MoveNext();
	}

	// Sexo
	$sql = "
		SELECT 
			seqSexo,
			txtSexo
		FROM 
			T_CIU_SEXO
		ORDER BY
			txtSexo
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSexo[ $objRes->fields['seqSexo'] ] = $objRes->fields['txtSexo'];
		$objRes->MoveNext();
	}

	// Ocupacion
	$sql = "
		SELECT 
			seqOcupacion,
			txtOcupacion
		FROM 
			T_CIU_OCUPACION
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrOcupacion[ $objRes->fields['seqOcupacion'] ] = $objRes->fields['txtOcupacion'];
		$objRes->MoveNext();
	}

	// Nivel Educativo
	$sql = "
		SELECT 
			seqNivelEducativo,
			txtNivelEducativo
		FROM 
			T_CIU_NIVEL_EDUCATIVO
		
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrNivelEducativo[ $objRes->fields['seqNivelEducativo'] ] = $objRes->fields['txtNivelEducativo'];
		$objRes->MoveNext();
	}

	// Condicion Etnica
	$sql = "
		SELECT 
			seqEtnia,
			txtEtnia
		FROM 
			T_CIU_ETNIA
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrCondicionEtnica[ $objRes->fields['seqEtnia'] ] = $objRes->fields['txtEtnia'];
		$objRes->MoveNext();
	}

	// Cajas de compensacion
	$sql = "
		SELECT 
			seqCajaCompensacion,
			txtCajaCompensacion
		FROM 
			T_CIU_CAJA_COMPENSACION
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrCajaCompensacion[ $objRes->fields['seqCajaCompensacion'] ] = $objRes->fields['txtCajaCompensacion'];
		$objRes->MoveNext();
	}
	
	// Salud
	$sql = "
		SELECT 
			seqSalud,
			txtSalud
		FROM 
			T_CIU_SALUD
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSalud[ $objRes->fields['seqSalud'] ] = $objRes->fields['txtSalud'];
		$objRes->MoveNext();
	}

	// Sisben
	$sql = "
		SELECT 
			seqSisben,
			txtSisben
		FROM 
			T_FRM_SISBEN
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrSisben[ $objRes->fields['seqSisben'] ] = $objRes->fields['txtSisben'];
		$objRes->MoveNext();
	}
        
        // Barrio
	$sql = "
		SELECT 
			seqBarrio,
			txtBarrio
		FROM 
			T_FRM_BARRIO
		ORDER BY 
			txtBarrio
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrBarrio[ $objRes->fields['seqBarrio'] ] = $objRes->fields['txtBarrio']; 
		$objRes->MoveNext();
	}	

	// Localidad
	$sql = "
		SELECT 
			seqLocalidad,
			txtLocalidad
		FROM 
			T_FRM_LOCALIDAD
		ORDER BY 
			txtLocalidad
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrLocalidad[ $objRes->fields['seqLocalidad'] ] = trim( substr( $objRes->fields['txtLocalidad'], strpos( $objRes->fields['txtLocalidad'] , "-" ) + 1 ) ); 
		$objRes->MoveNext();
	}	

	// Vivienda arrendada o propia
	$sql = "
		SELECT 
			seqVivienda,
			txtVivienda
		FROM 
			T_FRM_VIVIENDA
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrVivienda[ $objRes->fields['seqVivienda'] ] = $objRes->fields['txtVivienda'];
		$objRes->MoveNext();
	}

	// Modalidad de subsidio
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

	// Solucion
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

	// Proyectos 
	/*$sql = "
		SELECT
			seqProyecto,
			seqModalidad,
			txtNombre
		FROM 
			T_FRM_PROYECTO
	";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrProyecto[ $objRes->fields['seqModalidad'] ][ $objRes->fields['seqProyecto'] ] = $objRes->fields['txtNombre'];
		$objRes->MoveNext();
	}*/
	
	$arrProyecto = obtenerDatosTabla("T_PRY_PROYECTO", array("seqProyecto", "txtNombreProyecto"), "seqProyecto", "", "txtNombreProyecto");
	//$arrProyectoBp = obtenerDatosTabla("T_FRM_PROYECTO", array("seqProyecto", "txtNombre"), "seqProyecto", "", "txtNombre");

	// Bancos
	$sql = "
		SELECT 
			seqBanco,
			txtBanco
		FROM 
			T_FRM_BANCO
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

	$idFormulario = $_GET['seqFormulario'];
	// Unidades de Proyecto
	$sql = "SELECT txtNombreUnidad 
			FROM 
				T_FRM_FORMULARIO 
			INNER JOIN 
				T_PRY_UNIDAD_PROYECTO ON (T_FRM_FORMULARIO.seqUnidadProyecto = T_PRY_UNIDAD_PROYECTO.seqUnidadProyecto)
			WHERE
				T_FRM_FORMULARIO.seqFormulario = $idFormulario";
	$exeSql = mysql_query($sql);
	$rowSql = mysql_fetch_array($exeSql);
	$nombreUnidadProyecto = $rowSql['txtNombreUnidad'];
	
	// Conjunto Residencial
	$sql = "SELECT 
				txtNombreProyecto 
			FROM 
				T_PRY_PROYECTO 
			WHERE seqProyecto = (SELECT 
									seqProyectoHijo
								FROM 
									T_FRM_FORMULARIO 
								WHERE
									seqFormulario = $idFormulario) ";
	$exeSql = mysql_query($sql);
	$rowSql = mysql_fetch_array($exeSql);
	$nombreConjuntoResidencial = $rowSql['txtNombreProyecto'];
	
	$claFormulario = new FormularioSubsidios;
	$claFormulario->cargarFormulario( $_GET['seqFormulario'] );

	$arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA",array("seqTipoVictima","txtTipoVictima"),"seqTipoVictima");
	$arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia");
	$arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi");
	$arrCiudad = obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad");
	$arrTipoEsquema = obtenerDatosTabla("T_PRY_TIPO_ESQUEMA", array("seqTipoEsquema", "txtTipoEsquema"), "seqTipoEsquema");
	$arrConvenio = obtenerDatosTabla("V_FRM_CONVENIO", array("seqConvenio", "txtNombre"), "seqConvenio", "", "txtNombre");

	$claSmarty->assign( "arrConvenio" , $arrConvenio );
	$claSmarty->assign( "arrTipoEsquema" , $arrTipoEsquema );
	$claSmarty->assign( "arrCiudad" , $arrCiudad );
	$claSmarty->assign( "arrGrupoLgtbi" , $arrGrupoLgtbi );
	$claSmarty->assign( "arrCondicionEtnica" , $arrCondicionEtnica );
	$claSmarty->assign( "arrTipoVictima" , $arrTipoVictima );
	$claSmarty->assign( "fchImpresion" , $txtFecha );
	$claSmarty->assign( "objFormulario" , $claFormulario );
	$claSmarty->assign( "arrTipoDocumento" , $arrTipoDocumento );
	$claSmarty->assign( "arrParentesco" , $arrParentesco );
	$claSmarty->assign( "arrCondicionEspecial" , $arrCondicionEspecial );
	$claSmarty->assign( "arrEstadoCivil" , $arrEstadoCivil );
	$claSmarty->assign( "arrSexo" , $arrSexo );
	$claSmarty->assign( "arrOcupacion" , $arrOcupacion );
	$claSmarty->assign( "arrNivelEducativo" , $arrNivelEducativo );
	$claSmarty->assign( "arrEtnia" , $arrCondicionEtnica );
	$claSmarty->assign( "arrCajaCompensacion" , $arrCajaCompensacion );
	$claSmarty->assign( "arrSalud" , $arrSalud );
	$claSmarty->assign( "arrSisben" , $arrSisben );
	$claSmarty->assign( "arrBarrio" , $arrBarrio );
    $claSmarty->assign( "arrLocalidad" , $arrLocalidad );
	$claSmarty->assign( "arrVivienda" , $arrVivienda );
	$claSmarty->assign( "arrModalidad" , $arrModalidad );
	$claSmarty->assign( "arrSolucion" , $arrSolucion );
	$claSmarty->assign( "arrProyecto" , $arrProyecto );
	$claSmarty->assign( "nombreUnidadProyecto" , $nombreUnidadProyecto);
	$claSmarty->assign( "nombreConjuntoResidencial" , $nombreConjuntoResidencial);
	$claSmarty->assign( "arrProyectoBp" , $arrProyectoBp );
	$claSmarty->assign( "arrBanco" , $arrBanco );
	$claSmarty->assign( "arrDonantes" , $arrDonantes );
	$claSmarty->assign( "txtUsuarioSistema" , $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] ); 
	$claSmarty->display( "subsidios/formatoPostulacionImprimir.tpl" );

?>

