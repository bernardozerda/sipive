<?php

	/**
	 * CLASE QUE SE USA PARA CALIFICAR LOS FORMULARIOS
	 * @author Bernardo Zerda
	 * @version 1.0 Junio 2009
	 */
	
	class CalificacionSubsidios {
		
		public $arrModalidad;
		public $arrErrores;
		public $arrSociosEstrategicos;
		public $arrCriteriosUsados;

		private $arrConstantes;		
		private $arrSisben;
		private $arrEtnia;
		private $arrCondicion;
		private $arrParentesco;
		private $arrSolucion;
		private $arrProyectos; // viviendas en un sector catastral
		
		/**
		 * CONSTRUCTOR DE LA CALSE
		 * DECLARA LAS CONSTANTES A USAR EN LAS FORMULAS
		 * Y RECOGE LOS DATOS NECESARIOS PARA CALIFICAR
		 * @author bzerdar
		 * @param Void
		 * @return Void
		 * @version 1.0 Junio 2009
		 */
	    public function CalificacionSubsidios() {
	    	
	    	global $aptBd;
	    	
	    	// socios etrategicos de la secretaria del habitat para 
	    	// ahorro programado, esta variable se usa en los desempates
	    	$this->arrSociosEstrategicos[] = 34; // FNA
	    	
	    	// cuando se desempata se usan los criterios en orden, aqui se ven los formularios que han usado el primero, el segundo .... etc
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'sisben' ]      = array();
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'condiciones' ] = array();
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'etnias' ]      = array();
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'socios' ]      = array();
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'certificado' ] = array();
	    	$this->arrCriteriosUsados['sdv']['formularios'][ 'aleatorio' ]   = array();
	    	
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'sisben' ]      = 0.000000006;
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'condiciones' ] = 0.000000005;
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'etnias' ]      = 0.000000004;
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'socios' ]      = 0.000000003;
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'certificado' ] = 0.000000002;
	    	$this->arrCriteriosUsados['sdv']['constantes'][ 'aleatorio' ]   = 0.000000001;
	    	
	    	// desempates para arrendamiento
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'sisben' ]        = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'mesesArriendo' ] = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'monoparental' ]  = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'condiciones' ]   = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'menores' ]       = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'terceraEdad' ]   = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'etnias' ]        = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'desplazado' ]    = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'asignado' ]      = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'certificado' ]   = array();
	    	$this->arrCriteriosUsados['arr']['formularios'][ 'aleatorio' ]	   = array();
	    	
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'sisben' ]        = 0.0011;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'mesesArriendo' ] = 0.0010;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'monoparental' ]  = 0.0009;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'condiciones' ]   = 0.0008;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'menores' ]       = 0.0007;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'terceraEdad' ]   = 0.0006;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'etnias' ]        = 0.0005;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'desplazado' ]    = 0.0004;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'asignado' ]      = 0.0003;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'certificado' ]   = 0.0002;
	    	$this->arrCriteriosUsados['arr']['constantes'][ 'aleatorio' ]	  = 0.0001;
	    	
	    	// Obtiene todas las modalidades del 
	    	$sql = "SELECT seqModalidad, txtModalidad FROM T_FRM_MODALIDAD";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrModalidad[ $objRes->fields['seqModalidad'] ]['fnc'] = ereg_replace( "[^0-9A-Za-z]" , "" , strtolower( $objRes->fields['txtModalidad'] ) );
	    		$this->arrModalidad[ $objRes->fields['seqModalidad'] ]['nom'] = strtoupper( $objRes->fields['txtModalidad'] );
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Constantes para cada calificacion
	    	$this->arrConstantes['adquisicion']['b1']   =  91.8448020000000; // Sisben 1 
	    	$this->arrConstantes['adquisicion']['b2']   =  69.5387400000000; // Sisben 2
	    	$this->arrConstantes['adquisicion']['b3']   = 244.3265800000000; // Etnias
	    	$this->arrConstantes['adquisicion']['b4']   =  44.2561300000000; // Monoparental
	    	$this->arrConstantes['adquisicion']['b5']   =  73.0881070000000; // Dos o mas condiciones especiales
	    	$this->arrConstantes['adquisicion']['b6']   = 263.7852500000000; // Vivienda Viabilizada
	    	$this->arrConstantes['adquisicion']['b7']   = 248.3872600000000; // Vivienda VIP
	    	$this->arrConstantes['adquisicion']['b8']   = 238.7967300000000; // Vivienda VIS
	    	$this->arrConstantes['adquisicion']['b9']   =   1.5185580000000; // Numero de Meses de Ahorro
	    	
	    	$this->arrConstantes['construccion']['b1']  = 216.8744400000000; // Sisben 1
	    	$this->arrConstantes['construccion']['b2']  = 203.9171000000000; // Sisben 2
	    	$this->arrConstantes['construccion']['b3']  = 298.2034200000000; // Etnias
	    	$this->arrConstantes['construccion']['b4']  = 111.4861500000000; // Monoparental
	    	$this->arrConstantes['construccion']['b5']  = 160.0745300000000; // Dos o mas condiciones especiales
	    	$this->arrConstantes['construccion']['b6']  = 252.0657400000000; // Ubicacion de hogares en sector catastral
	    	
	    	$this->arrConstantes['estructural']['b1']   = 194.0184837998400; // Sisben 1
	    	$this->arrConstantes['estructural']['b2']   = 149.8734200354720; // Sisben 2
	    	$this->arrConstantes['estructural']['b3']   = 213.8421726258140; // Etnias
	    	$this->arrConstantes['estructural']['b4']   = 145.8632802702120; // Monoparental
	    	$this->arrConstantes['estructural']['b5']   = 198.6428321366240; // Dos o mas condiciones especiales
	    	$this->arrConstantes['estructural']['b6']   = 231.3753942672280; // Ubicacion de hogares en sector catastral
	    	
                $this->arrConstantes['habitabilidad']['b1'] = 115.9635982844360; // Sisben 1
	    	$this->arrConstantes['habitabilidad']['b2'] =  87.9527692918879; // Sisben 2
	    	$this->arrConstantes['habitabilidad']['b3'] = 131.2439096105280; // Etnias
	    	$this->arrConstantes['habitabilidad']['b4'] =  58.7347359638759; // Monoparental
	    	$this->arrConstantes['habitabilidad']['b5'] =  89.2014661783447; // Dos o mas condiciones especiales
	    	$this->arrConstantes['habitabilidad']['b6'] = 260.2066108924840; // Ubicacion de hogares en sector catastral
	    	
	    	$this->arrConstantes['arrendamiento']['b1'] =   3.66; // Numero de meses pagando arriendo
	    	$this->arrConstantes['arrendamiento']['b2'] = 226.51; // Sisben 1 
	    	$this->arrConstantes['arrendamiento']['b3'] = 203.15; // Sisben 2 
	    	$this->arrConstantes['arrendamiento']['b4'] = 125.22; // Sisben 3
	    	$this->arrConstantes['arrendamiento']['b5'] =  78.17; // Desplazado, Monoparental, discapacitado o mayor de 65 años
	    	$this->arrConstantes['arrendamiento']['b6'] = 137.09; // dos o mas condiciones especiales  
	    	$this->arrConstantes['arrendamiento']['b7'] = 231.48; // Hogar etnico 
	    	$this->arrConstantes['arrendamiento']['b8'] =  24.27; // hay menores de 14 años
	    	$this->arrConstantes['arrendamiento']['b9'] =  34.53; // Habilitado no asignado en algun corte
	    	
	    	// Niveles del sisben en la base de datos
	    	$sql = "SELECT seqSisben, txtSisben FROM T_FRM_SISBEN";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrSisben['id'][ $objRes->fields['seqSisben'] ] = strtoupper( $objRes->fields['txtSisben'] );
	    		$this->arrSisben['tx'][ strtoupper( $objRes->fields['txtSisben'] ) ] = $objRes->fields['seqSisben'];
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Condiciones Etnicas
	    	$sql = "SELECT seqEtnia, txtEtnia FROM T_CIU_ETNIA";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrEtnia['id'][ $objRes->fields['seqEtnia'] ] = strtoupper( $objRes->fields['txtEtnia'] );
	    		$this->arrEtnia['tx'][ strtoupper( $objRes->fields['txtEtnia'] ) ] = $objRes->fields['seqEtnia'];
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Condiciones especiales
	    	$sql = "SELECT seqCondicionEspecial, txtCondicionEspecial FROM T_CIU_CONDICION_ESPECIAL";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrCondicion['id'][ $objRes->fields['seqCondicionEspecial'] ] = strtoupper( $objRes->fields['txtCondicionEspecial'] );
	    		$this->arrCondicion['tx'][ strtoupper( $objRes->fields['txtCondicionEspecial'] ) ] = $objRes->fields['seqCondicionEspecial'];
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Parentesco
	    	$sql = "SELECT seqParentesco, txtParentesco FROM T_CIU_PARENTESCO";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrParentesco['id'][ $objRes->fields['seqParentesco'] ] = strtoupper( $objRes->fields['txtParentesco'] );
	    		$this->arrParentesco['tx'][ strtoupper( $objRes->fields['txtParentesco'] ) ] = $objRes->fields['seqParentesco'];
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Solucion
	    	$sql = "SELECT seqModalidad, seqSolucion, txtSolucion FROM T_FRM_SOLUCION";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrSolucion[ $objRes->fields['seqModalidad'] ]['id'][ $objRes->fields['seqSolucion'] ] = strtoupper( $objRes->fields['txtSolucion'] );
	    		$this->arrSolucion[ $objRes->fields['seqModalidad'] ]['tx'][ strtoupper( $objRes->fields['txtSolucion'] ) ] = $objRes->fields['seqSolucion']; 
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Formularios cerrados pertenecientes a un sector catastral
	    	// esto es para calcular la variable B7 de construccion y mejoramiento
	    	$sql = "
				SELECT pro.seqProyecto, count(*) as cuenta
				FROM T_FRM_FORMULARIO frm, T_FRM_PROYECTO pro
				WHERE frm.bolCerrado = 1
				AND frm.seqEstadoProceso = 7
				AND frm.seqProyecto IS NOT NULL
				AND frm.seqProyecto = pro.seqProyecto
				GROUP BY pro.seqProyecto	    	
	    	";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		$this->arrProyectos[ $objRes->fields['seqProyecto'] ] = $objRes->fields['cuenta']; 
	    		$objRes->MoveNext();
	    	}
	    	
	    	// Errores
	    	$this->arrErrores = array();
	    	
	    } // Fin constructor
		
		/**
		 * CALIFICACION DE LA MODALIDAD DE ADQUISISCION DE VIVIENDA
		 * @author bzerdar
		 * @param FormularioSubsidios objFormulario
		 * @return Array arrCalificacion
		 * @version 1.1 Septiembre de 2009
		 */
		public function adquisicindevivienda( $objFormulario ){
			
			$arrCalificacion = array();
			
			$arrCalificacion['total'] = 0; 
			
			// SISBEN B1: SISBEN NIVEL 1 O ES INDIGENA SIN SISBEN
			$objFormulario->seqSisben = ( $objFormulario->seqSisben == null )? 1 : $objFormulario->seqSisben;
			$arrCalificacion['variables']['b1']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b1']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 1'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['adquisicion']['b1'];
			} elseif( $this->arrSisben['tx']['NINGUNO'] == $objFormulario->seqSisben ) {
				$bolIndigenas = false;
				foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
					if( $this->arrEtnia['tx']['INDIGENA'] == $objCiudadano->seqEtnia ){
						$bolIndigenas = true;
						break;						
					}
				}
				if( $bolIndigenas ){ // indigena sin sisben
					$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['adquisicion']['b1'];
				}
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b1']['valor'];
			
			// SISBEN B2: SISBEN NIVEL 2 
			$arrCalificacion['variables']['b2']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b2']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 2'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b2']['valor'] = $this->arrConstantes['adquisicion']['b2'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b2']['valor'];
			
			// ETNIAS B3: CUALQUIER MIEMBRO DEL HOGAR CON ETNIA GANA EL PUNTO
			$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ 1 ];
			$arrCalificacion['variables']['b3']['valor'] = 0;
			$bolEtnias = false;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$objCiudadano->seqEtnia = ( $objCiudadano->seqEtnia == null )? 1 : $objCiudadano->seqEtnia;
				if( $this->arrEtnia['tx']['NINGUNA'] != $objCiudadano->seqEtnia ){
					$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ $objCiudadano->seqEtnia ];
					$bolEtnias = true;
					break;						
				}
			}
			if( $bolEtnias ){
				$arrCalificacion['variables']['b3']['valor'] = $this->arrConstantes['adquisicion']['b3'];
			}			
			$arrCalificacion['total'] += $arrCalificacion['variables']['b3']['valor'];

			// CONDICIONES ESPECIALES B4: MONOPARENTAL, DISCAPACITADO, MAYOR DE 65 AÑOS
			$arrCalificacion['variables']['b4']['formulario'] = "Ninguna Condición Especial";
			$arrCalificacion['variables']['b4']['valor'] = 0;
			
			$bolMonoparental = $this->hogarMonoparental( $objFormulario );
			
			$arrCondicionesEspeciales[ 2 ] = $this->arrCondicion['id'][ 2 ]; // Mayor de 65 años
			$arrCondicionesEspeciales[ 3 ] = $this->arrCondicion['id'][ 3 ]; // Discapacitado
			$arrCondicion    = $this->condicionEspecial($objFormulario, $arrCondicionesEspeciales );
			
			if( $bolMonoparental == true or $arrCondicion['cuenta'] == 1 ){
				$arrCalificacion['variables']['b4']['formulario'] = ( $bolMonoparental == true )? "Hogar Monoparental" : $arrCondicion['texto'] ;
				$arrCalificacion['variables']['b4']['valor'] = $this->arrConstantes['adquisicion']['b4'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b4']['valor'];
			
			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR
			$arrCondicion = $this->condicionEspecial( $objFormulario );
			
			// CONDICIONES ESPECIALES B5: SI EL HOGAR CUMPLE CON MAS DE UNA DE ESTAS CONDICIONES ESPECIALES ES IGUAL A UNO DE LO CONTRARIO CERO
			$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['cuenta'] . " Condiciones especiales";
			$arrCalificacion['variables']['b5']['valor'] = 0;
			if( $arrCondicion['cuenta'] > 1 ){
				$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['texto'];
				$arrCalificacion['variables']['b5']['valor'] = $this->arrConstantes['adquisicion']['b5'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b5']['valor'];
			
			// IDENTIFICACION DE LA SOLUCION DE VIVIENDA B6: IDENTIFICADA
			$arrCalificacion['variables']['b6']['formulario'] = "NO";
			$arrCalificacion['variables']['b6']['valor'] = 0;
			if( $objFormulario->bolIdentificada == 1 or $objFormulario->bolViabilizada == 1 ){
				$arrCalificacion['variables']['b6']['formulario'] = "SI";
				$arrCalificacion['variables']['b6']['valor'] = $this->arrConstantes['adquisicion']['b6'];	
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b6']['valor'];
			
			// SOLUCION DE VIVIENDA B7: SOLUCION DE VIVIENDA VIP
			$arrCalificacion['variables']['b7']['formulario'] = "NINGUNA";
			$arrCalificacion['variables']['b7']['valor'] = 0;
			if( $objFormulario->seqSolucion == 2 or $objFormulario->seqSolucion == 3 ){
				$arrCalificacion['variables']['b7']['formulario'] = $this->arrSolucion[ $objFormulario->seqModalidad ]['id'][ $objFormulario->seqSolucion ];
				$arrCalificacion['variables']['b7']['valor'] = $this->arrConstantes['adquisicion']['b7'];				
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b7']['valor'];
			
			// SOLUCION DE VIVIENDA B9: SOLUCION DE VIVIENDA VIS
			$arrCalificacion['variables']['b8']['formulario'] = "NINGUNA";
			$arrCalificacion['variables']['b8']['valor'] = 0;
			if( $objFormulario->seqSolucion == 4 ){
				$arrCalificacion['variables']['b8']['formulario'] = $this->arrSolucion[ $objFormulario->seqModalidad ]['id'][ $objFormulario->seqSolucion ];
				$arrCalificacion['variables']['b8']['valor'] = $this->arrConstantes['adquisicion']['b8'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b8']['valor'];
			
			// TIMEPO DE AHORRO B9: NUMERO DE MESES
			// CUENTA DE AHORRO 1
			$numMesesAhorro1 = 0;
			list( $ano , $mes , $dia ) = split( "-" , $objFormulario->fchAperturaCuentaAhorro );
			if( @checkdate( $mes , $dia , $ano ) ){
				$numAhora = time();
				$numFecha = strtotime( $objFormulario->fchAperturaCuentaAhorro );
				if( $numFecha != "" ){
					$numSegundosAhorro = $numAhora - $numFecha;
					$numDiasAhorro     = $numSegundosAhorro / 86400;
					$numMesesAhorro1   = $numDiasAhorro / 30;
					$numMesesAhorro1   = (  $numMesesAhorro1 > 48 )? 48 : $numMesesAhorro1 ;
					$numMesesAhorro1   = (  $numMesesAhorro1 < 0  )? 0  : $numMesesAhorro1 ;
					$numMesesAhorro1   = round( $numMesesAhorro1 , 4 );
				}
			}
			
			$numMesesAhorro2 = 0;
			list( $ano , $mes , $dia ) = split( "-" , $objFormulario->fchAperturaCuentaAhorro2 );
			if( @checkdate( $mes , $dia , $ano ) ){
				$numAhora = time();
				$numFecha = strtotime( $objFormulario->fchAperturaCuentaAhorro2 );
				if( $numFecha != "" ){
					$numSegundosAhorro = $numAhora - $numFecha;
					$numDiasAhorro     = $numSegundosAhorro / 86400;
					$numMesesAhorro2   = $numDiasAhorro / 30;
					$numMesesAhorro2   = (  $numMesesAhorro2 > 48 )? 48 : $numMesesAhorro2 ;
					$numMesesAhorro2   = (  $numMesesAhorro2 < 0  )? 0  : $numMesesAhorro2 ;
					$numMesesAhorro2   = round( $numMesesAhorro2 , 4 );
				}
			}
			
			// Mira cual de las dos fechas es mayor para tomar la mas antigua
			if( $numMesesAhorro1 > $numMesesAhorro2 ){
				$arrCalificacion['variables']['b9']['formulario'] = $objFormulario->fchAperturaCuentaAhorro . " (" . $numMesesAhorro1 . " Meses)";
				$arrCalificacion['variables']['b9']['valor'] = round( ( $numMesesAhorro1 * $this->arrConstantes['adquisicion']['b9'] ) , 4 );
				$arrCalificacion['total'] += $arrCalificacion['variables']['b9']['valor'];
			}else{
				$arrCalificacion['variables']['b9']['formulario'] = $objFormulario->fchAperturaCuentaAhorro2 . " (" . $numMesesAhorro2 . " Meses)";
				$arrCalificacion['variables']['b9']['valor'] = round( ( $numMesesAhorro2 * $this->arrConstantes['adquisicion']['b9'] ) , 4 );
				$arrCalificacion['total'] += $arrCalificacion['variables']['b9']['valor'];
			}
			
			return $arrCalificacion;
			
		} // Adquisicion de vivienda
		
		/**
		 * ALGORITMO QUE APLICA LA FORMULA DE CALIFICACION 
		 * MOSTRADA EN EL REGLAMENTO PARA MODALIDAD CONSTRUCCION
		 * @author Bernardo Zerda
		 * @param FormularioSubsidios objFormulario
		 * @return Array arrCalificacion
		 * @version 1.0 Julio 2009
		 */
		public function construccin( $objFormulario ){
			
			$arrCalificacion['total'] = 0; 
			
			// SISBEN B1: SISBEN NIVEL 1 O ES INDIGENA SIN SISBEN
			$objFormulario->seqSisben = ( $objFormulario->seqSisben == null )? 1 : $objFormulario->seqSisben;
			$arrCalificacion['variables']['b1']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b1']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 1'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['construccion']['b1'];
			} elseif( $this->arrSisben['tx']['NINGUNO'] == $objFormulario->seqSisben ) {
				$bolIndigenas = false;
				foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
					if( $this->arrEtnia['tx']['INDIGENA'] == $objCiudadano->seqEtnia ){
						$bolIndigenas = true;
						break;						
					}
				}
				if( $bolIndigenas ){ // indigena sin sisben
					$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['construccion']['b1'];
				}
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b1']['valor'];	
			
			// SISBEN B2: SISBEN NIVEL 2 
			$arrCalificacion['variables']['b2']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b2']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 2'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b2']['valor'] = $this->arrConstantes['construccion']['b2'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b2']['valor'];
			
			// ETNIAS B3: CUALQUIER MIEMBRO DEL HOGAR CON ETNIA GANA EL PUNTO
			$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ 1 ];
			$arrCalificacion['variables']['b3']['valor'] = 0;
			$bolEtnias = false;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
				if( $this->arrEtnia['tx']['NINGUNA'] != $objCiudadano->seqEtnia ){
					$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ $objCiudadano->seqEtnia ];
					$bolEtnias = true;
					break;						
				}
			}
			if( $bolEtnias ){
				$arrCalificacion['variables']['b3']['valor'] = $this->arrConstantes['construccion']['b3'];
			}			
			$arrCalificacion['total'] += $arrCalificacion['variables']['b3']['valor'];
			
			// CONDICIONES ESPECIALES B4: MONOPARENTAL, DISCAPACITADO, MAYOR DE 65 AÑOS
			$arrCalificacion['variables']['b4']['formulario'] = "Ninguna Condición Especial";
			$arrCalificacion['variables']['b4']['valor'] = 0;
			
			$bolMonoparental = $this->hogarMonoparental( $objFormulario );
			
			$arrCondicionesEspeciales[ 2 ] = $this->arrCondicion['id'][ 2 ]; // Mayor de 65 años
			$arrCondicionesEspeciales[ 3 ] = $this->arrCondicion['id'][ 3 ]; // Discapacitado
			$arrCondicion    = $this->condicionEspecial($objFormulario, $arrCondicionesEspeciales );
			
			if( $bolMonoparental == true or $arrCondicion['cuenta'] == 1 ){
				$arrCalificacion['variables']['b4']['formulario'] = ( $bolMonoparental == true )? "Hogar Monoparental" : $arrCondicion['texto'] ;
				$arrCalificacion['variables']['b4']['valor'] = $this->arrConstantes['construccion']['b4'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b4']['valor'];
		
			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR
			$arrCondicion = $this->condicionEspecial( $objFormulario );
			
			// CONDICIONES ESPECIALES B5: SI EL HOGAR CUMPLE CON MAS DE UNA DE ESTAS CONDICIONES ESPECIALES ES IGUAL A UNO DE LO CONTRARIO CERO
			$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['cuenta'] . " Condiciones especiales";
			$arrCalificacion['variables']['b5']['valor'] = 0;
			if( $arrCondicion['cuenta'] > 1 ){
				$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['texto'];
				$arrCalificacion['variables']['b5']['valor'] = $this->arrConstantes['construccion']['b5'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b5']['valor'];
			
			// HOGARES UBICADOS EN SECTORES CATASTRALES CON MAYOR NUMERO DE FAMILIAS POSTULADAS B7
			$arrCalificacion['variables']['b6']['formulario'] = "0 Hogares Postulados";
			$arrCalificacion['variables']['b6']['valor'] = 0;
			if( isset( $this->arrProyectos[ $objFormulario->seqProyecto ] ) ){
				if( intval( $this->arrProyectos[ $objFormulario->seqProyecto ] ) >= 5 ){
					$arrCalificacion['variables']['b6']['formulario'] = $this->arrProyectos[ $objFormulario->seqProyecto ] . " Hogares Postulados";
					$arrCalificacion['variables']['b6']['valor'] = $this->arrConstantes['construccion']['b6'];
				}	
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b6']['valor'];
				
			return $arrCalificacion;
			
		} // Construccion
		
		/**
		 * CALIFICACION DE LA MODALIDAD DE MEJORAMIENTO DE HABITABILIDAD
		 * @author bzerdar
		 * @param FormularioSubsidios objFormulario
		 * @return Array arrCalificacion
		 * @version 1.1 Septiembre de 2009
		 */
		public function mejoramientodehabitabilidad( $objFormulario ){
			
			$arrCalificacion['total'] = 0; 
			
			// SISBEN B1: SISBEN NIVEL 1 O ES INDIGENA SIN SISBEN
			$objFormulario->seqSisben = ( $objFormulario->seqSisben == null )? 1 : $objFormulario->seqSisben;
			$arrCalificacion['variables']['b1']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b1']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 1'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['habitabilidad']['b1'];
			} elseif( $this->arrSisben['tx']['NINGUNO'] == $objFormulario->seqSisben ) {
				$bolIndigenas = false;
				foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
					if( $this->arrEtnia['tx']['INDIGENA'] == $objCiudadano->seqEtnia ){
						$bolIndigenas = true;
						break;						
					}
				}
				if( $bolIndigenas ){ // indigena sin sisben
					$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['habitabilidad']['b1'];
				}
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b1']['valor'];	
			
			// SISBEN B2: SISBEN NIVEL 2 
			$arrCalificacion['variables']['b2']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b2']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 2'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b2']['valor'] = $this->arrConstantes['habitabilidad']['b2'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b2']['valor'];
			
			// ETNIAS B3: CUALQUIER MIEMBRO DEL HOGAR CON ETNIA GANA EL PUNTO
			$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ 1 ];
			$arrCalificacion['variables']['b3']['valor'] = 0;
			$bolEtnias = false;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
				if( $this->arrEtnia['tx']['NINGUNA'] != $objCiudadano->seqEtnia ){
					$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ $objCiudadano->seqEtnia ];
					$bolEtnias = true;
					break;						
				}
			}
			if( $bolEtnias ){
				$arrCalificacion['variables']['b3']['valor'] = $this->arrConstantes['habitabilidad']['b3'];
			}			
			$arrCalificacion['total'] += $arrCalificacion['variables']['b3']['valor'];
			
			// CONDICIONES ESPECIALES B4: MONOPARENTAL, DISCAPACITADO, MAYOR DE 65 AÑOS
			$arrCalificacion['variables']['b4']['formulario'] = "Ninguna Condición Especial";
			$arrCalificacion['variables']['b4']['valor'] = 0;
			
			$bolMonoparental = $this->hogarMonoparental( $objFormulario );
			
			$arrCondicionesEspeciales[ 2 ] = $this->arrCondicion['id'][ 2 ]; // Mayor de 65 años
			$arrCondicionesEspeciales[ 3 ] = $this->arrCondicion['id'][ 3 ]; // Discapacitado
			$arrCondicion    = $this->condicionEspecial($objFormulario, $arrCondicionesEspeciales );
			
			if( $bolMonoparental == true or $arrCondicion['cuenta'] == 1 ){
				$arrCalificacion['variables']['b4']['formulario'] = ( $bolMonoparental == true )? "Hogar Monoparental" : $arrCondicion['texto'] ;
				$arrCalificacion['variables']['b4']['valor'] = $this->arrConstantes['habitabilidad']['b4'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b4']['valor'];
		
			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR
			$arrCondicion = $this->condicionEspecial( $objFormulario );
			
			// CONDICIONES ESPECIALES B5: SI EL HOGAR CUMPLE CON MAS DE UNA DE ESTAS CONDICIONES ESPECIALES ES IGUAL A UNO DE LO CONTRARIO CERO
			$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['cuenta'] . " Condiciones especiales";
			$arrCalificacion['variables']['b5']['valor'] = 0;
			if( $arrCondicion['cuenta'] > 1 ){
				$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['texto'];
				$arrCalificacion['variables']['b5']['valor'] = $this->arrConstantes['habitabilidad']['b5'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b5']['valor'];
			
			// HOGARES UBICADOS EN SECTORES CATASTRALES CON MAYOR NUMERO DE FAMILIAS POSTULADAS B6
			$arrCalificacion['variables']['b6']['formulario'] = "0 Hogares Postulados";
			$arrCalificacion['variables']['b6']['valor'] = 0;
			if( isset( $this->arrProyectos[ $objFormulario->seqProyecto ] ) ){
				if( intval( $this->arrProyectos[ $objFormulario->seqProyecto ] ) >= 5 ){
					$arrCalificacion['variables']['b6']['formulario'] = $this->arrProyectos[ $objFormulario->seqProyecto ] . " Hogares Postulados";
					$arrCalificacion['variables']['b6']['valor'] = $this->arrConstantes['habitabilidad']['b6'];
				}	
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b6']['valor'];
			
			return $arrCalificacion;
			
		} // Habitabilidad
		
		/**
		 * CALIFICACION DE LA MODALIDAD DE MEJORAMIENTO ESTRUCTURAL
		 * @author bzerdar
		 * @param FormularioSubsidios objFormulario
		 * @return Array arrCalificacion
		 * @version 1.1 Septiembre de 2009
		 */
		public function mejoramientoestructural( $objFormulario ){
			
			$arrCalificacion['total'] = 0; 
			
			// SISBEN B1: SISBEN NIVEL 1 O ES INDIGENA SIN SISBEN
			$objFormulario->seqSisben = ( $objFormulario->seqSisben == null )? 1 : $objFormulario->seqSisben;
			$arrCalificacion['variables']['b1']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b1']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 1'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['estructural']['b1'];
			} elseif( $this->arrSisben['tx']['NINGUNO'] == $objFormulario->seqSisben ) {
				$bolIndigenas = false;
				foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
					if( $this->arrEtnia['tx']['INDIGENA'] == $objCiudadano->seqEtnia ){
						$bolIndigenas = true;
						break;						
					}
				}
				if( $bolIndigenas ){ // indigena sin sisben
					$arrCalificacion['variables']['b1']['valor'] = $this->arrConstantes['estructural']['b1'];
				}
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b1']['valor'];	
			
			// SISBEN B2: SISBEN NIVEL 2 
			$arrCalificacion['variables']['b2']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b2']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 2'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b2']['valor'] = $this->arrConstantes['estructural']['b2'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b2']['valor'];
			
			// ETNIAS B3: CUALQUIER MIEMBRO DEL HOGAR CON ETNIA GANA EL PUNTO
			$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ 1 ];
			$arrCalificacion['variables']['b3']['valor'] = 0;
			$bolEtnias = false;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
				if( $this->arrEtnia['tx']['NINGUNA'] != $objCiudadano->seqEtnia ){
					$arrCalificacion['variables']['b3']['formulario'] = $this->arrEtnia['id'][ $objCiudadano->seqEtnia ];
					$bolEtnias = true;
					break;						
				}
			}
			if( $bolEtnias ){
				$arrCalificacion['variables']['b3']['valor'] = $this->arrConstantes['estructural']['b3'];
			}			
			$arrCalificacion['total'] += $arrCalificacion['variables']['b3']['valor'];
			
			// CONDICIONES ESPECIALES B4: MONOPARENTAL, DISCAPACITADO, MAYOR DE 65 AÑOS
			$arrCalificacion['variables']['b4']['formulario'] = "Ninguna Condición Especial";
			$arrCalificacion['variables']['b4']['valor'] = 0;
			
			$bolMonoparental = $this->hogarMonoparental( $objFormulario );
			
			$arrCondicionesEspeciales[ 2 ] = $this->arrCondicion['id'][ 2 ]; // Mayor de 65 años
			$arrCondicionesEspeciales[ 3 ] = $this->arrCondicion['id'][ 3 ]; // Discapacitado
			$arrCondicion    = $this->condicionEspecial($objFormulario, $arrCondicionesEspeciales );
			
			if( $bolMonoparental == true or $arrCondicion['cuenta'] == 1 ){
				$arrCalificacion['variables']['b4']['formulario'] = ( $bolMonoparental == true )? "Hogar Monoparental" : $arrCondicion['texto'] ;
				$arrCalificacion['variables']['b4']['valor'] = $this->arrConstantes['estructural']['b4'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b4']['valor'];
		
			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR
			$arrCondicion = $this->condicionEspecial( $objFormulario );
			
			// CONDICIONES ESPECIALES B5: SI EL HOGAR CUMPLE CON MAS DE UNA DE ESTAS CONDICIONES ESPECIALES ES IGUAL A UNO DE LO CONTRARIO CERO
			$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['cuenta'] . " Condiciones especiales";
			$arrCalificacion['variables']['b5']['valor'] = 0;
			if( $arrCondicion['cuenta'] > 1 ){
				$arrCalificacion['variables']['b5']['formulario'] = $arrCondicion['texto'];
				$arrCalificacion['variables']['b5']['valor'] = $this->arrConstantes['estructural']['b5'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b5']['valor'];
			
			// HOGARES UBICADOS EN SECTORES CATASTRALES CON MAYOR NUMERO DE FAMILIAS POSTULADAS B6
			$arrCalificacion['variables']['b6']['formulario'] = "0 Hogares Postulados";
			$arrCalificacion['variables']['b6']['valor'] = 0;
			if( isset( $this->arrProyectos[ $objFormulario->seqProyecto ] ) ){
				if( intval( $this->arrProyectos[ $objFormulario->seqProyecto ] ) >= 5 ){
					$arrCalificacion['variables']['b6']['formulario'] = $this->arrProyectos[ $objFormulario->seqProyecto ] . " Hogares Postulados";
					$arrCalificacion['variables']['b6']['valor'] = $this->arrConstantes['estructural']['b6'];
				}	
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b6']['valor'];
						
			return $arrCalificacion;
			
		} // Estructural
		
		/**
		 * ALMACENA LA CALIFICACION DE LOS FORMULARIOS 
		 * EN LA BASE DE DATOS
		 * @author bzerdar
		 * @param Array arrCalificacion
		 * @return Array arrErrores
		 * @version 1.0 Septiembre 2009
		 */
		public function guardarCalificaciones( $arrTotales , $arrCalificacion ){
			
			global $txtPrefijoRuta, $arrConfiguracion, $aptBd;
			
			$arrMensajes = array();
			
			$txtFechaCalificacion = date( "Y-m-d" );
			
			$txtNombreArchivo = "calificacion" . date( "Ymd" ) . ".xls";
			
			$arrMensajes['mensajes']['nombreArchivo'] = $txtNombreArchivo;
			
			$aptArchivo = fopen( $txtPrefijoRuta . $arrConfiguracion['carpetas']['descargas'] . $txtNombreArchivo , "w" );
			if( $aptArchivo ){
				$txtArchivo = "Formulario\t" .
							  "Modalidad\t". 
							  "TipoDocumento\t" .
							  "Documento\t" .
							  "Nombre\t" .
							  "Puntaje\t" .
							  "B1\tValorB1\t" .
							  "B2\tValorB2\t" .
							  "B3\tValorB3\t" .
							  "B4\tValorB4\t" .
							  "B5\tValorB5\t" .
							  "B6\tValorB6\t" .
							  "B7\tValorB7\t" .
							  "B8\tValorB8\t" .
							  "B9\tValorB9\t" .
							  "B10\tValorB10\r\n";
				
				foreach( $arrTotales as $seqFormulario => $numPuntaje ){
					
					// Linea para el archivo
					$txtArchivo .= $seqFormulario ."\t";
					$txtArchivo .= $arrCalificacion[ $seqFormulario ]['datos']['txtModalidad'] ."\t";
					$txtArchivo .= $arrCalificacion[ $seqFormulario ]['datos']['tpoDocumento']  ."\t";
					$txtArchivo .= $arrCalificacion[ $seqFormulario ]['datos']['numDocumento']  ."\t";
					$txtArchivo .= $arrCalificacion[ $seqFormulario ]['datos']['nomPostulante'] ."\t";
					$txtArchivo .= number_format( $arrCalificacion[ $seqFormulario ]['calificacion']['total'] , 15 , "," , "." ) . "\t";
					foreach( $arrCalificacion[ $seqFormulario ]['calificacion']['variables'] as $arrVariable ){
						unset( $arrVariable['numero'] );
						$arrVariable['valor'] = number_format( $arrVariable['valor'] , 15 , "," , "." );
						$txtArchivo .= implode( "\t" , $arrVariable ) . "\t";					
					}
					$txtArchivo = trim( $txtArchivo , "\t" );
					$txtArchivo.= "\r\n";
					
				}
				
				fwrite( $aptArchivo , utf8_decode( $txtArchivo ) );
				fclose( $aptArchivo );
				
				/**
				 * ALMACENA LAS CALIFICACIONES EN LA BASE DE DATOS
				 */
				
				$sql = "
					DELETE
					FROM T_FRM_CALIFICACION
					WHERE fchCalificacion = '$txtFechaCalificacion'
				";
				$aptBd->execute( $sql );
				
				
				foreach( $arrTotales as $seqFormulario => $numPuntaje ){

					// Insert para la calificacion					
					$sql = "
						INSERT INTO T_FRM_CALIFICACION (
							fchCalificacion,							
							seqFormulario,
							valTotalCalificacion,
							valB1,
							valB2,
							valB3,
							valB4,
							valB5,
							valB6,
							valB7,
							valB8,
							valB9,
							valB10
						) VALUES (		
							\"$txtFechaCalificacion\",							
							$seqFormulario,
							" . $arrCalificacion[ $seqFormulario ][ 'calificacion' ][ 'total' ] . ",
					";	
					
					for( $i = 1 ; $i <= 10 ; $i++ ){
						if( $arrCalificacion[ $seqFormulario ]['calificacion']['variables'][ 'b'.$i ]['valor'] != "" ){
							$sql .= $arrCalificacion[ $seqFormulario ]['calificacion']['variables'][ 'b'.$i ]['valor'] . ","; 
						}else{
							$sql .= "0,";
						}
					}
					$sql = trim( $sql , "," );
					$sql .= ")";
					
					try {
						$aptBd->execute( $sql );
						
					} catch ( Exception $objError ){
						$arrMensajes['error'][] = "Hubo un fallo al salvar la calificacion del formulario $seqFormulario";
					}
					
					try {
						$sql = "
							UPDATE T_FRM_FORMULARIO SET 
								seqEstadoProceso = 9,
								numCortes = ( numCortes + 1 ) 
							WHERE seqFormulario = $seqFormulario
						";
						$aptBd->execute( $sql );
					} catch ( Exception $objError ){
						$arrMensajes['error'][] = "No se pudo actualizar el estado del proceso del formulario $seqFormulario";
					}
					
				}
				 
			}else{
				$arrMensajes['error'][] = "No se pudo abrir el archivo";
			}
			
			return $arrMensajes;
		}
		
		/**
		 * FUNCION QUE DESEMPATA UN GRUPO DE FORMULARIOS
		 * APLICA EL CRITERIO SEGUN CORRESPONDA, EL ORDEN DE LOS CRITERIOS ES:
		 * 1.) NIVEL MAS BAJO DEL SISBEN
		 * 2.) MAYOR NUMERO DE CONDICIONES ESPECIALES
		 * 3.) PERTENENCIA A ETNIAS
		 * 4.) AHORRO PROGRAMADO CON SOCIOS ESTRATEGICOS DE LA SDHT
		 * 5.) CERTIFICADO ELECTORAL
		 * @author bzerdar
		 * @param integer numPuntaje
		 * @param array arrFormulariosEmpatados
		 * @param array arrCriteriosDesempate
		 * @return array arrPuntajesNuevos ==> arrPuntajesNuevos[ seqFormulario ] = numPuntajeNuevo
		 * @version 1.0 Septiembre 2009
		 */
		private function desempatarFormulariosSDV( $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate ){
			
			srand( time() );
			
			$numPuntaje = doubleval( $numPuntaje );
			
			$arrPuntajesNuevos = array();
			foreach( $arrFormulariosEmpatados as $seqFormulario ){
					
				$numPuntajeNuevo = 0;
				
				if( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['sisben'] ) ){ // nivel de sisben
					
//					echo "sisben<br>";
					
					// Formula para calcular el valor del sisben, entre mas bajo el valor es mas alto
					$numPlus = $arrCriteriosDesempate[ $seqFormulario ][ 'sisben' ] * pow( 10000000000 , -1 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['sisben'] = $this->arrCriteriosUsados['sdv']['constantes']['sisben'] +  $numPlus;
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $this->arrPlus[ $seqFormulario ]['sisben'] + $numPuntaje;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['sisben'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['condiciones'] ) ){ // criterio de condiciones especiales
					
//					echo "condiciones<br>";
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
//					$numPuntajeOriginal = $numPuntaje - $this->arrPlus[ $seqFormulario ]['sisben'];
					$numPuntajeOriginal =  $numPuntaje;
					
					// formula para el nuevo puntaje = ( NoCondiciones + 1 ) * 0.0000000001
					$numPlus = ( $arrCriteriosDesempate[ $seqFormulario ][ 'condiciones' ] + 1 ) *  0.0000000001;
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['condiciones'] = $this->arrCriteriosUsados['sdv']['constantes']['condiciones'] +  $numPlus;
					
					// calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['condiciones'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['condiciones'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['etnias'] ) ){ // etnias
					
//					echo "etnias<br>";
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
//					$numPuntajeOriginal = $numPuntaje - $this->arrPlus[ $seqFormulario ]['condiciones'];
					$numPuntajeOriginal =  $numPuntaje;
					
					// si pertenece a etnias suma 0.000001 sino no suma nada
					$numPlus = ( $arrCriteriosDesempate[ $seqFormulario ]['etnias'] == 1 )? 0.0000000001 : 0 ;
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['etnias'] = $this->arrCriteriosUsados['sdv']['constantes']['etnias'] +  $numPlus;
					
					// calcula el nuevo puntaje del hogar					
					$numPuntajeNuevo = 	$this->arrPlus[ $seqFormulario ]['etnias'] + $numPuntajeOriginal;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['etnias'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['socios'] ) ){ // socios estrategicos
					
//					echo "socios<br>";
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
//					$numPuntajeOriginal = $numPuntaje - $this->arrPlus[ $seqFormulario ]['etnias'];
					$numPuntajeOriginal =  $numPuntaje;
				
					// si pertenece a etnias suma 0.000001 sino no suma nada
					$numPlus = ( $arrCriteriosDesempate[ $seqFormulario ]['socios'] == 1 )? 0.0000000001 : 0 ; 
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['socios'] = $this->arrCriteriosUsados['sdv']['constantes']['socios'] +  $numPlus;
					
					// calcula el nuevo puntaje del hogar					
					$numPuntajeNuevo = 	$this->arrPlus[ $seqFormulario ]['socios'] + $numPuntajeOriginal;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['socios'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['certificado'] ) ){ // certificado electoral
					
//					echo "certificado<br>";
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
//					$numPuntajeOriginal = $numPuntaje - $this->arrPlus[ $seqFormulario ]['socios'];
					$numPuntajeOriginal =  $numPuntaje;
					
					// si pertenece a etnias suma 0.000001 sino no suma nada
					$numPlus = ( $arrCriteriosDesempate[ $seqFormulario ]['certificado'] == 1 )? 0.0000000001 : 0 ; 
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['certificado'] = $this->arrCriteriosUsados['sdv']['constantes']['certificado'] +  $numPlus;
					
					// calcula el nuevo puntaje del hogar					
					$numPuntajeNuevo = 	$this->arrPlus[ $seqFormulario ]['certificado'] + $numPuntajeOriginal;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['certificado'][] = $seqFormulario;
					
//				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['sdv']['formularios']['aleatorio'] ) ){ // aleatorio
				} else {
					
//					echo "aleatorio<br>";
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
//					$numPuntajeOriginal = $numPuntaje - $this->arrPlus[ $seqFormulario ]['certificado'];
					$numPuntajeOriginal =  $numPuntaje;
					
					// Numero aleatorio entre 1 y la cantidad de formularios
					$numMaximo = count( $arrFormulariosEmpatados ) * 10;
					$numAleatorio = rand( 1 , $numMaximo ) / 10000000000;
					
					// calcula el nuevo puntaje del hogar					
					$numPuntajeNuevo = $this->arrCriteriosUsados['sdv']['constantes']['aleatorio'] + $numAleatorio + $numPuntajeOriginal;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['sdv']['formularios']['aleatorio'][] = $seqFormulario;
					
				}
				
			} // fin foreach formularios empatados
			
//			pr( $arrPuntajesNuevos );
			
			// Ordena en forma descendente como deben quedar
			arsort( $arrPuntajesNuevos );
			
			return $arrPuntajesNuevos;
		}
	
		/**
		 * CALIFICACION DE HOGARES PARA LA MODALIDAD DE ARRENDAMIENTO
		 * @author Bernardo Zerda
		 * @param FormularioSubsidios objFormulario
		 * @return Array arrCalificacion
		 * @version 1.0 Agosto 2010
		 */
		 public function arrendamiento( $objFormulario ){
		 	
		 	$arrCalificacion = array();
		 	$arrCalificacion['total'] = 0;  

		 	// NUMERO DE MESES PAGANDO ARRIENDO B1: NUMERO DE MESES PAGANDO ARRIENDO
			$numMesesArriendo = 0;
			list( $ano , $mes , $dia ) = split( "-" , $objFormulario->fchArriendoDesde );
			if( @checkdate( $mes , $dia , $ano ) ){
				$numAhora = time();
				$numFecha = strtotime( $objFormulario->fchArriendoDesde );
				if( $numFecha != "" ){
					$numSegundosAhorro = $numAhora - $numFecha;
					$numDiasAhorro     = $numSegundosAhorro / 86400;
					$numMesesArriendo   = $numDiasAhorro / 30;
					$numMesesArriendo   = (  $numMesesArriendo > 60 )? 60 : $numMesesArriendo ;
					$numMesesArriendo   = (  $numMesesArriendo < 0  )? 0  : $numMesesArriendo ;
					$numMesesArriendo   = round( $numMesesArriendo , 4 );
				}
			}
			$arrCalificacion['variables']['b1']['numero'] = $numMesesArriendo;
			$arrCalificacion['variables']['b1']['formulario'] = $objFormulario->fchArriendoDesde . " (" . $numMesesArriendo . " Meses)";
			$arrCalificacion['variables']['b1']['valor'] = round( ( $numMesesArriendo * $this->arrConstantes['arrendamiento']['b1'] ) , 4 );
			$arrCalificacion['total'] += $arrCalificacion['variables']['b1']['valor'];
			
			// NIVEL DEL SISBEN B2, B3 y B4: SISBEN NIVEL 1, NIVEL 2 O NIVEL 3
			$objFormulario->seqSisben  = ( $objFormulario->seqSisben  == null )? 1 : $objFormulario->seqSisben;
			$arrCalificacion['variables']['b2']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b2']['valor'] = 0;
			$arrCalificacion['variables']['b3']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b3']['valor'] = 0;
			$arrCalificacion['variables']['b4']['formulario'] = $this->arrSisben['id'][ $objFormulario->seqSisben ];
			$arrCalificacion['variables']['b4']['valor'] = 0;
			if( $this->arrSisben['tx']['NIVEL 1'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b2']['valor'] = $this->arrConstantes['arrendamiento']['b2'];
			} elseif( $this->arrSisben['tx']['NIVEL 2'] == $objFormulario->seqSisben ) {
				$arrCalificacion['variables']['b3']['valor'] = $this->arrConstantes['arrendamiento']['b3'];
			} elseif( $this->arrSisben['tx']['NIVEL 3'] == $objFormulario->seqSisben ){
				$arrCalificacion['variables']['b4']['valor'] = $this->arrConstantes['arrendamiento']['b4'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b2']['valor'];
			$arrCalificacion['total'] += $arrCalificacion['variables']['b3']['valor'];
			$arrCalificacion['total'] += $arrCalificacion['variables']['b4']['valor'];
			
			// CONDICIONES ESPECIALES DEL HOGAR B5: DESPLAZADO O MONOPARENTAL O DISCAPACITADO O TERCERA EDAD
			if( $objFormulario->bolDesplazado == 1 ){
				$arrCalificacion['variables']['b5']['formulario'] = "Desplazado, ";
				$arrCalificacion['variables']['b5']['valor'] = $this->arrConstantes['arrendamiento']['b5'];	
			} else {
				$arrCalificacion['variables']['b5']['formulario'] = "Independiente, ";
				$arrCalificacion['variables']['b5']['valor'] = 0;
			}
			
			if( $this->hogarMonoparental( $objFormulario ) == true ){
				$arrCalificacion['variables']['b5']['formulario'] .= "Monoparental, ";
				$arrCalificacion['variables']['b5']['valor'] = ( $arrCalificacion['variables']['b5']['valor'] == 0 )? $this->arrConstantes['arrendamiento']['b5'] : $arrCalificacion['variables']['b5']['valor'];
			} else {
				$arrCalificacion['variables']['b5']['formulario'] .= "No Monoparental, ";
			}
			
			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR SOLO DISCAPACITADO O MAYOR DE 65 AÑOS
			$numCondiciones = 0;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				
				$objCiudadano->seqCondicionEspecial  = ( $objCiudadano->seqCondicionEspecial  == null )? 6 : $objCiudadano->seqCondicionEspecial;
				$objCiudadano->seqCondicionEspecial2 = ( $objCiudadano->seqCondicionEspecial2 == null )? 6 : $objCiudadano->seqCondicionEspecial2;
				$objCiudadano->seqCondicionEspecial3 = ( $objCiudadano->seqCondicionEspecial3 == null )? 6 : $objCiudadano->seqCondicionEspecial3;  
				
				if( $this->arrCondicion['tx']['MAYOR DE 65 AñOS'] == $objCiudadano->seqCondicionEspecial 
				 or $this->arrCondicion['tx']['DISCAPACITADO'] == $objCiudadano->seqCondicionEspecial
				){
					$numCondiciones++;
				}
				
				if( $this->arrCondicion['tx']['MAYOR DE 65 AñOS'] == $objCiudadano->seqCondicionEspecial2 
				 or $this->arrCondicion['tx']['DISCAPACITADO'] == $objCiudadano->seqCondicionEspecial2
				){
					$numCondiciones++;
				}
				
				if( $this->arrCondicion['tx']['MAYOR DE 65 AñOS'] == $objCiudadano->seqCondicionEspecial3 
				 or $this->arrCondicion['tx']['DISCAPACITADO'] == $objCiudadano->seqCondicionEspecial3
				){
					$numCondiciones++;
				}
				
			}
			
			if( $numCondiciones > 0 ){
				$arrCalificacion['variables']['b5']['formulario'] .= "Con Condiciones Especiales";
				$arrCalificacion['variables']['b5']['valor'] = ( $arrCalificacion['variables']['b5']['valor'] == 0 )? $this->arrConstantes['arrendamiento']['b5'] : $arrCalificacion['variables']['b5']['valor'];
			}else{
				$arrCalificacion['variables']['b5']['formulario'] .= "Sin Condiciones Especiales";
			}


			// CONTADOR DE CONDICIONES ESPECIALES PARA EL HOGAR
			$numCondiciones = 0; 
			$numTerceraEdad = 0;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				
				$objCiudadano->seqCondicionEspecial  = ( $objCiudadano->seqCondicionEspecial  == null )? 6 : $objCiudadano->seqCondicionEspecial;
				$objCiudadano->seqCondicionEspecial2 = ( $objCiudadano->seqCondicionEspecial2 == null )? 6 : $objCiudadano->seqCondicionEspecial2;
				$objCiudadano->seqCondicionEspecial3 = ( $objCiudadano->seqCondicionEspecial3 == null )? 6 : $objCiudadano->seqCondicionEspecial3;  
				
				if( $this->arrCondicion['tx']['NINGUNO'] != $objCiudadano->seqCondicionEspecial ){
					$numCondiciones++;
				}
				
				if( $this->arrCondicion['tx']['NINGUNO'] != $objCiudadano->seqCondicionEspecial2 ){
					$numCondiciones++;
				}
				
				if( $this->arrCondicion['tx']['NINGUNO'] != $objCiudadano->seqCondicionEspecial3 ){
					$numCondiciones++;
				}
				
				// para contar las condiciones de tercera edad (para desempates)
				if( $objCiudadano->seqCondicionEspecial  == $this->arrCondicion['tx']['MAYOR DE 65 AñOS']
				or  $objCiudadano->seqCondicionEspecial2 == $this->arrCondicion['tx']['MAYOR DE 65 AñOS']
				or  $objCiudadano->seqCondicionEspecial3 == $this->arrCondicion['tx']['MAYOR DE 65 AñOS']
				) {
					$numTerceraEdad++;
				}
				
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b5']['valor'];
			
			// Cantidad de miembros de hogar mayores de edad (tercera edad) para desempates
			$arrCalificacion['extras']['terceraEdad'] = $numTerceraEdad;
			
			// CONDICIONES ESPECIALES B6: SI EL HOGAR CUMPLE CON SOLO UNA DE ESTAS CONDICIONES ESPECIALES ES IGUAL A UNO DE LO CONTRARIO CERO
			$arrCalificacion['variables']['b6']['numero'] = 0;
			$arrCalificacion['variables']['b6']['formulario'] = "$numCondiciones Condiciones especiales";
			$arrCalificacion['variables']['b6']['valor'] = 0;
			if( $numCondiciones > 1 ){
				$arrCalificacion['variables']['b6']['numero'] = $numCondiciones;
				$arrCalificacion['variables']['b6']['formulario'] = "$numCondiciones Condiciones Especiales";
				$arrCalificacion['variables']['b6']['valor'] = $this->arrConstantes['arrendamiento']['b6'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b6']['valor'];

			// ETNIAS B7: CUALQUIER MIEMBRO DEL HOGAR CON ETNIA GANA EL PUNTO
			$arrCalificacion['variables']['b7']['formulario'] = $this->arrEtnia['id'][ 1 ];
			$arrCalificacion['variables']['b7']['valor'] = 0;
			$bolEtnias = false;
			foreach( $objFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
				$objCiudadano->seqEtnia  = ( $objCiudadano->seqEtnia  == null )? 1 : $objCiudadano->seqEtnia;
				if( $this->arrEtnia['tx']['NINGUNA'] != $objCiudadano->seqEtnia ){
					$arrCalificacion['variables']['b7']['formulario'] = $this->arrEtnia['id'][ $objCiudadano->seqEtnia ];
					$bolEtnias = true;
					break;						
				}
			}
			if( $bolEtnias ){
				$arrCalificacion['variables']['b7']['valor'] = $this->arrConstantes['arrendamiento']['b7'];
			}			
			$arrCalificacion['total'] += $arrCalificacion['variables']['b7']['valor'];
			
			// Si no hay fecha de postulacion toma la fecha de hoy
			if( $objFormulario->fchPostulacion != "0000-00-00 00:00:00" and strtotime( $objFormulario->fchPostulacion ) ){
				$numFechaPostulacion = strtotime( $objFormulario->fchPostulacion );
			}else{
				$numFechaPostulacion = time();
			}
			
			// a partir de la fecha de postulacion se restan 14 años como referncia (segun reglamento) 
			$numMayorEdad   = strtotime( "-14 year" , $numFechaPostulacion );
			
			// cuenta los menores de edad del hogar
			$numContadorMenores = 0;
			foreach( $objFormulario->arrCiudadano as $objCiudadano ){
				$numEdad = strtotime( $objCiudadano->fchNacimiento );
				if( $numEdad > $numMayorEdad ){
					$numContadorMenores++;
				}
			}
			
			// NUMERO DE MENORES DE EDAD B8: NUMERO DE MENORES	
			$arrCalificacion['variables']['b8']['numero'] = $numContadorMenores;
			$arrCalificacion['variables']['b8']['formulario'] = $numContadorMenores . " Menores de edad";
			$arrCalificacion['variables']['b8']['valor'] = 0;
			if( $numContadorMenores > 0 ){
				$arrCalificacion['variables']['b8']['valor'] = $this->arrConstantes['arrendamiento']['b8'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b8']['valor'];
			
			// HOGAR HABILITADO NO ASIGNADO B9: HABILITADO NO ASIGNADO
			$arrCalificacion['variables']['b9']['formulario'] = "Ninguna resolucion de no asignado";
			$arrCalificacion['variables']['b9']['valor']      = 0;
			if( $this->hogarNoAsignado( $objFormulario , false ) ){
				$arrCalificacion['variables']['b9']['formulario'] = $this->hogarNoAsignado( $objFormulario , true );	
				$arrCalificacion['variables']['b9']['valor'] = $this->arrConstantes['arrendamiento']['b9'];
			}
			$arrCalificacion['total'] += $arrCalificacion['variables']['b9']['valor'];
					 	
		 	return $arrCalificacion;
		 } // fin calificacion arrendamiento
		 
		 /**
		  * DETECTA SI EL HOGAR ES MONOPARENTAL: ESTO QUIERE DECIR
		  * QUE ES UN HOGAR CON SOLO POSTULANTE PRINCIPAL SIN CONYUGE
		  * @author Bernardo Zerda
		  * @param FormularioSubsidios $objFormulario
		  * @return Boolean $bolMonoparental
		  * @version 1.0 Agosto 2010 
		  */
		 public function hogarMonoparental( $objFormulario ){
				 	
			// Mira dentro del hogar a ver si tiene conyuge
			$bolConyuge = false;
			foreach( $objFormulario->arrCiudadano as $objCiudadano ){
				if( $objCiudadano->seqParentesco == $this->arrParentesco['tx']['CONYUGE O COMPAñERA'] ){
					$bolConyuge = true;
					break;
				}
			}
			
			// si no hay conyuge el hogar es monoparental
			$bolMonoparental = false;
			if( $bolConyuge == false ){
				$bolMonoparental = true; // true
			}
			
			return $bolMonoparental;
		 } // fin hogar monoparental
		 
		 /**
		  * VERIFICA CUANTAS CONDICIONES ESPECIALES TIENE
		  * EL HOGAR Y POR CADA MIEMBRO DEL HOGAR
		  * @param FormularioSubsidios $objFormulario
		  * @param Array $arrCondiciones ==> Arreglo vacio incluye todas las condiciones,
		  * 								 de lo contrario solo tiene en cuenta las condiciones
		  * 								 especiales qe vengan en el arreglo 
		  * @return Array $arrCondicionesEspeciales ==> Resumen de las condiciones especiales del hogar
		  */
		 public function condicionEspecial( $objFormulario , $arrCondiciones = array() ){
		 	
		 	if( empty( $arrCondiciones ) ){
		 		unset( $this->arrCondicion['id'][ 6 ] );  
		 		$arrCondiciones = $this->arrCondicion['id'];
		 	}
		 	
		 	$arrCondicionesEspeciales['cuenta'] = 0;
		 	foreach( $objFormulario->arrCiudadano as $objCiudadano ){
				
		 		$objCiudadano->seqCondicionEspecial  = ( $objCiudadano->seqCondicionEspecial  == null )? 6 : $objCiudadano->seqCondicionEspecial ;
		 		$objCiudadano->seqCondicionEspecial2 = ( $objCiudadano->seqCondicionEspecial2 == null )? 6 : $objCiudadano->seqCondicionEspecial2;
		 		$objCiudadano->seqCondicionEspecial3 = ( $objCiudadano->seqCondicionEspecial3 == null )? 6 : $objCiudadano->seqCondicionEspecial3;
		 		
		 		if( isset( $arrCondiciones[ $objCiudadano->seqCondicionEspecial ] ) ){
					$arrCondicionesEspeciales['texto'] .= $arrCondiciones[ $objCiudadano->seqCondicionEspecial ] . "," ;
					$arrCondicionesEspeciales['cuenta']++;	
				}
				
		 		if( isset( $arrCondiciones[ $objCiudadano->seqCondicionEspecial2 ] ) ){
					$arrCondicionesEspeciales['texto'] .= $arrCondiciones[ $objCiudadano->seqCondicionEspecial2 ] . "," ;
					$arrCondicionesEspeciales['cuenta']++;	
				}
				
		 		if( isset( $arrCondiciones[ $objCiudadano->seqCondicionEspecial3 ] ) ){
					$arrCondicionesEspeciales['texto'] .= $arrCondiciones[ $objCiudadano->seqCondicionEspecial3 ] . "," ;
					$arrCondicionesEspeciales['cuenta']++;	
				}
				
			}
		 	
		 	return $arrCondicionesEspeciales;
		 	
		 } // Condiciones Especiales
		 
		 
		 /**
		  * CUENTA EL NUMERO DE VECES QUE ALGUNO DE LOS 
		  * MIEMBROS DE HOGAR HA ESTADO EN UNA RESOLUCION 
		  * DE ASIGNACION (SALE DE LA ESTRUCTURA DE ACTOS ADMINSITRATIVOS)
		  * @author Bernardo Zerda
		  * @param FormularioSubsidios objformulario
		  * @return Integer numApariciones
		  * @version 1.0 Agosto 2010
		  */
		 public function hogarAsignado( $objFormulario ){
		 	global $aptBd;
		 	
		 	$numApariciones = 0;
		 	foreach( $objFormulario->arrCiudadano as $objCiudadano ){
		 		
		 		$sql = "
		 			SELECT
					  count(1) as cuenta
					FROM
					  T_AAD_CIUDADANO_ACTO CAC,
					  T_AAD_HOGAR_ACTO HAC,
					  T_AAD_FORMULARIO_ACTO FAC,
					  T_AAD_HOGARES_VINCULADOS HVI,
					  T_AAD_ACTO_ADMINISTRATIVO AAD
					WHERE
					  cac.seqCiudadanoActo = hac.seqCiudadanoActo
					 AND hac.seqFormularioActo = fac.seqFormularioActo
					 AND fac.seqFormularioActo = hvi.seqFormularioActo
					 AND hvi.numActo = aad.numActo
					 AND hvi.fchActo = aad.fchActo
					 AND aad.seqTipoActo = 1
					 AND cac.numDocumento = " . $objCiudadano->numDocumento . "
					 AND cac.seqTipoDocumento = " . $objCiudadano->seqTipoDocumento . "
		 		";
		 		$objRes = $aptBd->execute( $sql );
		 		while( $objRes->fields ){
		 			$numApariciones += $objRes->fields['cuenta'];
		 			$objRes->MoveNext();
		 		}  
		 		
		 	}
		 	
		 	return $numApariciones;
		 }

		/**
		 * INICIO DEL PROCESO DE DESEMPATES
		 * @author Bernardo Zerda
		 * @param String txtModalidadDesempate ==> 'arr' para modalidad de arrendamiento 'sdv' para las demas modalidades 
		 * @param integer numPuntaje
		 * @param array arrFormulariosEmpatados
		 * @param array arrCriteriosDesempate
		 * @return array arrPuntajesNuevos ==> arrPuntajesNuevos[ seqFormulario ] = numPuntajeNuevo
		 * @version 1.0 Septiembre 2009
		 */		  
		 public function desempatarFormularios( $txtModalidadDesempate, $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate ){
		 	
		 	$arrPuntajesNuevos = array();
		 	
		 	switch( $txtModalidadDesempate ){
		 		case "sdv":
		 			$arrPuntajesNuevos = $this->desempatarFormulariosSDV( $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate );
		 		break;
		 		case "arr":
		 			$arrPuntajesNuevos = $this->desempatarFormulariosARR( $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate );
		 		break;
		 		default:
		 			$arrPuntajesNuevos = $this->desempatarFormulariosSDV( $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate );
		 		break;
		 	}
		 
		 	return $arrPuntajesNuevos;
		 } // fin desempatar formularios
		 
		/**
		 * FUNCION QUE DESEMPATA UN GRUPO DE FORMULARIOS
		 * APLICA EL CRITERIO SEGUN CORRESPONDA, EL ORDEN DE LOS CRITERIOS ES:
		 * 1.) NIVEL MAS BAJO DEL SISBEN
		 * 2.) MAYOR NUMERO DE MESES PAGANDO ARRIENDO
		 * 3.) CONDICION DE HOGAR MONOPARENTAL (POSTULANTE PRINCIPAL SIN CONYUGE)
		 * 4.) MAYOR NUMERO DE CONDICIONES ESPECIALES
		 * 5.) MAYOR NUMERO DE MENORES DE 14 (VAYA UNO A SABER PORQUE 14 Y NO 18 COMO DEBE SER)
		 * 6.) MAYOR NUMERO DE MAYORES DE 65 AÑOS
		 * 7.) TENER LA CONDICION DE HOGAR ETNICO (CUALQUIER MIEMBRO DEL HOGAR CON ETNIA)
		 * 8.) ESTAR HABILITADO POR LA SDHT Y NO HABER SIDO ASIGNADO
		 * 9.) TENER CERTIFICADO ELECTORAL
		 * @author Bernardo Zerda
		 * @param integer numPuntaje
		 * @param array arrFormulariosEmpatados
		 * @param array arrCriteriosDesempate
		 * @return array arrPuntajesNuevos ==> arrPuntajesNuevos[ seqFormulario ] = numPuntajeNuevo
		 * @version 1.0 Septiembre 2009
		 */
		 private function desempatarFormulariosARR( $numPuntaje , $arrFormulariosEmpatados , $arrCriteriosDesempate ){

			srand( time() );
			
		 	$arrPuntajesNuevos = array();

			// para cada formulario en empate se aplican los valores de desempate para cada criterio
			foreach( $arrFormulariosEmpatados as $seqFormulario ){
				
				$numPuntajeNuevo = 0;
					
				if( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['sisben'] ) ){ // nivel de sisben
					
					// Formula para calcular el valor del sisben, entre mas bajo el valor es mas alto
					if( $arrCriteriosDesempate[ $seqFormulario ][ 'sisben' ] != 0 ){
						$numPlus = round( ( 1 / ( $arrCriteriosDesempate[ $seqFormulario ][ 'sisben' ] * 100000000 ) ) , 10 );
					}else{
						$numPlus = 0; 	
					}
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['sisben'] = $this->arrCriteriosUsados['arr']['constantes']['sisben'] +  $numPlus;
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $this->arrPlus[ $seqFormulario ]['sisben'] + $numPuntaje;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['sisben'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['mesesArriendo'] ) ){ // meses pagando arriendo
						
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['sisben'] , 2 );
					
					// Entre mas meses mas vale el plus
					$numPlus = round( ( $arrCriteriosDesempate[ $seqFormulario ]['mesesArriendo'] / 1000000000 ) , 10 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['mesesArriendo'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['mesesArriendo'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['mesesArriendo'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['mesesArriendo'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['monoparental'] ) ){ // condicion de hogar monoparental
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['mesesArriendo'] , 2 );
					
					// Si tiene condicion de monoparental suma
					if( $arrCriteriosDesempate[ $seqFormulario ]['monoparental'] == true ){
						$numPlus = round( ( 1 / 1000000000 ) , 10 );
					}else{
						$numPlus = 0;
					}
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['monoparental'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['monoparental'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['monoparental'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['monoparental'][] = $seqFormulario;
					
				} elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['condiciones'] ) ){ // cantidad de condiciones especiales
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['monoparental'] , 2 );
					
					// Entre mas condiciones especiales mas vale el plus
					$numPlus = round( ( $arrCriteriosDesempate[ $seqFormulario ]['condiciones'] / 1000000000 ) , 10 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['condiciones'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['condiciones'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['condiciones'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['condiciones'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['menores'] ) ){ // menores de 14
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['condiciones'] , 2 );
					
					// Entre mas menores de 14 mas vale el plus
					$numPlus = round( ( $arrCriteriosDesempate[ $seqFormulario ]['menores'] / 1000000000 ) , 10 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['menores'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['menores'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['menores'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['menores'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['terceraEdad'] ) ){ // mayores de 65
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['menores'] , 2 );
					
					// Entre mas mayores de 65 mas vale el plus
					$numPlus = round( ( $arrCriteriosDesempate[ $seqFormulario ]['terceraEdad'] / 1000000000 ) , 10 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['terceraEdad'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['terceraEdad'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['terceraEdad'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['terceraEdad'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['etnias'] ) ){ // hogar etnico
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['terceraEdad'] , 2 );
					
					// Si es hogar etnico suma
					if( $arrCriteriosDesempate[ $seqFormulario ]['etnias'] == true ){
						$numPlus = round( ( 1 / 1000000000 ) , 10 );
					}else{
						$numPlus = 0;
					}
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['etnias'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['etnias'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['etnias'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['etnias'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['desplazado'] ) ){ // condicion de hogar desplazado
				
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['etnias'] , 2 );
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['desplazado'] = $this->arrCriteriosUsados['arr']['constantes']['desplazado'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['desplazado'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['desplazado'][] = $seqFormulario;
				
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['asignado'] ) ){ // hogar habilitado y no asignado
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['desplazado'] , 2 );
					
					// Si es hogar no asignado suma
					if( $arrCriteriosDesempate[ $seqFormulario ]['asignado'] == 0 ){
						$numPlus = round( ( 1 / 1000000000 ) , 10 );
					}else{
						$numPlus = 0;
					}
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['asignado'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['asignado'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['asignado'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['asignado'][] = $seqFormulario;
					
				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['certificado'] ) ){ // certificado electoral
					
					// Restaura el puntaje al original
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['asignado'] , 2 );
					
					// Si es hogar tiene certificado suma
					if( $arrCriteriosDesempate[ $seqFormulario ]['certificado'] == 1 ){
						$numPlus = round( ( 1 / 1000000000 ) , 10 );
					}else{
						$numPlus = 0;
					}
					
					// Recuerda el plus que se ha adicionado
					$this->arrPlus[ $seqFormulario ]['certificado'] = $numPlus + $this->arrCriteriosUsados['arr']['constantes']['certificado'];
					
					// Calcula el nuevo puntaje del hogar
					$numPuntajeNuevo = $numPuntajeOriginal + $this->arrPlus[ $seqFormulario ]['certificado'];
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['certificado'][] = $seqFormulario;
					
//				}elseif( ! in_array( $seqFormulario , $this->arrCriteriosUsados['arr']['formularios']['aleatorio'] ) ){ // aleatorio
				} else {
					
					// Restaura el puntaje original para no acumular puntajes en los criterios
					$numPuntajeOriginal = round( $numPuntaje - $this->arrPlus[ $seqFormulario ]['certificado'] , 2 );
						
					// Numero aleatorio entre 1 y la cantidad de formularios
					$numMaximo = count( $arrFormulariosEmpatados ) * 100;
					$numAleatorio = round( rand( 1 , $numMaximo ) / 1000000000 , 10 );
					
					// calcula el nuevo puntaje del hogar					
					$numPuntajeNuevo = $this->arrCriteriosUsados['arr']['constantes']['aleatorio'] + $numAleatorio + $numPuntajeOriginal;
					
					// Se agrega el nuevo puntaje
					$arrPuntajesNuevos[ $seqFormulario ] = $numPuntajeNuevo;
					
					// Se marcan los formularios para saber que ya se les aplico este criterio
					$this->arrCriteriosUsados['arr']['formularios']['aleatorio'][] = $seqFormulario;
					
				}
				
			}
		 	
		 	// Ordena en forma descendente como deben quedar
			arsort( $arrPuntajesNuevos );
		 	
		 	return $arrPuntajesNuevos;
		 } // fin desempatar formularios modalidad de arrendamiento
		 
		/**
		  * DETERMINA SI EL ULTIMO ACTO ADMINISTRATIVO
		  * EN EL QUE HA PARTICIPADO UN HOGAR ES UN ACTO 
		  * ADMINISTRATIVO DE NO ASIGNACION
		  * @author Bernardo Zerda
		  * @param FormularioSubsidios objformulario
		  * @return Integer numApariciones
		  * @version 1.0 Agosto 2010
		  */
		 
		 public function hogarNoAsignado( $objFormulario , $bolTexto ){
		 	global $aptBd;
		 	
		 	$bolNoAsignado = false;
		 	$txtNoAsignado = "";
		 	
		 	foreach( $objFormulario->arrCiudadano as $objCiudadano ){
		 	
			 	$sql = "
		 			SELECT
					  aad.seqTipoActo,
		              aad.numActo,
		              aad.fchActo,
					  tac.txtNombreTipoActo
					FROM
					  T_AAD_CIUDADANO_ACTO CAC,
					  T_AAD_HOGAR_ACTO HAC,
					  T_AAD_FORMULARIO_ACTO FAC,
					  T_AAD_HOGARES_VINCULADOS HVI,
					  T_AAD_ACTO_ADMINISTRATIVO AAD,
            		  T_AAD_TIPO_ACTO tac
					WHERE
					  cac.seqCiudadanoActo = hac.seqCiudadanoActo
					 AND hac.seqFormularioActo = fac.seqFormularioActo
					 AND fac.seqFormularioActo = hvi.seqFormularioActo
					 AND hvi.numActo = aad.numActo
					 AND hvi.fchActo = aad.fchActo
					 AND aad.seqTipoActo = tac.seqTipoActo
					 AND cac.numDocumento = " . $objCiudadano->numDocumento . "
					 AND cac.seqTipoDocumento = " . $objCiudadano->seqTipoDocumento . "
		           AND aad.fchActo = (
						SELECT
			    		  MAX(aad.fchActo)
						FROM
						  T_AAD_CIUDADANO_ACTO CAC,
						  T_AAD_HOGAR_ACTO HAC,
						  T_AAD_FORMULARIO_ACTO FAC,
						  T_AAD_HOGARES_VINCULADOS HVI,
						  T_AAD_ACTO_ADMINISTRATIVO AAD
						WHERE
						  cac.seqCiudadanoActo = hac.seqCiudadanoActo
						 AND hac.seqFormularioActo = fac.seqFormularioActo
						 AND fac.seqFormularioActo = hvi.seqFormularioActo
						 AND hvi.numActo = aad.numActo
						 AND hvi.fchActo = aad.fchActo
						 AND cac.numDocumento = " . $objCiudadano->numDocumento . "
						 AND cac.seqTipoDocumento = " . $objCiudadano->seqTipoDocumento . "
					)
				";
				
				$objRes = $aptBd->execute( $sql );
		 		while( $objRes->fields ){
		 			if( $objRes->fields['seqTipoActo'] == 5 ){
		 				$bolNoAsignado = true;
		 				$txtNoAsignado = $objRes->fields['txtNombreTipoActo'] . " " . $objRes->fields['numActo'] . " del " . $objRes->fields['fchActo'];  
		 			}
		 			$objRes->MoveNext();
		 		}
		 		
		 	}	
		 	
		 	if( $bolTexto == true ){
		 		return $txtNoAsignado;
		 	} else {
		 		return $bolNoAsignado;
		 	}
		 }
		 
		 
		 
		
		
		
	} // Fin Clase
	
?>