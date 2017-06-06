<?php

	/**
	 * SALVAR LA POSUTULACION PARA EL 
     * EQUEMA DE CASA EN MANO
     * @author Bernardo Zerda <bzerdar@habitatbogota.gov.co>
     * @version 1.0 Ago 2013
	 */
     
    date_default_timezone_set("America/Bogota");
    
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

  $arrErrores = array(); // Todos los errores van aqui

    /**********************************************************************************************************************
	 * VALIDACIONES DEL FORMULARIO - PESTAÑA DE COMPOSICION FAMILIAR
	 **********************************************************************************************************************/
    
    if( ! empty( $_POST['hogar'] ) ){
		
		$numCabezaFamilia = 0;
		$numCondicionJefeHogar = 0;
		$numCedula = 0;
		foreach( $_POST['hogar'] as $numDocumento => $arrCiudadano ){
            
            // nombre del ciudadano
            $txtNombre  = $arrCiudadano['txtNombre1']   . " ";
            $txtNombre .= ( trim( $arrCiudadano['txtNombre2'] ) != "" )? trim( $arrCiudadano['txtNombre2'] ) . " " : "";
            $txtNombre .= $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'];
            
			// el primer nombre no puede ser vacio
			if( $arrCiudadano['txtNombre1'] == "" ){
				$arrErrores[] = "El ciudadano con numero de documento $numDocumento debe tener primer nombre";
			}
			
			// el primer apellido no debe estar vacio
			if( $arrCiudadano['txtApellido1'] == "" ){
				$arrErrores[] = "El ciudadano con numero de documento $numDocumento debe tener primer apellido";
			}
			
			if( $arrCiudadano['seqEstadoCivil'] == 0 ){
				$arrErrores[] = "El ciudadano $txtNombre debe tener un estado civil.";
			}
			

            // Parentesco
            if( $arrCiudadano['seqParentesco'] == 0 ){
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener parentesco";
            }elseif( $arrCiudadano['seqParentesco'] == 1 ){
                $numCabezaFamilia++; // si es Jefe de Hogar ( solo debe existir un miembro con parentesco 1 )
                if( $arrCiudadano['seqTipoDocumento'] != 1 ){
                    if( $arrCiudadano['seqTipoDocumento'] != 2 ){
                        $arrErrores[] = "El tipo de documento seleccionado para el postulante principal no es válido";
                    }
                }
            }else{
                $seqParentesco = $arrCiudadano['seqParentesco'];
                $arrParentescos = obtenerDatosTabla("t_ciu_parentesco",array("seqParentesco","txtParentesco"),"seqParentesco","bolActivo = 1");
                if(!isset($arrParentescos[$seqParentesco])){
                    $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener parentesco válido";
                }
            }

			// solo puede haber una persona con condicion Especial Jefe de Hogar
			if( $arrCiudadano['seqCondicionEspecial'] == 1 ){
				if ( $arrCiudadano['seqParentesco'] != 1 ){
					$numCondicionJefeHogar++; // Si tiene  condicion especial Jefe de Hogar debe ser realmente el Postulante principal
				}
			}
			
			// por lo menos debe haber una cedula de ciudadania
			if( $arrCiudadano['seqTipoDocumento'] == 1 ){ 
				$numCedula++; // si es cedula de ciudadania ( por lo menos 1 colombiano mayor de edad )
			}
			
            // Estado Civil
            $arrEstadosCiviles = obtenerDatosTabla("t_ciu_estado_civil",array("seqEstadoCivil","txtEstadoCivil"),"seqEstadoCivil","bolActivo = 1");
            $seqEstadoCivil = $arrCiudadano['seqEstadoCivil'];
            if( ! isset($arrEstadosCiviles[$seqEstadoCivil] ) ){
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " no tiene un estado civil válido";
            }
			
			// Si es mayor de edad compare contra la fecha de postulacion si debe tener cedula
			list( $ano , $mes , $dia ) = split( "[-\/]" , $arrCiudadano['fchNacimiento'] );
			if( @checkdate( $mes , $dia , $ano ) === false ){
				$arrErrores[] = "La fecha de Nacimiento del ciudadano " . $txtNombre . " no es valida, verifique los datos";
			}else{ // fecha de nacimiento valida
				
				// fechas para comparar mayor de edad y tercera edad
				$numMayorEdad   = strtotime( "-18 year" , time() );
				$numTerceraEdad = strtotime( "-65 year" , time() );
				$numEdad 		= strtotime( $arrCiudadano['fchNacimiento'] );
				
				// tipos de documento invalidos para un mayor de edad
				$arrDocumentos[] = 6; // NIT
				$arrDocumentos[] = 7; // NUIP
				$arrDocumentos[] = 4; // TARJETA DE IDENTIDAD
				$arrDocumentos[] = 3; // REGISTRO CIVIL
				
				// tipos de documento invalidos para un menor de edad
				$arrDocumentosMayorEdad[] = 1; // Cedula Ciudadania
				$arrDocumentosMayorEdad[] = 2; // Cedula extranjeria
				$arrDocumentosMayorEdad[] = 6; // NIT
				
				$numCondicionEspecialMayor65 = 2;
				
				// se compara si es mayor de edad al momento de la postulacion
				if( ( $numEdad <= $numMayorEdad ) and in_array( $arrCiudadano['seqTipoDocumento'] , $arrDocumentos ) ){
					$arrErrores[] = "Tipo de documento errado para " . $txtNombre . " porque segun su fecha de nacimiento es mayor de edad";
				}
				
				// se compara si es menor de 65 aNos y tenga condicion especial "Mayor 65 aNos"
				if( ( $numEdad > $numTerceraEdad ) and ( $arrCiudadano["seqCondicionEspecial"] == $numCondicionEspecialMayor65 or
				 										$arrCiudadano["seqCondicionEspecial2"] == $numCondicionEspecialMayor65 or 
				 										$arrCiudadano["seqCondicionEspecial3"] == $numCondicionEspecialMayor65 ) ){
					$arrErrores[] = "Condicion especial errada para " . $txtNombre . " porque segun su fecha de nacimiento es menor de edad y se le esta asignando la condicion especial de Mayor de 65 Año";
				}
				
				// se compara si es menor de edad al momento de la postulacion
				if( ( $numEdad > $numMayorEdad ) and in_array( $arrCiudadano['seqTipoDocumento'] , $arrDocumentosMayorEdad ) ){
					$arrErrores[] = "Tipo de documento errado para " . $txtNombre . " porque segun su fecha de nacimiento es menor de edad";			
				}
				
				// se compara si es tercera edad al momento de la postulacion
				if( ( $numEdad <= $numTerceraEdad ) and ( $arrCiudadano['seqCondicionEspecial'] != 2 and $arrCiudadano['seqCondicionEspecial2'] != 2 and $arrCiudadano['seqCondicionEspecial3'] != 2 ) ){
					$arrErrores[] = "Debe tener condicion especial de Mayor de 65 Años para el ciudadano " . $txtNombre;			
				}
                
			} // fin fecha nacimiento valida
            
		} // fin foreach si hay miembros de hogar
		
		// errores que se producen dentro del grupo familiar
		switch( true ){
			case $numCabezaFamilia == 0: $arrErrores[] = "Debe haber una cabeza de familia para el hogar"; break;
			case $numCabezaFamilia > 1:  $arrErrores[] = "Solo puede tener una cabeza de familia para este hogar"; break;
			case $numCondicionJefeHogar > 0:  $arrErrores[] = "Solo el postulante principal debe tener la condición especial 'Madre / Padre cabeza de Familia'"; break;
			case $numCedula == 0: $arrErrores[] = "Debe haber por lo menos un mayor de edad colombiano dentro del nucleo familiar"; break;
		}
		
        // si es independiente debe indicar ingresos
        if( intval( $_POST['bolDesplazado'] ) == 0 ){
            if( intval( $_POST['valIngresoHogar'] ) == 0 ){
                $arrErrores[] = "El ingreso del hogar no puede sumar cero";
            }
        }
        
	} else { // no hay miembros de hogar
	
		$arrErrores[] = "Debe haber por lo menos una persona dentro del grupo familiar";
		
	} // fin validacion si hay miembros del hogar
    
    
    /**********************************************************************************************************************
	 * VALIDACIONES DEL FORMULARIO - DATOS DEL HOGAR
	 **********************************************************************************************************************/
    
    // Vive en arriendo, entonces tiene que tener los datos necesarios
    if( intval( $_POST['seqVivienda'] ) == 1 ){
        if ( intval( $_POST['valArriendo'] ) == 0 ){
            $arrErrores[] = "Indique el valor del arrendamiento que esta pagando";
        }
        if ( !esFechaValida( $_POST['fchArriendoDesde'] ) ){
            $arrErrores[] = "Indique una fecha v&aacute;lida para la fecha de inicio del pago de arriendo";
        }
        if ( trim( $_POST['txtComprobanteArriendo'] ) == "" ){
            $arrErrores[] = "Indique si tiene o no comoprobantes de arriendo";
        }
    }
    
    // direccion de residencia actual
    if ( trim( $_POST['txtDireccion'] ) == "" ){
        $arrErrores[] = "Indique la direcci&oacute;n donde reside actualmente";
    }
    
    // ciudad y validaciones relacionadas
    if( intval( $_POST['seqCiudad'] ) == 0 ){
        $arrErrores[] = "Indique la ciudad de residencia";
    }elseif( intval( $_POST['seqCiudad'] ) == 149 ){ // vive en bogota
        if( intval( $_POST['seqLocalidad'] ) == 0 ){
            $arrErrores[] = "Debe seleccionar una localidad";
        }
        if( intval($_POST['seqBarrio']) == 0 ){
            $arrErrores[] = "Debe seleccionar un barrio perteneciente a la localidad";
        }
    }else{ // fuera de bogota
        if( intval( $_POST['seqLocalidad'] ) == 0 ){
            $arrErrores[] = "Debe seleccionar la localidad 'Fuera de Bogota'";
        }
        if( inteval($_POST['seqBarrio']) == 1142 ){
            $arrErrores[] = "Debe seleccionar el barrio 'Fuera de Bogota' ";
        }
    }

    // Formatos de expresion regular para telefonos fijos y celular
    $txtFormatoFijo    = "/^[0-9]{7}$/";
    $txtFormatoCelular = "/^[3]{1}[0-9]{9}$/";

    // Telefono Fijo 1
    if( is_numeric( $_POST['numTelefono1'] ) == true and intval( $_POST['numTelefono1'] ) != 0 ){
        if ( ! preg_match( $txtFormatoFijo , trim( $_POST['numTelefono1'] ) ) ) {
            $arrErrores[] = "El número telefonico fijo 1 debe tener 7 digitos";
        }
    }

    // Telefono Celular
    if( is_numeric( $_POST['numCelular'] ) == true and intval( $_POST['numCelular'] ) != 0 ) {
        if ( ! preg_match( $txtFormatoCelular , trim( $_POST['numCelular'] ) ) ) {
            $arrErrores[] = "El número telefonico celular debe tener 10 digitos y debe iniciar con el número 3";
        }
    }

    // Debe haber telefono fijo o numero celular
    if( intval( $_POST['numCelular'] ) == 0 and intval( $_POST['numTelefono1'] ) == 0 ){
        $arrErrores[] = "Debe registrar un telefono fijo o celular de contacto";
    }

    // Si hay correo electronico debe ser valido
    if( trim( $_POST['txtCorreo'] ) != "" ){
        if( ! mb_ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreo'] ) ) ){
            $arrErrores[] = "No es un correo electrónico válido";
        }
    }
    
    // Valor del sisben
    $arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben"), "seqSisben","bolActivo = 1");
    $seqSisben = intval( $_POST['seqSisben'] );
    if( ! isset( $arrSisben[$seqSisben ] ) ){
        $arrErrores[] = "Indique un nivel del sisben válido";
    }
    
    /**********************************************************************************************************************
	 * VALIDACIONES DEL FORMULARIO - DATOS DE LA POSTULACION
	 **********************************************************************************************************************/

    if( trim( $_POST['txtDireccionSolucion'] ) == "" ){
        $arrErrores[] = "Indique la direcci&oacute;n de la soluci&oacute;n de vivienda";
    }
    
    if( intval( $_POST['seqSolucion'] ) == 1 ){
        $arrErrores[] = "Indique el tipo de la soluci&oacute;n de vivienda";
    }
    
    if( intval( $_POST['seqSolucion'] ) == 1 ){
        $arrErrores[] = "Indique el tipo de la soluci&oacute;n de vivienda";
    }
    
    if( intval( $_POST['bolPromesaFirmada'] ) == 0 ){
        $arrErrores[] = "No puede continuar si no tiene una promesa de compra-venta firmada";
    }
    
    /**********************************************************************************************************************
	 * VALIDACIONES DEL FORMULARIO - DATOS FINANCIEROS
	 **********************************************************************************************************************/
    
    // Validaciones para el ahorro
    if( intval( $_POST['valSaldoCuentaAhorro'] ) != 0 ){
        if( intval( $_POST['seqBancoCuentaAhorro'] ) == 1 ){
            $arrErrores[] = "Indique el banco de la cuenta de ahorro";
        }
        if( trim( $_POST['txtSoporteCuentaAhorro'] ) == "" ){
            $arrErrores[] = "Indique el soporte para la cuenta de ahorro";
        }
        if( !esFechaValida( $_POST['fchAperturaCuentaAhorro'] ) ){
            $arrErrores[] = "Indique la fecha de apertura de la cuenta de ahorro";
        }
    }
    
    // Validacion para la otra cuenta de ahorro
    if( intval( $_POST['valSaldoCuentaAhorro2'] ) != 0 ){
        if( intval( $_POST['seqBancoCuentaAhorro2'] ) == 1 ){
            $arrErrores[] = "Indique el banco del campo otro ahorro";
        }
        if( trim( $_POST['txtSoporteCuentaAhorro2'] ) == "" ){
            $arrErrores[] = "Indique el soporte del campo otro ahorro";
        }
        if( !esFechaValida( $_POST['fchAperturaCuentaAhorro2'] ) ){
            $arrErrores[] = "Indique la fecha del campo otro ahorro";
        }
    }
    
    // valor del subsidio nacional
    if( intval( $_POST['valSubsidioNacional'] ) != 0 ){
        if( trim( $_POST['txtSoporteSubsidioNacional'] ) == "" ){
            $arrErrores[] = "Indique el soporte para el subsidio nacional";
        }
    }
    
