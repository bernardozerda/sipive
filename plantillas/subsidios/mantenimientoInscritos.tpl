

	<table cellspacing="5" cellpadding="0" border="0" width="100%">
	
		<tr>
		
			<td width="280px" style="border: 1px dotted #ccc" valign="top">
				<p class="tituloTablaIndicadores" style="height:30px; vertical-align:middle;">
					Los siguientes parametros seran usados para el proceso de mantenimiento:
				</p>
				<ul>
					<li>
						<strong>Salario minimo:</strong> 
						<ul><li>$ {$valSalarioMinimo|number_format:0:',':'.'}</li></ul>
					</li>
					{foreach from=$arrModalidad key=seqModalidad item=arrSoluciones}
						<li>
							<strong>{$arrSoluciones.nombre}</strong>
							<ul>
								{foreach from=$arrSoluciones.soluciones key=seqSolucion item=arrValores}
									{if $arrValores.nombre|lower != "ninguna" && $arrValores.nombre|lower != "" }
										<li>
											<strong>{$arrValores.nombre}</strong>
											<ul>
											<li>Subsidio: $ {$arrValores.valor|number_format:0:',':'.'}</li>
											<li>Cierre: $ {$arrValores.cierre|number_format:0:',':'.'}</li>
											</ul>
										</li>
									{/if}
								{/foreach}
							</ul>
						</li>	
					{/foreach}
				</ul>
			</td>
			<td valign="top">
				<p class="tituloTablaIndicadores" style="height:30px; vertical-align:middle;">
					Cantidad de Registros por modalidad en el estado de Inscrito - Inscrito:
				</p>
				
				<p class="tituloTabla" style="height:30px; vertical-align:middle;">
					Marque las casillas para aplicar el mantenimiento solo a las 
					modalidades seleccionadas
				</p>
				
				<form id="frmMantenimiento" onSubmit="return false;">
					{foreach from=$arrInscritos key=seqModalidad item=arrDatos}
						<strong><input type="checkbox" name="{$seqModalidad}"> {$arrDatos.nombre}:</strong> {$arrDatos.inscritos|number_format:0:',':'.'}<br>
					{/foreach}
				</form>
				
				<p>
					<button onClick="someterFormulario( 'resultado' , 'frmMantenimiento' , './contenidos/subsidios/ejecutarMantenimientoInscritos.php' , false , true );">
						Ejecutar Mantenimiento
					</button>
				</p>
				
				<div id="resultado" style="height:350px; width:100%; border: 1px dotted #CCC; padding:10px; overflow: auto;">
					
				</div>
				
				
			</td>
		</tr>
	
	</table>
