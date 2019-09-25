<?php

/**
 * SALVA LOS DATOS DE REVISION TECNICA EN EL ESQUEMA
 * DE CASA EN MANO
 * @author Bernardo Zerda
 * @version 1.0 Jul 2013
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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

/**
 * VALIDACIONES GENERALES DE REVISION TECNICA
 */
if ($_POST['txtConcepto'] == "") {
    $arrErrores[] = "Seleccione el concepto final para el estudio";
}

if ($_POST['fchExpedicion'] == "" or $_POST['fchExpedicion'] == "0000-00-00") {
    $arrErrores[] = "Introduzca la fecha de expedición del certificado";
} 

if ($_POST['fchVisita'] == "") {
    $arrErrores[] = "Introduzca la fecha en la que realizó la visita";
} else {
    $numFechaVisita = strtotime($_POST['fchVisita']);
    $numFechaActual = strtotime(date("Y-m-d"));
    if ($numFechaVisita > $numFechaActual) {
        $arrErrores[] = "La fecha de la visita no puede ser mayor a la de hoy";
    }
}

if (trim($_POST['txtAprobo']) == "") {
    $arrErrores[] = "Debe proporcionar el nombre de quien aprueba este documento";
}

$_POST['numLargoMultiple'] = ( $_POST['numLargoMultiple'] == "" ) ? 0 : $_POST['numLargoMultiple'];
$_POST['numAnchoMultiple'] = ( $_POST['numAnchoMultiple'] == "" ) ? 0 : $_POST['numAnchoMultiple'];

$numLargo = floatval($_POST['numLargoMultiple']);
$numAncho = floatval($_POST['numAnchoMultiple']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaMultiple']) != $numArea) {
        $arrErrores[] = "El área del espacio múltiple no corresponde a los datos registrados";
    }
}

$_POST['numLargoAlcoba1'] = ( $_POST['numLargoAlcoba1'] == "" ) ? 0 : $_POST['numLargoAlcoba1'];
$_POST['numAnchoAlcoba1'] = ( $_POST['numAnchoAlcoba1'] == "" ) ? 0 : $_POST['numAnchoAlcoba1'];

$numLargo = floatval($_POST['numLargoAlcoba1']);
$numAncho = floatval($_POST['numAnchoAlcoba1']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaAlcoba1']) != $numArea) {
        $arrErrores[] = "El área de la alcoba 1 no corresponde a los datos registrados";
    }
}

$_POST['numLargoAlcoba2'] = ( $_POST['numLargoAlcoba2'] == "" ) ? 0 : $_POST['numLargoAlcoba2'];
$_POST['numAnchoAlcoba2'] = ( $_POST['numAnchoAlcoba2'] == "" ) ? 0 : $_POST['numAnchoAlcoba2'];

$numLargo = floatval($_POST['numLargoAlcoba2']);
$numAncho = floatval($_POST['numAnchoAlcoba2']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaAlcoba2']) != $numArea) {
        $arrErrores[] = "El área de la alcoba 2 no corresponde a los datos registrados";
    }
}

$_POST['numLargoAlcoba3'] = ( $_POST['numLargoAlcoba3'] == "" ) ? 0 : $_POST['numLargoAlcoba3'];
$_POST['numAnchoAlcoba3'] = ( $_POST['numAnchoAlcoba3'] == "" ) ? 0 : $_POST['numAnchoAlcoba3'];

$numLargo = floatval($_POST['numLargoAlcoba3']);
$numAncho = floatval($_POST['numAnchoAlcoba3']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaAlcoba3']) != $numArea) {
        $arrErrores[] = "El área de la alcoba 3 no corresponde a los datos registrados";
    }
}

$_POST['numLargoCocina'] = ( $_POST['numLargoCocina'] == "" ) ? 0 : $_POST['numLargoCocina'];
$_POST['numAnchoCocina'] = ( $_POST['numAnchoCocina'] == "" ) ? 0 : $_POST['numAnchoCocina'];

$numLargo = floatval($_POST['numLargoCocina']);
$numAncho = floatval($_POST['numAnchoCocina']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaCocina']) != $numArea) {
        $arrErrores[] = "El área de la cocina no corresponde a los datos registrados";
    }
}

