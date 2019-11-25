<?php

/**
 * ARCHIVO DE ENTRADA PARA EL ENRUTAMIENTO DE LOS
 * HOGARES PARA POSTULACION PLAN DE GOBIERNO 2 Y 3
 * INCLUIDO ESQUEMA DE PROYECTOS FUERA DE LA SECRETARÍA
 * Y ESQUEMA DE RETORNO O REUBICACION
 * **** BASADO EN LA EL CODIGO FUENTE DE CASA EN MANO ****
 * @author Bernardo Zerda <bzerdar@habitatbogota.gov.co>
 * @version 2.0 Mayo de 2017
 */
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

if (empty($_POST)) {
    $claSmarty->assign("txtFuncion", "buscarCedula('casaMano/casaMano')");
    $claSmarty->display("subsidios/buscarCedula.tpl");
} else {

    $claCiudadano = new Ciudadano();
    $claCasaMano = new CasaMano();
    $claSeguimiento = new Seguimiento();
    $arrErrores = array();
    $arrPermisosSubfases = array();

    // ciudadano para obtener el formulario vinculado
    $_POST['cedula'] = mb_ereg_replace("[^0-9]", "", $_POST['cedula']);
    $seqFormulario = $claCiudadano->formularioVinculado($_POST['cedula'], false, false);

    // Si el ciudadano no esta relacionado con algun formulario
    if ($seqFormulario == 0) {
        $arrErrores = $claCiudadano->arrErrores;
    } else {

        // obtiene la informacion del hogar
        $arrCasaMano = $claCasaMano->cargar($seqFormulario);
        $claCasaMano = end($arrCasaMano);

        // enrutamiento para el flujo del proceso
        // directo al formulario de postulacion si es
        // - Plan de gobierno 2
        // - Plan de gobierno 3 con esquema de CF - PROYECTO SDHT
        $arrFlujoHogar['flujo'] = "";
        $arrFlujoHogar['fase'] = "";
        if (
                in_array($claCasaMano->objPostulacion->seqModalidad, $claCasaMano->arrFases['pin']['modalidad']) and
                in_array($claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->arrFases['pin']['esquema'])
        ) {
            $arrFlujoHogar['flujo'] = "pin";
            $arrFlujoHogar['fase'] = "postulacion";
            $txtPlantilla = $claCasaMano->arrFases['pin']['postulacion']['plantilla'];
            $arrEstadosFlujo['atras'] = $claCasaMano->arrFases['pin']['postulacion']['atras'];
            $arrEstadosFlujo['adelante'] = $claCasaMano->arrFases['pin']['postulacion']['adelante'];
        } elseif (
                in_array($claCasaMano->objPostulacion->seqModalidad, $claCasaMano->arrFases['cem']['modalidad']) and
                in_array($claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->arrFases['cem']['esquema'])
        ) {
            $arrFlujoHogar['flujo'] = "cem";
            $arrFlujoHogar['fase'] = "panelHogar";
            $txtPlantilla = $claCasaMano->arrFases["cem"]["panelHogar"]["plantilla"];
            $arrEstadosFlujo = array();
        }
        $txtFlujo = $arrFlujoHogar['flujo'];
        $txtFase = $arrFlujoHogar['fase'];
        $txtArchivo = $claCasaMano->arrFases[$txtFlujo][$txtFase]['salvar'];
    }

    if (empty($arrErrores)) {
        // obtieene los permisos para saber a donde puede entrar
        $bolPermiso = $claCasaMano->puedeIngresar($arrFlujoHogar);
        if ($bolPermiso == false) {
            $arrErrores = $claCasaMano->arrErrores;
        }

        // obtiene los permisos de las subfases para bloquear los accesos desde el panel
        $arrPermisoPanel = array();
        foreach ($claCasaMano->arrFases['cem'] as $txtFase => $arrPermisos) {
            $arrPermisoPanel[$txtFase] = $claCasaMano->puedeIngresar(["flujo" => "cem", "fase" => $txtFase]);
        }
      
    }

    if (empty($arrErrores)) {

        // Informacion de los select que hay en el formulario
        $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento", "seqTipoDocumento not in (6,8)", "txtTipoDocumento");
        $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
        $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
        $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
        $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil", "bolActivo"), "seqEstadoCivil", "", "bolActivo DESC, txtEstadoCivil");
        $arrVivienda = obtenerDatosTabla("T_FRM_VIVIENDA", array("seqVivienda", "txtVivienda"), "seqVivienda", "", "txtVivienda");
        $arrTipoFinanciacion = obtenerDatosTabla("T_FRM_TIPO_FINANCIACION", array("seqTipoFinanciacion", "txtTipoFinanciacion"), "seqTipoFinanciacion", "", "seqTipoFinanciacion");
        $arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben", "bolActivo"), "seqSisben", "", "bolActivo DESC");
        $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
        $arrEstados = estadosProceso();
        $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "bolActivo DESC, txtParentesco");
        $arrCondicionEspecial = obtenerDatosTabla("T_CIU_CONDICION_ESPECIAL", array("seqCondicionEspecial", "txtCondicionEspecial"), "seqCondicionEspecial", "seqCondicionEspecial <> 6", "txtCondicionEspecial");
        $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia", "seqEtnia > 1", "txtEtnia");
        $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion", "seqOcupacion <> 20", "txtOcupacion");
        $arrCiudad = obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad = 149", "txtCiudad");
        $arrCiudad += obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad <> 149", "txtCiudad");
        $txtCondicion = ($claCasaMano->objPostulacion->seqCiudad == 149) ? "seqLocalidad not in (1,22)" : "seqLocalidad in (22)";
        $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", $txtCondicion);
        natsort($arrLocalidad);
        $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "txtDescripcion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1 and seqModalidad = " . $claCasaMano->objPostulacion->seqModalidad);
        $arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo", "seqNivelEducativo > 1", "txtNivelEducativo");
        $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud", "seqSalud <> 0", "txtSalud", "", "txtSalud");
        $arrDonantes = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array("seqEmpresaDonante", "txtEmpresaDonante"), "seqEmpresaDonante", "seqEmpresaDonante > 1", "txtEmpresaDonante");
        $arrEntidadSubsidio = obtenerDatosTabla("T_FRM_ENTIDAD_SUBSIDIO", array("seqEntidadSubsidio", "txtEntidadSubsidio"), "seqEntidadSubsidio", "", "seqEntidadSubsidio");
        $arrGrupoGestion = obtenerDatosTabla("T_SEG_GRUPO_GESTION", array("seqGrupoGestion", "txtGrupoGestion"), "seqGrupoGestion", "seqGrupoGestion NOT IN ( 15,5,10,12,17,20 )", "txtGrupoGestion");
        $arrPlanGobierno = obtenerDatosTabla("T_FRM_PLAN_GOBIERNO", array("seqPlanGobierno", "txtPlanGobierno"), "seqPlanGobierno", "", "txtPlanGobierno");
        $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $claCasaMano->objPostulacion->seqPlanGobierno, "seqPlanGobierno DESC, txtModalidad");
        $arrTipoEsquemas = obtenerTipoEsquema($claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqPlanGobierno, $claCasaMano->objPostulacion->bolDesplazado);
        $arrProyectos = obtenerProyectosPostulacion($claCasaMano->objPostulacion->seqFormulario, $claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->objPostulacion->seqPlanGobierno);
        $arrProyectosHijos = obtenerProyectosHijosPostulacion($claCasaMano->objPostulacion->seqFormulario, $claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->objPostulacion->seqPlanGobierno, $claCasaMano->objPostulacion->seqProyecto);
        if ($claCasaMano->objPostulacion->seqProyectoHijo != 0) {
            $seqProyecto = $claCasaMano->objPostulacion->seqProyectoHijo;
        } else {
            $seqProyecto = $claCasaMano->objPostulacion->seqProyecto;
        }
        $arrUnidadProyecto = obtenerUnidadesPostulacion($claCasaMano->objPostulacion->seqFormulario, $claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->objPostulacion->seqPlanGobierno, $seqProyecto);
        $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claCasaMano->objPostulacion->seqLocalidad, "txtBarrio");
        $arrConvenio = obtenerDatosTabla("V_FRM_CONVENIO", array("seqConvenio", "txtConvenio", "txtBanco", "numCupos", "numOcupados", "numDisponibles", "valCupos"), "seqConvenio", "seqConvenio <> 1 and numDisponibles > 0", "txtConvenio");

        // Calculo del valor del subsidio

        $arrayProvisional[] = 7204;
        $arrayProvisional[] = 10640;
        $arrayProvisional[] = 16890;
        $arrayProvisional[] = 31668;
        $arrayProvisional[] = 46670;
        $arrayProvisional[] = 90668;
        $arrayProvisional[] = 92243;
        $arrayProvisional[] = 128128;
        $arrayProvisional[] = 159367;
        $arrayProvisional[] = 167904;
        $arrayProvisional[] = 190161;
        $arrayProvisional[] = 190834;
        $arrayProvisional[] = 191717;
        $arrayProvisional[] = 201229;
        $arrayProvisional[] = 202946;
        $arrayProvisional[] = 203251;
        $arrayProvisional[] = 208543;
        $arrayProvisional[] = 208725;
        $arrayProvisional[] = 208727;
        $arrayProvisional[] = 208740;
        $arrayProvisional[] = 208763;
        $arrayProvisional[] = 208777;
        $arrayProvisional[] = 208786;
        $arrayProvisional[] = 208787;
        $arrayProvisional[] = 208793;
        $arrayProvisional[] = 208913;
        $arrayProvisional[] = 208998;
        $arrayProvisional[] = 209039;
        $arrayProvisional[] = 209052;
        $arrayProvisional[] = 209054;
        $arrayProvisional[] = 209135;
        $arrayProvisional[] = 209562;
        $arrayProvisional[] = 209653;
        $arrayProvisional[] = 209674;
        $arrayProvisional[] = 209813;
        $arrayProvisional[] = 213085;
        $arrayProvisional[] = 213359;
        $arrayProvisional[] = 214813;
        $arrayProvisional[] = 214871;
        $arrayProvisional[] = 214873;
        $arrayProvisional[] = 214922;
        $arrayProvisional[] = 215364;
        $arrayProvisional[] = 215523;
        $arrayProvisional[] = 216739;
        $arrayProvisional[] = 225187;
        $arrayProvisional[] = 225398;
        $arrayProvisional[] = 225632;
        $arrayProvisional[] = 225705;
        $arrayProvisional[] = 226616;
        $arrayProvisional[] = 228852;
        $arrayProvisional[] = 229592;
        $arrayProvisional[] = 229806;
        $arrayProvisional[] = 229817;
        $arrayProvisional[] = 231698;
        $arrayProvisional[] = 233195;
        $arrayProvisional[] = 233377;
        $arrayProvisional[] = 234184;
        $arrayProvisional[] = 236736;
        $arrayProvisional[] = 238100;
        $arrayProvisional[] = 238226;
        $arrayProvisional[] = 238563;
        $arrayProvisional[] = 240101;
        $arrayProvisional[] = 240401;
        $arrayProvisional[] = 241386;
        $arrayProvisional[] = 242255;
        $arrayProvisional[] = 243559;
        $arrayProvisional[] = 243827;
        $arrayProvisional[] = 244173;
        $arrayProvisional[] = 244193;
        $arrayProvisional[] = 244344;
        $arrayProvisional[] = 247978;
        $arrayProvisional[] = 248036;
        $arrayProvisional[] = 248259;
        $arrayProvisional[] = 248505;
        $arrayProvisional[] = 248512;
        $arrayProvisional[] = 248542;
        $arrayProvisional[] = 248554;
        $arrayProvisional[] = 248559;
        $arrayProvisional[] = 248752;
        $arrayProvisional[] = 248883;
        $arrayProvisional[] = 248955;
        $arrayProvisional[] = 248964;
        $arrayProvisional[] = 249183;
        $arrayProvisional[] = 249275;
        $arrayProvisional[] = 249358;
        $arrayProvisional[] = 249404;
        $arrayProvisional[] = 250304;
        $arrayProvisional[] = 250322;
        $arrayProvisional[] = 250523;
        $arrayProvisional[] = 250665;
        $arrayProvisional[] = 251127;
        $arrayProvisional[] = 251196;
        $arrayProvisional[] = 251252;
        $arrayProvisional[] = 251388;
        $arrayProvisional[] = 251519;
        $arrayProvisional[] = 251538;
        $arrayProvisional[] = 251657;
        $arrayProvisional[] = 255182;
        $arrayProvisional[] = 255366;
        $arrayProvisional[] = 257810;
        $arrayProvisional[] = 259077;
        $arrayProvisional[] = 259192;
        $arrayProvisional[] = 261286;
        $arrayProvisional[] = 261395;
        $arrayProvisional[] = 261479;
        $arrayProvisional[] = 261901;
        $arrayProvisional[] = 262756;
        $arrayProvisional[] = 263410;
        $arrayProvisional[] = 263731;
        $arrayProvisional[] = 264676;
        $arrayProvisional[] = 266526;
        $arrayProvisional[] = 267202;
        $arrayProvisional[] = 282433;
        $arrayProvisional[] = 287696;
        $arrayProvisional[] = 292102;
        $arrayProvisional[] = 292495;
        $arrayProvisional[] = 304164;
        $arrayProvisional[] = 306064;
        $arrayProvisional[] = 308474;
        $arrayProvisional[] = 310313;
        $arrayProvisional[] = 311265;
        $arrayProvisional[] = 324313;
        $arrayProvisional[] = 328342;
        $arrayProvisional[] = 330440;
        $arrayProvisional[] = 332244;
        $arrayProvisional[] = 333814;
        $arrayProvisional[] = 356988;
        $arrayProvisional[] = 356990;
        $arrayProvisional[] = 356994;
        $arrayProvisional[] = 356995;
        $arrayProvisional[] = 356996;
        $arrayProvisional[] = 358859;
        $arrayProvisional[] = 358864;
        $arrayProvisional[] = 358865;
        $arrayProvisional[] = 358867;
        $arrayProvisional[] = 358868;
        $arrayProvisional[] = 358869;
        $arrayProvisional[] = 358870;
        $arrayProvisional[] = 358871;
        $arrayProvisional[] = 358872;
        $arrayProvisional[] = 358874;
        $arrayProvisional[] = 358877;
        $arrayProvisional[] = 358878;
        $arrayProvisional[] = 358879;
        $arrayProvisional[] = 358881;
        $arrayProvisional[] = 358885;
        $arrayProvisional[] = 358887;
        $arrayProvisional[] = 358889;
        $arrayProvisional[] = 358891;
        $arrayProvisional[] = 358892;
        $arrayProvisional[] = 358893;
        $arrayProvisional[] = 358908;
        $arrayProvisional[] = 358909;
        $arrayProvisional[] = 358912;
        $arrayProvisional[] = 358913;
        $arrayProvisional[] = 358916;
        $arrayProvisional[] = 358923;
        $arrayProvisional[] = 358929;
        $arrayProvisional[] = 358931;
        $arrayProvisional[] = 358933;
        $arrayProvisional[] = 358934;
        $arrayProvisional[] = 358935;
        $arrayProvisional[] = 358937;
        $arrayProvisional[] = 358939;
        $arrayProvisional[] = 358940;
        $arrayProvisional[] = 358946;
        $arrayProvisional[] = 358947;
        $arrayProvisional[] = 358949;
        $arrayProvisional[] = 358950;
        $arrayProvisional[] = 358952;
        $arrayProvisional[] = 358953;
        $arrayProvisional[] = 358954;
        $arrayProvisional[] = 358955;
        $arrayProvisional[] = 358958;
        $arrayProvisional[] = 358959;
        $arrayProvisional[] = 358961;
        $arrayProvisional[] = 358965;
        $arrayProvisional[] = 358966;
        $arrayProvisional[] = 358968;
        $arrayProvisional[] = 358969;
        $arrayProvisional[] = 358973;
        $arrayProvisional[] = 358976;
        $arrayProvisional[] = 358978;
        $arrayProvisional[] = 358979;
        $arrayProvisional[] = 358981;
        $arrayProvisional[] = 358984;
        $arrayProvisional[] = 358985;
        $arrayProvisional[] = 358988;
        $arrayProvisional[] = 358989;
        $arrayProvisional[] = 358990;
        $arrayProvisional[] = 358991;
        $arrayProvisional[] = 358996;
        $arrayProvisional[] = 359001;
        $arrayProvisional[] = 359005;
        $arrayProvisional[] = 359019;
        $arrayProvisional[] = 359024;
        $arrayProvisional[] = 359026;
        $arrayProvisional[] = 359029;
        $prov = 0;
        if (in_array($claCasaMano->objPostulacion->seqFormulario, $arrayProvisional)) {
            $prov = 1;
            $claCasaMano->objPostulacion->valAspiraSubsidio = 100.366;
        } else {
            $claCasaMano->objPostulacion->valAspiraSubsidio = valorSubsidio($claCasaMano->objPostulacion);
        }


        // Suma de recursos propios
        $valSumaRecursosPropios = $claCasaMano->objPostulacion->valSaldoCuentaAhorro +
                $claCasaMano->objPostulacion->valSaldoCuentaAhorro2 +
                $claCasaMano->objPostulacion->valSaldoCesantias +
                $claCasaMano->objPostulacion->valCredito +
                $claCasaMano->objPostulacion->valAporteLote;

        // Suma de subsidios
        $valSumaSubsidios = $claCasaMano->objPostulacion->valSubsidioNacional +
                $claCasaMano->objPostulacion->valDonacion;

        // Total recursos
        $claCasaMano->objPostulacion->valTotalRecursos = $valSumaRecursosPropios + $valSumaSubsidios;

        // Seguimientos para el hogar
        $claSeguimiento->seqFormulario = $claCasaMano->objPostulacion->seqFormulario;
        $arrSeguimiento = $claSeguimiento->obtenerRegistros(100);

        // obtiene la informacion de la pestana de actos administrativos
        $arrActos = array();
        foreach ($claCasaMano->objPostulacion->arrCiudadano as $objCiudadano) {
            if ($objCiudadano->seqParentesco == 1) {
                $numDocumento = $objCiudadano->numDocumento;
                break;
            }
        }

        // obtiene la etapa para efectos de los permisos
        $claCasaMano->objPostulacion->seqEtapa = array_shift(obtenerDatosTabla("T_FRM_ESTADO_PROCESO", array("seqEstadoProceso", "seqEtapa"), "seqEstadoProceso", "seqEstadoProceso = " . $claCasaMano->objPostulacion->seqEstadoProceso));

        $claActosAdministrativos = new ActoAdministrativo();
        $arrActos = $claActosAdministrativos->cronologia($numDocumento);

        /*         * *****************************************************************************************************
         * INFORMACION ACTO INDEXACION -- ESTOS ACTOS SON DEL MODULO DE PROYECTOS
         * **************************************************************************************************** */
        $sqlActoUnidad = "
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
        $objRes = $aptBd->execute($sqlActoUnidad);
        while ($objRes->fields) {
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['seqUnidadActo'] = $objRes->fields['seqUnidadActo'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['numActo'] = $objRes->fields['numActo'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['fchActo'] = formatoFechaTextoFecha($objRes->fields['fchActo']);
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['txtDescripcion'] = $objRes->fields['txtDescripcion'];
            $arrActosAsociados[$objRes->fields['seqUnidadActo']]['valIndexado'] = $objRes->fields['valIndexado'];
            $objRes->MoveNext();
        }
       
        // ASIGNACION DE VARIABLES A LA PLANTILLA
        $claSmarty->assign("arrActos", $arrActos);
        $claSmarty->assign("arrConvenio", $arrConvenio);
        $claSmarty->assign("arrActosAsociados", $arrActosAsociados);
        $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar);
        $claSmarty->assign("arrEstadosFlujo", $arrEstadosFlujo);
        $claSmarty->assign("claCasaMano", $claCasaMano);
        $claSmarty->assign("arrCasaMano", $arrCasaMano);
        $claSmarty->assign("arrPost", $_POST);
        $claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);
        $claSmarty->assign("arrTipoVictima", $arrTipoVictima);
        $claSmarty->assign("arrGrupoLgtbi", $arrGrupoLgtbi);
        $claSmarty->assign("arrSexo", $arrSexo);
        $claSmarty->assign("arrEstadoCivil", $arrEstadoCivil);
        $claSmarty->assign("arrVivienda", $arrVivienda);
        $claSmarty->assign("arrSisben", $arrSisben);
        $claSmarty->assign("arrEntidadSubsidio", $arrEntidadSubsidio);
        $claSmarty->assign("arrBanco", $arrBanco);
        $claSmarty->assign("arrEstados", $arrEstados);
        $claSmarty->assign("arrParentesco", $arrParentesco);
        $claSmarty->assign("arrCondicionEspecial", $arrCondicionEspecial);
        $claSmarty->assign("arrCondicionEtnica", $arrCondicionEtnica);
        $claSmarty->assign("arrOcupacion", $arrOcupacion);
        $claSmarty->assign("arrCiudad", $arrCiudad);
        $claSmarty->assign("arrLocalidad", $arrLocalidad);
        $claSmarty->assign("arrBarrio", $arrBarrio);
        $claSmarty->assign("arrSolucion", $arrSolucion);
        $claSmarty->assign("arrNivelEducativo", $arrNivelEducativo);
        $claSmarty->assign("arrSalud", $arrSalud);
        $claSmarty->assign("arrDonantes", $arrDonantes);
        $claSmarty->assign("arrModalidad", $arrModalidad);
        $claSmarty->assign("arrTipoEsquemas", $arrTipoEsquemas);
        $claSmarty->assign("arrProyectos", $arrProyectos);
        $claSmarty->assign("arrProyectosHijos", $arrProyectosHijos);
        $claSmarty->assign("arrUnidadProyecto", $arrUnidadProyecto);
        $claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
        $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
        $claSmarty->assign("valSumaRecursosPropios", $valSumaRecursosPropios);
        $claSmarty->assign("valSumaSubsidios", $valSumaSubsidios);
        $claSmarty->assign("txtArchivo", $txtArchivo);
        $claSmarty->assign("arrRegistros", $arrSeguimiento);
        $claSmarty->assign("arrPermisoPanel", $arrPermisoPanel);
        $claSmarty->assign("prov", $prov);

        $claSmarty->display($txtPlantilla);
    } else {
        imprimirMensajes($arrErrores, array());
    }
}
?>
