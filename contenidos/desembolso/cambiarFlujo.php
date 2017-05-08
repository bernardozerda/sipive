<?php

	/**
	 * INICIO DE LA PANTALLA DE DESEMBOLSOS
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2009
	 */

	$txtPrefijoRuta = "../../";
	
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FlujoDesembolsos.class.php" );
    
   	$seqFormulario = $_POST['seqFormulario'];
    $txtFlujo      = $_POST['flujo'];

	$claFormulario = new FormularioSubsidios;
	$claFormulario->cargarFormulario( $seqFormulario );
    
    $claFlujoDesembolsos = new FlujoDesembolso( $seqFormulario );
    
    $arrFlujoHogar['flujo'] = $txtFlujo;
    $arrFlujoHogar['fase']  = "";
    foreach ( $claFlujoDesembolsos->arrFases[ $txtFlujo ] as $txtFase => $arrFases ){
       if( is_array( $arrFases['permisos'] ) ){
         if( in_array( $claFormulario->seqEstadoProceso , $arrFases['permisos'] ) ){
             $arrFlujoHogar['fase']  = $txtFase;
         }
       }
    }
    
    $claSmarty->assign( "arrFlujoHogar"       , $arrFlujoHogar  ); // Flujo de datos aplicado al hogar
    $claSmarty->assign( "cedula"              , $_POST['cedula'] );
    $claSmarty->assign( "seqFormulario"       , $seqFormulario  );
    $claSmarty->assign( "claFlujoDesembolsos" , $claFlujoDesembolsos );
    
    $claSmarty->display( "desembolso/fasesDesembolso.tpl" );

?>
