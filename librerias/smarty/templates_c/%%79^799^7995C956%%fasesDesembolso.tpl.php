<?php /* Smarty version 2.6.26, created on 2017-05-05 09:03:05
         compiled from desembolso/fasesDesembolso.tpl */ ?>
	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<?php $this->assign('txtFlujo', $this->_tpl_vars['arrFlujoHogar']['flujo']); ?>
		<?php $this->assign('txtFase', $this->_tpl_vars['arrFlujoHogar']['fase']); ?>
		<?php $this->assign('txtClase', 'msgOk'); ?>
		<?php $_from = $this->_tpl_vars['claFlujoDesembolsos']->arrFases[$this->_tpl_vars['txtFlujo']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtFaseDesembolso'] => $this->_tpl_vars['arrFasesDesembolso']):
?>
			<tr><td class="<?php echo $this->_tpl_vars['txtClase']; ?>
"
				style="cursor:pointer"
				onMouseOver="this.style.background='#FFFFFF'"
				onMouseOut="this.style.background='#E4E4E4'"
				onClick="javasript: cambiarFase(
						'contenidoFases',
						'imprimirFase',
						'<?php echo $this->_tpl_vars['arrFasesDesembolso']['codigo']; ?>
',
						'<?php echo $this->_tpl_vars['arrFasesDesembolso']['imprimir']; ?>
',
                        '<?php echo $this->_tpl_vars['txtFaseDesembolso']; ?>
',
						'seqFormulario=<?php echo $this->_tpl_vars['seqFormulario']; ?>
&cedula=<?php echo $this->_tpl_vars['cedula']; ?>
&flujo=<?php echo $this->_tpl_vars['txtFlujo']; ?>
&fase=<?php echo $this->_tpl_vars['txtFaseDesembolso']; ?>
'								
					);
				"
			>
				<?php echo $this->_tpl_vars['arrFasesDesembolso']['nombre']; ?>

			</td></tr>		
			<?php if ($this->_tpl_vars['txtFaseDesembolso'] == $this->_tpl_vars['arrFlujoHogar']['fase']): ?> 
				<?php $this->assign('txtClase', 'msgError'); ?>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	</table>