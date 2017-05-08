<?php

    // posicion relativa de los archivos a incluir
    $txtPrefijoRuta = "../../";
    
    // Autenticacion (si esta logueado no no)
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    
    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Grupo.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Menu.class.php" );
    
    $claMenu = new Menu();
    
    $arrMenu = $claMenu->obtenerHijos( $_SESSION['seqProyecto'] , 0 );
    
    unset( $arrMenu[39] );
    unset( $arrMenu[32] );
    
    foreach( $arrMenu as $seqMenu => $objMenu ){
       
       $txtAyuda = trim( $objMenu->txtEspanol );
       $txtAyuda = mb_ereg_replace("á", "a", $txtAyuda );
       $txtAyuda = mb_ereg_replace("é", "e", $txtAyuda );
       $txtAyuda = mb_ereg_replace("í", "i", $txtAyuda );
       $txtAyuda = mb_ereg_replace("ó", "o", $txtAyuda );
       $txtAyuda = mb_ereg_replace("ú", "u", $txtAyuda );
       $txtAyuda = mb_ereg_replace("[^0-9a-zA-Z]", "", $txtAyuda );
       $txtAyuda = mb_strtolower( "ayuda/html/" . $txtAyuda . ".html" );
       
       if( file_exists( $txtPrefijoRuta . "plantillas/" . $txtAyuda ) ){
          $objMenu->txtAyuda = $txtAyuda;
       }
       
       $objMenu->arrHijos = $claMenu->obtenerHijos( $_SESSION['seqProyecto'], $seqMenu );
       foreach( $objMenu->arrHijos as $seqHijo => $objHijo ){
          
          $txtAyuda = trim( $objHijo->txtEspanol );
          $txtAyuda = mb_ereg_replace("á", "a", $txtAyuda );
          $txtAyuda = mb_ereg_replace("é", "e", $txtAyuda );
          $txtAyuda = mb_ereg_replace("í", "i", $txtAyuda );
          $txtAyuda = mb_ereg_replace("ó", "o", $txtAyuda );
          $txtAyuda = mb_ereg_replace("ú", "u", $txtAyuda );
          $txtAyuda = mb_ereg_replace("[^0-9a-zA-Z]", "", $txtAyuda );
          $txtAyuda = mb_strtolower( "ayuda/html/" . $txtAyuda . ".html" );
          
          if( file_exists( $txtPrefijoRuta . "plantillas/" . $txtAyuda ) ){
             $objMenu->arrHijos[ $seqHijo ]->txtAyuda = $txtAyuda;
          }
          
       }
       $arrMenu[ $seqMenu ] = $objMenu;
    }
    
    $claSmarty->assign( "numAlto" , ( $_POST['alto'] - 50 ) );
    $claSmarty->assign( "arrMenu" , $arrMenu );
    $claSmarty->display( "ayuda/ayuda.tpl" );

?>
