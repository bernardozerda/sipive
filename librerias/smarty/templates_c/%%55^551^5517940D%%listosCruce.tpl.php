<?php /* Smarty version 2.6.26, created on 2017-05-05 10:03:40
         compiled from cruces/listosCruce.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'cruces/listosCruce.tpl', 3, false),array('modifier', 'number_format', 'cruces/listosCruce.tpl', 51, false),array('function', 'cycle', 'cruces/listosCruce.tpl', 29, false),)), $this); ?>

<div id="seleccionados" style="padding:5px;">
    <?php echo count($this->_tpl_vars['arrHogares']); ?>
 Hogares Listados 0 Seleccionados
</div>

<table border="0" cellpadding="2" cellspacing="0" width="100%" bgcolor="#e4e4e4">    
    <tr>
        <td width="20px;" align="center">
            <input type="checkbox" id="0" onClick="seleccionarCheck('frmListadoListos','0');">
        </td>   
        <td width="20px;">
            &nbsp;
        </td>
        <td width="85px" align="right">
            <strong>Documento</strong>
        </td>
        <td width="238px" style="padding-left:5px;">
            <strong>Nombre</strong>
        </td>
        <td>
            <strong>Estado</strong>
        </td>
    </tr>
</table>

<form id="frmListadoListos" onSubmit="return false;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">   
        <?php $_from = $this->_tpl_vars['arrHogares']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqFormulario'] => $this->_tpl_vars['arrInfo']):
?>
            <tr bgcolor="<?php echo smarty_function_cycle(array('values' => '#F9F9F9,#E4E4E4'), $this);?>
">
                <td width="20px;" align="center">
                    <input id="<?php echo $this->_tpl_vars['seqFormulario']; ?>
" 
                           type="checkbox" 
                           name="exportar[]"
                           value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
"
                           onClick="seleccionarCheck('frmListadoListos','<?php echo $this->_tpl_vars['seqFormulario']; ?>
');"
                    >
                </td>
                <td align="center" width="20px;">
                    <?php if (isset ( $this->_tpl_vars['arrInfo']['carta'] ) && $this->_tpl_vars['arrInfo']['carta'] == 1): ?>
                        <div style="background-color: red; font-size: 7px; color: white; font-weight: bold; width:100%; height: 10px;">
                            PDF
                        </div>                        
                    <?php elseif (isset ( $this->_tpl_vars['arrInfo']['carta'] ) && $this->_tpl_vars['arrInfo']['carta'] == 0): ?>
                        <div style="background-color: green; font-size: 7px; color: white; font-weight: bold; width:100%; height: 10px;">
                            OK
                        </div>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
                <td align="right" width="85px"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrInfo']['documento'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td style="padding-left:5px;" width="238px"><?php echo $this->_tpl_vars['arrInfo']['nombre']; ?>
</td>
                <td><?php echo $this->_tpl_vars['arrInfo']['estado']; ?>
</td>
            </tr>  
        <?php endforeach; endif; unset($_from); ?>
    </table>
    <input type="hidden" id="seqCruce" name="seqCruce" value="<?php echo $this->_tpl_vars['seqCruce']; ?>
">
</form>
