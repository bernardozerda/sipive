<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );	

	define( "LIMITE_TAMANO" , "205059" );
	
	$arrErrores = array();
	$arrMensajes = array();
 	
 	$arrExtensiones[] = "jpg";
 	$arrExtensiones[] = "jpeg";
 	$arrExtensiones[] = "gif";
 	$arrExtensiones[] = "png";
 	
	switch( $_FILES['archivo']['error'] ){
		case UPLOAD_ERR_INI_SIZE:
		  $arrErrores[] = "El archivo Excede el tamaño permitido de 200K";
		break;  
		case UPLOAD_ERR_FORM_SIZE:
		    $arrErrores[] = "El archivo Excede el tamaño permitido de 200K";
		break; 
		case UPLOAD_ERR_PARTIAL:
		  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
		break; 
		case UPLOAD_ERR_NO_FILE:
		  $arrErrores[] = "Debe especificar un archivo para cargar";
		break; 
	}
	
	// Validacion del tamaño
	if( $_FILES['archivo']['size'] > LIMITE_TAMANO ){
		$arrErrores[] = "El archivo Excede el tamaño permitido de 200K";
	}
	
	if( empty( $arrErrores ) ){
		$numPunto = strpos( $_FILES['archivo']['name'] , "." ) + 1;
		$numRestar = ( strlen( $_FILES['archivo']['name'] ) - $numPunto ) * -1; 
		
		$txtExtension = substr( $_FILES['archivo']['name'] , $numRestar );
		
		
		
		if( ! in_array( strtolower( $txtExtension ) , $arrExtensiones ) ){
			$arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
		}
	}
		
	if( empty( $arrErrores ) ){

		srand( time() );
		$txtNombre = rand( 0 , 99999 );
		$txtNombre = $_POST['seqFormulario'] . "_" . $txtNombre . "." . $txtExtension;
		
		$_POST['nombre'] = ( $_POST['nombre'] == "" )? $txtNombre : $_POST['nombre'] ;
		
		if( @move_uploaded_file( $_FILES['archivo']['tmp_name'] , $txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $txtNombre  ) ){
			$arrMensajes[] = "Archivo " . $_FILES['archivo']['name'] . " cargado";	
		}else{
			$arrErrores[] = "La imágen no se ha podido cargar";
		}
			
	}
	
	echo "<div id='nombreArchivoCargado' style='display:none'>$txtNombre</div>";
	echo "<div id='textoArchivoCargado' style='display:none'>" . $_POST['nombre'] . "</div>";
	imprimirMensajes( $arrErrores , $arrMensajes , "finCargarArchivosDesembolso" );

?>
