<?php
//set_time_limit(0);
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
$arrErrores = array();
$arrMensajes = array();

$seqUsuario = $_SESSION['seqUsuario'];
$fechaCreacion = date('Y-m-d H:i:s');

// Recibe datos básicos (POST)
$numeroActo			= $_POST['numActo'];
$fechaActo			= $_POST['fchActo'];
$tipoActoUnidad		= $_POST['seqTipoActoUnidad'];
$descripcionActo	= $_POST['txtDescripcion'];

// Valida existencia del acto
	if($numeroActo != ''){
		$sqlActo = "SELECT COUNT(*) AS acto
				FROM T_PRY_AAD_UNIDAD_ACTO
				WHERE numActo = $numeroActo AND fchActo = '$fechaActo'";
	$objRes = $aptBd->execute($sqlActo);
	while ($objRes->fields) {
		$existeActo = $objRes->fields['acto'];
		$objRes->MoveNext();
	}
	if ($existeActo > 0){
		$arrErrores[] = "Ya existe el acto";
	}
}

// Listado de proyectos de vivienda nueva válidos
$arrProyectos = array();
$sql = "SELECT seqProyecto, txtNombreProyecto
		FROM T_PRY_PROYECTO";
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
	$arrProyectos[$objRes->fields['seqProyecto']] = $objRes->fields['txtNombreProyecto'];
	$objRes->MoveNext();
}

// Validación datos básicos
if (!is_numeric($numeroActo) == true) {
	$arrErrores[] = "El número de acto no es válido";
}

if ($fechaActo == "") {
	$arrErrores[] = "La fecha del acto no puede estar vacía";
}

if ($tipoActoUnidad == 0) {
	$arrErrores[] = "El tipo de acto no es válido";
}

if ($descripcionActo == "") {
	$arrErrores[] = "La descripción del acto no puede estar vacía";
}

if( $_FILES['fileUnidadesActo']['error'] == UPLOAD_ERR_NO_FILE ){
	$arrErrores[] = "No se ha cargado el archivo plano";
}

