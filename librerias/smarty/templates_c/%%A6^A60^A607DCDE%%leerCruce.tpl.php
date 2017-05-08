<?php /* Smarty version 2.6.26, created on 2017-05-05 10:36:48
         compiled from cruces/leerCruce.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'cruces/leerCruce.tpl', 11, false),array('modifier', 'date_format', 'cruces/leerCruce.tpl', 18, false),)), $this); ?>
<?php 
    date_default_timezone_set("America/Bogota");
    setlocale(LC_TIME , 'spanish' );
 ?>

<div style="padding:5px;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
            <td width="130px"><b>Nombre del Cruce</b></td>
            <td>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrCruce']['nombre'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
 
                [ <a href="#" onClick="mostrarOcultar('detalleCruce');">Ver Detalles</a> ]
            </td>
        </tr>
        <tr>
            <td width="130px"><b>Fecha del Cruce</b></td>
            <td>
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrCruce']['creacion'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

            </td>
        </tr>
		<tr>
            <td width="130px"><b>Fecha Actualizaci&oacute;n</b></td>
            <td>
                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrCruce']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

            </td>
        </tr>
        <tr>
            <td><b>Firma de la carta</b></td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arrCruce']['firma'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
        </tr>
        <tr>
            <td><b>Elaboraci&oacute;n</b></td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arrCruce']['elaboro'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
        </tr>
        <tr>
            <td><b>Revisi&oacute;n</b></td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arrCruce']['reviso'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
        </tr>
    </table>
    <div id="detalleCruce" style="display: none">
        <table border="0" cellpadding="2" cellspacing="0" width="100%" >
            <tr>
                <td valign="top" width="130px"><b>Cuerpo de la carta</b></td>
                <td valign="top" align="justify" style="padding:5px;"><?php echo $this->_tpl_vars['arrCruce']['cuerpo']; ?>
</td>
            </tr>
            <tr>
                <td valign="top"><b>Pie de la carta</b></td>
                <td align="justify" style="padding:5px;"><?php echo $this->_tpl_vars['arrCruce']['pie']; ?>
</td>
            </tr>
        </table>
    </div>
</div>
<div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cruces/listosCruce.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

