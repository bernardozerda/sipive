<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Cruces.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );

$arrMiembros = array();

$claCruces = new Cruces();
$claCruces->cargar($_POST['seqCruce'], $_POST['seqFormulario']);

if($_POST['seqFormulario'] != 0) {
    $claFormulario = new FormularioSubsidios();
    $claFormulario->cargarFormulario($_POST['seqFormulario']);

    foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
        $bolIncluir = true;
        if ($claFormulario->seqPlanGobierno == 2 and (!in_array($objCiudadano->seqTipoDocumento, array(1, 2)))) {
            $bolIncluir = false;
        }
        if ($bolIncluir == true) {
            $arrMiembros[$objCiudadano->numDocumento] = mb_strtoupper(
                $objCiudadano->txtNombre1 . " " .
                $objCiudadano->txtNombre2 . " " .
                $objCiudadano->txtApellido1 . " " .
                $objCiudadano->txtApellido2
            );
        }
    }
}else{
    foreach($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrResultado){
        $numDocumento = $arrResultado['numDocumento'];
        $arrMiembros[$numDocumento] = mb_strtoupper($arrResultado['txtNombre']);
    }
}

foreach($claCruces->arrDatos['arrResultado'] as $seqResultado => $arrDatos){
    $seqFormulario = $arrDatos['seqFormulario'];
    $numDocumento = $arrDatos['numDocumento'];
    if(!isset($arrMiembros[$numDocumento])){
        $arrDatos[$numDocumento] = mb_strtoupper($arrDatos['txtNombre']);
    }
}

ksort($arrMiembros);

$txtCondicion = "";
if(isset($_SESSION['arrGrupos'][3][13]) and (! isset($_SESSION['arrGrupos'][3][20]))){
    $arrFuentesJuridicas = array(9,14,15);
    $txtCondicion = "seqFuente in (" . implode("," , $arrFuentesJuridicas) . ")";
}

$arrFuentes = obtenerDatosTabla(
    "t_cru_fuente",
    array("seqFuente","txtFuente"),
    "seqFuente",
    $txtCondicion,
    "txtFuente"
);

$arrErrores = array();
$arrMensajes = array();
$arrCausas = array();
if(intval($_POST['adicionar']) == 1){

    $arrCausas = obtenerDatosTabla(
        "t_cru_causa",
        array("seqCausa", "txtCausa"),
        "seqCausa",
        "seqFuente = " . $_POST['seqFuente'],
        "txtCausa"
    );

    if(intval($_POST['numDocumento']) == 0){
        $arrErrores[] = "Seleccione el miembro de hogar para quien desea registrar la inhabilidad";
    }

    if($_POST['seqFuente'] == 0){
        $arrErrores[] = "Seleccione la fuente de la inhabilidad";
    }

    if($_POST['seqCausa'] == 0){
        $arrErrores[] = "Seleccione la causa de la inhabilidad";
    }

    if($_POST['seqFuente'] != 8 and $_POST['txtDetalles'] == "") {
        $arrErrores[] = "Debe digitar el detalle de la inhabilidad";
    }

    if($_POST['seqFuente'] != 8 and $_POST['bolInhabilitar'] == 'no' and $_POST['txtObservaciones'] == "") {
        $arrErrores[] = "Debe digitar observaciones debido a que esta indicando una fuente pero solicita no inhabilitar el registro";
    }

    if($_POST['bolInhabilitar'] == ""){
        $arrErrores[] = "Seleccione si desea inhabilitar el registro o no";
    }elseif($_POST['bolInhabilitar'] == "si" and $_POST['seqFuente'] == 8){
        $arrErrores[] = "El valor del campo Inhabilitar no es válido";
    }

    if( empty( $arrErrores )){
        $claCruces->adicionar($_POST);
        $arrErrores = $claCruces->arrErrores;
        $arrMensajes = $claCruces->arrMensajes;
    }
}

imprimirMensajes($arrErrores,$arrMensajes);

$claSmarty->assign("arrCausas" , $arrCausas);
$claSmarty->assign("arrPost" , $_POST);
$claSmarty->assign("arrFuentes" , $arrFuentes);
$claSmarty->assign("arrMiembros" , $arrMiembros);
$claSmarty->assign( "claCruces", $claCruces );
$claSmarty->display( "cruces2/adicionar.tpl" );

?>
