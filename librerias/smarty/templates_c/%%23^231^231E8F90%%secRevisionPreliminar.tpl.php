<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secRevisionPreliminar.tpl */ ?>
<table width="100%" border="0">
	<tr>
		<td width="30%" valign="top">Profesional Responsable<img src="recursos/imagenes/blank.gif" onload="escondeLineaObservacionesContratoInterventoria();"></td>
		<td valign="top"><select name="seqProfesionalResponsable" id="seqProfesionalResponsable" >
				<option value="0">Seleccione una opci&oacute;n</option>
				<?php $_from = $this->_tpl_vars['arrProfesionalResponsable']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProfesionalResponsable'] => $this->_tpl_vars['txtProfesionalResponsable']):
?>
					<option value="<?php echo $this->_tpl_vars['seqProfesionalResponsable']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqProfesionalResponsable == $this->_tpl_vars['seqProfesionalResponsable']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtProfesionalResponsable']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr><!-- VO. BO. CONTRATO DE INTERVENTORIA -->
		<td valign="top">Vo. Bo. contrato de interventor&iacute;a</td>
		<td valign="top"><select name="optVoBoContratoInterventoria" id="optVoBoContratoInterventoria" onChange="escondeLineaObservacionesContratoInterventoria()">
				<option value="0" <?php if ($this->_tpl_vars['objFormularioProyecto']->optVoBoContratoInterventoria == 0): ?> selected <?php endif; ?>>Seleccione una opci&oacute;n</option>
				<option value="1" <?php if ($this->_tpl_vars['objFormularioProyecto']->optVoBoContratoInterventoria == 1): ?> selected <?php endif; ?>>Si</option>
				<option value="2" <?php if ($this->_tpl_vars['objFormularioProyecto']->optVoBoContratoInterventoria == 2): ?> selected <?php endif; ?>>Con Observaciones</option>
			</select>
		</td>
	</tr>
	<tr id="lineaObservacionesContratoInterventoria" style="display:none"><!-- OBSERVACIONES CONTRATO DE INTERVENTORIA -->
		<td valign="top">Descripci&oacute;n Contrato de interventor&iacute;a</td>
		<td valign="top" colspan="2"><textarea cols="90" id="txtObservacionesContratoInterventoria" name="txtObservacionesContratoInterventoria" ><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObservacionesContratoInterventoria; ?>
</textarea></td>
	</tr>
	<tr><!-- FECHA DE REVISION CONTRATO DE INTERVENTORIA -->
		<td valign="top">Fecha de revisi&oacute;n contrato de interventor&iacute;a</td>
		<td valign="top"><input name="fchRevisionContratoInterventoria" type="text" id="fchRevisionContratoInterventoria" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchRevisionContratoInterventoria; ?>
" size="12" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchRevisionContratoInterventoria' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
	</tr>
	<tr><td colspan="2"><input name="valTotalCostos" type="hidden" id="valTotalCostos" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalCostos; ?>
" /></td></tr>
</table>