
<!--
	FORMULARIO DE CREACION DE ProyectoS
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './{$arrConfiguracion.carpetas.contenidos}/administracion/salvarProyecto.php', false, true);  return false;" autocomplete=off>	
	
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Proyectos</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">
			
			<!-- NOMBRE DE LA Proyecto -->
			<tr>
				<th class="tituloCampo">Nombre Proyecto</th>
				<td><input name="nombre" type="text" id="nombre" value="{$objProyecto->txtProyecto}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- FECHA DE VENCIMIENTO -->
			<tr>
				<th class="tituloCampo">Vencimiento</th>
				<td>
					
					<!-- OBJETO QUE RECIBE LA FECHA QUE SE SELECCIONA EN EL CALENDARIO -->
					<input name="vencimiento" type="text" id="vencimiento" value="{$objProyecto->fchVencimiento}" readonly /> 
					
					<!-- MUESTRA EL OBJETO CALENDARIO -->
					<a href="#" onClick="javascript: calendarioPopUp( 'vencimiento' ); ">Calendario</a>
	    			
				</td>
			</tr>
			
			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr>
				<th class="tituloCampo">Estado</th>
				<td>
					Activo <input name="estado" type="radio" id="estado" value="1" {if $objProyecto->bolActivo == 1} checked {/if} /> 
					Inactivo <input name="estado" type="radio" id="estado" value="0" {if $objProyecto->bolActivo == 0} checked {/if}/> 
				</td>
			</tr>
			
			<!-- OPCION QUE SE MUESTRA POR DEFECTO AL ENTRAR -->
			<tr>
				<th class="tituloCampo">Opción por defecto</th>
				<td>
					<select name="seqMenu"
							id="seqMenu"
							style="width:200px"
					><option value="0">Seleccione una opción</option>
						{foreach from=$arrMenu key=seqMenu item=arrOpcion}
							<option value="{$seqMenu}" {if $objProyecto->seqMenu == $seqMenu} selected {/if}>{$arrOpcion->txtEspanol}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			
		</table>	
	
		
		<!-- BOTON DE SALVAR / EDITAR -->
		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			<tr><td align="right" style="padding-top: 5px; padding-right: 25px;">
				<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
				<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
			</td></tr>
		</table>
	</form>

	