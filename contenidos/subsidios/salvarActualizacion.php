<?php
/**
 * PRIMERA VERSION DE SALVAR ACTUALIZACION 
 *
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$arrErrores = array();
$arrMensajes = array();
$numFechaHoy = time();
$numMayorEdad = strtotime("-18 year", $numFechaHoy); // Timestamp de nacimiento de mayor de edad
$numTerceraEdad = strtotime("-65 year", $numFechaHoy); // Timestamp de nacimiento de terera edad

// tipos de documento invalidos para un mayor de edad
$arrDocumentos[] = 3; // REGISTRO CIVIL
$arrDocumentos[] = 4; // TARJETA DE IDENTIDAD
$arrDocumentos[] = 6; // NIT
$arrDocumentos[] = 7; // NUIP

// tipos de documento invalidos para un menor de edad
$arrDocumentosMayorEdad[] = 1; // Cedula Ciudadania
$arrDocumentosMayorEdad[] = 2; // Cedula extranjeria
$arrDocumentosMayorEdad[] = 6; // NIT

$arrEstadosCiviles = obtenerDatosTabla("t_ciu_estado_civil", array("seqEstadoCivil", "txtEstadoCivil"), "seqEstadoCivil", "bolActivo = 1");
$arrParentescos = obtenerDatosTabla("t_ciu_parentesco", array("seqParentesco", "txtParentesco"), "seqParentesco", "bolActivo = 1");
$arrSisben = obtenerDatosTabla("t_frm_sisben", array("seqSisben", "txtSisben"), "seqSisben", $txtCondicion);
$arrModalidad = obtenerDatosTabla("t_frm_modalidad", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = 3");

/**********************************************************************************************************************
 * LIMPIEZA DE CARACTERES
 **********************************************************************************************************************/

foreach ($_POST['hogar'] as $txtClave => $txtValor){
    $_POST['hogar'][$txtClave] = regularizarCampo($txtClave,$txtValor);
}
foreach ($_POST as $txtClave => $txtValor){
    if($txtClave != "hogar") {
        $_POST[$txtClave] = regularizarCampo($txtClave, $txtValor);
    }
}

/* * ****************************************************************************************************
 * VALIDACIONES GENERALES
 * **************************************************************************************************** */

// Informacion actual del formulario
$claCiudadano = new Ciudadano();
$claFormulario = new FormularioSubsidios();
$claFormulario->cargarFormulario($_POST['seqFormulario']);
//$victima = '';

// Solo grupo informadores puede modificar datos
$seqProyecto = $_SESSION['seqProyecto'];
if (!isset($_SESSION['arrGrupos'][$seqProyecto][5])) {
    $arrErrores[] = "No tiene privilegios para modificar la información";
}

// si el formulario esta cerrado solo los que tienen privilegios de cambiar informacion pueden salvar
if ($claFormulario->bolCerrado == 1) {
    if ($_SESSION['privilegios']['cambiar'] != 1) {
        $arrErrores[] = "No tiene privilegios para modificar formularios cerrados";
    }
} else {
    if ($_SESSION['privilegios']['editar'] != 1) {
        $arrErrores[] = "No tiene privilegios para modificar los datos delformulario";
    }
    if ($_POST['seqEstadoProceso'] == 52) {
        $arrErrores[] = "El hogar está inhabilitado, no puede actualizar los datos";
    }
}

