<?php

    /**
	 * CARGA EL CRUCE SELECCIONADO POR EL USUARIO
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
    
    $seqCruce = $_POST['seqCruce'];
    $arrCruce = array();
    $arrHogares = array();
    $arrEstados = estadosProceso();
    
    $sql = "
        SELECT
            cru.txtNombre,
            cru.fchCruce,
            cru.txtCuerpo,
            cru.txtPie,
            cru.txtFirma,
            cru.txtElaboro,
            cru.txtReviso,
			cru.fchCreacionCruce
        FROM T_CRU_CRUCES cru
        WHERE cru.seqCruce = '" . $seqCruce . "'
    ";
    $objRes = $aptBd->execute( $sql );
    if( $objRes->fields ){
        
        $arrCruce['fecha']   = $objRes->fields['fchCruce'];
        $arrCruce['nombre']  = $objRes->fields['txtNombre'];
        $arrCruce['cuerpo']  = $objRes->fields['txtCuerpo'];
        $arrCruce['pie']     = $objRes->fields['txtPie'];
        $arrCruce['firma']   = $objRes->fields['txtFirma'];
        $arrCruce['elaboro'] = $objRes->fields['txtElaboro'];
        $arrCruce['reviso']  = $objRes->fields['txtReviso'];
		$arrCruce['creacion']  = $objRes->fields['fchCreacionCruce'];
        
        $sql = "
            SELECT 
               cru.seqFormulario,
               cru.numDocumento,
               cru.txtNombre,
               ( 
                  SELECT SUM(cru1.bolInhabilitar) 
                  FROM T_CRU_RESULTADO cru1 
                  WHERE cru1.seqCruce = cru.seqCruce
                  AND cru1.seqFormulario = cru.seqFormulario
               ) AS bolInhabilitar
            FROM T_CRU_RESULTADO cru
            WHERE cru.seqCruce = $seqCruce
              AND cru.seqParentesco = 1
            ORDER BY cru.numDocumento
        ";
        $objRes = $aptBd->execute( $sql );
        while( $objRes->fields ){
            
            $seqFormulario = $objRes->fields['seqFormulario'];
            
            $claFormulario = new FormularioSubsidios;
            $claFormulario->cargarFormulario($seqFormulario);
            
            $arrHogares[ $seqFormulario ]['carta']     = ( $objRes->fields['bolInhabilitar'] > 0 )? 1 : 0;
            $arrHogares[ $seqFormulario ]['documento'] = $objRes->fields['numDocumento'];
            $arrHogares[ $seqFormulario ]['nombre']    = $objRes->fields['txtNombre'];
            $arrHogares[ $seqFormulario ]['estado']    = $arrEstados[ $claFormulario->seqEstadoProceso ];
            
            $objRes->MoveNext();
        }
        
        $claSmarty->assign( "seqCruce" , $seqCruce );
        $claSmarty->assign( "arrCruce" , $arrCruce );
        $claSmarty->assign( "arrHogares" ,  $arrHogares );
        $claSmarty->display( "cruces/leerCruce.tpl" );
        
    }
    
    
?>