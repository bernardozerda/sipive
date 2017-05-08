<?php

    /**
     * CLASE PARA LA INSCRIPCION / POSTULACION / ASIGNACION DE 
     * EL ESQUEMA DE CASA EN MANO
     */
     
   class CasaMano {
         
      public $arrFases;

      public $seqCasaMano;
      public $seqFormulario;
      public $fchRegistroVivienda;

      public $bolRevisionJuridica;
      public $fchRevisionJuridica;
      public $numDiasRevisionJuridica;
      public $txtRevisionJuridica;
      public $numDiasLimiteRevsionJuridica;

      public $bolRevisionTecnica;
      public $fchRevisionTecnica;
      public $numDiasRevisionTecnica;
      public $txtRevisionTecnica;
      public $numDiasLimiteRevsionTecnica;

      public $bolPrimeraVerificacion;
      public $fchPrimeraVerificacion;
      public $seqPrimeraVerificacion;
      public $fchPostulacion;
      public $bolSegundaVerificacion;
      public $fchSegundaVerificacion;
      public $seqSegundaVerificacion;

      public $objRegistroOferta;
      public $objRevisionJuridica;
      public $objRevisionTecnica;
      public $objPostulacion;
      public $objPrimeraVerificacion;
      public $objSegundaVerificacion;

      public $arrMensajes;
      public $arrErrores;
                 
      function CasaMano() {

         $this->arrFases = array();

         $this->arrFases['cem']['modalidad'] = array( 6,11 );

         $this->arrFases['cem']['panelHogar']['grupos']       = array( 23,15,14,7,8,31,32,33 );
         $this->arrFases['cem']['panelHogar']['permisos']     = array( 37,43,44,45,46,47,48,15,16,53 );

         $this->arrFases['cem']['registroOferta']['grupos']    = array( 23,7,8,31,15,14 );
         $this->arrFases['cem']['registroOferta']['permisos']  = array( 37,43,44,45,46,47,48,15,53 );
         $this->arrFases['cem']['registroOferta']['atras']     = array();
         $this->arrFases['cem']['registroOferta']['adelante']  = array( 37,43,44 );
         $this->arrFases['cem']['registroOferta']['salvar']    = "./contenidos/casaMano/salvarRegistroOferta.php";
         $this->arrFases['cem']['registroOferta']['plantilla'] = "desembolso/busquedaOferta.tpl";

         $this->arrFases['cem']['revisionJuridica']['grupos']    = array( 23,8,14,32 );
         $this->arrFases['cem']['revisionJuridica']['permisos']  = array( 44,45,46,47,48,15 );
         $this->arrFases['cem']['revisionJuridica']['atras']     = array( 37,43 );
         $this->arrFases['cem']['revisionJuridica']['adelante']  = array( 44 );
         $this->arrFases['cem']['revisionJuridica']['salvar']    = "./contenidos/casaMano/salvarRevisionJuridica.php";
         $this->arrFases['cem']['revisionJuridica']['plantilla'] = "desembolso/revisionJuridica.tpl";

         $this->arrFases['cem']['revisionTecnica']['grupos']    = array( 23,8,15,33 );
         $this->arrFases['cem']['revisionTecnica']['permisos']  = array( 44,45,46,47,48,15 );
         $this->arrFases['cem']['revisionTecnica']['atras']     = array( );
         $this->arrFases['cem']['revisionTecnica']['adelante']  = array( 44 );
         $this->arrFases['cem']['revisionTecnica']['salvar']    = "./contenidos/casaMano/salvarRevisionTecnica.php";
         $this->arrFases['cem']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";

         $this->arrFases['cem']['postulacion']['grupos']    = array( 23,7,8 );
         $this->arrFases['cem']['postulacion']['permisos']  = array( 44,46,47,48,15 );
         $this->arrFases['cem']['postulacion']['atras']     = array( 37,44 );
         $this->arrFases['cem']['postulacion']['adelante']  = array( 46,47 );
         $this->arrFases['cem']['postulacion']['salvar']    = "./contenidos/casaMano/salvarPostulacion.php";
         $this->arrFases['cem']['postulacion']['plantilla'] = "casaMano/postulacion.tpl";

         // este fnciona para mirar los permisos de quienes pueden obtener los pdf
         $this->arrFases['cem']['exportarPdf']['grupos']         = array( 23,8,14 );
         $this->arrFases['cem']['habitabilidadPdf']['grupos']    = array( 23,8,15 );

         $this->seqCasaMano             = 0;
         $this->seqFormulario           = 0;
         $this->fchRegistroVivienda     = null;

         $this->bolRevisionJuridica     = null;
         $this->fchRevisionJuridica     = null;
         $this->numDiasRevisionJuridica = 0;
         $this->txtRevisionJuridica     = "";
         $this->numDiasLimiteRevsionJuridica = 60;

         $this->bolRevisionTecnica      = null;
         $this->fchRevisionTecnica      = null;
         $this->numDiasRevisionTecnica  = 0;
         $this->txtRevisionTecnica      = "";
         $this->numDiasLimiteRevsionTecnica = 60;

         $this->bolPrimeraVerificacion  = null;
         $this->fchPrimeraVerificacion  = null;
         $this->seqPrimeraVerificacion  = null;
         $this->fchPostulacion          = null;
         $this->bolSegundaVerificacion  = null;
         $this->fchSegundaVerificacion  = null;
         $this->seqSegundaVerificacion  = null;

         $this->objRegistroOferta      = NULL;
         $this->objRevisionJuridica    = NULL;
         $this->objRevisionTecnica     = NULL;
         $this->objPostulacion         = NULL;
         $this->objPrimeraVerificacion = NULL;
         $this->objSegundaVerificacion = NULL;

         $this->arrErrores = array();
         $this->arrMensajes = array();

      }

      /**
       * CARGA TODOS LOS DATOS DEL REGISTRO DE CASA EN MANO
       * @global object $aptBd         // apuntador base de datos
       * @param integer $seqFormulario // identificador del formulario
       * @param integer $seqCasaMano   // identificador de casa en mano
       * @return array arrCasaMano     // arreglo que tiene todos los registros de casa en mano para un hogar
       */
      function cargar( $seqFormulario , $seqCasaMano = 0 ){
         global $aptBd;
         $arrCasaMano = array();

         try {

             $txtCondicion = "";
             $txtCondicion .= ( intval( $seqFormulario ) != 0 )? "AND seqFormulario = " . $seqFormulario ." " : ""; 
             $txtCondicion .= ( intval( $seqCasaMano )   != 0 )? "AND seqCasaMano   = " . $seqCasaMano   ." " : "";

             $sql = "
                 SELECT 
                     seqCasaMano,
                     seqFormulario,
                     fchRegistroVivienda,
                     bolRevisionJuridica,
                     fchRevisionJuridica,
                     txtRevisionJuridica,
                     bolRevisionTecnica,
                     fchRevisionTecnica,
                     txtRevisionTecnica,
                     bolPrimeraVerificacion,
                     fchPrimeraVerificacion,
                     seqPrimeraVerificacion,
                     fchPostulacion,
                     bolSegundaVerificacion,
                     fchSegundaVerificacion,
                     seqSegundaVerificacion
                 FROM T_CEM_CASA_MANO
                 WHERE 1 = 1 $txtCondicion
             ";

             $objRes = $aptBd->execute( $sql );
             while( $objRes->fields ){

                 $objCasaMano = new CasaMano();
                 foreach( $objRes->fields as $txtCampo => $txtValor ){
                     $objCasaMano->$txtCampo = $txtValor;
                 }

                 if( strtotime( $objCasaMano->fchRevisionJuridica ) != 0 ){
                     $objCasaMano->numDiasRevisionJuridica = intval( ( time() - strtotime( $objCasaMano->fchRevisionJuridica ) ) / 86400 ); 
                 }

                 if( strtotime( $objCasaMano->fchRevisionTecnica ) != 0 ){
                     $objCasaMano->numDiasRevisionTecnica = intval( ( time() - strtotime( $objCasaMano->fchRevisionTecnica ) ) / 86400 ); 
                 }

                 $objCasaMano->cargarRegistroOferta();
                 $objCasaMano->cargarRevisionJuridica();
                 $objCasaMano->cargarRevisionTecnica();
                 $objCasaMano->cargarPostulacion();
                 $objCasaMano->cargarPrimeraVerificacion();
                 $objCasaMano->cargarSegundaVerificacion();

                 $arrCasaMano[ $objRes->fields['seqCasaMano'] ] = $objCasaMano;

                 $objRes->MoveNext();
             }

         } catch ( Exception $objError ){
             $this->arrErrores[] = $objError->msg;
         }

         return $arrCasaMano;
      }
        
      public function cargarRegistroOferta(){
         global $aptBd;

         try{
             $sql = "
                 SELECT 
                   seqRegistroVivienda,
                   seqCasaMano,
                   numEscrituraPublica,
                   numCertificadoTradicion,
                   numCartaAsignacion,
                   numAltoRiesgo,
                   numHabitabilidad,
                   numBoletinCatastral,
                   numLicenciaConstruccion,
                   numUltimoPredial,
                   numUltimoReciboAgua,
                   numUltimoReciboEnergia,
                   numOtros,
                   txtNombreVendedor,
                   numDocumentoVendedor,
                   txtDireccionInmueble,
                   txtBarrio,
                   seqLocalidad,
                   txtEscritura,
                   numNotaria,
                   fchEscritura,
                   numAvaluo,
                   valInmueble,
                   txtMatriculaInmobiliaria,
                   numValorInmueble,
                   txtEscrituraPublica,
                   txtCertificadoTradicion,
                   txtCartaAsignacion,
                   txtAltoRiesgo,
                   txtHabitabilidad,
                   txtBoletinCatastral,
                   txtLicenciaConstruccion,
                   txtUltimoPredial,
                   txtUltimoReciboAgua,
                   txtUltimoReciboEnergia,
                   txtOtro,
                   txtViabilizoJuridico,
                   txtViabilizoTecnico,
                   bolViabilizoJuridico,
                   bolviabilizoTecnico,
                   bolPoseedor,
                   txtChip,
                   numActaEntrega,
                   txtActaEntrega,
                   numCertificacionVendedor,
                   txtCertificacionVendedor,
                   numAutorizacionDesembolso,
                   txtAutorizacionDesembolso,
                   numFotocopiaVendedor,
                   txtFotocopiaVendedor,
                   seqTipoDocumento,
                   txtCompraVivienda,
                   txtNit,
                   txtRit,
                   txtRut,
                   numNit,
                   numRit,
                   numRut,
                   txtTipoPredio,
                   numTelefonoVendedor,
                   txtCedulaCatastral,
                   numAreaConstruida,
                   numAreaLote,
                   txtTipoDocumentos,
                   numEstrato,
                   txtCiudad,
                   fchCreacion,
                   fchActualizacion,
                   numTelefonoVendedor2,
                   txtPropiedad,
                   fchSentencia,
                   numJuzgado,
                   txtCiudadSentencia,
                   numResolucion,
                   fchResolucion,
                   txtEntidad,
                   txtCiudadResolucion,
                   numContratoArrendamiento,
                   txtContratoArrendamiento,
                   numAperturaCAP,
                   txtAperturaCAP,
                   numCedulaArrendador,
                   txtCedulaArrendador,
                   numCuentaArrendador,
                   txtCuentaArrendador,
                   numRetiroRecursos,
                   txtRetiroRecursos,
                   numServiciosPublicos,
                   txtServiciosPublicos,
                   txtCorreoVendedor,
                   seqCiudad
                 FROM T_CEM_REGISTRO_VIVIENDA
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";
             $objRes = $aptBd->execute( $sql );
             while( $objRes->fields ){
                 foreach( $objRes->fields as $txtCampo => $txtValor ){
                      $this->objRegistroOferta->$txtCampo = $txtValor;
                 }
                 $objRes->MoveNext();
             }

         } catch ( Exception $objError ){
             $this->arrErrores[] = $objError->msg;
         }
      }

      public function cargarRevisionJuridica(){
         global $aptBd;

         try{
             $sql = "
                 SELECT 
                     seqJuridico,
                     seqCasaMano,
                     numResolucion,
                     fchResolucion,
                     txtObservaciones,
                     txtLibertad,
                     txtConcepto,
                     txtAprobo,
                     fchCreacion,
                     fchActualizacion
                 FROM T_CEM_JURIDICO
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";
             $objRes = $aptBd->execute( $sql );
             while( $objRes->fields ){
                 foreach( $objRes->fields as $txtCampo => $txtValor ){
                      $this->objRevisionJuridica[$txtCampo] = $txtValor;
                 }
                 $objRes->MoveNext();
             }

             if( intval( $this->objRevisionJuridica['seqJuridico'] ) != 0 ){
                 $sql = "
                     SELECT txtAdjunto
                     FROM T_CEM_ADJUNTOS_JURIDICOS
                     WHERE seqJuridico =  " . $this->objRevisionJuridica['seqJuridico'] . "
                     and seqTipoAdjunto = 1
                 ";
                 $objRes = $aptBd->execute( $sql );
                 while( $objRes->fields ){
                     $this->objRevisionJuridica['documento'][] = $objRes->fields['txtAdjunto'];
                     $objRes->MoveNext();
                 }

                 $sql = "
                     SELECT txtAdjunto
                     FROM T_CEM_ADJUNTOS_JURIDICOS
                     WHERE seqJuridico = " . $this->objRevisionJuridica['seqJuridico'] . "
                     and seqTipoAdjunto = 2
                 ";
                 $objRes = $aptBd->execute( $sql );
                 while( $objRes->fields ){
                     $this->objRevisionJuridica['recomendacion'][] = $objRes->fields['txtAdjunto'];
                     $objRes->MoveNext();
                 }
             }

         } catch ( Exception $objError ){
             $this->arrErrores[] = $objError->msg;
         }

      }

      public function cargarRevisionTecnica(){
         global $aptBd;
         global $txtPrefijoRuta;

         try{
             $sql = "
                 SELECT 
                     seqTecnico,
                     seqCasaMano,
                     numLargoMultiple,
                     numAnchoMultiple,
                     numAreaMultiple,
                     txtMultiple,
                     numLargoAlcoba1,
                     numAnchoAlcoba1,
                     numAreaAlcoba1,
                     txtAlcoba1,
                     numLargoAlcoba2,
                     numAnchoAlcoba2,
                     numAreaAlcoba2,
                     txtAlcoba2,
                     numLargoAlcoba3,
                     numAnchoAlcoba3,
                     numAreaAlcoba3,
                     txtAlcoba3,
                     numLargoCocina,
                     numAnchoCocina,
                     numAreaCocina,
                     txtCocina,
                     numLargoBano1,
                     numAnchoBano1,
                     numAreaBano1,
                     txtBano1,
                     numLargoBano2,
                     numAnchoBano2,
                     numAreaBano2,
                     txtBano2,
                     numLargoLavanderia,
                     numAnchoLavanderia,
                     numAreaLavanderia,
                     txtLavanderia,
                     numLargoCirculaciones,
                     numAnchoCirculaciones,
                     numAreaCirculaciones,
                     txtCirculaciones,
                     numLargoPatio,
                     numAnchoPatio,
                     numAreaPatio,
                     txtPatio,
                     numAreaTotal,
                     txtEstadoCimentacion,
                     txtCimentacion,
                     txtEstadoPlacaEntrepiso,
                     txtPlacaEntrepiso,
                     txtEstadoMamposteria,
                     txtMamposteria,
                     txtEstadoCubierta,
                     txtCubierta,
                     txtEstadoVigas,
                     txtVigas,
                     txtEstadoColumnas,
                     txtColumnas,
                     txtEstadoPanetes,
                     txtPanetes,
                     txtEstadoEnchapes,
                     txtEnchapes,
                     txtEstadoAcabados,
                     txtAcabados,
                     txtEstadoHidraulicas,
                     txtHidraulicas,
                     txtEstadoElectricas,
                     txtElectricas,
                     txtEstadoSanitarias,
                     txtSanitarias,
                     txtEstadoGas,
                     txtGas,
                     txtEstadoMadera,
                     txtMadera,
                     txtEstadoMetalica,
                     txtMetalica,
                     numLavadero,
                     txtLavadero,
                     numLavaplatos,
                     txtLavaplatos,
                     numLavamanos,
                     txtLavamanos,
                     numSanitario,
                     txtSanitario,
                     numDucha,
                     txtDucha,
                     txtEstadoVidrios,
                     txtVidrios,
                     txtEstadoPintura,
                     txtPintura,
                     txtOtros,
                     txtObservacionOtros,
                     numContadorAgua,
                     txtEstadoConexionAgua,
                     txtDescripcionAgua,
                     numContadorEnergia,
                     txtEstadoConexionEnergia,
                     txtDescripcionEnergia,
                     numContadorAlcantarillado,
                     txtEstadoConexionAlcantarillado,
                     txtDescripcionAlcantarillado,
                     numContadorGas,
                     txtEstadoConexionGas,
                     txtDescripcionGas,
                     numContadorTelefono,
                     txtEstadoConexionTelefono,
                     txtDescripcionTelefono,
                     txtEstadoAndenes,
                     txtDescripcionAndenes,
                     txtEstadoVias,
                     txtDescripcionVias,
                     txtEstadoServiciosComunales,
                     txtDescripcionServiciosComunales,
                     txtDescripcionVivienda,
                     txtNormaNSR98,
                     txtRequisitos,
                     txtExistencia,
                     txtDescipcionNormaNSR98,
                     txtDescripcionRequisitos,
                     txtDescripcionExistencia,
                     fchVisita,
                     txtAprobo,
                     fchCreacion,
                     fchActualizacion
                 FROM T_CEM_TECNICO
                 WHERE seqCasaMano = " . $this->seqCasaMano . "
             ";

             $objRes = $aptBd->execute( $sql );
             while( $objRes->fields ){
                 foreach( $objRes->fields as $txtCampo => $txtValor ){
                      $this->objRevisionTecnica[$txtCampo] = $txtValor;
                 }
                 $objRes->MoveNext();
             }

             if( intval( $this->objRevisionTecnica['seqTecnico'] ) != 0 ){

                 $sql = "
                     SELECT txtNombreAdjunto,
                            txtNombreArchivo,
                            seqTipoAdjunto
                       FROM T_CEM_ADJUNTOS_TECNICOS
                       WHERE seqTecnico =  " . $this->objRevisionTecnica['seqTecnico'] . "
                 "; 
                 $objRes = $aptBd->execute( $sql );
                 while( $objRes->fields ){

                     switch( $objRes->fields['seqTipoAdjunto'] ){
                         case 2:
                             $numContador = count( $this->objRevisionTecnica['observacion'] );
                             $this->objRevisionTecnica['observacion'][ $numContador ] = $objRes->fields['txtNombreAdjunto'];
                         break;
                         default: // Imagenes
                             $numContador = count( $this->objRevisionTecnica['imagenes'] );
                             $this->objRevisionTecnica['imagenes'][ $numContador ]['nombre'] = $objRes->fields['txtNombreAdjunto'];
                             $this->objRevisionTecnica['imagenes'][ $numContador ]['ruta']   = $objRes->fields['txtNombreArchivo'];
                             if( ! file_exists( $txtPrefijoRuta ."recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'] ) ){
                                 $this->objRevisionTecnica['imagenes'][ $numContador ]['nombre'] = "No Disponible";
                                 $this->objRevisionTecnica['imagenes'][ $numContador ]['ruta']   = "no_disponible.jpg"; 
                             }
                         break;
                     }

                     $objRes->MoveNext();
                 }
             }

         } catch ( Exception $objError ){
             $this->arrErrores[] = $objError->msg;
         }

      }
        
      public function cargarPostulacion(){
         $claFormulario = new FormularioSubsidios;
         $claFormulario->cargarFormulario( $this->seqFormulario );
         $this->objPostulacion = $claFormulario;
      }
        
      public function cargarPrimeraVerificacion(){
         global $aptBd;
         return true;
      }
        
      public function cargarSegundaVerificacion(){
         global $aptBd;
         return true;
      }
        
      public function salvarSeguimiento( $arrPost ){
         global $aptBd;

         if( intval( $arrPost['seqGrupoGestion'] ) == 0 ){
             $this->arrErrores[] = "Seleccione el grupo de la gesti&oacute;n realizada";
         }

         if( intval( $arrPost['seqGestion'] ) == 0 ){
             $this->arrErrores[] = "Seleccione la gesti&oacute;n realizada";
         }

         if( trim( $arrPost['txtComentario'] ) == "" ){
             $this->arrErrores[] = "Por favor diligencie el campo de comentarios";
         }

         if( empty( $this->arrErrores ) ){
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
                   " . $arrPost['seqFormulario'] . ",
                   '" . date( "Y-m-d H:i:s" ) . "',
                   ". $_SESSION['seqUsuario'] .",
                   '". $arrPost['txtComentario'] ."',
                   '".$arrPost['txtCambios']."',
                   ". mb_ereg_replace("[^0-9]", "", $arrPost['cedula'] ) .",
                   '". $arrPost['nombre'] ."',
                   ".$arrPost['seqGestion']."
                 )	
             ";
             try {
                 $aptBd->execute( $sql );
                 $this->arrMensajes[] = "Ha salvado un registro de actividad, el n&uacute;mero del registro es " . 
                                         number_format( $aptBd->Insert_ID() , 0 , "." , "," ) . ". Conserve este " .
                                         "n&uacute;mero para su referencia.";
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido registrar el seguimiento, contacte al administrador del sistema";
                 //$this->arrErrores[] = $objError->msg;
             }		
         }
      }
        
      public function salvar( $arrPost ){
         global $aptBd;
         
         $txtGrupo = "SDHT";
         $seqProyecto = $_SESSION['seqProyecto'];
         if( 
            in_array( 31 , $_SESSION['arrGrupos'][ $seqProyecto ] ) or 
            in_array( 32 , $_SESSION['arrGrupos'][ $seqProyecto ] ) or 
            in_array( 33 , $_SESSION['arrGrupos'][ $seqProyecto ] )
         ){
            $txtGrupo = "CVP";
         }
         
         unset( $arrPost['bolBorrar'] );

         // Lenguaje para la conversion de fechas
         date_default_timezone_set("America/Bogota");

         $this->salvarSeguimiento( $arrPost );

         if( empty ( $this->arrErrores ) ){

             if( intval( $arrPost['seqCasaMano'] ) == 0 ){

                 $sql = "
                     INSERT INTO T_CEM_CASA_MANO(
                         seqFormulario,
                         fchRegistroVivienda,
                         bolRevisionJuridica,
                         fchRevisionJuridica,
                         txtRevisionJuridica,
                         bolRevisionTecnica,
                         fchRevisionTecnica,
                         txtRevisionTecnica,
                         fchPostulacion,
                         fchPrimeraVerificacion,
                         fchSegundaVerificacion,
                         txtGrupo
                     ) VALUES (
                         " . $arrPost['seqFormulario'] . ",
                         NOW(),
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         NULL,
                         '$txtGrupo'
                     )
                 ";
				 $sqlEsquema = "
						UPDATE 
							T_FRM_FORMULARIO 
						SET 
							seqTipoEsquema= 5 
						WHERE 
							seqFormulario = " . $arrPost['seqFormulario'];
                 try{
                     $aptBd->execute( $sql );
                     $arrPost['seqCasaMano'] = $aptBd->Insert_ID();
                 } catch ( Exception $objError ){
                     $this->arrErrores[] = "No se ha podido adicionar el registro de casa en mano";
                 }
				 if( empty ( $this->arrErrores ) ){
					$aptBd->execute( $sqlEsquema );
				 }

             }else{

                 // actualizando el registro de casa en mano
                 switch( $arrPost['txtFase'] ){
                     case "registroOferta":
                         $arrCampos['fchRegistroVivienda'] = date( "Y-m-d H:i:s" );
                         break;
                     case "revisionJuridica":
                         $arrCampos['bolRevisionJuridica'] = ( $arrPost['txtConcepto'] == "" )? "" : $arrPost['txtConcepto'];
                         $arrCampos['fchRevisionJuridica'] = date( "Y-m-d H:i:s" );
                         $arrCampos['txtRevisionJuridica'] = $arrPost['concepto'];                            
                         break;
                     case "revisionTecnica":
                         $arrCampos['bolRevisionTecnica'] = ( $arrPost['txtConcepto'] == "" )? "" : $arrPost['txtConcepto'];
                         $arrCampos['fchRevisionTecnica'] = $arrPost['fchVisita'];
                         $arrCampos['txtRevisionTecnica'] = $arrPost['txtDescripcionVivienda'];                            
                         break;
                     case "primeraVerificacion":
                         $arrCampos['bolPrimeraVerificacion'] = $arrPost['bolResultado'];
                         $arrCampos['fchPrimeraVerificacion'] = $arrPost['fchCruce'];
                         $arrCampos['seqPrimeraVerificacion'] = $arrPost['seqCruce'];
                         break;
                     case "postulacion":
                         if( $this->objPostulacion->bolCerrado == 0 and $arrPost['bolCerrado'] == 1 ){
                             $arrCampos['fchPostulacion'] = $arrPost['fchPostulacion'];
                         }else{
                             $arrCampos['fchPostulacion'] = "";
                         }
                         break;
                     case "segundaVerificacion":
                         $arrCampos['bolSegundaVerificacion'] = $arrPost['bolResultado'];
                         $arrCampos['fchSegundaVerificacion'] = $arrPost['fchCruce'];
                         $arrCampos['seqSegundaVerificacion'] = $arrPost['seqCruce'];                            
                         break;
                 }

                 if( ! empty( $arrCampos ) ){

                     $sql = "UPDATE T_CEM_CASA_MANO SET ";
                     foreach( $arrCampos as $txtCampo => $txtValor ){
                         $sql.= $txtCampo . " = '" . $txtValor . "',";
                         $this->$txtCampo = $txtValor;
                     }
                     $sql = trim( $sql , "," );
                     $sql.= " WHERE seqCasaMano = " . intval( $arrPost['seqCasaMano'] ) . " " . 
                            "AND seqFormulario = " . intval( $arrPost['seqFormulario'] );

                     try {
                         $aptBd->execute( $sql );
                     } catch ( Exception $objError ){
                         $this->arrErrores[] = "No se ha podido actualizar el registro de casa en mano";
                     }
                 }

             }

             if( empty( $this->arrErrores ) ){

                 switch( $arrPost['txtFase'] ){
                     case "registroOferta":
                         $this->salvarRegistroOferta( $arrPost );
                         $this->modificarEstadoProceso( $arrPost );
                         break;
                     case "revisionJuridica":
                         $this->salvarRevisionJuridica( $arrPost );
                         $this->modificarEstadoProceso( $arrPost );
                         $this->verificacionConceptos( $arrPost );
                         break;
                     case "revisionTecnica":
                         $this->salvarRevisiontecnica( $arrPost );
                         $this->modificarEstadoProceso( $arrPost );
                         $this->verificacionConceptos( $arrPost );
                         break;
                     case "primeraVerificacion":
                         $this->verificacionConceptos( $arrPost );
                         break;
                     case "postulacion":
                         $this->salvarPostulacion( $arrPost );
                         $this->modificarEstadoProceso( $arrPost );
                         break;
                     case "segundaVerificacion":
                         $arrPost['seqEstadoProceso'] = ( intval( $arrPost['bolResultado'] ) == 1 )? 16 : 48;
                         $this->modificarEstadoProceso( $arrPost );
                         break;
                 }

             }

         }
         return $arrPost['seqCasaMano'];
      }
        
      public function modificarEstadoProceso( $arrPost ){
         global $aptBd;

         // La modadlidad del hogar se afecta cuando se selecciona vivienda nueva o usada
         // Para Vivienda nueva la modalidad queda en 6  - Adquisición de Vivienda Nueva
         // Para Vivienda usada la modalidad queda en 11 - Adquisición de Vivienda Usada
         $txtModalidad = "";
         if( isset( $arrPost['txtCompraVivienda'] ) and trim( $arrPost['txtCompraVivienda'] ) != "" ){
             $txtModalidad  = ",seqModalidad = ";
             $txtModalidad .= ( trim( $arrPost['txtCompraVivienda'] ) == "nueva" )? 6 : 11;
         }

         // Coloca el estado del proceso seleccionado por el usuario
		 /*echo "arrPost[seqFormulario]:".$arrPost['seqFormulario']."<br>";
		 echo "arrPost[estadoActual]:".$arrPost['estadoActual']."<br>";
		 echo "arrPost[seqEstadoProceso]:".$arrPost['seqEstadoProceso']."<br>";*/
		 
		 /*modificacion para que actualice el estado del proceso unicamente cuando cumpla las condiciones:
			 Campo -> bolPrimeraVerificacion en nulo o vacio
			 Campo -> bolRevisionJuridica que este en 1
			 Campo -> bolRevisionTecnica que este en 1
			 Los valores de estos campos son obtenidos desde -> \sdv\contenidos\cruces\salvarCruces.php
			 */
		 if($arrPost['bolPrimeraVerificacion'] == "" && $arrPost['bolRevisionJuridica'] == 1 && $arrPost['bolRevisionTecnica'] == 1){
                     
                     $sql = "
				 UPDATE T_FRM_FORMULARIO SET
					 seqEstadoProceso = 46,
					 seqTipoEsquema = 5
					 $txtModalidad
				 WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
			 ";
			 //echo "sql:".$sql;

			 try {
				 $aptBd->execute( $sql );
			 } catch ( Exception $objError ){
				 $this->arrErrores[] = "No se pudo modificar el estado del proceso";
			 }            
                     
                 }
				 
				 /*--- Fin de la modificacion subida el Jueves 9 de Octubre de 2014 ---*/
				 
		 /*
		 if ($arrPost['estadoActual'] != 15 ){
			 $sql = "
				 UPDATE T_FRM_FORMULARIO SET
					 seqEstadoProceso = " . $arrPost['seqEstadoProceso'] . ",
					 seqTipoEsquema = 5
					 $txtModalidad
				 WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
			 ";
			 //echo "sql:".$sql;

			 try {
				 $aptBd->execute( $sql );
			 } catch ( Exception $objError ){
				 $this->arrErrores[] = "No se pudo modificar el estado del proceso";
			 }            
		}*/
      }
        
      public function salvarRegistroOferta( $arrPost ){
         global $aptBd;

         // Lenguaje para la conversion de fechas
         date_default_timezone_set("America/Bogota");

         // Obtiene el registro de la oferta que 
         // esta asociada con el registro de casa en mano
         $sql = "
             SELECT seqRegistroVivienda
             FROM T_CEM_REGISTRO_VIVIENDA
             WHERE seqCasaMano = " . intval( $arrPost['seqCasaMano'] );

         $objRes = $aptBd->execute( $sql );
         $seqRegistroOferta = 0;
         if( $objRes->fields ){
             $seqRegistroOferta = $objRes->fields['seqRegistroVivienda'];
         }

         $arrPost['txtTipoDocumentos'] = $arrPost['documentos'];

		 $formu = $arrPost['seqFormulario'] ;
		 $estadoProceso = $arrPost['seqEstadoProceso'] ;
         // quita las variables del post que no sirven
		 unset( $arrPost['seqGrupoGestion'] );
         unset( $arrPost['txtComentario'] );
         unset( $arrPost['seqGestion'] );
         unset( $arrPost['seqFormulario'] );
         unset( $arrPost['txtFlujo'] );
         unset( $arrPost['txtFase'] );
         unset( $arrPost['cedula'] );
         unset( $arrPost['seqEstadoProceso'] );
         unset( $arrPost['radTipoDireccion'] );
         unset( $arrPost['documentos'] );
         unset( $arrPost['nombre'] );

         // Si no existe registro de vivienda lo inserta
         if( $seqRegistroOferta == 0 ){

             $arrPost['fchCreacion'] = date( "Y-m-d H:i:s" );
             $arrPost['fchActualizacion'] = NULL;

             $sql = "INSERT INTO T_CEM_REGISTRO_VIVIENDA (";
             $sql.= implode( "," , array_keys( $arrPost ) ) . ") VALUES (";
             $sql.= "'" . implode( "','" , $arrPost ) . "')";

			 $sqlInmueble = "UPDATE T_FRM_FORMULARIO SET txtDireccionSolucion = '".$arrPost['txtDireccionInmueble']."' WHERE seqFormulario = ".$formu."";
			 
             try{
                 $aptBd->execute( $sql );
                 $seqRegistroOferta = $aptBd->Insert_ID();
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido adicionar el registro de la vivienda";
             }
			 
			 try{
                 $aptBd->execute( $sqlInmueble );
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido actualizar el inmueble en el formulario";
             }

         } else {

             $arrPost['fchActualizacion'] = date( "Y-m-d H:i:s" );

             $sql = "UPDATE T_CEM_REGISTRO_VIVIENDA SET ";
             foreach( $arrPost as $txtCampo => $txtValor ){
                 $sql.= $txtCampo . " = '" . $txtValor . "',";
             }
             $sql = trim( $sql , "," );
             $sql.= "WHERE seqCasaMano = " . $arrPost['seqCasaMano'];

			 $sqlInmueble = "UPDATE T_FRM_FORMULARIO SET txtDireccionSolucion = '".$arrPost['txtDireccionInmueble']."' WHERE seqFormulario = ".$formu."";
			 
			 $sqlEstadoProceso = "UPDATE T_FRM_FORMULARIO SET seqEstadoProceso = '".$estadoProceso."' WHERE seqFormulario = ".$formu."";
			 
             try {
                 $aptBd->execute( $sql );
				 $aptBd->execute( $sqlInmueble );
				 $aptBd->execute( $sqlEstadoProceso );
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido actualizar el registro de la vivienda";
                 //$objError->msg
             }

         }

      }
        
      public function salvarRevisionJuridica( $arrPost ){
         global $aptBd;

         // Lenguaje para la conversion de fechas
         date_default_timezone_set("America/Bogota");

         // Obtiene el registro de la oferta que 
         // esta asociada con el registro de casa en mano
         $sql = "
             SELECT seqJuridico
             FROM T_CEM_JURIDICO
             WHERE seqCasaMano = " . intval( $arrPost['seqCasaMano'] );

         $objRes = $aptBd->execute( $sql );
         $seqJuridico = 0;
         if( $objRes->fields ){
             $seqJuridico = $objRes->fields['seqJuridico'];
         }

         // Si no existe registro de vivienda lo inserta
         if( $seqJuridico == 0 ){

             $arrPost['fchCreacion'] = date( "Y-m-d H:i:s" );
             $arrPost['fchActualizacion'] = NULL;

             $sql = "
                 INSERT INTO T_CEM_JURIDICO (
                     seqCasaMano,
                     numResolucion,
                     fchResolucion,
                     txtObservaciones,
                     txtLibertad,
                     txtConcepto,
                     txtAprobo,
                     fchCreacion,
                     fchActualizacion
                 ) VALUES (
                     '" . $arrPost['seqCasaMano'] . "',
                     NULL,
                     NULL,
                     '" . $arrPost['observaciones'] . "',
                     '" . $arrPost['libertad'] . "',
                     '" . $arrPost['concepto'] . "',
                     '" . $arrPost['aprobo'] . "',
                     '" . date( "Y-m-d H:i:s" ) . "',
                     NULL
                 )
             ";

             try{
                 $aptBd->execute( $sql );
                 $seqJuridico = $aptBd->Insert_ID();
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido adicionar la revisión jurídica";
                 //$objError->msg
             }

         }else{

             $sql = "
                 UPDATE T_CEM_JURIDICO SET
                     seqCasaMano = '" . $arrPost['seqCasaMano'] . "',
                     numResolucion = '',
                     fchResolucion = '',
                     txtObservaciones = '" . $arrPost['observaciones'] . "',
                     txtLibertad = '" . $arrPost['libertad'] . "',
                     txtConcepto = '" . $arrPost['concepto'] . "',
                     txtAprobo = '" . $arrPost['aprobo'] . "',
                     fchActualizacion = '" . date( "Y-m-d H:i:s" ) . "'
                 WHERE seqCasaMano = '" . $arrPost['seqCasaMano'] . "'
             ";
             try {
                 $aptBd->execute( $sql );
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido actualizar la revisión jurídica";
                 //$objError->msg
             }


         }

         /**
          * ELIMINA LOS REGISTROS DE LOS 
          * DOCUMENTOS Y RECOMENDACIONES
          */

          $sql = "
             DELETE 
             FROM T_CEM_ADJUNTOS_JURIDICOS
             WHERE seqJuridico = $seqJuridico
          ";
          $aptBd->execute( $sql );

          /**
          * INSERTA LOS REGISTROS DE 
          * LOS DOCUMENOS ANALIZADOS
          */

          if( ! empty( $arrPost['documento'] ) ){
             foreach( $arrPost['documento'] as $txtDocumento ){
                 $sql = " 
                     INSERT INTO T_CEM_ADJUNTOS_JURIDICOS ( 
                         seqJuridico, 
                         seqTipoAdjunto, 
                         txtAdjunto
                     ) VALUES (
                         $seqJuridico,
                         1,
                         \"$txtDocumento\"
                     )
                 ";
                 try{
                     $aptBd->execute( $sql );
                 } catch ( Exception $objError ){
                     $this->arrErrores[] = $objError->msg;
                 }
             }
          }

          if( ! empty( $arrPost['recomendacion'] ) ){
             foreach( $arrPost['recomendacion'] as $txtRecomendacion ){
                 $sql = " 
                     INSERT INTO T_CEM_ADJUNTOS_JURIDICOS ( 
                         seqJuridico, 
                         seqTipoAdjunto, 
                         txtAdjunto
                     ) VALUES (
                         $seqJuridico,
                         2,
                         \"$txtRecomendacion\"
                     )
                 ";
                 try{
                     $aptBd->execute( $sql );
                 } catch ( Exception $objError ){
                     $this->arrErrores[] = $objError->msg;
                 }			
             }						
          }
      }
        
      public function salvarRevisionTecnica( $arrPost ){
         global $aptBd;
         global $txtPrefijoRuta;

         // Lenguaje para la conversion de fechas
         date_default_timezone_set("America/Bogota");

         // Obtiene el registro de la oferta que 
         // esta asociada con el registro de casa en mano
         $sql = "
             SELECT seqTecnico
             FROM T_CEM_TECNICO
             WHERE seqCasaMano = " . intval( $arrPost['seqCasaMano'] );

         $objRes = $aptBd->execute( $sql );
         $seqTecnico = 0;
         if( $objRes->fields ){
             $seqTecnico = $objRes->fields['seqTecnico'];
         }

         // quita las variables del post que no sirven
         unset( $arrPost['seqGrupoGestion'] );
         unset( $arrPost['txtComentario'] );
         unset( $arrPost['seqGestion'] );
         unset( $arrPost['seqFormulario'] );
         unset( $arrPost['txtFlujo'] );
         unset( $arrPost['txtFase'] );
         unset( $arrPost['cedula'] );
         unset( $arrPost['seqEstadoProceso'] );
         unset( $arrPost['nombre'] );
         unset( $arrPost['txtConcepto'] );

         // Obtiene el arreglo de los archivos cargados
         $arrNombreArchivoCargado = array();
         $arrTextoArchivoCargado  = array();
         $arrObservaciones        = array();

         if( ! empty( $arrPost['nombreArchivoCargado'] ) ){
             $arrNombreArchivoCargado = $arrPost['nombreArchivoCargado'];
             $arrTextoArchivoCargado  = $arrPost['textoArchivoCargado'];
         }

         if( ! empty( $arrPost['observacion'] ) ){
             $arrObservaciones = $arrPost['observacion'];
         }

         unset( $arrPost['nombreArchivoCargado'] );
         unset( $arrPost['textoArchivoCargado'] );
         unset( $arrPost['observacion'] );

         // Si no existe registro de vivienda lo inserta
         if( $seqTecnico == 0 ){

             $arrPost['fchCreacion'] = date( "Y-m-d H:i:s" );
             $arrPost['fchActualizacion'] = NULL;

             $sql = "INSERT INTO T_CEM_TECNICO (";
             $sql.= implode( "," , array_keys( $arrPost ) ) . ") VALUES (";
             $sql.= "'" . implode( "','" , $arrPost ) . "')";

             try { 
                 $aptBd->execute( $sql );
                 $seqTecnico = $aptBd->Insert_ID();
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido adicionar el registro técnico";
                 //$objError->msg
             }

         } else {

             $arrPost['fchActualizacion'] = date( "Y-m-d H:i:s" );

             $sql = "UPDATE T_CEM_TECNICO SET ";
             foreach( $arrPost as $txtCampo => $txtValor ){
                 $sql.= $txtCampo . " = '" . $txtValor . "',";
             }
             $sql = trim( $sql , "," );
             $sql.= "WHERE seqCasaMano = " . $arrPost['seqCasaMano'];

             try {
                 $aptBd->execute( $sql );
             } catch ( Exception $objError ){
                 $this->arrErrores[] = "No se ha podido actualizar el registro técnico";
             }

         }

         /**
         * SALVAR LAS IMAGENES
         */

        $arrNombreArchivoCargado = ( is_array( $arrNombreArchivoCargado ) )? $arrNombreArchivoCargado : array() ;
        if( is_dir( $txtPrefijoRuta ."recursos/imagenes/desembolsos" ) ){
           if( $aptDir = opendir( $txtPrefijoRuta ."recursos/imagenes/desembolsos" ) ){

                   // Elimina de la carpeta los archivos que no esten en el arreglo que viene del formulario
              while( ( $txtArchivo = readdir( $aptDir ) ) !== false ){
                 if( $txtArchivo != "." and $txtArchivo != ".." ){
                    $numFormulario = intval( substr( $txtArchivo , 0 , strpos( $txtArchivo , "_" ) ) );
                    $seqFormulario = ( intval($seqFormulario) == 0 )? $this->seqFormulario : $seqFormulario;
                    if( $numFormulario == $seqFormulario ){
                       if( ! in_array( $txtArchivo , $arrNombreArchivoCargado ) ){
                          unlink( $txtPrefijoRuta ."recursos/imagenes/desembolsos/" . $txtArchivo );
                       }
                    }
                 }
              }
              closedir( $aptDir );

                   // Elimina los registros de las imagenes que haya
                   // para insertar las que vienen en el formulario
                   // las imagenes ya estan fisicamente en la carpeta desde 
                   // que se cargan en el formulario
              $sql = "
                 DELETE 
                 FROM T_CEM_ADJUNTOS_TECNICOS
                 WHERE seqTecnico =  $seqTecnico
              ";
              $aptBd->execute( $sql );

                   // Para cada imagen se inserta el registro en la base de datos
              foreach( $arrNombreArchivoCargado as $numIndice => $txtNombreArchivo ){
                 $sql = "
                    INSERT INTO T_CEM_ADJUNTOS_TECNICOS (
                       seqTecnico,
                       seqTipoAdjunto,
                       txtNombreAdjunto,
                       txtNombreArchivo
                    ) VALUES (
                       $seqTecnico,
                       3,
                       '" . $arrTextoArchivoCargado[ $numIndice ] . "',
                       '$txtNombreArchivo'
                    )
                 ";
                 try {
                    $aptBd->execute( $sql );
                 } catch ( Exception $objError ){
                    $this->arrErrores[] = "No se pudo almacenar los datos de la imagen $txtNombreArchivo";
                 }
              }

                   $arrObservaciones = ( is_array( $arrObservaciones ) )? $arrObservaciones : array() ;
              foreach( $arrObservaciones as $numIndice => $txtTexto ){
                 $sql = "
                    INSERT INTO T_CEM_ADJUNTOS_TECNICOS (
                       seqTecnico,
                       seqTipoAdjunto,
                       txtNombreAdjunto,
                       txtNombreArchivo
                    ) VALUES (
                       $seqTecnico,
                       2,
                       '" . $txtTexto . "',
                       ''
                    )
                 ";
                 try {
                    $aptBd->execute( $sql );
                 } catch ( Exception $objError ){
                    $this->arrErrores[] = "No se pudo almacenar una de las observaciones ( $numIndice )";
                 }
              }

           } else {
              $this->arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, no se pudo abrir el directorio de imagenes";
           }
        } else {
           $this->arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, falta la carpeta de imagenes";
        }

      }
        
      public function salvarPostulacion( $arrPost ){
         global $aptBd;
		  pr($arrPost);die();

         $seqFormulario = $arrPost['seqFormulario'];

         if( $_SESSION['privilegios']['cambiar'] == 1 ){
             $bolCambios = true;    
         } else {
             if( $this->objPostulacion->bolCerrado == 1 and $arrPost['bolCerrado'] == 1 ){
                 $bolCambios = false;
             } else {
                 $bolCambios = true;
             }
         }

         // si el formulario ya estaba cerrado no se puede modificar
         if( $bolCambios == false ){
             $this->arrErrores[] = "El formulario ya esta cerrado, no puede realizar cambios";
         }else{

             // Procesamiento de todos los miembros de hogar
             foreach( $arrPost['hogar'] as $numDocumento => $arrCiudadano ){

                 // Pone los valores correspondientes del post en la clase
                 $claCiudadano = new Ciudadano();
                 foreach( $arrCiudadano as $txtClave => $txtValor ){
                     $claCiudadano->$txtClave = $txtValor;
                 }

                 // Verifica si el ciudadano no existe para crearlo o editarlo
                 $seqCiudadano = $claCiudadano->ciudadanoExiste( $arrCiudadano['seqTipoDocumento'] , $numDocumento );
                 if( $seqCiudadano == 0 ){
                     $seqCiudadano = $claCiudadano->guardarCiudadano();
                 }else{

                     // formulario del ciudadano para saber si existe 
                     // y si existe ademas debe ser del msmo formulario
                     // porque si lo estan tratando de meter en otro
                     // de todas maneras actualiza la info del primero
                     $sql = " 
                         SELECT 
                             frm.seqFormulario, 
                             frm.txtFormulario
                         FROM 
                             T_FRM_HOGAR hog, 
                             T_FRM_FORMULARIO frm
                         WHERE hog.seqCiudadano = $seqCiudadano
                           AND hog.seqFormulario = frm.seqFormulario
                         GROUP BY 
                             frm.seqFormulario, 
                             frm.txtFormulario
                     ";
                     $objRes = $aptBd->execute( $sql );
                     if( $objRes->fields ){
                         $seqFormularioCiudadano = $objRes->fields['seqFormulario'];
                     }

                     // El ciudadano existente debe estar vinculado el mismo formulario presente
                     // si esta vinculado a otro formulario es un error
                     if( $seqFormularioCiudadano == $arrPost['seqFormulario'] ){
                         $claCiudadano->editarCiudadano( $seqCiudadano );
                     } else {
                         $txtNombre = strtolower( ucwords( $arrCiudadano['txtNombre1'] ." " . $arrCiudadano['txtNombre2'] . " " . $arrCiudadano['txtApellido1'] ." " . $arrCiudadano['txtApellido2'] ) );
                         $this->arrErrores[] = "El ciudadano [ " . number_format( $numDocumento , 0 , "," , "." ) . " ] $txtNombre esta vinculado a otro hogar, verifique el formulario " . $objRes->fields['txtFormulario'];
                     }

                 }

                 // Los errores de la clase ciudadano  se pasan a la clase presente
                 if( ! empty( $claCiudadano->arrErrores ) ){
                     foreach ( $claCiudadano->arrErrores as $txtError ){
                         $this->arrErrores[] = $txtError;
                     }
                 }

                 // Quita los valores anteiores del objeto posulacion y los reemplaza con los actuales del post
                 // que fueron transladados a claCiudadano
                 if( empty( $this->arrErrores ) ){    
                     if( isset( $this->objPostulacion->arrCiudadano[ $seqCiudadano ] ) ){
                         unset( $this->objPostulacion->arrCiudadano[ $seqCiudadano ] );
                     }
                     $this->objPostulacion->arrCiudadano[ $seqCiudadano ] = $claCiudadano;
                 }

             } // foreach procesamiento del hogar que viene en el post

             // si hay miembros de hogar que se quitan se borran de la base de datos
             foreach( $this->objPostulacion->arrCiudadano as $seqCiudadano => $objCiudadano ){
                 $numDocumento = $objCiudadano->numDocumento;
                 if( ! isset( $arrPost['hogar'][ $numDocumento ] ) ){
                     $arrCiudadanoEliminado[$numDocumento] = $seqCiudadano;
                 }
             }

             // ya no se requiere el arreglo de hogar en el post
             unset( $arrPost['hogar'] );

             // Si no hay errores
             if( empty( $this->arrErrores ) ){

                 if( isset( $arrPost[ 'bolCerrado' ] ) ){
                     $arrPost[ 'bolCerrado' ] = 1;
                 } else {
                     $arrPost[ 'bolCerrado' ] = 0;
                 }

                 $this->objPostulacion->fchUltimaActualizacion = date( "Y-m-d H:i:s" );

                 // obtiene la fecha de postulacion la primera vez que cierra el formulario
                 if( intval( $this->objPostulacion->bolCerrado ) == 0 and $arrPost[ 'bolCerrado' ] == 1 ){
                     $this->objPostulacion->fchPostulacion = $arrPost['fchPostulacion'];
                 } elseif( intval( $this->objPostulacion->bolCerrado ) == 1 and $arrPost[ 'bolCerrado' ] == 1 ) {
                 }else{
                     $arrPost['fchPostulacion'] = "";
//                        $arrPost['txtFormulario']  = "";
                 }

                 // quitando variables no necesarias
                 unset( $arrPost['seqGrupoGestion'] );
                 unset( $arrPost['txtComentario'] );
                 unset( $arrPost['salvar'] );
                 unset( $arrPost['fechaNac'] );
                 unset( $arrPost['txtArchivo'] );
                 unset( $arrPost['txtCiudadanoAtendido'] );
                 unset( $arrPost['seqCasaMano'] );
                 unset( $arrPost['txtFase'] );
                 unset( $arrPost['txtFlujo'] );
                 unset( $arrPost['cedula'] );
                 unset( $arrPost['nombre'] );
                 unset( $arrPost['fchPostulacion'] );
                 unset( $arrPost['seqFormulario'] );
                 unset( $arrPost['seqEstadoProceso'] );

                 foreach( $arrPost as $txtClave => $txtValor ){
                     $this->objPostulacion->$txtClave = $txtValor;
                 }
                 $this->objPostulacion->txtSoproteAporteLote = $arrPost['txtSoporteLote'];

                 $this->objPostulacion->editarFormulario( $seqFormulario );

                 if( empty( $this->objPostulacion->arrErrores ) ){

                     $sql = "
                         DELETE
                         FROM T_FRM_HOGAR
                         WHERE seqFormulario = $seqFormulario
                     "; //echo $sql ."<br>";
                     $aptBd->execute( $sql );

                     // Salvando el hogar
                     foreach( $this->objPostulacion->arrCiudadano as $seqCiudadano => $objCiudadano ){
                         if( ! @in_array($seqCiudadano, $arrCiudadanoEliminado ) ){
                             $sql = "
                                 INSERT INTO T_FRM_HOGAR (
                                   seqCiudadano,
                                   seqFormulario,
                                   bolSoporteDocumento,
                                   seqParentesco
                                 ) VALUES (
                                   $seqCiudadano,
                                   $seqFormulario,
                                   0,
                                   ".$objCiudadano->seqParentesco."
                                 )
                             "; 
                             try { //echo $sql ."<br>";
                                 $aptBd->execute( $sql );
                             } catch ( Exception $objError ){						
                                 $this->arrErrores[] = "No se ha podido salvar los datos del hogar";
                             }					
                         }
                     }

                     // Si se eliminaron miembros de ahogar hay que eliminarlos del sistema
               if( ! empty( $arrCiudadanoEliminado ) ){
                  foreach( $arrCiudadanoEliminado as $seqCiudadano ){
                     $sql = "
                        DELETE 
                        FROM T_CIU_CIUDADANO
                        WHERE seqCiudadano = $seqCiudadano
                     "; //echo $sql ."<br>";
                     $aptBd->execute( $sql );
                  }
               }

                 }else{
                     $this->arrErrores = $this->objPostulacion->arrErrores;
                 }
             }
         } 
      }
        
      public function cambios( $arrPost ){

         $bolCambios = false;

         /******************************************************************
          * Cambios en registro de oferta
          ******************************************************************/

         if( trim( $arrPost['txtFase'] ) == "registroOferta" ){
             foreach( $this->objRegistroOferta  as $txtClave => $txtValor ){
                 if( isset( $arrPost[ $txtClave ] ) ){
                     switch( substr( $txtClave , 0 , 3 ) ){
                         case "num":
                             $bolCambios = ( intval( $txtValor ) != intval( $arrPost[ $txtClave ] ) )? true : $bolCambios;
                         break;
                         case "seq":
                             $bolCambios = ( intval( $txtValor ) != intval( $arrPost[ $txtClave ] ) )? true : $bolCambios;
                         break;
                         case "fch":
                             $bolCambios = ( strtotime( $txtValor ) != strtotime( $arrPost[ $txtClave ] ) )? true : $bolCambios;
                         break;
                         case "txt":
                             $bolCambios = ( trim( strtoupper( $txtValor ) ) != trim( strtoupper( $arrPost[ $txtClave ] ) ) )? true : $bolCambios;
                         break;
                         default:
                             $bolCambios = ( trim( $txtValor ) != trim( $arrPost[ $txtClave ] ) )? true : $bolCambios;
                         break;
                     }
                 }
             }
         }

         // Cambios en el tipo de persona
         if( isset( $arrPost['documentos'] ) ){
             if( trim( $this->objRegistroOferta->txtTipoDocumentos ) != trim( $arrPost['documentos'] ) ){
                 $bolCambios = true;
             }
         }

//            echo "Registro de vivienda<br>";
//            var_dump($bolCambios);

         /******************************************************************
          * Cambios en revision juridica
          ******************************************************************/
         if( trim( $arrPost['txtFase'] ) == "revisionJuridica" ){

             if( empty( $this->objRevisionJuridica ) ){
                 if( trim( $arrPost['aprobo'] ) != "" ){
                     $bolCambios = true;
                 }else{
                     $bolCambios = false;
                 }
             } else {
                 // verificando que los datos sean iguales
                 if( intval( $this->bolRevisionJuridica ) != trim( $arrPost[ "txtConcepto" ] ) ){
                     $bolCambios = true;
                 }

                 if( trim( $this->objRevisionJuridica[ "txtAprobo" ] ) != trim( $arrPost[ "aprobo" ] ) ){
                     $bolCambios = true;
                 }

                 if( trim( $this->objRevisionJuridica[ "txtObservaciones" ] ) != trim( $arrPost[ "observaciones" ] ) ){
                     $bolCambios = true;
                 }

                 if( trim( $this->objRevisionJuridica[ "txtLibertad" ] ) != trim( $arrPost[ "libertad" ] ) ){
                     $bolCambios = true;
                 }

                 if( trim( $this->objRevisionJuridica[ "txtConcepto" ] ) != trim( $arrPost[ "concepto" ] ) ){
                     $bolCambios = true;
                 }

                 // verificando que no cambien los documentos
                 $arrPost[ "documento" ] = ( ! isset( $arrPost[ "documento" ] ) )? array() : $arrPost[ "documento" ];
                 if( count( $this->objRevisionJuridica[ "documento" ] ) != count( $arrPost[ "documento" ] ) ){
                     $bolCambios = true;
                 }else{
                     $this->objRevisionJuridica[ "documento" ] = ( ! empty( $this->objRevisionJuridica[ "documento" ] ) ) ? $this->objRevisionJuridica[ "documento" ] : array( );
                     foreach( $this->objRevisionJuridica[ "documento" ] as $txtDocumento ){
                         if( ! in_array( $txtDocumento , $arrPost[ "documento" ] ) ){
                             $bolCambios = true;		
                         }
                     }
                 }

                 // verificando que no cambien las recomendaciones
                 $arrPost[ "recomendacion" ] = ( ! isset( $arrPost[ "recomendacion" ] ) )? array() : $arrPost[ "recomendacion" ];
                 if( count( $this->objRevisionJuridica[ "recomendacion" ] ) != count( $arrPost[ "recomendacion" ] ) ){
                     $bolCambios = true;
                 }else{
                     $this->objRevisionJuridica[ "recomendacion" ] = ( !empty( $this->objRevisionJuridica[ "recomendacion" ] ) ) ? $this->objRevisionJuridica[ "recomendacion" ] : array( );
                     foreach( $this->objRevisionJuridica[ "recomendacion" ] as $txtDocumento ){
                         if( ! in_array( $txtDocumento , $arrPost[ "recomendacion" ] ) ){
                             $bolCambios = true;		
                         }
                     }
                 }

             }

         }
//            echo "Revision Juridica<br>";
//            var_dump($bolCambios);

         /******************************************************************
          * Cambios en revision tecnica
          ******************************************************************/
         if( trim( $arrPost['txtFase'] ) == "revisionTecnica" ){

             if( empty( $this->objRevisionTecnica ) ){
                 if( trim( $arrPost['txtAprobo'] ) != "" ){
                     $bolCambios = true;
                 } else {
                     $bolCambios = false;
                 }
             } else {

                 // verificando que los datos sean iguales
                 if( intval( $this->bolRevisionTecnica ) != trim( $arrPost[ "txtConcepto" ] ) ){
                     $bolCambios = true;
                 }

                 // Verifica cambios en las variables del formulario
                 // se llaman igual en el post y en la clase
                 foreach( $arrPost as $txtClave => $txtValor ){
                     if( isset( $this->objRevisionTecnica[ $txtClave ] ) ){
                         if( trim( $this->objRevisionTecnica[ $txtClave ] ) != trim( $txtValor ) ){
                             $bolCambios = true;
                         }
                     }
                 }

                 // varifica cambios en las imagenes
                 // no esta igual en el post y en la clase
                if( count( $this->objRevisionTecnica[ "imagenes" ] ) != count( $arrPost[ "nombreArchivoCargado" ] ) ){
                     $bolCambios = true;
                 }else{

                     // monta los nombres de los archivos en un arreglo
                     $arrArchivos = array();
                     $this->objRevisionTecnica[ "imagenes" ] = ( is_array( $this->objRevisionTecnica[ "imagenes" ] ) )? $this->objRevisionTecnica[ "imagenes" ] : array();
                     foreach( $this->objRevisionTecnica[ "imagenes" ] as $arrImagen ){
                         $arrArchivos[] = $arrImagen[ "ruta" ];
                     }

                     // compara los nombres de los archivos (esta no es la etiqueta de la foto es el nombre del archivo)
                     $arrPost[ "nombreArchivoCargado" ] = ( is_array( $arrPost[ "nombreArchivoCargado" ] ) )? $arrPost[ "nombreArchivoCargado" ] : array();
                     foreach( $arrPost[ "nombreArchivoCargado" ] as $txtArchivo ){
                         if( ! in_array( $txtArchivo , $arrArchivos ) ){
                             $bolCambios = true;
                         }
                     }
                 }

                 // verifica cambios en vivienda nueva
                 if( count( $this->objRevisionTecnica[ "observacion" ] ) != count( $arrPost[ "observacion" ] ) ){
                     $bolCambios = true;
                 }else{
                     $arrPost[ "observacion" ] = ( is_array( $arrPost[ "observacion" ] ) )? $arrPost[ "observacion" ] : array();
                     foreach( $arrPost[ "observacion" ] as $txtObservacion ){
                         if( ! in_array( $txtObservacion , $this->objRevisionTecnica[ "observacion" ] ) ){
                             $bolCambios = true;
                         }
                     }
                 }
             }
         }

//            echo "Revision tecnica<br>";
//            var_dump($bolCambios);

         /******************************************************************
          * Cambios en postulacion
          ******************************************************************/

         if( trim( $arrPost['txtFase'] ) == "postulacion" ){

             // Campos que se pueden modificar sin restricciones
             $arrCamposLibres[] = "txtDireccion";
             $arrCamposLibres[] = "numTelefono1";
             $arrCamposLibres[] = "numTelefono2";
             $arrCamposLibres[] = "numCelular";
             $arrCamposLibres[] = "txtDireccionSolucion";

             // para simplificar la escritura
             $claFormulario = $this->objPostulacion;
             $claFormulario->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $claFormulario->seqBarrio );

             // Si la variable de cerrado no viene hay que colocarla en cero
             if( ! isset( $arrPost['bolCerrado'] ) ){
                 $arrPost['bolCerrado'] = 0;
             }

             // Cambios en el hogar
             $arrCedulasFormulario = array();
             foreach( $claFormulario->arrCiudadano as $objCiudadano ){
                 $numDocumento = $objCiudadano->numDocumento;
                 $arrCedulasFormulario[] = $numDocumento;
                 if( isset( $arrPost['hogar'][ $numDocumento ] ) ){
                     foreach( $objCiudadano as $txtClave => $txtValor ){
                         if( isset( $arrPost['hogar'][ $numDocumento ][ $txtClave ] ) ){
                             $txtValor = mb_ereg_replace("[^0-9]", "", $txtValor);
                             $arrPost['hogar'][ $numDocumento ][ $txtClave ] = mb_ereg_replace("[^0-9]", "", $arrPost['hogar'][ $numDocumento ][ $txtClave ] );
                             if( $txtValor != $arrPost['hogar'][ $numDocumento ][ $txtClave ] ){
                                 $arrCamposCambiados[] = $txtClave;
                                 $bolCambios = true;
                             }
                         }
                     }
                 } else {
                     $arrCamposCambiados[] = "objCiudadano";
                     $bolCambios = true;
                 }
             }

             foreach( $arrPost['hogar'] as $numDocumento => $arrMiembro ){
                 if( ! in_array( $numDocumento , $arrCedulasFormulario ) ){
                     $bolCambios = true;
                 }				
             }

             // Cambios en los datos del formulario
             unset( $claFormulario->arrCiudadano );
             foreach( $claFormulario as $txtClave => $txtValor ){
                 if( isset( $arrPost[ $txtClave ] ) ){
                     $txtValor = ( $txtValor === "0000-00-00" )? "" : $txtValor ;
                     $txtValor = ( $txtValor === null )? 0 : $txtValor ;
                     if( $txtValor != $arrPost[ $txtClave ] ){
                         if( ! in_array( $txtClave , $arrCamposLibres ) ){
                             $arrCamposCambiados[] = $txtClave;
                             $bolCambios = true;
                         }
                     }
                 }
             }

         }

         return $bolCambios;
      }
        
      public function verificacionConceptos( $arrPost ){
         global $aptBd;

         if( intval( $arrPost['seqCasaMano'] ) != 0 ){

             // Verificacion sin cruce
             if( $this->bolPrimeraVerificacion == 1 ){

                 // juridica o tecnica no viabilizan
                 if( $this->bolRevisionJuridica == 2 or $this->bolRevisionTecnica == 2 ){
                     $arrPost['txtCompraVivienda'] = "nueva";
                     $seqEstadoProceso = 37; // Hogar actualizado

                 // Juridica y tecnica viabilizan
                 }elseif( $this->bolRevisionJuridica == 1 and $this->bolRevisionTecnica == 1 ){
                     $seqEstadoProceso = 46; // Primera verificacion aprobada

                 // Alguien falta en el proceso
                 }elseif( $this->bolRevisionJuridica == 0 or $this->bolRevisionTecnica == 0 ){
                     $seqEstadoProceso = 44; // Primera verificacion
                 } else {
                     $seqEstadoProceso = 0;
                 }

             // Verificacion con cruce 
             } elseif( $this->bolPrimeraVerificacion == 2 ) {
                 $seqEstadoProceso = 45; // Primera verificacion pendiente

             // No hay primera verificacion    
             } else {
                 $seqEstadoProceso = 0;
             }

             // alterar el estado del proceso segun el resultado
             if( $seqEstadoProceso != 0 ){
                 $arrPost['seqEstadoProceso'] = $seqEstadoProceso;
                 $this->modificarEstadoProceso( $arrPost );
             }

         }else{
             $this->arrErrores[] = "No se encuentra el registro de casa en mano para hacer la verificacion de conceptos";
         }
      }
        
      /**
       * VERIFICA LOS PERMISOS DEL USUARIO PARA 
       * SABER SI PUEDE O NO INGRESAR A CADA PANTALLA
       * @param array $arrFlujoHogar // contiene flujo y fase para ver los permisos
       */
       public function puedeIngresar( $arrFlujoHogar, $claFormulario ){

         $bolPermiso  = false;                       // Determina si tiene o no permisos
         $txtFlujo    = $arrFlujoHogar['flujo'];     // Determina e flujo de casa en mano
         $txtFase     = $arrFlujoHogar['fase'];      // Determina la fase del modulo de casa en mano
         $seqProyecto = $_SESSION['seqProyecto'];    // Es el identificador del proyect (SDV=3)
         $arrEstados  = estadosProceso();            // Los estados del proceso

         $seqEstadoProceso = $claFormulario->seqEstadoProceso; // El estado actual del proceso

         if( in_array( $claFormulario->seqModalidad , $this->arrFases['cem']['modalidad'] ) ){

             // Verifica los permisos para grupos de usuarios
             foreach( $_SESSION['arrGrupos'][ $seqProyecto ] as $seqGrupo ){
                 if( in_array( $seqGrupo , $this->arrFases[ $txtFlujo ][ $txtFase ]['grupos'] ) ){
                     $bolPermiso = true;
                 }
             }

             // si pertenece a los grupos autorizados para usar el modulo
             if( $bolPermiso == true ){

                 // Verifica si el hogar tiene permisos
                 $bolPermiso = false;
                 if( in_array( $seqEstadoProceso , $this->arrFases[ $txtFlujo ][ $txtFase ]['permisos'] ) ){
                     $bolPermiso = true;
                 } else {
                     $this->arrErrores[] = "El hogar esta registrado con el estado del proceso \"" . 
                                           $arrEstados[ $seqEstadoProceso ] . 
                                           "\" que no es permitido para el uso del modulo ";
                 }
             } else {
                 $this->arrErrores[] = "No tiene los privilegios de grupo suficientes para poder usar este módulo";
             }
         } else {
             $this->arrErrores[] = "El hogar no pertenece a la modalidad de adquisición de vivienda nueva o usada";
         }

         return $bolPermiso;
         
       }
        
   }

?>
