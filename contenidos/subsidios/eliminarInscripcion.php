<?php

   $txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
   include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );

   $claCiudadano  = new Ciudadano();
   $claFormulario = new FormularioSubsidios();
    
   switch( true ){
      case isset( $_POST['cedula'] ):

         $numDocumentoFormat = mb_ereg_replace( "[^0-9]" , "" , $_POST['cedula'] );
         $seqFormulario = $claCiudadano->formularioVinculado( $numDocumentoFormat , false , true );
         if( $seqFormulario != 0 ){
            $arrEstados = estadosProceso( 0 , 1 );
            $claFormulario->cargarFormulario( $seqFormulario );
            if( isset( $arrEstados[ $claFormulario->seqEstadoProceso ] ) ){

               $claFormulario->txtCiudad    = obtenerNombres("T_FRM_CIUDAD", "seqCiudad", $claFormulario->seqCiudad );
               $claFormulario->txtLocalidad = obtenerNombres("T_FRM_LOCALIDAD", "seqLocalidad", $claFormulario->seqLocalidad );
               if( trim( $claFormulario->txtBarrio ) == "" ){
                  $claFormulario->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $claFormulario->seqBarrio );
               }

               foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                  $claFormulario->arrCiudadano[ $seqCiudadano ]->txtTipoDocumento = obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $objCiudadano->seqTipoDocumento );
                  $claFormulario->arrCiudadano[ $seqCiudadano ]->txtParentesco = obtenerNombres("T_CIU_PARENTESCO", "seqParentesco", $objCiudadano->seqParentesco );
               }
               
               $claFormulario->txtModalidad = obtenerNombres("T_FRM_MODALIDAD", "seqModalidad", $claFormulario->seqModalidad );
               $claFormulario->txtSolucion =  obtenerNombres("T_FRM_SOLUCION", "seqSolucion", $claFormulario->seqSolucion );
               
               $claSmarty->assign( "seqFormulario" , $seqFormulario );
               $claSmarty->assign( "claFormulario" , $claFormulario );
               $claSmarty->display( "subsidios/eliminarInscripcion.tpl" );
               
            }else {
               $arrErrores[] = "No puede eliminar un formulario que no esta en la etapa de inscripci&oacute;n";
            }
         }else{
            $arrErrores[] = "El numero de documento no est&aacute; registrado o pertenece a un menor de edad";
         }

      break;
      case isset( $_POST['eliminar'] ):

         if( $_POST['txtComentario'] == "" ){
            $arrErrores[] = "Por favor diligencie el campo de comentarios";
         } else {

            // Borrado del formulario
            $claFormulario->cargarFormulario( $_POST['formulario'] );
            foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
               if( $objCiudadano->seqParentesco == 1 ){
                  
                  $txtNombre  = trim( $objCiudadano->txtNombre1 ) . " ";
                  $txtNombre .= ( trim( $objCiudadano->txtNombre2 ) == "" )? "" : trim( $objCiudadano->txtNombre2 ) . " ";
                  $txtNombre .= trim( $objCiudadano->txtApellido1 ) . " ";
                  $txtNombre .= trim( $objCiudadano->txtApellido2 );
                  $seqParentesco = $objCiudadano->seqParentesco;
                  $numDocumento = mb_ereg_replace( "[^0-9]" , "" , $objCiudadano->numDocumento );
                  
                  break;
               }
            }

            $arrSql[] = "SET foreign_key_checks = 0";
            $arrSql[] = "DELETE FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS WHERE seqFormulario = " . $_POST['formulario'] . ";";
            $arrSql[] = "DELETE FROM T_SEG_SEGUIMIENTO WHERE seqFormulario = " . $_POST['formulario'] . ";";
            $arrSql[] = "DELETE FROM T_FRM_HOGAR WHERE seqFormulario = " . $_POST['formulario'] . ";";
            $arrSql[] = "DELETE FROM T_FRM_FORMULARIO WHERE seqFormulario = " . $_POST['formulario'] . ";";

            // Borrado de los ciudadanos
            foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
               $arrSql[] = "DELETE FROM T_CIU_CIUDADANO WHERE seqCiudadano = " . $seqCiudadano . ";";
            }
            $arrSql[] = "SET foreign_key_checks = 1";
            foreach( $arrSql as $sql ){
               $aptBd->execute( $sql );
            }

            $sql = "
               INSERT INTO T_FRM_BORRADO (
                  seqFormulario,
                  seqTipoDocumento,
                  numDocumento,
                  txtNombre,
                  fchBorrado,
                  txtComentario
               ) VALUES (
                  " . $_POST['formulario'] . ",
                  " . $seqParentesco . ",
                  " . $numDocumento . ",
                  '" . $txtNombre . "',
                  NOW(),
                  '" . $_POST['txtComentario'] . "'
                )
            ";
            $aptBd->execute( $sql );
            
            $arrMensajes[] = "El formulario asociado al ciudadano identificado con el n&uacute;mero de documento " . number_format( $numDocumento ) . " ha sido eliminado";

         }

      break;
      default:

         $claSmarty->assign( "txtFuncion" , "buscarCedula( 'subsidios/eliminarInscripcion' )" );
         $claSmarty->display( "subsidios/buscarCedula.tpl" );

      break;
   }
    
   imprimirMensajes( $arrErrores , $arrMensajes );
    
?>