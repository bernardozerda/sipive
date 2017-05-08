	
	<!-- IMPRIME LAS CARACTERISTICAS DE LOS ACTOS --> 
	<table cellpadding="1" cellspacing="0" border="0" width="99%">
		{foreach from=$claTipoActo->arrCaracteristicas key=seqCaracteristica item=arrCaracteristica}
			{if $arrCaracteristica.dato == "hidden"}
				<input type="hidden"
					   name="caracteristica[{$seqCaracteristica}]"
					   id="caracteristica[{$seqCaracteristica}]" 
				/>
			{else}
				<tr>
					<td valign="top" width="180px">{$arrCaracteristica.nombre}</td>
					<td valign="top">
						{if $arrCaracteristica.dato == "numero"}
							<input type="text"
								   name="caracteristica[{$seqCaracteristica}]"
								   id="caracteristica[{$seqCaracteristica}]"  
								   value="" 
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this );"
								   style="width:100px"
							/>
						{/if}
						{if $arrCaracteristica.dato == "texto"}
							<input type="text"
								   name="caracteristica[{$seqCaracteristica}]"
								   id="caracteristica[{$seqCaracteristica}]" 
								   value="" 
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
								   style="width:300px"
							/>
						{/if}
						{if $arrCaracteristica.dato == "textarea"}
							<textarea name="caracteristica[{$seqCaracteristica}]"
									  id="caracteristica[{$seqCaracteristica}]" 
								   	  value="" 
								      onFocus="this.style.backgroundColor = '#ADD8E6';" 
								      onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
								      style="width:250px; height:30px"
							></textarea>
						{/if}
						{if $arrCaracteristica.dato == "fecha"}
							<input name="caracteristica[{$seqCaracteristica}]" 
								   id="{$seqCaracteristica}" 
								   value="" 
								   style="width:100px"
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
								   readonly 
							/> <a href="#" onClick="javascript: calendarioPopUp( '{$seqCaracteristica}'); ">Calendario</a> 
						{/if}
					</td>
				</tr>
			{/if}
		{/foreach}
	</table>