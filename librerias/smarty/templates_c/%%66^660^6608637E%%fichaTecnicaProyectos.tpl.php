<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:49
         compiled from proyectos/fichaTecnicaProyectos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'explode', 'proyectos/fichaTecnicaProyectos.tpl', 30, false),array('modifier', 'date_format', 'proyectos/fichaTecnicaProyectos.tpl', 35, false),array('modifier', 'number_format', 'proyectos/fichaTecnicaProyectos.tpl', 84, false),)), $this); ?>
<?php if ($this->_tpl_vars['boolMostrar'] == 1): ?>
    <div class="divLeftP">
        <h1>SECRETARÍA DISTRITAL DEL HÁBITAT</h1>
        <h2>SUBSECRETARÍA DE GESTIÓN FINANCIERA</h2>
        <h3>FICHA DE PROYECTOS APROBADOS EN COMITÉ DE ELEGIBILIDAD PARA VIVIENDA NUEVA</h3>
    </div>
    <div class="divRightP">
        <img src="recursos/imagenes/bta_positiva.png" />
    </div>

    <div class="bodyP" id="bodyP">
        <table>
            <tr>
                <th colspan="2">NOMBRE DEL PROYECTO</th>
                <td  colspan="4">
                    <select id="seqProyecto" name="seqProyecto" onchange="obtenerDatos(this.value)">
                        <option value="0">Seleccione</option>
                        <?php $_from = $this->_tpl_vars['arrListaProyectos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                            <option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
<?php endif; ?>
<div id="divDatos" class="bodyP">
    <table>
        <?php $_from = $this->_tpl_vars['arrDatosProy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cid'] => $this->_tpl_vars['con']):
?>
            <?php $this->assign('fchResol', ((is_array($_tmp="-")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['con']['resolucion']) : explode($_tmp, $this->_tpl_vars['con']['resolucion']))); ?> 
            <?php $this->assign('fchEleg', ((is_array($_tmp="-")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['con']['elegibilidad']) : explode($_tmp, $this->_tpl_vars['con']['elegibilidad']))); ?> 
            <tr>
                <?php if ($this->_tpl_vars['con']['elegibilidad'] != ""): ?>
                    <th>RESOLUCIÓN DE ELEGIBILIDAD</th>
                    <td><?php echo $this->_tpl_vars['fchEleg'][0]; ?>
 de <?php echo ((is_array($_tmp=$this->_tpl_vars['fchEleg'][1])) ? $this->_run_mod_handler('date_format', true, $_tmp, " %e %B de %Y") : smarty_modifier_date_format($_tmp, " %e %B de %Y")); ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['con']['resolucion'] != ""): ?>

                    <th>RESOLUCIÓNES <br> MODIFICATORIAS E <br> INDEXACIÒN</th>
                    <td colspan="3"><?php echo $this->_tpl_vars['fchResol'][0]; ?>
 de <?php echo ((is_array($_tmp=$this->_tpl_vars['fchResol'][1])) ? $this->_run_mod_handler('date_format', true, $_tmp, " %e %B de %Y") : smarty_modifier_date_format($_tmp, " %e %B de %Y")); ?>
</td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">LOCALIZACIÓN</th>
            </tr>
            <tr>
                <?php if ($this->_tpl_vars['con']['txtDireccion'] != ""): ?>
                    <th>DIRECCIÓN</th>
                    <td><?php echo $this->_tpl_vars['con']['txtBarrio']; ?>
 <br><?php echo $this->_tpl_vars['con']['TxtNombrePlanParcial']; ?>
 / <?php echo $this->_tpl_vars['con']['txtDireccion']; ?>
</td>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['con']['resolucion'] != ""): ?>
                    <th>LOCALIDAD</th>
                    <td colspan="3"><?php echo $this->_tpl_vars['con']['txtLocalidad']; ?>
</td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">OFERENTE / CONSTRUCTOR / INTERVENTOR</th>
            </tr>
            <tr>
                <?php if ($this->_tpl_vars['con']['txtNombreOferente'] != ""): ?>
                    <th>OFERENTE</th>
                    <td><?php echo $this->_tpl_vars['con']['txtNombreOferente']; ?>
