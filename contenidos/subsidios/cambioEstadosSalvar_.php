<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

//    pr( $_POST );
//    pr( $_FILES );

/**
 * VALIDACIONES 
 * */
$arrErrores = array();
$arrMensajes = array();

// Establece el orden de los estados
// esto es para evitar cambios de estado
// hacia atras en el proceso
// solo funciona para archivos masivos
$arrEstadosNombre = estadosProceso();
$arrEstadosOrden = array();
foreach ($arrEstadosNombre as $seqEstadoProceso => $txtEstadoProceso) {
    $numOrden = count($arrEstadosOrden);
    $arrEstadosOrden[$numOrden] = $seqEstadoProceso;
}

// Grupo de Gestion 
if ($_POST['seqGrupoGestion'] == 0) {
    $arrErrores[] = "Seleccione el grupo de la gestión realizada";
}

// Gestion
if ($_POST['seqGestion'] == 0) {
    $arrErrores[] = "Seleccione la gestión realizada";
}

// Comentarios
if ($_POST['txtComentario'] == "") {
    $arrErrores[] = "Por favor diligencie el campo de comentarios";
}



// construccion del arreglo a procesar
$arrArchivo = array();
if ($_FILES['archivo']['error'] != UPLOAD_ERR_NO_FILE) {
    $bolProhibidoAtras = true;

    // Errores en la carga de archivos
    switch ($_FILES['archivo']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
            break;
        case UPLOAD_ERR_PARTIAL:
            $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
            break;
    }

    if (empty($arrErrores)) {

        // abre el 
        $aptArchivo = fopen($_FILES['archivo']['tmp_name'], "r");

        // validacion de titulos del archivo
        $txtTitulos = fgets($aptArchivo);
        $arrTitulos = split("\t", $txtTitulos);

        if (!is_array($arrTitulos)) {
            $arrErrores[] = "Al parecer el archivo no esta separado por tabulaciones";
        }

        if (strtolower(trim($arrTitulos[0])) != "documento") {
            $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Documento\" ";
        }

        if (strtolower(trim($arrTitulos[1])) != "estado") {
            $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Estado\" ";
        }

        if (strtolower(trim($arrTitulos[2])) != "comentario") {
            $arrErrores[] = "El archivo no tiene el formato correcto, le fata la columna \"Comentario\" ";
        }

        // validacion de las lineas del archivo
        $numLinea = 2;
        while ($txtLinea = fgets($aptArchivo)) {

            // obtiene los datos de la linea
            $arrLinea = split("\t", $txtLinea);
            $numDocumento = trim($arrLinea[0]);
            $seqEstadoProceso = trim($arrLinea[1]);
            $txtComentario = trim($arrLinea[2]);

            // validacion del numero de documento
            if (!is_numeric($numDocumento)) {
                $arrErrores[] = "Error Linea $numLinea: El campo documento debe tener un valor numérico";
            }

            // validacion del estado
            if (!isset($arrEstadosNombre[$seqEstadoProceso])) {
                $arrErrores[] = "Error Linea $numLinea: El estado del proceso $seqEstadoProceso no existe";
            }

            // si no hay comentario toma el del post
            $txtComentario = ( trim($txtComentario) == "" ) ? trim($_POST['txtComentario']) : trim($txtComentario);

            // numero de documento en la base de datos
            $claCiudadanoCambio = new Ciudadano();
            $seqFormulario = $claCiudadanoCambio->formularioVinculado($numDocumento, false, true);
            if ($seqFormulario == 0) {
                $arrErrores[] = "Error Linea $numLinea: El número de documento no existe en la base de datos";
            }

            // datos del archivo al arreglo
            $arrArchivo[$seqFormulario]['documento'] = $numDocumento;
            $arrArchivo[$seqFormulario]['estado'] = $seqEstadoProceso;
            $arrArchivo[$seqFormulario]['comentario'] = $txtComentario;

            // incrementa el numero de linea para el control
            $numLinea++;
        } // fin validacion de lineas
    }
} else {

    // Estado del proceso
    if ($_POST['seqEstadoProceso'] == 0) {
        $arrErrores[] = "Seleccione un estado del proceso v&aacute;lido";
    }

    $bolProhibidoAtras = false;

    $buscaCedulaFormat = str_replace(".", "", $_POST['buscaCedula']);
    $buscaCedulaConfirmacionFormat = str_replace(".", "", $_POST['buscaCedulaConfirmacion']);

    if (trim($buscaCedulaFormat) != trim($buscaCedulaConfirmacionFormat)) {
        $arrErrores[] = "Verifique que el número de documento este bien escrito";
    } else {

        // Obtiene los datos del post
        $seqTipoDocumento = trim($_POST['seqTipoDocumento']);
        $numDocumento = trim($buscaCedulaFormat);
        $seqEstadoProceso = trim($_POST['seqEstadoProceso']);
        $txtComentario = trim($_POST['txtComentario']);

        // numero de documento en la base de datos
        $seqFormulario = Ciudadano::formularioVinculado($numDocumento, false, true);
        if ($seqFormulario == 0) {
            $arrErrores[] = "El número de documento no existe en la base de datos";
        }

        // datos al arreglo
        $arrArchivo[$seqFormulario]['documento'] = $numDocumento;
        $arrArchivo[$seqFormulario]['estado'] = $seqEstadoProceso;
        $arrArchivo[$seqFormulario]['comentario'] = $txtComentario;
    }
} // fin si viene de un archivo
// Validacion de cambios hacia adelante
$arrFormularios = array();
foreach ($arrArchivo as $seqFormulario => $arrDatos) {

    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($seqFormulario);

    // restriccion levantada
    $bolProhibidoAtras = false;
    if ($bolProhibidoAtras == true) {

        $arrPosicionFutura = array_keys($arrEstadosOrden, $arrDatos['estado']);
        $numPosicionFutura = $arrPosicionFutura[0];

        $arrPosicionActual = array_keys($arrEstadosOrden, $claFormulario->seqEstadoProceso);
        $numPosicionActual = $arrPosicionActual[0];

        if ($numPosicionFutura < $numPosicionActual) {
            $arrErrores[] = "No puede realizar el cambio de '" . $arrEstadosNombre[$claFormulario->seqEstadoProceso] . "' a '"
                    . $arrEstadosNombre[$arrDatos['estado']] . "' para el documento " . number_format($arrDatos['documento']);
        }
    }

    if (empty($arrErrores)) {

        $claFormulario->seqEstadoProceso = $arrDatos['estado'];
        $claFormulario->fchUltimaActualizacion = date("Y-m-d H:i:s");

        // para paso a riego
        if ($arrDatos['estado'] == 6) {
            $claFormulario->seqProyecto = 37; // Ninguno
            $claFormulario->seqProyectoHijo = 0;
            $claFormulario->seqUnidadProyecto = 1; // Ninguno
        }

        // para paso a inscrito
        if ($arrDatos['estado'] == 36) {
            //$claFormulario->txtFormulario = "";
            $claFormulario->fchInscripcion = "";
            $claFormulario->fchPostulacion = "";
            $claFormulario->fchVigencia = "";
            $claFormulario->fchUltimaActualizacion = date( "Y-m-d H:i:s" );
            $claFormulario->seqPlanGobierno = 3; // Bogota Mejor Para Todos
            $claFormulario->seqTipoEsquema = 1; // Individual
            $claFormulario->seqModalidad = 6; // Adquisición de Vivienda Nueva
            $claFormulario->seqSolucion = 13; // Solución correspondiente a la modalidad Vivienda Nueva
            $claFormulario->seqProyecto = 37; // Ninguno
            $claFormulario->fchVigencia = "";
            $claFormulario->seqProyectoHijo = 0;
            $claFormulario->seqUnidadProyecto = 1; // Ninguno
            $claFormulario->txtDireccionSolucion = "";
            $claFormulario->txtMatriculaInmobiliaria = "";
            $claFormulario->txtChip = "";
            $claFormulario->bolPromesaFirmada = 0;
            $claFormulario->bolIdentificada = 0;
            $claFormulario->bolViabilizada = 0;
            $claFormulario->valAvaluo = 0;
            $claFormulario->valTotal = 0;
            $claFormulario->bolCerrado = 0;
            // Libera Unidad Habitacional
            $sqlLibera = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = $seqFormulario";
            @mysql_query($sqlLibera);
        }

        // Para paso a Inscrito Inactivo
        if ($arrDatos['estado'] == 35) {
            //$claFormulario->txtFormulario = "";
            $claFormulario->fchPostulacion = "0000-00-00";
            $claFormulario->fchVigencia = "0000-00-00";
            //$claFormulario->seqPlanGobierno = 2;
            $claFormulario->seqModalidad = 0;
            $claFormulario->seqTipoEsquema = 1;
            $claFormulario->txtDireccionSolucion = "";
            $claFormulario->seqSolucion = 1; // 1 -Ninguno
            $claFormulario->seqProyecto = 37; // 37 - Ninguno
            $claFormulario->fchVigencia = "";
            $claFormulario->seqProyectoHijo = 0;
            $claFormulario->seqUnidadProyecto = 1;
            //$claFormulario->fchInscripcion = date( "Y-m-d H:i:s" );
            $claFormulario->bolCerrado = 0;
            // Libera Unidad Habitacional
            $sqlLibera = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = $seqFormulario";
            @mysql_query($sqlLibera);
        }

        // Para paso a Asignacion Revocado
        if ($arrDatos['estado'] == 21) {
            $claFormulario->txtDireccionSolucion = "";
            $claFormulario->seqUnidadProyecto = 1;
            $claFormulario->txtMatriculaInmobiliaria = "";
            $claFormulario->txtChip = "";
            $claFormulario->valAvaluo = 0;
            $claFormulario->valTotal = 0;
            // Libera Unidad Habitacional
            @$sqlLibera = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = $seqFormulario";
            mysql_query($sqlLibera);
        }

        // Para paso a Postulación Renuncia
        if ($arrDatos['estado'] == 14) {
            $claFormulario->txtDireccionSolucion = "";
            $claFormulario->seqUnidadProyecto = 1;
            $claFormulario->txtMatriculaInmobiliaria = "";
            $claFormulario->txtChip = "";
            $claFormulario->valAvaluo = 0;
            $claFormulario->valTotal = 0;
            $claFormulario->valSaldoCuentaAhorro = 0;
            $claFormulario->seqBancoCuentaAhorro = 1;
            $claFormulario->txtSoporteCuentaAhorro = "";
            $claFormulario->fchAperturaCuentaAhorro = "";
            $claFormulario->bolInmovilizadoCuentaAhorro = 0;
            $claFormulario->valSaldoCuentaAhorro2 = 0;
            $claFormulario->seqBancoCuentaAhorro2 = 1;
            $claFormulario->txtSoporteCuentaAhorro2 = "";
            $claFormulario->fchAperturaCuentaAhorro2 = "";
            $claFormulario->bolInmovilizadoCuentaAhorro2 = 0;
            //$claFormulario->valAspiraSubsidio = 0;
            $claFormulario->txtSoporteSubsidio = "";
            $claFormulario->valTotalRecursos = $claFormulario->valSubsidioNacional + $claFormulario->valAporteLote + $claFormulario->valSaldoCesantias + $claFormulario->valAporteAvanceObra + $claFormulario->valCredito + $claFormulario->valAporteMateriales + $claFormulario->valDonacion;
            // Libera Unidad Habitacional
            @$sqlLibera = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = $seqFormulario";
            mysql_query($sqlLibera);
        }

        // Para paso a asignación Renuncia
        if ($arrDatos['estado'] == 18) {
            $claFormulario->txtDireccionSolucion = "";
            $claFormulario->seqUnidadProyecto = 1;
            $claFormulario->txtMatriculaInmobiliaria = "";
            $claFormulario->txtChip = "";
            $claFormulario->valAvaluo = 0;
            $claFormulario->valTotal = 0;
            $claFormulario->valSaldoCuentaAhorro = 0;
            $claFormulario->seqBancoCuentaAhorro = 1;
            $claFormulario->txtSoporteCuentaAhorro = "";
            $claFormulario->fchAperturaCuentaAhorro = "";
            $claFormulario->bolInmovilizadoCuentaAhorro = 0;
            $claFormulario->valSaldoCuentaAhorro2 = 0;
            $claFormulario->seqBancoCuentaAhorro2 = 1;
            $claFormulario->txtSoporteCuentaAhorro2 = "";
            $claFormulario->fchAperturaCuentaAhorro2 = "";
            $claFormulario->bolInmovilizadoCuentaAhorro2 = 0;
            //$claFormulario->valAspiraSubsidio = 0;
            $claFormulario->txtSoporteSubsidio = "";
            $claFormulario->valTotalRecursos = $claFormulario->valSubsidioNacional + $claFormulario->valAporteLote + $claFormulario->valSaldoCesantias + $claFormulario->valAporteAvanceObra + $claFormulario->valCredito + $claFormulario->valAporteMateriales + $claFormulario->valDonacion;
            // Libera Unidad Habitacional
            @$sqlLibera = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = $seqFormulario";
            mysql_query($sqlLibera);
        }

        // Para paso a Inscrito Inactivo
        if ($arrDatos['estado'] == 39) {
            $claFormulario->bolCerrado = 1;
        }

        // para paso a hogar calificado (53) o postulado (54)
        if ($arrDatos['estado'] == 53 || $arrDatos['estado'] == 54) {
//            $claFormulario->seqTipoEsquema = "1";
        }

        $claFormulario->txtComentario = $arrDatos['comentario'];

        $arrFormularios[$seqFormulario] = $claFormulario;
    }
}

