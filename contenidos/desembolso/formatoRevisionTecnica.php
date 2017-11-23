<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );

include( "./datosComunes.php" );

$txtFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s");
$txtSoloFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y")));

$numDiaActual = date("d");
$txtMesActual = utf8_encode(ucwords(strftime("%B")));
$numAnoActual = date("Y");

$seqFormulario = $_GET['seqFormulario'];
$seqCasaMano = intval($_GET['seqCasaMano']);

$claFormulario = new FormularioSubsidios;
$claDesembolso = new Desembolso;

$claFormulario->cargarFormulario($seqFormulario);
if ($seqCasaMano != 0) {
    $claCasaMano = new CasaMano();
    $arrCasaMano = $claCasaMano->cargar($seqFormulario, $seqCasaMano);
    $objCasaMano = array_shift($arrCasaMano);


//    $claDesembolso = $objCasaMano->objRegistroOferta;
//    $claDesembolso->arrTecnico = $objCasaMano->objRevisionTecnica;

   // simulacion de la clase de desembolso para la plantilla
   $claDesembolso = new Desembolso();
   $claDesembolso->arrTecnico = $objCasaMano->objRevisionTecnica;
   foreach( $objCasaMano->objRegistroOferta as $txtClave => $txtValor ) {
      $claDesembolso->$txtClave = $txtValor;
   }


} else {
    $claDesembolso->cargarDesembolso($seqFormulario);
}

$txtFechaVisita = utf8_encode(ucwords(strftime("%A %#d de %B del %Y", strtotime($claDesembolso->arrTecnico['fchVisita']))));

foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        break;
    }
}

/* asignacion del numero de matricula profesion segun el usuario que imprima el estudio 
  68 -> fabio
  105 -> hugo
  110 -> eduardo

 */

switch ($_SESSION['seqUsuario']) {
    case 68:
        $txtMatriculaProfesional = "2570050993 CND";
        break;
    case 105:
        $txtMatriculaProfesional = "A20992010-80070556";
        break;
    case 110:
        $txtMatriculaProfesional = "25202127963 CND";
        break;
	case 422:
        $txtMatriculaProfesional = "A13832010-1018407205";
        break;
	case 423:
        $txtMatriculaProfesional = "25202-227575 CND";
        break;
    case 508:
        $txtMatriculaProfesional = "25202-329840 CND";
        break;
    default :
        $txtMatriculaProfesional = "________________________________________";
        break;
}

$claSeguimiento = new Seguimiento;
$claSeguimiento->seqFormulario = $_GET['seqFormulario'];

// desde aquí
$formularioActual = $_GET['seqFormulario'];
$sql = "SELECT T_PRY_PROYECTO.seqProyecto, txtNombreComercial
		FROM T_PRY_PROYECTO 
		LEFT JOIN T_PRY_UNIDAD_PROYECTO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
		WHERE seqFormulario = " . $formularioActual;
$objRes = $aptBd->execute( $sql );
while( $objRes->fields ){
	$idProyecto  = $objRes->fields['seqProyecto'];
	$nombreComercial  = $objRes->fields['txtNombreComercial'];
	$objRes->MoveNext();
}
// hasta aquí

$numRegistros = array_shift(array_keys($claSeguimiento->obtenerRegistros(1, 0)));

$claSmarty->assign("txtFuente12", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 12px;");
$claSmarty->assign("txtFuente10", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;");
$claSmarty->assign("txtFecha", $txtFecha);
$claSmarty->assign("txtSoloFecha", $txtSoloFecha);
$claSmarty->assign("claCiudadano", $objCiudadano);
$claSmarty->assign("claDesembolso", $claDesembolso);
$claSmarty->assign("claFormulario", $claFormulario);
$claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("txtFechaVisita", $txtFechaVisita);
$claSmarty->assign("numDiaActual", $numDiaActual);
$claSmarty->assign("txtMesActual", $txtMesActual);
$claSmarty->assign("numAnoActual", $numAnoActual);
$claSmarty->assign("numRegistro", $numRegistros);
$claSmarty->assign("nombreComercial", $nombreComercial);
$claSmarty->assign("txtMatriculaProfesional", $txtMatriculaProfesional);

$claSmarty->display("desembolso/formatoRevisionTecnica.tpl");

//	pr( $claDesembolso );
?>
