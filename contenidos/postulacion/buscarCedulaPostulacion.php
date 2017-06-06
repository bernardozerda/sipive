<?php

    /**
     * AQUI SE REALIZA LA BUSQUEDA DE LA CEDULA	
     * PARA SABER SI SE MUESTRA EL FORMULARIO DE INSCRIPCION
     * O SI SE MUESTRA EL FORMULARIO DEPOSTULACION
     * @author Bernardo Zerda
     * @version 1.0 Mayo de 2009
     * @version 2.0 Enero 2014
     */
    $txtPrefijoRuta = "../../";

    include($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
    include($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );

    if (!isset($_POST['cedula'])) {
        $claSmarty->assign("txtFuncion", "buscarCedula('postulacion/buscarCedulaPostulacion');");
        $claSmarty->display("subsidios/buscarCedula.tpl");
    } else {

        /********************************************************************************************************
         * OBTENCION DE DATOS PARA EL FORMULARIO
         * ****************************************************************************************************** */

        // Quita los puntos del documento
        $_POST['cedula'] = mb_ereg_replace("[^0-9]", "", $_POST['cedula']);

        // Informacion de los select que hay en el formulario
        $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento", "seqTipoDocumento <> 6", "txtTipoDocumento");
        $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
        $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
        $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
        $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil", "bolActivo"), "seqEstadoCivil", "", "txtEstadoCivil");
        $arrVivienda = obtenerDatosTabla("T_FRM_VIVIENDA", array("seqVivienda", "txtVivienda"), "seqVivienda", "", "txtVivienda");
        $arrTipoFinanciacion = obtenerDatosTabla("T_FRM_TIPO_FINANCIACION", array("seqTipoFinanciacion", "txtTipoFinanciacion"), "seqTipoFinanciacion", "", "seqTipoFinanciacion");
		$arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben", "bolActivo"), "seqSisben","","bolActivo DESC");
        $arrCajaCompensacion = obtenerDatosTabla("T_CIU_CAJA_COMPENSACION", array("seqCajaCompensacion", "txtCajaCompensacion"), "seqCajaCompensacion");
        $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
        $arrEstados = estadosProceso();
        $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco", "bolActivo"), "seqParentesco", "", "txtParentesco");
        $arrCondicionEspecial = obtenerDatosTabla("T_CIU_CONDICION_ESPECIAL", array("seqCondicionEspecial", "txtCondicionEspecial"), "seqCondicionEspecial", "seqCondicionEspecial <> 6", "txtCondicionEspecial");
        $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia", "seqEtnia > 1", "txtEtnia");
        $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion", "seqOcupacion <> 20", "txtOcupacion");
        $arrCiudad = obtenerDatosTabla("T_FRM_CIUDAD", array("seqCiudad", "CONCAT( txtDepartamento , ' - ' , txtCiudad ) as txtCiudad"), "seqCiudad", "", "txtCiudad");
        $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", "seqLocalidad <> 1");
        natsort($arrLocalidad);
        $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1");
        $arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo", "seqNivelEducativo > 1", "txtNivelEducativo");
        $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud", "", "txtSalud");
        $arrDonantes = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array("seqEmpresaDonante", "txtEmpresaDonante"), "seqEmpresaDonante", "seqEmpresaDonante > 1", "txtEmpresaDonante");
		$arrEntidadSubsidio = obtenerDatosTabla("T_FRM_ENTIDAD_SUBSIDIO", array("seqEntidadSubsidio", "txtEntidadSubsidio"), "seqEntidadSubsidio", "", "seqEntidadSubsidio");
		$arrGrupoGestion = obtenerDatosTabla("T_SEG_GRUPO_GESTION", array("seqGrupoGestion", "txtGrupoGestion"), "seqGrupoGestion", "seqGrupoGestion NOT IN ( 15,5,10,12,17,20 )", "txtGrupoGestion");
        $arrPlanGobierno = obtenerDatosTabla( "T_FRM_PLAN_GOBIERNO" , array( "seqPlanGobierno" , "txtPlanGobierno" ) , "seqPlanGobierno" , "" , "txtPlanGobierno" );
        $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad"), "seqModalidad", "seqPlanGobierno = " . $claFormulario->seqPlanGobierno , "seqPlanGobierno DESC, txtModalidad");

        /*******************************************************************************************************
         * VERIFICACION DE DATOS
         *******************************************************************************************************/

        $claFormulario = new FormularioSubsidios();
        $claCiudadano = new Ciudadano();

        // BUSQUEDA DEL FORMULARIO ASOCIADO
        $seqFormulario = $claCiudadano->formularioVinculado($_POST['cedula']);

        if ($seqFormulario == 0) {
            $arrErrores[] = "No existe el registro para el documento consultado [" . $_POST['cedula'] . "']";
        } else {

            // CARGA DE LOS DATOS DEL FORMULARIO
            $claFormulario->cargarFormulario($seqFormulario);
            $seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $claFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");

            // COLOCAR LAS CONDICIONES DE ENTRADA A LA PLANTILLA
            // NO INGRESA SI EL HOGAR ESTA EN ETAPA DE INSCRIPCION
            if($seqEtapa == 1){
            	$txtPlantilla = "";
            	$arrErrores[] = "Hogar en etapa de inscripción, ingrese por Proceso --> Inscripción";
            }else{
                $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claFormulario->seqLocalidad, "txtBarrio");

                // PROYECTOS QUE APLICAN SEGUN MODALIDAD Y ESQUEMA
                $arrTipoEsquemas = obtenerTipoEsquema($claFormulario->seqModalidad, $claFormulario->seqPlanGobierno);
                $arrProyectos = obtenerProyectosPostulacion($claFormulario->seqFormulario,$claFormulario->seqModalidad,$claFormulario->seqTipoEsquema, $claFormulario->seqPlanGobierno);
                $arrProyectosHijos = obtenerProyectosHijosPostulacion($claFormulario->seqFormulario,$claFormulario->seqModalidad,$claFormulario->seqPlanGobierno,$claFormulario->seqProyecto);
                $arrUnidadProyecto = obtenerUnidadesPostulacion($claFormulario->seqFormulario,$claFormulario->seqModalidad,$claFormulario->seqPlanGobierno,$claFormulario->seqProyectoHijo);

                // Calculo del valor del subsidio
                $claFormulario->valAspiraSubsidio = valorSubsidio($claFormulario);

                // Suma de recursos
                $valSumaRecursos = $claFormulario->valAspiraSubsidio + $claFormulario->valTotalRecursos;
                $valSumaRecursosSMMLV = number_format($valSumaRecursos / $arrConfiguracion['constantes']['salarioMinimo'],2,".",".");

                $txtPlantilla = "postulacion/postulacion.tpl";
            }

//*******************************************************************************************************************//
			


            // Obtiene los ultimos 100 seguimientos del hogar
            if ($seqFormulario != 0) {
                $claSeguimiento = new Seguimiento;
                $claSeguimiento->seqFormulario = $seqFormulario;
                $arrSeguimiento = $claSeguimiento->obtenerRegistros(100);
            }

            // obtiene la informacion de la pestana de actos administrativos
            $arrActos = array();
            if (is_object($claFormulario)) {

                foreach ($claFormulario->arrCiudadano as $objCiudadano) {
                    if( $objCiudadano->seqParentesco == 1 ){
                        $numDocumento = mb_ereg_replace("[^0-9]", "", $objCiudadano->numDocumento);
                        break;
                    }
                }

                $claActosAdministrativos = new ActoAdministrativo();
                $arrActos = $claActosAdministrativos->cronologia($numDocumento);

            }

        }

		/*******************************************************************************************************
         * INFORMACION ACTO INDEXACION
         * **************************************************************************************************** */
		 $sqlActoUnidad =  "SELECT T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo, numActo, fchActo, txtDescripcion, valIndexado
							FROM T_PRY_AAD_UNIDAD_ACTO
							INNER JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON (T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo)
							WHERE seqTipoActoUnidad = 2
							AND T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = (SELECT seqUnidadProyecto 
																		  FROM T_FRM_FORMULARIO 
																		  WHERE seqFormulario = $seqFormulario)";
		$objRes = $aptBd->execute( $sqlActoUnidad );
		while( $objRes->fields ){
			$arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['seqUnidadActo']		= $objRes->fields['seqUnidadActo'];
			$arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['numActo']			= $objRes->fields['numActo'];
			$arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['fchActo']			= formatoFechaTextoFecha($objRes->fields['fchActo']);
			$arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['txtDescripcion']	= $objRes->fields['txtDescripcion'];
			$arrActosAsociados[ $objRes->fields['seqUnidadActo'] ]['valIndexado']		= $objRes->fields['valIndexado'];
			$objRes->MoveNext();
		}

        if( empty( $arrErrores ) ){
        
            /**************************************************************************************************************
             * ASIGNACION DE VARIABLES A LA PLANTILLA
             * ************************************************************************************************************ */
			$esCoordinador = 0;
			if ($_SESSION['seqUsuario'] == 5 || $_SESSION['seqUsuario'] == 414) {
				//if (array_key_exists(7, $_SESSION['arrGrupos'] [3]) || array_key_exists(9, $_SESSION['arrGrupos'] [3])) {
				$esCoordinador = 1;
			}
			$claSmarty->assign("esCoordinador", $esCoordinador);
            $claSmarty->assign("arrActosAsociados", $arrActosAsociados);
			$claSmarty->assign("arrRegistros", $arrSeguimiento);
            $claSmarty->assign("numDocumento", $_POST['cedula']);
            $claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);
            $claSmarty->assign("arrTipoVictima", $arrTipoVictima);
            $claSmarty->assign("arrGrupoLgtbi", $arrGrupoLgtbi);
            $claSmarty->assign("arrSexo", $arrSexo);
            $claSmarty->assign("arrEstadoCivil", $arrEstadoCivil);
            $claSmarty->assign("arrVivienda", $arrVivienda);
            $claSmarty->assign("arrModalidades", $arrModalidades);
			$claSmarty->assign("arrTipoFinanciacion", $arrTipoFinanciacion);
            $claSmarty->assign("arrSisben", $arrSisben);
            $claSmarty->assign("arrCajaCompensacion", $arrCajaCompensacion);
			$claSmarty->assign("arrEntidadSubsidio", $arrEntidadSubsidio);
            $claSmarty->assign("arrBanco", $arrBanco);
            $claSmarty->assign("arrEstado", $arrEstados);
            $claSmarty->assign("arrParentesco", $arrParentesco);
            $claSmarty->assign("arrCondicionEspecial", $arrCondicionEspecial);
            $claSmarty->assign("arrCondicionEtnica", $arrCondicionEtnica);
            $claSmarty->assign("arrOcupacion", $arrOcupacion);
            $claSmarty->assign("arrLocalidad", $arrLocalidad);
            $claSmarty->assign("arrSolucion", $arrSolucion);
            $claSmarty->assign("arrNivelEducativo", $arrNivelEducativo);
            $claSmarty->assign("arrSalud", $arrSalud);
            $claSmarty->assign("arrDonantes", $arrDonantes);
            $claSmarty->assign("arrProyectos", $arrProyectos);
			$claSmarty->assign("arrProyectosHijos", $arrProyectosHijos);
            $claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
            $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
			$claSmarty->assign("arrUnidadProyecto", $arrUnidadProyecto);
            $claSmarty->assign("arrCiudad", $arrCiudad);
            $claSmarty->assign("arrBarrio", $arrBarrio);
            $claSmarty->assign("seqFormulario", $seqFormulario);
            $claSmarty->assign("objFormulario", $claFormulario);
            $claSmarty->assign("objCiudadano", $objCiudadano);
            $claSmarty->assign("arrActos", $arrActos);
            $claSmarty->assign("arrTipoEsquemas", $arrTipoEsquemas);
            $claSmarty->assign("valSumaRecursos", $valSumaRecursos);
            $claSmarty->assign("valSumaRecursosSMMLV", $valSumaRecursosSMMLV);
            $claSmarty->assign("valSalarioMinimo", $arrConfiguracion['constantes']['salarioMinimo']);

            if ($txtPlantilla != "") {
                $claSmarty->display($txtPlantilla);
            }
        
        } else {
            
            imprimirMensajes($arrErrores);
            
        }
        
    } // FIN POST CEDULA

?>