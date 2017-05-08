<?php

    /**
	 * SALVA LOS DATOS DE REVISION JURIDICA EN EL ESQUEMA
	 * DE CASA EN MANO
	 * @author Bernardo Zerda
	 * @version 1.0 Jul 2013
	 */    

    $txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

	/*
	 * VALIDACION DE CAMPOS OBLIGATORIOS
	 */
	
    if( $_POST['txtConcepto'] == "" ){
        $arrErrores[] = "Seleccione el concepto final para el estudio";
    }
    
    
	// validando observaciones
	if( $_POST['observaciones'] == "" ){
		$arrErrores[] = "El campo de observaciones no puede quedar vacio";
	}
	
	// validando libertad
	if( $_POST['libertad'] == "" ){
		$arrErrores[] = "El campo de libertad no puede quedar vacio";
	}
	
	// validando documentos analizados
	if( ! ( isset( $_POST['documento'] ) and is_array( $_POST ) ) ){
		$arrErrores[] = "Indique que documentos ha analizado";
	}
	
	// validando concepto
	if( $_POST['concepto'] == "" ){
		$arrErrores[] = "El campo de concepto no puede quedar vacio";
	}
	
	// validando preparo
	if( $_POST['aprobo'] == "" ){
		$arrErrores[] = "Indique el nombre de la persona que aprueba la elaboracion del documento";
	}    
    
	if( empty( $arrErrores ) ){
		
        // salva el registro de concepto juridico
        $claCasaMano = new CasaMano();
        $arrCasaMano = $claCasaMano->cargar( $_POST['seqFormulario'] , $_POST['seqCasaMano'] );
        $objCasaMano = array_shift( $arrCasaMano );
        
        $objCasaMano->salvar( $_POST );
        
        if( ! empty( $objCasaMano->arrErrores ) ){
            $arrErrores = $objCasaMano->arrErrores;
        }
        
	}

	/**
 	 * IMPRESION DE LOS MENSAJES GENERADOS POR EL CODIGO
 	 */ 
 	 
    if( empty( $arrErrores ) ){
		$arrMensajes = $objCasaMano->arrMensajes;
		$txtEstilo = "msgOk";
	}else{
		$arrMensajes = $arrErrores;
		$txtEstilo = "msgError";
	}	 

	echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' id='tablaMensajes' style='padding:5px' class='$txtEstilo'>" ;
    foreach( $arrMensajes as $txtMensaje ){
    	echo "<tr><td class='$txtEstilo'><li>$txtMensaje</li></td></tr>";
    }
    echo "</table>";
    
    

?>
