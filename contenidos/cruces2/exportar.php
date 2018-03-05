<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );

$arrEstados = estadosProceso();

$seqCruce      = (intval($_GET['seqCruce']) != 0)? $_GET['seqCruce'] : null;
$seqFormulario = (intval($_GET['seqFormulario']) != 0)? $_GET['seqFormulario'] : null;

$claCruces = new Cruces();
$claCruces->cargar($seqCruce,$seqFormulario);

$xmlArchivo  = "<?xml version='1.0'?> ";
$xmlArchivo .= "<?mso-application progid='Excel.Sheet'?> ";
$xmlArchivo .= "<Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet' ";
$xmlArchivo .= "xmlns:o='urn:schemas-microsoft-com:office:office' ";
$xmlArchivo .= "xmlns:x='urn:schemas-microsoft-com:office:excel' ";
$xmlArchivo .= "xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet' ";
$xmlArchivo .= "xmlns:html='http://www.w3.org/TR/REC-html40'>";

$xmlArchivo .= "<Styles>";
$xmlArchivo .= "<Style ss:ID='Default' ss:Name='Normal'>";
$xmlArchivo .= "<Alignment/>";
$xmlArchivo .= "<Borders/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior/>";
$xmlArchivo .= "<NumberFormat/>";
$xmlArchivo .= "<Protection/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s1'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Center'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
$xmlArchivo .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s2'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
$xmlArchivo .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s3'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
$xmlArchivo .= "<Interior ss:Color='#D8D8D8' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s4'>";
$xmlArchivo .= "<Borders>";
$xmlArchivo .= "<Border ss:Position='Right' ss:LineStyle='Continuous' ss:Weight='1'/>";
$xmlArchivo .= "</Borders>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Right'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8' ss:Bold='1'/>";
$xmlArchivo .= "<Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s5'>";
$xmlArchivo .= "<NumberFormat ss:Format='yyyy-mm-dd'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s6'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#C5D9F1' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s7'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#F2DDDC' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s8'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#EAF1DD' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s9'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#E5E0EC' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s10'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#F2F2F2' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "<Style ss:ID='s11'>";
$xmlArchivo .= "<Alignment ss:Vertical='Center' ss:Horizontal='Left'/>";
$xmlArchivo .= "<Font ss:FontName='Calibri' ss:Size='8'/>";
$xmlArchivo .= "<Interior ss:Color='#FDE9D9' ss:Pattern='Solid'/>";
$xmlArchivo .= "</Style>";

$xmlArchivo .= "</Styles>";

$xmlArchivo .= "<ss:Worksheet ss:Name='Datos'>";
$xmlArchivo .= "<ss:Table>";

// titulos del archivo
$arrTitulos[] = "RESULTADO";
$arrTitulos[] = "FORMULARIO";
$arrTitulos[] = "POSTULANTE PRINCIPAL";
$arrTitulos[] = "MODALIDAD";
$arrTitulos[] = "ESTADO";
$arrTitulos[] = "TIPO_DOCUMENTO";
$arrTitulos[] = "DOCUMENTO";
$arrTitulos[] = "NOMBRE";
$arrTitulos[] = "PARENTESCO";
$arrTitulos[] = "ENTIDAD";
$arrTitulos[] = "CAUSA";
$arrTitulos[] = "DETALLE";
$arrTitulos[] = "INHABILITAR";
$arrTitulos[] = "OBSERVACIONES";

// titulos
$xmlArchivo .= "<ss:Row>";
foreach ($arrTitulos as $txtTitulo => $txtValor){
    $xmlArchivo .= "<ss:Cell ss:StyleID='s1'><ss:Data ss:Type='String'>$txtValor</ss:Data></ss:Cell>";
}
$xmlArchivo .= "</ss:Row>";

