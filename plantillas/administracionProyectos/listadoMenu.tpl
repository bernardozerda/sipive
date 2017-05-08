
<!--
	
	LISTADO PARA LAS OPCIONES DE MENU
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->


<center>

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px">{$txtTitulo}</td></tr>
	</table>
	<br>		
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td style="padding-left:5px">
		
			<!--  SELECT DE PROYECTOS AUTORIZADOS -->
			<b>Proyecto:<b> <select name="proyectoArbol" id="proyectoArbol" style="width:200px">
				{foreach from=$arrProyecto key=seqProyecto item=objProyecto}
					<option value="{$seqProyecto}" {if $seqProyectoPost == $seqProyecto} selected {/if} >{$objProyecto->txtProyecto}</option>
				{/foreach}
			</select>
		</td></tr>
		
		<tr><td style="padding-left:5px">
			<div id="arbolMenu"></div>         <!-- OBJETO QUE ALIJARA EL ARBOL -->
			<div id="listenerArbolMenu"></div> <!-- OBJETO QUE DISPARA EL LISTENER QUE INSTANCIA EL ARBOL (buscar listenerArbolMenu en listener.js) -->		
		</td></tr>
		
	</table>
</center>