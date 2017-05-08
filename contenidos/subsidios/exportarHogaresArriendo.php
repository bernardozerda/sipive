<?php

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

	$txtNombreArchivo = "HogaresArrendamiento" . date( "Ymd_His" ) . ".xls";

	$txtArchivo = "
	<table>
		<thead>
	        <tr>
	            <th>Tipo Documento</th>
	            <th>Documento</th>
	            <th>Nombre</th>
	            <th>Dirección</th>
	            <th>Teléfono 1</th>
	            <th>Teléfono 2</th>
	            <th>Celular</th>
	        </tr>
	    </thead>
	    <tbody>
	";
	foreach ( $_POST['postulados']  as $seqFormulario => $arrDatos ){
		$txtArchivo .= "
			<tr>
				<td>" . $arrDatos[ 'TipoDocumento' ] . "</td> 
				<td>" . $arrDatos[ 'Documento' ] . "</td>
				<td>" . $arrDatos[ 'Nombre' ] . "</td>
				<td>" . $arrDatos[ 'Direccion' ] . "</td>
				<td>" . $arrDatos[ 'Telefono1' ] . "</td>
				<td>" . $arrDatos[ 'Telefono2' ] . "</td>
				<td>" . $arrDatos[ 'Celular' ] . "</td>
			</tr>
		";
	}
	
	$txtArchivo .= "</tbody></table>";

	header("Content-disposition: attachment; filename=$txtNombreArchivo");
	header("Content-Type: application/force-download");
	header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 1"); 
	
	echo utf8_decode( $txtArchivo );

?>
