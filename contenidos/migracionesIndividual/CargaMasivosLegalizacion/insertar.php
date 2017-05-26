<?php
include '../../../recursos/archivos/verificarSesion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->
        <link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    </head>
    <body>

        <div id="contenidos" class="container">
            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                Modulo Legalizaci&oacute;n Desembolsos
            </div>

            <div class="well">
                <?php
                include_once "../lib/mysqli/shared/ez_sql_core.php";
                include_once "../lib/mysqli/ez_sql_mysqli.php";
                include '../migrarTablero.php';

                function doc2form($numDocumento) { // Recibe el documento y devuelve el formulario asociado
                    global $db;
                    if (intval($numDocumento) != 0) { // Documento es diferente de 0
                        if (intval($numDocumento) != '') { // Documento es diferente de vacío
                            $query = $db->get_row("SELECT frm.seqFormulario
                                                    FROM T_FRM_FORMULARIO frm
                                                    INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                                                    INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                                                    WHERE ciu.numDocumento = $numDocumento");
                            return $query->seqFormulario;
                        }
                    } else {
                        return 0;
                    }
                }

                $error = "";
                $usuario = $_SESSION['seqUsuario'];
                $documentosSinUnidad = "";
                $listaFormularios = "";
                $listaDocumentosLegalizados = "";
                $listaFormulariosEstadoInvalido = "";
                $formularios = "";
                $updateMatricula = array();
                $listaFormulariosSinMatricula = "";
                $inicioSeguimiento = "INSERT INTO T_SEG_SEGUIMIENTO (seqFormulario, fchMovimiento, seqUsuario, txtComentario, txtCambios, numDocumento, txtNombre, seqGestion, bolMostrar) VALUES ";
                $archivo = $_FILES["archivo"];

                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);
                    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios', 'localhost');
                    $validar = obternerDocumentos($lineas, $db, 40, 29, "Estudio de Titulos Aprobado");
                    $registros = 0;

                    if ($validar) {
                        foreach ($lineas as $linea_num => $linea) {
                            $datos = explode("\t", $linea);
                            $formularioActual = doc2form(str_replace(",", "", str_replace(".", "", trim($datos [0]))));
                            if ($formularioActual == '' || $formularioActual == 0) {
                                $documentosSinUnidad .= trim($datos [0]) . ", ";
                            } else {
                                // Cedulas Legalizadas antes de ejecutar actualizacion
                                $formularioActualComa = $formularioActual . ", ";
                                $listaFormularios .= $formularioActualComa;
                                $queryLegalizado = $db->get_row("SELECT seqFormulario 
                                                                FROM T_PRY_UNIDAD_PROYECTO
                                                                WHERE seqFormulario = $formularioActual
                                                                AND bolLegalizado = 1");
                                if ($queryLegalizado->seqFormulario > 0) {
                                    $listaDocumentosLegalizados .= trim($datos [0]) . ", ";
                                }
                                // Verifica el estado inicial del formulario
                                $queryEstado = $db->get_row("SELECT seqEstadoProceso
                                                        FROM T_FRM_FORMULARIO
                                                        WHERE seqFormulario = $formularioActual");
                                if ($queryEstado->seqEstadoProceso != 29) { // Estado diferente a Estudio de Títulos Aprobado (29)
                                    $listaFormulariosEstadoInvalido .= trim($datos [0]) . ", ";
                                }
                                // Verifica la matricula inmobiliaria de la escrituracion
                                $queryMatricula = $db->get_row("SELECT txtMatriculaInmobiliaria
                                                            FROM T_DES_ESCRITURACION
                                                            WHERE seqFormulario = $formularioActual");
                                if ($queryMatricula->txtMatriculaInmobiliaria != '') { // Si tiene matricula, arma el update en T_PRY_UNIDAD_PROYECTO
                                    $updateMatricula[] = "UPDATE T_PRY_UNIDAD_PROYECTO SET bolLegalizado = 1, fchLegalizado = NOW(), txtMatriculaInmobiliaria = '" . $queryMatricula->txtMatriculaInmobiliaria . "' WHERE seqFormulario = " . $formularioActual . ";";
                                    $formularios .= $formularioActual . ", ";
                                } else {
                                    $listaFormulariosSinMatricula .= trim($datos [0]) . ", ";
                                }
                                // Consulta el nombre del postulante principal
                                $documento = trim($datos [0]);
                                $queryNombrePostulante = $db->get_row("SELECT CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS nombrePpal FROM T_CIU_CIUDADANO WHERE numDocumento = $documento");
                                $nombrePpal = $queryNombrePostulante->nombrePpal;
                                $contenidoSeguimiento .= "($formularioActual, NOW(), $usuario, 'Subsidio Legalizado teniendo en cuenta que se cumple con lo establecido en el numeral 4 del Artículo 5° de la Resolución 575 de 2015, que modifica la Resolución 844 de 2014', '<b>[ $formularioActual ] Cambios en el formulario</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;seqEstadoProceso, Valor Anterior: 29, Valor Nuevo: 40', " . $documento . ", '" . $nombrePpal . "', 46, 1), ";
                            }
                            $registros++;
                        }

                        $formularios = substr($formularios, 0, -2); // Formularios separados por coma para cambio de estado
                        $queryCambioEstado = "UPDATE T_FRM_FORMULARIO SET seqEstadoProceso = 40 WHERE seqFormulario IN ($formularios)";
                        $contenidoSeguimiento = substr($contenidoSeguimiento, 0, -2);
                        $documentosSinUnidad = substr($documentosSinUnidad, 0, -2);
                        $listaFormulariosSinMatricula = substr($listaFormulariosSinMatricula, 0, -2);
                        $querySeguimientos = $inicioSeguimiento . $contenidoSeguimiento . ";";
                        $listaFormularios = substr($listaFormularios, 0, -2); // Quita la última coma de la lista de formularios
                        $listaDocumentosLegalizados = substr($listaDocumentosLegalizados, 0, -2); // Quita la última coma de la lista de formularios
                        $listaFormulariosEstadoInvalido = substr($listaFormulariosEstadoInvalido, 0, -2); // Quita la última coma de la lista de formularios

                        if ($listaDocumentosLegalizados != '') { // Si hay documentos que presenten legalización, muestra error y no actualiza
                            $error .= "<p class='alert alert-danger'><strong>No se pudieron subir las legalizaciones, los siguientes documentos ya se encontraban legalizados: </strong>" . $listaDocumentosLegalizados . ".</p>";
                        }
                        if ($documentosSinUnidad != '') { // Documentos que no existan en la tabla de unidades, muestra error y no actualiza
                            $error .= "<p class='alert alert-danger'>No se pudieron subir las legalizaciones, los siguientes documentos no tienen una unidad asignada: <strong>" . $documentosSinUnidad . "</strong>.</p>";
                        }
                        if ($listaFormulariosEstadoInvalido != '') { // Documentos con estado diferente a Estudio de Títulos Aprobado (29), muestra error y no actualiza
                            $error .= "<p class='alert alert-danger'>No se pudieron subir las legalizaciones, los siguientes documentos no tienen un estado v&aacute;lido: <strong>" . $listaFormulariosEstadoInvalido . "</strong>.</p>";
                        }
                        if ($listaFormulariosSinMatricula != '') { // Si hay documentos que no tienen una matricula en la escrituracion, muestra error y no actualiza
                            $error .= "<p class='alert alert-danger'>No se pudieron subir las legalizaciones, los siguientes documentos no tienen una matr&iacute;cula inmobiliaria asociada: <strong>" . $listaFormulariosSinMatricula . "</strong>.</p>";
                        }

                        if ($error == '') {
                            foreach ($updateMatricula AS $consulta) {
                                $db->query($consulta);
                            }
                            $db->query($queryCambioEstado);
                            $db->query($querySeguimientos);
                            echo "<br><p class='alert alert-success'>Los $registros registros se legalizaron</p>";
                        } else {
                            echo $error;
                        }
                        migrarInformacion($separado_por_comas, $db, 40, 29);
                    }
                } else {
                    echo "<p class='alert alert-danger'>Error en la carga del archivo</p>";
                }
                ?>
                <p align="center"><a href="javascript:history.back(1)" class="btn btn-primary" role="button">Volver</a></p>
            </div>
        </div> <!-- /container -->

    </body>
</html>