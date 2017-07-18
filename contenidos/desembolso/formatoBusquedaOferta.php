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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );

include( "./datosComunes.php" );

$txtFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s");

$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario($_GET['seqFormulario']);

// desde aquí
$formularioActual = $_GET['seqFormulario'];
$nombreComercial = '';
$sql = "SELECT T_PRY_PROYECTO.seqProyecto, txtNombreComercial
		FROM T_PRY_PROYECTO 
		LEFT JOIN T_PRY_UNIDAD_PROYECTO ON (T_PRY_PROYECTO.seqProyecto = T_PRY_UNIDAD_PROYECTO.seqProyecto)
		WHERE seqFormulario = " . $formularioActual;
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    $idProyecto = $objRes->fields['seqProyecto'];
    $nombreComercial = $objRes->fields['txtNombreComercial'];
    $objRes->MoveNext();
}
// hasta aquí

$arrBeneficiario = array();
foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $arrBeneficiario['nombre'] = $objCiudadano->txtNombre1 . " " . $objCiudadano->txtNombre2 . " " .
                $objCiudadano->txtApellido1 . " " . $objCiudadano->txtApellido2;
        $arrBeneficiario['tipoDocumento'] = $arrTipoDocumento[$objCiudadano->seqTipoDocumento];
        //$arrBeneficiario['documento'] = number_format( $objCiudadano->numDocumento , 0 , "." , "," );
        $arrBeneficiario['documento'] = $objCiudadano->numDocumento;
        break;
    }
}

$arrBeneficiario['modalidad'] = $arrModalidad[$claFormulario->seqModalidad];
$arrBeneficiario['valor'] = "\$ " . number_format($claFormulario->valAspiraSubsidio, 0, ".", ",");

// Obtiene los actos administrativos a los que se realaciona el postulante principal
$claActosAdministrativos = new ActoAdministrativo;
//$arrFormularioActo = $claActosAdministrativos->actoExisteCiudadano($arrBeneficiario['documento']);

// obtiene el ultimo acto adminsitrativo de asignacion
$arrResolucionAsignacion = array();
foreach ($arrFormularioActo as $seqFormularioActo) {
    $arrActoAdministrativo = $claActosAdministrativos->obtenerActoAdministrativo($seqFormularioActo);
    if ($arrActoAdministrativo['seqTipoActo'] == 1) {
        $arrResolucionAsignacion['numero'] = $arrActoAdministrativo['numActo'];
        $arrResolucionAsignacion['fecha'] = $arrActoAdministrativo['fchActo'];
    }
}

$arrBeneficiario['resolucion'] = $arrResolucionAsignacion['numero'] . " del " . $arrActoAdministrativo['fchActo'];
$arrBeneficiario['direccion'] = strtoupper($claFormulario->txtDireccion);
$arrBeneficiario['barrio'] = ( trim($claFormulario->txtBarrio) != "" ) ? strtoupper($claFormulario->txtBarrio) : obtenerNombres("T_FRM_BARRIO", "seqBarrio", $claFormulario->seqBarrio);
$arrBeneficiario['localidad'] = trim($arrLocalidad[$claFormulario->seqLocalidad]);
$arrBeneficiario['telefono1'] = $claFormulario->numTelefono1;
$arrBeneficiario['telefono2'] = $claFormulario->numTelefono2;
$arrBeneficiario['celular'] = $claFormulario->numCelular;

if (intval($_GET['seqCasaMano'])) {
    $seqCasaMano = $_GET['seqCasaMano'];
    $claCasaMano = new CasaMano();
    $arrCasaMano = $claCasaMano->cargar($_GET['seqFormulario']);
    $claDesembolso = $arrCasaMano[$seqCasaMano]->objRegistroOferta;
} else {
    $claDesembolso = new Desembolso;
    $claDesembolso->cargarDesembolso($_GET['seqFormulario']);
}

