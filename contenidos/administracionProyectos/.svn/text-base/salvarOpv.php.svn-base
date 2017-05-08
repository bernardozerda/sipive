<?php
/**
* SALVA O EDITA LAS OPVS DE LA BASE DE DATOS
* @author Jaison Ospina
* @version 0.1 Noviembre 2013
*/

// Posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Opv.class.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );

/**
* Validacion del formulario de opvs
*/ 

$arrErrores = array();

// Validacion del nombre
if( ( ! isset( $_POST['nombre'] ) ) or trim( $_POST['nombre'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre de la OPV";
}

// Validacion del NIT de la OPV
if( ( ! isset( $_POST['numNitOpv'] ) ) or trim( $_POST['numNitOpv'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el NIT de la OPV";
}

// Validacion del nombre
if( ( ! isset( $_POST['txtRepresentanteOpv'] ) ) or trim( $_POST['txtRepresentanteOpv'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el nombre del Representante de la OPV";
}

// Validacion del Tipo de Documento del representante de la OPV
if( ( ! isset( $_POST['seqTipoDocRepresentanteOpv'] ) ) or trim( $_POST['seqTipoDocRepresentanteOpv'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Documento del Representante de la OPV";
}

// Validacion del numero de documento del representante de la OPV
if( ( ! isset( $_POST['numDocRepresentanteOpv'] ) ) or trim( $_POST['numDocRepresentanteOpv'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el N&uacute;mero de documento del Representante de la OPV";
}

/**
* Salvar o editar Opvs si no hay errores
*/

if( empty( $arrErrores ) ){

	$claOpv = new Opv;
	$claRegistro = new RegistroActividades;

	//echo $_POST['seqEditar'] . trim( $_POST['nombre'] ) . $_POST['numNitOpv'] . trim( $_POST['txtRepresentanteOpv'] ) . $_POST['seqTipoDocRepresentanteOpv'] . $_POST['numDocRepresentanteOpv'] . $_POST['bolActivo'];

	// Verifica si es para crear o editar la Opv
	if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
		$arrErrores = $claOpv->editarOpv( $_POST['seqEditar'] , trim( $_POST['nombre'] ) , $_POST['numNitOpv'] , trim( $_POST['txtRepresentanteOpv'] ) , $_POST['seqTipoDocRepresentanteOpv'] , $_POST['numDocRepresentanteOpv'] , $_POST['bolActivo'] , $_POST['seqMenu'] );
		$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de Opv: [" . $_POST['seqEditar'] . "] " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
	} else {
		$arrErrores = $claOpv->guardarOpv( $_POST['seqOpv'], trim( $_POST['nombre'] ) , $_POST['numNitOpv'] , trim( $_POST['txtRepresentanteOpv'] ) , $_POST['seqTipoDocRepresentanteOpv'] , $_POST['numDocRepresentanteOpv'] , $_POST['bolActivo'], $_POST['seqMenu'] );
		$claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de Opv: " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );	
	}
}

/**
* Impresion de resultados
*/

if( empty( $arrErrores ) ){
	$arrMensajes[] = "La Opv <b>" . $_POST['nombre'] . "</b> se ha guardado";
	imprimirMensajes( array() , $arrMensajes , "salvarOpv" );
}else{
	imprimirMensajes( $arrErrores , array() );
}

// Desconecta la base de datos
$aptBd->close();

?>