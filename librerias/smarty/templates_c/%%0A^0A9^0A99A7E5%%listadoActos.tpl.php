<?php /* Smarty version 2.6.26, created on 2017-05-05 08:47:22
         compiled from actosAdministrativos/listadoActos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'intval', 'actosAdministrativos/listadoActos.tpl', 5, false),)), $this); ?>

<?php if (! empty ( $this->_tpl_vars['arrTipoActo'] )): ?>
   <?php $_from = $this->_tpl_vars['arrTipoActo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoActo'] => $this->_tpl_vars['objTipoActo']):
?>
         <div class="menuLateral" style="cursor: pointer;" onClick="mostrarOcultar('<?php echo $this->_tpl_vars['objTipoActo']->txtTipoActo; ?>
');">
            <?php echo $this->_tpl_vars['objTipoActo']->txtTipoActo; ?>
 [<?php echo ((is_array($_tmp=$this->_tpl_vars['arrConteo'][$this->_tpl_vars['seqTipoActo']])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)); ?>
]
         </div>
         <div id="<?php echo $this->_tpl_vars['objTipoActo']->txtTipoActo; ?>
" style="display: none;">
            <?php $_from = $this->_tpl_vars['arrActos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['objActo']):
?>
               <?php if ($this->_tpl_vars['objActo']->seqTipoActo == $this->_tpl_vars['seqTipoActo']): ?>
                  <div id="" 
                       style="padding-left: 30px; height: 15px; cursor: pointer;"
                       onMouseOver="this.style.background='#EDEDED'"
                       onMouseOut="this.style.background='#F9F9F9'"
                       onClick="cargarContenido('informacion','contenidos/actosAdministrativos/informacionActo.php','seqTipoActo=<?php echo $this->_tpl_vars['seqTipoActo']; ?>
&numActo=<?php echo $this->_tpl_vars['objActo']->numActo; ?>
&fchActo=<?php echo $this->_tpl_vars['objActo']->fchActo; ?>
',true)"
                  >
                     <?php echo $this->_tpl_vars['objActo']->numActo; ?>
 del <?php echo $this->_tpl_vars['objActo']->fchActo; ?>

                  </div>
               <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>   
         </div>
   <?php endforeach; endif; unset($_from); ?>  
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><div style="border-width: 1px;  border-style: dotted; border-width: 1px;"><table><tr><td align="center"><img src='recursos/imagenes/alerta-icono-pequeno.jpg'></td></tr><tr><td style="color:#FF0000; text-align:justify">Confirmar la inclusi&oacute;n de todos los hogares relacionados en los diferentes art&iacute;culos del acto administrativo (Hogares vulnerables y v&iacute;ctimas / proyectos, seg&uacute;n corresponda)</td></tr></table></div>   
<?php else: ?>

   <div class="msgError">No hay registros</div>
<?php endif; ?>
