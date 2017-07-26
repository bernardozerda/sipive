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



                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);
                    foreach ($lineas as $linea_num => $linea) {
                        $linea = str_replace("\n", "", $linea);
                        $linea = str_replace("\r", "", $linea);
                        $linea = str_replace("\t", " ", $linea);
                        if (!empty($linea)) {
                            array_push($arrDocumentosArchivo, trim($linea));
                        }
                    }
                } else {
                    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                $rad = explode("-", $_POST['numRadicado']);

                if ($_POST['fchRadicado'] == "") {
                    exit('Debe seleccionar una fecha de radicado. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                if ($_POST['numRadicado'] == "") {
                    exit('Debe seleccionar un número de radicado. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                if (count($rad) != 3) {
                    exit('El formato del número de radicado debe ser X-XX-XXXX <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }

                $date = date_create($_POST['fchRadicado']);
                $fecha = date_format($date, 'Y-m-d h:i:s');

                $numRadicado = $_POST['numRadicado'];
                //var_dump($arrDocumentosArchivo);

                $separado_por_comas = implode(",", $arrDocumentosArchivo);
                $validar = validarDocumentos($separado_por_comas, $db);
                if ($validar) {
                    migrarInformacion($separado_por_comas, $db, $fecha, $numRadicado);
                }

                // Valida si el documento cumple con los requisitos para ejecutar el cambio de estado y actualizar la fecha de radicación 
                function validarDocumentos($separado_por_comas, $db) {
                    global $db;
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
                            $val .= "<br>" . $value->numdocumento . ".";
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
                            WHERE seqEstadoProceso NOT IN(15)
                            and numDocumento IN(" . $separado_por_comas . ")";
                        $resultados = $db->get_results($sql);
                        $rows = count($resultados);
                        if ($rows > 0) {
                            $val = "<b>Los siguientes documentos no tienen el estado de Asignaci&oacute;n-Asignado</b><br>";
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
                            //Está consulta válida que los documentos pertenezcan a un mismo proyecto
                            $sql = "SELECT seqFormulario,
                                    seqProyecto,
                                    txtNombreProyecto,
                                    GROUP_CONCAT(numDocumento,' del proyecto ', ucwords(txtNombreProyecto) SEPARATOR '<br> ') AS 'documentos'
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                                    INNER JOIN t_pry_proyecto pro USING(seqProyecto)
                                    WHERE ciu.numDocumento IN (" . $separado_por_comas . ")      
                                    GROUP BY seqFormulario,
                                    seqProyecto,
                                    txtNombreProyecto";
                            $resultados = $db->get_results($sql);
                            $rows = count($resultados);
                            if ($rows > 1) {
                                $val = "<b>Los siguientes documentos no pertenecen a un mismo proyecto</b><br>";
                                foreach ($resultados as $value) {
                                    $val .= "<br>" . $value->documentos . ".";
                                }
                                $val .= " <br><br> Por favor verifique que los documentos a radicar pertenezcan al mismo proyecto ";
                                $msg = "<p class='alert alert-danger'>" . ucfirst($val) . "</p>";
                                $band = false;
                                if (!$band) {
                                    echo $msg;
                                    die();
                                } else {
                                    return $band;
                                }
                            }
                        }
                    }
                    return $band;
                }

                function migrarInformacion($separado_por_comas, $db, $fecha, $numRadicado) {
                    global $db;
                    $sql = "SELECT seqFormulario, numDocumento
                        FROM t_frm_formulario
                        INNER JOIN t_frm_hogar hog USING (seqFormulario)
                        INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                        INNER JOIN t_pry_proyecto pro USING(seqProyecto)
                        WHERE seqEstadoProceso IN(15) AND seqParentesco = 1
                        AND numDocumento IN(" . $separado_por_comas . ")";
                    $resultados = $db->get_results($sql);
                    $rows = count($resultados);
                    $documentos = "";
                    $cont = 0;
                    if ($rows > 0) {
                        $update = "UPDATE t_frm_formulario SET seqEstadoProceso = CASE seqFormulario";
                        //$updateProy = "UPDATE t_pry_unidad_proyecto SET fchRadicacion = CASE seqFormulario";
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
                            $update .= " WHEN " . $value->seqFormulario . " THEN 62";
                            // $updateProy .= " WHEN " . $value->seqFormulario . " THEN '" . $fecha . "'";
                            $seguimiento .= "(
				" . $value->seqFormulario . ",
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"RADICACION EXPEDIENTES PARA LEGALIZACION SDVE CON NUMERO DE RADICADO- " . $numRadicado . "- FECHA - " . $fecha . "\",
				" . $value->numDocumento . ",				
				5,
                                 1
			 ),";
                            $seqFormularios .= $value->seqFormulario . ",";
                            $documentos .= $value->numDocumento . ",";
                            $cont++;
                        }
                        $seqFormularios = substr_replace($seqFormularios, '', -1, 1);
                        $documentos = substr_replace($documentos, '', -1, 1);
                        if (!empty($seguimiento)) {
                            $seguimiento = substr_replace($seguimiento, ';', -1, 1);
                        }

                        $update .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";

                        if( esFechaValida( $fecha ) ){
                            $fecha = "'" . $fecha . "'";
                        }else{
                            $fecha = "NULL";
                        }

                        $updateRad = "UPDATE t_pry_unidad_proyecto SET fchRadicacion = " . $fecha . ", txtRadicadoForest = '" . $numRadicado . "' WHERE seqFormulario IN (" . $seqFormularios . ")";

                        if ($db->query($update)) {
                            $documentos = str_replace(",", "<br>", $documentos);
                            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de estado de los siguientes documentos"
                            . $documentos . "</p>";
                        } else {
                            echo "<p class='alert alert-danger'>Hubo un error al modificar los estados de los documentos. Por favor consulte al administrador</p>";
                        }
                        if (!empty($updateRad)) {
                            if ($db->query($updateRad)) {
                                $documentos = str_replace(",", "<br>", $documentos);
                                echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de la fecha  de radicaci&oacute;n de los siguientes documentos: "
                                . $documentos . "</p>";
                            } else {
                                echo "<p class='alert alert-danger'>Hubo un error al modificar la fecha de la Radicaci&oacute;n. Por favor consulte al administrador</p>";
                            }
                        }
                        // echo "<br> seguimiento ->" . $seguimiento;
                        $db->query($seguimiento);
                    }
                }
                ?>
                </body>
                </html>