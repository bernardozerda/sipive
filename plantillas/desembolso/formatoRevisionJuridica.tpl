{assign var=tipoDocCiudadano 	value=$claCiudadano->seqTipoDocumento}
{assign var=tipoDocVendedor 	value=$claDesembolso->seqTipoDocumento}
{assign var=txtCompraVivienda 	value=$claDesembolso->txtCompraVivienda}
{assign var=txtPropiedad 		value=$claDesembolso->txtPropiedad}

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
		
		<!-- TITULO DE LA CARTA DE IMPRESION -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
			<tr>
				<td width="150px" height="80px" align="center" valign="middle">
               {if in_array( 31, $smarty.session.arrGrupos.3) || in_array( 32, $smarty.session.arrGrupos.3) || in_array( 33, $smarty.session.arrGrupos.3)}
                  <img src="../../recursos/imagenes/cvp.png">
               {else}
                  <img src="../../recursos/imagenes/escudo.png">
               {/if}
            </td>
				<td align="center" valign="middle" style="padding:20px; {$txtFuente12}">
					<b>Subsidio Distrital de Vivienda</b><br>
					<b>Revisión de oferta para adquisición de vivienda</b><br>
					<span style="{$txtFuente10}">
						Fecha de Radicaci&oacute;n: {$txtFecha}<br>
						No. Registro: {$numRegistro|number_format:0:'.':','}
					</span>
				</td>
				<td width="150px" align="center" valign="middle">
					<img src="../../recursos/imagenes/bta_positiva_carta.jpg">
				</td>
			</tr>
		</table>
		
		<!-- IDENTIFICACION DE LAS PARTES -->
		<table cellspacing="0" cellpadding="4" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="3" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Identificación de las partes</b></td></tr>
			<tr>
				<td><b>Promitente Comprador</b></td>
				<td>{$claCiudadano->txtNombre1} {$claCiudadano->txtNombre2} {$claCiudadano->txtApellido1} {$claCiudadano->txtApellido2}</td>
				<td>{$arrTipoDocumento.$tipoDocCiudadano} <!--{$claCiudadano->numDocumento|number_format:0:'.':','}-->{$claCiudadano->numDocumento}</td>
			</tr>
			<tr>
				<td><b>Promitente Vendedor</b></td>
				<td>{$claDesembolso->txtNombreVendedor}</td>
				<td>{$arrTipoDocumento.$tipoDocVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}</td>
			</tr>
			<tr>
				<td colspan="2"><b>Resolución de Asignación del Subsidio Distrital De Vivienda</b></td>
				<td>{$claDesembolso->arrJuridico.numResolucion} del {$claDesembolso->arrJuridico.fchResolucion}</td>
			</tr>
		</table>
		
		<!-- IDENTIFICACION DEL INMUEBLE -->
		<table cellspacing="0" cellpadding="3" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Identificación del Inmueble</b></td></tr>
			<tr>
				<td><b>Dirección</b></td>
				<td colspan="5">{$claDesembolso->txtDireccionInmueble}</td>
			</tr>
			<tr>
				<td><b>Folio de Matrícula</b></td>
				<td>{$claDesembolso->txtMatriculaInmobiliaria}</td>
				<td><b>Cédula Catastral</b></td>
				<td>{$claDesembolso->txtCedulaCatastral}</td>
				<td><b>CHIP</b></td>
				<td>{$claDesembolso->txtChip}</td>
			</tr>
			<tr>
				<td><b>Área del Lote (m<sup>2</sup>)</b></td>
				<td>{$claDesembolso->numAreaLote|number_format:0:'.':','}</td>
				<td><b>Área Construida (m<sup>2</sup>)</b></td>
				<td>{$claDesembolso->numAreaConstruida|number_format:0:'.':','}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		
		<!-- ANOTACION -->
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="{$txtFuente10}">
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px;border-top: 1px dotted #999999;">
				{if $txtPropiedad neq ""}
					La descripción de cabida y linderos reposan en la 
					{if $txtPropiedad eq "escritura"}
						escritura pública {$claDesembolso->txtEscritura} del {$claDesembolso->fchEscritura}, elevada ante la Notaria {$claDesembolso->numNotaria} del Circulo de  {$claDesembolso->txtCiudad}.
					{elseif $txtPropiedad eq "sentencia"}
						sentencia de fecha {$claDesembolso->fchSentencia} proferida por el juzgado civil # {$claDesembolso->numJuzgado} del circuito de {$claDesembolso->txtCiudadSentencia}
					{elseif $txtPropiedad eq "resolucion"}
						resolución # {$claDesembolso->numResolucion} de fecha {$claDesembolso->fchResolucion} emitida por {$claDesembolso->txtEntidad} de la ciudad {$claDesembolso->txtCiudadResolucion}
					{/if}
				{/if}
				
				
			</td></tr>
		</table>
		
		<!-- OBSERVACIONES -->
		<table cellspacing="0" cellpadding="4" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Observaciones</b></td></tr>
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px;">
				{$claDesembolso->arrJuridico.txtObservaciones}
			</td></tr>
		</table>
		
		<!-- LIBERTAD -->
		<table cellspacing="0" cellpadding="4" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Libertad</b></td></tr>
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px;">
				{$claDesembolso->arrJuridico.txtLibertad}
			</td></tr>
		</table>
		
		<!-- DOCUMENTOS ANALIZADOS -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Documentos Analizados</b></td></tr>
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;">
				<ol>
					{foreach from=$claDesembolso->arrJuridico.documento item=txtDocumento}
						<li>{$txtDocumento}</li>
					{/foreach}
				</ol>
			</td></tr>
		</table>
		
		<!-- RECOMENDACIONES -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Recomendaciones</b></td></tr>
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;">
				<ol>
					{foreach name=recomendaciones from=$claDesembolso->arrJuridico.recomendacion item=txtRecomendacion}
						<li>{$txtRecomendacion}</li>
					{/foreach}
					
					{if $claFormulario->seqModalidad == 1 || $claFormulario->seqModalidad == 6 || $claFormulario->seqModalidad == 11}
                  <li>EL PRECIO DE COMPRA NO DEBE SUPERAR LOS 70 SMMLV.</li>
                  <li>SI HAY VIABILIDAD TÉCNICA, PARA LA POSULACI&Oacute;N, SE FIRMAR&Aacute; LA PROMESA DE COMPRA VENTA QUE ENTREGAR&Aacute; EL TUTOR ASIGNADO.</li>
                  <li>EN LA ESCRITURA PÚBLICA DEBERÁ IR PROTOCOLIZADA LA CARTA DE ASIGNACIÓN DEL SUBSIDIO DISTRITAL DE VIVIENDA.</li>
                  <li>ANTES DE LA FIRMA DE LA ESCRITURA PÚBLICA EL HOGAR BENEFICIARIO DEBERÁ ALLEGAR EL BORRADOR DE LA MINUTA PARA SU REVISIÓN Y APROBACIÓN.</li>
                  <li>AL MOMENTO DE FIRMAR ESCRITURA PÚBLICA EL VENDEDOR DEBERÁ ESTAR A PAZ Y SALVO CON EL IMPUESTO PREDIAL DE LOS ÚLTIMOS CINCO AÑOS, CUANDO APLIQUE.</li>
                  <li>AL MOMENTO DE FIRMAR ESCRITURAS PÚBLICAS EL VENDEDOR DEBERÁ ESTAR A PAZ Y SALVO CON LOS SERVICIOS PÚBLICOS BÁSICOS Y NO DEBERÁ TENER CRÉDITOS A SU CARGO EN CODENSA Y ACUEDUCTO, CUANDO APLIQUE.</li>
                  <li>VERIFICAR QUE LOS NOMBRES, CEDULAS Y TIPO DE VIVIENDA DEL HOGAR BENEFICIARIO DEL SDV ESTÉN ESCRITOS EN FORMA CORRECTA.</li>
                  <li>ACTUALIZAR EL NOMBRE DEL TITULAR EN LOS RECIBOS DE AGUA Y LUZ, CUANDO APLIQUE.</li>
					{/if}
				</ol>
			</td></tr>
		</table>
		
		<!-- COMENTARIOS -->
		<table cellspacing="0" cellpadding="4" border="0" width="100%" style="{$txtFuente10}">
			<tr><td colspan="7" style="padding:5px; {$txtFuente12}" bgcolor="#E4E4E4"><b>Concepto</b></td></tr>
			<tr><td align="justify" style="padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px;">
				{$claDesembolso->arrJuridico.txtConcepto}
			</td></tr>
		</table>
		
		<!-- FIRMA DE LA CARTA -->
		<table cellspacing="0" cellpadding="4" border="0" width="100%" style="border-top: 1px solid #999999; {$txtFuente12}">
			<tr><td style="padding:5px; {$txtFuente12}">Cordialmente</td></tr>
			<tr><td height="50px">&nbsp;</td></tr>
			<tr><td style="padding-left:20px;">
				<b>{$claDesembolso->arrJuridico.txtAprobo}</b><br>
                {if in_array( 31, $smarty.session.arrGrupos.3) || in_array( 32, $smarty.session.arrGrupos.3) || in_array( 33, $smarty.session.arrGrupos.3)}
                    <span style="{$txtFuente10}">Caja de Vivienda Popular<br><br>
                {else}
                    <span style="{$txtFuente10}">Subdirección de Recursos Públicos<br><br>
                {/if}            
				Preparó: {$txtUsuarioSesion}</span>
			</td></tr>
			<tr>
				<td style="padding-left:20px;"><br /><span style="{$txtFuente10}">El estudio jurídico responde por la regularidad formal de los documentos examinados, mas no por la veracidad de su contenido.</span>
			</td></tr>
		</table>
	</body>
</html>

