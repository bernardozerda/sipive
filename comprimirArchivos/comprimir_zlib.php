<?php
require('zipArchive.lib.php'); 
$zip = new ZipArchive();

$filename = '31DIC2014.zip';
$archivo = '../../sipive_bck/sipiveWed12312014.sql';

if ($zip->open($filename, ZIPARCHIVE::CREATE) === true) {
    $zip->addFile($archivo);

    $zip->close();
    echo 'Creado ' . $filename;
} else {
    echo 'Error creando ' . $filename;
}
?>
