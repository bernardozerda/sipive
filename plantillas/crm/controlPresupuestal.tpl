{assign var=arrNomina 					value=$claCrm->arrNomina }
{assign var=arrConcepto 				value=$claCrm->arrConcepto }
{assign var=arrMesesEjecutadosTXT 		value=$claCrm->arrMesesEjecutadosTXT }



	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td>
				<div id="tabView" class="yui-navset" style="width:100%; text-align:left;">
					<ul class="yui-nav">
						<li class="selected"><a href="#tabNomina"><em>Nomina</em></a></li>
						<li><a href="#tabConceptos"><em>Conceptos</em></a></li>
				    </ul>  
				    
				    <div class="yui-content">
				    
				    	<!-- NOMINA -->
				    	<div id="tabNomina" style="height:390px; width:735px; overflow:auto;">
				    	
				    		<!-- AGREGAR NOMINA -->
				    		<table cellpadding="2" cellspacing="0" border="0" width="100%">
				    		
				    			<tr>
									<td colspan="2" style="border:1px dotted #999999; padding:2px;" id="busquedaAvanzadaNomina" valign="top">
										<table cellpadding="2" cellspacing="0" border="0" width="735px">
											<tr>
												<td style="width:14px; height:14px; cursor:pointer;" align="center">
												<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;" 
												 	 onClick="cuadroBusquedaAvanzada( 'busquedaAvanzadaNomina' );"
													 onMouseOver="this.style.backgroundColor='#ADD8E6';"
													 onMouseOut="this.style.backgroundColor='#F9F9F9';"
													 id="masbusquedaAvanzadaNomina"
												>+</div>
												</td>
												<td>
													<a href="#" onClick="cuadroBusquedaAvanzada( 'busquedaAvanzadaNomina' );" style="text-decoration: hidden;">Agregar Nomina</a>
												</td>
											</tr>
										</table>
										
										<div id="cuadrobusquedaAvanzadaNomina" style="display:none;">
											<form id="frmNomina" >
											<input type="hidden" id="bolAgregarNomina" name="bolAgregarNomina" value="1" />
											<table cellspacing="0" cellpadding="0" border="0" width="735px">
								    			<tr class="tituloTabla" valign="middle" >
								    				<td width="150px" style="padding-bottom:4px;padding-top:8px;padding-left:10px;">Archivo Nomina</td>
													<td >
														<input type='file'
															id='fileNomina'
															name = 'fileNomina' >
														&nbsp;&nbsp;
														<a href="#" onClick="plantillaModuloOperativoNomina( )" >Ver Plantilla</a>
													</td>
								    			</tr>
								    			<tr>
								    				<td colspan="2">
								    					<table cellspacing="0" cellpadding="0" border="0" width="100%">
								    						<tr class="tituloTabla" valign="middle">
								    							<!-- <td /> -->
								    							<td style="padding-bottom:4px;padding-top:4px;padding-left:10px;">Nombre</td>
								    							<td>Número de Documento</td>
								    							<td>Fecha Inicial Contrato</td>
								    							<td>Fecha Final Contrato</td>
								    							<td>Valor Total Contrato</td>
								    							<td>Valor Mensual Contrato</td>
								    						</tr>
								    						<tr valign="middle">
								    							<!-- <td /><input type="checkbox" /> -->
								    							<td  style="padding-bottom:4px;padding-top:4px;padding-left:10px;" >
								    								<input 
								    									type="text"
								    									id="txtNombreContratista"
								    									name="txtNombreContratista"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloLetras( this ) "
																		style="width:110px"  
								    								/>
								    							</td>
								    							<td>
								    								<input 
								    									type="text"
								    									id="numDocumento"
								    									name="numDocumento"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
																		style="width:110px"  
								    								/>
								    							</td>
								    							<td>
								    								
								    								<input	type="text" 
																			id="fchInicioContrato"
																			name="fchInicioContrato"
																			onFocus="calendarioPopUp('fchInicioContrato'); " 
																			style="width:110px; background:#ADD8E6;" 
																			readonly
																	/> <a onClick="calendarioPopUp('fchInicioContrato')" href="#">Calendario</a> 
																</td>
								    							<td>
								    								
								    								<input	type="text" 
																			id="fchFinalContrato"
																			name="fchFinalContrato"
																			onFocus="calendarioPopUp('fchFinalContrato');" 
																			style="width:110px;  background:#ADD8E6;" 
																			readonly
																	/> <a onClick="calendarioPopUp('fchFinalContrato')" href="#">Calendario</a> 
																</td>
								    							<td>
								    								<input 
								    									type="text"
								    									id="valTotalContrato"
								    									name="valTotalContrato"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
																		style="width:110px"  
								    								/>
								    							</td>
								    							<td>
								    								<input 
								    									type="text"
								    									id="valMesContrato"
								    									name="valMesContrato"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
																		style="width:110px"  
								    								/>
								    							</td>
								    						</tr>
								    					</table>
								    				</td>
								    			</tr>
								    			<tr>
								    				<td colspan="2" align="right" style="padding-right:28px;padding-top:3px;padding-bottom:5px;" >
								    					<input type="button" value="Agregar" onclick="someterFormulario( 'mensajes', 'frmNomina', './contenidos/crm/salvarNomina.php', true, true )" >
								    				</td>
								    			</tr>
								    		</table>
								    		</form>
										</div>
									</td>
								</tr>
				    		</table>
				    		<!-- FIN AGREGAR NOMINA -->
				    		
				    		<!-- CONTRATISTAS NOMINA -->
				    		<div id="contratistasNomina" ></div>
				    		<form id="frmAgregarNomina" >
				    		<input type="hidden" id="bolAgregarNomina" name="bolAgregarNomina" value="0" />
				    		<table cellpadding="4" cellspacing="0" border="0" width="735px" >
				    			<tr align="left" class="tituloTablaIndicadores">
				    				<td width="100px"  >
				    					<input type="button" 
				    							value="Ejecutar Nómina"
				    							onclick="pedirConfirmacionEjecutarNomina( );" 
				    					/>
				    				</td>
				    			</tr>
				    		</table>
				    		
				    		<table cellpadding="2" cellspacing="0" border="1" width="735px"> 
				    			<tr class="tituloTabla" >
				    				<td >Nombre</td>
				    				<td >Número Documento</td>
				    				<td >Fecha Inicial</td>
				    				<td >Fecha Final</td>
				    				<td >Valor Total Contrato</td>
				    				<td >Valor Mensual Contrato</td>
				    				{foreach from=$arrMesesEjecutadosTXT key=txtFecha item=numFecha}
				    					<td>{$txtFecha}</td>
				    				{/foreach}
				    			</tr>
				    			{foreach from=$arrNomina item=arrDatoNomina}
				    				<tr>
				    					{foreach from=$arrDatoNomina key=keyNomina item=datoNomina}
				    						
				    						{if $keyNomina eq "seqNomina"}
				    							{assign var=seqNomina 		value=$datoNomina }
				    						{elseif $keyNomina eq "valPagado" }
				    							{foreach from=$datoNomina item=valPagado}
				    								<td>{$valPagado}</td>
				    							{/foreach}
				    						{else}
				    							<td>
				    								{$datoNomina}
				    								<input type="hidden"
				    										id="{$keyNomina}[{$seqNomina}]" 
				    										name="{$keyNomina}[{$seqNomina}]"
				    										value="{$datoNomina}"
				    								/>
				    							</td>
				    						{/if}
				    					{/foreach}
				    				</tr>
								{/foreach}
				    		</table>
				    		</form>
				    		<!-- FIN CONTRATISTAS NOMINA -->
				    		
				    	</div>
				    	<!-- FIN NOMINA -->
				    	
				    	<!-- CONCEPTO -->
				    	<div id="tabConceptos" style="height:390px; overflow:auto">
				    	
				    		<!-- AGREGAR CONCEPTO -->
				    		<table cellpadding="2" cellspacing="0" border="0" width="100%">
				    		
				    			<tr>
									<td colspan="2" style="border:1px dotted #999999; padding:2px;" id="busquedaAvanzadaConcepto" valign="top">
										<table cellpadding="2" cellspacing="0" border="0" width="100%">
											<tr>
												<td style="width:14px; height:14px; cursor:pointer;" align="center">
												<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; text-align:center;" 
												 	 onClick="cuadroBusquedaAvanzada( 'busquedaAvanzadaConcepto' );"
													 onMouseOver="this.style.backgroundColor='#ADD8E6';"
													 onMouseOut="this.style.backgroundColor='#F9F9F9';"
													 id="masbusquedaAvanzadaConcepto"
												>+</div>
												</td>
												<td>
													<a href="#" onClick="cuadroBusquedaAvanzada( 'busquedaAvanzadaConcepto' );" style="text-decoration: hidden;">Agregar Conceptos</a>
												</td>
											</tr>
										</table>
										
										<div id="cuadrobusquedaAvanzadaConcepto" style="display:none;">
											<form id="frmConcepto">
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
								    			<tr class="tituloTabla" valign="middle" >
								    				<td width="150px" style="padding-bottom:4px;padding-top:8px;padding-left:10px;">Archivo Conceptos</td>
													<td >
														<input type='file'
															id='fileConceptos'
															name = 'fileConceptos' >
														&nbsp;&nbsp;
														<a href="#" onClick="plantillaModuloOperativoConceptos( )" >Ver Plantilla</a>
													</td>
								    			</tr>
								    			<tr>
								    				<td colspan="2">
								    					<table cellspacing="0" cellpadding="0" border="0" width="100%">
								    						<tr class="tituloTabla" valign="middle">
								    							<!-- <td /> -->
								    							<td style="padding-bottom:4px;padding-top:4px;padding-left:10px;">Concepto</td>
								    							<td>Proyecto</td>
								    							<td>Valor</td>
								    							<td>Fecha</td>
								    						</tr>
								    						<tr valign="middle">
								    							<!-- <td /><input type="checkbox" /> -->
								    							<td  style="padding-bottom:4px;padding-top:4px;padding-left:10px;" >
								    								<input 
								    									type="text"
								    									id="txtConcepto"
								    									name="txtConcepto"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloLetrasNumeros( this );"
																		style="width:115px"  
								    								/>
								    							</td>
								    							<td>
								    								<input	type="text" 
																			id="numProyecto"
																			name="numProyecto"
																			onFocus="this.style.backgroundColor = '#ADD8E6';" 
																			onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
																			style="width:115px" 
																	/>
																</td>
								    							<td>
								    								<input 
								    									type="text"
								    									id="valConcepto"
								    									name="valConcepto"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
																		style="width:115px"  
								    								/>
								    							</td>
								    							<td>
								    								<input 
								    									type="text"
								    									id="fchConcepto"
								    									name="fchConcepto"
																		onFocus="this.style.backgroundColor = '#ADD8E6';" 
																		onBlur="this.style.backgroundColor = '#FFFFFF'; "
																		style="width:115px" 
																		value=""
																		readonly
								    								/> <a onClick="calendarioPopUp('fchConcepto')" href="#">Calendario</a>
								    							</td>
								    						</tr>
								    					</table>
								    				</td>
								    			</tr>
								    			<tr>
								    				<td colspan="2" align="right" style="padding-right:28px;padding-top:3px;padding-bottom:5px;" >
								    					<input type="button" value="Agregar" onclick="someterFormulario( 'mensajes', 'frmConcepto', './contenidos/crm/salvarConcepto.php', true, true )" >
								    				</td>
								    			</tr>
								    		</table>
								    		</form>
										</div>
										
									</td>
								<tr>
				    		
				    		</table>
				    		<!-- FIN AGREGAR CONCEPTO -->
				    		
				    		<!-- LISTA CONCEPTOS -->
				    		<table cellpadding="2" cellspacing="0" border="1" width="100%" >	
				    			<tr class="tituloTabla" valign="middle">
	    							<td width="30px" />
	    							<td>Concepto</td>
	    							<td>Proyecto</td>
	    							<td>Valor</td>
	    							<td>Fecha</td>
	    						</tr>
	    						{foreach from=$arrConcepto item=arrDatoConcepto}
				    				<tr>
				    					{foreach from=$arrDatoConcepto key=keyConcepto item=datoConcepto}
				    						<td>
				    						{if $keyConcepto eq "seqConcepto"}
				    							<a href="#" onclick="pedirConfirmacionBorrarConcepto( {$datoConcepto} );"
				    												
				    												>( - )</a> 
				    						{elseif $keyConcepto eq "valConcepto" }
				    							$ {$datoConcepto|number_format:0:'.':','}
				    						{else}
				    							{$datoConcepto}
				    						{/if}
				    						</td>
				    					{/foreach}
				    				</tr>
								{/foreach}
				    		</table>
				    	
				    	</div>
				    	<!-- FIN CONCEPTO -->
				    	
				    </div>
				    
				  </div>
			</td>
		</tr>
	</table>

	<div id="activarTabView"></div>