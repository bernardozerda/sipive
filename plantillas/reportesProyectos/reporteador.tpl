<form id="reporteador">
	<table cellpadding="0" cellspacing="0" border="0" width="98%">
		<tr>
		
<!-- CRITERIOS DE LISTADO: LISTADO, CONTEO Y SUMA -->
			<td width="250px" align="center" valign="top"><!-- style="border: 1px dotted #999999;"> -->
				<div id="tabTipoReportes" class="yui-navset" style="width:100%; text-align:left;">
									
					<ul class="yui-nav">
			        	<li class="selected"><a href="#tabReporteTipos"><em>Tipo Reporte</em></a></li>
				    </ul>
				    <div class="yui-content">
					    <div id="tabReporteTipos">
							<table cellpadding="3" cellspacing="0" border="0" width="100%">
								<tr><td align='right' ><a href="#" onClick="verAyudaReporteador( 1 )"><span class="tituloAyuda">Ayuda</span></a></td></tr>
								<tr><td><input type="radio" id="rListado" name="criterio" value="" checked> Listar Registros</td></tr>
								<tr><td><input type="radio" id="rConteo"  name="criterio" value="count(*)"> Conteo de Registros</td></tr>
								<!-- <tr><td><input type="radio" id="rConteo"  name="criterio" value="sum(*)"> Suma de Registros</td></tr> -->
								<tr><td><input type="checkbox" id="rPPal" checked name="criterioPPal" value="1" style="display:none"></td></tr>
								<tr><td><input type="file" name="fileSecuenciales" id="fileSecuenciales"/></td></tr>
							</table>
						</div>
					</div>
				</div>
			</td>
			<td rowspan="3" align="center" valign="top">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					
<!-- TABLA DE CONDICIONES WHERE DE LA CONSULTA -->
					<tr><td>
					
					<div id="tabCondiciones" class="yui-navset" style="width:100%; text-align:left;">
					
						<ul class="yui-nav">
				        	<li class="selected"><a href="#tabCondicionesReportes"><em>Condiciones</em></a></li>
					    </ul>
					    <div class="yui-content">
					    	<div id="tabCondicionesReportes">
					
						<table cellpadding="3" cellspacing="0" border="0" width="100%">
							<tr>
								<tr><td align='right' colspan="3" ><a href="#" onClick="verAyudaReporteador( 3 )"><span class="tituloAyuda">Ayuda</span></a></td></tr>
								<td align="center" width="240px">
									
									<select	id="wCampo" 
										style="width:250px"
										onFocus="this.style.backgroundColor = '#ADD8E6';" 
										onBlur="this.style.backgroundColor = '#FFFFFF';"
										onChange="cambioWSelectProyectos( this.options[ this.selectedIndex ].value )"
									>
										<option value="">Seleccione Campo</option>
										{foreach from=$arrCamposGrupos key=idCampoGrupo item=arrCampos}
											<optgroup label="{$idCampoGrupo}">
											{foreach from=$arrCampos key=idCampo item=txtCampo}
												<option value="{$idCampo}">{$txtCampo}</option>
											{/foreach}
											</optgroup>
										{/foreach}	
									</select>
								</td>
								<td align="center" id="tdWCriterio">
									<select id="wCriterio" 
											style="width:98%;"
											onFocus="this.style.backgroundColor = '#ADD8E6';" 
											onBlur="this.style.backgroundColor = '#FFFFFF';"
									>
										<option value="">Criterio</select>
									</select> 
								</td>
								<td width="70px">
									<input type="radio" id="wY" name="wCondicion" value="AND" checked> Y
									<input type="radio" id="wO" name="wCondicion" value="OR"> O  
								</td>
							</tr>
							<tr>
								<td colspan="2" id="tdWValor" style="padding-left:7px">
									<input type="text" 
										   id="wValor" 
										   value="Inserte Valor"
										   onFocus="this.style.backgroundColor = '#ADD8E6';" 
										   onBlur="this.style.backgroundColor = '#FFFFFF';" 
										   onClick="this.value=''" 
										   style="width:100%"
									/> 
								</td>
								<td align="center">
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarCondicionProyectos();"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr>
							
						</table>
						</div>
						</div>
					</div>
					<tr>
						<td colspan="3">
	<!-- LISTADO DE CONDICIONES APLICADAS A LA CONSULTA -->								
							<table cellpadding="3" cellspacing="0" border="0" width="100%">
								<tr><td class="tituloTabla">Condiciones de la consulta</td></tr>
								<tr><td id="wCondiciones"></td></tr>
							</table>
						</td>
					</tr>
					</td></tr>
<!-- RESULTADO DEL REPORTE -->					
					<tr><td>
						<div style="height:420px; overflow:auto;" id="resultado" >
							{include file="$txtArchivoAyuda"}
						</div>
					</td></tr>
				</table>
			</td>
		</tr>
<!-- LISTADO DE CAMPOS -->
		<tr>
			<td valign="top">
			
				<div id="tabCamposMostrar" class="yui-navset" style="width:100%; text-align:left;">
									
					<ul class="yui-nav">
			        	<li class="selected"><a href="#tabReporteadorCampos"><em>Campos para reporte</em></a></li>
				    </ul>  
				    
				    <div class="yui-content">
				    	<table cellpadding="3" cellspacing="0" border="0" width="100%">
				    		<tr><td align='right' ><a href="#" onClick="verAyudaReporteador( 2 )"><span class="tituloAyuda">Ayuda</span></a></td></tr>
				    	</table>
				    	<div id="tabReporteadorCampos" style="height:300px; overflow:auto;">
					    	<div id="treeDivArbolMostrar" class="ygtv-checkbox"></div>
							<div id="txtDivArbolReporteador" style="display:none">{$txtJsPostulacion}</div>
							<div id="camposOcultosReporteador" style="display:none"></div>
				    	</div>
				    </div>
				
				</div>
			</td>
		</tr>
<!-- BOTONES DE LOS CAMPOS -->
		<tr>
			<td align="center" style="border: 1px dotted #999999; padding:5px;">
				<table cellpadding="3" cellspacing="0" border="0" width="100%">
					<tr><td align="center">
						<a href="#" onClick="mostrarAyudaGeneralReporteador( )">AYUDA GENERAL</a>
					</td></tr>
					<tr><td>
					<button type="button" id="ejecutarReporteador" title="Exportar" class="reporteadorPlay">
						Ejecutar
					</button>
					 &nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" id="exportarReporte" title="Exportar" class="reporteadorExport" >
						Exportar
					</button>
					</td></tr>
				</table>
			</td>
		</tr>
	</table>
</form>


<div id="objReporteadorListenerProyectos"></div>
