<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$arrTipoDocumento = obtenerDatosTabla(
    "t_ciu_tipo_documento",
    array("seqTipoDocumento","txtTipoDocumento"),
    "seqTipoDocumento"
);

$sql = "
    SELECT 
        bor.seqFormulario,
        tdo.txtTipoDocumento,
        bor.numDocumento,
        bor.txtNombre,
        bor.fchBorrado,
        bor.txtComentario
    FROM t_frm_borrado bor
    INNER JOIN t_ciu_tipo_documento tdo ON tdo.seqTipoDocumento = bor.seqTipoDocumento
    ORDER BY bor.fchBorrado DESC
";
$arrBorrados = $aptBd->GetAll($sql);

$claSmarty->assign( "arrTipoDocumento" , $arrTipoDocumento );
$claSmarty->assign( "arrBorrados" , $arrBorrados );
$claSmarty->display( "eliminarFormulario/buscar.tpl" );

?>
