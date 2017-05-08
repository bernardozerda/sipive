<?php
	/**
	 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
	 * RELACIONADAS CON LA FIDUCIARIA
	 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
	 * @author Jaison Ospina
	 * @version 0.1 Agosto 2013
	 */


	class Fiduciaria {
		public $txtNombreFiduciaria;					// Nombre de la Fiduciaria
		public $seqTipoDocumentoFiduciaria;				// Tipo de Documento de la Fiduciaria
		public $numDocumentoFiduciaria;					// Numero de Documento de la Fiduciaria
		public $txtDireccionFiduciaria;					// Direccion de la Fiduciaria
		public $numTelefono1Fiduciaria;					// Telefono 1 de la Fiduciaria
		public $numTelefono2Fiduciaria;					// Telefono 2 de la Fiduciaria
		public $txtCorreoElectronicoFiduciaria;			// Correo Electronico de la Fiduciaria
		public $txtNombreRepresentanteLegal;			// Nombre del Representante Legal de la Fiduciaria
		public $numDocumentoRepresentanteLegal;			// Numero de Documento del Representante Legal de la Fiduciaria
		public $txtCorreoElectronicoRepresentanteLegal;	// Numero de Documento del Representante Legal de la Fiduciaria
		public $bolActivo;								// Estado Activo de la Fiduciaria
		
		/**
		 * CONSTRUCTOR DE LA CLASE
		 * @author Jaison ospina
		 * @param Void
		 * @return Void
		 * @version 1.0 Agosto 2013
		 */
		public function Fiduciaria() {
			$this->txtNombreFiduciaria		 				= "";
			$this->seqTipoDocumentoFiduciaria				= 0;
			$this->numDocumentoFiduciaria					= 0;
			$this->txtDireccionFiduciaria		 			= "";
			$this->numTelefono1Fiduciaria		 			= 0;
			$this->numTelefono2Fiduciaria		 			= 0;
			$this->txtCorreoElectronicoFiduciaria		 	= "";
			$this->txtNombreRepresentanteLegal				= "";
			$this->numDocumentoRepresentanteLegal			= 0;
			$this->txtCorreoElectronicoRepresentanteLegal	= "";
			$this->bolActivo								= 0;
		} // Fin Constructor

		/**
		* CARGA UNO O TODAS LAS FIDUCIARIA QUE
		* HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
		* QUE SE LE PASE A LA FUNCION
		* @author Jaison Ospina
		* @return array arrFiduciaria
		* @version 1.0 Noviembre 2013
		*/
		public function cargarFiduciaria( $seqFiduciaria ) {

			global $aptBd;

			// Arreglo que se retorna
			$arrFiduciaria = array();

			// Si viene parametro la consulta es para una sola Fiduciaria
			$txtCondicion = "";
			if( $seqFiduciaria != 0 ){
				$txtCondicion = " AND seqFiduciaria = $seqFiduciaria";
			}

			// Consulta de Fiduciaria
			$sql = "
				SELECT
            		seqFiduciaria,
	    			txtNombreFiduciaria,
					seqTipoDocumentoFiduciaria,
					numDocumentoFiduciaria,
					txtDireccionFiduciaria,
					numTelefono1Fiduciaria,
					numTelefono2Fiduciaria,
					txtCorreoElectronicoFiduciaria,
					txtNombreRepresentanteLegal,
					numDocumentoRepresentanteLegal,
					txtCorreoElectronicoRepresentanteLegal,
					bolActivo
	    		FROM 
	    			T_PRY_FIDUCIARIA
				WHERE seqFiduciaria > 0
					$txtCondicion
				ORDER BY
					txtNombreFiduciaria
			";
			//echo $sql;
			
		$objRes = $aptBd->execute( $sql );
			if( $aptBd->ErrorMsg() == "" ){
				while( $objRes->fields ){
					$seqFiduciaria = $objRes->fields['seqFiduciaria'];
					$objFiduciaria = new Fiduciaria;
					$objFiduciaria->txtNombreFiduciaria						= $objRes->fields['txtNombreFiduciaria'];
					$objFiduciaria->seqTipoDocumentoFiduciaria				= $objRes->fields['seqTipoDocumentoFiduciaria'];
					$objFiduciaria->numDocumentoFiduciaria					= $objRes->fields['numDocumentoFiduciaria'];
					$objFiduciaria->txtDireccionFiduciaria					= $objRes->fields['txtDireccionFiduciaria'];
					$objFiduciaria->numTelefono1Fiduciaria					= $objRes->fields['numTelefono1Fiduciaria'];
					$objFiduciaria->numTelefono2Fiduciaria					= $objRes->fields['numTelefono2Fiduciaria'];
					$objFiduciaria->txtCorreoElectronicoFiduciaria			= $objRes->fields['txtCorreoElectronicoFiduciaria'];
					$objFiduciaria->txtNombreRepresentanteLegal				= $objRes->fields['txtNombreRepresentanteLegal'];
					$objFiduciaria->numDocumentoRepresentanteLegal			= $objRes->fields['numDocumentoRepresentanteLegal'];
					$objFiduciaria->txtCorreoElectronicoRepresentanteLegal	= $objRes->fields['txtCorreoElectronicoRepresentanteLegal'];
					$objFiduciaria->bolActivo								= $objRes->fields['bolActivo'];
					$arrFiduciaria[ $seqFiduciaria ] 						= $objFiduciaria; // arreglo de objetos
					$objRes->MoveNext();
				}
			}
			return $arrFiduciaria;
		} // Fin Cargar Fiduciaria

		/**
		* GUARDA EN LA BASE DE DATOS LA INFORMACION DE LA FIDUCIARIA
		* @author Jaison Ospina
		
		* @param String txtNombreFiduciaria
		* @param integer seqTipoDocumentoFiduciaria
		* @param integer numDocumentoFiduciaria
		* @param String txtDireccionFiduciaria
		* @param integer numTelefono1Fiduciaria
		* @param integer numTelefono2Fiduciaria
		* @param String txtCorreoElectronicoFiduciaria
		* @param String txtNombreRepresentanteLegal
		* @param integer numDocumentoRepresentanteLegal
		* @param String txtCorreoElectronicoRepresentanteLegal
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0,1 Noviembre 2013
		*/

		public function guardarFiduciaria ( $seqFiduciaria, $txtNombreFiduciaria, $seqTipoDocumentoFiduciaria, $numDocumentoFiduciaria, $txtDireccionFiduciaria, $numTelefono1Fiduciaria, $numTelefono2Fiduciaria, $txtCorreoElectronicoFiduciaria, $txtNombreRepresentanteLegal, $numDocumentoRepresentanteLegal, $txtCorreoElectronicoRepresentanteLegal, $bolActivo ) {

		global $aptBd;
		$arrErrores = array();

		// Verifica si la Fiduciaria existe
		$sql = mysql_query("SELECT * FROM T_PRY_FIDUCIARIA WHERE numDocumentoFiduciaria = $numDocumentoFiduciaria");
		$cuantos = mysql_num_rows($sql);
		if ($cuantos > 0){
			$arrErrores[] = "El Documento <b>$numDocumentoFiduciaria</b> ya está asignado a otra Fiduciaria";
		} else {
			// Instruccion para insertar la Fiduciaria en la base de datos
			$sql = "INSERT INTO T_PRY_FIDUCIARIA ( 
						txtNombreFiduciaria,
						seqTipoDocumentoFiduciaria,
						numDocumentoFiduciaria,
						txtDireccionFiduciaria,
						numTelefono1Fiduciaria,
						numTelefono2Fiduciaria,
						txtCorreoElectronicoFiduciaria,
						txtNombreRepresentanteLegal,
						numDocumentoRepresentanteLegal,
						txtCorreoElectronicoRepresentanteLegal,
						bolActivo
					) VALUES (
						\"" . ereg_replace( '\"' , "" , $txtNombreFiduciaria ) . "\", 
						'$seqTipoDocumentoFiduciaria',
						'$numDocumentoFiduciaria',
						'$txtDireccionFiduciaria', 
						'$numTelefono1Fiduciaria', 
						'$numTelefono2Fiduciaria', 
						'$txtCorreoElectronicoFiduciaria', 
						'$txtNombreRepresentanteLegal', 
						'$numDocumentoRepresentanteLegal', 
						'$txtCorreoElectronicoRepresentanteLegal',
						$bolActivo
					) ";
					//echo $sql;
				try {
					$aptBd->execute( $sql );
				} catch ( Exception $objError ){
					$arrErrores[] = "No se ha podido guardar la Fiduciaria <b>$txtNombreFiduciaria</b>. Reporte este error al administrador del sistema";
				}
			}
			return $arrErrores;

		} // Fin guardar Fiduciaria

		/**
		* MODIFICA LA INFORMACION DE LA FIDUCIARIA SELECCIONADO Y GUARDA LOS NUEVOS DATOS
		* @author Jaison Ospina
		* @param integer seqFiduciaria
		* @param String txtNombreFiduciaria
		* @param integer seqTipoDocumentoFiduciaria
		* @param integer numDocumentoFiduciaria
		* @param String txtNombreRepresentanteLegal
		* @param integer numDocumentoRepresentanteLegal
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0.1 Agosto 2013
		*/
		
        public function editarFiduciaria( $seqFiduciaria, $txtNombreFiduciaria, $seqTipoDocumentoFiduciaria, $numDocumentoFiduciaria, $txtDireccionFiduciaria, $numTelefono1Fiduciaria, $numTelefono2Fiduciaria, $txtCorreoElectronicoFiduciaria, $txtNombreRepresentanteLegal, $numDocumentoRepresentanteLegal, $txtCorreoElectronicoRepresentanteLegal, $bolActivo ) {
            global $aptBd;
            $arrErrores = array();
            
            // Verifica si la Fiduciaria existe
			$sql = mysql_query("SELECT * FROM T_PRY_FIDUCIARIA WHERE numDocumentoFiduciaria = $numDocumentoFiduciaria AND seqFiduciaria <> $seqFiduciaria");
			$cuantos = mysql_num_rows($sql);
			if ($cuantos > 0){
				$arrErrores[] = "El Documento <b>$numDocumentoFiduciaria</b> ya está asignado a otra Fiduciaria";
			} else {
				// Consulta para hacer la actualizacion
				$sql = "
					UPDATE T_PRY_FIDUCIARIA SET
						txtNombreFiduciaria = \"" . ereg_replace( '\"' , "" , $txtNombreFiduciaria ) . "\", 
						seqTipoDocumentoFiduciaria = '$seqTipoDocumentoFiduciaria',
						numDocumentoFiduciaria = '$numDocumentoFiduciaria',
						txtDireccionFiduciaria = '$txtDireccionFiduciaria',
						numTelefono1Fiduciaria = '$numTelefono1Fiduciaria',
						numTelefono2Fiduciaria = '$numTelefono2Fiduciaria',
						txtCorreoElectronicoFiduciaria = '$txtCorreoElectronicoFiduciaria',
						txtNombreRepresentanteLegal = '$txtNombreRepresentanteLegal',
						numDocumentoRepresentanteLegal = '$numDocumentoRepresentanteLegal',
						txtCorreoElectronicoRepresentanteLegal = '$txtCorreoElectronicoRepresentanteLegal',
						bolActivo = $bolActivo
					WHERE seqFiduciaria = $seqFiduciaria
				";
				//echo $sql;

				try {
					$aptBd->execute( $sql );
				} catch ( Exception $objError ){
					$arrFiduciaria = $this->cargarFiduciaria( $seqFiduciaria );
					$arrErrores[] = "No se ha podido editar la Fiduciaria <b>".$arrFiduciaria[ $seqFiduciaria ]->txtNombreFiduciaria."</b>. Reporte este error al administrador del sistema";
				}
			}
			return $arrErrores;

		} // Fin editar Fiduciaria

		/**
		* VERIFICA SI SE PUEDE BORRAR LA FIDUCIARIA Y SI ES POSIBLE LO BORRA DEL SISTEMA
		* @author Jaison Ospina
		* @param integer seqFiduciaria
		* @return array arrErrores
		* @version 1.0 Noviembre 2013
		*/
		public function borrarFiduciaria( $seqFiduciaria ){

			global $aptBd;
			$arrErrores = array();

			// Valida que se pueda borrar la Fiduciaria
			//$arrErrores = $this->validarBorrarFiduciaria( $seqFiduciaria );
            
            // si no hay errores entra a eliminar
            if( empty( $arrErrores ) ){
                
                $sql = "
                    DELETE
                    FROM T_PRY_FIDUCIARIA
                    WHERE seqFiduciaria = $seqFiduciaria
                ";
                
                // borra la Fiduciaria
                try {
                	$aptBd->execute( $sql );
                } catch ( Exception $objError ) {
                  $arrFiduciaria = $this->cargarFiduciaria( $seqFiduciaria );
                	$arrErrores[] = "No se ha podido borrar la Fiduciaria <b>".$arrFiduciaria[ $seqFiduciaria ]->txtNombreFiduciaria."</b>";
                  //pr( $objError->getMessage() );
                }
                
            }
            
            return $arrErrores;
            
        } // Fin borrar Fiduciaria
        
	} // Fin clase
?>