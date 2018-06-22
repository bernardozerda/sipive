<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// Modalidad de subsidio
$sql = "
        SELECT 
                seqModalidad,
                CONCAT(txtModalidad,' ( ',txtPlanGobierno,' )') as txtModalidad
        FROM 
                T_FRM_MODALIDAD INNER JOIN T_FRM_PLAN_GOBIERNO ON (T_FRM_MODALIDAD.seqPlanGobierno = T_FRM_PLAN_GOBIERNO.seqPlanGobierno)
        WHERE
                T_FRM_MODALIDAD.seqPlanGobierno = 2
        ORDER BY
                seqModalidad
	";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrModalidad[$objRes->fields['seqModalidad']] = $objRes->fields['txtModalidad'];
    $objRes->MoveNext();
}

// Fechas de Calificacion
/* $sql = "
  SELECT
  date_format(fchCalificacion,'%Y-%m-%d') AS fechaCalificacion, COUNT(*) AS cuantos
  FROM
  t_frm_calificacion_plan2
  GROUP BY
  fechaCalificacion
  ORDER BY
  fechaCalificacion"; */
$sql = "
		SELECT 
			fchCalificacion AS fechaCalificacion, COUNT(*) AS cuantos
		FROM 
			t_frm_calificacion_plan2
		GROUP BY 
			fechaCalificacion
		ORDER BY 
			fechaCalificacion DESC";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $arrFchCalifica[$objRes->fields['fechaCalificacion']] = $objRes->fields['cuantos'];
    $objRes->MoveNext();
}

// ESTADO DEL PROCESO ANTES DE CALIFICAR

$sql = "
		SELECT 
			frm.seqModalidad as Modalidad,
			moa.txtModalidad as NombreModalidad,
			ciu.numDocumento as Documento,
			upper( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 )) as Nombre,
			frm.fchPostulacion,
			frm.bolDesplazado as Desplazado,
			frm.bolCerrado as Cerrado
		FROM
			T_FRM_FORMULARIO frm
		INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
		INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
		INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
		INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
		WHERE 
			frm.seqEstadoProceso = 6
			AND hog.seqParentesco = 1
			AND fchNacimiento <> '0000-00-00'
		ORDER BY 
			frm.seqPlanGobierno
	";

$objRes = $aptBd->execute($sql);
$arrReporte = array();
$arrArchivo[] = array_keys($objRes->fields);
while ($objRes->fields) {

    $seqModalidad = $objRes->fields['Modalidad'];
    $numTutor = ( trim($objRes->fields['Tutor']) == "" ) ? -1 : intval($objRes->fields['Tutor']);
    $txtFormulario = $objRes->fields['Formulario'];
    $bolCerrado = $objRes->fields['Cerrado'];

    // Reporte abiertos y cerrados por modalidad
    $arrReporte[0][$bolCerrado][$seqModalidad] ++;

    $arrTotales[0]['estado'][$bolCerrado] ++;
    $arrTotales[0]['modalidad'][$seqModalidad] ++;
    $arrTotales[0]['total'] ++;

    // Reporte abiertos y cerrados por tutor
    $arrReporte[1]['resumen'][$numTutor][$bolCerrado] ++;
    ksort($arrReporte[1]['resumen']);

    $arrTotales[1]['estado'][$bolCerrado] ++;
    $arrTotales[1]['tutor'][$numTutor] ++;
    $arrTotales[1]['total'] ++;

    // Detalle de abiertos y cerrados por tutor
    $arrReporte[1]['detalle'][$numTutor][$bolCerrado][] = $txtFormulario;

    // Arreglo para mandar al archivo
    $arrArchivo[] = $objRes->fields;

    $objRes->MoveNext();
}

$txtArchivo = $txtPrefijoRuta . "descargas/formulariosAbiertos" . date("Ymd") . ".xls";
$aptArchivo = fopen($txtArchivo, "w");
if ($aptArchivo) {
    foreach ($arrArchivo as $numLinea => $arrLinea) {
        fwrite($aptArchivo, utf8_decode(implode("\t", $arrLinea)) . "\r\n");
    }
    fclose($aptArchivo);
} else {
    $txtArchivo = "";
}

$claSmarty->assign("arrCerrado", $arrCerrado);
$claSmarty->assign("arrModalidad", $arrModalidad);
$claSmarty->assign("arrFchCalifica", $arrFchCalifica);
$claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
$claSmarty->assign("arrReporte", $arrReporte);
$claSmarty->assign("arrTotales", $arrTotales);
$claSmarty->assign("txtArchivo", $txtArchivo);
$claSmarty->display("calificacion/calificacionFormulariosPlan2.tpl");
?>
