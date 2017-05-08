<?php
/**
* REPORTE DE INFORMACION DISPONIBLE EN SIFSV DEL PROYECTO Y LOTE DE MAYOR EXTENSION
* @author Jaison Ospina
* @version 1.0 Marzo 2016
*/

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

/*$arrSeqFormularios = array( );
if( isset( $_FILES['fileSecuenciales'] ) and !$_FILES['fileSecuenciales']['error'] ){
	try {
		$aptArchivo = fopen( $_FILES['fileSecuenciales']['tmp_name'] , "r" );
		$numLinea = 1;
		while( $txtLinea = fgets( $aptArchivo ) ){
			try {
				$txtLinea = trim( $txtLinea );
			}catch( Exception $objError ){ }
			$numLinea++;
		}
	}catch( Exception $objError ){ }
}

if( !empty( $arrSeqFormularios ) ){
	$arrCondiciones[] = "txtNombreProyecto = '" . $txtLinea . "'";
}

$txtCondicion = implode( " AND ", $arrCondiciones );
*/

$sql = "
	SELECT 
		seqProyecto AS 'ID Proyecto',
		txtNombreProyecto AS 'Nombre Proyecto',
		txtNombrePlanParcial AS 'Nombre Plan Parcial',
		T_PRY_PROYECTO.seqLocalidad AS 'Codigo Localidad',
		txtLocalidad AS 'Localidad',
		txtBarrio AS 'Barrio',
		txtDireccion AS 'Direccion',
		txtChipLote AS 'CHIP',
		txtMatriculaInmobiliariaLote AS 'Matricula Inmobiliaria',
		txtLicenciaUrbanismo AS 'Licencia Urbanismo',
		txtExpideLicenciaUrbanismo AS 'Curaduria',
		fchLicenciaUrbanismo1 AS 'Fecha Licencia Urbanismo',
		fchVigenciaLicenciaUrbanismo AS 'Fecha Vigencia Urbanismo',
		txtLicenciaConstruccion AS 'Licencia Construccion',
		fchLicenciaConstruccion1 AS 'Fecha Licencia Construccion',
		fchVigenciaLicenciaConstruccion AS 'Vigencia Licencia Construccion',
		txtNombreVendedor AS 'Vendedor',
		numNitVendedor AS 'NIT Vendedor',
		txtCedulaCatastral AS 'Cedula Catastral',
		txtEscritura AS 'Número Escritura',
		numNotaria AS 'Notaria',
		fchEscritura AS 'Fecha Escritura'
	FROM T_PRY_PROYECTO
	LEFT JOIN T_FRM_LOCALIDAD ON (T_PRY_PROYECTO.seqLocalidad = T_FRM_LOCALIDAD.seqLocalidad)
	LEFT JOIN T_FRM_BARRIO ON (T_PRY_PROYECTO.seqBarrio = T_FRM_BARRIO.seqBarrio)
	WHERE seqTipoEsquema = 1
	AND seqProyectoPadre IS NULL
";
//echo $sql;die();
$objRes = $aptBd->execute( $sql );
$txtNombreArchivo = "ReportePlantillaInformeSolucion" . date( "Ymd" ) . ".xls";

$claReportes = new Reportes;
$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
?>