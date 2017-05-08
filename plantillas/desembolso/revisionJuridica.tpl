
	<!--
		PLANTILLA PARA LA ETAPA DE REVSION DE OFERTA Y ESCRITURACION 
		@author Bernardo Zerda
		@version 1.0 Dic 2009
	-->
	
	<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->	
	{assign var=seqModalidad 				value=$claFormulario->seqModalidad}
	{assign var=seqSolucion 				value=$claFormulario->seqSolucion}		
	{assign var=seqLocalidad 				value=$claFormulario->seqLocalidad}
	{assign var=seqBancoAhorro 				value=$claFormulario->seqBancoCuentaAhorro}
	{assign var=seqBancoAhorro2 			value=$claFormulario->seqBancoCuentaAhorro2}
	{assign var=seqBancoCredito 			value=$claFormulario->seqBancoCredito}
	{assign var=seqEstadoProceso 			value=$claFormulario->seqEstadoProceso}
	{assign var=seqBancoCuentaAhorro  		value=$claFormulario->seqBancoCuentaAhorro}
	{assign var=seqBancoCuentaAhorro2 		value=$claFormulario->seqBancoCuentaAhorro2}
	{assign var=seqBancoCredito 			value=$claFormulario->seqBancoCredito}
	{assign var=seqEntidadDonante 			value=$claFormulario->seqEmpresaDonante}
	{assign var=txtCompraVivienda 			value=$claDesembolso->txtCompraVivienda}
	{assign var=seqTipoDocumento 			value=$claPostulantePrincipal->seqTipoDocumento}
	{assign var=seqTipoDocumentoVendedor 	value=$claDesembolso->seqTipoDocumento}

	<!-- 
		TREE VIEW QUE CONTIENE LA INFORMACION DE LA FASE 
	-->	
	{assign var=numAltura value=500}
	<div id="demo" class="yui-navset" style="width:98%; height:{$numAltura}; text-align:left;">
	    <ul class="yui-nav">
	    	<li class="selected"><a href="#dh"><em>Datos del Hogar</em></a></li>
	        <li><a href="#cj"><em>Concepto Jur&iacute;dico</em></a></li>
	        <li><a href="#se"><em>Seguimiento</em></a></li>
	        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
	    </ul>            
	    <div class="yui-content">
	    
			<!-- PESTANA DE DATOS DEL HOGAR -->
			<div id="dh" style="height:{$numAltura}">
				{include file="desembolso/pestanaDatosHogar.tpl"}				
			</div>
			
			<!-- CONCEPTO JURIDICO -->			
			<div id="cj" style="height:{$numAltura}; overflow:auto;"><p>
				
				<!-- QUIEN PREPARA Y QUIEN APRUEBA EL DOCUMENTO -->
				<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
					<tr>
						<td width="100px" class="tituloTabla">Preparado Por</td>
						<td>{$txtUsuarioSesion}</td>
					</tr>
					<tr>
						<td class="tituloTabla" valign="top">Aprobado Por</td>
						<td height="22px" valign="top">
							<div id="buscarUsuario">
								<input	id="aprobo" 
										name="aprobo"
										type="text" 
										style="width:250px" 
										onFocus="this.style.backgroundColor = '#ADD8E6'; " 
										onBlur="this.style.backgroundColor = '#FFFFFF';" 
										value="{$claDesembolso->arrJuridico.txtAprobo}"
								/>
								<div id="contUsuario" style="width:250px"></div>
							</div>	
						</td>
					</tr>
				</table>
				
				<!-- IDENTIFICACION DE LAS PARTES INVOLUCRADAS -->
				<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#FFFFFF">
					<tr><td colspan="3" class="tituloTabla">Identificaci&oacute;n de las partes</td></tr>
					<tr>
						<td width="165px"><b>Promitente comprador</b></td>
						<td>
							{$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} 
							{$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
						</td>
						<td>
							<b>Documento:</b> {$arrTipoDocumento.$seqTipoDocumento} {$objCiudadano->numDocumento}
						</td>
					</tr>
					<tr>
						<td><b>Promitente vendedor</b></td>
						<td>{$claDesembolso->txtNombreVendedor}</td>
						<td><b>Documento:</b> {$arrTipoDocumento.$seqTipoDocumentoVendedor} {$claDesembolso->numDocumentoVendedor|number_format:0:'.':','}</td>
					</tr>
					
					
					<!-- DEFINE LA RESOLUCION DE ASIGNACION -->
					{assign var=numResolucion value=0}
					{assign var=fchResolucion value=""}
					{if $claDesembolso->arrJuridico.numResolucion == "" || $claDesembolso->arrJuridico.numResolucion == 0}
						{assign var=numResolucion value=$arrResolucionAsignacion.numero}
					{else}
						{assign var=numResolucion value=$claDesembolso->arrJuridico.numResolucion}
					{/if}
					{if $claDesembolso->arrJuridico.fchResolucion == ""}
						{assign var=fchResolucion value=$arrResolucionAsignacion.fecha}
					{else}
						{assign var=fchResolucion value=$claDesembolso->arrJuridico.fchResolucion}
					{/if}
					
					<!-- RESOLUCION DE ASIGNACION -->
                    {if $arrFlujoHogar.flujo != "cem"} <!-- PARA CASA EN MANO NO SE MUESTRA -->
                        <tr>
                            <td colspan="2"><b>Resolucion de asignacion del subsidio distrital de vivienda</b></td>
                            <td>
                                No. <input type="text" 
                                       name="numResolucion" 
                                       id="numResolucion" 
                                       value="{$numResolucion}"
                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                       onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );" 
                                       style="width:50px"
                                       maxlength="5"								  
                                /> del <input type="text" 
                                       name="resolucion" 
                                       id="resolucion" 
                                       value="{$fchResolucion}"
                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                       onBlur="this.style.backgroundColor = '#FFFFFF'; esFechaValida( this );" 
                                       style="width:80px"
                                       maxlength="10"								  
                                /> yyyy-mm-dd

                            </td>
                        </tr>
                    {/if}
				</table>
				<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#FFFFFF">
					<tr><td colspan="4" class="tituloTabla">Identificaci&oacute;n del Inmueble</td></tr>
					
					<!-- DIRECCION Y FOLIO DE MATRICULA-->
					<tr>
						<td width="20%"><b>Direcc&oacute;n:</b> </td>
						<td width="30%">{$claDesembolso->txtDireccionInmueble}</td>
						<td width="20%"><b>Folio de Matricula:</b></td>
						<td>{$claDesembolso->txtMatriculaInmobiliaria}</td>
					</tr>
					
					<!-- RESOLUCION DE ASIGNACION Y CEDULA CATASTRAL -->
					<tr>
						<td><b>CHIP:</b></td>
						<td>{$claDesembolso->txtChip}</td>
						<td><b>Cedula Catastral:</b></td>
						<td>{$claDesembolso->txtCedulaCatastral}</td>
					</tr>
					
					<!-- AREA LOTE Y AREA CONSTRUIDA -->
					<tr>
						<td><b>Area lote (m<sup>2</sup>):</b></td>
						<td>{$claDesembolso->numAreaLote|number_format:0:'.':','}</td>
						<td><b>Area construida (m<sup>2</sup>):</b></td>
						<td>{$claDesembolso->numAreaConstruida|number_format:0:'.':','}</td>
					</tr>
					
					<!-- DESCRIPCION DE CABIDA Y LINDEROS -->
					<tr>
						<th colspan="4" style="padding:5px; padding-left:5px; padding-right:20px;" align="left">
							La descripci&oacute;n de cabida y linderos reposan en la escritura p&uacute;blica 
							{$claDesembolso->txtEscritura} del {$claDesembolso->fchEscritura}, elevada ante la notaria 
							{$claDesembolso->numNotaria} del circulo de {$claDesembolso->txtCiudad}
						</th>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="2" border="0" width="100%">
				
					<!-- OBSERVACIONES Y LIBERTAD -->
					<tr>
						<td class="tituloTabla">Observaciones</td>
						<td class="tituloTabla">Libertad</td>
					</tr>
					<tr>
						<td align="center" width="50%">	
							<textarea name="observaciones" 
									  style="width:96%"
									  onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   	  onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
							>{$claDesembolso->arrJuridico.txtObservaciones}</textarea>
						</td>
						<td align="center">
							<textarea name="libertad" 
									  style="width:96%"
									  onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   	  onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
							>{$claDesembolso->arrJuridico.txtLibertad}</textarea>
						</td>
					</tr>

					<!-- DOCUMENTOS ANALIZADOS -->
					<tr><td colspan="3" class="tituloTabla">Documentos Analizados</td></tr>
					<tr>
						<td valign="top" style="padding-left:10px;">
							<input type="text"
								   id="documento"
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
								   style="width:300px;"
								   class="inputLogin"
							/> 
							
							<button type="button" 
									id="adicionar" 
									title="adicionar" 
									class="reporteador"
									onClick="adicionarDocumentoAnalizado( document.getElementById('documento') , 'documentosAnalizados' , 'documento' , 95 , 50 );"
							>
								<img src="./recursos/imagenes/plus_icon.gif" alt="Adicionar" align="center" >
							</button>
						</td>
						<td id="documentosAnalizados" bgcolor="#FFFFFF">
							{foreach name=documento from=$claDesembolso->arrJuridico.documento item=txtDocumento}
								{math equation="x + y" x=$smarty.foreach.documento.index y=1 assign=numSecuencia}							
								<div id="documento{$numSecuencia}">							
									<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
										 onMouseOver="this.style.backgroundColor='#FFA4A4';"
										 onMouseOut="this.style.backgroundColor='#F9F9F9'"
										 onClick="eliminarObjeto('documento{$numSecuencia}')"
									>X</div>
									<div style="cursor:pointer; float:right; width:95%; height:14px; border:1px solid #F9F9F9;"
									onMouseOver="mostrarHint( '{$txtDocumento}')" onMouseOut="ocultarHint();">
										{if $txtDocumento|strlen > 40}
											{$numSecuencia} - {$txtDocumento|substr:0:40}...
										{else}
											{$numSecuencia} - {$txtDocumento}
										{/if}
									</div>
									<input type="hidden" name="documento[]" value="{$txtDocumento}">
								</div>								
							{/foreach}
						</td>
					</tr>
					
					<!-- RECOMENDACIONES -->
                    <tr><td colspan="3" class="tituloTabla">Recomendaciones y Comentarios</td></tr>
                    <tr><td valign="top" style="padding-left:10px;">
                        <input type="text" 
                               id="recomendacion"
                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                               onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
                               style="width:300px;"
                               class="inputLogin"
                        /> 
                        <button type="button" 
                                id="adicionar" 
                                title="adicionar" 
                                class="reporteador"
                                onClick="adicionarDocumentoAnalizado( document.getElementById('recomendacion') , 'recomendaciones' , 'recomendacion' , 95 , 50 );"
                        >
                            <img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
                        </button>
                    </td>
                    <td id="recomendaciones">
						<ol>
                            <li>EL PRECIO DE COMPRA NO DEBERÁ SUPERAR LOS 70 SMMLV.</li>
                            <li>SI HAY VIABILIDAD TÉCNICA, PARA LA POSULACI&Oacute;N, SE FIRMAR&Aacute; LA PROMESA DE COMPRA VENTA QUE ENTREGAR&Aacute; EL TUTOR ASIGNADO.</li>
                            <li>EN LA ESCRITURA PÚBLICA DEBERÁ IR PROTOCOLIZADA LA CARTA DE ASIGNACIÓN DEL SUBSIDIO DISTRITAL DE VIVIENDA.</li>
                            <li>ANTES DE LA FIRMA DE LA ESCRITURA PÚBLICA EL HOGAR BENEFICIARIO DEBERÁ ALLEGAR EL BORRADOR DE LA MINUTA PARA SU REVISIÓN Y APROBACIÓN.</li>
                            <li>AL MOMENTO DE FIRMAR ESCRITURA PÚBLICA EL VENDEDOR DEBERÁ ESTAR A PAZ Y SALVO CON EL IMPUESTO PREDIAL DE LOS ÚLTIMOS CINCO AÑOS, CUANDO APLIQUE.</li>
                            <li>AL MOMENTO DE FIRMAR ESCRITURAS PÚBLICAS EL VENDEDOR DEBERÁ ESTAR A PAZ Y SALVO CON LOS SERVICIOS PÚBLICOS BÁSICOS Y NO DEBERÁ TENER CRÉDITOS A SU CARGO EN CODENSA Y ACUEDUCTO, CUANDO APLIQUE.</li>
                            <li>VERIFICAR QUE LOS NOMBRES, CEDULAS Y TIPO DE VIVIENDA DEL HOGAR BENEFICIARIO DEL SDV ESTÉN ESCRITOS EN FORMA CORRECTA.</li>
                            <li>ACTUALIZAR EL NOMBRE DEL TITULAR EN LOS RECIBOS DE AGUA Y LUZ, CUANDO APLIQUE.</li>
                        </ol>
                        {foreach name=recomendacion from=$claDesembolso->arrJuridico.recomendacion item=txtRecomendacion}
                                {math equation="x + y" x=$smarty.foreach.recomendacion.index y=1 assign=numSecuencia}							
                                <div id="recomendacion{$numSecuencia}">							
                                    <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                         onMouseOver="this.style.backgroundColor='#FFA4A4';"
                                         onMouseOut="this.style.backgroundColor='#F9F9F9'"
                                         onClick="eliminarObjeto('recomendacion{$numSecuencia}')"
                                    >X</div>
                                    <div style="cursor:pointer; float:right; width:95%; height:14px; border:1px solid #F9F9F9;"
                                    onMouseOver="mostrarHint( '{$txtRecomendacion}')" onMouseOut="ocultarHint();">
                                        {if $txtRecomendacion|strlen > 40}
                                            {$numSecuencia} - {$txtRecomendacion|substr:0:40}...
                                        {else}
                                            {$numSecuencia} - {$txtRecomendacion}
                                        {/if}
                                    </div>
                                    <input type="hidden" name="recomendacion[]" value="{$txtRecomendacion}">
                                </div>								
                            {/foreach}
                    </td></tr>
				</table>
				
				<!-- CONCEPTO -->
				<table cellspacing="0" cellpadding="2" border="0" width="100%">
					<tr><td class="tituloTabla" colspan="2">Concepto</td></tr>
					<tr>
						<td align="center" colspan="2">	
							<textarea name="concepto"
									  style="width:96%; height:60px;"
									  onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   	  onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
							>{$claDesembolso->arrJuridico.txtConcepto}</textarea>
						</td>
					</tr>
				</table>
				
			</p></div>
<!-- PESTANA DE SEGUIMIENTO -->			
			<div id="se" style="height:{$numAltura}; overflow:auto;"><p>
				{include file="seguimiento/seguimientoFormulario.tpl"}
	        	<p><div id="contenidoBusqueda">
	        		{include file="seguimiento/buscarSeguimiento.tpl"}
	        	</div></p>
	        	<!--  <input type="hidden" id="seqFormularioEditar" value="{$seqFormulario}"> -->
	        	<input type="hidden" id="seqFormulario" value="{$seqFormulario}">
			</p></div>
			
<!-- PESTANA ACTOS ADMINISTRATIVOS -->	        
	        <div id="aad" style="height:{$numAltura};"><p>
	        	{include file="subsidios/actosAdministrativos.tpl"}
	        </p></div>
			
		</div>		
	</div>	

<!-- NO BORRAR, ESTE DIV ACTIVA EL TABVIEW -->
		<div id="seguimiento"></div>
		<div id="listenerBuscarUsuario" style="visibility: hidden;">juridica</div>