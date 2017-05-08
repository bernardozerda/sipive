<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
   
   $txtResolucion = ( trim( $_POST['resolucion'] ) != "" )? $_POST['resolucion'] : "";
   
   // validaciones para el archivo cargado
   switch( $_FILES['documentos']['error'] ){
      case UPLOAD_ERR_INI_SIZE:
        $arrErrores[] = "El archivo excede el tamaño permitido";
      break;  
      case UPLOAD_ERR_FORM_SIZE:
        $arrErrores[] = "El archivo excede el tamaño permitido";
      break; 
      case UPLOAD_ERR_PARTIAL:
        $arrErrores[] = "El archivo no ha cargado";
      break; 
      case UPLOAD_ERR_NO_FILE:
      break; 
      default:
          $arrDocumentos = mb_split( "\n" , file_get_contents( $_FILES['documentos']['tmp_name'] ) );
      break;
   } 
   
   $claCiudadano = new Ciudadano();
   $txtFormularios = "";
   foreach( $arrDocumentos as $numDocumento ){
      if( is_numeric( trim( $numDocumento ) ) ){
         $seqFormulario = $claCiudadano->formularioVinculado( trim( $numDocumento ) );
         if( $seqFormulario != 0 ){
            $txtFormularios .= "formularios[]=" . $seqFormulario . "&"; 
         }
      }
   }
   $txtFormularios = ( trim( $txtFormularios ) == "" )? "formularios[]=" : $txtFormularios;
   
   $txtParametro = $txtFormularios . "#resolucion=" . $txtResolucion;
   echo $txtParametro;

?>
