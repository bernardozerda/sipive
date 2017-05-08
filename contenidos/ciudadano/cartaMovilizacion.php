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
include( $txtPrefijoRuta . "librerias/pdf/class.ezpdf.php" );

setlocale(LC_TIME, 'spanish');
date_default_timezone_set("America/Bogota");

$claCiudadano = new Ciudadano();
$claFormulario = new FormularioSubsidios();

$seqFormulario = $claCiudadano->formularioVinculado($_GET['documento']);
$claFormulario->cargarFormulario($seqFormulario);

$txtPossible = '0123456789abcdefghijkmnpqrstvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
$txtCodigo = '';
$i = 0;
mt_srand(time());
while ($i < 6) {
    $txtCodigo .= substr($txtPossible, mt_rand(0, strlen($txtPossible) - 1), 1);
    $i++;
}

$txtTamanoFuente = 10;
$txtTamanoCausas = $txtTamanoFuente - 2;
$txtTamanoPie = $txtTamanoCausas - 2;

$claPdf = & new Cezpdf("LETTER");
$claPdf->selectFont($txtPrefijoRuta . "librerias/pdf/fonts/TimesNewRoman.afm");
$claPdf->ezSetCmMargins(1, 0.5, 2, 2);

// Escudo
$claPdf->ezImage($txtPrefijoRuta . "recursos/imagenes/escudo.jpg", 0, 70, 'none', 'center');

// Ciudad
$claPdf->ezText(utf8_decode("Bogotá D.C. " . strftime("%d de %B de %Y") . "\n"), $txtTamanoFuente);

// Obtiene el saludo segun el sexo del postulante principal y obtiene el nombre
foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $txtEncabezado = ( $objCiudadano->seqSexo == 1 ) ? "Señor" : "Señora";
        $txtSaludo = ( $objCiudadano->seqSexo == 1 ) ? "Apreciado señor" : "Apreciada señora";
        $txtNombre = $objCiudadano->txtNombre1 . " ";
        $txtNombre .= ( $objCiudadano->txtNombre2 != "" ) ? $objCiudadano->txtNombre2 . " " : "";
        $txtNombre .= $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
        $txtTipoDocumento = obtenerNombres("T_CIU_TIPO_DOCUMENTO", "seqTipoDocumento", $objCiudadano->seqTipoDocumento);

        $txtInscripcion = ( $objCiudadano->seqSexo == 1 ) ? "inscrito" : "inscrita";

        $claPdf->ezText(utf8_decode($txtEncabezado), $txtTamanoFuente);
        $claPdf->ezText(utf8_decode($txtNombre), $txtTamanoFuente);
        $claPdf->ezText(utf8_decode($txtTipoDocumento . " " . $objCiudadano->numDocumento), $txtTamanoFuente);

        break;
    }
}

// Limpia a direcion de dobles espacios
$txtDireccion = mb_strtoupper($claFormulario->txtDireccion);
do {
    $txtDireccion = mb_ereg_replace("  ", " ", $txtDireccion);
} while (mb_strpos($txtDireccion, "  ") !== false);

// obtiene el telefono
$numTelefono = "";
if (trim($claFormulario->numTelefono1) != "") {
    $numTelefono = trim($claFormulario->numTelefono1);
} elseif (trim($claFormulario->numTelefono2 != "")) {
    $numTelefono = trim($claFormulario->numTelefono2);
} else {
    $numTelefono = trim($claFormulario->numCelular);
}
//$numTelefono = ( $numTelefono != "" )? " / " . $numTelefono : "";
// pone la direccion y el telefono y la palabra ciudad
$claPdf->ezText(utf8_decode("Dirección: " . $txtDireccion), $txtTamanoFuente);
$claPdf->ezText(utf8_decode("Teléfono: " . $numTelefono), $txtTamanoFuente);
$claPdf->ezText(utf8_decode("Ciudad\n"), $txtTamanoFuente);
$claPdf->ezText(utf8_decode("\t\t\t\t\t\t\t\t\t\tAsunto: : Autorización Movilización de Recursos\n"), $txtTamanoFuente);
$claPdf->ezText(utf8_decode($txtSaludo . "\n"), $txtTamanoFuente);

$txtParrafo = "Cordial saludo. La Secretaría Distrital del Hábitat se permite informar que todos los trámites para la obtención del Subsidio Distrital de ";
$txtParrafo .= "Vivienda en Especie (SDVE), desde la etapa de inscripción hasta la asignación, son gratuitos, por lo que no necesita de intermediarios o tramitadores.";
$claPdf->ezText(utf8_decode("<i>" . $txtParrafo . "</i>\n"), $txtTamanoFuente, array("justification" => "full"));

