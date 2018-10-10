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
    where f.seqPlanGobierno = 3
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

$numTotalHogares = count($arrDatos);
$numHogaresProcesados = 1;
foreach($arrDatos as $seqFormulario => $arrInformacion){

    if($arrInformacion['sumaIngresos'] != $arrInformacion['sumaBaseDatos']){

        echo date("Y-m-d H:i:s") . "\t(" . $seqFormulario . ")\tIngresos Hogar\t";
        echo "Suma: " . number_format($arrInformacion['sumaIngresos'] ) . "\t";
        echo "Base Datos: " . number_format($arrInformacion['sumaBaseDatos'] );
        echo "\r\n";

        $sql = "update t_frm_formulario set valIngresoHogar = " . $arrInformacion['sumaIngresos'] . " where seqFormulario = " . $seqFormulario;
        $objRes = $aptBd->execute($sql);

    }

    if( $arrInformacion['valTotalRecursos'] != $arrInformacion['sumaFinancieros'] ){

        echo date("Y-m-d H:i:s") . "\t(" . $seqFormulario . ")\tFinancieros\t";
        echo "Suma: " . number_format($arrInformacion['sumaFinancieros'] ) . "\t";
        echo "Base Datos: " . number_format($arrInformacion['valTotalRecursos'] );
        echo "\r\n";

        $sql = "update t_frm_formulario set valTotalRecursos = " . $arrInformacion['sumaFinancieros'] . " where seqFormulario = " . $seqFormulario;
        $objRes = $aptBd->execute($sql);
    }

    $numHogaresProcesados++;

}





?>