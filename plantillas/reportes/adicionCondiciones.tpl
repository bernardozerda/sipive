	<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left" 
			onMouseOver="this.style.backgroundColor='#FFA4A4';"
			onMouseOut="this.style.backgroundColor='#F9F9F9'"
			onClick="eliminarObjeto('{$txtCondicion}')">
	X</div>
	<div style="float:right; width:96%; height:14px; border:1px solid #F9F9F9;">
		{$txtCampoSeleccionado} || {$txtCriterioSeleccionado} || {$txtValorSeleccionado} || {$txtCondicionYO}
	</div>
	<input type="hidden" name="condiciones[{$txtCondicion}][campo]" value="{$wCampo}" />
	<input type="hidden" name="condiciones[{$txtCondicion}][wCriterio]" value="{$wCriterio}" />
	<input type="hidden" name="condiciones[{$txtCondicion}][wValor]" value="{$wValor}" />
	<input type="hidden" name="condiciones[{$txtCondicion}][wCondicion]" value="{$wCondicion}" />
	