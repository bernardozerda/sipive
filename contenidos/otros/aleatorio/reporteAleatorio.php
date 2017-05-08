<?php

$link = mysql_connect('localhost', 'sdht_usuario', 'Ochochar*1') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('sipive') or die('No se pudo seleccionar la base de datos');

$lineas = file('formularios.txt');

header("Content-Type: application/vnd.ms-excel");
header("content-disposition: attachment;filename=aleatorio.xls");
echo "<table border = '1'>
    <tr>   
    <th>seqFormulario</th>
<th>txtFormulario</th>
<th>NumeroResolucion</th>
<th>FechaResolucion</th>
<th>NombrePPAL</th>
<th>NumeroDocumentoPPAL</th>
<th>Nombre</th>
<th>Primer Nombre</th>
<th>Segundo Nombre</th>
<th>Primer Apellido</th>
<th>Segundo Apellido</th>
<th>Tipo de Documento</th>
<th>Documento</th>
<th>Parentesco</th>
<th>Estado Civil</th>
<th>Fecha de Nacimiento</th>
<th>Condici&oacute;n Especial 1</th>
<th>Condici&oacute;n Especial 2</th>
<th>Condici&oacute;n Especial 3</th>
<th>Hecho Victimizante</th>
<th>Sexo</th>
<th>Condici&oacute;n Etnica</th>
<th>LGTBI</th>
<th>Grupo LGTBI</th>
<th>Nivel Educativo</th>
<th>Sistema de Salud</th>
<th>Ingresos del Ciudadano</th>
<th>Ocupaci&oacute;n</th>
<th>Fecha de Inscripcion</th>
<th>Fecha Postulaci&oacute;n</th>
<th>Fecha Ultima Actualizacion</th>
<th>Tipo de Vivienda</th>
<th>Valor Arriendo</th>
<th>Direccion de Residencia</th>
<th>Localidad</th>
<th>Telefono Fijo 1</th>
<th>Telefono Fijo 2</th>
<th>Telefono Celular</th>
<th>Correo electronico</th>
<th>Hogar Victima</th>
<th>Valor Subsidio</th>
<th>Vigencia SDV</th>
<th>Punto de Atencion</th>
<th>Direcion de la Solucion</th>
<th>Modalidad</th>
<th>Solucion de Vivienda</th>
<th>Proyecto</th>
<th>Conjunto Residencial</th>
<th>Unidad Proyecto</th>
<th>CHIP</th>
<th>Matricula Inmobiliaria</th>
<th>Promesa Firmada</th>
<th>Ingresos del Hogar</th>
<th>Saldo Cuenta Ahorro 1</th>
<th>Banco Cuenta Ahorro 1</th>
<th>Soporte Cuenta Ahorro 1</th>
<th>Cuenta Ahorro 1 Inmobilizada</th>
<th>Fecha Apertura Cuenta Ahorro 1</th>
<th>Saldo Cuenta Ahorro 2</th>
<th>Banco Cuenta Ahorro 2</th>
<th>Soporte Cuenta Ahorro 2</th>
<th>Cuenta Ahorro 2 Inmobilizada</th>
<th>Fecha Apertura Cuenta Ahorro 2</th>
<th>Valor Subsidio: AVC / FOVIS / SFV</th>
<th>Soporte Subsidio: AVC / FOVIS / SFV</th>
<th>Valor Aporte Lote</th>
<th>Valor Cesantias</th>
<th>Soporte Cesantias</th>
<th>Valor Aporte Avance Obra</th>
<th>Soporte Avance Obra</th>
<th>Valor Credito</th>
<th>Banco Credito</th>
<th>Soporte Credito</th>
<th>Fecha Vencimiento del Credito</th>
<th>Valor Aporte Materiales</th>
<th>Soporte Aporte Materiales</th>
<th>Valor Reconocimiento / Donaci&oacute;n</th>
<th>Empresa Reconocimiento / Donaci&oacute;n</th>
<th>Soporte Cambio Valor Reconocimiento / Donaci&oacute;n</th>
<th>Esquema</th>
 </tr>";