// si el formulario tiene sancion no se puede modificar
if ($claFormulario->bolSancion == 1) {
    $arrErrores[] = "No puede modificar formularios de hogares que se encuentran sancionados";
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

// si no hay erroes continua
if (empty($arrErrores)) {

    /******************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE COMPOSICION FAMILIAR
     ******************************************************************************************************/

    if (!empty($_POST['hogar'])) {

        $numCabezaFamilia = 0;
        $numCondicionJefeHogar = 0;
        $numCondicionJefeHogarSinIngreso = 0;
        $numCuentaUnionMarital = 0;
        $numCuentaCasado = 0;
        $numCedula = 0;
        $numVictimas = 0;

        foreach ($_POST['hogar'] as $numDocumento => $arrCiudadano) {

            // nombre del ciudadano
            $txtNombre  = trim($arrCiudadano['txtNombre1'] ) . " ";
            $txtNombre .= (trim($arrCiudadano['txtNombre2']) != "") ? trim($arrCiudadano['txtNombre2']) . " " : "";
            $txtNombre .= trim($arrCiudadano['txtApellido1'] ) . " " . trim( $arrCiudadano['txtApellido2'] );

            // el primer nombre no puede ser vacio
            if ($arrCiudadano['txtNombre1'] == "") {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener primer nombre";
            }

            // el primer apellido no debe estar vacio
            if ($arrCiudadano['txtApellido1'] == "") {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener primer apellido";
            }

            // Estado Civil
            if ($arrCiudadano['seqEstadoCivil'] == 0) {
                $arrErrores[] = "El ciudadano con el numero de documento " . number_format($numDocumento) . " debe tener un estado civil.";
            } else{
                $seqEstadoCivil = $arrCiudadano['seqEstadoCivil'];
                if( ! isset( $arrEstadosCiviles[$seqEstadoCivil] ) ) {
                    $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " no tiene un estado civil válido";
                }
            }

            // Nivel Educativo
            if( intval( $arrCiudadano['seqNivelEducativo'] ) == 0 ){
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " no tiene nivel educativo valido";
            }

            // Años aprobados
            if ($_POST['valIngresoHogar'] > 0 && $arrCiudadano['seqNivelEducativo'] != 1 && $arrCiudadano['numAnosAprobados'] == 0) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener años aprobados";
            }

            // Afiliacion a salud
            if ($arrCiudadano['seqSalud'] == 0) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener afiliación a saludo válida";
            }

            // Parentesco
            if ($arrCiudadano['seqParentesco'] == 0) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener parentesco";
            } elseif ($arrCiudadano['seqParentesco'] == 1) {
                $numCabezaFamilia++; // si es Jefe de Hogar ( solo debe existir un miembro con parentesco 1 )
                if ($arrCiudadano['seqTipoDocumento'] != 1 and $arrCiudadano['seqTipoDocumento'] != 2) {
                    $arrErrores[] = "El tipo de documento seleccionado para el postulante principal no es válido";
                }
            } else {
                $seqParentesco = $arrCiudadano['seqParentesco'];
                if (!isset($arrParentescos[$seqParentesco])) {
                    $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener parentesco válido";
                }
            }

            // Solo puede haber una persona con condicion Especial Jefe de Hogar
            if (( $arrCiudadano['seqCondicionEspecial'] == 1 ) || ( $arrCiudadano['seqCondicionEspecial2'] == 1 ) || ( $arrCiudadano['seqCondicionEspecial3'] == 1 )) {
                if ($arrCiudadano['valIngresos'] > 0) {
                    $numCondicionJefeHogar++; // Cuenta los miembros del hogar que cuentan con la condición 'Madre / Padre cabeza de Familia'
                } else {
                    $numCondicionJefeHogarSinIngreso++; // Cuenta los miembros del hogar que cuentan con la condición 'Madre / Padre cabeza de Familia' sin Ingreso
                }
            }

            // Debe haber minimo dos personas con estado civil casado
            if ($arrCiudadano['seqEstadoCivil'] == 6) {
                $numCuentaCasado ++;
            }


            // Debe haber minimo dos personas con estado civil union marital
            if ($arrCiudadano['seqEstadoCivil'] == 7) {
                $numCuentaUnionMarital ++;
            }

            // por lo menos debe haber una cedula de ciudadania
            if ($arrCiudadano['seqTipoDocumento'] == 1) {
                $numCedula++; // si es cedula de ciudadania ( por lo menos 1 colombiano mayor de edad )
            }

            // fecha de nacimiento
            if (!esFechaValida($arrCiudadano['fchNacimiento'])) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener una fecha de nacimiento.";
            } else {

                // Si es mayor de edad compare contra la fecha de postulacion si debe tener cedula
                if (!esFechaValida($arrCiudadano['fchNacimiento'])) {
                    $arrErrores[] = "La fecha de Nacimiento del ciudadano " . number_format($numDocumento) . " no es valida, verifique los datos";
                } else {

                    // fechas para comparar mayor de edad y tercera edad
                    $numEdad = strtotime($arrCiudadano['fchNacimiento']);

                    // se compara si es mayor de edad al momento de la postulacion
                    if (($numEdad <= $numMayorEdad) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentos)) {
                        $arrErrores[] = "Tipo de documento errado para " . number_format($numDocumento) . " porque segun su fecha de nacimiento es mayor de edad";
                    }

                    // se compara si es menor de 65 aNos y tenga condicion especial "Mayor 65 aNos"
                    if (($numEdad > $numTerceraEdad) and ($arrCiudadano["seqCondicionEspecial"] == $numCondicionEspecialMayor65 or
                            $arrCiudadano["seqCondicionEspecial2"] == $numCondicionEspecialMayor65 or
                            $arrCiudadano["seqCondicionEspecial3"] == $numCondicionEspecialMayor65)
                    ) {
                        $arrErrores[] = "Condicion especial errada para " . number_format($numDocumento) . " porque segun su fecha de nacimiento es menor de edad y se le esta asignando la condicion especial de Mayor de 65 Año";
                    }

                    // se compara si es menor de edad al momento de la postulacion
                    if (($numEdad > $numMayorEdad) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentosMayorEdad)) {
                        $arrErrores[] = "Tipo de documento errado para " . number_format($numDocumento) . " porque segun su fecha de nacimiento es menor de edad";
                    }

                    // se compara si es tercera edad al momento de la postulacion
                    if (($numEdad <= $numTerceraEdad) and ($arrCiudadano['seqCondicionEspecial'] != 2 and $arrCiudadano['seqCondicionEspecial2'] != 2 and $arrCiudadano['seqCondicionEspecial3'] != 2)) {
                        $arrErrores[] = "Debe tener condicion especial de Mayor de 65 Años para el ciudadano " . number_format($numDocumento);
                    }

                } // fin fecha nacimiento valida

                // si es por desplazamiento forzado suma
                if( $arrCiudadano['seqTipoVictima'] == 2){
                    $numVictimas++;
                }

                // Averigua si la cedula que se esta procesando pertenece a otro formulario
                // si es asi, obtiene la cedula del postulante principal de aquel formulario y emite el error
                $seqFormulario = $claCiudadano->formularioVinculado2($numDocumento, $arrCiudadano['seqTipoDocumento'], false, false);
                if( $seqFormulario != 0 and $_POST['seqFormulario'] != $seqFormulario ){
                    $sql = "
                        SELECT numDocumento
                        FROM T_FRM_HOGAR hog INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                        WHERE hog.seqFormulario = " . $seqFormulario . "
                        AND hog.seqParentesco = 1
                    ";
                    $objRes = $aptBd->execute($sql);
                    $numPPalExterno = 0;
                    if ($objRes->fields) {
                        $numPPalExterno = $objRes->fields['numDocumento'];
                    }
                    $arrErrores[] = "El ciudadano " . number_format($numDocumento) . " está vinculado al hogar de " . number_format($numPPalExterno) . ", no puede adicionarlo a este nucleo familiar ";
                }
            }

            // si es por desplazamiento forzado suma
            if( $arrCiudadano['seqTipoVictima'] == 2){
                $numVictimas++;
            }

        } // validaciones para cada miembro de hogar

        // errores que se producen dentro del grupo familiar
        switch (true) {
            case $numCabezaFamilia == 0:
                $arrErrores[] = "Debe haber un postulante principal para el hogar";
                break;
            case $numCabezaFamilia > 1:
                $arrErrores[] = "Solo puede tener un postulante principal para este hogar";
                break;
            case $numCondicionJefeHogar > 1:
                $arrErrores[] = "Solo puede haber un miembro de hogar con la condición especial de \"Madre / Padre cabeza de Familia\"";
                break;
            case $numCondicionJefeHogarSinIngreso > 0:
                $arrErrores[] = "La persona con la condición especial 'Madre / Padre cabeza de Familia' debe tener ingresos";
                break;
            case $numCedula == 0:
                $arrErrores[] = "Debe haber por lo menos un mayor de edad colombiano dentro del nucleo familiar";
                break;
            case $numCuentaCasado % 2 != 0:
                $arrErrores[] = "Verificar estado civil, debe existir otra persona con estado civil 'Casado' en el hogar";
                break;
            case $numCuentaUnionMarital % 2 != 0:
                $arrErrores[] = "Verificar estado civil, debe existir otra persona con estado civil 'Unión Marital' en el hogar";
                break;
            case $numVictimas == 0 and $_POST['bolDesplazado'] == 1:
                $arrErrores[] = "No hay victimas que acrediten la condicion de desplazado de este hogar";
                break;
            case $numVictimas > 0 and $_POST['bolDesplazado'] == 0:
                $arrErrores[] = "Hay desplazamiento forzado en el hogar, debe acreditar la condicion de victima";
                break;
        }

        // si es vulnerable debe indicar ingresos
