<?php

   /**
    * MODULO DE ACTOS ADMINISTRATIVOS
    * -- MODIFICACION DEL MODULO DE ASIGNACION --
    * @author Bernardo Zerda
    * @version 2.0 Diciembre de 2013
    */

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
   
   $arrTipoActo = $claTipoActo->cargarTipoActo();
   $arrActos    = $claActo->cargarActoAdministrativo();
   
   $arrConteo = array();
   foreach( $arrActos as $objActo ){
      $arrConteo[ $objActo->seqTipoActo ]++;
   }
   
   $claSmarty->assign( "arrConteo" , $arrConteo );
   $claSmarty->assign( "arrTipoActo" , $arrTipoActo );
   $claSmarty->assign( "arrActos" , $arrActos );
   $claSmarty->display( "actosAdministrativos/actosAdministrativos.tpl" );
   
?>
