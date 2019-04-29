<?php

	class Ciudadano {
	
	    public $txtNombre1;
        public $txtNombre2;
        public $txtApellido1;
        public $txtApellido2;
        public $fchNacimiento;
        public $seqTipoDocumento;
        public $numDocumento;
        public $valIngresos;
        public $seqCajaCompensacion;
        public $seqNivelEducativo;
        public $seqEtnia;
        public $seqEstadoCivil;
        public $seqOcupacion;
        public $seqCondicionEspecial;
        public $seqCondicionEspecial2;
        public $seqCondicionEspecial3;
        public $seqSexo;
        public $bolLgtb;
        public $bolBeneficiario;
        public $seqSalud;
        public $bolCertificadoElectoral;
        
        // Informacion relacionada con un formulario (Hogar)
        public $bolSoporteDocumento;
        public $seqParentesco;
        
        public $arrErrores;
	
	    public function Ciudadano() {
	    	
	    	$this->txtNombre1 = "";
			$this->txtNombre2 = "";
			$this->txtApellido1 = "";
			$this->txtApellido2 = "";
			$this->fchNacimiento = "";
			$this->seqTipoDocumento = "";
			$this->numDocumento = "";
			$this->valIngresos = "";
			$this->seqCajaCompensacion = "";
			$this->seqNivelEducativo = "";
			$this->seqEtnia = "";
			$this->seqEstadoCivil = "";
			$this->seqOcupacion = "";
			$this->seqCondicionEspecial = "";
			$this->seqCondicionEspecial2 = "";
			$this->seqCondicionEspecial3 = "";
			$this->seqSexo = "";
			$this->bolLgtb = "";
			$this->bolBeneficiario = "";
			$this->seqSalud = 0;
	        $this->bolSoporteDocumento = 0;
	        $this->seqParentesco = 0;
	        $this->bolCertificadoElectoral = 0;
			
			$this->arrErrores = array();
	    	
	    } // Fin constructor
	    
	    public function guardarCiudadano(){
	    	
	    	global $aptBd;
	    	
	    	$seqCiudadano = 0;
	    	
			$numDocumentoFormat = str_replace(".","",$this->numDocumento);
			$numValIngresosFormat = str_replace(".","",$this->valIngresos);
			
	    	$sql = "	    	
				INSERT INTO T_CIU_CIUDADANO (
				  txtNombre1,
				  txtNombre2,
				  txtApellido1,
				  txtApellido2,
				  fchNacimiento,
				  seqTipoDocumento,
				  numDocumento,
				  valIngresos,
				  seqCajaCompensacion,
				  seqNivelEducativo,
				  seqEtnia,
				  seqEstadoCivil,
				  seqOcupacion,
				  seqCondicionEspecial,
				  seqCondicionEspecial2,
				  seqCondicionEspecial3,
				  seqSexo,
				  bolLgtb,
				  bolBeneficiario,
				  seqSalud,
				  bolCertificadoElectoral
				) VALUES (
				  \"".$this->txtNombre1."\",
				  \"".$this->txtNombre2."\",
				  \"".$this->txtApellido1."\", 
				  \"".$this->txtApellido2."\",
				  \"".$this->fchNacimiento."\",
				  ".$this->seqTipoDocumento.", 
				  ".$numDocumentoFormat.",
				  ".$numValIngresosFormat.",
				  ".$this->seqCajaCompensacion.", 
				  ".$this->seqNivelEducativo.",
				  ".$this->seqEtnia.",
				  ".$this->seqEstadoCivil.", 
				  ".$this->seqOcupacion.",
				  ".$this->seqCondicionEspecial.",
			      ".$this->seqCondicionEspecial2.",
				  ".$this->seqCondicionEspecial3.",
				  ".$this->seqSexo.",
				  ".$this->bolLgtb.",
				  ".$this->bolBeneficiario.",
				  ".$this->seqSalud.",
				  ".$this->bolCertificadoElectoral."
				)
			";
	    	
	    	try {
	    		$aptBd->execute( $sql );
	    		$seqCiudadano = $aptBd->Insert_ID();
	    	} catch ( Exception $objError ) {
	    		$this->arrErrores[] = "No se pudo salvar el registro del ciudadano, puede que el ciudadano ya este creado. $txtFormulario"; 
//	    		pr( $sql );
	    	}
	    	
	    	return $seqCiudadano;
	    	
	    } // fin guardar ciudadano
	    
		public function cargarCiudadano( $seqCiudadano ){
			
			global $aptBd;
			
			$sql = "	
				SELECT ucwords(txtNombre1) as txtNombre1,
				       ucwords(txtNombre2) as txtNombre2,
				       ucwords(txtApellido1) as txtApellido1,
				       ucwords(txtApellido2) as txtApellido2,
				       fchNacimiento,
				       seqTipoDocumento,
				       numDocumento,
				       valIngresos,
				       seqCajaCompensacion,
				       seqNivelEducativo,
				       seqEtnia,
				       seqEstadoCivil,
				       seqOcupacion,
				       seqCondicionEspecial,
					   seqCondicionEspecial2,
					   seqCondicionEspecial3,
				       seqSexo,
				       bolLgtb,
				       bolBeneficiario,
					   seqSalud,
					   bolCertificadoElectoral
				  FROM T_CIU_CIUDADANO
				  WHERE seqCiudadano = $seqCiudadano		
			";
			$objRes = $aptBd->execute( $sql );
			if( $objRes->fields ){
				$this->txtNombre1              = $objRes->fields['txtNombre1'];
				$this->txtNombre2              = $objRes->fields['txtNombre2'];
				$this->txtApellido1            = $objRes->fields['txtApellido1'];
				$this->txtApellido2            = $objRes->fields['txtApellido2'];
				$this->fchNacimiento           = $objRes->fields['fchNacimiento'];
				$this->seqTipoDocumento        = $objRes->fields['seqTipoDocumento'];
				$this->numDocumento            = number_format($objRes->fields['numDocumento'], 0, ",", ".");
				$this->valIngresos             = $objRes->fields['valIngresos'];
				$this->seqCajaCompensacion     = ( intval( $objRes->fields['seqCajaCompensacion'] ) == 0 )? 1 : intval( $objRes->fields['seqCajaCompensacion'] ) ;
				$this->seqNivelEducativo       = $objRes->fields['seqNivelEducativo'];
				$this->seqEtnia                = $objRes->fields['seqEtnia'];
				$this->seqEstadoCivil          = $objRes->fields['seqEstadoCivil'];
				$this->seqOcupacion            = $objRes->fields['seqOcupacion'];
				$this->seqCondicionEspecial    = $objRes->fields['seqCondicionEspecial'];
				$this->seqCondicionEspecial2   = $objRes->fields['seqCondicionEspecial2'];
				$this->seqCondicionEspecial3   = $objRes->fields['seqCondicionEspecial3'];
				$this->seqSexo                 = $objRes->fields['seqSexo'];
				$this->bolLgtb                 = $objRes->fields['bolLgtb'];
				$this->bolBeneficiario         = ( intval( $objRes->fields['bolBeneficiario'] ) == 0 )? 1 : intval( $objRes->fields['bolBeneficiario'] );
				$this->seqSalud                = $objRes->fields['seqSalud'];
				$this->bolCertificadoElectoral = $objRes->fields['bolCertificadoElectoral'];
			}else{
				$this->arrErrores[] = "Ciudadano [$seqCiudadano] no encontrado";
			}
			
		} // fin cargar Ciudadano
	
		public function editarCiudadano( $seqCiudadano ){
			
			global $aptBd;
			
			$numDocumentoFormat = str_replace(".","",$this->numDocumento);
			$numValIngresosFormat = str_replace(".","",$this->valIngresos);
			
			$sql = "
				UPDATE T_CIU_CIUDADANO SET 
					txtNombre1 = \"".$this->txtNombre1."\",
					txtNombre2 = \"".$this->txtNombre2."\",
					txtApellido1 = \"".$this->txtApellido1."\",
					txtApellido2 = \"".$this->txtApellido2."\",
					fchNacimiento = \"".$this->fchNacimiento."\",
					seqTipoDocumento = ".$this->seqTipoDocumento.", 
					numDocumento = ".$numDocumentoFormat.",
					valIngresos = ".$numValIngresosFormat.",
					seqCajaCompensacion = ".$this->seqCajaCompensacion.", 
					seqNivelEducativo = ".$this->seqNivelEducativo.",
					seqEtnia = ".$this->seqEtnia.",
					seqEstadoCivil = ".$this->seqEstadoCivil.", 
					seqOcupacion = ".$this->seqOcupacion.",
				  	seqCondicionEspecial = ".$this->seqCondicionEspecial.",
					seqCondicionEspecial2 = ".$this->seqCondicionEspecial2.",
					seqCondicionEspecial3 = ".$this->seqCondicionEspecial3.", 
					seqSexo = ".$this->seqSexo.",
					bolLgtb = ".$this->bolLgtb.",
					bolBeneficiario = ".$this->bolBeneficiario.",
					seqSalud = ".$this->seqSalud.",
					bolCertificadoElectoral = ".$this->bolCertificadoElectoral."
				WHERE 
					seqCiudadano = $seqCiudadano		
			";
			
			try {
				$aptBd->execute( $sql );
			} catch( Exception $objError ){
				$this->arrErrores[] = "No se pudo actualizar los datos del ciudadano [".$this->txtNombre1." ".$this->txtApellido1." " . $this->txtApellido2 . "]";
//				pr( $objError->getMessage() );
			}
			
		}
	
		public function ciudadanoExiste( $seqTipoDocumento , $numDocumento ){
			
			global $aptBd;
			
			$seqCiudadano = 0;
			
			$numDocumentoFormat = str_replace(".","",$numDocumento);
			
			$sql = "
				SELECT seqCiudadano
				FROM T_CIU_CIUDADANO
				WHERE numDocumento = $numDocumentoFormat
				AND seqTipoDocumento = $seqTipoDocumento
			";
			$objRes = $aptBd->execute( $sql );
			if( $objRes->fields ){
				$seqCiudadano = $objRes->fields['seqCiudadano'];
			}
			
			return $seqCiudadano;
		}
	
		public function buscarNombre( $txtParametro , $numLimiteRegistros = 20 ){
			
			global $aptBd;
			
			$arrResultados = array();
			$txtParametro = strtolower( $txtParametro );
			
			
			$sql = " 
					SELECT 
						CONCAT( ucwords( ciu.txtNombre1 ) , ' ' , 
						        ucwords( ciu.txtNombre2 ) , ' ' ,
						        ucwords( ciu.txtApellido1 ) , ' ' , 
						        ucwords( ciu.txtApellido2 ) ) as nombre , 
								ciu.numDocumento 
						
					FROM  T_CIU_CIUDADANO ciu 
					WHERE  ciu.seqTipoDocumento in ( 1 , 2 ) AND  
					lower( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) LIKE '%$txtParametro%' 
					LIMIT $numLimiteRegistros
				"; 
			
			
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$arrResultados[ ] = $objRes->fields;
					$objRes->MoveNext(); 
				}		
			} catch ( Exception $objError ){
				return $objError->msg;
			}
				
			return $arrResultados;
		}
		
		public function documentoVinculado( $seqFormulario ){
			global $aptBd;
			$numDocumento = 0;
			$sql = "
				SELECT 
					ciu.numDocumento
				FROM 
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano
				and hog.seqFormulario = $seqFormulario			
			";
			
			try{
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numDocumento = $objRes->fields['numDocumento'];
				}
			}catch ( Exception $objError ){ }
			return $numDocumento;
		}
		
		/**
		 * RETORNA EL IDENTIFICADOR DEL FIRMUALRIO AL QUE
		 * ESTA VINCULADO UN CIUDADANO
		 * @author Bernardo Zerda
		 * @author Diego Gaitan
		 * @param Integer nmCedula
		 * @param Boolean bolPostulantePrincipal ==> TRUE: para que varifique que la cedula es de un posultante principal
		 * 												   si la cedua no corresponde a un postulante principal retorna cero (0)
		 * 											 FALSE: Cualquier miembro de hogar funciona, solo retorna cero si el ciudadano no existe o 
		 * 													no esta vinculado a ningun formulario
		 * @param Boolean bolSoloMayorEdad      ==> TRUE: Consulta solo ciudadanos con cedula de ciudadania o cedula de extranjeria
		 * 											FALSE: Consulta cualquier tipo de documento
		 * @version 1.0 Dic 2009
		 * @version 1.1 Sep 2010
		 */
		public function formularioVinculado( $numCedula, $bolPostualtePrincipal = false, $bolSoloMayorEdad = true ){
			global $aptBd;
			$seqFormulario = 0;
			$sql = "
				SELECT 
					hog.seqFormulario
				FROM 
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano ";
			if( $bolSoloMayorEdad ){
			$sql .=	" and ciu.seqTipoDocumento in (1,2) ";
			}
			$sql .= " and ciu.numDocumento = $numCedula ";
			
			if( $bolPostualtePrincipal ){
				$sql .= "and hog.seqParentesco = 1 ";
			}
			try{
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$seqFormulario = $objRes->fields['seqFormulario'];
				}
			}catch ( Exception $objError ){ }
			return $seqFormulario;
		}
		
	} // fin clase
?>