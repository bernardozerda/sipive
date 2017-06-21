<?php

	// Lenguaje para la conversion de fechas
    
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

    include( "../desembolso/datosComunes.php" );

    $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "bolActivo DESC, txtParentesco");

    // simula el flujo del hogar en desembolsos para efectos de la plantilla
    $arrFlujoHogar['flujo'] = "cem";
    $arrFlujoHogar['fase']  = "registroOferta";
    
    // Los estados del proceso se cargan para las traducciones en las plantillas
    $arrEstados = estadosProceso();
    
    // carga los datos del hogar
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario( $_POST['seqFormulario'] );

    // obtieene los permisos para saber a donde puede entrar
    $claCasaMano = new CasaMano();
    
    $objCasaMano = null;
    if( intval( $_POST['seqFormulario'] ) != 0 ){
        $arrCasaMano = $claCasaMano->cargar( $_POST['seqFormulario'] , $_POST['seqCasaMano'] );
        $objCasaMano = array_shift( $arrCasaMano );
    }

    $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $objCasaMano->objRegistroOferta->seqLocalidad, "txtBarrio");

    $arrTextoBarrio = obtenerDatosTabla(
        "T_FRM_BARRIO",
        array("seqLocalidad","seqBarrio"),
        "seqLocalidad",
        "seqLocalidad = " . $objCasaMano->objRegistroOferta->seqLocalidad . " and txtBarrio = '" . $objCasaMano->objRegistroOferta->txtBarrio . "'"
    );
    $objCasaMano->objRegistroOferta->seqBarrio = $arrTextoBarrio[$objCasaMano->objRegistroOferta->seqLocalidad];


    $bolPermiso = $objCasaMano->puedeIngresar( $arrFlujoHogar );
    if( $bolPermiso == true ){
        
        // Obtienr los ultimos seguimientos
		$claSeguimiento = new Seguimiento;
		$claSeguimiento->seqFormulario = $seqFormulario;
		$arrRegistros = $claSeguimiento->obtenerRegistros( 100 );
		
        // Carga el tutor que tiene asignado ese hogar
		$claCRM = new CRM;
		$txtTutor = $claCRM->obtenerTutorHogar( $seqFormulario );
      
      // Obtiene el postulante principal
      foreach( $claFormulario->arrCiudadano as $objCiudadano ){
         if( $objCiudadano->seqParentesco == 1 ){
            $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
            break;
         }
      }
      
      // obtiene la informacion de la pestana de actos administrativos
      $claActosAdministrativos = new ActoAdministrativo();
      $arrActos = $claActosAdministrativos->cronologia( $numDocumento );
      
      $claSmarty->assign( "arrActos" , $arrActos );
      $claSmarty->assign( "arrParentesco" , $arrParentesco );
      $claSmarty->assign( "arrBarrio" , $arrBarrio );
      $claSmarty->assign( "txtTutor" , $txtTutor );
      $claSmarty->assign( "arrFlujoHogar" , $arrFlujoHogar );
      $claSmarty->assign( "arrRegistros" , $arrRegistros );
      $claSmarty->assign( "claFlujoDesembolsos" , $claCasaMano ); // claFlujoDesembolsos es emulado por claCasaMano
      $claSmarty->assign( "claDesembolso" , $objCasaMano->objRegistroOferta ); // Emula la clase de desembolsos para la plantilla}
      $claSmarty->assign( "fchCreacion" , $objCasaMano->objRegistroOferta->fchCreacion ); // para la plantilla de desembolso
      $claSmarty->assign( "fchActualizacion" , $objCasaMano->objRegistroOferta->fchActualizacion ); // para la plantilla de deembolso
      $claSmarty->assign( "arrEstados" , $arrEstados );
      $claSmarty->assign( "claFormulario" , $claFormulario );
      $claSmarty->assign( "seqFormulario" , $_POST['seqFormulario'] );
      $claSmarty->assign( "seqCasaMano" , intval( $_POST['seqCasaMano'] ) );
      $claSmarty->assign( "cedula" , $_POST['cedula'] );
      $claSmarty->assign( "bolModificar" , intval( $_POST['modificar'] ) );
      $claSmarty->assign( "txtImprimir" , "desembolsoBusquedaOferta(" . intval( $_POST['seqFormulario'] ) . "," . intval( $_POST['seqCasaMano'] ) . ")" );
      $claSmarty->display( "casaMano/fasesCEM.tpl" );
        
    } else {
        $arrMensaje = $claCasaMano->arrErrores;
        $claSmarty->assign( "estilo" , "msgError" );
        $claSmarty->assign( "arrImprimir" , $arrMensaje );
        $claSmarty->display( "mensajes.tpl" );   
    }
?>
