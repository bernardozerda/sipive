<?php

ini_set("memory_limit","-1");

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

    $arrFormato[3] = "fecha";
    $arrFormato[5] = "fecha";
    $arrFormato[9] = "fecha";

    $arrArchivo = cargarArchivo("archivo", $arrFormato);

    if(empty($arrArchivo['errores'])){

        $arrEstados = estadosProceso();

        $sql = "
            select 
                fac.seqFormulario,
                fac.seqFormularioActo,
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
            $txtEstado     = trim($arrLinea[10]);

            $seqFormularioActo = intval($arrFormularios[$numResolucion . "-" . $fchResolucion][$seqFormulario]);
            if($seqFormularioActo == 0){
                $arrArchivo['errores'][] = "Error Linea " . ( $numLinea + 1 ) . ": No existe formulario relacionado con el acto administrativo";
            }

            $seqEstadoProceso = 0;
            if(! in_array($txtEstado, $arrEstados)){
                $arrArchivo['errores'][] = "Error Linea " . ( $numLinea + 1 ) . ": El estado no existe";
            }else{
                $seqEstadoProceso = array_shift(array_keys($arrEstados,$txtEstado));
            }

            $arrSql[] = "update t_aad_formulario_acto set seqEstadoProceso = $seqEstadoProceso where seqFormularioActo = $seqFormularioActo";

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

$claSmarty->assign("arrErrores",$arrArchivo['errores']);
$claSmarty->assign("arrMensajes",$arrMensajes);
$claSmarty->display( "subsidios/mantenimientoFac.tpl" );

?>