<?php

$txtPrefijoRuta = "./";

include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
global $aptBd;
echo $sql = "select seqFormularioActo, "
 . "seqPlanGobierno,"
 . "seqProyecto, 
            seqProyectoHijo,
            seqUnidadProyecto,
            valComplementario,
            valCartaLeasing,
            seqModalidad,
            seqSolucion,
            txtMatriculaInmobiliaria,
            valAspiraSubsidio,
            seqTipoEsquema,
            txtDireccionSolucion,
            seqConvenio from t_aad_formulario_acto 
            ";

$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
     $objRes->fields['seqFormularioActo'];
   $sql = "update t_aad_formulario_acto set seqPlanGobiernoActual =  " . $objRes->fields['seqFormularioActo'] . ", "
            . "seqProyectoActual = '" . $objRes->fields['seqProyecto'] . "', seqProyectoHijoActual =  '" . $objRes->fields['seqProyectoHijo'] . "',"
            . "seqUnidadProyectoActual = '" . $objRes->fields['seqUnidadProyecto'] . "', valComplementarioActual = ' " . $objRes->fields['valComplementario'] . "',"
            . "valCartaLeasingActual = '" . $objRes->fields['valCartaLeasing'] . "', seqModalidadActual =  '" . $objRes->fields['seqModalidad'] . "',"
            . "seqSolucionActual = '" . $objRes->fields['seqSolucion'] . "', txtMatriculaInmobiliariaActual =  '" . $objRes->fields['txtMatriculaInmobiliaria'] . "',"
            . "valAspiraSubsidioActual = '" . $objRes->fields['valAspiraSubsidio'] . "', seqTipoEsquemaActual =  '" . $objRes->fields['seqTipoEsquema'] . "',"
            . "seqConvenioActual = '" . $objRes->fields['seqConvenio'] . "', txtDireccionSolucionActual =  '" . $objRes->fields['txtDireccionSolucion'] . "' "
            . "where seqFormularioActo = ".$objRes->fields['seqFormularioActo'];
    $aptBd->execute($sql);

    $objRes->MoveNext();
}