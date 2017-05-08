
	<!--
		PLANTILLA PARA LA ETAPA DE REVSION DE OFERTA Y ESCRITURACION 
		@author Bernardo Zerda
		@version 1.0 Dic 2009
	-->
	
	<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->
	{assign var=seqModalidad     		value=$claFormulario->seqModalidad}
	{assign var=seqSolucion      		value=$claFormulario->seqSolucion}		
	{assign var=seqLocalidad     		value=$claFormulario->seqLocalidad}
	{assign var=seqBancoAhorro   		value=$claFormulario->seqBancoCuentaAhorro}
	{assign var=seqBancoAhorro2  		value=$claFormulario->seqBancoCuentaAhorro2}
	{assign var=seqBancoCredito  		value=$claFormulario->seqBancoCredito}
	{assign var=seqEstadoProceso 	  	value=$claFormulario->seqEstadoProceso}
	{assign var=seqBancoCuentaAhorro  	value=$claFormulario->seqBancoCuentaAhorro}
	{assign var=seqBancoCuentaAhorro2 	value=$claFormulario->seqBancoCuentaAhorro2}
	{assign var=seqBancoCredito       	value=$claFormulario->seqBancoCredito}
	{assign var=seqEntidadDonante     	value=$claFormulario->seqEmpresaDonante}
	{assign var=seqTipoDocumento 		value=$objCiudadano->seqTipoDocumento}
    
    {assign var=numAltura value=500}
	<div id="demo" class="yui-navset" style="width:98%; height:{$numAltura}; text-align:left;">
	    <ul class="yui-nav">
	    	<li class="selected"><a href="#dho"><em>Datos del Hogar</em></a></li>
	        <li><a href="#dho"><em>Estudio de Titulos</em></a></li>
	        <li><a href="#seg"><em>Seguimiento</em></a></li>
	        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
	    </ul>  
	    <div class="yui-content">
<!-- PESTANA DE DATOS DEL HOGAR -->
			<div id="dho" style="height:{$numAltura}">
				{include file="desembolso/pestanaDatosHogar.tpl"}				
			</div>
