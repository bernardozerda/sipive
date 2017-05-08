<?php

	/**
	 * CLASE PARA MANIPULAR LOS CONTACTOS
	 * DEL BANCO DE VIVIENDA
	 * @author bernardo zerda
	 * @version 1.0 Doc 2010
	 */

	class Generales {
		
		public $arrEstadoProceso;
		public $arrLocalidades;
		public $arrTipoDocumento;
		public $arrTipoInmueble;
		public $arrErrores;
		
		function Generales(){
			
			$this->estadosProceso();
			$this->localidades();
			$this->tipoDocumento();
			$this->tipoInmueble();
			
			if( ! empty( $this->arrErrores ) ){
				pr( $this->arrErrores );
			}
		}
		
		/**
		 * OBTIENE LOS ESTADOS DEL PROCESO
		 * @access private
		 * @author bernardo zerda
		 * @param Void
		 * @return Void
		 */		
		 
		private function estadosProceso(){
			global $aptBd;
			$sql = "
				SELECT 
					seqEstadoProceso,
					txtEstadoProceso
				FROM T_BVU_ESTADO_PROCESO
				ORDER BY seqEstadoProceso
			";
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$this->arrEstadoProceso[ $objRes->fields['seqEstadoProceso'] ] = $objRes->fields['txtEstadoProceso']; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				$this->arrErrores[] = "No se pudo acceder a los estados del proceso";
			}	
		}
		
		/**
		 * OBTIENE OBTIENE LAS LOCALIDADES
		 * @access private
		 * @author bernardo zerda
		 * @param Void
		 * @return Void
		 */
		 
		private function localidades(){
			global $aptBd;
			$sql = "
				SELECT seqLocalidad, SUBSTRING( txtLocalidad , LOCATE('-' , txtLocalidad ) + 2 ) as txtLocalidad
				FROM T_FRM_LOCALIDAD
				ORDER BY txtLocalidad
			";
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$this->arrLocalidades[ $objRes->fields['seqLocalidad'] ] = $objRes->fields['txtLocalidad']; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				$this->arrErrores[] = "No se pudo acceder a las localidades";
			}	
		}
		
		/**
		 * OBTIENE LOS TIPOS DE DOCUMENTO PARA 
		 * EL BANCO DE VIVIENDA. SOLO OBTIENE
		 * CEDULA DE CIUDADANIA, CEDULA DE EXTRANGERIA
		 * Y NIT
		 * @access private
		 * @author bernardo zerda
		 * @param Void
		 * @return Void
		 */
		
		private function tipoDocumento(){
			global $aptBd;
			$sql = "
				SELECT seqTipoDocumento, txtTipoDocumento
				FROM T_CIU_TIPO_DOCUMENTO
				WHERE seqTipoDocumento IN (1,2,6)
				ORDER BY txtTipoDocumento
			";
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$this->arrTipoDocumento[ $objRes->fields['seqTipoDocumento'] ] = $objRes->fields['txtTipoDocumento']; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				$this->arrErrores[] = "No se pudo acceder a los tipos de documento";
			}	
		}		
		
		/**
		 * OBTIENE LOS TIPOS DE INMUEBLE PARA 
		 * EL BANCO DE VIVIENDA
		 * @access private
		 * @author bernardo zerda
		 * @param Void
		 * @return Void
		 */
		
		private function tipoInmueble(){
			global $aptBd;
			$sql = "
				SELECT seqTipoInmueble, txtTipoInmueble
				FROM T_BVU_TIPO_INMUEBLE
				ORDER BY txtTipoInmueble
			";
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$this->arrTipoInmueble[ $objRes->fields['seqTipoInmueble'] ] = $objRes->fields['txtTipoInmueble']; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				$this->arrErrores[] = "No se pudo acceder a los tipos de inmueble";
			}	
		}		
		
		
	} // fin clase

