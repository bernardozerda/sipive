<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

	$txtNombreVariable = ereg_replace( "[0-9]" , "" , $_POST['eliminar'] );

	$txtTexto = ( strlen( $_POST['texto'] ) > $_POST['limite'] )? substr( $_POST['texto'] , 0 , $_POST['limite'] ) . "..." : $_POST['texto'];

	echo "
	<div style=\"width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left;\"
		 onMouseOver=\"this.style.backgroundColor='#FFA4A4';\"
		 onMouseOut=\"this.style.backgroundColor='#F9F9F9'\"
		 onClick=\"eliminarObjeto('" . $_POST['eliminar'] . "')\"
	>X</div>
	<div style=\"cursor:pointer; float:right; width:" . $_POST['ancho'] . "%; height:14px; border:1px solid #F9F9F9;\"
	onMouseOver=\"mostrarHint( '" . $_POST['texto'] . "')\" onMouseOut=\"ocultarHint();\">
		" . $_POST['secuencia'] . " - " . $txtTexto . "
	</div>
	<input type='hidden' name='" . $txtNombreVariable . "[]' value='" . $_POST['texto'] . "'>
	";

?>
