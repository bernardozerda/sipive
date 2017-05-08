<?php
require('zipArchive.lib.php');
$zip = new ZipArchive();
// configuracion de las variables del servidor
$txtServidorFTP	= "10.114.63.2";
$txtPuertoFTP	= "2122";
$txtUsuarioFTP	= "usrhabitat";
$txtClaveFTP	= "usrhabitat";
$txtRutaFTP		= "sipive_bck";
// establecer una conexión básica
$aptFTP = ftp_connect( $txtServidorFTP , $txtPuertoFTP ); 
// iniciar una sesión con nombre de usuario y contraseña
$bolLogin = ftp_login( $aptFTP, $txtUsuarioFTP , $txtClaveFTP ); 
ftp_chdir( $aptFTP, $txtRutaFTP );
// enabling passive mode 
ftp_pasv( $aptFTP, true ); 
// obtiene el listado de archivos
$arrArchivos = ftp_nlist( $aptFTP , "-t ." );
//var_dump($arrArchivos);
$ultimoBackup = array_pop($arrArchivos);
echo $ultimoBackup."<br>";

// Comprimiendo el archivo
$hoy = date( "Y-m-d" ); 
$ayer = date( "Ymd", strtotime( "-1 day", strtotime( $hoy ) ) );
$filename = "sipive".$ayer.".zip";
//echo $filename."<br>";
$zip->open($filename,ZipArchive::CREATE);
$zip->addFile($ultimoBackup);
$zip->close();
/*if ($zip->open($filename, ZipArchive::CREATE) === true) {
	$zip->addFile($ultimoBackup);
	$zip->close();
	echo 'Creado '.$filename;
} else {
    echo 'Error creando '.$filename;
}*/
?>