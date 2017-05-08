<?php /* Smarty version 2.6.26, created on 2017-05-04 21:34:17
         compiled from seguimiento/verCambios.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'seguimiento/verCambios.tpl', 5, false),array('modifier', 'count', 'seguimiento/verCambios.tpl', 10, false),)), $this); ?>

<div style='height:<?php echo $this->_tpl_vars['numAlto']; ?>
; overflow:auto;'>		
	<table cellspacing="0" cellspacing="0" border="0" width="100%" style="font-size:7px">
		<?php $_from = $this->_tpl_vars['arrLineas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrItem']):
?>
			<tr> <?php echo smarty_function_cycle(array('name' => 'lineas','values' => "#FFFFFF,#E4E4E4",'assign' => 'color'), $this);?>

				<?php $_from = $this->_tpl_vars['arrItem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['celdas'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['celdas']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['txtValor']):
        $this->_foreach['celdas']['iteration']++;
?>
					<td style="border-right: 1px dotted #999999" 
						bgcolor="<?php echo $this->_tpl_vars['color']; ?>
" 
						valign="top"
						<?php if (count($this->_tpl_vars['arrItem']) == 1): ?> colspan="3" <?php endif; ?>
						<?php if (($this->_foreach['celdas']['iteration'] <= 1)): ?> width="30%" <?php else: ?> width="35%" <?php endif; ?>
					>
						<?php echo $this->_tpl_vars['txtValor']; ?>

					</td>
				<?php endforeach; endif; unset($_from); ?>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
</div>
	




