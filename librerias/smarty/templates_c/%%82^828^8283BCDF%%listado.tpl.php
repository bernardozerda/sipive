<?php /* Smarty version 2.6.26, created on 2017-05-04 22:55:02
         compiled from ./administracion/listado.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', './administracion/listado.tpl', 26, false),)), $this); ?>

<!--
	
	LISTADO GENERICO QUE FUNCIONA PARA LAS OPCIONES DE MENU DEL 
	PANEL DE CONTROL EXCEPTO PARA LAS OPCIONES DE MENU

	@author Bernardo Zerda 
	@version 1.0 Abil de 2009
	@version 1.1 Septiembre de 2009
	
-->	

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px"><?php echo $this->_tpl_vars['txtTitulo']; ?>
</td></tr>
	</table>
	<br>	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td>
				<div style="width:100%; height: 580px; overflow: auto;">
			
					<table cellspacing="2" cellpadding="0" border="0" width="100%">
					
						<!-- PARA CADA OPCION DEL LISTADO COLOCA LA PRESENTACION UNIFORME -->
						<?php $_from = $this->_tpl_vars['arrListado']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqListado'] => $this->_tpl_vars['arrInformacion']):
?>
							<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F9F9F9"), $this);?>
"
								style="cursor:pointer"
								onMouseOver="this.style.background='#e0e0e0'"
								onMouseOut="this.style.background='<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#FFFFFF,#F9F9F9"), $this);?>
'"
								onClick="cargarContenido( 'formulario' , '<?php echo $this->_tpl_vars['txtEditar']; ?>
' , 'seqEditar=<?php echo $this->_tpl_vars['seqListado']; ?>
' , true);"
							>
	
								<?php if ($this->_tpl_vars['arrInformacion']['estado'] != 'inactivo'): ?>
									<td align="center" widht="15px"><img src="./recursos/imagenes/bullet.jpg" /></td> 
								<?php else: ?>
									<td align="center" widht="15px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
								<?php endif; ?>
														
								<td style="padding-left:5px;"><?php echo $this->_tpl_vars['arrInformacion']['nombre']; ?>
</td> <!-- FORMATEA LA CADENA DE CARACTERES -->
	
	
								
								<td><a href="#" onClick="eliminarRegistro( <?php echo $this->_tpl_vars['seqListado']; ?>
 , '<?php echo $this->_tpl_vars['txtPregunta']; ?>
' , '<?php echo $this->_tpl_vars['txtBorrar']; ?>
' ); document.getElementById('seqEditar').value = ''; ">Borrar</td>
							</tr>
						<?php endforeach; endif; unset($_from); ?>					
					</table>
					
				</div>
					
			</td>
		</tr>
		

		
	</table>