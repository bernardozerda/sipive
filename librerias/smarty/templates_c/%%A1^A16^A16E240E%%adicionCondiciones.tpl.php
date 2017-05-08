<?php /* Smarty version 2.6.26, created on 2017-05-05 12:09:17
         compiled from reportes/adicionCondiciones.tpl */ ?>
	<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left" 
			onMouseOver="this.style.backgroundColor='#FFA4A4';"
			onMouseOut="this.style.backgroundColor='#F9F9F9'"
			onClick="eliminarObjeto('<?php echo $this->_tpl_vars['txtCondicion']; ?>
')">
	X</div>
	<div style="float:right; width:96%; height:14px; border:1px solid #F9F9F9;">
		<?php echo $this->_tpl_vars['txtCampoSeleccionado']; ?>
 || <?php echo $this->_tpl_vars['txtCriterioSeleccionado']; ?>
 || <?php echo $this->_tpl_vars['txtValorSeleccionado']; ?>
 || <?php echo $this->_tpl_vars['txtCondicionYO']; ?>

	</div>
	<input type="hidden" name="condiciones[<?php echo $this->_tpl_vars['txtCondicion']; ?>
][campo]" value="<?php echo $this->_tpl_vars['wCampo']; ?>
" />
	<input type="hidden" name="condiciones[<?php echo $this->_tpl_vars['txtCondicion']; ?>
][wCriterio]" value="<?php echo $this->_tpl_vars['wCriterio']; ?>
" />
	<input type="hidden" name="condiciones[<?php echo $this->_tpl_vars['txtCondicion']; ?>
][wValor]" value="<?php echo $this->_tpl_vars['wValor']; ?>
" />
	<input type="hidden" name="condiciones[<?php echo $this->_tpl_vars['txtCondicion']; ?>
][wCondicion]" value="<?php echo $this->_tpl_vars['wCondicion']; ?>
" />
	