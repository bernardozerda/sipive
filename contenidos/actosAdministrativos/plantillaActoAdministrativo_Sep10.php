<?php

   /**
    * CONTENIDO DEL POPUP DE AYUDA DE LA PLANTILLA DE ACTOS ADMINISTRATIVOS
    * @author Bernardo Zerda
    * @version 1.0 Enero de 2014
    **/

   $txtPrefijoRuta = "../../";

   include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "ActosAdministrativos2.class.php" );    
   
   $claTipoActo = new TipoActoAdministrativo();
   $arrTipoActo = $claTipoActo->cargarTipoActo( $_POST['seqTipoActo'] );
   $objTipoActo = array_shift( $arrTipoActo );
   
   $arrEstados = estadosProceso();
   
   $claSmarty->assign( "objTipoActo" , $objTipoActo );
   $claSmarty->assign( "arrEstados" , $arrEstados );
   $claSmarty->display( "actosAdministrativos/plantillaActoAdministrativo.tpl" );
   
   
   
?>
