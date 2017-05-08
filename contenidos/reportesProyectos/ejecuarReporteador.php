<?php

	$txtPrefijoRuta = "../../";	
        
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ReportesProyectos.class.php" );
        
	include( "./configuracionReporteador.php" );
	
	$arrErrores 		= array();
	//$arrCamposDefecto 	= array("frm.seqFormulario", "frm.txtFormulario");
	$arrCamposDefecto 	= array("pry.seqProyecto");
	$arrCamposSql 		= array();
	$claReportes 		= new Reportes();
	$bolFlag 			= true;
	$arrProyectos 	= array( );
	
	if( $_FILES["fileSecuenciales"]["size"] ){
		$claReportes->cargarSecuencialesFormulario(  );
		$arrProyectos = $claReportes->seqProyectos;
		$arrErrores 	= $claReportes->arrErrores;
	}
	//pr($_POST);die();
   $arrSCampos = array();
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

		$arrTitulosCampos = array();
		$arrTitulosCampos[] = "seqProyecto";
		//$arrTitulosCampos[] = "txtFormulario";

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
         
			if($arrDatosCampo["tablaOrigen"] == "T_PRY_ENTIDAD_OFERENTE" ){
				$txtInnerJoin = "";
				$txtInnerJoin = "LEFT JOIN T_PRY_ENTIDAD_OFERENTE ofe ON pry.seqProyecto = ofe.seqProyecto";
				$arrInnerJoin[] = $txtInnerJoin;
			}
                       
			if( $arrDatosCampo["tablaJoin"] == "T_PRY_ESTADO_PROCESO" ){
				$txtInnerJoin = "LEFT JOIN T_PRY_ESTADO_PROCESO est ON pry.seqPryEstadoProceso = est.seqPryEstadoProceso";
				$arrInnerJoin[] = $txtInnerJoin;
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
						if($arrDatosCampo["tablaJoin"] == "T_FRM_PROYECTO"){
							$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
						} else {
							$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
						}
					}else{
						$arrInnerJoin[] = "LEFT JOIN ". $txtInnerJoin;
					}
					break;
			}
		}

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

			if( $arrDatosCampo["tablaJoin"] == "T_PRY_ESTADO_PROCESO" ){
				$txtInnerJoin = "INNER JOIN T_PRY_ESTADO_PROCESO est ON pry.seqPryEstadoProceso = est.seqPryEstadoProceso";
				$arrInnerJoin[] = $txtInnerJoin;
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
						$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;						
					}else{
						$arrInnerJoin[] = "INNER JOIN ". $txtInnerJoin;
					}
					
					break;
				case "texto":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "numero":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "booleano":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA T_FR_FORMULARIO
					if($arrDatosCampo["tablaOrigen"] != "T_FRM_FORMULARIO"){ }
					break;
				case "fecha":
				case "fechahora":
					// SE DEJA ESTE IF SI SE ESTA BUSCANDO UN TEXTO SOBRE UNA TABLA QUE NO SEA T_FR_FORMULARIO
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
			foreach($arrSCampos as $txtAliasCampoAnalizar => $txtCampoAnalizar){
                            
				if( $txtCampoAnalizar == "seqUsuario" ){
					$arrCamposSql[] = "upper(concat(usu.txtNombre, ' ', usu.txtApellido ) ) as 'Usuario'";
					$arrTitulosCampos[] = "Usuario";
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
               
					$txtTipoDato 	= $arrDatosCampo["tipoDato"];
					
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
		
		$arrInnerJoin 	= array_unique($arrInnerJoin);
//		$arrWhere 		= ( is_array( $arrWhere ) )?array_unique($arrWhere):"";
		$arrWhere 		= ( !empty($arrWhere) ) ?  array_unique($arrWhere) : array( );
		if( !empty( $arrProyectos ) ){
			$arrWhere[] = " AND pry.seqProyecto in ( $arrProyectos )";
		}

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
		//echo "txtInnerJoin: ". $txtInnerJoin."<br>";
		
		$txtLimite = (isset($_GET["preview"]))?" LIMIT 1000 ":"";
		//pr($txtCamposSql);die();
		$sql = "SELECT ". $txtCamposSql .
				" FROM T_PRY_PROYECTO pry ".
				$txtInnerJoin .
				" WHERE ".
				$txtWhere .
				$txtLimite
				;	
		//echo $sql; exit(0);
		//echo $sql;

		if( empty($arrErrores) ){
	 		try {
//	 			pr( $sql ); die( );
				$objRes = $aptBd->execute( $sql );
				if(isset($_GET["preview"])){
					$txtJsReporteador = $claReportes->obtenerJsReporteador( $objRes, $arrTitulosCampos );
					$claSmarty->assign( "txtJsReporteador" , $txtJsReporteador );
					$claSmarty->display( "reportesProyectos/previewReportador.tpl" );
				}else{
					$claReportes->obtenerReportesGeneralReporteador( $objRes, "ReporteReporteador" );
				}
			}catch(Exception $objError ){
				$arrErrores[] = "Se ha producido un error al consultar los datos";
			}
		}
	}else{
		$arrErrores[] = "Ingrese una condicion para ejecutar el reporteador.";
	}
	if(!empty($arrErrores)){
		imprimirMensajes( $arrErrores, array() );
	}
?>