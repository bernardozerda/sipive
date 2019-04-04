<?php
//var_dump($_REQUEST); die();
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$claReporte = new Reportes();
$objRes;
if ($_REQUEST['nombre']) {
    if (isset($_REQUEST['tipo'])) {
        $arrFormularios = Array();
        if ($_FILES['archivo']['error'] == 0) {
            $arrFormularios = mb_split("\n", file_get_contents($_FILES['archivo']['tmp_name']));
            //   pr($arrDocumentos);           
            foreach ($arrFormularios as $numLinea => $numFormulario) {
                if (intval($numFormulario) != 0) {
                    $arrFormularios[$numLinea] = (float) ($numFormulario);
                } else {
                    unset($arrFormularios[$numLinea]);
                }
            }
        }
        $result = $claReporte->validarFormRepGral($arrFormularios, $_REQUEST['nombre']);
        if (count($result) > 0) {
            echo '<div class = "alert alert-danger" role = "alert">Los siguiente formularios no existen en el reporte ' . implode(",", $result) . ' Por favor Verifique</div> ';
        } else {
            $txtNombreArchivo = explode('_', $_REQUEST['nombre']);
            $objRes = $claReporte->obtenerlistaReportesGral($_REQUEST['nombre'], $arrFormularios);
            // var_dump($objRes);                        die();
            $claReporte->obtenerReportesGeneral($objRes, $txtNombreArchivo[0] . "_");
            
        }
    } else {
        $txtNombreArchivo = explode('_', $_REQUEST['nombre']);
        $objRes = $claReporte->obtenerlistaReportesGral($_REQUEST['nombre'], NULL);
        $claReporte->obtenerReportesGeneral($objRes, $txtNombreArchivo[0] . "_");
    }
}

