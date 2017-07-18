<?php

$txtPrefijoRuta = "../../";
include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php");

include("../desembolso/datosComunes.php");

// simula el flujo del hogar en desembolsos para efectos de la plantilla
$arrFlujoHogar['flujo'] = "cem";
$arrFlujoHogar['fase'] = "revisionJuridica";

// Los estados del proceso se cargan para las traducciones en las plantillas
$arrEstados = estadosProceso();

// carga los datos del hogar
$claFormulario = new FormularioSubsidios();
$claFormulario->cargarFormulario($_POST['seqFormulario']);
$claFormulario->txtBarrio = $arrBarrio[$claFormulario->seqBarrio];

// Obtiene el postulante principal
foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
        break;
    }
}

// obtieene los permisos para saber a donde puede entrar
$claCasaMano = new CasaMano();

$objCasaMano = null;
if (intval($_POST['seqFormulario']) != 0 and intval($_POST['seqCasaMano']) != 0) {
    $arrCasaMano = $claCasaMano->cargar($_POST['seqFormulario'], $_POST['seqCasaMano']);
    $objCasaMano = array_shift($arrCasaMano);
}

// simulacion de la clase de desembolso para la plantilla
$claDesembolso = $objCasaMano->objRegistroOferta;
$claDesembolso->arrJuridico = $objCasaMano->objRevisionJuridica;

$bolPermiso = $objCasaMano->puedeIngresar($arrFlujoHogar);
if ($bolPermiso == true) {

    // Obtienr los ultimos seguimientos
    $claSeguimiento = new Seguimiento;
    $claSeguimiento->seqFormulario = $_POST['seqFormulario'];
    $arrRegistros = $claSeguimiento->obtenerRegistros(100);

    // Carga el tutor que tiene asignado ese hogar
    $claCRM = new CRM;
    $txtTutor = $claCRM->obtenerTutorHogar($_POST['seqFormulario']);

    // obtiene la informacion de la pestana de actos administrativos
    $claActosAdministrativos = new ActoAdministrativo();
    $arrActos = $claActosAdministrativos->cronologia($numDocumento);

    $txtImprimir = "desembolsoRevisionJuridica( " . $_POST['seqFormulario'] . " , " . $_POST['seqCasaMano'] . " )";

    $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "bolActivo DESC, txtParentesco");

    $claSmarty->assign( "arrParentesco" , $arrParentesco );
    $claSmarty->assign("arrActos", $arrActos);
    $claSmarty->assign("txtTutor", $txtTutor);
    $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar);
    $claSmarty->assign("arrRegistros", $arrRegistros);
    $claSmarty->assign("claFlujoDesembolsos", $claCasaMano); // claFlujoDesembolsos es emulado por claCasaMano
    $claSmarty->assign("claDesembolso", $claDesembolso); // Emula la clase de desembolsos para la plantilla}
    $claSmarty->assign("arrEstados", $arrEstados);
    $claSmarty->assign("claFormulario", $claFormulario);
    $claSmarty->assign("seqFormulario", $_POST['seqFormulario']);
    $claSmarty->assign("seqCasaMano", intval($_POST['seqCasaMano']));
    $claSmarty->assign("cedula", $_POST['cedula']);
    $claSmarty->assign("objCiudadano", $objCiudadano);
    $claSmarty->assign("txtImprimir", $txtImprimir);
    $claSmarty->assign("numConcepto", $objCasaMano->bolRevisionJuridica);
    $claSmarty->assign("txtUsuarioSesion", ucwords(strtolower($_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'])));
    $claSmarty->assign("bolModificar", intval($_POST['modificar']));
    $claSmarty->display("casaMano/fasesCEM.tpl");

} else {
    $arrMensaje = $objCasaMano->arrErrores;
    $claSmarty->assign("estilo", "msgError");
    $claSmarty->assign("arrImprimir", $arrMensaje);
    $claSmarty->display("mensajes.tpl");
}

?>