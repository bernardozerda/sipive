<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaConjuntosResidenciales.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConsultaConjuntosResidenciales.tpl', 29, false),)), $this); ?>
<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CONJUNTO RESIDENCIAL</td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaConjuntoResidencial">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre&nbsp;del&nbsp;Conjunto</th>
				<th align="center" style="padding:6px;">Nombre Comercial</th>
				<th align="center" style="padding:6px;">&nbsp;&nbsp;Direcci&oacute;n&nbsp;del&nbsp;Conjunto&nbsp;&nbsp;&nbsp;</th>
				<th align="center" style="padding:6px;">Unidades</th>
				<th align="center" style="padding:6px;">Chip</th>
				<th align="center" style="padding:6px;">Matr&iacute;cula Inmobiliaria</th>
				<th align="center" style="padding:6px;">Lic. Urbanismo</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vigencia&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Curadur&iacute;a</th>
				<th align="center" style="padding:6px;">Lic. Construcci&oacute;n</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vigencia&nbsp;Licencia</th>
				<th align="center" style="padding:6px;">Vendedor</th>
				<th align="center" style="padding:6px;">NIT&nbsp;Vendedor</th>
				<th align="center" style="padding:6px;">C&eacute;dula&nbsp;Catastral</th>
				<th align="center" style="padding:6px;">No. Escritura</th>
				<th align="center" style="padding:6px;">Fecha Escritura</th>
				<th align="center" style="padding:6px;">No. Notar&iacute;a</th>
			</tr>
			<?php $this->assign('num', '0'); ?>
			<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

			<?php $_from = $this->_tpl_vars['arrConjuntoResidencial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyecto'] => $this->_tpl_vars['arrConjunto']):
?>
				<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
				<?php else: ?> <tr class="fila_1">
				<?php endif; ?>
					<td align="left" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtNombreProyecto']; ?>
</td>
					<td align="left" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtNombreComercial']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtDireccion']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['valNumeroSoluciones']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtChipLote']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtMatriculaInmobiliariaLote']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtLicenciaUrbanismo']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['fchLicenciaUrbanismo1']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['fchVigenciaLicenciaUrbanismo']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtExpideLicenciaUrbanismo']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtLicenciaConstruccion']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['fchLicenciaConstruccion1']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['fchVigenciaLicenciaConstruccion']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtNombreVendedor']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['numNitVendedor']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtCedulaCatastral']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['txtEscritura']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['fchEscritura']; ?>
</td>
					<td align="center" style="padding:6px"><?php echo $this->_tpl_vars['arrConjunto']['numNotaria']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
	</div>
</p>