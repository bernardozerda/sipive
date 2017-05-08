<?php
function create_zip($files = array(),$destination = '',$overwrite = false) {
	if(file_exists($destination) && !$overwrite) { return false; }
	$valid_files = array();
	if(is_array($files)) {
		foreach($files as $file) {
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	if(count($valid_files)) {
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		$zip->close();
		return file_exists($destination);
	} else {
		return false;
	}
}

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
var_dump($arrArchivos);
$ultimoBackup = array_pop($arrArchivos);
//echo $ultimoBackup."<br>";

// Nombre del Archivo comprimido
$hoy = date( "Y-m-d" ); 
$ayer = date( "Ymd", strtotime( "-1 day", strtotime( $hoy ) ) );
$filename = "sipive" . $ayer . ".zip";

// Areglo de Archivos a comprimir
$files_to_zip = array($ultimoBackup);

// Comprimiendo
create_zip($files_to_zip, $filename);
?>

