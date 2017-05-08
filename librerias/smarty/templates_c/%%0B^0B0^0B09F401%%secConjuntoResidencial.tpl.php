<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:52
         compiled from proyectos/secConjuntoResidencial.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secConjuntoResidencial.tpl', 31, false),)), $this); ?>
<p>
	<table border="0" cellspacing="2" cellpadding="0" width="860">
		<tr><td class="tituloTabla" colspan="7">CONJUNTO RESIDENCIAL</td></tr>
		<tr><td colspan="7" align="right"><div onClick="addConjuntoResidencial()" style="cursor: hand">Adicionar Conjunto Residencial&nbsp;<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
	</table>
	<div style="width:860px; overflow: scroll;">
		<table border="0" cellspacing="2" cellpadding="0" width="100%" id="tablaConjuntoResidencial">
			<tr class="tituloTabla">
				<th align="center" style="padding:6px;">Nombre</th>
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
				<th align="center" style="padding:6px;">NIT Vendedor</th>
				<th align="center" style="padding:6px;">C&eacute;dula Catastral</th>
				<th align="center" style="padding:6px;">No. Escritura</th>
				<th align="center" style="padding:6px;">Fecha&nbsp;Escritura</th>
				<th align="center" style="padding:6px;">No. Notar&iacute;a</th>
				<th align="center" style="padding:6px;"></th>
			</tr>
			<?php $this->assign('num', '0'); ?>
			<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

			<?php $_from = $this->_tpl_vars['arrConjuntoResidencial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyecto'] => $this->_tpl_vars['arrConjunto']):
?>
				<?php if ($this->_tpl_vars['num']++%2 == 0): ?> <tr class="fila_0">
				<?php else: ?> <tr class="fila_1">
				<?php endif; ?>
					<td align="left" style="padding:6px">
						<?php echo smarty_function_counter(array('print' => false), $this);?>

						<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
						<input type="hidden" name="seqProyectoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqProyectoHijo" value="<?php echo $this->_tpl_vars['arrConjunto']['seqProyecto']; ?>
" >
						<input type="hidden" name="seqProyectoPadre[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqProyectoPadre" value="<?php echo $this->_tpl_vars['arrConjunto']['seqProyectoPadre']; ?>
" >
						<input type="text" name="txtNombreProyectoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="txtNombreProyectoHijo" value="<?php echo $this->_tpl_vars['arrConjunto']['txtNombreProyecto']; ?>
" size='28' onblur="sinCaracteresEspeciales( this );">
					</td>
					<td align="center" style="padding:6px">
						<input type="text" name="txtNombreComercialHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="txtNombreComercialHijo" value="<?php echo $this->_tpl_vars['arrConjunto']['txtNombreComercial']; ?>
" size='28' onblur="sinCaracteresEspeciales( this );">
					</td>
					<td align="center" style="padding:6px">
						<a href="#" onClick="recogerDireccion( 'txtDireccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]', 'objDireccionOculto' )"><img src="recursos/imagenes/icono_lupa.gif"></a>
						<input type="text" name='txtDireccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id="txtDireccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['txtDireccion']; ?>
" size="20" style="background-color:#E4E4E4;" readonly />
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='valNumeroSolucionesHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='valNumeroSolucionesHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['valNumeroSoluciones']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='6' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtChipLoteHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtChipLoteHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtChipLote']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='13' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtMatriculaInmobiliariaLoteHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtMatriculaInmobiliariaLoteHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtMatriculaInmobiliariaLote']; ?>
" size='13' onBlur='sinCaracteresEspeciales( this );' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtLicenciaUrbanismoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtLicenciaUrbanismoHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtLicenciaUrbanismo']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='18' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchLicenciaUrbanismo1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchLicenciaUrbanismo1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['fchLicenciaUrbanismo1']; ?>
" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input name="fchVigenciaLicenciaUrbanismoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchVigenciaLicenciaUrbanismoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['fchVigenciaLicenciaUrbanismo']; ?>
" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaUrbanismoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtExpideLicenciaUrbanismoHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtExpideLicenciaUrbanismoHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtExpideLicenciaUrbanismo']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='13' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtLicenciaConstruccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtLicenciaConstruccionHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtLicenciaConstruccion']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='18' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchLicenciaConstruccion1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchLicenciaConstruccion1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['fchLicenciaConstruccion1']; ?>
" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion1Hijo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input name="fchVigenciaLicenciaConstruccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchVigenciaLicenciaConstruccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['fchVigenciaLicenciaConstruccion']; ?>
" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaConstruccionHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtNombreVendedorHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtNombreVendedorHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtNombreVendedor']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='20' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='numNitVendedorHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='numNitVendedorHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['numNitVendedor']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtCedulaCatastralHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtCedulaCatastralHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtCedulaCatastral']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='22' >
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='txtEscrituraHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='txtEscrituraHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['txtEscritura']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px">
						<input name="fchEscrituraHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchEscrituraHijo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrConjunto']['fchEscritura']; ?>
" size="8" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchEscrituraHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a>
					</td>
					<td align="center" style="padding:6px">
						<input type='text' name='numNotariaHijo[<?php echo $this->_tpl_vars['actual']; ?>
]' id='numNotariaHijo' value="<?php echo $this->_tpl_vars['arrConjunto']['numNotaria']; ?>
" onBlur='sinCaracteresEspeciales( this );' size='12' >
					</td>
					<td align="center" style="padding:6px;">
						<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
					</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</table>
	</div>
</p>