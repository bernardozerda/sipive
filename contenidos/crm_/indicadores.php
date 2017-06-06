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
}
//echo "<br>********" . $bolIndicador;
$seqProyecto = $_SESSION['seqProyecto'];
$bolIndicador = false;
$txtPlantilla = "sinInicio.tpl";
$seqGrupo = 0;
$txtSecuencialesGrupos = implode(" , ", array_keys($_SESSION['arrGrupos'][$seqProyecto]));

if (isset($_POST["seqGrupo"])) {
    $seqGrupo = $_POST["seqGrupo"];
}

$sql = "
			SELECT 
				seqGrupo, 
				txtGrupo
			FROM T_COR_GRUPO
			WHERE seqGrupo IN ( $txtSecuencialesGrupos )
			";
$objRes = $aptBd->execute($sql);
$arrGruposUsuario = array();
while ($objRes->fields) {
    $arrGruposUsuario[$objRes->fields['seqGrupo']] = $objRes->fields['txtGrupo'];
    $objRes->MoveNext();
}

if ($seqGrupo == 0) {
    switch (true) {

        // Indicadores Tutores de Desembolso
        // Coordinadores = 7
        // Tutores Desembolso = 8
        // Directivos = 18
        case ( in_array(7, array_keys($arrGruposUsuario)) ):
        case ( in_array(8, array_keys($arrGruposUsuario)) ):
        case ( in_array(18, array_keys($arrGruposUsuario)) ):
            $txtContenidoIndicadores = "crm/indicadoresTutoresDesembolsoListener.tpl";
            $claSmarty->assign("seqGrupoSeleccionado", 8);
            $bolIndicador = true;
            break;

        // Indicadores para el grupo Solicitud Desembolso
        // Grupo Desembolso = 9
        case ( in_array(9, array_keys($arrGruposUsuario)) ):
            $txtContenidoIndicadores = "crm/indicadoresSolicitudDesembolsoBase.tpl";
            $claSmarty->assign("seqGrupoSeleccionado", 9);
            $bolIndicador = true;
            break;
    }
} else {

    switch (true) {

        // Indicadores Tutores de Desembolso
        // Coordinadores = 7
        // Tutores Desembolso = 8
        // Directivos = 18
        case ( $seqGrupo == 7 and in_array(7, array_keys($arrGruposUsuario)) ):
        case ( $seqGrupo == 8 and in_array(8, array_keys($arrGruposUsuario)) ):
        case ( $seqGrupo == 18 and in_array(18, array_keys($arrGruposUsuario)) ):
            $txtContenidoIndicadores = "crm/indicadoresTutoresDesembolsoListener.tpl";
            $claSmarty->assign("seqGrupoSeleccionado", 8);
            $bolIndicador = true;
            break;

        // Indicadores para el grupo tutores
        // Grupo Desembolso = 8
        case ( $seqGrupo == 8 and in_array(8, array_keys($arrGruposUsuario)) ):
            $txtContenidoIndicadores = "crm/indicadoresTutoresDesembolsoListener.tpl";
            $claSmarty->assign("seqGrupoSeleccionado", 8);
            $bolIndicador = true;
            break;

        // Indicadores para el grupo Solicitud Desembolso
        // Grupo Desembolso = 9
        case ( $seqGrupo == 9 and in_array(9, array_keys($arrGruposUsuario)) ):
            $txtContenidoIndicadores = "crm/indicadoresSolicitudDesembolsoBase.tpl";
            $claSmarty->assign("seqGrupoSeleccionado", 9);
            $bolIndicador = true;
            break;
    }
}
$bolIndicador = false;
echo "<br>********" . $bolIndicador;
if ($bolIndicador === true) {
    $txtPlantilla = "crm/baseIndicadores.tpl";
}
$claSmarty->assign("txtContenidoIndicadores", $txtContenidoIndicadores);
$claSmarty->assign("arrGruposUsuario", $arrGruposUsuario);
$claSmarty->assign("txtArchivoInicio", $txtPlantilla);

if ($seqGrupo) {
    $claSmarty->display($txtPlantilla);
}
?>
