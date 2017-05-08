<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaCronograma.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConsultaCronograma.tpl', 24, false),)), $this); ?>
<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CRONOGRAMA DE FECHAS DE OBRA</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaFormularioFechas">
			<tr class="tituloTabla">
				<th align="center" style="padding:3px;"></th>
				<th align="center" style="padding:3px;" colspan="3">Proyecto</th>
				<th align="center" style="padding:3px;" colspan="2">Ventas del Proyecto</th>
				<th align="center" style="padding:3px;" colspan="2">Entrega y Escrituraci&oacute;n de Viviendas</th>
			</tr>
			<tr class="tituloTabla">
				<th align="center" style="padding:3px;">Acta Descriptiva</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
				<th align="center" style="padding:3px;">Plazo Ejecuci&oacute;n (Meses)</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
				<th align="center" style="padding:3px;">Inicio</th>
				<th align="center" style="padding:3px;">Terminaci&oacute;n</th>
			</tr>
			<?php $this->assign('num', '0'); ?>
			<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

			<?php $_from = $this->_tpl_vars['arrCronogramaFecha']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCronogramaFecha'] => $this->_tpl_vars['arrCronograma']):
?>
				<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
				<?php else: ?> <tr class="fila_1">
				<?php endif; ?>
					<td align="center" valign="top" style="padding:6px;">Num. <?php echo $this->_tpl_vars['arrCronograma']['numActaDescriptiva']; ?>
 A&ntilde;o <?php echo $this->_tpl_vars['arrCronograma']['numAnoActaDescriptiva']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchInicialProyecto']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchFinalProyecto']; ?>
</td>
					<td align="center" valign="top" style="padding:6px;"><?php echo $this->_tpl_vars['arrCronograma']['valPlazoEjecucion']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchInicialEntrega']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchFinalEntrega']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchInicialEscrituracion']; ?>
</td>
					<td align="center" valign="top" style="padding:3px;"><?php echo $this->_tpl_vars['arrCronograma']['fchFinalEscrituracion']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
	</div>
</p>