// datos
foreach ($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrDatos){

    $seqFormulario = $arrDatos['seqFormulario'];
    if( ! isset( $arrFormularios[$seqFormulario] ) ){
        $arrFormularios[$seqFormulario] = new FormularioSubsidios();
        $arrFormularios[$seqFormulario]->cargarFormulario($seqFormulario);
    }

    // va quitando los ciudadanos que esten en el archivo, los que queden se adicionaran
    foreach ($arrFormularios[$seqFormulario]->arrCiudadano as $seqCiudadano => $objCiudadano){
        if(
            $objCiudadano->seqTipoDocumento == $arrDatos['seqTipoDocumento'] and
            $objCiudadano->numDocumento == $arrDatos['numDocumento']
        ){
            unset($arrFormularios[$seqFormulario]->arrCiudadano[$seqCiudadano]);
        }
    }

    $txtModalidad = array_shift(
        obtenerDatosTabla(
            "t_frm_modalidad",
            array("seqModalidad", "txtModalidad"),
            "seqModalidad",
            "seqModalidad = " . $arrDatos['seqModalidad']
        )
    );

    $seqEstadoProceso = $arrDatos['seqEstadoProceso'];

    $txtTipoDocumento = array_shift(
        obtenerDatosTabla(
            "t_ciu_tipo_documento",
            array("seqTipoDocumento","txtTipoDocumento"),
            "seqTipoDocumento",
            "seqTipoDocumento = " . $arrDatos['seqTipoDocumento']
        )
    );

    $txtParentesco = array_shift(
        obtenerDatosTabla(
            "t_ciu_parentesco",
            array("seqParentesco","txtParentesco"),
            "seqParentesco",
            "seqParentesco = " . $arrDatos['seqParentesco']
        )
    );

    $txtInhabilitar = ($arrDatos['bolInhabilitar'] == 1)? "SI" : "NO";

    $xmlArchivo .= "<ss:Row>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['seqResultado'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['seqFormulario'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['numDocumentoPrincipal'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtModalidad . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrEstados[$seqEstadoProceso] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtTipoDocumento . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $arrDatos['numDocumento'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrDatos['txtNombre'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtParentesco . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrDatos['txtEntidad'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrDatos['txtTitulo'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrDatos['txtDetalle'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtInhabilitar . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrDatos['txtObservaciones'] . "</ss:Data></ss:Cell>";
    $xmlArchivo .= "</ss:Row>";

}

// datos
$arrTipoDocumentoMayores = array(1,2);
foreach($arrFormularios as $seqFormulario => $claFormulario) {

    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {

        $bolAdicionar = true;

        if ($claFormulario->seqPlanGobierno == 2 and (!in_array($objCiudadano->seqTipoDocumento, $arrTipoDocumentoMayores))) {
            $bolAdicionar = false;
        }

        if ($bolAdicionar == true) {
            $numColumna = 0;

            $claFormularioPrincipal = new FormularioSubsidios();
            $claFormularioPrincipal->cargarFormulario($seqFormulario);
            $objPrincipal = Cruces::obtenerPrincipal($claFormularioPrincipal);

            $txtModalidad = array_shift(
                obtenerDatosTabla(
                    "t_frm_modalidad",
                    array("seqModalidad", "txtModalidad"),
                    "seqModalidad",
                    "seqModalidad = " . $claFormulario->seqModalidad
                )
            );

            $seqEstadoProceso = $claFormulario->seqEstadoProceso;

            $txtTipoDocumento = array_shift(
                obtenerDatosTabla(
                    "t_ciu_tipo_documento",
                    array("seqTipoDocumento", "txtTipoDocumento"),
                    "seqTipoDocumento",
                    "seqTipoDocumento = " . $objCiudadano->seqTipoDocumento
                )
            );

            $txtParentesco = array_shift(
                obtenerDatosTabla(
                    "t_ciu_parentesco",
                    array("seqParentesco", "txtParentesco"),
                    "seqParentesco",
                    "seqParentesco = " . $objCiudadano->seqParentesco
                )
            );

            $xmlArchivo .= "<ss:Row>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'></ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>$seqFormulario</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $objPrincipal->numDocumento . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtModalidad . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $arrEstados[$seqEstadoProceso] . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtTipoDocumento . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>" . $objCiudadano->numDocumento . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . Cruces::obtenerNombre($objCiudadano) . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>" . $txtParentesco . "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>SDHT</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>PENDIENTE CRUCES</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'></ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>SI</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'></ss:Data></ss:Cell>";
            $xmlArchivo .= "</ss:Row>";

        }
    }

}

$xmlArchivo .= "</ss:Table>";
$xmlArchivo .= "</ss:Worksheet>";

$xmlArchivo .= "</ss:Workbook>";

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: inline; filename=\"Datos_" . $claCruces->arrDatos['txtNombre'] . "_" . date("YmdHis") . "\".xls");

echo $xmlArchivo;

?>