<?php

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );
   
   $arrTipoActo = array();
   $claTipoActo = new TipoActoAdministrativo();
   $claActo     = new ActoAdministrativo();
   
   // Obtiene los filtros
   $seqTipoActo = intval( $_POST['seqTipoActo'] );
   $numActo = intval( $_POST['numActo'] );
   
   $arrDocumentos = array();
   if( $_FILES['cedulas']['error'] == 0 ){
      $arrDocumentos = file( $_FILES['cedulas']['tmp_name'] );
      foreach( $arrDocumentos as $numLinea => $numDocumento ){
         if( ! is_numeric( trim( $numDocumento ) ) ){
            unset( $arrDocumentos[ $numLinea ] ); 
         }else{
            $arrDocumentos[ $numLinea ] = trim( $numDocumento );
         }
      }
   }
   
   // Obtiene los tipos y actos administrativos que aplican segun los filtros
   $arrTipoActo = $claTipoActo->cargarTipoActo( $seqTipoActo );
   $arrActos    = $claActo->cargarActoAdministrativo( $numActo , null , $arrDocumentos );
     
   // Obtiene los tipos de actos administrativos para filtrar
   foreach( $arrActos as $objActo ){
      $arrSeqTipoActo[] = $objActo->seqTipoActo;
   }
   
   // si no hay resultados en algun tipo de acto no se muestra el tipo de acto
   foreach( $arrTipoActo as $seqTipoActo => $objTipoActo ){
      if( @! in_array( $seqTipoActo , $arrSeqTipoActo ) ){
         unset( $arrTipoActo[ $seqTipoActo ] );
      }
   }
   
   $arrConteo = array();
   foreach( $arrActos as $objActo ){
      $arrConteo[ $objActo->seqTipoActo ]++;
   }
   
   $claSmarty->assign( "arrConteo" , $arrConteo );
   $claSmarty->assign( "arrTipoActo" , $arrTipoActo );
   $claSmarty->assign( "arrActos" , $arrActos );
   $claSmarty->display( "actosAdministrativos/listadoActos.tpl" );

?>
