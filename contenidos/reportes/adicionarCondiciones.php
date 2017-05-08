<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
   include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );

   include( "./configuracionReporteador.php" );
   include( "./configuracionReporteadorDesembolso.php" );

   //pr( $_POST );
    
   $txtAliasCampo = "";
   if( strpos( $_POST['wCampo'] , "." ) !== false ){
      list( $txtAliasCampo , $txtCampo ) = mb_split( "\." , $_POST['wCampo'] );
   }else{
      $txtAliasCampo = 0;
      $txtCampo = $_POST['wCampo'];
   }
   
   if( ! is_numeric( $txtAliasCampo ) ){
      if( isset( $arrCampos[ $txtCampo ] ) and $arrCampos[ $txtCampo ]['aliasOrigen'] == $txtAliasCampo ){
         $txtDatosCampo = "arrCampos";
      } else {
         $txtDatosCampo = "arrCamposDesembolso";
      }
   } else {
      $txtDatosCampo = ( $arrCampos[$txtCampo] ) ? "arrCampos" : "arrCamposDesembolso" ;
   }
   
   if( $txtDatosCampo == "arrCampos" ){
      $txtCampoSeleccionado    = $arrCampos[ $txtCampo ][ "nombre" ];
      $txtTipoDato             = $arrCampos[ $txtCampo ][ "tipoDato" ];
   }else {
      $txtCampoSeleccionado    = $arrCamposDesembolso[ $txtCampo ][ "nombre" ];
      $txtTipoDato             = $arrCamposDesembolso[ $txtCampo ][ "tipoDato" ];
   }
   
	$txtCriterioSeleccionado = ( $arrCriterios[$txtTipoDato][$_POST['wCriterio']]["texto"] ) ? 
                                       $arrCriterios[$txtTipoDato][$_POST['wCriterio']]["texto"] : 
                                       $arrCamposDesembolso[$txtTipoDato][$_POST['wCriterio']]["texto"];

//	$txtCampoSeleccionado = ( $arrCampos[$_POST["wCampo"]]["nombre"] ) ? $arrCampos[$_POST["wCampo"]]["nombre"] 
//																		: $arrCamposDesembolso[$_POST["wCampo"]]["nombre"] ;
//	$txtTipoDato = ( $arrCampos[$_POST["wCampo"]]["tipoDato"] ) ? $arrCampos[$_POST["wCampo"]]["tipoDato"] 
//																: $arrCamposDesembolso[$_POST["wCampo"]]["tipoDato"] ;   
   
	$txtWCondicion = $_POST["wCondicion"];
	$txtCondicionYO = ( $txtWCondicion == "AND" ) ? "Y" : "O";
	
	switch ($txtTipoDato){
		case "booleano":
			$txtValorSeleccionado = ($_POST["wValor"])?"SI":"NO";
			break;
		case "externo":
			if( $txtCampo == "seqEstadoProceso" ){
				$sql = "SELECT ".
						" concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) as txtEstadoProceso ".
						" FROM ".
						" T_FRM_ESTADO_PROCESO epr ".
						" INNER JOIN T_FRM_ETAPA eta on epr.seqEtapa = eta.seqEtapa ".
						" WHERE ". 
						" epr.seqEstadoProceso ".
						" = ". 
						$_POST["wValor"]
						;
			} else{ 
				$sql = "SELECT ".
						$arrCampos[$txtCampo]["selectJoin"] .
						" FROM ".
						$arrCampos[$txtCampo]["tablaJoin"].
						" WHERE ". 
						$arrCampos[$txtCampo]["campoJoin"].
						" = ". 
						$_POST["wValor"]
						;
			}
			try {
				$objRes = $aptBd->execute( $sql );
				$txtSelectJoin = $arrCampos[$txtCampo]["selectJoin"];
				$arrSelectJoin = explode(" ", $txtSelectJoin);
				$txtSelectJoin = $arrSelectJoin[count($arrSelectJoin)-1];
				$txtValorSeleccionado = $objRes->fields[$txtSelectJoin];
			} catch ( Exception $objError ) { }
			break;
		case "texto":
		case "numero":
		case "fecha":
		case "fechahora":
			$txtValorSeleccionado = $_POST["wValor"];
			break;
		default:
			$txtValorSeleccionado = "";
			break;
	}
	
   $txtWCampo = ( $txtAliasCampo != "" )? $txtAliasCampo . "." . $txtCampo : $txtCampo;
   
	$claSmarty->assign( "txtCondicion" , $_POST['condicion']  );
	$claSmarty->assign( "txtCampoSeleccionado" , $txtCampoSeleccionado  );
	$claSmarty->assign( "txtCriterioSeleccionado" , $txtCriterioSeleccionado  );
	$claSmarty->assign( "txtValorSeleccionado" , $txtValorSeleccionado  );
	$claSmarty->assign( "txtCondicionYO" , $txtCondicionYO );
	
	$claSmarty->assign( "wCondicion" , $txtWCondicion  );
	$claSmarty->assign( "wCampo" , $txtWCampo);
	$claSmarty->assign( "wCriterio" , $_POST['wCriterio']);
	$claSmarty->assign( "wValor" , $_POST['wValor']);
	$claSmarty->display( "reportes/adicionCondiciones.tpl"  );
	
?>
