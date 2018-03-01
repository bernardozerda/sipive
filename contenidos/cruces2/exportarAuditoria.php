<?php

ini_set("memory_limit", "-1");

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );

// titulos del archivo
$arrTitulos[] = "FECHA";
$arrTitulos[] = "USUARIO";
$arrTitulos[] = "ID CRUCE";
$arrTitulos[] = "ID FORMULARIO";
$arrTitulos[] = "MODALIDAD";
$arrTitulos[] = "ESTADO DEL PROCESO";
$arrTitulos[] = "POSTULANTE PRINCIPAL";
$arrTitulos[] = "TIPO DE DOCUMENTO";
$arrTitulos[] = "DOCUMENTO";
$arrTitulos[] = "NOMBRE";
$arrTitulos[] = "PARENTESCO";
$arrTitulos[] = "FUENTE";
$arrTitulos[] = "CAUSA";
$arrTitulos[] = "DETALLE";
$arrTitulos[] = "INHABILITAR";
$arrTitulos[] = "OBSERVACIONES";

$seqCruce = (intval($_GET['seqCruce']) != 0)? $_GET['seqCruce'] : null;

$t1 = time();

$claCruces = new Cruces();
$claCruces->cargar($seqCruce);

$t2 = time();

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

$xmlArchivo .= "<ss:Worksheet ss:Name='Auditoria'>";
$xmlArchivo .= "<ss:Table>";

// titulos
$xmlArchivo .= "<ss:Row>";
foreach ($arrTitulos as $txtTitulo => $txtValor){
    $xmlArchivo .= "<ss:Cell ss:StyleID='s1'><ss:Data ss:Type='String'>$txtValor</ss:Data></ss:Cell>";
}
$xmlArchivo .= "</ss:Row>";

// datos
foreach ($claCruces->arrAuditoria as $numLinea => $arrDatos){
    $xmlArchivo .= "<ss:Row>";
    foreach($arrDatos as $txtTitulo => $txtValor) {
        
        switch(true){
            case (esFechaValida($txtValor)) and (strlen($txtValor) <= 10) and (strtotime( $txtValor ) !== false):
                $txtTipo = "DateTime";
                break;
            case is_numeric($txtValor):
                $txtTipo = "Number";
                break;
            default:
                $txtTipo = "String";
                break;
        }
        
        $txtEstilo = "";
        switch($txtTipo){
            case "DateTime":
                $txtValor = date( "Y-m-d" , strtotime( $txtValor ) );
                $txtEstilo = "ss:StyleID='s5'";
                break;
            case "Number":
                $txtValor = doubleval($txtValor);
                break;
            default:
                $txtValor = trim($txtValor);
                break;
        }
        $xmlArchivo .= "<ss:Cell $txtEstilo><ss:Data ss:Type='$txtTipo'>" . $txtValor . "</ss:Data></ss:Cell>";
    }
    $xmlArchivo .= "</ss:Row>";
}
$xmlArchivo .= "</ss:Table>";
$xmlArchivo .= "</ss:Worksheet>";

$xmlArchivo .= "</ss:Workbook>";

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: inline; filename=\"Auditoria_" . $claCruces->arrDatos['txtNombre'] . "_" . date("YmdHis") . "\".xls");
echo $xmlArchivo;

?>