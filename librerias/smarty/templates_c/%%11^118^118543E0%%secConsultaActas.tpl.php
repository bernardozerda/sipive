<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaActas.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConsultaActas.tpl', 11, false),)), $this); ?>
<table border="0" width="100%" id="tablaFormularioActas">
	<tr><td class="tituloTabla" colspan="5">ACTAS DEL PROYECTO</td></tr>
	<tr class="tituloTabla">
		<th align="center" width="10%" style="padding:6px;">Acta</th>
		<th align="center" width="15%" style="padding:6px;">Fecha</th>
		<th align="center" width="65%" style="padding:6px;">Observaciones</th>
	</tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
	<?php $this->assign('num', '0'); ?>
	<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

	<?php $_from = $this->_tpl_vars['arrActaProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqActaProyecto'] => $this->_tpl_vars['arrActa']):
?>
		<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
		<?php else: ?> <tr class="fila_1">
		<?php endif; ?>
			<td align="center" width="10%" style="padding:6px;"><?php echo $this->_tpl_vars['arrActa']['numActaProyecto']; ?>
</td>
			<td align="center" width="15%" style="padding:6px;"><?php echo $this->_tpl_vars['arrActa']['fchActaProyecto']; ?>
</td>
			<td align="center" width="65%" style="padding:6px;"><?php echo $this->_tpl_vars['arrActa']['txtEpigrafe']; ?>
</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>