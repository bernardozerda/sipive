<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:05
         compiled from proyectos/inscripcion.tpl */ ?>
<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<?php if ($this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso != ""): ?>
	<?php $this->assign('seqPryEstadoProceso', $this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso); ?>
<?php else: ?>
	<?php $this->assign('seqPryEstadoProceso', 1); ?>
<?php endif; ?>

<form name="frmInscripcionProyecto" id="frmInscripcionProyecto" onSubmit="return false;">
	<!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
	<?php $this->assign('seqPryEstadoProceso', $this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'proyectos/pedirSeguimiento.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
		<tr> <!-- BOTON PARA SALVAR EL FORMULARIO -->
			<td height="25px" valign="middle" align="right" style="padding-right:10px; padding-left:10px;" bgcolor="#E4E4E4" colspan="4">
				<div style="font-size: 10px; float:left">(*) Campo obligatorio </div>
				<div style="font-size: 10px; float:right">
					<?php if ($this->_tpl_vars['arrPrivilegios']['crear'] == '1' || $this->_tpl_vars['arrPrivilegios']['editar'] == '1'): ?>
						<input type="submit" name="salvar" id="salvar" value="Salvar Inscripci&oacute;n" onClick="preguntarGuardarProyecto()"/>
					<?php else: ?>
						&nbsp;
					<?php endif; ?>
				</div>
				<input type="hidden" id="seqUsuario" name="seqUsuario" value="<?php echo $this->_tpl_vars['seqUsuario']; ?>
">
				<input type="hidden" id="seqFormularioEditar" name="seqFormularioEditar" value="<?php echo $this->_tpl_vars['seqProyecto']; ?>
">
				<input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/proyectos/salvarInscripcion.php">
			</td>
		</tr>
	</table>
	<div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
		<ul class="yui-nav" style="background:#E4E4E4;">
			<li class="selected"><a href="#frm"><em>Proyecto</em></a></li>
			<li><a href="#ofe"><em>Oferente</em></a></li>
		</ul>
		<div class="yui-content">
			<div id="frm" style="height:380px;">
				<?php $this->assign('f', $this->_tpl_vars['objFormularioProyecto']->seqModalidad); ?>
				<?php if ($this->_tpl_vars['seqModalidad'] == ""): ?>
					<?php $this->assign('seqModalidad', 1); ?>
				<?php endif; ?>
				<!-- ESTADO DEL PROCESO -->
				<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
					<tr bgcolor="#E4E4E4">
						<td width="140px"><b>Estado del proceso: </b></td>
						<td width="280px">
						<?php if ($this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso == ""): ?> Inscripcion <?php else: ?> <?php echo $this->_tpl_vars['arrEstadoProceso'][$this->_tpl_vars['seqPryEstadoProceso']]; ?>
 <?php endif; ?>
						<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="1">
						</td>
						<td width="140px"><b>Fecha de Inscripci&oacute;n</b></td>
						<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchInscripcion; ?>
&nbsp;</td>
					</tr>
					<tr><td height="5px"></td></tr>
				</table>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secDatosProyectoInscripcion.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div id="ofe" style="height:380px;">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secDatosOferente.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	</div>
</form>
<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>