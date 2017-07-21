<?php

/**
 * ESTE ES EL CODIGO QUE MUESTRA LOS INDICADORES POR PERFILES
 * 
 */
if (!file_exists($txtPrefijoRuta . "recursos/archivos/verificarSesion.php")) {
    $txtPrefijoRuta = "../../";
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRMProyecto.class.php" );
} else {
    $txtPrefijoRuta = "";
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );

    include 'librerias/clases/CRMProyecto.class.php';
}

$claCrm = new CRMProyecto;
//var_dump($_SESSION);
//$arrGrupoPermitido[ proyecto ][ grupo ] = grupoProyecto
$arrGrupoPermitidos[3][9] = 10;
$arrGrupoPermitidos[3][7] = 8;

$seqProyecto = $_SESSION["seqProyecto"];

$bolGrupoPermitido = false;
foreach ($_SESSION["arrGrupos"][$seqProyecto] as $seqGrupo => $seqProyectoGrupo) {
    if (isset($arrGrupoPermitidos[$seqProyecto][$seqGrupo]) and ( $arrGrupoPermitidos[$seqProyecto][$seqGrupo] == $seqProyectoGrupo )) {
        $bolGrupoPermitido = true;
    }
}
if ($bolGrupoPermitido) {

    $txtPlantilla = "crm/panel/panel.tpl";

    $arrEstado = array();

    $arrEstado[62] = "Revisión Documental";
    $arrEstado[17] = "Cargue Información Solución";
    $arrEstado[19] = "Captura datos Escrituracion";
    $arrEstado[22] = "Cargue Datos Escrituración";
    $arrEstado[23] = "Migración Estudios Técnicos";
    $arrEstado[25] = "Generación Certificado Habitabilidad";
    $arrEstado[26] = "Estudio de Titulos";
    $arrEstado[27] = "Cargue Datos Estudio Títulos";
    $arrEstado[31] = "Consolidación Documental";
    $arrEstado[29] = "Cierre Legalizado";

    $listEstados = "62,17,19,22,23,25,26,27,31,29";
//$arrProyectos = $claCrm->obtenerListaProyectos();
    $arrayGroupProyect = $claCrm->obtenerGroupProyectos($listEstados, $arrEstado);
    $arrDatosProyectos = $claCrm->obtenerDatosProyectos($listEstados, $arrEstado);
    $totalUnidades = $claCrm->totalUnidades(1);
    $totalPorVincular = $claCrm->totalUnidades(2);
    $totalPostuladas = $claCrm->totalUnidades(3);
    $totalVinculadas = $claCrm->totalUnidades(4);
    $totalUnidadesXProy = $claCrm->totalUnidadesPorProyecto(1);
    $totalPorVincularXProy = $claCrm->totalUnidadesPorProyecto(2);
    $totalPostuladasXProy = $claCrm->totalUnidadesPorProyecto(3);
    $totalVinculadasXProy = $claCrm->totalUnidadesPorProyecto(4);
    $totalLegalizadasXProy = $claCrm->totalUnidadesPorProyecto(5);
    $totalProcesoLeg = $claCrm->totalUnidadesPorProyecto(6);
    $totalDevExpedientes = $claCrm->totalUnidadesPorProyecto(7);
    $totalLegalizadas = $claCrm->totalLegalizadas(0);
//echo($totalLegalizadas[0]['cant']);
    $sumaTotalLegalizados = 0;
    foreach ($arrayGroupProyect as $key => $value) {
        foreach ($arrEstado as $keyEstado => $valueEstado) {
            $valueEstado = str_replace(" ", "", $valueEstado);
            $valueEstado = $claCrm->quitarTildes($valueEstado);
            $sumaTotalLegalizados += $value['val' . $valueEstado];
        }
    }

    foreach ($totalProcesoLeg as $key => $value) {
        $totalProcesoLeg = $value['cant'];
    }
    foreach ($totalDevExpedientes as $key => $value) {
        $totalDevExpedientes = $value['cant'];
    }
//print_r($sumaTotalLegalizados);
    $arrayCantProy = Array();
    //var_dump($arrayGroupProyect);

    $claSmarty->assign("arrEstados", $arrEstado);
    $claSmarty->assign("arrGroupProyecto", $arrayGroupProyect);
    $claSmarty->assign("arrProyecto", $arrDatosProyectos);
    $claSmarty->assign("totalUnidades", $totalUnidades);
    $claSmarty->assign("totalPorVincular", $totalPorVincular);
    $claSmarty->assign("totalPostuladas", $totalPostuladas);
    $claSmarty->assign("totalVinculadas", $totalVinculadas);
    $claSmarty->assign("totalPorLegalizar", $sumaTotalLegalizados);
    $claSmarty->assign("totalLegalizadas", $totalLegalizadas[0]['cant']);
    $claSmarty->assign("totalUnidadesXProy", $totalUnidadesXProy);
    $claSmarty->assign("totalPorVincularXProy", $totalPorVincularXProy);
    $claSmarty->assign("totalPostuladasXProy", $totalPostuladasXProy);
    $claSmarty->assign("totalVinculadasXProy", $totalVinculadasXProy);
    $claSmarty->assign("totalLegalizadasXProy", $totalLegalizadasXProy);
    $claSmarty->assign("totalProcesoLeg", $totalProcesoLeg[0]);
    $claSmarty->assign("totalDevExpedientes", $totalDevExpedientes);
} else {
    $txtPlantilla = "sinInicio.tpl";
}
$claSmarty->assign("txtArchivoInicio", $txtPlantilla);
?>

