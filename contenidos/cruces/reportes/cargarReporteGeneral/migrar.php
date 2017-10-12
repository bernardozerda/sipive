<?php
$txtPrefijo = '../../../../';
$txtPrefijoRuta = "../../../../";
include $txtPrefijo . 'recursos/archivos/lecturaConfiguracion.php';
include $txtPrefijo . 'librerias/clases/Cruces.class.php';
include( $txtPrefijo . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Estilos CSS -->
        <link href="<?php echo $txtPrefijo ?>librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $txtPrefijo ?>librerias/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $txtPrefijo ?>librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
              
    </head>
    <body>

        <div id="contenidos" class="container">
            <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
                M&oacute;dulo De Cargue de Informe General de Cruces
            </div>

            <div class="well">
                <?php
                date_default_timezone_set('America/Bogota');
                $arrDocumentosArchivo = array();
                $cruces = new Cruces();
                $user = 414;


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


                if ($_POST['fchCruce'] == "") {
                    exit('Debe seleccionar una fecha de cruce. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                if ($_POST['nombreGrupoCruce'] == "") {
                    exit('Debe ingresar un nombre de Grupo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }

                $date = date_create($_POST['fchCruce']);
                $fecha = date_format($date, 'Y-m-d h:i:s');

                $nombreGrupo = $_POST['nombreGrupoCruce'];

                $separado_por_comas = implode(",", $arrDocumentosArchivo);

                $nombreCruce = $cruces->validarCruceExiste($nombreGrupo, $fecha);
                if ($nombreCruce) {
                    $validar = $cruces->validarDocumentos($separado_por_comas);

                    if ($validar) {
                        $formularios = $cruces->obtenerFormularios($separado_por_comas);
                    }
                    if ($formularios != "") {
                        $insertarGrupo = $cruces->insertarReporteGrupo($nombreGrupo);

                        if ($insertarGrupo > 0) {
                            $insertarRegistros = $cruces->insertarReporteGeneral($formularios, $fecha, $insertarGrupo, $user);
                            if ($insertarRegistros > 0) {

                                echo "<p class='alert alert-success'><b>Los datos se almacenaron con  éxito!!!</b><br><br> ";
                                echo "En total se insertaron " . $insertarRegistros . " Registros!!!</p> ";
                                die();
                            } else {
                                echo "<p class='alert alert-danger'>No se inserto ningun registro por favor comuniquese con el administrador del sistema </p>";
                                die();
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>