<?php

	/**
	 * SALVA LOS DATOS DE REGISTRO DE OFERTA EN EL ESQUEMA
	 * DE CASA EN MANO
	 * @author Bernardo Zerda
	 * @version 1.0 Jul 2013
	 */    

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
   
   //pr($_POST);die();

	// Verifica los permisos de creacion / edicion
	if( intval( $_POST['seqCasaMano'] ) == 0 ){
		if( $_SESSION[ "privilegios" ][ "crear" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para salvar el registro";
		}
	}else{
		if( $_SESSION[ "privilegios" ][ "editar" ] != 1 ){
			$arrErrores[] = "No tiene privilegios para editar el registro";
		}
	}
    
   $claFormulario = new FormularioSubsidios();
   $claFormulario->cargarFormulario( $_POST[ 'seqFormulario' ] );
    
	/*
	 * SEGUN LA MODALIDAD PIDE ALGUNOS CAMPOS COMO OBLIGATORIOS
	 * PARA ARRENDAMIENTO SON DIFERENTES
	 */
	
	// FLUJO DE DATOS DE ESCRITURA PUBLICA Y FASE BUSQUEDA DE OFERTA
	$txtEtiqueta = ( $claFormulario->seqModalidad != 5 )? "Vendedor" : "Arrendador";
   
	$arrObligatorios['txtNombreVendedor']        = "Nombre del $txtEtiqueta";
	$arrObligatorios['numDocumentoVendedor']     = "Documento del $txtEtiqueta";
	$arrObligatorios['txtCompraVivienda']        = "Tipo de Vivienda";
	$arrObligatorios['numTelefonoVendedor']      = "N&uacute;mero de Tel&eacute;fono del $txtEtiqueta";
   $arrObligatorios['txtCorreoVendedor']        = "Correo Electr&oacute;nico";
	$arrObligatorios['txtDireccionInmueble']     = "Direcci&oacute;n del Inmueble";
   $arrObligatorios['seqCiudad']                = "Ciudad";
	$arrObligatorios['seqLocalidad']             = "Localidad";
	$arrObligatorios['txtBarrio']                = "Barrio";
	$arrObligatorios['txtMatriculaInmobiliaria'] = "Matr&iacute;cula Inmobiliaria";
   $arrObligatorios['txtChip']                  = "CHIP";
   $arrObligatorios['txtCedulaCatastral']       = "Cedula Catastral";
   $arrObligatorios['numAreaLote']              = "Area del Lote o Porcentaje de Participaci&oacute;n";
	$arrObligatorios['numAreaConstruida']        = "Area Construida";
	$arrObligatorios['numAvaluo']                = "Valor del Avaluo del Inmueble";
	$arrObligatorios['numValorInmueble']         = "Valor del Inmueble";
	$arrObligatorios['txtTipoPredio']            = "Tipo de Predio";
	$arrObligatorios['numEstrato']               = "Estrato";
	$arrObligatorios['txtCorreoVendedor']        = "Correo del Vendedor";
   
   if( $_POST['txtCompraVivienda'] != "nueva" ){
      switch( $_POST['txtPropiedad'] ){
         case "escritura":
            $arrObligatorios['txtEscritura'] = "N&uacute;mero de la Escritura p&uacute;blica del Titulo de Propiedad";
            $arrObligatorios['fchEscritura'] = "Fecha de la Escritura p&uacute;blica del Titulo de Propiedad";
            $arrObligatorios['numNotaria']   = "N&uacute;mero de la Notar&iacute;a de la Escritura p&uacute;blica del Titulo de Propiedad";
            $arrObligatorios['txtCiudad']    = "Ciudad de la Escritura p&uacute;blica del Titulo de Propiedad";
         break;
         case "sentencia":
            $arrObligatorios['fchSentencia']       = "Fecha de la Sentencia del Titulo de Propiedad";
            $arrObligatorios['numJuzgado']         = "N&uacute;mero del Juzgado de la Sentencia del Titulo de Propiedad";
            $arrObligatorios['txtCiudadSentencia'] = "Ciudad de la Sentencia del Titulo de Propiedad";
         break;
         case "resolucion":
            $arrObligatorios['numResolucion']       = "N&uacute;mero de la Resoluci&oacute;n del Titulo de Propiedad";
            $arrObligatorios['fchResolucion']        = "Fecha de la Resoluci&oacute;n del Titulo de Propiedad";
            $arrObligatorios['txtEntidad']          = "Entidad de la Resoluci&oacute;n del Titulo de Propiedad";
            $arrObligatorios['txtCiudadResolucion'] = "Ciudad de la Resoluci&oacute;n del Titulo de Propiedad";
         break;
      }
   }
   
	if( $claFormulario->seqModalidad != 5 ){ // OTRAS MODALIDADES DIFERENTES A ARRIENDO
		
      
      $arrObligatorios['numCertificadoTradicion']   = "Certificado de Tradicion y Libertad";
      $arrObligatorios['numBoletinCatastral'] = "Boletin Catastral";
      
      // desplazado
      if( $claFormulario->bolDesplazado == 1 ){
         $arrObligatorios['numHabitabilidad'] = "Certificado de Habitabilidad";
      }
      
      if( $_POST['txtCompraVivienda'] == "nueva" ){
         $arrObligatorios['numLicenciaConstruccion'] = "Licencia de Construcci&oacute;n";
      }else{ // Vivienda Usada
         $arrObligatorios['numEscrituraPublica'] = "Escritura P&uacute;blica";
         $arrObligatorios['numUltimoPredial']          = "Ultimo Recibo Predial";
         $arrObligatorios['numUltimoReciboAgua']       = "Ultimo Recibo de Agua";
         $arrObligatorios['numUltimoReciboEnergia']    = "Ultimo Recibo de Energia";
      }
      
		if( $_POST['documentos'] == "persona" ){
			$arrObligatorios['numFotocopiaVendedor'] = "Fotocopia Cédula del Vendedor";
		}else{
			$arrObligatorios['numFotocopiaVendedor'] = "Fotocopia Cedula del Representante Legal";
			$arrObligatorios['numRut']               = "Fotocopia del RUT";
			$arrObligatorios['numRit']               = "Fotocopia del RIT";
		}
		
	}else{ // OBLIGATORIOS PARA LA MODALIDAD DE ARRENDAMIENTO EN LA FASE DE ESCRITURACION
		
		$arrObligatorios["numContratoArrendamiento"] = "Contrato de Arrendamiento";
		$arrObligatorios["numAperturaCAP"] 			   = "Certificado Apertura CAP";
		$arrObligatorios["numCedulaArrendador"] 		= "Cédula Arrendador";
		$arrObligatorios["numCuentaArrendador"] 		= "Certificación Cuenta Arrendador";
		$arrObligatorios["numServiciosPublicos"] 		= "Tres Recibos de Servicios Públicos";
		$arrObligatorios["numRetiroRecursos"] 		   = "Autorizacion de retiro de recursos";
		
	}
    
	// Si no hay errores se pasa a validar que los datos obligatorios esten diligenciados
	foreach( $arrObligatorios as $txtClave => $txtValor ){
		if( isset( $_POST[ $txtClave ] ) ){
			$bolError = false;
			//echo "#". $_POST[ $txtClave ] ."#";
			switch( substr( $txtClave , 0 , 3 ) ){
				case "num":
					$bolError = ( intval( $_POST[ $txtClave ] ) == 0 )? true : false;
				break;
            case "seq":
					$bolError = ( intval( $_POST[ $txtClave ] ) == 0 )? true : false;
				break;
				case "fch":
					$bolError = ( ! esFechaValida( trim( $_POST[ $txtClave ] ) ) );
				break;
				case "txt":
					$bolError = ( trim( $_POST[ $txtClave ] ) == "" )? true : false;
				break;
				default:
					$bolError = ( trim( $_POST[ $txtClave ] ) == "" )? true : false;
				break;
			}
			if( $bolError == true ){
				$arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[ $txtClave ];
			}
		}else{
			$arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[ $txtClave ];
		}
	}
   
   // El valor del inmueble no debe superar ls 70 smmlv
   if( intval( $_POST['numValorInmueble'] ) > ( $arrConfiguracion['constantes']['salarioMinimo'] * 70 ) ){
		$arrErrores[] = "El Valor del Inmueble supera el l&iacute;mite permitido";
	}
   
	// Salvar el registro si no hay errores
	if( empty( $arrErrores ) ){
        
        $claCasaMano = new CasaMano();
        $seqCasaMano = $claCasaMano->salvar( $_POST );
        
        if( ! empty( $claCasaMano->arrErrores ) ){
            $arrErrores = $claCasaMano->arrErrores;
        }
        
	} 
	
	/**
 	 * IMPRESION DE LOS MENSAJES GENERADOS POR EL CODIGO
 	 */ 
 	 
    if( empty( $arrErrores ) ){
		$arrMensajes = $claCasaMano->arrMensajes;
		$txtEstilo = "msgOk";
	}else{
		$arrMensajes = $arrErrores;
		$txtEstilo = "msgError";
	}	 

	echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>" ;
    foreach( $arrMensajes as $txtMensaje ){
    	echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
    }
    echo "</table>";
    echo "<div id='tablaMensajes'><input type='hidden' id='casaMano' value='$seqCasaMano'></div>";
    
?>
