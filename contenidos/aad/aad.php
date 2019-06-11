<?php

/**
 * MODULO DE ACTOS ADMINISTRATIVOS
 * @author Bernardo Zerda
 * @version 4.0 Junio de 2018
 */
echo "prueba";
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );

$claTipoActo = new aadTipo();
$claActosAdministrativos = new aad();

// obtiene la informacion de los tipos de actos administrativos
$arrTipoActo = $claTipoActo->cargarTipoActo();

// obtener el archivo
$arrArchivo = $claActosAdministrativos->cargarArchivo();
foreach($arrArchivo as $numLinea => $arrLinea){
    foreach($arrLinea as $numColumna => $txtValor){
        $arrDocumentos[] = $txtValor;
    }
}

// obtiene el listado de los actos con filtros
$arrActos = $claActosAdministrativos->listarActos(
    $_POST['seqTipoActo'],
    mb_ereg_replace("[^0-9]","",$_POST['numActo']),
    $_POST['fchInicial'],
    $_POST['fchFinal'],
    $arrDocumentos
);

$claSmarty->assign( "arrPost" , $_POST );
$claSmarty->assign( "arrTipoActo" , $arrTipoActo );
$claSmarty->assign( "arrActos"    , $arrActos    );
$claSmarty->display( "aad/aad.tpl" );

?>