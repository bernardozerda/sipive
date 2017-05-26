<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );
	
	$seqTutor 	= $_POST["idUsuario"];
	$txtMasiva 	= $_POST["masiva"];
	$arrErrores = array( );
	
	$claActos = new ActoAdministrativo;
		
	$arrCoordinadores 	= array( );
	$arrSecuenciales 	= array( );
	$arrUsuarios 	 	= array( );
	$arrDatosTabla 		= array( );
		
	// Obtengo los secuenciales de formulario que tiene el tutor y su coordinador respectivo
	$sql = "
		SELECT 
			seqFormulario, 
			seqUsuarioCoordinador
		FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS 
		WHERE seqUsuario = $seqTutor
	";
	
	try{
			
		$objRes = $aptBd->execute( $sql );
		
		$arrTotal = array( );
		while( $objRes->fields ){
			$arrTotal[ $objRes->fields['seqFormulario'] ] = $objRes->fields['seqUsuarioCoordinador'];
			$arrSecuenciales[] 	= $objRes->fields['seqFormulario'];
			$arrUsuarios[] 		= $objRes->fields['seqUsuarioCoordinador'];
			$objRes->MoveNext();
		}
		$arrUsuarios = array_unique( $arrUsuarios );
		$arrUsuarios[] = $seqTutor;
	}catch ( Exception $objError ){
		$arrErrores[] = "Tutor Incorrecto";
	}
	
	// Obtener el nombre del Usuario y los Coordinadores que tiene
	$sql = "
		SELECT 
			seqUsuario,
			concat(txtNombre, ' ', txtApellido) as Nombre
		FROM T_COR_USUARIO
		WHERE seqUsuario in ( ". implode( ", ", $arrUsuarios ) ." )
	";
	try{
		$objRes = $aptBd->execute( $sql );
		$txtNombreUsuario = "";
		while( $objRes->fields ){
			
			if( $objRes->fields['seqUsuario'] == $seqTutor ){
				$txtNombreUsuario = $objRes->fields['Nombre'];
			}else{
				$arrCoordinadores[ $objRes->fields['seqUsuario'] ] = $objRes->fields['Nombre'];
			}
			$objRes->MoveNext();
		}
	}catch( Exception $objError ){
		$arrErrores[] = "No se pudieron obtener los Coordinadores";
	}
	
	$sql = "
		SELECT 
			frm.seqFormulario, 
			ciu.numDocumento, 
			ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre
		FROM T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		WHERE hog.seqParentesco = 1 AND 
		frm.seqFormulario IN ( ". implode(", ", $arrSecuenciales ) ." )
		LIMIT 100
	";
	try{
		
		$objRes = $aptBd->execute( $sql );
		
		while( $objRes->fields ){
			$arrTemporal = &$arrDatosTabla[];
			
			$seqFormulario 	= $objRes->fields["seqFormulario"];
			$numDocumento 	= $objRes->fields["numDocumento"];
			$txtNombre 		= $objRes->fields["Nombre"];
			
			$arrSecuencialFormularioActo = $claActos->actoExisteCiudadano( $numDocumento );
			
			$fchActo = "";
			$numActo = "";
			foreach( $arrSecuencialFormularioActo as $seqFormularioActo ){
				$arrActo = $claActos->obtenerActoAdministrativo( $seqFormularioActo );
				if( $arrActo["seqTipoActo"] == 1 ){
					$fchActo = $arrActo["fchActo"];
					$numActo = $arrActo["numActo"];
					break;
				}
				
			}
			
			if( $txtMasiva != "Masiva" ){
				$arrTemporal["Usuario"] = $txtNombreUsuario;
			}
			$arrTemporal["Coordinador"] = $arrCoordinadores[ $arrTotal[ $seqFormulario ] ];	
			$arrTemporal["Documento"] 	= $numDocumento;
			$arrTemporal["Nombre"] 		= $txtNombre;
			$arrTemporal["FechaActo"] 		= $fchActo;
			$arrTemporal["NumeroActo"] 		= $numActo;
			
			$objRes->MoveNext();
		}
	}catch( Exception $objError ){
		$arrErrores[] = "No se pudo obtener los Formularios Asignados para el tutor";
	}
	
	if( $arrErrores ){
		imprimirErrores( $arrErrores );
	}else{
		
		$txtJs = CRM::arrayToJsDataTable( $arrDatosTabla, "NoAsignados" );
		$claSmarty->assign( "txtDataTableJS", 	$txtJs );
		if( $txtMasiva == "Masiva" ){
			$claSmarty->display( "crm/dataTableFormularioMasiva.tpl" );
		}else {
			$claSmarty->display( "crm/dataTableFormulario.tpl" );
		}
		
	}
	

?>