//        if (intval($_POST['bolDesplazado']) == 0) {
//            if (intval($_POST['valIngresoHogar']) == 0) {
//                $arrErrores[] = "El ingreso del hogar no puede sumar cero";
//            }
//        }

    } else {
        $arrErrores[] = "Debe haber por lo menos una persona dentro del grupo familiar";
    } // si hay miembros de hogar

    /******************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE DATOS DEL HOGAR
     ******************************************************************************************************/

    // Vive en arriendo, entonces tiene que tener los datos necesarios
    if (intval($_POST['seqVivienda']) == 1) {
        if (intval($_POST['valArriendo']) == 0) {
            $arrErrores[] = "Indique el valor del arrendamiento que esta pagando";
        }
        if (!esFechaValida($_POST['fchArriendoDesde'])) {
            $arrErrores[] = "Indique una fecha v&aacute;lida para la fecha de inicio del pago de arriendo";
        }
        if (trim($_POST['txtComprobanteArriendo']) == "") {
            $arrErrores[] = "Indique si tiene o no comoprobantes de arriendo";
        }
    }

    // direccion de residencia
    if ($_POST['txtDireccion'] == "") {
        $arrErrores[] = "Debe dar una direcci&oacute;n";
    }

    // ciudad y validaciones relacionadas
    if (intval($_POST['seqCiudad']) == 0) {
        $arrErrores[] = "Indique la ciudad de residencia";
    } elseif (intval($_POST['seqCiudad']) == 149) { // vive en bogota
        if (intval($_POST['seqLocalidad']) == 0) {
            $arrErrores[] = "Debe seleccionar una localidad";
        }
        if (intval($_POST['seqBarrio']) == 0) {
            $arrErrores[] = "Debe seleccionar un barrio perteneciente a la localidad";
        }
    } else { // fuera de bogota
        if (intval($_POST['seqLocalidad']) == 0) {
            $arrErrores[] = "Debe seleccionar la localidad 'Fuera de Bogota'";
        }
        if (intval($_POST['seqBarrio']) != 1142) {
            $arrErrores[] = "Debe seleccionar el barrio 'Fuera de Bogota'";
        }
    }

    // Sisben
    $seqSisben = intval($_POST['seqSisben']);
    if (!isset($arrSisben[$seqSisben])) {
        $arrErrores[] = "Indique un nivel del sisben válido";
    }

    // Formatos de expresion regular para telefonos fijos y celular
    $txtFormatoFijo = "/^[0-9]{7}$/";
    $txtFormatoCelular = "/^[3]{1}[0-9]{9}$/";

    // Telefono Fijo 1
    if (is_numeric($_POST['numTelefono1']) == true and intval($_POST['numTelefono1']) != 0) {
        if (!preg_match($txtFormatoFijo, trim($_POST['numTelefono1']))) {
            $arrErrores[] = "El número telefonico fijo 1 debe tener entre 7 y 10 digitos";
        }
    }

    // Telefono Celular
    if (is_numeric($_POST['numCelular']) == true and intval($_POST['numCelular']) != 0) {
        if (!preg_match($txtFormatoCelular, trim($_POST['numCelular']))) {
            $arrErrores[] = "El número telefonico celular debe tener 10 digitos y debe iniciar con el número 3";
        }
    }

    // Debe haber telefono fijo o numero celular
    if (intval($_POST['numCelular']) == 0 and intval($_POST['numTelefono1']) == 0) {
        $arrErrores[] = "Debe registrar un telefono fijo o celular de contacto";
    }

    // Si hay correo electronico debe ser valido
    if (trim($_POST['txtCorreo']) != "") {
        if (!mb_ereg("^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$", trim($_POST['txtCorreo']))) {
            $arrErrores[] = "No es un correo electrónico válido";
        }
    }

    // Hogares que viven en la misma vivienda
    if (intval($_POST['numHabitaciones']) == 0) {
        $arrErrores[] = "Indique el numero de hogares que habitan la vivienda";
    }

    // Cantidad de dormitorios (pueden ser cero - dormitorio 'cambuche')
