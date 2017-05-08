<?php /* Smarty version 2.6.26, created on 2017-05-04 22:55:02
         compiled from ./administracion/formularioProyectos.tpl */ ?>

<!--
	FORMULARIO DE CREACION DE ProyectoS
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<form onSubmit="someterFormulario( 'mensajes', this, './<?php echo $this->_tpl_vars['arrConfiguracion']['carpetas']['contenidos']; ?>
/administracion/salvarProyecto.php', false, true);  return false;" autocomplete=off>	
	
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr><td class="tituloTabla" height="20px" colspan="2">Formulario de Proyectos</td></tr>
		</table>
		<br>
		<table cellspacing="2" cellpadding="0" border="0" width="100%">
			
			<!-- NOMBRE DE LA Proyecto -->
			<tr>
				<th class="tituloCampo">Nombre Proyecto</th>
				<td><input name="nombre" type="text" id="nombre" value="<?php echo $this->_tpl_vars['objProyecto']->txtProyecto; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<!-- FECHA DE VENCIMIENTO -->
			<tr>
				<th class="tituloCampo">Vencimiento</th>
				<td>
					
					<!-- OBJETO QUE RECIBE LA FECHA QUE SE SELECCIONA EN EL CALENDARIO -->
					<input name="vencimiento" type="text" id="vencimiento" value="<?php echo $this->_tpl_vars['objProyecto']->fchVencimiento; ?>
" readonly /> 
					
					<!-- MUESTRA EL OBJETO CALENDARIO -->
					<a href="#" onClick="javascript: calendarioPopUp( 'vencimiento' ); ">Calendario</a>
	    			
				</td>
			</tr>
			
			<!-- ESTADO: ACTIVO O INACTIVO -->
			<tr>
				<th class="tituloCampo">Estado</th>
				<td>
					Activo <input name="estado" type="radio" id="estado" value="1" <?php if ($this->_tpl_vars['objProyecto']->bolActivo == 1): ?> checked <?php endif; ?> /> 
					Inactivo <input name="estado" type="radio" id="estado" value="0" <?php if ($this->_tpl_vars['objProyecto']->bolActivo == 0): ?> checked <?php endif; ?>/> 
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
						<?php $_from = $this->_tpl_vars['arrMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqMenu'] => $this->_tpl_vars['arrOpcion']):
?>
							<option value="<?php echo $this->_tpl_vars['seqMenu']; ?>
" <?php if ($this->_tpl_vars['objProyecto']->seqMenu == $this->_tpl_vars['seqMenu']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['arrOpcion']->txtEspanol; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>
			
		</table>	
	
		
		<!-- BOTON DE SALVAR / EDITAR -->
		<table cellspacing="2" cellpadding="0" border="0" width="100%">	
			<tr><td align="right" style="padding-top: 5px; padding-right: 25px;">
				<input name="btnSalvar" type="submit" id="btnSalvar" value="Guardar" />
				<input name="seqEditar" type="hidden" id="seqEditar" value="<?php echo $this->_tpl_vars['seqEditar']; ?>
">
			</td></tr>
		</table>
	</form>

	