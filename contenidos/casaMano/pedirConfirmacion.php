<?php

    $txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos']   . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "CasaMano.class.php" );

    // declaracion de variables necesarias
    $bolCambios = false;
    $arrErrores = array();

    $claSeguimiento = new Seguimiento();

    $claCasaMano = new CasaMano();
    $arrCasaMano = $claCasaMano->cargar( $_POST['seqFormulario'] , $_POST['seqCasaMano']);
    $claCasaMano = end($arrCasaMano);

    // obtiene el nombre de la persona que ha sido atendida
    foreach( $claCasaMano->objPostulacion->arrCiudadano as $objCiudadano ){
        if( $objCiudadano->numDocumento == $_POST['cedula'] ){
            $_POST['nombre'] = ucwords( trim( strtolower(
                $objCiudadano->txtNombre1 . " " .
                $objCiudadano->txtNombre2 . " " .
                $objCiudadano->txtApellido1 . " " .
                $objCiudadano->txtApellido2
            ) ) );
            break;
        }       
    }

    // si el formulario esta abierto hay que colocar la variable porque no viene el el post solo para la fase de postulacion
    if( $arrFlujoHogar['fase'] == "postulacion" ) {
        $_POST['bolCerrado'] = intval($_POST['bolCerrado']);
    }



    // detecta los cambios en el formulario
    $bolCambios = $claCasaMano->cambios( $_POST );
    if( $bolCambios != "" ){
        // Mensaje cuando hay cambios
        $txtMensaje = "<h2>Confirme que desea cambiar <br>los datos para el hogar de:</h2>";
        $txtMensaje.= "<h3>" . $_POST['nombre'] . " [ " . number_format($objCiudadano->numDocumento,0,'.','.') . " ]</h3>";

        $claSmarty->assign( "txtMensaje" , $txtMensaje );
        $claSmarty->assign( "bolMostrarConfirmacion" , $bolCambios );
        $claSmarty->assign( "txtArchivo" , $claCasaMano->arrFases[ $_POST['txtFlujo'] ][ $_POST['txtFase'] ]['salvar'] );
        $claSmarty->assign( "arrPost" , $_POST );
        $claSmarty->display( "desembolso/pedirConfirmacion.tpl" );

    } else {
        $claCasaMano->salvar( $_POST );
        imprimirMensajes( $claCasaMano->arrErrores , $claCasaMano->arrMensajes );
    }
    
    
?>
