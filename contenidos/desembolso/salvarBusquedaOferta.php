<?php

    /**
     * SALVA LOS DATOS DE DESEMBOLSO EN LAS FASES DE 
     * BUSQUEDA DE OFERTA Y ESCRITURACION
     * @author Bernardo Zerda
     * @version 1.0 Dic 2009
     * @version 2.0 Jun 2013
     */

   // Verifica los permisos de creacion / edicion
   if( intval( $claDesembolso->seqDesembolso ) == 0 ){
       if( $_SESSION[ "privilegios" ][ "crear" ] != 1 ){
           $arrErrores[] = "No tiene privilegios para salvar el registro";
       }
   }else{
       if( $_SESSION[ "privilegios" ][ "editar" ] != 1 ){
           $arrErrores[] = "No tiene privilegios para editar el registro";
       }
   }

   /*
    * CAMPOS OBLIGATORIOS PARA EL FORMULARIO 
    */

    $arrBarrio = obtenerDatosTabla(
        "T_FRM_BARRIO",
        array("seqBarrio","txtBarrio"),
        "seqBarrio",
        "seqBarrio = " . $_POST['seqBarrio']
    );
    $seqBario = $_POST['seqBarrio'];
    $txtBarrio = $arrBarrio[ $seqBario ];
    $_POST['txtBarrio'] = $txtBarrio;
    unset( $_POST['seqBarrio'] );

   // Para modalidad de arrendamiento la etiqueta cambia
   $txtEtiqueta = ( $claFormulario->seqModalidad != 5 )? "Vendedor" : "Arrendador";
    
   // Obligatorios para el formulario
   $arrObligatorios['busquedaOferta']['txtNombreVendedor']        = "Nombre del $txtEtiqueta";
   $arrObligatorios['busquedaOferta']['numDocumentoVendedor']     = "Documento del $txtEtiqueta";
   $arrObligatorios['busquedaOferta']['numTelefonoVendedor']      = "N&uacute;mero de Tel&eacute;fono";
   $arrObligatorios['busquedaOferta']['txtCorreoVendedor']        = "Correo Electr&oacute;nico";
   $arrObligatorios['busquedaOferta']['txtCompraVivienda']        = "Tipo de Vivienda";
   $arrObligatorios['busquedaOferta']['txtDireccionInmueble']     = "Direcci&oacute;n del Inmueble";
   $arrObligatorios['busquedaOferta']['seqLocalidad']             = "Localidad";
   $arrObligatorios['busquedaOferta']['txtBarrio']                = "Barrio";
   
   switch( $_POST['txtPropiedad'] ){
      case "escritura":
          $arrObligatorios['busquedaOferta']['txtEscritura'] = "N&uacute;mero de la Escritura p&uacute;blica del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['fchEscritura'] = "Fecha de la Escritura p&uacute;blica del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['numNotaria']   = "N&uacute;mero de la Notar&iacute;a de la Escritura p&uacute;blica del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['txtCiudad']    = "Ciudad de la Escritura p&uacute;blica del Titulo de Propiedad";
      break;
      case "sentencia":
          $arrObligatorios['busquedaOferta']['fchSentencia']       = "Fecha de la Sentencia del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['numJuzgado']         = "N&uacute;mero del Juzgado de la Sentencia del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['txtCiudadSentencia'] = "Ciudad de la Sentencia del Titulo de Propiedad";
      break;
      case "resolucion":
          $arrObligatorios['busquedaOferta']['numResolucion']       = "N&uacute;mero de la Resoluci&oacute;n del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['fchResolucion']       = "Fecha de la Resoluci&oacute;n del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['txtEntidad']          = "Entidad de la Resoluci&oacute;n del Titulo de Propiedad";
          $arrObligatorios['busquedaOferta']['txtCiudadResolucion'] = "Ciudad de la Resoluci&oacute;n del Titulo de Propiedad";
      break;
   }
   
   $arrObligatorios['busquedaOferta']['txtMatriculaInmobiliaria'] = "Matr&iacute;cula Inmobiliaria";

   if ( $arrCodigo['flujo'] == "escritura" or $arrCodigo['flujo'] == "giroAnticipado" ){
       $arrObligatorios['busquedaOferta']['txtChip']                  = "CHIP";
       $arrObligatorios['busquedaOferta']['txtCedulaCatastral']       = "Cedula Catastral";
   }

   $arrObligatorios['busquedaOferta']['numAreaLote']              = "Area del Lote o Porcentaje de Participaci&oacute;n";
   $arrObligatorios['busquedaOferta']['numAreaConstruida']        = "Area Construida";
   $arrObligatorios['busquedaOferta']['numAvaluo']                = "Valor del Avaluo del Inmueble";
   $arrObligatorios['busquedaOferta']['numValorInmueble']         = "Valor del Inmueble";
   $arrObligatorios['busquedaOferta']['txtTipoPredio']            = "Tipo de Predio";
   $arrObligatorios['busquedaOferta']['numEstrato']               = "Estrato";

   if( $claFormulario->seqModalidad != 5 ){ // OTRAS MODALIDADES DIFERENTES A ARRIENDO

      $arrObligatorios['escrituracion'] = $arrObligatorios['busquedaOferta'];

     // $arrObligatorios['escrituracion']['numEscrituraPublica']       = "Escritura P&uacute;blica";
      //$arrObligatorios['escrituracion']['numCertificadoTradicion']   = "Certificado de Tradicion y Libertad";       
      $arrObligatorios['escrituracion']['numCartaAsignacion']        = "Fotocopia Carta de Asignaci&oacute;n";       
      
      if ( $arrCodigo['flujo'] == "escritura" and $_POST['txtCompraVivienda'] == "usada" ){
         //$arrObligatorios['escrituracion']['numAltoRiesgo']          = "Certificado de Riesgo";
         //$arrObligatorios['escrituracion']['numBoletinCatastral']    = "Bolet&iacute;n Catastral";
         //$arrObligatorios['escrituracion']['numUltimoReciboAgua']    = "&Uacute;ltimo recibo de acueducto y alcantarillado";
         //$arrObligatorios['escrituracion']['numUltimoReciboEnergia'] = "&Uacute;ltimo recibo de energ&iacute;a";
      }
      
      if ( $arrCodigo['flujo'] == "escritura" or $arrCodigo['flujo'] == "retornoEscritura" ){
         $arrObligatorios['escrituracion']['numHabitabilidad'] = "Certificado de Habitabilidad";
      }
      
      if ( $arrCodigo['flujo'] == "retornoEscritura" ){
        // $arrObligatorios['escrituracion']['numUltimoPredial'] = "Recibo de &uacute;ltimo pago de impuesto predial";
      }
      
      if ( $arrCodigo['flujo'] == "escritura" ){
        // $arrObligatorios['escrituracion']['numActaEntrega'] = "Acta de Entrega del Inmueble";
      }
      
      //$arrObligatorios['escrituracion']['numCertificacionVendedor']  = "Certificacion Bancaria del Vendedor";
      //$arrObligatorios['escrituracion']['numAutorizacionDesembolso'] = "Autorizacion de Desembolso";
      
      if( $_POST['documentos'] == "persona" ){
          //$arrObligatorios['escrituracion']['numFotocopiaVendedor'] = "Fotocopia Cedula del Vendedor";
      } else {
          $arrObligatorios['escrituracion']['numFotocopiaVendedor'] = "Fotocopia Cedula del Representante Legal";
          $arrObligatorios['escrituracion']['numRut']               = "Fotocopia del RUT";
          $arrObligatorios['escrituracion']['numRit']               = "Fotocopia del RIT";
      }
      
      // Para la modalidad de construccion en fase de escrituracion
      if( $claFormulario->seqModalidad == 2 ){
          $arrObligatorios['escrituracion']['numLicenciaConstruccion'] = "Licencia Construcci&oacute;n Inmueble";
      }

    }else{ // OBLIGATORIOS PARA LA MODALIDAD DE ARRENDAMIENTO EN LA FASE DE ESCRITURACION

        $arrObligatorios['escrituracion']["numContratoArrendamiento"] 	= "Contrato de Arrendamiento";
        $arrObligatorios['escrituracion']["numAperturaCAP"] 		      = "Certificado Apertura CAP";
        $arrObligatorios['escrituracion']["numCedulaArrendador"] 	      = "Cédula Arrendador";
        $arrObligatorios['escrituracion']["numCuentaArrendador"] 	      = "Certificación Cuenta Arrendador";
        $arrObligatorios['escrituracion']["numServiciosPublicos"] 	   = "Tres Recibos de Servicios Públicos";
        $arrObligatorios['escrituracion']["numRetiroRecursos"] 		   = "Autorizacion de retiro de recursos";

    }
    
    // Si no hay errores se pasa a validar que los datos obligatorios esten diligenciados
    $txtFlujo = $arrCodigo['flujo'];
    $txtFase  = $arrCodigo['fase'];	
    foreach( $arrObligatorios[ $txtFase ] as $txtClave => $txtValor ){
        if( isset( $_POST[ $txtClave ] ) ){
                $bolError = false;
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
                    $arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[ $txtFase ][ $txtClave ];
                }
        }else{
            $arrErrores[] = "Debe dar un valor v&aacute;lido para el campo " . $arrObligatorios[ $txtFase ][ $txtClave ];
        }
    }

   // Salvar el registro si no hay errores
   if( empty( $arrErrores ) ){

      // Obtiene los cambios que hay entre la clase y los datos que se estan salvando
      $claSeguimiento = new Seguimiento;
      $_POST['txtCambios'] = $claSeguimiento->cambiosDesembolso( $arrCodigo['fase'] , $claDesembolso , $_POST );

      // obtiene el nombre de la persona que ha sido atendida
      foreach( $claFormulario->arrCiudadano as $objCiudadano ){
              if( str_replace( "." , "" , $objCiudadano->numDocumento ) == $_POST['cedula'] ){
                  $_POST['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
              }
      }

      // Guarda los cambios
      $claDesembolso = new Desembolso;

       $arrErrores = $claDesembolso->salvarBusquedaOferta( $_POST , $txtFase );

      if( $txtFase == "escrituracion" ){

          if($claFormulario->seqModalidad == 13){
              if(intval($_POST['numContratoLeasing']) == 0){
                  $arrErrores[] = "Indique el contrato de leasing";
              }
              if(!esFechaValida($_POST['fchContratoLeasing'])){
                  $arrErrores[] = "Indique la fecha del contrato de leasing";
              }
              if(intval($_POST['numFoliosContratoLeasing']) == 0){
                  $arrErrores[] = "Indique la cantidad de folios que tiene el contrato de leasing";
              }
              if(trim($_POST['txtFoliosContratoLeasing']) == ""){
                  $arrErrores[] = "Indique la cantidad de folios que tiene el contrato de leasing";
              }
          }

          $arrErrores = $claDesembolso->salvarEscrituracion( $_POST , $txtFase );
      }

      // Asignacion del tutor al proceso
      $claCrm = new CRM;
      $claCrm->asignarFormularioTutor( $_POST[ "seqFormulario" ] );

       // Coloca el flujo
       $sql = "delete from t_des_flujo where seqFormulario = " . $_POST['seqFormulario'];
       $aptBd->execute( $sql );

        $sql = "
          insert into t_des_flujo (seqFormulario, txtFlujo) 
          values (" . $_POST['seqFormulario'] . ",'" . $_POST['txtFlujo'] . "')
      ";
       try {
           $aptBd->execute( $sql );
       } catch ( Exception $objError ){
           $arrErrores[] = $objError->getMessage();
       }

      // Coloca el estado del proceso seleccionado por el usuario
      $sql = "
          UPDATE T_FRM_FORMULARIO SET
                  seqEstadoProceso = " . $_POST['seqEstadoProceso'] . "
          WHERE seqFormulario = " . $_POST['seqFormulario'] . "
      ";

      try { 
          $aptBd->execute( $sql );
      } catch ( Exception $objError ){
          $arrErrores[] = $objError->getMessage();
      }

   }

   /**
    * IMPRESION DE LOS MENSAJES GENERADOS POR EL CODIGO
    */ 

   if( empty( $arrErrores ) ){
       $arrMensajes[] = "La gestión se ha salvado, el numero de registro es " . number_format( $claDesembolso->seqSeguimiento , 0 , "." , "," ) . "<br>conserve este numero para referencia futura";		
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

?>