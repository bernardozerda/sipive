<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FlujoDesembolsos.class.php" );
	
    // Detecta si hay cambios en el formulario de desembolso
    $bolCambios = false;
    
    // Identificador del formulario
    $seqFormulario = $_POST['seqFormulario'];
    
    // Estafo del proceso del POST
    $seqEstadoProceso = $_POST['seqEstadoProceso'];
    
    // Para salvar el seguimiento se quitan para validar y despues se ponen para salvar el seguimiento
    $seqGrupoGestion = $_POST['seqGrupoGestion'];
    $seqGestion      = $_POST['seqGestion'];
    $txtComentario   = $_POST['txtComentario'];
    
    // Para saber si aplican las validaciones para persona natural o persona juridica
    $txtDocumentos = $_POST['documentos'];
    
    // Para saber si es poseedor del inmueble y aplicar las validaciones correspondientes
    $bolPoseedor = $_POST['bolPoseedor'];
    
    // Para saber que tipo de propiedad es y aplicar validaciones
    $txtPropiedad = $_POST['txtPropiedad'];
    
    // Para saber al final del proceso a quien se atendio
    $numCedula = $_POST['cedula'];
    
    // Para determinar cuando la fase viene cambiada
    $txtFasePlantilla = $_POST['fase'];
    
    // Variables que no requieren validaciones
    unset( $_POST['seqGrupoGestion'] );
    unset( $_POST['seqGestion'] );
    unset( $_POST['txtComentario'] );
    unset( $_POST['btnSalvar'] );
    unset( $_POST['seqFormulario'] );
    unset( $_POST['seqEstadoProceso'] );
    //unset( $_POST['documentos'] ); // Tipo de persona, empresa o natural
    unset( $_POST['txtPropiedad'] ); // Titulo de propiedad, escritura, sentencia o resolucion
    unset( $_POST['radTipoDireccion'] ); // Radio del tipo de direccion del popUp de direccion
    unset( $_POST['bolPoseedor'] );
    unset( $_POST['cedula'] );
    unset( $_POST['fase'] );
    
	// Carga los Datos del hogar y postulacion
	$claFormulario = new FormularioSubsidios;
	$claFormulario->cargarFormulario( $seqFormulario );
    
    // Datos de desembolso para este hogar
    $claDesembolso = new Desembolso;
    $claDesembolso->cargarDesembolso( $seqFormulario );
	
	// Para ver cual es el flujo de validaciones que aplica
	$claFlujoDesemboslos = new FlujoDesembolso( $seqFormulario );
	$arrCodigo = $claFlujoDesemboslos->obtenerCodigo( $_POST['txtFlujo'] , $claFormulario->seqEstadoProceso , $txtFasePlantilla );
    
    // Comparacion del estado del proceso de la base de datos con el del post
    if( $claFormulario->seqEstadoProceso != $seqEstadoProceso ){
    	$bolCambios = true;
    }
    
    if( $bolCambios == false ){
        
        // reemplaza todos los caracteres que son de presentacion 
        // y que no deben ir a la base de datos
        foreach( $_POST as $txtClave => $txtValor ){
            if( ! is_array( $_POST[ $txtClave ] ) ){
                $_POST[ $txtClave ] = preg_replace( "/[^áéíóúÁÉÍÓÚñÑA-Za-z0-9\ \.\-\/@]/" , "" , $txtValor );
            }
        }
        
		$bolCambios = $claDesembolso->hayCambios( $_POST , $arrCodigo['fase'] );
    }
    
	// si no tiene flujo asignado se le asigna uno
	$seqFlujo = $claFlujoDesemboslos->asignarFlujo( $seqFormulario , $_POST['txtFlujo'] );
	if( $seqFlujo == 0 ){
		$arrErrores[] = "Se produjo un error al intentar salvar el flujo del desembolso, por favor contacte al administrador del sistema";
	}
	
	// Se vuelven a colocar para mandar a salvar el registro
	$_POST['seqGrupoGestion'] = $seqGrupoGestion;
	$_POST['seqGestion']      = $seqGestion;
	$_POST['txtComentario']   = $txtComentario;

	// Para saber al final del proceso a que ciudadano se atendio
	$_POST['cedula'] = $numCedula;
	
	// el formulario lo requiere para salvar 
	$_POST['seqFormulario'] = $seqFormulario;
	
	// Si hubo cambios en el formulario muestra el pop up de confirmacion
	if( $bolCambios == true ){
		
		// estado del proceso debe pasar para salvar los cambios
		$_POST['seqEstadoProceso'] = $seqEstadoProceso;
		
		// Para aplicar las validaciones para persona natural o juridica
		$_POST['documentos'] = $txtDocumentos;
		
		// Para aplicar las validaciones correspondientes si es poseedor del inmueble
		$_POST['bolPoseedor'] = $bolPoseedor;
		
		// Para aplicar las validaciones por tipo de propiedad
		$_POST['txtPropiedad'] = $txtPropiedad;
		
        // Para determinar si la plantilla ha sido cambiada 
        $_POST['fase'] = $txtFasePlantilla;
        
		// obtiene el postulante principal del formulario cargado
		foreach( $claFormulario->arrCiudadano as $objCiudadano ){
			if( $objCiudadano->seqParentesco == 1 ){
            $txtNombre  = trim( $objCiudadano->txtNombre1 ) . " ";
            $txtNombre .= ( trim( $objCiudadano->txtNombre2 ) != "" )? trim( $objCiudadano->txtNombre2 ) . " " : "";
            $txtNombre .= trim( $objCiudadano->txtApellido1 ) . " ";
            $txtNombre .= trim( $objCiudadano->txtApellido2 );
				break;
			}
		}
		
      if( $_POST['seqEstadoProceso'] == $arrCodigo['final'] ){
      
         // Mensaje cuando hay cambios
         $txtMensaje  = "<div style='font-size:12px;text-align:justify'>";
         $txtMensaje .= "Ha llegado al final de la aplicaci&oacute;n del subsidio para el hogar de <strong>" . $txtNombre . "</strong>.<br><br>";
         $txtMensaje .= "Puede eliminar los registros de giros de desembolso escribiendo la palabra<span class='msgError'>\"BORRAR\"</span> ";
         $txtMensaje .= "en el siguiente cuadro de texto. Si no desea borrar los registros, deje en blanco el cuadro y de click en el boton ";
         $txtMensaje .= "<strong>\"Salvar Informaci&oacute;n\"</strong><br><br><center><input type='text' name='confirmacion' style='width:200px;' placeholder='Borrar'></center>";
         $txtMensaje .= "</div>";
         
      } else {
         
         // Mensaje cuando hay cambios
         $txtMensaje = "Es necesario que confirme la acci&oacute;n que esta apunto de realizar:";
         $txtMensaje.= "<div class='msgOk' style='font-size:12px;'> Desea cambiar los datos del registro para el documento ".$objCiudadano->numDocumento." ?</div>";
      
      }
      
		$claSmarty->assign( "txtMensaje" , utf8_encode( $txtMensaje ) );
		$claSmarty->assign( "bolMostrarConfirmacion" , $bolCambios );
		$claSmarty->assign( "txtArchivo" , "./contenidos/desembolso/salvarDesembolso.php" );
		$claSmarty->assign( "arrPost" , $_POST );
		$claSmarty->display( "desembolso/pedirConfirmacion.tpl" );
		
	}else{ 
		
		$arrErrores = array();
		
		// Grupo de Gestion 
		if( $_POST['seqGrupoGestion'] == 0 ){
			$arrErrores[] = "Seleccione el grupo de la gesti&oacute;n realizada";
		}
		
		// Grstion
		if( $_POST['seqGestion'] == 0 ){
			$arrErrores[] = "Seleccione la gesti&oacute;n realizada";
		}
		
		// Comentarios
		if( $_POST['txtComentario'] == "" ){
			$arrErrores[] = "Por favor diligencie el campo de comentarios";
		}
		
		// obtiene el nombre de la persona que ha sido atendida
		foreach( $claFormulario->arrCiudadano as $objCiudadano ){
			if( str_replace( "." , "" , $objCiudadano->numDocumento ) == $_POST['cedula'] ){
				$_POST['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
			}
		}
		
		if( empty( $arrErrores ) ){
		
			$numDocumentoFormat = str_replace(".","",$_POST[ "cedula" ]);
			
			$sql = "
				INSERT INTO T_SEG_SEGUIMIENTO ( 
					seqFormulario, 
					fchMovimiento, 
					seqUsuario, 
					txtComentario, 
					txtCambios, 
					numDocumento, 
					txtNombre, 
					seqGestion
				) VALUES (
					" . $_POST['seqFormulario'] . ",
					now(),
					". $_SESSION['seqUsuario'] .",
					\"" . ereg_replace( "\n", "" , $_POST['txtComentario'] ) . "\",
					\"Sin Cambios en los datos del formulario\",
					". $numDocumentoFormat .",
					\"". $_POST[ "nombre" ] ."\",
					" . $_POST['seqGestion'] . "
				)					
			";
			
			try {
				$aptBd->execute( $sql );
				$seqSeguimiento = $aptBd->Insert_ID();
			} catch ( Exception $objError ){
				$arrErrores[] = "No se ha podido registrar la actividad del hogar, contacte al administrador";
			}
		
		
			$arrMensajes[] = "Ha salvado un registro de actividad, el n&uacute;mero del registro es " . number_format( $seqSeguimiento , 0 , "." , "," ) . 
							". Conserve este n&uacute;mero para su referencia.";
			imprimirMensajes( array() ,  $arrMensajes );
		}else{
			imprimirMensajes( $arrErrores , array() );
		}		
		
	} // fin si hubo cambios

?>
