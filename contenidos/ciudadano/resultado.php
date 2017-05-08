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
   
   setlocale(LC_TIME , 'spanish' );
   date_default_timezone_set("America/Bogota");
   
   $arrRespuesta = array();
   $claCiudadano = new Ciudadano();
   $claFormulario = new FormularioSubsidios();
   $claPreguntas = new Preguntas();
   
   // validacion de las respuestas
   $seqFormulario = $claCiudadano->formularioVinculado( $_POST['documento'] );   
   foreach( $_POST['respuesta'] as $numPregunta => $numRespuesta ){
      $arrRespuesta[ $numPregunta ] = $claPreguntas->validarRespuesta( $seqFormulario , $numPregunta , $numRespuesta );
   }
   
   // si hay respuestas mal dadas
   if( in_array( false , $arrRespuesta ) ){
      
      $fchFinBloqueo = $claPreguntas->bloquearDocumento( $_POST['documento'] );
      if( $fchFinBloqueo !== false ){
         $txtBloqueo = "<br><br>Usted podr&aacute; volver a usar este servicio de consulta hasta el d&iacute;a " . $fchFinBloqueo;
      }
      
      echo "
         <center>
         <div class='alert alert-error fade in'>
         <button type='button' class='close' data-dismiss='alert'>×</button>
         <h4 class='alert-heading'>Lo sentimos:</h4>
         <div style='width:650px;'><ul>
            La Secretar&iacute;a Distrital de H&aacute;bitat le informa que no ha sido posible 
            verificar su identidad como beneficiario del Subsidio Distrital de Vivienda en Especie.
            Si tiene alguna inquietud por favor comun&iacute;quese con la  al tel&eacute;fono 
            358 1600 Extensiones 1006, 1007, 1008 o 1009. $txtBloqueo<br>
            <button onClick=\"location.href='index.php';\" class='btn btn-danger'>Volver</button>
         </ul></div></div>
         </center>
      ";
      
   } else {
      
      if( $claPreguntas->quitarBloqueo( $_POST['documento'] ) ){
      
         $claFormulario->cargarFormulario($seqFormulario);
         
         $claFormulario->fchInscripcion = strftime( "%d de %B de %Y a las %H:%M" , strtotime( $claFormulario->fchInscripcion ) );
         $claFormulario->fchUltimaActualizacion = strftime( "%d de %B de %Y a las %H:%M" , strtotime( $claFormulario->fchUltimaActualizacion ) );
         $claFormulario->txtModalidad = obtenerNombres( "T_FRM_MODALIDAD" , "seqModalidad" , $claFormulario->seqModalidad );
         $claFormulario->txtVivienda = obtenerNombres( "T_FRM_VIVIENDA" , "seqVivienda" , $claFormulario->seqVivienda );
         $claFormulario->txtCiudad = obtenerNombres( "T_FRM_CIUDAD" , "seqCiudad" , $claFormulario->seqCiudad );
         $claFormulario->txtLocalidad = obtenerNombres( "T_FRM_LOCALIDAD" , "seqLocalidad" , $claFormulario->seqLocalidad );
         
         if( trim( $claFormulario->txtBarrio ) == "" ){
            $claFormulario->txtBarrio = obtenerNombres( "T_FRM_BARRIO" , "seqBarrio" , $claFormulario->seqBarrio );
         }
         
         $txtNombreConsulta = "";
         foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
            $claFormulario->arrCiudadano[$seqCiudadano]->numDocumento = mb_ereg_replace( "[^0-9]" , "" , $objCiudadano->numDocumento );
            $claFormulario->arrCiudadano[$seqCiudadano]->txtParentesco = obtenerNombres( "T_CIU_PARENTESCO" , "seqParentesco" , $objCiudadano->seqParentesco );
            
            if( mb_ereg_replace( "[^0-9]", "", $objCiudadano->numDocumento ) == $_POST['documento'] ){
               $txtNombreConsulta  = trim( $objCiudadano->txtNombre1 ) . " ";
               $txtNombreConsulta .= ( trim( $objCiudadano->txtNombre2 ) == "" )? "" : trim( $objCiudadano->txtNombre2 ) . " ";
               $txtNombreConsulta .= trim( $objCiudadano->txtApellido1 ) . " ";
               $txtNombreConsulta .= trim( $objCiudadano->txtApellido2 );
               $txtSaludo = ( $objCiudadano->seqSexo == 1 )? "Bienvenido" : "Bienvenida";
            }
            
            if( $objCiudadano->seqParentesco == 1 ){
               $claSmarty->assign( "objPrincipal" , $objCiudadano );
            }
            
         }
         
         $arrEstado = obtenerDatosTabla( 
                 "T_FRM_ESTADO_PROCESO" , 
                 array("seqEstadoProceso","seqEtapa","txtEstadoProceso") , 
                 "seqEstadoProceso", 
                 "seqEstadoProceso = " . $claFormulario->seqEstadoProceso 
         );
         
         $arrEstado[ $claFormulario->seqEstadoProceso ]['txtEtapa'] = obtenerNombres( "T_FRM_ETAPA" , "seqEtapa" , $arrEstado[ $claFormulario->seqEstadoProceso ]['seqEtapa'] );
         $arrEstado[ $claFormulario->seqEstadoProceso ]['txtEstado'] = obtenerNombres( "T_FRM_ESTADO_PROCESO" , "seqEstadoProceso" , $claFormulario->seqEstadoProceso );
         
         $arrEstado[ $claFormulario->seqEstadoProceso ]['txtDescripcion'] = array_shift( obtenerDatosTabla( 
                 "T_FRM_ESTADO_PROCESO" , 
                 array("seqEstadoProceso","txtDescripcion") , 
                 "seqEstadoProceso", 
                 "seqEstadoProceso = " . $claFormulario->seqEstadoProceso 
         ) );
         
         $claFormulario->txtBancoCuentaAhorro  = obtenerNombres( "T_FRM_BANCO" , "seqBanco" , $claFormulario->seqBancoCuentaAhorro );
         $claFormulario->txtBancoCuentaAhorro2 = obtenerNombres( "T_FRM_BANCO" , "seqBanco" , $claFormulario->seqBancoCuentaAhorro2 );
         
         $claSmarty->assign( "seqFormulario" , $seqFormulario );
         $claSmarty->assign( "arrEstado" , $arrEstado[ $claFormulario->seqEstadoProceso ] );
         $claSmarty->assign( "txtNombreConsulta" , $txtNombreConsulta );
         $claSmarty->assign( "txtSaludo" , $txtSaludo );
         $claSmarty->assign( "claFormulario" , $claFormulario );
         $claSmarty->display( "ciudadano/resultado.tpl" );
         
      } else {
         
         echo "
            <center>
            <div class='alert alert-error fade in'>
            <button type='button' class='close' data-dismiss='alert'>×</button>
            <h4 class='alert-heading'>Lo sentimos:</h4>
            <div style='width:650px;'><ul>
               Ha ocurrido un error inesperado al intentar mostrar la informaci&oacute;n 
               del Subsidio Distrital de Vivienda en Especie. Por favor comun&iacute;quese con nosotros al tel&eacute;fono 
               358 1600 Extensiones 1006, 1007, 1008 o 1009.<br>
               <button onClick=\"location.href='index.php';\" class='btn btn-danger'>Volver</button>
            </ul></div></div>
            </center>
         ";
         
      }
      
   }
   

?>
