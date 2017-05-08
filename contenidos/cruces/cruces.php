<?php

    /**
	 * INICIO DE LA PANTALLA DE VERIFICACION DE CRUCES DE CASA EN MANO
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2013
	 */

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CiudadanoBp.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidiosBp.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
    
    $arrEstados = estadosProceso();
    $arrCruces = array();
    
    $sql = "
        SELECT 
            seqCruce,
            txtNombre,
            fchCruce,
            txtCuerpo,
            txtPie,
            txtFirma,
            txtElaboro,
            txtReviso
        FROM T_CRU_CRUCES            
        ORDER BY txtNombre
    ";
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
        $arrCruces[ $objRes->fields['seqCruce'] ]['fecha']   = $objRes->fields['fchCruce'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['nombre']  = $objRes->fields['txtNombre'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['cuerpo']  = $objRes->fields['txtCuerpo'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['pie']     = $objRes->fields['txtPie'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['firma']   = $objRes->fields['txtFirma'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['elaboro'] = $objRes->fields['txtElaboro'];
        $arrCruces[ $objRes->fields['seqCruce'] ]['reviso']  = $objRes->fields['txtReviso'];
        $objRes->MoveNext();
    }
    
    $claSmarty->assign( "arrCruces"      , $arrCruces );
    $claSmarty->assign( "arrEstados"     , $arrEstados );
    $claSmarty->assign( "txtUsuario"     , $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] );
    $claSmarty->display( "cruces/cruces.tpl" );
    
?>
