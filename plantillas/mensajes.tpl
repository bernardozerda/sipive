	
<!--
	ARCHIVO QUE MUESTRA LA TABLA DE ERRORES (ver funciones.php funcion imprimirMensajes )
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px" class="{$estilo}">
        {foreach from=$arrImprimir item=txtMensaje}
            <tr><td class="{$estilo}"><li>{$txtMensaje}</li></td></tr>
        {/foreach}
    </table>
    
    {if $idDivOculto != ""}
    	<div id="{$idDivOculto}"></div>
    {/if}
    
