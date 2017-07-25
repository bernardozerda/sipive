<?php

/**
 * INICIO DE LA PANTALLA DE DESEMBOLSOS
 * @author Bernardo Zerda
 * @version 1.0 Dic 2009
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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );

$valCedulaFormat = str_replace(".", "", $_POST['cedula']);
if (is_numeric($valCedulaFormat) and $valCedulaFormat > 0) {

    // Datos del ciudadano que esta solicitando la informacion
    $numDocumento = str_replace(".", "", $_POST['cedula']);
    $claCiudadano = new Ciudadano;
    $seqCiudadano = $claCiudadano->ciudadanoExiste(1, $numDocumento);
    if ($seqCiudadano == 0) {
        $seqCiudadano = $claCiudadano->ciudadanoExiste(2, $numDocumento);
    }
    $claCiudadano->cargarCiudadano($seqCiudadano);
    $seqFormulario = $claCiudadano->formularioVinculado($numDocumento);

    // Verifica si el ciudadano esta vinculado a un formulario
    if ($seqFormulario != 0) {

        // Obtiene la informacion del formulario
        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($seqFormulario);

        // Obtencion de datos comunes apra el proceso de desembolso
        include( "./datosComunes.php" );

        // Verifica si el hogar tiene un estado que le permite acceder al modulo de desembolsos
        // asimismo determina el flujo de datos que debe seguir el hogar y la fase del desembolso en la que se encuentra
        $arrFlujoHogar = $claFlujoDesembolsos->obtenerFlujo($seqFormulario, $claFormulario->seqEstadoProceso);


        if ($arrFlujoHogar['flujo'] != "" and $arrFlujoHogar['fase'] != "") {

            // Obtiene los datos del modulo de desembolsos del hogar
            $claDesembolso = new Desembolso;
            $claDesembolso->cargarDesembolso($seqFormulario);

            $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claDesembolso->seqLocalidad, "txtBarrio");

            $claDesembolso->seqBarrio = array_shift(
                obtenerDatosTabla(
                    "T_FRM_BARRIO",
                    array("seqBarrio","txtBarrio"),
                    "txtBarrio",
                    "txtBarrio = '" . $claDesembolso->txtBarrio . "' and seqLocalidad = " . $claDesembolso->seqLocalidad
                )
            );

            // Carga el tutor que tiene asignado ese hogar
            $claCRM = new CRM;
            $txtTutor = $claCRM->obtenerTutorHogar($seqFormulario);

            // Obtiene los ultimos 100 seguimientos del hogar
            $claSeguimiento = new Seguimiento;
            $claSeguimiento->seqFormulario = $seqFormulario;
            $arrRegistros = $claSeguimiento->obtenerRegistros(100);

            // Obtiene el postulante principal
            foreach ($claFormulario->arrCiudadano as $objCiudadano) {
                if ($objCiudadano->seqParentesco == 1) {
                    $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
                    break;
                }
            }

            // obtiene la informacion de la pestana de actos administrativos
            $claActosAdministrativos = new ActoAdministrativo();
            $arrActos = $claActosAdministrativos->cronologia($numDocumento);

            // obtiene el ultimo acto adminsitrativo de asignacion
            $arrResolucionAsignacion = array();
            $arrResolucionIndexacion = array();
            foreach ($arrActos as $txtClave => $arrInformacion) {
                if ($arrInformacion["acto"]["tipo"] == 1) {
                    $arrResolucionAsignacion['numero'] = $arrInformacion['acto']['numero'];
                    $arrResolucionAsignacion['fecha'] = date("Y-m-d", $arrInformacion['acto']['marca']);
                    $arrResolucionAsignacion['valor'] = $arrInformacion['acto']['valor']; // Aqui esta el valor original de la resolucion de asignacion
                    if (isset($arrInformacion['relacionado'])) {
                        foreach ($arrInformacion['relacionado'] as $txtClave => $arrRelacionado) {
                            if ($arrRelacionado['tipo'] == 8) {
                                $arrResolucionIndexacion['numero'] = $arrRelacionado['numero'];
                                $arrResolucionIndexacion['fecha'] = date("Y-m-d", $arrRelacionado['marca']);
                                $arrResolucionIndexacion['proyecto'] = $arrRelacionado['caracteristicas'][38];
                                $arrResolucionIndexacion['rp'] = $arrRelacionado['caracteristicas'][35];
                                $arrResolucionIndexacion['fechaRp'] = $arrRelacionado['caracteristicas'][37];
                                $arrResolucionIndexacion['valor'] = $arrRelacionado['indexacion'];
                            }
                            //si hay una resolucion modificatoria al valor del subsidio se reemplaza el valor del subsidio por el de la modificacion
                            if ($arrRelacionado['tipo'] == 2) {
                                if (is_array($arrRelacionado['modificaciones'])) {
                                    foreach ($arrRelacionado['modificaciones'] as $arrModificacion) {
                                        if ($arrModificacion['txtCampo'] == "VR SUBSIDIO" or $arrModificacion['txtCampo'] == "Valor Del Subsidio") {
                                            $arrResolucionAsignacion['valor'] = $arrModificacion['txtCorrecto'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $arrNombreProyectos = array();
            $arrNombreProyectos[644] = "Soluciones De Vivienda Para Población En Situación De Desplazamiento";
            $arrNombreProyectos[801] = "Mejoramiento del Habitát Rural";
            $arrNombreProyectos[1075] = "Estructuración de instrumentos de financiación para el desarrollo territorial";
            $arrNombreProyectos[435] = "Mejoramiento Integral de Barrios de Origen Informal";
            if (strtotime($arrResolucionAsignacion['fecha']) >= strtotime("2012-01-01")) {
                $arrNombreProyectos[488] = "Implementación de instrumentos de gestión y financiación para  la producción de Vivienda de Interés Prioritario";
            } else {
                $arrNombreProyectos[488] = "Instrumentos de Financiación para Adquisición, Construcción y Mejoramiento de Vivienda";
            }

            $claDesembolso->arrJuridico['numResolucion'] = $arrResolucionAsignacion['numero'];
            $claDesembolso->arrJuridico['fchResolucion'] = $arrResolucionAsignacion['fecha'];
            $claDesembolso->arrJuridico['valResolucion'] = $arrResolucionAsignacion['valor'];
            $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($arrResolucionAsignacion['fecha']))));

            // Plantilla comun para todas las fases de desembolso
            $claSmarty->assign("arrActos", $arrActos);
            $claSmarty->assign("arrNombreProyectos", $arrNombreProyectos);
            $claSmarty->assign("arrResolucionIndexacion", $arrResolucionIndexacion);
            $claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']); // Prepara concepto juridico
            $claSmarty->assign("objCiudadano", $objCiudadano); // Postulante principal
            $claSmarty->assign("seqFormulario", $seqFormulario);
            $claSmarty->assign("cedula", $valCedulaFormat); // PARA SABER AL FINAL DEL PROCESO A QUE CIUDADANO SE ATENDIO
            $claSmarty->assign("claFormulario", $claFormulario);

            if ($arrFlujoHogar['fase'] == "escrituracion") {
                if (is_array($claDesembolso->arrEscrituracion)) {
                    foreach ($claDesembolso->arrEscrituracion as $txtClave => $txtValor) {
                        $claDesembolso->$txtClave = $txtValor;
                    }
                }
            }
            $esCoordinador = 0;
            $claSmarty->assign("esCoordinador", $esCoordinador);
            if ($_SESSION['seqUsuario'] == 5 || $_SESSION['seqUsuario'] == 414) {
                //if (array_key_exists(7, $_SESSION['arrGrupos'] [3]) || array_key_exists(9, $_SESSION['arrGrupos'] [3])) {
                $esCoordinador = 1;
            }
            $claSmarty->assign("esCoordinador", $esCoordinador);
            $claSmarty->assign("arrBarrio", $arrBarrio);
            $claSmarty->assign("claDesembolso", $claDesembolso);
            $claSmarty->assign("txtFase", $arrFlujoHogar['fase']);
            $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar); // Flujo de datos aplicado al hogar
            $claSmarty->assign("txtPlantilla", $claFlujoDesembolsos->arrFases[$arrFlujoHogar['flujo']][$arrFlujoHogar['fase']]['plantilla']);
            $claSmarty->assign("txtImprimir", $claFlujoDesembolsos->arrFases[$arrFlujoHogar['flujo']][$arrFlujoHogar['fase']]['imprimir']);
            $claSmarty->assign("txtTutor", $txtTutor);
            $claSmarty->assign("arrRegistros", $arrRegistros);
            $claSmarty->assign("arrResolucionAsignacion", $arrResolucionAsignacion); // Para plantilla revision juridica
            $claSmarty->assign("txtHoy", utf8_encode(ucwords(strftime("%d de %B del %Y")))); //  Para la plantilla de estudio de titulos
            $claSmarty->display("desembolso/desembolso.tpl");
        } else {
            $arrEstados = estadosProceso();
            $arrErrores[] = "Este hogar no se encuentra listo para realizar el proceso de desembolso, el estado actual es: " . $arrEstados[$claFormulario->seqEstadoProceso];
            imprimirMensajes($arrErrores, array());
        }
    } else {
        $arrErrores[] = "Este ciudadano no existe o no est&aacute; vinculado a un hogar";
        imprimirMensajes($arrErrores, array());
    }
} else {
    $arrErrores[] = "Digite un numero de documento";
    imprimirMensajes($arrErrores, array());
} // fin if si hay cedula digitada
?>
