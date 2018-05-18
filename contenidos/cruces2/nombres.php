<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	
// Obtiene los datos
$txtConsulta = strtolower( trim( $_GET['query'] ) );
$arrResultados = array();

try {
	$sql  = "";
	$sql .= "SELECT DISTINCT ";
	$sql .= "UPPER( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as nombre ";
	$sql .= "FROM T_COR_USUARIO usu ";
	$sql .= "INNER JOIN T_COR_PERFIL per ON usu.seqUsuario = per.seqUsuario ";
	$sql .= "INNER JOIN T_COR_PROYECTO_GRUPO prg ON per.seqProyectoGrupo = prg.seqProyectoGrupo ";
	$sql .= "INNER JOIN T_COR_GRUPO gru ON prg.seqGrupo = gru.seqGrupo ";
	$sql .= "WHERE prg.seqProyecto = 3 ";
	//$sql .= "AND usu.bolActivo = 1 ";
	$sql .= "AND CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) LIKE '%$txtConsulta%' ";
	$sql .= "ORDER BY nombre";

	$objRes = $aptBd->execute( $sql );
	while( $objRes->fields ){
		$arrResultados[] = $objRes->fields[ 'nombre' ];
		$objRes->MoveNext();
	}

} catch (  Exception $objError ){
	$arrResultados = array();
}

// Despliega los resultados
echo implode( "\n" , $arrResultados );

?>
