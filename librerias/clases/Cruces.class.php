<?php

	/**
	 * CLASE PARA LA MANIPULACION DE LOS CRUCES
	 * @author Bernardo Zerda
	 * @version 1.0 Marzo 2017
	 */
	
	class Cruces {
	
		public $seqCruce; 
		public $txtNombre; 
		public $fchCruce; 
		public $txtCuerpo; 
		public $txtPie; 
		public $txtFirma; 
		public $txtElaboro; 
		public $txtReviso; 
		public $fchCreacionCruce; 
		public $txtUsuario; 
		public $txtNombreArchivo; 
		public $seqUsuario; 
		public $txtUsuarioActualiza; 
		public $txtNombreArchivoActualiza; 
		public $seqUsuarioActualiza;
		public $arrHogares;

		public $numPaginador; // Cuantos registros por pagina
		public $numPaginas; // cuantas paginas por bloque

		private $arrEstados;
		private $arrFormatoArchivo;

		/**
		 * CONSTRUCTOR DE LA CLASE, SE COLCOAN LOS PARAMETROS
		 * GENERALES COMO REGLAS DE ENTRADA Y SALIDA PARA LOS CRUCES
		 * Y FORMATO DEL ARCHIVO DE CARGA, APARTE DE INICIALIZAR LOS DATOS
		 * DE LA CLASE
		 * @author Bernardo Zerda
		 * @param void
		 * @return boolean
		 * @version 1.0 Mar 2017
		 */
		
		function Cruces(){
		
			// Inicializa las variables
			$this->seqCruce = 0;
			$this->txtNombre = "";
			$this->fchCruce = NULL;
			$this->txtCuerpo = "";
			$this->txtPie = "";
			$this->txtFirma = "";
			$this->txtElaboro = "";
			$this->txtReviso = "";
			$this->fchCreacionCruce = NULL;
			$this->txtUsuario = "";
			$this->txtNombreArchivo = "";
			$this->seqUsuario = 0;
			$this->txtUsuarioActualiza = "";
			$this->txtNombreArchivoActualiza = "";
			$this->seqUsuarioActualiza = 0;
			$this->arrHogares = array();
			$this->numPaginas = 10;
			$this->numPaginador = 20;

			// Formato de carga del archivo
			$this->arrFormatoArchivo[] = "seqformulario";
			$this->arrFormatoArchivo[] = "postulante principal";
			$this->arrFormatoArchivo[] = "modalidad";
			$this->arrFormatoArchivo[] = "estado";
			$this->arrFormatoArchivo[] = "tipo documento";
			$this->arrFormatoArchivo[] = "documento";
			$this->arrFormatoArchivo[] = "nombre";
			$this->arrFormatoArchivo[] = "parentesco";
			$this->arrFormatoArchivo[] = "entidad";
			$this->arrFormatoArchivo[] = "causa";
			$this->arrFormatoArchivo[] = "detalle";
			$this->arrFormatoArchivo[] = "inhabilitar";
			$this->arrFormatoArchivo[] = "observaciones";
			
			// Carga los estados del proceso
			$this->arrEstados = estadosProceso();
			
			return true;	
		}
		
		/**
		 * OBTIENE LOS DATOS BASICOS DEL CRUCE
		 * @author Bernardo Zerda
		 * @version 1.0 mar 2017
		 * @param string txtCruce
		 * @return array $arrCruces
		 */
		
		public function listarCruces($txtCruce="",$txtColumnaOrden="",$txtDireccionOrden=""){
			global $aptBd;
			$arrCruces = array();
			$txtCondicion = ($txtCruce == "")? "" : "WHERE cru.txtNombre like '%" . $txtCruce. "%'";

			switch($txtColumnaOrden){
				case "nombre":
					$txtColumnaOrden = "cru.txtNombre";
					break;
				case "fecha":
                    $txtColumnaOrden = "cru.fchCreacionCruce";
					break;
				default:
                    $txtColumnaOrden = "cru.fchCreacionCruce";
					break;
			}

            switch($txtDireccionOrden){
                case "asc":
                    $txtDireccionOrden = "ASC";
                    break;
                case "desc":
                    $txtDireccionOrden = "DESC";
                    break;
                default:
                    $txtDireccionOrden = "DESC";
                    break;
            }

			$sql = "
				SELECT 
					cru.seqCruce,
					cru.txtNombre,
					cru.fchCruce,
					cru.txtCuerpo,
					cru.txtPie,
					cru.txtFirma,
					cru.txtElaboro,
					cru.txtReviso,
					cru.fchCreacionCruce,
					cru.txtUsuario,
					cru.txtNombreArchivo,
					cru.seqUsuario,
					cru.txtUsuarioActualiza,
					cru.txtNombreArchivoActualiza,
					cru.seqUsuarioActualiza
				FROM T_CRU_CRUCES cru
				" . $txtCondicion . "
				ORDER BY " . $txtColumnaOrden . " " . $txtDireccionOrden . "
			";
			$objRes = $aptBd->execute($sql);
			while( $objRes->fields ){
				$seqCruce = $objRes->fields['seqCruce'];
				$arrCruces[$seqCruce] = $objRes->fields;
				$objRes->MoveNext();
			}
			return $arrCruces;	
		}		
		
		/**
		 * VALIDACION DE LA PLANTILLA DE CARGA DE CRUCES, SOLO VALIDA LA LINEA DE TITULOS
		 * @author Bernardo Zerda
		 * @version 1.0 mar 2017
		 * @param array arrLineaTitulos
		 * @return array $arrErrores
		 */
		public function validarPlantillaCarga( $arrLineaTitulos = array() ){
			$arrErrores = array();
			if( empty( $arrLineaTitulos )){
				$arrErrores[] = "No hay datos para validar";
			}else{				
				for( $i = 0 ; $i < count( $arrLineaTitulos ) ; $i++ ){
					if( trim( strtolower( $arrLineaTitulos[$i] ) ) != $this->arrFormatoArchivo[$i]  ){
						$arrErrores[] = "Error Linea 1 Columna " . ($i + 1) . ": No existe la columna " . ucwords( $this->arrFormatoArchivo[$i]) . " o no está en la posición correcta";
					}
				}
			}
			return $arrErrores;
		}
		
		/**
		 * VALIDACION DE LAS LINEAS DEL ARCHIVO
		 * @author Bernardo Zerda
		 * @version 1.0 mar 2017
		 * @param array arrLineaTitulos
		 * @return array $arrErrores
		 */
		public function validarLineaArchivo( $arrLinea, $numLinea){
			
			// Limpia y codifica cada uno de los campos
			foreach ($arrLinea as $txtClave => $txtValor) {
				$arrLinea[$txtClave] = trim($txtValor);
			}
			
			/**
			 * VALIDACION DE COHERENCIA DE LOS DATOS
			 */
			
			// Validacion del seqFormulario
			$seqFormulario = 0;
			if( is_numeric( $arrLinea[0] ) ){
				$seqFormulario = intval($arrLinea[0]);
			}else{
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[0] ) . ": Introduzca solo números";
			}
			
			// Validacion del postulante principal
			$numDocumentoPPal = 0;
			if( is_numeric( $arrLinea[1] ) ){
				$numDocumentoPPal = intval($arrLinea[1]);
			}else{
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[1] ) . ": Introduzca solo números";
			}
			
			// Validacion de la modalidad
			$seqModalidad = obtenerSecuencial($arrLinea[2], "T_FRM_MODALIDAD", "txtModalidad", "seqModalidad");
			if( $seqModalidad == 0 ){
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[2] ) . ": Valor no válido o no existe";
			}
			
			// Valida estados del proceso
			$seqEstadoProceso = 0;
			if( in_array( $arrLinea[3] , $this->arrEstados) ){
				$seqEstadoProceso = array_keys($this->arrEstados,$arrLinea[3]);
			}else{
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[3] ) . ": Valor no válido o no existe";
			}
			
			// Validacion del tipo de documento
			$seqTipoDocumento = obtenerSecuencial($arrLinea[4], "T_CIU_TIPO_DOCUMENTO", "txtTipoDocumento", "seqTipoDocumento");
			if( $seqTipoDocumento == 0 ){
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[4] ) . ": Valor no válido o no existe";
			}
						
			// Validacion del documento
			$numDocumento = 0;
			if( is_numeric( $arrLinea[5] ) ){
                $numDocumento = intval($arrLinea[5]);
			}else{
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[5] ) . ": Introduzca solo números";
			}
			
			// Validacion del nombre
			$txtNombre = "";
			if( trim( $arrLinea[6]) != ""){
				$txtNombre = $arrLinea[6];
			}else{
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[6] ) . ": No puede dejar vacía esta columna";
			}
			
			// Validacion del parentesco
			$seqParentesco = obtenerSecuencial($arrLinea[7], "T_CIU_PARENTESCO", "txtParentesco", "seqParentesco");
			if( $seqParentesco == 0 ){
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[7] ) . ": Valor no válido o no existe";
			}
			
			// son opcionales la entidad, causa y detalle
			$txtEntidad = trim( $arrLinea[8] );
			$txtCausa   = trim( $arrLinea[9] );
			$txtDetalle = trim( $arrLinea[10] );
			
			// Validacion de inhabilitar
			if( ! ( trim( strtolower( $arrLinea[11] ) ) == 'si' or trim( strtolower( $arrLinea[11] ) ) == 'no' ) ) {
				$arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[11] ) . ": Valor no válido, solo puede indicar Si o No";
			}
			
			// la observacion es opcional
			$txtObservaciones = trim( $arrLinea[12]); 
			
			/**
			 * VALIDACION DE REGLAS DE NEGOCIO
			 */

            $claFormulario = new FormularioSubsidios();

			if( empty($arrErrores) ) {

                // Valida la existencia del formulario
                $txtError = $claFormulario->formularioExiste($seqFormulario);
                if ($txtError !== true) {
                    $arrErrores[] = "Error Linea " . $numLinea . " Columna " . ucwords($this->arrFormatoArchivo[0]) . " " . $txtError;
                }
            }

            if( empty($arrErrores) ) {

				// coincide el formulario con el postulante principal
				$claFormulario->cargarFormulario($seqFormulario);
				foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
					if( $objCiudadano->seqParentesco == 1 ){
						break;
					}
				}

				// validacion del postulante principal
				if( $numDocumentoPPal != $objCiudadano->numDocumento ){
                    $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[1] ) . " El documento de postulante principal no es el que figura en el formulario";
				}

				// validacion de la modalidad
                if( $seqModalidad != $claFormulario->seqModalidad ){
                    $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[2] ) . " La modalidad no coindice con la del formulario";
				}

                // estado del proceso
                if( $seqEstadoProceso != $claFormulario->seqEstadoProceso ){
                    $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[3] ) . " El estado del proceso no coincide con el del formulario";
                }

                // validacion del documento del ciudadano
                $seqFormularioCiudadano = $claFormulario->formularioVinculado2($numDocumento, $seqTipoDocumento);
                if( $seqFormulario !=  $seqFormularioCiudadano ){
                    $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[4] ) . " El ciudadano " . $numDocumento . " pertenece a un hogar diferente al del postulante principal referenciado o no existe";
				}

				// validando nombres y parentescos del ciudadano
                foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                    if( $numDocumento == $objCiudadano->numDocumento ){
                    	if( $seqParentesco != $objCiudadano->seqParentesco ){
                            $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[4] ) . " El ciudadano " . $numDocumento . " tiene un parentesco diferente en la base de datos";
						}
                        if( $txtNombre != trim($objCiudadano->obtenerNombre($numDocumento)) ){
                            $arrErrores[] = "Error Linea " . $numLinea ." Columna " . ucwords( $this->arrFormatoArchivo[4] ) . " El ciudadano " . $numDocumento . " tiene otro nombre en la base de datos";
                        }
					}
                }
			}

			return $arrErrores;	
		}
		
		/**
		 * CARGA UN CRUCE SELECCIONADO POR EL USUARIO
         * @author Bernardo Zerda
         * @version 1.1 Jul 2017
		 */

		public function leerCruce(){
			global $aptBd;

            $arrEstados = estadosProceso();

            $sql = "
				SELECT
					cru.seqCruce,
					cru.txtNombre,
					cru.fchCruce,
					cru.txtCuerpo,
					cru.txtPie,
					cru.txtFirma,
					cru.txtElaboro,
					cru.txtReviso,
					cru.fchCreacionCruce,
					cru.txtUsuario,
					cru.txtNombreArchivo,
					cru.seqUsuario,
					cru.txtUsuarioActualiza,
					cru.txtNombreArchivoActualiza,
					cru.seqUsuarioActualiza
				FROM T_CRU_CRUCES cru
				WHERE cru.seqCruce = '" . $this->seqCruce . "'
			";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->fields ){
            	foreach($objRes->fields as $txtCampo => $txtValor){
            		$this->$txtCampo = regularizarCampo( $txtCampo , $txtValor );
				}

                $sql = "
					SELECT DISTINCT
					   cru.seqFormulario,
					   cru.numDocumento,
					   cru.txtNombre,
					   ( 
						  SELECT SUM(cru1.bolInhabilitar) 
						  FROM T_CRU_RESULTADO cru1 
						  WHERE cru1.seqCruce = cru.seqCruce
						  AND cru1.seqFormulario = cru.seqFormulario
					   ) AS bolInhabilitar,
					   frm.seqEstadoProceso
					FROM T_CRU_RESULTADO cru
					INNER JOIN T_FRM_FORMULARIO frm ON cru.seqFormulario = frm.seqFormulario
					WHERE cru.seqCruce = " . $this->seqCruce . "
					  AND cru.seqParentesco = 1
					ORDER BY cru.numDocumento
				";
				$objRes = $aptBd->execute( $sql );
                while( $objRes->fields ){
                    $seqEstadoProceso = $objRes->fields['seqEstadoProceso'];
                    $seqFormulario = $objRes->fields['seqFormulario'];
                    $this->arrHogares[ $seqFormulario ]['bolInhabilitar']     = ( $objRes->fields['bolInhabilitar'] > 0 )? 1 : 0;
                    $this->arrHogares[ $seqFormulario ]['numDocumento'] = $objRes->fields['numDocumento'];
                    $this->arrHogares[ $seqFormulario ]['txtNombre']    = $objRes->fields['txtNombre'];
                    $this->arrHogares[ $seqFormulario ]['txtEstado']    = $arrEstados[ $seqEstadoProceso ];
                    $objRes->MoveNext();
                }
            }
			return true;
		}

		
	}

?>
