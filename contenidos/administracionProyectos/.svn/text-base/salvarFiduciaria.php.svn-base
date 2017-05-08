<?php
/**
* SALVA O EDITA LAS FIDUCIARIAS DE LA BASE DE DATOS
* @author Jaison Ospina
* @version 0.1 Diciembre 2013
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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Fiduciaria.class.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "RegistroActividades.class.php" );

/**
* Validacion del formulario de Fiduciarias
*/ 

$arrErrores = array();

//////////////////////////////////////////////// VALIDACION DATOS FIDUCIARIA ////////////////////////////////////////////////////

// Validacion del nombre
if( ( ! isset( $_POST['nombre'] ) ) or trim( $_POST['nombre'] ) == "" ){
   	$arrErrores[] = "Debe diligenciar el nombre de la Fiduciaria";
}

// Validacion del Tipo de Documento de la Fiduciaria
if( ( ! isset( $_POST['seqTipoDocumentoFiduciaria'] ) ) or trim( $_POST['seqTipoDocumentoFiduciaria'] ) == 0 ){
	$arrErrores[] = "Debe seleccionar el Tipo de Documento de la Fiduciaria";
}

// Validacion del Numero de Documento de la Fiduciaria
if( ( ! isset( $_POST['numDocumentoFiduciaria'] ) ) or trim( $_POST['numDocumentoFiduciaria'] ) == "" ){
	$arrErrores[] = "Debe diligenciar el N&uacute;mero de Documento de la Fiduciaria";
} else {
	if( $_POST['numDocumentoFiduciaria'] <= 0 ){
		$arrErrores[] = "El campo N&uacute;mero de Documento de la Fiduciaria debe ser mayor que cero";
	}
}

$exregfijo = "/^[0-9]{7}$/";
$exregcel = "/^[3]{1}[0-9]{9}$/";
if ($_POST['numTelefono1Fiduciaria'] == "" and $_POST['numTelefono2Fiduciaria'] == "") {
	echo $_POST['numTelefono1Fiduciaria'];
	$arrErrores[] = "La Fiduciaria debe tener un telefono de contacto";
} else {
	if ($_POST['numTelefono1Fiduciaria'] != "" && $_POST['numTelefono1Fiduciaria'] != 0) {
		if (!preg_match($exregfijo, $_POST['numTelefono1Fiduciaria'])) {
			$arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
		}
	}
	if ($_POST['numTelefono2Fiduciaria'] != "" && $_POST['numTelefono2Fiduciaria'] != 0) {
		if (!preg_match($exregcel, $_POST['numTelefono2Fiduciaria'])) {
			$arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
		}
	}
}

// Validacion del correo electronico de la Fiduciaria
if( ( ! isset( $_POST['txtCorreoElectronicoFiduciaria'] ) ) or trim( $_POST['txtCorreoElectronicoFiduciaria'] ) == "" ){
   	$arrErrores[] = "Debe diligenciar el correo electr&oacute;nico de la Fiduciaria";
} else {
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoElectronicoFiduciaria'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico de la Fiduciaria no es v&aacute;lido";
	}
}

////////////////////////////////////////// VALIDACION DATOS REPRESENTANTE LEGAL //////////////////////////////////////////////////

// Validacion del nombre del representante legal
if( ( ! isset( $_POST['txtNombreRepresentanteLegal'] ) ) or trim( $_POST['txtNombreRepresentanteLegal'] ) == "" ){
   	$arrErrores[] = "Debe diligenciar el nombre del representante legal";
}

// Validacion del nombre del representante legal
if( ( ! isset( $_POST['numDocumentoRepresentanteLegal'] ) ) or trim( $_POST['numDocumentoRepresentanteLegal'] ) == "" ){
   	$arrErrores[] = "Debe diligenciar el n&uacute;mero de documento del representante legal";
}

// Validacion del correo electronico del representante legal
if( ( ! isset( $_POST['txtCorreoElectronicoRepresentanteLegal'] ) ) or trim( $_POST['txtCorreoElectronicoRepresentanteLegal'] ) == "" ){
   	$arrErrores[] = "Debe diligenciar el correo electr&oacute;nico del representante legal";
} else {
	if( ! ereg( "^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$" , trim( $_POST['txtCorreoElectronicoRepresentanteLegal'] ) ) ){
		$arrErrores[] = "El correo electr&oacute;nico del representante legal no es v&aacute;lido";
	}
}

/**
* Salvar o editar Fiduciarias si no hay errores
*/

if( empty( $arrErrores ) ){
	$claFiduciaria = new Fiduciaria;
	$claRegistro = new RegistroActividades;

	// Verifica si es para crear o editar la Fiduciaria
	if( isset( $_POST['seqEditar'] ) and is_numeric( $_POST['seqEditar'] ) and $_POST['seqEditar'] > 0 ){
		$arrErrores = $claFiduciaria->editarFiduciaria( $_POST['seqEditar'] , trim( $_POST['nombre'] ) , $_POST['seqTipoDocumentoFiduciaria'] , trim( $_POST['numDocumentoFiduciaria'] ) , $_POST['txtDireccionFiduciaria'] , $_POST['numTelefono1Fiduciaria'] , $_POST['numTelefono2Fiduciaria'] , $_POST['txtCorreoElectronicoFiduciaria'] , $_POST['txtNombreRepresentanteLegal'] , $_POST['numDocumentoRepresentanteLegal'] , $_POST['txtCorreoElectronicoRepresentanteLegal'] , $_POST['bolActivo'] , $_POST['seqMenu'] );
		$claRegistro->registrarActividad( "Edicion" , 0 , $_SESSION['seqUsuario'] , "Edicion de la Fiduciaria: [" . $_POST['seqEditar'] . "] " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );
	} else {
		$arrErrores = $claFiduciaria->guardarFiduciaria( $_POST['seqFiduciaria'], trim( $_POST['nombre'] ) , $_POST['seqTipoDocumentoFiduciaria'] , trim( $_POST['numDocumentoFiduciaria'] ) , $_POST['txtDireccionFiduciaria'] , $_POST['numTelefono1Fiduciaria'] , $_POST['numTelefono2Fiduciaria'] , $_POST['txtCorreoElectronicoFiduciaria'] , $_POST['txtNombreRepresentanteLegal'] , $_POST['numDocumentoRepresentanteLegal'] , $_POST['txtCorreoElectronicoRepresentanteLegal'] , $_POST['bolActivo'], $_POST['seqMenu'] );
		$claRegistro->registrarActividad( "Creacion" , 0 , $_SESSION['seqUsuario'] , "Creacion de la Fiduciaria: " . trim( $_POST['nombre'] ) . " Mensaje: " . implode( "," , $arrErrores ) );	
	}
}

/**
* Impresion de resultados
*/

if( empty( $arrErrores ) ){
	//pr ($arrErrores);
	$arrMensajes[] = "La Fiduciaria <b>" . $_POST['nombre'] . "</b> se ha guardado";
	imprimirMensajes( array() , $arrMensajes , "salvarFiduciaria" );
} else {
	imprimirMensajes( $arrErrores , array() );
}

	// Desconecta la base de datos
	$aptBd->close();
?>