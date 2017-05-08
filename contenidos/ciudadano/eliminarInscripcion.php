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
   
   setlocale(LC_TIME , 'spanish' );
   date_default_timezone_set("America/Bogota");

   $arrRespuesta = array();
   $claFormulario = new FormularioSubsidios();
   $claFormulario->cargarFormulario( $_POST['formulario'] );

   foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
      if( $objCiudadano->seqParentesco == 1 ){
         $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
         $txtNombre  = trim( $objCiudadano->txtNombre1 ) . " ";
         $txtNombre .= ( trim( $objCiudadano->txtNombre2 ) != "" )? trim( $objCiudadano->txtNombre2 ) . " " : "";
         $txtNombre .= trim( $objCiudadano->txtApellido1 ) . " ";
         $txtNombre .= trim( $objCiudadano->txtApellido2 );
         break;
      }
   }
   
   $sql = "SET foreign_key_checks = 0";
   $aptBd->execute( $sql );
   
   $sql = "
      INSERT INTO T_SEG_SEGUIMIENTO (
         seqFormulario, 
         fchMovimiento, 
         seqUsuario, 
         txtComentario, 
         txtCambios, 
         numDocumento, 
         txtNombre, 
         seqGestion, 
         bolMostrar
      ) VALUES (
         " . $_POST['formulario'] . ", 
         now(), 
         1, 
         'Hogar eliminado mediante la pagina de servicios al ciudadano', 
         '', 
         $numDocumento, 
         '$txtNombre', 
         40, 
         1
      )
   ";
   $aptBd->execute( $sql );
   
   $sql = "
      DELETE 
      FROM T_FRM_HOGAR
      WHERE seqFormulario = " . $_POST['formulario'] . "
   ";
   $aptBd->execute( $sql );
   
   foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
      
      $sql = "
         DELETE 
         FROM T_CIU_CIUDADANO
         WHERE seqCiudadano = $seqCiudadano
      ";
      $aptBd->execute( $sql );
      
   }

   $sql = "
      DELETE 
      FROM T_FRM_FORMULARIO
      WHERE seqFormulario = " . $_POST['formulario'] . "
   ";
   $aptBd->execute( $sql );
   
   $sql = "SET foreign_key_checks = 1";
   $aptBd->execute( $sql );
   
   echo "
      <center>
      <div class='alert alert-info fade in'>
      <button type='button' class='close' data-dismiss='alert'>×</button>
      <h4 class='alert-heading'>Transacci&oacute;n exitosa</h4>
      <div style='width:650px;'><ul>
         De acuerdo con su solicitud, hemos eliminado sus datos de nuestro sistema, en caso de que quiera
         volver a inscribirse para obtener el subsidio distrital de vivienda, deber&aacute; acercarse a 
         los puntos de atenci&oacute;n de la Secretar&iacute;a Distrital de H&aacute;bitat para realizar el 
         proceso. Si tiene dudas por favor comun&iacute;quese con nosotros al tel&eacute;fono 
         358 1600 Extensiones 1006, 1007, 1008 o 1009.<br>
         <button onClick=\"location.href='index.php';\" class='btn btn-primary'>Terminar</button>
      </ul></div></div>
      </center>
   "; 
   
?>
