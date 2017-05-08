<?php
	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );

	// VALIDACIONES

	$arrErrores = array();
	$arrMensajes = array();

	// Grupo de Gestion
	if( $_POST['seqGrupoGestion'] == 0 ){
		$arrErrores[] = "Seleccione el grupo de la gestión realizada";
	}

	// Gestion
	if( $_POST['seqGestion'] == 0 ){
		$arrErrores[] = "Seleccione la gestión realizada";
	}

	// Comentarios
	if( $_POST['txtComentario'] == "" ){
		$arrErrores[] = "Por favor diligencie el campo de comentarios";
	}

	// Estado del proceso
	if( $_POST['seqPryEstadoProceso'] == 0 ){
		$arrErrores[] = "Seleccione un estado del proceso v&aacute;lido";
	}

	// Proyecto (campo oculto)
	if( $_POST['nombre'] == "" && $_POST['myHidden'] == "" ){
		$arrErrores[] = "Seleccione un Proyecto de Vivienda";
	}
	
	// Nombre de Proyecto 
	if( $_POST['nombre'] == "" && $_POST['myHidden'] != ""){
		$arrErrores[] = "Seleccione un Proyecto de Vivienda";
	}
	
	/**
	* PROCESAMIENTO
	*/

	$numModificados = 0;
	$numErrores = 0;

	$seqProyecto = $_POST['myHidden'];
	$seqEstadoProcesoProyecto = $_POST['seqPryEstadoProceso'];
	
	if( empty( $arrErrores ) ){

			$claProyectoViviendaActual = new ProyectoVivienda();

			$claProyectoViviendaActual->editarEstadoProyectoVivienda( $seqProyecto, $seqEstadoProcesoProyecto);
			if( empty( $claProyecto->arrErrores ) ){

				$claSeguimientoProyectos = new SeguimientoProyectos();
				//$txtCambios = $claSeguimientoProyectos->cambiosPostulacion( $seqFormulario , $claFormularioActual , $claProyecto );
				$txtCambios = "Se realizó cambio de estado";

				$sql = "
						INSERT INTO T_SEG_SEGUIMIENTO_PROYECTOS (
							seqProyecto,
							fchMovimiento,
							seqUsuario,
							txtComentario,
							txtCambios,
							seqGestion,
							bolMostrar
						) VALUES (
							$seqProyecto,
							now(),
							" . $_SESSION['seqUsuario'] . ",
							\"" . ereg_replace("\n", "", $_POST['txtComentario']) . "\",
							\"" . ereg_replace("\"", "", $txtCambios) . "\",
							" . $_POST['seqGestion'] . ",
							1
						)
					";

				try {
					$aptBd->execute( $sql );
				} catch ( Exception $objError ){
					$arrErrores[] = "No se ha podido registrar el seguimiento del proyecto";
				}

			} else {
				$numErrores++;
				$arrErrores[] = "No se pudo actualizar la informacion del proyecto $seqProyecto ( " . $claProyecto->numDocumento . " )";
			}
	}

	/**
	 * DESPLIEGUE DE MENSAJES
	 */

	$txtDivListener = "";
	if( empty( $arrErrores ) ){
		$arrMensajes[] = "El Estado del Proyecto se ha actualizado";
		$txtDivListener = "salvarProyecto";
	}

	imprimirMensajes( $arrErrores , $arrMensajes , $txtDivListener );
?>