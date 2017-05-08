<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:52
         compiled from proyectos/secCronogramaFechas.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secCronogramaFechas.tpl', 27, false),)), $this); ?>
<p>
		<table border="0" cellspacing="2" cellpadding="0" width="860">
			<tr><td class="tituloTabla" colspan="7">CRONOGRAMA DE FECHAS DE OBRA</td></tr>
			<tr><td colspan="7" align="right"><div onClick="addCronogramaFechas()" style="cursor: hand">Adicionar Cronograma<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
		</table>
		<div style="width:860px; overflow: scroll;">
			<table border="0" cellspacing="2" cellpadding="0" width="1350" id="tablaFormularioFechas">
				<tr class="tituloTabla">
					<th align="center" style="padding:3px;"></th>
					<th align="center" style="padding:3px;" colspan="3">Proyecto</th>
					<th align="center" style="padding:3px;" colspan="2">Ventas del Proyecto</th>
					<th align="center" style="padding:3px;" colspan="2">Entrega y Escrituraci&oacute;n de Viviendas</th>
					<th align="center" style="padding:6px;"></th>
				</tr>
				<tr class="tituloTabla">
					<th align="center" width="12%" style="padding:3px;">Acta Descriptiva</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="8%" style="padding:3px;">Plazo Ejecuci&oacute;n (Meses)</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="12%" style="padding:3px;">Inicio</th>
					<th align="center" width="12%" style="padding:3px;">Terminaci&oacute;n</th>
					<th align="center" width="8%" style="padding:6px;"></th>
				</tr>
				<?php $this->assign('num', '0'); ?>
				<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

				<?php $_from = $this->_tpl_vars['arrCronogramaFecha']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCronogramaFecha'] => $this->_tpl_vars['arrCronograma']):
?>
					<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
					<?php else: ?> <tr class="fila_1">
					<?php endif; ?>
						<td align="center" width="18%" valign="top" style="padding:6px;">
							<?php echo smarty_function_counter(array('print' => false), $this);?>

							<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
							<input type="hidden" name="seqCronogramaFecha[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqCronogramaFecha" value="<?php echo $this->_tpl_vars['arrCronograma']['seqCronogramaFecha']; ?>
" >
							Num. <input name="numActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="numActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['numActaDescriptiva']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
							 A&ntilde;o <input name="numAnoActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="numAnoActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['numAnoActaDescriptiva']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:center" />
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchInicialProyecto']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchFinalProyecto']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalProyecto[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:6px;">
							<input name="valPlazoEjecucion[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="valPlazoEjecucion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['valPlazoEjecucion']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="12" style="text-align:center" />
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchInicialEntrega']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchFinalEntrega']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEntrega[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchInicialEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchInicialEscrituracion']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchInicialEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="12%" valign="top" style="padding:3px;">
							<input name="fchFinalEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['fchFinalEscrituracion']; ?>
" size="12" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchFinalEscrituracion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
						</td>
						<td align="center" width="10%" valign="top" style="padding:6px;">
							<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
	</p>