<?php

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Encuestas.class.php");

	$arrErrores = array();
	$arrMensajes = array();
	
	if($_POST['buscaCedulaConfirmacion'] != $_POST['buscaCedula']){
		$arrErrores[] = "La cédula digitada y su confirmación no coinciden";
	}
	
	if(empty($arrErrores)){
		$numDocumento = mb_ereg_replace("[^0-9]", "", $_POST['buscaCedula']);
		$claEncuestas = new Encuestas();
		$arrAplicaciones = $claEncuestas->listarAplicaciones($numDocumento);
	}
	
	if( empty($arrAplicaciones) ){
		$arrErrores[] = "El hogar no tiene aplicaciones de encuestas realizadas";
	}
	
	//pr($arrAplicaciones);
	
	if(! empty($arrErrores)){
		imprimirMensajes($arrErrores, $arrMensajes);
	}else{
		
		$seqProyecto = $_SESSION['seqProyecto'];
		if(isset($_SESSION['arrGrupos'][$seqProyecto][20])){
			$bolEliminar = true;
		}else{
			$bolEliminar = false;
		}
		
		$claSmarty->assign( "bolEliminar" , $bolEliminar);
		$claSmarty->assign( "arrAplicaciones" , $arrAplicaciones);
		$claSmarty->display( "encuestasPive/listarEncuestas.tpl" );
	}
?>