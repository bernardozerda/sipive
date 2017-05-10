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
//   include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );
//pr( $_POST );


$arrErrores = array();
$arrMensajes = array();
$numFechaHoy = time();
$numMayorEdad = strtotime("-18 year", $numFechaHoy); // Timestamp de nacimiento de mayor de edad
$numTerceraEdad = strtotime("-65 year", $numFechaHoy); // Timestamp de nacimiento de terera edad
// Informacion actual del formulario
$claCiudadano = new Ciudadano();
$claFormulario = new FormularioSubsidios();
$claFormulario->cargarFormulario($_POST['seqFormulario']);
$victima = '';

/* * ****************************************************************************************************
 * VALIDACIONES GENERALES
 * **************************************************************************************************** */

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



// si no hay erroes continua
if (empty($arrErrores)) {

    /*     * ****************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE COMPOSICION FAMILIAR
     * **************************************************************************************************** */

    $numCabezaFamilia = 0;
    $numCondicionJefeHogar = 0;
    $numCondicionJefeHogarSinIngreso = 0;
    $numCedula = 0;
    $numVictimas = 0;
    $numAdultos = 0;
    $numNinos = 0;
    $hoy = date('Y-m-d');
    $cuentaUnionMarital = 0;
    $cuentaCasado = 0;

    if (!empty($_POST['hogar'])) {
        // var_dump($_POST);

        foreach ($_POST['hogar'] as $numDocumento => $arrCiudadano) {

            // el primer nombre no puede ser vacio
            if ($arrCiudadano['txtNombre1'] == "") {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener primer nombre";
            }

            // el primer apellido no debe estar vacio
            if ($arrCiudadano['txtApellido1'] == "") {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener primer apellido";
            }

            // Parentesco
            if ($arrCiudadano['seqParentesco'] == 0) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener parentesco";
            } elseif ($arrCiudadano['seqParentesco'] == 1) {
                $numCabezaFamilia++; // si es Jefe de Hogar ( solo debe existir un miembro con parentesco 1 )
                if ($arrCiudadano['seqTipoDocumento'] != 1) {
                    if ($arrCiudadano['seqTipoDocumento'] != 2) {
                        $arrErrores[] = "El tipo de documento seleccionado para el postulante principal no es válido";
                    }
                }
            }elseif ( $arrCiudadano['seqParentesco'] == 13 or $arrCiudadano['seqParentesco'] == 12 ){
            	$arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " tiene seleccionado un parentesco que no es válido";
            }

            // Solo puede haber una persona con condicion Especial Jefe de Hogar
            if (( $arrCiudadano['seqCondicionEspecial'] == 1 ) || ( $arrCiudadano['seqCondicionEspecial2'] == 1 ) || ( $arrCiudadano['seqCondicionEspecial3'] == 1 )) {
                if ($arrCiudadano['valIngresos'] > 0) {
                    $numCondicionJefeHogar++; // Cuenta los miembros del hogar que cuentan con la condición 'Madre / Padre cabeza de Familia'
                } else {
                    $numCondicionJefeHogarSinIngreso++; // Cuenta los miembros del hogar que cuentan con la condición 'Madre / Padre cabeza de Familia' sin Ingreso
                }
            }

            // Estado Civil

            $arrEstadoCivilProhibido = ( $_POST['seqPlanGobierno'] == 1 || $_POST['seqPlanGobierno'] == 3) ? array(0) : array(0, 1, 3, 4, 5);
            if (in_array($arrCiudadano['seqEstadoCivil'], $arrEstadoCivilProhibido)) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " no puede tener el estado civil seleccionado.";
            }

            if ($_POST['seqPlanGobierno'] == 3) {
                // echo "<br> <br>".$arrCiudadano['seqNivelEducativo'];
                if ($_POST['valIngresoHogar'] > 0 && $arrCiudadano['seqNivelEducativo'] != 1 && $arrCiudadano['anosAprobados'] == 0) {
                    $arrErrores[] = "El ciudadano debe seleccionar el numero de años aprobados";
                }

                if ($arrCiudadano['seqSalud'] == 0) {
                    $arrErrores[] = "El ciudadano debe seleccionar si se encuentra afiliado a la salud";
                }
            }



            // Si es el caso de unión marital de hecho, deben existir solo 2 personas con ese estado civil en el hogar
            // Author: Jaison Ospina - Enero 21
            if ($arrCiudadano['seqEstadoCivil'] == 7) {
                $cuentaUnionMarital ++;
            }

            if ($arrCiudadano['seqEstadoCivil'] == 6) {
                $cuentaCasado ++;
            }

            // fecha de nacimiento
            if (!esFechaValida($arrCiudadano['fchNacimiento'])) {
                $arrErrores[] = "El ciudadano con numero de documento " . number_format($numDocumento) . " debe tener una fecha de nacimiento.";
            } else {

                // Valida que no se seleccione una fecha mayor o igual a hoy
                if (strtotime($arrCiudadano['fchNacimiento']) >= strtotime($hoy)) {
                    $arrErrores[] = "Fecha de nacimiento invalida para " .
                            $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                            $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                            ", debe seleccionar una fecha menor a hoy";
                }

                $numEdad = strtotime($arrCiudadano['fchNacimiento']);

                // tipos de documento invalidos para un menor de edad                  
                $arrDocumentosMenorEdad[] = 4; // Tarjeta de Identidad
                $arrDocumentosMenorEdad[] = 3; // Registro Civil
                // tipos de documento invalidos para un menor de edad
                $arrDocumentosMayorEdad[] = 1; // Cedula Ciudadania
                $arrDocumentosMayorEdad[] = 2; // Cedula extranjeria
                // Identificador de la condicion especial
                $numCondicionEspecialMayor65 = 2;

                // se compara si es mayor de edad al momento de la actualizacion
                if (( $numEdad <= $numMayorEdad ) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentosMenorEdad)) {
                    $arrErrores[] = "Tipo de documento errado para " .
                            $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                            $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                            " porque segun su fecha de nacimiento es mayor de edad";
                }

                // se compara si es menor de edad al momento de la actualizacion
                if (( $numEdad > $numMayorEdad ) and in_array($arrCiudadano['seqTipoDocumento'], $arrDocumentosMayorEdad)) {
                    $arrErrores[] = "Tipo de documento errado para " .
                            $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                            $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                            " porque segun su fecha de nacimiento es menor de edad";
                }



                // se compara si es menor de 65 aNos y tenga condicion especial mayor 65 anos
                if (( $numEdad > $numTerceraEdad ) and ( $arrCiudadano["seqCondicionEspecial"] == $numCondicionEspecialMayor65 or
                        $arrCiudadano["seqCondicionEspecial2"] == $numCondicionEspecialMayor65 or
                        $arrCiudadano["seqCondicionEspecial3"] == $numCondicionEspecialMayor65 )) {
                    $arrErrores[] = "Condicion especial errada para " .
                            $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                            $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'] .
                            " porque segun su fecha de nacimiento es menor de edad y se le esta asignando la condicion especial de Mayor de 65 Año";
                }

                // se compara si es tercera edad al momento de la actualizacion
                if (( $numEdad <= $numTerceraEdad ) and ( $arrCiudadano['seqCondicionEspecial'] != 2 and
                        $arrCiudadano['seqCondicionEspecial2'] != 2 and
                        $arrCiudadano['seqCondicionEspecial3'] != 2 )) {
                    $arrErrores[] = "Debe tener condicion especial de Mayor de 65 A&ntilde;os para el ciudadano " .
                            $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " .
                            $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'];
                }
            } // fin fecha nacimiento valida
            // por lo menos debe haber una cedula de ciudadania
            if ($arrCiudadano['seqTipoDocumento'] == 1) {
                $numCedula++; // si es cedula de ciudadania ( por lo menos 1 colombiano mayor de edad )
            }

            // suma la cantidad de victimas de desplazamiento forzado que hay en el hogar
            /* if( $arrCiudadano['seqTipoVictima'] == 2 ){
              $numVictimas++;
              } */

            // VALIDAR SI ALGUNO DE LOS INTEGRANTES TIENE HECHO VICTIMIZANTE 
            $elarray = $arrCiudadano['seqTipoVictima'];
            $arrTipVic = explode(',', $elarray);
            foreach ($arrTipVic as $numeros) {
                if ($numeros == '2') {
                    $victima = 'OK';
                } else {
                    $normal = 'OK';
                }
            }

            $tipoDocumento = $arrCiudadano['seqTipoDocumento'];
            //echo "TIPO DOCUMENTO: " . $tipoDocumento . " TIPO DOCUMENTO";
            // $seqFormulario = $claCiudadano->formularioVinculado( $numDocumento, $bolPostualtePrincipal = false, $bolSoloMayorEdad = false );
            $seqFormulario = $claCiudadano->formularioVinculado2($numDocumento, $tipoDocumento, $bolPostualtePrincipal = false, $bolSoloMayorEdad = false);

            /* echo "<br><br><b>Formulario del Hogar:</b> ".$_POST['seqFormulario']."<br>";
              echo "<b>Formulario del Ciudadano:</b> ".$seqFormulario."<br>";
              echo "<b>Tipo Documento:</b> ".$tipoDocumento."<br>";
              echo "<b>numDocumento:</b> ".$numDocumento."<br><br>"; */

            // formulario del ciudadano
            $sql = "SELECT numDocumento
						FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
						WHERE seqFormulario = (SELECT seqFormulario
						FROM T_FRM_HOGAR INNER JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
						WHERE numDocumento = $numDocumento AND seqTipoDocumento = $tipoDocumento)
						AND seqParentesco = 1";
            //echo "SQL: " . $sql;
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqPostPalExistente = $objRes->fields['numDocumento'];
            }
            //echo "<br>$seqFormulario != 0 && $seqFormulario != " . $_POST['seqFormulario'];
            if ($seqFormulario != 0 and $seqFormulario != $_POST['seqFormulario']) {
                $txtNombre = strtolower(ucwords($arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " . $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2']));
                $arrErrores[] = "El ciudadano [" . number_format($numDocumento) . "] $txtNombre está vinculado al hogar de [" . number_format($seqPostPalExistente) . "], no puede adicionarlo a este nucleo familiar ";
            }

            // Conteo de ninos y adultos
            if ($numEdad <= $numMayorEdad) {
                $numAdultos++;
            } else {
                $numNinos++;
            }
        } // validaciones para cada miembro de hogar
        // Compara si el hogar cuenta con parejas completas con estado "Union marital de hecho" en el hogar
        // Author: Jaison Ospina - Enero 21 /2016
        if ($cuentaUnionMarital % 2 == 0) {
            $unionMarital = 'ok';
        } else {
            $unionMarital = 'no';
        }

        if ($cuentaCasado % 2 == 0) {
            $casado = 'ok';
        } else {
            $casado = 'no';
        }

        // errores que se producen dentro del grupo familiar
        switch (true) {
            case $numCabezaFamilia == 0: $arrErrores[] = "Debe existir un postulante principal en el hogar";
                break;
            case $numCabezaFamilia > 1: $arrErrores[] = "El hogar solo puede tener un postulante principal";
                break;
            case $numCondicionJefeHogar > 1: $arrErrores[] = "No puede existir mas de una persona con la condición especial 'Madre / Padre cabeza de Familia'";
                break;
            case $numCondicionJefeHogarSinIngreso > 0: $arrErrores[] = "La persona con la condición especial 'Madre / Padre cabeza de Familia' debe tener ingresos";
                break;
            case $numCedula == 0: $arrErrores[] = "Debe haber por lo menos un mayor de edad colombiano dentro del nucleo familiar";
                break;
            case $unionMarital == 'no': $arrErrores[] = "Verificar estado civil, debe existir otra persona con estado civil 'Unión Marital de hecho' en el hogar";
                break;
            case $casado == 'no': $arrErrores[] = "Verificar estado civil, debe existir otra persona con estado civil 'Casado' en el hogar";
                break;
        }
    } else {
        $arrErrores[] = "Debe haber por lo menos una persona dentro del grupo familiar";
    } // si hay miembros de hogar


    /*     * ****************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE DATOS DEL HOGAR
     * **************************************************************************************************** */

    // Tipo de vivienda
    if ($_POST['seqVivienda'] == 1) {

        // NO PUEDE HABER UN VALOR DE ARRENDAMIENTO CERO
        $_POST['valArriendo'] = mb_ereg_replace("[^0-9]", "", $_POST['valArriendo']);
        if (intval($_POST['valArriendo']) == 0) {
            $arrErrores[] = "Ha seleccionado el tipo de vivienda 'Arrendamiento' por lo tanto debe indicar el valor del arrendamiento";
        }

        // debe tener fecha desde la que paga arriendo
        if (!esFechaValida($_POST['fchArriendoDesde'])) {
            $arrErrores[] = "Ha seleccionado el tipo de vivienda 'Arrendamiento' por lo tanto debe colocar la fecha desde la que se paga el arriendo";
        }

        // Debe contestar la pregunta de si hay comprobate de arriendo
        if (trim($_POST['txtComprobanteArriendo']) == "") {
            $arrErrores[] = "Ha seleccionado el tipo de vivienda 'Arrendamiento' por lo tanto debe indicar si existe el comprobante de arriendo";
        }
    }

    // direccion de residencia
    if ($_POST['txtDireccion'] == "") {
        $arrErrores[] = "Debe dar una direcci&oacute;n";
    }

    // ciudad
    if (intval($_POST['seqCiudad']) == 0) {
        $arrErrores[] = "Seleccione la ciudad en los datos del hogar";
    }

    // localidad
    if (intval($_POST['seqLocalidad']) == 1 or intval($_POST['seqLocalidad']) == 0) {
        $arrErrores[] = "Debe seleccionar una localidad diferente";
    }

    // barrio
    if (intval($_POST['seqBarrio']) == 0) {
        $arrErrores[] = "Debe seleccionar una barrio diferente";
    }
    
    // Sisben
    $arrSisbenInactivos = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben","txtSisben"), "seqSisben","bolActivo = 0");
    $seqPostSisben = intval($_POST['seqSisben']);
    if($seqPostSisben == 0 ){
    	$arrErrores[] = "Seleccione un valor para la pregunta ¿Tiene Sisben?";
    }elseif(isset($arrSisbenInactivos[$seqPostSisben])){
    	$arrErrores[] = "El valor seleccionado para la pregunta ¿Tiene Sisben? no es válido";
    }

    $txtFormatoFijo    = "/^[0-9]{7}$/";
    $txtFormatoCelular = "/^[3]{1}[0-9]{9}$/";
    
    // Telefono Celular
    if ( ! preg_match( $txtFormatoCelular , trim( $_POST['numCelular'] ) ) ) {
    	$arrErrores[] = "El número telefonico celular debe tener 10 digitos y debe iniciar con el número 3";
    }
    
    // Telefono Fijo 1
    if( is_numeric( $_POST['numTelefono1'] ) == true and intval( $_POST['numTelefono1'] ) != 0 ){
    	if ( ! preg_match( $txtFormatoFijo , trim( $_POST['numTelefono1'] ) ) ) {
    		$arrErrores[] = "El número telefonico fijo 1 debe tener 7 digitos";
    	}
    }
    
    // Formatos de expresion regular para telefonos fijos y celular
    /* $txtFormatoFijo    = "/^[0-9]{7}$/";
      $txtFormatoCelular = "/^[3]{1}[0-9]{9}$/";

      // Telefono Fijo 2
      if( is_numeric( $_POST['numTelefono2'] ) == true and intval( $_POST['numTelefono2'] ) != 0 ){
      if ( ! preg_match( $txtFormatoFijo , trim( $_POST['numTelefono2'] ) ) ) {
      $arrErrores[] = "El número telefonico fijo 2 debe tener 7 digitos";
      }
      }

      // Telefono Celular
      if( is_numeric( $_POST['numCelular'] ) == true and intval( $_POST['numCelular'] ) != 0 ) {
      if ( ! preg_match( $txtFormatoCelular , trim( $_POST['numCelular'] ) ) ) {
      $arrErrores[] = "El número telefonico celular debe tener 10 digitos y debe iniciar con el número 3";
      }
      }

      // Debe haber telefono fijo o numero celular
      if( intval( $_POST['numCelular'] ) == 0 and intval( $_POST['numTelefono1'] ) == 0 ){
      $arrErrores[] = "Debe registrar un telefono fijo o celular de contacto";
      } */

    if ($_POST['seqPlanGobierno'] == 2) {
        $exregfijo = "/^[0-9]{7}$/";
        $exregcel = "/^[3]{1}[0-9]{9}$/";
        if ($_POST['numTelefono1'] == "" and $_POST['numCelular'] == "") {
            $arrErrores[] = "El ciudadano debe tener un telefono de contacto";
        } else {
            if ($_POST['numTelefono1'] != "" || $_POST['numTelefono1'] != 0) {
                if (!preg_match($exregfijo, $_POST['numTelefono1'])) {
                    $arrErrores[] = "El Numero Telefonico no puede ser menor ni mayor a 7 digitos";
                }
            }
            if ($_POST['numCelular'] != "" || $_POST['numCelular'] != 0) {
                if (!preg_match($exregcel, $_POST['numCelular'])) {
                    $arrErrores[] = "El Numero celular no puede ser menor ni mayor a 10 digitos y debe empezar por 3";
                }
            }
        }
    }

    // Si hay correo electronico debe ser valido
    if (trim($_POST['txtCorreo']) != "") {
        if (!ereg("^[0-9a-zA-Z._\-]+\@[a-zA-Z0-9._\-]+\.([a-zA-z]{2,4})(([\.]{1})([a-zA-Z]{2}))?$", trim($_POST['txtCorreo']))) {
            $arrErrores[] = "No es un correo electrónico válido";
        }
    }

    /*     * ****************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE DATOS DE LA POSTULACION
     * **************************************************************************************************** */

    // Modalidad
    /* $arrModalidadProhibida = ( $_POST['seqPlanGobierno'] == 1 )? array( 0 , 6 , 11 , 7 , 10 , 8 , 9 ) : array( 0 , 1 , 5 , 2 , 3 , 4 );
      if( in_array( intval( $_POST['seqModalidad'] ) , $arrModalidadProhibida ) ){
      $arrErrores[] = "La modalidad de postulacion seleccionada no es v&aacute;lida";
      } */

    // Valida la Modalidad a la cual se pasa y asigna el Plan de Gobierno para los formularios abiertos
    if ($_POST['bolCerrado'] == 0) {
        if ($_POST['seqModalidad'] == 6 || $_POST['seqModalidad'] == 7 || $_POST['seqModalidad'] == 8 ||
                $_POST['seqModalidad'] == 9 || $_POST['seqModalidad'] == 10 || $_POST['seqModalidad'] == 11) {
            $_POST['seqPlanGobierno'] = 2;
        }
    }

    // solucion
    if ($_POST['seqSolucion'] == 1) {
        $arrErrores[] = "Debe seleccionar el tipo de solucion";
    }

    // Quita los puntos de los campos
    $_POST['valPresupuesto'] = mb_ereg_replace("[^0-9]", "", $_POST['valPresupuesto']);
    $_POST['valAvaluo'] = mb_ereg_replace("[^0-9]", "", $_POST['valAvaluo']);
    $_POST['valTotal'] = mb_ereg_replace("[^0-9]", "", $_POST['valTotal']);

    /*     * ****************************************************************************************************
     * VALIDACIONES PARA LA PESTANA DE INFORMACION FINANCIERA
     * **************************************************************************************************** */

    // Campo Tiene Ahorro, valida el banco, el soporte y la fecha de apertura
    $_POST['valSaldoCuentaAhorro'] = mb_ereg_replace("[^0-9]", "", $_POST['valSaldoCuentaAhorro']);
    if (intval($_POST['valSaldoCuentaAhorro']) != 0) {
        if ($_POST['seqBancoCuentaAhorro'] == 1) {
            $arrErrores[] = "Debe indicar la entidad en la cual tiene el ahorro";
        }
        if (trim($_POST['txtSoporteCuentaAhorro'] == "")) {
            $arrErrores[] = "Debe indicar el soporte de la cuenta de ahorro";
        }
        if (!esFechaValida($_POST['fchAperturaCuentaAhorro'])) {
            $arrErrores[] = "Debe indicar la fecha de apertura del ahorro";
        }
    }

    if (($_POST['seqBancoCuentaAhorro'] != 1 ) || ( $_POST['txtSoporteCuentaAhorro'] != "" ) || ( $_POST['fchAperturaCuentaAhorro'] != "" )) {
        if ((intval($_POST['valSaldoCuentaAhorro']) == 0 ) || ( intval($_POST['valSaldoCuentaAhorro']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del ahorro";
        }
    }

    // Campo Tiene Ahorro 2, valida el banco 2, el soporte 2 y la fecha de apertura 2
    $_POST['valSaldoCuentaAhorro2'] = mb_ereg_replace("[^0-9]", "", $_POST['valSaldoCuentaAhorro2']);
    if (intval($_POST['valSaldoCuentaAhorro2']) != 0) {
        if ($_POST['seqBancoCuentaAhorro2'] == 1) {
            $arrErrores[] = "Debe indicar la entidad en la cual tiene el otro ahorro";
        }
        if (trim($_POST['txtSoporteCuentaAhorro2'] == "")) {
            $arrErrores[] = "Debe indicar el soporte de la cuenta del otro ahorro";
        }
        if (!esFechaValida($_POST['fchAperturaCuentaAhorro2'])) {
            $arrErrores[] = "Debe indicar la fecha de apertura del otro ahorro";
        }
    }

    if (($_POST['seqBancoCuentaAhorro2'] != 1 ) || ( $_POST['txtSoporteCuentaAhorro2'] != "" ) || ( $_POST['fchAperturaCuentaAhorro2'] != "" )) {
        if ((intval($_POST['valSaldoCuentaAhorro2']) == 0 ) || ( intval($_POST['valSaldoCuentaAhorro2']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del otro ahorro";
        }
    }

    // Campo Subsidio Nacional
    $_POST['valSubsidioNacional'] = mb_ereg_replace("[^0-9]", "", $_POST['valSubsidioNacional']);
    if (intval($_POST['valSubsidioNacional']) != 0 and trim($_POST['txtSoporteSubsidioNacional']) == "") {
        $arrErrores[] = "Debe indicar el soporte del Subsidio Nacional";
    }

    if (($_POST['seqEntidadSubsidio'] != 1 ) || ( $_POST['txtSoporteSubsidioNacional'] != "" )) {
        if ((intval($_POST['valSubsidioNacional']) == 0 ) || ( intval($_POST['valSubsidioNacional']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del Subsidio Nacional";
        }
    }

    // Campo Aporte Lote o terreno
    $_POST['valAporteLote'] = mb_ereg_replace("[^0-9]", "", $_POST['valAporteLote']);
    if (intval($_POST['valAporteLote']) != 0 and trim($_POST['txtSoporteLote']) == "") {
        $arrErrores[] = "Debe indicar el soporte del Aporte Lote o Terreno";
    }

    if (( $_POST['txtSoporteLote'] != "")) {
        if ((intval($_POST['valAporteLote']) == 0 ) || ( intval($_POST['valAporteLote']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del Aporte Lote o Terreno";
        }
    }

    // Campo Cesantias
    $_POST['valSaldoCesantias'] = mb_ereg_replace("[^0-9]", "", $_POST['valSaldoCesantias']);
    if (intval($_POST['valSaldoCesantias']) != 0 and trim($_POST['txtSoporteCesantias']) == "") {
        $arrErrores[] = "Debe indicar el soporte de la cesantia";
    }

    if (( $_POST['txtSoporteCesantias'] != "")) {
        if ((intval($_POST['valSaldoCesantias']) == 0 ) || ( intval($_POST['valSaldoCesantias']) == "" )) {
            $arrErrores[] = "Debe indicar un valor de la cesantia";
        }
    }

    // Campo Aporte Avance de Obra
    $_POST['valAporteAvanceObra'] = mb_ereg_replace("[^0-9]", "", $_POST['valAporteAvanceObra']);
    if (intval($_POST['valAporteAvanceObra']) != 0 and trim($_POST['txtSoporteAvanceObra']) == "") {
        $arrErrores[] = "Debe indicar el soporte del Aporte Avance de Obra";
    }

    if (( $_POST['txtSoporteAvanceObra'] != "")) {
        if ((intval($_POST['valAporteAvanceObra']) == 0 ) || ( intval($_POST['valAporteAvanceObra']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del Aporte Avance de Obra";
        }
    }

    // Campo Tiene Credito, valida banco, soporte y fecha
    $_POST['valCredito'] = mb_ereg_replace("[^0-9]", "", $_POST['valCredito']);
    if (intval($_POST['valCredito']) != 0) {
        if ($_POST['seqBancoCredito'] == 1) {
            $arrErrores[] = "Debe indicar la entidad en la cual tiene el Credito";
        }
        if (trim($_POST['txtSoporteCredito']) == "") {
            $arrErrores[] = "Debe indicar el soporte del credito";
        }
        if (!esFechaValida($_POST['fchAprobacionCredito'])) {
            $arrErrores[] = "Debe indicar la fecha de vencimiento del credito";
        }
    }

    if (($_POST['seqBancoCredito'] != 1 ) || ( $_POST['txtSoporteCredito'] != "" ) || ( $_POST['fchAprobacionCredito'] != "" )) {
        if ((intval($_POST['valCredito']) == 0 ) || ( intval($_POST['valCredito']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del credito";
        }
    }

    // Campo Aporte Materiales
    $_POST['valAporteMateriales'] = mb_ereg_replace("[^0-9]", "", $_POST['valAporteMateriales']);
    if (intval($_POST['valAporteMateriales']) != 0 and trim($_POST['txtSoporteAporteMateriales']) == "") {
        $arrErrores[] = "Debe indicar el soporte del Aporte Materiales";
    }

    if (( $_POST['txtSoporteAporteMateriales'] != "")) {
        if ((intval($_POST['valAporteMateriales']) == 0 ) || ( intval($_POST['valAporteMateriales']) == "" )) {
            $arrErrores[] = "Debe indicar un valor del Aporte Materiales";
        }
    }

    // Campo Tiene Donación / Reconocimiento Económico
    $_POST['valDonacion'] = mb_ereg_replace("[^0-9]", "", $_POST['valDonacion']);
    if (intval($_POST['valDonacion']) != 0) {
        if ($_POST['seqEmpresaDonante'] == 1) {
            $arrErrores[] = "Debe indicar la entidad a la cual hizo la donacion";
        }
        if (trim($_POST['txtSoporteDonacion']) == "") {
            $arrErrores[] = "Debe indicar el soporte de la donacion";
        }
    }

    if (($_POST['seqEmpresaDonante'] != 1 ) || ( $_POST['txtSoporteDonacion'] != "" )) {
        if ((intval($_POST['valDonacion']) == 0 ) || ( intval($_POST['valDonacion']) == "" )) {
            $arrErrores[] = "Debe indicar un valor de la donacion";
        }
    }

    /*     * ****************************************************************************************************
     * OTRAS VALIDACIONES DE NEGOCIO
     * **************************************************************************************************** */

    // si es formulario está cerrado no guarda en estando en inscripcion
    if (intval($_POST['bolCerrado']) == 1) {
        $arrErrores[] = "El formulario está cerrado, ingresar por el modulo de postulación";
    }

    // Obtiene el valor del subsidio segun modalidad y tipo de solucion seleccionada	
    try {
        if ($_POST['seqPlanGobierno'] != 3) {
            $_POST['valAspiraSubsidio'] = mb_ereg_replace("[^0-9]", "", $_POST['valAspiraSubsidio']);
            if(intval($_POST['valAspiraSubsidio']) != 0) {
                $valAspiraSubsidio = 0;
                $sql = "
                    SELECT valSubsidio
                    FROM T_FRM_VALOR_SUBSIDIO
                    WHERE seqSolucion = " . $_POST['seqSolucion'] . "
                      AND seqModalidad = " . $_POST['seqModalidad'] . "
                 ";
                $objRes = $aptBd->execute($sql);
                if ($objRes->RecordCount() > 0) {
                    $valAspiraSubsidio = $objRes->fields['valSubsidio'];
                    if ((intval($_POST['valAspiraSubsidio']) < $valAspiraSubsidio) and trim($_POST['txtSoporteSubsidio']) == "") {
                        $arrErrores[] = "No puede cambiar el valor tope del subsidio sin dar un soporte para este cambio, diligencie el campo 'Soporte Cambio'";
                    }
                } else {
                    $arrErrores[] = "No se ha podido establecer el valor del subsidio con base en la modalidad y la solucion seleccionada";
                }
            }
        }
    } catch (Exception $objError) {
        $valAspiraSubsidio = 0;
        $arrErrores[] = "No se ha podido establecer el valor del subsidio con base en la modalidad y la solucion seleccionada";
    }

    // si es independiente debe indicar ingresos
    if (intval($_POST['bolDesplazado']) == 0) {
        if (intval($_POST['valIngresoHogar']) == 0) {
            $arrErrores[] = "El ingreso del hogar no puede sumar cero";
        }
    }

    // si hay victimas de desplazamiento forzado dentro del hogar, el hogar se considera desplazado
    // el conteo de victimas se hace en el ciclo de validaciones del hogar
    if ($numVictimas == 0) {
        $_POST['bolDesplazado'] == 0;
    } else {
        $_POST['bolDesplazado'] == 1;
    }

    // ACCIONES AL CERRAR EL FORMULARIO
    if ($_POST['bolCerrado'] == 0) {
        // Indica que esta abriendo el formularios
        if ($claFormulario->bolCerrado == 1) {
            $_POST['txtFormulario'] = "";
            $_POST['fchPostulacion'] = "";
        }
    } else { // post bolCerrado == 1
        // el formulario sigue cerrado
        if ($claFormulario->bolCerrado == 1) {
            $_POST['txtFormulario'] = $claFormulario->txtFormulario;
            $_POST['fchPostulacion'] = $claFormulario->fchPostulacion;
        } else {
            $_POST['fchPostulacion'] = date("Y-m-d H:i:s");
        }
    }

//      // Define el esquema a partir del esquema al que pertenece el proyecto
//      $claProyecto = new ProyectoVivienda();
//      if( intval( $_POST['seqProyecto'] ) != 0 ){
//        $arrProyecto = $claProyecto->cargarProyectoVivienda( $_POST['seqProyecto'] );
//        $objProyecto = $arrProyecto[ $_POST['seqProyecto'] ];
//        if( intval( $objProyecto->seqTipoEsquema ) == 0 ){
//            $arrErrores[] = "El proyeto no tiene el esquema definido, contacte al estructurador del proyecto " . $objProyecto->txtNombreProyecto;
//        }else{
//            $seqTipoEsquema = $objProyecto->seqTipoEsquema;
//            switch( $seqTipoEsquema ){
//                case 1: 
//                    $_POST['seqEstadoProceso'] = 49; // IND - Primera Verificacion
//                    break;
//            }
//        }
//      }else{
//          $seqTipoEsquema = 0;
//      }
} // si no hay errores generales

/* * *********************************************************************************************************************
 * PROCESAMIENTO DE LOS DATOS
 * ******************************************************************************************************************** */

if (empty($arrErrores)) {

    // Donde guardara los datos del post para salvar en la base de datos
    $claFormularioNuevo = new FormularioSubsidios();

    // recorre el hogar en el post que es como debe quedar
    foreach ($_POST['hogar'] as $numDocumento => $arrCiudadano) {

        $claCiudadanoNuevo = new Ciudadano();
        $claCiudadanoNuevo->txtNombre1 = $arrCiudadano['txtNombre1'];
        $claCiudadanoNuevo->txtNombre2 = $arrCiudadano['txtNombre2'];
        $claCiudadanoNuevo->txtApellido1 = $arrCiudadano['txtApellido1'];
        $claCiudadanoNuevo->txtApellido2 = $arrCiudadano['txtApellido2'];
        $claCiudadanoNuevo->fchNacimiento = $arrCiudadano['fchNacimiento'];
        $claCiudadanoNuevo->seqTipoDocumento = $arrCiudadano['seqTipoDocumento'];
        $claCiudadanoNuevo->numDocumento = $numDocumento;
        $claCiudadanoNuevo->valIngresos = $arrCiudadano['valIngresos'];
        $claCiudadanoNuevo->seqNivelEducativo = $arrCiudadano['seqNivelEducativo'];
        $claCiudadanoNuevo->seqEtnia = $arrCiudadano['seqEtnia'];
        $claCiudadanoNuevo->seqEstadoCivil = $arrCiudadano['seqEstadoCivil'];
        $claCiudadanoNuevo->seqOcupacion = $arrCiudadano['seqOcupacion'];
        $claCiudadanoNuevo->seqCondicionEspecial = $arrCiudadano['seqCondicionEspecial'];
        $claCiudadanoNuevo->seqCondicionEspecial2 = $arrCiudadano['seqCondicionEspecial2'];
        $claCiudadanoNuevo->seqCondicionEspecial3 = $arrCiudadano['seqCondicionEspecial3'];
        $claCiudadanoNuevo->seqSexo = $arrCiudadano['seqSexo'];
        $claCiudadanoNuevo->bolLgtb = $arrCiudadano['bolLgtb'];
        $claCiudadanoNuevo->numAnosAprobados = $arrCiudadano['anosAprobados'];
        $claCiudadanoNuevo->seqSalud = $arrCiudadano['seqSalud'];
        $claCiudadanoNuevo->seqTipoVictima = $arrCiudadano['seqTipoVictima'];
        $claCiudadanoNuevo->seqGrupoLgtbi = $arrCiudadano['seqGrupoLgtbi'];
        $claCiudadanoNuevo->seqParentesco = $arrCiudadano['seqParentesco'];

        // verifica si el ciudadano existe o no para guardarlo o editarlo
        $seqCiudadano = $claCiudadanoNuevo->ciudadanoExiste($arrCiudadano['seqTipoDocumento'], $numDocumento);
        if ($seqCiudadano == 0) {
            $seqCiudadano = $claCiudadanoNuevo->guardarCiudadano();
        } else {
            $claCiudadanoNuevo->editarCiudadano($seqCiudadano);
        }

        if ($victima == 'OK') {
            $condicionV = 1;
        } else {
            $condicionV = 0;
        }

        // recopilacion de errores
        if (!empty($claCiudadanoNuevo->arrErrores)) {
            foreach ($claCiudadanoNuevo->arrErrores as $txtError) {
                $arrErrores[] = $txtError;
            }
        }

        // asocia con el formulario (clase) el ciudadano nuevo
        $claFormularioNuevo->arrCiudadano[$seqCiudadano] = $claCiudadanoNuevo;
        $claCiudadanoNuevo = null;
    }

    // coloca los datoa del post en el formulario
    $claFormularioNuevo->seqFormulario = $_POST['seqFormulario'];
    $claFormularioNuevo->txtDireccion = $_POST['txtDireccion'];
    $claFormularioNuevo->seqTipoDireccion = 0;
    $claFormularioNuevo->numTelefono1 = $_POST['numTelefono1'];
    $claFormularioNuevo->numTelefono2 = $_POST['numTelefono2'];
    $claFormularioNuevo->numCelular = $_POST['numCelular'];
    $claFormularioNuevo->txtBarrio = obtenerNombres("T_FRM_BARRIO", "seqBarrio", $_POST['seqBarrio']);
    $claFormularioNuevo->txtCorreo = $_POST['txtCorreo'];
    $claFormularioNuevo->txtMatriculaInmobiliaria = $_POST['txtMatriculaInmobiliaria'];
    $claFormularioNuevo->txtChip = $_POST['txtChip'];
    $claFormularioNuevo->bolViabilizada = $_POST['bolViabilizada'];
    $claFormularioNuevo->bolIdentificada = $_POST['bolIdentificada'];
    if ($_POST['seqPlanGobierno'] == 2 || $_POST['seqPlanGobierno'] == 3) {
        $claFormularioNuevo->bolDesplazado = $condicionV;
    } else {
        $claFormularioNuevo->bolDesplazado = $_POST['bolDesplazado'];
    }
    //$claFormularioNuevo->bolDesplazado                = $_POST['bolDesplazado'];
    $claFormularioNuevo->seqSolucion = $_POST['seqSolucion'];
    $claFormularioNuevo->valPresupuesto = $_POST['valPresupuesto'];
    $claFormularioNuevo->valAvaluo = $_POST['valAvaluo'];
    $claFormularioNuevo->valTotal = $_POST['valTotal'];
    $claFormularioNuevo->seqModalidad = $_POST['seqModalidad'];
    $claFormularioNuevo->seqPlanGobierno = $_POST['seqPlanGobierno'];
    $claFormularioNuevo->seqBancoCuentaAhorro = $_POST['seqBancoCuentaAhorro'];
    $claFormularioNuevo->fchAperturaCuentaAhorro = $_POST['fchAperturaCuentaAhorro'];
    $claFormularioNuevo->bolInmovilizadoCuentaAhorro = intval($_POST['bolInmovilizadoCuentaAhorro']);
    $claFormularioNuevo->valSaldoCuentaAhorro = $_POST['valSaldoCuentaAhorro'];
    $claFormularioNuevo->txtSoporteCuentaAhorro = $_POST['txtSoporteCuentaAhorro'];
    $claFormularioNuevo->seqBancoCuentaAhorro2 = $_POST['seqBancoCuentaAhorro2'];
    $claFormularioNuevo->fchAperturaCuentaAhorro2 = $_POST['fchAperturaCuentaAhorro2'];
    $claFormularioNuevo->bolInmovilizadoCuentaAhorro2 = intval($_POST['bolInmovilizadoCuentaAhorro2']);
    $claFormularioNuevo->valSaldoCuentaAhorro2 = $_POST['valSaldoCuentaAhorro2'];
    $claFormularioNuevo->txtSoporteCuentaAhorro2 = $_POST['txtSoporteCuentaAhorro2'];
    $claFormularioNuevo->valSubsidioNacional = $_POST['valSubsidioNacional'];
    $claFormularioNuevo->seqEntidadSubsidio = $_POST['seqEntidadSubsidio'];
    $claFormularioNuevo->txtSoporteSubsidioNacional = $_POST['txtSoporteSubsidioNacional'];
    $claFormularioNuevo->txtSoporteSubsidio = $_POST['txtSoporteSubsidio'];
    $claFormularioNuevo->valAporteLote = $_POST['valAporteLote'];
    $claFormularioNuevo->txtSoporteAporteLote = $_POST['txtSoporteLote'];
    $claFormularioNuevo->seqCesantias = 1;
    $claFormularioNuevo->valSaldoCesantias = $_POST['valSaldoCesantias'];
    $claFormularioNuevo->txtSoporteCesantias = $_POST['txtSoporteCesantias'];
    $claFormularioNuevo->valAporteAvanceObra = $_POST['valAporteAvanceObra'];
    $claFormularioNuevo->txtSoporteAvanceObra = $_POST['txtSoporteAvanceObra'];
    $claFormularioNuevo->valAporteMateriales = $_POST['valAporteMateriales'];
    $claFormularioNuevo->txtSoporteAporteMateriales = $_POST['txtSoporteAporteMateriales'];
    $claFormularioNuevo->seqEmpresaDonante = $_POST['seqEmpresaDonante'];
    $claFormularioNuevo->valDonacion = $_POST['valDonacion'];
    $claFormularioNuevo->txtSoporteDonacion = $_POST['txtSoporteDonacion'];
    $claFormularioNuevo->seqBancoCredito = $_POST['seqBancoCredito'];
    $claFormularioNuevo->valCredito = $_POST['valCredito'];
    $claFormularioNuevo->txtSoporteCredito = $_POST['txtSoporteCredito'];
    $claFormularioNuevo->valTotalRecursos = $_POST['valSaldoCuentaAhorro'] + $_POST['valSaldoCuentaAhorro2'] + $_POST['valSubsidioNacional'] + $_POST['valAporteLote'] + $_POST['valSaldoCesantias'] + $_POST['valAporteAvanceObra'] + $_POST['valCredito'] + $_POST['valAporteMateriales'] + $_POST['valDonacion'];
    //$claFormularioNuevo->valTotalRecursos             = $_POST['valTotalRecursos'];
    $claFormularioNuevo->valAspiraSubsidio = $_POST['valAspiraSubsidio'];
    $claFormularioNuevo->seqVivienda = $_POST['seqVivienda'];
    $claFormularioNuevo->valArriendo = $_POST['valArriendo'];
    $claFormularioNuevo->bolPromesaFirmada = $_POST['bolPromesaFirmada'];
    $claFormularioNuevo->fchInscripcion = $claFormulario->fchInscripcion;
    $claFormularioNuevo->fchPostulacion = $claFormulario->fchPostulacion;
    $claFormularioNuevo->fchVencimiento = $claFormulario->fchVencimiento;
    $claFormularioNuevo->bolIntegracionSocial = $_POST['bolIntegracionSocial'];
    $claFormularioNuevo->bolSecSalud = intval($_POST['bolSecSalud']);
    $claFormularioNuevo->bolSecEducacion = intval($_POST['bolSecEducacion']);
    $claFormularioNuevo->bolSecMujer = intval($_POST['bolSecMujer']);
    $claFormularioNuevo->bolIpes = intval($_POST['bolIpes']);
    $claFormularioNuevo->bolAltaCon = intval($_POST['bolAltaCon']);
    $claFormularioNuevo->txtOtro = $_POST['txtOtro'];
    $claFormularioNuevo->numAdultosNucleo = $numAdultos;
    $claFormularioNuevo->numNinosNucleo = $numNinos;
    //$claFormularioNuevo->seqUsuario                 = $_SESSION['seqUsuario'];
    $claFormularioNuevo->seqUsuario = $claFormulario->seqUsuario;
    //$claFormularioNuevo->seqPuntoAtencion           = $_SESSION['seqPuntoAtencion'];
    $claFormularioNuevo->seqPuntoAtencion = $claFormulario->seqPuntoAtencion;
    $claFormularioNuevo->bolCerrado = $_POST['bolCerrado'];
    $claFormularioNuevo->seqLocalidad = $_POST['seqLocalidad'];
    $claFormularioNuevo->seqCiudad = $_POST['seqCiudad'];
    $claFormularioNuevo->valIngresoHogar = $_POST['valIngresoHogar'];
    $claFormularioNuevo->seqEstadoProceso = $_POST['seqEstadoProceso'];
    $claFormularioNuevo->txtDireccionSolucion = $_POST['txtDireccionSolucion'];
    $claFormularioNuevo->fchAprobacionCredito = $_POST['fchAprobacionCredito'];
    $claFormularioNuevo->txtFormulario = $_POST['txtFormulario'];
    $claFormularioNuevo->fchUltimaActualizacion = date("y-m-d H:i:s");
    $claFormularioNuevo->seqProyecto = $_POST['seqProyecto'];
    $claFormularioNuevo->seqProyectoHijo = $_POST['seqProyectoHijo'];
    $claFormularioNuevo->seqUnidadProyecto = $_POST['seqUnidadProyecto'];
    $claFormularioNuevo->seqTipoFinanciacion = $_POST['seqTipoFinanciacion'];
    $claFormularioNuevo->numCortes = 0;
    $claFormularioNuevo->seqPeriodo = 1;
    $claFormularioNuevo->fchArriendoDesde = $_POST['fchArriendoDesde'];
    $claFormularioNuevo->bolSancion = $_POST['bolSancion'];
    $claFormularioNuevo->fchVigencia = $claFormulario->fchVigencia;
    $claFormularioNuevo->seqUpz = $_POST['seqUpz'];
    $claFormularioNuevo->seqBarrio = $_POST['seqBarrio'];
    $claFormularioNuevo->seqSisben = $_POST['seqSisben'];
    $claFormularioNuevo->fchNotificacion = $claFormulario->fchNotificacion;
    $claFormularioNuevo->txtComprobanteArriendo = $_POST['txtComprobanteArriendo'];
    $claFormularioNuevo->seqTipoEsquema = $_POST['seqTipoEsquema'];
    $claFormularioNuevo->numPuntajeSisben = 0;
    $claFormularioNuevo->flagActualizar = 1;
    $claFormularioNuevo->numHabitaciones = $_POST['numCohabitacion'];
    $claFormularioNuevo->numHacinamiento = $_POST['numHacinamiento'];

//    pr($claFormularioNuevo);
//    die();

    // edita los datos del formulario
    $claFormularioNuevo->editarFormulario($_POST['seqFormulario']);

    // si hay errores los pasa al arreglo de errores
    if (!empty($claFormularioNuevo->arrErrores)) {
        foreach ($claFormularioNuevo->arrErrores as $txtError) {
            $arrErrores[] = $txtError;
        }
    }

    // elimina la informacion dela tabla hogar para que sean vinculados los
    // ciudadanos que estan en el hoar nuevo unicamente
    $sql = "
         DELETE
         FROM T_FRM_HOGAR
         WHERE seqFormulario = " . $_POST['seqFormulario'] . " 
      ";
    $aptBd->execute($sql);

    // en relacion con el formulario anterior se eliminan los ciudadanos que ya no estan en el nuevo hogar (post)
    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
        if (!isset($_POST['hogar'][$claCiudadano->numDocumento])) {
            $seqCiudadano = $claCiudadano->ciudadanoExiste($claCiudadano->seqTipoDocumento, $claCiudadano->numDocumento);
            $claCiudadano->borrarCiudadano($seqCiudadano);
        }
    }

    // construye el hogar con base en lo que esta en el post
    foreach ($claFormularioNuevo->arrCiudadano as $seqCiudadano => $claCiudadanoNuevo) {
        $sql = "
            INSERT INTO T_FRM_HOGAR (
               seqCiudadano,
               seqFormulario,
               bolSoporteDocumento,
               seqParentesco
            ) VALUES (
               \"" . $seqCiudadano . "\",
               \"" . $_POST['seqFormulario'] . "\",
               \"0\",
               \"" . $claCiudadanoNuevo->seqParentesco . "\"
            )
         ";
        $aptBd->execute($sql);
    }

    // Nombre de la persona atendida
    foreach ($claFormularioNuevo->arrCiudadano as $seqCiudadano => $claCiduadanoNuevo) {
        if ($claCiduadanoNuevo->numDocumento == $_POST['numDocumento']) {
            $txtNombre = trim($claCiduadanoNuevo->txtNombre1) . " ";
            $txtNombre .= ( trim($claCiduadanoNuevo->txtNombre2) != "" ) ? trim($claCiduadanoNuevo->txtNombre2) . " " : "";
            $txtNombre .= trim($claCiduadanoNuevo->txtApellido1) . " ";
            $txtNombre .= trim($claCiduadanoNuevo->txtApellido2);
        }
    }

    // datos del postulante principal
    foreach ($claFormularioNuevo->arrCiudadano as $seqCiudadano => $claCiduadanoNuevo) {
        if ($claCiduadanoNuevo->seqParentesco == 1) {
            break;
        }
    }

    $claSeguimiento = new Seguimiento;
    //var_dump($claCiduadanoNuevo);
    $txtCambios = $claSeguimiento->cambiosPostulacion($_POST['seqFormulario'], $claFormulario, $claFormularioNuevo);

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
				\"" . $_POST['seqFormulario'] . "\",
				now(),
				\"" . $_SESSION['seqUsuario'] . "\",
				\"" . mb_ereg_replace("\n", "", $_POST['txtComentario']) . "\",
				\"" . mb_ereg_replace("\"", "", $txtCambios) . "\",
				\"" . $_POST['numDocumento'] . "\",
				\"" . $txtNombre . "\",
				\"" . $_POST['seqGestion'] . "\"
			)					
		";

    try {
        $aptBd->execute($sql);
        $seqSeguimiento = $aptBd->Insert_ID();
    } catch (Exception $objError) {
        $arrErrores[] = "El formulario se ha salvado pero no ha quedado registro de la actividad";
    }
}

/* * *********************************************************************************************************************
 * IMPRESION DE LOS MENSAJES
 * ******************************************************************************************************************** */

if (empty($arrErrores)) {

    $arrMensajes[] = "El formulario se ha salvado, Cedula [ " . number_format($claCiduadanoNuevo->numDocumento) . " ].<br>" .
            "El numero de registro es " . number_format($seqSeguimiento, 0, ".", ",") . ". Conserve este numero para referencia futura";
    $txtEstilo = "msgOk";
} else {
    $arrMensajes = $arrErrores;
    $txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px'>";
foreach ($arrMensajes as $txtMensaje) {
    echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
    //print_r($txtMensaje);
}
echo "</table>";
?>
