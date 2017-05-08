<?php

/**
 * SEGUNDA VERSION DE SALVAR POSTULACION 
 * LA MODIFICACION CONSISTE EN EL REDISEÑO 
 * DEL SEGUIMIENTO Y ORGANIZACION DE VALIDACIONES
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CiudadanoBp.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidiosBp.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoBp.class.php" );

$arrErrores = array(); // Todos los errores van aqui

/**
 * LOS QUE TIENEN PERMISOS PARA MODIFICAR EN ESTA PANTALLA
 * Proyecto         = 3 --> Subsidio de vivienda
 * Grupo            = 6 --> Tutores de postulacion
 *   Grupo Proyecto = 7 --> Tutores de postulacion asignado a Subsidio de vivienda
 * 
 * FORMATO DEL ARREGLO
 * $arrGrupoPermitido[ proyecto ][ grupo ] = grupoProyecto
 * */
$arrGrupoPermitidos[3][6] = 7;

// proyecto actual
$seqProyecto = $_SESSION["seqProyecto"];

// verifica si el usuario pertenece 
// a alguno de los grupos autorizados
$bolGrupoPermitido = false;
foreach ($_SESSION["arrGrupos"][$seqProyecto] as $seqGrupo => $seqProyectoGrupo) {
    if (isset($arrGrupoPermitidos[$seqProyecto][$seqGrupo]) and ( $arrGrupoPermitidos[$seqProyecto][$seqGrupo] == $seqProyectoGrupo )) {
        $bolGrupoPermitido = true;
    }
}

if ($bolGrupoPermitido == false) {
    $arrErrores[] = "No tiene privilegios para salvar cambios";
} else {
    if ($_SESSION["privilegios"]["editar"] != 1) {
        $arrErrores[] = "No tiene privilegios para salvar cambios";
    }
}

/* * ********************************************************************************************************************
 * VALIDACIONES DEL FORMULARIO
 * ******************************************************************************************************************** */

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

// direccion de residencia
if ($_POST['txtDireccion'] == "") {
    $arrErrores[] = "Debe dar una direcci&oacute;n";
}

// numero de telefono
if ($_POST['numTelefono1'] == "" or $_POST['numTelefono1'] == 0) {
    $arrErrores[] = "El formulario debe tener por lo menos un tel&eacute;fono de contacto";
}

// SI LA VIVIENDA ES ARRENDADA
if ($_POST['seqVivienda'] == 1) {

    // NO PUEDE HABER UN VALOR DE ARRENDAMIENTO CERO
    if (intval($_POST['valArriendo']) == 0) {
        $arrErrores[] = "Debe indicar el valor del arrendamiento";
    }
} else { // para otros tipos de vivienda el valor del arriendo es cero
    $_POST['valArriendo'] = 0;
}

// fecha de la cuenta de ahorro si la tiene debe ser valida
if ($_POST['fchAperturaCuentaAhorro'] != "") {
    if (!esFechaValida($_POST['fchAperturaCuentaAhorro'])) {
        $arrErrores[] = "La fecha de apertura de la cuenta de ahorro no es v&aacute;lida, si no la tiene debe dejar el campo vac&iacute;o";
    }
}

// fecha de la cuenta de ahorro si la tiene debe ser valida
if ($_POST['fchAperturaCuentaAhorro2'] != "") {
    if (!esFechaValida($_POST['fchAperturaCuentaAhorro2'])) {
        $arrErrores[] = "La fecha de apertura de la segunda de ahorro no es v&aacute;lida, si no la tiene debe dejar el campo vac&iacute;o";
    }
}

// si tiene fecha de credito debe ser valida
if ($_POST['fchAprobacionCredito'] != "") {
    if (!esFechaValida($_POST['fchAprobacionCredito'])) {
        $arrErrores[] = "La fecha de aprobaci&oacute;n del cr&eacute;dito no es v&aacute;lida, si no la tiene debe dejar el campo vac&iacute;o";
    }
}

