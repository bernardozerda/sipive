	
	<table cellspacing="0" cellpadding="0" border="0" width="100%" >
		
		{if $bolCoordinadorGrupo == 1 }
			<tr bgcolor="#e4e4e4">
				<!--
				<td width="35%" style="padding-left:10px;font-size:10px;font-weight:bold;"  align="left" id="txtNombreTutorDesembolso" >
					{if $seqUsuario == 0 }
						TODOS LOS TUTORES
					{else}
						Tutor: { $arrTutores.$seqUsuario } 
					{/if}
				</td> 
				-->
				<td width="35%" style="padding-left:10px;font-size:10px;font-weight:bold;"  align="left" id="txtNombreTutorDesembolso" >
					TODOS LOS TUTORES
				</td> 
				
				<td style="padding:5px;" >
					<form id="frmSeleccionTutorDesembolso">
						<select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
								onBlur="this.style.backgroundColor = '#FFFFFF';"
								onchange="cargaIndicadoresTutorDesembolso( );"
								id="seqUsuario"
								name="seqUsuario"  
								style="width:400px;"
						>
							<option value="0" {if $seqUsuario == 0 } selected {/if}>TODOS</option>
							{foreach from=$arrTutores key=seqTutorDesembolso item=txtNombreTutor }
								<option value="{$seqTutorDesembolso}" >{$txtNombreTutor}</option>
							{/foreach}
						</select>
					</form>
				</td>
				
			</tr>
		{/if}
		<tr>
			<td colspan="2">
				<div id="divIndicadoresTutorDesembolso">{include file="$txtArchivoIndicadorDesembolso"}</div>
			</td>
		</tr>
	
	</table>