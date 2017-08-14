<?php

	/**
	 * CLASE DONDE SE ESTABLECE EL FLUJO DE PLANTILLAS
	 * Y FASES A SEGUIR POR UN HOGAR EN LA ETAPA DE DESEMBOLSO
	 * @author Bernardo Zerda
	 * @version Junio 2013
	 */

	Class FlujoDesembolso {
		
		public $arrFlujos;			// Contra Escrituta, Giro Anticipado, Finalizacion de Obra, Ahorro Programado, Oferente
		public $arrFases;			// De acuerdo al flujo de observan una fases del desembolso
		public $arrObligatorios;	// De acuerdo al flujo y la fase se colocan los campos obligatorios
		
		function FlujoDesembolso( $seqFormulario ){
			
			$this->arrFlujos["escritura"]        = utf8_encode("Escritura Publica Registrada");
			$this->arrFlujos["giroAnticipado"]   = utf8_encode("Giro Anticpado");
            
            $this->arrFlujos["postulacionIndividual"]   = utf8_encode("Postulacion Individual");
            
            $this->arrFlujos["retornoEscritura"]        = utf8_encode("Retorno con Escritura Publica Registrada");
			$this->arrFlujos["retornoGiroAnticipado"]   = utf8_encode("Retorno con Giro Anticpado");
            
			$this->arrObligatorios = array();
			$this->arrFases = $this->obtenerFases( $seqFormulario );
			
         $this->flujosAplicables( $seqFormulario );
            
			return true;	
		}
	
		
		/**
		 * INDICA EL FLUJO DE LAS FASES LAS PLANTILLAS Y 
		 * CODIGOS QUE RESPONDEN A LAS PETICIONES
 		**/	
		 
		private function obtenerFases( $seqFormulario = 0 ){
            
			/*****************************************************************
			 * Fases del desemboslo con escritura publica registrada
 			******************************************************************/	 
			
			$arrFases['escritura']['busquedaOferta']['nombre']    = utf8_encode("Busqueda de la Oferta");
			$arrFases['escritura']['busquedaOferta']['permisos']  = array( 15 , 19 , 22 , 24 , 26 , 27 , 28 , 29 , 30 , 32 , 33 );
			$arrFases['escritura']['busquedaOferta']['adelante']  = array( 15 , 19 , 22 );
			$arrFases['escritura']['busquedaOferta']['atras']     = array( ); // No hay regreso a otras fases
			$arrFases['escritura']['busquedaOferta']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['escritura']['busquedaOferta']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['escritura']['busquedaOferta']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['escritura']['busquedaOferta']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario );";
			
			$arrFases['escritura']['revisionJuridica']['nombre'] = utf8_encode("Revision Juridica");
			$arrFases['escritura']['revisionJuridica']['permisos']  = array( 22 , 24 , 26 , 27 , 28 , 29 , 30 , 32 , 33 );
			$arrFases['escritura']['revisionJuridica']['adelante']  = array( 22 , 24 );
			$arrFases['escritura']['revisionJuridica']['atras']     = array( 15 , 19 );
			$arrFases['escritura']['revisionJuridica']['plantilla'] = "desembolso/revisionJuridica.tpl";
			$arrFases['escritura']['revisionJuridica']['codigo']    = "./contenidos/desembolso/revisionJuridica.php";
			$arrFases['escritura']['revisionJuridica']['salvar']    = "./salvarRevisionJuridica.php";
			$arrFases['escritura']['revisionJuridica']['imprimir']  = "desembolsoRevisionJuridica( $seqFormulario );";
			
			$arrFases['escritura']['revisionTecnica']['nombre'] = utf8_encode("Revision Tecnica");
			$arrFases['escritura']['revisionTecnica']['permisos']  = array( 24 , 26 , 27 , 28 , 29 , 30 , 32 , 33 );
			$arrFases['escritura']['revisionTecnica']['adelante']  = array( 24 , 26 );
			$arrFases['escritura']['revisionTecnica']['atras']     = array( 15 , 19 , 22 );
			$arrFases['escritura']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
			$arrFases['escritura']['revisionTecnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
			$arrFases['escritura']['revisionTecnica']['salvar']    = "./salvarRevisionTecnica.php";
			$arrFases['escritura']['revisionTecnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario );";
			
			$arrFases['escritura']['escrituracion']['nombre'] = utf8_encode("Escrituracion");
			$arrFases['escritura']['escrituracion']['permisos']  = array( 26 , 27 , 28 , 29 , 30 , 32 , 33 , 62 );
			$arrFases['escritura']['escrituracion']['adelante']  = array( 26 , 27 , 62 , 28 );
			$arrFases['escritura']['escrituracion']['atras']     = array( 15 , 19 , 24 );
			$arrFases['escritura']['escrituracion']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['escritura']['escrituracion']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['escritura']['escrituracion']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['escritura']['escrituracion']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario , 0 , 1 );";
			
			$arrFases['escritura']['estudioTitulos']['nombre'] = utf8_encode("Estudio de Titulos");
			$arrFases['escritura']['estudioTitulos']['permisos']  = array( 28 , 29 , 30 , 32 , 33 );
			$arrFases['escritura']['estudioTitulos']['adelante']  = array( 28 , 29 );
			$arrFases['escritura']['estudioTitulos']['atras']     = array( 15 , 19 , 27 );
			$arrFases['escritura']['estudioTitulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
			$arrFases['escritura']['estudioTitulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
			$arrFases['escritura']['estudioTitulos']['salvar']    = "./salvarEstudioTitulos.php";
			$arrFases['escritura']['estudioTitulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario );";
			
			$arrFases['escritura']['solicitudDesembolso']['nombre'] = utf8_encode("Solicitud de Desembolso");
			$arrFases['escritura']['solicitudDesembolso']['permisos']  = array( 29 , 30 , 32 , 33 );
			$arrFases['escritura']['solicitudDesembolso']['adelante']  = array( 29 , 30 , 32 , 33 );
			$arrFases['escritura']['solicitudDesembolso']['atras']     = array( 15 , 19 , 28 );
			$arrFases['escritura']['solicitudDesembolso']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['escritura']['solicitudDesembolso']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['escritura']['solicitudDesembolso']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['escritura']['solicitudDesembolso']['imprimir']  = "";
			
         $arrFases['escritura']['estadoFnial'] = 33;
         
			/*****************************************************************
			 * Fases del desemboslo con giro anticipado
 			******************************************************************/	 
            
         $arrFases['giroAnticipado']['busquedaOferta']['nombre']    = utf8_encode("Busqueda de la Oferta");
			$arrFases['giroAnticipado']['busquedaOferta']['permisos']  = array( 15,19,22,24,26,27,28,29,30,32,33,40 );
			$arrFases['giroAnticipado']['busquedaOferta']['adelante']  = array( 15,19,22 );
			$arrFases['giroAnticipado']['busquedaOferta']['atras']     = array( ); // No hay regreso a otras fases
			$arrFases['giroAnticipado']['busquedaOferta']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['giroAnticipado']['busquedaOferta']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['giroAnticipado']['busquedaOferta']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['giroAnticipado']['busquedaOferta']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario );";
            
         $arrFases['giroAnticipado']['revisionJuridica']['nombre'] = utf8_encode("Revision Juridica");
			$arrFases['giroAnticipado']['revisionJuridica']['permisos']  = array( 22,24,26,27,28,29,30,32,33,40 );
			$arrFases['giroAnticipado']['revisionJuridica']['adelante']  = array( 22,24 );
			$arrFases['giroAnticipado']['revisionJuridica']['atras']     = array( 15,19 );
			$arrFases['giroAnticipado']['revisionJuridica']['plantilla'] = "desembolso/revisionJuridica.tpl";
			$arrFases['giroAnticipado']['revisionJuridica']['codigo']    = "./contenidos/desembolso/revisionJuridica.php";
			$arrFases['giroAnticipado']['revisionJuridica']['salvar']    = "./salvarRevisionJuridica.php";
			$arrFases['giroAnticipado']['revisionJuridica']['imprimir']  = "desembolsoRevisionJuridica( $seqFormulario );";
            
         $arrFases['giroAnticipado']['solicitudDesembolso']['nombre'] = utf8_encode("Solicitud de Desembolso");
			$arrFases['giroAnticipado']['solicitudDesembolso']['permisos']  = array( 24,26,27,28,29,30,32,33,40 );
			$arrFases['giroAnticipado']['solicitudDesembolso']['adelante']  = array( 24,30,32,33 );
			$arrFases['giroAnticipado']['solicitudDesembolso']['atras']     = array( 15,19,22 );
			$arrFases['giroAnticipado']['solicitudDesembolso']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['giroAnticipado']['solicitudDesembolso']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['giroAnticipado']['solicitudDesembolso']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['giroAnticipado']['solicitudDesembolso']['imprimir']  = "";
            
         $arrFases['giroAnticipado']['escrituracion']['nombre'] = utf8_encode("Escrituracion");
			$arrFases['giroAnticipado']['escrituracion']['permisos']  = array( 26,27,28,29,32,33,40 );
			$arrFases['giroAnticipado']['escrituracion']['adelante']  = array( 32,33,27 );
			$arrFases['giroAnticipado']['escrituracion']['atras']     = array( 15,19,30 );
			$arrFases['giroAnticipado']['escrituracion']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['giroAnticipado']['escrituracion']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['giroAnticipado']['escrituracion']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['giroAnticipado']['escrituracion']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario , 0 , 1 );";
            
         $arrFases['giroAnticipado']['revisionTecnica']['nombre'] = utf8_encode("Revision Tecnica");
			$arrFases['giroAnticipado']['revisionTecnica']['permisos']  = array( 26,27,28,29,40 );
			$arrFases['giroAnticipado']['revisionTecnica']['adelante']  = array( 27,26 );
			$arrFases['giroAnticipado']['revisionTecnica']['atras']     = array( 15,19,32,33 );
			$arrFases['giroAnticipado']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
			$arrFases['giroAnticipado']['revisionTecnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
			$arrFases['giroAnticipado']['revisionTecnica']['salvar']    = "./salvarRevisionTecnica.php";
			$arrFases['giroAnticipado']['revisionTecnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario );";
            
         $arrFases['giroAnticipado']['estudioTitulos']['nombre'] = utf8_encode("Estudio de Titulos");
			$arrFases['giroAnticipado']['estudioTitulos']['permisos']  = array( 26,28,29,40 );
			$arrFases['giroAnticipado']['estudioTitulos']['adelante']  = array( 26,28,29 );
			$arrFases['giroAnticipado']['estudioTitulos']['atras']     = array( 15,19,27 );
			$arrFases['giroAnticipado']['estudioTitulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
			$arrFases['giroAnticipado']['estudioTitulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
			$arrFases['giroAnticipado']['estudioTitulos']['salvar']    = "./salvarEstudioTitulos.php";
			$arrFases['giroAnticipado']['estudioTitulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario );";
            
         $arrFases['giroAnticipado']['legalizacion']['nombre'] = utf8_encode("Legalizacion Desembolso");
			$arrFases['giroAnticipado']['legalizacion']['permisos']  = array( 29,40 );
			$arrFases['giroAnticipado']['legalizacion']['adelante']  = array( 29,40 );
			$arrFases['giroAnticipado']['legalizacion']['atras']     = array( 15,19,28 );
			$arrFases['giroAnticipado']['legalizacion']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['giroAnticipado']['legalizacion']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['giroAnticipado']['legalizacion']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['giroAnticipado']['legalizacion']['imprimir']  = "";
			
         $arrFases['giroAnticipado']['estadoFnial'] = 40;
         
         /*****************************************************************
			 * Fases del desemboslo para esquema de retorno
          * con escritura publica registrada para hogares desplazados
 			******************************************************************/	 
			
			$arrFases['retornoEscritura']['busquedaOferta']['nombre']    = utf8_encode("Busqueda de la Oferta");
			$arrFases['retornoEscritura']['busquedaOferta']['permisos']  = array( 15 , 19 , 22 , 24 , 26 , 27 , 28 , 29 , 30 , 32 , 33 );
			$arrFases['retornoEscritura']['busquedaOferta']['adelante']  = array( 15 , 19 , 22 , 24 );
			$arrFases['retornoEscritura']['busquedaOferta']['atras']     = array( ); // No hay regreso a otras fases
			$arrFases['retornoEscritura']['busquedaOferta']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['retornoEscritura']['busquedaOferta']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['retornoEscritura']['busquedaOferta']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['retornoEscritura']['busquedaOferta']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario );";
			
			$arrFases['retornoEscritura']['revisionTecnica']['nombre'] = utf8_encode("Revision Tecnica");
			$arrFases['retornoEscritura']['revisionTecnica']['permisos']  = array( 22 , 24, 26 , 27 , 28 , 29 , 30 , 32 , 33 ); // se adiciona 24
			$arrFases['retornoEscritura']['revisionTecnica']['adelante']  = array( 22 , 26, 24 , 27  ); // Se adiciona 24 y 27
			$arrFases['retornoEscritura']['revisionTecnica']['atras']     = array( 15 , 19 );
			$arrFases['retornoEscritura']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
			$arrFases['retornoEscritura']['revisionTecnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
			$arrFases['retornoEscritura']['revisionTecnica']['salvar']    = "./salvarRevisionTecnica.php";
			$arrFases['retornoEscritura']['revisionTecnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario );";
			
			$arrFases['retornoEscritura']['escrituracion']['nombre'] = utf8_encode("Escrituracion");
			$arrFases['retornoEscritura']['escrituracion']['permisos']  = array( 26 , 27 , 28 , 29 , 30 , 32 , 33 );
			$arrFases['retornoEscritura']['escrituracion']['adelante']  = array( 26 , 27 , 28 );
			$arrFases['retornoEscritura']['escrituracion']['atras']     = array( 15 , 19 , 22 );
			$arrFases['retornoEscritura']['escrituracion']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['retornoEscritura']['escrituracion']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['retornoEscritura']['escrituracion']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['retornoEscritura']['escrituracion']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario , 0 , 1 );";
			
			$arrFases['retornoEscritura']['estudioTitulos']['nombre'] = utf8_encode("Estudio de Titulos");
			$arrFases['retornoEscritura']['estudioTitulos']['permisos']  = array( 28 , 29 , 30 , 32 , 33 );
			$arrFases['retornoEscritura']['estudioTitulos']['adelante']  = array( 28 , 29 );
			$arrFases['retornoEscritura']['estudioTitulos']['atras']     = array( 15 , 19 , 26 );
			$arrFases['retornoEscritura']['estudioTitulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
			$arrFases['retornoEscritura']['estudioTitulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
			$arrFases['retornoEscritura']['estudioTitulos']['salvar']    = "./salvarEstudioTitulos.php";
			$arrFases['retornoEscritura']['estudioTitulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario );";
			
			$arrFases['retornoEscritura']['solicitudDesembolso']['nombre'] = utf8_encode("Solicitud de Desembolso");
			$arrFases['retornoEscritura']['solicitudDesembolso']['permisos']  = array( 29 , 30 , 32 , 33 );
			$arrFases['retornoEscritura']['solicitudDesembolso']['adelante']  = array( 29 , 30 , 32 , 33 );
			$arrFases['retornoEscritura']['solicitudDesembolso']['atras']     = array( 15 , 19 , 28 );
			$arrFases['retornoEscritura']['solicitudDesembolso']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['retornoEscritura']['solicitudDesembolso']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['retornoEscritura']['solicitudDesembolso']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['retornoEscritura']['solicitudDesembolso']['imprimir']  = "";
            
         $arrFases['retornoEscritura']['estadoFnial'] = 33;
         
         /*****************************************************************
			 * Fases del desemboslo para el esquema de retorno
          * con giro anticipado para hogares desplazados
 			******************************************************************/	 
            
         $arrFases['retornoGiroAnticipado']['busquedaOferta']['nombre']    = utf8_encode("Busqueda de la Oferta");
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['permisos']  = array( 15,19,22,26,27,28,29,30,32,33,40 );
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['adelante']  = array( 15,19,30 );
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['atras']     = array( ); // No hay regreso a otras fases
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['retornoGiroAnticipado']['busquedaOferta']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario );";
            
         $arrFases['retornoGiroAnticipado']['solicitudDesembolso']['nombre'] = utf8_encode("Solicitud de Desembolso");
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['permisos']  = array( 26,27,28,29,30,32,33,40 );
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['adelante']  = array( 30,32,33 );
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['atras']     = array( 15,19 );
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['retornoGiroAnticipado']['solicitudDesembolso']['imprimir']  = "";

         $arrFases['retornoGiroAnticipado']['escrituracion']['nombre'] = utf8_encode("Escrituracion");
			$arrFases['retornoGiroAnticipado']['escrituracion']['permisos']  = array( 26,27,28,29,32,33,40 );
			$arrFases['retornoGiroAnticipado']['escrituracion']['adelante']  = array( 32,33,27 );
			$arrFases['retornoGiroAnticipado']['escrituracion']['atras']     = array( 15,19,30 );
			$arrFases['retornoGiroAnticipado']['escrituracion']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['retornoGiroAnticipado']['escrituracion']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['retornoGiroAnticipado']['escrituracion']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['retornoGiroAnticipado']['escrituracion']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario , 0 , 1 );";
            
         $arrFases['retornoGiroAnticipado']['revisionTecnica']['nombre'] = utf8_encode("Revision Tecnica");
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['permisos']  = array( 26,27,28,29,40 );
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['adelante']  = array( 27,26 );
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['atras']     = array( 15,19,32,33 );
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['salvar']    = "./salvarRevisionTecnica.php";
			$arrFases['retornoGiroAnticipado']['revisionTecnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario );";
            
         $arrFases['retornoGiroAnticipado']['estudioTitulos']['nombre'] = utf8_encode("Estudio de Titulos");
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['permisos']  = array( 26,28,29,40 );
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['adelante']  = array( 26,28,29 );
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['atras']     = array( 15,19,27 );
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['salvar']    = "./salvarEstudioTitulos.php";
			$arrFases['retornoGiroAnticipado']['estudioTitulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario );";
            
         $arrFases['retornoGiroAnticipado']['legalizacion']['nombre'] = utf8_encode("Legalizacion Desembolso");
			$arrFases['retornoGiroAnticipado']['legalizacion']['permisos']  = array( 29,40 );
			$arrFases['retornoGiroAnticipado']['legalizacion']['adelante']  = array( 29,40 );
			$arrFases['retornoGiroAnticipado']['legalizacion']['atras']     = array( 15,19,28 );
			$arrFases['retornoGiroAnticipado']['legalizacion']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['retornoGiroAnticipado']['legalizacion']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['retornoGiroAnticipado']['legalizacion']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['retornoGiroAnticipado']['legalizacion']['imprimir']  = "";
         
         $arrFases['retornoGiroAnticipado']['estadoFnial'] = 40;
         
			/*****************************************************************
			 * Fases del desemboslo de postulacion individual
 			******************************************************************/	 
            
         $arrFases['postulacionIndividual']['escrituracion']['nombre'] = utf8_encode("Escrituracion");
			$arrFases['postulacionIndividual']['escrituracion']['permisos']  = array( 15,17,19,23,26,27,28,29,40 );
			$arrFases['postulacionIndividual']['escrituracion']['adelante']  = array( 15,17,19,23,27 );
			$arrFases['postulacionIndividual']['escrituracion']['atras']     = array( );
			$arrFases['postulacionIndividual']['escrituracion']['plantilla'] = "desembolso/busquedaOferta.tpl";
			$arrFases['postulacionIndividual']['escrituracion']['codigo']    = "./contenidos/desembolso/busquedaOferta.php";
			$arrFases['postulacionIndividual']['escrituracion']['salvar']    = "./salvarBusquedaOferta.php";
			$arrFases['postulacionIndividual']['escrituracion']['imprimir']  = "desembolsoBusquedaOferta( $seqFormulario , 0 , 1 );";
            
         $arrFases['postulacionIndividual']['revisionTecnica']['nombre'] = utf8_encode("Revision Tecnica");
			$arrFases['postulacionIndividual']['revisionTecnica']['permisos']  = array( 23,25,26,27,28,29,40 );
			$arrFases['postulacionIndividual']['revisionTecnica']['adelante']  = array( 23,27,25,26 );
			$arrFases['postulacionIndividual']['revisionTecnica']['atras']     = array( 15 );
			$arrFases['postulacionIndividual']['revisionTecnica']['plantilla'] = "desembolso/revisionTecnica.tpl";
			$arrFases['postulacionIndividual']['revisionTecnica']['codigo']    = "./contenidos/desembolso/revisionTecnica.php";
			$arrFases['postulacionIndividual']['revisionTecnica']['salvar']    = "./salvarRevisionTecnica.php";
			$arrFases['postulacionIndividual']['revisionTecnica']['imprimir']  = "desembolsoRevisionTecnica( $seqFormulario );";
            
         $arrFases['postulacionIndividual']['estudioTitulos']['nombre'] = utf8_encode("Estudio de Titulos");
			$arrFases['postulacionIndividual']['estudioTitulos']['permisos']  = array( 26,28,29,31,40 );
			$arrFases['postulacionIndividual']['estudioTitulos']['adelante']  = array( 26,28,31,29 );
			$arrFases['postulacionIndividual']['estudioTitulos']['atras']     = array( 15,27 );
			$arrFases['postulacionIndividual']['estudioTitulos']['plantilla'] = "desembolso/estudioTitulos.tpl";
			$arrFases['postulacionIndividual']['estudioTitulos']['codigo']    = "./contenidos/desembolso/estudioTitulos.php";
			$arrFases['postulacionIndividual']['estudioTitulos']['salvar']    = "./salvarEstudioTitulos.php";
			$arrFases['postulacionIndividual']['estudioTitulos']['imprimir']  = "desembolsoEstudioTitulos( $seqFormulario );";
            
         $arrFases['postulacionIndividual']['legalizacion']['nombre'] = utf8_encode("Legalizacion Desembolso");
			$arrFases['postulacionIndividual']['legalizacion']['permisos']  = array( 29,62,40 );
			$arrFases['postulacionIndividual']['legalizacion']['adelante']  = array( 29,62,40 );
			$arrFases['postulacionIndividual']['legalizacion']['atras']     = array( 15,28 );
			$arrFases['postulacionIndividual']['legalizacion']['plantilla'] = "desembolso/solicitudDesembolso.tpl";
			$arrFases['postulacionIndividual']['legalizacion']['codigo']    = "./contenidos/desembolso/solicitudDesembolso.php";
			$arrFases['postulacionIndividual']['legalizacion']['salvar']    = "./salvarSolicitudDesembolsos.php";
			$arrFases['postulacionIndividual']['legalizacion']['imprimir']  = "";
			
         $arrFases['postulacionIndividual']['estadoFnial'] = 40;         
         
			return $arrFases;
		}
		
		/**
		 * DETERMINA CUAL FLUJO APLICA Y EN QUE ESTADO DE LA 
		 * ETAPA DEL DESEMBOLSO ESTA
		 * @param Integer $seqEstadoProceso
		 */
		public function obtenerFlujo( $seqFormulario , $seqEstadoProceso , $txtFlujo = "" ){
			global $aptBd;
			
         // Obtiene la informacion del formulario
			$claFormulario = new FormularioSubsidios;
			$claFormulario->cargarFormulario( $seqFormulario );
            
			// Flujo de datos que aplica por defecto
			$arrFlujoHogar['flujo'] = "escritura";
			$arrFlujoHogar['fase']  = "";
			
         // En la base de datos se guarda el flujo de datos seleccionado
         $sql = "
             SELECT txtFlujo		
             FROM T_DES_FLUJO
             WHERE seqFormulario = $seqFormulario 	
         ";
         $objRes = $aptBd->execute( $sql );
         if( $objRes->fields ){
             if( $objRes->fields['txtFlujo'] == "cem" ){
                 $objRes->fields['txtFlujo'] = "escritura";
             }
             $arrFlujoHogar['flujo'] = $objRes->fields['txtFlujo'];
         }

         //echo $arrFlujoHogar['flujo'] . " ==> " . $txtFlujo . "<br>";
         if( $txtFlujo != "" and $arrFlujoHogar['flujo'] != $txtFlujo ){
             $arrFlujoHogar['flujo'] = $txtFlujo;
         }
            
			// Segun el estado determina la fase en la que esta
			$txtFlujo = $arrFlujoHogar['flujo'];
			foreach ($this->arrFases[ $txtFlujo ] as $txtFase => $arrFases ){
				if( is_array( $arrFases['permisos'] ) ){
					if( in_array( $seqEstadoProceso , $arrFases['permisos'] ) ){
						$arrFlujoHogar['fase']  = $txtFase;
					}
				}
			}
			
			return $arrFlujoHogar;
		}
	
		/**
		 * DETERMINA EL CODIGO Y LA PLANTILLA QUE RESPONDE
		 * AL SALVAR ALGUN FORMULARIO DE DESEMBOLSO
		 * @param varchar txtFlujo
		 * @param integer seqEstadoProceso
		 */
		public function obtenerCodigo( $txtFlujo , $seqEstadoProceso , $txtFasePlantilla = "" ){
			
			$arrCodigo['flujo']     = $txtFlujo;
			$arrCodigo['codigo']    = "";
			$arrCodigo['plantilla'] = "";
			$arrCodigo['imprimir']  = "";
			$arrCodigo['salvar']    = "";
			$arrCodigo['final']     = "";
            
			foreach( $this->arrFases[ $txtFlujo ]  as $txtFase => $arrFase ){
				if( is_array( $arrFase['permisos'] ) ){
					if( in_array( $seqEstadoProceso , $arrFase['permisos'] ) ){
						$arrCodigo['fase']      = $txtFase;
						$arrCodigo['codigo']    = $arrFase['codigo'];
						$arrCodigo['plantilla'] = $arrFase['plantilla'];
						$arrCodigo['imprimir']  = $arrFase['imprimir'];
						$arrCodigo['salvar']    = $arrFase['salvar'];
						$arrCodigo['salvar']    = $arrFase['salvar'];
					}
				}
			}
			
         if( $txtFasePlantilla != $arrCodigo['fase'] ){
             $arrCodigo['fase']      = $txtFasePlantilla;
             $arrCodigo['codigo']    = $this->arrFases[ $txtFlujo ][ $txtFasePlantilla ]['codigo'];
             $arrCodigo['plantilla'] = $this->arrFases[ $txtFlujo ][ $txtFasePlantilla ]['plantilla'];
             $arrCodigo['imprimir']  = $this->arrFases[ $txtFlujo ][ $txtFasePlantilla ]['imprimir'];
             $arrCodigo['salvar']    = $this->arrFases[ $txtFlujo ][ $txtFasePlantilla ]['salvar'];
         }
         
         $arrCodigo['final'] = $this->arrFases[ $txtFlujo ]['estadoFnial'];
         
			return $arrCodigo;
			
		}
		
		
		/**
		 * ASIGNA EL FLUJO DE DATOS EN CASO DE NO TENERLO
		 */
		public function asignarFlujo( $seqFormulario , $txtFlujo ){
			global $aptBd;
			$seqFlujo = 0;
			$sql = "
				SELECT seqFlujo
				FROM T_DES_FLUJO
				WHERE seqFormulario = $seqFormulario
			";
			try{
	 			$objRes = $aptBd->execute( $sql );
	 			if( $objRes->fields ){
	 				$sql = "
		 				UPDATE T_DES_FLUJO SET
							seqFormulario = $seqFormulario,
							txtFlujo = '$txtFlujo'
						WHERE seqFlujo = " . $objRes->fields['seqFlujo'] ."
					";
	 				try{ 
			 			$aptBd->execute( $sql );
			 		} catch ( Exception $objError ){
			 			$seqFlujo = 0;
			 		}
	 			} else {
	 				$sql = "
		 				INSERT INTO T_DES_FLUJO (
							seqFormulario,
							txtFlujo
						) VALUES (
							$seqFormulario,
							'$txtFlujo'
						)
	 				";
	 				try{ 
			 			$aptBd->execute( $sql );
			 			$seqFlujo = $aptBd->Insert_ID();
			 		} catch ( Exception $objError ){
			 			$seqFlujo = 0;
			 		}
	 			}
	 		} catch ( Exception $objError ){
	 			$seqFlujo = 0;
	 		}
			return $seqFlujo;
		}
	
        /**
         * FILTRA LAS FASES APLICABLES AL HOGAR
         * SI ES DESPLAZADO APLICAN LOS FLUJOS DE RETORNO
         */
        private function flujosAplicables( $seqFormulario ){
            
            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario( $seqFormulario );
            
            if( $claFormulario->bolDesplazado != 1 ){
                unset( $this->arrFlujos['retornoEscritura'] );
                unset( $this->arrFlujos['retornoGiroAnticipado'] );
            }
            
        }
        
        
    }


?>