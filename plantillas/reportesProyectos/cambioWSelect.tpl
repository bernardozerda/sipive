
	{if $txtMostrar == "criterio"}
<!-- CRITERIOS PARA LAS COMPARACIONES -->		
		<select id="wCriterio" 
				style="width:98%;"
				onFocus="this.style.backgroundColor = '#ADD8E6';" 
				onBlur="this.style.backgroundColor = '#FFFFFF';"
		>
			<option value="">Criterio</option>
			{foreach from=$arrCriterio item=arrInformacion }
				<option value="{$arrInformacion.valor}">{$arrInformacion.texto}</option>
			{/foreach}
		</select> 
	{else}
<!-- VALORES PARA LOS CAMPOS SEGUN EL TIPO DE DATO-->		
		
		{if $txtTipoDato == "booleano"}
			<select id="wValor"
					onFocus="this.style.backgroundColor = '#ADD8E6';" 
			   		onBlur="this.style.backgroundColor = '#FFFFFF';"
			   		style="width:98%"
			><option value="">Seleccione Valor</option>
			<option value="1">Si</option>
			<option value="0">No</option>
			</select>
		{/if}
		
		{if $txtTipoDato == "fecha" or $txtTipoDato == "fechahora"}
			<input type="text" 
				   id="wValor"
				   name="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; esFechaValida( this )" 
				   onClick="this.value=''" 
				   style="width:78%"
				   maxlength="10"
				   readonly
			/> <a href="#" onClick="javascript: calendarioPopUp( 'wValor'); ">Calendario</a>
		{/if}
		
		{if $txtTipoDato == "numero"}
			<input type="text" 
				   id="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this )" 
				   onClick="this.value=''" 
				   style="width:98%"
			/>
		{/if}
		
		{if $txtTipoDato == "texto"}
			<input type="text" 
				   id="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this )" 
				   onClick="this.value=''" 
				   style="width:98%"
			/>
		{/if}
		
		{if $txtTipoDato == "externo"}
			<select id="wValor"
					onFocus="this.style.backgroundColor = '#ADD8E6';" 
			   		onBlur="this.style.backgroundColor = '#FFFFFF';"
			   		style="width:100%"
			><option value="">Seleccione Valor</option>
				{foreach from=$arrSeleccion key=seqSeleccion item=txtSeleccion}
					<option value="{$seqSeleccion}">{$txtSeleccion}</option>
				{/foreach}
			</select>
		{/if}
	
	{/if}


