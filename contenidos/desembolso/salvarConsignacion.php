<?php

	/**
 	 * SALVA LOS DATOS DE LA CONSIGNACION AL CAP DE LOS SCA
 	 * @author Bernardo Zerda
 	 * @version 1.0 11/10/2010 
	 **/

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    
    // formulario para relacionar los datos
    $seqFormulario = $_POST[ 'seqFormulario' ];
    
    // Variable para los errores
    $arrErrores = array();
    
    // datos del desembolso
    $claDesembolso = new Desembolso;
    $claDesembolso->cargarDesembolso( $seqFormulario );
    
    // Seguimientos
    $claSeguimiento = new Seguimiento;
    
    
    /**
     * VALIDACIONES
     */
    
    // gestion realizada
    if( intval( $_POST['seqGestion'] ) == 0 ){
    	$arrErrores[] = "Debe seleccionar un grupo de gestion y una gestion para la actividad que esta por realizar";
    }
    
    // El comentario
    if( trim( $_POST[ 'txtComentario' ] ) == "" ){
    	$arrErrores[] = "Realice un comentario para la gestion a realizar";
    }
    
    // El nombre de la consigancion
    if( trim( $_POST[ 'txtNombreConsignacion' ] ) == "" ){
    	$arrErrores[] = "La consignación debe estar a nombre de alguien";
    }
    
    // Fecha de la consignacion
    if( esFechaValida( $_POST[ 'fchConsignacion' ] ) === false ) {
    	$arrErrores[] = "Indíque la fecha en la que se realizó la consignación";
    } 
    
    // Valor de la consignacion
    if( is_numeric( $_POST[ 'valConsignacion' ] ) and $_POST[ 'valConsignacion' ] == 0 ){
   		$arrErrores[] = "El valor de la consignacion no puede ser cero y tampoco puede estar vacio";
    }  
    
	// Numero de cuenta
	if( trim( $_POST[ 'numCuenta' ] ) == "" ){
		$arrErrores[] = "Debe diligenciar el campo de numero de cuenta";
	}  
	
	// Banco de la consignacion
	if( intval( $_POST[ 'seqBancoConsignacion' ] ) == 1 or intval( $_POST[ 'seqBancoConsignacion' ] ) == 0 ){
		$arrErrores[] = "El banco seleccionado no es válido";
	} 
	
	/**
	 * PROCESAMIENTO
	 */
	
	$arrMensajes = array();
	if( empty( $arrErrores ) ){
		$_POST['txtCambios'] = $claSeguimiento->cambiosDesembolso( "Consignaciones" , $claDesembolso , $_POST );
		$arrErrores = $claDesembolso->salvarConsignacion( $seqFormulario , $_POST );
		if( empty( $arrErrores ) ){
			$arrMensajes[] = "Se ha salvado la consignacion, el numero de registro es " . number_format( $claDesembolso->seqSeguimiento , 0 , "." , "," ) . "<br>conserve este numero para referencia futura";
		}
				
	}
	
	imprimirMensajes( $arrErrores , $arrMensajes );
	

?>
