<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
	// Actos Administrativos Unidades
	$sql = "SELECT 
				T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo, 
				numActo,
				fchActo,
				CONCAT(numActo,' de ',fchActo) as Acto,
				txtTipoActoUnidad,
				COUNT(*) AS cuantos
			FROM 
				T_PRY_AAD_UNIDAD_ACTO 
			INNER JOIN 
				T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
			INNER JOIN
				T_PRY_AAD_UNIDAD_TIPO_ACTO ON (T_PRY_AAD_UNIDAD_ACTO.seqTipoActoUnidad = T_PRY_AAD_UNIDAD_TIPO_ACTO.seqTipoActoUnidad)
			GROUP BY
				Acto
			ORDER BY 
				fchActo DESC, numActo DESC";
	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrActosUnidades[ $objRes->fields['seqUnidadActo'] ]['seqUnidadActo'] = $objRes->fields['seqUnidadActo'];
		$arrActosUnidades[ $objRes->fields['seqUnidadActo'] ]['Acto'] = $objRes->fields['Acto'];
		$arrActosUnidades[ $objRes->fields['seqUnidadActo'] ]['txtTipoActoUnidad'] = $objRes->fields['txtTipoActoUnidad'];
		$arrActosUnidades[ $objRes->fields['seqUnidadActo'] ]['cuantos'] = $objRes->fields['cuantos'];
		$objRes->MoveNext();
	}

	// Tipos de Acto
	$sql = "SELECT
				seqTipoActoUnidad,
				txtTipoActoUnidad
			FROM
				T_PRY_AAD_UNIDAD_TIPO_ACTO
			ORDER BY
				seqTipoActoUnidad
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoActoUnidad[$objRes->fields['seqTipoActoUnidad']] = $objRes->fields['txtTipoActoUnidad'];
		$objRes->MoveNext();
	}

	$claSmarty->assign( "arrActosUnidades" , $arrActosUnidades	);
	$claSmarty->assign( "arrTipoActoUnidad" , $arrTipoActoUnidad	);
	$claSmarty->assign( "txtArchivo" , $txtArchivo 			);
	$claSmarty->display( "actosUnidades/actosUnidades.tpl" );
?>
