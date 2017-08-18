<?php

// Ruta relativa 
$txtPrefijoRuta = "../../";

// Archivos necesarios
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
//include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );

setlocale(LC_TIME, 'spanish');
date_default_timezone_set("America/Bogota");
$hoy = iconv('ISO-8859-1', 'UTF-8', strftime('%Y', time()));
$claCiudadano = new Ciudadano();
$claFormulario = new FormularioSubsidios();
//var_dump($claFormulario); exit();
$seqFormulario = $claCiudadano->formularioVinculado($_GET['documento']);
$claFormulario->cargarFormulario($seqFormulario);
$contenido ="";
if ($_GET['tipo'] == 2) {
    $contenido .= '<p>&nbsp;</p><p>Bogota D.C.  NO INSCRITO - APLICATIVO ' .$hoy. '</p>';
}else{
    $contenido .= '<p>&nbsp;</p><p>Bogota D.C. ' . "<p><p>&nbsp;</p>";
}

$txtCodigo = obtenerCode();

function obtenerCode() {
    $claCiudadano = new Ciudadano();
    $txtPossible = '0123456789abcdefghijkmnpqrstvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
    $txtCodigo = '';
    $i = 0;
    mt_srand(time());
    while ($i < 8) {
        $txtCodigo .= substr($txtPossible, mt_rand(0, strlen($txtPossible) - 1), 1);
        $i++;
    }
    $txtCodigo = strtoupper($txtCodigo);

    $code = $claCiudadano->obtenerCodigo($txtCodigo);
    if (count($code) > 1) {
        $txtCodigo = obtenerCode();
    } else {

        return $txtCodigo;
    }
}

$txtTamanoFuente = 10;
$txtTamanoCausas = $txtTamanoFuente - 2;
$txtTamanoPie = $txtTamanoCausas - 2;

$txtSeparador = "\t";
$txtSalto = "\n";
// Escudo

$txtFchIns = $claFormulario->fchInscripcion;
//echo $txtFchIns =  strftime('%A %d de %B de %Y', $txtFchIns);
//exit();
$txtFchIns = explode(" ", $txtFchIns);
//$txtFchIns = date_format($txtFchIns[0],'o\n l jS F Y');
// Obtiene el saludo segun el sexo del postulante principal y obtiene el nombre
//public integer Gender\Gender::get ( $_GET['nombre'] [, integer 1 ] );
$txtSaludo = "Señores<br>";
$txtNombre = $_GET['banco'];
$txtEncabezado = "";
$txtNombre1 = strtoupper($_GET['nombre']);

foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {

    if ($objCiudadano->seqParentesco == 1) {
        $txtEncabezado = ( $objCiudadano->seqSexo == 1 ) ? " el señor" : " la señora";
        $txtTipoDocumento = obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $objCiudadano->seqTipoDocumento);
        $txtInscripcion = ( $objCiudadano->seqSexo == 1 ) ? "inscrito" : "inscrita";
        break;
    }
}
$contenido .= utf8_decode($txtSaludo);
$contenido .= utf8_decode(strtoupper($txtNombre));
// Limpia a direcion de dobles espacios
$txtDireccion = mb_strtoupper($claFormulario->txtDireccion);
do {
    $txtDireccion = mb_ereg_replace("  ", " ", $txtDireccion);
} while (mb_strpos($txtDireccion, "  ") !== false);

// obtiene el telefono
$numTelefono = "";
//$contenido .= utf8_decode($txtDireccion) . "<br>";
if (trim($claFormulario->numTelefono1) != "") {
    $numTelefono = trim($claFormulario->numTelefono1);
} elseif (trim($claFormulario->numTelefono2 != "")) {
    $numTelefono = trim($claFormulario->numTelefono2);
} else {
    if (trim($claFormulario->numCelular) != "") {
        $numTelefono = trim($claFormulario->numCelular);
        //$contenido .= utf8_decode("Telefono: " . $numTelefono) . "<br>";
    }
}



$contenido .= "<br>" . utf8_decode("Bogotá") . "";
$contenido .= "<br><br><div  style='font-size: 20px'>" . utf8_decode("<b style='text-align:justify;'>Asunto:</b> Autorización Movilización de Recursos ") . "</div>";
$contenido .= utf8_decode("Respetados Señores:") . "";

