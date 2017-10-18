<div style="overflow: auto; height:400px;">
	{foreach from=$arrAplicaciones key="i" item="arrAplicacion"}	
		<p>
		<table cellpadding="5" style="width: 90%; border: 1px dotted #999999; padding:5px;">
				<tr>
					<td class="tituloTabla" width="10%">Diseño Aplicado</td>
					<td>
						{$arrAplicacion.txtDiseno}
					</td>
					<td rowspan="2" width="10%">
						<form onSubmit="return false;" id="Exportar{$arrAplicacion.seqAplicacion}">
							{if $arrAplicacion.bolActiva == 0}
								<div style="background-color: red; font-size: 9px; color: white; font-weight: bold; width:70px; height: 12px; text-align: center;">
									INACTIVA
								</div>
							{else}
								<div style="background-color: green; font-size: 9px; color: white; font-weight: bold; width:70px; height: 12px; text-align: center;">
									ACTIVA
								</div>
							{/if}
							
							<button onclick="someterFormulario('mensajes', this.form, './contenidos/encuestasPive/exportarEncuesta.php', true, false);" style="width:70px;">
								<img src="../../recursos/imagenes/word.png" width="25px" height="25px"><br>
								<span style="font-size: 10px; font-weight: bold;">Exportar<br>Respuestas</span>
							</button>
							<input type="hidden" name="seqAplicacion" value="{$arrAplicacion.seqAplicacion}">
						</form>
					</td>
					<td rowspan="2" align="center" width="10%">
						{if false}
							<form onSubmit="return false;">
								<div style="background-color: black; font-size: 9px; color: white; font-weight: bold; width:70px; height: 12px; text-align: center;">
									&nbsp;
								</div>
								<button onclick="pedirConfirmacion('mensajes', this.form,'./contenidos/encuestasPive/eliminarEncuestas.php');" style="width:70px;">
									<img src="../../recursos/imagenes/error.png" width="25px" height="25px"><br>
									<span style="font-size: 10px; font-weight: bold;">Eliminar<br>Aplicación</span>
								</button>
								<input type="hidden" name="seqAplicacion" value="{$arrAplicacion.seqAplicacion}">
							</form>
						{/if}
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<strong>Número del formulario de encuesta:</strong> {$arrAplicacion.txtFormulario}<br>
						<strong>Nombre del cargue:</strong> {$arrAplicacion.txtNombreCargue}<br>
						<strong>Fecha de aplicación:</strong> {$arrAplicacion.fchAplicacion}<br>
						<strong>Fecha de carga:</strong> {$arrAplicacion.fchCarga}
					</td>
				</tr>
		</table>
		</p>
	{/foreach}	
</div>

