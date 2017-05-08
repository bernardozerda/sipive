<?php
	/**
	* CARGA LOS DATOS PROYECTO Y UNIDADES ASOCIADAS
	* @author Jaison Ospina
	* @version 1.0 Jul 2015
	*/

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );

	$seqProyecto = $_POST['seqProyecto'];
	$arrProyecto = array();
	$arrUnidades = array();

	$sql = "
		SELECT
			pry.txtNombreProyecto,
			ofe.txtNombreOferente,
			pry.valNumeroSoluciones
		FROM T_PRY_PROYECTO pry
		LEFT JOIN T_PRY_ENTIDAD_OFERENTE ofe ON (pry.seqProyecto = ofe.seqProyecto)
		WHERE pry.seqProyecto = '" . $seqProyecto . "'
	";
	$objRes = $aptBd->execute( $sql );
	if( $objRes->fields ){

		$arrProyecto['nombre']		= $objRes->fields['txtNombreProyecto'];
		$arrProyecto['oferente']	= $objRes->fields['txtNombreOferente'];
		$arrProyecto['soluciones']	= $objRes->fields['valNumeroSoluciones'];

		$sql = "SELECT 
				und.seqUnidadProyecto,
				und.txtNombreUnidad,
				und.valSDVEActual,
				'' AS numDocumento
			FROM T_PRY_UNIDAD_PROYECTO und 
			WHERE und.seqProyecto = $seqProyecto
			ORDER BY txtNombreUnidad";
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields ){
			$seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
			$arrUnidades[ $seqUnidadProyecto ]['unidad']		= $objRes->fields['seqUnidadProyecto'];
			$arrUnidades[ $seqUnidadProyecto ]['nombreUnidad']	= $objRes->fields['txtNombreUnidad'];
			$arrUnidades[ $seqUnidadProyecto ]['sdveActual']	= $objRes->fields['valSDVEActual'];
			$objRes->MoveNext();
		}

		$claSmarty->assign( "seqProyecto" , $seqProyecto );
		$claSmarty->assign( "arrProyecto" , $arrProyecto );
		$claSmarty->assign( "arrUnidades" , $arrUnidades );
		$claSmarty->display( "unidadProyecto/leerUnidad.tpl" );
	}
?>