if ($_GET['tipo'] == 2) {
    $txtParrafo = "<p stroke='0.2' fill='true'  style='text-align:justify;'>
La Secretaria Distrital del Hábitat informa que ".$txtEncabezado." ".strtoupper($txtNombre1) .",
    NO se encuentra inscrito (a) en el Sistema
de Información del Programa Integral de Vivienda Efectiva - SIPIVE de la Secretaría Distrital del
Hábitat, por lo tanto no es beneficiario de recursos correspondientes al Aporte Distrital que otorga esta Entidad,
en el marco del Decreto 623 de 2016, <i>\"Por el cual se establece el Programa Integral de Vivienda Efectiva y se
dictan medidas para la generación de vivienda nueva y el mejoramiento de las condiciones de habitabilidad y
estructurales de las viviendas y se dictan otras disposiciones\"</i>.</p>";
    $txtParrafo .= "<p>En consideración a lo anterior, esta Secretaría autoriza a  " . $txtEncabezado . " " . strtoupper($txtNombre1) . ", a efectuar la movilización de los recursos "
           . "que se encuentran depositados en la Cuenta de Ahorro Programado.</p>";

} else {
    $txtParrafo .= "<p>En atención a su comunicación, la Secretaría Distrital del Hábitat informa que  " . $txtEncabezado . " " . strtoupper($txtNombre1) . ", no es beneficiaria (o) del Aporte Distrital que asigna la SDHT.</p>"
    . "<p>En consideración a lo anterior, esta Secretaría autoriza a ".$txtEncabezado." ".strtoupper($txtNombre1) .", a realizar la movilización de los recursos que se encuentran depositados en la Cuenta de Ahorro Programado.</p>";
      
}
  $txtParrafo .= "<p>Cabe aclarar que esta movilización se autoriza única y exclusivamente para los recursos 
depositados por el hogar. Respecto a los recursos consignados por la Caja de Vivienda Popular - CVP -
correspondiente al Valor Único de Reconocimiento - VUR, deberá acercarse a la Caja de Vivienda
Popular ubicada en la Carrera 13 No. 54 - 13, para solicitar el trámite correspondiente.</p>";
      



$contenido .= utf8_decode($txtParrafo);


$txtParrafo = "<p>Finalmente, la Secretaría Distrital del Hábitat le informa que todos los trámites son gratuitos, "
              . "por lo que no necesita de intermediarios o tramitadores. Cualquier información adicional acerca del presente documento, "
              . "puede comunicarse con nuestra línea PBX 3581600 Extensión 3001</p>";


//$contenido .= utf8_decode($txtParrafo);

if($_GET['tipo'] == 2){
    $txtParrafo .="<p><b>Cordialmente,</b></p><p>&nbsp;</p><p>&nbsp;</p>";
}else{
    $txtParrafo .="<p><b>Cordialmente,</b><p><p>&nbsp;</p><p>&nbsp;</p>";
}
$contenido .= utf8_decode($txtParrafo);


$txtParrafo = "<br><br><div class='code'>Código de verificacion: <b>" . $txtCodigo . "</b></div>";
$contenido .= utf8_decode($txtParrafo);
$numDoc = 0;
$objCiudadano->numDocumento;

if ($objCiudadano->numDocumento != "" && $objCiudadano->numDocumento != 0) {
    $numDoc = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
} else {
    $numDoc = mb_ereg_replace("[^0-9]", "", $_GET['documento']);
}
if ($_GET['tipo'] == 2) {
    $txtTipo = 'No inscrito';
} else {
    $txtTipo = 'Movilizacion';
}


$sql1 = "
  INSERT INTO T_CIU_CARTA (
  numDocumento,
  txtNombreCiu,
  txtTipoCarta,
  fchCarta,
  txtCodigo,
  txtBanco,
 seqUsuario
  ) VALUES (
  '" . $numDoc . "',
  '" . $_GET['nombre'] . "',
  '" . $txtTipo . "',
  now(),
  '$txtCodigo',
  '" . $_GET['banco'] . "',
   " . $_SESSION['seqUsuario'] . "
  );
  ";
