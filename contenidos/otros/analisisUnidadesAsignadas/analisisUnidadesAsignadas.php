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
        und.bolLegalizado,
        pgo.txtPlanGobierno,
        moa.txtModalidad,
        tes.txtTipoEsquema,
        und.fchLegalizado,
        und.bolActivo
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
    WHERE pry.seqTipoEsquema in (1,2)
";
$arrRegistros = $aptBd->GetAll($sql);
foreach($arrRegistros as $numLinea => $arrRegistro){
    if( trim( $arrRegistro['txtNombreProyectoPadre'] ) == "" ){
        $txtProyecto = $arrRegistro['txtNombreProyecto'];
        $txtConjunto = "";
    } else {
        $txtProyecto = $arrRegistro['txtNombreProyectoPadre'];
        $txtConjunto = $arrRegistro['txtNombreProyecto'];
    }
    $arrRegistros[$numLinea]['txtNombreProyectoPadre'] = $txtProyecto;
    $arrRegistros[$numLinea]['txtNombreProyecto'] = $txtConjunto;
}

$txtSeparador = "\t";
$txtSalto     = "\r\n";

//$txtSeparador = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//$txtSalto     = "<br>";

$txtArchivo =  "Proyecto" . $txtSeparador;
$txtArchivo .=  "Conjunto Residencial" . $txtSeparador;
$txtArchivo .=  "seqUnidadProyecto" . $txtSeparador;
$txtArchivo .=  "Unidad Proyecto" . $txtSeparador;
$txtArchivo .=  "Nombre Unidad Referencia" . $txtSeparador;
$txtArchivo .=  "Nombre Unidad Auxiliar" . $txtSeparador;
$txtArchivo .=  "Valor Aprobado" . $txtSeparador;
$txtArchivo .=  "Valor Complementario" . $txtSeparador;
$txtArchivo .=  "Valor Actual" . $txtSeparador;
$txtArchivo .=  "Viabilidad Técnica" . $txtSeparador;
$txtArchivo .=  "seqFormulario" . $txtSeparador;
$txtArchivo .=  "Documento" . $txtSeparador;
$txtArchivo .=  "Nombre" . $txtSeparador;
$txtArchivo .=  "txtFormulario" . $txtSeparador;
$txtArchivo .=  "Estado del Proceso" . $txtSeparador;
$txtArchivo .=  "Matrícula Inmobiliaria" . $txtSeparador;
$txtArchivo .=  "Legalizado" . $txtSeparador;
$txtArchivo .=  "Fecha Legalizado" . $txtSeparador;
$txtArchivo .=  "Plan de Gobierno" . $txtSeparador;
$txtArchivo .=  "Modalidad" . $txtSeparador;
$txtArchivo .=  "Esquema" . $txtSeparador;
$txtArchivo .=  "Activo". $txtSeparador;
$txtArchivo .=  $txtSalto;
foreach( $arrRegistros as $arrRegistro ){
    $txtArchivo .=  implode($txtSeparador,$arrRegistro) . $txtSalto;
}

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=analisisUnidadesAsignadas.xls");

echo utf8_decode($txtArchivo);