//    if (intval($_POST['numHacinamiento']) == 0) {
//        $arrErrores[] = "Indique el numero de dormitorios que usa el hogar";
//    }

    /******************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE DATOS DE LA POSTULACION
     * **************************************************************************************************** */

    // modalidad
    if (!isset($arrModalidad[$_POST['seqModalidad']])) {
        $arrErrores[] = "La modalidad seleccionada no es válida";
    }

    // tipo esquema
    if ( $_POST['seqTipoEsquema'] == 0 ){
        $arrErrores[] = "Seleccione el tipo de esquema";
    }

    // solucion
    if ($_POST['seqSolucion'] == 1) {
        $arrErrores[] = "Debe seleccionar el tipo de solucion";
    }

    /******************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE INFORMACION FINANCIERA
     ***************************************************************************************************** */

    // Validaciones para el ahorro
    if (intval($_POST['valSaldoCuentaAhorro']) != 0) {
        if (intval($_POST['seqBancoCuentaAhorro']) == 1) {
            $arrErrores[] = "Indique el banco de la cuenta de ahorro";
        }
        if (trim($_POST['txtSoporteCuentaAhorro']) == "") {
            $arrErrores[] = "Indique el soporte para la cuenta de ahorro";
        }
        if (!esFechaValida($_POST['fchAperturaCuentaAhorro'])) {
            $arrErrores[] = "Indique la fecha de apertura de la cuenta de ahorro";
        }
    }else{
        if (($_POST['seqBancoCuentaAhorro'] != 1 ) || ( $_POST['txtSoporteCuentaAhorro'] != "" ) || ( $_POST['fchAperturaCuentaAhorro'] != "" )) {
            if ((intval($_POST['valSaldoCuentaAhorro']) == 0 ) || ( intval($_POST['valSaldoCuentaAhorro']) == "" )) {
                $arrErrores[] = "Debe indicar un valor del ahorro";
            }
        }
    }

    // Validacion para la otra cuenta de ahorro
    if (intval($_POST['valSaldoCuentaAhorro2']) != 0) {
        if (intval($_POST['seqBancoCuentaAhorro2']) == 1) {
            $arrErrores[] = "Indique el banco del campo otro ahorro";
        }
        if (trim($_POST['txtSoporteCuentaAhorro2']) == "") {
            $arrErrores[] = "Indique el soporte del campo otro ahorro";
        }
        if (!esFechaValida($_POST['fchAperturaCuentaAhorro2'])) {
            $arrErrores[] = "Indique la fecha del campo otro ahorro";
        }
    }else{
        if (($_POST['seqBancoCuentaAhorro2'] != 1 ) || ( $_POST['txtSoporteCuentaAhorro2'] != "" ) || ( $_POST['fchAperturaCuentaAhorro2'] != "" )) {
            if ((intval($_POST['valSaldoCuentaAhorro2']) == 0 ) || ( intval($_POST['valSaldoCuentaAhorro2']) == "" )) {
                $arrErrores[] = "Debe indicar un valor del otro ahorro";
            }
        }
    }

    // cesantias
    if (intval($_POST['valSaldoCesantias']) != 0) {
        if (trim($_POST['txtSoporteCesantias']) == "") {
            $arrErrores[] = "Indique el soporte para las cesantías";
        }
    }else{
        if ($_POST['txtSoporteCesantias'] != "") {
            if ((intval($_POST['valSaldoCesantias']) == 0 ) || ( intval($_POST['valSaldoCesantias']) == "" )) {
                $arrErrores[] = "Debe indicar un valor de la cesantia";
            }
        }
    }

    // credito
    if (intval($_POST['valCredito']) != 0) {
        if (intval($_POST['seqBancoCredito']) == 1) {
            $arrErrores[] = "Indique el banco que otorga el credito";
        }
        if (trim($_POST['txtSoporteCredito']) == "") {
            $arrErrores[] = "Indique el soporte para el credito";
        }
        if (!esFechaValida($_POST['fchAprobacionCredito'])) {
            $arrErrores[] = "Debe indicar la fecha de vencimiento del credito";
        }
    }else{
        if (($_POST['seqBancoCredito'] != 1 ) || ( $_POST['txtSoporteCredito'] != "" ) || ( $_POST['fchAprobacionCredito'] != "" )) {
            if ((intval($_POST['valCredito']) == 0 ) || ( intval($_POST['valCredito']) == "" )) {
                $arrErrores[] = "Debe indicar un valor del credito";
            }
        }
    }

    // valor del subsidio nacional
    if (intval($_POST['valSubsidioNacional']) != 0) {
        if (trim($_POST['txtSoporteSubsidioNacional']) == "") {
            $arrErrores[] = "Indique el soporte para el subsidio nacional";
        }
        if (intval($_POST['seqEntidadSubsidio']) == 1) {
            $arrErrores[] = "Indique la entidad que otorga el subsidio nacional";
        }
    }else{
        if (($_POST['seqEntidadSubsidio'] != 1 ) || ( $_POST['txtSoporteSubsidioNacional'] != "" )) {
            if ((intval($_POST['valSubsidioNacional']) == 0 ) || ( intval($_POST['valSubsidioNacional']) == "" )) {
                $arrErrores[] = "Debe indicar un valor del Subsidio Nacional";
            }
        }
    }

    // valor de la donacion (VUR)
    if (intval($_POST['valDonacion']) != 0) {
        if (intval($_POST['seqEmpresaDonante']) == 0) {
            $arrErrores[] = "Indique la empresa que ha realizado la donaci&oacute;n";
        }
        if (trim($_POST['txtSoporteDonacion']) == "") {
            $arrErrores[] = "Indique el soporte para la donaci&oacute;n";
        }
    }else{
        if (($_POST['seqEmpresaDonante'] != 1 ) || ( $_POST['txtSoporteDonacion'] != "" )) {
            if ((intval($_POST['valDonacion']) == 0 ) || ( intval($_POST['valDonacion']) == "" )) {
                $arrErrores[] = "Debe indicar un valor de la donacion";
            }
        }
    }
    
} // si no hay errores generales

