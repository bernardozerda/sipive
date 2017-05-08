<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaTiposVivienda.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConsultaTiposVivienda.tpl', 17, false),)), $this); ?>
<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">TIPO VIVIENDA</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaTipoVivienda">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre</th>
				<th align="center" style="padding:6px;">Cantidad</th>
				<th align="center" style="padding:6px;">&Aacute;rea</th>
				<th align="center" style="padding:6px;">A&ntilde;o Venta</th>
				<th align="center" style="padding:6px;">Precio Venta</th>
				<th align="center" style="padding:6px;">Descripci&oacute;n</th>
				<th align="center" style="padding:6px;">Cierre</th>
			</tr>
			<?php $this->assign('num', '0'); ?>
			<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

			<?php $_from = $this->_tpl_vars['arrTipoVivienda']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoVivienda'] => $this->_tpl_vars['arrTipoV']):
?>
				<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
				<?php else: ?> <tr class="fila_1">
				<?php endif; ?>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrTipoV']['txtNombreTipoVivienda']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrTipoV']['numCantidad']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrTipoV']['numArea']; ?>
&nbsp;m²</td>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrTipoV']['numAnoVenta']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;">$ <?php echo $this->_tpl_vars['arrTipoV']['valPrecioVenta']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrTipoV']['txtDescripcion']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;">$ <?php echo $this->_tpl_vars['arrTipoV']['valCierre']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
	</div>
</p>