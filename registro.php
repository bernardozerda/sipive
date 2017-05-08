<?php
    
    /**
     * FORMULARIO DE REGISTRO PARA LAS CUENTAS
     * DEL WEB SERVICE
     * @author Bernardo Zerda
     * @version 1.0 Septiembre 2013
     */    

    // Esta variable de usa para ubicar los archivos a incluir
    $txtPrefijoRuta = "./";
    
    include( "./recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    
    $claSmarty->display( "registroWs.tpl" );
    
?>
