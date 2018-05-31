<?php

    // constantes
    $arrVariables['giroFiducia']['planGobierno'] = array(3);
    $arrVariables['giroFiducia']['modalidad'] = array(12);
    $arrVariables['giroFiducia']['esquema'] = array(12);
    $arrVariables['giroFiducia']['estados'] = array(27,22,23,25,26,28,24,31,29);

    $arrVariables['giroConstructor']['planGobierno'] = array(3);
    $arrVariables['giroConstructor']['modalidad'] = array(12);
    $arrVariables['giroConstructor']['esquema'] = array(12);
    $arrVariables['giroConstructor']['estados'] = array(29);

    // proyectos
    $sql = "
        select distinct 
          if(frm.txtDireccionSolucion is null or frm.txtDireccionSolucion = '','No Disponible',frm.txtDireccionSolucion) as txtProyecto
        from t_frm_formulario frm
        where frm.seqPlanGobierno in (" . implode("," , $arrVariables[$txtTipoGiro]['planGobierno']) . ")
          and frm.seqModalidad in (" . implode("," , $arrVariables[$txtTipoGiro]['modalidad']) . ")
          and frm.seqTipoEsquema in (" . implode("," , $arrVariables[$txtTipoGiro]['esquema']) . ")
          and frm.seqEstadoProceso in (" . implode("," , $arrVariables[$txtTipoGiro]['estados']) . ")
    ";
    $objRes = $aptBd->execute($sql);
    $arrProyectos = array();
    while($objRes->fields){
        $arrProyectos[] = $objRes->fields['txtProyecto'];
        $objRes->MoveNext();
    }

    // bancos
    $arrBancos = obtenerDatosTabla(
        "t_frm_banco",
        array("seqBanco","txtBanco"),
        "seqBanco",
        "seqBanco > 1"
    );

?>
