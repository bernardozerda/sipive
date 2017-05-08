{assign var=txtTutoresMasivaJS 			value=$claCrm->txtTutoresMasivaJS }
{assign var=txtTutoresInformacionJS 	value=$claCrm->txtTutoresInformacionJS }
{assign var=txtDataTableJS 				value=$claCrm->txtHogaresSinAsignarJS }
{assign var=arrCoordinadores 			value=$claCrm->arrCoordinadores }


	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td>
				<div id="tabView" class="yui-navset" style="width:100%; text-align:left;">
					<ul class="yui-nav">
						<li class="selected"><a href="#tabInformacion"><em>Asignacion Formularios Informacion</em></a></li>
						<li><a href="#tabFormularios"><em>Asignacion Formularios</em></a></li>
				    </ul>  
				    
				    <div class="yui-content">
				    
				    	<div id="tabInformacion" style="height:412px; overflow:auto">
				    		{include file="crm/asignacionInformacion.tpl"}
				    	</div>
				    
				    	<div id="tabFormularios" style="height:412px; overflow:auto">
				    		{include file="crm/asignacionFormsUsuarios.tpl"}
				    	</div>
				    	
				    </div>
				    
				  </div>
			</td>
		</tr>
	</table>

	<div id="txtDivAsignacionFormularios" style="display:none">
		{$txtTutoresInformacionJS}
		{$txtTutoresMasivaJS} 
	</div>
	<div id="activarTabView"></div>
	<div id="objArbolFormulariosAsignarListener"></div>
	