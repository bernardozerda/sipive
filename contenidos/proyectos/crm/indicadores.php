<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$arrGrupoPermitidos[6][1] = 1;
$arrGrupoPermitidos[6][20] = 47;
$arrGrupoPermitidos[6][20] = 46;

$bolGrupoPermitido = false;
//pr($arrGrupoPermitidos);
$txtPlantilla = "";
$arrProyTableroPal = "";
//echo "<p>****".$seqProyecto."</p>";
//pr($_SESSION["arrGrupos"][$seqProyecto]);
foreach ($_SESSION["arrGrupos"][$seqProyecto] as $seqGrupo => $seqProyectoGrupo) {
    if (isset($arrGrupoPermitidos[$seqProyecto][$seqGrupo]) and ( $arrGrupoPermitidos[$seqProyecto][$seqGrupo] == $seqProyectoGrupo )) {
        $bolGrupoPermitido = true;
    }
}
if ($bolGrupoPermitido) {
    $arrProyTableroPal = Proyecto::obtenerDatosProyectosTableroPal();
    $txtPlantilla = "proyectos/crm/tablero.tpl";
    
} else {
    $txtPlantilla = "sinInicio.tpl";
}
$claSmarty->assign("arrProyTableroPal", $arrProyTableroPal);
$claSmarty->assign("txtArchivoInicio", $txtPlantilla);
