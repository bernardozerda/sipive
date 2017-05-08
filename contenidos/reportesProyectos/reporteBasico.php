<?php
	
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ReportesProyectos.class.php" );
		
	$arrArbolReportes = array();
	$seqProyecto = $_SESSION['seqProyecto'];
	$arrGrupos 	 = $_SESSION['arrGrupos'][$seqProyecto];
	
	$arrGrupos = ( empty( $arrGrupos ) )?"null":
					implode( ",", $arrGrupos);
					
	$sql = "select
				men.seqMenu
			from
				T_COR_MENU men 
				where men.txtMenuEn like '%Reportes%'";
	$objRes = $aptBd->execute( $sql );
	$seqMenuPadre = $objRes->fields['seqMenu'];
					
	$sql = "SELECT 
			  per.seqProyectoGrupo,
			  gru.txtGrupo,
			  men.txtMenuEs,
			  men.txtCodigo
			FROM 
			  T_COR_MENU men
			  INNER JOIN T_COR_PERMISO per on per.seqMenu = men.seqMenu
			  INNER JOIN T_COR_PROYECTO_GRUPO pgr on per.seqProyectoGrupo = pgr.seqProyectoGrupo
			  INNER JOIN T_COR_GRUPO gru on pgr.seqGrupo = gru.seqGrupo
			WHERE men.seqMenuPadre = $seqMenuPadre
			  and pgr.seqProyecto = $seqProyecto
			  and per.seqProyectoGrupo in ($arrGrupos)
			ORDER BY men.numOrden";
	try {
	 	
	 	$objRes = $aptBd->execute( $sql );
	 	
	 	while( $objRes->fields ){
	 		
	 		$seqProyectoGrupo 	= $objRes->fields['seqProyectoGrupo'];
	 		$txtGrupo 			= $objRes->fields['txtGrupo'];
	 		$txtMenuEs 			= $objRes->fields['txtMenuEs'];
	 		$txtCodigo 			= $objRes->fields['txtCodigo'];
	 		
	 		$arrArbolReportes[ucwords($txtGrupo)][$txtMenuEs] = $txtCodigo;
	 		$objRes->MoveNext();
	 	}
	 	
	 	$bolReporteCargar = false;
	 		 	
	 	$txtJs = "var objArbol = new YAHOO.widget.TreeView('treeDiv1', [";
	 	
	 	foreach( $arrArbolReportes as $txtGrupo => $arrListadoReportes ){
	 		$txtJs .= "{";
	 		$txtJs .= "type: 'text',";
	 		$txtJs .= "label: '$txtGrupo',";
	 		$txtJs .= "children: [";
	 		
	 		foreach( $arrListadoReportes as $txtMenuEs => $txtCodigo){
	 			$txtJs .= "{";
		 		$txtJs .= "type: 'text',";
		 		$txtJs .= "label: '$txtMenuEs',";
		 		$txtJs .= "txtCodigo: '$txtCodigo'";
	 			$txtJs .= "},";
	 			
	 			if( !$bolReporteCargar ){
	 				$bolReporteCargar = true;
	 				$txtDivReporteCargar .= "var txtArchivoReporte = '$txtCodigo';";
	 			}
	 			
	 		}
	 		$txtJs = trim( $txtJs , ", " );
	 		$txtJs .= "]";
	 		$txtJs .= "},";
	 	}
	 	$txtJs = trim( $txtJs , ", " );
	 	$txtJs .= "]);";
	 	$txtJs .= $txtDivReporteCargar;
	 	
	} catch ( Exception $objError ) { }
	
	
	$claSmarty->assign( "txtJs" , $txtJs  );
	$claSmarty->assign( "txtArchivoInicio" , "reportes/inicioReportes.tpl"  );
	
?>
