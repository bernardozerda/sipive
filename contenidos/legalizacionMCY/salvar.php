<?php

ini_set("memory_limit", "-1");
date_default_timezone_set('america/bogota');
session_start();

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "LegalizacionMCY.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel/Writer/Excel2007.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel/IOFactory.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );



$arrErrores = array();

$claLegalizacionMcy = new LegalizacionMCY();
$claDesembolso = new Desembolso();
$claSeguimiento = new Seguimiento();
$textoSeg = "SUBSIDIO LEGALIZADO TENIENDO EN CUENTA LA INFORMACION REPORTADA POR EL SISTEMA DE INFORMACION DEL PROGRAMA MI CASA "
        . "YA Y QUE SE CUMPLE CON LO ESTABLECIDO POR LA RESOLUCION 654 DE 2018";

$arrArchivo = $claLegalizacionMcy->cargarArchivo();
if (empty($claLegalizacionMcy->arrErrores)) {
    $claLegalizacionMcy->validarTitulos($arrArchivo[0]);
    if (empty($claLegalizacionMcy->arrErrores)) {
        unset($arrArchivo[0]);
        $claLegalizacionMcy->validarformularios($arrArchivo);
        if (empty($claLegalizacionMcy->arrErrores)) {
            $destino = '../../recursos/informesMCY/';
            if (!is_dir($destino)) {
                mkdir($destino, 0777, true);
                chmod($destino, 0777);
            }

            $tipo = explode(".", $_FILES['archivo']['name']);
            $cont = count($tipo);
            $tipo = $tipo[($cont - 1)];
            //echo "<br>".$tipo; die();
            $target_path = $destino . basename($_FILES['archivo']['name']);
            // echo "<br>" . $target_path . ", " . "reporte_" . date("M") . "." . $tipo;

            if (empty($claLegalizacionMcy->arrErrores)) {
                $claLegalizacionMcy->salvarDatosFaseI($arrArchivo, $claDesembolso);


                if (empty($claLegalizacionMcy->arrErrores)) {
                    foreach ($claLegalizacionMcy->objSegNuevo as $key => $value) {
                        $txtCambios = "<b>[ " . $key . " ] Datos del Formulario:</b><br>";
                        foreach ($claLegalizacionMcy->objSegNuevo[$key] as $keyF => $valueF) {

                            //echo "<br>" . $keyF . " = " . $valueF;
                            $valueF = ucwords(strtolower($valueF));
                            $valAnterior = ($keyF == 'txtEstadoProceso') ? "Asignacion - Asignado" : 'Ninguno';
                            $txtCambios .= $claSeguimiento->compararValores($keyF, $valAnterior, $valueF, 1);
                        }
                        // echo "<br>" . $txtCambios;
                        $claLegalizacionMcy->salvarSeguimiento($key, $txtCambios, $textoSeg);
                    }
                    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) {

                        $fecha = str_replace(":", "", $claLegalizacionMcy->fecha);
                        rename($target_path, $destino . "ReporteMCY_" . str_replace(".", "", ucwords(strftime("%b", strtotime($claLegalizacionMcy->fecha)))) . "_" . $fecha . "." . $tipo);
                        //rename($target_path, "reporte_" . date("M") . "." . $tipo);
                        echo "<span style='color:green;'>El archivo " . basename($_FILES['archivo']['name']) . " ha sido subido</span><br>";
                    } else {
                        $claLegalizacionMcy->arrErrores[] = "Ha ocurrido un error al subir el archivo, trate de nuevo!";
                    }
                    echo " <div class='alert alert-success'>Se almacenaron los datos con éxito!</div>";
                } else {
                    $claLegalizacionMcy->mostrarErrores();
                }
            } else {
                $claLegalizacionMcy->mostrarErrores();
            }
        } else {
            $claLegalizacionMcy->mostrarErrores();
        }
        //$claArchivoMcy->salvar($arrArchivo);
    } else {
        $claLegalizacionMcy->mostrarErrores();
    }
} else {
    $claLegalizacionMcy->mostrarErrores();
}

$claSmarty->assign("arrMensajes", $claLegalizacionMcy->arrMensajes);
$claSmarty->assign("arrErrores", $claLegalizacionMcy->arrErrores);
$claSmarty->display("legalizacionMCY/legalizacion.tpl");
?>