<?php
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
$arrArchivos = ftp_nlist( $aptFTP , "." );
//chdir($dir);
$hoy = date( "Y-m-d" ); 
$ayer = date( "Ymd", strtotime( "-1 day", strtotime( $hoy ) ) );
// Ordenar por fecha modificación
array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_ASC, $files);
foreach($files as $filename){
	//echo "<li>".substr($filename, 0, -4)."</li>";
	$ultimo = substr($filename, 0, -4);
}
echo $ultimoBackup;
$ultimoBackup = $ultimo.".sql";
echo $ultimoBackup;
/*
// Comprimiendo el archivo
$zip = new ZipArchive();
$filename = "../../sipive".$ayer.".zip";
if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
	$zip->addFile($ultimoBackup);
	$zip->close();
	echo 'Creado '.$filename;
} else {
    echo 'Error creando '.$filename;
}*/
?>