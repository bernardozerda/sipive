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
		<meta name="title" content="Subsidios de Vivienda">
		<meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
		<meta name="description" content="Sistema de informacion de subsidios de vivienda">
		<meta http-equiv="Content-Language" content="es">
		<meta name="robots" content="index,  nofollow" />
		<title>SDV - SDHT</title>
	</head>
	<body onLoad="window.print();"> 
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
                  <b>Subsidio Distrital de Vivienda</b><br>
                  <b>Proceso de Desembolso. Recibo de Documentación</b><br>
                  <span style="{$txtFuente10}">
                     Fecha de Radicaci&oacute;n: {$txtFecha}<br>
                     No. Registro: {$numRegistro|number_format:0:'.':','}
                  </span>
               </td>
            {else}
               <td align="center" valign="middle" style="{$txtFuente12} padding:10px;">
                  <b>Subsidio Distrital de Vivienda</b><br>
                  <b>Esquema de Inscripci&oacute;n Casa en Mano.<br>Recibo de Documentación</b><br>
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
				<td style="border-bottom: 1px dotted #999999;"><b>Nombre del Beneficiario</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.nombre}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Documento</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.tipoDocumento} {$arrBeneficiario.documento}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Modalidad</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.modalidad}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Valor del Subsidio</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.valor}&nbsp;</td>
			</tr>
         {if $seqCasaMano == 0}
            <tr>
               <td style="border-bottom: 1px dotted #999999;"><b>Resoluci&oacute;n de Asignaci&oacute;n</b></td>
               <td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.resolucion}&nbsp;</td>
               <td style="border-bottom: 1px dotted #999999;">&nbsp;</td>
               <td style="border-bottom: 1px dotted #999999;">&nbsp;</td>
            </tr>
         {/if}   
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Direcci&oacute;n</b></td>
				<td style="border-bottom: 1px dotted #999999;" colspan="3">{$arrBeneficiario.direccion}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Localidad</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.localidad}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Barrio</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.barrio}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Tel&eacute;fonos</b></td>
				<td style="border-bottom: 1px dotted #999999;" colspan="3">
					{$arrBeneficiario.telefono1}&nbsp;&nbsp;&nbsp;
					{$arrBeneficiario.telefono2}&nbsp;&nbsp;&nbsp;
					{$arrBeneficiario.celular}&nbsp;
				</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
			<tr>
				<td bgcolor="#CECECE" align="center" colspan="4"><b>DATOS DEL INMUEBLE</b></td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;" width="140px"><b>Nombre del Vendedor</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtNombreVendedor|ucwords}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;" width="120px"><b>Documento</b></td>
				<td style="border-bottom: 1px dotted #999999;" width="200px">{$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Direcci&oacute;n del inmueble</b></td>
				<td style="border-bottom: 1px dotted #999999;" colspan="3">{$claDesembolso->txtDireccionInmueble|strtoupper}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Localidad</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrLocalidad.$seqLocalidadDesembolso}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Barrio</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtBarrio}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;" width="130px"><b>Título de Propiedad</b></td>
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
			<tr>
				<td style="border-bottom: 1px dotted #999999;" width="130px"><b>Matr&iacute;cula Inmobili&aacute;ria</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtMatriculaInmobiliaria|upper}&nbsp;</td>	
				<td style="border-bottom: 1px dotted #999999;" width="130px"><b>Chip</b></td>
				<td style="border-bottom: 1px dotted #999999;" colspan="3">{$claDesembolso->txtChip|upper}&nbsp;</td>			
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Aval&uacute;o</b></td>
				<td style="border-bottom: 1px dotted #999999;">$ {$claDesembolso->numAvaluo|number_format:0:'.':','}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Valor de la venta</b></td>
				<td style="border-bottom: 1px dotted #999999;">$ {$claDesembolso->numValorInmueble|number_format:0:'.':','}&nbsp;</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
			<tr>
				<td bgcolor="#CECECE" align="center" colspan="3"><b>DOCUMENTOS RADICADOS</b></td>
			</tr>
			<tr>
				<td style="border-bottom: 1px solid #999999;" align="center"><b>DOCUMENTO</b></td>
				<td style="border-bottom: 1px solid #999999;" align="center"><b>FOLIOS</b></td>
				<td style="border-bottom: 1px solid #999999;" align="center"><b>OBSERVACIONES</b></td>
			</tr>
			
			{if $claFormulario->seqModalidad != 5}
			
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Escritura p&uacute;blica de adquisici&oacute;n de la vivienda o Promesa de Compraventa</b></td>
					<td width="60px" align="center">{$claDesembolso->numEscrituraPublica}&nbsp;</td>
					<td>{$claDesembolso->txtEscrituraPublica}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificado de tradici&oacute;n y libertad vigente</b></td>
					<td width="60px" align="center">{$claDesembolso->numCertificadoTradicion}&nbsp;</td>
					<td>{$claDesembolso->txtCertificadoTradicion}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Fotocopia de la carta de asignacion del SDV</b></td>
					<td width="60px" align="center">{$claDesembolso->numCartaAsignacion}&nbsp;</td>
					<td>{$claDesembolso->txtCartaAsignacion}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificado de alto riesgo</b></td>
					<td width="60px" align="center">{$claDesembolso->numAltoRiesgo}&nbsp;</td>
					<td>{$claDesembolso->txtAltoRiesgo}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificado de habitabilidad</b></td>
					<td width="60px" align="center">{$claDesembolso->numHabitabilidad}&nbsp;</td>
					<td>{$claDesembolso->txtHabitabilidad}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Bolet&iacute;n catastral</b></td>
					<td width="60px" align="center">{$claDesembolso->numBoletinCatastral}&nbsp;</td>
					<td>{$claDesembolso->txtBoletinCatastral}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Licencia de contrucci&oacute;n del inmueble</b></td>
					<td width="60px" align="center">{$claDesembolso->numLicenciaConstruccion}&nbsp;</td>
					<td>{$claDesembolso->txtLicenciaConstruccion}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Recibo de pago del &uacute;ltimo impuesto predial</b></td>
					<td width="60px" align="center">{$claDesembolso->numUltimoPredial}&nbsp;</td>
					<td>{$claDesembolso->txtUltimoPredial}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>&Uacute;ltimo recibo de acueducto y alcantarillado</b></td>
					<td width="60px" align="center">{$claDesembolso->numUltimoReciboAgua}&nbsp;</td>
					<td>{$claDesembolso->txtUltimoReciboAgua}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>&Uacute;ltimo recibo de energ&iacute;a</b></td>
					<td width="60px" align="center">{$claDesembolso->numUltimoReciboEnergia}&nbsp;</td>
					<td>{$claDesembolso->txtUltimoReciboEnergia}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Acta de Entrega del Inmueble</b></td>
					<td width="60px" align="center">{$claDesembolso->numActaEntrega}&nbsp;</td>
					<td>{$claDesembolso->txtActaEntrega}&nbsp;</td>
				</tr>
				
				<tr  bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificación bancaria del vendedor</b></td>
					<td width="60px" align="center">{$claDesembolso->numCertificacionVendedor}&nbsp;</td>
					<td>{$claDesembolso->txtCertificacionVendedor}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Autorización de desembolso</b></td>
					<td width="60px" align="center">{$claDesembolso->numAutorizacionDesembolso}&nbsp;</td>
					<td>{$claDesembolso->txtAutorizacionDesembolso}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Fotocopia Cedula Vendedor</b></td>
					<td width="60px" align="center">{$claDesembolso->numFotocopiaVendedor}&nbsp;</td>
					<td>{$claDesembolso->txtFotocopiaVendedor}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>RUT (Persona Jurídica)</b></td>
					<td width="60px" align="center">{$claDesembolso->numRut}&nbsp;</td>
					<td>{$claDesembolso->txtRut}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>RIT (Persona Jurídica)</b></td>
					<td width="60px" align="center">{$claDesembolso->numRit}&nbsp;</td>
					<td>{$claDesembolso->txtRit}&nbsp;</td>
				</tr>
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>NIT (Persona Jurídica)</b></td>
					<td width="60px" align="center">{$claDesembolso->numNit}&nbsp;</td>
					<td>{$claDesembolso->txtNit}&nbsp;</td>
				</tr>

			{else}
			
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Contrato de Arrendamiento</b></td>
					<td width="60px" align="center">{$claDesembolso->numContratoArrendamiento}&nbsp;</td>
					<td>{$claDesembolso->txtContratoArrendamiento}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificado de apertura CAP</b></td>
					<td width="60px" align="center">{$claDesembolso->numAperturaCAP}&nbsp;</td>
					<td>{$claDesembolso->txtAperturaCAP}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Cédula del Arrendador</b></td>
					<td width="60px" align="center">{$claDesembolso->numCedulaArrendador}&nbsp;</td>
					<td>{$claDesembolso->txtCedulaArrendador}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificación Cuenta Arrendador</b></td>
					<td width="60px" align="center">{$claDesembolso->numCuentaArrendador}&nbsp;</td>
					<td>{$claDesembolso->txtCuentaArrendador}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Tres Recibos de Servicios Públicos</b></td>
					<td width="60px" align="center">{$claDesembolso->numServiciosPublicos}&nbsp;</td>
					<td>{$claDesembolso->txtServiciosPublicos}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Autorización de Retiro de Recursos</b></td>
					<td width="60px" align="center">{$claDesembolso->numRetiroRecursos}&nbsp;</td>
					<td>{$claDesembolso->txtRetiroRecursos}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Certificado de tradici&oacute;n y libertad vigente</b></td>
					<td width="60px" align="center">{$claDesembolso->numCertificadoTradicion}&nbsp;</td>
					<td>{$claDesembolso->txtCertificadoTradicion}&nbsp;</td>
				</tr>
				
				<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
					<td width="260px"><b>Bolet&iacute;n nomenclatura</b></td>
					<td width="60px" align="center">{$claDesembolso->numBoletinCatastral}&nbsp;</td>
					<td>{$claDesembolso->txtBoletinCatastral}&nbsp;</td>
				</tr>
				
			{/if}
			
			<tr bgcolor="{cycle name=c1 values="#EAEAEA,#FFFFFF"}">
				<td width="260px"><b>Otros Documentos</b></td>
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
				<td bgcolor="#CECECE" align="center" width="25%"><b>RADICADO POR</b></td>
				<td bgcolor="#CECECE" align="center" width="25%"><b>RECIBIDO POR</b></td>
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
					<b>Subsidio Distrital de Vivienda</b><br>
					<b>Proceso de Desembolso. Recibo de Documentación</b><br>
					<span style="{$txtFuente10}">Fecha de Radicaci&oacute;n: {$txtFecha}</span>
				</td>
				<td width="150px" align="center" valign="middle"><img src="../../recursos/imagenes/bta_positiva_carta.jpg"></td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="750px" style="{$txtFuente10}">
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Nombre del Beneficiario</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.nombre}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Documento</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrBeneficiario.tipoDocumento} {$arrBeneficiario.documento}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;" width="140px"><b>Nombre del Vendedor</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtNombreVendedor}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;" width="90px"><b>Documento</b></td>
				<td style="border-bottom: 1px dotted #999999;" width="200px">{$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Direcci&oacute;n del inmueble</b></td>
				<td style="border-bottom: 1px dotted #999999;" colspan="3">{$claDesembolso->txtDireccionInmueble}&nbsp;</td>
			</tr>
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>Localidad</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$arrLocalidad.$seqLocalidadDesembolso}&nbsp;</td>
				<td style="border-bottom: 1px dotted #999999;"><b>Barrio</b></td>
				<td style="border-bottom: 1px dotted #999999;">{$claDesembolso->txtBarrio}&nbsp;</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" border="0" width="750px" style="{$txtFuente10}">
			<tr>
				<td bgcolor="#CECECE" align="center" width="25%"><b>RADICADO POR</b></td>
				<td bgcolor="#CECECE" align="center" width="25%"><b>RECIBIDO POR</b></td>
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