</td>
                <?php endif; ?>
                <th>CONSTRUCTOR</th>
                <td><?php echo $this->_tpl_vars['con']['txtNombreConstructor']; ?>
</td>
                <th>INTERVENTOR</th>
                <td><?php echo $this->_tpl_vars['con']['interventor']; ?>
</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">DATOS GENERALES DEL PROYECTO RELACIONADOS CON EL SUBSIDIO</th>
            </tr>
            <tr>
                <?php if ($this->_tpl_vars['con']['Costos'] != ""): ?>
                    <th>VALOR DEL PROYECTO</th>
                    <td>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['con']['Costos'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['con']['soluciones'] != ""): ?>
                    <th>No. SOLUCIONES VIP</th>
                    <td><?php echo $this->_tpl_vars['con']['soluciones']; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['con']['soluciones'] != ""): ?>
                    <th>No. SOLUCIONES VIs</th>
                    <td>0</td>
                <?php endif; ?>
            </tr>
            <tr>
                <?php if ($this->_tpl_vars['con']['valSDVE'] != ""): ?>
                    <th>VALOR DEL SDVE</th>
                    <td>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['con']['valSDVE'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['con']['valTorres'] != ""): ?>
                    <th>No. TORRES VIP</th>
                    <td><?php echo $this->_tpl_vars['con']['valTorres']; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['con']['soluciones'] != ""): ?>
                    <th>No. TORRES VIS</th>
                    <td>0</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>MODALIDAD DE DESEMBOLSO / ESQUEMA FINANCIACIÓN</th>
                <td><?php echo $this->_tpl_vars['con']['ModalidadDesembolso']; ?>
</td>
                <th>AREA CONSTRUIDA UNIDAD VIP</th>
                <td><?php echo $this->_tpl_vars['con']['area']; ?>
</td>
                <th>AREA CONSTRUIDA UNIDAD VIS</th>
                <td>0</td>

            </tr>
            <tr>
                <th>FIDICIARIA</th>
                <td><?php echo $this->_tpl_vars['con']['fiduciaria']; ?>
</td>
                <th>TIPO DE SOLUCIÓN VIP</th>
                <td><?php echo $this->_tpl_vars['con']['txtTipoSolucion']; ?>
</td>
                <th>TIPO DE SOLUCIÓN VIS</th>
                <td>0</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">BENEFICIARIOS</th>
            </tr>
            <tr>
                <th>POBLACIÓN BENEFICIARIA</th>
                <td>Vulnerable/ Desplazado/ Reasentamiento/ VIPA</td>
                <?php if ($this->_tpl_vars['con']['cuposvinculados'] != ""): ?>
                    <th>CUPOS VINCULADOS</th>
                    <td colspan="3"><?php echo $this->_tpl_vars['con']['cuposvinculados']; ?>
</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>ESQUEMA DE POSTULACIÓN</th>
                <td><?php echo $this->_tpl_vars['con']['txtTipoEsquema']; ?>
</td>
                <?php if ($this->_tpl_vars['con']['cuposvinculados'] != ""): ?>
                    <th>CUPOS POR VINCULAR</th>
                    <td colspan="3"><?php echo $this->_tpl_vars['con']['soluciones']-$this->_tpl_vars['con']['cuposvinculados']; ?>
</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; endif; unset($_from); ?>   
    </table>
    <table>
        <tr>
            <th>Entidad</th>
            <th>Código</th>
            <th>Trámite</th>
            <th>Comentario</th>
        </tr>
        <?php $_from = $this->_tpl_vars['arrListaEntidades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idList'] => $this->_tpl_vars['lista']):
?>
            <tr>
                <td><?php echo $this->_tpl_vars['lista']['txtNombreEntidad']; ?>
</td>
                <td><?php echo $this->_tpl_vars['lista']['txtCodigoEntidad']; ?>
</td>
                <td><?php echo $this->_tpl_vars['lista']['txtTramiteEntidad']; ?>
</td>
                <td><?php echo $this->_tpl_vars['lista']['txtComentarioEntidad']; ?>
</td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
</div>
