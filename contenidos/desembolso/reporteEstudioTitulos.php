<?php
/**
* PLANTILLA ESTUDIO DE TITULOS
* @author Jaison Ospina
			Andres Martinez
* @version 1.0 Abril 2016
*/

ini_set('memory_limit','128M');

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$arrSeqFormularios = array( );
if( isset( $_FILES['fileSecuenciales'] ) and !$_FILES['fileSecuenciales']['error'] ){
	try {
		$aptArchivo = fopen( $_FILES['fileSecuenciales']['tmp_name'] , "r" );
		$numLinea = 1;
		while( $txtLinea = fgets( $aptArchivo ) ){
			try {
				$txtLinea = trim( $txtLinea );
				if( is_numeric( $txtLinea ) ){
					$seqFormulario = Ciudadano::formularioVinculado($txtLinea);
					if( $seqFormulario ){
						$arrSeqFormularios[] = $seqFormulario;
					}
				}
			}catch( Exception $objError ){ }
			$numLinea++;
		}
	}catch( Exception $objError ){ }
}

if( !empty( $arrSeqFormularios ) ){
	$arrCondiciones[] = "T_DES_ESCRITURACION.seqFormulario IN ( ". implode( $arrSeqFormularios, " , " ) ." )";
}

$arrCondiciones[] = "T_FRM_HOGAR.seqParentesco = 1";

$txtCondicion = implode( " AND ", $arrCondiciones );

$sql = "
	SELECT T_DES_ESCRITURACION.seqFormulario AS 'HOGAR',
       T_CIU_CIUDADANO.numDocumento AS 'CC POSTULANTE PRINCIPAL',
       T_CIU_TIPO_DOCUMENTO.txtTipoDocumento AS 'TIPO DE DOCUMENTO',
       UPPER(CONCAT(T_CIU_CIUDADANO.txtNombre1,' ',T_CIU_CIUDADANO.txtNombre2,' ',T_CIU_CIUDADANO.txtApellido1,' ',T_CIU_CIUDADANO.txtApellido2)) AS 'NOMBRE POSTULANTE PRINCIPAL',
       T_PRY_PROYECTO.txtNombreProyecto AS 'PROYECTO',
       T_DES_ESCRITURACION.txtNombreVendedor AS 'PROPIETARIO',
       T_FRM_FORMULARIO.seqUnidadProyecto AS 'seqUnidadProyecto',
       T_PRY_UNIDAD_PROYECTO.txtNombreUnidad AS 'txtnombreunidad',
       T_DES_ESCRITURACION.txtDireccionInmueble AS 'DIRECCION INMUEBLE',
       T_PRY_TECNICO.txtexistencia AS 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD',
       T_DES_ESCRITURACION.txtEscritura AS 'ESCRITURA REGISTRADA',
       T_DES_ESCRITURACION.fchEscritura AS 'FECHA ESCRITURA',
       T_DES_ESCRITURACION.numNotaria AS 'NOTARIA',
       T_DES_ESCRITURACION.txtCiudad AS 'CIUDAD NOTARIA',
       T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'FOLIO DE MATRICULA',
       T_DES_ESCRITURACION.numValorInmueble AS 'VALOR INMUEBLE',
       T_AAD_ACTO_ADMINISTRATIVO.numActo AS 'NUMERO DEL ACTO',
       DATE_FORMAT(T_AAD_ACTO_ADMINISTRATIVO.fchacto, '%d-%m-%Y')
          AS 'FECHA DEL ACTO',
       '' AS 'No. ESCRITURA',
       '' AS 'FECHA ESCRITURA (D/M/A)',
       '' AS 'NOTARIA',
       '' AS 'CIUDAD NOTARIA',
       '' AS 'FOLIO DE MATRICULA',
       '' AS 'ZONA OFICINA REGISTRO',
       '' AS 'CIUDAD OFICINA REGISTRO',
       '' AS 'FECHA FOLIO (D/M/A)',
       '' AS 'RESOLUCION DE VINCULACION COINCIDENTE',
       '' AS 'BENEFICIARIOS DEL SDV COINCIDENTES',
       '' AS 'NOMBRE Y CEDULA DE LOS PROPIETARIOS EN EL CTL INCIDENTES',
       '' AS 'CONSTITUCION PATRIMONIO FAMILIA',
       '' AS 'INDAGACION AFECTACION A VIVIENDA FAMILIAR',
       '' AS 'RESTRICCIONES',
       '' AS 'ESTADO CIVIL COINCIDENTE',
       '' AS 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA',
       '' AS 'No. DE ANOTACION CTL COMPRAVENTA',
       '' AS 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)',
       '' AS 'PATRIMONIO DE FAMILIA REGISTRADO',
       '' AS 'PROHIBICION DE TRANSFERENCIA Y DERECHO DE PREFERENCIA REGISTRADOS',
       '' AS 'IMPRESION DE CONSULTA FONVIVIENDA (HOGARES VICTIMAS)',
       '' AS 'ELABORO',
       '' AS 'APROBO',
       '' AS 'SE VIABILIZA JURIDICAMENTE',
       '' AS 'OBSERVACION'
	FROM T_DES_ESCRITURACION
	INNER JOIN T_FRM_FORMULARIO ON (T_DES_ESCRITURACION.seqFormulario = T_FRM_FORMULARIO.seqFormulario)
	INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
	INNER JOIN T_CIU_CIUDADANO ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano)
	INNER JOIN T_CIU_TIPO_DOCUMENTO ON (T_CIU_CIUDADANO.seqTipoDocumento = T_CIU_TIPO_DOCUMENTO.seqTipoDocumento)
	INNER JOIN T_PRY_UNIDAD_PROYECTO ON (T_FRM_FORMULARIO.seqFormulario = T_PRY_UNIDAD_PROYECTO.seqFormulario)
	INNER JOIN T_PRY_PROYECTO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
	INNER JOIN T_PRY_TECNICO ON (T_FRM_FORMULARIO.seqUnidadProyecto = T_PRY_TECNICO.seqUnidadProyecto)
	INNER JOIN T_AAD_FORMULARIO_ACTO ON (T_FRM_FORMULARIO.seqFormulario = T_AAD_FORMULARIO_ACTO.seqFormulario)
	INNER JOIN T_AAD_HOGARES_VINCULADOS ON (T_AAD_FORMULARIO_ACTO.seqFormularioActo = T_AAD_HOGARES_VINCULADOS.seqFormularioActo)
	INNER JOIN (SELECT * FROM T_AAD_ACTO_ADMINISTRATIVO ORDER BY T_AAD_ACTO_ADMINISTRATIVO.fchActo DESC) AS T_AAD_ACTO_ADMINISTRATIVO
				ON (T_AAD_HOGARES_VINCULADOS.numActo = T_AAD_ACTO_ADMINISTRATIVO.numActo AND T_AAD_HOGARES_VINCULADOS.fchActo = T_AAD_ACTO_ADMINISTRATIVO.fchActo)
WHERE $txtCondicion 
GROUP BY T_DES_ESCRITURACION.seqFormulario
ORDER BY T_AAD_ACTO_ADMINISTRATIVO.fchActo
";
//echo $sql;die();
$objRes = $aptBd->execute( $sql );
$txtNombreArchivo = "ReporteEstudioTitulos" . date( "Ymd_His" ) . ".xls";

$claReportes = new Reportes;
$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
?>