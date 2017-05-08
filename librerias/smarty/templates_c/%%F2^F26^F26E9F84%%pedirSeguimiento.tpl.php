<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:05
         compiled from proyectos/pedirSeguimiento.tpl */ ?>

	<!-- TABLA QUE MUESTRA LAS CATEGORIAS DE SEGUIMIENTO -->
	
	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		<tr>
			<td width="120px" class="tituloTabla">Grupo de Gestión</td>
			<td width="250px">
				<select name="seqGrupoGestion" 
						id="seqGrupoGestion" 
						style="width:250px"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			onBlur="this.style.backgroundColor = '#FFFFFF';"
						onChange="obtenerGestionProyectos( this , 'tdGestion' , 'seqGestion' );">
				>
					<option value="0">Seleccione Grupo</option>
					<?php $_from = $this->_tpl_vars['arrGrupoGestion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqGrupoGestion'] => $this->_tpl_vars['txtGrupoGestion']):
?>
						<option value="<?php echo $this->_tpl_vars['seqGrupoGestion']; ?>
"><?php echo $this->_tpl_vars['txtGrupoGestion']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
			<td rowspan="2" align="center">
				<textarea rows="2" 
						  cols="5" 
						  id="txtComentario" 
						  name="txtComentario" 
						  style="width:95%"
						  onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			  onBlur="this.style.backgroundColor = '#FFFFFF';"
				></textarea>
			</td>
		</tr>
		<tr>
			<td  class="tituloTabla">Gestión</td>
			<td id="tdGestion">
				<select name="seqGestion" 
						id="seqGestion" 
						style="width:250px"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
			  			onBlur="this.style.backgroundColor = '#FFFFFF';"
				>
					<option value="0">Seleccione Gesti&oacute;n</select>
				</select>
			</td>
		</tr>
	</table>