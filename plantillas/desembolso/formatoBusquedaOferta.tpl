{assign var=seqModalidad     value=$claFormulario->seqModalidad}
{assign var=seqSolucion      value=$claFormulario->seqSolucion}		
{assign var=seqLocalidad     value=$claFormulario->seqLocalidad}
{assign var=seqLocalidadDesembolso value=$claDesembolso->seqLocalidad}
{assign var=seqBancoAhorro   value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoAhorro2  value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito  value=$claFormulario->seqBancoCredito}
{assign var=seqEstadoProceso value=$claFormulario->seqEstadoProceso}

{assign var=seqBancoCuentaAhorro  value=$claFormulario->seqBancoCuentaAhorro}
{assign var=seqBancoCuentaAhorro2 value=$claFormulario->seqBancoCuentaAhorro2}
{assign var=seqBancoCredito       value=$claFormulario->seqBancoCredito}
{assign var=seqEntidadDonante     value=$claFormulario->seqEmpresaDonante}

{assign var=tipoDocVendedor value=$claDesembolso->seqTipoDocumento}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="SIPIVE">
        <meta name="keywords" content="pive,subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
        <meta name="description" content="SIPIVE">
        <meta http-equiv="Content-Language" content="es">
        <meta name="robots" content="index,  nofollow" />
        <title>SDV - SDHT</title>
    </head>
    <body>
    {*<body onLoad="window.print();">*}

    {*<table cellspacing="0" cellpadding="0" border="0" width="750px" style="border: 1px solid #999999;">*}
        {*<tr>*}
            {*<td width="150px" height="80px" align="center" valign="middle">*}
                {*<img src="../../recursos/imagenes/escudo.png">*}
            {*</td>*}
            {*<td align="center" valign="middle" style="{$txtFuente12} padding:10px;">*}
                {*<strong>ALCALDIA MAYOR DE BOGOTA - SECRETARIA DEL HABITAT</strong><br>*}
                {*PROGRAMA INTEGRAL DE VIVIENDA EFECTIVA (PIVE)<br>*}
                {*Proceso de Desembolso. Recibo de Documentación<br>*}
                {*<span style="{$txtFuente10}">*}
                    {*Fecha de Radicaci&oacute;n: {$txtFecha}<br>*}
                    {*No. Registro: {$numRegistro|number_format:0:'.':','}*}
                {*</span>*}
            {*</td>*}
            {*<td width="150px" align="center" valign="middle">*}
                {*<img src="../../recursos/imagenes/bta_positiva_carta.jpg">*}
            {*</td>*}
        {*</tr>*}
    {*</table>*}

    {*<table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">*}
        {*<tr>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Beneficiario</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.nombre}&nbsp;</td>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Documento</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.tipoDocumento} {$arrBeneficiario.documento}&nbsp;</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Modalidad</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.modalidad}&nbsp;</td>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Valor estimado del aporte</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.valor}&nbsp;</td>*}
        {*</tr>*}
        {*{if $seqCasaMano == 0}*}
            {*<tr>*}
                {*<td style="border-bottom: 1px dotted #999999;"><strong>Resoluci&oacute;n de Asignaci&oacute;n</strong></td>*}
                {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.resolucion}&nbsp;</td>*}
                {*<td style="border-bottom: 1px dotted #999999;">&nbsp;</td>*}
                {*<td style="border-bottom: 1px dotted #999999;">&nbsp;</td>*}
            {*</tr>*}
        {*{/if}*}
        {*<tr>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Direcci&oacute;n</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;" colspan="3">{$arrBeneficiario.direccion}&nbsp;</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Localidad</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.localidad}&nbsp;</td>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Barrio</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.barrio}&nbsp;</td>*}
        {*</tr>*}
        {*<tr>*}
            {*<td style="border-bottom: 1px dotted #999999;"><strong>Tel&eacute;fonos</strong></td>*}
            {*<td style="border-bottom: 1px dotted #999999;" colspan="3">*}
                {*{$arrBeneficiario.telefono1}&nbsp;&nbsp;&nbsp;*}
                {*{$arrBeneficiario.telefono2}&nbsp;&nbsp;&nbsp;*}
                {*{$arrBeneficiario.celular}&nbsp;*}
            {*</td>*}
        {*</tr>*}
    {*</table>*}

    {*<br>*}
    {*<hr>*}


                        <table cellspacing="0" cellpadding="0" border="0" width="750px" style="border: 1px solid #999999;">
                            <tr>
                                <td width="150px" height="80px" align="center" valign="middle">
                                    {if in_array( 31, $smarty.session.arrGrupos.3) || in_array( 32, $smarty.session.arrGrupos.3) || in_array( 33, $smarty.session.arrGrupos.3)}
                                        <img src="../../recursos/imagenes/cvp.png">
                                        {else}
                                            <img src="../../recursos/imagenes/escudo.png">
                                            {/if}
                                            </td>
                                            {if $seqCasaMano == 0}
                                                <td align="center" valign="middle" style="{$txtFuente12} padding:10px;">
                                                    <strong>ALCALDIA MAYOR DE BOGOTA</strong><br>
                                                    SECRETARIA DEL HABITAT<br>
                                                    PROGRAMA INTEGRAL DE VIVIENDA EFECTIVA (PIVE)<br>
                                                        <strong>Proceso de Desembolso. Recibo de Documentación</strong><br>
                                                            <span style="{$txtFuente10}">
                                                                Fecha de Radicaci&oacute;n: {$txtFecha}<br>
                                                                    No. Registro: {$numRegistro|number_format:0:'.':','}
                                                            </span>
                                                            </td>
                                                        {else}
                                                            <td align="center" valign="middle" style="{$txtFuente12} padding:10px;">
                                                                <strong>Secretaría Distrital de Hábitat</strong><br>
                                                                    <strong>Programa PIVE.<br>Recibo de Documentación</strong><br>
                                                                        <span style="{$txtFuente10}">
                                                                            Fecha de Radicaci&oacute;n: {$txtFecha}<br>
                                                                                No. Registro: {$numRegistro|number_format:0:'.':','}
                                                                        </span>
                                                                        </td>
                                                                    {/if}
                                                                    <td width="150px" align="center" valign="middle"><img src="../../recursos/imagenes/bta_positiva_carta.jpg"></td>
                                                                    </tr>
                                                                    </table>
                                                                    <table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Nombre del Beneficiario</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.nombre}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Documento</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.tipoDocumento} {$arrBeneficiario.documento}&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Modalidad</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.modalidad}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Valor estimado del aporte</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.valor}&nbsp;</td>
                                                                        </tr>
                                                                        {if $seqCasaMano == 0}
                                                                            <tr>
                                                                                <td style="border-bottom: 1px dotted #999999;"><strong>Resoluci&oacute;n de Asignaci&oacute;n</strong></td>
                                                                                <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.resolucion}&nbsp;</td>
                                                                                <td style="border-bottom: 1px dotted #999999;">&nbsp;</td>
                                                                                <td style="border-bottom: 1px dotted #999999;">&nbsp;</td>
                                                                            </tr>
                                                                        {/if}
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Direcci&oacute;n</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" colspan="3">{$arrBeneficiario.direccion}&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Localidad</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.localidad}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Barrio</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.barrio}&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Tel&eacute;fonos</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" colspan="3">
                                                                                {$arrBeneficiario.telefono1}&nbsp;&nbsp;&nbsp;
                                                                                {$arrBeneficiario.telefono2}&nbsp;&nbsp;&nbsp;
                                                                                {$arrBeneficiario.celular}&nbsp;
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                    <table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
                                                                        <tr>
                                                                            <td bgcolor="#CECECE" align="center" colspan="4"><strong>DATOS DEL INMUEBLE</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;" width="140px"><strong>Nombre del Vendedor</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtNombreVendedor|ucwords}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;" width="120px"><strong>Documento</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" width="200px">{$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Direcci&oacute;n del inmueble</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" >{$claDesembolso->txtDireccionInmueble|strtoupper}&nbsp;</td>
                                                                            {if $nombreComercial != ''}
                                                                                <td style="border-bottom: 1px dotted #999999;"><strong>Proyecto</strong></td>
                                                                                <td style="border-bottom: 1px dotted #999999;">{$nombreComercial}</td>

                                                                            {/if}
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Localidad</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrLocalidad.$seqLocalidadDesembolso}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Barrio</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtBarrio}&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;" width="130px"><strong>Título de Propiedad</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" colspan="3">
                                                                                {if $claDesembolso->txtPropiedad == "escritura"}
                                                                                    Escritura Pública Número {$claDesembolso->txtEscritura} del {$claDesembolso->fchEscritura} registrada en la notaria {$claDesembolso->numNotaria}&nbsp; de {$claDesembolso->txtCiudad} 
                                                                                {/if}
                                                                                {if $claDesembolso->txtPropiedad == "sentencia"}
                                                                                    Sentencia con fecha de {$claDesembolso->fchSentencia} del juzgado {$claDesembolso->numJuzgado} en la ciudad de {$claDesembolso->txtCiudadSentencia|upper}
                                                                                {/if}
                                                                                {if $claDesembolso->txtPropiedad == "resolucion"}
                                                                                    Resolución número {$claDesembolso->numResolucion} del {$claDesembolso->fchResolucion} expedido por {$claDesembolso->txtEntidad|upper} en la ciudad de {$claDesembolso->txtCiudadResolucion|upper}
                                                                                {/if}
                                                                            </td>
                                                                        </tr>

                                                                        {if $claFormulario->seqModalidad == 13}
                                                                            <tr>
                                                                                <td style="border-bottom: 1px dotted #999999;" width="130px"><strong>Contrato Leasing</strong></td>
                                                                                <td style="border-bottom: 1px dotted #999999;" colspan="3">
                                                                                    {$arrContratoLeasing.numContratoLeasing} de {$arrContratoLeasing.txtFechaLeasing}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border-bottom: 1px dotted #999999;" width="130px"><strong>Convenio</strong></td>
                                                                                <td style="border-bottom: 1px dotted #999999;" colspan="3">
                                                                                    {$arrConvenio.txtConvenio} de {$arrConvenio.txtBanco}
                                                                                </td>
                                                                            </tr>
                                                                        {/if}


                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;" width="130px"><strong>Matr&iacute;cula Inmobili&aacute;ria</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtMatriculaInmobiliaria|upper}&nbsp;</td>	
                                                                            <td style="border-bottom: 1px dotted #999999;" width="130px"><strong>Chip</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;" colspan="3">{$claDesembolso->txtChip|upper}&nbsp;</td>			
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Aval&uacute;o</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">$ {$claDesembolso->numAvaluo|number_format:0:'.':','}&nbsp;</td>
                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Valor de la venta</strong></td>
                                                                            <td style="border-bottom: 1px dotted #999999;">$ {$claDesembolso->numValorInmueble|number_format:0:'.':','}&nbsp;</td>
                                                                        </tr>
                                                                    </table>

                                                                    <table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
                                                                        <tr>
                                                                            <td bgcolor="#CECECE" align="center" colspan="3"><strong>DOCUMENTOS RADICADOS</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-bottom: 1px solid #999999;" align="center"><strong>DOCUMENTO</strong></td>
                                                                            <td style="border-bottom: 1px solid #999999;" align="center"><strong>FOLIOS</strong></td>
                                                                            <td style="border-bottom: 1px solid #999999;" align="center"><strong>OBSERVACIONES</strong></td>
                                                                        </tr>

                                                                        {if $claFormulario->seqModalidad != 5}

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Escritura p&uacute;blica de adquisici&oacute;n de la vivienda o Promesa de Compraventa</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numEscrituraPublica}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtEscrituraPublica}&nbsp;</td>
                                                                            </tr>

                                                                            {if $claFormulario->seqModalidad == 13}
                                                                                <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                    <td width="260px"><strong>Cotnrato de Leasing Habitacional</strong></td>
                                                                                    <td width="60px" align="center">{$arrContratoLeasing.numFoliosContratoLeasing}&nbsp;</td>
                                                                                    <td>{$arrContratoLeasing.txtFoliosContratoLeasing}&nbsp;</td>
                                                                                </tr>
                                                                            {/if}


                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificado de tradici&oacute;n y libertad vigente</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCertificadoTradicion}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCertificadoTradicion}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Fotocopia de la carta de asignacion del SDV</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCartaAsignacion}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCartaAsignacion}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificado de alto riesgo</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numAltoRiesgo}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtAltoRiesgo}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificado de habitabilidad</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numHabitabilidad}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtHabitabilidad}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Bolet&iacute;n catastral</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numBoletinCatastral}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtBoletinCatastral}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Licencia de contrucci&oacute;n del inmueble</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numLicenciaConstruccion}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtLicenciaConstruccion}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Recibo de pago del &uacute;ltimo impuesto predial</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numUltimoPredial}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtUltimoPredial}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>&Uacute;ltimo recibo de acueducto y alcantarillado</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numUltimoReciboAgua}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtUltimoReciboAgua}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>&Uacute;ltimo recibo de energ&iacute;a</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numUltimoReciboEnergia}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtUltimoReciboEnergia}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Acta de Entrega del Inmueble</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numActaEntrega}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtActaEntrega}&nbsp;</td>
                                                                            </tr>

                                                                            <tr  bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificación bancaria del vendedor</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCertificacionVendedor}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCertificacionVendedor}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Autorización de desembolso</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numAutorizacionDesembolso}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtAutorizacionDesembolso}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Fotocopia Cedula Vendedor</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numFotocopiaVendedor}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtFotocopiaVendedor}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>RUT (Persona Jurídica)</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numRut}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtRut}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>RIT (Persona Jurídica)</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numRit}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtRit}&nbsp;</td>
                                                                            </tr>
                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>NIT (Persona Jurídica)</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numNit}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtNit}&nbsp;</td>
                                                                            </tr>

                                                                        {else}

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Contrato de Arrendamiento</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numContratoArrendamiento}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtContratoArrendamiento}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificado de apertura CAP</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numAperturaCAP}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtAperturaCAP}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Cédula del Arrendador</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCedulaArrendador}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCedulaArrendador}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificación Cuenta Arrendador</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCuentaArrendador}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCuentaArrendador}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Tres Recibos de Servicios Públicos</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numServiciosPublicos}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtServiciosPublicos}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Autorización de Retiro de Recursos</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numRetiroRecursos}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtRetiroRecursos}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Certificado de tradici&oacute;n y libertad vigente</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numCertificadoTradicion}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtCertificadoTradicion}&nbsp;</td>
                                                                            </tr>

                                                                            <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                                <td width="260px"><strong>Bolet&iacute;n nomenclatura</strong></td>
                                                                                <td width="60px" align="center">{$claDesembolso->numBoletinCatastral}&nbsp;</td>
                                                                                <td>{$claDesembolso->txtBoletinCatastral}&nbsp;</td>
                                                                            </tr>

                                                                        {/if}

                                                                        <tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
                                                                            <td width="260px"><strong>Otros Documentos</strong></td>
                                                                            <td width="60px" align="center">{$claDesembolso->numOtros}&nbsp;</td>
                                                                            <td>{$claDesembolso->txtOtro}&nbsp;</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td bgcolor="#E4E4E4" align="center">TOTAL FOLIOS RADICADOS</td>
                                                                            <td bgcolor="#E4E4E4" align="center">{$numTotalFolios}&nbsp;</td>
                                                                            <td bgcolor="#E4E4E4" align="center">&nbsp;</td>
                                                                        </tr>

                                                                    </table>
                                                                    <table cellspacing="0" cellpadding="0" border="0" width="750px" style="{$txtFuente10}">
                                                                        <tr>
                                                                            <td bgcolor="#CECECE" align="center" width="25%"><strong>RADICADO POR</strong></td>
                                                                            <td bgcolor="#CECECE" align="center" width="25%"><strong>RECIBIDO POR</strong></td>
                                                                        </tr>
                                                                        <tr><td colspan="4">
                                                                                <table cellspacing="3" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
                                                                                    <tr>
                                                                                        <td width="50%" height="40px" style="border: 1px dotted #000000;">&nbsp;</td>
                                                                                        <td width="50%" height="40px" style="border: 1px dotted #000000;">&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td  width="50%" height="20px" style="border: 1px dotted #999999;">{$arrBeneficiario.nombre}<br> C.C.</td>
                                                                                        <td  width="50%" height="20px" style="border: 1px dotted #999999;" valign="top">
                                                                                            {$txtUsuarioSesion}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td></tr>
                                                                        <tr><td colspan="4" style="border-bottom: 2px dashed black;">&nbsp;</td></tr>
                                                                        <tr><td colspan="4">&nbsp;</td></tr>
                                                                    </table>
                                                                    <table cellspacing="0" cellpadding="0" border="0" width="750px" style="border: 1px solid #999999;">
                                                                        <tr>
                                                                            <td width="150px" height="80px" align="center" valign="middle">
                                                                                {if in_array( 31, $smarty.session.arrGrupos.3) || in_array( 32, $smarty.session.arrGrupos.3) || in_array( 33, $smarty.session.arrGrupos.3)}
                                                                                    <img src="../../recursos/imagenes/cvp.png">
                                                                                    {else}
                                                                                        <img src="../../recursos/imagenes/escudo.png">
                                                                                        {/if}

                                                                                        </td>
                                                                                        <td align="center" valign="middle" style="padding:10px; {$txtFuente12}">
                                                                                            <strong>Secretaría Distrital de Hábitat</strong><br>
                                                                                                <strong>Proceso de Desembolso. Recibo de Documentación</strong><br>
                                                                                                    <span style="{$txtFuente10}">Fecha de Radicaci&oacute;n: {$txtFecha}</span>
                                                                                                    </td>
                                                                                                    <td width="150px" align="center" valign="middle"><img src="../../recursos/imagenes/bta_positiva_carta.jpg"></td>
                                                                                                    </tr>
                                                                                                    </table>
                                                                                                    <table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
                                                                                                        <tr>
                                                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Nombre del Beneficiario</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.nombre}&nbsp;</td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Documento</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.tipoDocumento} {$arrBeneficiario.documento}&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="border-bottom: 1px dotted #999999;" width="140px"><strong>Nombre del Vendedor</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtNombreVendedor}&nbsp;</td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;" width="90px"><strong>Documento</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;" width="200px">{$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Direcci&oacute;n del inmueble</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;" colspan="3">{$claDesembolso->txtDireccionInmueble}&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Localidad</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;">{$arrLocalidad.$seqLocalidadDesembolso}&nbsp;</td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;"><strong>Barrio</strong></td>
                                                                                                            <td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtBarrio}&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    <table cellspacing="0" cellpadding="0" border="0" width="750px" style="{$txtFuente10}">
                                                                                                        <tr>
                                                                                                            <td bgcolor="#CECECE" align="center" width="25%"><strong>RADICADO POR</strong></td>
                                                                                                            <td bgcolor="#CECECE" align="center" width="25%"><strong>RECIBIDO POR</strong></td>
                                                                                                        </tr>
                                                                                                        <tr><td colspan="4">
                                                                                                                <table cellspacing="3" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
                                                                                                                    <tr>
                                                                                                                        <td  width="25%" height="40px" style="border: 1px dotted #000000;">&nbsp;</td>
                                                                                                                        <td  width="25%" height="40px" style="border: 1px dotted #000000;">&nbsp;</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td  width="25%" height="20px" style="border: 1px dotted #999999;">{$arrBeneficiario.nombre}<br> C.C.</td>
                                                                                                                        <td  width="25%" height="20px" style="border: 1px dotted #999999;" valign="top">
                                                                                                                            {$txtUsuarioSesion}
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </td></tr>
                                                                                                    </table>
                                                                                                    </body>
                                                                                                    </html>