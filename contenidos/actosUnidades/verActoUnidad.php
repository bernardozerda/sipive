<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	$seqActo = intval( $_POST['seqActo'] );

	if( $seqActo != 0 ){
		// Datos básicos del Acto
		$sql = "SELECT
					seqUnidadActo, numActo, fchActo, txtTipoActoUnidad, txtDescripcion
				FROM
					T_PRY_AAD_UNIDAD_ACTO
				INNER JOIN
					T_PRY_AAD_UNIDAD_TIPO_ACTO ON (T_PRY_AAD_UNIDAD_ACTO.seqTipoActoUnidad = T_PRY_AAD_UNIDAD_TIPO_ACTO.seqTipoActoUnidad)
				WHERE
					seqUnidadActo = $seqActo
				";
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields ){
			$arrInformacionActo[ $objRes->fields['seqUnidadActo'] ]['seqUnidadActo']		= $objRes->fields['seqUnidadActo'];
			$arrInformacionActo[ $objRes->fields['seqUnidadActo'] ]['numActo'] 				= $objRes->fields['numActo'];
			$arrInformacionActo[ $objRes->fields['seqUnidadActo'] ]['fchActo']				= $objRes->fields['fchActo'];
			$arrInformacionActo[ $objRes->fields['seqUnidadActo'] ]['txtTipoActoUnidad']	= $objRes->fields['txtTipoActoUnidad'];
			$arrInformacionActo[ $objRes->fields['seqUnidadActo'] ]['txtDescripcion']		= $objRes->fields['txtDescripcion'];
			$objRes->MoveNext();
		}

		// Hogares Vinculados al Acto
		$sql = "SELECT
					seqUnidadVinculado, txtNombreProyecto, txtNombreUnidad, T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto AS seqUnidad, valIndexado
				FROM
					T_PRY_AAD_UNIDADES_VINCULADAS
				INNER JOIN
					T_PRY_UNIDAD_PROYECTO ON (T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = T_PRY_UNIDAD_PROYECTO.seqUnidadProyecto)
				INNER JOIN
					T_PRY_PROYECTO ON (T_PRY_UNIDAD_PROYECTO.seqProyecto = T_PRY_PROYECTO.seqProyecto)
				WHERE
					seqUnidadActo = $seqActo
				ORDER BY
					txtNombreProyecto, txtNombreUnidad
				";
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields ){
			$arrVinculadosActo[ $objRes->fields['seqUnidadVinculado'] ]['seqUnidadVinculado']	= $objRes->fields['seqUnidadVinculado'];
			$arrVinculadosActo[ $objRes->fields['seqUnidadVinculado'] ]['txtNombreProyecto']	= $objRes->fields['txtNombreProyecto'];
			$arrVinculadosActo[ $objRes->fields['seqUnidadVinculado'] ]['txtNombreUnidad']		= $objRes->fields['txtNombreUnidad'];
			$arrVinculadosActo[ $objRes->fields['seqUnidadVinculado'] ]['seqUnidad']			= $objRes->fields['seqUnidad'];
			$arrVinculadosActo[ $objRes->fields['seqUnidadVinculado'] ]['valIndexado']			= $objRes->fields['valIndexado'];
			$objRes->MoveNext();
		}
	}

	$claSmarty->assign( "arrInformacionActo" , $arrInformacionActo	);
	$claSmarty->assign( "arrVinculadosActo" , $arrVinculadosActo	);
	$claSmarty->display( "actosUnidades/verInformacionActo.tpl" ); //Crear
?>