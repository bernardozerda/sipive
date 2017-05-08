<?php

	/**
	 * CLASE QUE REALIZA TODAS LAS OPERACIONES DE SEGUIMIENTO
	 * @author bzerdar
	 * @version 1.0 Septiembre 2009
	 */

	class SeguimientoProyectos {

		public $seqSeguimiento;
		public $seqGrupoGestion;
		public $seqGestion;
		public $fchInicial;
		public $fchFinal;
		public $txtComentario;
		public $bolCambios;
		public $txtCriterio;
		public $seqProyecto;
		public $arrErrores;

		private $arrConversionCampos;
		private $arrIgnorarCampos;
		private $txtSeparador;
		private $txtSalto;

		function SeguimientoProyectos() {

			$this->txtSeparador = "\t";
			$this->txtSalto	 = "\n";

			$this->txtSeparador = str_repeat( "&nbsp;" , 5 );
			$this->txtSalto	 = "<br>";

			$this->seqSeguimiento = 0;
			$this->seqGrupoGestion = 0;
			$this->seqGestion = 0;
			$this->fchInicial = null;
			$this->fchFinal = null;
			$this->txtComentario = "";
			$this->txtCambios = null;
			$this->txtCriterio = null;
			$this->seqProyecto = 0;
			$this->arrErrores = array();

			// CONVERSION DE LOS CAMPOS DEL PROYECTO
			$this->arrConversionCampos['txtNombreProyecto']['nombre'] 					= "Nombre del Proyecto";
			$this->arrConversionCampos['txtNombreProyecto']['tabla'] 					= "";
			$this->arrConversionCampos['txtNombrePlanParcial']['nombre'] 				= "Nombre del Plan Parcial";
			$this->arrConversionCampos['txtNombrePlanParcial']['tabla'] 				= "";
			$this->arrConversionCampos['seqTipoEsquema']['nombre'] 						= "Tipo de Esquema";
			$this->arrConversionCampos['seqTipoEsquema']['tabla'] 						= "T_PRY_TIPO_ESQUEMA";
			$this->arrConversionCampos['seqPryTipoModalidad']['nombre'] 				= "Tipo de Modalidad";
			$this->arrConversionCampos['seqPryTipoModalidad']['tabla'] 					= "T_PRY_TIPO_MODALIDAD";
			$this->arrConversionCampos['seqOpv']['nombre'] 								= "OPV";
			$this->arrConversionCampos['seqOpv']['tabla'] 								= "T_PRY_OPV";
			$this->arrConversionCampos['seqTipoProyecto']['nombre'] 					= "Tipo de Proyecto";
			$this->arrConversionCampos['seqTipoProyecto']['tabla'] 						= "T_PRY_TIPO_PROYECTO";
			$this->arrConversionCampos['seqTipoUrbanizacion']['nombre'] 				= "Tipo de Urbanización";
			$this->arrConversionCampos['seqTipoUrbanizacion']['tabla'] 					= "T_PRY_TIPO_URBANIZACION";
			$this->arrConversionCampos['seqTipoSolucion']['nombre'] 					= "Tipo de Solución";
			$this->arrConversionCampos['seqTipoSolucion']['tabla'] 						= "T_PRY_TIPO_SOLUCION";
			$this->arrConversionCampos['txtDescripcionProyecto']['nombre'] 				= "Descripción del Proyecto";
			$this->arrConversionCampos['txtDescripcionProyecto']['tabla'] 				= "";
			$this->arrConversionCampos['seqLocalidad']['nombre'] 						= "Localidad";
			$this->arrConversionCampos['seqLocalidad']['tabla'] 						= "T_FRM_LOCALIDAD";
			$this->arrConversionCampos['txtDireccion']['nombre'] 						= "Dirección";
			$this->arrConversionCampos['txtDireccion']['tabla'] 						= "";
			$this->arrConversionCampos['valNumeroSoluciones']['nombre'] 				= "Número de Soluciones";
			$this->arrConversionCampos['valNumeroSoluciones']['tabla'] 					= "";
			$this->arrConversionCampos['valAreaConstruida']['nombre'] 					= "Area Construída";
			$this->arrConversionCampos['valAreaConstruida']['tabla'] 					= "";
			$this->arrConversionCampos['valAreaLote']['nombre'] 						= "Area Lote";
			$this->arrConversionCampos['valAreaLote']['tabla'] 							= "";
			$this->arrConversionCampos['valCostoProyecto']['nombre'] 					= "Costo de Proyecto";
			$this->arrConversionCampos['valCostoProyecto']['tabla'] 					= "";
			$this->arrConversionCampos['txtChipLote']['nombre'] 						= "Chip Lote";
			$this->arrConversionCampos['txtChipLote']['tabla'] 							= "";
			$this->arrConversionCampos['txtRegistroEnajenacion']['nombre'] 				= "Registro de Enajenación";
			$this->arrConversionCampos['txtRegistroEnajenacion']['tabla'] 				= "";
			$this->arrConversionCampos['txtDescEquipamientoComunal']['nombre'] 			= "Descripción del Equipamiento Comunal";
			$this->arrConversionCampos['txtDescEquipamientoComunal']['tabla'] 			= "";

			// CONVERSION DE LOS CAMPOS DEL OFERENTE
			$this->arrConversionCampos['seqOferente']['nombre'] 						= "Oferente";
			$this->arrConversionCampos['seqOferente']['tabla'] 							= "T_PRY_OFERENTE";
			$this->arrConversionCampos['seqConstructor']['nombre'] 						= "Constructor";
			$this->arrConversionCampos['seqConstructor']['tabla'] 						= "T_PRY_CONSTRUCTOR";

			// LICENCIA DE URBANISMO
			$this->arrConversionCampos['txtLicenciaUrbanismo']['nombre'] 				= "Licencia de Urbanismo";
			$this->arrConversionCampos['txtLicenciaUrbanismo']['tabla'] 				= "";
			$this->arrConversionCampos['txtExpideLicenciaUrbanismo']['nombre'] 			= "Entidad que Expide la Licencia de Urbanismo";
			$this->arrConversionCampos['txtExpideLicenciaUrbanismo']['tabla'] 			= "";
			$this->arrConversionCampos['fchLicenciaUrbanismo1']['nombre'] 				= "Fecha de Licencia de Urbanismo";
			$this->arrConversionCampos['fchLicenciaUrbanismo1']['tabla'] 				= "";
			$this->arrConversionCampos['fchVigenciaLicenciaUrbanismo']['nombre'] 		= "Vigencia de Licencia de Urbanismo";
			$this->arrConversionCampos['fchVigenciaLicenciaUrbanismo']['tabla'] 		= "";
			$this->arrConversionCampos['fchEjecutoriaLicenciaUrbanismo']['nombre'] 		= "Fecha Ejecutoria de Licencia de Urbanismo";
			$this->arrConversionCampos['fchEjecutoriaLicenciaUrbanismo']['tabla'] 		= "";
			$this->arrConversionCampos['txtResEjecutoriaLicenciaUrbanismo']['nombre']	= "Resolución Ejecutoria de Licencia de Urbanismo";
			$this->arrConversionCampos['txtResEjecutoriaLicenciaUrbanismo']['tabla']	= "";

			// LICENCIA DE CONSTRUCCION
			$this->arrConversionCampos['txtLicenciaConstruccion']['nombre'] 			= "Licencia de Construcción";
			$this->arrConversionCampos['txtLicenciaConstruccion']['tabla'] 				= "";
			$this->arrConversionCampos['fchLicenciaConstruccion1']['nombre'] 			= "Fecha de Licencia de Construcción";
			$this->arrConversionCampos['fchLicenciaConstruccion1']['tabla'] 			= "";
			$this->arrConversionCampos['fchVigenciaLicenciaConstruccion']['nombre'] 	= "Vigencia de Licencia de Construcción";
			$this->arrConversionCampos['fchVigenciaLicenciaConstruccion']['tabla'] 		= "";

			// DATOS DEL INTERVENTOR
			$this->arrConversionCampos['txtNombreInterventor']['nombre'] 				= "Nombre del Interventor";
			$this->arrConversionCampos['txtNombreInterventor']['tabla'] 				= "";
			$this->arrConversionCampos['bolTipoPersonaInterventor']['nombre'] 			= "Tipo de Persona Interventor";
			$this->arrConversionCampos['bolTipoPersonaInterventor']['tabla'] 			= "";
			$this->arrConversionCampos['numNitInterventor']['nombre'] 					= "Nit del Interventor";
			$this->arrConversionCampos['numNitInterventor']['tabla'] 					= "";
			$this->arrConversionCampos['numCedulaInterventor']['nombre'] 				= "Cédula del Interventor";
			$this->arrConversionCampos['numCedulaInterventor']['tabla'] 				= "";
			$this->arrConversionCampos['numTProfesionalInterventor']['nombre'] 			= "Tarjeta Profesional del Interventor";
			$this->arrConversionCampos['numTProfesionalInterventor']['tabla'] 			= "";

			// CAMPOS QUE NO SE MOSTRARAN POR AHROA
			$this->arrIgnorarCampos[] = "";
			$this->arrIgnorarCampos[] = "arrErrores";

			$this->arrTipoDato['txtNombreProyecto'] 				= "texto";
			$this->arrTipoDato['txtNombrePlanParcial'] 				= "texto";
			$this->arrTipoDato['seqTipoEsquema'] 					= "numero";
			$this->arrTipoDato['seqPryTipoModalidad'] 				= "numero";
			$this->arrTipoDato['seqOpv'] 							= "numero";
			$this->arrTipoDato['seqTipoProyecto'] 					= "numero";
			$this->arrTipoDato['seqTipoUrbanizacion'] 				= "numero";
			$this->arrTipoDato['seqTipoSolucion'] 					= "numero";
			$this->arrTipoDato['txtDescripcionProyecto'] 			= "texto";
			$this->arrTipoDato['seqLocalidad'] 						= "numero";
			$this->arrTipoDato['txtDireccion'] 						= "texto";
			$this->arrTipoDato['valNumeroSoluciones'] 				= "numero";
			$this->arrTipoDato['valAreaConstruida'] 				= "numero";
			$this->arrTipoDato['valAreaLote'] 						= "numero";
			$this->arrTipoDato['valCostoProyecto'] 					= "numero";
			$this->arrTipoDato['txtChipLote'] 						= "texto";
			$this->arrTipoDato['txtRegistroEnajenacion'] 			= "texto";
			$this->arrTipoDato['txtDescEquipamientoComunal'] 		= "texto";
			$this->arrTipoDato['txtNombreOferente']					= "texto";
			$this->arrTipoDato['seqConstructor'] 					= "numero";
			$this->arrTipoDato['txtLicenciaUrbanismo'] 				= "texto";
			$this->arrTipoDato['txtExpideLicenciaUrbanismo'] 		= "texto";
			$this->arrTipoDato['fchLicenciaUrbanismo1'] 			= "fechahora";
			$this->arrTipoDato['fchVigenciaLicenciaUrbanismo'] 		= "fechahora";
			$this->arrTipoDato['fchEjecutoriaLicenciaUrbanismo'] 	= "fechahora";
			$this->arrTipoDato['txtResEjecutoriaLicenciaUrbanismo'] = "texto";
			$this->arrTipoDato['txtLicenciaConstruccion'] 			= "texto";
			$this->arrTipoDato['fchLicenciaConstruccion1'] 			= "fechahora";
			$this->arrTipoDato['fchVigenciaLicenciaConstruccion'] 	= "fechahora";
			$this->arrTipoDato['txtNombreInterventor'] 				= "texto";
			$this->arrTipoDato['bolTipoPersonaInterventor'] 		= "booleano";
			$this->arrTipoDato['numNitInterventor'] 				= "numero";
			$this->arrTipoDato['numCedulaInterventor'] 				= "numero";
			$this->arrTipoDato['numTProfesionalInterventor'] 		= "numero";
		} // fin constructor

		function obtenerRegistros( $numLimite = 0 , $numInicia = 0 ){

			global $aptBd;

			$arrRegistros = array();

			$txtCondicion = ( $this->seqSeguimiento != 0 )? "AND seg.seqSeguimiento = " . $this->seqSeguimiento . " " : "" ;
			$txtCondicion.= ( $this->seqGrupoGestion != 0 )? "AND gge.seqGrupoGestion = " . $this->seqGrupoGestion . " " : "" ;
			$txtCondicion.= ( $this->seqGestion != 0 )? "AND ges.seqGestion = " . $this->seqGestion . " " : "" ;
			$txtCondicion.= ( $this->fchInicial != "" )? "AND seg.fchMovimiento >= '" . $this->fchInicial . " 00:00:00' " : "" ;
			$txtCondicion.= ( $this->fchFinal != "" )? "AND seg.fchMovimiento <= '" . $this->fchFinal . " 23:59:59' " : "" ;

			if( trim( $this->txtComentario ) != "" ){
				switch( $this->txtCriterio ){
					case "inicia":
						$txtCondicion .= "AND seg.txtComentario LIKE '" . $this->txtComentario . "%' ";
					break;
					case "termina":
						$txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "' ";
					break;
					case "contiene":
						$txtCondicion .= "AND seg.txtComentario LIKE '%" . $this->txtComentario . "%' ";
					break;
					default:
						$txtCondicion .= "AND seg.txtComentario = '" . $this->txtComentario . "' ";
					break;
				}
			}
			if( $this->txtCambios != "" ){
				switch( $this->txtCambios ){
					case "si":
						$txtCondicion .= "AND seg.txtCambios <> ''";
					break;
					case "no":
						$txtCondicion .= "AND seg.txtCambios = ''";
					break;
					case "ambos":
						$txtCondicion .= "";
					break;
					default:
						$txtCondicion .= "";
					break;
				}
			}

			$txtCondicion .= "AND seg.seqProyecto = " . $this->seqProyecto . " ";

			$txtLimite = "";
			if( $numLimite != 0 ){
				$txtLimite .= "LIMIT ";
				if( $numInicia != 0 ){
					$txtLimite .= "$numInicia , $numLimite";
				}else{
					$txtLimite .= "$numLimite";
				}
			}

			$sql = "
				SELECT 
					seg.seqSeguimiento,
					seg.seqProyecto,
					seg.fchMovimiento,
					ucwords(gge.txtGrupoGestion) as txtGrupoGestion,
					ucwords(ges.txtGestion) as txtGestion,
					ucwords( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as txtUsuario,
					seg.txtComentario as txtComentario,
					seg.txtCambios
				FROM 
					T_SEG_SEGUIMIENTO_PROYECTOS seg,
					T_SEG_GESTION_PROYECTOS ges,
					T_SEG_GRUPO_GESTION_PROYECTOS gge,
					T_COR_USUARIO usu
				WHERE seg.seqGestion = ges.seqGestion
				AND ges.seqGrupoGestion = gge.seqGrupoGestion
				AND seg.seqUsuario = usu.seqUsuario
				AND seg.bolMostrar = 1
				$txtCondicion
				ORDER BY seg.seqSeguimiento DESC
				$txtLimite
			";

			try {
				$objRes = $aptBd->execute( $sql );					   
				while( $objRes->fields ){
					$seqSeguimiento = $objRes->fields['seqSeguimiento'];
					unset( $objRes->fields['seqSeguimiento'] );
					$arrRegistros[ $seqSeguimiento ] = $objRes->fields;
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ){
				$this->arrErrores[] = "No se han podido consultar los movimientos del proyecto, hubo un error al consultar los datos";
			}

			return $arrRegistros;
		}

		function parserTextoCambios( $txtTextoCambio ){

			// se reemplaza el tabulador por los espacios
			$txtTabulador = str_repeat(  "&nbsp;" , 5 );

			// Salto de linea sobrante
			$txtTextoCambio = trim( $txtTextoCambio , "\n" );

			// Separacion por lineas
			$arrLineas = split( "\n" , $txtTextoCambio );

			// Separacion campo - valores
			foreach( $arrLineas as $numLinea => $txtLinea ){
				$arrLinea = split( "," , $txtLinea );
				$arrLineas[ $numLinea ] = array();
				if( count( $arrLinea ) == 1 ){
					$arrLineas[ $numLinea ][ 0 ] = "<b>" . ereg_replace( "\t" , $txtTabulador , $txtLinea ) . "</b>";
				}else{
					foreach( $arrLinea as $numOtraLinea => $txtValor ){
						if( $numOtraLinea == 0 ){
							$txtCampo = trim( $txtValor );
							$txtCampo = ereg_replace( $txtTabulador, "" , $txtCampo ); 
							if( ! in_array( $txtCampo , $this->arrIgnorarCampos ) ){
								if( isset( $this->arrConversionCampos[ $txtCampo ] ) ){
									$txtTexto = $this->arrConversionCampos[ $txtCampo ]['nombre'];  
								}else{
									$txtTexto = $txtCampo;
								}
								if( strpos( $txtValor , "\t" ) === false ){
									$arrLinea[ $numOtraLinea ] = "<b>" . $txtTexto . "</b>";
								}else{
									$numOcurrencias = strcount( "\t" , $txtValor );
									$arrLinea[ $numOtraLinea ] = "<b>" . str_repeat( $txtTabulador , $numOcurrencias ) . $txtTexto . "</b>";
								}
							}else{
								$arrLinea = array();
							}
						}else{
							if( ! in_array( $txtCampo , $this->arrIgnorarCampos ) ){
								$arrTraducir = split( ":" , $txtValor );
								foreach( $arrTraducir as $numPosicion => $txtTraducir ){
									$arrTraducir[ $numPosicion ] = trim( $txtTraducir );
								}
								if( count( $arrTraducir ) > 2 ){
									for( $i = 2 ; $i < count( $arrTraducir ); $i++ ){
										$arrTraducir[ 1 ] .= ":" . $arrTraducir[ $i ];
										unset( $arrTraducir[ $i ] );
									}
								}
								if( isset( $this->arrConversionCampos[ $txtCampo ] ) ){
									$txtTabla = $this->arrConversionCampos[ $txtCampo ]['tabla'];
									$txtValor = obtenerNombres( $txtTabla , $txtCampo , $arrTraducir[ 1 ] );
								}else{
									$txtValor = $arrTraducir[ 1 ];
								}

								$arrLinea[ $numOtraLinea ] = $txtValor."&nbsp;";

							} else {
								$arrLinea = array();
							}
						}
					}
					if( ! empty( $arrLinea ) ){
						$arrLineas[ $numLinea ] = $arrLinea;
					}else{
						unset( $arrLineas[ $numLinea ] );
					}
				}
			} 
			return $arrLineas;
		}

		/**
		 * MIRA LOS CAMBIOS EN EL FORMULARIO DE PROYECTO DE POSTULACION / INSCRIPCION
		 */
		public function cambiosPostulacion( $seqProyecto , $objAnterior , $objNuevo ){
			//pr ($objAnterior);
			//pr ($objNuevo);
			//public function cambiosPostulacion( $seqProyecto ){

			$txtSeparador = $this->txtSeparador;
			$txtSalto	 = $this->txtSalto;

			// Cambios en el formulario

			$txtCambios .= "<b>[ " . $seqProyecto . " ] Cambios en el Proyecto</b>" . $txtSalto ;

			if( is_object( $objNuevo ) ){
				foreach( $objNuevo as $txtClave => $txtValorNuevo ){
					if( ! in_array( $txtClave , $this->arrIgnorarCampos ) ){
						$txtValorAnterior = $objAnterior->$txtClave;
						//echo "TXTVALORANTERIOR: ".$txtValorAnterior."\t";
						//echo "TXTVALORNUEVO: ".$txtValorNuevo."<BR>";
						$txtCambios .= $this->compararValores( $txtClave, $txtValorAnterior , $txtValorNuevo , 1 );
					}
				}
			}

			return $txtCambios;
		}

		/**
		 * COMPARACION DE VALORES
		 */
		 
		private function compararValores( $txtClave , $txtValorAnterior , $txtValorNuevo , $numSeparadores = 0 ){

			$txtSeparador = str_repeat( $this->txtSeparador , $numSeparadores );
			$txtSalto	 = $this->txtSalto;
			$txtCambios = "";

			switch( $this->arrTipoDato[ $txtClave ] ){
				case "numero":
					$txtValorAnterior = ( is_numeric( $txtValorAnterior ) )? $txtValorAnterior : 0 ;
					$txtValorNuevo	= ( is_numeric( $txtValorNuevo ) )?	$txtValorNuevo	: 0 ;
					if( $txtValorAnterior != $txtValorNuevo ){
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					} 
				break;
				case "texto":
					$txtValorAnterior = strtolower( trim( $txtValorAnterior ) );
					$txtValorNuevo	= strtolower( trim( $txtValorNuevo ) );
					if( $txtValorAnterior != $txtValorNuevo ){
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					}
				break;
				case "fecha":

					$txtValorAnterior = ( $txtValorAnterior == "0000-00-00" )? null : $txtValorAnterior;
					$txtValorNuevo	= ( $txtValorNuevo == "0000-00-00" )?	null : $txtValorNuevo;

					list( $ano , $mes , $dia ) = split( "[/-]" , $txtValorAnterior );
					if( @checkdate( $mes , $dia , $ano ) === false ){
						$txtValorAnterior = 0;
					}else{
						$txtValorAnterior = strtotime( $txtValorAnterior );
					}

					list( $ano , $mes , $dia ) = split( "[/-]" , $txtValorNuevo );
					if( @checkdate( $mes , $dia , $ano ) === false ){
						$txtValorNuevo = 0;
					}else{
						$txtValorNuevo = strtotime( $txtValorNuevo );
					}

					if( $txtValorAnterior != $txtValorNuevo ){
						if( $txtValorAnterior == 0 ){
							$txtValorAnterior = "Ninguno";
						}else{
							$txtValorAnterior = date( "Y-m-d" , $txtValorAnterior );
						}
						if( $txtValorNuevo == 0 ){
							$txtValorNuevo = "Ninguno";
						}else{
							$txtValorNuevo = date( "Y-m-d" , $txtValorNuevo );
						}
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					}

				break;
				case "fechahora":

					if( strtotime( $txtValorAnterior ) !== false ){
						$txtValorAnterior = strtotime( $txtValorAnterior );
					}else{
						$txtValorAnterior = 0;
					}

					if( strtotime( $txtValorNuevo ) !== false ){
						$txtValorNuevo = strtotime( $txtValorNuevo );
					}else{
						$txtValorNuevo = 0;
					}

					if( $txtValorAnterior != $txtValorNuevo ){
						if( $txtValorAnterior == 0 ){
							$txtValorAnterior = "Ninguno";
						}else{
							$txtValorAnterior = date( "Y-m-d H:i:s" , $txtValorAnterior );
						}
						if( $txtValorNuevo == 0 ){
							$txtValorNuevo = "Ninguno";
						}else{
							$txtValorNuevo = date( "Y-m-d H:i:s" , $txtValorNuevo );
						}
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					}

				break;
				case "booleano":
					$txtValorAnterior = ( $txtValorAnterior == 1 )? "Si" : "No";
					$txtValorNuevo	= ( $txtValorNuevo == 1	)? "Si" : "No";
					if( $txtValorAnterior != $txtValorNuevo ){
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					}
				break;
				default:
					$txtValorAnterior = strtolower( trim( $txtValorAnterior ) );
					$txtValorNuevo	= strtolower( trim( $txtValorNuevo ) );
					if( $txtValorAnterior != $txtValorNuevo ){
						$txtCambios .= $txtSeparador . $txtClave . ", Valor Anterior: $txtValorAnterior, Valor Nuevo: $txtValorNuevo" . $txtSalto;
					}
				break;
			}
			return $txtCambios;

		} // fin comparar valores

		/**
		 * CAMBIOS PARA TODAS LAS FASES DE DESEMBOLSOS
		 */
		public function cambiosDesembolso( $txtFase , $objAnterior , $arrNuevo ){

			switch( $txtFase ){
				case "busquedaOferta":	  $txtCambios = $this->cambiosDesembolsoBusqueda( $objAnterior , $arrNuevo );  break;
				case "revisionJuridica":	$txtCambios = $this->cambiosRevisionJuridica( $objAnterior , $arrNuevo );	break;
				case "revisionTecnica":	 $txtCambios = $this->cambiosRevisionTecnica( $objAnterior , $arrNuevo );	 break;
				case "escrituracion": 		$txtCambios = $this->cambiosDesembolsoBusqueda( $objAnterior , $arrNuevo );  break;
				case "estudioTitulos": 		$txtCambios = $this->cambiosEstudioTitulos( $objAnterior , $arrNuevo );	  break;
				case "solicitudDesembolso": $txtCambios = $this->cambiosSolicitudDesembolso( $objAnterior , $arrNuevo ); break;
				case "Consignaciones":		$txtCambios = $this->cambiosConsignaciones( $objAnterior , $arrNuevo );		 break;
			}

			return $txtCambios;
		} // fin cambios desembolso

		public function eliminarSolicitud( $seqFormulario , $seqSolicitud , $fchSolicitud ){
			$txtCambios = "<b>[ $seqFormulario ] Datos del Formulario:</b>" . $this->txtSalto;
			$txtCambios .= $this->txtSeparador . "<b>[ No Solicitud $seqSolicitud ] " . $fchSolicitud . ":</b> ";
			$txtCambios .= "<span class='msgError'>Solicitud Eliminada</span>" . $this->txtSalto; 
			return $txtCambios;
		}

		public function eliminarConsignacion( $seqFormulario , $seqConsignacion , $arrConsignaciones ){

			$txtBanco = obtenerNombres( "T_FRM_BANCO", "seqBanco" , $arrConsignaciones['seqBancoConsignacion'] );

			$txtCambios = "<b>[ $seqFormulario ] Datos del Formulario:</b>" . $this->txtSalto;
			$txtCambios .= $this->txtSeparador . "<b>[ No Consignacion $seqSolicitud ] " . $arrConsignaciones['fchConsignacion'] . ":</b> <span class='msgError'>Solicitud Eliminada</span>";
			$txtCambios .= $this->txtSalto;
			$txtCambios .= $this->txtSeparador . "A Nombre de, Valor Anterior: " . $arrConsignaciones['txtNombreConsignacion'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto; 
			$txtCambios .= $this->txtSeparador . "Valor de la Consignacion, Valor Anterior: " . $arrConsignaciones['valConsignacion'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
			$txtCambios .= $this->txtSeparador . "Banco, Valor Anterior: " . $txtBanco . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
			$txtCambios .= $this->txtSeparador . "No Cuenta, Valor Anterior: " . $arrConsignaciones['numCuenta'] . ", " . "Valor Nuevo: Eliminado" . $this->txtSalto;
			return $txtCambios;
		}

		private function comparacionNumeros( $arrAnterior , $arrNuevo , $txtClave , $txtTexto ){
			$txtCambios = "";
			$txtValorAnterior = $arrAnterior[ $txtClave ];
			$txtValorNuevo	= $arrNuevo[ $txtClave ];
			if( $txtValorAnterior != $txtValorNuevo ){
				$txtValorAnterior = ( $txtValorAnterior == 0 )? "Ninguno" : $txtValorAnterior;
				$txtValorNuevo	= ( $txtValorNuevo	== 0 )? "Ninguno" : $txtValorNuevo;
				$txtCambios = $this->txtSeparador . $txtTexto  . ", Valor Anterior: " . $txtValorAnterior . ", " . 
							   "Valor Nuevo: " . $txtValorNuevo . $this->txtSalto;
			}
			return $txtCambios;
		}

		private function comparacionTexto( $arrAnterior , $arrNuevo , $txtClave , $txtTexto ){
			$txtCambios = "";
			$txtValorAnterior = strtolower( trim( $arrAnterior[ $txtClave ] ) );
			$txtValorNuevo	= strtolower( trim( $arrNuevo[ $txtClave ] ) );
			if( $txtValorAnterior != $txtValorNuevo ){
				$txtValorAnterior = ( $txtValorAnterior == "" )? "Ninguno" : $txtValorAnterior;
				$txtValorNuevo	= ( $txtValorNuevo	== "" )? "Ninguno" : $txtValorNuevo;
				$txtCambios = $this->txtSeparador . $txtTexto . ", Valor Anterior: " . ucwords( $txtValorAnterior ). ", " . 
							   "Valor Nuevo: " . ucwords( $txtValorNuevo ) . $this->txtSalto;
			}
			return $txtCambios;
		}

	} // fin clase seguimiento

?>