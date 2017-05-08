<?php /* Smarty version 2.6.26, created on 2017-05-05 08:47:22
         compiled from actosAdministrativos/informacionActo.tpl */ ?>
 <form id="frmSavarAAD" onSubmit="return false;"> <!-- FORMULARIO PARA SALVAR LOS CAMBIOS EN LOS ACTOS ADMINISTRATIVOS -->
   
<table cellspacing="0" cellpadding="3" border="0" width="100%">

   <!-- TIPO DE ACTO ADMINISTRATIVO -->
   <tr>
      <td width="200px">
         <b>Tipo de Acto Administrativo</b>
      </td>
      <td>
         <select name="seqTipoActo" 
                 id="seqTipoActo"
                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                 onBlur="this.style.backgroundColor = '#FFFFFF';"
                 onChange="
                     cargarContenido(
                        'informacion',
                        './contenidos/actosAdministrativos/informacionActo.php',
                        'seqTipoActo=' + this.options[ this.selectedIndex ].value,
                        true
                     );
                 "
         >
            <?php $_from = $this->_tpl_vars['arrTipoActo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoActo'] => $this->_tpl_vars['objTipoActo']):
?>
               <option value="<?php echo $this->_tpl_vars['seqTipoActo']; ?>
" <?php if ($this->_tpl_vars['arrPost']['seqTipoActo'] == $this->_tpl_vars['seqTipoActo']): ?> selected <?php endif; ?> >
                  <?php echo $this->_tpl_vars['objTipoActo']->txtTipoActo; ?>

               </option>
            <?php endforeach; endif; unset($_from); ?>
         </select>
      </td>
      <td align="center">
         <a href="#" onClick="plantillaActoAdministrativo2('seqTipoActo')">Vea como construir el archivo de carga</a>
      </td>
   </tr>
   
   <!-- DATOS PRINCIPALES DEL ACTO ADMINISTRATIVO -->
   <tr>
      <td colspan="3">
         
         <table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr>
               <td width="200px;">
                  <b>Número de la Resolución</b>
               </td>
               <td>
                  <input type="text"
                         name="numActo"
                         id="numActo"
                         onFocus="this.style.backgroundColor = '#ADD8E6';"
                         onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros(this);"
                         value="<?php echo $this->_tpl_vars['arrPost']['numActo']; ?>
"
                         <?php if ($this->_tpl_vars['arrPost']['seqTipoActo'] == 7): ?>
                            readonly
                         <?php endif; ?>
               </td>
            </tr>
            <tr>
               <td>
                  <b>Fecha de la Resolución</b>
               </td>
               <td>
                  <input type="text"
                         name="fchActo"
                         id="fchActo"
                         onFocus="this.style.backgroundColor = '#ADD8E6';"
                         onBlur="this.style.backgroundColor = '#FFFFFF';"
                         value="<?php echo $this->_tpl_vars['arrPost']['fchActo']; ?>
"
                         readonly
                  >
                  <a href="#" onClick="calendarioPopUp('fchActo')">Calendario</a>
               </td>
            </tr>
            <tr>
               <td colspan="2" style="height:75px; padding-top:10px; padding-bottom:10px;">
                  <?php if (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 0 || intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 1): ?>
                     <?php $this->assign('seqCaracteristica', '1'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['1']); ?>
                  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 2): ?>
                     <?php $this->assign('seqCaracteristica', '2'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['2']); ?>
                  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 3): ?>
                     <?php $this->assign('seqCaracteristica', '3'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['3']); ?>
                  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 5): ?>
                     <?php $this->assign('seqCaracteristica', '8'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['5']); ?>
                  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 7): ?>
                     <?php $this->assign('seqCaracteristica', '39'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['7']); ?>
                  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 8): ?>
                     <?php $this->assign('seqCaracteristica', '31'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['8']); ?>
				  <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 9): ?>
                     <?php $this->assign('seqCaracteristica', '99'); ?>
                     <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['9']); ?>
                  <?php endif; ?>
                  <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
               </td>
            </tr>
         </table>
         
      </td>
   </tr>
   <tr>
      <td colspan="3">
         <div id="tabActoAdministrativo" class="yui-navset">
            <ul class="yui-nav">
               <li class="selected">
                  <a href="#tab1">
                     <em>Informaci&oacute;n</em>
                  </a>
               </li>
               <?php if ($this->_tpl_vars['arrPost']['numActo'] != 0 && $this->_tpl_vars['arrPost']['fchActo'] != ""): ?>
                  <li>
                     <a href="#tab2">
                        <?php if (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 0 || intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 1): ?>
                           <em>Giros</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 2): ?>
                           <em>Modificaciones</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 3): ?>
                           <em>Inhabitados</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 4): ?>
                           <em>Resultados</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 5): ?>
                           <em>Listado</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 6): ?>
                           <em>Listado</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 7): ?>
                           <em>Listado</em>
                        <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 8): ?>
                           <em>Indexaci&oacute;n</em>
						<?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 9): ?>
                           <em>Listado</em>
						<?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 10): ?>
                           <em>Listado</em>
                        <?php endif; ?>
                     </a>
                  </li>
                  <li>
                     <a href="#tab3">
                        <em>Exportables</em>
                     </a>
                  </li>
               <?php endif; ?>
            </ul>            
            <div class="yui-content">
               <!-- CARACTERISTICAS DE CADA ACTO ADMINISTRATIVO -->
               <div id="tab1" style="height:400px; width:600; overflow: scroll;">
                  <p>
                     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/pestanaInformacion.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                     <div style="width: 100%; text-align: center">
                        <label for="archivo">Archivo de carga</label>
                        <input type="file" name="archivo" id="archivo"><br><br>
                        <a href="#" onClick="plantillaActoAdministrativo2('seqTipoActo')">Vea como construir el archivo de carga</a>
                     </div>
                  </p>
               </div>
         
               </form> <!-- ESTE FORMULARIO SE ABRE EN LA LINEA DE ESTE ARCHIVO Y SE CIERRA AQUI -->
                     
               <?php if ($this->_tpl_vars['arrPost']['numActo'] != 0 && $this->_tpl_vars['arrPost']['fchActo'] != ""): ?>
                  
                  <!-- INFORMACION DE LOS GIROS REALIZADOS -->   
                  <div id="tab2" style="height:410px; overflow: auto;">
                     <p><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/pestanaMasInformacion.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></p>
                  </div>
                
                  <!-- EXPORTABLES DE EXCEL DE HOGARES, INFORMACION DEL ACTO ADMINISTRATIVO Y HOGARES VINCULADOS -->
                  <div id="tab3" style="height:410px; overflow: auto;">
                     <p><center><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/pestanaExportables.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></center></p>
                  </div> 
                  
               <?php endif; ?>
            </div>
         </div>
         <div id="listenerTabActoAdministrativo"></div>
      </td>
   </tr>
</table>
   