//
//die();
//
//
//$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
//mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');
///* $link = mysql_connect('localhost', 'root', 'root') or die('No se pudo conectar: ' . mysql_error());
//  mysql_select_db('sipive_feb10') or die('No se pudo seleccionar la base de datos'); */
//
//header("Content-Type: application/vnd.ms-excel");
//header("content-disposition: attachment;filename=analisisUnidadesAsignadas.xls");
//// Dibuja los titulos de la tabla
//// echo "\r\n";
//    echo "Proyecto"."\t";
//    echo "Conjunto Residencial"."\t";
//    echo "seqUnidadProyecto"."\t";
//    echo "Unidad Proyecto"."\t";
//    echo "Nombre Unidad Referencia"."\t";
//    echo "Nombre Unidad Auxiliar"."\t";
//    echo "Valor Aprobado"."\t";
//    echo "Valor Complementario"."\t";
//    echo "Valor Actual"."\t";
//    echo "Viabilidad T&eacute;cnica"."\t";
//    echo "seqFormulario"."\t";
//    echo "Documento"."\t";
//    echo "Nombre"."\t";
//    echo "txtFormulario"."\t";
//    echo "Estado del Proceso"."\t";
//    echo "Matr&iacute;cula Inmobiliaria"."\t";
//    echo "Legalizado"."\t";
//    echo "Fecha Legalizado"."\t";
//    echo "Plan de Gobierno"."\t";
//    echo "Modalidad\t";
//    echo "Esquema\t";
//    echo "Activo"."\t";
//
//
//$sql = "SELECT txtExistencia, seqUnidadProyecto FROM T_PRY_TECNICO";
//$reg = mysql_query($sql);
//$arrTxtExistencia = Array();
//while ($rows = mysql_fetch_array($reg)) {
//    $arrTxtExistencia[$rows['seqUnidadProyecto']] = $rows['seqUnidadProyecto'];
//
//}
////var_dump($arrTxtExistencia);
//
////exit();
//// Recorrer las unidades residenciales de esquema individual
//$query_unidades = "SELECT
//                    und.txtNombreUnidad,
//                    und.seqFormulario,
//                    und.seqProyecto,
//                    und.seqUnidadProyecto,
//                    und.txtNombreUnidadReal,
//                    und.txtNombreUnidadAux,
//                    und.valSDVEAprobado,
//                    und.valSDVEComplementario,
//                    und.valSDVEActual,
//                    und.txtMatriculaInmobiliaria,
//                    und.bolLegalizado,
//                    und.fchLegalizado,
//                    und.bolActivo,
//                    pgo.txtPlanGobierno,
//                    moa.txtModalidad,
//                    tes.txtTipoEsquema
//            FROM T_PRY_UNIDAD_PROYECTO und
//            LEFT JOIN T_PRY_PROYECTO pry ON (und.seqProyecto = pry.seqProyecto)
//            INNER JOIN T_FRM_PLAN_GOBIERNO pgo ON pgo.seqPlanGobierno = und.seqPlanGobierno
//            INNER JOIN T_FRM_MODALIDAD moa ON und.seqModalidad = moa.seqModalidad
//            INNER JOIN T_PRY_TIPO_ESQUEMA tes ON und.seqTipoEsquema = tes.seqTipoEsquema
//            WHERE pry.seqTipoEsquema in (1,2)";
//$execute_unidades = mysql_query($query_unidades);
//
//while ($row_unidades = mysql_fetch_array($execute_unidades)) {
//    $tbl_txtExistencia = '';
//    $key = "";
//    $tbl_nombreUnidad = $row_unidades['txtNombreUnidad'];
//    $tbl_formulario = (int)$row_unidades['seqFormulario'];
//    $tbl_seqProyecto = $row_unidades['seqProyecto'];
//    $tbl_seqUnidadProyecto = $row_unidades['seqUnidadProyecto'];
//    $tbl_txtNombreUnidadReal = $row_unidades['txtNombreUnidadReal'];
//    $tbl_txtNombreUnidadAux = $row_unidades['txtNombreUnidadAux'];
//    $tbl_valSDVEAprobado = $row_unidades['valSDVEAprobado'];
//    $tbl_valSDVEComplementario = $row_unidades['valSDVEComplementario'];
//    $tbl_valSDVEActual = $row_unidades['valSDVEActual'];
//    $tbl_txtMatriculaInmobiliaria = $row_unidades['txtMatriculaInmobiliaria'];
//    $tbl_bolLegalizado = $row_unidades['bolLegalizado'];
//    $tbl_fchLegalizado = $row_unidades['fchLegalizado'];
//    $tbl_bolActivo = $row_unidades['bolActivo'];
//    $tbl_planGobierno = $row_unidades['txtPlanGobierno'];
//    $tbl_modalidad = $row_unidades['txtModalidad'];
//    $tbl_tipoEsquema = $row_unidades['txtTipoEsquema'];
//
//    $key = array_search($tbl_seqUnidadProyecto, ($arrTxtExistencia));
//    if($key != "" ){
//        $tbl_txtExistencia = "SI";
//    }
//
//    // Si la unidad está asignada a algún proyecto recibe los datos del tomador de la unidad.
//    if ($tbl_formulario > 1) {
//        $query_detalle = "SELECT frm.seqFormulario,
//                                frm.txtFormulario,
//                                pry.txtNombreProyecto AS 'proyecto',
//                                prh.txtNombreProyecto AS 'proyectoHijo',
//                                UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'nombrePpal',
//                                ciu.numDocumento AS 'documentoPpal',
//                                CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'estadoProceso'
//                FROM T_FRM_FORMULARIO frm
//                LEFT JOIN T_PRY_PROYECTO pry ON (frm.seqProyecto = pry.seqProyecto)
//                LEFT JOIN T_PRY_PROYECTO prh ON (frm.seqProyectoHijo = prh.seqProyecto)
//                LEFT JOIN T_FRM_HOGAR hog ON (frm.seqFormulario = hog.seqFormulario)
//                LEFT JOIN T_CIU_CIUDADANO ciu ON (hog.seqCiudadano = ciu.seqCiudadano)
//                LEFT JOIN T_FRM_ESTADO_PROCESO epr ON (frm.seqEstadoProceso = epr.seqEstadoProceso)
//                LEFT JOIN T_FRM_ETAPA eta ON (epr.seqEtapa = eta.seqEtapa)
//                WHERE hog.seqParentesco = 1
//                AND frm.seqFormulario = $tbl_formulario";
//        $execute_detalle = mysql_query($query_detalle);
//        while ($row_detalle = mysql_fetch_array($execute_detalle)) {
//            $tbl_nombrePpal = $row_detalle['nombrePpal'];
//            $tbl_estadoProceso = $row_detalle['estadoProceso'];
//            $tbl_txtFormulario = $row_detalle['txtFormulario'];
//            $tbl_documentoPpal = $row_detalle['documentoPpal'];
//            $tbl_proyecto = $row_detalle['proyecto'];
//            $tbl_proyectoHijo = $row_detalle['proyectoHijo'];
//        }
//    } else { // Si la unidad está libre muestra los datos del proyecto
//        //desde
//        $query_proyecto = "SELECT p.txtNombreProyecto AS 'padre',
//                                    h.txtNombreProyecto AS 'hijo'
//                                    FROM	T_PRY_PROYECTO p
//                                    LEFT JOIN T_PRY_PROYECTO h ON (p.seqProyectoPadre = h.seqProyecto)
//                                    WHERE	p.seqProyecto = $tbl_seqProyecto";
//        $execute_proyecto = mysql_query($query_proyecto);
//        $row_proyecto = mysql_fetch_array($execute_proyecto);
//
//        if ($row_proyecto['hijo'] != "") {
//            $tbl_proyecto = $row_proyecto['hijo'];
//            $tbl_proyectoHijo = $row_proyecto['padre'];
//        } else {
//            $tbl_proyecto = $row_proyecto['padre'];
//            $tbl_proyectoHijo = "";
//        }
//        //hasta
//        $tbl_nombrePpal = '';
//        $tbl_estadoProceso = '';
//        $tbl_txtFormulario = '';
//        $tbl_documentoPpal = '';
//    }
//    echo "\r\n";
//    echo $tbl_proyecto."\t";
//    echo $tbl_proyectoHijo."\t";
//    echo $tbl_seqUnidadProyecto."\t";
//    echo $tbl_nombreUnidad."\t";
//    echo $tbl_txtNombreUnidadReal."\t";
//    echo $tbl_txtNombreUnidadAux."\t";
//    echo $tbl_valSDVEAprobado."\t";
//    echo $tbl_valSDVEComplementario."\t";
//    echo $tbl_valSDVEActual."\t";
//    echo $tbl_txtExistencia."\t";
//    echo $tbl_formulario."\t";
//    echo $tbl_documentoPpal."\t";
//    echo utf8_decode($tbl_nombrePpal)."\t";
//    echo $tbl_txtFormulario."\t";
//    echo $tbl_estadoProceso."\t";
//    echo $tbl_txtMatriculaInmobiliaria."\t";
//    echo $tbl_bolLegalizado."\t";
//    echo $tbl_fchLegalizado."\t";
//    echo $tbl_planGobierno ."\t";
//    echo $tbl_modalidad ."\t";
//    echo $tbl_tipoEsquema ."\t";
//    echo $tbl_bolActivo."\t";
//
//}
//
//echo "</table>";
//
//// Liberar resultados
////mysql_free_result($result);
//// Cerrar la conexión
//mysql_close($link);
?>