$aptBd->execute($sql1);
$txtCambios = '';
if ($_GET['cuenta'] == 1) {
    $totalRecursos = 0;
    if ($claFormulario->valSaldoCuentaAhorro > 0) {
        $totalRecursos = $claFormulario->valTotalRecursos - $claFormulario->valSaldoCuentaAhorro;
        $txtCambios .="<b> Cambios en el formulario: [ " . $seqFormulario . " ]</b>" . $txtSalto;
        $txtCambios .= " Valor Ahorro 1: , Valor Anterior: $claFormulario->valSaldoCuentaAhorro, Valor Nuevo: 0" . $txtSalto;
        $txtCambios .= "Entidad , Valor Anterior: " . $_GET['banco'] . ", Valor Nuevo: Ninguno" . $txtSalto;
        $txtCambios .= "Fecha Movilización , Valor Anterior: $claFormulario->fchAperturaCuentaAhorro, Valor Nuevo: 0000-00-00. $txtSalto";
        $txtCambios .= "Soporte de cuenta , Valor Anterior: $claFormulario->txtSoporteCuentaAhorro, Valor Nuevo: Ninguno" . $txtSalto;
        $txtCambios .= "Total Recursos: , Valor Anterior: $claFormulario->valTotalRecursos, Valor Nuevo: " . $totalRecursos . " " . $txtSalto;
    }

    $sql = "
  UPDATE T_FRM_FORMULARIO SET
  bolInmovilizadoCuentaAhorro = 0,
  fchAperturaCuentaAhorro = null,
  seqBancoCuentaAhorro = 1,
  txtSoporteCuentaAhorro = '',
  valSaldoCuentaAhorro = 0,
  valTotalRecursos = " . $totalRecursos . "
  WHERE seqFormulario = $seqFormulario
  ";
    $claFormulario->valSaldoCuentaAhorro = 0;
    $aptBd->execute($sql);
} else if ($_GET['cuenta'] == 2) {
    $totalRecursos = 0;
    if ($claFormulario->valSaldoCuentaAhorro2 > 0) {
        $totalRecursos = $claFormulario->valTotalRecursos - $claFormulario->valSaldoCuentaAhorro2;
        $txtCambios .="<b> Cambios en el formulario: [ " . $seqFormulario . " ]</b>" . $txtSalto;
        $txtCambios .= "Valor Ahorro 2 : , Valor Anterior: $claFormulario->valSaldoCuentaAhorro2, Valor Nuevo: 0" . $txtSalto;
        $txtCambios .= "Entidad , Valor Anterior: " . $_GET['banco'] . ", Valor Nuevo: Ninguno" . $txtSalto;
        $txtCambios .= "Fecha Movilización , Valor Anterior: $claFormulario->fchAperturaCuentaAhorro2, Valor Nuevo: 0000-00-00" . $txtSalto;
        $txtCambios .= "Soporte de cuenta , Valor Anterior: $claFormulario->txtSoporteCuentaAhorro2, Valor Nuevo: Ninguno" . $txtSalto;
        $txtCambios .= "Total Recursos: , Valor Anterior: $claFormulario->valTotalRecursos, Valor Nuevo: " . $totalRecursos . " " . $txtSalto;
    }
    $sql = "
  UPDATE T_FRM_FORMULARIO SET
  bolInmovilizadoCuentaAhorro2 = 0,
  fchAperturaCuentaAhorro2 = null,
  seqBancoCuentaAhorro2 = 1,
  txtSoporteCuentaAhorro2 = '',
  valSaldoCuentaAhorro2 = 0,
  valTotalRecursos = " . $totalRecursos . "
  WHERE seqFormulario = $seqFormulario
  ";
    $claFormulario->valSaldoCuentaAhorro2 = 0;
    $aptBd->execute($sql);
}

if ($claFormulario->seqFormulario != 0) {
     $sql = "
      INSERT INTO T_SEG_SEGUIMIENTO (
         seqFormulario, 
         fchMovimiento, 
         seqUsuario, 
         txtComentario, 
         txtCambios, 
         numDocumento, 
         txtNombre, 
         seqGestion, 
         bolMostrar
      ) VALUES (
         $seqFormulario, 
         NOW(), 
         " . $_SESSION['seqUsuario'] . ", 
         'El hogar ha generado la carta de movilizacion de recursos para el banco " . $_GET['banco'] . " registrado con el codigo: <b>" . $txtCodigo . "</b>. Registrado a nombre de:".$txtNombre1 ." Identificado con C.C:".$numDoc."' , 
         \"" . ereg_replace("\"", "", $txtCambios) . "\", 
         " . mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) . ", 
         '".$txtNombre1."', 
         105, 
         1
      )
   ";
    $aptBd->execute($sql);
}

$claFormulario->valTotalRecursos = (
        $claFormulario->valSaldoCuentaAhorro +
        $claFormulario->valSaldoCuentaAhorro2 +
        $claFormulario->valSubsidioNacional +
        $claFormulario->valAporteLote +
        $claFormulario->valSaldoCesantias +
        $claFormulario->valAporteAvanceObra +
        $claFormulario->valCredito +
        $claFormulario->valAporteMateriales +
        $claFormulario->valDonacion
        );
?>
