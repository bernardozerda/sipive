{assign var=txtTutoresMasivaJS 			value=$claAsignacionFormulario->txtTutoresMasivaJS }
{assign var=txtTutoresInformacionJS 	value=$claAsignacionFormulario->txtTutoresInformacionJS }
{assign var=txtDataTableJS 				value=$claAsignacionFormulario->txtHogaresSinAsignarJS }
{assign var=arrCoordinadores 			value=$claAsignacionFormulario->arrCoordinadores }


	
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
				    		{include file="asignacionFormularios/asignacionInformacion.tpl"}
				    	</div>
				    
				    	<div id="tabFormularios" style="height:412px; overflow:auto">
				    		{include file="asignacionFormularios/asignacionFormsUsuarios.tpl"}
				    	</div>
				    	
				    </div>
				    
				  </div>
			</td>
		</tr>
	</table>

	<div id="activarTabView"></div>
	<div id="objArbolFormulariosAsignarListener"></div>