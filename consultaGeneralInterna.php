<?php

    $txtPrefijoRuta = "./";

    include( "./recursos/archivos/verificarSesion.php" ); // Verifica si hay sesion
    include( "./recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

    $seqFormulario = intval($_POST['seqFormulario']);
    $seqTipoDocumento = intval($_POST['seqTipoDocumento']);
    $numDocumento = intval($_POST['numDocumento']);

    $arrDatosBasicos = array();

    if($seqFormulario != 0 or $numDocumento != 0){
        $arrDatosBasicos  = consultaBasicaHogar($seqFormulario, $seqTipoDocumento, $numDocumento);
        $arrDatosMiembros = consultaMiembros($seqFormulario, $seqTipoDocumento, $numDocumento);
        $arrDatosAAD      = consultaAAD($seqFormulario, $seqTipoDocumento, $numDocumento);
    }

    $claSmarty->assign("seqFormulario", $seqFormulario);
    $claSmarty->assign("seqTipoDocumento", $seqTipoDocumento);
    $claSmarty->assign("numDocumento", $numDocumento);
    $claSmarty->assign("arrDatosBasicos",$arrDatosBasicos);
    $claSmarty->assign("arrDatosMiembros",$arrDatosMiembros);
    $claSmarty->assign("arrDatosAAD",$arrDatosAAD);

    $claSmarty->display("consultaGeneralInterna.tpl");


    function consultaBasicaHogar($seqFormulario, $seqTipoDocumento, $numDocumento){
        global $aptBd;

        $txtCondicion = ($numDocumento != 0)? " AND ciu.numDocumento = $numDocumento AND ciu.seqTipoDocumento = $seqTipoDocumento" : "";
        $txtCondicion .= ($seqFormulario != 0)? " AND frm.seqFormulario = $seqFormulario" : "";

        if($txtCondicion != "") {
            $sql = "
                select 
                  hog.seqFormulario as 'Formulario', 
                  pgo.txtPlanGobierno as 'Plan de Gobierno',
                  moa.txtModalidad as 'Modalidad',
                  tes.txtTipoEsquema as 'Esquema', 
                  sol.txtSolucion as 'Solución',
                  concat(eta.txtEtapa, ' - ',epr.txtEstadoProceso) as 'Estado del Proceso', 
                  frm.txtFormulario as 'No. Formulario',
                  frm.fchInscripcion as 'Fecha de Inscripción', 
                  frm.fchPostulacion as 'Fecha de Postulación',
                  frm.fchUltimaActualizacion as 'Fecha de Última Actualización', 
                  IF(frm.bolCerrado = 1,'SI','NO') as 'Cerrado', 
                  IF(frm.bolDesplazado = 1,'SI (Desplazado)','NO (Vulnerable)') as 'Victima', 
                  pry1.txtNombreProyecto as 'Proyecto',
                  pry2.txtNombreProyecto as 'Conjunto',
                  upr.txtNombreUnidad as 'Unidad Habitacional',
                  frm.txtDireccionSolucion as 'Direccion Solución', 
                  frm.txtMatriculaInmobiliaria as 'Matricula Inmobiliaria', 
                  frm.txtChip as 'CHIP', 
                  frm.valTotalRecursos as 'Total Recursos', 
                  frm.valIngresoHogar as 'Ingresos del Hogar', 
                  frm.valAspiraSubsidio as 'Valor del Subsidio / Aporte',
                  frm.valComplementario as 'Valor Complementario',
                  con.txtConvenio as 'Convenio Leasing',
                  con.txtBanco as 'Banco Convenio',
                  frm.valCartaLeasing as 'Valor Carta Leasing'
                from t_frm_hogar hog
                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                inner join t_frm_formulario frm on hog.seqFormulario = frm.seqFormulario
                inner join t_frm_plan_gobierno pgo on frm.seqPlanGobierno = pgo.seqPlanGobierno
                inner join t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
                left join t_frm_solucion sol on frm.seqFormulario = sol.seqSolucion
                inner join t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
                inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
                left join t_pry_tipo_esquema tes on frm.seqTipoEsquema = tes.seqTipoEsquema
                left join t_pry_proyecto pry1 on frm.seqProyecto = pry1.seqProyecto
                left join t_pry_proyecto pry2 on frm.seqProyectoHijo = pry2.seqProyecto
                left join t_pry_unidad_proyecto upr on frm.seqFormulario = upr.seqUnidadProyecto
                left join v_frm_convenio con on frm.seqConvenio = con.seqConvenio
                WHERE hog.seqParentesco = 1
                $txtCondicion
            ";
        }
        return $aptBd->GetAll($sql);
    }

    function consultaMiembros($seqFormulario, $seqTipoDocumento, $numDocumento){
        global $aptBd;

        $txtCondicion = ($numDocumento != 0)? " AND ciu.numDocumento = $numDocumento AND ciu.seqTipoDocumento = $seqTipoDocumento" : "";
        $txtCondicion .= ($seqFormulario != 0)? " AND frm.seqFormulario = $seqFormulario" : "";

        if($txtCondicion != "") {
            $sql = "
                select 
                    ciu.seqCiudadano as 'Ciudadano', 
                    par.txtParentesco as 'Parentesco', 
                    eci.txtEstadoCivil as 'Estado Civil',
                    ciu.numDocumento as 'Documento', 
                    tdo.txtTipoDocumento as 'Tipo de Documento',
                    CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2) AS 'Nombre', 
                    ciu.valIngresos as 'Ingresos', 
                    tvi.txtTipoVictima as 'Tipo de Victima',
                    glg.txtGrupoLgtbi as 'Grupo LGTBI'
                from t_frm_hogar hog
                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                inner join t_frm_formulario frm on hog.seqFormulario = frm.seqFormulario
                inner join t_ciu_parentesco par on hog.seqParentesco = par.seqParentesco
                inner join t_ciu_estado_civil eci on ciu.seqEstadoCivil = eci.seqEstadoCivil
                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
                left join t_frm_tipovictima tvi on ciu.seqTipoVictima = tvi.seqTipoVictima
                left join t_frm_grupo_lgtbi glg on ciu.seqGrupoLgtbi = glg.seqGrupoLgtbi
                WHERE 1 = 1
                $txtCondicion
            ";
        }
        return $aptBd->GetAll($sql);
    }

    function consultaAAD($seqFormulario, $seqTipoDocumento, $numDocumento){
        global $aptBd;

        $txtCondicion = ($numDocumento != 0)? " AND ciu.numDocumento = $numDocumento AND ciu.seqTipoDocumento = $seqTipoDocumento" : "";
        $txtCondicion .= ($seqFormulario != 0)? " AND frm.seqFormulario = $seqFormulario" : "";

        if($txtCondicion != "") {
            $sql = "
                SELECT DISTINCT
                  hvi.numActo AS 'Número del Acto',
                  hvi.fchActo AS 'Fecha del Acto',
                  tac.txtNombreTipoActo AS 'Tipo del Acto',
                  moa.txtModalidad AS 'Modalidad'
                FROM T_AAD_HOGARES_VINCULADOS hvi
                LEFT JOIN T_AAD_FORMULARIO_ACTO fac ON hvi.seqFormularioActo = fac.seqFormularioActo
                LEFT JOIN t_frm_hogar hog on fac.seqFormulario = hog.seqFormulario
                LEFT JOIN t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                LEFT JOIN t_aad_tipo_acto tac ON hvi.seqTipoActo = tac.seqTipoActo
                LEFT JOIN t_frm_modalidad moa ON moa.seqModalidad = fac.seqModalidad
                WHERE 1 = 1
                $txtCondicion
             ";
        }
        return $aptBd->GetAll($sql);
    }



?>