<?php

	/**
	 * CAMBIA LA CLAVE DEL USUARIO CUANDO 
	 * ESTA VENCIDA
	 * @author bernardo zerda
	 * @version 1.0 Abril 2009
	 */

    // posicion relativa de los archivos a incluir
		$txtPrefijoRuta = "../../";
	
    // Inclusiones necesarias
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Usuario.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Autenticacion.class.php" );

		$arrErrores = array(); // variable para los errores

    /**
     * VALIDACION DE LOS DATOS
     */
     
		// Validacion del usuario al que se le va a cambiar la clave
		if( ! isset( $_POST['usuarioCambio'] ) or $_POST['usuarioCambio'] == "" ){
			$arrErrores[] = "No se encuentra el usuario para hacer el cambio, reporte este error al administrador";
		}
		
    // Debe haber clave actual
		if( ! isset( $_POST['actual'] ) or $_POST['actual'] == "" ){
			$arrErrores[] = "Debe digitar la clave actual";
		}
		
    // Debe digitar nueva clave
		if( ! isset( $_POST['nueva'] ) or $_POST['nueva'] == "" ){
			$arrErrores[] = "Debe digitar una contrase&ntilde;na nueva";
		}
		
    // debe digitar la confirmacion de la clave
		if( ! isset( $_POST['confirmacion'] ) or $_POST['confirmacion'] == "" ){
			$arrErrores[] = "Debe confirmar la clave nueva";
		}
		
    // clave nueva y confirmacion deben ser iguales
		if( $_POST['nueva'] != $_POST['confirmacion'] ){
			$arrErrores[] = "No coincide la clave nueva con la confirmaci&oacute;n";
		}
		
    /**
     * PROCESO DE CAMBIO DE CLAVE
     */
    
    // si no hay errores procede
		if( empty( $arrErrores ) ){
			
      // Clases necesarias
			$claAutenticacion = new Autenticacion;
			
      // Verifica la existencia del usuario y que ademas la clave actual sea la correcta
			$arrUsuario = $claAutenticacion->datosUsuario( $_POST['usuarioCambio'] , $_POST['actual'] );
			
      // Si no hay datos del usuario es porque hay algun dato mal escrito
      // ya se el usuario o la contrase�a
			if( ! empty( $arrUsuario ) ){
				
				$seqUsuario = key( $arrUsuario ); // obtiene el identificador del usuairo
				
				// Permisos que tenia el usuario
                $arrPrivilegios['crear']   =  $arrUsuario[ $seqUsuario ]->bolCrear;
                $arrPrivilegios['editar']  =  $arrUsuario[ $seqUsuario ]->bolEditar;
                $arrPrivilegios['borrar']  =  $arrUsuario[ $seqUsuario ]->bolBorrar;
                $arrPrivilegios['cambiar'] =  $arrUsuario[ $seqUsuario ]->bolCambiar;
				
                // Formatea los grupos para pasarlos como los necesita la funcion
                $arrPermisos = array();
                foreach( $arrUsuario[ $seqUsuario ]->arrGrupos as $seqProyecto => $arrGrupos ){
                	foreach( $arrGrupos as $seqGrupo => $seqProyectoGrupo ){
                		$arrPermisos[ $seqProyectoGrupo ] = $seqProyectoGrupo;
                	}
                }
                
                // si la clave esta vencida debe renovarla a 30 dias
                if( $arrUsuario[ $seqUsuario ]->numVencimiento < 0 ){
                	$arrUsuario[ $seqUsuario ]->numVencimiento = 30;
                }
                
		        // se usa la edicion del usuario para centralizar el
		        // procedimiento de cambio de clave, ademas el metodo de cambio de clave es privado por seguridad
				$arrErrores = $claAutenticacion->editarUsuario( 
					$seqUsuario , 
					$arrUsuario[ $seqUsuario ]->txtNombre , 
					$arrUsuario[ $seqUsuario ]->txtApellido , 
					$arrUsuario[ $seqUsuario ]->txtUsuario , 
					$_POST['nueva'] , 
					$arrUsuario[ $seqUsuario ]->txtCorreo , 
					$arrUsuario[ $seqUsuario ]->bolActivo , 
					$arrUsuario[ $seqUsuario ]->numVencimiento , 
					$arrPermisos,
					$arrPrivilegios
				);
				
			}else{
				$arrErrores = "La contrase&ntilde;a actual no coincide";
			}
			
		}
		
    /**
     * MUESTRA LOS MENSAJES DE ERROR
     */
     
    if( empty( $arrErrores ) ){
        $arrMensajes[] = "Su contrase&ntilde;a ha sido cambiada, puede cerrar esta ventana e intentar ingresar al aplicativo";
        imprimirMensajes( array() , $arrMensajes );
    }else{
        imprimirMensajes( $arrErrores , array() );
    }


?>
