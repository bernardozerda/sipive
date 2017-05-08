<?php
	/**
	 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
	 * RELACIONADAS CON EL OFERENTE
	 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
	 * @author Jaison Ospina
	 * @version 0.1 Agosto 2013
	 */


	class Oferente {
		public $txtNombreOferente;				// Nombre de la Oferente
		public $seqTipoDocumentoOferente;		// Tipo de Documento del Oferente
		public $numDocumentoOferente;			// Numero de Documento del Oferente
		public $txtNombreRepresentanteLegal;	// Nombre del Representante Legal del Oferente
		public $numDocumentoRepresentanteLegal;	// Numero de Documento del Representante Legal del Oferente
		public $bolActivo;						// Estado Activo del Oferente
		
		/**
		 * CONSTRUCTOR DE LA CLASE
		 * @author Jaison ospina
		 * @param Void
		 * @return Void
		 * @version 1.0 Agosto 2013
		 */
		public function Oferente() {
			$this->txtNombreOferente		 		= "";
			$this->seqTipoDocumentoOferente			= 0;
			$this->numDocumentoOferente				= 0;
			$this->txtNombreRepresentanteLegal		= "";
			$this->numDocumentoRepresentanteLegal	= 0;
			$this->bolActivo						= 0;
		} // Fin Constructor

		/**
		* CARGA UNO O TODOS LOS OFERENTES QUE
		* HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
		* QUE SE LE PASE A LA FUNCION
		* @author Jaison Ospina
		* @return array arrOferente
		* @version 1.0 Noviembre 2013
		*/
		public function cargarOferente( $seqOferente ) {

			global $aptBd;

			// Arreglo que se retorna
			$arrOferente = array();

			// Si viene parametro la consulta es para un solo Oferente
			$txtCondicion = "";
			if( $seqOferente != 0 ){
				$txtCondicion = " AND seqOferente = $seqOferente";
			}

			// Consulta de Oferente
			$sql = "
				SELECT
            		seqOferente,
	    			txtNombreOferente,
					seqTipoDocumentoOferente,
					numDocumentoOferente,
					txtNombreRepresentanteLegal,
					numDocumentoRepresentanteLegal,
					bolActivo
	    		FROM 
	    			T_PRY_OFERENTE
				WHERE seqOferente > 0
					$txtCondicion
				ORDER BY
					txtNombreOferente
			";
			//echo $sql;
			
		$objRes = $aptBd->execute( $sql );
			if( $aptBd->ErrorMsg() == "" ){
				while( $objRes->fields ){
					$seqOferente = $objRes->fields['seqOferente'];
					$objOferente = new Oferente;
					$objOferente->txtNombreOferente					= $objRes->fields['txtNombreOferente'];
					$objOferente->seqTipoDocumentoOferente			= $objRes->fields['seqTipoDocumentoOferente'];
					$objOferente->numDocumentoOferente				= $objRes->fields['numDocumentoOferente'];
					$objOferente->txtNombreRepresentanteLegal		= $objRes->fields['txtNombreRepresentanteLegal'];
					$objOferente->numDocumentoRepresentanteLegal	= $objRes->fields['numDocumentoRepresentanteLegal'];
					$objOferente->bolActivo							= $objRes->fields['bolActivo'];
					$arrOferente[ $seqOferente ] 					= $objOferente; // arreglo de objetos
					$objRes->MoveNext();
				}
			}
			return $arrOferente;
		} // Fin Cargar Oferente

		/**
		* GUARDA EN LA BASE DE DATOS LA INFORMACION DEL OFERENTE
		* @author Jaison Ospina
		
		* @param String txtNombreOferente
		* @param integer seqTipoDocumentoOferente
		* @param integer numDocumentoOferente
		* @param String txtNombreRepresentanteLegal
		* @param integer numDocumentoRepresentanteLegal
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0,1 Noviembre 2013
		*/

		public function guardarOferente ( $seqOferente, $txtNombreOferente, $seqTipoDocumentoOferente, $numDocumentoOferente, $txtNombreRepresentanteLegal, $numDocumentoRepresentanteLegal, $bolActivo ) {

		global $aptBd;
		$arrErrores = array();
            
		// Instruccion para insertar el Oferente en la base de datos
		$sql = "INSERT INTO T_PRY_OFERENTE ( 
					txtNombreOferente,
					seqTipoDocumentoOferente,
					numDocumentoOferente,
					txtNombreRepresentanteLegal,
					numDocumentoRepresentanteLegal,
					bolActivo
				) VALUES (
					\"" . ereg_replace( '\"' , "" , $txtNombreOferente ) . "\", 
					$seqTipoDocumentoOferente,
					$numDocumentoOferente,
					'$txtNombreRepresentanteLegal',
					$numDocumentoRepresentanteLegal,
					$bolActivo
				) ";
			//echo $sql;

			try {
				$aptBd->execute( $sql );
			} catch ( Exception $objError ){
				$arrErrores[] = "No se ha podido guardar el Oferente <b>$txtNombreOferente</b>. Reporte este error al administrador del sistema";
			}

			return $arrErrores;

		} // Fin guardar Oferente

		/**
		* MODIFICA LA INFORMACION DEL OFERENTE SELECCIONADO Y GUARDA LOS NUEVOS DATOS
		* @author Jaison Ospina
		* @param integer seqOferente
		* @param String txtNombreOferente
		* @param integer seqTipoDocumentoOferente
		* @param integer numDocumentoOferente
		* @param String txtNombreRepresentanteLegal
		* @param integer numDocumentoRepresentanteLegal
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0.1 Agosto 2013
		*/
		
        public function editarOferente( $seqOferente, $txtNombreOferente, $seqTipoDocumentoOferente, $numDocumentoOferente, $txtNombreRepresentanteLegal, $numDocumentoRepresentanteLegal, $bolActivo ) {
            global $aptBd;
            $arrErrores = array();
            
            // Consulta para hacer la actualizacion
            $sql = "
                UPDATE T_PRY_OFERENTE SET
					txtNombreOferente = \"" . ereg_replace( '\"' , "" , $txtNombreOferente ) . "\", 
					seqTipoDocumentoOferente = $seqTipoDocumentoOferente,
					numDocumentoOferente = $numDocumentoOferente,
					txtNombreRepresentanteLegal = '$txtNombreRepresentanteLegal',
					numDocumentoRepresentanteLegal = '$numDocumentoRepresentanteLegal',
					bolActivo = $bolActivo
				WHERE seqOferente = $seqOferente
            ";
			//echo $sql;
			
            try {
				$aptBd->execute( $sql );
            } catch ( Exception $objError ){
                $arrOferente = $this->cargarOferente( $seqOferente );
                $arrErrores[] = "No se ha podido editar el Oferente <b>".$arrOferente[ $seqOferente ]->txtNombreOferente."</b>. Reporte este error al administrador del sistema";
			}

			return $arrErrores;

		} // Fin editar Oferente

		/**
		* VERIFICA SI SE PUEDE BORRAR EL OFERENTE Y SI ES POSIBLE LO BORRA DEL SISTEMA
		* @author Jaison Ospina
		* @param integer seqOferente
		* @return array arrErrores
		* @version 1.0 Noviembre 2013
		*/
		public function borrarOferente( $seqOferente ){

			global $aptBd;
			$arrErrores = array();

			// Valida que se pueda borrar el Oferente
			//$arrErrores = $this->validarBorrarOferente( $seqOferente );
            
            // si no hay errores entra a eliminar
            if( empty( $arrErrores ) ){
                
                $sql = "
                    DELETE
                    FROM T_PRY_OFERENTE
                    WHERE seqOferente = $seqOferente
                ";
                
                // borra el Oferente
                try {
                	$aptBd->execute( $sql );
                } catch ( Exception $objError ) {
                  $arrOferente = $this->cargarOferente( $seqOferente );
                	$arrErrores[] = "No se ha podido borrar el Oferente <b>".$arrOferente[ $seqOferente ]->txtNombreOferente."</b>";
                  //pr( $objError->getMessage() );
                }
                
            }
            
            return $arrErrores;
            
        } // Fin borrar Oferente
        
	} // Fin clase
?>