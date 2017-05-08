<?php /* Smarty version 2.6.26, created on 2017-05-04 21:25:26
         compiled from subsidios/actosAdministrativos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'subsidios/actosAdministrativos.tpl', 22, false),)), $this); ?>
<div style="height: 400px; overflow: auto; padding: 0px;" >
    <?php $this->assign('txtEstilo', "style='padding:3px;'"); ?>

    <ul>
        <?php $_from = $this->_tpl_vars['arrActos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrActo']):
?>
            <li<?php echo $this->_tpl_vars['txtEstilo']; ?>
> </li>
            <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>
                <strong><?php echo $this->_tpl_vars['arrActo']['acto']['nombre']; ?>
</strong> <?php echo $this->_tpl_vars['arrActo']['acto']['numero']; ?>
 del <?php echo $this->_tpl_vars['arrActo']['acto']['fecha']; ?>
<?php if ($this->_tpl_vars['esCoordinador'] == 1): ?> <span> <b>Estado</b>: <?php echo $this->_tpl_vars['arrActo']['acto']['seqEstadoProceso']; ?>
</span><?php endif; ?>
                <!-- /****************************************************************************************************/
                // Cambios Generados por Ing Liliana Basto
                // Inserción de icono para Actualizar Acto Administrativos
                    /****************************************************************************************************/-->
                <?php if ($this->_tpl_vars['esCoordinador'] == 1): ?>
                    <button type="button" value="Actualizar Acto" style="width:50px; position: relative; float: left; margin-right: 3%" onclick="modificarActo('actosAdministrativos/modificarActo',<?php echo $this->_tpl_vars['seqFormulario']; ?>
,<?php echo $this->_tpl_vars['arrActo']['acto']['seqformActo']; ?>
);">
                        <img src="./recursos/imagenes/modify.png" width="16px" height="16px">
                        <span style="font-size: 8px; font-weight: bold;">Actualizar <br>Acto</span>
                    </button>
                <?php endif; ?>
                <ul>
                    <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Fecha de Notificaci&oacute;n: <?php echo $this->_tpl_vars['arrActo']['notificado']; ?>
</li>
                        <?php if ($this->_tpl_vars['arrActo']['acto']['tipo'] == 1): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Valor de los giros realizados: $ <?php echo ((is_array($_tmp=$this->_tpl_vars['arrActo']['acto']['giros'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</li>
                        <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 2): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>
                            Modificaciones realizadass:
                            <ul>
                                <?php $_from = $this->_tpl_vars['arrActo']['modificaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrModificacion']):
?>
                                    <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><?php echo $this->_tpl_vars['arrModificacion']['txtCampo']; ?>
: Se cambió <?php echo $this->_tpl_vars['arrModificacion']['txtIncorrecto']; ?>
 por <?php echo $this->_tpl_vars['arrModificacion']['txtCorrecto']; ?>
</li>
                                    <?php endforeach; endif; unset($_from); ?>
                            </ul>
                        </li>
                    <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 3): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>
                            <?php $_from = $this->_tpl_vars['arrActo']['acto']['inhabilidades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['numDocumento'] => $this->_tpl_vars['arrDocumentos']):
?>
                                Inhabilidades encontradas para <?php echo $this->_tpl_vars['arrDocumentos']['txtNombre']; ?>
:
                                <ul>
                                    <?php $_from = $this->_tpl_vars['arrDocumentos']['arrListado']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrInhabilidad']):
?>
                                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><?php echo $this->_tpl_vars['arrInhabilidad']['txtFuente']; ?>
: <?php echo $this->_tpl_vars['arrInhabilidad']['txtCausa']; ?>
</li>
                                        <?php endforeach; endif; unset($_from); ?>
                                </ul>
                            <?php endforeach; endif; unset($_from); ?>
                        </li>
                    <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 4): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Interpuesto contra la resoluci&oacute;n: <?php echo $this->_tpl_vars['arrActo']['acto']['numeroReferencia']; ?>
 del <?php echo $this->_tpl_vars['arrActo']['acto']['fechaReferencia']; ?>
</li>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Resultado del Recurso de Reposici&oacute;n: <?php echo $this->_tpl_vars['arrActo']['acto']['resultado']; ?>
</li>
                        <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 5): ?>
                        <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 6): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Renunci&oacute; a la Resoluci&oacute;n: <?php echo $this->_tpl_vars['arrActo']['acto']['numeroReferencia']; ?>
 del <?php echo $this->_tpl_vars['arrActo']['acto']['fechaReferencia']; ?>
