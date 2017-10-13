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
                $arrayAfiliados = Array();
                $cruces = new Cruces();
                $user = 414;


                if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $nombreArchivo = $_FILES['archivo']['tmp_name'];
                    $lineas = file($nombreArchivo);

                    foreach ($lineas as $linea_num => $linea) {
                        $data = explode("\t", $linea);
                        // echo "****". $linea_num ."== 0 &&". strtoupper($data[0])." != 'DOCUMENTO' || ".strtoupper($data[1])." != 'ENTIDAD'";                       die();
                        if ($linea_num == 0 && strtoupper($data[0]) != 'DOCUMENTO' && strtoupper($data[1]) != 'ENTIDAD') {
                            echo "El archivo debe contener los titulos DOCUMENTO Y ENTIDAD";
                            $die();
                        } else if ($linea_num > 0) {
                            if (!empty($linea)) {

                                $arrayAfiliados['Documento'][$linea_num] = $data[0];
                                $arrayAfiliados['Entidad'][$linea_num] = $data[1];
                            }
                        }
                    }
                } else {
                    exit('debe seleccionar un archivo. <img border="0" src="../lib/back.png" width="30" height="30" style="cursor: pointer" onClick="history.back()">Volver');
                }
                $validar = $cruces->validarDocumentosAfiliados($arrayAfiliados['Documento'], 1);
                if ($validar) {
                    //var_dump($arrayAfiliados);
                    $insertarCruces = $cruces->InsertarCruces($arrayAfiliados, 1);
                }
                ?>
            </div>
        </div>
    </body>
</html>