$txtParrafo = "En atención a su comunicación radicada en esta entidad bajo el número del asunto, a través de la cual nos solicita ";
$txtParrafo .= "la movilización de los recursos que tiene depositados en el banco " . $_GET['banco'] . ", le manifestamos que usted se encuentra ";
$txtParrafo .= "$txtInscripcion en el Sistema de Información para la Financiación de Soluciones de Vivienda de la Secretaría ";
$txtParrafo .= "Distrital del Hábitat - SIFSV, para acceder a un SDVE.";
$claPdf->ezText(utf8_decode($txtParrafo . "\n"), $txtTamanoFuente, array("justification" => "full"));

$txtParrafo = "A su vez le comunicamos que se ha hecho la respectiva modificación en el SIFSV de su información financiera, ";
$txtParrafo .= "por lo tanto, puede movilizar los recursos de la cuenta.";
$claPdf->ezText(utf8_decode($txtParrafo . "\n"), $txtTamanoFuente, array("justification" => "full"));

$txtParrafo = "Cualquier información adicional, puede comunicarse con nuestra línea de atención al ciudadano PBX 3581600 extensiones de la 1006 a la 1009.";
$claPdf->ezText(utf8_decode($txtParrafo), $txtTamanoFuente, array("justification" => "full"));

$claPdf->ezText(utf8_decode("\nCordialmente\n"), $txtTamanoFuente, array("justification" => "full"));
$numLinea = $claPdf->ezText("\n");

$claPdf->ezText(utf8_decode("Ana Lucía Quintero Mojica"), $txtTamanoFuente, array("justification" => "full"));
$claPdf->ezText(utf8_decode("Subdirector de Recursos Públicos"), $txtTamanoFuente, array("justification" => "full"));
$claPdf->ezText(utf8_decode("subsidiodistritaldeviviendaenespecie@habitatbogota.gov.co"), $txtTamanoFuente, array("justification" => "full"));

$numLinea = $claPdf->ezText("\n");

$numLinea = $claPdf->ezText(utf8_decode($txtCodigo), 20, array("justification" => "center"));
$claPdf->rectangle(120, ( $numLinea - 15), 350, 40);

$numLinea = $claPdf->ezText("\n\n\n");

$claPdf->ezImage($txtPrefijoRuta . "recursos/imagenes/pieCartas.jpg", 0, 550, 'none', 'left');

$sql = "
      INSERT INTO T_CIU_CARTA (
         numDocumento,
         txtTipoCarta,
         fchCarta,
         txtCodigo,
         txtBanco
      ) VALUES (
         '" . mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) . "',
         'Movilizacion',
         now(),
         '$txtCodigo',
         '" . $_GET['banco'] . "'
      );
   ";
$aptBd->execute($sql);

if ($_GET['cuenta'] == 1) {
    $sql = "
         UPDATE T_FRM_FORMULARIO SET
            bolInmovilizadoCuentaAhorro = 0,
            fchAperturaCuentaAhorro = null,
            seqBancoCuentaAhorro = 1,
            txtSoporteCuentaAhorro = '',
            valSaldoCuentaAhorro = 0
         WHERE seqFormulario = $seqFormulario
      ";
    $claFormulario->valSaldoCuentaAhorro = 0;
} else {
    $sql = "
         UPDATE T_FRM_FORMULARIO SET
            bolInmovilizadoCuentaAhorro2 = 0,
            fchAperturaCuentaAhorro2 = null,
            seqBancoCuentaAhorro2 = 1,
            txtSoporteCuentaAhorro2 = '',
            valSaldoCuentaAhorro2 = 0
         WHERE seqFormulario = $seqFormulario
      ";
    $claFormulario->valSaldoCuentaAhorro2 = 0;
}
$aptBd->execute($sql);


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

$sql = "
      UPDATE T_FRM_FORMULARIO SET
         valTotalRecursos = " . $claFormulario->valTotalRecursos . "
      WHERE seqFormulario = $seqFormulario
   ";
$aptBd->execute($sql);

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
         1, 
         'El hogar ha generado la carta de movilizacion de recursos para el banco " . $_GET['banco'] . " desde el sitio web de servicios al ciudadano, se han aplicado los cambios a los datos financieros del hogar', 
         '', 
         " . mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento) . ", 
         '$txtNombre', 
         40, 
         1
      )
   ";
$aptBd->execute($sql);

// Imprime por pantalla
$claPdf->ezStream();
?>
