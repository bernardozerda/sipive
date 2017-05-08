<?php

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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );

$seqFormulario = $_POST['seqFormulario'];

include( "./datosComunes.php" );

$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario($seqFormulario);

if (in_array($claFormulario->seqEstadoProceso, $claFlujoDesembolsos->arrFases[$_POST['flujo']][$_POST['fase']]['permisos'])) {

    // obtiene los estados que corresponden al estado del proceso del formulario
    $arrFlujoHogar = $claFlujoDesembolsos->obtenerFlujo($seqFormulario, $claFormulario->seqEstadoProceso, $_POST['flujo']);

    // obtiene los seguimientos
    $claSeguimiento = new Seguimiento;
    $claSeguimiento->seqFormulario = $seqFormulario;
    $arrRegistros = $claSeguimiento->obtenerRegistros(100);

    // carga el egiastro de desembolso   
    $claDesembolso = new Desembolso();
    $claDesembolso->cargarDesembolso($seqFormulario);

    // Obtiene el postulante principal
    foreach ($claFormulario->arrCiudadano as $objCiudadano) {
        if ($objCiudadano->seqParentesco == 1) {
            $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
            break;
        }
    }

    // Obtiene la fecha de hoy
    $txtHoy = utf8_encode(ucwords(strftime("%d de %B del %Y")));

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
                    // INICIO
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
                    // FIN
                }
            }
        }
    }

    $arrNombreProyectos = array();
    $arrNombreProyectos[644] = "Soluciones De Vivienda Para Población En Situación De Desplazamiento";
    $arrNombreProyectos[801] = "Mejoramiento del Hábitat Rural";
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

    // Carga el tutor que tiene asignado ese hogar
    $claCRM = new CRM;
    $txtTutor = $claCRM->obtenerTutorHogar($seqFormulario);

    $claSmarty->assign("arrActos", $arrActos);
    $claSmarty->assign("arrNombreProyectos", $arrNombreProyectos);
    $claSmarty->assign("arrResolucionIndexacion", $arrResolucionIndexacion);
    $claSmarty->assign("objCiudadano", $objCiudadano); // Postulante principal
    $claSmarty->assign("claDesembolso", $claDesembolso);
    $claSmarty->assign("arrRegistros", $arrRegistros); // Registros de seguimiento
    $claSmarty->assign("claFormulario", $claFormulario);
    $claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
    $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar); // Flujo de datos aplicado al hogar 

    $claSmarty->display($claFlujoDesembolsos->arrFases[$_POST['flujo']][$_POST['fase']]['plantilla']);
} else {
    $arrEstados = estadosProceso();
    $arrErrores[] = "Este hogar no se encuentra listo para realizar el proceso de desembolso, el estado actual es: " . $arrEstados[$claFormulario->seqEstadoProceso];
    imprimirMensajes($arrErrores, array());
}
?>
