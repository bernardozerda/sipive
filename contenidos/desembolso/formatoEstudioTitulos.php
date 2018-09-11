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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );

include( "./datosComunes.php" );

$txtFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s");

$seqFormulario = $_GET['seqFormulario'];

$claFormulario = new FormularioSubsidios;
$claDesembolso = new Desembolso;

$claFormulario->cargarFormulario($seqFormulario);
$claDesembolso->cargarDesembolso($seqFormulario);
$numDoc = 0;
foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $numDoc = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
        break;
    }
}

$claDesembolso->arrTitulos['fchEscrituraIdentificacionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchEscrituraIdentificacion']))));
$claDesembolso->arrTitulos['fchEscrituraTituloTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchEscrituraTitulo']))));
$claDesembolso->arrTitulos['fchMatriculaTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchMatricula']))));

$claSeguimiento = new Seguimiento;
$claSeguimiento->seqFormulario = $_GET['seqFormulario'];
$claActosAdministrativos = new ActoAdministrativo();
$arrActos = $claActosAdministrativos->cronologia($numDoc);

//echo "<br> ***************** ".$claDesembolso->arrJuridico['numResolucion']."********<br>";
$fecha = strtotime('2009-01-01');
if ($claDesembolso->arrJuridico['numResolucion'] == 0) {
    foreach ($arrActos as $txtClave => $arrInformacion) {
        if ($arrInformacion['acto']['tipo'] == 1) {

            $fecha2 = formatoFechaGeneral($arrInformacion['acto']['fecha']);

            if ($fecha2 > $fecha) {
                $fecha = $fecha2;
                $claDesembolso->arrJuridico['numResolucion'] = $arrInformacion['acto']['numero'];
                $claDesembolso->arrJuridico['fchResolucion'] = $arrInformacion['acto']['fecha'];
                $claDesembolso->arrJuridico['valResolucion'] = $arrInformacion['acto']['valor'];
                $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($arrInformacion['acto']['fecha']))));
            }

        }
    }
}

// desde aquí
$formularioActual = $_GET['seqFormulario'];
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

$numRegistros = array_shift(array_keys($claSeguimiento->obtenerRegistros(1, 0)));

// si es modalidad de leasing carga los datos del contrato
$arrContratoLeasing = array();
if($claFormulario->seqModalidad == 13){

    $seqEscrituracion = $claDesembolso->arrEscrituracion['seqEscrituracion'];
    $arrContratoLeasing = obtenerDatosTabla(
        "t_des_escrituracion",
        array("seqEscrituracion","numContratoLeasing","fchContratoLeasing"),
        "seqEscrituracion",
        "seqEscrituracion = " . $seqEscrituracion
    )[$seqEscrituracion];
    $arrContratoLeasing['txtFechaLeasing'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($arrContratoLeasing['fchContratoLeasing']))));

    $arrConvenio = obtenerDatosTabla(
        "v_frm_convenio",
        array("seqConvenio","txtConvenio","txtBanco"),
        "seqConvenio",
        "seqConvenio = " . $claFormulario->seqConvenio
    )[$claFormulario->seqConvenio];

}


// Obtiene el postulante principal
foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
        break;
    }
}

// obtiene la informacion de la pestana de actos administrativos
$claActosAdministrativos = new ActoAdministrativo();
$arrActos = $claActosAdministrativos->cronologia($numDocumento);

foreach ($arrActos as $txtClave => $arrInformacion) {
    if ($arrInformacion['acto']['tipo'] == 1) {
        if(in_array($arrInformacion['acto']['idEstadoProceso'],array(15,32,33,40,59))) {
            $claDesembolso->arrJuridico['numResolucion'] = $arrInformacion['acto']['numero'];
            $claDesembolso->arrJuridico['fchResolucion'] = $arrInformacion['acto']['fecha'];
            $claDesembolso->arrJuridico['valResolucion'] = $arrInformacion['acto']['valor'];
            $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($arrInformacion['acto']['fecha']))));
        }
    }
}

$claSmarty->assign("txtFuente12", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 11px;");
$claSmarty->assign("txtFuente10", "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;");
$claSmarty->assign("txtFecha", $txtFecha);
$claSmarty->assign("claCiudadano", $objCiudadano);
$claSmarty->assign("claDesembolso", $claDesembolso);
$claSmarty->assign("claFormulario", $claFormulario);
$claSmarty->assign("nombreComercial", $nombreComercial);
$claSmarty->assign("txtUsuarioSesion", utf8_encode($_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']));
$claSmarty->assign("numRegistro", $numRegistros);
$claSmarty->assign("arrContratoLeasing", $arrContratoLeasing);
$claSmarty->assign("arrConvenio", $arrConvenio);

$claSmarty->display("desembolso/formatoEstudioTitulos.tpl");
?>
