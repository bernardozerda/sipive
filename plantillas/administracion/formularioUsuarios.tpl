
<!--
	
	FORMULARIO PARA LA CREACION DE USUARIOS
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 1.0 Abil de 2009
	@version 1.1 Septiembre de 2009
	
-->
	
	<form onSubmit="
			someterFormulario( 
				'mensajes', 
				this, 
				'./{$arrConfiguracion.carpetas.contenidos}/administracion/salvarUsuarios.php', 
				false, 
				true
			);  return false;" 
		  autocomplete=off
	>

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px" colspan="3">Datos del usuario</td></tr>
	</table>
	<br>
	
	<table cellspacing="0" cellpadding="1" border="0" width="100%">

		<!-- NOMBRE DE PILA DEL USUARIO -->
		<tr>
			<th width="80px" class="tituloCampo">Nombres</th>
			<td colspan="2">
				<input	name="nombre" 
						type="text" 
						id="nombre" 
						value="{$objUsuario->txtNombre}" 
						onBlur="sinCaracteresEspeciales( this );"
						style="width:200px" 
				/>
			</td>
		</tr>

		<!-- APELLIDOS DEL USUARIO -->
		<tr>
			<th class="tituloCampo">Apellidos</th>
			<td colspan="2">
				<input	name="apellido" 
						type="text" 
						id="apellido" 
						value="{$objUsuario->txtApellido}" 
						onBlur="sinCaracteresEspeciales( this );" 
						style="width:200px"
				/>
			</td>
		</tr>
		
		<!-- CORREO ELECTRONICO -->
		<tr>
			<th class="tituloCampo">Correo</th>
			<td colspan="2">
				<input	class="inputLogin" 
						name="correo" 
						type="text" 
						id="correo" 
						value="{$objUsuario->txtCorreo}" 
						onBlur="sinCaracteresEspeciales( this );"
						style="width:250px"
				/>
			</td>
		</tr>
		
		<!-- LOGIN DEL USUARIO -->
		<tr>
			<th class="tituloCampo">Usuario</th>
			<td colspan="2"><input class="inputLogin" name="usuario" type="text" id="usuario" value="{$objUsuario->txtUsuario}" onBlur="sinCaracteresEspeciales( this );" /></td>
		</tr>
		
		<!-- CLAVE -->
		<tr>	
			<th class="tituloCampo">Clave</th>
			<td><input name="clave" class="inputLogin" type="password" id="clave" onKeyUp="passwordChanged( this );"/></td>
			<td id="fortaleza" width="100px">&nbsp;</td> <!-- MUESTRA LA FORTALEZA DE LA CLAVE -->
		</tr>
		
		<!-- CONFIRMACION DE LA CLAVE -->
		<tr>	
			<th class="tituloCampo">Confirmar</th>
			<td><input class="inputLogin" name="confirmaClave" type="password" id="confirmaClave" onKeyUp="encriptarCadena( 'clave' , 'confirmaClave' );" /></td>
			<td id="compararClaves">&nbsp;</td> <!-- MUESTRA SI LAS CLAVES SON IGUALES O NO -->
		</tr>
		
		<tr><td height="5px"></td></tr>
		
	</table>
	<table cellspacing="0" cellpadding="2" border="0" width="100%">
		
		<!-- PRIVILEGIOS -->
		<tr>
			<td class="tituloTabla">Privilegios</td>
		</tr>
		
		<!-- PRIVILEGIOS DE CAMBIO DE INFORMACION -->
		<tr>
			<td align="center">
				<input type="checkbox" name="privilegios[crear]"   id="crear"   value="1" {if $objUsuario->bolCrear   == 1 } checked {/if} >Crear 
				<input type="checkbox" name="privilegios[editar]"  id="editar"  value="1" {if $objUsuario->bolEditar  == 1 } checked {/if} >Editar 
				<input type="checkbox" name="privilegios[borrar]"  id="borrar"  value="1" {if $objUsuario->bolBorrar  == 1 } checked {/if} >Borrar
				 
				<input type="checkbox" name="privilegios[cambiar]" id="cambiar" value="1" {if $objUsuario->bolCambiar == 1 } checked {/if} >Abrir Formularios  
			</td>
		</tr>
		
		<tr><td height="5px"></td></tr>
		
		<!-- VENCIMIENTO DE CLAVE -->
		<tr>
			<td class="tituloTabla">Vencimiento de la clave</td>
		</tr>
		
		<!-- VENCIMIENTO DE LA CLAVE -->
		<tr>
			<td align="center">
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="-30" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./{$arrConfiguracion.carpetas.contenidos}/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						{if $objUsuario->numVencimiento == -30} checked {/if} 
				/> Vencida
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="30" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./{$arrConfiguracion.carpetas.contenidos}/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						{if $objUsuario->numVencimiento == 30} checked {/if} 
				/> 30 Dias 
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="60" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./{$arrConfiguracion.carpetas.contenidos}/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						{if $objUsuario->numVencimiento == 60} checked {/if}
				/> 60 Dias
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="90" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./{$arrConfiguracion.carpetas.contenidos}/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						{if $objUsuario->numVencimiento == 90} checked {/if}
				/> 90 Dias
			</td>	
		</tr>
		
		<tr>
			<td align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
					<tr>
						<td width="150px" align="center">Próximo Vencimiento:</td>
						<td id="proximoVencimiento">
							{if $objUsuario->fchVencimiento}
								{$objUsuario->fchVencimiento}
							{else}
								&nbsp;
							{/if}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<!-- ESTADO -->
		<tr>
			<td class="tituloTabla">Estado del Usuario</td>
		</tr>
		
		<!-- ACTIVO O INACTIVO -->
		<tr>
			<td align="center">
				<input name="estado" type="radio" id="estado" value="1" {if $objUsuario->bolActivo == 1} checked {/if} /> Activo
				<input name="estado" type="radio" id="estado" value="0" {if $objUsuario->bolActivo == 0} checked {/if}/> Inactivo 
			</td>
		</tr>
		
		<tr><td height="5px"></td></tr>
		
	</table>
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%">
	
		<!-- TITULO ASIGNACION A GRUPOS -->
		<tr>
			<td class="tituloTabla" colspan="2">Asignaci&oacute;n a Grupos</td>
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
			<tr>
				<td colspan="2" align="center">
					<table cellspacing="0" cellpadding="1" border="0" width="99%" id="{$seqProyecto}" style="border: 1px dotted #999999">			
					
						<!-- MUESTRA LOS GRUPOS ASOCIADOS A LA Proyecto -->
						{foreach from=$objProyecto->arrProyectoGrupo key=seqGrupo item=seqProyectoGrupo}
							<tr><td style="padding-left: 20px;">
								<input type="checkbox" 
									   name="proyectoGrupo[{$seqProyectoGrupo}]" 
									   value="{$seqProyectoGrupo}" 
										{if isset( $objUsuario->arrGrupos.$seqProyecto.$seqGrupo ) } checked {/if} 
								/> {$arrGrupo.$seqGrupo->txtNombre|lower|ucwords}
							</td></tr>
						{/foreach}
					</table>
				</td>
			</tr>
		{/foreach}
		
		<tr><td height="5px" colspan="2"></td></tr>
		
	</table>

	<!-- TABLA QUE ALOJA EL BOTON DE SUBMIT Y LAS VARIABLES OCULTAS -->
	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
		<tr><td align="right" style="padding-right: 5px;">
			<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
			<input name="seqEditar" type="hidden" id="seqEditar" value="{$seqEditar}">
		</td></tr>
	</table>
		
	</form>

