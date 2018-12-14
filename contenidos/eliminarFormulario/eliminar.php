<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );

$arrErrores = array();

$arrEstados = obtenerDatosTabla(
    "v_frm_estado",
    array("seqEstadoProceso","txtEstado"),
    "seqEstadoProceso"
);

$arrModalidad = obtenerDatosTabla(
    "t_frm_modalidad",
    array("seqModalidad","txtModalidad"),
    "seqModalidad"
);

$arrTipoEsquema = obtenerDatosTabla(
    "t_pry_tipo_esquema",
    array("seqTipoEsquema","txtTipoEsquema"),
    "seqTipoEsquema"
);

$arrSolucion = obtenerDatosTabla(
    "t_frm_solucion",
    array("seqSolucion","txtSolucion"),
    "seqSolucion"
);

$arrCiudad = obtenerDatosTabla(
    "v_frm_ciudad",
    array("seqCiudad","txtCiudad"),
    "seqCiudad"
);

$arrLocalidad = obtenerDatosTabla(
    "t_frm_localidad",
    array("seqLocalidad","txtLocalidad"),
    "seqLocalidad"
);

$arrBarrio = obtenerDatosTabla(
    "t_frm_barrio",
    array("seqBarrio","txtBarrio"),
    "seqBarrio"
);

$arrTipoDocumento = obtenerDatosTabla(
    "t_ciu_tipo_documento",
    array("seqTipoDocumento","txtTipoDocumento"),
    "seqTipoDocumento"
);

$arrParentesco = obtenerDatosTabla(
    "t_ciu_parentesco",
    array("seqParentesco","txtParentesco"),
    "seqParentesco"
);

$sql = "select seqEstadoProceso, seqEtapa from t_frm_estado_proceso";
$objRes = $aptBd->execute($sql);
$arrEtapa = array();
while($objRes->fields){
    $seqEstadoProceso = $objRes->fields['seqEstadoProceso'];
    $seqEtapa = $objRes->fields['seqEtapa'];
    $arrEtapa[$seqEstadoProceso] = $seqEtapa;
    $objRes->MoveNext();
}

if(trim($_POST['txtComentario']) == ""){
    $arrErrores[] = "Digite el comentario para la eliminación";
}

$claCiudadano = new Ciudadano();
$txtNombre = $claCiudadano->obtenerNombre($_POST['numDocumento']);
$seqFormulario = $claCiudadano->formularioVinculado2($_POST['numDocumento'], $_POST['seqTipoDocumento'], false, false);
if ($seqFormulario == 0) {
    $arrErrores[] = "No existe formulario vinculado para el documento buscado";
} else {
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($seqFormulario);
    $seqEstadoProceso = $claFormulario->seqEstadoProceso;
    if ($arrEtapa[$seqEstadoProceso] != 1) {
        $arrErrores[] = "El formulario no se puede eliminar porque no está en la etapa de Inscripción";
    } else {

        try{

            $aptBd->BeginTrans();

            $arrSql[] = "SET foreign_key_checks = 0";
            $arrSql[] = "DELETE FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS WHERE seqFormulario = " . $_POST['seqFormulario'] . ";";
            $arrSql[] = "DELETE FROM T_SEG_SEGUIMIENTO WHERE seqFormulario = " . $_POST['seqFormulario'] . ";";
            $arrSql[] = "DELETE FROM T_FRM_HOGAR WHERE seqFormulario = " . $_POST['seqFormulario'] . ";";
            $arrSql[] = "DELETE FROM T_FRM_FORMULARIO WHERE seqFormulario = " . $_POST['seqFormulario'] . ";";
            $arrSql[] = "UPDATE T_PRY_UNIDAD_PROYECTO SET seqFormulario = null WHERE seqFormulario = " . $_POST['seqFormulario'] . ";";

            // Borrado de los ciudadanos
            foreach( $claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano ){
                $arrSql[] = "DELETE FROM T_CIU_CIUDADANO WHERE seqCiudadano = " . $seqCiudadano . ";";
            }
            $arrSql[] = "SET foreign_key_checks = 1";
            foreach( $arrSql as $sql ){
                $aptBd->execute( $sql );
            }

            $sql = "
                INSERT INTO T_FRM_BORRADO (
                    seqFormulario,
                    seqTipoDocumento,
                    numDocumento,
                    txtNombre,
                    fchBorrado,
                    txtComentario
                ) VALUES (
                    " . $_POST['seqFormulario'] . ",
                    " . $_POST['seqTipoDocumento'] . ",
                    " . $_POST['numDocumento'] . ",
                    '" . $txtNombre . "',
                    NOW(),
                    '" . $_POST['txtComentario'] . "'
                )
            ";
            $aptBd->execute($sql);

            $txtMensaje = "El formulario asociado al ciudadano identificado con el número de documento " . number_format( $_POST['numDocumento'] ) . " ha sido eliminado";

            $aptBd->CommitTrans();

        }catch(Exception $objError){
            $arrErrores[] = "Hubo problemas al momento de eliminar el formulario";
            $arrErrores[] = $objError->getMessage();
            $aptBd->Rollbacktrans();
        }
    }
}

//$arrErrores[] = "Error de prueba";

if(empty($arrErrores)){
    $sql = "
        SELECT 
            bor.seqFormulario,
            tdo.txtTipoDocumento,
            bor.numDocumento,
            bor.txtNombre,
            bor.fchBorrado,
            bor.txtComentario
        FROM t_frm_borrado bor
        INNER JOIN t_ciu_tipo_documento tdo ON tdo.seqTipoDocumento = bor.seqTipoDocumento
        ORDER BY bor.fchBorrado DESC
    ";
    $arrBorrados = $aptBd->GetAll($sql);

    $claSmarty->assign("txtMensaje"       , $txtMensaje);
    $claSmarty->assign("arrBorrados"      , $arrBorrados );
    $claSmarty->assign("arrTipoDocumento" , $arrTipoDocumento);
    $claSmarty->display( "eliminarFormulario/buscar.tpl" );
}else{
    $claSmarty->assign("arrErrores"       , $arrErrores );
    $claSmarty->assign("arrEstados"       , $arrEstados );
    $claSmarty->assign("arrEtapa"         , $arrEtapa );
    $claSmarty->assign("arrModalidad"     , $arrModalidad );
    $claSmarty->assign("arrTipoEsquema"   , $arrTipoEsquema );
    $claSmarty->assign("arrSolucion"      , $arrSolucion );
    $claSmarty->assign("arrCiudad"        , $arrCiudad );
    $claSmarty->assign("arrLocalidad"     , $arrLocalidad );
    $claSmarty->assign("arrBarrio"        , $arrBarrio );
    $claSmarty->assign("arrParentesco"    , $arrParentesco );
    $claSmarty->assign("arrTipoDocumento" , $arrTipoDocumento );
    $claSmarty->assign("arrPost"          , $_POST);
    $claSmarty->assign("claFormulario"    , $claFormulario );
    $claSmarty->display( "eliminarFormulario/vistaPrevia.tpl" );
}





?>