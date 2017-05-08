<?php

	class Preguntas {
      
      private $numLimitePreguntas;
      private $arrSpool;
	
      public function Preguntas() {

        $this->numLimitePreguntas = 4; 

        $this->arrSpool[] = "documentoPrincipal";	// 0
        $this->arrSpool[] = "direccion";			   // 1
        $this->arrSpool[] = "telefono";				// 2
        $this->arrSpool[] = "modalidad";			   // 3
        $this->arrSpool[] = "bancoAhorro";			// 4
        $this->arrSpool[] = "bancoCredito";			// 5
        $this->arrSpool[] = "condicionEspecial";	// 6
        $this->arrSpool[] = "estadoCivil";			// 7
        $this->arrSpool[] = "valorCredito";			// 8
        $this->arrSpool[] = "valorAhorro";			// 9
      } // fin constructor
	    
      public function obtenerLimitePreguntas(){
         return $this->numLimitePreguntas;
      }
       
      public function validarRespuesta( $seqFormulario , $numPregunta , $txtRespuesta ){
        global $aptBd;

        // carga los datos del hogar
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario( $seqFormulario );

        // Obtiene el postulante principal
        foreach( $claFormulario->arrCiudadano as $objCiudadano ){
           if( $objCiudadano->seqParentesco == 1 ){
              break;
           }
        }

        $bolRespuesta = false;
        switch( $numPregunta ){
           case 0: // Numero del documento del postulante principal
              if( mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento ) == $txtRespuesta ){
                 $bolRespuesta = true;
              }
           break;
           case 1: // Direccion de residiencia
              if( $claFormulario->txtDireccion == $txtRespuesta ){
                 $bolRespuesta = true;
              }
           break;	
           case 2: // Telefono de residencia
              if( ( $claFormulario->numTelefono1 == $txtRespuesta ) or ( $claFormulario->numTelefono2 == $txtRespuesta ) ){
                 $bolRespuesta = true;
              }
           break;
           case 3: // Modalidad 
              if( $claFormulario->seqModalidad == $txtRespuesta ){
                 $bolRespuesta = true;
              } 
           break;
           case 4: // Banco de Ahorro
              if( ( $claFormulario->seqBancoCuentaAhorro == $txtRespuesta ) or ( $claFormulario->seqBancoCuentaAhorro2 == $txtRespuesta ) ){
                 $bolRespuesta = true;
              }
           break;
           case 5: // Banco de Credito
              if( $claFormulario->seqBancoCredito == $txtRespuesta ){
                 $bolRespuesta = true;
              }
           break;
           case 6: // Condicion Especial del postulante principal
              if( ( $objCiudadano->seqCondicionEspecial == $txtRespuesta ) 
               or ( $objCiudadano->seqCondicionEspecial2 == $txtRespuesta ) 
               or ( $objCiudadano->seqCondicionEspecial3 == $txtRespuesta ) ){
                 $bolRespuesta = true;
              }
           break;
           case 7: // Estado civil del postulante principal
              if( $objCiudadano->seqEstadoCivil == $txtRespuesta ){
                 $bolRespuesta = true;
              }
           break;
           case 8: // valor del credito
              if( $claFormulario->valCredito == $txtRespuesta ){
                 $bolRespuesta = true;
              }
           break;
           case 9: // Valor del ahorro
              if( ( $claFormulario->valSaldoCuentaAhorro == $txtRespuesta ) or ( $claFormulario->valSaldoCuentaAhorro2 == $txtRespuesta ) ){
                 $bolRespuesta = true;
              }
           break;
           
        }

        return $bolRespuesta;

      } // fin validar respuesta

      public function obtenerPregunta( $numDocumento ){
         $arrPreguntas = array();
         do {
            $numPreguntaAleatoria = intval( rand( 0 , ( count( $this->arrSpool ) - 1 ) ) );
            if( ! isset( $arrPreguntas[ $numPreguntaAleatoria ] ) ){
               $fncPregunta = $this->arrSpool[ $numPreguntaAleatoria ];
               if( $fncPregunta != "" ){
                  $arrPreguntas[ $numPreguntaAleatoria ] = $this->$fncPregunta( $numDocumento );
               }
               $i++;
            }
         } while ( $i < $this->obtenerLimitePreguntas () );
         
         return $arrPreguntas;
      } // obtener pregunta
	   
      /**
       * ESTABLECE UN ORDEN ALEATORIO PARA LAS RESPUESTAS
       * QUE SE MUESTRAN AL CIUDADANO
       * @param array arrRespuestas
       * @return array arrOrdenCorrecto
       */
      
      private function desordenarRespuestas( $arrRespuestas ){
	    	
			// copia el arreglo
			$arrOrdenAleatorio = array();
			foreach( $arrRespuestas as $txtClave => $txtValor ){
				$arrOrdenAleatorio[] = $txtValor;
			}    	
	    	
	    	// Orden aleatorio de las opciones
	    	shuffle( $arrOrdenAleatorio );
	    	
	    	// Copiando las respuestas en el orden correcto
	    	$arrOrdenCorrecto = array();
	    	foreach( $arrOrdenAleatorio as $txtValor ){
				foreach( $arrRespuestas as $txtClave => $txtRespuesta ){
					if( $txtValor == $txtRespuesta ){
						$arrOrdenCorrecto[ $txtClave ] = $txtRespuesta;
					}
				}
	    	}
	    	
	    	// retorna el arreglo de respuestas desordenado
	    	return $arrOrdenCorrecto;
	    }
      
      /**
       * SELECCIONA ALEATORIAMENTE LOS NUMEROS
       * DE LOS POSTULANTES PRINCIPALES 
       * DE LA BASE DE DATOS
       * @author Bernardo Zerda
       * @param Integer numDocumento
       * @return Array arrPregunta
       * @version 1.0 Mayo 2010 
       */
      private function documentoPrincipal( $numDocumento ){ 
         global $aptBd;

         // texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Cu&aacute;l de los siguientes es el n&uacute;mero de documento del postulante principal de su hogar";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	    	
	    	// extrae el postulante principal
	    	foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
	    		if( $objCiudadano->seqParentesco == 1 ){
	    			break;
	    		}
	    	}
	    	
	    	// una de las respuestas (la correcta)
         $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
	    	$arrPregunta[ "respuesta" ][ $numDocumento ] = number_format( $numDocumento ); 
			
			// total de ciudadanos
			try{
				$sql = "
					SELECT COUNT(seqCiudadano) as cuenta
					FROM T_CIU_CIUDADANO
					WHERE seqCiudadano <> $seqCiudadano
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 100000;
				}
			} catch ( Exception $objError ){
				$numTotal = 100000;
			}    	
	    	
	    	// tres documentos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT numDocumento
					FROM T_CIU_CIUDADANO
					WHERE seqCiudadano <> $seqCiudadano
					ORDER BY seqCiudadano
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
               $numDocumento = mb_ereg_replace("[^0-9]", "", $objRes->fields[ "numDocumento" ] );
	    			$arrPregunta[ "respuesta" ][ $numDocumento ] = number_format( $numDocumento ); 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		do {
	    			srand( time() );
	    			$numAleatorio = rand( 10000000 , 80000000 );
	    			$arrPregunta[ "respuesta" ][ $numAleatorio ] = number_format( $numAleatorio );
	    		} while ( count( $arrPregunta[ "respuesta" ] ) < 4 );
	    	} 
	    	
			$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );			
	    	
	    	return $arrPregunta; 
	    }
	    
      /**
       * SELECCIONA ALEATORIAMENTE DIRECCIONES
       * DE LOS FORMULARIOS DE LA BASE DE DATOS
       * @author Bernardo Zerda
       * @param Integer numDocumento
       * @return Array arrPregunta
       * @version 1.0 Mayo 2010 
       */
	    
      private function direccion( $numDocumento ){ 
        global $aptBd;    
	 		
         // texto de la pregunta
         $arrPregunta[ "texto" ] = "Con cu&aacute;l de las siguientes direcciones est&aacute; usted relacionado";

         // Extrae la informacion del hogar
         $seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
         $claFormulario = new FormularioSubsidios();
         $claFormulario->cargarFormulario( $seqFormulario );

         // direccion del hogar
         $arrPregunta[ "respuesta" ][ $claFormulario->txtDireccion ] = textoMayusculas( $claFormulario->txtDireccion ); 

         // total de direcciones
         try{
            $sql = "
               SELECT COUNT(txtDireccion) as cuenta
               FROM T_FRM_FORMULARIO
               WHERE txtDireccion <> ''
               AND seqFormulario <> $seqFormulario
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->fields ){
               $numTotal = $objRes->fields[ "cuenta" ];
            }else{
               $numTotal = 100000;
            }
         } catch ( Exception $objError ){
            $numTotal = 100000;
         }    	

         // tres documentos aleatorios
         try {
            srand( time() );
            $numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
            $sql = "
               SELECT txtDireccion
               FROM T_FRM_FORMULARIO
               WHERE seqFormulario <> $seqFormulario
               ORDER BY seqFormulario
               LIMIT $numInicioAleatorio , 3
            ";
            $objRes = $aptBd->execute( $sql ); 
            while( $objRes->fields ){
               $arrPregunta[ "respuesta" ][ $objRes->fields[ "txtDireccion" ] ] = textoMayusculas( $objRes->fields[ "txtDireccion" ] ); 
               $objRes->MoveNext();
            }
         } catch ( Exception $objError ){
            $arrPregunta[ "respuesta" ][ "Cl 72 A 63-12" ] = textoMayusculas( "Cl 72 A 63-12" );
            $arrPregunta[ "respuesta" ][ "AvCl 64 C 68 B-83 L-4 Brr. Guali" ] = textoMayusculas( "AvCl 64 C 68 B-83 L-4 Brr. Guali" );
            $arrPregunta[ "respuesta" ][ "Cl 24 26-70" ] = textoMayusculas( "Cl 24 26-70" );
         } 

         $arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );

         return $arrPregunta;
      }

      /**
      * SELECCIONA ALEATORIAMENTE TELEFONOS
      * @author Bernardo Zerda
      * @param Integer numDocumento
      * @return Array arrPregunta
      * @version 1.0 Mayo 2010 
      */
      private function telefono( $numDocumento ){ 
         global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Con cu&aacute;l de los siguientes tel&eacute;fonos est&aacute; usted relacionado";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		// telefono del hogar
	 		if( $claFormulario->numTelefono1 != 0 ){
	 			$arrPregunta[ "respuesta" ][ $claFormulario->numTelefono1 ] = $claFormulario->numTelefono1 ." ";	
	 		}elseif( $claFormulario->numTelefono2 != 0 ){
	 			$arrPregunta[ "respuesta" ][ $claFormulario->numTelefono2 ] = $claFormulario->numTelefono2 ." ";
	 		}else{
	 			$arrPregunta[ "respuesta" ][ $claFormulario->numCelular ] = $claFormulario->numCelular ." ";
	 		}
	 		
	 		// total de telefonos
			try{
				$sql = "
					SELECT COUNT(numTelefono1) as cuenta
					FROM T_FRM_FORMULARIO
					WHERE numTelefono1 <> 0
					AND seqFormulario <> $seqFormulario
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 100000;
				}
			} catch ( Exception $objError ){
				$numTotal = 100000;
			}
			
			// tres documentos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT numTelefono1
					FROM T_FRM_FORMULARIO
					WHERE numTelefono1 <> 0
					AND seqFormulario <> $seqFormulario
					ORDER BY seqFormulario
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			$arrPregunta[ "respuesta" ][ $objRes->fields[ "numTelefono1" ] ] = $objRes->fields[ "numTelefono1" ] ." "; 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ 2086825 ] = "2086825 ";
	    		$arrPregunta[ "respuesta" ][ 6194385 ] = "6194385 ";
	    		$arrPregunta[ "respuesta" ][ 8104338 ] = "8104338 ";
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );		
			
			return $arrPregunta;
	    }
	    
	    /**
	     * SELECCIONA ALEATORIAMENTE MODALIDAD
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	    private function modalidad( $numDocumento ){ 
	    	global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Con cu&aacute;l de las siguientes modalidades del Subsidio Distrital de Vivienda est&aacute; usted relacionado";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	    	
	    	// modalidad del hogar
	 		$arrPregunta[ "respuesta" ][ $claFormulario->seqModalidad ] = 
                 utf8_encode( utf8_decode( obtenerNombres( "T_FRM_MODALIDAD" , "seqModalidad" , $claFormulario->seqModalidad ) ) ); 
	    	
	    	// las otras modalidades
	    	try {
		    	$sql = "
			    	SELECT seqModalidad, txtModalidad
					FROM T_FRM_MODALIDAD
					WHERE seqModalidad <> " . $claFormulario->seqModalidad . "
					LIMIT 0 , 3
				";
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$arrPregunta[ "respuesta" ][ $objRes->fields[ "seqModalidad" ] ] = utf8_encode( utf8_decode( $objRes->fields[ "txtModalidad" ] ) );
					$objRes->MoveNext();
				}
				
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ 3 ] = "Mejoramiento de Habitabilidad";
	    		$arrPregunta[ "respuesta" ][ 2 ] = "Construcci&oacute;n";
	    		$arrPregunta[ "respuesta" ][ 1 ] = "Adquisici&oacute; de Vivienda";
	    		$arrPregunta[ "respuesta" ][ 4 ] = "Mejoramiento Estructural";
	    		unset( $arrPregunta[ "respuesta" ][ $claFormulario->seqModalidad ] );
	    	}
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );

	    	return $arrPregunta;	
	    }
	    
	    /**
	     * SELECCIONA ALEATORIAMENTE BANCOS DEL AHORRO
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	    private function bancoAhorro( $numDocumento ){ 
	    	 global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Con cu&aacute;l de los siguientes bancos tiene cuenta de ahorros";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		// banco del hogar
	 		if( $claFormulario->seqBancoCuentaAhorro != 1 ){  
	 			$arrPregunta[ "respuesta" ][ $claFormulario->seqBancoCuentaAhorro ] = textoMayusculas( obtenerNombres( "T_FRM_BANCO" , "seqBanco" , $claFormulario->seqBancoCuentaAhorro ) ); 
	 		}else{
	 			$arrPregunta[ "respuesta" ][ $claFormulario->seqBancoCuentaAhorro2 ] = textoMayusculas( obtenerNombres( "T_FRM_BANCO" , "seqBanco" , $claFormulario->seqBancoCuentaAhorro2 ) );
	 		}
	 		
	 		// total de bancos
			try{
				$sql = "
					SELECT COUNT(seqBanco) as cuenta
					FROM T_FRM_BANCO
					WHERE seqBanco NOT IN ( " . $claFormulario->seqBancoCuentaAhorro . " , " . $claFormulario->seqBancoCuentaAhorro2 . " )
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 20;
				}
			} catch ( Exception $objError ){
				$numTotal = 20;
			}    	
	 		
	 		// tres bancos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT seqBanco, txtBanco
					FROM T_FRM_BANCO	
					WHERE seqBanco NOT IN ( " . $claFormulario->seqBancoCuentaAhorro . " , " . $claFormulario->seqBancoCuentaAhorro2 . " )				
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			$arrPregunta[ "respuesta" ][ $objRes->fields[ "seqBanco" ] ] = textoMayusculas( $objRes->fields[ "txtBanco" ] ); 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ "BANCO DEL CARIBE" ] = "BANCO DEL CARIBE";
	    		$arrPregunta[ "respuesta" ][ "COOPERATIVA SUPERFIDUCIA" ] = "COOPERATIVA SUPERFIDUCIA";
	    		$arrPregunta[ "respuesta" ][ "PRESTAMOS ANDINA" ] = "PRESTAMOS ANDINA";
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );
	 		
	 		return $arrPregunta;
	    }
	    
	    /**
	     * SELECCIONA ALEATORIAMENTE BANCOS DEL AHORRO
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	     
	    private function bancoCredito( $numDocumento ){ 
	    	 global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Con cu&aacute;l de los siguientes bancos tiene credito";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		// banco de credito del hogar
 			$arrPregunta[ "respuesta" ][ $claFormulario->seqBancoCredito ] = textoMayusculas( obtenerNombres( "T_FRM_BANCO" , "seqBanco" , $claFormulario->seqBancoCredito ) ); 
	 		
	 		// total de bancos
			try{
				$sql = "
					SELECT COUNT(seqBanco) as cuenta
					FROM T_FRM_BANCO
					WHERE seqBanco <> " . $claFormulario->seqBancoCredito . "
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 20;
				}
			} catch ( Exception $objError ){
				$numTotal = 20;
			}    	
	 		
	 		// tres bancos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT seqBanco, txtBanco
					FROM T_FRM_BANCO
					WHERE seqBanco <> " . $claFormulario->seqBancoCredito . "					
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			$arrPregunta[ "respuesta" ][ $objRes->fields[ "seqBanco" ] ] = textoMayusculas( $objRes->fields[ "txtBanco" ] ); 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ "BANCO DEL CARIBE" ] = "BANCO DEL CARIBE";
	    		$arrPregunta[ "respuesta" ][ "COOPERATIVA SUPERFIDUCIA" ] = "COOPERATIVA SUPERFIDUCIA";
	    		$arrPregunta[ "respuesta" ][ "PRESTAMOS ANDINA" ] = "PRESTAMOS ANDINA";
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );
	    	
	    	return $arrPregunta;
	    }
	    
		/**
	     * SELECCIONA ALEATORIAMENTE CONDICIONES ESPECUALES
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	     
	    private function condicionEspecial( $numDocumento ){ 
	    	 global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Cu&aacute;l de las siguientes condiciones especiales presenta el postulante principal de su hogar";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	    	
	    	foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
	    		if( $objCiudadano->seqParentesco == 1 ){
	    			break;
	    		}
	    	}
	    	
	    	// condicion especial del principal
	    	if( $objCiudadano->seqCondicionEspecial != 6 ){
	 			$seqCondicionEspecial = utf8_decode( $objCiudadano->seqCondicionEspecial );  
	    	}elseif( $objCiudadano->seqCondicionEspecial2 != 6 ){
				$seqCondicionEspecial = utf8_decode( $objCiudadano->seqCondicionEspecial2 );	    		
	    	}else{
	    		$seqCondicionEspecial = utf8_decode( $objCiudadano->seqCondicionEspecial3 );
	    	}
	    	
	    	$arrPregunta[ "respuesta" ][ $seqCondicionEspecial ] = 
                  utf8_encode( utf8_decode( obtenerNombres( "T_CIU_CONDICION_ESPECIAL" , "seqCondicionEspecial" , $seqCondicionEspecial ) ) );
	    	
	    	// las otras condiciones especiales
	    	try {
		    	$sql = "
			    	SELECT seqCondicionEspecial, txtCondicionEspecial
					FROM T_CIU_CONDICION_ESPECIAL
					WHERE seqCondicionEspecial <> $seqCondicionEspecial
					LIMIT 0 , 3
				";
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$arrPregunta[ "respuesta" ][ $objRes->fields[ "seqCondicionEspecial" ] ] = utf8_encode( utf8_decode( $objRes->fields[ "txtCondicionEspecial" ] ) );
					$objRes->MoveNext();
				}
				
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ 1 ] = textoMayusculas( "Mujer / Hombre Cabeza de Familia" );
	    		$arrPregunta[ "respuesta" ][ 2 ] = textoMayusculas( "Mayor de 65 a&nacute;os" );
	    		$arrPregunta[ "respuesta" ][ 3 ] = textoMayusculas( "Discapacitado" );
	    		$arrPregunta[ "respuesta" ][ 6 ] = textoMayusculas( "Ninguno" );
	    		unset( $arrPregunta[ "respuesta" ][ $seqCondicionEspecial ] );
	    	}
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );

	    	return $arrPregunta;	
	    }
	    
	    /**
	     * SELECCIONA ALEATORIAMENTE ESTADOS CIVILES
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	     
	    private function estadoCivil( $numDocumento ){ 
	    	 global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Cu&aacute;l de los siguientes es el estado civil del postulante principal de su hogar";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
	    		if( $objCiudadano->seqParentesco == 1 ){
	    			break;
	    		}
	    	}
	 		
	 		// banco de credito del hogar
 			$arrPregunta[ "respuesta" ][ $objCiudadano->seqEstadoCivil ] = obtenerNombres( "T_CIU_ESTADO_CIVIL" , "seqEstadoCivil" , $objCiudadano->seqEstadoCivil ); 
	 		
	 		// tres documentos aleatorios
	    	try {
	    		$sql = "
	    			SELECT seqEstadoCivil, txtEstadoCivil
					FROM T_CIU_ESTADO_CIVIL
					WHERE seqEstadoCivil <> " . $objCiudadano->seqEstadoCivil . "
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			if( count( $arrPregunta[ "respuesta" ] ) < 4 ){
	    				$arrPregunta[ "respuesta" ][ $objRes->fields[ "seqEstadoCivil" ] ] = $objRes->fields[ "txtEstadoCivil" ];
	    			} 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ "UNION LIBRE" ] = "Separado(a)";
	    		$arrPregunta[ "respuesta" ][ "NINGUNO DE LOS ANTERIORES" ] = "Soltero(a) con Union Marital";
	    		$arrPregunta[ "respuesta" ][ "TODOS LOS ANTERIORES" ] = "Viudo(a)";
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );
	    	
	    	return $arrPregunta;
	    }
	    
	    /**
	     * SELECCIONA ALEATORIAMENTE VALORES DE CREDITO
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	     	    
	    private function valorCredito( $numDocumento ){ 
	    	global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Cu&aacute;l es el valor de su credito";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		// valor del credito
 			$arrPregunta[ "respuesta" ][ $claFormulario->valCredito ] = "\$ " . number_format( $claFormulario->valCredito );
	 		
	 		// total de valores de credito
			try{
				$sql = "
					SELECT COUNT( DISTINCT valCredito ) as cuenta
					FROM T_FRM_FORMULARIO
					WHERE valCredito <> " . $claFormulario->valCredito . "
					AND seqFormulario <> $seqFormulario
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 1000;
				}
			} catch ( Exception $objError ){
				$numTotal = 1000;
			}
			
			// tres documentos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT valCredito
					FROM T_FRM_FORMULARIO
					WHERE valCredito <> " . $claFormulario->valCredito . "
					AND seqFormulario <> $seqFormulario
					ORDER BY seqFormulario
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			$arrPregunta[ "respuesta" ][ $objRes->fields[ "valCredito" ] ] = "\$ " . number_format( $objRes->fields[ "valCredito" ] );  
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ 16611391 ] = "\$ " . number_format( 16611391 );
	    		$arrPregunta[ "respuesta" ][ 29577022 ] = "\$ " . number_format( 29577022 );
	    		$arrPregunta[ "respuesta" ][ 12683016 ] = "\$ " . number_format( 12683016 );
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );			
			
			return $arrPregunta;
	    }
	    
		/**
	     * SELECCIONA ALEATORIAMENTE VALORES DE AHORRO
	     * @author Bernardo Zerda
	     * @param Integer numDocumento
	     * @return Array arrPregunta
	     * @version 1.0 Mayo 2010 
	     */
	     
	    private function valorAhorro( $numDocumento ){ 
	    	global $aptBd;    
	 		
	 		// texto de la pregunta
	    	$arrPregunta[ "texto" ] = "Cu&aacute;l es el valor del ahorro";
	    	
	    	// Extrae la informacion del hogar
	    	$seqFormulario = Ciudadano::formularioVinculado( $numDocumento );
	    	$claFormulario = new FormularioSubsidios();
	    	$claFormulario->cargarFormulario( $seqFormulario );
	 		
	 		// direccion del hogar
	 		if( $claFormulario->seqBancoCuentaAhorro != 1 ){  
	 			$arrPregunta[ "respuesta" ][ $claFormulario->valSaldoCuentaAhorro ] = "\$ "  . number_format( $claFormulario->valSaldoCuentaAhorro ); 
	 		}else{
	 			$arrPregunta[ "respuesta" ][ $claFormulario->valSaldoCuentaAhorro2 ] = "\$ "  . number_format( $claFormulario->valSaldoCuentaAhorro2 );
	 		}
	 		
	 		// total de bancos
			try{
				$sql = "
					SELECT COUNT( DISTINCT valSaldoCuentaAhorro) as cuenta
					FROM T_FRM_FORMULARIO
					WHERE seqFormulario <> $seqFormulario
				";
				$objRes = $aptBd->execute( $sql );
				if( $objRes->fields ){
					$numTotal = $objRes->fields[ "cuenta" ];
				}else{
					$numTotal = 1000;
				}
			} catch ( Exception $objError ){
				$numTotal = 1000;
			}    	
	 		
	 		// tres documentos aleatorios
	    	try {
	    		srand( time() );
	    		$numInicioAleatorio = rand( 0 , ( $numTotal - 4 ) );
	    		$sql = "
	    			SELECT DISTINCT valSaldoCuentaAhorro
					FROM T_FRM_FORMULARIO
					WHERE seqFormulario <> $seqFormulario
					AND valSaldoCuentaAhorro <> " . $claFormulario->valSaldoCuentaAhorro . "
					LIMIT $numInicioAleatorio , 3
	    		";
	    		$objRes = $aptBd->execute( $sql ); 
	    		while( $objRes->fields ){
	    			$arrPregunta[ "respuesta" ][ $objRes->fields[ "valSaldoCuentaAhorro" ] ] = "\$ "  . number_format( $objRes->fields[ "valSaldoCuentaAhorro" ] ); 
	    			$objRes->MoveNext();
	    		}
	    	} catch ( Exception $objError ){
	    		$arrPregunta[ "respuesta" ][ 862873 ]  = "\$ "  . number_format( 862873 );
	    		$arrPregunta[ "respuesta" ][ 2000000 ] = "\$ "  . number_format( 2000000 );
	    		$arrPregunta[ "respuesta" ][ 943956 ]  = "\$ "  . number_format( 943956 );
	    	} 
	    	
	    	$arrPregunta[ "respuesta" ] = $this->desordenarRespuestas( $arrPregunta[ "respuesta" ] );
	 		
	 		return $arrPregunta;
	    }
	    
      public function bloquearDocumento( $numDocumento ){
         global $aptBd;
         
         setlocale(LC_TIME , 'spanish' );
         date_default_timezone_set("America/Bogota");
         
         try {

            $sql = "
               SELECT numDemora
               FROM T_CIU_BLOQUEOS
               WHERE numDocumento = $numDocumento
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() == 0 ){

               $numDemora = 30; // minutos
               $fchFinBloqueo = date( "Y-m-d H:i:s" , strtotime( "+$numDemora MINUTES" ) );

               $sql = "
                 INSERT INTO T_CIU_BLOQUEOS (
                    numDocumento,
                    fchFinBloqueo,
                    numDemora
                 ) VALUES (
                    '$numDocumento',
                    '$fchFinBloqueo',
                    '$numDemora'
                 )
               ";
               $aptBd->execute( $sql );
               
            } else {
               
               $numMaximo = 1440; // 24 horas (1440 minutos)
               $numDemora = $objRes->fields['numDemora']; // demora actual
               
               if( ( $numDemora * 2 ) > $numMaximo ){
                  $numDemora = $numMaximo;
               }else {
                  $numDemora = $numDemora * 2;
               }
               
               $fchFinBloqueo = date( "Y-m-d H:i:s" , strtotime( "+$numDemora MINUTES" ) );
               
               $sql = "
                  UPDATE T_CIU_BLOQUEOS SET
                     fchFinBloqueo = '$fchFinBloqueo',
                     numDemora = '$numDemora'
                  WHERE numDocumento = $numDocumento
               ";
               
               $aptBd->execute( $sql );
               
            }

         } catch ( Exception $objError ){
            $fchFinBloqueo = false;
         }

         return $fchFinBloqueo;
      }
      
      public function quitarBloqueo( $numDocumento ){
         global $aptBd;
         try {
            $sql = "
               DELETE 
               FROM T_CIU_BLOQUEOS
               WHERE numDocumento = $numDocumento
            ";
            $aptBd->execute( $sql );
            return true;  
         } catch( Exception $objError ){
            return false;
         }
      }
      
      public function obtenerBloqueo( $numDocumento ){
         global $aptBd;
         setlocale(LC_TIME , 'spanish' );
         date_default_timezone_set("America/Bogota");
         try {
            $sql = "
               SELECT fchFinBloqueo
               FROM T_CIU_BLOQUEOS
               WHERE numDocumento = $numDocumento
            ";
            $objRes = $aptBd->execute( $sql );
            if( $objRes->RecordCount() == 0 ){
               return false;
            } else {
               return $objRes->fields['fchFinBloqueo'];
            }
         } catch( Exception $objError ){
            return false;
         }
      }
      
       
	} // fin clase

?>