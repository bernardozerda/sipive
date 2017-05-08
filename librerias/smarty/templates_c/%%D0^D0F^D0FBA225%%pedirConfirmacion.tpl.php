<?php /* Smarty version 2.6.26, created on 2017-05-04 21:27:31
         compiled from subsidios/pedirConfirmacion.tpl */ ?>

	<?php if ($this->_tpl_vars['bolConfirmacion'] == true): ?>

		<div id="dlgPedirConfirmacion" style="visibility: hidden; height: 1px;">
			<div class="hd">Se solicita atención del usuario...</div>
			<div class="bd" style="text-align:center">
			<form method="POST" action="<?php echo $this->_tpl_vars['txtArchivo']; ?>
">
				<p><?php echo $this->_tpl_vars['txtMensaje']; ?>
</p>
            
				<?php if ($this->_tpl_vars['txtArchivo'] == "./contenidos/subsidios/salvarInscripcion.php"): ?>
				
               <?php $_from = $this->_tpl_vars['arrPost']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtClave'] => $this->_tpl_vars['txtValor']):
?>
						<input type="hidden" name="<?php echo $this->_tpl_vars['txtClave']; ?>
" value="<?php echo $this->_tpl_vars['txtValor']; ?>
">
					<?php endforeach; endif; unset($_from); ?>
				
            
            <?php else: ?>
               
					<?php $_from = $this->_tpl_vars['arrPost']['hogar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['numDocumento'] => $this->_tpl_vars['arrCiudadano']):
?>
						<?php $_from = $this->_tpl_vars['arrCiudadano']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtClave'] => $this->_tpl_vars['txtValor']):
?>
							<input type="hidden" name="hogar[<?php echo $this->_tpl_vars['numDocumento']; ?>
][<?php echo $this->_tpl_vars['txtClave']; ?>
]" value="<?php echo $this->_tpl_vars['txtValor']; ?>
">
						<?php endforeach; endif; unset($_from); ?>
					<?php endforeach; endif; unset($_from); ?>
					
					<?php $_from = $this->_tpl_vars['arrPost']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtClave'] => $this->_tpl_vars['txtValor']):
?>
						<?php if ($this->_tpl_vars['txtClave'] != 'hogar'): ?>
							<input type="hidden" name="<?php echo $this->_tpl_vars['txtClave']; ?>
" value="<?php echo $this->_tpl_vars['txtValor']; ?>
">
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
            
			</form>
			</div>
		</div>

		<div id="dlgPedirConfirmacionListener"></div>
	
	<?php endif; ?>