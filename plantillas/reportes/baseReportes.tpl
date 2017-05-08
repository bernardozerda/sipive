
	<form>
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>	
			<!-- FILTROS -->
			{if not empty( $arrFiltros ) }
        	<td width="30%" valign="top" >
					<!-- <span class="tituloTabla"> -->
				FILTROS
					<!-- </span> -->
					<table cellspacing="0" cellpadding="0" border="0" width="98%">
					
						{foreach from=$arrFiltros item=arrFiltro}
						<tr>
							<td>{$arrFiltro[0]}</td>
							<td>{$arrFiltro[1]}</td>
						</tr>
						{/foreach}
						
					</table>
			</td>
        	{/if}
			
			<!-- RESULTADO DEL REPORTE -->
			<td>
				
				<div id="tabView" class="yui-navset" style="width:100%; text-align:left;">
				    <ul class="yui-nav">
			        	<li class="selected"><a href="#tabReportes"><em>Tablas</em></a></li>
			        	{if $txtGraficas neq ""}
			        		<li><a href="#graReportes"><em>Graficas</em></a></li>
			        	{/if}    
				    </ul>            
				    <div class="yui-content">	    
				    	
				    	<!-- TABLAS -->
				        <div id="tabReportes" style="height:412px; overflow:auto">
				        
				        	
				        	<table cellspacing="0" cellpadding="0" border="1" width="100%" align="center">
				        	
				        		<tr>
				        		{foreach from=$arrTablas.titulos item=txtTitulo}
				        			<td class="tituloTabla">{$txtTitulo}</td>
				        		{/foreach}		
				        		</tr>
				        		
				        		
				        		{foreach from=$arrTablas.datos item=arrFila}
				        			<tr>
				        			{foreach from=$arrFila key=i item=dato}
		        						<td align=left class="tituloCampo">{if is_numeric( $dato )}  {$dato|number_format:0:'.':','} {else} {$dato} {/if} </td>
				        			{/foreach}
				        			<tr>
				        		{/foreach}
				        	</table>
				        	{if $txtIdFormulario neq ""}
				        		<!--
					        	<br /><br />
						        	<table>
						        		<tr>
						        			<td>
						        				<a onclick = "someterFormulario( 'mensajes' , document.{$txtIdFormulario} , 
						        					'./contenidos/reportes/ReportesExportables.php?reporte={$txtIdFormulario}' , true , true );" 
						        					href="#">Exportable</a>
						        			</td>
						        		</tr>
						        	</table>
						        	-->
					        {/if}
				        </div>
				        
				        <!-- graficas -->
				        {if $txtGraficas neq ""}
							<div id="graReportes" style="height:412px;">
								<div style="display:none" id="objGraficas">{$txtGraficas}</div>
								<div id="objGraficasBorrar"></div>
							</div>
						{/if}
				    </div>
				</div>
				
			</td>
		
		</tr>
	</table>
	</form>

	<div id="activarTabView"></div>	