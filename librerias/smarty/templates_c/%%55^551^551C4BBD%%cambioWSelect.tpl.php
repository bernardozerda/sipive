<?php /* Smarty version 2.6.26, created on 2017-05-05 12:09:11
         compiled from reportes/cambioWSelect.tpl */ ?>

	<?php if ($this->_tpl_vars['txtMostrar'] == 'criterio'): ?>
<!-- CRITERIOS PARA LAS COMPARACIONES -->		
		<select id="wCriterio" 
				style="width:98%;"
				onFocus="this.style.backgroundColor = '#ADD8E6';" 
				onBlur="this.style.backgroundColor = '#FFFFFF';"
		>
			<option value="">Criterio</option>
			<?php $_from = $this->_tpl_vars['arrCriterio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrInformacion']):
?>
				<option value="<?php echo $this->_tpl_vars['arrInformacion']['valor']; ?>
"><?php echo $this->_tpl_vars['arrInformacion']['texto']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select> 
	<?php else: ?>
<!-- VALORES PARA LOS CAMPOS SEGUN EL TIPO DE DATO-->		
		
		<?php if ($this->_tpl_vars['txtTipoDato'] == 'booleano'): ?>
			<select id="wValor"
					onFocus="this.style.backgroundColor = '#ADD8E6';" 
			   		onBlur="this.style.backgroundColor = '#FFFFFF';"
			   		style="width:98%"
			><option value="">Seleccione Valor</option>
			<option value="1">Si</option>
			<option value="0">No</option>
			</select>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['txtTipoDato'] == 'fecha' || $this->_tpl_vars['txtTipoDato'] == 'fechahora'): ?>
			<input type="text" 
				   id="wValor"
				   name="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; esFechaValida( this )" 
				   onClick="this.value=''" 
				   style="width:78%"
				   maxlength="10"
				   readonly
			/> <a href="#" onClick="javascript: calendarioPopUp( 'wValor'); ">Calendario</a>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['txtTipoDato'] == 'numero'): ?>
			<input type="text" 
				   id="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this )" 
				   onClick="this.value=''" 
				   style="width:98%"
			/>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['txtTipoDato'] == 'texto'): ?>
			<input type="text" 
				   id="wValor" 
				   value="Inserte Valor"
				   onFocus="this.style.backgroundColor = '#ADD8E6';" 
				   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this )" 
				   onClick="this.value=''" 
				   style="width:98%"
			/>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['txtTipoDato'] == 'externo'): ?>
			<select id="wValor"
					onFocus="this.style.backgroundColor = '#ADD8E6';" 
			   		onBlur="this.style.backgroundColor = '#FFFFFF';"
			   		style="width:100%"
			><option value="">Seleccione Valor</option>
				<?php $_from = $this->_tpl_vars['arrSeleccion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSeleccion'] => $this->_tpl_vars['txtSeleccion']):
?>
					<option value="<?php echo $this->_tpl_vars['seqSeleccion']; ?>
"><?php echo $this->_tpl_vars['txtSeleccion']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		<?php endif; ?>
	
	<?php endif; ?>

