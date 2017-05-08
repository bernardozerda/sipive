<?php
	
	$txtPrefijoRuta = "../../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    
    $sql = "
    	SELECT
		  seqLocalidad,
		  SUBSTRING(txtLocalidad, LOCATE('-', txtLocalidad, 1) + 2 , length( txtLocalidad ) ) as txtLocalidad
		FROM T_FRM_LOCALIDAD
		WHERE seqLocalidad > 1
		ORDER BY SUBSTRING(txtLocalidad, LOCATE('-', txtLocalidad, 1) + 2 , length( txtLocalidad ) )
    ";
    $objRes = $aptBd->execute($sql);
    while( $objRes->fields ){
    	$arrLocalidad[ $objRes->fields['seqLocalidad'] ] = $objRes->fields['txtLocalidad'];
    	$objRes->MoveNext();
    }
    
    $claSmarty->assign( "arrLocalidad" , $arrLocalidad );
    $claSmarty->display( "bancoVivienda/cargaMasiva/cargaMasiva.tpl" );
    
?>
