

	<table cellpadding="0" cellspacing="0" width="100%">
		<tr >	
			<td  class="tituloTablaIndicadores" style="padding-top:5px; padding-bottom:5px; " >Grupos a los que pertenece este usuario
				<select name="seqGrupo" id="seqGrupo" 
				onchange="cargarIndicador( this.value );"  
				>
					{foreach from=$arrGruposUsuario key=seqGrupo item=txtGrupo }
						{if $seqGrupo eq 7 or $seqGrupo eq 9}
							<option
							 value="{$seqGrupo}" {if $seqGrupo == $seqGrupoSeleccionado} selected {/if}
							>
								{$txtGrupo}
							</option>
						{/if}
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>	
			<td>
				<!-- <div id="divMuestraIndicadores" > -->
				{include file=$txtContenidoIndicadores}
				<!-- </div> -->
				<div id="divIndicadores"></div>
			</td>
		</tr>
	</table>
