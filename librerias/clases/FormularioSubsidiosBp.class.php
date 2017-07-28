<?php

	/**
	 * CLASE QUE MANEJA LOS FORMULARIOS DE INSCRIPCION Y 
	 * POSTULACION
	 * @author Bernardo Zerda
	 * @version 1.0 Mayo 2009
	 */


	class FormularioSubsidios {
		
		// Variables para el ciudadano
		public $arrCiudadano;
        
        // Variables del formulario
		public $txtDireccion;
		public $numTelefono1;
		public $numTelefono2;
		public $numCelular;
		public $txtBarrio;
		public $txtCorreo;
		public $txtMatriculaInmobiliaria;
		public $txtChip;
		public $bolViabilizada;
		public $bolIdentificada;
		public $bolDesplazado;
		public $seqSolucion;
		public $valPresupuesto;
		public $valAvaluo;
		public $valTotal;
		public $seqModalidad;
		public $seqBancoCuentaAhorro;
		public $fchAperturaCuentaAhorro;
		public $bolInmovilizadoCuentaAhorro;
		public $valSaldoCuentaAhorro;
		public $txtSoporteCuentaAhorro;
		public $seqBancoCuentaAhorro2;
		public $fchAperturaCuentaAhorro2;
		public $bolInmovilizadoCuentaAhorro2;
		public $valSaldoCuentaAhorro2;
		public $txtSoporteCuentaAhorro2;
		public $valSubsidioNacional;
		public $txtSoporteSubsidio;
		public $valAporteLote;
		public $txtSoporteAporteLote;
		public $seqCesantias;
		public $valSaldoCesantias;
		public $txtSoporteCesantias;
		public $valAporteAvanceObra;
		public $txtSoporteAvanceObra;
		public $valAporteMateriales;
		public $txtSoporteAporteMateriales;
		public $seqEmpresaDonante;
		public $valDonacion;
		public $txtSoporteDonacion;
		public $seqBancoCredito;
		public $valCredito;
		public $txtSoporteCredito;
		public $valTotalRecursos;
		public $valAspiraSubsidio;
		public $seqVivienda;
		public $valArriendo;
		public $bolPromesaFirmada;
		public $fchInscripcion;
		public $fchPostulacion;
		public $fchVencimiento;
		public $bolIntegracionSocial;
		public $bolSecSalud;
		public $bolSecEducacion;
		public $bolIpes;
		public $txtOtro;
		public $seqSisben;
		public $numAdultosNucleo;
		public $numNinosNucleo;
		public $seqUsuario;
		public $seqPuntoAtencion;
		public $bolCerrado;
		public $seqLocalidad;
		public $valIngresoHogar;
		public $seqEstadoProceso;   
		public $txtDireccionSolucion;
		public $fchAprobacionCredito;
		public $txtFormulario;
		public $fchUltimaActualizacion;
		public $seqProyecto;
		public $numCortes;
		public $seqPeriodo;
		public $fchArriendoDesde;
		public $bolSancion;
		public $fchVigencia;
		public $arrErrores;    
        public $seqBarrio;
        public $seqUpz;
		
	    public function FormularioSubsidios() {
			
			$this->arrCiudadano = array();
			
			$this->txtDireccion= "";
			$this->numTelefono1= "";
			$this->numTelefono2= "";
			$this->numCelular= "";
			$this->txtBarrio= "";
			$this->txtCorreo= "";
			$this->txtMatriculaInmobiliaria= "";
			$this->txtChip= "";
			$this->bolViabilizada= "";
			$this->bolIdentificada= "";
			$this->bolDesplazado= "";
			$this->seqSolucion= "";
			$this->valPresupuesto= "";
			$this->valAvaluo= "";
			$this->valTotal= "";
			$this->seqModalidad= "";
			$this->seqBancoCuentaAhorro= "";
			$this->fchAperturaCuentaAhorro= "";
			$this->bolInmovilizadoCuentaAhorro= "";
			$this->valSaldoCuentaAhorro= "";
			$this->txtSoporteCuentaAhorro= "";
			$this->seqBancoCuentaAhorro2= "";
			$this->fchAperturaCuentaAhorro2= "";
			$this->bolInmovilizadoCuentaAhorro2= "";
			$this->valSaldoCuentaAhorro2= "";
			$this->txtSoporteCuentaAhorro2= "";
			$this->valSubsidioNacional= "";
			$this->txtSoporteSubsidio= "";
			$this->valAporteLote= "";
			$this->txtSoporteAporteLote= "";
			$this->seqCesantias= "";
			$this->valSaldoCesantias= "";
			$this->txtSoporteCesantias= "";
			$this->valAporteAvanceObra= "";
			$this->txtSoporteAvanceObra= "";
			$this->valAporteMateriales= "";
			$this->txtSoporteAporteMateriales= "";
			$this->seqEmpresaDonante= 0;
			$this->valDonacion= "";
			$this->txtSoporteDonacion= "";
			$this->seqBancoCredito= "";
			$this->valCredito= "";
			$this->txtSoporteCredito= "";
			$this->valTotalRecursos= "";
			$this->valAspiraSubsidio= "";
			$this->seqVivienda= "";
			$this->valArriendo= "";
			$this->bolPromesaFirmada= "";
			$this->fchInscripcion= "";
			$this->fchPostulacion= "";
			$this->fchVencimiento= "";
			$this->bolIntegracionSocial= "";
			$this->bolSecSalud= "";
			$this->bolSecEducacion= "";
			$this->bolIpes= "";
			$this->txtOtro= "";
			$this->seqSisben= "";
			$this->numAdultosNucleo= "";
			$this->numNinosNucleo= "";
			$this->seqUsuario= 0;
			$this->seqPuntoAtencion = 0;
			$this->bolCerrado= "";
			$this->seqLocalidad= "";
			$this->valIngresoHogar= "";
			$this->seqEstadoProceso= ""; 	
			$this->txtDireccionSolucion = "";
			$this->fchAprobacionCredito = "";
			$this->txtFormulario = "";
			$this->fchUltimaActualizacion = "";
			$this->seqProyecto = null;
			$this->numCortes = 0;
			$this->seqPeriodo = 0;
			$this->fchArriendoDesde = "";
			$this->bolSancion = 0;
			$this->fchVigencia = "";
            $this->seqUpz = "";
			$this->seqBarrio = "";
			$this->arrErrores = array();
			
	    	
	    } // Fin Constructor
	    
	    
	    public function guardarFormulario(){
	    	
	    	global $aptBd;

	    	$seqFormulario = 0;
	    		    	
	    	// Salva el formulario
	    	
	    	if( empty( $arrErrores ) ){
	    		
	    		$sql = "
					INSERT INTO T_FRM_FORMULARIO (
					  txtDireccion,
					  numTelefono1,
					  numTelefono2,
					  numCelular,
					  txtBarrio,
					  txtCorreo,
					  txtMatriculaInmobiliaria,
					  txtChip,
					  bolViabilizada,
					  bolIdentificada,
					  bolDesplazado,
					  seqSolucion,
					  valPresupuesto,
					  valAvaluo,
					  valTotal,
					  seqModalidad,
					  seqBancoCuentaAhorro,
					  fchAperturaCuentaAhorro,
					  bolInmovilizadoCuentaAhorro,
					  valSaldoCuentaAhorro,
					  txtSoporteCuentaAhorro,
					  seqBancoCuentaAhorro2,
					  fchAperturaCuentaAhorro2,
					  bolInmovilizadoCuentaAhorro2,
					  valSaldoCuentaAhorro2,
					  txtSoporteCuentaAhorro2,
					  valSubsidioNacional,
					  txtSoporteSubsidio,
					  valAporteLote,
					  txtSoporteAporteLote,
					  seqCesantias,
					  valSaldoCesantias,
					  txtSoporteCesantias,
					  valAporteAvanceObra,
					  txtSoporteAvanceObra,
					  valAporteMateriales,
					  txtSoporteAporteMateriales,
					  seqEmpresaDonante,
					  valDonacion,
					  txtSoporteDonacion,
					  seqBancoCredito,
					  valCredito,
					  txtSoporteCredito,
					  valTotalRecursos,
					  valAspiraSubsidio,
					  seqVivienda,
					  valArriendo,
					  bolPromesaFirmada,
					  fchInscripcion,
					  fchPostulacion,
					  fchVencimiento,
					  bolIntegracionSocial,
					  bolSecSalud,
					  bolSecEducacion,
					  bolIpes,
					  txtOtro,
					  seqSisben,
					  numAdultosNucleo,
					  numNinosNucleo,
					  seqUsuario,
					  bolCerrado,
					  seqLocalidad,
					  valIngresoHogar,
					  seqEstadoProceso,
					  txtDireccionSolucion,
					  seqPuntoAtencion,
					  fchAprobacionCredito,
					  txtFormulario,
					  fchUltimaActualizacion,
					  seqProyecto,
					  txtSoporteSubsidioNacional,
					  fchArriendoDesde,
					  txtComprobanteArriendo,
                      seqBarrio,
					  seqUpz
					) VALUES (
					  \"".$this->txtDireccion."\",
					  ".$this->numTelefono1.",
					  ".$this->numTelefono2.",
					  ".$this->numCelular.",
					  \"".$this->txtBarrio."\",
					  \"".$this->txtCorreo."\",
					  \"". strtoupper( $this->txtMatriculaInmobiliaria )."\",
					  \"". strtoupper( $this->txtChip )."\",
					  ".$this->bolViabilizada.",
					  ".$this->bolIdentificada.",
					  ".$this->bolDesplazado.",
					  ".$this->seqSolucion.",
					  ".$this->valPresupuesto.",
					  ".$this->valAvaluo.",
					  ".$this->valTotal.",
					  ".$this->seqModalidad.",
					  ".$this->seqBancoCuentaAhorro.",
					  \"".$this->fchAperturaCuentaAhorro."\",
					  ".$this->bolInmovilizadoCuentaAhorro.",
					  ".$this->valSaldoCuentaAhorro.",
					  \"".$this->txtSoporteCuentaAhorro."\",				
					  ".$this->seqBancoCuentaAhorro2.",
					  \"".$this->fchAperturaCuentaAhorro2."\",
					  ".$this->bolInmovilizadoCuentaAhorro2.",
					  ".$this->valSaldoCuentaAhorro2.",
					  \"".$this->txtSoporteCuentaAhorro2."\",
					  ".$this->valSubsidioNacional.",
					  \"".$this->txtSoporteSubsidio."\",
					  ".$this->valAporteLote.",
					  \"".$this->txtSoporteAporteLote."\",
					  ".$this->seqCesantias.",
					  ".$this->valSaldoCesantias.",
					  \"".$this->txtSoporteCesantias."\",
					  ".$this->valAporteAvanceObra.",
					  \"".$this->txtSoporteAvanceObra."\",
					  ".$this->valAporteMateriales.",
					  \"".$this->txtSoporteAporteMateriales."\",
					  \"".$this->seqEmpresaDonante."\",
					  ".$this->valDonacion.",
					  \"".$this->txtSoporteDonacion."\",
					  ".$this->seqBancoCredito.",
					  ".$this->valCredito.",
					  \"".$this->txtSoporteCredito."\",
					  ".$this->valTotalRecursos.",
					  ".$this->valAspiraSubsidio.",
					  ".$this->seqVivienda.",
					  ".$this->valArriendo.",
					  ".$this->bolPromesaFirmada.",
					  \"".$this->fchInscripcion."\",
					  \"".$this->fchPostulacion."\",
					  \"".$this->fchVencimiento."\",
					  ".$this->bolIntegracionSocial.",
					  ".$this->bolSecSalud.",
					  ".$this->bolSecEducacion.",
					  ".$this->bolIpes.",
					  \"".$this->txtOtro."\",
					  ".$this->seqSisben.",
					  ".$this->numAdultosNucleo.",
					  ".$this->numNinosNucleo.",
					  ".$this->seqUsuario.",
					  ".$this->bolCerrado.",
					  ".$this->seqLocalidad.",
					  ".$this->valIngresoHogar.",
					  ".$this->seqEstadoProceso.",
					 \"".$this->txtDireccionSolucion."\",
					  ".$this->seqPuntoAtencion.",
					  \"" . $this->fchAprobacionCredito . "\",
					  \"" . $this->txtFormulario  . "\",
				      \"".$this->fchUltimaActualizacion."\",
					  ".$this->seqProyecto.",
					  \"" . $this->txtSoporteSubsidioNacional . "\",
					  \"" . $this->fchArriendoDesde . "\",
					  \"" . $this->txtComprobanteArriendo . "\",
                      \"" . $this->seqBarrio . "\",
                      \"" . $this->seqUpz . "\"
					)		
	    		";
		    	try {
		    		$aptBd->execute( $sql );
		    		$seqFormulario = $aptBd->Insert_ID();
		    	} catch ( Exception $objError ) {
		    		$this->arrErrores[] = "No se pudo salvar el registro del formulario, reporte este error al administrador";
		    	}
		    	
				return $seqFormulario;
	    	}
	    	
	    } // guardarFormulario
	    
	    
	    public function cargarFormulario( $seqFormulario ){
	    	
	    	global $aptBd;
	    	
	    	$this->arrCiudadano = array();
	    	
			// Obtiene los ciudadanos suscritos al formulario ( Hogar )
			$sql = "
				SELECT 
					seqCiudadano,
					bolSoporteDocumento,
					seqParentesco
				FROM 
					T_FRM_HOGAR
				WHERE 
					seqFormulario = $seqFormulario
				ORDER BY 
					seqParentesco	
			";
			$objRes = $aptBd->execute( $sql );
			while( $objRes->fields ){
				
				$claCiudadano = new Ciudadano;
				$claCiudadano->cargarCiudadano( $objRes->fields['seqCiudadano'] );
				
				$claCiudadano->bolSoporteDocumento = $objRes->fields['bolSoporteDocumento'];
				$claCiudadano->seqParentesco = $objRes->fields['seqParentesco'];
				
				$this->arrCiudadano[ $objRes->fields['seqCiudadano'] ] = $claCiudadano;
				
				$objRes->MoveNext();
			}
			
			// Obtiene los datos del formulario
			if( ! empty( $this->arrCiudadano ) ){
				
				$sql = "
					SELECT txtDireccion,
					       numTelefono1,
					       numTelefono2,
					       numCelular,
					       txtBarrio,
					       txtCorreo,
					       txtMatriculaInmobiliaria,
					       txtChip,
					       bolViabilizada,
					       bolIdentificada,
					       bolDesplazado,
					       seqSolucion,
					       valPresupuesto,
					       valAvaluo,
					       valTotal,
					       seqModalidad,
					       seqBancoCuentaAhorro,
					       fchAperturaCuentaAhorro,
					       bolInmovilizadoCuentaAhorro,
					       valSaldoCuentaAhorro,
					       txtSoporteCuentaAhorro,
					       seqBancoCuentaAhorro2,
					       fchAperturaCuentaAhorro2,
					       bolInmovilizadoCuentaAhorro2,
					       valSaldoCuentaAhorro2,
					       txtSoporteCuentaAhorro2,
					       valSubsidioNacional,
					       txtSoporteSubsidio,
					       valAporteLote,
					       txtSoporteAporteLote,
					       seqCesantias,
					       valSaldoCesantias,
					       txtSoporteCesantias,
					       valAporteAvanceObra,
					       txtSoporteAvanceObra,
					       valAporteMateriales,
					       txtSoporteAporteMateriales,
					       seqEmpresaDonante,
					       valDonacion,
					       txtSoporteDonacion,
					       seqBancoCredito,
					       valCredito,
					       txtSoporteCredito,
					       valTotalRecursos,
					       valAspiraSubsidio,
					       seqVivienda,
					       valArriendo,
					       bolPromesaFirmada,
					       fchInscripcion,
					       fchPostulacion,
					       fchVencimiento,
					       bolIntegracionSocial,
					       bolSecSalud,
					       bolSecEducacion,
					       bolIpes,
					       txtOtro,
					       seqSisben,
					       numAdultosNucleo,
					       numNinosNucleo,
					       seqUsuario,
					       bolCerrado,
					       seqLocalidad,
					       valIngresoHogar,
					       seqEstadoProceso,
						   txtDireccionSolucion,
						   seqPuntoAtencion,
						   fchAprobacionCredito,
						   txtFormulario,
						   fchUltimaActualizacion,
						   seqProyecto,
						   numCortes,
						   seqPeriodo,
						   txtSoporteSubsidioNacional,
						   fchArriendoDesde,
						   txtComprobanteArriendo,
						   bolSancion ,
                           fchVigencia,
                           seqBarrio,
                           seqUpz,
                           seqPlanGobierno,
                           seqCiudad
					  FROM T_FRM_FORMULARIO
					  WHERE seqFormulario = $seqFormulario			
				";
				$objRes = $aptBd->execute( $sql );
				
				if( $objRes->fields ){
					
					$this->txtDireccion= $objRes->fields['txtDireccion'];
					$this->numTelefono1= $objRes->fields['numTelefono1'];
					$this->numTelefono2= $objRes->fields['numTelefono2'];
					$this->numCelular= $objRes->fields['numCelular'];
					$this->txtBarrio= $objRes->fields['txtBarrio'];
					$this->txtCorreo= $objRes->fields['txtCorreo'];
					$this->txtMatriculaInmobiliaria= strtoupper( $objRes->fields['txtMatriculaInmobiliaria'] );
					$this->txtChip= strtoupper( $objRes->fields['txtChip'] );
					$this->bolViabilizada= $objRes->fields['bolViabilizada'];
					$this->bolIdentificada= $objRes->fields['bolIdentificada'];
					$this->bolDesplazado= $objRes->fields['bolDesplazado'];
					$this->seqSolucion= $objRes->fields['seqSolucion'];
					$this->valPresupuesto= $objRes->fields['valPresupuesto'];
					$this->valAvaluo= $objRes->fields['valAvaluo'];
					$this->valTotal= $objRes->fields['valTotal'];
					$this->seqModalidad= $objRes->fields['seqModalidad'];
					$this->seqBancoCuentaAhorro= $objRes->fields['seqBancoCuentaAhorro'];
					$this->fchAperturaCuentaAhorro= $objRes->fields['fchAperturaCuentaAhorro'];
					$this->bolInmovilizadoCuentaAhorro= $objRes->fields['bolInmovilizadoCuentaAhorro'];
					$this->valSaldoCuentaAhorro= $objRes->fields['valSaldoCuentaAhorro'];
					$this->txtSoporteCuentaAhorro= $objRes->fields['txtSoporteCuentaAhorro'];
					$this->seqBancoCuentaAhorro2= $objRes->fields['seqBancoCuentaAhorro2'];
					$this->fchAperturaCuentaAhorro2= $objRes->fields['fchAperturaCuentaAhorro2'];
					$this->bolInmovilizadoCuentaAhorro2= $objRes->fields['bolInmovilizadoCuentaAhorro2'];
					$this->valSaldoCuentaAhorro2= $objRes->fields['valSaldoCuentaAhorro2'];
					$this->txtSoporteCuentaAhorro2= $objRes->fields['txtSoporteCuentaAhorro2'];
					$this->valSubsidioNacional= $objRes->fields['valSubsidioNacional'];
					$this->txtSoporteSubsidio= $objRes->fields['txtSoporteSubsidio'];
					$this->valAporteLote= $objRes->fields['valAporteLote'];
					$this->txtSoporteAporteLote= $objRes->fields['txtSoporteAporteLote'];
					$this->seqCesantias= $objRes->fields['seqCesantias'];
					$this->valSaldoCesantias= $objRes->fields['valSaldoCesantias'];
					$this->txtSoporteCesantias= $objRes->fields['txtSoporteCesantias'];
					$this->valAporteAvanceObra= $objRes->fields['valAporteAvanceObra'];
					$this->txtSoporteAvanceObra= $objRes->fields['txtSoporteAvanceObra'];
					$this->valAporteMateriales= $objRes->fields['valAporteMateriales'];
					$this->txtSoporteAporteMateriales= $objRes->fields['txtSoporteAporteMateriales'];
					$this->seqEmpresaDonante= $objRes->fields['seqEmpresaDonante'];
					$this->valDonacion= $objRes->fields['valDonacion'];
					$this->txtSoporteDonacion= $objRes->fields['txtSoporteDonacion'];
					$this->seqBancoCredito= $objRes->fields['seqBancoCredito'];
					$this->valCredito= $objRes->fields['valCredito'];
					$this->txtSoporteCredito= $objRes->fields['txtSoporteCredito'];
					$this->valTotalRecursos= $objRes->fields['valTotalRecursos'];
					$this->valAspiraSubsidio= $objRes->fields['valAspiraSubsidio'];
					$this->seqVivienda= $objRes->fields['seqVivienda'];
					$this->valArriendo= $objRes->fields['valArriendo'];
					$this->bolPromesaFirmada= $objRes->fields['bolPromesaFirmada'];
					$this->fchInscripcion= $objRes->fields['fchInscripcion'];
					$this->fchPostulacion= $objRes->fields['fchPostulacion'];
					$this->fchVencimiento= $objRes->fields['fchVencimiento'];
					$this->bolIntegracionSocial= $objRes->fields['bolIntegracionSocial'];
					$this->bolSecSalud= $objRes->fields['bolSecSalud'];
					$this->bolSecEducacion= $objRes->fields['bolSecEducacion'];
					$this->bolIpes= $objRes->fields['bolIpes'];
					$this->txtOtro= $objRes->fields['txtOtro'];
					$this->seqSisben= $objRes->fields['seqSisben'];
					$this->numAdultosNucleo= $objRes->fields['numAdultosNucleo'];
					$this->numNinosNucleo= $objRes->fields['numNinosNucleo'];
					$this->seqUsuario= $objRes->fields['seqUsuario'];
					$this->bolCerrado= $objRes->fields['bolCerrado'];
					$this->seqLocalidad= $objRes->fields['seqLocalidad'];
					$this->valIngresoHogar= $objRes->fields['valIngresoHogar'];
					$this->seqEstadoProceso= $objRes->fields['seqEstadoProceso']; 		
					$this->txtDireccionSolucion = $objRes->fields['txtDireccionSolucion'];
					$this->seqPuntoAtencion = $objRes->fields['seqPuntoAtencion'];
					$this->fchAprobacionCredito = $objRes->fields['fchAprobacionCredito'];
					$this->txtFormulario = $objRes->fields['txtFormulario'];
					$this->fchUltimaActualizacion = $objRes->fields['fchUltimaActualizacion'];
					$this->seqProyecto = $objRes->fields['seqProyecto'];
					$this->numCortes = $objRes->fields['numCortes'];
					$this->seqPeriodo = $objRes->fields['seqPeriodo'];
					$this->txtSoporteSubsidioNacional = $objRes->fields['txtSoporteSubsidioNacional'];
					$this->fchArriendoDesde = $objRes->fields['fchArriendoDesde'];
					$this->txtComprobanteArriendo = $objRes->fields['txtComprobanteArriendo'];
					$this->bolSancion = $objRes->fields['bolSancion'];
					$this->fchVigencia = $objRes->fields['fchVigencia'];
                    $this->seqBarrio = $objRes->fields['seqBarrio'];
                    $this->seqUpz = $objRes->fields['seqUpz'];
                    $this->seqCiudad = $objRes->fields['seqCiudad'];
                    $this->seqPlanGobierno = $objRes->fields['seqPlanGobierno'];
                    
				}else{
					$this->arrErrores[] = "No se encuentra el formulario [$seqFormulario]";
				}
				
			}
			
	    } // fin cargar formulario
	    
	
		public function editarFormulario( $seqFormulario ){
			
			global $aptBd;
			
			$sql = "
				UPDATE T_FRM_FORMULARIO SET 
					txtDireccion  =   \"".$this->txtDireccion."\",
					numTelefono1  =   ".$this->numTelefono1.",
					numTelefono2  =   ".$this->numTelefono2.",
					numCelular  =   ".$this->numCelular.",
					txtBarrio  =   \"".$this->txtBarrio."\",
					txtCorreo  =   \"".$this->txtCorreo."\",
					txtMatriculaInmobiliaria  =   \"". strtoupper( $this->txtMatriculaInmobiliaria )."\",
					txtChip  =   \"". strtoupper( $this->txtChip )."\",
					bolViabilizada  =   ".$this->bolViabilizada.",
					bolIdentificada  =   ".$this->bolIdentificada.",
					bolDesplazado  =   ".$this->bolDesplazado.",
					seqSolucion  =   ".$this->seqSolucion.",
					valPresupuesto  =   ".$this->valPresupuesto.",
					valAvaluo  =   ".$this->valAvaluo.",
					valTotal  =   ".$this->valTotal.",
					seqModalidad  =   ".$this->seqModalidad.",
					seqBancoCuentaAhorro  =   ".$this->seqBancoCuentaAhorro.",
					fchAperturaCuentaAhorro  =   \"".$this->fchAperturaCuentaAhorro."\",
					bolInmovilizadoCuentaAhorro  =   ".$this->bolInmovilizadoCuentaAhorro.",
					valSaldoCuentaAhorro  =   ".$this->valSaldoCuentaAhorro.",
					txtSoporteCuentaAhorro  =   \"".$this->txtSoporteCuentaAhorro."\",
					seqBancoCuentaAhorro2  =   ".$this->seqBancoCuentaAhorro2.",
					fchAperturaCuentaAhorro2  =   \"".$this->fchAperturaCuentaAhorro2."\",
					bolInmovilizadoCuentaAhorro2  =   \"".$this->bolInmovilizadoCuentaAhorro2."\",
					valSaldoCuentaAhorro2  =   \"".$this->valSaldoCuentaAhorro2."\",
					txtSoporteCuentaAhorro2  =   \"".$this->txtSoporteCuentaAhorro2."\",
					valSubsidioNacional  =   ".$this->valSubsidioNacional.",
					txtSoporteSubsidio  =   \"".$this->txtSoporteSubsidio."\",
					valAporteLote  =   ".$this->valAporteLote.",
					txtSoporteAporteLote  =   \"".$this->txtSoporteAporteLote."\",
					seqCesantias  =   ".$this->seqCesantias.",
					valSaldoCesantias  =   ".$this->valSaldoCesantias.",
					txtSoporteCesantias  =   \"".$this->txtSoporteCesantias."\",
					valAporteAvanceObra  =   ".$this->valAporteAvanceObra.",
					txtSoporteAvanceObra  =   \"".$this->txtSoporteAvanceObra."\",
					valAporteMateriales  =   ".$this->valAporteMateriales.",
					txtSoporteAporteMateriales  =   \"".$this->txtSoporteAporteMateriales."\",
					seqEmpresaDonante  =   \"".$this->seqEmpresaDonante."\",
					valDonacion  =   ".$this->valDonacion.",
					txtSoporteDonacion  =   \"".$this->txtSoporteDonacion."\",
					seqBancoCredito  =   ".$this->seqBancoCredito.",
					valCredito  =   ".$this->valCredito.",
					txtSoporteCredito  =   \"".$this->txtSoporteCredito."\",
					valTotalRecursos  =   ".$this->valTotalRecursos.",
					valAspiraSubsidio  =   ".mb_ereg_replace("[^0-9]", "", $this->valAspiraSubsidio ).",
					seqVivienda  =   ".$this->seqVivienda.",
					valArriendo  =   ".$this->valArriendo.",
					bolPromesaFirmada  =   ".$this->bolPromesaFirmada.",
					fchInscripcion  =   \"".$this->fchInscripcion."\",
					fchPostulacion  =   \"".$this->fchPostulacion."\",
					fchVencimiento  =   \"".$this->fchVencimiento."\",
					bolIntegracionSocial  =   ".$this->bolIntegracionSocial.",
					bolSecSalud  =   ".$this->bolSecSalud.",
					bolSecEducacion =   ".$this->bolSecEducacion.",
					bolIpes  =   ".$this->bolIpes.",
					txtOtro  =   \"".$this->txtOtro."\",
					seqSisben  =   ".$this->seqSisben.",
					numAdultosNucleo  =   ".$this->numAdultosNucleo.",
					numNinosNucleo  =   ".$this->numNinosNucleo.",
					seqUsuario  =   ".$this->seqUsuario.",
					bolCerrado  =   " . intval( $this->bolCerrado ) . ",
					seqLocalidad  =   ".$this->seqLocalidad.",
					valIngresoHogar  =   ".$this->valIngresoHogar.",
					seqEstadoProceso  =   ".$this->seqEstadoProceso.",
					txtDireccionSolucion = \"".$this->txtDireccionSolucion."\",
					seqPuntoAtencion = ".$this->seqPuntoAtencion.",
					fchAprobacionCredito = \"" . $this->fchAprobacionCredito . "\",
					txtFormulario = \"" . $this->txtFormulario . "\",
					fchUltimaActualizacion = \"".$this->fchUltimaActualizacion."\",
					seqProyecto = '".$this->seqProyecto."',
					txtSoporteSubsidioNacional = \"" . $this->txtSoporteSubsidioNacional . "\",
					fchArriendoDesde = \"" . $this->fchArriendoDesde . "\",
					txtComprobanteArriendo = \"" . $this->txtComprobanteArriendo . "\",
                    seqBarrio  =   \"".$this->seqBarrio."\",
					seqUpz  =   \"".$this->seqUpz."\"
				WHERE
					seqFormulario = $seqFormulario		
			";
			
			try {
				$aptBd->execute( $sql );
			} catch ( Exception $objError ){
				$this->arrErrores[] = "No se ha podido actualizar la informacion del formulario [$seqFormulario]";
				print_r( $objError->getMessage() );
			}
			
		} // Editar Formulario
	
		public function listosCalificacion(){
			global $aptBd;
			$sql = "
				SELECT
					frm.seqFormulario
				FROM
					T_FRM_FORMULARIO frm,
					T_FRM_HOGAR hog, 
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano
					and hog.seqFormulario = frm.seqFormulario
					and frm.bolCerrado = 1
					and frm.seqEstadoProceso = 7
					AND frm.fchPostulacion <= ( 
						SELECT fchFinal 
						FROM T_FRM_PERIODO 
						WHERE seqPeriodo = (
							SELECT max(seqPeriodo) 
							FROM T_FRM_PERIODO
						) 
					)					
				GROUP BY 
					frm.seqFormulario
			";
			$objRes = $aptBd->execute( $sql );
			while( $objRes->fields ){
				$arrFormulario[ ] = $objRes->fields['seqFormulario']; 
				$objRes->MoveNext();
			}
			return $arrFormulario;
		} // listos para calificar
		
		/**
		 * RECIBE UN NUMERO DE FORMULARIO Y DICE SI ES 
		 * LA SECUENCIA QUE SIGUE O ESTA ERRADA
		 * @author Bernardo Zerda
		 * @param String txtFormulario
		 * @return Integer numProximaSecuencia
		 * @version 1.0 Julio 2009
		 */
		public function tutorSecuencia( $txtFormulario ){
			
			global $aptBd;
			
			// Separa el tutor del numero del formulario
			$arrFormulario = split( "-" , $txtFormulario );
			$numTutor = $arrFormulario[ 0 ];
			$numFormulario = intval( $arrFormulario[ 1 ] );
			
			// consulta los numeros de formulario
			$sql = "
				SELECT txtFormulario
				FROM T_FRM_FORMULARIO
				WHERE txtFormulario LIKE '$numTutor%'
				OR txtFormulario LIKE '0$numTutor%'
			";
			$objRes = $aptBd->execute( $sql );
			$arrSecuencia = array();
			while( $objRes->fields ){
				$arrFormularioBd = split( "[\/-]" , $objRes->fields['txtFormulario'] );
				$numTutorBd = intval( $arrFormularioBd[ 0 ] );
				$numFormularioBd = intval( $arrFormularioBd[ 1 ] );
				$arrSecuencia[ ] = $numFormularioBd; 
				$objRes->MoveNext();
			}
			sort( $arrSecuencia ); // Ordena la secuencia
			
			// Numero de la proxima secuencia
			$numProximaSecuencia = ( $arrSecuencia[ ( count( $arrSecuencia ) - 1 ) ] + 1 ); 
			
			return $numProximaSecuencia;
		} // tutor secuencia
		
		/**
		 * OBTIENE LAS FECHAS DE INSCRIPCION Y POSTULACION
		 * PARA QUE QUEDEN FIJAS AL MOMENTO DE ACTUALIZAR
		 * EL FORMULARIO
		 * @author Bernardo Zerda
		 * @param Integer seqFormulario
		 * @return Array arrFechas
		 * @version 1.0 Julio 2009
		 */
		public function obtenerFechas( $seqFormulario ){
			global $aptBd;
			$arrFechas = array();
			$sql = "
				SELECT fchInscripcion, fchPostulacion, fchNotificacion
				FROM T_FRM_FORMULARIO
				WHERE seqFormulario = $seqFormulario
			";
			$objRes = $aptBd->execute( $sql );
			if( $objRes->fields ){
				$arrFechas['fchInscripcion']  = ( $objRes->fields['fchInscripcion']  != "0000-00-00" )? $objRes->fields['fchInscripcion']  : "" ;
				$arrFechas['fchPostulacion']  = ( $objRes->fields['fchPostulacion']  != "0000-00-00" )? $objRes->fields['fchPostulacion']  : "" ;
				$arrFechas['fchNotificacion'] = ( $objRes->fields['fchNotificacion'] != "0000-00-00" )? $objRes->fields['fchNotificacion'] : "" ; 
			} 
			return $arrFechas;
		} // obtener fechas
	
		/**
		 * VERIFICA LA EXISTENCIA DE UN IDENTIFICADOR
		 * DE FORMULARIO EN LA TABLA T_FRM_FORMULARIO
		 * @author Bernardo Zerda
		 * @param Integer seqFormulario
		 * @return Boolean ==> cuando existe
		 * 		   String  ==> Texto del error cuando no existe
		 */
		public function formularioExiste( $seqFormulario ){
			global $aptBd;
			$sql = "
				SELECT count( seqFormulario ) as cuenta
				FROM T_FRM_FORMULARIO
				WHERE seqFormulario = $seqFormulario
			"; 
			try{
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields[ "cuenta" ] == 1 ){
					return true;
				}else{
					return "El formulario $seqFormulario no existe";
				}
			} catch( Exception $objError ){
				return "El secuencial del formulario no puede ser vacio";
			}
		}
	
		public function obtenerActosAdministrativos(  ){
			
			$claActosAdministrativos = new ActoAdministrativo;
			$arrFormularioActo = $claActosAdministrativos->actoExisteCiudadano( $_POST['cedula'] );
			
			$txtJs = "";
			if( !empty( $arrFormularioActo ) ){
				$arrHogaresVinculados = array( );	
				foreach( $arrFormularioActo as $seqFormularioActo ){
					$arrHogaresVinculados[] = $claActosAdministrativos->obtenerActoAdministrativo( $seqFormularioActo );
				}
				
	//			Secuensiales Resolucion modificatoria
	//			5	Resolucion que Modifica
	//			8	Fecha resolucion
				
				
				$arrTiposActosAdministrativos = array( );
				$arrCaracteristicasActosAdministrativos = array( );
				$arrActosAdministrativo = array( );
				foreach( $arrHogaresVinculados as $arrDatosHogares ){
					
					$seqTipoActo 		= $arrDatosHogares['seqTipoActo'];
					$numActo 			= $arrDatosHogares['numActo'];
					$fchActo 			= $arrDatosHogares['fchActo'];
					$seqFormularioActo 	= $arrDatosHogares['seqFormularioActo'];
					
               if( trim( $numActo ) != 0 and trim( $fchActo ) != "" ){
                  $arrActosAdministrativo[] = $claActosAdministrativos->cargarActoAdministrativoNumero( $seqTipoActo , $numActo , $fchActo , $seqFormularioActo );
                  $arrCaracteristicasActosAdministrativos[] = "";
               }
				}
				
	//			pr( $arrHogaresVinculados );
	//			pr( $arrActosAdministrativo );
				
				$arrArbolMostrar = array( );
				$i = 0;
				foreach( $arrHogaresVinculados as $arrActo ){
					
					unset( $arrActosAdministrativo[$i][0] );
					$arrActoCiudadano = $arrActosAdministrativo[$i];
					$seqTipoActo = $arrActo["seqTipoActo"];
					$numActo 	 = $arrActo["numActo"];
					$fchActo 	 = $arrActo["fchActo"];
					$txtTitulo = "";
					
					$txtTitulo = $arrActo["txtNombreTipoActo"] ." Número ". $numActo ." del ". formatoFechaTextoFecha( $fchActo );
					
					
					// RESOLUCION MODIFICATORIA
					if( $seqTipoActo == 2 ){
						$arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica( $numActo, $fchActo, $seqTipoActo );
						$txtTitulo .= " Resolucion que Modifica: ". $arrResolucionModifica["Resolucion que Modifica"];
						$txtTitulo .= " Fecha resolucion: ". formatoFechaTextoFecha( $arrResolucionModifica["Fecha resolucion"] );
					}
					
					// RESOLUCION MODIFICATORIA
					if( $seqTipoActo == 4 ){
						$arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica( $numActo, $fchActo, $seqTipoActo );
						$txtTitulo .= " En respuesta a Resolucion numero ". $arrResolucionModifica["Resolucion que Modifica"];
						$txtTitulo .= " del ". formatoFechaTextoFecha( $arrResolucionModifica["Fecha Resolucion"] );
					}
					
					// RESOLUCION RENUNCIA
					if( $seqTipoActo == 6 ){
						$arrResolucionModifica = $claActosAdministrativos->obtenerResolucionModifica( $numActo, $fchActo, $seqTipoActo );
						$txtTitulo .= " Resolución de Asignación ". $arrResolucionModifica["Resolución Asignacion"];
						$txtTitulo .= " del ". formatoFechaTextoFecha( $arrResolucionModifica["Fecha Resolución Asignacion"] );
					}
					
					// NOTIFICACIONES
					if( $seqTipoActo == 7 ){
						$arrResolucionAsociada  = $claActosAdministrativos->obtenerResolucionModifica( $numActo, $fchActo, $seqTipoActo );
						$txtTipoActo 			= $claActosAdministrativos->tipoActo( $arrResolucionAsociada[ "Numero Acto Administrativo" ] , $arrResolucionAsociada[ "Fecha Acto Administrativo" ] );
						$txtTitulo .= " para la $txtTipoActo ". $arrResolucionAsociada[ "Numero Acto Administrativo" ];
						$txtTitulo .= " del ". formatoFechaTextoFecha( $arrResolucionAsociada[ "Fecha Acto Administrativo" ] );
					}
					
					$i++;
					$arrArbolMostrar[$txtTitulo] = array( );
					
					foreach( $arrActoCiudadano as $arrDatosCiudadanoActo ){
						$txtCiudadano = utf8_encode( $arrDatosCiudadanoActo[10] ." Numero Documento: ". number_format( $arrDatosCiudadanoActo[9] ) );
						switch( $seqTipoActo ){
							case 2: // RESOLUCION MODIFICATORIA
								$txtModificacion = "Campo Modifica: ". $arrDatosCiudadanoActo[11] .
													". Campo Incorrecto: ". $arrDatosCiudadanoActo[12] .
													". Campo Correcto: ". $arrDatosCiudadanoActo[13];
								$arrArbolMostrar[$txtTitulo][$txtCiudadano][] = utf8_encode( $txtModificacion );
								break;
							case 3: // RESOLUCION INHABILITADOS
								if( $arrDatosCiudadanoActo[11] ){
									$txtCausa = str_replace( ";", "<br />", $arrDatosCiudadanoActo[11] );
									$txtCausa = str_replace( ":", ": ", $txtCausa );
									$txtInhabilidad = "Inhabilidad: <br />". $txtCausa .
														"Causa: ". $arrDatosCiudadanoActo[12] .
														"<br />Fuente: ". $arrDatosCiudadanoActo[13];
									$arrArbolMostrar[$txtTitulo][$txtCiudadano][] = utf8_encode( $txtInhabilidad );
								}
								break;
							case 4: // RECURSO DE REPOSICION
								if( $arrDatosCiudadanoActo[11] ){
									$txtRecursoReposicion = "Resultado: ". $arrDatosCiudadanoActo[11];
									$arrArbolMostrar[$txtTitulo][$txtCiudadano] = utf8_encode( $txtRecursoReposicion );
								}
								break;
							default:
								$arrArbolMostrar[$txtTitulo][$txtCiudadano] = "";
								break;
						}
					}
					
				}
				
				 $txtJs = "var objArbol = new YAHOO.widget.TreeView('treeDivArbolMostrar', [";
		 	
			 	foreach( $arrArbolMostrar as $txtResolucion => $arrActoCiudadano ){
			 		$txtJs .= "{";
			 		$txtJs .= "type: 'text',";
			 		$txtJs .= "label: '$txtResolucion',";
			 		$txtJs .= "idCampo: '',";
			 		$txtJs .= "children: [";
			 		
			 		foreach( $arrActoCiudadano as $txtNombreCiudadano => $txtDescripcionActo ){
			 			$txtJs .= "{";
				 		$txtJs .= "type: 'text',";
				 		$txtJs .= "label: '$txtNombreCiudadano'";
				 		if( is_array( $txtDescripcionActo )  ){
				 			$txtJs .= ",children: [";
				 			foreach( $txtDescripcionActo as $txtDescripcion ){
					 			$txtJs .= "{";
					 			$txtJs .= "type: 'text',";
					 			$txtJs .= "label: '$txtDescripcion'";
					 			$txtJs .= "},";
				 			}
				 			$txtJs = trim( $txtJs , "," );
				 			$txtJs .= "]";
				 		}
				 		else if( $txtDescripcionActo ){
				 			$txtJs .= ",children: [";
				 			$txtJs .= "{";
				 			$txtJs .= "type: 'text',";
				 			$txtJs .= "label: '$txtDescripcionActo'";
				 			$txtJs .= "}]";
				 		}
				 		
			 			$txtJs .= "},";
			 		}
			 		$txtJs = trim( $txtJs , "," );
			 		$txtJs .= "]";
			 		$txtJs .= "},";
			 	}
			 	$txtJs = trim( $txtJs , "," ) . "]);";
			}
			return $txtJs;
			
		}
	
	} // Fin de clase
	
?>