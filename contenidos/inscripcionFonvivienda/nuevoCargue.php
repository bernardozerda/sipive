<?php

/**
 * FORMULARIO PARA EL NUEVO CARGUE DE ARCHIVOS DE FONVIVIENDA
 */

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$claInscripcion = new InscripcionFonvivienda();

if(isset($_POST['crear']) and intval($_POST['crear']) == 1) {
    $claInscripcion->validarTitulos();
    if(empty($claInscripcion->arrErrores)){
        $claInscripcion->crearCargue();
    }
}

$claSmarty->assign("bolPendientes" , $claInscripcion->hayCarguesPendientes());
$claSmarty->assign("claInscripcion", $claInscripcion);
$claSmarty->display("inscripcionFonvivienda/nuevoCargue.tpl")

?>