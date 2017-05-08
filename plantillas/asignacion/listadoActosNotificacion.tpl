
	<select	
			name="txtActoAdministrativoNotificacion"
			id="txtActoAdministrativoNotificacion"
			style="width:220px"
			onFocus="this.style.backgroundColor = '#ADD8E6';" 
			onBlur="this.style.backgroundColor = '#FFFFFF';" 
			onChange="asignarActoAdministrativoNotificacion( )"
		>
		<option value="0/000-00-00"></option>
		{foreach from=$arrListadoActos key=seqTipoActo item=txtTipoActo}
			<option value="{$txtTipoActo.numActo}/{$txtTipoActo.fchActo}">Resolucion {$txtTipoActo.numActo} - {$txtTipoActo.fchActo}</option>
		{/foreach}
	</select>