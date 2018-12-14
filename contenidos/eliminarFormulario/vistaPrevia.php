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

// validaciones
if($_POST['seqTipoDocumento'] == 0){
    $arrErrores[] = "Seleccione el tipo de documento";
}

if(intval($_POST['numDocumento']) == 0){
    $arrErrores[] = "Debe dar un numero de documento";
}

if(empty($arrErrores)) {
    $claCiudadano = new Ciudadano();
    $seqFormulario = $claCiudadano->formularioVinculado2($_POST['numDocumento'],$_POST['seqTipoDocumento'],false,false);
    if($seqFormulario == 0){
        $arrErrores[] = "No existe formulario vinculado para el documento buscado";
    }else{
        $claFormulario = new FormularioSubsidios();
        $claFormulario->cargarFormulario($seqFormulario);
    }
}

$claSmarty->assign( "arrErrores"       , $arrErrores );
$claSmarty->assign( "arrEstados"       , $arrEstados );
$claSmarty->assign( "arrEtapa"         , $arrEtapa );
$claSmarty->assign( "arrModalidad"     , $arrModalidad );
$claSmarty->assign( "arrTipoEsquema"   , $arrTipoEsquema );
$claSmarty->assign( "arrSolucion"      , $arrSolucion );
$claSmarty->assign( "arrCiudad"        , $arrCiudad );
$claSmarty->assign( "arrLocalidad"     , $arrLocalidad );
$claSmarty->assign( "arrBarrio"        , $arrBarrio );
$claSmarty->assign( "arrParentesco"    , $arrParentesco );
$claSmarty->assign( "arrTipoDocumento" , $arrTipoDocumento );
$claSmarty->assign("arrPost"           , $_POST);
$claSmarty->assign( "claFormulario"    , $claFormulario );

$claSmarty->display( "eliminarFormulario/vistaPrevia.tpl" );

?>