<div align="center">

	<!-- Solo el administrador del sistema puede cargar encuestas -->
	{assign var=seqProyectoAplicacion value=$smarty.session.seqProyecto}
	{if isset( $smarty.session.arrGrupos.$seqProyectoAplicacion.20 ) or isset($smarty.session.arrGrupos.$seqProyectoAplicacion.37)}
		<p>
			<fieldset style="width: 90%; border: 1px dotted #999999; padding:10px;">
				<legend>
					<strong>CARGA DE INFORMACIÓN DE LAS ENCUESTAS</strong>
				</legend>
				<p style="width: 100%" class="msgVerde">Cargue las aplicaciones de las encuestas realizadas a los hogares</p>
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
							<td colspan="2" align="center">
								<input type="submit" name="cargar" value="Cargar Archivos">
							</td>
						</tr>
					</table>
				</form>
			</fieldset>
		</p>
	{/if}
	<p>
		<fieldset style="width: 90%; border: 1px dotted #999999; padding:10px; padding-bottom:30px;">
			<legend> <strong>EXPORTAR ARCHIVOS PLANOS DE LAS ENCUESTAS</strong></legend>
			<p style="width: 100%" class="msgVerde">
				Obtenga el archivo plano de las aplicaciones de las encuestas previamente cargadas,
				es un archivo plano con las respuestas dadas por los hogares.<br>
				<span class="msgError">Este archivo no es el archivo que se usa para los cruces, para obtenerlo vaya a Exportables -> Encuestas PIVE (para cruces)</span>
			</p>
			<form onsubmit="return false;">
				<table cellpadding="3" cellspacing="0" border="0" width="95%">
					<tr>
						<td width="150px">
							<strong>Seleccione la encuesta</strong>
						</td>
						<td>
							<span id="planoDiseno"
								  onMouseOver="mostrarTooltip('planoDiseno','Seleccione el diseño que fue aplicado al hogar')"
							>
								<img src="./recursos/imagenes/ayuda.png" width="20px" height="20px">
							</span>
						</td>
						<td colspan="2">
							<select name="diseno" style="width: 350px">
								<option value="0">Seleccione una opción</option>
                                {foreach from=$arrDisenos item=objEncuesta}
									<option value="{$objEncuesta->seqDiseno}">{$objEncuesta->txtDiseno}</option>
                                {/foreach}
							</select>
						</td>
						<td rowspan="2">
							<button onclick="someterFormulario('mensajes', this.form, './contenidos/encuestasPive/listarEncuestas.php', true, false);" style="width:70px;">
								<img src="recursos/imagenes/inscrito.gif" width="25px" height="25px"><br>
								<span style="font-size: 10px; font-weight: bold;">Exportar<br>Respuestas</span>
							</button>
						</td>
					</tr>
					<tr>
						<td><strong>Listado de documentos</strong></td>
						<td>
							<span id="planoEncuesta"
								  onMouseOver="mostrarTooltip('planoEncuesta','Cargue un archivo de texto plano separado por tabulaciones y sin titulos con los numeros de documento')"
							>
								<img src="./recursos/imagenes/ayuda.png" width="20px" height="20px">
							</span>
						</td>
						<td style="vertical-align: middle" width="260px">
							<input type="file" name="documentos">
						</td>

					</tr>
				</table>
			</form>
		</fieldset>
	</p>

	<p>
		<fieldset style="width: 90%; border: 1px dotted #999999; padding:10px; padding-bottom:30px;">
			<legend> <strong>EXPORTAR FORMATO WORD DE LAS ENCUESTAS</strong></legend>
			<p style="width: 100%" class="msgVerde">
				Consulte los resultados dados por un hogar (en word) para todas las aplicaciones que se hayan realizado para un hogar
			</p>
				<form onsubmit="return false;">
					{assign var=txtFuncion value="someterFormulario('resultado',this.form,'./contenidos/encuestasPive/listarEncuestas.php',true,true);"}
					{include file="subsidios/buscarCedula.tpl"}
				</form>
				<div id="resultado" style="background-color:#E4E4E4;"></div>
		</fieldset>
	</p>
</div>