//    // valor del aporte en lote
//    if( intval( $_POST['valAporteLote'] ) != 0 ){
//        if( trim( $_POST['txtSoporteLote'] ) == "" ){
//            $arrErrores[] = "Indique el soporte para el aporte en lotes o terrenos";
//        }
//    }
    
    // valor del saldo de cesantias
    if( intval( $_POST['valSaldoCesantias'] ) != 0 ){
        if( trim( $_POST['txtSoporteCesantias'] ) == "" ){
            $arrErrores[] = "Indique el soporte para el aporte de cesantias";
        }
    }
    
//    // valor del aporte en avance de obra
//    if( intval( $_POST['valAporteAvanceObra'] ) != 0 ){
//        if( trim( $_POST['txtSoporteAvanceObra'] ) == "" ){
//            $arrErrores[] = "Indique el soporte para el aporte en avance de obra";
//        }
//    }
    
    // valor del credito
    if( intval( $_POST['valCredito'] ) != 0 ){
        if( intval( $_POST['seqBancoCredito'] ) == 1 ){
            $arrErrores[] = "Indique el banco que otorga el credito";
        }
        if( trim( $_POST['txtSoporteCredito'] ) == "" ){
            $arrErrores[] = "Indique el soporte para el credito";
        }
        
    }
    
