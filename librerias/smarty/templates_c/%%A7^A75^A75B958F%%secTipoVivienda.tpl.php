<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:52
         compiled from proyectos/secTipoVivienda.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secTipoVivienda.tpl', 19, false),)), $this); ?>
<p>
		<table border="0" cellspacing="2" cellpadding="0" width="860">
			<tr><td class="tituloTabla" colspan="7">TIPO VIVIENDA</td></tr>
			<tr><td colspan="7" align="right"><div onClick="addTipoVivienda()" style="cursor: hand">Adicionar Tipo de Vivienda&nbsp;<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
		</table>
		<div style="width:860px; overflow: scroll;">
			<table border="0" cellspacing="2" cellpadding="0" width="1200" id="tablaTipoVivienda">
				<tr class="tituloTabla">
					<th align="center" width="18%" style="padding:6px;">Nombre</th>
					<th align="center" width="8%" style="padding:6px;">Cantidad</th>
					<th align="center" width="10%" style="padding:6px;">&Aacute;rea</th>
					<th align="center" width="10%" style="padding:6px;">A&ntilde;o Venta</th>
					<th align="center" width="10%" style="padding:6px;">Precio Venta</th>
					<th align="center" width="26%" style="padding:6px;">Descripci&oacute;n</th>
					<th align="center" width="10%" style="padding:6px;">Cierre</th>
					<th align="center" width="8%" style="padding:6px;"></th>
				</tr>
				<?php $this->assign('num', '0'); ?>
				<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

				<?php $_from = $this->_tpl_vars['arrTipoVivienda']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoVivienda'] => $this->_tpl_vars['arrTipoV']):
?>
					<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
					<?php else: ?> <tr class="fila_1">
					<?php endif; ?>
						<td align="center" valign="top" style="padding:6px;" width="18%">
							<?php echo smarty_function_counter(array('print' => false), $this);?>

							<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
							<input type="hidden" name="seqTipoVivienda[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqTipoVivienda" value="<?php echo $this->_tpl_vars['arrTipoV']['seqTipoVivienda']; ?>
" >
							<input type="text" name="txtNombreTipoVivienda[<?php echo $this->_tpl_vars['actual']; ?>
]" id="txtNombreTipoVivienda" value="<?php echo $this->_tpl_vars['arrTipoV']['txtNombreTipoVivienda']; ?>
" style="width:150px;" onblur="sinCaracteresEspeciales( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="8%">
							<input type="text" name="numCantidad[<?php echo $this->_tpl_vars['actual']; ?>
]" id="numCantidad<?php echo $this->_tpl_vars['actual']; ?>
" value="<?php echo $this->_tpl_vars['arrTipoV']['numCantidad']; ?>
" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							<input type="text" name="numArea[<?php echo $this->_tpl_vars['actual']; ?>
]" id="numArea" value="<?php echo $this->_tpl_vars['arrTipoV']['numArea']; ?>
" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">&nbsp;m²
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							<input type="text" name="numAnoVenta[<?php echo $this->_tpl_vars['actual']; ?>
]" id="numAnoVenta" value="<?php echo $this->_tpl_vars['arrTipoV']['numAnoVenta']; ?>
" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							$ <input type="text" name="valPrecioVenta[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valPrecioVenta<?php echo $this->_tpl_vars['actual']; ?>
" value="<?php echo $this->_tpl_vars['arrTipoV']['valPrecioVenta']; ?>
" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaVentas();">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="26%">
							<textarea name="txtDescripcion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="txtDescripcion" style="width:260px" ><?php echo $this->_tpl_vars['arrTipoV']['txtDescripcion']; ?>
</textarea>
						</td>
						<td align="center" valign="top" style="padding:6px;" width="10%">
							$ <input type="text" name="valCierre[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valCierre" value="<?php echo $this->_tpl_vars['arrTipoV']['valCierre']; ?>
" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );">
						</td>
						<td align="center" valign="top" style="padding:6px;" width="8%">
							<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
	</p>