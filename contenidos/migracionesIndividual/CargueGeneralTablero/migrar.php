<?php
include '../../../recursos/archivos/verificarSesion.php';

$code = $_GET['code'];
$titulo = "";
$estadoV = 0;
$estadoT = "";
if (isset($code)) {
    if ($code == 17) {
        $titulo = "M&oacute;dulo Remisi&oacute;n Soluci&oacute;n";
        $estadoT = "Remisi&oacute;n Datos Soluci&oacute;n";
        $estadoV = 62;
    }
    if ($code == 22) {
        $titulo = "M&oacute;dulo Remisi&oacute;n Informaci&oacute;n Escrituraci&oacute;n";
        $estadoT = "Remisi&oacute;n Informaci&oacute;n Escrituraci&oacute;n";
        $estadoV = 19;
    }
    if ($_GET['code'] == 26) {
        $titulo = "Generaci&oacute;n Certificado Habitabilidad";
        $estadoT = "Revisión Técnica Aprobada";
        $estadoV = 25;
    }
    if ($_GET['code'] == 27) {
        $titulo = "Remisi&oacute;n Estudio de Titulos";
        $estadoT = "Escrituraci&oacute;n";
        $estadoV = 26;
    }
    if ($_GET['code'] == 29) {
        $titulo = "Conformación Definitiva Documentaci&oacute;n";
        $estadoT = "Estudio de Titulos Aprobado";
        $estadoV = 31;
    }
}
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
                <?= $titulo ?>
            </div>

            <div class="well">
                <?php
                include "../lib/mysqli/shared/ez_sql_core.php";
                include "../lib/mysqli/ez_sql_mysqli.php";

                date_default_timezone_set('America/Bogota');
                $arrDocumentosArchivo = array();
                $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios', 'localhost');


                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);
                    foreach ($lineas as $linea_num => $linea) {
                        array_push($arrDocumentosArchivo, trim($linea));
                    }
                } else {
                    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                //var_dump($arrDocumentosArchivo);

                $separado_por_comas = implode(",", $arrDocumentosArchivo);
                $validar = validarDocumentos($separado_por_comas, $db, $code, $estadoV, $estadoT);
                if ($validar) {
                    migrarInformacion($separado_por_comas, $db, $code, $estadoV);
                }

                // Valida si el documento cumple con los requisitos para ejecutar el cambio de estado y actualizar la fecha de radicación 
                function validarDocumentos($separado_por_comas, $db, $code, $estadoV, $estadoT) {

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
                        //Está consulta válida que los números no tengán un estado diferente al estado proceso
                        $sql = "SELECT numdocumento, seqProyecto FROM t_frm_formulario
                            INNER JOIN t_frm_hogar hog USING (seqFormulario)
                            INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                            WHERE seqEstadoProceso NOT IN(" . $estadoV . ")
                            and numDocumento IN(" . $separado_por_comas . ")";
                        $resultados = $db->get_results($sql);
                        $rows = count($resultados);
                        if ($rows > 0) {
                            $val = "<b>Los siguientes documentos no tienen el estado de " . $estadoT . "</b><br>";
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
                        }
                    }
                    return $band;
                }

                /*                 * ********************************* Función Cambios de estado  ******************************************* */

                function migrarInformacion($separado_por_comas, $db, $code, $estadoV) {

                    $datos = datosEstado($separado_por_comas, $db, $code, $estadoV);

                    $sql = $datos[0];
                    $resultados = $db->get_results($sql);
                    $rows = count($resultados);
                    $documentos = "";
                    $cont = 0;
                    if ($rows > 0) {
                        $update = "UPDATE t_frm_formulario SET seqEstadoProceso = CASE seqFormulario";
                        $updateProy = $datos[1];
                        $seguimiento = "INSERT INTO T_SEG_SEGUIMIENTO ( 
				seqFormulario, 
				fchMovimiento, 
				seqUsuario, 
				txtComentario,				
				numDocumento,
                                txtNombre,
				seqGestion,
                                bolMostrar
			 ) VALUES";
                        $seqFormularios = "";

                        foreach ($resultados as $value) {
                            $update .= " WHEN " . $value->dato . " THEN " . $code . "";
                            $updateProy .= " WHEN " . $value->dato . " THEN NOW()";
                            $seguimiento .= "(
				" . $value->dato . ",
				now(),
				" . $_SESSION['seqUsuario'] . ",
				\"" . $datos[3] . "\",
				" . $value->numDocumento . ",
                                    '" . $value->nombre . "',
				" . $datos[2] . ",
                                 1
			 ),";
                            $seqFormularios .= $value->dato . ", ";
                            $documentos .= $value->numDocumento . ",";
                            $cont++;
                        }
                        $seqFormularios = substr_replace($seqFormularios, '', -2, 1);
                        $documentos = substr_replace($documentos, '', -1, 1);
                        //echo "<br>2. ****" . $seguimiento . "<br>";
                        if (!empty($seguimiento)) {
                            $seguimiento = substr_replace($seguimiento, ';', -1, 1);
                        }
                        $update .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
                        $updateProy .= " END WHERE seqFormulario IN (" . $seqFormularios . ")";
                        // echo $update;                        die();
                        if ($db->query($update)) {
                            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de estado de los siguientes documentos"
                            . $documentos . "</p>";
                        } else {
                            echo "<p class='alert alert-danger'>Hubo un error almodificar los estados de los documentos. Por favor consulte al administrador</p>";
                        }
                        if ($db->query($updateProy)) {
                            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la modificaci&oacute;n de la fecha  de radicaci&oacute;n de los siguientes documentos"
                            . $documentos . "</p>";
                        } else {
                            echo "<p class='alert alert-danger'>Hubo un error al modificar la fecha de la Radicaci&oacute;n. Por favor consulte al administrador</p>";
                        }
                        echo "<br> seguimiento ->" . $seguimiento;

                        if ($db->query($seguimiento)) {
                            echo "<p class='alert alert-success'>En total se modifico " . $cont . " registros <br><br>Se realiz&oacute; la inserci&oacute;n de seguimiento de los siguientes documentos";
                        } else {
                            echo "<p class='alert alert-danger'>Hubo un error al insertar el seguimiento. Por favor consulte al administrador</p>";
                        }
                    }
                }

                function datosEstado($separado_por_comas, $db, $code, $estadoV) {
                    $datos = Array();
                    if ($code == 17) {
                        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                            CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                    
                                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                                    AND numDocumento IN(" . $separado_por_comas . ")";

                        $datos[1] = "UPDATE t_pry_unidad_proyecto SET fchInformacionSolucion  = CASE seqFormulario";
                        $datos[2] = 52;
                        $datos[3] = "DEFICION EXPEDIENTES A LEGALIZAR";
                    }
                    if ($code == 22) {
                        $datos[0] = "SELECT seqFormulario as dato, numDocumento, 
                            CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)
                                    INNER JOIN t_des_desembolso des USING(seqFormulario)                                    
                                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                                    AND numDocumento IN(" . $separado_por_comas . ")";

                        $datos[1] = "UPDATE t_des_desembolso SET fchCreacionEscrituracion  = CASE seqFormulario";
                        $datos[2] = 52;
                        $datos[3] = "ENTREGA DATOS ESCRITURACION";
                    }
                    if ($code == 26) {
                        $datos[0] = "SELECT seqFormulario as dato, numDocumento,
                            CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                                                      
                                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                                    AND numDocumento IN(" . $separado_por_comas . ")";

                        $datos[1] = "UPDATE t_des_tecnico tec LEFT JOIN t_des_desembolso des USING (seqDesembolso) SET tec.fchActualizacion = CASE seqFormulario";
                        $datos[2] = 69;
                        $datos[3] = "CERTIFICADOS DE EXISTENCIA Y HABITABILIDAD GENERADO";
                    }
                    if ($code == 27) {
                        $datos[0] = "SELECT seqFormulario as dato, numDocumento,
                            CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                                                      
                                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                                    AND numDocumento IN(" . $separado_por_comas . ")";

                        $datos[1] = "UPDATE t_pry_unidad_proyecto SET fchInformacionTitulos = CASE seqFormulario";
                        $datos[2] = 16;
                        $datos[3] = "ENTREGA DATOS ESTUDIOS DE TITULOS";
                    }

                    if ($code == 29) {
                        $datos[0] = "SELECT seqFormulario as dato, numDocumento,
                            CONCAT(txtNombre1, ' ', txtNombre2, ' ', txtApellido1, ' ', txtApellido2) AS nombre
                                    FROM t_frm_formulario
                                    INNER JOIN t_frm_hogar hog USING (seqFormulario)
                                    INNER JOIN t_ciu_ciudadano ciu USING (seqCiudadano)                                                                      
                                    WHERE seqEstadoProceso IN(" . $estadoV . ") AND seqParentesco = 1
                                    AND numDocumento IN(" . $separado_por_comas . ")";

                        $datos[1] = "UPDATE t_des_tecnico  tec INNER JOIN t_des_desembolso des USING (seqDesembolso)
                                      inner join t_des_estudio_titulos tit using(seqDesembolso) SET tit.fchActualizacion = CASE seqFormulario";
                        $datos[2] = 75;
                        $datos[3] = "EST TITULOS APROBADO. TRASLADO DOCUMENTACION PARA LEGALIZACION";
                    }
                    return $datos;
                }
                ?>
                </body>
                </html>