<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    
    // configuracion de los campos que se podrán usar en las consultas
    include( "./configuracionReporteador.php" );
    //include( "./configuracionReporteadorDesembolso.php" ); 
    
    //pr( $_POST );
    
   $txtAliasCampo = "";
   if( strpos( $_POST['campo'] , "." ) !== false ){
      list( $txtAliasCampo , $txtCampo ) = mb_split( "\." , $_POST['campo'] );
   }else{
      $txtAliasCampo = 0;
      $txtCampo = $_POST['campo'];
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
   
	//$txtCampo = $_POST['campo'];
	if( $txtDatosCampo == "arrCampos" ){
		
	    $txtTipoDato = strtolower( $arrCampos[ $txtCampo ]['tipoDato'] );

		$arrSeleccion = array();
		if( strtolower( $arrCampos[ $txtCampo ]['tipoDato'] ) == "externo" ){
			
			if( ! isset( $arrCampos[ $txtCampo ]['selectEspecial'] ) ){
				$sql = "
					SELECT 
						" . $arrCampos[ $txtCampo ]['aliasJoin'] . "." . $arrCampos[ $txtCampo ]['campoJoin'] . ",
						" . $arrCampos[ $txtCampo ]['aliasJoin'] . "." . $arrCampos[ $txtCampo ]['selectJoin'] . "
					FROM " . $arrCampos[ $txtCampo ]['tablaJoin'] . " " . $arrCampos[ $txtCampo ]['aliasJoin'] . "
					ORDER BY 2
				";
			}else{
				$sql = $arrCampos[ $txtCampo ]['selectEspecial'];
			}
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$arrValores = array();
					foreach( $objRes->fields as $txtCampo => $txtValor ){
						$arrValores[] = $txtValor;
					}
					$arrSeleccion[ $arrValores[0] ] = $arrValores[1]; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				//pr( $sql );
			}
			
		}

	} /*else if( $txtDatosCampo == "arrCamposDesembolso" ){
		
		$txtTipoDato = strtolower( $arrCamposDesembolso[ $txtCampo ]['tipoDato'] );

		
		$arrSeleccion = array();
		if( strtolower( $arrCamposDesembolso[ $txtCampo ]['tipoDato'] ) == "externo" ){
			
			$arrSelectMostrar = $arrCamposDesembolso[ $txtCampo ];
			$sql = "";
			
			if( isset( $arrSelectMostrar["selectEspecial"] ) ){
				$sql = $arrCamposDesembolso[ $txtCampo ]['selectEspecial'];
			}else if( isset( $arrSelectMostrar["datosEspeciales"] ) ){
				$arrSeleccion = $arrCamposDesembolso[ $txtCampo ]['datosEspeciales'];
			}else{
				$sql = "
					SELECT 
						" . $arrCamposDesembolso[ $txtCampo ]['aliasJoin'] . "." . $arrCamposDesembolso[ $txtCampo ]['campoJoin'] . ",
						" . $arrCamposDesembolso[ $txtCampo ]['aliasJoin'] . "." . $arrCamposDesembolso[ $txtCampo ]['selectJoin'] . "
					FROM " . $arrCamposDesembolso[ $txtCampo ]['tablaJoin'] . " " . $arrCamposDesembolso[ $txtCampo ]['aliasJoin'] . "
					ORDER BY 2
				";
			}
			
			
			try {
				$objRes = $aptBd->execute( $sql );
				while( $objRes->fields ){
					$arrValores = array();
					foreach( $objRes->fields as $txtCampo => $txtValor ){
						$arrValores[] = $txtValor;
					}
					$arrSeleccion[ $arrValores[0] ] = $arrValores[1]; 
					$objRes->MoveNext();
				}
			} catch ( Exception $objError ) {
				//pr( $sql );
			}
			
		}
	}*/
	
	$claSmarty->assign( "txtTipoDato" , $txtTipoDato );	
	$claSmarty->assign( "arrSeleccion" , $arrSeleccion );
	$claSmarty->assign( "arrCriterio" , $arrCriterios[ $txtTipoDato ] );
	$claSmarty->assign("txtMostrar" , $_POST['mostrar'] );
	$claSmarty->display("reportesProyectos/cambioWSelect.tpl");
    	

?>
