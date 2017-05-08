<head>
    <!-- Estilos CSS -->
    <link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
</head>
<?php
$txtPrefijoRuta = "../../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

# definimos la carpeta destino
$carpetaDestino = "../../../recursos/descargables/desembolso/";
$error ="";
$msn = "";
# si hay algun archivo que subir
if ($_FILES["archivo"]["name"][0]) {

    $archivo = $carpetaDestino . "" . $_FILES["archivo"]["name"][0];
    $nombreArchivo = $_FILES["archivo"]["name"][0];
    $totalArchivos = count(glob($carpetaDestino . "/{*.xls,*.xlsx}", GLOB_BRACE));

//var_dump($_FILES["archivo"]["name"][0]);        exit();
    # recorremos todos los arhivos que se han subido
    for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {

        # si es un formato de imagen
//        if ($_FILES["archivo"]["type"][$i] == "Excel/xlsx" || $_FILES["archivo"]["type"][$i] == "Excel/xls" || $_FILES["archivo"]["type"][$i] == "xlsx") {
        # si exsite la carpeta o se ha creado
        if (file_exists($carpetaDestino) || @mkdir($carpetaDestino)) {
            if (file_exists($archivo)) {
                $nombre = explode(".", $nombreArchivo);
                $archivoAbierto = fopen($archivo, 'r');
                fclose($archivoAbierto);
                rename($archivo, $carpetaDestino . "/" . $nombre[0] . "_" . $totalArchivos . "." . $nombre[1]);
            }

            $origen = $_FILES["archivo"]["tmp_name"][$i];
            $destino = $carpetaDestino . $_FILES["archivo"]["name"][$i];

            # movemos el archivo
            if (@move_uploaded_file($origen, $destino)) {
                $msn .= "<br>" . $_FILES["archivo"]["name"][$i] . " movido correctamente!";
            } else {
                $error .= "<br>No se ha podido mover el archivo: " . $_FILES["archivo"]["name"][$i];
            }
        } else {
            $error .=  "<br>No se ha podido crear la carpeta" . $user;
        }
//        } else {
//            echo "<br>" . $_FILES["archivo"]["name"][$i] . " - NO es excel (xls-xlsx)";
//        }
    }
} else {
    $error .=  "No existe Ningun archivo ";
}

?>
<?php if($error != ""){ ?>
<p class='alert alert-danger'><?=$error?></p>
<?php } ?>

<?php if($msn != ""){ ?>
<p class='alert alert-success'><?=$msn?></p>
<?php } ?>