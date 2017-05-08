<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaOferente.tpl */ ?>
<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL OFERENTE<img src="recursos/imagenes/blank.gif" onload="escondetxtDireccion(); escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona();">
		<img src="recursos/imagenes/blank.gif" onload="escondeTerritorialDirigido(); escondeLineaOpv();"></td>
	</tr>
	<tr><td><b>Nombre</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreOferente; ?>
</td>
		<td><b>Nit o C&eacute;dula</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numNitOferente; ?>
</td>
	</tr>
	<tr><td><b>Nombre de Contacto</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreContactoOferente; ?>
</td>
		<td><b>Tel&eacute;fono Fijo de Contacto</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoOferente; ?>
 
			<?php if ($this->_tpl_vars['objFormularioProyecto']->numExtensionOferente != ""): ?> 
				<?php if ($this->_tpl_vars['objFormularioProyecto']->numExtensionOferente != 0): ?> 
					Ext. <?php echo $this->_tpl_vars['objFormularioProyecto']->numExtensionOferente; ?>
 
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td><b>Celular de Contacto</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numCelularOferente; ?>
 </td>
		<td><b>Correo de Contacto</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoOferente; ?>
 
		</td>
	</tr>
	<tr>
		<!-- PREGUNTA SI EL OFERENTE ES CONSTRUCTOR -->
		<td><b>El oferente es constructor?</b></td>
		<td><?php if ($this->_tpl_vars['objFormularioProyecto']->bolConstructor == 0): ?> Si <?php endif; ?>
			<?php if ($this->_tpl_vars['objFormularioProyecto']->bolConstructor == 1): ?> No <?php endif; ?>
		</td>
		<!-- CONSTRUCTOR -->
		<td id="idTituloConstructor" style="display:none"><b>Constructor</b></td>
		<td id="idComboConstructor" style="display:none"><?php $_from = $this->_tpl_vars['arrConstructor']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqConstructor'] => $this->_tpl_vars['txtNombreConstructor']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqConstructor == $this->_tpl_vars['seqConstructor']): ?> <?php echo $this->_tpl_vars['txtNombreConstructor']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
	<tr><td><b>Representante Legal</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtRepresentanteLegalOferente; ?>
</td>
		<td><b>Nit Representante Legal</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numNitRepresentanteLegalOferente; ?>
</td>
	</tr>
	<tr><td><b>Tel&eacute;fono Fijo</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoRepresentanteLegalOferente; ?>

			<?php if ($this->_tpl_vars['objFormularioProyecto']->numExtensionRepresentanteLegalOferente != ""): ?> 
				<?php if ($this->_tpl_vars['objFormularioProyecto']->numExtensionRepresentanteLegalOferente != 0): ?> 
					Ext. <?php echo $this->_tpl_vars['objFormularioProyecto']->numExtensionRepresentanteLegalOferente; ?>

				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td><b>Tel&eacute;fono Celular</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numCelularRepresentanteLegalOferente; ?>

		</td>
	</tr>
	<tr>
		<td><b>Direcci&oacute;n</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionRepresentanteLegalOferente; ?>
</td>
		<td><b>Correo electr&oacute;nico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoRepresentanteLegalOferente; ?>
</td>
		<td colspan="2"></td>
	</tr>
</table>