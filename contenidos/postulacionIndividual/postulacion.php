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

    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos2.class.php" );

    if (!isset($_POST['cedula'])) {
        $claSmarty->assign("txtFuncion", "buscarCedula('postulacionIndividual/postulacion');");
        $claSmarty->display("subsidios/buscarCedula.tpl");
    } else {

        /********************************************************************************************************
         * OBTENCION DE DATOS PARA EL FORMULARIO
         * ****************************************************************************************************** */

        // Quita los puntos del documento
        $_POST['cedula'] = mb_ereg_replace("[^0-9]", "", $_POST['cedula']);

        // Informacion de los select que hay en el formulario
        $arrTipoDocumento = obtenerDatosTabla("T_CIU_TIPO_DOCUMENTO", array("seqTipoDocumento", "txtTipoDocumento"), "seqTipoDocumento", "", "txtTipoDocumento");
        $arrTipoVictima = obtenerDatosTabla("T_FRM_TIPOVICTIMA", array("seqTipoVictima", "txtTipoVictima"), "seqTipoVictima", "seqTipoVictima <> 0", "txtTipoVictima");
        $arrGrupoLgtbi = obtenerDatosTabla("T_FRM_GRUPO_LGTBI", array("seqGrupoLgtbi", "txtGrupoLgtbi"), "seqGrupoLgtbi", "seqGrupoLgtbi <> 0", "txtGrupoLgtbi");
        $arrSexo = obtenerDatosTabla("T_CIU_SEXO", array("seqSexo", "txtSexo"), "seqSexo", "", "txtSexo");
        $arrEstadoCivil = obtenerDatosTabla("T_CIU_ESTADO_CIVIL", array("seqEstadoCivil", "txtEstadoCivil"), "seqEstadoCivil", "", "txtEstadoCivil");
        $arrVivienda = obtenerDatosTabla("T_FRM_VIVIENDA", array("seqVivienda", "txtVivienda"), "seqVivienda", "", "txtVivienda");
        $arrModalidad = obtenerDatosTabla("T_FRM_MODALIDAD", array("seqModalidad", "txtModalidad", "seqPlanGobierno"), "seqModalidad", "", "seqPlanGobierno DESC, txtModalidad");
        $arrSisben = obtenerDatosTabla("T_FRM_SISBEN", array("seqSisben", "txtSisben"), "seqSisben");
        $arrCajaCompensacion = obtenerDatosTabla("T_CIU_CAJA_COMPENSACION", array("seqCajaCompensacion", "txtCajaCompensacion"), "seqCajaCompensacion");
        $arrBanco = obtenerDatosTabla("T_FRM_BANCO", array("seqBanco", "txtBanco"), "seqBanco", "seqBanco > 1", "txtBanco");
        $arrEstados = estadosProceso();
        $arrParentesco = obtenerDatosTabla("T_CIU_PARENTESCO", array("seqParentesco", "txtParentesco"), "seqParentesco", "", "txtParentesco");
        $arrCondicionEspecial = obtenerDatosTabla("T_CIU_CONDICION_ESPECIAL", array("seqCondicionEspecial", "txtCondicionEspecial"), "seqCondicionEspecial", "seqCondicionEspecial <> 6", "txtCondicionEspecial");
        $arrCondicionEtnica = obtenerDatosTabla("T_CIU_ETNIA", array("seqEtnia", "txtEtnia"), "seqEtnia", "seqEtnia > 1", "txtEtnia");
        $arrOcupacion = obtenerDatosTabla("T_CIU_OCUPACION", array("seqOcupacion", "txtOcupacion"), "seqOcupacion", "seqOcupacion <> 20", "txtOcupacion");
        $arrCiudad = obtenerDatosTabla("T_FRM_CIUDAD", array("seqCiudad", "CONCAT( txtDepartamento , ' - ' , txtCiudad ) as txtCiudad"), "seqCiudad", "", "txtCiudad");
        $arrLocalidad = obtenerDatosTabla("T_FRM_LOCALIDAD", array("seqLocalidad", "txtLocalidad"), "seqLocalidad", "seqLocalidad <> 1");
        natsort($arrLocalidad);
        $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "", "txtBarrio");
        $arrSolucion = obtenerDatosTabla("T_FRM_SOLUCION", array("seqSolucion", "txtSolucion", "seqModalidad"), "seqSolucion", "seqSolucion <> 1");
        $arrEntidadSubsidio = obtenerDatosTabla("T_FRM_ENTIDAD_SUBSIDIO", array("seqEntidadSubsidio", "txtEntidadSubsidio"), "seqEntidadSubsidio", "", "seqEntidadSubsidio");
		$arrNivelEducativo = obtenerDatosTabla("T_CIU_NIVEL_EDUCATIVO", array("seqNivelEducativo", "txtNivelEducativo"), "seqNivelEducativo", "seqNivelEducativo > 1", "txtNivelEducativo");
        $arrSalud = obtenerDatosTabla("T_CIU_SALUD", array("seqSalud", "txtSalud"), "seqSalud", "", "txtSalud");
        $arrDonantes = obtenerDatosTabla("T_FRM_EMPRESA_DONANTE", array("seqEmpresaDonante", "txtEmpresaDonante"), "seqEmpresaDonante", "seqEmpresaDonante > 1", "txtEmpresaDonante");
        $arrProyecto = obtenerDatosTabla("T_PRY_PROYECTO", array("seqProyecto", "txtNombreProyecto"), "seqProyecto", "", "txtNombreProyecto");
        $arrProyectoBp = obtenerDatosTabla("T_FRM_PROYECTO", array("seqProyecto", "txtNombre"), "seqProyecto", "", "txtNombre");
        $arrGrupoGestion = obtenerDatosTabla("T_SEG_GRUPO_GESTION", array("seqGrupoGestion", "txtGrupoGestion"), "seqGrupoGestion", "seqGrupoGestion NOT IN ( 15,5,10,12,17,20 )", "txtGrupoGestion");
        $arrPlanGobierno = obtenerDatosTabla( "T_FRM_PLAN_GOBIERNO" , array( "seqPlanGobierno" , "txtPlanGobierno" ) , "seqPlanGobierno" , "" , "txtPlanGobierno" );
        
        $sql = "
            SELECT 
                seqModalidad,
                seqSolucion,
                valSubsidio
            FROM 
                T_FRM_VALOR_SUBSIDIO
        ";
        $objRes = $aptBd->execute($sql);
        $arrValorSubsidio = array();
        while ($objRes->fields) {
            $arrValorSubsidio[$objRes->fields['seqModalidad']][$objRes->fields['seqSolucion']] = $objRes->fields['valSubsidio'];
            $objRes->MoveNext();
        }

        /*******************************************************************************************************
         * VERIFICACION DE LA EXISTENCIA DEL CIUDADANO
         * **************************************************************************************************** */

        $txtImpresion = "";
        $claFormulario = new FormularioSubsidios();
        $claCiudadano = new Ciudadano();
        $seqFormulario = $claCiudadano->formularioVinculado($_POST['cedula']);

        if ($seqFormulario == 0) {
            $arrErrores[] = "No existe el registro para el documento consultado [" . $_POST['cedula'] . "']";
        } else {
            
            $claFormulario->cargarFormulario($seqFormulario);
            
            $arrEstadosPermitidos = array( 53 , 54 , 56 , 16 , 15 );
            if( in_array( $claFormulario->seqEstadoProceso , $arrEstadosPermitidos ) ){
                
                $txtPlantilla = "postulacionIndividual/postulacion.tpl";
                $txtImpresion = "imprimirPostulacionCEM( document.frmIndividual , './contenidos/postulacionIndividual/pedirConfirmacion.php' )";
                
                $arrBarrio = obtenerDatosTabla("T_FRM_BARRIO", array("seqBarrio", "txtBarrio"), "seqBarrio", "seqLocalidad = " . $claFormulario->seqLocalidad, "txtBarrio");
                $claFormulario->seqEtapa = obtenerCampo("T_FRM_ESTADO_PROCESO", $claFormulario->seqEstadoProceso, "seqEtapa", "seqEstadoProceso");
                
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

                
            }else{
                $arrErrores[] = "El estado del proceso actual '" . $arrEstados[ $claFormulario->seqEstadoProceso ] .
                                "' no es permitido para ingresar al esquema de postulación individual";
            }
        } 
        
        if( empty( $arrErrores ) ){
        
            /**************************************************************************************************************
             * ASIGNACION DE VARIABLES A LA PLANTILLA
             * ************************************************************************************************************ */

            $claSmarty->assign("arrRegistros", $arrSeguimiento);
            $claSmarty->assign("numDocumento", $_POST['cedula']);
            $claSmarty->assign("arrTipoDocumento", $arrTipoDocumento);
            $claSmarty->assign("arrTipoVictima", $arrTipoVictima);
            $claSmarty->assign("arrGrupoLgtbi", $arrGrupoLgtbi);
            $claSmarty->assign("arrSexo", $arrSexo);
            $claSmarty->assign("arrEstadoCivil", $arrEstadoCivil);
            $claSmarty->assign("arrVivienda", $arrVivienda);
            $claSmarty->assign("arrModalidad", $arrModalidad);
            $claSmarty->assign("arrSisben", $arrSisben);
            $claSmarty->assign("arrCajaCompensacion", $arrCajaCompensacion);
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
            $claSmarty->assign("arrProyecto", $arrProyecto);
            $claSmarty->assign("arrProyectoBp", $arrProyectoBp);
            $claSmarty->assign("arrPlanGobierno", $arrPlanGobierno);
            $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
            $claSmarty->assign("arrValorSubsidio", $arrValorSubsidio);
			$claSmarty->assign("arrEntidadSubsidio", $arrEntidadSubsidio);
            $claSmarty->assign("arrCiudad", $arrCiudad);
            $claSmarty->assign("arrBarrio", $arrBarrio);
            $claSmarty->assign("seqFormulario", $seqFormulario);
            $claSmarty->assign("objFormulario", $claFormulario);
            $claSmarty->assign("objCiudadano", $objCiudadano);
            $claSmarty->assign("arrActos", $arrActos);
            $claSmarty->assign("txtImpresion", $txtImpresion);
            
            if ($txtPlantilla != "") {
                $claSmarty->display($txtPlantilla);
            }
        
        } else {
            
            imprimirMensajes($arrErrores);
            
        }
        
    } // FIN POST CEDULA
?>