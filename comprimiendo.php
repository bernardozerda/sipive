<?php
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
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
//$ultimoBackup = array_pop($arrArchivos);
//echo $ultimoBackup."<br>";

// Nombre del Archivo comprimido
$hoy = date( "Y-m-d" ); 
$ayer = date( "DmdY", strtotime( "-1 day", strtotime( $hoy ) ) );
//$filename = "../sdv/comprimirArchivos/backups/sipive".$ayer.".sql";
$filename = "sipive".$ayer.".sql";
echo "<b>Ultimo: " . $filename . "</b><br>";

// Areglo de Archivos a comprimir
//$files_to_zip = array($filename);
//var_dump($files_to_zip);

// Comprimiendo
/*create_zip($files_to_zip, $filename);
create_zip($files_to_zip);*/
//$destination = "/sdv/comprimirArchivos";
//echo "destination: " . $destination;
create_zip($filename);
?>