/**
 * PROCESAMIENTO
 */
$numModificados = 0;
$numErrores = 0;

$buscaCedulaFormat = str_replace(".", "", $_POST['buscaCedula']);

if (empty($arrErrores)) {

    foreach ($arrFormularios as $seqFormulario => $claFormulario) {

        $claFormularioActual = new FormularioSubsidios();
        $claFormularioActual->cargarFormulario($seqFormulario);

        if ($claFormularioActual->seqEstadoProceso == 1) {
            $claFormulario->fchInscripcion = $claFormularioActual->fchInscripcion;
        }

        $txtNombre = "";
        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
            if ($claCiudadano->numDocumento == $buscaCedulaFormat) {
                $txtNombre = $claCiudadano->txtNombre1 . " " . $claCiudadano->txtNombre2 .
                        $claCiudadano->txtApellido1 . " " . $claCiudadano->txtApellido2;
            }
        }
        
        
        // Para cambios especiales de Mejoramiento y Adquisicion
        if(isset($_POST['especial']) and $_POST['especial'] == "mejoramiento"){
        	$claFormulario->seqModalidad    = 9;  // Mejoramiento Habitacional
        	$claFormulario->seqSolucion     = 16; // 70 SMMLV
        	$claFormulario->seqTipoEsquema  = 4;  // Territorial Dirigido
        	$claFormulario->seqPlanGobierno = 2;  // Bogotá Humana
        	$claFormulario->seqProyecto     = 98; // TERRITORIAL DIRIGIDA - HABITACIONAL URBANO
        }elseif(isset($_POST['especial']) and $_POST['especial'] == "adquisicion"){
        	$claFormulario->seqModalidad    = 6;  // Adquisición de Vivienda Nueva
        	$claFormulario->seqSolucion     = 13; // 70 SMMLV
        	$claFormulario->seqTipoEsquema  = 1;  // Individual
        	$claFormulario->seqPlanGobierno = 2;  // Bogotá Humana
        	//$claFormulario->seqProyecto     = 32; // INDIVIDUAL PROYECTO SDVE
        }else{
            $claFormulario->seqPlanGobierno = 3;
        }

        $claFormulario->seqCesantias = ($claFormulario->seqCesantias == 0)? 1: $claFormulario->seqCesantias;
        $claFormulario->seqPeriodo   = ($claFormulario->seqPeriodo == 0)? 1: $claFormulario->seqPeriodo;

        $claFormulario->editarFormulario($seqFormulario);
        if (empty($claFormulario->arrErrores)) {

            $claSeguimiento = new Seguimiento();
            $txtCambios = $claSeguimiento->cambiosCambioEstados($seqFormulario, $claFormularioActual, $claFormulario);

            $sql = "
					INSERT INTO T_SEG_SEGUIMIENTO (
						seqFormulario, 
						fchMovimiento, 
						seqUsuario, 
						txtComentario, 
						txtCambios, 
						numDocumento, 
						txtNombre, 
						seqGestion
					) VALUES (
						$seqFormulario,
						'" . date("Y-m-d H:i:s") . "',
						" . $_SESSION['seqUsuario'] . ",
						\"Cambio desde el menu Formulario -> Cambio Estados:<br>" . $claFormulario->txtComentario . "\",
						\"" . ereg_replace("\"", "", $txtCambios) . "\",
						" . intval($buscaCedulaFormat) . ",
						\"$txtNombre\",
						" . $_POST['seqGestion'] . "
					)					
				";

            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido registrar el seguimiento del formulario";
            }

     
        } else {
            $numErrores++;
            $arrErrores[] = "No se pudo actualizar la informacion del formulario $seqFormulario ( " . $claFormulario->numDocumento . " )";
            $arrErrores[] = $claFormulario->arrErrores[1];
        }
    }
}

/**
 * DESPLIEGUE DE MENSAJES 
 */
$txtDivListener = "";
if (empty($arrErrores)) {
    $arrMensajes[] = "Registros Modificados $numModificados, Registros no modificados $numErrores";
    $txtDivListener = "salvarProyecto";
}

imprimirMensajes($arrErrores, $arrMensajes, $txtDivListener);
?>