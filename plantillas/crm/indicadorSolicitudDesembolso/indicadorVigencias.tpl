	
{ assign var=arrIndicadorVigencias 		value=$claCrm->arrIndicadorVigencias }
	
	
	<table cellpadding="1" cellspacing="0" border="0" width="100%">
		<tr><td class="tituloTabla" style="padding-bottom: 5px;" >Control Vigencias</td></tr>
		
		{foreach from=$arrIndicadorVigencias key=numProyecto item=arrIndicadorVigencia }
			<tr>
				<td>
					<div class="botonMas" 
						style="background: #E4E4E4;"
						onClick="mostrarOcultar('proyectoCV{$numProyecto}');" 
					> + </div>
					<div style="cursor:pointer; height:15px; width:93%; float:left; padding-left:5px; "
						class="tituloTablaIndicadores" 
						onClick="mostrarOcultar('proyectoCV{$numProyecto}')"
					>
						Proyecto {$numProyecto}
					</div>
					
					<div style="padding-left:16px; display:none; float:left; width:100%" id="proyectoCV{$numProyecto}">
					
						<table cellpadding="1" cellspacing="0" border="0" width="98%">
							{foreach from=$arrIndicadorVigencia key=txtNombreControl item=arrIndicadorControl}
								<tr>
									<td>
										<div class="botonMas" 
											onClick="verVigencia{$txtNombreControl}{$numProyecto}( 'vigencia{$txtNombreControl}{$numProyecto}' );" 
										> + </div>
										<div style="cursor:pointer; height:15px; width:93%; float:left; padding-left:5px;"
											onClick="verVigencia{$txtNombreControl}{$numProyecto}( 'vigencia{$txtNombreControl}{$numProyecto}' );" 
											onMouseOver="this.style.background='#E4E4E4'" 
											onMouseOut="this.style.background='#F9F9F9'"
										> {$txtNombreControl} </div>
										
										<div style="padding-left:16px; display:none; overflow: auto; float:left; width:100%;" id="vigencia{$txtNombreControl}{$numProyecto}">
										
											{if $txtNombreControl eq "Resoluciones"}
												{assign var='txtArchivoIndicadorControl' value='indicadorResolucionesVigencias'}
											{elseif $txtNombreControl eq "Operaciones"}
												{assign var='txtArchivoIndicadorControl' value='vigenciaNomina'}
											{/if}
											{include file="crm/indicadorSolicitudDesembolso/$txtArchivoIndicadorControl.tpl"}
										
										</div>
									</td>
								</tr>
							
							{/foreach}
						</table>
					
					</div>
				</td>
			</tr>
		
		{/foreach}
		
		
	</table>
	
	<div id="divTxtJSGraficasVigencia" style="display:none; " > 
		{$claCrm->txtNominaJS}
		{$claCrm->txtNominaFinalizadaJS}
		{$claCrm->txtVigenciaResolucion644JS}
		{$claCrm->txtVigenciaResolucion488JS}
	</div>