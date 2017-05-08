<?php /* Smarty version 2.6.26, created on 2017-05-04 22:55:02
         compiled from administracion/administracionInicial.tpl */ ?>
	
	<!-- ESTA PLANTILLA ES LA ESTRUCTURA
	DE TODOS LOS ADMINISTRADORES, LAS proyectoS
	LOS GRUPOS, LOS USUARIOS Y LOS MENU
	TENDRAN ESTA MISMA PLANTILLA EN COMUN
	-->

	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
		<tr>
		
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php O EL QUE SEA CARGADO USANDO EL menuLateral.tpl -->
			<td id="listado" align="left" width="300px" valign="top" style="border-right: 1px dotted #999999;">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['txtListado']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</td>
			
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php O EL QUE SEA CARGADO USANDO EL menuLateral.tpl -->
			<td id="formulario" align="left" valign="top">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['txtFormulario']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</td>
			
			<!-- SE MUESTRA EL ARCHIVO QUE INDIQUE EL administracionInicial.php -->
			<td id="menu" width="100px" align="left" valign="top" style="border-left: 1px dotted #999999">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['txtMenu']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</td>
		</tr>
	</table>