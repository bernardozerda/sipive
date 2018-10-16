<?php

$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

$sql = "
    SELECT
        pryP.txtNombreProyecto as txtNombreProyectoPadre,
        pry.txtNombreProyecto as txtNombreProyecto,
        und.seqUnidadProyecto,
        und.txtNombreUnidad, 
        und.txtNombreUnidadReal,
        und.txtNombreUnidadAux,
        und.valSDVEAprobado,
        und.valSDVEComplementario,
        und.valSDVEActual,
        IF(LOWER(tec.txtExistencia) = 'si','SI','NO') as 'viabilidadTecnica',
        und.seqFormulario,
        ciu.numDocumento AS 'documentoPpal',
        UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'nombrePpal',
        frm.txtFormulario,
        CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'estadoProceso',
        und.txtMatriculaInmobiliaria,
        IF(und.bolLegalizado=0,'NO','SI') as bolLegalizado,
        IF(und.fchLegalizado='0000:00:00',NULL,und.fchLegalizado) as fchLegalizado,
        IF(und.fchDevolucionExpediente='0000:00:00',NULL,und.fchDevolucionExpediente) as fchDevolucionExpediente,
        pgo.txtPlanGobierno,
        moa.txtModalidad,
        tes.txtTipoEsquema,
        IF(und.bolActivo=0,'NO','SI') as bolActivo,
        CONCAT(und.seqEstadoUnidad ,'-', est.txtEstadoUnidad) as estado
    FROM T_PRY_UNIDAD_PROYECTO und 
    INNER JOIN T_PRY_PROYECTO pry ON und.seqProyecto = pry.seqProyecto
    LEFT  JOIN T_PRY_PROYECTO pryP ON pry.seqProyectoPadre = pryP.seqProyecto
    INNER JOIN T_FRM_PLAN_GOBIERNO pgo ON pgo.seqPlanGobierno = und.seqPlanGobierno
    INNER JOIN T_FRM_MODALIDAD moa ON und.seqModalidad = moa.seqModalidad
    INNER JOIN T_PRY_TIPO_ESQUEMA tes ON und.seqTipoEsquema = tes.seqTipoEsquema                                       
    LEFT  JOIN T_FRM_FORMULARIO frm ON und.seqFormulario = frm.seqFormulario
    LEFT  JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario AND hog.seqParentesco = 1
    LEFT  JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
    LEFT  JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
    LEFT  JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
    LEFT  JOIN T_PRY_TECNICO tec ON und.seqUnidadProyecto = tec.seqUnidadProyecto
    LEFT JOIN T_PRY_ESTADO_UNIDAD est ON est.seqEstadoUnidad = und.seqEstadoUnidad
    WHERE pry.seqProyectoGrupo in (1,2)
";

//echo $sql."<br>"; die();
$arrRegistros = $aptBd->GetAll($sql);
foreach ($arrRegistros as $numLinea => $arrRegistro) {
    if (trim($arrRegistro['txtNombreProyectoPadre']) == "") {
        $txtProyecto = $arrRegistro['txtNombreProyecto'];
        $txtConjunto = "";
    } else {
        $txtProyecto = $arrRegistro['txtNombreProyectoPadre'];
        $txtConjunto = $arrRegistro['txtNombreProyecto'];
    }
    $arrRegistros[$numLinea]['txtNombreProyectoPadre'] = $txtProyecto;
    $arrRegistros[$numLinea]['txtNombreProyecto'] = $txtConjunto;

    if (trim($arrRegistro['estado']) == "") {
        $arrRegistros[$numLinea]['estado'] = "Ninguno";
    }
}

$txtSeparador = "\t";
$txtSalto = "\r\n";

//$txtSeparador = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//$txtSalto     = "<br>";

$txtArchivo = "Proyecto" . $txtSeparador;
$txtArchivo .= "Conjunto Residencial" . $txtSeparador;
$txtArchivo .= "seqUnidadProyecto" . $txtSeparador;
$txtArchivo .= "Unidad Proyecto" . $txtSeparador;
$txtArchivo .= "Nombre Unidad Referencia" . $txtSeparador;
$txtArchivo .= "Nombre Unidad Auxiliar" . $txtSeparador;
$txtArchivo .= "Valor Aprobado" . $txtSeparador;
$txtArchivo .= "Valor Complementario" . $txtSeparador;
$txtArchivo .= "Valor Actual" . $txtSeparador;
$txtArchivo .= "Viabilidad Técnica" . $txtSeparador;
$txtArchivo .= "seqFormulario" . $txtSeparador;
$txtArchivo .= "Documento" . $txtSeparador;
$txtArchivo .= "Nombre" . $txtSeparador;
$txtArchivo .= "txtFormulario" . $txtSeparador;
$txtArchivo .= "Estado del Proceso" . $txtSeparador;
$txtArchivo .= "Matrícula Inmobiliaria" . $txtSeparador;
$txtArchivo .= "Legalizado" . $txtSeparador;
$txtArchivo .= "Fecha Legalizado" . $txtSeparador;
$txtArchivo .= "Devolución" . $txtSeparador;
$txtArchivo .= "Plan de Gobierno" . $txtSeparador;
$txtArchivo .= "Modalidad" . $txtSeparador;
$txtArchivo .= "Esquema" . $txtSeparador;
$txtArchivo .= "Activo" . $txtSeparador;
$txtArchivo .= "Estado" . $txtSeparador;
$txtArchivo .= $txtSalto;
foreach ($arrRegistros as $arrRegistro) {
    $txtArchivo .= implode($txtSeparador, $arrRegistro) . $txtSalto;
}

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=analisisUnidadesAsignadas.xls");

echo utf8_decode($txtArchivo);