foreach ($lineas as $linea_num => $linea) {
    $datos = explode("\t", $linea);
    $clave = trim($datos[0]);
    $consulta = "SELECT frm.seqFormulario,
       frm.txtFormulario,
       (SELECT DISTINCT concat('Res. ', aad.numActo)
          FROM T_AAD_ACTO_ADMINISTRATIVO aad
               LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi
                  ON aad.fchActo = hvi.fchActo AND aad.numActo = hvi.numActo
               LEFT JOIN T_AAD_FORMULARIO_ACTO fac
                  ON hvi.seqFormularioActo = fac.seqFormularioActo
               LEFT JOIN T_AAD_HOGAR_ACTO hac
                  ON fac.seqFormularioActo = hac.seqFormularioActo
               LEFT JOIN T_AAD_CIUDADANO_ACTO cac
                  ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               LEFT JOIN t_aad_tipo_acto tac
                  ON aad.seqTipoActo = tac.seqTipoActo
               LEFT JOIN t_frm_formulario frm
                  ON fac.seqFormulario = frm.seqFormulario
         WHERE     fac.seqFormulario = hog.seqFormulario
               AND aad.seqCaracteristica = 1
               AND YEAR(aad.fchActo) = '2014'
               AND (hac.seqParentesco = 1 OR hac.seqParentesco IS NULL))
          AS NumeroResolucion,
       (SELECT DISTINCT DATE_FORMAT(aad.fchActo, '%d-%m-%Y')
          FROM T_AAD_ACTO_ADMINISTRATIVO aad
               LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi
                  ON aad.fchActo = hvi.fchActo AND aad.numActo = hvi.numActo
               LEFT JOIN T_AAD_FORMULARIO_ACTO fac
                  ON hvi.seqFormularioActo = fac.seqFormularioActo
               LEFT JOIN T_AAD_HOGAR_ACTO hac
                  ON fac.seqFormularioActo = hac.seqFormularioActo
               LEFT JOIN T_AAD_CIUDADANO_ACTO cac
                  ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
               LEFT JOIN t_aad_tipo_acto tac
                  ON aad.seqTipoActo = tac.seqTipoActo
               LEFT JOIN t_frm_formulario frm
                  ON fac.seqFormulario = frm.seqFormulario
         WHERE     fac.seqFormulario = hog.seqFormulario
               AND aad.seqCaracteristica = 1
               AND YEAR(aad.fchActo) = '2014'
               AND (hac.seqParentesco = 1 OR hac.seqParentesco IS NULL))
          AS FechaResolucion,
       (SELECT upper(concat(ciu1.txtNombre1,
                            ' ',
                            ciu1.txtNombre2,
                            ' ',
                            ciu1.txtApellido1,
                            ' ',
                            ciu1.txtApellido2))
          FROM T_FRM_HOGAR hog1
               INNER JOIN T_CIU_CIUDADANO ciu1
                  ON hog1.seqCiudadano = ciu1.seqCiudadano
         WHERE     hog1.seqFormulario = hog.seqFormulario
               AND hog1.seqParentesco = 1)
          AS 'NombrePPAL',
       (SELECT ciu1.numDocumento
          FROM T_FRM_HOGAR hog1
               INNER JOIN T_CIU_CIUDADANO ciu1
                  ON hog1.seqCiudadano = ciu1.seqCiudadano
         WHERE     hog1.seqFormulario = hog.seqFormulario
               AND hog1.seqParentesco = 1)
          AS 'NumeroDocumentoPPAL',
       upper(concat(ciu.txtNombre1,
                    ' ',
                    ciu.txtNombre2,
                    ' ',
                    ciu.txtApellido1,
                    ' ',
                    ciu.txtApellido2))
          AS 'Nombre',
       upper(ciu.txtNombre1) AS 'Primer Nombre',
       upper(ciu.txtNombre2) AS 'Segundo Nombre',
       upper(ciu.txtApellido1) AS 'Primer Apellido',
       upper(ciu.txtApellido2) AS 'Segundo Apellido',
       tdo.txtTipoDocumento AS 'Tipo de Documento',
       ciu.numDocumento AS 'Documento',
       par.txtParentesco AS 'Parentesco',
       eci.txtEstadoCivil AS 'Estado Civil',
       DATE_FORMAT(ciu.fchNacimiento, '%d-%m-%Y') AS 'Fecha de Nacimiento',
       ce1.txtCondicionEspecial AS 'Condición Especial 1',
       ce2.txtCondicionEspecial AS 'Condición Especial 2',
       ce3.txtCondicionEspecial AS 'Condición Especial 3',
       tvc.txtTipoVictima AS 'Hecho Victimizante',
       sex.txtSexo AS 'Sexo',
       etn.txtEtnia AS 'Condición Etnica',
       if(ciu.bolLgtb = 1, 'SI', 'NO') AS 'LGTBI',
       glg.txtGrupoLgtbi AS 'Grupo LGTBI',
       ned.txtNivelEducativo AS 'Nivel Educativo',
       sal.txtSalud AS 'Sistema de Salud',
       ciu.valIngresos AS 'Ingresos del Ciudadano',
       ocu.txtOcupacion AS 'Ocupación',
       DATE_FORMAT(frm.fchInscripcion, '%d-%m-%Y') AS 'Fecha de Inscripcion',
       DATE_FORMAT(frm.fchPostulacion, '%d-%m-%Y') AS 'Fecha Postulacion',
       DATE_FORMAT(frm.fchUltimaActualizacion, '%d-%m-%Y')
          AS 'Fecha Ultima Actualizacion',
       viv.txtVivienda AS 'Tipo de Vivienda',
       frm.valArriendo AS 'Valor Arriendo',
       upper(frm.txtDireccion) AS 'Direccion de Residencia',
       loc.txtLocalidad AS 'Localidad',
       frm.numTelefono1 AS 'Telefono Fijo 1',
       frm.numTelefono2 AS 'Telefono Fijo 2',
       frm.numCelular AS 'Telefono Celular',
       upper(frm.txtCorreo) AS 'Correo electronico',
       tvh.txtDesplazado AS 'Hogar Victima',
       frm.valAspiraSubsidio AS 'Valor Subsidio',
       DATE_FORMAT(frm.fchVigencia, '%d-%m-%Y') AS 'Vigencia SDV',
       pun.txtPuntoAtencion AS 'Punto de Atencion',
       upper(frm.txtDireccionSolucion) AS 'Direcion de la Solucion',
       moa.txtModalidad AS 'Modalidad',
       sol.txtSolucion AS 'Solucion de Vivienda',
       pro.txtNombreProyecto AS 'Proyecto',
       prh.txtNombreProyecto AS 'Conjunto Residencial',
       und.txtNombreUnidad AS 'Unidad Proyecto',
       upper(frm.txtChip) AS 'CHIP',
       upper(frm.txtMatriculaInmobiliaria) AS 'Matricula Inmobiliaria',
       if(frm.bolPromesaFirmada = 1, 'SI', 'NO') AS 'Promesa Firmada',
       frm.valIngresoHogar AS 'Ingresos del Hogar',
       frm.valSaldoCuentaAhorro AS 'Saldo Cuenta Ahorro 1',
       ba1.txtBanco AS 'Banco Cuenta Ahorro 1',
       upper(frm.txtSoporteCuentaAhorro) AS 'Soporte Cuenta Ahorro 1',
       if(frm.bolInmovilizadoCuentaAhorro = 1, 'SI', 'NO')
          AS 'Cuenta Ahorro 1 Inmobilizada',
       DATE_FORMAT(frm.fchAperturaCuentaAhorro, '%d-%m-%Y')
          AS 'Fecha Apertura Cuenta Ahorro 1',
       frm.valSaldoCuentaAhorro2 AS 'Saldo Cuenta Ahorro 2',
       ba2.txtBanco AS 'Banco Cuenta Ahorro 2',
       upper(frm.txtSoporteCuentaAhorro2) AS 'Soporte Cuenta Ahorro 2',
       if(frm.bolInmovilizadoCuentaAhorro2 = 1, 'SI', 'NO')
          AS 'Cuenta Ahorro 2 Inmobilizada',
       DATE_FORMAT(frm.fchAperturaCuentaAhorro2, '%d-%m-%Y')
          AS 'Fecha Apertura Cuenta Ahorro 2',
       frm.valSubsidioNacional AS 'Valor Subsidio: AVC / FOVIS / SFV',
       upper(frm.txtSoporteSubsidioNacional)
          AS 'Soporte Subsidio: AVC / FOVIS / SFV',
       frm.valAporteLote AS 'Valor Aporte Lote',
       frm.valSaldoCesantias AS 'Valor Cesantias',
       upper(frm.txtSoporteCesantias) AS 'Soporte Cesantias',
       frm.valAporteAvanceObra AS 'Valor Aporte Avance Obra',
       upper(frm.txtSoporteAvanceObra) AS 'Soporte Avance Obra',
       frm.valCredito AS 'Valor Credito',
       bcr.txtBanco AS 'Banco Credito',
       upper(frm.txtSoporteCredito) AS 'Soporte Credito',
       DATE_FORMAT(frm.fchAprobacionCredito, '%d-%m-%Y')
          AS 'Fecha Vencimiento del Credito',
       frm.valAporteMateriales AS 'Valor Aporte Materiales',
       upper(frm.txtSoporteAporteMateriales) AS 'Soporte Aporte Materiales',
       frm.valDonacion AS 'Valor Reconocimiento / Donación',
       edo.txtEmpresaDonante AS 'Empresa Reconocimiento / Donación',
       upper(frm.txtSoporteSubsidio)
          AS 'Soporte Cambio Valor Reconocimiento / Donación',
       tes.txtTipoEsquema AS Esquema
  FROM T_FRM_FORMULARIO frm
       INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
       INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
       INNER JOIN T_CIU_TIPO_DOCUMENTO tdo
          ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
       INNER JOIN T_FRM_ESTADO_PROCESO epr
          ON frm.seqEstadoProceso = epr.seqEstadoProceso
       INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
       INNER JOIN T_CIU_PARENTESCO par
          ON hog.seqParentesco = par.seqParentesco
       INNER JOIN T_CIU_ESTADO_CIVIL eci
          ON ciu.seqEstadoCivil = eci.seqEstadoCivil
       INNER JOIN T_CIU_CONDICION_ESPECIAL ce1
          ON ciu.seqCondicionEspecial = ce1.seqCondicionEspecial
       INNER JOIN T_CIU_CONDICION_ESPECIAL ce2
          ON ciu.seqCondicionEspecial2 = ce2.seqCondicionEspecial
       INNER JOIN T_CIU_CONDICION_ESPECIAL ce3
          ON ciu.seqCondicionEspecial3 = ce3.seqCondicionEspecial
       INNER JOIN T_FRM_TIPOVICTIMA tvc
          ON ciu.seqTipoVictima = tvc.seqTipoVictima
       INNER JOIN T_CIU_SEXO sex ON ciu.seqSexo = sex.seqSexo
       INNER JOIN T_CIU_ETNIA etn ON ciu.seqEtnia = etn.seqEtnia
       INNER JOIN T_FRM_GRUPO_LGTBI glg
          ON ciu.seqGrupoLgtbi = glg.seqGrupoLgtbi
       INNER JOIN T_CIU_NIVEL_EDUCATIVO ned
          ON ciu.seqNivelEducativo = ned.seqNivelEducativo
       INNER JOIN T_CIU_SALUD sal ON ciu.seqSalud = sal.seqSalud
       INNER JOIN T_CIU_OCUPACION ocu ON ciu.seqOcupacion = ocu.seqOcupacion
       INNER JOIN T_COR_USUARIO usu ON frm.seqUsuario = usu.seqUsuario
       INNER JOIN T_FRM_VIVIENDA viv ON frm.seqVivienda = viv.seqVivienda
       INNER JOIN T_FRM_LOCALIDAD loc ON frm.seqLocalidad = loc.seqLocalidad
       INNER JOIN T_FRM_TIPO_VICTIMA_HOGAR tvh
          ON frm.bolDesplazado = tvh.bolDesplazado
       INNER JOIN T_FRM_PUNTO_ATENCION pun
          ON frm.seqPuntoAtencion = pun.seqPuntoAtencion
       INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
       INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
       LEFT JOIN T_PRY_PROYECTO pro ON frm.seqProyecto = pro.seqProyecto
       LEFT JOIN T_PRY_PROYECTO prh ON frm.seqProyectoHijo = prh.seqProyecto
       LEFT JOIN T_PRY_UNIDAD_PROYECTO und
          ON frm.seqUnidadProyecto = und.seqUnidadProyecto
       INNER JOIN T_FRM_BANCO ba1 ON frm.seqBancoCuentaAhorro = ba1.seqBanco
       INNER JOIN T_FRM_BANCO ba2 ON frm.seqBancoCuentaAhorro2 = ba2.seqBanco
       INNER JOIN T_FRM_BANCO bcr ON frm.seqBancoCredito = bcr.seqBanco
       INNER JOIN T_FRM_EMPRESA_DONANTE edo
          ON frm.seqEmpresaDonante = edo.seqEmpresaDonante
       LEFT JOIN t_pry_tipo_esquema tes
          ON tes.seqTipoEsquema = frm.seqTipoEsquema
       LEFT JOIN t_cem_casa_mano cem ON cem.seqFormulario = frm.seqFormulario
 WHERE (1 = 1) AND numDocumento > 0 AND frm.seqFormulario = '$clave';";
    
    $result = mysql_query($consulta) or die('Consulta fallida: ' . mysql_error());
    while ($hogar = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo "<tr>";
        foreach ($hogar as $col_value) {
            echo "<td>$col_value</td>";
        }
        echo "</tr>";
    }
}
echo "</table>";

// Liberar resultados
mysql_free_result($result);

// Cerrar la conexión
mysql_close($link);
?>