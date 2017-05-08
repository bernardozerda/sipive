<?php

    $memoria_inicial = memory_get_usage( true );

    ini_set( "max_execution_time" , "86400" );
    ini_set( "memory_limit" , "128M" );

    // Esta variable de usa para ubicar los archivos a incluir
    $txtPrefijoRuta = "./";
    
    include( "./recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
   
    header("Content-disposition: attachment; filename=Imagenes_" . time() . ".csv");
	header("Content-Type: application/force-download");
	header("Content-Type: text/plain; charset=ISO-8859-1");
	header("Content-Transfer-Encoding: base64");
	header("Pragma: no-cache");
	header("Expires: 1"); 
 
    $sql = "
        SELECT txtNombreArchivo
        FROM T_DES_ADJUNTOS_TECNICOS
        WHERE seqTipoAdjunto = 3
    ";
    $objRes = $aptBd->execute( $sql );
    $txtArchivo = "Archivo;Existe\n";
    while ( $objRes->fields ){
        $txtArchivo.= $txtNombreArchivo . ";";
        if( file_exists( "./recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'] ) ){
            $txtArchivo.= "si\n";
        }else{
            $txtArchivo.= "no\n";
        }
        $objRes->MoveNext();
    }
    
    echo $txtArchivo;
    
    $memoria_final = memory_get_usage( true );
    
//    echo number_format( $memoria_inicial ) . " - " . 
//         number_format( $memoria_final )   . " = " . 
//         number_format( ( $memoria_final - $memoria_inicial ) ) . "<br>";
    
?>
