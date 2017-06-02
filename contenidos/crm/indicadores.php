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

if ($_SESSION['seqUsuario'] == 414 || $_SESSION['seqUsuario'] == 425 || $_SESSION['seqUsuario'] == 437 || $_SESSION['seqUsuario'] == 5) {

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
//var_dump($arrayGroupProyect);
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
//print_r($sumaTotalLegalizados);
    $arrayCantProy = Array();


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
} else {
    $txtPlantilla = "sinInicio.tpl";
}
$claSmarty->assign("txtArchivoInicio", $txtPlantilla);
?>

