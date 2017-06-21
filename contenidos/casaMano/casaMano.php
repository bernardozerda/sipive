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

    if( empty( $_POST ) ){
        $claSmarty->assign( "txtFuncion" , "buscarCedula('casaMano/casaMano')" );
        $claSmarty->display( "subsidios/buscarCedula.tpl" );
    }else{

        $claCiudadano   = new Ciudadano();
        $claCasaMano    = new CasaMano();
        $claSeguimiento = new Seguimiento();
        $arrErrores     = array();

        // ciudadano para obtener el formulario vinculado
        $_POST['cedula'] = mb_ereg_replace("[^0-9]","", $_POST['cedula']);
        $seqFormulario = $claCiudadano->formularioVinculado( $_POST['cedula'] );

        // Si el ciudadano no esta relacionado con algun formulario
        if($seqFormulario == 0){
            $arrErrores = $claCiudadano->arrErrores;
        }else{

            // obtiene la informacion del hogar
            $arrCasaMano = $claCasaMano->cargar($seqFormulario);
            $claCasaMano = end($arrCasaMano);

            // enrutamiento para el flujo del proceso
            // directo al formulario de postulacion si es
            // - Plan de gobierno 2
            // - Plan de gobierno 3 con esquema de CF - PROYECTO SDHT
            $arrFlujoHogar['flujo'] = "";
            $arrFlujoHogar['fase']  = "";
            if(
                in_array($claCasaMano->objPostulacion->seqModalidad,$claCasaMano->arrFases['pin']['modalidad']) and
                in_array($claCasaMano->objPostulacion->seqTipoEsquema,$claCasaMano->arrFases['pin']['esquema'])
            ){
                $arrFlujoHogar['flujo'] = "pin";
                $arrFlujoHogar['fase']  = "postulacion";
                $txtPlantilla = $claCasaMano->arrFases['pin']['postulacion']['plantilla'];
                $arrEstadosFlujo['atras']    = $claCasaMano->arrFases['pin']['postulacion']['atras'];
                $arrEstadosFlujo['adelante'] = $claCasaMano->arrFases['pin']['postulacion']['adelante'];

            }elseif(
                in_array($claCasaMano->objPostulacion->seqModalidad,$claCasaMano->arrFases['cem']['modalidad']) and
                in_array($claCasaMano->objPostulacion->seqTipoEsquema,$claCasaMano->arrFases['cem']['esquema'])
            ){
                $arrFlujoHogar['flujo'] = "cem";
                $arrFlujoHogar['fase']  = "panelHogar";
                $txtPlantilla = $claCasaMano->arrFases["cem"]["panelHogar"]["plantilla"];
                $arrEstadosFlujo = array();
            }
            $txtFlujo = $arrFlujoHogar['flujo'];
            $txtFase  = $arrFlujoHogar['fase'];
            $txtArchivo = $claCasaMano->arrFases[$txtFlujo][$txtFase]['salvar'];
        }

        // obtieene los permisos para saber a donde puede entrar
        $bolPermiso = $claCasaMano->puedeIngresar( $arrFlujoHogar );
        if( $bolPermiso == false ){
            $arrErrores = $claCasaMano->arrErrores;
        }

        if( empty( $arrErrores ) ){

            // Informacion de los select que hay en el formulario
            $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento", "seqTipoDocumento <> 6", "txtTipoDocumento");
            $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
            $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
            $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
            $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil", "bolActivo"), "seqEstadoCivil", "", "bolActivo DESC, txtEstadoCivil");
            $arrVivienda = obtenerDatosTabla("T_FRM_VIVIENDA", array("seqVivienda", "txtVivienda"), "seqVivienda", "", "txtVivienda");
            $arrTipoFinanciacion = obtenerDatosTabla("T_FRM_TIPO_FINANCIACION", array("seqTipoFinanciacion", "txtTipoFinanciacion"), "seqTipoFinanciacion", "", "seqTipoFinanciacion");
            $arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben", "bolActivo"), "seqSisben","","bolActivo DESC");
            $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
            $arrEstados = estadosProceso();
            $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "bolActivo DESC, txtParentesco");
            $arrCondicionEspecial = obtenerDatosTabla("T_CIU_CONDICION_ESPECIAL", array("seqCondicionEspecial", "txtCondicionEspecial"), "seqCondicionEspecial", "seqCondicionEspecial <> 6", "txtCondicionEspecial");
            $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia", "seqEtnia > 1", "txtEtnia");
            $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion", "seqOcupacion <> 20", "txtOcupacion");
            $arrCiudad = obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad = 149", "txtCiudad");
            $arrCiudad += obtenerDatosTabla("V_FRM_CIUDAD", array("seqCiudad", "txtCiudad"), "seqCiudad", "seqCiudad <> 149", "txtCiudad");
            $txtCondicion = ($claCasaMano->objPostulacion->seqCiudad == 149)? "seqLocalidad not in (1,22)" : "seqLocalidad in (22)";
            $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", $txtCondicion);
            natsort($arrLocalidad);
            $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "txtDescripcion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1 and seqModalidad = " . $claCasaMano->objPostulacion->seqModalidad);
            $arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo", "seqNivelEducativo > 1", "txtNivelEducativo");
            $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud", "", "txtSalud");
            $arrDonantes = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array("seqEmpresaDonante", "txtEmpresaDonante"), "seqEmpresaDonante", "seqEmpresaDonante > 1", "txtEmpresaDonante");
            $arrEntidadSubsidio = obtenerDatosTabla("T_FRM_ENTIDAD_SUBSIDIO", array("seqEntidadSubsidio", "txtEntidadSubsidio"), "seqEntidadSubsidio", "", "seqEntidadSubsidio");
            $arrGrupoGestion = obtenerDatosTabla("T_SEG_GRUPO_GESTION", array("seqGrupoGestion", "txtGrupoGestion"), "seqGrupoGestion", "seqGrupoGestion NOT IN ( 15,5,10,12,17,20 )", "txtGrupoGestion");
            $arrPlanGobierno = obtenerDatosTabla( "T_FRM_PLAN_GOBIERNO" , array( "seqPlanGobierno" , "txtPlanGobierno" ) , "seqPlanGobierno" , "" , "txtPlanGobierno" );
            $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $claCasaMano->objPostulacion->seqPlanGobierno , "seqPlanGobierno DESC, txtModalidad");
            $arrTipoEsquemas = obtenerTipoEsquema($claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqPlanGobierno);
            $arrProyectos = obtenerProyectosPostulacion($claCasaMano->objPostulacion->seqFormulario,$claCasaMano->objPostulacion->seqModalidad,$claCasaMano->objPostulacion->seqTipoEsquema, $claCasaMano->objPostulacion->seqPlanGobierno);
            $arrProyectosHijos = obtenerProyectosHijosPostulacion($claCasaMano->objPostulacion->seqFormulario,$claCasaMano->objPostulacion->seqModalidad,$claCasaMano->objPostulacion->seqPlanGobierno,$claCasaMano->objPostulacion->seqProyecto);
            if($claCasaMano->objPostulacion->seqProyectoHijo != 0) {
                $seqProyecto = $claCasaMano->objPostulacion->seqProyectoHijo;
            }else{
                $seqProyecto = $claCasaMano->objPostulacion->seqProyecto;
            }
            $arrUnidadProyecto = obtenerUnidadesPostulacion($claCasaMano->objPostulacion->seqFormulario, $claCasaMano->objPostulacion->seqModalidad, $claCasaMano->objPostulacion->seqPlanGobierno, $seqProyecto);
            $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claCasaMano->objPostulacion->seqLocalidad, "txtBarrio");
            $arrConvenio = obtenerDatosTabla("V_FRM_CONVENIO", array("seqConvenio", "txtNombre","txtBanco","numCupos","numOcupados","numDisponibles","valCupos"), "seqConvenio", "seqConvenio <> 1 and numDisponibles > 0", "txtNombre");

            // Calculo del valor del subsidio
            $claCasaMano->objPostulacion->valAspiraSubsidio = valorSubsidio($claCasaMano->objPostulacion);

            // Suma de recursos propios
            $valSumaRecursosPropios =
                $claCasaMano->objPostulacion->valSaldoCuentaAhorro +
                $claCasaMano->objPostulacion->valSaldoCuentaAhorro2 +
                $claCasaMano->objPostulacion->valSaldoCesantias +
                $claCasaMano->objPostulacion->valCredito;

            // Suma de subsidios
            $valSumaSubsidios =
                $claCasaMano->objPostulacion->valSubsidioNacional +
                $claCasaMano->objPostulacion->valDonacion;

            // Total recursos
            $claCasaMano->objPostulacion->valTotalRecursos = $valSumaRecursosPropios + $valSumaSubsidios;

            // Seguimientos para el hogar
            $claSeguimiento->seqFormulario = $claCasaMano->objPostulacion->seqFormulario;
            $arrSeguimiento = $claSeguimiento->obtenerRegistros(100);

            // obtiene la informacion de la pestana de actos administrativos
            $arrActos = array();
            foreach ($claCasaMano->objPostulacion->arrCiudadano as $objCiudadano) {
                if( $objCiudadano->seqParentesco == 1 ){
                    $numDocumento = $objCiudadano->numDocumento;
                    break;
                }
            }

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

            // ASIGNACION DE VARIABLES A LA PLANTILLA
            $claSmarty->assign("arrActos", $arrActos);
            $claSmarty->assign("arrConvenio", $arrConvenio);
            $claSmarty->assign("arrActosAsociados", $arrActosAsociados);
            $claSmarty->assign("arrFlujoHogar", $arrFlujoHogar);
            $claSmarty->assign("arrEstadosFlujo", $arrEstadosFlujo);
            $claSmarty->assign("claCasaMano", $claCasaMano);
            $claSmarty->assign("arrCasaMano" , $arrCasaMano );
            $claSmarty->assign("arrPost" , $_POST );
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
            $claSmarty->assign("txtArchivo",$txtArchivo);
            $claSmarty->assign("arrRegistros", $arrSeguimiento);

            $claSmarty->display( $txtPlantilla );

        }else{
            imprimirMensajes($arrErrores,array());
        }

    }
    
?>