// construccion del arreglo a procesar
$arrArchivo = array();
if( $_FILES['fileUnidadesActo']['error'] != UPLOAD_ERR_NO_FILE ){

	// Validación de los títulos
	if( empty( $arrErrores ) ){
		// abre el archivo
		$aptArchivoAux	= fopen( $_FILES['fileUnidadesActo']['tmp_name'] , "r" );
		$aptArchivo 	= fopen( $_FILES['fileUnidadesActo']['tmp_name'] , "r" );
		$aptArchivoOK 	= fopen( $_FILES['fileUnidadesActo']['tmp_name'] , "r" );

		// validacion de titulos del archivo
		$txtTitulos = fgets( $aptArchivoAux );
		$arrTitulos = split( "\t" , $txtTitulos );
		if( ! is_array( $arrTitulos ) ){
			$arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
		}
		if( strtolower( trim( $arrTitulos[ 0 ] ) ) != "proyecto" ){
			$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna 'proyecto'";
		}
		if( strtolower( trim( $arrTitulos[ 1 ] ) ) != "unidad proyecto" ){
			$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna 'unidad proyecto'";
		}
		if( strtolower( trim( $arrTitulos[ 2 ] ) ) != "valor indexacion" ){
			$arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna 'valor indexacion'";
		}
	}

	// Validación integridad de los datos
	if( empty( $arrErrores ) ) {
		$arrLineaAux = array();
		$numLineaAux = 0;
		while( $txtLineaAux = fgets( $aptArchivoAux ) ) {
			$numLineaAux++;
			$arrLineaAux = split( "\t" , $txtLineaAux );
			if( trim( $arrLineaAux[ 0 ] ) == '' ){
				$arrErrores[] = "Error Linea $numLineaAux: El proyecto no debe estar vacío";
			}
			if( trim( $arrLineaAux[ 1 ] ) == '' ){
				$arrErrores[] = "Error Linea $numLineaAux: La unidad de proyecto no debe estar vacía";
			}
			if( ! is_numeric( trim( $arrLineaAux[ 2 ] ) )){
				$arrErrores[] = "Error Linea $numLineaAux: El valor de indexación debe ser un campo numérico";
			}
		}
	}

	//////////////////////////////////////////////////// VALIDA LA EXISTENCIA DEL PROYECTO Y QUE LA UNIDAD CORRESPONDA AL PROYECTO
	if( empty( $arrErrores ) ){
		// validacion de las lineas del archivo
		$numLinea	= 0;
		$existe		= 0;
		$arrDatosCombinados = array();
		while( $txtLinea = fgets( $aptArchivo ) ){
			$numLinea++;
			$proyectoValido = 0;
			$unidadValida = 0;
			$codProyecto = 0;
			$codUnidad = 0;
			// obtiene los datos de la linea
			$arrLinea 			= split( "\t" , $txtLinea );
			$proyecto			= trim( $arrLinea[ 0 ] );
			$unidadProyecto		= trim( $arrLinea[ 1 ] );
			$valorIndexacion	= trim( $arrLinea[ 2 ] );

			// Valida que el nombre del proyecto sea válido
			if( in_array( $proyecto , $arrProyectos ) ){
				$proyectoValido = 1;
				$codProyecto = array_search($proyecto, $arrProyectos);
			} else {
				if ($numLinea <> 1){ // Si es la linea de los títulos, no valide
					$arrErrores[] = "No existe el proyecto $proyecto en la linea $numLinea";
				}
			}

			// Valida que la unidad existe en el proyecto y prepara el arreglo para ser utilizado en la indexación
			$arrUnidadProyecto = array();
			$sql = "SELECT seqUnidadProyecto, txtNombreUnidad, valSDVEActual, seqFormulario
					FROM T_PRY_UNIDAD_PROYECTO
					WHERE seqProyecto = $codProyecto
					AND txtNombreUnidad = '" . $unidadProyecto . "'
					LIMIT 1";
			$objRes = $aptBd->execute($sql);
			if ($numLinea <> 1){ // Si es la linea de los títulos, no valide
				if ($objRes->fields['seqUnidadProyecto'] <= 1){
					$arrErrores[] = "No existe la unidad $unidadProyecto en el proyecto $proyecto";
				} else { // Si no hay errores, se crea el arreglo
					$arrDatosCombinados[ $objRes->fields['seqUnidadProyecto'] ]['seqUnidadProyecto']	= $objRes->fields['seqUnidadProyecto'];
					$arrDatosCombinados[ $objRes->fields['seqUnidadProyecto'] ]['txtNombreUnidad']		= $objRes->fields['txtNombreUnidad'];
					$arrDatosCombinados[ $objRes->fields['seqUnidadProyecto'] ]['valSDVEActual']		= $objRes->fields['valSDVEActual'];
					$arrDatosCombinados[ $objRes->fields['seqUnidadProyecto'] ]['seqFormulario']		= $objRes->fields['seqFormulario'];
					$arrDatosCombinados[ $objRes->fields['seqUnidadProyecto'] ]['valIndexacion']		= $valorIndexacion;
				}
			}
			$objRes->MoveNext();
		} // Fin While
	} // Fin If errores

	////////////////////////////////////////////////////////// SI NO HAY ERRORES EN LA VALIDACION DE DATOS SE PROCEDE A INDEXAR
	if( empty( $arrErrores ) ){
		// Crea el acto
		$sqlNuevoActo = "INSERT INTO T_PRY_AAD_UNIDAD_ACTO (numActo, fchActo, seqTipoActoUnidad, txtDescripcion, fchCreacion, seqUsuario) 
						VALUES ($numeroActo, '$fechaActo', $tipoActoUnidad, '$descripcionActo', '$fechaCreacion', $seqUsuario)";
		$aptBd->execute($sqlNuevoActo);
		$ultimoActo = $aptBd->Insert_ID();

		// Recorre el arreglo con todos los datos del archivo y otros datos de indexación
		foreach ($arrDatosCombinados AS $seqUnidadProyecto => $arrUnidadAuxiliar){
			// Actualiza el valor Actual de la unidad
			$nuevoValorActual = $arrUnidadAuxiliar['valSDVEActual'] + $arrUnidadAuxiliar['valIndexacion'];
			$sqlUpdValorActual = "UPDATE T_PRY_UNIDAD_PROYECTO 
									SET valSDVEActual = " . $nuevoValorActual . "
									WHERE seqUnidadProyecto = " . $arrUnidadAuxiliar['seqUnidadProyecto'] . "";
//			$aptBd->execute($sqlUpdValorActual);
			// Inserta las unidades que van a ser indexadas
			$sqlAddUndVinculadas = "INSERT T_PRY_AAD_UNIDADES_VINCULADAS (seqUnidadActo, seqUnidadProyecto, valIndexado)
									VALUES ($ultimoActo, " . $arrUnidadAuxiliar['seqUnidadProyecto'] . ", " . $arrUnidadAuxiliar['valIndexacion'] . ") ";
			$aptBd->execute($sqlAddUndVinculadas);
			// Actualiza el valor del subsidio y soporte del cambio en el formulario
			$soporte = "Res. " . $numeroActo . " de " . $fechaActo;
			if ($arrUnidadAuxiliar['seqFormulario'] > 0) { // Si existe el formulario actualice los datos del subsidio
				$sqlUpdateSubsidio = "UPDATE T_FRM_FORMULARIO 
									SET valAspiraSubsidio = " . $nuevoValorActual . ", txtSoporteSubsidio = '" . $soporte . "'
									WHERE seqUnidadProyecto = " . $arrUnidadAuxiliar['seqUnidadProyecto'] . "";
//				$aptBd->execute($sqlUpdateSubsidio);
			}
		} // Fin foreach
	} // Fin If errores
}
	///////////////////////////////////////////////////////////////////////// IMPRIMIR MENSAJES
	if( empty( $arrErrores ) ){
		$arrMensajes[] = "El Acto $numeroActo de $fechaActo se ha salvado";
		$txtEstilo = "msgOk";
	}else{
		$arrMensajes = $arrErrores;
		$txtEstilo = "msgError";
	}
	echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";
	foreach( $arrMensajes as $txtMensaje ){
		echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
	}
	echo "</table>";
?>