<?php
	/**
	 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
	 * RELACIONADAS CON LAS OPV
	 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
	 * @author Jaison Ospina
	 * @version 0.1 Agosto 2013
	 */


	class Opv {
		public $txtNombreOpv;				// Nombre de la OPV
		public $numNitOpv;					// Nit de la OPV
		public $txtRepresentanteOpv;		// Nombre del Representante Legal
		public $seqTipoDocRepresentanteOpv;	// Tipo de Documento del Representante Legal
		public $numDocRepresentanteOpv;		// Numero de Documento del Representante Legal
		public $bolActivo;					// Estado Activo de la OPV

		/**
		 * CONSTRUCTOR DE LA CLASE
		 * @author Jaison ospina
		 * @param Void
		 * @return Void
		 * @version 1.0 Agosto 2013
		 */
		public function Opv() {
			$this->txtNombreOpv		 			= "";
			$this->numNitOpv					= 0;
			$this->txtRepresentanteOpv			= "";
			$this->seqTipoDocRepresentanteOpv	= 0;
			$this->numDocRepresentanteOpv		= 0;
			$this->bolActivo					= 0;
		} // Fin Constructor

		/**
		* CARGA UNO O TODOS LAS OPV QUE
		* HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
		* QUE SE LE PASE A LA FUNCION
		* @author Jaison Ospina
		* @return array arrOpv
		* @version 1.0 Noviembre 2013
		*/
		public function cargarOpv( $seqOpv ) {

			global $aptBd;

			// Arreglo que se retorna
			$arrOpv = array();

			// Si viene parametro la consulta es para una sola Opv
			$txtCondicion = "";
			if( $seqOpv != 0 ){
				$txtCondicion = " AND seqOpv = $seqOpv";
			}

			// Consulta de Opv
			$sql = "
				SELECT
            		seqOpv, 
	    			txtNombreOpv,
					numNitOpv,
					txtRepresentanteOpv,
					seqTipoDocRepresentanteOpv,
					numDocRepresentanteOpv,
					bolActivo
	    		FROM 
	    			T_PRY_OPV
				WHERE seqOpv > 0
					$txtCondicion
				ORDER BY
					txtNombreOpv
			";

		$objRes = $aptBd->execute( $sql );
			if( $aptBd->ErrorMsg() == "" ){
				while( $objRes->fields ){
					$seqOpv = $objRes->fields['seqOpv'];
					$objOpv = new Opv;
					$objOpv->txtNombreOpv				= $objRes->fields['txtNombreOpv'];
					$objOpv->numNitOpv					= $objRes->fields['numNitOpv'];
					$objOpv->txtRepresentanteOpv		= $objRes->fields['txtRepresentanteOpv'];
					$objOpv->seqTipoDocRepresentanteOpv	= $objRes->fields['seqTipoDocRepresentanteOpv'];
					$objOpv->numDocRepresentanteOpv		= $objRes->fields['numDocRepresentanteOpv'];
					$objOpv->bolActivo					= $objRes->fields['bolActivo'];
					$arrOpv[ $seqOpv ] 					= $objOpv; // arreglo de objetos
					$objRes->MoveNext();
				}
			}
			return $arrOpv;
		} // Fin Cargar Opv

		/**
		* GUARDA EN LA BASE DE DATOS LA INFORMACION DE LAS OPV
		* @author Jaison Ospina

		* @param String txtNombreOpv
		* @param integer numNitOpv
		* @param integer txtRepresentanteOpv
		* @param integer seqTipoDocRepresentanteOpv
		* @param String numDocRepresentanteOpv
		* @param integer numDocRepresentanteOpv
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0,1 Noviembre 2013
		*/

		public function guardarOpv ( $seqOpv, $txtNombreOpv, $numNitOpv, $txtRepresentanteOpv, $seqTipoDocRepresentanteOpv, $numDocRepresentanteOpv, $bolActivo ) {

		global $aptBd;
		$arrErrores = array();
            
		// Verifica si la OPV existe
		$sql = mysql_query("SELECT * FROM T_PRY_OPV WHERE numNitOpv = $numNitOpv");
		$cuantos = mysql_num_rows($sql);
		if ($cuantos > 0){
			$arrErrores[] = "El NIT <b>$numNitOpv</b> ya está asignado a otra OPV";
		} else {
			// Instruccion para insertar la Opv en la base de datos
			$sql = "INSERT INTO T_PRY_OPV ( 
						txtNombreOpv,
						numNitOpv,
						txtRepresentanteOpv,
						seqTipoDocRepresentanteOpv,
						numDocRepresentanteOpv,
						bolActivo
					) VALUES (
						\"" . ereg_replace( '\"' , "" , $txtNombreOpv ) . "\", 
						$numNitOpv,
						'$txtRepresentanteOpv',
						$seqTipoDocRepresentanteOpv,
						$numDocRepresentanteOpv,
						$bolActivo
					) ";
				//echo $sql;
			try {
				$aptBd->execute( $sql );
			} catch ( Exception $objError ){
				$arrErrores[] = "No se ha podido guardar la Opv <b>$txtNombreOpv</b>. Reporte este error al administrador del sistema";
			}
		}
		return $arrErrores;
		} 

		// Fin guardar Opv

		/**
		* MODIFICA LA INFORMACION DE LA OPV SELECCIONADA Y GUARDA LOS NUEVOS DATOS
		* @author Jaison Ospina
		* @param integer seqOpv
		* @param String txtNombreOpv
		* @param integer numNitOpv
		* @param String txtRepresentanteOpv
		* @param integer seqTipoDocRepresentanteOpv
		* @param String numDocRepresentanteOpv
		* @param Boolean bolActivo
		* @return Array arrErrores
		* @version 0.1 Agosto 2013
		*/

        public function editarOpv( $seqOpv, $txtNombreOpv, $numNitOpv, $txtRepresentanteOpv, $seqTipoDocRepresentanteOpv, $numDocRepresentanteOpv, $bolActivo ) {
            global $aptBd;
            $arrErrores = array();

			//echo $seqOpv, $txtNombreOpv. $numNitOpv. $txtRepresentanteOpv. $seqTipoDocRepresentanteOpv. $numDocRepresentanteOpv. $bolActivo;

            // Verifica si la OPV existe
			$sql = mysql_query("SELECT * FROM T_PRY_OPV WHERE numNitOpv = $numNitOpv AND seqOpv <> $seqOpv");
			$cuantos = mysql_num_rows($sql);
			if ($cuantos > 0){
				$arrErrores[] = "El NIT <b>$numNitOpv</b> ya está asignado a otra OPV";
			} else {
				// Consulta para hacer la actualizacion
				$sql = "
					UPDATE T_PRY_OPV SET
						txtNombreOpv = \"" . ereg_replace( '\"' , "" , $txtNombreOpv ) . "\", 
						numNitOpv = $numNitOpv,
						txtRepresentanteOpv = '$txtRepresentanteOpv',
						seqTipoDocRepresentanteOpv = $seqTipoDocRepresentanteOpv,
						numDocRepresentanteOpv = '$numDocRepresentanteOpv',
						bolActivo = $bolActivo
					WHERE seqOpv = $seqOpv
				";
				//echo $sql;

				try {
					$aptBd->execute( $sql );
				} catch ( Exception $objError ){
					$arrOpv = $this->cargarOpv( $seqOpv );
					$arrErrores[] = "No se ha podido editar la Opv <b>".$arrOpv[ $seqOpv ]->txtNombreOpv."</b>. Reporte este error al administrador del sistema";
				}
			}

			return $arrErrores;

		} // Fin editar Opv

		/**
		* VERIFICA SI SE PUEDE BORRAR LA OPV Y SI ES POSIBLE LO BORRA DEL SISTEMA
		* @author Jaison Ospina
		* @param integer seqOpv
		* @return array arrErrores
		* @version 1.0 Noviembre 2013
		*/
		public function borrarOpv( $seqOpv ){

			global $aptBd;
			$arrErrores = array();

			// Valida que se pueda borrar la Opv
			//$arrErrores = $this->validarBorrarOpv( $seqOpv );

			// si no hay errores entra a eliminar
			if( empty( $arrErrores ) ){

				$sql = "
					DELETE
					FROM T_PRY_OPV
					WHERE seqOpv = $seqOpv
				";

				// borra la Opv
				try {
					$aptBd->execute( $sql );
				} catch ( Exception $objError ) {
                  $arrOpv = $this->cargarOpv( $seqOpv );
                	$arrErrores[] = "No se ha podido borrar la Opv <b>".$arrOpv[ $seqOpv ]->txtNombreOpv."</b>";
                  //pr( $objError->getMessage() );
                }
            }
            
			return $arrErrores;
            
        } // Fin borrar Opv
        
	} // Fin clase
?>