<?php

	$txtPrefijoRuta = "../../";	
        
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
        
   //pr( $_POST );
   
	include( "./configuracionReporteador.php" );
	include( "./configuracionReporteadorDesembolso.php" );
	
	$arrErrores 		= array();
	$arrCamposDefecto 	= array("frm.seqFormulario", "frm.txtFormulario");
	$arrCamposSql 		= array();
	$claReportes 		= new Reportes();
	$bolFlag 			= true;
	$arrFormularios 	= array( );
	
	if( $_FILES["fileSecuenciales"]["size"] ){
		$claReportes->cargarSecuencialesFormulario(  );
		$arrFormularios = $claReportes->seqFormularios;
		$arrErrores 	= $claReportes->arrErrores;
	}
	
   $arrSCampos = array();
   if( ! empty( $_POST["sCampos"] ) ){
      foreach( $_POST["sCampos"] as $txtCampo ){
         $txtAliasCampo = "";
         if( strpos( $txtCampo , "." ) !== false ){
            list( $txtAliasCampo , $txtCampo ) = mb_split( "\." , $txtCampo );
         }
         if( $txtAliasCampo == "" ){
            $numPosicion = count( $arrSCampos );
            $arrSCampos[ $numPosicion ] = $txtCampo;
         } else {
            $arrSCampos[ $txtAliasCampo ] = $txtCampo;
         }
      }
   }
  // pr ($_POST["sCampos"]);
   
   if( ! empty( $_POST["sCamposDesembolso"] ) ){
      foreach( $_POST["sCamposDesembolso"] as $txtCampo ){
         $txtAliasCampo = "";
         if( strpos( $txtCampo , "." ) !== false ){
            list( $txtAliasCampo , $txtCampo ) = mb_split( "\." , $txtCampo );
         }
         if( $txtAliasCampo == "" ){
            $numPosicion = count( $arrSCampos );
            $arrSCampos[ $numPosicion ] = $txtCampo;
         } else {
            $arrSCampos[ $txtAliasCampo ] = $txtCampo;
         }
      }
   }
   
