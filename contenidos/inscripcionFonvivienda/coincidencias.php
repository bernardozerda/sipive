<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "InscripcionFonvivienda.class.php" );

$seqCargue = intval($_POST['seqCargue']);
$numHogar = intval($_POST['numHogar']);
$numDocumento = doubleval($_POST['numDocumento']);
$txtNombre = trim($_POST['txtNombre']);

$arrEstados = estadosProceso();
$arrParentescos = obtenerDatosTabla(
    "t_ciu_parentesco",
    array("seqParentesco","txtParentesco"),
    "seqParentesco"
);
$arrTiposDocumento = obtenerDatosTabla(
    "t_ciu_tipo_documento",
    array("seqTipoDocumento","txtTipoDocumento"),
    "seqTipoDocumento"
);

$claInscripcion = new InscripcionFonvivienda();
$claInscripcion->cargar($seqCargue,$numHogar);

// obtiene los datos adicionales del ciudadano coincidente
foreach($claInscripcion->arrHogares[$numHogar]['ciudadanos'] as $idCiudadano => $arrCiudadano){
    if($arrCiudadano['numDocumento'] == $numDocumento) {
        foreach ($arrCiudadano['coincidencias'] as $numDistancia => $arrCoincidencias) {
            foreach ($arrCoincidencias as $numDocumentoCoincidencia => $txtNombreCoincidencia) {

                $claCiudadano = new Ciudadano();
                $seqFormulario = $claCiudadano->formularioVinculado($numDocumentoCoincidencia,false,false);

                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($seqFormulario);

                foreach($claFormulario->arrCiudadano as $seqCiudadanoCoincidencia => $objCiudadano){
                    if($numDocumentoCoincidencia == $objCiudadano->numDocumento){
                        break;
                    }
                }

                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia] = array();
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['ciudadano'] = $seqCiudadanoCoincidencia;
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['nombre'] = $txtNombreCoincidencia;
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['formulario'] = $seqFormulario;
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['idEstado'] = $claFormulario->seqEstadoProceso;
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['estado'] = $arrEstados[ $claFormulario->seqEstadoProceso ];
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['parentesco'] = $arrParentescos[ $objCiudadano->seqParentesco ];
                $claInscripcion->arrHogares[$numHogar]['ciudadanos'][$idCiudadano]['coincidencias'][$numDistancia][$numDocumentoCoincidencia]['tipoDocumento'] = $arrTiposDocumento[ $objCiudadano->seqTipoDocumento ];

            }
        }
    }
}

$claSmarty->assign("seqCargue" , $seqCargue);
$claSmarty->assign("numHogar" , $numHogar);
$claSmarty->assign("numDocumento" , $numDocumento);
$claSmarty->assign("txtNombre" , $txtNombre);
$claSmarty->assign("claInscripcion" , $claInscripcion);
$claSmarty->display("inscripcionFonvivienda/coincidencias.tpl");

?>