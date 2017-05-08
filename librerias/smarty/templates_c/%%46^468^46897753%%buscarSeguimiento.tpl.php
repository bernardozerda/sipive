<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from seguimientoProyectos/buscarSeguimiento.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'seguimientoProyectos/buscarSeguimiento.tpl', 1, false),array('modifier', 'number_format', 'seguimientoProyectos/buscarSeguimiento.tpl', 7, false),)), $this); ?>
<?php if (count($this->_tpl_vars['arrRegistros']) != 0): ?>

	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<?php $_from = $this->_tpl_vars['arrRegistros']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqRegistro'] => $this->_tpl_vars['arrInformacion']):
?>
			<tr>
				<td bgcolor="#E4E4E4" colspan="2" height="22px">
					<b>Registro No:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['seqRegistro'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', ',') : number_format($_tmp, '0', '.', ',')); ?>
&nbsp;
					<?php if ($this->_tpl_vars['arrInformacion']['txtCambios'] != ""): ?>
						<a href="#" onClick="verCambiosFormularioProyectos( '<?php echo $this->_tpl_vars['arrInformacion']['seqProyecto']; ?>
' , '<?php echo $this->_tpl_vars['seqRegistro']; ?>
' );">Detalles</a>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td width="400px" valign="top" 
					style="border-bottom: 1px dotted #999999; border-right: 1px dotted #999999; padding-bottom: 5px; padding-top: 3px;"
				>
					<b>Fecha del Registro:</b> <?php echo $this->_tpl_vars['arrInformacion']['fchMovimiento']; ?>
 <br>
					<b>Grupo Gestión:</b> <?php echo $this->_tpl_vars['arrInformacion']['txtGrupoGestion']; ?>
<br>
					<b>Seguimiento:</b> <?php echo $this->_tpl_vars['arrInformacion']['txtGestion']; ?>
<br>
					<b>Atendido por:</b> <?php echo $this->_tpl_vars['arrInformacion']['txtUsuario']; ?>
<br>
				</td>
				<td align="justify" valign="top" style="padding-left:5px; border-bottom: 1px dotted #999999; padding-bottom: 3px; padding-top: 3px;">
					<?php echo $this->_tpl_vars['arrInformacion']['txtComentario']; ?>

				</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>

<?php else: ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px">
    	<tr><td class="msgError"><li>No hay seguimientos registrados para este proyecto</li></td></tr>
    </table>
<?php endif; ?>