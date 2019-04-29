<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );

//pr($_POST);
//pr($_FILES);

// Obtiene eL archivo de excel con las cedulas (si hay)
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

$claTipoActo = new aadTipo();
$arrTipoActo = $claTipoActo->cargarTipoActo();

$claActosAdministrativos = new aad();
$arrActos = $claActosAdministrativos->listarActos($_POST['seqTipoActo'],$_POST['numActo'],null,$arrDocumentos);

$claSmarty->assign( "arrTipoActo" , $arrTipoActo );
$claSmarty->assign( "arrActos"    , $arrActos    );
$claSmarty->display( "aad/listado.tpl" );


?>