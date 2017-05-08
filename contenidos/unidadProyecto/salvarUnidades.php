<?php
	/**
	* INICIO DE LA PANTALLA DE VERIFICACION DE UNIDADES
	* @author Jaison Ospina
	* @version 1.0 Jul 2015
	*/
	date_default_timezone_set("America/Bogota");

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );

	$arrErrores = array();
	$arrMensajes = array();

	$arrExtensiones[]	= "csv";
	$arrExtensiones[]	= "txt";

	/**********************************************************************
	* VALIDACIONES DEL FORMULARIO Y DEL ARCHIVO
	**********************************************************************/

	// validaciones para el archivo cargado
	switch ($_FILES['archivo']['error']) {
		case UPLOAD_ERR_INI_SIZE:
			$arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
		break;
		case UPLOAD_ERR_FORM_SIZE:
			$arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
		break;
		case UPLOAD_ERR_PARTIAL:
			$arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
		break;
		case UPLOAD_ERR_NO_FILE:
			$arrErrores[] = "Debe especificar un archivo para cargar";
		break;
		default:
			$numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
			$numRestar = ( strlen($_FILES['archivo']['name']) - $numPunto ) * -1;
			$txtExtension = substr($_FILES['archivo']['name'], $numRestar);
			if (!in_array(strtolower($txtExtension), $arrExtensiones)) {
					$arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
			}
		break;
	}

	// validaciones para las lineas del archivo
	if (empty($arrErrores)) {
		$aptArchivo = fopen($_FILES['archivo']['tmp_name'], "r");
		if ($aptArchivo) {
			$txtLinea = fgets($aptArchivo);
			$numLinea = 0;
			while ($txtLinea = fgets($aptArchivo)) {
				$numLinea++;
				$txtLinea = utf8_encode($txtLinea);

				// Separa las lineas para que cada linea quede en un array
				$arrLinea = "";
				$arrLinea = mb_split("\t", trim($txtLinea));

				// Limpia y codifica cada uno de los campos
				foreach ($arrLinea as $txtClave => $txtValor) {
					$arrLinea[$txtClave] = trim($txtValor);
				}

				// Valida que los textos del archivo no hayan sido cambiados
				$seqUnidadProyecto	= $arrLinea[0];
				$seqProyecto		= $arrLinea[1];
				$txtNombreUnidad 	= $arrLinea[2];
				$valAprobado 		= $arrLinea[3];
				$valIndexacion1		= $arrLinea[4];
				$valResIndexacion1	= $arrLinea[5];
				$fchResIndexacion1	= $arrLinea[6];
				$valIndexacion2		= $arrLinea[7];
				$valResIndexacion2	= $arrLinea[8];
				$fchResIndexacion2	= $arrLinea[9];
				$valIndexacion3		= $arrLinea[10];
				$valResIndexacion3	= $arrLinea[11];
				$fchResIndexacion3	= $arrLinea[12];

				// Si no existe el codigo de unidad
				if ($seqUnidadProyecto == 0 || $seqUnidadProyecto == "") {
					$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad no existe";
				}

				// Si no existe el código de Proyecto
				if ($seqProyecto == 0 || $seqProyecto == "") {
					$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El Proyecto no existe";
				}

				// Si no existe el nombre de la unidad
				if ($txtNombreUnidad == "") {
					$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": El nombre de la unidad no existe";
				}

				// Debe existir el valor aprobado
				if ($valAprobado == 0 || $valAprobado == "") {
					$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener un valor de aprobación";
				}

				// Si hay un valor de indexación 1 debe tener resolucion y fecha
				if ($valIndexacion1 > 0) {
					if ($valResIndexacion1 == 0 || $valResIndexacion1 == "") {
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener un número de resolución de indexación 1";
					}
					if ($fchResIndexacion1 == '0000-00-00' || $fchResIndexacion1 == ""){
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener una fecha de resolución de indexación 1";
					}
				}

				// Si hay un valor de indexación 2 debe tener resolucion y fecha
				if ($valIndexacion2 > 0) {
					if ($valResIndexacion2 == 0 || $valResIndexacion2 == "") {
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener un número de resolución de indexación 2";
					}
					if ($fchResIndexacion2 == '0000-00-00' || $fchResIndexacion2 == ""){
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener una fecha de resolución de indexación 2";
					}
				}

				// Si hay un valor de indexación 3 debe tener resolucion y fecha
				if ($valIndexacion3 > 0) {
					if ($valResIndexacion3 == 0 || $valResIndexacion3 == "") {
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener un número de resolución de indexación 3";
					}
					if ($fchResIndexacion3 == '0000-00-00' || $fchResIndexacion3 == ""){
						$arrErrores[] = "Error Linea " . ( $numLinea + 1 ) . ": La unidad debe tener una fecha de resolución de indexación 3";
					}
				}

				// si toda la linea esta bien la pasa al arreglo
				if (empty($arrErrores)) {
					$arrLinea[0] = $seqUnidadProyecto;
					$arrLinea[1] = $seqProyecto;
					$arrLinea[2] = $txtNombreUnidad;
					$arrLinea[3] = $valAprobado;
					$arrLinea[4] = $valIndexacion1;
					$arrLinea[5] = $valResIndexacion1;
					// Convierte la fecha de indexación 1 recibida de excel para almacenarla
					$posicion = strpos($fchResIndexacion1, "/");
					if ($posicion === false) { // Si no encuentra el caracter '/' convertir
						$arrLinea[6] = $fchResIndexacion1;
					} else {
						$array = explode("/", $fchResIndexacion1);
						$arrLinea[6] = $array[2]."-".$array[1]."-".$array[0];
					}
					$arrLinea[7] = $valIndexacion2;
					$arrLinea[8] = $valResIndexacion2;
					// Convierte la fecha de indexación 2 recibida de excel para almacenarla
					$posicion = strpos($fchResIndexacion2, "/");
					if ($posicion === false) { // Si no encuentra el caracter '/' convertir
						$arrLinea[9] = $fchResIndexacion2;
					} else {
						$array = explode("/", $fchResIndexacion2);
						$arrLinea[9] = $array[2]."-".$array[1]."-".$array[0];
					}
					$arrLinea[10] = $valIndexacion3;
					$arrLinea[11] = $valResIndexacion3;
					// Convierte la fecha de indexación 3 recibida de excel para almacenarla
					$posicion = strpos($fchResIndexacion3, "/");
					if ($posicion === false) { // Si no encuentra el caracter '/' convertir
						$arrLinea[12] = $fchResIndexacion3;
					} else {
						$array = explode("/", $fchResIndexacion3);
						$arrLinea[12] = $array[2]."-".$array[1]."-".$array[0];
					}
					$arrArchivo[$numLinea] = $arrLinea;
				}
			}
		} else {
			$arrErrores[] = "El archivo no se pudo abrir";
		}
	}
	// ACTUALIZANDO LOS VALORES DE LA TABLA
	if (empty($arrErrores)) {
		// Consulta las unidades que tiene el proyecto en la tabla T_PRY_UNIDAD_PROYECTO
		$sql = "SELECT
					seqProyecto,
					COUNT(*) AS cantidad
				FROM T_PRY_UNIDAD_PROYECTO
				WHERE seqProyecto = '" . $seqProyecto . "'
				GROUP BY seqProyecto";
		$objRes = $aptBd->execute($sql);
		$seqProyecto = 0;
		if ($objRes->fields) {
			$seqProyecto = $objRes->fields['seqProyecto'];
			$numCantidad = $objRes->fields['cantidad'];
		}
		//echo "Lineas Archivo: " . $numLinea . "<br>Lineas Consulta: ". $numCantidad;

		// Compara el número de unidades del archivo cargado contra las que existen en la tabla T_PRY_UNIDAD_PROYECTO
		if ($numLinea == $numCantidad) {
			foreach ($arrArchivo as $numLinea => $arrLinea) {
				$nuevoValorSDVE = $arrLinea[3] + $arrLinea[4] + $arrLinea[7] + $arrLinea[10];
				$sql = "UPDATE
							T_PRY_UNIDAD_PROYECTO
						SET
							valSDVEIndexacion1 = '" . $arrLinea[4] . "',
							valResIndexacion1 = '" . $arrLinea[5] . "',
							fchResIndexacion1 = '" . $arrLinea[6] . "',
							valSDVEIndexacion2 = '" . $arrLinea[7] . "',
							valResIndexacion2 = '" . $arrLinea[8] . "',
							fchResIndexacion2 = '" . $arrLinea[9] . "',
							valSDVEIndexacion3 = '" . $arrLinea[10] . "',
							valResIndexacion3 = '" . $arrLinea[11] . "',
							fchResIndexacion3 = '" . $arrLinea[12] . "',
							valSDVEActual = " . $nuevoValorSDVE . "
						WHERE
							seqUnidadProyecto = " . $arrLinea[0] . "
						AND
							seqProyecto = " . $arrLinea[1] . ";";
				//echo $sql."<br>";
				$aptBd->execute($sql);
			}
		} else {
			$arrErrores[] = "La cantidad de registros del archivo cargado no coincide con los existentes en la base de datos";
		}
	}

	/*****************************************************************************
	* PROCESAMIENTO DE LOS DATOS DEL ARCHIVO
	* ************************************************************************* */

	if (empty($arrErrores)) {
		$arrMensajes[] = "Se han actualizado las " . $numCantidad . " unidades correctamente";
	}

	imprimirMensajes($arrErrores, $arrMensajes);
?>