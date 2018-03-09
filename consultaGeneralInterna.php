<?php

$txtPrefijoRuta = "./";

include( "./recursos/archivos/verificarSesion.php" ); // Verifica si hay sesion
include( "./recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );

if($_POST['txtSistema'] == "sdht_subsidios") {
    $arrConfiguracion['baseDatos']['nombre'] = $_POST['txtSistema'];
}

include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$seqFormulario = intval($_POST['seqFormulario']);
$seqTipoDocumento = intval($_POST['seqTipoDocumento']);
$numDocumento = intval($_POST['numDocumento']);
$txtSistema = trim($_POST['txtSistema']);

if($seqFormulario == 0){
    $seqFormulario = consultarFormulario($seqTipoDocumento,$numDocumento);
}

$arrDatosBasicos = array();
$arrDatosMiembros = array();
$arrDatosAAD = array();
$arrDatosDesembolso = array();

if($seqFormulario != 0){
    $arrDatosBasicos    = consultaBasicaHogar($seqFormulario);
    $arrDatosMiembros   = consultaMiembros($seqFormulario);
    $arrDatosAAD        = consultaAAD($seqFormulario);
    $arrDatosDesembolso = consultaDesembolsos($seqFormulario);
}

$claSmarty->assign("seqFormulario", $seqFormulario);
$claSmarty->assign("seqTipoDocumento", $seqTipoDocumento);
$claSmarty->assign("numDocumento", $numDocumento);
$claSmarty->assign("txtSistema", $txtSistema);
$claSmarty->assign("arrDatosBasicos",$arrDatosBasicos);
$claSmarty->assign("arrDatosMiembros",$arrDatosMiembros);
$claSmarty->assign("arrDatosAAD",$arrDatosAAD);
$claSmarty->assign("arrDatosDesembolso",$arrDatosDesembolso);

$claSmarty->display("consultaGeneralInterna.tpl");

function consultaBasicaHogar($seqFormulario){
    global $aptBd, $txtSistema;

    if($_POST['txtSistema'] == "sdht_subsidios") {
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
                  frm.valAspiraSubsidio as 'Valor del Subsidio / Aporte'
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
                left join t_pry_unidad_proyecto upr on frm.seqUnidadProyecto = upr.seqUnidadProyecto
                WHERE hog.seqParentesco = 1
                  AND frm.seqFormulario = $seqFormulario
            ";
    }else{
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
                  AND frm.seqFormulario = $seqFormulario
            ";
    }

    return $aptBd->GetAll($sql);
}

function consultaMiembros($seqFormulario){
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

function consultaAAD($seqFormulario){
    global $aptBd;

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
            WHERE fac.seqFormulario = $seqFormulario
         ";

    return $aptBd->GetAll($sql);
}

function consultarFormulario($seqTipoDocumento, $numDocumento){
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
    while($objRes->fields){
        $seqFormulario = $objRes->fields['seqFormulario'];
        $objRes->MoveNext();
    }
    return $seqFormulario;
}

function consultaDesembolsos($seqFormulario){
    global $aptBd;

    $sql = "
            select 
                des.seqDesembolso as 'Desembolso',
                des.txtNombreVendedor as 'Vendedor',
                tdo.txtTipoDocumento as 'Tipo de documento',
                des.numDocumentoVendedor as 'Documento del vendedor',
                des.txtDireccionInmueble as 'Dirección',
                des.txtMatriculaInmobiliaria as 'Matrícula inmobiliaria',
                des.txtChip as 'CHIP',
                des.txtEscritura as 'Escritura',
                des.fchEscritura as 'Fecha',
                des.numNotaria as 'Notaría',
                des.txtCiudad as 'Ciudad'
            from t_des_desembolso des
            inner join t_ciu_tipo_documento tdo on des.seqTipoDocumento = tdo.seqTipoDocumento
            where seqFormulario = $seqFormulario
        ";
    $arrDatos = $aptBd->GetAll($sql);
    $arrDesembolso = array();
    foreach($arrDatos as $arrRegistro){

        $seqDesembolso = $arrRegistro['Desembolso'];
        $arrDesembolso[$seqDesembolso]['Antecedente'] = $arrRegistro;

        $sql = "
                select 
                    seqJuridico as 'Juridico',                    
                    txtConcepto as 'Concepto'
                from t_des_juridico 
                where seqDesembolso = $seqDesembolso
            ";
        $arrJuridico = $aptBd->GetAll($sql);

        foreach($arrJuridico as $arrRegistroJuridico){
            $arrDesembolso[$seqDesembolso]['Juridico'] = $arrRegistroJuridico;
        }

        $sql = "
                select 
                    seqTecnico as 'Técnico',
                    txtExistencia as 'Certificado de existencia'
                from t_des_tecnico
                where seqDesembolso = $seqDesembolso
            ";
        $arrTecnico = $aptBd->GetAll($sql);

        foreach($arrTecnico as $arrRegistroTecnico){
            $arrDesembolso[$seqDesembolso]['Técnico'] = $arrRegistroTecnico;
        }

        $sql = "
                select 
                    esc.seqEscrituracion as 'Escrituracion',
                    esc.txtNombreVendedor as 'Vendedor',
                    tdo.txtTipoDocumento as 'Tipo de documento',
                    esc.numDocumentoVendedor as 'Documento del vendedor',
                    esc.txtDireccionInmueble as 'Dirección',
                    esc.txtMatriculaInmobiliaria as 'Matrícula inmobiliaria',
                    esc.txtChip as 'CHIP',
                    esc.txtEscritura as 'Escritura',
                    esc.fchEscritura as 'Fecha',
                    esc.numNotaria as 'Notaría',
                    esc.txtCiudad as 'Ciudad'
                from t_des_escrituracion esc
                left join t_ciu_tipo_documento tdo on esc.seqTipoDocumento = tdo.seqTipoDocumento
                where seqDesembolso = $seqDesembolso
            ";
        $arrEscrituracion = $aptBd->GetAll($sql);

        foreach($arrEscrituracion as $arrRegistroEscrituracion){
            $arrDesembolso[$seqDesembolso]['Escrituración'] = $arrRegistroEscrituracion;
        }

        $sql = "
                select
                    tit.seqEstudioTitulos as 'Titulos',
                    ati.seqAdjuntoTitulos as 'Adjunto',
                    ati.txtAdjunto as 'Recomendación'
                from t_des_estudio_titulos tit
                inner join t_des_adjuntos_titulos ati on tit.seqEstudioTitulos = ati.seqEstudioTitulos
                where seqDesembolso = $seqDesembolso
                  and seqTipoAdjunto = 2
            ";
        $arrTitulos = $aptBd->GetAll($sql);

        foreach($arrTitulos as $arrRegistroTitulos){
            $seqAdjuntoTitulos = $arrRegistroTitulos['Adjunto'];
            $arrDesembolso[$seqDesembolso]['Títulos'][$seqAdjuntoTitulos] = $arrRegistroTitulos;
        }

        $sql = "
                select 
                    seqSolicitud as 'Solicitud',
                    numRadiacion as 'Numero de radicación',
                    fchRadicacion as 'Fecha de radicación',
                    valSolicitado as 'Valor solicitado',
                    numOrden as 'Número de orden',
                    fchOrden as 'Fecha de orden',
                    valOrden as 'Valor de la orden'
                from t_des_solicitud
                where seqDesembolso = $seqDesembolso
            ";
        $arrSolicitudes = $aptBd->GetAll($sql);

        foreach($arrSolicitudes as $arrRegistroSolicitud){
            $seqAdjuntoSolicitud = $arrRegistroSolicitud['Solicitud'];
            unset($arrRegistroSolicitud['Solicitud']);
            $arrDesembolso[$seqDesembolso]['Solicitudes'][$seqAdjuntoSolicitud] = $arrRegistroSolicitud;
        }

    }

    return $arrDesembolso;

}

?>