<?php

date_default_timezone_set("America/Bogota");

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
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CRM.class.php" );

$seqFormulario = $_POST['seqFormulario'];

include( "./datosComunes.php" );

$claFormulario = new FormularioSubsidios;
$claFormulario->cargarFormulario($seqFormulario);

//    if( in_array( $claFormulario->seqEstadoProceso , $claFlujoDesembolsos->arrFases[ $_POST['flujo'] ][ $_POST['fase'] ]['permisos'] ) ){
// obtiene los estados que corresponden al estado del proceso del formulario
$arrFlujoHogar = $claFlujoDesembolsos->obtenerFlujo($seqFormulario, $claFormulario->seqEstadoProceso, $_POST['flujo']);

// obtiene los seguimientos
$claSeguimiento = new Seguimiento;
$claSeguimiento->seqFormulario = $seqFormulario;
$arrRegistros = $claSeguimiento->obtenerRegistros(100);

// carga el egiastro de desembolso   
$claDesembolso = new Desembolso();
$claDesembolso->cargarDesembolso($seqFormulario);

$arrConvenio = obtenerDatosTabla(
    "v_frm_convenio",
    array("seqConvenio","txtConvenio","txtBanco"),
    "seqConvenio",
    "seqConvenio = " . $claFormulario->seqConvenio
)[$claFormulario->seqConvenio];

$claDesembolso->arrTitulos['fchEscrituraIdentificacionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchEscrituraIdentificacion']))));
$claDesembolso->arrTitulos['fchEscrituraTituloTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchEscrituraTitulo']))));
$claDesembolso->arrTitulos['fchMatriculaTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($claDesembolso->arrTitulos['fchMatricula']))));

// Obtiene el postulante principal
foreach ($claFormulario->arrCiudadano as $objCiudadano) {
    if ($objCiudadano->seqParentesco == 1) {
        $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
        break;
    }
}

// Obtiene la fecha de hoy
$txtHoy = utf8_encode(ucwords(strftime("%d de %B del %Y")));

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

// Carga el tutor que tiene asignado ese hogar
$claCRM = new CRM;
$txtTutor = $claCRM->obtenerTutorHogar($seqFormulario);
//echo "<br> ***************** " . $claDesembolso->arrJuridico['numResolucion'] . "*******<br>";
foreach ($arrActos as $txtClave => $arrInformacion) {
    if ($arrInformacion['acto']['tipo'] == 1) {
        if(in_array($arrInformacion['acto']['idEstadoProceso'],array(15,32,33,40,59))){
            $claDesembolso->arrJuridico['numResolucion'] = $arrInformacion['acto']['numero'];
            $claDesembolso->arrJuridico['fchResolucion'] = $arrInformacion['acto']['fecha'];
            $claDesembolso->arrJuridico['valResolucion'] = $arrInformacion['acto']['valor'];
            $claDesembolso->arrJuridico['fchResolucionTexto'] = utf8_encode(ucwords(strftime("%d de %B del %Y", strtotime($arrInformacion['acto']['fecha']))));
        }
    }
}
$claSmarty->assign("arrActos", $arrActos);
$claSmarty->assign("txtHoy", $txtHoy);
$claSmarty->assign("objCiudadano", $objCiudadano); // Postulante principal
$claSmarty->assign("claDesembolso", $claDesembolso);
$claSmarty->assign("arrRegistros", $arrRegistros); // Registros de seguimiento
$claSmarty->assign("claFormulario", $claFormulario);
$claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);
$claSmarty->assign("arrFlujoHogar", $arrFlujoHogar); // Flujo de datos aplicado al hogar        
$claSmarty->assign("arrConvenio", $arrConvenio);

$claSmarty->display($claFlujoDesembolsos->arrFases[$_POST['flujo']][$_POST['fase']]['plantilla']);

//    } else {
//		$arrEstados = estadosProceso();
//		$arrErrores[] = "Este hogar no se encuentra listo para realizar el proceso de desembolso, el estado actual es: " . $arrEstados[ $claFormulario->seqEstadoProceso ];
//		imprimirMensajes( $arrErrores , array() );
//	}
?>