// validaciones para el tipo de solucion
if ($_POST['seqSolucion'] == 1) {
    $arrErrores[] = "Debe seleccionar el tipo de solucion";
} else {

    // Valores para la consulta del valor del subsidio
    $seqSolucion = $_POST['seqSolucion'];
    $seqModalidad = $_POST['seqModalidad'];

    // Si es desplazado - adquisicion de vivienda - tipo 2 o VIS
    // el valor del subsidio debe ser el maximo (como en tipo 1)
    // por eso se alteran los valores
    // no se altera el post para que se guarden los valores
    // de modalidad y solucion seleccionados por el usuario
    if ($_POST["bolDesplazado"] == 1 and $_POST["seqModalidad"] == 1 and $_POST["seqSolucion"] != 2) {
        $seqSolucion = 2;
        $seqModalidad = 1;
    }

    // Obtiene el valor del subsidio segun modalidad y tipo de solucion seleccionada	
    $valSubsidio = 0;
    $sql = "
			SELECT valSubsidio
			FROM T_FRM_VALOR_SUBSIDIO
			WHERE seqSolucion = " . $seqSolucion . "
			  AND seqModalidad = " . $seqModalidad . "
		";
    $objRes = $aptBd->execute($sql);
    if ($objRes->fields) {
        $valSubsidio = $objRes->fields['valSubsidio'];
    }

    // si el valor del subsidio es menor se debe colocar una justificacion
    if (( $_POST['valAspiraSubsidio'] < $valSubsidio ) and trim($_POST['txtSoporteSubsidio']) == "") {
        $arrErrores[] = "No puede cambiar el valor tope del subsidio sin dar un soporte para este cambio, diligencie el campo 'Soporte Cambio'";
    }

    // el valor del subsidio nunca puede ser mayor al establecido en la solucion
    if ($_POST['valAspiraSubsidio'] > $valSubsidio) {
        $arrErrores[] = "El valor del subsidio al que se aspira nunca puede superar el limite establecido";
    }
}

// para mejoramiento y construccion se debe seleccionar proyecto
if ($_POST['seqProyecto'] == 0 and $_POST['seqModalidad'] != 1 and $_POST['seqModalidad'] != 5) {
    $arrErrores[] = "Para esta modalidad la vivienda debe pertenecer a uno de los proyectos";
}

// si es independiente debe indicar ingresos
if ($_POST['bolDesplazado'] == 0) {
    if ($_POST['valIngresoHogar'] == 0) {
        $arrErrores[] = "El ingreso del hogar no puede sumar cero";
    }
}

// Validacion del cierre financiero
if ($_POST['bolDesplazado'] == 0) {
    if ($_POST['seqModalidad'] == 1 or $_POST['seqModalidad'] == 2) {
        $valCierre = valorCierreFinanciero($_POST['seqModalidad'], $_POST['seqModalidad']);
        if ($_POST['valTotalRecursos'] < $valCierre) {
            $arrNotificaciones[] = "Parece que no cuenta con los recursos suficientes para el cierre financiero";
        }
    }
}

// la fecha desde la que paga arriendo es solo para la modalidad de arrendamiento
if ($_POST['seqModalidad'] != 5 and $_POST['fchArriendoDesde'] != "") {
    $_POST['fchArriendoDesde'] = "";
}

// la localidad no puede ser desconocida
if ($_POST['seqLocalidad'] == 1) {
    $arrErrores[] = "Debe seleccionar una localidad diferente";
}

// cuando hay fecha debe haber comprobante de arriendo
if ((!esFechaValida($_POST['fchArriendoDesde']) ) and strtolower($_POST['txtComprobanteArriendo']) == "si") {
    $arrErrores[] = "Debe colocar la fecha desde la que se paga el arriendo";
}

// informacion que no es obligatoria
$_POST['bolCerrado'] = ( isset($_POST['bolCerrado']) and $_POST['bolCerrado'] == 1 ) ? 1 : 0;
$_POST['numTelefono2'] = ( $_POST['numTelefono2'] == "" ) ? 0 : $_POST['numTelefono2'];
$_POST['numCelular'] = ( $_POST['numCelular'] == "" ) ? 0 : $_POST['numCelular'];

// Carga el formulario anteior para validacion del tipo de documento
$seqFormulario = $_POST['seqFormularioEditar'];
$claFormularioAnterior = new FormularioSubsidios;
$claFormularioAnterior->cargarFormulario($seqFormulario);

