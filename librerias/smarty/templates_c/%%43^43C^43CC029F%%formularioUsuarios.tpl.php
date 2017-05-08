<?php /* Smarty version 2.6.26, created on 2017-05-04 22:55:04
         compiled from administracion/formularioUsuarios.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'administracion/formularioUsuarios.tpl', 230, false),array('modifier', 'ucwords', 'administracion/formularioUsuarios.tpl', 230, false),)), $this); ?>

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
				'./<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/salvarUsuarios.php', 
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
						value="<?php echo $this->_tpl_vars['objUsuario']->txtNombre; ?>
" 
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
						value="<?php echo $this->_tpl_vars['objUsuario']->txtApellido; ?>
" 
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
						value="<?php echo $this->_tpl_vars['objUsuario']->txtCorreo; ?>
" 
						onBlur="sinCaracteresEspeciales( this );"
						style="width:250px"
				/>
			</td>
		</tr>
		
		<!-- LOGIN DEL USUARIO -->
		<tr>
			<th class="tituloCampo">Usuario</th>
			<td colspan="2"><input class="inputLogin" name="usuario" type="text" id="usuario" value="<?php echo $this->_tpl_vars['objUsuario']->txtUsuario; ?>
" onBlur="sinCaracteresEspeciales( this );" /></td>
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
				<input type="checkbox" name="privilegios[crear]"   id="crear"   value="1" <?php if ($this->_tpl_vars['objUsuario']->bolCrear == 1): ?> checked <?php endif; ?> >Crear 
				<input type="checkbox" name="privilegios[editar]"  id="editar"  value="1" <?php if ($this->_tpl_vars['objUsuario']->bolEditar == 1): ?> checked <?php endif; ?> >Editar 
				<input type="checkbox" name="privilegios[borrar]"  id="borrar"  value="1" <?php if ($this->_tpl_vars['objUsuario']->bolBorrar == 1): ?> checked <?php endif; ?> >Borrar
				 
				<input type="checkbox" name="privilegios[cambiar]" id="cambiar" value="1" <?php if ($this->_tpl_vars['objUsuario']->bolCambiar == 1): ?> checked <?php endif; ?> >Abrir Formularios  
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
								'./<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						<?php if ($this->_tpl_vars['objUsuario']->numVencimiento == -30): ?> checked <?php endif; ?> 
				/> Vencida
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="30" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						<?php if ($this->_tpl_vars['objUsuario']->numVencimiento == 30): ?> checked <?php endif; ?> 
				/> 30 Dias 
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="60" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						<?php if ($this->_tpl_vars['objUsuario']->numVencimiento == 60): ?> checked <?php endif; ?>
				/> 60 Dias
				<input	name="vencimiento" 
						type="radio" 
						id="vencimiento" 
						value="90" 
						onClick="
							cargarContenido( 
								'proximoVencimiento' , 
								'./<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/proximoVencimiento.php' , 
								'numDias=' + this.value , 
								true 
							);" 
						<?php if ($this->_tpl_vars['objUsuario']->numVencimiento == 90): ?> checked <?php endif; ?>
				/> 90 Dias
			</td>	
		</tr>
		
		<tr>
			<td align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
					<tr>
						<td width="150px" align="center">Próximo Vencimiento:</td>
						<td id="proximoVencimiento">
							<?php if ($this->_tpl_vars['objUsuario']->fchVencimiento): ?>
								<?php echo $this->_tpl_vars['objUsuario']->fchVencimiento; ?>

							<?php else: ?>
								&nbsp;
							<?php endif; ?>
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
				<input name="estado" type="radio" id="estado" value="1" <?php if ($this->_tpl_vars['objUsuario']->bolActivo == 1): ?> checked <?php endif; ?> /> Activo
				<input name="estado" type="radio" id="estado" value="0" <?php if ($this->_tpl_vars['objUsuario']->bolActivo == 0): ?> checked <?php endif; ?>/> Inactivo 
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
		<?php $_from = $this->_tpl_vars['arrProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyecto'] => $this->_tpl_vars['objProyecto']):
?>
			<tr>
				<?php if ($this->_tpl_vars['objProyecto']->bolActivo != 0): ?>
					<td align="center" widht="10px"><img src="./recursos/imagenes/bullet.jpg" /></td> 
				<?php else: ?>
					<td align="center" widht="10px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
				<?php endif; ?>				
				<td>
					<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['objProyecto']->txtProyecto)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>

				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<table cellspacing="0" cellpadding="1" border="0" width="99%" id="<?php echo $this->_tpl_vars['seqProyecto']; ?>
" style="border: 1px dotted #999999">			
					
						<!-- MUESTRA LOS GRUPOS ASOCIADOS A LA Proyecto -->
						<?php $_from = $this->_tpl_vars['objProyecto']->arrProyectoGrupo; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqGrupo'] => $this->_tpl_vars['seqProyectoGrupo']):
?>
							<tr><td style="padding-left: 20px;">
								<input type="checkbox" 
									   name="proyectoGrupo[<?php echo $this->_tpl_vars['seqProyectoGrupo']; ?>
]" 
									   value="<?php echo $this->_tpl_vars['seqProyectoGrupo']; ?>
" 
										<?php if (isset ( $this->_tpl_vars['objUsuario']->arrGrupos[$this->_tpl_vars['seqProyecto']][$this->_tpl_vars['seqGrupo']] )): ?> checked <?php endif; ?> 
								/> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrGrupo'][$this->_tpl_vars['seqGrupo']]->txtNombre)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>

							</td></tr>
						<?php endforeach; endif; unset($_from); ?>
					</table>
				</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		
		<tr><td height="5px" colspan="2"></td></tr>
		
	</table>

	<!-- TABLA QUE ALOJA EL BOTON DE SUBMIT Y LAS VARIABLES OCULTAS -->
	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
		<tr><td align="right" style="padding-right: 5px;">
			<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
			<input name="seqEditar" type="hidden" id="seqEditar" value="<?php echo $this->_tpl_vars['seqEditar']; ?>
">
		</td></tr>
	</table>
		
	</form>
