<?php
	
	/**
	 * ESTA CLASE REGISTRA LAS ACTIVIDADES DEL 
	 * USUARIO EN EL APLICATIVO, LLENA LA TABLA DE
	 * T_AUDITORIA CON LAS ACCIONES QUE SE ALMACENAN
	 * EN T_ACCION
	 * @author bernardo zerda
	 * @version 1.0 abril 2009
	 */


	class RegistroActividades {
		
		private $arrAcciones; // Arreglo para las acciones disponibles [txtAccion]['seqAccion'] = Identificador de la accion
                              //                                                  ['txtAccion'] = Nombre de la accion
                              //                                                  ['txtDescripcion'] = Explicacion de la accion
		
		/**
		 * ELCONSTRUCTOR DE ESTA CLASE OBTIENE
		 * LAS ACCIONES QUE SE PUEDEN REALIZAR
		 * @author bernardo zerda
		 * @param Void
		 * @return Void
		 * @version 1.0 abril 2009
		 */
	    public function RegistroActividades() {
	    	
	    	global $aptBd;
	    	
	    	$this->arrAcciones = array();
	    	
	    	// Obtiene todas las acciones posibles
	    	$sql = "
	    		SELECT 
	    			seqAccion,
	    			txtAccion,
	    			txtDescripcion
	    		FROM
	    			T_COR_ACCION
	    	";
	    	$objRes = $aptBd->execute( $sql );
	    	while( $objRes->fields ){
	    		
	    		$seqAccion      = $objRes->fields['seqAccion'];
	    		$txtAccion      = $objRes->fields['txtAccion'];
	    		$txtDescripcion = $objRes->fields['txtDescripcion'];
	    		
	    		$this->arrAcciones[ $txtAccion ][ 'seqAccion' ]      = $seqAccion;
	    		$this->arrAcciones[ $txtAccion ][ 'txtDescripcion' ] = $txtDescripcion; 
	    		
	    		$objRes->MoveNext();
	    	}
	    	
	    } // fin constructor
	    
	    
	    /**
	     * ESTE MEODO REGISTRA UNA ACTIVIDAD EN EL 
	     * LOG DEL SISTEMA T_AUDITORIA
	     * @author bernardo zerda
	     * @param string Accion realizada
	     * @param integer seqPermiso
	     * @param integer seqUsuario
	     * @param string txtDescripcion
	     * @return array arrErrores
	     */
	    public function registrarActividad( $txtAccion , $seqPermiso , $seqUsuario , $txtDescripcion ){
	    	
	    	global $aptBd; // conexion a la base de datos
	    	$arrErrores = array();
	    	
        $sql = "
        	INSERT INTO T_COR_AUDITORIA (
        		seqAccion,
        		seqPermiso,
        		seqUsuario,
        		txtDescripcion,
        		fchAccion,
        		ipUsuario,
        		maquinaUsuario
        	) VALUES (
        		" . $this->arrAcciones[ $txtAccion ][ 'seqAccion' ] . ",
        		$seqPermiso,
        		$seqUsuario,
        		\"" . mb_ereg_replace( '\"' , '' , $txtDescripcion ) . "\",
        		NOW(),
        		'". $_SERVER['REMOTE_ADDR'] ."',
        		'". gethostbyaddr($_SERVER['REMOTE_ADDR']) ."'
        	)
        ";

	    	try {
	    		$aptBd->execute( $sql );
	    	} catch ( Exception $objError ) {
	    		$arrErrores[] = "No se pudo registrar la actividad del usuario";
	    		//pr($arrErrores); die();
	    	}
	    	
	    	return $arrErrores;
	    }
	    
	    
	}
?>