<!-- ESTUDIO DE TITULOS -->
			<div id="eti" style="height:{$numAltura}; overflow:auto;">
				
				<table cellpadding="3" cellspacing="0" border="0" width="100%">
					<tr bgcolor="#FFFFFF"><td colspan="2" align="center">
						<b>Secretaría Distrital del Hábitat<br>
						{if $seqModalidad eq "5"}
							Concepto Jurídico Contrato<br /> 
							Subsidio Condicionado de Arrendamiento
						{else}
							Estudio de Títulos<br />
							Vivienda {$claDesembolso->txtCompraVivienda|ucwords}</b>
						{/if}
					</td></tr>
				
					<!-- PREPARO -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td><b>Preparó</b></td>
						<td>{$txtUsuarioSesion}</td>
					</tr>
					
					<!-- APROBO -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td><b>Aprobó</b></td>
						<td colspan="2" height="17px" valign="top">
							<div id="buscarUsuario">
								<input	id="aprobo" 
										name="aprobo"
										type="text" 
										style="width:250px" 
										onFocus="this.style.backgroundColor = '#ADD8E6'; " 
										onBlur="this.style.backgroundColor = '#FFFFFF';" 
										value="{$claDesembolso->arrTitulos.txtAprobo}"
								/>
								<div id="contUsuario" style="width:250px"></div>
							</div>	
						</td>
					</tr>
					
					<!-- FECHA -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td><b>Fecha:</b></td>
						<td>{$txtHoy}</td>
					</tr>
					
					<!-- PROPERTARIO -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td><b>{if $seqModalidad eq "5"}Arrendador{else}Propietario{/if}</b></td>
						<td>
							{if $claDesembolso->arrEscrituracion.txtNombreVendedor != ""}
								{$claDesembolso->arrEscrituracion.txtNombreVendedor}
							{else}
								{$claDesembolso->txtNombreVendedor}
							{/if}
						</td>
					</tr>
					
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td><b>Postulante Principal:</b></td> 
						<td>{$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2}
							{$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
							{$arrTipoDocumento.$seqTipoDocumento} {$objCiudadano->numDocumento}
						</td>
					</tr>
					
					<!-- IDENTIFICACION DEL INMUEBLE -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top">
							<b>Identificación Actual del Inmueble:</b>
						</td>
						<td align="justify">
							{if $claDesembolso->arrEscrituracion.txtDireccionInmueble != ""}
								{$claDesembolso->arrEscrituracion.txtDireccionInmueble|upper} 
							{else}
								{$claDesembolso->txtDireccionInmueble|upper}
							{/if}; predio cuya descripcion, cabida y linderos se encuentran estipulados en la escritura pública 
							<u><i><a href="#" id="escritura1" onClick="recogerValor( ['escritura1','escritura2'] , 'numero' ,'variables' )">
								{if $claDesembolso->arrTitulos.numEscrituraIdentificacion != ""}
									{$claDesembolso->arrTitulos.numEscrituraIdentificacion|number_format:0:',':'.'}
								{else}
									Número Escritura
								{/if}
							</a></i></u> del 
							<u><i><a href="#" id="fecha1" onClick="calendarioDesembolso( ['fecha1','fecha2'] , 'variables' );" >
								{if $claDesembolso->arrTitulos.fchEscrituraIdentificacion != ""}
									{$claDesembolso->arrTitulos.fchEscrituraIdentificacion|date_format:"%d de %B del %Y"}
								{else}
									Fecha Escritura
								{/if}
							</a></i></u> elevada ante la notaría 
							<u><i><a href="#" id="notaria1" onClick="recogerValor( ['notaria1','notaria2'] , 'numero' ,'variables' )">
								{if $claDesembolso->arrTitulos.numNotariaIdentificacion != ""}
									{$claDesembolso->arrTitulos.numNotariaIdentificacion|number_format:0:',':'.'}
								{else}
									Número Notaría
								{/if}
							</a></i></u> de 
							<u><i><a href="#" id="ciudadIdentificacion" onClick="recogerValor( ['ciudadAdquisicion','ciudadIdentificacion'] , 'texto' , 'variables' ); ">
								 {if $claDesembolso->arrTitulos.txtCiudadIdentificacion != ""}
									{$claDesembolso->arrTitulos.txtCiudadIdentificacion}
								{else}
									Ciudad
								{/if}
							</a></i></u>
						</td>
					</tr>
					
					{if $seqModalidad neq "5"}
					<!-- TITULO DE ADQUISICION -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top">
							<b>Título de Adquisición:</b>
						</td>
						<td align="justify">
							Escritura pública 
							<u><i><a href="#" id="escritura2" onClick="recogerValor( ['escritura1','escritura2'] , 'numero' ,'variables' )">
								{if $claDesembolso->arrTitulos.numEscrituraTitulo != ""}
									{$claDesembolso->arrTitulos.numEscrituraTitulo|number_format:0:',':'.'}
								{else}
									Número Escritura
								{/if}
							</a></i></u> del 
							<u><i><a href="#" id="fecha2" onClick="calendarioDesembolso( ['fecha1','fecha2'] , 'variables' );" >
								{if $claDesembolso->arrTitulos.fchEscrituraTitulo != ""}
									{$claDesembolso->arrTitulos.fchEscrituraTituloTexto|date_format:"%d de %B del %Y"}
								{else}
									Fecha Escritura
								{/if}
							</a></i></u> elevada ante la notaría 
							<u><i><a href="#" id="notaria2" onClick="recogerValor( ['notaria1','notaria2'] , 'numero' ,'variables' )">
								{if $claDesembolso->arrTitulos.numNotariaTitulo != ""}
									{$claDesembolso->arrTitulos.numNotariaTitulo|number_format:0:',':'.'}
								{else}
									Número Notaría
								{/if}
							</a></i></u> de 
								
							<u><i><a href="#" id="ciudadAdquisicion" onClick="recogerValor( ['ciudadAdquisicion','ciudadIdentificacion'] , 'texto' , 'variables' ); ">
								 {if $claDesembolso->arrTitulos.txtCiudadTitulo != ""}
									{$claDesembolso->arrTitulos.txtCiudadTitulo}
								{else}
									Ciudad
								{/if}
							</a></i></u> Registrada en la anotacion 
								
							<a href="#" id="numerofolio" onClick="recogerValor( ['numerofolio','numerofolio'] , 'numero' ,'variables' )">
							{if $claDesembolso->arrTitulos.numFolioMatricula != 0}
								{$claDesembolso->arrTitulos.numFolioMatricula|number_format:0:',':'.'}
							{else}
								Folio
							{/if} </a>
							del Folio de Matricula Inmobilaria.
							
						</td>
					</tr>
					{/if}
					
					<!-- MATRICULA INMOBILIARIA -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top">
							<b>Matricula Inmobiliaria:</b>
						</td>
						<td align="justify">
							{if $claDesembolso->arrEscrituracion.txtMatriculaInmobiliaria != ""}
								{$claDesembolso->arrEscrituracion.txtMatriculaInmobiliaria|upper}
							{else}
								{$claDesembolso->txtMatriculaInmobiliaria|upper}
							{/if}; de la oficina de registro de instrumentos públicos zona <u><i><a href="#" id="zona" onClick="recogerValor( ['zona'] , 'select' ,'variables' )">
							{if $claDesembolso->arrTitulos.txtZonaMatricula != ""}
								{$claDesembolso->arrTitulos.txtZonaMatricula|ucwords}
							{else}
								Zona
							{/if}
							</a></i></u> 
							de 
							<u><i><a href="#" id="ciudadMatricula" onClick="recogerValor( ['ciudadMatricula'] , 'texto' ,'variables' )">
							{if $claDesembolso->arrTitulos.txtCiudadMatricula != ""}
								{$claDesembolso->arrTitulos.txtCiudadMatricula|ucwords}
							{else}
								Bogot&aacute;
							{/if}
							</a></i></u> 
							 cuya fecha de expedicion data del 
							<u><i><a href="#" id="fechaMatricula" onClick="calendarioDesembolso( ['fechaMatricula'] , 'variables' );">
								{if $claDesembolso->arrTitulos.fchMatricula != ""}
									{$claDesembolso->arrTitulos.fchMatricula|date_format:"%d de %B del %Y"}
								{else}
									Fecha Matricula
								{/if}
							</a></i></u> 
						</td>
					</tr>
					
					{if $seqModalidad neq "5"}
					<!-- MODO DE ADQUISICION -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top">
							<b>Modo de Adquisición:</b>
						</td>
						<td align="justify">
							<div style="float:left">Compraventa {$arrSolucionDescripcion.$seqModalidad.$seqSolucion}, adquirida con el producto otorgado por la SDHT&nbsp;</div>
							<div style="float:left;" id="subsidioFonvivienda">
								{if $claDesembolso->arrTitulos.bolSubsidioFonvivienda == 1}
									y Fonvivienda
								{/if}
							</div>
						</td>
					</tr>
					{/if}
					
					{if $seqModalidad neq "5"}
						<!-- AVALUO -->
						<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
							<td valign="top">
								<b>Valor Inmueble:</b>
							</td>
							<td align="justify">
								<div style="float:left"></div>
								<div style="float:left;" id="subsidioFonvivienda">
									{if $claDesembolso->arrEscrituracion.numValorInmueble != ""}
										${$claDesembolso->arrEscrituracion.numValorInmueble|number_format:0:",":"."}
									{else}
										${$claDesembolso->numValorInmueble|number_format:0:",":"."}
									{/if}
								</div>
							</td>
						</tr>
					{/if}
					
					<!-- SUBSIDIOS ASIGNADOS -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top">
							<b>Subsidios Asignados:</b>
						</td>
						<td align="justify">
							<input type="checkbox" 
								   name="subsidioSdht" 
								   value="1"
								   onClick="this.checked=true"
								   checked
							/> SDHT: Resolución {$claDesembolso->arrJuridico.numResolucion|number_format:0:',':'.'} del {$claDesembolso->arrJuridico.fchResolucion}<br>
							<input type="checkbox" 
								   name="subsidioFonvivienda" 
								   value="1"
								   onClick="checkSubsidioFonvivienda( this );" 
								   {if $claDesembolso->arrTitulos.bolSubsidioFonvivienda == 1 } checked {/if} 
							/> Fonvivienda: Resolución <u><i><a href="#" id="resolucion" onClick="recogerValor( ['resolucion'] , 'numero' ,'variables' )">
							{if $claDesembolso->arrTitulos.numResolucionFonvivienda != "" && $claDesembolso->arrTitulos.numResolucionFonvivienda != 0}
								{$claDesembolso->arrTitulos.numResolucionFonvivienda|number_format:0:',':'.'}
							{else}
								Número Resolución
							{/if}
							</a></i></u> del 
							<u><i><a href="#" id="ano" onClick="recogerValor( ['ano'] , 'numero' ,'variables' )">
							{if $claDesembolso->arrTitulos.numAnoResolucionFonvivienda != "" && $claDesembolso->arrTitulos.numAnoResolucionFonvivienda != 0}
								{$claDesembolso->arrTitulos.numAnoResolucionFonvivienda|number_format:0:',':'.'}
							{else}
								Año Resolución
							{/if}
							</a></i></u> 
						</td>
					</tr>
					
					<!-- OBSERVACIONES -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top"><b>Observaciones:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="observacion"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea>
								</td>
								<td width="50px"> 
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('observacion') , 'resultadoObservaciones' , 'observacion' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}"><td id="resultadoObservaciones" colspan="2">
						{foreach name=observacion from=$claDesembolso->arrTitulos.observacion item=txtObservacion}
							{math equation="x + y" x=$smarty.foreach.observacion.index y=1 assign=numSecuencia}							
							<div id="observacion{$numSecuencia}">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('observacion{$numSecuencia}')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '{$txtObservacion}')" onMouseOut="ocultarHint();">
									{if $txtObservacion|strlen > 100 }
										{$numSecuencia} - {$txtObservacion|substr:0:100}...
									{else}
										{$numSecuencia} - {$txtObservacion}
									{/if}
								</div>
								<input type="hidden" name="observacion[]" value="{$txtObservacion}">
							</div>	
						{/foreach}
					</td></tr>
					
					<!-- DOCUMENTOS ANALIZADOS -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top"><b>Documentos Analizados:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="documento"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea>
								</td>
								<td width="50px"> 
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('documento') , 'resultadoDocumentos' , 'documento' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}"><td id="resultadoDocumentos" colspan="2">
						{foreach name=documentos from=$claDesembolso->arrTitulos.documentos item=txtDocumentos}
							{math equation="x + y" x=$smarty.foreach.documentos.index y=1 assign=numSecuencia}							
							<div id="documento{$numSecuencia}">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('documento{$numSecuencia}')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '{$txtDocumentos}')" onMouseOut="ocultarHint();">
									{if $txtDocumentos|strlen > 100 }
										{$numSecuencia} - {$txtDocumentos|substr:0:100}...
									{else}
										{$numSecuencia} - {$txtDocumentos}
									{/if}
								</div>
								<input type="hidden" name="documento[]" value="{$txtDocumentos}">
							</div>	
						{/foreach}
					</td></tr>
					
					<!-- RECOMENDACIONES -->
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}">
						<td valign="top"><b>Recomendaciones:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="recomendaciones"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea> 
								</td>
								<td width="50px">
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('recomendaciones') , 'resultadoRecomendaciones' , 'recomendaciones' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="{cycle values="#F9F9F9,#F0F0F0"}"><td id="resultadoRecomendaciones" colspan="2">
						{foreach name=recomendaciones from=$claDesembolso->arrTitulos.recomendaciones item=txtRecomendacion}
							{math equation="x + y" x=$smarty.foreach.documentos.index y=1 assign=numSecuencia}							
							<div id="recomendaciones{$numSecuencia}">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('recomendaciones{$numSecuencia}')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '{$txtRecomendacion}')" onMouseOut="ocultarHint();">
									{if $txtDocumentos|strlen > 100 }
										{$numSecuencia} - {$txtRecomendacion|substr:0:100}...
									{else}
										{$numSecuencia} - {$txtRecomendacion}
									{/if}
								</div>
								<input type="hidden" name="recomendaciones[]" value="{$txtRecomendacion}">
							</div>	
						{/foreach}
					</td></tr>
				</table>
				
				<!-- VARIABLES PARA EL FORMULARIO -->
				<div id="variables">
					<input type="hidden" 
						   id="varescritura1" 
						   name="escritura1" 
						   value="{$claDesembolso->arrTitulos.numEscrituraIdentificacion}"
					/>
					<input type="hidden" 
						   id="varfecha1"
						   name="fecha1" 
						   value="{$claDesembolso->arrTitulos.fchEscrituraIdentificacion}"
					/>
					<input type="hidden" 
						   id="varnotaria1"
						   name="notaria1" 
						   value="{$claDesembolso->arrTitulos.numNotariaIdentificacion}"
					/>
					<input type="hidden" 
						   id="varescritura2" 
						   name="escritura2" 
						   value="{$claDesembolso->arrTitulos.numEscrituraTitulo}"
					/>
					<input type="hidden" 
						   id="varfecha2"
						   name="fecha2" 
						   value="{$claDesembolso->arrTitulos.fchEscrituraTitulo}"
					/>
					<input type="hidden" 
						   id="varnotaria2"
						   name="notaria2" 
						   value="{$claDesembolso->arrTitulos.numNotariaTitulo}"
					/>
					<input type="hidden" 
						   id="varciudadAdquisicion"
						   name="ciudadAdquisicion" 
						   value="{$claDesembolso->arrTitulos.txtCiudadTitulo}"
					/>
					<input type="hidden" 
						   id="varciudadIdentificacion"
						   name="ciudadIdentificacion" 
						   value="{$claDesembolso->arrTitulos.txtCiudadIdentificacion}"
					/>
					<input type="hidden" 
						   id="varnumerofolio"
						   name="numerofolio" 
						   value="{$claDesembolso->arrTitulos.numFolioMatricula}"
					/>
					<input type="hidden" 
						   id="varzona"
						   name="zona" 
						   value="{$claDesembolso->arrTitulos.txtZonaMatricula}"
					/>

					<input type="hidden" 
						   id="varciudadMatricula"
						   name="ciudadMatricula" 
						   value="{if $claDesembolso->arrTitulos.txtCiudadMatricula != ''}{$claDesembolso->arrTitulos.txtCiudadMatricula}{else}Bogot&aacute;{/if}"
					/>


					<input type="hidden" 
						   id="varfechaMatricula"
						   name="fechaMatricula" 
						   value="{$claDesembolso->arrTitulos.fchMatricula}"
					/>
					<input type="hidden" 
						   id="varresolucion"
						   name="resolucion" 
						   value="{$claDesembolso->arrTitulos.numResolucionFonvivienda}"
					/>
					<input type="hidden" 
						   id="varano"
						   name="ano" 
						   value="{$claDesembolso->arrTitulos.numAnoResolucionFonvivienda}"
					/>
				</div>
								
			</div>
<!-- PESTANA DE SEGUIMIENTO -->			
			<div id="seg" style="height:{$numAltura}; overflow:auto;"><p>
				{include file="seguimiento/seguimientoFormulario.tpl"}
	        	<p><div id="contenidoBusqueda">
	        		{include file="seguimiento/buscarSeguimiento.tpl"}
	        	</div></p>
	        	<input type="hidden" id="seqFormularioEditar" value="{$seqFormulario}">
			</p></div>	
			
			<!-- PESTAÑA ACTOS ADMINISTRATIVOS -->	        
	        <div id="aad" style="height:{$numAltura};"><p>
	        	{include file="subsidios/actosAdministrativos.tpl"}
	        </p></div>
					
	    </div>
	</div>
	
	<div id="seguimiento"></div>
	<div id="listenerBuscarUsuario" style="visibility: hidden;">juridica</div>	
	
	
