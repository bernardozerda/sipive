<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaResoluciones.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConsultaResoluciones.tpl', 11, false),)), $this); ?>
<table border="0" width="100%" id="tablaFormularioRes">
	<tr><td class="tituloTabla" colspan="5">RESOLUCIONES DEL PROYECTO</td></tr>
	<tr class="tituloTabla">
		<th align="center" width="10%" style="padding:6px;">Resoluci&oacute;n</th>
		<th align="center" width="15%" style="padding:6px;">Fecha</th>
		<th align="center" width="65%" style="padding:6px;">Resuelve</th>
	</tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
	<?php $this->assign('num', '0'); ?>
	<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

	<?php $_from = $this->_tpl_vars['arrResolucionProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqResolucionProyecto'] => $this->_tpl_vars['arrResolucion']):
?>
		<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
		<?php else: ?> <tr class="fila_1">
		<?php endif; ?>
			<td align="center" style="padding:6px;"><?php echo $this->_tpl_vars['arrResolucion']['numResolucionProyecto']; ?>
</td>
			<td align="center" style="padding:6px;"><?php echo $this->_tpl_vars['arrResolucion']['fchResolucionProyecto']; ?>
</td>
			<td align="center" style="padding:6px;"><?php echo $this->_tpl_vars['arrResolucion']['txtResuelve']; ?>
</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>