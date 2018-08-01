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

if( (! empty($_FILES)) and $_FILES['archivo']['error'] != 4 ) {

    $arrArchivo = cargarArchivo("archivo");

    if(empty($arrArchivo['errores'])){

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
        foreach($arrArchivo['archivo'] as $numLinea => $arrLinea){

            $seqFormulario = $arrLinea[2];
            $numResolucion = mb_ereg_replace("[^0-9]","",$arrLinea[7]);
            $fchResolucion = $arrLinea[9];
            $txtEstado     = trim(mb_strtoupper($arrLinea[10]));

            $seqFormularioActo = intval($arrFormularios[$numResolucion . "-" . $fchResolucion][$seqFormulario]);
            if($seqFormularioActo == 0){
                $arrArchivo['errores'][] = "Error Linea " . ( $numLinea + 1 ) . ": No existe formulario relacionado con el acto administrativo";
            }

            $seqEstadoProceso = 0;
            if(! isset($arrEstados[$txtEstado])){
                $arrArchivo['errores'][] = "Error Linea " . ( $numLinea + 1 ) . ": No se encuentra la equivalencia del estado '$txtEstado'";
            }else{
                $seqEstadoProceso = $arrEstados[$txtEstado];
            }

            $arrSql[] = "update t_aad_formulario_acto set seqEstadoProceso = $seqEstadoProceso, fchUltimaActualizacion = now() where seqFormularioActo = $seqFormularioActo";

        }

        if(empty($arrArchivo['errores'])) {
            try {
                $aptBd->BeginTrans();
                foreach($arrSql as $sql){
                    $aptBd->execute($sql);
                }
                $arrMensajes[] = "Estado de actos administrativos actualizados, procesadas " . count($arrSql) . " cambios";
                $aptBd->CommitTrans();
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