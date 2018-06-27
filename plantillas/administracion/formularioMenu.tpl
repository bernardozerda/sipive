
<!--
	
	FORMULARIO PARA LAS OPCIONES DE MENU
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISEÑO
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<form style="height: 95%"
		  onSubmit="someterFormulario( 'mensajes', this, './contenidos/administracion/salvarMenu.php', false, true);  return false;"
	>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="3">Formulario de opciones</td></tr>
		</table>
		<br>

		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			
			<!-- ETIQUETA ESPAÑOL -->
			<tr>
				<th width="130px" class="tituloCampo">Etiqueta</th>
				<td><input name="es" type="text" class="inputLogin" id="es" value="{$claMenu->txtEspanol}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;" /></td>
			</tr>

			<!-- ARCHIVO PHP -->
			<tr>
				<th width="130px" class="tituloCampo">C&oacute;digo Fuente</th>
				<td><input name="codigo" class="inputLogin" type="text" id="codigo" value="{$claMenu->txtCodigo}" style="width:200px;" /></td>
			</tr>
			
			<!-- SELECT CON LAS OPCIONES QUE PUEDEN SER PADRE -->
			<tr>
				<th width="130px" class="tituloCampo">Menu Padre</th>
				<td>
					{$claMenu->imprimirSelectMenu($seqProyecto)}
				</td>
			</tr>
			
			<!-- EN QUE ORDEN SE COLOCARA LA OPCION -->
			<tr>
				<th width="130px" class="tituloCampo">Orden del menu</th>
				<td id="selectOrden">
					{include file="administracion/recalcularOrden.tpl"}
				</td>
			</tr>
		</table>
		<br>
		 
		<table cellspacing="3" cellpadding="0" border="0" width="98%">	
			
			<tr>
				<th class="tituloCampo" colspan="2" style="padding-bottom: 5px;">Asignaci&oacute;n a Grupos</th>
			</tr>
			
			<!-- PARA CADA Proyecto SE MUESTRAN LOS GRUPOS ASOCIADOS -->
			{foreach from=$arrProyecto key=seqPry item=objProyecto}
				{if $seqPry == $seqProyecto}
					<tr>
						{if $objProyecto->bolActivo != 0}
							<td align="center" widht="10px"><img src="./recursos/imagenes/bullet.jpg" /></td>
						{else}
							<td align="center" widht="10px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
						{/if}
						<td>
							{$objProyecto->txtProyecto}
						</td>
					</tr>
					<tr><td style="padding:5px; border: 1px dotted #999999" colspan="2">
						<table cellspacing="0" cellpadding="0" border="0" width="100%" id="{$seqPry}">

							<!-- MUESTRA LOS GRUPOS ASOCIADOS A LA Proyecto -->
							{foreach from=$objProyecto->arrProyectoGrupo key=seqGrupo item=seqProyectoGrupo}
								<tr><td style="padding-left: 20px;">
									<input type="checkbox" name="proyectoGrupo[{$seqPry}][{$seqGrupo}]" value="{$seqProyectoGrupo}"
									{if isset( $claMenu->arrGrupo.$seqPry.$seqGrupo ) } checked {/if} >
										{$arrGrupo.$seqGrupo->txtNombre}
								</td></tr>
							{/foreach}
						</table>
					</td></tr>
				{/if}
			{/foreach}
		</table>
		
		<!-- TABLA CON LOS BOTONES PARA BORRAR O EDITAR/CREAR LA OPCION -->
		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			<tr>
				
				<!-- BOTON BORRAR ONCLICK DISPARA LA VENTANA EMERGENTE DE CONFIRMACION -->
				<td align="right" style="padding-right: 5px;">
					<input name="btnBorrar" type="button" id="btnBorrar" value="Borrar" 
						   onClick="eliminarRegistro( 
						   				'{$seqEditar}#{$seqProyecto}' ,
						   				'Esta a punto de eliminar la opcion <b>{$claMenu->txtEspanol|lower|ucwords}</b>, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?' , 
						   				'./contenidos/administracion/borrarMenu.php' ); 
						   		   " 
					/>
					<input type="hidden" name="{$seqEditar}#{$seqProyecto}" id="{$seqEditar}#{$seqProyecto}" value="{$seqEditar}#{$seqProyecto}">
				</td>
				
				<!-- BOTON CREAR MAS LAS VARIABLES OCULTAS PARA EDITAR -->
				<td align="right" style="padding-right: 25px;" width="100px">
					<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
					<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
					<input name="proyecto"   type="hidden" id="proyecto"   value="{$seqProyecto}">
				</td>
			</tr>
		</table>
	</form>
		