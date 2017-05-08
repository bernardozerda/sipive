<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "FormularioSubsidios.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos.class.php" );
	
	
	// valida el archivo
	switch( $_FILES['hogares']['error'] ){
		case UPLOAD_ERR_INI_SIZE:
		  $arrErrores[] = "El archivo Excede el tamaño permitido";
		break;  
		case UPLOAD_ERR_FORM_SIZE:
		    $arrErrores[] = "El archivo Excede el tamaño permitido";
		break; 
		case UPLOAD_ERR_PARTIAL:
		  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
		break; 
		case UPLOAD_ERR_NO_FILE:
		  $arrErrores[] = "Debe especificar un archivo para cargar";
		break; 
	}
	
	// Validaciones de la notificacion
	if( empty( $arrErrores ) ){
		
		if( intval( $_POST[ "numNotificacion" ] ) == 0 ){
			$arrErrores[] = "La notificación debe tener un número.";
		}
		
		if( $_POST[ "fchNotificacion" ] == "" ){
			$arrErrores[] = "Debe indicar para la notificación.";
		}
		
		if( $_POST[ "seqTipoActo" ] == 0 ){
			$arrErrores[] = "La notificación debe hacer referencia a un Tipo Acto Administrativo.";
		}
		
	}
	
	// Valida las caracteristicas de la notificacion
	if( empty( $arrErrores ) ){
		
		$claTipoActo = new TipoActoAdministrativo;
		$claActoAdmo = new ActoAdministrativo;
		$claTipoActo->cargarTipoActo( 7 );
		$claTipoActo->validarDatos( $_POST[ "caracteristica" ] );
		if( empty( $claTipoActo->arrErrores ) ){
			$arrArchivo = $claTipoActo->validarArchivo( $_FILES['hogares']['tmp_name'] );	
			if( ! empty( $claTipoActo->arrErrores ) ){
				$arrErrores = $claTipoActo->arrErrores;
			}
		}else{
			$arrErrores = $claTipoActo->arrErrores;
		}
		
		$numActo = $_POST['caracteristica'][ 20 ];
		$fchActo = $_POST['caracteristica'][ 21 ];
		if( empty( $arrErrores ) ){
			$arrErrores = $claActoAdmo->validarArchivoNotificacion( $numActo , $fchActo , $arrArchivo );
		}
		
	}
	
	// Salvar la notificacion
	if( empty( $arrErrores ) ){
		
		$claActo = new ActoAdministrativo;
		$claActo->seqTipoActo = 7;
		$claActo->numActo     = $_POST['numNotificacion'];
		$claActo->fchActo     = $_POST['fchNotificacion'];
		$claActo->numActoReferencia = $_POST['caracteristica'][ 20 ];
		$claActo->fchActoReferencia = $_POST['caracteristica'][ 21 ];
		
		$claActo->arrCaracteristicas = $_POST['caracteristica'];
		
		$claActo->salvarNotificacion( $_POST[ "seqTipoActo" ] , $arrArchivo , $claTipoActo->arrTipoActos );
		
		if( empty( $claActo->arrErrores ) ){
			
			if( $claActo->actoExiste( ) ){
				$claActo->editarActo( );
			}else{
				$claActo->salvarActo( );
			}
			
			// los datos de los hogares vinculados
			$claActo->vincularHogarActo( $arrArchivo );
			
		}
		
		if( empty( $claActo->arrErrores ) ){
			$arrMensajes[] = "Ha salvado la " . $claTipoActo->txtNombreTipoActo . " " . $claActo->numActo . " del " . $claActo->fchActo;
		}else{
			$arrErrores = $claActo->arrErrores;
			
		}
		
	}
	
	imprimirMensajes( $arrErrores , $arrMensajes );
	

?>