// Si no hay fecha de postulacion toma la fecha de hoy
$numFechaHoy = time();
if ($claFormularioAnterior->fchPostulacion != "0000-00-00 00:00:00" and strtotime($claFormularioAnterior->fchPostulacion)) {
    $numFechaPostulacion = strtotime($claFormularioAnterior->fchPostulacion);
} else {
    $numFechaPostulacion = time();
}

// Si hay miembros de hogar
if (!empty($_POST['hogar'])) {

    $numCabezaFamilia = 0;
    $numCedula = 0;
    foreach ($_POST['hogar'] as $numDocumento => $arrCiudadano) {
        // el primer nombre no puede ser vacio
        if ($arrCiudadano['txtNombre1'] == "") {
            $arrErrores[] = "El ciudadano con numero de documento $numDocumento debe tener primer nombre";
        }

        // el primer apellido no debe estar vacio
        if ($arrCiudadano['txtApellido1'] == "") {
            $arrErrores[] = "El ciudadano con numero de documento $numDocumento debe tener primer apellido";
        }

        if ($arrCiudadano['seqEstadoCivil'] == 0) {
            $arrErrores[] = "El ciudadano con numero de documento $numDocumento debe tener un estado civil.";
        }

        // solo puede haber un postulante principal
        if ($arrCiudadano['seqParentesco'] == 1) {
            $numCabezaFamilia++; // si es postulante principal ( solo debe haber 1 )
        }

        // por lo menos debe haber una cedula de ciudadania
        if ($arrCiudadano['seqTipoDocumento'] == 1) {
            $numCedula++; // si es cedula de ciudadania ( por lo menos 1 colombiano mayor de edad )
        }

        if ($arrCiudadano['seqEstadoCivil'] == 1 or
                $arrCiudadano['seqEstadoCivil'] == 3 or
                $arrCiudadano['seqEstadoCivil'] == 4 or
                $arrCiudadano['seqEstadoCivil'] == 5) {
            $arrErrores[] = "No puede utilizar este estado civil para el ciudadano.";
        }

        // Si es mayor de edad compare contra la fecha de postulacion si debe tener cedula
        list( $ano, $mes, $dia ) = split("[-\/]", $arrCiudadano['fchNacimiento']);
        if (@checkdate($mes, $dia, $ano) === false) {
            $arrErrores[] = "La fecha de Nacimiento del ciudadano " .
                    $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                    $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                    " no es valida, verifique los datos";
        } else { // fecha de nacimiento valida
            // fechas para comparar mayor de edad y tercera edad
            $numMayorEdad = strtotime("-18 year", $numFechaHoy);
            $numTerceraEdad = strtotime("-65 year", $numFechaHoy);
            $numEdad = strtotime($arrCiudadano['fchNacimiento']);

            // tipos de documento invalidos para un mayor de edad
            $arrDocumentos[] = 6; // NIT
            $arrDocumentos[] = 4; // TARJETA DE IDENTIDAD	
            $arrDocumentos[] = 3; // REGISTRO CIVIL
            // tipos de documento invalidos para un menor de edad
            $arrDocumentosMayorEdad[] = 1; // Cedula Ciudadania
            $arrDocumentosMayorEdad[] = 2; // Cedula extranjeria
            $arrDocumentosMayorEdad[] = 6; // NIT

            $numCondicionEspecialMayor65 = 2;

            // se compara si es mayor de edad al momento de la postulacion
            if (( $numEdad <= $numMayorEdad ) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentos)) {
                $arrErrores[] = "Tipo de documento errado para " .
                        $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                        $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                        " porque segun su fecha de nacimiento es mayor de edad";
            }

            // se compara si es menor de 65 aNos y tenga condicion especial "Mayor 65 aNos"
            if (( $numEdad > $numTerceraEdad ) and ( $arrCiudadano["seqCondicionEspecial"] == $numCondicionEspecialMayor65 or
                    $arrCiudadano["seqCondicionEspecial2"] == $numCondicionEspecialMayor65 or
                    $arrCiudadano["seqCondicionEspecial3"] == $numCondicionEspecialMayor65 )) {
                $arrErrores[] = "Condicion especial errada para " .
                        $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                        $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                        " porque segun su fecha de nacimiento es menor de edad y se le esta asignando la condicion especial de Mayor de 65 Año";
            }

            // se compara si es menor de edad al momento de la postulacion
            if (( $numEdad > $numMayorEdad ) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentosMayorEdad)) {
                $arrErrores[] = "Tipo de documento errado para " .
                        $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                        $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                        " porque segun su fecha de nacimiento es menor de edad";
            }

            // se compara si es tercera edad al momento de la postulacion
            if (( $numEdad <= $numTerceraEdad ) and ( $arrCiudadano['seqCondicionEspecial'] != 2 and $arrCiudadano['seqCondicionEspecial2'] != 2 and $arrCiudadano['seqCondicionEspecial3'] != 2 )) {
                $arrErrores[] = "Debe tener condicion especial de Mayor de 65 Años para el ciudadano " .
                        $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                        $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'];
            }
        } // fin fecha nacimiento valida
    } // fin foreach si hay miembros de hogar
    // errores que se producen dentro del grupo familiar
    switch (true) {
        case $numCabezaFamilia == 0: $arrErrores[] = "Debe haber una cabeza de familia para el hogar";
            break;
        case $numCabezaFamilia > 1: $arrErrores[] = "Solo puede tener una cabeza de familia para este hogar";
            break;
        case $numCedula == 0: $arrErrores[] = "Debe haber por lo menos un mayor de edad colombiano dentro del nucleo familiar";
            break;
    }
} else { // no hay miembros de hogar
    $arrErrores[] = "Debe haber por lo menos una persona dentro del grupo familiar";
} // fin validacion si hay miembros del hogar
// Numero del formulario solo si esta en cosecha
if ($_POST['seqEstadoProceso'] == 7) {

    // debe terner numero de formulario si esta en cosecha
    if ($_POST['txtFormulario'] == "") {

        $arrErrores[] = "El numero del formulario no puede estar vacío";
    } else { // tiene numero de formulario
        // si no tiene numero de formulario se lo asigna
        if ($claFormularioAnterior->txtFormulario == "") {
            $txtFormato = "/^[0-9]{3}[-][0-9]{3,6}$/"; // dos digitos de tutor y seis de numero de formulario
            $txtFormulario = trim($_POST['txtFormulario']);
            if (preg_match($txtFormato, $txtFormulario)) {
                $arrFormulario = split("-", $txtFormulario);
                $numFormulario = intval($arrFormulario[1]);
                $numSiguiente = FormularioSubsidios::tutorSecuencia($txtFormulario);

                if ($numFormulario != $numSiguiente) {
                    $arrErrores[] = "El formulario $numFormulario no es el n&uacute;mero correcto de secuencia, el numero correcto es $numSiguiente";
                }
            } else {
                $arrErrores[] = "El numero del formulario no tiene el formato correcto";
            }
        } // si no tiene numero de formulario lo asigna
    } // fin si tiene numero de formulario 
} else {

    // en riego quita el numero del formulario
    if ($_POST['seqEstadoProceso'] == 6) {
        $_POST['txtFormulario'] = "";
    }
}

