	<!-- ESTA PLANTILLA ES LA ESTRUCTURA
	DE TODOS LOS ADMINISTRADORES, LAS proyectoS
	LOS GRUPOS, LOS USUARIOS Y LOS MENU
	TENDRAN ESTA MISMA PLANTILLA EN COMUN
	-->

	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
		<tr>
		
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php O EL QUE SEA CARGADO USANDO EL menuLateral.tpl -->
			<td id="listado" align="left" width="300px" valign="top" style="border-right: 1px dotted #999999;">
				{include file="$txtListado"}
			</td>
			
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php O EL QUE SEA CARGADO USANDO EL menuLateral.tpl -->
			<td id="formulario" align="left" valign="top">
				{include file="$txtFormulario"}
			</td>
			
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php -->
			<td id="menu" width="100px" align="left" valign="top" style="border-left: 1px dotted #999999">
				{include file="$txtMenu"}
			</td>
		</tr>
	</table>