</li>
                        <?php elseif ($this->_tpl_vars['arrActo']['acto']['tipo'] == 8): ?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Valor de la indexación: $<?php echo ((is_array($_tmp=$this->_tpl_vars['arrActo']['acto']['indexacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</li>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>N&uacute;mero resoluci&oacute;n referencia: <?php echo ((is_array($_tmp=$this->_tpl_vars['arrActo']['acto']['numeroReferencia'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</li>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Fecha resoluci&oacute;n referencia: <?php echo $this->_tpl_vars['arrActo']['acto']['fechaReferencia']; ?>
</li>

                    <?php endif; ?>

                    <?php $_from = $this->_tpl_vars['arrActo']['relacionado']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrRelacionado']):
?>
                        <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><strong><?php echo $this->_tpl_vars['arrRelacionado']['nombre']; ?>
</strong> <?php echo $this->_tpl_vars['arrRelacionado']['numero']; ?>
 del <?php echo $this->_tpl_vars['arrRelacionado']['fecha']; ?>
</li>
                        <ul>
                            <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Fecha de Notificaci&oacute;n: <?php echo $this->_tpl_vars['arrRelacionado']['notificado']; ?>
</li>
                                <?php if ($this->_tpl_vars['arrRelacionado']['tipo'] == 1): ?>
                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Valor de los giros realizados: $ <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRelacionado']['acto']['giros'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</li>
                                <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 2): ?>
                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>
                                    Modificaciones realizadas:
                                    <ul>
                                        <?php $_from = $this->_tpl_vars['arrRelacionado']['modificaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrModificacion']):
?>
                                            <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><?php echo $this->_tpl_vars['arrModificacion']['txtCampo']; ?>
: Se cambió <?php echo $this->_tpl_vars['arrModificacion']['txtIncorrecto']; ?>
 por <?php echo $this->_tpl_vars['arrModificacion']['txtCorrecto']; ?>
</li>
                                            <?php endforeach; endif; unset($_from); ?>
                                    </ul>
                                </li>
                            <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 3): ?>
                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>
                                    <?php $_from = $this->_tpl_vars['arrRelacionado']['acto']['inhabilidades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['numDocumento'] => $this->_tpl_vars['arrDocumentos']):
?>
                                        Inhabilidades encontradas para <?php echo $this->_tpl_vars['arrDocumentos']['txtNombre']; ?>
:
                                        <ul>
                                            <?php $_from = $this->_tpl_vars['arrDocumentos']['arrListado']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrInhabilidad']):
?>
                                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><?php echo $this->_tpl_vars['arrInhabilidad']['txtFuente']; ?>
: <?php echo $this->_tpl_vars['arrInhabilidad']['txtCausa']; ?>
</li>
                                                <?php endforeach; endif; unset($_from); ?>
                                        </ul>
                                    <?php endforeach; endif; unset($_from); ?>
                                </li>
                            <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 4): ?>
                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
><?php echo $this->_tpl_vars['arrRelacionado']['resultado']; ?>
</li>
                                <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 5): ?>
                                <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 6): ?>
                                <?php elseif ($this->_tpl_vars['arrRelacionado']['tipo'] == 8): ?>
                                <li <?php echo $this->_tpl_vars['txtEstilo']; ?>
>Valor de la indexación: $<?php echo ((is_array($_tmp=$this->_tpl_vars['arrRelacionado']['indexacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</li>
                                <?php endif; ?>
                        </ul>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'subsidios/actosUnidades.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>









<!-- 
<?php if ($this->_tpl_vars['txtActosAdministrativosJs'] != ""): ?>
        <div id="treeDivArbolMostrar"></div>
        <div id="objArbolActosAdministrativos" style="display:none" ><?php echo $this->_tpl_vars['txtActosAdministrativosJs']; ?>
</div>
<?php endif; ?>
-->