// si el formulario esta cerrado solo los que tienen privilegios de cambiar informacion pueden salvar
if ($claFormularioAnterior->bolCerrado == 1) {
    if ($_SESSION['privilegios']['cambiar'] != 1) {
        $arrErrores[] = "No tiene privilegios para editar postulaciones, el formulario esta cerrado";
    }
} else {
    if ($_SESSION['privilegios']['editar'] != 1) { // debe porder editar para que se puedan ver las postulaciones
        $arrErrores[] = "No tiene privilegios para editar postulaciones";
    }
}

/* * ********************************************************************************************************************
 * SALVAR LOS CAMBIOS
 * ******************************************************************************************************************** */
//	$arrErrores = array( );
if (empty($arrErrores)) {

    // Carga el formulario anteior para validacion del numero de formulario	
    $claFormularioCambios = new FormularioSubsidios;
    $claFormularioCambios->cargarFormulario($seqFormulario);

    $arrHogarAnterior = $claFormularioCambios->arrCiudadano;

    $arrHogar = array();
    foreach ($_POST['hogar'] as $numDocumento => $arrCiudadano) {

        $claCiudadano = new Ciudadano;
        $claCiudadano->txtNombre1 = $arrCiudadano['txtNombre1'];
        $claCiudadano->txtNombre2 = $arrCiudadano['txtNombre2'];
        $claCiudadano->txtApellido1 = $arrCiudadano['txtApellido1'];
        $claCiudadano->txtApellido2 = $arrCiudadano['txtApellido2'];
        $claCiudadano->fchNacimiento = $arrCiudadano['fchNacimiento'];
        $claCiudadano->seqTipoDocumento = $arrCiudadano['seqTipoDocumento'];
        $claCiudadano->numDocumento = $arrCiudadano['numDocumento'];
        $claCiudadano->valIngresos = $arrCiudadano['valIngresos'];
        $claCiudadano->seqCajaCompensacion = ( intval($arrCiudadano['seqCajaCompensacion']) != 0 ) ? $arrCiudadano['seqCajaCompensacion'] : 1;
        $claCiudadano->seqNivelEducativo = $arrCiudadano['seqNivelEducativo'];
        $claCiudadano->seqEtnia = $arrCiudadano['seqEtnia']; // Ninguna Etnia
        $claCiudadano->seqEstadoCivil = $arrCiudadano['seqEstadoCivil'];
        $claCiudadano->seqOcupacion = $arrCiudadano['seqOcupacion'];
        $claCiudadano->seqCondicionEspecial = $arrCiudadano['seqCondicionEspecial'];
        $claCiudadano->seqCondicionEspecial2 = $arrCiudadano['seqCondicionEspecial2'];
        $claCiudadano->seqCondicionEspecial3 = $arrCiudadano['seqCondicionEspecial3'];
        $claCiudadano->seqSexo = $arrCiudadano['seqSexo'];
        $claCiudadano->bolLgtb = $arrCiudadano['bolLgtb'];
        $claCiudadano->bolBeneficiario = intval($arrCiudadano['bolBeneficiario']);
        $claCiudadano->seqSalud = $arrCiudadano['seqSalud'];
        $claCiudadano->seqParentesco = $arrCiudadano['seqParentesco'];
        $claCiudadano->bolCertificadoElectoral = ( $arrCiudadano['bolCertificadoElectoral'] == "" ) ? 0 : $arrCiudadano['bolCertificadoElectoral'];

        if ($claCiudadano->seqParentesco == 1) {
            $numCedulaPrincipal = $claCiudadano->numDocumento;
        }

        $seqCiudadano = $claCiudadano->ciudadanoExiste($arrCiudadano['seqTipoDocumento'], $numDocumento);
        $claFormularioAnterior->arrCiudadano[$seqCiudadano]->seqParentesco = $arrCiudadano['seqParentesco'];
        if (isset($claFormularioAnterior->arrCiudadano[$seqCiudadano])) {
            unset($claFormularioAnterior->arrCiudadano[$seqCiudadano]);
        }

        if ($seqCiudadano == 0) {
            $seqCiudadano = $claCiudadano->guardarCiudadano();
        } else {

            // formulario del ciudadano para saber si existe 
            // y si existe ademas debe ser del msmo formulario
            // porque si lo estan tratando de meter en otro
            // de todas maneras actualiza la info del primero
            $sql = " 
					SELECT 
						frm.seqFormulario, 
						frm.txtFormulario
					FROM 
						T_FRM_HOGAR hog, 
						T_FRM_FORMULARIO frm
					WHERE hog.seqCiudadano = $seqCiudadano
					  AND hog.seqFormulario = frm.seqFormulario
					GROUP BY 
						frm.seqFormulario, 
						frm.txtFormulario
				";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqFormularioCiudadano = $objRes->fields['seqFormulario'];
            }

            if ($seqFormularioCiudadano == $_POST['seqFormularioEditar']) {
                $claCiudadano->editarCiudadano($seqCiudadano);
            } else {
                $objCiudadanoExiste = new Ciudadano;
                $objCiudadanoExiste->cargarCiudadano($seqCiudadano);
                $txtNombre = strtolower(ucwords($objCiudadanoExiste->txtNombre1 . " " . $objCiudadanoExiste->txtNombre2 . " " . $objCiudadanoExiste->txtApellido1 . " " . $objCiudadanoExiste->txtApellido2));
                $arrErrores[] = "El ciudadano [ " . number_format($numDocumento, 0, ",", ".") . " ] $txtNombre esta vinculado a otro hogar, verifique el formulario " . $objRes->fields['txtFormulario'];
                $claCiudadano->arrErrores = $arrErrores;
            }
        }

        if (empty($claCiudadano->arrErrores)) {
            $arrHogarNuevo[$seqCiudadano] = $claCiudadano;
            if (isset($claFormularioAnterior->arrCiudadano[$seqCiudadano])) {
                $arrHogar[$seqCiudadano] = $claFormularioAnterior->arrCiudadano[$seqCiudadano];
                unset($claFormularioAnterior->arrCiudadano[$seqCiudadano]);
            } else {
                $arrHogar[$seqCiudadano] = $claCiudadano;
            }
        }
    } // fin foreach hogar
    // si no hay errores salva los datos del formulario
    if (empty($claCiudadano->arrErrores)) {

        $claFormulario = new FormularioSubsidios;

        // obtiene las fechas de inscripcion, postulacion y ultima de actualizacion
        $arrFechas = $claFormulario->obtenerFechas($seqFormulario);

        // si es riego pierde el numero de formulario, el estado cerrado y la fecha de postualcion
        if ($_POST['seqEstadoProceso'] == 6) {
            $_POST['bolCerrado'] = 0;
            $arrFechas['fchPostulacion'] = "";
            $_POST['txtFormulario'] = "";
        } else {

            // primera vez que lo cierra
            if (intval($claFormularioAnterior->bolCerrado) == 0 and $_POST['bolCerrado'] == 1) {

                // no pueden haber fechas anteriores 
                //		0001-01-01 lo recnoce como fecha valida
                //		0000-00-00 lo recnoce como fecha valida
                $numTimeMinimo = strtotime("2000-01-01 00:00:00");
                if (strtotime($claFormularioAnterior->fchPostulacion) < $numTimeMinimo) {
                    $claFormularioAnterior->fchPostulacion = "";
                }

                // si abre el frm en cosecha respeta la fecha de postulacion
                if (strtotime($claFormularioAnterior->fchPostulacion)) {
                    $arrFechas['fchPostulacion'] = $claFormularioAnterior->fchPostulacion;
                } else {
                    $arrFechas['fchPostulacion'] = date("Y-m-d H:i:s");
                }
            }
        } // si es para riego o cosecha

        $claFormulario->arrCiudadano = $arrHogar;
        $claFormulario->bolCerrado = $_POST['bolCerrado'];
        $claFormulario->bolDesplazado = $_POST['bolDesplazado'];
        $claFormulario->bolIdentificada = $_POST['bolIdentificada'];
        $claFormulario->bolInmovilizadoCuentaAhorro = ( $_POST['bolInmovilizadoCuentaAhorro'] != 1 ) ? 0 : 1;
        $claFormulario->bolInmovilizadoCuentaAhorro2 = ( $_POST['bolInmovilizadoCuentaAhorro2'] != 1 ) ? 0 : 1;
        $claFormulario->bolIntegracionSocial = $_POST['bolIntegracionSocial'];
        $claFormulario->bolIpes = $_POST['bolIpes'];
        $claFormulario->bolPromesaFirmada = $_POST['bolPromesaFirmada'];
        $claFormulario->bolSecEducacion = $_POST['bolSecEducacion'];
        $claFormulario->bolSecSalud = $_POST['bolSecSalud'];
        $claFormulario->bolViabilizada = $_POST['bolViabilizada'];
        $claFormulario->fchArriendoDesde = $_POST['fchArriendoDesde'];
        $claFormulario->fchAperturaCuentaAhorro = $_POST['fchAperturaCuentaAhorro'];
        $claFormulario->fchAperturaCuentaAhorro2 = $_POST['fchAperturaCuentaAhorro2'];
        $claFormulario->fchAprobacionCredito = $_POST['fchAprobacionCredito'];
        $claFormulario->fchInscripcion = $arrFechas['fchInscripcion'];
        $claFormulario->fchNotificacion = $arrFechas['fchNotificacion'];
        $claFormulario->fchPostulacion = $arrFechas['fchPostulacion'];
        $claFormulario->fchUltimaActualizacion = date("Y-m-d H:i:s");
        $claFormulario->fchVencimiento = null;
        $claFormulario->numAdultosNucleo = $_POST['numAdultosNucleo'];
        $claFormulario->numCelular = $_POST['numCelular'];
        $claFormulario->numCortes = 0; // MAS ADELANTE EN ESTE MISMO CODIGO SE COLOCA ESTA FECHA
        $claFormulario->numNinosNucleo = $_POST['numNinosNucleo'];
        $claFormulario->numTelefono1 = $_POST['numTelefono1'];
        $claFormulario->numTelefono2 = $_POST['numTelefono2'];
        $claFormulario->seqBancoCredito = $_POST['seqBancoCredito'];
        $claFormulario->seqBancoCuentaAhorro = $_POST['seqBancoCuentaAhorro'];
        $claFormulario->seqBancoCuentaAhorro2 = $_POST['seqBancoCuentaAhorro2'];
        $claFormulario->seqCesantias = 1;
        $claFormulario->seqEmpresaDonante = $_POST['seqEmpresaDonante'];
        $claFormulario->seqEstadoProceso = $_POST['seqEstadoProceso'];
        $claFormulario->seqLocalidad = $_POST['seqLocalidad'];
        $claFormulario->seqModalidad = $_POST['seqModalidad'];
        $claFormulario->seqProyecto = ( $_POST['seqProyecto'] == 0 ) ? "null" : $_POST['seqProyecto'];
        $claFormulario->seqPuntoAtencion = $_SESSION['seqPuntoAtencion'];
        $claFormulario->seqSisben = $_POST['seqSisben'];
        $claFormulario->seqSolucion = $_POST['seqSolucion'];
        $claFormulario->seqUsuario = $_SESSION['seqUsuario'];
        $claFormulario->seqVivienda = $_POST['seqVivienda'];
        $claFormulario->txtBarrio = $_POST['txtBarrio'];
        $claFormulario->txtChip = strtoupper($_POST['txtChip']);
        $claFormulario->txtComprobanteArriendo = $_POST['txtComprobanteArriendo'];
        $claFormulario->txtCorreo = $_POST['txtCorreo'];
        $claFormulario->txtDireccion = $_POST['txtDireccion'];
        $claFormulario->txtDireccionSolucion = $_POST['txtDireccionSolucion'];
        $claFormulario->txtFormulario = $_POST['txtFormulario'];
        $claFormulario->txtMatriculaInmobiliaria = strtoupper($_POST['txtMatriculaInmobiliaria']);
        $claFormulario->txtOtro = $_POST['txtOtro'];
        $claFormulario->txtSoporteAporteLote = $_POST['txtSoporteLote'];
        $claFormulario->txtSoporteAporteMateriales = $_POST['txtSoporteAporteMateriales'];
        $claFormulario->txtSoporteAvanceObra = $_POST['txtSoporteAvanceObra'];
        $claFormulario->txtSoporteCesantias = $_POST['txtSoporteCesantias'];
        $claFormulario->txtSoporteCredito = $_POST['txtSoporteCredito'];
        $claFormulario->txtSoporteCuentaAhorro = $_POST['txtSoporteCuentaAhorro'];
        $claFormulario->txtSoporteCuentaAhorro2 = $_POST['txtSoporteCuentaAhorro2'];
        $claFormulario->txtSoporteDonacion = $_POST['txtSoporteDonacion'];
        $claFormulario->txtSoporteSubsidio = $_POST['txtSoporteSubsidio']; // Razon por la que se cambia el valor del subsidio
        $claFormulario->txtSoporteSubsidioNacional = $_POST['txtSoporteSubsidioNacional']; // Carta que soporta el hecho de ser desplazado
        $claFormulario->valAporteAvanceObra = $_POST['valAporteAvanceObra'];
        $claFormulario->valAporteLote = $_POST['valAporteLote'];
        $claFormulario->valAporteMateriales = $_POST['valAporteMateriales'];
        $claFormulario->valArriendo = $_POST['valArriendo'];
        $claFormulario->valAspiraSubsidio = $_POST['valAspiraSubsidio'];
        $claFormulario->valAvaluo = $_POST['valAvaluo'];
        $claFormulario->valCredito = $_POST['valCredito'];
        $claFormulario->valDonacion = $_POST['valDonacion'];
        $claFormulario->valIngresoHogar = $_POST['valIngresoHogar'];
        $claFormulario->valPresupuesto = $_POST['valPresupuesto'];
        $claFormulario->valSaldoCesantias = $_POST['valSaldoCesantias'];
        $claFormulario->valSaldoCuentaAhorro = $_POST['valSaldoCuentaAhorro'];
        $claFormulario->valSaldoCuentaAhorro2 = $_POST['valSaldoCuentaAhorro2'];
        $claFormulario->valSubsidioNacional = $_POST['valSubsidioNacional'];
        $claFormulario->valTotal = $_POST['valTotal'];
        $claFormulario->valTotalRecursos = $_POST['valTotalRecursos'];

        $claFormulario->editarFormulario($seqFormulario);

        if (empty($claFormulario->arrErrores)) {

            $sql = "
					DELETE
					FROM T_FRM_HOGAR
					WHERE seqFormulario = $seqFormulario
				";
            $aptBd->execute($sql);

            // Salvando el hogar
            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {

                $sql = "
						INSERT INTO T_FRM_HOGAR (
						  seqCiudadano,
						  seqFormulario,
						  bolSoporteDocumento,
						  seqParentesco
						) VALUES (
						  $seqCiudadano,
						  $seqFormulario,
						  0,
						  " . $objCiudadano->seqParentesco . "
						)
					";
                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido salvar los datos del hogar";
                }
            }

            // Si se eliminaron miembros de ahogar hay que eliminarlos del sistema
            foreach ($claFormularioAnterior->arrCiudadano as $seqCiudadano => $arrInfo) {
                $sql = "
						DELETE 
						FROM T_CIU_CIUDADANO
						WHERE seqCiudadano = $seqCiudadano
					";
                $aptBd->execute($sql);
            }
        } else {
            $arrErrores = $claFormulario->arrErrores;
        }
    } else {
        $arrErrores = $claCiudadano->arrErrores;
    }


    /*     * *********************************************************************************************************************
     * CALCULO DE LOS CAMBIOS DEL FORMULARIO
     * ******************************************************************************************************************** */

    $claFormularioCambios->arrCiudadano = $arrHogarAnterior;
    $claFormulario->arrCiudadano = $arrHogarNuevo;

    $claSeguimiento = new Seguimiento;
    $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormularioEditar'], $claFormularioCambios, $claFormulario);

    $_POST['seqGestion'] = ( $_POST['seqGestion'] == "" ) ? 17 : $_POST['seqGestion'];

    $numDocumentoFormat = str_replace(".", "", $_POST['numDocumentoAtendido']);

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
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"" . ereg_replace("\n", "", $_POST['txtComentario']) . "\",
				\"" . ereg_replace("\"", "", $txtCambios) . "\",
				" . $numDocumentoFormat . ",
				\"" . $_POST['txtCiudadanoAtendido'] . "\",
				" . $_POST['seqGestion'] . "
			)					
		";

    try {
        $aptBd->execute($sql);
        $seqSeguimiento = $aptBd->Insert_ID();
    } catch (Exception $objError) {
        $arrErrores[] = "El formulario se ha salvado pero no ha quedado registro de la actividad";
    }
} // fin if errores vacios	

/* * *********************************************************************************************************************
 * IMPRESION DE LOS MENSAJES
 * ******************************************************************************************************************** */

if (empty($arrErrores)) {
    $arrMensajes[] = "El formulario se ha salvado, Cedula [ " . $numCedulaPrincipal . " ].<br>" .
            "El numero de registro es " . number_format($seqSeguimiento, 0, ".", ",") . ". Conserve este numero para referencia futura";


    $txtEstilo = "msgOk";
} else {
    $arrMensajes = $arrErrores;
    $txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";

if (!empty($arrNotificaciones)) {
    foreach ($arrNotificaciones as $txtMensaje) {
        echo "<tr><td class='msgAlerta'><li>$txtMensaje</li></td></tr>";
    }
}

foreach ($arrMensajes as $txtMensaje) {
    echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
}
echo "</table>";
?>
