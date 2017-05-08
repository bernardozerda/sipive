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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );

include( "./datosComunes.php" );

$txtFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s");
$numAno2Digitos = date("y");

$seqFormulario = $_GET['seqFormulario'];
$seqSolicitud = $_GET['seqSolicitud'];

$claFormulario = new FormularioSubsidios;
$claDesembolso = new Desembolso;

$claFormulario->cargarFormulario($seqFormulario);
$claDesembolso->cargarDesembolso($seqFormulario);

foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        break;
    }
}

// Obtiene los actos administrativos a los que se realaciona el postulante principal
$claActosAdministrativos = new ActoAdministrativo;
$arrFormularioActo = $claActosAdministrativos->actoExisteCiudadano($objCiudadano->numDocumento);

// obtiene el ultimo acto adminsitrativo de asignacion
$arrResolucionAsignacion = array();
$arrResolucionIndexacion = array();
$arrResolucionModificacion = array();

foreach ($arrFormularioActo as $seqFormularioActo) {
    $arrActoAdministrativo = $claActosAdministrativos->obtenerActoAdministrativo($seqFormularioActo);
    $arrActo = $claActosAdministrativos->cargarActoAdministrativoNumero($arrActoAdministrativo['seqTipoActo'], $arrActoAdministrativo['numActo'], $arrActoAdministrativo['fchActo'], $seqFormularioActo);
    $arrCaracteristicas = $claActosAdministrativos->caracteristicasActo($arrActoAdministrativo['numActo'], $arrActoAdministrativo['fchActo']);
    if ($arrActoAdministrativo['seqTipoActo'] == 1) {
        $arrResolucionAsignacion['numero'] = $arrActoAdministrativo['numActo'];
        $arrResolucionAsignacion['fecha'] = $arrActoAdministrativo['fchActo'];
        $arrResolucionAsignacion['valor'] = $arrActo[1][13]; // Aqui esta el valor de la resolucion
    } elseif ($arrActoAdministrativo['seqTipoActo'] == 8) {
        $arrResolucionIndexacion['numero'] = $arrActoAdministrativo['numActo'];
        $arrResolucionIndexacion['fecha'] = $arrActoAdministrativo['fchActo'];
        $arrResolucionIndexacion['proyecto'] = $arrCaracteristicas['Número del Proyecto'];
        $arrResolucionIndexacion['rp'] = $arrCaracteristicas['RP'];
        $arrResolucionIndexacion['fechaRp'] = $arrCaracteristicas['Fecha RP'];
        $arrResolucionIndexacion['valor'] = $arrActo[1][21]; // Aqui esta el valor de la resolucion
        //$arrResolucionIndexacion['valor']  = $arrActo[1][13]; // Aqui esta el valor de la resolucion
    } elseif ($arrActoAdministrativo['seqTipoActo'] == 2) {
        $arrResolucionModificacion['numero'] = $arrActoAdministrativo['numActo'];
        $arrResolucionModificacion['fecha'] = $arrActoAdministrativo['fchActo'];
        //pr($arrResolucionModificacion);die();
        if ($arrCaracteristicas['Resolucion que Modifica'] == $arrResolucionAsignacion['numero'] and
                strtotime($arrCaracteristicas['Fecha resolucion']) == strtotime($arrResolucionAsignacion['fecha'])
        ) {
            $arrResolucionAsignacion['valor'] = $arrActo[1][13];
        }
    }
} //die();
// adquiere la fecha del acto administrativo asi no este dentro del arreglo juridico
//        if( is_numeric( $claDesembolso->arrJuridico['numResolucion'] ) ){
//            $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $claDesembolso->arrJuridico['fchResolucion'] ) ) ) );
//        } else {
//            $claDesembolso->arrJuridico['numResolucion'] = $arrResolucionAsignacion['numero'];
//            $claDesembolso->arrJuridico['fchResolucion'] = $arrResolucionAsignacion['fecha'];
//            $claDesembolso->arrJuridico['valResolucion'] = $arrResolucionAsignacion['valor'];
//            $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode( ucwords( strftime("%d de %B del %Y" , strtotime( $arrResolucionAsignacion['fecha'] ) ) ) );					
//        }

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