//    // valor del aporte en materiales
//    if( intval( $_POST['valAporteMateriales'] ) != 0 ){
//        if( trim( $_POST['txtSoporteAporteMateriales'] ) == "" ){
//            $arrErrores[] = "Indique el soporte para el aporte en materiales";
//        }
//    }
    
    // valor de la donacion (VUR)
    if( intval( $_POST['valDonacion'] ) != 0 ){
        if( intval( $_POST['seqEmpresaDonante'] ) == 0 ){
            $arrErrores[] = "Indique la empresa que ha realizado la donaci&oacute;n";
        }
        if( trim( $_POST['txtSoporteDonacion'] ) == "" ){
            $arrErrores[] = "Indique el soporte para la donaci&oacute;n";
        }
    }
    
    // Valores para la consulta del valor del subsidio
//    $seqSolucion = $_POST['seqSolucion'];
//    $seqModalidad = $_POST['seqModalidad'];
//
//    // Si es desplazado - adquisicion de vivienda - tipo 2 o VIS
//    // el valor del subsidio debe ser el maximo (como en tipo 1)
//    // por eso se alteran los valores
//    // no se altera el post para que se guarden los valores
//    // de modalidad y solucion seleccionados por el usuario
//    if( $_POST[ "bolDesplazado" ] == 1 and $_POST[ "seqModalidad" ] == 1 and $_POST[ "seqSolucion" ] != 2 ){
//        $seqSolucion = 2;
//        $seqModalidad = 1;
//    }
//
//        $_POST['valAspiraSubsidio'] = mb_ereg_replace("[^0-9]", "", $_POST['valAspiraSubsidio'] );
//
//    // Obtiene el valor del subsidio segun modalidad y tipo de solucion seleccionada
//    $valSubsidio = 0;
//    $sql = "
//        SELECT valSubsidio
//        FROM T_FRM_VALOR_SUBSIDIO
//        WHERE seqSolucion = ". $seqSolucion ."
//          AND seqModalidad = ". $seqModalidad ."
//    ";
//    $objRes = $aptBd->execute( $sql );
//    if( $objRes->fields ){
//        $valSubsidio = $objRes->fields['valSubsidio'];
//    }
//
//    // si el valor del subsidio es menor se debe colocar una justificacion
//    if( ( $_POST['valAspiraSubsidio'] < $valSubsidio ) and trim( $_POST['txtSoporteSubsidio'] ) == "" ){
//        $arrErrores[] = "No puede cambiar el valor tope del subsidio sin dar un soporte para este cambio, diligencie el campo 'Soporte Cambio'";
//    }

    /* el valor del subsidio nunca puede ser mayor al establecido en la solucion
    if( $_POST['valAspiraSubsidio'] > $valSubsidio ){
        $arrErrores[] = "El valor del subsidio al que se aspira nunca puede superar el limite establecido";
    }*/
    
    
    /**********************************************************************************************************************
	 * SALVANDO EL REGISTRO DE LA POSTULACION
	 **********************************************************************************************************************/

    // Salvar el registro si no hay errores
	if( empty( $arrErrores ) ){
        
      $_POST['fchPostulacion'] = date( "Y-m-d H:i:s" );    

      $claCasaMano = new CasaMano();
      $arrCasaMano = $claCasaMano->cargar($_POST['seqFormulario'], $_POST['seqCasaMano'] );
      $objCasaMano = $arrCasaMano[ $_POST['seqCasaMano'] ];
      
      if( trim( $_POST['txtFormulario'] ) != "" ){
         $txtFormato = "/^[0-9]{2}[-][0-9]{3,6}$/"; // dos digitos de tutor y hasta seis de numero de formulario
         $txtFormulario = trim( $_POST['txtFormulario'] );
         if( preg_match( $txtFormato , $txtFormulario ) ){
             $arrFormulario = mb_split( "-" , $txtFormulario );
             $numFormulario = intval( $arrFormulario[ 1 ] );
             $numSiguiente = FormularioSubsidios::tutorSecuencia( $txtFormulario );
             if( $numFormulario != $numSiguiente ){
                 $arrErrores[] = "El formulario $numFormulario no es el n&uacute;mero correcto de secuencia, el numero correcto es $numSiguiente";
             }			
         }else{
             $arrErrores[] = "El numero del formulario no tiene el formato correcto";
         }
      }
        
      if( empty( $arrErrores ) ){

          $_POST['cedula'] = $_POST['numDocumento'];

          $objCasaMano->salvar( $_POST );
          $arrErrores = $objCasaMano->arrErrores;
      }
        
	} 
    
    /*********************************************************************************************************************
 	 * IMPRESION DE LOS MENSAJES GENERADOS POR EL CODIGO
 	 ********************************************************************************************************************/ 
 	 
    if( empty( $arrErrores ) ) {
		$arrMensajes = $objCasaMano->arrMensajes;
		$txtEstilo = "msgOk";
	} else {
		$arrMensajes = $arrErrores;
		$txtEstilo = "msgError";
    }

	echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>" ;
   foreach( $arrMensajes as $txtMensaje ){
     echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
   }
   echo "</table>";

?>
