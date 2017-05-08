<?php
	
	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
 	
 	define( "SEPARADOR" , "\t" );
 	define( "SALTO" , "\n" );
 	
 	// Obtiene los datos del grupo y el query
 	$arrParametros = split( "\?" , $_GET[ "consulta" ] );
 	
 	// obtiene el nombre del grupo
 	$txtGrupo = $arrParametros[ 0 ];
 	
 	// obtiene el parametro a buscar
 	$arrParametros[ 1 ] = ereg_replace( "query=" , "" , $arrParametros[ 1 ] );
 	$txtParametro = ereg_replace( " " , "%" , $arrParametros[ 1 ] );
	while( strpos( $txtParametro , "%%" ) !== false ){
		$txtParametro = ereg_replace( "%%" , "%" , $txtParametro );
	} 	
 	
// 	echo $txtGrupo . SEPARADOR . $txtParametro . SALTO;
 	
 	$seqProyecto = $_SESSION['seqProyecto'];
 	$seqProtectoGrupo = Grupo::nombreGrupo2Identificador( $seqProyecto , $txtGrupo );
 	
	$sql =	"SELECT ";
	$sql.=	"  usu.seqUsuario, ";
	$sql.=	"  ucwords( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as txtUsuario "; 
	$sql.=	"FROM ";
	$sql.=	"  T_COR_USUARIO usu, ";
	$sql.=	"  T_COR_PERFIL per, ";
	$sql.=	"  T_COR_PROYECTO_GRUPO prg ";
	$sql.=	"WHERE usu.seqUsuario = per.seqUsuario ";
	$sql.=	"AND per.seqProyectoGrupo = prg.seqProyectoGrupo ";
	$sql.=	"AND prg.seqProyectoGrupo IN ( " . $seqProtectoGrupo ." , 31 , 32 , 33, 15) "; // Grupo de usuarios tutores de desembolso asociado al proyecto subsidios de vivienda 
	$sql.=	"AND prg.seqProyecto = " . $_SESSION['seqProyecto'] ." " ;
	$sql.=  "AND CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) LIKE '%$txtParametro%' ";
	$sql.=  "ORDER BY CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ";
 	
 	$objRes = $aptBd->execute( $sql );
 	$arrResultados = array();
 	while( $objRes->fields ){
 		$arrResultados[] = "" . SEPARADOR . $objRes->fields['txtUsuario'] . SALTO;
 		$objRes->MoveNext();
 	}
	
	if( empty( $arrResultados ) ){
		echo "No se encontraron resultados para \"". ereg_replace( "%" , " " , $txtParametro ) ."\"" . SEPARADOR . SALTO;
	}else{
		foreach( $arrResultados as $txtResultado ){
			echo $txtResultado;
		}
	}
	
	
	
?>
