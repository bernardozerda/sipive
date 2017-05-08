<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    
    $claCiudadano = new Ciudadano();
    $claFormulario = new FormularioSubsidios();
    
    $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "", "txtModalidad");
    $arrProyecto = obtenerDatosTabla("T_PRY_PROYECTO", array("seqProyecto", "txtNombreProyecto"), "seqProyecto", "", "txtNombreProyecto");
    $arrProyectoBp = obtenerDatosTabla("T_FRM_PROYECTO", array("seqProyecto", "txtNombre"), "seqProyecto", "", "txtNombre");
    $arrEsquema = obtenerDatosTabla("T_PRY_TIPO_ESQUEMA", array( "seqTipoEsquema" , "txtTipoEsquema" ) , "seqTipoEsquema");
    $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array( "seqTipoDocumento" , "txtTipoDocumento" ), "seqTipoDocumento");
    $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array( "seqParentesco" , "txtParentesco" ), "seqParentesco");
    
    $seqFormulario = $claCiudadano->formularioVinculado( $_POST['documento'] );
    if( intval( $seqFormulario ) != 0 ){
        $claFormulario->cargarFormulario( $seqFormulario );
        
        $arrEtapa = obtenerDatosTabla("T_FRM_ESTADO_PROCESO", array( "seqEtapa" , "seqEstadoProceso" ), "seqEstadoProceso", "seqEstadoProceso = " . $claFormulario->seqEstadoProceso);
        $seqEtapa = $arrEtapa[ $claFormulario->seqEstadoProceso ];

    } else {
        $arrErrores[] = "El documento " . number_format( $_POST['documento'] ) . " no se encuentra dentro de la base de datos del sistema";
    }

    
    
    $claSmarty->assign( "seqEtapa"      , $seqEtapa            );
    $claSmarty->assign( "numDocumento"  , $_POST['documento']  );
    $claSmarty->assign( "arrModalidad"    , $arrModalidad      );
    $claSmarty->assign( "arrTipoDocumento"  , $arrTipoDocumento);
    $claSmarty->assign( "arrParentesco"  , $arrParentesco);
    $claSmarty->assign( "arrProyecto"   , $arrProyecto         );
    $claSmarty->assign( "arrProyectoBp" , $arrProyectoBp       );
    $claSmarty->assign( "arrEsquema"    , $arrEsquema          );
    $claSmarty->assign( "arrErrores"    , $arrErrores          );
    $claSmarty->assign( "arrErrores"    , $arrErrores          );
    $claSmarty->assign( "claFormulario" , $claFormulario       );
    $claSmarty->display( "constructoras/consulta.tpl" );

?>
