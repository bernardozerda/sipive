<?php

   // Esta variable de usa para ubicar los archivos a incluir
   $txtPrefijoRuta = "../";
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   
   if( intval( $_GET['cuenta'] ) != 0 ){
      
      $sql = "
         UPDATE T_WSE_CUENTAS SET
            bolActivo = 1
         WHERE seqCuenta = " . intval( $_GET['cuenta'] ) . "
      ";
      $aptBd->execute( $sql );
      
      $claSmarty->display( "webservice/activacion.tpl" );
   }
   
?>
