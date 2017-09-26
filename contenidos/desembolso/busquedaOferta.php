<?php

/**
 * ARCHIVO PARA EL FORMULARIO
 * DE BUSQUEDA DE LA OFERTA
 */

$txtPrefijoRuta = "../../";

include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php");
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Grupo.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Desembolso.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php");
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php");

$seqFormulario = $_POST['seqFormulario'];

include("./datosComunes.php");

$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario($seqFormulario);

if (in_array($claFormulario->seqEstadoProceso, $claFlujoDesembolsos->arrFases[$_POST['flujo']][$_POST['fase']]['permisos'])) {

    // obtiene los estados que corresponden al estado del proceso del formulario
    $arrFlujoHogar = $claFlujoDesembolsos->obtenerFlujo($seqFormulario, $claFormulario->seqEstadoProceso, $_POST['flujo']);

    // Obtiene los datos del desembolso
    $claDesembolso = new Desembolso;
    $claDesembolso->cargarDesembolso($seqFormulario);

    $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claDesembolso->seqLocalidad, "txtBarrio");

    $claDesembolso->seqBarrio = array_shift(
        obtenerDatosTabla(
            "T_FRM_BARRIO",
            array("seqBarrio","txtBarrio"),
            "txtBarrio",
            "txtBarrio = '" . $claDesembolso->txtBarrio . "' and seqLocalidad = " . $claDesembolso->seqLocalidad
        )
    );

    // Obtienr los ultimos seguimientos
    $claSeguimiento = new Seguimiento;
    $claSeguimiento->seqFormulario = $seqFormulario;
    $arrRegistros = $claSeguimiento->obtenerRegistros(100);

    // Carga el tutor que tiene asignado ese hogar
    $claCRM = new CRM;
    $txtTutor = $claCRM->obtenerTutorHogar($seqFormulario);

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

   /*******************************************************************************************************
    * INFORMACION ACTO INDEXACION -- ESTOS ACTOS SON DEL MODULO DE PROYECTOS
    * **************************************************************************************************** */
   $sqlActoUnidad =  "
                SELECT 
                    uac.seqUnidadActo, 
                    uac.numActo, 
                    uac.fchActo, 
                    uac.txtDescripcion, 
                    uvi.valIndexado
                FROM T_PRY_AAD_UNIDAD_ACTO uac
                INNER JOIN T_PRY_AAD_UNIDADES_VINCULADAS uvi ON uac.seqUnidadActo = uvi.seqUnidadActo
                WHERE seqTipoActoUnidad = 2 
                AND uvi.seqUnidadProyecto = (
                      SELECT seqUnidadProyecto 
                      FROM T_FRM_FORMULARIO 
                      WHERE seqFormulario = $seqFormulario
                )
            ";
   $objRes = $aptBd->execute( $sqlActoUnidad );
   while( $objRes->fields ){
      $arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['seqUnidadActo']		= $objRes->fields['seqUnidadActo'];
      $arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['numActo']			= $objRes->fields['numActo'];
      $arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['fchActo']			= formatoFechaTextoFecha($objRes->fields['fchActo']);
      $arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['txtDescripcion']	= $objRes->fields['txtDescripcion'];
      $arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['valIndexado']		= $objRes->fields['valIndexado'];
      $objRes->MoveNext();
   }
   $claSmarty->assign("arrActosAsociados", $arrActosAsociados);

    $claSmarty->assign("arrActos", $arrActos); //  Pestania de actos administrativos
    $claSmarty->assign("arrRegistros", $arrRegistros); // Registros de seguimiento
    if ($_POST['fase'] == "escrituracion") {

        if (is_array($claDesembolso->arrEscrituracion)) {
            foreach ($claDesembolso->arrEscrituracion as $txtClave => $txtValor) {
                $claDesembolso->$txtClave = $txtValor;
            }

            $arrBarrio = obtenerDatosTabla(
                "T_FRM_BARRIO",
                array("seqBarrio", "txtBarrio"),
                "txtBarrio",
                "txtBarrio like '" . $claDesembolso->arrEscrituracion['txtBarrio'] . "' and seqLocalidad = " . $claDesembolso->arrEscrituracion['seqLocalidad']
            );

            $txtBarrio = strtoupper($claDesembolso->arrEscrituracion['txtBarrio']);
            $claDesembolso->seqBarrio = $arrBarrio[$txtBarrio];

            $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claDesembolso->arrEscrituracion['seqLocalidad'], "txtBarrio");

        }
    }
    $claSmarty->assign("claDesembolso", $claDesembolso);
    $claSmarty->assign("arrBarrio", $arrBarrio);
    $claSmarty->assign("claFormulario", $claFormulario);
    $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar); // Flujo de datos aplicado al hogar
    $claSmarty->assign("txtTutor", $txtTutor);
    $claSmarty->assign("txtFase", $_POST['fase']);
    $claSmarty->display($claFlujoDesembolsos->arrFases[$_POST['flujo']][$_POST['fase']]['plantilla']);

} else {
    $arrEstados = estadosProceso();
    $arrErrores[] = "Este hogar no se encuentra listo para realizar el proceso de desembolso, el estado actual es: " . $arrEstados[$claFormulario->seqEstadoProceso];
    imprimirMensajes($arrErrores, array());
}

?>
