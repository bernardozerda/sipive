
<!--
	
	FORMULARIO DE CREACION DE GRUPOS	

	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->


<form style="height: 95%" onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracion/salvarGrupos.php', false, true);  return false;" autocomplete=off>

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Grupos</td></tr>
	</table>
	<br>

	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
	
		<!-- NOMBRE DEL GRUPO -->
		<tr>
			<th class="tituloCampo">Nombre Grupo</th>
			<td>
				<input name="nombre" 
					   type="text" 
					   id="nombre" 
					   value="{$objGrupo->txtNombre}" 
					   onBlur="sinCaracteresEspeciales( this );"
					   style="width:200px;" 
				/>
			</td>
		</tr>
		
		<!-- DESCRIPCION DEL GRUPO -->
		<tr>
			<th class="tituloCampo">Descripci&oacute;n</th>
			<td>
				<input name="descripcion" 
					   type="text" 
					   id="descripcion" 
					   value="{$objGrupo->txtDescripcion}" 
					   onBlur="sinCaracteresEspeciales( this );"
					   style="width:200px;" 
				/>
			</td>
		</tr>
	</table>
	<br>
	<table cellspacing="2" cellpadding="0" border="0" width="100%" style="border-top: 1px dotted #999999; border-bottom: 1px dotted #999999;">	
		
		<tr>
			<th class="tituloCampo" colspan="3">Asociaci&oacute;n con Proyectos</th>
		</tr>
		
		<!-- ProyectoS CREADAS EN EL APLICATIVO PARA ASOCIAR EL GRUPO A ESTAS ProyectoS -->
		{foreach from=$arrProyectos key=seqProyecto item=objProyecto}
			<tr bgcolor="{cycle values="#FFFFFF,#F4F4F4"}">
				{if $objProyecto->bolActivo != 0}
					<td align="center" widht="10px"><img src="./recursos/imagenes/bullet.jpg" /></td> 
				{else}
					<td align="center" widht="10px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
				{/if}
				<td width="200px" style="padding-left:15px">{$objProyecto->txtProyecto|lower|ucwords}</td>
				<td><input type="checkbox" name="proyecto[{$seqProyecto}]" value="{$objProyecto->txtProyecto}" {if isset( $objGrupo->arrProyectos.$seqProyecto ) } checked {/if} ></td>
			</tr> 
		{/foreach}
		
	</table>
	<br>
	
	<!-- TABLA PARA EL BOTON DE ENVIAR LOS DATOS -->
	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
		<tr><td align="right" style="padding-right: 25px;">
			<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
			<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
		</td></tr>
	</table>
	
</form>