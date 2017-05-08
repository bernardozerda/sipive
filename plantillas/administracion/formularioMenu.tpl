
<!--
	
	FORMULARIO PARA LAS OPCIONES DE MENU
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<form style="height: 95%" onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracion/salvarMenu.php', false, true);  return false;" autocomplete=off>

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="3">Formulario de opciones</td></tr>
		</table>
		<br>

		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			
			<!-- ETIQUETA ESPA�OL -->
			<tr>
				<th width="130px" class="tituloCampo">Etiqueta Espa&ntilde;ol</th>
				<td><input name="es" type="text" class="inputLogin" id="es" value="{$objMenu->txtEspanol}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;" /></td>
			</tr>
			
			<!-- ETIQUETA INGLES -->
			<tr>
				<th width="130px" class="tituloCampo">Etiqueta Ingl&eacute;s</th>
				<td><input name="en" type="text" class="inputLogin" id="en" value="{$objMenu->txtIngles}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- ARCHIVO PHP -->
			<tr>
				<th width="130px" class="tituloCampo">C&oacute;digo Fuente</th>
				<td><input name="codigo" class="inputLogin" type="text" id="codigo" value="{$objMenu->txtCodigo}" onBlur="sinCaracteresEspeciales( this );" style="width:170px;" /> .php</td>
			</tr>
			
			<!-- SELECT CON LAS OPCIONES QUE PUEDEN SER PADRE -->
			<tr>
				<th width="130px" class="tituloCampo">Padre del Menu</th>
				<td>
					<select name="padre" id="padre" style="width:200px;" onChange="cargarContenido( 'selectOrden' , '{$arrConfiguracion.carpetas.contenidos}/administracion/recalcularOrden.php' , 'proyecto={$seqProyectoMenu}&padre='+this.options[ this.selectedIndex ].value , true );">
						<option value="0">Es Menu Principal</option>
						{foreach from=$arrMenuPadre key=seqMenu item=objMenuSelect}
							<option value="{$seqMenu}" {if $seqMenu == $objMenu->seqPadre} selected {/if}>{$objMenuSelect->txtEspanol|lower|ucwords}</option>
						{/foreach}
					</select>
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
				<th class="tituloCampo" colspan="2">Asignaci&oacute;n a Grupos</th>
			</tr>
			
			<!-- PARA CADA Proyecto SE MUESTRAN LOS GRUPOS ASOCIADOS -->
			{foreach from=$arrProyecto key=seqProyecto item=objProyecto}
			
				<tr>
					{if $objProyecto->bolActivo != 0}
						<td align="center" widht="10px"><img src="./recursos/imagenes/bullet.jpg" /></td> 
					{else}
						<td align="center" widht="10px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
					{/if}				
					<td>
						{$objProyecto->txtProyecto|lower|ucwords}
					</td>
				</tr>
				<tr><td style="padding:5px; border: 1px dotted #999999" colspan="2">
					<table cellspacing="0" cellpadding="0" border="0" width="100%" id="{$seqProyecto}">			
					
						<!-- MUESTRA LOS GRUPOS ASOCIADOS A LA Proyecto -->
						{foreach from=$objProyecto->arrProyectoGrupo key=seqGrupo item=seqProyectoGrupo}
							<tr><td style="padding-left: 20px;">
								<input type="checkbox" name="proyectoGrupo[{$seqProyecto}][{$seqGrupo}]" value="{$seqProyectoGrupo}" 
								{if isset( $objMenu->arrGrupo.$seqProyecto.$seqGrupo ) } checked {/if} > 
									{$arrGrupo.$seqGrupo->txtNombre|lower|ucwords}
							</td></tr>
						{/foreach}
					</table>
				</td></tr>
			{/foreach}
		</table>
		
		<!-- TABLA CON LOS BOTONES PARA BORRAR O EDITAR/CREAR LA OPCION -->
		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			<tr>
				
				<!-- BOTON BORRAR ONCLICK DISPARA LA VENTANA EMERGENTE DE CONFIRMACION -->
				<td align="right" style="padding-right: 5px;">
					<input name="btnBorrar" type="button" id="btnBorrar" value="Borrar" 
						   onClick="eliminarRegistro( 
						   				'{$seqEditar}#{$seqProyectoMenu}' , 
						   				'Esta a punto de eliminar la opcion <b>{$objMenu->txtEspanol|lower|ucwords}</b>, se requiere confirmacion para realizar esta accion.<br>&iquest;Desea Continuar?' , 
						   				'./contenidos/administracion/borrarMenu.php' ); 
						   		   " 
					/>
					<input type="hidden" name="{$seqEditar}#{$seqProyectoMenu}" id="{$seqEditar}#{$seqProyectoMenu}" value="{$seqEditar}#{$seqProyectoMenu}">
				</td>
				
				<!-- BOTON CREAR MAS LAS VARIABLES OCULTAS PARA EDITAR -->
				<td align="right" style="padding-right: 25px;" width="100px">
					<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
					<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
					<input name="proyecto"   type="hidden" id="proyecto"   value="{$seqProyectoMenu}">
				</td>
			</tr>
		</table>
	</form>
		