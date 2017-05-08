<?php /* Smarty version 2.6.26, created on 2017-05-05 08:47:22
         compiled from actosAdministrativos/pestanaInformacion.tpl */ ?>

   <!-- TABLA DE INFORMACION PARA LA RESOLUCION DE ASIGNADOS -->
   <?php if (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 0 || intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 1): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['1']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td colspan="">
               <?php $this->assign('seqCaracteristica', '17'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td colspan="">
               <?php $this->assign('seqCaracteristica', '48'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 <!-- INICIO FILA 1 'CDP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '9'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '23'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '40'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '51'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '59'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '67'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '75'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '83'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '100'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '108'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '116'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '124'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '132'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
		 </tr>
		 		 <!-- INICIO FILA 2 'Valor CDP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '10'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '24'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '41'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '52'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '60'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '68'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '76'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '84'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '101'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '109'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '117'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '125'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '133'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 3 'Fecha CDP' -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '11'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '25'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '42'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>          
            <td>
               <?php $this->assign('seqCaracteristica', '53'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '61'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '69'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '77'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '85'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
             <td>
               <?php $this->assign('seqCaracteristica', '102'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '110'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '118'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '126'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '134'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 4 'Vigencia CDP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '12'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '26'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '43'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>            
            <td>
               <?php $this->assign('seqCaracteristica', '54'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '62'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '70'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '78'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '86'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '103'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '111'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '119'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '127'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '135'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 5 'RP' -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '13'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '27'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '44'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>           
            <td>
               <?php $this->assign('seqCaracteristica', '55'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '63'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '71'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '79'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '87'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '104'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '112'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '120'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '128'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '136'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 6 'Valor RP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '14'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '28'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '45'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>          
            <td>
               <?php $this->assign('seqCaracteristica', '56'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '64'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '72'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '80'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '88'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '105'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '113'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '121'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '129'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '137'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 7 'Fecha RP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '15'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '29'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '46'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>           
            <td>
               <?php $this->assign('seqCaracteristica', '57'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '65'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '73'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '81'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '89'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            
            <td>
               <?php $this->assign('seqCaracteristica', '106'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '114'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '122'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '130'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '138'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
		 		 <!-- INICIO FILA 8 'Vigencia RP'  -->
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '16'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '30'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '47'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>         
            <td>
               <?php $this->assign('seqCaracteristica', '58'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '66'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '74'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '82'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '90'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '107'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '115'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '123'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '131'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			<td>
               <?php $this->assign('seqCaracteristica', '139'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         
      </table>
   
   <!-- TABLA DE INFORMACION PARA LA RESOLUCION MODIFICATORIA -->
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 2): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['2']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '4'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '7'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>
	  <div align="center"><a href="#" onClick="plantillaProyectoUnidadHabitacional()">Gu&iacute;a de proyectos y unidades habitacionales</a></div><br>
   
   <!-- TABLA DE INFORMACION PARA LA RESOLUCION DE INHABILITADOS -->
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 3): ?>
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
      
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE REPOSICION -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 4): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['4']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '5'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '6'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>
   
   <!-- TABLA DE INFORMACION PARA LOS NO ASIGNADOS -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 5): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['5']); ?>
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
      
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE RENUNCIA -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 6): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['6']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '18'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '19'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>   
   
   <!-- TABLA DE INFORMACION PARA LOS RECURSOS DE PERDIDA -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 9): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['9']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '49'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '50'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>
	  
	<!-- TABLA DE INFORMACION PARA LOS RECURSOS DE REVOCATORIA -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 10): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['10']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '91'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '92'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>
	<!-- TABLA DE INFORMACION PARA VIVIENDA GRATUITA -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 11): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['11']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '140'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '141'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
      </table>
   
   <!-- TABLA DE INFORMACION PARA LAS NOTIFICACIONES -->
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 7): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['7']); ?>        
      <span class="msgOk">Este tipo de Acto administrativo no tiene informaci&oacute;n adicional</span>
   
   <!-- TABLA DE INFORMACION PARA LAS RESOLUCIONES DE INDEXACION -->   
   <?php elseif (intval ( $this->_tpl_vars['arrPost']['seqTipoActo'] ) == 8): ?>
      <?php $this->assign('objTipoActo', $this->_tpl_vars['arrTipoActo']['8']); ?>
      <table cellspacing="0" cellpadding="3" border="0" width="100%">
         <tr>
            <td colspan="2">
               <?php $this->assign('seqCaracteristica', '38'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '32'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '35'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
			<td>
               <?php $this->assign('seqCaracteristica', '93'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '96'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '33'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '36'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
			<td>
				<?php $this->assign('seqCaracteristica', '94'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '97'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
         </tr>
         <tr>
            <td>
               <?php $this->assign('seqCaracteristica', '34'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '37'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
			<td>
               <?php $this->assign('seqCaracteristica', '95'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
            <td>
               <?php $this->assign('seqCaracteristica', '98'); ?>
               <?php $this->assign('arrCaracteristica', $this->_tpl_vars['objTipoActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]); ?>
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actosAdministrativos/camposActos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
			
         </tr>
      </table>   
   <?php endif; ?>
   