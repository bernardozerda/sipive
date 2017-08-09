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
                Migraci&oacute;n a Informaci&oacute;n de la Soluci&oacute;n
            </div>
            <div class="well">
                <?php
                include '../conecta.php';
                include '../migrarTablero.php';

                function fechaCorrecta($fecha) {
                    $fecha = str_replace(',', '.', $fecha);
                    if (is_numeric($fecha)) { // Si la fecha es númerica
                        $nuevaFecha = date("Y-m-d H:i:s", $fecha);
                    } else if (strpos($fecha, '/')) { // Si la fecha está separada por slash
                        $nuevaFecha = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $fecha)));
                    } else if (strpos($fecha, '-')) { // Si la fecha es correcta
                        $nuevaFecha = $fecha;
                    }
                    return $nuevaFecha;
                }

                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $arrFormularioArchivo = array();
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);
                    $registros = 0;

                    global $db;
                    // Recorre las líneas del archivo
                    $error = "";
                    $queryUpdate = array();
                    // GUIA CAMPOS -> (0) seqDesembolso (1) seqFormulario (2) txtNombreVendedor (3) numDocumentoVendedor (4) txtDireccionInmueble (5) txtBarrio (6) seqLocalidad (7) txtEscritura (8) numNotaria (9) fchEscritura (10) txtMatriculaInmobiliaria (11) bolViabilizoJuridico (12) bolviabilizoTecnico (13) txtChip (14) seqTipoDocumento (15) txtCompraVivienda (16) txtTipoPredio (17) numTelefonoVendedor (18) txtCedulaCatastral (19) txtTipoDocumentos (20) numEstrato (21) txtCiudad (22) fchCreacionBusquedaOferta (23) fchActualizacionBusquedaOferta (24) txtPropiedad (25) txtCorreoVendedor (26) seqCiudad (27) seqAplicacionSubsidio (28) seqProyectosSoluciones (29) Descripcion de la Unidad
                    $encabezado = array('seqDesembolso', 'seqFormulario', 'txtNombreVendedor', 'numDocumentoVendedor', 'txtDireccionInmueble', 'txtBarrio', 'seqLocalidad', 'txtEscritura', 'numNotaria', 'fchEscritura', 'txtMatriculaInmobiliaria', 'bolViabilizoJuridico', 'bolviabilizoTecnico', 'txtChip', 'seqTipoDocumento', 'txtCompraVivienda', 'txtTipoPredio', 'numTelefonoVendedor', 'txtCedulaCatastral', 'txtTipoDocumentos', 'numEstrato', 'txtCiudad', 'fchCreacionBusquedaOferta', 'fchActualizacionBusquedaOferta', 'txtPropiedad', 'txtCorreoVendedor', 'seqCiudad', 'seqAplicacionSubsidio', 'seqProyectosSoluciones', 'Descripcion de la Unidad');

                    $queryInsert = "";
                    foreach ($lineas as $linea_num => $linea) { // RECORRE LAS LINEAS DEL ARCHIVO
                        $datos = explode("\t", $linea);
                        if ($linea == 0) { // Validar que los encabezados estén correctos
                            for ($i = 0; $i <= 29; $i++) {
                                if ($encabezado[$i] != trim($datos [$i])) { // Compara el encabezado del archivo contra el arreglo de encabezados
                                    $error .= "Nombre errado para el encabezado '" . trim($datos [$i]) . "', debe llamarse '" . $encabezado[$i] . "'.<br>";
                                }
                            }
                        } else { // Encabezados correctos -> Se procede a validar datos
                            array_push($arrFormularioArchivo, trim($datos[1]));
                            $seqFormulario = trim($datos[1]);
                            $txtNombreVendedor = trim($datos[2]);
                            $numDocumentoVendedor = trim($datos[3]);
                            $txtBarrio = trim($datos[5]);
                            $seqLocalidad = trim($datos[6]);
                            $txtEscritura = trim($datos[7]);
                            $numNotaria = trim($datos[8]);
                            $fchEscritura = fechaCorrecta($datos[9]);
                            $txtMatriculaInmobiliaria = trim($datos[10]);
                            $bolViabilizoJuridico = trim($datos[11]);
                            $bolviabilizoTecnico = trim($datos[12]);
                            $txtChip = trim($datos[13]);
                            $seqTipoDocumento = trim($datos[14]);
                            $txtCompraVivienda = trim($datos[15]);
                            $txtTipoPredio = trim($datos[16]);
                            $numTelefonoVendedor = trim($datos[17]);
                            $txtCedulaCatastral = trim($datos[18]);
                            $txtTipoDocumentos = trim($datos[19]);
                            $numEstrato = trim($datos[20]);
                            $txtCiudad = trim($datos[21]);
                            $fchCreacionBusquedaOferta = fechaCorrecta($datos[22]);
                            $fchActualizacionBusquedaOferta = fechaCorrecta($datos[23]);
                            $txtPropiedad = trim($datos[24]);
                            $txtCorreoVendedor = trim($datos[25]);
                            $seqCiudad = trim($datos[26]);
                            $seqAplicacionSubsidio = trim($datos[27]);
                            $seqProyectosSoluciones = trim($datos[28]);
                            $direccionUnidad = trim($datos[4]) . " " . trim($datos[29]); // Unifica los campos Dirección y unidad Residencial
                            // Verificar si el formulario actual tiene registro en T_DES_DESEMBOLSO
                            $qryVerificaDesembolso = $db->get_row("SELECT seqDesembolso FROM T_DES_DESEMBOLSO WHERE seqFormulario = $seqFormulario");
                            if ($qryVerificaDesembolso->seqDesembolso > 0) {

                                $queryUpdate[] = "UPDATE T_DES_DESEMBOLSO SET
                                                    txtNombreVendedor = '$txtNombreVendedor',
                                                    numDocumentoVendedor = '$numDocumentoVendedor',
                                                    txtBarrio = '$txtBarrio',
                                                    seqLocalidad = '$seqLocalidad',
                                                    txtEscritura = '$txtEscritura',
                                                    numNotaria = '$numNotaria',
                                                    fchEscritura = '$fchEscritura',
                                                    txtMatriculaInmobiliaria = '$txtMatriculaInmobiliaria',
                                                    bolViabilizoJuridico = '$bolViabilizoJuridico',
                                                    bolviabilizoTecnico = '$bolviabilizoTecnico',
                                                    txtChip = '$txtChip',
                                                    seqTipoDocumento = '$seqTipoDocumento',
                                                    txtCompraVivienda = '$txtCompraVivienda',
                                                    txtTipoPredio = '$txtTipoPredio',
                                                    numTelefonoVendedor = '$numTelefonoVendedor',
                                                    txtCedulaCatastral = '$txtCedulaCatastral',
                                                    txtTipoDocumentos = '$txtTipoDocumentos',
                                                    numEstrato = '$numEstrato',
                                                    txtCiudad = '$txtCiudad',
                                                    fchCreacionBusquedaOferta = '$fchCreacionBusquedaOferta',
                                                    fchActualizacionBusquedaOferta = '$fchActualizacionBusquedaOferta',
                                                    txtPropiedad = '$txtPropiedad',
                                                    txtCorreoVendedor = '$txtCorreoVendedor',
                                                    seqCiudad = '$seqCiudad',
                                                    seqAplicacionSubsidio = '$seqAplicacionSubsidio',
                                                    seqProyectosSoluciones = '$seqProyectosSoluciones',
                                                    txtDireccionInmueble = '$direccionUnidad'
                                            WHERE seqDesembolso = " . $qryVerificaDesembolso->seqDesembolso . ";";
                            } else {
                                $queryInsert .= "($seqFormulario, '$txtNombreVendedor', '$numDocumentoVendedor', '$txtBarrio', '$seqLocalidad', '$txtEscritura', '$numNotaria', '$fchEscritura', '$txtMatriculaInmobiliaria', '$bolViabilizoJuridico', '$bolviabilizoTecnico', '$txtChip', '$seqTipoDocumento', '$txtCompraVivienda', '$txtTipoPredio', '$numTelefonoVendedor', '$txtCedulaCatastral', '$txtTipoDocumentos', '$numEstrato', '$txtCiudad', '$fchCreacionBusquedaOferta', '$fchActualizacionBusquedaOferta', '$txtPropiedad', '$txtCorreoVendedor', '$seqCiudad', '$seqAplicacionSubsidio', '$seqProyectosSoluciones', '$direccionUnidad'), ";
                            }
                        }
                        $registros++;
                    } // FIN RECORRE LINEAS
                    // EJECUTA LOS INSERTS Y UPDATES
                    if ($error == "") { // Si no hay errores se ejecutan los queries
                        // INSERTS      
                         global $db;
                        $separado_por_comas = implode(",", $arrFormularioArchivo);
                        $validar = validarDocumentos($separado_por_comas, $db, 27, 17, "Remisión Datos Solución");
                        if ($queryInsert != '' && $validar) {
                            $segmentoInsert = "INSERT INTO T_DES_DESEMBOLSO (seqFormulario, txtNombreVendedor, numDocumentoVendedor, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, txtMatriculaInmobiliaria, bolViabilizoJuridico, bolviabilizoTecnico, txtChip, seqTipoDocumento, txtCompraVivienda, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, txtTipoDocumentos, numEstrato, txtCiudad, fchCreacionBusquedaOferta, fchActualizacionBusquedaOferta, txtPropiedad, txtCorreoVendedor, seqCiudad, seqAplicacionSubsidio, seqProyectosSoluciones, txtDireccionInmueble) VALUES ";
                          $queryInsert = $segmentoInsert . substr($queryInsert, 0, -2) . ";";
                            $db->query($queryInsert);
                        }
                        // UPDATES
                        foreach ($queryUpdate AS $consultaUpdate) {
                            $db->query($consultaUpdate);
                        }

                        //Se cambio de estado  19 a 27 por sol ING 31-07-2017
                        migrarInformacion($separado_por_comas, $db, 27, 17);
                        //migrarInformacion($separado_por_comas, $db, 19, 17);
                        //echo "<br><p class='alert alert-success'>Se migraron $registros registros a informaci&oacute;n de la soluci&oacute;n.</p>";
                    } else { // Si hay errores los muestra y no ejecuta nada
                        echo "<p class='alert alert-danger'>$error</p>";
                    }
                } else {
                    echo "<p class='alert alert-danger'>Por favor seleccione un archivo</p>";
                }
                ?>
                <p align="center"><a href="javascript:history.back(1)" class="btn btn-primary" role="button">Volver</a></p>
            </div>
        </div> <!-- /container -->
    </body>
</html>