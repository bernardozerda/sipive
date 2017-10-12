<?php

    set_time_limit ( 86400 );

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Encuestas.class.php");
	
	$claEncuesta = new Encuestas();
	$arrErrores = array();
	$arrExtensiones[] = "csv";
	$arrExtensiones[] = "txt";
	
	// Valida que se coloque un nombre para el cargue
	if( trim($_POST['nombreSelect']) == "" and trim($_POST['nombreInput']) == ""){
		$arrErrores[] = "Debe dar un nombre al cargue";
	}else{
		$txtNombre = (trim($_POST['nombreSelect']) == "")? trim($_POST['nombreInput']) : trim($_POST['nombreSelect']);
	}
	
	// Valida que se seleccione un diseño de encuesta 
	if( $_POST['diseno'] == 0 ){
		$arrErrores[] = "Seleccione un formato de encuesta";
	}else{
		$claEncuesta = array_shift($claEncuesta->obtenerDiseno($_POST['diseno']));
	} 
	
	// Si el diseño solicita un archivo para formularios
	if($claEncuesta->bolFormulario == 1){

		// Validacion del cargue de archivos
		switch ($_FILES['formulario']['error']) {
			case UPLOAD_ERR_INI_SIZE:
				$arrErrores[] = "El archivo \"" . $_FILES['formulario']['name'] . "\" Excede el tamaño permitido";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$arrErrores[] = "El archivo \"" . $_FILES['formulario']['name'] . "\" Excede el tamaño permitido";
				break;
			case UPLOAD_ERR_PARTIAL:
				$arrErrores[] = "El archivo \"" . $_FILES['formulario']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
				break;
			case UPLOAD_ERR_NO_FILE:
				$arrErrores[] = "Debe especificar un archivo de formulario para cargar";
				break;
			default:
				$numPunto = strpos($_FILES['formulario']['name'], ".") + 1;
				$numRestar = ( strlen($_FILES['formulario']['name']) - $numPunto ) * -1;
				$txtExtension = substr($_FILES['formulario']['name'], $numRestar);
				if (!in_array(strtolower($txtExtension), $arrExtensiones)) {
					$arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
				}
				break;
		}

		// validacion de preguntas completas para el archivo de formulario
		if( empty($arrErrores) ){
			$aptArchivo = fopen($_FILES['formulario']['tmp_name'], "r");
			if ($aptArchivo) {
				$txtLinea = fgets($aptArchivo);
				$arrTitulosformulario = mb_split("\t", $txtLinea);

				// limpieza del archivo
				foreach($arrTitulosformulario as $i => $txtLinea){
					if( mb_strtoupper(trim($txtLinea),"UTF-8") != ""){
						$arrTitulosformulario[$i] = mb_strtoupper(trim($txtLinea),"UTF-8");
					}else{
						unset($arrTitulosformulario[$i]);
					}
				}

				// valida que todas las respuestas tengan columna
				$arrErrores = $claEncuesta->validarTitiulos($arrTitulosformulario,"formulario");

				// Si no hay errores se realiza la transformacion del archivo en arreglo
				if(empty($arrErrores)){
					$arrIdEncuesta = array();
					while( $txtLinea = fgets($aptArchivo) ){
						$arrLinea = mb_split("\t", utf8_encode($txtLinea));
						if(trim($arrLinea[0]) != ""){
							$arrIdEncuesta[] = $arrLinea[0];
							$numCuenta = count($arrFormulario);
							foreach( $arrTitulosformulario as $i => $txtClave ){
								$arrFormulario[$numCuenta][$txtClave] = $arrLinea[$i];
							}
						}
					}
				}

			}else{
				$arrErrores[] = "No se ha podido abrir el archivo " . $_FILES['formulario']['name'];
			}
		}

		//validacion de los datos de las variables, tipos de datos y respuestas
		if(empty($arrErrores)){
			$arrErrores = $claEncuesta->validarRespuestas($arrFormulario,"formulario");
		}

	}
	
	if($claEncuesta->bolCiudadano == 1){

		// Validaciones del cargue del archivo
		switch ($_FILES['ciudadano']['error']) {
			case UPLOAD_ERR_INI_SIZE:
				$arrErrores[] = "El archivo \"" . $_FILES['ciudadano']['name'] . "\" Excede el tamaño permitido";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$arrErrores[] = "El archivo \"" . $_FILES['ciudadano']['name'] . "\" Excede el tamaño permitido";
				break;
			case UPLOAD_ERR_PARTIAL:
				$arrErrores[] = "El archivo \"" . $_FILES['ciudadano']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
				break;
			case UPLOAD_ERR_NO_FILE:
				$arrErrores[] = "Debe especificar un archivo de ciudadano para cargar";
				break;
			default:
				$numPunto = strpos($_FILES['ciudadano']['name'], ".") + 1;
				$numRestar = ( strlen($_FILES['ciudadano']['name']) - $numPunto ) * -1;
				$txtExtension = substr($_FILES['ciudadano']['name'], $numRestar);
				if (!in_array(strtolower($txtExtension), $arrExtensiones)) {
					$arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
				}
				break;
		}

		// validacion de preguntas completas para el archivo de ciudadano
		if( empty($arrErrores) ){
			$aptArchivo = fopen($_FILES['ciudadano']['tmp_name'], "r");
			if ($aptArchivo) {
				$txtLinea = fgets($aptArchivo);
				$arrTitulosCiudadano = mb_split("\t", $txtLinea);

				// limpieza de la linea
				foreach($arrTitulosCiudadano as $i => $txtLinea){
					if( mb_strtoupper(trim($txtLinea),"UTF-8") != ""){
						$arrTitulosCiudadano[$i] = mb_strtoupper(trim($txtLinea),"UTF-8");
					}else{
						unset($arrTitulosCiudadano[$i]);
					}
				}

				// validando los titulos del archivo
				$arrErrores = $claEncuesta->validarTitiulos($arrTitulosCiudadano,"ciudadano");

				// convierte la linea en un arreglo identificador ==> valor
				if(empty($arrErrores)){
					while( $txtLinea = fgets($aptArchivo) ){
						$arrLinea = mb_split("\t", utf8_encode($txtLinea));
						if(trim($arrLinea[0]) != ""){
							if( in_array($arrLinea[0], $arrIdEncuesta) ){
								unset($arrIdEncuesta[ array_shift(array_keys($arrIdEncuesta,$arrLinea[0])) ]);
							}
							$numCuenta = count($arrCiudadano);
							foreach( $arrTitulosCiudadano as $i => $txtClave ){
								$arrCiudadano[$numCuenta][$txtClave] = $arrLinea[$i];
							}
						}
					}
					if( ! empty($arrIdEncuesta) ){
						$arrErrores[] = "Debe haber al menos un ciudadano vinculado a los formularios " . implode(",", $arrIdEncuesta);
						$arrErrores[] = "Verifique el archivo de formularios que no haya lineas duplicadas para los numeros de formularios " . implode(",", $arrIdEncuesta);
					}
				}
			}else{
				$arrErrores[] = "No se ha podido abrir el archivo " . $_FILES['ciudadano']['name'];
			}
		}

		//validacion de los datos de las variables, tipos de datos y respuestas
		if(empty($arrErrores)){
			$arrErrores = $claEncuesta->validarRespuestas($arrCiudadano,"ciudadano");
		}

	}

	// verifica que los que contestan la encuesta este dentro de los ciudadanos
    $arrDocumentos = array();
	if( ! empty( $arrCiudadano ) ) {
        foreach ($arrCiudadano as $arrDatos) {
            $arrDocumentos[] = $arrDatos['NUM_DOCUM'];
        }
        foreach($arrFormulario as $arrAplicacion){
            if( ! in_array( $arrAplicacion['NUMERO_DOC'] , $arrDocumentos ) ){
                $arrErrores[] = "Error Formulario " . $arrAplicacion['FORMULARIO'] . " El documento " . $arrAplicacion['NUMERO_DOC'] . " no se encuentra dentro de los ciudadanos encuestados";
            }
        }
    }

	// Si no hay errores salva la informacion
	if(empty($arrErrores)){
		$numInicio = time();
		$arrErrores = $claEncuesta->salvar($txtNombre,$arrFormulario,$arrCiudadano);
		$numFinal = time();
	}

	$arrMensajes = (empty($arrErrores))? "Fueron Cargados " . count($arrFormulario) . " aplicaciones de encuesta [" . ($numFinal - $numInicio) . "]" : array();
	
	imprimirMensajes($arrErrores, $arrMensajes);
	
?>