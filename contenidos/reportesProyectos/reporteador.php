<?php

	if( !file_exists( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" )){
		
		$txtPrefijoRuta = "../../";
	
		include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	    
	    // configuracion de los campos que se podrán usar en las consultas
	    include( "./configuracionReporteador.php" );
	    //include( "./configuracionReporteadorDesembolso.php" );
	    
	    $mostrarPlantilla = true;
	    
	} else {
		include( $txtPrefijoRuta . "/contenidos/reportes/configuracionReporteador.php" );
	    //include( $txtPrefijoRuta . "/contenidos/reportes/configuracionReporteadorDesembolso.php" );
	    $claSmarty->assign( "txtArchivoInicio" , "reportesProyectos/reporteador.tpl"  );
	    $mostrarPlantilla = false;
	}
   
//   pr( $arrCampos );
//   pr( $arrCamposDesembolso );
//   pr($arrCamposGrupos );
//        pr($arrCamposGrupos);
//        pr($arrCamposDesembolso);
        
        
    $txtJs = "var objArbol = new YAHOO.widget.TreeView('treeDivArbolMostrar', [";

 	foreach( $arrCamposGrupos as $txtGrupo => $arrListadoReportes ){
 		$txtJs .= "{";
 		$txtJs .= "type: 'text',";
 		$txtJs .= "label: '$txtGrupo',";
 		$txtJs .= "idCampo: '',";
 		$txtJs .= "children: [";
 		
 		foreach( $arrListadoReportes as $idCampo => $txtMenuEs){
 			$txtJs .= "{";
	 		$txtJs .= "type: 'text',";
	 		$txtJs .= "label: '$txtMenuEs',";
	 		$txtJs .= "idCampo: '$idCampo'";
 			$txtJs .= "},";
 		}
 		$txtJs = trim( $txtJs , ", " );
 		$txtJs .= "]";
 		$txtJs .= "},";
 	}
 	$txtJs = trim( $txtJs , ", " );
 	$txtJsPostulacion = $txtJs . "]);";
 	
 	unset( $arrCamposGrupos["Datos Ciudadano"]["txtNombreCiudadano"] );
    
    $claSmarty->assign( "arrCampos" , $arrCampos );
    $claSmarty->assign( "arrCamposGrupos" , $arrCamposGrupos );
    $claSmarty->assign( "arrCamposDesembolso" , $arrCamposDesembolso );
    $claSmarty->assign( "arrCamposDesembolsojuridico" , $arrCamposDesembolsojuridico );
    $claSmarty->assign( "txtJsPostulacion" , $txtJsPostulacion );
    $claSmarty->assign( "txtArchivoAyuda", "reportesProyectos/ayudaReporteador.tpl" );
    
    
    if( $mostrarPlantilla ){
    	$claSmarty->display( "reportesProyectos/reporteador.tpl" );
    }
    
?>
