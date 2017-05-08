{ assign var=numDiasPromedio 		value=$claCrm->numDiasPromedio }
{ assign var=numDesembolsoTotal 	value=$claCrm->numDesembolsoTotal }

<table cellspacing="0" cellpadding="0" border="0" width="100%" >

	<tr height="500px" >
		<!-- INDICADORES POR PROCESO -->
		<td width="30%" valign="top">
			<form id="frmSemaforos" >
			<input type="hidden" value="{$seqUsuario}" id="seqUsuario" name="seqUsuario" >
			<table cellspacing="0" cellpadding="0" border="0" width="100%" >
			
				<tr>
					<td colspan="2" class="tituloTabla" style="font-size:13px; text-align:center; padding-bottom:10px; padding-top:6px" >INDICADORES DESEMBOLSO</td>
				</tr>
			
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Asignados</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td > 
						<div id="divAsignados" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerAsignados" ></div>
					</td>
				</tr>
				<tr id="trTiempoPromedioAsignados" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Busqueda de la Oferta</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td > 
						<div id="divRevisionOferta" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerRevisionOferta" ></div>
					</td>
				</tr>
				<tr id="trTiempoPromedioRevisionOferta" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Revisión Jurídica Oferta</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divRevisionJuridica" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerRevisionJuridica" ></div>
					</td>
				</tr>
				<tr id="trTiempoPromedioRevisionJuridica" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Revisión Técnica</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divRevisionTecnica" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerRevisionTecnica" ></div>
					</td>
				</tr>
				<tr id="trTiempoPromedioRevisionTecnica" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Escrituración</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divEscrituracion" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerEscrituracion" ></div>
					</td>
				</tr>
				<tr id="trTiempoPromedioEscrituracion" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Radicado de Titulos</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divRadicadoTitulos" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerRadicadoTitulos" ></div>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Estudio Juridico Escrituras</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divEstudioTitulos" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerEstudioTitulos" ></div>
				</tr>
				<tr id="trTiempoPromedioEstudioTitulos" />
				<tr>
					<td align="center" colspan="2" style="padding-bottom:2px" class="tituloTabla" ><b>Solicitud de Desembolso</b></td>
				</tr>
				<tr>
					<td width="10%" />
					<td>
						<div id="divSolicitudDesembolso" >{include file="crm/indicadorTutorDesembolso/cuentaIndicador.tpl"}</div>
						<div id="divListenerSolicitudDesembolso" ></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="salir" style="font-size: 10px; text-align: left; padding: 3px;">
						Desembolsos Totales: ( { $numDesembolsoTotal } )
					</td>
				</tr>
				
			</table>
			</form>
		</td>
		
		<!-- FILTROS Y REPORTE -->
		<td valign="top">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			
				<tr valign="top" >
					<td colspan="2" class="tituloTabla" align="center"  class="tituloTabla" style="font-size:13px; text-align:center; padding-bottom:10px; padding-top:3px">CONTROL DE VOLUMEN</td>
				</tr>
			
				<!-- FILTROS -->
				<tr  bgcolor="#e4e4e4"  >
				
					<td width="50%" valign="top" style="padding-left:20px;padding-top:10px;" bgcolor="#e4e4e4" >
						<form id="reporteDiaSemanaAno" >
						<input type="hidden" value="{$seqUsuario}" id="seqUsuario" name="seqUsuario" >
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td>
									<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
											onBlur="this.style.backgroundColor = '#FFFFFF';"
											onchange="cargarIndicadoresDiaSemanaMes( this.value );"
											name="estadoDesembolso"
											id="estadoDesembolso" 
											style="width:180px;"
									>
										<option value="todos" selected >TODOS</option>
										{foreach from=$arrEstado key=seqEstadoProceso item=txtEstadoProceso}
											<option value="{$seqEstadoProceso}" >{$txtEstadoProceso}</option>
										{/foreach}
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<div id="divRangosEstados" >{include file="crm/indicadorTutorDesembolso/rangoEstados.tpl"}</div>
								</td>
							</tr>
							
						</table>
						</form>
					</td>
					<td style="padding-top:10px;" valign="top"  bgcolor="#e4e4e4" >
						<form id="reporteRango" >
						<input type="hidden" value="{$seqUsuario}" id="seqUsuario" name="seqUsuario" >
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2" >
									<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
											onBlur="this.style.backgroundColor = '#FFFFFF';" 
											name="estadoDesembolso"
											id="estadoDesembolso" 
											style="width:180px;"
									>
										<option value="todos" selected >TODOS</option>
										{foreach from=$arrEstado key=seqEstadoProceso item=txtEstadoProceso}
											<option value="{$seqEstadoProceso}" >{$txtEstadoProceso}</option>
										{/foreach}
									</select>
								</td>
							</tr>
							<tr height="25px">
								<td width="80px">Fecha Inicio:</td>
								<td>
									<input	type="text" 
											id="fchIni" 
											name="fchIni"
											style="width:100px;"
											maxlength="10"
											onFocus="this.style.backgroundColor = '#ADD8E6';" 
											onBlur="this.style.backgroundColor = '#FFFFFF';"
											value=""
											readonly 
									/> <a href="#" onClick="calendarioPopUp( 'fchIni' );">Calendario</a>	
								</td>
							</tr>
							<tr height="25px">
								<td width="80px">Fecha Fin:</td>
								<td>
									<input	type="text" 
											id="fchFin" 
											name="fchFin"
											style="width:100px;"
											maxlength="10"
											onFocus="this.style.backgroundColor = '#ADD8E6';" 
											onBlur="this.style.backgroundColor = '#FFFFFF';"
											value=""
											readonly 
									/> <a href="#" onClick="calendarioPopUp( 'fchFin' );">Calendario</a>	
								</td>
							</tr>
						</table>
						</form>
					</td>
					
				</tr>
				<tr  bgcolor="#e4e4e4" >
					<!-- BOTONES DE REPORTES POR DIA, SEMANA, MES -->
					<td width="50%" valign="top"  style="padding-bottom: 12px;padding-left:20px" >
						<input type="button" value="Consultar" 	onClick="reporteDiaSemanaMesRango('consulta' , 'diaSemanaMes', 'reporteDiaSemanaAno' )"; >&nbsp;
						<input type="button" value="Exportable" onClick="reporteDiaSemanaMesRango('reporte'  , 'diaSemanaMes', 'reporteDiaSemanaAno' )"; >
					</td>
					<!-- BOTONES DE REPORTES RANGO FECGAS -->
					<td valign="top" style="padding-bottom: 12px;">
						<input type="button" value="Consultar"  onClick="reporteDiaSemanaMesRango('consulta' , 'rangoFechas', 'reporteRango' )"; >&nbsp;
						<input type="button" value="Exportable" onClick="reporteDiaSemanaMesRango('reporte'  , 'rangoFechas', 'reporteRango' )"; >
					</td> 
				</tr>
				<tr  valign="top" >
					<td colspan="2" class="salir" style="font-size: 10px;" align="left">Tiempo promdio desde Busqueda de oferta a Solicitud de desembolso: ( { $numDiasPromedio } ) Dias</td>
				</tr>
				
				<tr height="385px" valign="top" >
					<td colspan="2" style="border:1px solid #999;" >
						<div id="divDataTableTutoresIndicadoresDesembolso"></div>
					</td>
				</tr>
			
			</table>
		</td>
	
	</tr>

</table>

<input value="0" type="hidden" name="pruebaAlerta" id="pruebaAlerta" />