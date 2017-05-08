<?php

    /**
	 * INICIO DE LA PANTALLA DE INSCRIPCION DE CASA EN MANO
	 * @author Bernardo Zerda
	 * @version 1.0 Ago 2013
	 */

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

    if( empty( $_POST ) ){
        $claSmarty->assign( "txtFuncion" , "buscarCedula('casaMano/casaMano')" );
        $claSmarty->display( "subsidios/buscarCedula.tpl" );
    }else{
        
        $arrFlujoHogar['flujo'] = "cem";
        $arrFlujoHogar['fase']  = "panelHogar";
        
        // ciudadano para obtener el formulario vinculado
        $claCiudadano = new Ciudadano();
        $seqFormulario = $claCiudadano->formularioVinculado( str_replace( "." , "" , $_POST['cedula'] ) );
        
        // obtiene la informacion del hogar
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario( $seqFormulario );
        $claFormulario->txtBarrio = obtenerCampo( "T_FRM_BARRIO" , $claFormulario->seqBarrio , "txtBarrio" , "seqBarrio" );
        
        // obtieene los permisos para saber a donde puede entrar
        $claCasaMano = new CasaMano();
        
        $bolPermiso = $claCasaMano->puedeIngresar( $arrFlujoHogar , $claFormulario );
        if( $bolPermiso == true ){
            
            include( $txtPrefijoRuta . "contenidos/desembolso/datosComunes.php" );
            
            // Carga de los datos de casa en mano en el panel de control del hogar
            $arrCasaMano = $claCasaMano->cargar( $seqFormulario );
            $claSmarty->assign( "claFormulario" , $claFormulario );
            $claSmarty->assign( "seqFormulario" , $seqFormulario );
            $claSmarty->assign( "arrPost" , $_POST );   
            $claSmarty->assign( "arrCasaMano" , $arrCasaMano );   
            $claSmarty->assign( "arrEstados" , estadosProceso() );   
            $claSmarty->display( "casaMano/casaMano.tpl" );   
            
        }else{
            
            $arrMensaje = $claCasaMano->arrErrores;
            $claSmarty->assign( "estilo" , "msgError" );
            $claSmarty->assign( "arrImprimir" , $arrMensaje );
            $claSmarty->display( "mensajes.tpl" );   
        }
        
        
            
    }
    
?>
