<?php

   // Ruta relativa 
	$txtPrefijoRuta = "../../";

	// Archivos necesarios
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php"                   );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php"    );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
   
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "FormularioSubsidios.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Preguntas.class.php" );
   
   // Elimian cualquier sesion iniciada
   unset( $_SESSION );
   
   $numDocumento = intval( $_POST['documento'] );
   $claPreguntas = new Preguntas();
   $claCiudadano = new Ciudadano();
   
   // Primero se verifica que la cedula este inscrita en el programa y que no tenga bloqueos
   $bolBloqueado = true;
   $fchFinBloqueo = $claPreguntas->obtenerBloqueo( $numDocumento );
   if( $fchFinBloqueo !== false ){
      if( time() > strtotime( $fchFinBloqueo ) ){
         $bolBloqueado = false;
      }
   } else {
      $bolBloqueado = false;
   }
   
   if( $bolBloqueado ){
   
      echo "
         <center>
         <div class='alert alert-error fade in'>
         <button type='button' class='close' data-dismiss='alert'>×</button>
         <h4 class='alert-heading'>Lo sentimos:</h4>
         <div style='width:700px;'><ul>
            La Secretar&iacute;a Distrital de H&aacute;bitat le informa que por motivos de seguridad de la informaci&oacute;n
            usted podr&aacute; volver a usar este servicio de consulta hasta el " . $fchFinBloqueo . ". 
            Si tiene alguna inquietud por favor comun&iacute;quese con la  al tel&eacute;fono 
            358 1600 Extensiones 1006, 1007, 1008 o 1009.<br>
            <button onClick=\"location.href='index.php';\" class='btn btn-danger'>Volver</button>
         </ul></div></div>
         </center>
      ";
         
   } else {
         
      $seqFormulario = $claCiudadano->formularioVinculado( $numDocumento );
      if( $seqFormulario != 0 ){
         $arrPreguntas = $claPreguntas->obtenerPregunta( $numDocumento );
      }

      $claSmarty->assign( "numDocumento" , $numDocumento );
      $claSmarty->assign( "arrPreguntas" , $arrPreguntas );
      $claSmarty->display( "ciudadano/ciudadano.tpl" );
   
   }   
      
?>
