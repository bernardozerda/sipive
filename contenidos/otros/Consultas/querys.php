<?php

$consulta1 = 'SELECT seqTipoDocumento,txtTipoDocumento FROM T_CIU_TIPO_DOCUMENTO ORDER BY txtTipoDocumento;';
$consulta2 = 'SELECT seqTipoVictima,txtTipoVictima FROM T_FRM_TIPOVICTIMA WHERE seqTipoVictima <> 0 ORDER BY txtTipoVictima;';
$consulta3 = 'SELECT seqGrupoLgtbi,txtGrupoLgtbi FROM T_FRM_GRUPO_LGTBI WHERE seqGrupoLgtbi <> 0 ORDER BY txtGrupoLgtbi;';
$consulta4 = 'SELECT seqSexo,txtSexo FROM T_CIU_SEXO ORDER BY txtSexo;';
$consulta5 = 'SELECT seqEstadoCivil,txtEstadoCivil FROM T_CIU_ESTADO_CIVIL ORDER BY txtEstadoCivil;';
$consulta6 = 'SELECT seqVivienda,txtVivienda FROM T_FRM_VIVIENDA ORDER BY txtVivienda;';
$consulta7 = 'SELECT seqModalidad,txtModalidad,seqPlanGobierno FROM T_FRM_MODALIDAD ORDER BY seqPlanGobierno DESC, txtModalidad;';
$consulta8 = 'SELECT seqSisben,txtSisben FROM T_FRM_SISBEN;';
$consulta9 = 'SELECT seqCajaCompensacion,txtCajaCompensacion FROM T_CIU_CAJA_COMPENSACION;';
$consulta10 = 'SELECT seqBanco,txtBanco FROM T_FRM_BANCO WHERE seqBanco > 1 ORDER BY txtBanco;';
$consulta11 = 'SELECT seqParentesco,txtParentesco FROM T_CIU_PARENTESCO ORDER BY txtParentesco;';
$consulta12 = 'SELECT seqCondicionEspecial,txtCondicionEspecial FROM T_CIU_CONDICION_ESPECIAL WHERE seqCondicionEspecial <> 6 ORDER BY txtCondicionEspecial;';
$consulta13 = 'SELECT seqEtnia,txtEtnia FROM T_CIU_ETNIA WHERE seqEtnia > 1 ORDER BY txtEtnia;';
$consulta14 = 'SELECT seqOcupacion,txtOcupacion FROM T_CIU_OCUPACION WHERE seqOcupacion <> 20 ORDER BY txtOcupacion;';
//$consulta15 = 'SELECT seqCiudad,CONCAT( txtDepartamento , ' - ' , txtCiudad ) as txtCiudad FROM T_FRM_CIUDAD ORDER BY txtCiudad;';
$consulta16 = 'SELECT seqLocalidad,txtLocalidad FROM T_FRM_LOCALIDAD WHERE seqLocalidad <> 1;';
$consulta17 = 'SELECT seqBarrio,txtBarrio FROM T_FRM_BARRIO ORDER BY txtBarrio;';
$consulta18 = 'SELECT seqSolucion,txtSolucion,seqModalidad FROM T_FRM_SOLUCION WHERE seqSolucion <> 1;';
$consulta19 = 'SELECT seqNivelEducativo,txtNivelEducativo FROM T_CIU_NIVEL_EDUCATIVO WHERE seqNivelEducativo > 1 ORDER BY txtNivelEducativo;';
$consulta20 = 'SELECT seqSalud,txtSalud FROM T_CIU_SALUD ORDER BY txtSalud;';
$consulta21 = 'SELECT seqEmpresaDonante,txtEmpresaDonante FROM T_FRM_EMPRESA_DONANTE WHERE seqEmpresaDonante > 1 ORDER BY txtEmpresaDonante ;';
$consulta22 = 'SELECT seqEntidadSubsidio,txtEntidadSubsidio FROM T_FRM_ENTIDAD_SUBSIDIO ORDER BY seqEntidadSubsidio;';
$consulta23 = 'SELECT seqProyecto,txtNombreProyecto FROM T_PRY_PROYECTO WHERE seqTipoEsquema NOT IN ( 8 ) ORDER BY txtNombreProyecto;';
$consulta24 = 'SELECT seqProyecto,txtNombre FROM T_FRM_PROYECTO ORDER BY txtNombre;';
$consulta25 = 'SELECT seqGrupoGestion,txtGrupoGestion FROM T_SEG_GRUPO_GESTION WHERE seqGrupoGestion NOT IN ( 15,5,10,12,17,20 ) ORDER BY txtGrupoGestion;';
$consulta26 = 'SELECT seqPlanGobierno,txtPlanGobierno FROM T_FRM_PLAN_GOBIERNO ORDER BY txtPlanGobierno;';
