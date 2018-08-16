<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->procesarCargue($_POST['seqCargue']);
$claInscripcion->cargar($_POST['seqCargue']);

$bolProcesar = false;
foreach($claInscripcion->arrHogares as $numHogar => $arrHogar){
    if($arrHogar['seqEstadoHogar'] == 2){
        $bolProcesar = true;
    }
}

$claSmarty->assign("bolProcesar" , $bolProcesar);
$claSmarty->assign("claInscripcion" , $claInscripcion);
$claSmarty->display("inscripcionFonvivienda/informacion.tpl");

?>