<?php

   // Esta variable de usa para ubicar los archivos a incluir
   $txtPrefijoRuta = "../";
   
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   
   if( $_POST['usuario'] != "" ){
       
      $sql = "
         SELECT seqCuenta
         FROM T_WSE_CUENTAS
         WHERE txtUsuario = '" . $_POST['usuario'] . "'
      ";
      $objRes = $aptBd->execute( $sql );
      if( $objRes->RecordCount() > 0 ){
         echo "<span class='text-error'>Nombre de usuario no disponible</span>";
      }
      
   }
    

?>