//	$arrSCampos 			= ( $_POST["sCampos"] ) ? $_POST["sCampos"] : array( );
//	$arrSCamposDesembolso 	= ( $_POST["sCamposDesembolso"] ) ? $_POST["sCamposDesembolso"]  : array();
//	$arrSCampos = array_merge( $arrSCampos, $arrSCamposDesembolso );

	$bolReporteCuenta = false;
	if( $_POST["criterio"] == "count(*)" ){
		$_POST["sCampos"] = array( "1" );
		$bolReporteCuenta = true;
	}
	
	if( empty( $arrSCampos ) and $bolReporteCuenta === false ){
		$arrErrores[] = "Ingrese los campos a mostrar para el reporteador.";
	}else if( $_POST["condiciones"] or $_FILES["fileSecuenciales"]["size"] ){
		$arrCondiciones = ( empty( $_POST["condiciones"] ) )?array( ):$_POST["condiciones"];
		$arrInnerJoin 	= array();
		$arrInnerJoinCiudadano = array();
		$arrInnerJoinDesembolso = array();
		$arrTitulosCampos = array();
		$arrTitulosCampos[] = "seqFormulario";
		$arrTitulosCampos[] = "txtFormulario";
		//pr($arrCamposDesembolso); die();
		foreach($arrSCampos as $txtAliasCampoAnalizar => $txtCampoAnalizar){
			
         if( ! is_numeric( $txtAliasCampoAnalizar ) ){
            if( isset( $arrCampos[ $txtCampoAnalizar ] ) and $arrCampos[ $txtCampoAnalizar ]['aliasOrigen'] == $txtAliasCampoAnalizar ){
               $arrDatosCampo = $arrCampos[ $txtCampoAnalizar ];
            } else {
               $arrDatosCampo = $arrCamposDesembolso[ $txtCampoAnalizar ];
            }
         } else {
            $arrDatosCampo = ( $arrCampos[$txtCampoAnalizar] ) ? $arrCampos[$txtCampoAnalizar] : $arrCamposDesembolso[$txtCampoAnalizar] ;
         }
         
			if($arrDatosCampo["tablaOrigen"] == "T_CIU_CIUDADANO" || $arrDatosCampo["tablaOrigen"] == "T_FRM_HOGAR" || isset($_POST["criterioPPal"])){
				$txtInnerJoin = "";
				$txtInnerJoin = "INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario";
				$arrInnerJoinCiudadano[] = $txtInnerJoin;
				$txtInnerJoin = "";
				$txtInnerJoin = "INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano";
				$arrInnerJoinCiudadano[] = $txtInnerJoin;
			}
			if($arrDatosCampo["tablaOrigen"] == "T_DES_DESEMBOLSO"){
				$txtInnerJoin = "";
				$txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
			if($arrDatosCampo["tablaOrigen"] == "T_DES_JURIDICO"){
				$txtInnerJoin = "";
				$txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario ";
				$txtInnerJoin .= "LEFT JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
                        
                        if($arrDatosCampo["tablaOrigen"] == "T_DES_ESTUDIO_TITULOS"){
                            
				$txtInnerJoin = "";                                
                                $txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario ";
				$txtInnerJoin .= "LEFT JOIN T_DES_ESTUDIO_TITULOS est ON des.seqDesembolso = est.seqDesembolso";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
                       
			if( $arrDatosCampo["tablaJoin"] == "T_FRM_ESTADO_PROCESO" or $arrDatosCampo["tablaJoin"] == "T_FRM_ETAPA" ){
				$txtInnerJoin = "INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso";
				$arrInnerJoin[] = $txtInnerJoin;
				$txtInnerJoin = "INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa";
				$arrInnerJoin[] = $txtInnerJoin;
			}
			$txtRevisarDesembolso = strstr( $txtCampoAnalizar, "Desembolso" );
			if( $txtRevisarDesembolso == "Desembolso" ){
				$arrCampoAnalizar = explode( "Desembolso", $txtCampoAnalizar );
				$txtCampoAnalizar = $arrCampoAnalizar[0];
			}
			 
			$txtTipoDato = $arrDatosCampo["tipoDato"];
			switch ($txtTipoDato){
				case "externo":
					$txtInnerJoin = "";
					$txtInnerJoin = $arrDatosCampo["tablaJoin"] ." ".  $arrDatosCampo["aliasJoin"]
									. " ON ". $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar
									. " = ". $arrDatosCampo["aliasJoin"] .".". $arrDatosCampo["campoJoin"]
								;
					if($arrDatosCampo["tablaOrigen"] == "T_FRM_FORMULARIO"){ 
						if($arrDatosCampo["tablaJoin"] == "T_PRY_UNIDAD_PROYECTO"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else if($arrDatosCampo["tablaJoin"] == "T_PRY_PROYECTO" && $arrDatosCampo["aliasJoin"] == "pro"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else if($arrDatosCampo["tablaJoin"] == "T_PRY_PROYECTO" && $arrDatosCampo["aliasJoin"] == "prh"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else {
							$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
						}
						/*if($arrDatosCampo["tablaJoin"] == "T_PRY_PROYECTO" && $arrDatosCampo["aliasJoin"] == "pro"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else if($arrDatosCampo["tablaJoin"] == "T_PRY_PROYECTO" && $arrDatosCampo["aliasJoin"] == "prh"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else {
							$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
						}*/
					}else if( $arrDatosCampo["tablaOrigen"] == "T_DES_DESEMBOLSO" or
							  $arrDatosCampo["tablaOrigen"] == "T_DES_JURIDICO"
					 ){
						$arrInnerJoinDesembolso[] = "LEFT JOIN ". $txtInnerJoin;
					}else{
						$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
					}
					break;
			}
		}
		//pr ($arrInnerJoin);

		//CICLO PARA SACAR LAS CLAUSULAS WHERE
		foreach($arrCondiciones as $arrCondicionEspecifica){
			
         if( strpos( $arrCondicionEspecifica["campo"] , "." ) !== false ){
            list( $txtAliasCampoAnalizar , $txtCampoAnalizar ) = mb_split("\.", $arrCondicionEspecifica["campo"]);
         }else{
            $txtAliasCampoAnalizar = 0;
            $txtCampoAnalizar = $arrCondicionEspecifica["campo"];
         }
         
         if( ! is_numeric( $txtAliasCampoAnalizar ) ){
            if( isset( $arrCampos[ $txtCampoAnalizar ] ) and $arrCampos[ $txtCampoAnalizar ]['aliasOrigen'] == $txtAliasCampoAnalizar ){
               $arrDatosCampo = $arrCampos[ $txtCampoAnalizar ];
            }else{
               $arrDatosCampo = $arrCamposDesembolso[ $txtCampoAnalizar ];
            }
         } else {
            $arrDatosCampo = ( $arrCampos[$txtCampoAnalizar] ) ? $arrCampos[$txtCampoAnalizar] : $arrCamposDesembolso[$txtCampoAnalizar] ;
         }
         
			$txtTipoDato 		= $arrDatosCampo["tipoDato"];
			$txtRevisarDesembolso = strstr( $txtCampoAnalizar, "Desembolso" );
			
			if( $txtRevisarDesembolso == "Desembolso" ){
				$arrCampoAnalizar = explode( "Desembolso", $txtCampoAnalizar );
				$txtCampoAnalizar = $arrCampoAnalizar[0];
			}
			
			switch ($txtTipoDato){
				case "externo":
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " ". 
								$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " = '". 
								$arrCondicionEspecifica["wValor"] ."'";
					$arrWhere[] = $txtWhere; 
					break;
				case "texto":
					$numKeyCriterios = $arrCondicionEspecifica['wCriterio'];
					$txtCondicion 	 = $arrCriterios['texto'][$numKeyCriterios]["valor"];
					switch ($txtCondicion){
						case "inicia":
							$txtBusquequedaTexto = "'". $arrCondicionEspecifica["wValor"] ."%'";
							break;
						case "termina":
							$txtBusquequedaTexto = "'%". $arrCondicionEspecifica["wValor"] ."'";
							break;
						case "contiene":
							$txtBusquequedaTexto = "'%". $arrCondicionEspecifica["wValor"] ."%'";
							break;
						case "igual":
							$txtBusquequedaTexto = "'". $arrCondicionEspecifica["wValor"] ."'";
							break;
					}
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " " . 
								$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " like ". 
								$txtBusquequedaTexto;
					$arrWhere[] = $txtWhere; 
					break;
				case "numero":
					$numKeyCriterios = $arrCondicionEspecifica['wCriterio'];
					$txtCondicion 	 = $arrCriterios['numero'][$numKeyCriterios]["valor"];
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " " . $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " " . 
								$txtCondicion ." ". $arrCondicionEspecifica["wValor"] ." ";
					$arrWhere[] = $txtWhere; 
					break;
				case "booleano":
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " ".
								$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " = ". 
								$arrCondicionEspecifica["wValor"];
					$arrWhere[] = $txtWhere; 
					break;
				case "fecha":
					$numKeyCriterios = $arrCondicionEspecifica['wCriterio'];
					$txtCondicion 	 = $arrCriterios['fecha'][$numKeyCriterios]["valor"];
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " " .
								$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " " . 
								$txtCondicion . " '" . $arrCondicionEspecifica["wValor"] ."'";
					$arrWhere[] = $txtWhere; 
					break;
				case "fechahora":
					$numKeyCriterios = $arrCondicionEspecifica['wCriterio'];
					$txtCondicion 	 = $arrCriterios['fechahora'][$numKeyCriterios]["valor"];
					$txtHora 		 = $arrCriterios['fechahora'][$numKeyCriterios]["hora"];
					$txtWhere = "";
					$txtWhere = $arrCondicionEspecifica["wCondicion"] . " " .
								$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " " . 
								$txtCondicion . " '" . $arrCondicionEspecifica["wValor"] ." ". $txtHora ."'";
					$arrWhere[] = $txtWhere; 
					break;
					break;
			}
			
		}
      
		// CICLO PARA SACAR LOS INNER JOIN
		foreach($arrCondiciones as $arrCondicionEspecifica){
			$txtCampoAnalizar 	= $arrCondicionEspecifica["campo"];
			$arrDatosCampo 		= ( $arrCampos[$txtCampoAnalizar] ) ? $arrCampos[$txtCampoAnalizar] : $arrCamposDesembolso[$txtCampoAnalizar] ;
			if($arrDatosCampo["tablaOrigen"] == "T_CIU_CIUDADANO" || $arrDatosCampo["tablaOrigen"] == "T_FRM_HOGAR" || isset($_POST["criterioPPal"])){
				$txtInnerJoin = "";
				$txtInnerJoin = "INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario";
				$arrInnerJoinCiudadano[] = $txtInnerJoin;
				$txtInnerJoin = "";
				$txtInnerJoin = "INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano";
				$arrInnerJoinCiudadano[] = $txtInnerJoin;
			}
			if($arrDatosCampo["tablaOrigen"] == "T_DES_DESEMBOLSO"){
				$txtInnerJoin = "";
				$txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
			if($arrDatosCampo["tablaOrigen"] == "T_DES_JURIDICO"){
				$txtInnerJoin = "";
				$txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario ";
				$txtInnerJoin .= "LEFT JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
                        
                        if($arrDatosCampo["tablaOrigen"] == "T_DES_ESTUDIO_TITULOS"){
                            
				$txtInnerJoin = "";
                                $txtInnerJoin = "LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario ";
                                $txtInnerJoin .= "LEFT JOIN T_DES_ESTUDIO_TITULOS est ON des.seqDesembolso = est.seqDesembolso";
				$arrInnerJoinDesembolso[] = $txtInnerJoin;
			}
                        
			if( $arrDatosCampo["tablaJoin"] == "T_FRM_ESTADO_PROCESO" or $arrDatosCampo["tablaJoin"] == "T_FRM_ETAPA" ){
				$txtInnerJoin = "INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso";
				$arrInnerJoin[] = $txtInnerJoin;
				$txtInnerJoin = "INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa";
				$arrInnerJoin[] = $txtInnerJoin;
			}
			
			$txtRevisarDesembolso = strstr( $txtCampoAnalizar, "Desembolso" );
			if( $txtRevisarDesembolso == "Desembolso" ){
				$arrCampoAnalizar = explode( "Desembolso", $txtCampoAnalizar );
				$txtCampoAnalizar = $arrCampoAnalizar[0];
			}
			$txtTipoDato = $arrDatosCampo["tipoDato"];
			
			switch ($txtTipoDato){
				/*case "externo":
					$txtInnerJoin = "";
					$txtInnerJoin = $arrDatosCampo["tablaJoin"] ." ".  $arrDatosCampo["aliasJoin"]
									. " ON ". $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar
									. " = ". $arrDatosCampo["aliasJoin"] .".". $arrDatosCampo["campoJoin"]
								;
					if($arrDatosCampo["tablaOrigen"] == "T_FRM_FORMULARIO"){ 
						$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;						
					}else if( $arrDatosCampo["tablaOrigen"] == "T_DES_DESEMBOLSO" or
							  $arrDatosCampo["tablaOrigen"] == "T_DES_JURIDICO"
					 ){
						$arrInnerJoinDesembolso[] = "LEFT JOIN ". $txtInnerJoin;
					}else{
						$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
					}
					
					break;*/
				case "texto":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA 
					// T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "numero":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA 
					// T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "booleano":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA 
					// T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "fecha":
				case "fechahora":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA 
					// T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
			}
		}
		
		//CICLO PARA SACAR LOS CAMPOS QUE SE VAN A BUSCAR EN LA CONSULTA
		if($_POST["criterio"] == "count(*)"){ 
//			|| $_POST["criterio"] == "sum(*)"){
			$arrCamposSql[] 	= $_POST["criterio"] ." AS Cuenta";
			$arrCamposDefecto 	= array();
			$arrTitulosCampos 	= array( "Cuenta" );
		}else{
			if( !isset($_POST["criterioPPal"] ) ){
				$arrCamposSql[] = "( SELECT 
										upper(concat(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
									FROM
										T_FRM_HOGAR hog1
										INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
									WHERE hog1.seqFormulario = hog.seqFormulario
										AND hog1.seqParentesco = 1
									) AS 'NombrePPAL'";
				$arrTitulosCampos[] = "NombrePPAL";
				$arrCamposSql[] = "( SELECT 
										ciu1.numDocumento
									FROM 
										T_FRM_HOGAR hog1
										INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
									WHERE hog1.seqFormulario = hog.seqFormulario
										AND hog1.seqParentesco = 1
									) AS 'NumeroDocumentoPPAL'";
				$arrTitulosCampos[] = "NumeroDocumentoPPAL";
			}
			
			foreach($arrSCampos as $txtAliasCampoAnalizar => $txtCampoAnalizar){
                            
				if( $txtCampoAnalizar == "txtNombreCiudadano" ){
					$arrCamposSql[] = "upper(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) as 'Nombre'";
					$arrTitulosCampos[] = "Nombre";
				}else if( $txtCampoAnalizar == "seqUsuario" ){
					$arrCamposSql[] = "upper(concat(usu.txtNombre, ' ', usu.txtApellido ) ) as 'Usuario'";
					$arrTitulosCampos[] = "Usuario";
				}else if( $txtCampoAnalizar == "numDocumento" ){
					$arrCamposSql[] = "ciu.numDocumento as 'Documento'";
					$arrTitulosCampos[] = "Documento";
				} else if( $txtCampoAnalizar == "seqEstadoProceso" ){
					$arrCamposSql[] = "concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) as 'Estado del Proceso'";
					$arrTitulosCampos[] = "Estado del Proceso";
				}else{
               
               if( ! is_numeric( $txtAliasCampoAnalizar ) ){
                  if( isset( $arrCampos[ $txtCampoAnalizar ] ) and $arrCampos[ $txtCampoAnalizar ]['aliasOrigen'] == $txtAliasCampoAnalizar ){
                     $arrDatosCampo = $arrCampos[ $txtCampoAnalizar ];
                  } else {
                     $arrDatosCampo = $arrCamposDesembolso[ $txtCampoAnalizar ];
                  }
               } else {
                  $arrDatosCampo = ( $arrCampos[$txtCampoAnalizar] ) ? $arrCampos[$txtCampoAnalizar] : $arrCamposDesembolso[$txtCampoAnalizar] ;
               }
               
					//$arrDatosCampo 		= ( $arrCampos[$txtCampoAnalizar] ) ? $arrCampos[$txtCampoAnalizar] : $arrCamposDesembolso[$txtCampoAnalizar] ;
               
					$txtTipoDato 	= $arrDatosCampo["tipoDato"];
					$txtRevisarDesembolso = strstr( $txtCampoAnalizar, "Desembolso" );
					
					if( $txtRevisarDesembolso == "Desembolso" ){
						$arrCampoAnalizar = explode( "Desembolso", $txtCampoAnalizar );
						$txtCampoAnalizar = $arrCampoAnalizar[0];
					}
                                        //pr($arrDatosCampo);die();
	
					switch ($txtTipoDato){
						case "externo":
							$arrCamposSql[] = $arrDatosCampo["aliasJoin"] .".". $arrDatosCampo["selectJoin"].
											" as '". $arrDatosCampo["nombre"] ."'";
							break;
						case "texto":
							$arrCamposSql[] = "upper(". $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar .") ".
											"as '". $arrDatosCampo["nombre"] ."'";
							break;
						case "numero":
							$arrCamposSql[] = $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar.
											" as '". $arrDatosCampo["nombre"] ."'";
							break;
						case "booleano":
							$arrCamposSql[] = "if(" .$arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . " = 1, ".
												"'SI','NO') as '". $arrDatosCampo["nombre"] ."'";
							break;
						case "fecha":
						case "fechahora":
							$arrCamposSql[] = "DATE_FORMAT( ". $arrDatosCampo["aliasOrigen"] .".". $txtCampoAnalizar . ", '%d-%m-%Y' ) ". 
											" as '". $arrDatosCampo["nombre"] ."'";
							break;
					}
					$arrTitulosCampos[] = utf8_encode( $arrDatosCampo["nombre"] );
					
				}
			}
		}
		if( !empty($arrWhere) && is_array($arrWhere) ){
			$arrWhere[] = " AND 1 = 1 ";
		}else{
			$arrWhere[] = " 1 = 1 ";
		}
		$arrWhere[] = " ) AND numDocumento > 0 ";
		if( isset($_POST["criterioPPal"] ) ){
			$arrWhere[] = " AND hog.seqParentesco = 1";
		}
		
		$arrInnerJoin 	= array_merge($arrInnerJoinCiudadano, $arrInnerJoin);                
		$arrInnerJoin 	= array_merge($arrInnerJoin, $arrInnerJoinDesembolso);                

		$arrInnerJoin 	= array_unique($arrInnerJoin);
//		$arrWhere 		= ( is_array( $arrWhere ) )?array_unique($arrWhere):"";
		$arrWhere 		= ( !empty($arrWhere) ) ?  array_unique($arrWhere) : array( );
		if( !empty( $arrFormularios ) ){
			$arrWhere[] = " AND frm.seqFormulario in ( $arrFormularios )";
		}
                if (in_array('LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario', $arrInnerJoin)&&in_array('LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario LEFT JOIN T_DES_ESTUDIO_TITULOS est ON des.seqDesembolso = est.seqDesembolso', $arrInnerJoin)){
                    $num = array_search('LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario', $arrInnerJoin);
                    //echo $num;
                    unset($arrInnerJoin[$num]);
                    
                }
                
		//pr($arrInnerJoin);die();
		
		
		$arrCamposSql 	= array_merge( $arrCamposDefecto, $arrCamposSql);
		$arrCamposSql 	= array_unique($arrCamposSql);
		if( !empty($arrWhere) ){
			$txtWherePos1 = $arrWhere[0];
			$arrWherePos1 = explode(" ", $txtWherePos1);
			$arrPos1Final = array_shift($arrWherePos1);
			$arrWhere[0]  = implode( " ", $arrWherePos1 );
		}else{
			$arrWhere[ 0 ] = 1;
		}
		
//		pr($arrInnerJoin);
//		pr($arrWhere);
//		pr($arrCamposSql);
		
		$txtCamposSql = implode(" , ", $arrCamposSql);
		$txtInnerJoin = implode(" ", $arrInnerJoin);
		$txtWhere 	  = implode(" ", $arrWhere);                
		
		//pr ($arrInnerJoin);
		
		$txtLimite = (isset($_GET["preview"]))?" LIMIT 1000 ":"";
		//pr($txtCamposSql);die();
		$sql = "SELECT ". $txtCamposSql .
				" FROM T_FRM_FORMULARIO frm ".
				$txtInnerJoin .
				" WHERE ( ".
				$txtWhere .
				$txtLimite
				;	
				//echo "<b>txtWhere: </b>".$txtWhere."<br><br>";
				//echo $sql; exit(0);
				//var_dump($arrInnerJoin);
		if( empty($arrErrores) ){
	 		try {
//	 			pr( $sql ); die( );
				$objRes = $aptBd->execute( $sql );
				if(isset($_GET["preview"])){
					$txtJsReporteador = $claReportes->obtenerJsReporteador( $objRes, $arrTitulosCampos );
					$claSmarty->assign( "txtJsReporteador" , $txtJsReporteador );
					$claSmarty->display( "reportes/previewReportador.tpl" );
				}else{
					$claReportes->obtenerReportesGeneralReporteador( $objRes, "ReporteReporteador" );
				}
			}catch(Exception $objError ){
				$arrErrores[] = "Se ha producido un error al consultar los datos";
			}
		}
					

	}else{
		$arrErrores[] = "Ingrese una condicion para ejecutar el reporteador.";
		/*if($txtWhere == ''){
			$arrErrores[] = "Ingrese una condicion para ejecutar el reporteador.";
		}*/
	}
	if(!empty($arrErrores)){
		imprimirMensajes( $arrErrores, array() );
	}
	

?>

