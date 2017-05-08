<?php
	/**
	* CUANDO SE EDITA UN PROYECTO DE VIENDA ESTE ARCHIVO
	* RECOGE LA INFORMACION DE ESE PROYECTO Y LA
	* COLOCA EN EL FORMULARIO PARA QUE SEA MODIFICADA
	* @author Jaison Ospina
	* @version 0.1 Agosto 2013
	*/

	// posicion relativa de los archivos a incluir
	$txtPrefijoRuta = "../../";

	// Autenticacion (si esta logueado no no)
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

	// Inclusiones necesarias
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']	. "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']	. "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones']	. "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']		. "ProyectoVivienda.class.php" );
	//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']	. "Menu.class.php" );

	// Verifica que el valor sea numerico

	if( ! ( is_numeric( $_POST[ 'seqEditar' ] ) ) and isset( $_POST['seqEditar'] ) ){
		$_POST[ 'seqEditar' ] = 0;
	}

	// Identificador de la Proyecto de Vivienda editar

	$seqProyecto = $_POST[ 'seqEditar' ];

	// Obtiene la informacion para la Proyecto de Vivienda
	$claProyectoVivienda = new ProyectoVivienda;
	$arrProyectoVivienda = $claProyectoVivienda->cargarProyectoVivienda( $seqProyecto );

	// Definición de Arreglos para los Combos
	$arrTipoProyecto		= array();
	$arrTipoUrbanizacion	= array();
	$arrTipoSolucion		= array();
	$arrTipoDocumento		= array();
	$arrTipoEsquema			= array();
	$arrTipoOrganizacion	= array();

	// Asignaciones a la plantilla
	$claSmarty->assign( "seqEditar" , $seqProyecto );
	$claSmarty->assign( "objProyectoVivienda" , $arrProyectoVivienda[ $seqProyecto ] );
	$claSmarty->assign( "arrConfiguracion" , $arrConfiguracion );

	// Tipos de Proyecto
	$sql = "SELECT 
				seqTipoProyecto,
				txtTipoProyecto
			FROM 
				T_PRY_TIPO_PROYECTO
			WHERE 
				estado = 1
			ORDER BY 
				txtTipoProyecto
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoProyecto[$objRes->fields['seqTipoProyecto']] = $objRes->fields['txtTipoProyecto'];
		$objRes->MoveNext();
	}

	// Tipos de Urbanización
	$sql = "SELECT 
				seqTipoUrbanizacion,
				txtTipoUrbanizacion
			FROM 
				T_PRY_TIPO_URBANIZACION
			WHERE 
				estado = 1
			ORDER BY 
				txtTipoUrbanizacion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoUrbanizacion[$objRes->fields['seqTipoUrbanizacion']] = $objRes->fields['txtTipoUrbanizacion'];
		$objRes->MoveNext();
	}
	
	// Tipos de Solución
	$sql = "SELECT 
				seqTipoSolucion,
				txtTipoSolucion
			FROM 
				T_PRY_TIPO_SOLUCION
			WHERE 
				estado = 1
			ORDER BY 
				txtTipoSolucion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoSolucion[$objRes->fields['seqTipoSolucion']] = $objRes->fields['txtTipoSolucion'];
		$objRes->MoveNext();
	}
	
	// Tipos de Documento
	$sql = "SELECT 
				seqTipoDocumento,
				txtTipoDocumento
			FROM 
				T_CIU_TIPO_DOCUMENTO
			WHERE 
				seqTipoDocumento IN (1,2,6)
			ORDER BY 
				txtTipoDocumento
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoDocumento[$objRes->fields['seqTipoDocumento']] = $objRes->fields['txtTipoDocumento'];
		$objRes->MoveNext();
	}
	
	// Tipos de Esquema
	$sql = "SELECT 
				seqTipoEsquema,
				txtTipoEsquema
			FROM 
				T_PRY_TIPO_ESQUEMA
			WHERE 
				estado = 1
			ORDER BY 
				txtTipoEsquema
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoEsquema[$objRes->fields['seqTipoEsquema']] = $objRes->fields['txtTipoEsquema'];
		$objRes->MoveNext();
	}

	// Tipos de Organización
	$sql = "SELECT 
				seqTipoOrganizacion,
				txtTipoOrganizacion
			FROM 
				T_PRY_TIPO_ORGANIZACION
			WHERE 
				estado = 1
			ORDER BY 
				txtTipoOrganizacion
		";
	$objRes = $aptBd->execute($sql);
	while ($objRes->fields) {
		$arrTipoOrganizacion[$objRes->fields['seqTipoOrganizacion']] = $objRes->fields['txtTipoOrganizacion'];
		$objRes->MoveNext();
	}

	// Asignacion del Arreglo al Smarty
	$claSmarty->assign( "arrTipoProyecto", $arrTipoProyecto);
	$claSmarty->assign( "arrTipoUrbanizacion", $arrTipoUrbanizacion);
	$claSmarty->assign( "arrTipoSolucion", $arrTipoSolucion);
	$claSmarty->assign( "arrTipoDocumento", $arrTipoDocumento);
	$claSmarty->assign( "arrTipoEsquema", $arrTipoEsquema);
	$claSmarty->assign( "arrTipoOrganizacion", $arrTipoOrganizacion);
	
	// Muestra el formulario
	$claSmarty->display( "administracion/formularioProyectosVivienda.tpl" );

	// Desconecta la base de datos
	$aptBd->close();
?>