/***********************************************************************************************************************
 * PROCESAMIENTO DE LOS DATOS
 ***********************************************************************************************************************/

if (empty($arrErrores)) {

    // parte de lo que esta en la base de datos
    $claSeguimiento = new Seguimiento();
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($_POST['seqFormulario']);

    $claSeguimiento->arrIgnorarCampos = array();
    $_POST['nombre'] = Ciudadano::obtenerNombre($_POST['numDocumento']);
    $_POST['cedula'] = $_POST['numDocumento'];
    $claSeguimiento->salvarSeguimiento($_POST,"cambiosPostulacion");

    if( ! empty( $claSeguimiento->arrErrores ) ){
        $arrErrores = $claSeguimiento->arrErrores;
    }else {

        // Ciudadanos eliminados y actualizados
        foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
            $numDocumento = $objCiudadano->numDocumento;
            if (empty($objCiudadano->arrErrores)) {
                if (isset($_POST['hogar'][$numDocumento])) {
                    foreach ($objCiudadano as $txtClave => $txtValor) {
                        $objCiudadano->$txtClave = regularizarCampo($txtClave, $_POST['hogar'][$numDocumento][$txtClave]);
                    }
                    $objCiudadano->editarCiudadano($seqCiudadano);
                } else {
                    $objCiudadano->borrarCiudadano();
                    $seqCiudadano = $objCiudadano->seqCiudadano;
                    unset($claFormulario->arrCiudadano[$seqCiudadano]);
                }
            } else {
                $arrErrores = $objCiudadano->arrErrores;
            }
        }

        // ciudadanos adicionados
        if (empty($arrErrores)) {

            foreach ($_POST['hogar'] as $numDocumento => $arrDatos) {
                $seqCiudadano = Ciudadano::ciudadanoExiste($arrDatos['seqTipoDocumento'], $arrDatos['numDocumento']);
                $objCiudadano = new Ciudadano();
                if ($seqCiudadano != 0) {
                    $objCiudadano->cargarCiudadano($seqCiudadano);
                }
                foreach ($objCiudadano as $txtClave => $txtValor) {
                    if( isset( $arrDatos[$txtClave] )) {
                        $objCiudadano->$txtClave = regularizarCampo($txtClave, $arrDatos[$txtClave]);

                    }
                }
                if ($seqCiudadano == 0) {
                    $objCiudadano->guardarCiudadano();
                } else {
                    $objCiudadano->editarCiudadano($seqCiudadano);
                }

                if (empty($objCiudadano->arrErrores)) {
                    $seqCiudadano = $objCiudadano->seqCiudadano;
                    $claFormulario->arrCiudadano[$seqCiudadano] = $objCiudadano;
                } else {
                    $arrErrores = $objCiudadano->arrErrores;
                }
            }

            $claFormulario->relacionarCiudadanoFormulario();
            if (!empty($claFormulario->arrErrores)) {
                $arrErrores = $claFormulario->arrErrores;
            }
        }

        // cambios en el formulario
        foreach ($claFormulario as $txtClave => $txtValor) {
            if ($txtClave != "arrCiudadano") {
                if( array_key_exists($txtClave, $_POST) ) {
                    $claFormulario->$txtClave = regularizarCampo($txtClave, $_POST[$txtClave]);
                }
            }
        }

        $claFormulario->txtBarrio = array_shift(
            obtenerDatosTabla(
                "T_FRM_BARRIO",
                array("seqBarrio","txtBarrio"),
                "seqBarrio",
                "seqBarrio = " . $claFormulario->seqBarrio
            )
        );

        $claFormulario->seqEstadoProceso = 37;
        $claFormulario->editarFormulario($_POST['seqFormulario']);
        if (!empty($claFormulario->arrErrores)) {
            $arrErrores = $claFormulario->arrErrores;
        }else{
            $arrMensajes = $claSeguimiento->arrMensajes;
        }
    }
}

/***********************************************************************************************************************
 * IMPRESION DE LOS MENSAJES
 ***********************************************************************************************************************/

imprimirMensajes($arrErrores,$arrMensajes);

?>