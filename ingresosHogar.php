<?php

// si se intenta acceder por navegador redirecciona al index
if(isset($_SERVER['HTTP_HOST'])){
    header("Location: " . $txtPrefijoRuta . "index.php");
}

ini_set('memory_limit', '-1');

$txtPrefijoRuta = "./";

// Inclusion de las librerias
include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$sql = "
    select
        f.seqFormulario,
        c.seqCiudadano,
        c.valIngresos,
        f.valIngresoHogar,
        f.valSaldoCuentaAhorro,
        f.valSaldoCuentaAhorro2,
        f.valSubsidioNacional,
        f.valAporteLote,
        f.valSaldoCesantias,
        f.valAporteAvanceObra,
        f.valCredito,
        f.valAporteMateriales,
        f.valDonacion,
        f.valTotalRecursos
    from t_frm_formulario f
    inner join t_frm_hogar h on f.seqformulario = h.seqFormulario
    inner join t_ciu_ciudadano c on h.seqCiudadano = c.seqCiudadano
    where f.seqPlanGobierno in (2,3)
      and f.seqModalidad in (12,13,6)
      and f.seqTipoEsquema in (1,12,16,17,18)
";

$objRes = $aptBd->execute($sql);
$arrDatos = array();
echo date("Y-m-d H:i:s") . "\tInicia Consulta\r\n";
while($objRes->fields){

    $arrDatos[ $objRes->fields['seqFormulario'] ]['datos'][ $objRes->fields['seqCiudadano'] ] = $objRes->fields['valIngresos'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['sumaIngresos'] = ( ! isset($arrDatos[ $objRes->fields['seqFormulario'] ]['sumaIngresos']) )? 0 : $arrDatos[ $objRes->fields['seqFormulario'] ]['sumaIngresos'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['sumaIngresos'] += $objRes->fields['valIngresos'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['sumaBaseDatos'] = $objRes->fields['valIngresoHogar'];

    $arrDatos[ $objRes->fields['seqFormulario'] ]['valSaldoCuentaAhorro'] = $objRes->fields['valSaldoCuentaAhorro'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valSaldoCuentaAhorro2'] = $objRes->fields['valSaldoCuentaAhorro2'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valSubsidioNacional'] = $objRes->fields['valSubsidioNacional'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valAporteLote'] = $objRes->fields['valAporteLote'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valSaldoCesantias'] = $objRes->fields['valSaldoCesantias'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valCredito'] = $objRes->fields['valCredito'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valDonacion'] = $objRes->fields['valDonacion'];
    $arrDatos[ $objRes->fields['seqFormulario'] ]['valTotalRecursos'] = $objRes->fields['valTotalRecursos'];

    $arrDatos[ $objRes->fields['seqFormulario'] ]['sumaFinancieros'] =
        $objRes->fields['valSaldoCuentaAhorro'] +
        $objRes->fields['valSaldoCuentaAhorro2'] +
        $objRes->fields['valSaldoCesantias'] +
        $objRes->fields['valCredito'] +
        $objRes->fields['valAporteLote'] +
        $objRes->fields['valSubsidioNacional'] +
        $objRes->fields['valDonacion'];

    $objRes->MoveNext();

}

try {

    $aptBd->BeginTrans();

    $numTotalHogares = count($arrDatos);
    $numHogaresProcesados = 1;
    $numModificados = 0;
    $numModificadosIngresos = 0;
    $numModificadosFinancieros = 0;
    foreach ($arrDatos as $seqFormulario => $arrInformacion) {

        $bolModificado = false;

        echo date("Y-m-d H:i:s") . "\t$numHogaresProcesados de $numTotalHogares\tProcesando formulario $seqFormulario\r\n";

        if ($arrInformacion['sumaIngresos'] != $arrInformacion['sumaBaseDatos']) {
            $sql = "update t_frm_formulario set valIngresoHogar = " . $arrInformacion['sumaIngresos'] . " where seqFormulario = " . $seqFormulario;
            $objRes = $aptBd->execute($sql);
            $bolModificado = true;
            $numModificadosIngresos++;
        }

        if ($arrInformacion['valTotalRecursos'] != $arrInformacion['sumaFinancieros']) {
            $sql = "update t_frm_formulario set valTotalRecursos = " . $arrInformacion['sumaFinancieros'] . " where seqFormulario = " . $seqFormulario;
            $objRes = $aptBd->execute($sql);
            $bolModificado = true;
            $numModificadosFinancieros++;
        }

        $numHogaresProcesados++;

        if($bolModificado){
            $numModificados++;
        }

    }

    echo "$numModificados hogares modificados de $numHogaresProcesados procesados\r\n";
    echo "$numModificadosIngresos por ingresos\r\n";
    echo "$numModificadosFinancieros por financieros\r\n";

    if( isset($argv[1]) and trim(mb_strtolower($argv[1]))){
        $aptBd->RollbackTrans();
        echo "Los cambios no fueron aplicados\r\n";
    }else{
        $aptBd->CommitTrans();
    }


}catch(Exception $objError){
    echo $objError->getMessage() . "\r\n";

    $aptBd->RollbackTrans();

}

?>