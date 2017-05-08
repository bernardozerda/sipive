<?php
    
    /**
	 * OBTIENE LOS HOGARES LISTOS PARA EL CRUCE Y LOS LISTA EN PANTALLA
	 * @author Bernardo Zerda
	 * @version 1.0 Dic 2013
	 */

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    
    // Estados listos para cruzar
    $arrInscripcion = ( isset( $_POST['estados']['inscripcion'] ) )? $_POST['estados']['inscripcion'] : array();
    $arrPostulacion = ( isset( $_POST['estados']['postulacion'] ) )? $_POST['estados']['postulacion'] : array();
    
    // para cargar el listado de hogares
    $arrHogares = array();
    $arrEstados = estadosProceso();
    
    //si hay estados dentro de la tabla
    if( ! empty( $_POST['estados'] ) ){
        
        $sqlInscripcion = "";
        if( ! empty( $arrInscripcion ) ){
            $sqlInscripcion = "
                SELECT
                    frm.seqFormulario
                FROM T_FRM_FORMULARIO frm
                INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                WHERE frm. seqEstadoProceso in (" . implode ( "," , $arrInscripcion ) . ")
                AND hog.seqParentesco = 1
                ORDER BY ciu.numDocumento
            ";
        }
        
        $sqlPostulacion = "";
        if( ! empty( $arrPostulacion ) ){
            $sqlPostulacion = "
                SELECT
                    frm.seqFormulario
                FROM T_FRM_FORMULARIO frm
                INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                WHERE frm. seqEstadoProceso in (" . implode ( "," , $arrPostulacion ) . ")
                AND hog.seqParentesco = 1                
                ORDER BY ciu.numDocumento
            ";
        }
        
        $sql = "";
        if( $sqlInscripcion != "" ){
            $sql = ( $sqlPostulacion == "" )? $sqlInscripcion : "(" . $sqlInscripcion . ") UNION (" . $sqlPostulacion . ")";
        }else{
            $sql = $sqlPostulacion;
        }
        
        $objRes = $aptBd->execute( $sql );
        while( $objRes->fields ){
            
            $seqFormulario = $objRes->fields['seqFormulario'];
            $claFormulario = new FormularioSubsidios;
            $claFormulario->cargarFormulario($seqFormulario);
            
            $bolIncluir = true;
            if( $claFormulario->seqEstadoProceso == 7 and $claFormulario->bolCerrado == 0 ){
                $bolIncluir = false;
            }
            
            if( $bolIncluir ){
                $txtNombre = "";
                foreach( $claFormulario->arrCiudadano as $objCiudadano ){
                    if( $objCiudadano->seqParentesco == 1 ){
                        $txtNombre = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " . 
                                     $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
                        break;
                    }
                }
                $arrHogares[ $seqFormulario ]['documento'] = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento );
                $arrHogares[ $seqFormulario ]['nombre']    = $txtNombre;
                $arrHogares[ $seqFormulario ]['estado']    = $arrEstados[ $claFormulario->seqEstadoProceso ];
            }
            
            $objRes->MoveNext();
        }
    }
    
    $claSmarty->assign( "arrHogares" , $arrHogares );
    $claSmarty->display( "cruces/listosCruce.tpl" );
?>
