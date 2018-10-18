<?php

ini_set("memory_limit","-1");
ini_set("max_execution_time","0");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$arrMensajes = array();

// equivalencias entre los estados a reportar
$arrEstados["DESEMBOLSADO"] = 33;
$arrEstados["DESEMBOLSADO - PENDIENTE REINTEGRO"] = 59;
$arrEstados["DESEMBOLSADO - REINTEGRADO"] = 60;
$arrEstados["DESEMBOLSO - LEGALIZADO"] = 40;
$arrEstados["DESVINCULACION"] = 57;
$arrEstados["EXCLUIDO. VINCULACION"] = 57;
$arrEstados["EXCLUIDO. VIVIENDA GRATUITA"] = 63;
$arrEstados["PERDIDA"] = 21;
$arrEstados["PROCESO DESEMBOLSO"] = 15;
$arrEstados["PROCESO LEGALIZACION"] = 15;
$arrEstados["RENUNCIA"] = 18;
$arrEstados["REVOCADO"] = 58;
$arrEstados["VENCIDO"] = 34;
$arrEstados["VINCULACION"] = 15;
$arrEstados["VINCULACION - LEGALIZADO"] = 40;

if( (! empty($_FILES)) and $_FILES['archivo']['error'] != 4 ) {

    $arrArchivo = cargarArchivo("archivo");

    // validaciones de formato para el archivo
    foreach($arrArchivo['archivo'] as $numLinea => $arrLinea){
        if($numLinea > 0){

            $seqFormulario = intval($arrLinea[2]);
            $numResolucion = intval(mb_ereg_replace("[^0-9]","",$arrLinea[7]));
            $fchResolucion = $arrLinea[9];
            $txtEstado     = trim(mb_strtoupper($arrLinea[10]));

            if($seqFormulario == 0){
                $arrArchivo['errores'][] = "Error linea " . ($numLinea + 1) . ": ID Hogar no válido";
            }

            if($numResolucion == 0){
                $arrArchivo['errores'][] = "Error linea " . ($numLinea + 1) . ": Número de resolución no válido";
            }

            if(! esFechaValida($fchResolucion)){
                $arrArchivo['errores'][] = "Error linea " . ($numLinea + 1) . ": Fecha de resolución no válida (use yyyy-mm-dd)";
            }

            if(! isset($arrEstados[$txtEstado])){
                $arrArchivo['errores'][] = "Error Linea " . ( $numLinea + 1 ) . ": No se encuentra la equivalencia del estado '$txtEstado'";
            }

        }
    }

    if(empty($arrArchivo['errores'])){

        // recoge la equivalencia entre formulario y formulario-acto
        $sql = "
            select 
                fac.seqFormulario,
                fac.seqFormularioActo,
                fac.seqEstadoProceso,
                hvi.numActo,
                hvi.fchActo
            from t_aad_formulario_acto fac
            inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
            where hvi.seqTipoActo = 1
        ";
        $objRes = $aptBd->execute($sql);
        $arrFormularios = array();
        while( $objRes->fields ){

            $seqFormulario     = $objRes->fields['seqFormulario'];
            $seqFormularioActo = $objRes->fields['seqFormularioActo'];
            $seqEstadoProceso  = $objRes->fields['seqEstadoProceso'];
            $numResolucion     = $objRes->fields['numActo'];
            $fchResolucion     = $objRes->fields['fchActo'];

            $arrFormularios[ $numResolucion . "-" . $fchResolucion ][$seqFormulario] = $seqFormularioActo;

            $objRes->MoveNext();
        }

        unset($arrArchivo['archivo'][0]);
        foreach($arrArchivo['archivo'] as $numLinea => $arrLinea) {

            $seqFormulario = intval($arrLinea[2]);
            $numResolucion = intval(mb_ereg_replace("[^0-9]", "", $arrLinea[7]));
            $fchResolucion = $arrLinea[9];
            $txtEstado = trim(mb_strtoupper($arrLinea[10]));

            $seqFormularioActo = intval($arrFormularios[$numResolucion . "-" . $fchResolucion][$seqFormulario]);
            if ($seqFormularioActo == 0) {
                $arrArchivo['errores'][] = "Error Linea " . ($numLinea + 1) . ": No existe formulario relacionado con el acto administrativo";
            }

            $arrSql[] = "update t_aad_formulario_acto set seqEstadoProceso = " . $arrEstados[$txtEstado] . ", fchUltimaActualizacion = now() where seqFormularioActo = $seqFormularioActo";

        }

        if(empty($arrArchivo['errores']) and (!empty($arrSql))) {
            try {
                $aptBd->BeginTrans();
                foreach($arrSql as $sql){
                    $aptBd->execute($sql);
                }
                $arrMensajes[] = "Estado de actos administrativos actualizados, procesadas " . count($arrSql) . " cambios";
                $aptBd->RollBackTrans();
            } catch (Exception $objError) {
                $aptBd->RollBackTrans();
                $arrArchivo['errores'][] = $objError->getMessage();
            }
        }

    }

}

$sql = "
    select distinct
      epr.seqEstadoProceso as seqEstado,
      concat(eta.txtEtapa,' - ',epr.txtEstadoProceso) as txtEstado
    from t_aad_formulario_acto fac
    inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo and hvi.seqTipoActo = 1
    inner join t_frm_estado_proceso epr on fac.seqEstadoProceso = epr.seqEstadoProceso
    inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
    order by concat(eta.txtEtapa,' - ',epr.txtEstadoProceso)
";
$arrEstados = $aptBd->GetAll($sql);

$claSmarty->assign("arrErrores",$arrArchivo['errores']);
$claSmarty->assign("arrMensajes",$arrMensajes);
$claSmarty->assign("arrEstados", $arrEstados);
$claSmarty->display( "subsidios/mantenimientoFac.tpl" );

?>