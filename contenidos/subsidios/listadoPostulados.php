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
	
	if( $_POST['fchInicio'] === "" ){
		echo "<span class='msgError'>Seleccione una fecha</span>";
		exit(0);
	}
	
	$txtCondicion = "";
	if( $_POST['fchInicio'] != 0 ){
		$txtCondicion = " AND frm.fchPostulacion <= '".$_POST['fchInicio']." 23:59:59' ";
	}else{
		$_POST['fchInicio'] = "todas las fechas";
	}
	
	// Nombre del archivo a descargar
	$txtArchivo = "listadoPostulados.xls";

	// Consulta que estrae los datos
	$sql = "
		SELECT 
			frm.seqFormulario,
			frm.txtFormulario,
			frm.fchPostulacion,
			ucwords(ciu.txtNombre1) as txtNombre1,
			ucwords(ciu.txtNombre2) as txtNombre2,
			ucwords(ciu.txtApellido1) as txtApellido1,
			ucwords(ciu.txtApellido2) as txtApellido2,
			tdo.txtTipoDocumento,
			ciu.numDocumento
		FROM 
			T_FRM_FORMULARIO frm,
			T_FRM_HOGAR hog,
			T_CIU_CIUDADANO ciu,
			T_CIU_TIPO_DOCUMENTO tdo
		WHERE
			hog.seqFormulario = frm.seqFormulario
			AND frm.seqEstadoProceso = 7
			AND hog.seqCiudadano = ciu.seqCiudadano
			AND ciu.seqTipoDocumento = tdo.seqTipoDocumento
			AND tdo.seqTipoDocumento IN ( 1,2 )
			AND frm.bolCerrado = 1
			$txtCondicion
	";
	$objRes = $aptBd->execute( $sql );
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtArchivo );
	
?>
