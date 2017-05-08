<ul>
	{foreach from=$arrActosAsociados key=seqUnidadActo item=arrActo}
		<li><b>Resolución de Indexaci&oacute;n </b>{$arrActo.numActo} de {$arrActo.fchActo}</li>
		<ul style="padding-right:25px; text-align:justify"><b>Descripci&oacute;n: </b>{$arrActo.txtDescripcion}</ul>
		<ul style="padding-right:25px; text-align:justify"><b>Valor Indexado: </b>$ {$arrActo.valIndexado}</ul><br>
	{/foreach}
</ul>