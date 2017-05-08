<?php

	class AsignacionFormularios {
	
		public $arrTutores;
		public $arrTutoresNoAsignados;
		public $arrTutoresXCoordinadores;
		public $arrHogaresSinAsignar;
		public $arrCoordinadores;
		public $arrNombreTutor;
		public $arrNombreTutorNoCuenta;
		
		public $txtTutoresInformacionJS;
		public $txtHogaresSinAsignarJS;
		public $txtTutoresMasivaJS;
//		public $txtTutoresNoAsignadosJS;
//		public $txtTutoresXCoordinadoresJS;


	
	    function AsignacionFormularios() {
	    	
	    	$this->obtenerTutores( );
	    	$this->obtenerCoordinadores( );
	    	$this->obtenerTutoresAsignados( );
	    	$this->obtenerHogaresSinAsignar( );
	    	
	    	$this->txtTutoresInformacionJS = $this->arrayToJsTree( $this->arrTutores, "Tutores", true );
	    	if( count( $this->arrHogaresSinAsignar ) > 0 ){
	    		$this->txtHogaresSinAsignarJS = $this->arrayToJsDataTable( $this->arrHogaresSinAsignar, "NoAsignados" );
	    	}
	    	$arrTutoresMasiva = array_merge( $this->arrTutoresXCoordinadores, $this->arrTutoresNoAsignados );
//	    	$this->txtTutoresNoAsignadosJS = $this->arrayToJsTree( $this->arrTutoresNoAsignados, "NoAsignados" );
	    	$this->txtTutoresMasivaJS = $this->arrayToJsTree( $arrTutoresMasiva, "TutoresMasiva", false, true );
	    	
	    }
	    
	    private function obtenerTutoresAsignados( ){
	    
	    	global $aptBd;
	    	$arrTutores 				= $this->arrTutores;
	    	$arrTutoresNoAsignados 		= array( );
	    	$arrSeqTutores 				= array( );
	    	$arrNombreTutor 			= $this->arrNombreTutor;
	    	$arrNombreTutoresAsignados  = array( );
	    	$arrCoodrinadores 			= $this->arrCoordinadores;
	    	$txtTutorDesembolso 		= "Tutores Desembolso";
	    	$txtTutorPostulacion 		= "Tutores Postulacion";
	    	
	    	foreach( $arrTutores as $arrGrupoTutores ){
	    		foreach( $arrGrupoTutores as $seqUsuario => $txtNombre ){
	    			$arrSeqTutores[] = $seqUsuario;
	    		}
	    	}
	    	
	    	$sql = "
				SELECT 
				DISTINCT seqUsuario,
				seqUsuarioCoordinador
				FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
				ORDER BY 1
			";
			$objRes = $aptBd->execute( $sql );
			$arrTutoresXCoordinadores 	= array( );
			$arrTutoresAsignados 		= array( );
			while( $objRes->fields ){
				
				$txtGrupoTutor = "";
				if( array_key_exists( $objRes->fields["seqUsuario"], $arrTutores[ $txtTutorDesembolso ] ) ){
					$txtGrupoTutor = $txtTutorDesembolso;
				}else if( array_key_exists( $objRes->fields["seqUsuario"], $arrTutores[ $txtTutorPostulacion ] ) ){
					$txtGrupoTutor = $txtTutorPostulacion;
				}
				
				$arrTutoresAsignados[] 	= $objRes->fields["seqUsuario"];
				$arrTemporal 			= &$arrTutoresXCoordinadores[ $arrCoodrinadores[ $objRes->fields[ "seqUsuarioCoordinador" ] ] ][ $txtGrupoTutor ];
				$arrTemporal[ $objRes->fields["seqUsuario"] ] = $arrNombreTutor[ $objRes->fields["seqUsuario"] ];
				$objRes->MoveNext();
			}
	    	
	    	$arrTutoresNoAsignados = array_diff( $arrSeqTutores, $arrTutoresAsignados );
	    	$arrNombreTutoresNoAsignados 		  = array( );
	    	
	    	foreach( $arrTutoresNoAsignados as $seqTutor ){
	    		$arrNombreTutoresNoAsignados[ $seqTutor ] = $arrNombreTutor[ $seqTutor ];
	    	}
	    	
	    	$this->arrTutoresNoAsignados["NoAsignados"] = $arrNombreTutoresNoAsignados;
	    	$this->arrTutoresXCoordinadores 			= $arrTutoresXCoordinadores;
	    	
	    }
	    
	    private function obtenerHogaresSinAsignar( ){
	    	
	    	global $aptBd;
	    	
	    	$sql = "
				SELECT 
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS nombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE 
					frm.seqFormulario NOT IN
					(
						SELECT 
							fus.seqFormulario
						FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS fus
					)
					AND hog.seqParentesco = 1
				LIMIT 100
			";
			
			$objRes = $aptBd->execute( $sql );
			$arrNoAsignados = array( );
			while( $objRes->fields ){
				$arrTemporal = &$arrNoAsignados[];
				$arrTemporal["Documento"] 		= $objRes->fields['numDocumento'];
				$arrTemporal["NombreCiudadano"] = $objRes->fields['nombre'];
				$arrTemporal["Asignado"] 		= "No Asignado";
				$objRes->MoveNext();
			}
			$this->arrHogaresSinAsignar = $arrNoAsignados;
	    	
	    }
	    
	    private function obtenerTutores( ){
	    	
	    	global $aptBd;
	    	
	    	$sql = "
					SELECT 
						ucwords(concat(usu.txtNombre, ' ', usu.txtApellido)) AS usuario,
						ucwords(gru.txtGrupo) AS Grupo,
						usu.seqUsuario
					FROM T_COR_GRUPO gru
						INNER JOIN T_COR_PROYECTO_GRUPO pro ON pro.seqGrupo = gru.seqGrupo
						INNER JOIN T_COR_PERFIL per ON per.seqProyectoGrupo = pro.seqProyectoGrupo
						INNER JOIN T_COR_USUARIO usu ON per.seqUsuario = usu.seqUsuario
					WHERE gru.seqGrupo IN (6, 8, 7)
					AND usu.seqUsuario <> 1
					AND usu.bolActivo = 1
					AND usu.seqUsuario NOT IN (
						SELECT 
							usu1.seqUsuario
						FROM T_COR_GRUPO gru1
							INNER JOIN T_COR_PROYECTO_GRUPO pro1 ON pro1.seqGrupo = gru1.seqGrupo
							INNER JOIN T_COR_PERFIL per1 ON per1.seqProyectoGrupo = pro1.seqProyectoGrupo 
							INNER JOIN T_COR_USUARIO usu1 ON per1.seqUsuario = usu1.seqUsuario
						WHERE gru1.seqGrupo IN (18, 9, 13, 14, 7)
					)
					ORDER BY 2, 1
				";
			$objRes 				= $aptBd->execute( $sql );
			$arrTutores 			= array( );
			$arrNombreTutorNoCuenta = array( );
			while( $objRes->fields ){
				$seqUsuario = $objRes->fields['seqUsuario'];
				$sql = "
						SELECT count(1) AS cuenta
						FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS
						WHERE seqUsuario = $seqUsuario
						";
				$objResUsuario = $aptBd->execute( $sql );
				$arrTutores[ $objRes->fields['Grupo'] ][ $seqUsuario ] 	= $objRes->fields['usuario'] ."( ". $objResUsuario->fields['cuenta'] ." )";
				$arrNombreTutor[ $seqUsuario ] 							= $objRes->fields['usuario'] ."( ". $objResUsuario->fields['cuenta'] ." )";
				$arrNombreTutorNoCuenta[ $seqUsuario ] 					= $objRes->fields['usuario'] ;
				$objRes->MoveNext();
			}
			$this->arrTutores 				= $arrTutores;
			$this->arrNombreTutor 			= $arrNombreTutor;
			$this->arrNombreTutorNoCuenta 	= $arrNombreTutorNoCuenta;
	    	
	    }

		private function obtenerCoordinadores( ){
	    	
	    	global $aptBd;
	    	
	    	$sql = "
					SELECT 
						ucwords(concat(usu.txtNombre, ' ', usu.txtApellido)) AS usuario,
						usu.seqUsuario
					FROM T_COR_GRUPO gru
						INNER JOIN T_COR_PROYECTO_GRUPO pro ON pro.seqGrupo = gru.seqGrupo
						INNER JOIN T_COR_PERFIL per ON per.seqProyectoGrupo = pro.seqProyectoGrupo
						INNER JOIN T_COR_USUARIO usu ON per.seqUsuario = usu.seqUsuario
					WHERE gru.seqGrupo IN (7) 
					AND usu.seqUsuario <> 1
					AND usu.bolActivo = 1
					ORDER BY 1
				";
				
			$objRes = $aptBd->execute( $sql );
			$arrCoordinadores = array( );
			while( $objRes->fields ){
				$arrCoordinadores[ $objRes->fields['seqUsuario'] ] = $objRes->fields['usuario'];
				$objRes->MoveNext();
			}
			$this->arrCoordinadores = $arrCoordinadores;
	    	
	    }
	    
	    public function generarReporteTotalHogar( ){
	    	
	    	global $aptBd;
	    	
	    	$sql = "
				SELECT 
					frm.seqFormulario,
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS nombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE 
					frm.seqFormulario NOT IN
					(
						SELECT 
							fus.seqFormulario
						FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS fus
					)
					AND hog.seqParentesco = 1
			";
			$objRes = $aptBd->execute( $sql );
			$arrDatosTabla = array( );
			
			if( $objRes->fields ){
				
				$txtNombreArchivo = "ReporteTotalAsignados_". date("Y-m-d") . ".xls";
				header("Content-disposition: attachment; filename=$txtNombreArchivo");
				header("Content-Type: application/force-download");
				header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
				header("Content-Transfer-Encoding: binary");
				header("Pragma: no-cache");
				header("Expires: 1"); 
				
				echo utf8_decode( implode( "\t", array_keys( $objRes->fields ) ) ). "\r\n";
				
				while( $objRes->fields ){
					$seqFormulario 	= $objRes->fields["seqFormulario"];
					$numDocumento 	= $objRes->fields["numDocumento"];
					$txtNombre 		= $objRes->fields["nombre"];
					echo 	$seqFormulario ."\t". 
							$numDocumento ."\t".
							utf8_decode( $txtNombre ) ."\t"
					;
					echo "\r\n";
					$objRes->MoveNext();
				}
				
			}else{
				$arrErrores[] = "El tutor no tiene Hogares Asignados";
			}
			
			if( !empty( $arrErrores ) ){
				imprimirMensajes( $arrErrores , array() );
			}	
			
	    }
	    
	    public function generarReporteTutorHogar( $seqTutor ){
	    	
	    	global $aptBd;
	    	
	    	// Obtengo los secuenciales de formulario que tiene el tutor y su coordinador respectivo
	    	$sql = "
				SELECT 
					seqFormulario, 
					seqUsuarioCoordinador
				FROM T_FRM_FORMULARIO_USUARIOS_ASIGNADOS 
				WHERE seqUsuario = $seqTutor
			";
			
			$objRes = $aptBd->execute( $sql );
			$arrSecuenciales = array();
			$arrUsuarios 	 = array( );
			$arrTotal = array( );
			while( $objRes->fields ){
				$arrTotal[ $objRes->fields['seqFormulario'] ] = $objRes->fields['seqUsuarioCoordinador'];
				$arrSecuenciales[] 	= $objRes->fields['seqFormulario'];
				$arrUsuarios[] 		= $objRes->fields['seqUsuarioCoordinador'];
				$objRes->MoveNext();
			}
			
			$arrUsuarios = array_unique( $arrUsuarios );
			$arrUsuarios[] = $seqTutor;
			
			// Obtener el nombre del Usuario y los Coordinadores que tiene
			$sql = "
				SELECT 
					seqUsuario,
					concat(txtNombre, ' ', txtApellido) as Nombre
				FROM T_COR_USUARIO
				WHERE seqUsuario in ( ". implode( ", ", $arrUsuarios ) ." )
			";
			$objRes = $aptBd->execute( $sql );
			$txtNombreUsuario = "";
			$arrCoordinadores = array();
			while( $objRes->fields ){
				
				if( $objRes->fields['seqUsuario'] == $seqTutor ){
					$txtNombreUsuario = $objRes->fields['Nombre'];
				}else{
					$arrCoordinadores[ $objRes->fields['seqUsuario'] ] = $objRes->fields['Nombre'];
				}
				$objRes->MoveNext();
			}
			
			$sql = "
				SELECT 
					frm.seqFormulario, 
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE hog.seqParentesco = 1 AND 
				frm.seqFormulario IN ( ". implode(", ", $arrSecuenciales ) ." )
			";
			
			$objRes = $aptBd->execute( $sql );
			$arrDatosTabla = array( );
			while( $objRes->fields ){
				$arrTemporal = &$arrDatosTabla[];
				
				$seqFormulario 	= $objRes->fields["seqFormulario"];
				$numDocumento 	= $objRes->fields["numDocumento"];
				$txtNombre 		= $objRes->fields["Nombre"];
				
				$arrTemporal["Usuario"] 	= $txtNombreUsuario;
				$arrTemporal["Coordinador"] = $arrCoordinadores[ $arrTotal[ $seqFormulario ] ];
				$arrTemporal["Documento"] 	= $numDocumento;
				$arrTemporal["Nombre"] 		= $txtNombre;
				
				$objRes->MoveNext();
			}
			
			if( !empty( $arrDatosTabla ) ){
				
				$txtNombreArchivo = "ReporteHogaresAsignados_". str_replace(" ", "", $txtNombre) ."_". date("Y-m-d") . ".xls";
				header("Content-disposition: attachment; filename=$txtNombreArchivo");
				header("Content-Type: application/force-download");
				header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
				header("Content-Transfer-Encoding: binary");
				header("Pragma: no-cache");
				header("Expires: 1"); 
				
				echo utf8_decode( implode( "\t", array_keys( $arrDatosTabla[0] ) ) ). "\r\n";
				foreach( $arrDatosTabla as $arrDatosFila ){
					echo utf8_decode( implode(  "\t", $arrDatosFila  ) ). "\r\n";
				}
		
			}else{
				$arrErrores[] = "El tutor no tiene Hogares Asignados";
			}
			
			if( !empty( $arrErrores ) ){
				imprimirMensajes( $arrErrores , array() );
			}	
			
	    }
	    
	    public function arrayToJsDataTable( $arrDataTable, $txtDataTable ){
	    	
	    	$txtJs = "var objDataTable$txtDataTable = {";
	    	if( $arrDataTable ){
	    		$txtJs .= "titulos: [";
	    		foreach( $arrDataTable[0] as $txtTitulo => $txtDato){
	    			$txtJs .= "'". $txtTitulo ."',";
	    		}
	    		$txtJs = trim( $txtJs , ", " );
	    		$txtJs .= "], ";
	    		$txtJs .= "datos: [" ; 
	    		foreach( $arrDataTable as $arrDatos ){
	    			$txtJs .= "{";
	    			foreach( $arrDatos as $txtTitulo => $txtDato ){
	    				$txtJs .= ereg_replace( " " , "" , $txtTitulo ) . ": \"$txtDato\" , ";
	    			}
	    			$txtJs = trim( $txtJs , ", " );
	    			$txtJs .= "}, ";
	    		}
	    		
	    		$txtJs = trim( $txtJs , ", " );
	    		$txtJs .= "]";
	    	} 
	    	$txtJs .= "}";
	    	return $txtJs;
	    	
	    }
	    
	    private function arrayToJsTree( $arrArbol, $txtArbol, $bolInformacion = false, $bolDoble = false ){
	    	
	    	$txtInformacion = "";
	    	if( $bolInformacion === true ){
	    		$txtInformacion = "Informacion";
	    	}
	    	
	    	$txtJs = "var objArbol$txtArbol$txtInformacion = new YAHOO.widget.TreeView('treeDivArbolMostrar$txtArbol$txtInformacion', [";
	 
		 	foreach( $arrArbol as $txtGrupo => $arrUsuarios ){
		 		$txtJs .= "{";
		 		$txtJs .= "type: 'text',";
		 		$txtJs .= "label: '$txtGrupo',";
		 		$txtJs .= "children: [";
		 		if( $bolDoble === false ){
			 		foreach( $arrUsuarios as $idUsuario => $txtNombreUsuario ){
			 			$txtJs .= "{";
				 		$txtJs .= "type: 'text',";
				 		$txtJs .= "label: '$txtNombreUsuario',";
//				 		$txtJs .= "idCampo: '". $txtArbol ."_ $idUsuario',";
				 		$txtJs .= "idUsuario: '$idUsuario'";
			 			$txtJs .= "},";
			 		}
		 		}else{
		 			
		 			foreach( $arrUsuarios as $txtUsuario => $arrDatosUsuario ){
		 				$txtJs .= "{";
				 		$txtJs .= "type: 'text',";
				 		if( is_array( $arrDatosUsuario ) ){
				 			$txtJs .= "label: '$txtUsuario',";
				 			$txtJs .= "children: [";
					 		foreach( $arrDatosUsuario as $seqUsuario => $txtNombre ){
					 			$txtJs .= "{";
						 		$txtJs .= "type: 'text',";
						 		$txtJs .= "label: '$txtNombre',";
//						 		$txtJs .= "idCampo: '". $txtArbol ."_ $seqUsuario',";
						 		$txtJs .= "idUsuario: '$seqUsuario'";
					 			$txtJs .= "},";
					 		}
					 		$txtJs = trim( $txtJs , ", " );
				 			$txtJs .= "],";
				 		}else{
				 			$txtJs .= "label: '$arrDatosUsuario',";
//				 			$txtJs .= "idCampo: '". $txtArbol ."_ $txtUsuario',";
						 	$txtJs .= "idUsuario: '$txtUsuario',";
				 		}
				 		$txtJs = trim( $txtJs , ", " );
				 		$txtJs .= "},";
		 			}
		 		}
		 		$txtJs = trim( $txtJs , ", " );
		 		$txtJs .= "]},";
		 	}
		 	$txtJs = trim( $txtJs , ", " );
		 	$txtJs .= "]);";
		 	return $txtJs;
	    	
	    }
	
	}
?>