$claDesembolso->numNotaria = ( $claDesembolso->numNotaria == 0 ) ? "" : $claDesembolso->numNotaria;

if ($_GET['bolEscrituracion'] == 1) {
    foreach ($claDesembolso->arrEscrituracion as $txtClave => $txtValor) {
        $claDesembolso->$txtClave = $txtValor;
    }
    $numTotalFolios = (
            $claDesembolso->numEscrituraPublica +
            $claDesembolso->numCertificadoTradicion +
            $claDesembolso->numCartaAsignacion +
            $claDesembolso->numAltoRiesgo +
            $claDesembolso->numHabitabilidad +
            $claDesembolso->numBoletinCatastral +
            $claDesembolso->numLicenciaConstruccion +
            $claDesembolso->numUltimoPredial +
            $claDesembolso->numUltimoReciboAgua +
            $claDesembolso->numUltimoReciboEnergia +
            $claDesembolso->numActaEntrega +
            $claDesembolso->numCertificacionVendedor +
            $claDesembolso->numAutorizacionDesembolso +
            $claDesembolso->numFotocopiaVendedor +
            $claDesembolso->numOtros +
            $claDesembolso->numContratoArrendamiento +
            $claDesembolso->numAperturaCAP +
            $claDesembolso->numCedulaArrendador +
            $claDesembolso->numCuentaArrendador +
            $claDesembolso->numServiciosPublicos +
            $claDesembolso->numRetiroRecursos +
            $claDesembolso->numNit +
            $claDesembolso->numRit +
            $claDesembolso->numRut


            );
} else {

    $numTotalFolios = (
            $claDesembolso->numEscrituraPublica +
            $claDesembolso->numCertificadoTradicion +
            $claDesembolso->numCartaAsignacion +
            $claDesembolso->numAltoRiesgo +
            $claDesembolso->numHabitabilidad +
            $claDesembolso->numBoletinCatastral +
            $claDesembolso->numLicenciaConstruccion +
            $claDesembolso->numUltimoPredial +
            $claDesembolso->numUltimoReciboAgua +
            $claDesembolso->numUltimoReciboEnergia +
            $claDesembolso->numActaEntrega +
            $claDesembolso->numCertificacionVendedor +
            $claDesembolso->numAutorizacionDesembolso +
            $claDesembolso->numFotocopiaVendedor +
            $claDesembolso->numOtros +
            $claDesembolso->numContratoArrendamiento +
            $claDesembolso->numAperturaCAP +
            $claDesembolso->numCedulaArrendador +
            $claDesembolso->numCuentaArrendador +
            $claDesembolso->numServiciosPublicos +
            $claDesembolso->numRetiroRecursos
            );
}

$claSeguimiento = new Seguimiento;
$claSeguimiento->seqFormulario = $_GET['seqFormulario'];

$numRegistros = array_shift(array_keys($claSeguimiento->obtenerRegistros(1, 0)));

$claSmarty->assign("txtFuente12", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 12px;");
$claSmarty->assign("txtFuente10", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;");
$claSmarty->assign("txtFecha", $txtFecha);
$claSmarty->assign("arrBeneficiario", $arrBeneficiario);
$claSmarty->assign("claFormulario", $claFormulario);

if ($_GET['bolEscrituracion'] == 1) {
    foreach ($claDesembolso->arrEscrituracion as $txtClave => $txtValor) {
        $claDesembolso->$txtClave = $txtValor;
    }
}
$claSmarty->assign("claDesembolso", $claDesembolso);

$claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("numTotalFolios", $numTotalFolios);
$claSmarty->assign("numRegistro", $numRegistros);
$claSmarty->assign("nombreComercial", $nombreComercial);
$claSmarty->assign("arrResolucionAsignacion", $arrResolucionAsignacion);
$claSmarty->assign("seqCasaMano", $_GET['seqCasaMano']);

$claSmarty->display("desembolso/formatoBusquedaOferta.tpl");
?>
