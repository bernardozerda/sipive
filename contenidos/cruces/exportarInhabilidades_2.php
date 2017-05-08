<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );    
    
    // Header para redireccionar cuando el archivo este listo
    header("Content-disposition: attachment; filename=" . time() . ".xls");
	header("Content-Type: application/force-download");
	header("Content-Type: text/plain; charset=ISO-8859-1");
	header("Content-Transfer-Encoding: base64");
	header("Pragma: no-cache");
	header("Expires: 1"); 
	
    // Arreglos necesarios
    $arrArchivo = array();
    $arrCruce   = array();
    $arrEstados = estadosProceso();
    
    // titulos del archivo
	$arrArchivo[0][] = "seqFormulario";
    $arrArchivo[0][] = "MODALIDAD";
    $arrArchivo[0][] = "ESTADO";
    $arrArchivo[0][] = "TIPO_DOCUMENTO";
    $arrArchivo[0][] = "DOCUMENTO";
    $arrArchivo[0][] = "NOMBRE";
    $arrArchivo[0][] = "PARENTESCO";
    $arrArchivo[0][] = "ENTIDAD";
    $arrArchivo[0][] = "CAUSA";
    $arrArchivo[0][] = "DETALLE";
    $arrArchivo[0][] = "INHABILITAR";
    $arrArchivo[0][] = "OBSERVACIONES";
    
    // esto es para cuando se recupera un cruce
    if( isset( $_POST['seqCruce'] ) and intval( $_POST['seqCruce'] ) > 0 ){
        
        $sql = "
            SELECT 
                frm.seqFormulario,
                moa.txtModalidad,
                CONCAT( eta.txtEtapa , 
                        ' - ' , 
                        est.txtEstadoProceso 
                ) as txtEstadoProceso,
                tdo.txtTipoDocumento,
                ciu.numDocumento,
                UPPER( CONCAT( TRIM( ciu.txtNombre1 ), 
                        ' ' , 
                        if( TRIM( ciu.txtNombre2 ) <> '', 
                            CONCAT( TRIM( ciu.txtNombre2 ) , ' ' ), 
                            '' 
                        ) , 
                        TRIM( ciu.txtApellido1 ), 
                        ' ' , 
                        TRIM( ciu.txtApellido2 )
                ) ) as txtNombre,
                par.txtParentesco,
                res.txtEntidad,
                res.txtTitulo,
                res.txtDetalle,
                if( res.bolInhabilitar <> 0, 'SI' , 'NO' ) as bolInhabilitar,
                res.txtObservaciones
            FROM T_FRM_FORMULARIO frm
            INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
            INNER JOIN T_FRM_ESTADO_PROCESO est ON frm.seqEstadoProceso = est.seqEstadoProceso
            INNER JOIN T_FRM_ETAPA eta ON est.seqEtapa = eta.seqEtapa
            INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
            INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
            INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
            INNER JOIN T_CIU_PARENTESCO par ON par.seqParentesco = hog.seqParentesco
            INNER JOIN T_CRU_RESULTADO res ON res.seqFormulario = frm.seqFormulario AND ciu.numDocumento = res.numDocumento
            WHERE res.seqCruce = " . $_POST['seqCruce'] . "          
              AND frm.seqFormulario IN ( " . implode( "," , $_POST['exportar'] ) . " )             
        ";
        
    } else {
        
        // consulta del listado de hogares seleccionados
        $sql = "
            SELECT 
                frm.seqFormulario,
                moa.txtModalidad,
                CONCAT( eta.txtEtapa , 
                        ' - ' , 
                        est.txtEstadoProceso 
                ) as txtEstadoProceso,
                tdo.txtTipoDocumento,
                ciu.numDocumento,
                UPPER( CONCAT( TRIM( ciu.txtNombre1 ), 
                        ' ' , 
                        if( TRIM( ciu.txtNombre2 ) <> '', 
                            CONCAT( TRIM( ciu.txtNombre2 ) , ' ' ), 
                            '' 
                        ) , 
                        TRIM( ciu.txtApellido1 ), 
                        ' ' , 
                        TRIM( ciu.txtApellido2 )
                ) ) as txtNombre,
                par.txtParentesco,
                '' as txtEntidad,
                '' as txtTitulo,
                '' as txtDetalle,
                'SI' as bolInhabilitar,
                '' as txtObservaciones
            FROM T_FRM_FORMULARIO frm
            INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
            INNER JOIN T_FRM_ESTADO_PROCESO est ON frm.seqEstadoProceso = est.seqEstadoProceso
            INNER JOIN T_FRM_ETAPA eta ON est.seqEtapa = eta.seqEtapa
            INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
            INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
            INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
            INNER JOIN T_CIU_PARENTESCO par ON par.seqParentesco = hog.seqParentesco
            WHERE frm.seqFormulario IN ( " . implode( "," , $_POST['exportar'] ) . " )     
        "; 
        
    }
    
    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
        $numLinea = count( $arrArchivo );
        $arrArchivo[ $numLinea ] = $objRes->fields;
        $objRes->MoveNext();
    }
    
    /****************************
     * EXPORTANDO EL RESULTADO
     ****************************/
    
    $txtArchivo = "";
    if( count( $arrArchivo ) > 1 ){
        foreach( $arrArchivo as $numLinea => $arrLinea ){
            $txtColor = "";
            if( $numLinea == 0 ){
                $txtColor = "background-color:#666666;color:white;text-align:center;";
            }else{
                $txtColor = ( fmod( $numLinea , 2 ) == 0 )? "background-color:#e4e4e4" : "background-color:#ffffff";
            }
            $txtArchivo .=  implode("\t", $arrLinea)."\r\n";
        }
    }
    //$txtArchivo .= "</table>";
    echo utf8_decode( $txtArchivo );
    
?>