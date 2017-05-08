{ assign var=arrIndicadorControlPresupuestal 		value=$claCrm->arrIndicadorControlPresupuestal }
	
	<table cellpadding="1" cellspacing="0" border="0" width="100%">
		<tr><td class="tituloTabla" style="padding-bottom: 5px;" >Control Presupuestal</td></tr>
		{foreach from=$arrIndicadorControlPresupuestal key=numProyecto item=arrIndicadorProyecto }
			<tr >
				<td >
				
					<div class="botonMas" 
						style="background: #E4E4E4;"
						onClick="mostrarOcultar('proyecto{$numProyecto}');" 
					> + </div>
					<div style="cursor:pointer; height:15px; width:96%; float:left; padding-left:5px; "
						class="tituloTablaIndicadores" 
						onClick="mostrarOcultar('proyecto{$numProyecto}');" 
					>
						Proyecto {$numProyecto}
					</div> 
					<div style="padding-left:16px; display:none; float:left; width:100%" id="proyecto{$numProyecto}">
					
					<table cellpadding="1" cellspacing="0" border="0" width="98%">
					
						{foreach from=$arrIndicadorProyecto key=txtNombreControl item=arrIndicadorControl}
							<tr>
								<td>
									<div class="botonMas" 
										onClick="ver{$txtNombreControl}{$numProyecto}( '{$txtNombreControl}{$numProyecto}' );" 
									> + </div>
									<div style="cursor:pointer; height:15px; width:96%; float:left; padding-left:5px;"
										onClick="ver{$txtNombreControl}{$numProyecto}( '{$txtNombreControl}{$numProyecto}' );" 
										onMouseOver="this.style.background='#E4E4E4'" 
										onMouseOut="this.style.background='#F9F9F9'"
									> {$txtNombreControl} </div>
									<div style="padding-left:16px; display:none; overflow: auto; width:100%; float:left;" id="{$txtNombreControl}{$numProyecto}">
										{if $txtNombreControl eq "Resoluciones"}
											{assign var='txtArchivoIndicadorControl' value='indicadorResoluciones'}
										{elseif $txtNombreControl eq "Operaciones"}
											{assign var='txtArchivoIndicadorControl' value='indicadorOperaciones'}
										{else $txtNombreControl eq "Conceptos"}
											{assign var='txtArchivoIndicadorControl' value='indicadorConceptos'}
										{/if}
										{include file="crm/indicadorSolicitudDesembolso/$txtArchivoIndicadorControl.tpl"}
									</div>
								</td>
							</tr>
						{/foreach}
						<tr>
							<td>
								<div class="botonMas"
									onClick="verGrafica{$numProyecto}( 'grafica{$numProyecto}' );" 
								> + </div>
								<div style="cursor:pointer; height:15px; width:96%; float:left; padding-left:5px;"
									onClick="verGrafica{$numProyecto}( 'grafica{$numProyecto}' );" 
									onMouseOver="this.style.background='#E4E4E4'" 
									onMouseOut="this.style.background='#F9F9F9'"
								> Gráficas Desembolsos </div>
								<div style="padding-left:16px; display:none; overflow: auto; width:100%; float:left;" id="grafica{$numProyecto}">
									<a href="#" onclick="agrandarMontoDesembolso{$numProyecto}( );">Agrandar</a> - Monto Desembolsado <br />
									<div id="GraficaTotalGiros{$numProyecto}" ></div>
									<a href="#" onclick="agrandarCantidadHogares{$numProyecto}( );">Agrandar</a> - Cantidad Hogares<br />
									<div id="GraficaTotalHogares{$numProyecto}" ></div>
								</div>
								
							</td>
						</tr>
					
					</table>
						
						
						
					</div>
					
					
				</td>
			</tr>
		{/foreach}
		<tr>
			<td>
				<div class="botonMas" 
					style="background: #E4E4E4;"
					onClick="verGraficasTotalControlPresupuestal( 'graficasTotalControlPresupuestal' ) ;" 
				> + </div>
				<div style="cursor:pointer; height:15px; width:96%; float:left; padding-left:5px; "
					class="tituloTablaIndicadores" 
					onClick="verGraficasTotalControlPresupuestal( 'graficasTotalControlPresupuestal' );" 
				>
					Gráficas Totales Desembolso
				</div> 
				<div style="padding-left:16px; display:none; float:left; width:100%" id="graficasTotalControlPresupuestal">
					<a href="#" onclick="agrandarMontoHogaresTotales( );">Agrandar</a> - Monto Desembolsado Totales <br />
					<div id="GraficaTotalGirosTODO" ></div>
					<a href="#" onclick="agrandarCantidadHogaresTotales( );">Agrandar</a> - Cantidad Hogares Totales<br />
					<div id="GraficaTotalHogaresTODO" ></div>
					<a href="#" onclick="agrandarResumenIndicador( );">Agrandar</a> - Resumen
					<br />
					<div id="GraficaResumen" ></div>
				</div>
			</td>
		</tr>
	</table>
	<div id="divTxtJSGraficasControlPresupuestal" style="display:none;"> 
	
		{$claCrm->txtResolucionesTotalGiros644JS}
		{$claCrm->txtResolucionesTotalHogares644JS}
		{$claCrm->txtResolucionesCDPEjecutado644JS}
		{$claCrm->txtResolucionesTotal644}
		{$claCrm->txtProyecto644JS}
		{$claCrm->txtConcepto644JS}
		
		{$claCrm->txtResolucionesTotalGiros488JS}
		{$claCrm->txtResolucionesTotalHogares488JS}
		{$claCrm->txtResolucionesCDPEjecutado488JS}
		{$claCrm->txtResolucionesTotal488}
		{$claCrm->txtProyecto488JS}
		{$claCrm->txtConcepto488JS}
		
		{$claCrm->txtResolucionesTotalHogaresTODOJS}
		{$claCrm->txtResolucionesTotalGirosTODOJS}
		{$claCrm->txtResumenDesembolsosJS}
		
		{$claCrm->txtOperacionesJS}
		{$claCrm->txtOperacionePorContratosJS}
		{$claCrm->txtOperacionePorContratosTotalJS}
		
	</div>