$_POST['numLargoBano1'] = ( $_POST['numLargoBano1'] == "" ) ? 0 : $_POST['numLargoBano1'];
$_POST['numAnchoBano1'] = ( $_POST['numAnchoBano1'] == "" ) ? 0 : $_POST['numAnchoBano1'];

$numLargo = floatval($_POST['numLargoBano1']);
$numAncho = floatval($_POST['numAnchoBano1']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaBano1']) != $numArea) {
        $arrErrores[] = "El área de la baño 1 no corresponde a los datos registrados";
    }
}

$_POST['numLargoBano2'] = ( $_POST['numLargoBano2'] == "" ) ? 0 : $_POST['numLargoBano2'];
$_POST['numAnchoBano2'] = ( $_POST['numAnchoBano2'] == "" ) ? 0 : $_POST['numAnchoBano2'];

$numLargo = floatval($_POST['numLargoBano2']);
$numAncho = floatval($_POST['numAnchoBano2']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaBano2']) != $numArea) {
        $arrErrores[] = "El área de la baño 2 no corresponde a los datos registrados";
    }
}

$_POST['numLargoLavanderia'] = ( $_POST['numLargoLavanderia'] == "" ) ? 0 : $_POST['numLargoLavanderia'];
$_POST['numAnchoLavanderia'] = ( $_POST['numAnchoLavanderia'] == "" ) ? 0 : $_POST['numAnchoLavanderia'];

$numLargo = floatval($_POST['numLargoLavanderia']);
$numAncho = floatval($_POST['numAnchoLavanderia']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaLavanderia']) != $numArea) {
        $arrErrores[] = "El área de la lavanderia no corresponde a los datos registrados";
    }
}

$_POST['numLargoCirculaciones'] = ( $_POST['numLargoCirculaciones'] == "" ) ? 0 : $_POST['numLargoCirculaciones'];
$_POST['numAnchoCirculaciones'] = ( $_POST['numAnchoCirculaciones'] == "" ) ? 0 : $_POST['numAnchoCirculaciones'];

$numLargo = floatval($_POST['numLargoCirculaciones']);
$numAncho = floatval($_POST['numAnchoCirculaciones']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaCirculaciones']) != $numArea) {
        $arrErrores[] = "El área de la circulaciones no corresponde a los datos registrados";
    }
}

$_POST['numLargoPatio'] = ( $_POST['numLargoPatio'] == "" ) ? 0 : $_POST['numLargoPatio'];
$_POST['numAnchoPatio'] = ( $_POST['numAnchoPatio'] == "" ) ? 0 : $_POST['numAnchoPatio'];

$numLargo = floatval($_POST['numLargoPatio']);
$numAncho = floatval($_POST['numAnchoPatio']);
$numArea = round(( $numLargo * $numAncho), 2);
if ($numLargo != 0 and $numAncho != 0) {
    if (floatval($_POST['numAreaPatio']) != $numArea) {
        $arrErrores[] = "El área de la patio no corresponde a los datos registrados";
    }
}

/**
 * PROCEDE A SALVAR EL REGISTRO SI NO HAY ERRORES
 */
$arrMensajes = array();
if (empty($arrErrores)) {

    // salva el registro de concepto juridico
    $claCasaMano = new CasaMano();
    $arrCasaMano = $claCasaMano->cargar($_POST['seqFormulario'], $_POST['seqCasaMano']);
    $objCasaMano = array_shift($arrCasaMano);

    $objCasaMano->salvar($_POST);

    if (!empty($objCasaMano->arrErrores)) {
        $arrErrores = $objCasaMano->arrErrores;
    }
}

/**
 * IMPRESION DE LOS MENSAJES GENERADOS POR EL CODIGO
 */
if (empty($arrErrores)) {
    $arrMensajes = $objCasaMano->arrMensajes;
    $txtEstilo = "msgOk";
} else {
    $arrMensajes = $arrErrores;
    $txtEstilo = "msgError";
}

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>";
foreach ($arrMensajes as $txtMensaje) {
    echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
}
echo "</table>";
?>
