<?php

/**
 * CLASE QUE PERMITE CREAR FUNCIONES A 
 * POSTULACION
 * @author Liliana Basto
 * @version 1.0 OCTUBRE 2019
 */

/**
 * Description of funciones
 *
 * @author liliana.basto
 */
class funciones {

    function consultaMiembros($seqFormulario) {

        global $aptBd;

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
                WHERE frm.seqFormulario = $seqFormulario
            ";

        return $aptBd->GetAll($sql);
    }

    function consultarFormulario($seqTipoDocumento, $numDocumento) {
        global $aptBd;
        $seqFormulario = 0;
        $sql = "
                select seqFormulario
                from t_frm_hogar hog
                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
                where ciu.numDocumento = $numDocumento
                and ciu.seqTipoDocumento = $seqTipoDocumento
            ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $objRes->MoveNext();
        }
        return $seqFormulario;
    }

    function consultaBasicaHogar($seqFormulario) {

        global $aptBd;

        $sql = "
        select 
          hog.seqFormulario as 'Formulario', 
          concat('[',pgo.seqPlanGobierno,'] ',pgo.txtPlanGobierno) as 'Plan de Gobierno',
          concat('[',moa.seqModalidad,'] ',moa.txtModalidad) as 'Modalidad',
          concat('[',tes.seqTipoEsquema,'] ',tes.txtTipoEsquema) as 'Esquema',
          concat('[',sol.seqSolucion,'] ',sol.txtSolucion) as 'Solución',
          concat('[',frm.seqEstadoProceso,'] ',eta.txtEtapa, ' - ',epr.txtEstadoProceso) as 'Estado del Proceso', 
          frm.txtFormulario as 'No. Formulario',
          frm.fchInscripcion as 'Fecha de Inscripción', 
          frm.fchPostulacion as 'Fecha de Postulación',
          frm.fchUltimaActualizacion as 'Fecha de Última Actualización', 
          IF(frm.bolCerrado = 1,'SI','NO') as 'Cerrado', 
          IF(frm.bolDesplazado = 1,'SI (Desplazado)','NO (Vulnerable)') as 'Victima',
          concat('[',pry1.seqProyecto,'] ',pry1.txtNombreProyecto) as 'Proyecto',
          concat('[',pry2.seqProyecto,'] ',pry2.txtNombreProyecto) as 'Conjunto',
          concat('[',upr.seqUnidadProyecto,'] ',upr.txtNombreUnidad) as 'Unidad Habitacional',
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
        left join t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
        left join t_frm_solucion sol on frm.seqFormulario = sol.seqSolucion
        inner join t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
        inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
        left join t_pry_tipo_esquema tes on frm.seqTipoEsquema = tes.seqTipoEsquema
        left join t_pry_proyecto pry1 on frm.seqProyecto = pry1.seqProyecto
        left join t_pry_proyecto pry2 on frm.seqProyectoHijo = pry2.seqProyecto
        left join t_pry_unidad_proyecto upr on frm.seqUnidadProyecto = upr.seqUnidadProyecto
        left join v_frm_convenio con on frm.seqConvenio = con.seqConvenio
        WHERE hog.seqParentesco = 1
          AND frm.seqFormulario = $seqFormulario ";

        return $aptBd->GetAll($sql);
    }

    function consultaSegumientosHogar($seqFormulario) {

        global $aptBd;

        $sql = "	
            SELECT 
            seg.seqSeguimiento,
            seg.seqFormulario,
            seg.fchMovimiento,
            ucwords(gge.txtGrupoGestion) as txtGrupoGestion,
            ucwords(ges.txtGestion) as txtGestion,
            ucwords( CONCAT( usu.txtNombre , ' ' , usu.txtApellido ) ) as txtUsuario,
            seg.txtComentario as txtComentario,
            seg.txtCambios,
            seg.numDocumento as numAtendido,
            ucwords( seg.txtNombre ) as txtAtendido
            FROM 
            T_SEG_SEGUIMIENTO seg,
            T_SEG_GESTION ges,
            T_SEG_GRUPO_GESTION gge,
            T_COR_USUARIO usu
            WHERE seg.seqGestion = ges.seqGestion
            AND ges.seqGrupoGestion = gge.seqGrupoGestion
            AND seg.seqUsuario = usu.seqUsuario
            AND seg.bolMostrar = 1 and seg.fchMovimiento > '2017-05-10'   and seqFormulario =  $seqFormulario    	
            ORDER BY seg.seqSeguimiento DESC            
        ";
        return $aptBd->GetAll($sql);
    }

}