if (is_array($claDesembolso->arrSolicitud)) {
    //foreach( $claDesembolso->arrSolicitud['detalles'] as $seqSolicitud => $arrSolicitud ){
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRegistroPresupuestal1Texto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRegistroPresupuestal1']))));
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRegistroPresupuestal2Texto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRegistroPresupuestal2']))));
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRadicacionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchRadicacion']))));
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchOrdenTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchOrden']))));
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchSolicitudTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y a las %I:%M:%S", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchSolicitud']))));
    $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchActualizacionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y a las %I:%M:%S", strtotime($claDesembolso->arrSolicitud['detalles'][$seqSolicitud]['fchActualizacion']))));
    //} 
}

$arrSolicitud = &$claDesembolso->arrSolicitud['detalles'][$seqSolicitud];

$arrSolicitud['txtSubsecretaria'] = $arrSolicitud['txtSubsecretaria'];
$arrSolicitud['txtSubdireccion'] = $arrSolicitud['txtSubdireccion'];
$arrSolicitud['txtRevisoSubsecretaria'] = ucwords($arrSolicitud['txtRevisoSubsecretaria']);
$arrSolicitud['txtElaboroSubsecretaria'] = ucwords($arrSolicitud['txtElaboroSubsecretaria']);
$arrSolicitud['txtNombreBeneficiarioGiro'] = ucwords($arrSolicitud['txtNombreBeneficiarioGiro']);

$objCiudadano->txtNombre1 = mb_strtoupper($objCiudadano->txtNombre1);
$objCiudadano->txtNombre2 = mb_strtoupper($objCiudadano->txtNombre2);
$objCiudadano->txtApellido1 = mb_strtoupper($objCiudadano->txtApellido1);
$objCiudadano->txtApellido2 = mb_strtoupper($objCiudadano->txtApellido2);

$arrSolicitud['txtNombreBeneficiarioGiro'] = mb_strtoupper($arrSolicitud['txtNombreBeneficiarioGiro']);

$claDesembolso->txtNombreVendedor = mb_strtoupper($claDesembolso->txtNombreVendedor);

$claSeguimiento = new Seguimiento;
$claSeguimiento->seqFormulario = $_GET['seqFormulario'];
$numRegistros = array_shift(array_keys($claSeguimiento->obtenerRegistros(1, 0)));

$numSolicitudes = count($claDesembolso->arrSolicitud['resumen']['fechas']);



$result = $aptBd->execute("select txtFlujo from T_DES_FLUJO where seqFormulario = " . $_GET['seqFormulario']);
$txtflujo = $result->fields['txtFlujo'];
$claSmarty->assign("Flujo", $txtflujo);

$claSmarty->assign("arrResolucionModificacion", $arrResolucionModificacion);
$claSmarty->assign("arrResolucionIndexacion", $arrResolucionIndexacion);
$claSmarty->assign("arrNombreProyectos", $arrNombreProyectos);
$claSmarty->assign("txtFuente12", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;");
$claSmarty->assign("txtFuente10", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;");
$claSmarty->assign("numAno2Digitos", $numAno2Digitos);
$claSmarty->assign("txtFecha", $txtFecha);
$claSmarty->assign("claCiudadano", $objCiudadano);
$claSmarty->assign("claDesembolso", $claDesembolso);
$claSmarty->assign("arrSolicitud", $claDesembolso->arrSolicitud['detalles'][$seqSolicitud]);
$claSmarty->assign("claFormulario", $claFormulario);
$claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("numRegistro", $numRegistros);
$claSmarty->assign("numSolicitudes", $numSolicitudes);

$claSmarty->display("desembolso/formatoSolicitudDesembolso.tpl");

//	pr( $claDesembolso );
?>
