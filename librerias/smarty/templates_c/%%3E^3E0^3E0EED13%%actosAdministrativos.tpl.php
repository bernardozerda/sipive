<?php /* Smarty version 2.6.26, created on 2017-05-05 08:47:22
         compiled from actosAdministrativos/actosAdministrativos.tpl */ ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="620px">
   <tr>
      <td width="230px" height="80px" valign="top" align="center">
         <div class="tituloTabla" style="height:18px;">Filtros</div>
         <form id="frmFiltros" onSubmit="return false;">
            <div style="padding: 5px;">
               <select name="seqTipoActo" 
                       onFocus="this.style.backgroundColor = '#ADD8E6';"
                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                       style="width: 220px;"
               >
                  <option value="0">Todos los Actos</option>
                  <?php $_from = $this->_tpl_vars['arrTipoActo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoActo'] => $this->_tpl_vars['objTipoActo']):
?>
                     <option value="<?php echo $this->_tpl_vars['seqTipoActo']; ?>
"><?php echo $this->_tpl_vars['objTipoActo']->txtTipoActo; ?>
</option>
                  <?php endforeach; endif; unset($_from); ?>   
               </select>
            </div>
            <div style="padding: 5px;">
               <input type="text" 
                      name="numActo" 
                      onFocus="this.style.backgroundColor = '#ADD8E6'"
                      onBlur="
                         this.style.backgroundColor = '#FFFFFF'; 
                         soloNumeros( this ); 
                      " 
                      style="width: 220px;"
                      placeholder="Número de Acto Admnistrativo"
               >
            </div>
            <div style="padding: 5px;">
               <input type="file" 
                      name="cedulas" 
                      style="width: 220px;"
                      placeholder="Documentos"
               >
            </div>
            <div style="padding: 5px;">
               <input type="button" 
                      style="width: 80px;"
                      placeholder="Filtrar"
                      value="Filtrar"
                      onClick="
                         someterFormulario( 'listadoActos' , this.form , 'contenidos/actosAdministrativos/listadoActos.php', true , true );
                      "
               > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type="reset" 
                      style="width: 80px;"
                      placeholder="Limpiar"
                      value="Limpiar"
               >
            </div>
         </form>
      </td>
      <td rowspan="2"  valign="top">
         <div id="informacion" style="width:620px; height:620px; padding:10px;">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/informacionActo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
      </td>
   </tr>
   <tr>
      <td valign="top">
         <div class="tituloTabla" style="height:18px;">Listado</div>
         <div id="listadoActos" style="height: 520px; overflow: auto;">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/listadoActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
      </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td align="center">
         <button onClick="someterFormulario('mensajes','frmSavarAAD','./contenidos/actosAdministrativos/salvarActosAdministrativos.php',true,true);">
            Guardar Cambios
         </button>
      </td>
   </tr>
</table>

         