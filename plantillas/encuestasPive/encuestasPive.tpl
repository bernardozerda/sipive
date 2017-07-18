<div align="center">

	<!-- Solo el administrador del sistema puede cargar encuestas -->
	{assign var=seqProyectoAplicacion value=$smarty.session.seqProyecto}
	{if isset( $smarty.session.arrGrupos.$seqProyectoAplicacion.20 )}
		<p>
			<fieldset style="width: 90%; border: 1px dotted #999999; padding:10px;">
				<legend><strong> CARGA DE INFORMACIÓN DE LAS ENCUESTAS</strong> </legend>
				<form id="frmEncuestas"
					onSubmit="someterFormulario('mensajes',this,'./contenidos/encuestasPive/salvarEncuestas.php',true,true); return false;">
					<table cellpadding="5">

						<tr>
							<td>Tipo de Cargue</td>
							<td>
								Existente
								<input type="radio" name="cargue"
										 onclick="
											document.getElementById('nombreExistente').style.display='';
											document.getElementById('nombreNuevo').style.display='none';
										 "
										 {if $arrCargues|@count != 0} checked {/if}
								>
								Nuevo
								<input type="radio" name="cargue"
										 onclick="
											document.getElementById('nombreExistente').style.display='none';
											document.getElementById('nombreNuevo').style.display='';
										 "
										 {if $arrCargues|@count == 0} checked {/if}
								>
							</td>
						</tr>

						<tr>
							<td>Nombre del cargue</td>
							<td>
								<div id="nombreExistente" style="display: {if $arrCargues|@count == 0} none {/if}">
									<select name="nombreSelect" style="width: 500px">
										<option value="">Seleccione una opción</option>
										{foreach from=$arrCargues item=txtNombre}
											<option value="{$txtNombre}">{$txtNombre}</option>
										{/foreach}
									</select>
								</div>
								<div id="nombreNuevo" style="display: {if $arrCargues|@count != 0} none {/if}">
									<input type="text" name="nombreInput" value="" placeholder="Nombre del cargue" style="width: 500px">
								</div>
							</td>
						</tr>

						<tr>
							<td>Seleccione la encuesta</td>
							<td>
								<select name="diseno" style="width: 500px">
									<option value="0">Seleccione una opción</option>
									{foreach from=$arrDisenos item=objEncuesta}
										<option value="{$objEncuesta->seqDiseno}">{$objEncuesta->txtDiseno}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Cargue el archivo de formulario</td>
							<td><input type="file" name="formulario"></td>
						</tr>
						<tr>
							<td>Cargue el archivo de ciudadanos</td>
							<td><input type="file" name="ciudadano"></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit"
								name="cargar" value="Cargar Archivos"></td>
						</tr>
					</table>
				</form>
			</fieldset>
		</p>
	{/if}
	<p>
		<fieldset style="width: 90%; border: 1px dotted #999999; padding:10px; padding-bottom:30px;">
			<legend> <strong>CONSULTA DE INFORMACIÓN DE ENCUESTAS </strong></legend>
				<form onsubmit="return false;">
					{assign var=txtFuncion value="someterFormulario('resultado',this.form,'./contenidos/encuestasPive/listarEncuestas.php',true,true);"}
					{include file="subsidios/buscarCedula.tpl"}
				</form>
				<div id="resultado" style="background-color:#E4E4E4;"></div>
		</fieldset>
	</p>
</div>