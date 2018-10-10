<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );

$seqFormulario = intval($_POST['seqFormulario']);
$arrTipoDocumento = obtenerDatosTabla(
    "t_ciu_tipo_documento",
    array("seqTipoDocumento","txtTipoDocumento"),
    "seqTipoDocumento"
);

$arrParentesco = obtenerDatosTabla(
    "t_ciu_parentesco",
    array("seqParentesco","txtParentesco"),
    "seqParentesco"
);

$claFormulario = null;
if($seqFormulario != 0){
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($seqFormulario);
}

$claSmarty->assign( "seqFormulario" , $seqFormulario);
$claSmarty->assign( "arrTipoDocumento" , $arrTipoDocumento);
$claSmarty->assign( "arrParentesco" , $arrParentesco);
$claSmarty->assign( "claFormulario" , $claFormulario );
$claSmarty->display("inscripcionFonvivienda/verHogar.tpl");

?>