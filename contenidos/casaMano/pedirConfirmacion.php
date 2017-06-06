<?php

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

    // declaracion de variables necesarias
    $bolCambios = false;
    $arrErrores = array();

    // CORRECCION DE CAMPOS MAL NOMBRADOS EN LA PLANTILLA
    //(aun no se puede corregir en la plantilla como tal porque debe cambiarse actualizacion.tpl y esta en desarrollo ocupada)
    foreach($_POST['hogar'] as $numDocumento => $arrCiudadano){
        $_POST['hogar'][$numDocumento]['numAnosAprobados'] = $_POST['hogar'][$numDocumento]['anosAprobados'];
        unset( $_POST['hogar'][$numDocumento]['anosAprobados'] );
    }

    $claCasaMano = new CasaMano();
    $claFormulario = new FormularioSubsidios();
    
    // Carga los datos del formulario
    $claFormulario->cargarFormulario( $_POST['seqFormulario'] );
    
    // obtiene el nombre de la persona que ha sido atendida
    foreach( $claFormulario->arrCiudadano as $objCiudadano ){
        if( mb_ereg_replace( "[^0-9]" , "" , $objCiudadano->numDocumento ) == mb_ereg_replace("[^0-9]", "", $_POST['cedula'] ) ){
            $_POST['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
            break;
        }       
    }
    
    // Carga los datos de casa en mano
    $arrCasaMano = $claCasaMano->cargar( $_POST['seqFormulario'] );
    
    // si hay cambios en el formulrio los detecta
    if( intval( $_POST['seqCasaMano'] ) != 0 ){
        $objCasaMano = $arrCasaMano[ $_POST['seqCasaMano'] ];
        $bolCambios = $objCasaMano->cambios( $_POST );
    } else {
        if( trim( $_POST['txtNombreVendedor'] ) != "" ){
            $bolCambios = true;
        } else {
            $bolCambios = false;
        }
    }
    
    // Detecta si hay cambios en el estado del proceso
    if( intval( $_POST['seqEstadoProceso'] ) != intval( $claFormulario->seqEstadoProceso ) ){
        $bolCambios = true;
    }

    if( $bolCambios === true ){

        // Mensaje cuando hay cambios
        $txtMensaje = "Es necesario que confirme la acci&oacute;n que esta apunto de realizar:";
        $txtMensaje.= "<div class='msgOk' style='font-size:12px;'> Desea cambiar los datos del registro para el documento ".$objCiudadano->numDocumento." ?</div>";

        $claSmarty->assign( "txtMensaje" , utf8_encode( $txtMensaje ) );
        $claSmarty->assign( "bolMostrarConfirmacion" , $bolCambios );
        $claSmarty->assign( "txtArchivo" , $claCasaMano->arrFases[ $_POST['txtFlujo'] ][ $_POST['txtFase'] ]['salvar'] );
        $claSmarty->assign( "arrPost" , $_POST );
        $claSmarty->display( "desembolso/pedirConfirmacion.tpl" );
    
    } else {
        
        
        // solo para la fase de postulacion los telefonos y direcciones se pueden
        // cambiar sin que haya restricciones
        if( $_POST["txtFase"] == "postulacion" ){
            $sql = "
                UPDATE T_FRM_FORMULARIO SET
                    txtDireccion = '" . $_POST['txtDireccion'] . "',
                    numTelefono1 = '" . $_POST['numTelefono1'] . "',
                    numTelefono2 = '" . $_POST['numTelefono2'] . "',
                    numCelular   = '" . $_POST['numCelular'] . "',
                    txtCorreo    = '" . $_POST['txtCorreo'] . "',
                    seqCiudad    = '" . $_POST['seqCiudad'] . "',
                    seqLocalidad = '" . $_POST['seqLocalidad'] . "'
                WHERE seqFormulario = " . $_POST['seqFormulario'] . "
            ";
            $aptBd->execute( $sql );
        }
        
        
        
        $claCasaMano->salvarSeguimiento( $_POST );
        imprimirMensajes( $claCasaMano->arrErrores , $claCasaMano->arrMensajes );
        
    }
    
    
?>
