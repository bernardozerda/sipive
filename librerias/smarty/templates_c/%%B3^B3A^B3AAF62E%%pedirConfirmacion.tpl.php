<?php /* Smarty version 2.6.26, created on 2017-05-05 09:17:58
         compiled from proyectos/pedirConfirmacion.tpl */ ?>

	<?php if ($this->_tpl_vars['bolMostrarConfirmacion'] == true): ?>

		<div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
			<div class="hd">Se solicita atención del usuario...</div>
			<div class="bd" style="text-align:center">
			<form method="POST" action="<?php echo $this->_tpl_vars['txtArchivo']; ?>
">
				<p><?php echo $this->_tpl_vars['txtMensaje']; ?>
</p>
				<?php $_from = $this->_tpl_vars['arrPost']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtClave'] => $this->_tpl_vars['arrValor']):
?>
					<?php if (is_array ( $this->_tpl_vars['arrValor'] )): ?>
						<?php $_from = $this->_tpl_vars['arrValor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtNombre'] => $this->_tpl_vars['txtValor']):
?>
							<input type="hidden" name="<?php echo $this->_tpl_vars['txtClave']; ?>
[]" value="<?php echo $this->_tpl_vars['txtValor']; ?>
">
						<?php endforeach; endif; unset($_from); ?>
					<?php else: ?>
						<input type="hidden" name="<?php echo $this->_tpl_vars['txtClave']; ?>
" value="<?php echo $this->_tpl_vars['arrValor']; ?>
">
					<?php endif; ?>
					
				<?php endforeach; endif; unset($_from); ?>
			</form>
			</div>
		</div>

		<div id="dlgPedirConfirmacionListener"></div>
	
	<?php endif; ?>