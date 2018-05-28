<?php

    // constantes
    $arrVariables['giroFiducia']['planGobierno'] = array(3);
    $arrVariables['giroFiducia']['modalidad'] = array(12);
    $arrVariables['giroFiducia']['esquema'] = array(12);
    $arrVariables['giroFiducia']['estados'] = array(27,22,23,25,26,28,24,31,29);

    // proyectos
    $sql = "
        select distinct 
          if(frm.txtDireccionSolucion is null or frm.txtDireccionSolucion = '','No Disponible',frm.txtDireccionSolucion) as txtProyecto
        from t_frm_formulario frm
        where frm.seqPlanGobierno in (" . implode("," , $arrVariables['giroFiducia']['planGobierno']) . ")
          and frm.seqModalidad in (" . implode("," , $arrVariables['giroFiducia']['modalidad']) . ")
          and frm.seqTipoEsquema in (" . implode("," , $arrVariables['giroFiducia']['esquema']) . ")
          and frm.seqEstadoProceso in (" . implode("," , $arrVariables['giroFiducia']['estados']) . ")
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
