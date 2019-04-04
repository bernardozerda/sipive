<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../librerias/jquery/css/bootstrap.min.css"/> 
    <link href="../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet" />        
    <link href="../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />   
</head>
<?php
ini_set('memory_limit', '-1');
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
$claReporte = new Reportes();

$tipo = $_FILES['archivo']['type'];
$tamanio = $_FILES['archivo']['size'];
$archivotmp = $_FILES['archivo']['tmp_name'];
//Se Carga el archivo
$lineas = file($archivotmp);

$i = 0;
$identificador = "";

$sqlDelete = "DELETE FROM t_frm_reporte_gral WHERE seqReporteHogar in (";
$sqlInsert = "INSERT INTO t_frm_reporte_gral VALUES ";
$band = true;
$insert = "";
$seqReporte = "";
$valDoc = "";
?>
<body>
    <div id="contenidos" class="container">
        <center>
            <div id="mensajes">
            </div>
        </center>
        <div class="thumbnail" style="min-height: 500px; ">
            <div class="caption">
                <?php
                //Recorremos el bucle para leer línea por línea

                if (count($lineas) < 5000) {
                    foreach ($lineas as $linea_num => $linea) {
                        $documento = 0;
                        $sql = "SELECT * FROM t_frm_reporte_gral where ";
                        $datos = explode("\t", $linea);
                        //abrimos bucle
                        /* si es diferente a 0 significa que no se encuentra en la primera línea 
                          (con los títulos de las columnas) y por lo tanto puede leerla */
                        if ($i == 0 && count($datos) != 103) {
                            echo "El archivo no cumple con las columnas requeridas!! " . count($datos);
                            die();
                        } else if ($i > 0) {
                            //  echo "<br><br>" . $key . " - " . $linea;
                            // var_dump($datos);
                            $insert = "(";
                            foreach ($datos as $key => $value) {
                                if ($key == 0) {
                                    $seqReporte .= $value . ",";
                                    $posicion = $value;
                                    $sql .= " seqReporteHogar = " . $value;
                                } else if ($key == 5) {
                                    $documento = $value;
                                    $sql .= " and DocumentoCiudadano = " . $value . " and  txtNombreReporte = '" . $_POST['name'] . "'";
                                }
                                // echo "<br> ".$key." -> ".$value."<br>";

                                if ($key == 13 || $key == 37 || $key == 40 || $key == 42 || $key == 82 || $key == 101) {//
                                    if (count(explode("/", $value)) == 3) {//
                                        $value = str_replace('/', '-', $value);
                                        $value = date('Y-m-d', strtotime($value));
                                    }
                                    $insert .= "'" . $value . "',";
                                    // echo "<br> " . $key . " -> " . $value . "<br>";
                                } else {
                                    //   echo "<br> " . $key . " -> " . $value . "<br>";
                                    $insert .= is_numeric($value) ? $value . "," : "'" . utf8_encode(trim($value)) . "',";
                                }
                                // $insert .= is_numeric($value) ? $value . "," : "'" . utf8_encode(trim($value)) . "',";
                                if ($key == 102) {
                                    $insert = substr_replace($insert, '', -1, 1);
                                    $insert .= "),";
                                }
                            }
                            $sqlInsert .= $insert;
                            //  echo  $sqlInsert."<br><br>";
                            $validar = $claReporte->obtenerReportesGral($sql);
                            // echo "<br>Validar - > " . $validar . "<br>";
                            if (!$validar) {
                                $valDoc .= "El registro " . $posicion . " con N° de documento " . $documento . " del reporte " . $_POST['name'] . " No coinciden con los previamente registrados<br>";
                                $band = false;
                            }
                        }
                        /* Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
                          entraremos en la condición, de esta manera conseguimos que no lea la primera línea. */
                        $i++;
                        //cerramos bucle
                    }


                    //echo "<br>band *** " . $band;


                    if ($band) {

                        $seqReporte = substr_replace($seqReporte, '', -1, 1);
                        $sqlDelete .= $seqReporte . ");";
//                    echo "<p>**" . $sqlDelete . " </p><br>";
//                    
//                    echo "<br><p>".$sqlInsert."</p>";
//                    die();

                        $deleteVal = $claReporte->obtenerReportesGral($sqlDelete);
                        if ($deleteVal) {
                            $sqlInsert = substr_replace($sqlInsert, ';', -1, 1);
                            $band = $claReporte->obtenerReportesGral($sqlInsert);
                            // echo "<br> -***** -".$band;
                            if (!$band) {
                                echo '<div class = "alert alert-danger" role = "alert">Hubo un error al insertar '
                                . '<a class="btn btn-info btn-lg" onclick=""  href="./listadoReportesGral.php"><span class="glyphicon glyphicon-download-alt" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a></div> ';
                            } else {
                                echo '<div class = "alert alert-success" role = "alert">El reporte Se modifico correctamente</div> ';
                                // echo "<script>location.href='./listadoReportesGral.php'</script>";
                                //echo "<script>$('.modal-backdrop.fade').hide(); console.log('pasoo')</script>";
                            }
                        }
                    } else {
                        echo ' <div class = "alert alert-danger" role = "alert">
                    El reporte tiene problemas con los siguientes Documentos &nbsp;&nbsp;<a class="btn btn-info btn-lg" onclick="location.href="  href="#"><span class="glyphicon glyphicon-level-up" aria-hidden="true" style="cursor: pointer; text-align: center">&nbsp;Volver</span>Volver</a>
                    </div><h5>' . $valDoc . '</h5>';
                        // echo "<p><b>**** El reporte tiene problemas con los siguientes Documentos  ****** </b></p> " . $valDoc;
                    }
                } else {
                    echo '<div class = "alert alert-danger" role = "alert">El reporte excede el limite permitido de 5000 Registros</div> ';
                }
                ?>
            </div>
        </div>
    </div>