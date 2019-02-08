<?php
include '../../../recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->
        <link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <!--        <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">-->
    </head>
    <body>

        <div id="contenidos" class="container">
            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                M&oacute;dulo de Radicaci&oacute;n 
            </div>

            <div class="well">
                <?php
                include '../conecta.php';

                date_default_timezone_set('America/Bogota');
                $arrDocumentosArchivo = array();

                $separado_por_comas = "";
                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);
                    //$lineas = trim($lineas);
                    $arrayLineas = Array();
                    foreach ($lineas as $linea_num => $linea) {
                        $linea = str_replace("\n", "", $linea);
                        $linea = str_replace("\r", "", $linea);
                        //$linea = str_replace("\t", " ", $linea);

                        if (!empty($linea)) {
                            $arrayLineas = explode("\t", $linea);
                            if ($linea_num == 0 && strtoupper($arrayLineas[0]) != 'DOCUMENTO' && strtoupper($arrayLineas[1]) != 'COMENTARIO') {
                                exit("Verifique los titulos del Archivo de texto debe se documento y  comentario");
                            } else if ($linea_num != 0 && !empty($arrayLineas[0])) {
                                $separado_por_comas .= trim($arrayLineas[0]) . ",";
                                array_push($arrDocumentosArchivo, $linea);
                            }
                        }
                    }

                    $separado_por_comas = substr_replace($separado_por_comas, '', -1, 1);
                } else {
                    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                $validar = validarDocumentos($separado_por_comas, $db, $arrDocumentosArchivo);

                if ($validar) {
                    migrarInformacion($separado_por_comas, $db, $fecha, $numRadicado, $arrDocumentosArchivo);
                }

                // Valida si el documento cumple con los requisitos para ejecutar el cambio de estado y actualizar la fecha de radicación 
                function validarDocumentos($separado_por_comas, $db, $arrDocumentosArchivo) {

                    $band = true;
                    $msg = "";
                    // Está consulta válida que los números de los documentos pertenezcan al postulante principal
                    $sql = "SELECT numdocumento, seqProyecto FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE seqParentesco NOT IN(1) 
                            and numDocumento IN(" . $separado_por_comas . ")";
                    $resultados = $db->get_results($sql);
                    $rows = count($resultados);
                    if ($rows > 0) {
                        $val = "<b>Los siguientes documentos no se encuentran registrados como postulante principal</b><br>";
                        foreach ($resultados as $value) {
                            $val .= "<br>" . $value->numdocumento . "";
                        }
                        $val .= " <br><br> Por favor verifique los datos del hogar ";
                        $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
                        $band = false;
                        if (!$band) {
                            echo $msg;
                            die();
                        }
                    } else if ($band) {
                        //Está consulta válida que los números no tengán un estado diferente a asignación-asignado
                        $sql = "SELECT numdocumento, seqProyecto FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            INNER JOIN t_frm_estado_proceso USING(seqEstadoProceso)
                            WHERE seqEtapa NOT IN(5)
                            and numDocumento IN(" . $separado_por_comas . ")";
                        $resultados = $db->get_results($sql);
                        $rows = count($resultados);
                        if ($rows > 0) {
                            $val = "<b>Los siguientes documentos no tienen el estado de Radicación Expedientes ó Cargue Datos Escrituración ó Cargue Estudio de Titulos</b><br>";
                            foreach ($resultados as $value) {
                                $val .= "<br>" . $value->numdocumento . "";
                            }
                            $val .= " <br><br> Por favor verifique los datos del hogar ";
                            $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
                            $band = false;
                            if (!$band) {
                                echo $msg;
                                die();
                            }
                        } 
//                        else if ($band) {
//                            //Está consulta válida que los documentos pertenezcan a un mismo proyecto
//                            $sql = "SELECT seqFormulario,
//                                    seqProyecto,
//                                    txtNombreProyecto,
//                                    GROUP_CONCAT(numDocumento,' del proyecto ', ucwords(txtNombreProyecto) SEPARATOR '<br> ') AS 'documentos'
//                                    FROM t_frm_formulario
//                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
//                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
//                                    INNER JOIN t_pry_proyecto pro USING(seqProyecto)
//                                    WHERE ciu.numDocumento IN (" . $separado_por_comas . ")      
//                                    GROUP BY seqProyecto";
//                            $resultados = $db->get_results($sql);
//                            $rows = count($resultados);
//                            if ($rows > 1) {
//                                $val = "<b>Los siguientes documentos no pertenecen a un mismo proyecto</b><br>";
//                                foreach ($resultados as $value) {
//                                    $val .= "<br>" . $value->documentos . ".";
//                                }
//                                $val .= " <br><br> Por favor verifique que los documentos a radicar pertenezcan al mismo proyecto ";
//                                $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
//                                $band = false;
//                                if (!$band) {
//                                    echo $msg;
//                                    die();
//                                } else {
//                                    return $band;
//                                }
//                            }
//                        }
                    }
                    return $band;
                }

                function migrarInformacion($separado_por_comas, $db, $fecha, $numRadicado, $arrDocumentosArchivo) {

                    $sql = "SELECT seqFormulario, numDocumento
                        FROM t_frm_formulario
                        INNER JOIN t_frm_hogar hog USING (seqFormulario)
                        INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                        INNER JOIN t_pry_proyecto pro USING(seqProyecto)
                        INNER JOIN t_pry_unidad_proyecto und using(seqFormulario)
                        INNER JOIN t_frm_estado_proceso USING(seqEstadoProceso)
                        WHERE seqEtapa IN(5) AND seqParentesco = 1
                        AND numDocumento IN(" . $separado_por_comas . ")";
                    $resultados = $db->get_results($sql);
                    $rows = count($resultados);
                    $documentos = "";
                    $cont = 0;
                    if ($rows > 0) {
                        $update = "UPDATE t_frm_formulario SET seqEstadoProceso = CASE seqFormulario";
                        $updateProy = "UPDATE t_pry_unidad_proyecto SET fchDevolucionExpediente = CASE seqFormulario";
                        $seguimiento = "INSERT INTO T_SEG_SEGUIMIENTO ( 
				seqFormulario, 
				fchMovimiento, 
				seqUsuario, 
				txtComentario,				
				numDocumento,				
				seqGestion,
                                bolMostrar
			 ) VALUES";
                        $seqFormularios = "";

                        foreach ($resultados as $value) {
                            $update .= " WHEN " . $value->seqFormulario . " THEN 15";
                            $updateProy .= " WHEN " . $value->seqFormulario . " THEN NOW()";
                            foreach ($arrDocumentosArchivo as $keyDoc => $valueDoc) {
                                //echo "<br>".$valueDoc;
                                $arrDoc = explode("\t", $valueDoc);
                                if ($arrDoc[0] == $value->numDocumento) {
                                    $seguimiento .= "(
				" . $value->seqFormulario . ",
				now(),
				" . $_SESSION['seqUsuario'] . ",
				 '" . $arrDoc[1] . "',
				" . $value->numDocumento . ",				
				81,
                                 1
			 ),";
                                }
                            }

                            $seqFormularios .= $value->seqFormulario . ", ";
                            $documentos .= $value->numDocumento . ",";
                            $cont++;
                        }
                        $seqFormularios = substr_replace($seqFormularios, '', -2, 1);
                        $documentos = substr_replace($documentos, '', -1, 1);
                        if (!empty($seguimiento)) {
                            $seguimiento = substr_replace($seguimiento, ';', -1, 1);
                        }

                        $update .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
                        $updateProy .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
                        if ($db->query($update)) {
                            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de estado de los siguientes documentos"
                            . $documentos . "</p>";
                        } else {
                            echo "<p class='alert alert-danger'>Hubo un error almodificar los estados de los documentos. Por favor consulte al administrador</p>";
                        }
                        $updateProy;
                        if (!empty($updateProy)) {
                            if ($db->query($updateProy)) {
                                echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de la fecha  de radicaci&oacute;n de los siguientes documentos: "
                                . $documentos . "</p>";
                            } else {
                                echo "<p class='alert alert-danger'>Hubo un error al modificar la fecha de la Radicaci&oacute;n. Por favor consulte al administrador</p>";
                            }
                        }
                        //echo "<br> seguimiento ->" . $seguimiento;
                        $db->query($seguimiento);
                    } else {
                        echo $msg = "<p class='alert alert-danger'>No existe unidades vinculadas</p>";
                        die();
                    }
                }
                ?>
                </body>
                </html>