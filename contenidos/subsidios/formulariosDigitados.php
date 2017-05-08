<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Usuario.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Reportes.class.php" );
	
	$claUsuario = new Usuario;
	
	// Nombre del archivo a descargar
	$txtArchivo      = "formularioDigitados.xls";
	// Si no viene fecha es un error
	if( $_POST['fchInicio'] === "" ){
		echo "<span class='msgError'>Seleccione una fecha</span>";
		exit(0);
	}

	// Condicion si viene fecha
	$txtCondicion = "";
	if( $_POST['fchInicio'] != 0 ){
		$txtCondicion = " AND frm.fchPostulacion >= '".$_POST['fchInicio']." 00:00:00' AND frm.fchPostulacion <= '".$_POST['fchInicio']." 23:59:59' ";
	}else{
		$_POST['fchInicio'] = "todas las fechas";
	}
	
	// Consulta que estrae los datos
	$sql = "
		SELECT 
			frm.seqFormulario,
			frm.txtFormulario,
			pat.txtPuntoAtencion,			
			epr.txtEstadoProceso,
			tdo.txtTipoDocumento,
			ciu.numDocumento,			
			CONCAT( ciu.txtApellido1 , ' ' , ciu.txtApellido2 , ' ' , ciu.txtNombre1 , ' ' , ciu.txtNombre2 ) as txtNombrePostulante,
			frm.fchPostulacion,
			frm.seqUsuario
		FROM 
			T_FRM_FORMULARIO frm,
			T_FRM_ESTADO_PROCESO epr,
			T_FRM_PUNTO_ATENCION pat,
			T_FRM_HOGAR hog,
			T_CIU_CIUDADANO ciu,
			T_CIU_TIPO_DOCUMENTO tdo
		WHERE frm.seqEstadoProceso = epr.seqEstadoProceso
		  AND frm.seqPuntoAtencion = pat.seqPuntoAtencion
			AND hog.seqFormulario = frm.seqFormulario
			AND hog.seqParentesco = 1
			AND hog.seqCiudadano = ciu.seqCiudadano
			AND ciu.seqTipoDocumento = tdo.seqTipoDocumento
			$txtCondicion
	";
	$objRes = $aptBd->execute( $sql );
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtArchivo );
	
?>
	
	

