<?php
/**
* ARCHIVO PARA EL FORMULARIO
* DE BUSQUEDA DE LA OFERTA
*/

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );

$seqFormulario = $_POST['seqFormulario'];

include( "./datosComunes.php" );

$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario( $seqFormulario );

if( in_array( $claFormulario->seqEstadoProceso , $claFlujoDesembolsos->arrFases[ $_POST['flujo'] ][ $_POST['fase'] ]['permisos'] ) ){

	// obtiene los estados que corresponden al estado del proceso del formulario
	$arrFlujoHogar = $claFlujoDesembolsos->obtenerFlujo( $seqFormulario , $claFormulario->seqEstadoProceso , $_POST['flujo'] );

	// Obtiene los datos del desembolso
	$claDesembolso = new Desembolso;
	$claDesembolso->cargarDesembolso( $seqFormulario );

	// Obtienr los ultimos seguimientos
	$claSeguimiento = new Seguimiento;
	$claSeguimiento->seqFormulario = $seqFormulario;
	$arrRegistros = $claSeguimiento->obtenerRegistros( 100 );

	// Carga el tutor que tiene asignado ese hogar
	$claCRM = new CRM;
	$txtTutor = $claCRM->obtenerTutorHogar( $seqFormulario );
	
	// Obtiene el postulante principal
	foreach( $claFormulario->arrCiudadano as $objCiudadano ){
		if( $objCiudadano->seqParentesco == 1 ){
			$numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
			break;
		}
	}

	// OBTIENE EL NOMBRE DEL PROYECTO QUE ESTÁ ASOCIADO A LA ESCRITURACIÓN
	$sqlAuxiliar = "SELECT T_PRY_UNIDAD_PROYECTO.seqProyecto, seqProyectoPadre
					FROM T_PRY_UNIDAD_PROYECTO INNER JOIN T_PRY_PROYECTO ON (T_PRY_UNIDAD_PROYECTO.seqProyecto = T_PRY_PROYECTO.seqProyecto )
					WHERE seqFormulario = $seqFormulario";
	$objRes = $aptBd->execute( $sqlAuxiliar );
	$idProyecto			= $objRes->fields['seqProyecto'];
	$idProyectoPadre	= $objRes->fields['seqProyectoPadre'];
	if ($idProyectoPadre == 0 || $idProyectoPadre == '') {
		$proyectoPPal	= $idProyecto;
	} else {
		$proyectoPPal	= $idProyectoPadre;
		$conjuntoRes	= $idProyecto;
	}
	// Nombre Proyecto
	$sqlNombrePry = "SELECT txtNombreComercial
					FROM T_PRY_PROYECTO
					WHERE seqProyecto = $proyectoPPal";
	$objRes = $aptBd->execute( $sqlNombrePry );
	$nombreCcial	= $objRes->fields['txtNombreComercial'];
	// Nombre Conjunto
	if ($conjuntoRes != 0){
		$sqlNombrePry = "SELECT txtNombreComercial
						FROM T_PRY_PROYECTO
						WHERE seqProyecto = $conjuntoRes";
		$objRes = $aptBd->execute( $sqlNombrePry );
		$NombreConjunto	= $objRes->fields['txtNombreComercial'];
	}
	// Preparando variable
	if ($idProyectoPadre == 0 || $idProyectoPadre == '') {
		$nombreProyecto = $nombreCcial;
	} else {
		$nombreProyecto = $nombreCcial . " - " . $NombreConjunto;
	}

	// obtiene la informacion de la pestana de actos administrativos
	$claActosAdministrativos = new ActoAdministrativo();
	$arrActos = $claActosAdministrativos->cronologia( $numDocumento );

	$claSmarty->assign( "arrActos" , $arrActos ); // Pestania de actos administrativos
	$claSmarty->assign( "arrRegistros" , $arrRegistros ); // Registros de seguimiento
	if( $_POST['fase'] == "escrituracion" ){
		if( is_array( $claDesembolso->arrEscrituracion ) ){
			foreach( $claDesembolso->arrEscrituracion as $txtClave => $txtValor ){
				$claDesembolso->$txtClave = $txtValor;
			}
		}
	}
	$claSmarty->assign( "claDesembolso" , $claDesembolso );
	$claSmarty->assign( "nombreProyecto" , $nombreProyecto );
	$claSmarty->assign( "claFormulario" , $claFormulario );
	$claSmarty->assign( "arrFlujoHogar" , $arrFlujoHogar ); // Flujo de datos aplicado al hogar
	$claSmarty->assign( "txtTutor" , $txtTutor );
	$claSmarty->assign( "txtFase" , $_POST['fase'] );
	$claSmarty->display( $claFlujoDesembolsos->arrFases[ $_POST['flujo'] ][ $_POST['fase'] ]['plantilla'] );
} else{
	$arrEstados = estadosProceso();
	$arrErrores[] = "Este hogar no se encuentra listo para realizar el proceso de desembolso, el estado actual es: " . $arrEstados[ $claFormulario->seqEstadoProceso ];
	imprimirMensajes( $arrErrores , array() );
}
?>