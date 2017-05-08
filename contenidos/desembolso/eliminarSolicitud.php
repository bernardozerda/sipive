<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
 
	/**
	 * LOS QUE TIENEN PERMISOS PARA MODIFICAR EN ESTA PANTALLA
	 * Proyecto         = 3  --> Subsidio de vivienda
	 * Grupo            = 9  --> Solicitud de desembolso
	 *   Grupo Proyecto = 10 --> Solicitud de desembolso asignado a Subsidio de vivienda
	 * 
	 * FORMATO DEL ARREGLO
	 * $arrGrupoPermitido[ proyecto ][ grupo ] = grupoProyecto
	**/
	
	$arrGrupoPermitidos[ 3 ][ 9 ] = 10;
	
	// proyecto actual
	$seqProyecto = $_SESSION[ "seqProyecto" ];
	
	// verifica si el usuario pertenece 
	// a alguno de los grupos autorizados
	$bolGrupoPermitido = false;
	foreach( $_SESSION[ "arrGrupos" ][ $seqProyecto ] as $seqGrupo => $seqProyectoGrupo ){
		if( isset( $arrGrupoPermitidos[ $seqProyecto ][ $seqGrupo ] ) and ( $arrGrupoPermitidos[ $seqProyecto ][ $seqGrupo ] == $seqProyectoGrupo ) ){
			$bolGrupoPermitido = true;		
		}		
	}	
	
	if( $bolGrupoPermitido == false ){
		$arrErrores[] = "No tiene privilegios para eliminar solicitudes";
	}else{  		
		if( $_SESSION[ "privilegios" ][ "borrar" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para eliminar solicitudes";
		}
	}

   if( trim( $_POST['txtComentario'] ) == "" ){
      $arrErrores[] = "Debe dejar un comentario para el seguimiento de actividades (seguimiento)";
   }
   
   if( intval( $_POST['seqGestion'] ) == 0 ){
      $arrErrores[] = "Seleccione la gestión realziada para el registro de actividades (seguimiento)";
   }

	$arrMensajes = array();
	if( empty( $arrErrores ) ){
		
		$seqFormulario = substr( $_POST['seqBorrar'] , 0 , strlen( $_POST['seqBorrar'] ) - ( strlen( $_POST['seqBorrar'] ) - strpos( $_POST['seqBorrar'] , "#" ) ) );
		$seqSolicitud  = substr( $_POST['seqBorrar'] , strpos( $_POST['seqBorrar'] , "#" ) + 1 );
	
		$claFormulario = new FormularioSubsidios;
		$claFormulario->cargarFormulario( $seqFormulario );
		
		$txtNombrePrincipal = "";
		$numDocumentoPrincipal = 0;
		foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
			if( $objCiudadano->seqParentesco == 1 ){
				$txtNombrePrincipal = $objCiudadano->txtNombre1 . " " .
									  $objCiudadano->txtNombre2 . " " .
									  $objCiudadano->txtApellido1 . " " .
									  $objCiudadano->txtApellido2 . " ";
				$numDocumentoPrincipal = $objCiudadano->numDocumento;
				break;
			}
		}
		
		$claDesembolso = new Desembolso;
		$claDesembolso->cargarDesembolso( $seqFormulario );
		
		$claSeguimiento = new Seguimiento;
		
		$arrSeguimiento['txtComentario'] = trim( $_POST['txtComentario'] );
		$arrSeguimiento['txtCambios']    = $claSeguimiento->eliminarSolicitud( $seqFormulario , $seqSolicitud , $claDesembolso->arrSolicitud['resumen']['fechas'][ $seqSolicitud ] );
		$arrSeguimiento['cedula']        = $numDocumentoPrincipal;
		$arrSeguimiento['nombre']        = $txtNombrePrincipal;
		$arrSeguimiento['seqGestion']    = intval( $_POST['seqGestion'] );
		
		if( empty( $arrErrores ) ){
         $bolBorrar = ( $_POST['bolBorrar'] == "true" )? 1 : 0;
			$arrErrores = $claDesembolso->borrarSolicitud( $seqFormulario , $seqSolicitud , $arrSeguimiento , $bolBorrar );
		}
		
		if( empty( $arrErrores ) ){
			$arrMensajes[] = "Ha eliminado la solicitud de desembolso";
		}
	
	}
	
	imprimirMensajes( $arrErrores , $arrMensajes );

?>