// -------------------------------------------------------------------

	/**
	 * CLASE PARA MANIPULAR LOS DATOS DE LAS VIVIENDAS
	 * DEL BANCO DE VIVIENDA ( LAS IMAGENES NO SE MANIPULAN )
	 * @author bernardo zerda
	 * @version 1.0 Doc 2010
	 */
	 
	class Inmueble {
		
	    function Inmueble() {
	    	
	    } // fin Constructor
	    
	    /**
	     * OBTIENE LOS REGISTROS DEL BANCO DE VIVIENDA
	     * @author bernardo zerda
	     * @param integer seqEstadoProceso
	     * @param date fchDesde
	     * @param date fchHasta
	     * @param boolean bolCondiciones ==> Si esta en true es proque se quieren incluir todos los registros
	     * 									 incluso los que no cumplen las condiciones basicas
	     * @return array arrViviendas
	     */
	     
	    public function obtenerViviendas( $seqEstadoProceso , $fchDesde , $fchHasta , $bolCondiciones ){
	    	global $aptBd;
	    	$arrViviendas = array();
	    	
	    	$txtCondicion = ( intval( $seqEstadoProceso ) == 0 )? "" : " AND inm.seqEstadoProceso = $seqEstadoProceso ";
	    	$txtCondicion.= ( trim( $fchDesde ) == "" )? "" : " AND inm.fchCreacion >= '$fchDesde 00:00:00' ";
	    	$txtCondicion.= ( trim( $fchHasta ) == "" )? "" : " AND inm.fchCreacion <= '$fchHasta 23:59:59' "; 
	    	
	    	if( $bolCondiciones == true ){
	    		$txtCondicion.= "
					AND inm.numBanos > 0 
					AND lower(inm.txtCocina) = 'si'
					AND lower(inm.txtLavanderia) = 'si'
					AND lower(inm.txtAgua) <> 'no existe'
					AND lower(inm.txtEnergia) <> 'no existe'
					AND lower(inm.txtEspacioMultiple) = 'si'
				";
	    	}
	    	
	    	$sql = "
				SELECT 
				    UPPER( CONCAT( con.txtNombre1 , ' ' , con.txtNombre2 , ' ' , con.txtApellido1 , ' ' , con.txtApellido2 ) ) as NombreContacto,
				    tdo.txtTipoDocumento as TipoDocumentoContacto,
				    con.numDocumento,
				    con.numTelefono1,
				    con.numTelefono2,
				    con.numCelular,
				    con.txtCorreo,				
					inm.seqInmueble as idVivienda,
					epr.txtEstadoProceso as EstadoProceso,
					tin.txtTipoInmueble as TipoInmueble,
					SUBSTRING( loc.txtLocalidad , LOCATE('-' , loc.txtLocalidad ) + 2 ) as Localidad,
					inm.txtDireccionInmueble as DireccionVivienda,
					inm.txtDireccionInmueble as DireccionViviendaTexto,
					inm.txtBarrio as Barrio,
					inm.txtMatriculaInmobiliaria as MatriculaInmobiliaria,
					inm.txtChip as CHIP,
					inm.numPisos as Niveles,
					inm.numPiso as Piso,
					inm.numHabitaciones as Habitaciones,
					inm.numBanos as Banos,
					inm.numAreaConstruida as AreaConstruida,
					inm.numAreaLote	as AreaLote,
					inm.numEstrato as Estrato,
					inm.valOferta as ValorVenta,
					UPPER(inm.txtEspacioMultiple) as EspacioMultiple,
					UPPER(inm.txtCocina) as Cocina,
					UPPER(inm.txtLavanderia) as Lavanderia,
					UPPER(inm.txtAgua) as ServicioAgua,
					UPPER(inm.txtEnergia) as ServicioEnergia,
					UPPER(inm.txtGas) as ServicioGas,
					UPPER(inm.txtTelefono) as ServicioTelefono,
					UPPER(inm.txtInstalacionCocina) as InstalacionCocina,
					UPPER(inm.txtInstalacionCalentador) as InstalacionCalentador,
					UPPER(inm.numGarajes) as Garajes,
					UPPER(inm.txtVista) as Visa,
					UPPER(inm.txtHabitacionServicio) as HabitacionServicio,
					UPPER(inm.txtBanoServicio) as BanoServicio,
					UPPER(inm.txtPisoCocina) as PisoCocina,
					UPPER(inm.txtPisoHabitaciones) as PisoHabitaciones,
					UPPER(inm.txtPisoComedor) as PisoComedor,
					UPPER(inm.txtPisoSala) as PisoSala,
					inm.fchCreacion as CreacionRegistro,
					inm.fchActualizacion as ActualizacionRegistro,
					UPPER(pre.txtBarrioLegalizado) as BarrioLegalizado,
					UPPER(pre.txtReservaVial) as ReservaVial,
					UPPER(pre.txtZonaRiesgo) as ZonaRiezgo,
					UPPER(pre.txtZonaProteccionAmbiental) as ZonaProteccionAmbiental,
					UPPER(pre.txtRemocionMasa) as RemocionMasa,
					IF( inm.bolvendido = 1 , 'Si' , 'No' ) as InmuebleVendido, 
					pre.fchViabilizacion as FechaViabilizacion,
					pre.fchRevision as RechaRevision
				FROM T_BVU_INMUEBLE inm
				INNER JOIN T_BVU_CONTACTO con ON inm.seqContacto = con.seqContacto
				INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON con.seqTipoDocumento = tdo.seqTipoDocumento
				INNER JOIN T_BVU_ESTADO_PROCESO epr ON inm.seqEstadoProceso = epr.seqEstadoProceso
				INNER JOIN T_BVU_TIPO_INMUEBLE tin ON inm.seqTipoInmueble = tin.seqTipoInmueble
				INNER JOIN T_FRM_LOCALIDAD loc ON inm.seqLocalidad = loc.seqLocalidad
				LEFT JOIN T_BVU_PREVIABILIZADO pre ON pre.seqInmueble = inm.seqInmueble	    	
				WHERE 1=1 $txtCondicion
				
			"; // and txtDireccionInmueble = 'CL 7A S 2 80 IN 1 AP 102'
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$seqInmueble = $objRes->fields['idVivienda'];
					foreach( $objRes->fields as $txtClave => $txtValor ){
						$arrViviendas[ $seqInmueble ][ $txtClave ] = utf8_decode( $txtValor );
					}
					$arrViviendas[ $seqInmueble ]['DireccionViviendaTexto'] = strtoupper( $this->cunu2texto( $arrViviendas[ $seqInmueble ]['DireccionVivienda'] ) );
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ){
				$this->arrErrores[] = "No se ha podido importar las viviendas";
			}
	    	return $arrViviendas;
	    } // fin obtener viviendas
	    
	    public function salvarPreviabilizacion( $arrArchivo ){
	    	global $aptBd;
	    	$fchHoy = date( "Y-m-d H:i:s" );
	    	foreach( $arrArchivo as $numLinea => $arrDatos ){
	    		$sql = "
	    			UPDATE T_BVU_INMUEBLE SET
	    				seqEstadoProceso = " . $arrDatos[ 1 ] . ",
	    				txtMatriculaInmobiliaria = \"" . $arrDatos[ 2 ] . "\",
						txtChip = \"" . $arrDatos[ 3 ] . "\"
					WHERE seqInmueble = " . $arrDatos[ 0 ] . "
	    		";
	    		try {
	    			$aptBd->execute( $sql );
	    			$sql = "
	    				SELECT COUNT(1) as cuenta
	    				FROM T_BVU_PREVIABILIZADO
	    				WHERE seqInmueble = " . $arrDatos[ 0 ] . "
	    			";
	    			$objRes = $aptBd->execute( $sql );
	    			if( $objRes->fields['cuenta'] > 0 ){
	    				$sql = "
	    					UPDATE T_BVU_PREVIABILIZADO SET
								txtBarrioLegalizado = \"" . $arrDatos[ 4 ] . "\",
								txtReservaVial = \"" . $arrDatos[ 5 ] . "\",
								txtZonaRiesgo = \"" . $arrDatos[ 6 ] . "\",
								txtZonaProteccionAmbiental = \"" . $arrDatos[ 7 ] . "\",
								txtRemocionMasa = \"" . $arrDatos[ 8 ] . "\",
								fchRevision = \"$fchHoy\"
	    					WHERE seqInmueble = " . $arrDatos[ 0 ] . "
	    				";
	    				try {
	    					$aptBd->execute( $sql );
	    				} catch ( Exception $objError ){
	    					$this->arrErrores[] = "No se pudo actualizar la previabilizacion de la vivienda de la linea " . ( $numLinea + 1 ); 
	    				}
	    			} else {
	    				$sql = "
	    					INSERT INTO T_BVU_PREVIABILIZADO (
								seqInmueble,
								txtBarrioLegalizado,
								txtReservaVial,
								txtZonaRiesgo,
								txtZonaProteccionAmbiental,
								txtRemocionMasa,
								fchviabilizacion,
								fchRevision
							) VALUES (
								\"" . $arrDatos[ 0 ] . "\",
								\"" . $arrDatos[ 4 ] . "\",
								\"" . $arrDatos[ 5 ] . "\",
								\"" . $arrDatos[ 6 ] . "\",
								\"" . $arrDatos[ 7 ] . "\",
								\"" . $arrDatos[ 8 ] . "\",
								\"$fchHoy\",
								\"$fchHoy\"
							)
	    				";
	    				try {
	    					$aptBd->execute( $sql );
	    				} catch ( Exception $objError ){
	    					$this->arrErrores[] = "No se pudo crear la previabilizacion de la vivienda de la linea " . ( $numLinea + 1 );
	    				}
	    			}
	    		} catch ( Exception $objError ){
	    			$this->arrErrores[] = "No se pudieron actualizar los datos de la vivienda de la linea " . ( $numLinea + 1 );
	    		}
	    	}
	    } // fin salvar previabilizacion
	    
	    /**
	     * TRADUCCION DEL FORMATO CUNU EN UNA DIRECCION LEGIBLE
	     * @author Bernardo Zerda Rodriguez
	     * @param String $txtDireccionCUNU
	     */
		function cunu2texto( $txtDireccionCUNU ){
			global $txtPrefijoRuta;
			$arrCaracteres = array();
			$arrPosiciones = array();
			
			include( $txtPrefijoRuta . "../bvu/librerias/funciones/datosComunesCUNU.php" );
			
			$txtEdicionRural  = "";
			$arrEdicionUrbana = array();
			$numPosicion = 0;
			foreach( $arrCaracteres as $txtClave => $numCaracteres ){
				$txtPosicion = substr( $txtDireccionCUNU , $numPosicion , $numCaracteres );
				$arrEdicionUrbana[ $txtClave ] = trim( ereg_replace( "#" , " " , $txtPosicion ) );
				$numPosicion += $numCaracteres;
			}
			
			if( ! isset( $arrPosiciones['viaPrincipal'][ trim( $arrEdicionUrbana['viaPrincipal'] ) ] ) ){
				$arrEdicionUrbana = array();
				$txtEdicionRural = $txtDireccionCUNU;
			}
			
			unset( $arrEdicionUrbana['municipio'] );
			if( $arrEdicionUrbana['cuadranteViaPrincipal'] != "" ){
				$txtCuadrante = trim( strtoupper( $arrEdicionUrbana['cuadranteViaPrincipal'] ) );
				$arrEdicionUrbana['cuadranteViaPrincipal'] = $arrCuadrante[ $txtCuadrante ];
			}

			if( $arrEdicionUrbana['cuadranteViaGeneradora'] != "" ){
				$txtCuadrante = trim( strtoupper( $arrEdicionUrbana['cuadranteViaGeneradora'] ) );
				$arrEdicionUrbana['cuadranteViaGeneradora'] = $arrCuadrante[ $txtCuadrante ];
			}
			
			$arrEdicionUrbana['numeroViaPrincipal'] = $arrEdicionUrbana['numeroViaPrincipal'] . $arrEdicionUrbana['letraViaPrincipal'];
			unset( $arrEdicionUrbana['letraViaPrincipal'] );
			
			
			$arrEdicionUrbana['numeroViaGeneradora'] = $arrEdicionUrbana['numeroViaGeneradora'] . $arrEdicionUrbana['letraViaGeneradora'];
			unset( $arrEdicionUrbana['letraViaGeneradora'] );
			
			$txtDireccion = "";
			if( $txtEdicionRural == "" ){
				$txtDireccion = implode( " " , $arrEdicionUrbana );
				while( strpos( $txtDireccion , "  " ) !== false ){
					$txtDireccion = ereg_replace( "  " , " " , $txtDireccion );
				} 
			} else {
				$txtDireccion = $txtEdicionRural;
			}
			
			return $txtDireccion;	
		}
	    
	    /**
	     * VERIFICA LA EXISTENCIA DE UN INMUEBLE POR SU ID
	     */
	    public function inmuebleExiste( $seqInmueble ){
	    	global $aptBd;
	    	
	    	$sql = "
	    		SELECT COUNT(seqInmueble) as cuenta
	    		FROM T_BVU_INMUEBLE
	    		WHERE seqInmueble = $seqInmueble
	    	";
	    	$objRes = $aptBd->execute( $sql );
	    	if( $objRes->fields['cuenta'] > 0 ){
	    		return true;
	    	} else {
	    		return false;
	    	}
	    	
	    }
		
		
	} // fin clase inmueble

// -------------------------------------------------------------------

	/**
	 * CLASE PARA MANIPULAR LOS CONTACTOS
	 * DEL BANCO DE VIVIENDA
	 * @author bernardo zerda
	 * @version 1.0 Doc 2010
	 */

	class Contacto {
		
		function Contacto() {
			
		} // fin constructor
		
	} // fin clase contacto 

?>