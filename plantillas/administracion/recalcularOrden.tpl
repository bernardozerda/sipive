
<!--
	CUANDO SE CAMBIA UN PADRE EN EL FORMULARIO DE MENU
	EL ARCHIVO QUE SE EJECUTA CALCULA CUANTAS OPCIONES PODRIA
	TENER COMO HIJOS ESE PADRE, ESTE SELECT MUESTRA ESE NUMERO DE OPCIONES
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<select name="orden" id="orden" style="width:100px;">
		{section name=orden start=1 loop=$numOpciones}
		 	<option value="{$smarty.section.orden.index}" {if $smarty.section.orden.index == $objMenu->numOrden} selected {/if}>
		 		Posicion {$smarty.section.orden.index}
		 	</option>
		{/section}
	</select>

