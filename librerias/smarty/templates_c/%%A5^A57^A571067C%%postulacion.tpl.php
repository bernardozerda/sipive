<?php /* Smarty version 2.6.26, created on 2017-05-05 04:22:12
         compiled from postulacionIndividual/postulacion.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'postulacionIndividual/postulacion.tpl', 543, false),array('modifier', 'number_format', 'postulacionIndividual/postulacion.tpl', 572, false),array('function', 'math', 'postulacionIndividual/postulacion.tpl', 544, false),)), $this); ?>
<!-- ********************************************************** 
        PLANTILLA DE POSTLACION ESUQEMA DE POSTULACION INDIVIDUAL
*************************************************************** -->
<?php $this->assign('seqEstadoProceso', $this->_tpl_vars['objFormulario']->seqEstadoProceso); ?>
<?php $this->assign('txtFuncion', "pedirConfirmacion('mensajes', this, './contenidos/postulacionIndividual/pedirConfirmacion.php')"); ?>

<form name="frmIndividual" id="frmIndividual" onSubmit="<?php echo $this->_tpl_vars['txtFuncion']; ?>
;
        return false;" autocomplete=off >

    <!-- CODIGO PARA EL SEGUIMIENTO Y BOTON SUBMIT DEL FORMULARIO -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'subsidios/pedirSeguimiento.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <!-- TABLA PARA IMPRIMIR EL FORMULARIO DE POSTULACION -->
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
        <tr>
            <td width="150px" align="center">
                <?php if ($this->_tpl_vars['txtImpresion'] != ""): ?>
                    <a href="#" onClick="javascript: <?php echo $this->_tpl_vars['txtImpresion']; ?>
">Imprimir Formulario</a>
                <?php endif; ?>
            </td>
            <!-- Si la ETAPA del hogar es INSCRIPCIÓN (1) 'NO MUESTRA' el campo 'Cerrar Postulación' -->
            <?php if ($this->_tpl_vars['objFormulario']->seqEtapa != 1 && $this->_tpl_vars['objFormulario']->seqEstadoProceso == 54 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 7): ?>
                <td align="center">
                    <?php if ($this->_tpl_vars['txtImpresion'] != ""): ?>
                        Cerrar Postulaci&oacute;n 
                        <input type="checkbox"
                               name="bolCerrado"
                               id="bolCerrado"
                               value="1"
                               <?php if ($this->_tpl_vars['objFormulario']->bolCerrado == 1): ?> checked <?php endif; ?> >
                    <?php else: ?>
                        <strong>
                            <?php if ($this->_tpl_vars['objFormulario']->bolCerrado == 1): ?> 
                                Formulario Cerrado
                            <?php else: ?>
                                Formulario Abierto
                            <?php endif; ?>
                        </strong>
                        <input type="hidden"
                               name="bolCerrado"
                               id="bolCerrado"
                               value="<?php echo $this->_tpl_vars['objFormulario']->bolCerrado; ?>
" >
                    <?php endif; ?>
                </td>
            <?php else: ?>
                <td align="center">
                    <strong>
                        <?php if ($this->_tpl_vars['objFormulario']->bolCerrado == 1): ?> 
                            Formulario Cerrado
                        <?php else: ?>
                            Formulario Abierto
                        <?php endif; ?>
                    </strong>
                    <input type="hidden"
                           name="bolCerrado"
                           id="bolCerrado"
                           value="<?php echo $this->_tpl_vars['objFormulario']->bolCerrado; ?>
" >
                </td>
            <?php endif; ?>

            <td align="right" style="padding-right: 10px;" width="250px">
                <?php if ($_SESSION['privilegios']['crear'] == 1 || $_SESSION['privilegios']['editar'] == 1): ?>
                    <input type="submit" name="salvar" id="salvar" value="Salvar Postulaci&oacute;n">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- SI TIENE SANCION SE MUESTRA -->
    <?php if ($this->_tpl_vars['objFormulario']->bolSancion == 1): ?>
        <p style="background-color: #FF0000; color:white;">HOGAR SANCIONADO</p>
    <?php endif; ?>
    <input type="hidden" value="<?php echo $this->_tpl_vars['objFormulario']->bolSancion; ?>
" id="bolSancion" name="bolSancion">

    <!-- TAB VIEW PRINCIPAL -->
    <div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <li><a href="#aad"><em>Actos Administrativos</em></a></li>
        </ul>            
        <div class="yui-content">

            <!-- FORMULARIO DE POSTULACION -->	    
            <div id="frm" style="height:510px;">

                <!-- TABLA DE ESTADO DEL PROCESO Y NUMERO DEL FORMULARIO -->
                <p>
                <table cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td style="width:100px;">
                            <b>Estado</b>
                        </td>
                        <td style="width:350px;" align="left">
                            <?php echo $this->_tpl_vars['arrEstado'][$this->_tpl_vars['seqEstadoProceso']]; ?>

                            <input type="hidden" 
                                   name="seqEstadoProceso" 
                                   id="seqEstadoProceso" 
                                   value="<?php echo $this->_tpl_vars['seqEstadoProceso']; ?>
"
                                   >
                        </td>
                        <td align="right">
                            <?php if ($this->_tpl_vars['txtTutorDesembolso'] != ""): ?>
                                <b>Tutor de Desembolso: </b> <?php echo $this->_tpl_vars['txtTutorDesembolso']; ?>

                            <?php else: ?>
                                &nbsp;
                            <?php endif; ?>
                        </td>
                    </tr>
                    <!-- Si la ETAPA del hogar es INSCRIPCIÓN (1) 'NO MUESTRA' el campo 'No. formulario' -->
                    <?php if ($this->_tpl_vars['objFormulario']->seqEtapa != 1 && $this->_tpl_vars['objFormulario']->seqEstadoProceso == 54 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 7): ?>
                        <tr>
                            <!-- NUMERO DEL FORMULARIO -->
                            <td><b>No.Formulario</b></td>
                            <td align="left">
                                <?php if ($this->_tpl_vars['txtImpresion'] != ""): ?>
                                    <input type="text" 
                                           name="txtFormulario" 
                                           id="txtFormulario" 
                                           value="<?php echo $this->_tpl_vars['objFormulario']->txtFormulario; ?>
"
                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                           onBlur="sinCaracteresEspeciales(this);
                                                   this.style.backgroundColor = '#FFFFFF';" 
                                           style="width:100px;"
                                           />
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['objFormulario']->txtFormulario; ?>

                                    <input type="hidden" 
                                           name="txtFormulario" 
                                           id="txtFormulario" 
                                           value="<?php echo $this->_tpl_vars['objFormulario']->txtFormulario; ?>
"
                                           >
                                <?php endif; ?>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <!-- NUMERO DEL FORMULARIO -->
                            <td><b>No.Formulario</b></td>
                            <td align="left">
                                <?php echo $this->_tpl_vars['objFormulario']->txtFormulario; ?>

                                <input type="hidden" 
                                       name="txtFormulario" 
                                       id="txtFormulario" 
                                       value="<?php echo $this->_tpl_vars['objFormulario']->txtFormulario; ?>
" >
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endif; ?>
                </table>
                </p>

                <!-- SUB - PESTANAS DEL FORMULARIO DE POSTULACION -->
                <div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
                    <ul class="yui-nav">
                        <li class="selected"><a href="#composicion"><em>Composición Familiar</em></a></li>
                        <li><a href="#datosHogar"><em>Datos del Hogar</em></a></li>
                        <li><a href="#modalidad"><em>Datos de la Postulación</em></a></li>
                        <li><a href="#financiera"><em>Información Financiera</em></a></li>
                    </ul>            
                    <div class="yui-content">

                        <!-- COMPOSICION FAMILIAR -->				    
                        <div id="composicion" style="height:420px; overflow:auto;"><p>

                                <!-- TABLA PARA LAS FECHAS DE INSCRIPCION, POSTULACION, ULTIMA ACTUALIZACION -->
                            <table cellpadding="3" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <td class="tituloTabla">Fecha de Inscripción:</td>
                                    <td class="tituloTabla">Fecha de Postulación:</td>
                                    <td class="tituloTabla">Última Actualización:</td>
                                    <td class="tituloTabla">Vigencia de SDV:</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:10px"><?php echo $this->_tpl_vars['objFormulario']->fchInscripcion; ?>
</td>                                                                
                                    <td style="padding-left:10px"><?php echo $this->_tpl_vars['objFormulario']->fchPostulacion; ?>
</td>
                                <input type="hidden" name="fchPostulacion" id="fchPostulacion" value="<?php echo $this->_tpl_vars['objFormulario']->fchPostulacion; ?>
"/>
                                <td style="padding-left:10px"><?php echo $this->_tpl_vars['objFormulario']->fchUltimaActualizacion; ?>
</td>                                
                                <td style="padding-left:10px"><?php echo $this->_tpl_vars['objFormulario']->fchVigencia; ?>
</td>
                                </tr>
                            </table>

                            <!-- TABLA PARA AGREGAR UN MIEMBRO DE HOGAR -->
                            <p>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <tr>
                                    <td style="padding-right:15px;" align="right" height="20px" valign="middle" bgcolor="#E4E4E4">
                                        <?php if ($this->_tpl_vars['objFormulario']->bolSancion != 1): ?>
                                            <a href="#" 
                                               onClick="mostrarOcultar('agregarMiembro');
                                                       document.getElementById('tipoDocumento').focus();"
                                               > Agregar Miembro al Hogar </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="agregarMiembro" style="display: none;">
                                        <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
                                            <tr>
                                                <!-- TIPO DE DOCUMENTO -->
                                                <td width="15%">Tipo Documento</td>
                                                <td width="35%" align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="tipoDocumento" 
                                                            style="width:90%;"
                                                            >
                                                        <?php $_from = $this->_tpl_vars['arrTipoDocumento']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoDocumento'] => $this->_tpl_vars['txtTipoDocumento']):
?>
                                                            <?php if ($this->_tpl_vars['seqTipoDocumento'] != 6): ?>
                                                                <option value="<?php echo $this->_tpl_vars['seqTipoDocumento']; ?>
"><?php echo $this->_tpl_vars['txtTipoDocumento']; ?>
</option>
                                                            <?php endif; ?>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                                <!-- NUMERO DEL DOCUMENTO -->
                                                <td width="15%">Número Documento</td>
                                                <td width="35%" align="center">
                                                    <input type="text" 
                                                           id="numeroDoc" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           onKeyUp="formatoSeparadores(this)"
                                                           onChange="formatoSeparadores(this)"
                                                           style="width:90%;" 
                                                           >
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- PRIMER APELLIDO -->
                                                <td>Primer Apellido</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="apellido1" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:90%;"
                                                           >
                                                </td>
                                                <!-- SEGUNDO APELLIDO -->
                                                <td>Segundo Apellido</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="apellido2" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:90%;"
                                                           >
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- PRIMER NOMBRE -->
                                                <td>Primer Nombre</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="nombre1" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetrasEspacio(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:90%;"
                                                           />
                                                </td>
                                                <!-- SEGUNDO NOMBRE -->
                                                <td>Segundo Nombre</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="nombre2" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloLetras(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           style="width:90%;"
                                                           />
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- PARENTESCO -->
                                                <td>Parentesco</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="parentesco" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="0">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrParentesco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqParentesco'] => $this->_tpl_vars['txtParentesco']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqParentesco']; ?>
"><?php echo $this->_tpl_vars['txtParentesco']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                                <!-- ESTADO CIVIL -->
                                                <td>Estado Civil</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="estadoCivil" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="0">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrEstadoCivil']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstadoCivil'] => $this->_tpl_vars['txtEstadoCivil']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqEstadoCivil']; ?>
"
                                                                    <?php if ($this->_tpl_vars['seqEstadoCivil'] == 1 || $this->_tpl_vars['seqEstadoCivil'] == 3 || $this->_tpl_vars['seqEstadoCivil'] == 4 || $this->_tpl_vars['seqEstadoCivil'] == 5): ?>
                                                                        style="color:#666666"
                                                                        disabled
                                                                    <?php endif; ?>
                                                                    >
                                                                <?php echo $this->_tpl_vars['txtEstadoCivil']; ?>

                                                            </option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- FECHA DE NACIMIENTO -->
                                                <td>Fecha Nacimiento</td>
                                                <td style="padding-left:16px">
                                                    <input	type="text" 
                                                           id="fechaNac"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:80px" 
                                                           value=""
                                                           readonly
                                                           /> <a onClick="calendarioPopUp('fechaNac')" href="#">Calendario</a>
                                                    <a onClick="document.getElementById('fechaNac').value = '';" href="#">Limpiar</a>
                                                </td>

                                                <!-- CONDICION ESPECIAL -->
                                                <td>Condici&oacute;n Especial 1</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="6">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"><?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- CONDICION ETNICA -->
                                                <td>Condición Etnica</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEtnica" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="1">NINGUNA </option>
                                                        <?php $_from = $this->_tpl_vars['arrCondicionEtnica']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEtnia'] => $this->_tpl_vars['txtEtnia']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqEtnia']; ?>
"><?php echo $this->_tpl_vars['txtEtnia']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>

                                                <!-- CONDICION ESPECIAL 2 -->
                                                <td>Condición Especial 2</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial2" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="6">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"><?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- SEXO -->
                                                <td>Sexo</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="sexo" 
                                                            style="width:90%;"
                                                            >
                                                        <?php $_from = $this->_tpl_vars['arrSexo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSexo'] => $this->_tpl_vars['txtSexo']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqSexo']; ?>
"><?php echo $this->_tpl_vars['txtSexo']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>

                                                <!-- CONDICION ESPECIAL 3 -->
                                                <td>Condición Especial 3</td>
                                                <td align="center">
                                                    <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="condicionEspecial3" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="6">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"><?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- LGTBI Y HOGAR VICTIMA (DESPLAZADO) -->
                                            <tr>
                                                <td>Grupo LGTBI<img src="recursos/imagenes/blank.gif" onload="cambiaLgtbi()"></td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="seqGrupoLgtbi" 
                                                            onChange="cambiaLgtbi()"
                                                            style="width:90%;"
                                                            >
                                                        <option value="0">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrGrupoLgtbi']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqGrupoLgtbi'] => $this->_tpl_vars['txtGrupoLgtbi']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqGrupoLgtbi']; ?>
">
                                                                <?php echo $this->_tpl_vars['txtGrupoLgtbi']; ?>

                                                            </option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                                <td>Hecho Victimizante</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="seqTipoVictima"
                                                            style="width:90%;"
                                                            >
                                                        <option value="0">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrTipoVictima']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoVictima'] => $this->_tpl_vars['txtTipoVictima']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqTipoVictima']; ?>
">
                                                                <?php echo $this->_tpl_vars['txtTipoVictima']; ?>

                                                            </option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- GRUPO LGTBI Y NIVEL EDUCATIVO -->
                                            <tr>
                                                <td>LGTBI</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="bolLgtb" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="0" disabled>No</option>
                                                        <option value="1" disabled>Si</option>
                                                    </select>
                                                </td>
                                                <td>Nivel Educativo</td>
                                                <td align="center">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="nivelEducativo" 
                                                            style="width:90%;"
                                                            >
                                                        <option value="1">Ninguno</option>
                                                        <?php $_from = $this->_tpl_vars['arrNivelEducativo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqNivelEducativo'] => $this->_tpl_vars['txtNivelEducativo']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqNivelEducativo']; ?>
"><?php echo $this->_tpl_vars['txtNivelEducativo']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- INGRESOS MENSUALES -->
                                            <tr>
                                                <td>Ingresos</td>
                                                <td align="center">
                                                    <input type="text" 
                                                           id="ingresos" 
                                                           value="" 
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="soloNumeros(this);
                                                                   this.style.backgroundColor = '#FFFFFF';" 
                                                           onkeyup="formatoSeparadores(this)"
                                                           onchange="formatoSeparadores(this)"
                                                           style="width:90%; text-align: right;"
                                                           />
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <!-- OCUPACION -->
                                                <td>Ocupación</td>
                                                <td align="center" colspan="3">
                                                    <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                            id="ocupacion" 
                                                            style="width:96%;"
                                                            >
                                                        <option value="20">NINGUNO</option>
                                                        <?php $_from = $this->_tpl_vars['arrOcupacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqOcupacion'] => $this->_tpl_vars['txtOcupacion']):
?>
                                                            <option value="<?php echo $this->_tpl_vars['seqOcupacion']; ?>
"><?php echo $this->_tpl_vars['txtOcupacion']; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- AGREGAR AL FORMULARIO -->
                                                <td colspan="4" align="right" height="25px" valign="top" style="padding-right:10px">
                                                    <img src="./recursos/imagenes/bullet.jpg" 
                                                         border="0"
                                                         style="cursor:pointer"
                                                         onClick="agregarMiembroHogarPostulacion();"
                                                         />&nbsp;
                                                    <a href="#" onClick="agregarMiembroHogarPostulacion();">Agregar</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            </p>

                            <!-- IMPRIMIR LOS MIEMBROS DE HOGAR CON TODOS LOS DATOS -->
                            <div id="datosHogar">

                                <?php $this->assign('valTotal', 0); ?>
                                <?php $_from = $this->_tpl_vars['objFormulario']->arrCiudadano; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCiudadano'] => $this->_tpl_vars['objCiudadano']):
?>

                                    <?php $this->assign('tipoDocumento', $this->_tpl_vars['objCiudadano']->seqTipoDocumento); ?>
                                    <?php $this->assign('parentesco', $this->_tpl_vars['objCiudadano']->seqParentesco); ?>
                                    <?php $this->assign('estadoCivil', $this->_tpl_vars['objCiudadano']->seqEstadoCivil); ?>
                                    <?php $this->assign('condicionEspecial', $this->_tpl_vars['objCiudadano']->seqCondicionEspecial); ?>
                                    <?php $this->assign('condicionEspecial2', $this->_tpl_vars['objCiudadano']->seqCondicionEspecial2); ?>
                                    <?php $this->assign('condicionEspecial3', $this->_tpl_vars['objCiudadano']->seqCondicionEspecial3); ?>
                                    <?php $this->assign('codicionEtnica', $this->_tpl_vars['objCiudadano']->seqEtnia); ?>
                                    <?php $this->assign('sexo', $this->_tpl_vars['objCiudadano']->seqSexo); ?>
                                    <?php $this->assign('grupoLgtbi', $this->_tpl_vars['objCiudadano']->seqGrupoLgtbi); ?>
                                    <?php $this->assign('tipoVictima', $this->_tpl_vars['objCiudadano']->seqTipoVictima); ?>
                                    <?php $this->assign('lgbt', $this->_tpl_vars['objCiudadano']->bolLgbt); ?>
                                    <?php $this->assign('nivelEducativo', $this->_tpl_vars['objCiudadano']->seqNivelEducativo); ?>
                                    <?php $this->assign('ocupacion', $this->_tpl_vars['objCiudadano']->seqOcupacion); ?>

                                    <?php $this->assign('valIngresosCiudadano', ((is_array($_tmp=$this->_tpl_vars['objCiudadano']->valIngresos)) ? $this->_run_mod_handler('replace', true, $_tmp, '[^0-9]', '') : smarty_modifier_replace($_tmp, '[^0-9]', ''))); ?>
                                    <?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['valTotal'],'y' => $this->_tpl_vars['valIngresosCiudadano'],'assign' => 'valTotal'), $this);?>


                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
">
                                        <tr onMouseOver="this.style.background = '#E4E4E4';"
                                            onMouseOut="this.style.background = '#F9F9F9';"
                                            style="cursor:pointer"
                                            >
                                            <td align="center" width="18px" height="22px">
                                                <div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                     onClick="desplegarDetallesMiembroHogar('<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
')"
                                                     onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                     onMouseOut="this.style.backgroundColor = '#F9F9F9';"
                                                     id="masDetalles<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
"
                                                     >+</div>  
                                            </td>
                                            <td width="282px" style="padding-left:5px;">
                                                <?php echo $this->_tpl_vars['objCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtNombre2; ?>
 
                                                <?php echo $this->_tpl_vars['objCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtApellido2; ?>

                                            </td>
                                            <td width="140px" align="right" style="padding-right: 15px">
                                                <?php if ($this->_tpl_vars['tipoDocumento'] == 1): ?>     C.C.
                                                <?php elseif ($this->_tpl_vars['tipoDocumento'] == 2): ?> C.E.
                                                <?php elseif ($this->_tpl_vars['tipoDocumento'] == 3): ?> T.I.
                                                <?php elseif ($this->_tpl_vars['tipoDocumento'] == 4): ?> R.C.
                                                <?php elseif ($this->_tpl_vars['tipoDocumento'] == 5): ?> PAS.
                                                <?php elseif ($this->_tpl_vars['tipoDocumento'] == 6): ?> NIT.
                                                <?php else: ?> <?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocumento']]; ?>
  
                                                <?php endif; ?>
                                                <?php echo ((is_array($_tmp=$this->_tpl_vars['objCiudadano']->numDocumento)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, '.', '.') : number_format($_tmp, 0, '.', '.')); ?>

                                            </td>
                                            <td width="260px">
                                                <?php echo $this->_tpl_vars['arrParentesco'][$this->_tpl_vars['parentesco']]; ?>

                                            </td>
                                            <td align="right" style="padding-right:7px">
                                                $ <?php echo ((is_array($_tmp=$this->_tpl_vars['objCiudadano']->valIngresos)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                            </td>
                                            <?php if ($this->_tpl_vars['objFormulario']->bolSancion != 1): ?>
                                                <td align="center" width="18px" height="22px">
                                                    <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                         onClick="modificarMiembroHogar('<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
')"
                                                         onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                                         onMouseOut="this.style.backgroundColor = '#F9F9F9';"
                                                         >E</div>  
                                                </td>
                                                <td align="center" width="18px" height="22px">
                                                    <div	style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999;" 
                                                         onClick="quitarMiembroHogar('<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
');"
                                                         onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                         onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                                         >X</div>  
                                                </td>
                                            <?php endif; ?>
                                        </tr>

                                        <!-- TODAS ESTAS VARIABLES DEBEN ESTAR DENTRO DE ESTA TABLA -->
                                        <input type="hidden" id="parentesco-<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
" value="<?php echo $this->_tpl_vars['objCiudadano']->seqParentesco; ?>
">
                                        <input type="hidden" id="ingreso-<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
" value="<?php echo $this->_tpl_vars['objCiudadano']->valIngresos; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-txtNombre1" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][txtNombre1]" value="<?php echo $this->_tpl_vars['objCiudadano']->txtNombre1; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-txtNombre2" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][txtNombre2]" value="<?php echo $this->_tpl_vars['objCiudadano']->txtNombre2; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-txtApellido1" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][txtApellido1]" value="<?php echo $this->_tpl_vars['objCiudadano']->txtApellido1; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-txtApellido2" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][txtApellido2]" value="<?php echo $this->_tpl_vars['objCiudadano']->txtApellido2; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqTipoDocumento" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqTipoDocumento]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqTipoDocumento; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-numDocumento" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][numDocumento]" value="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqParentesco" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqParentesco]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqParentesco; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-valIngresos" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][valIngresos]" value="<?php echo $this->_tpl_vars['objCiudadano']->valIngresos; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-fchNacimiento" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][fchNacimiento]" value="<?php echo $this->_tpl_vars['objCiudadano']->fchNacimiento; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqCondicionEspecial" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqCondicionEspecial]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqCondicionEspecial; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqCondicionEspecial2" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqCondicionEspecial2]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqCondicionEspecial2; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqCondicionEspecial3" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqCondicionEspecial3]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqCondicionEspecial3; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqEtnia" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqEtnia]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqEtnia; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqEstadoCivil" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqEstadoCivil]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqEstadoCivil; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqOcupacion" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqOcupacion]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqOcupacion; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqSexo" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqSexo]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqSexo; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqGrupoLgtbi" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqGrupoLgtbi]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqGrupoLgtbi; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-bolLgtb" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][bolLgtb]" value="<?php echo $this->_tpl_vars['objCiudadano']->bolLgtb; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqTipoVictima" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqTipoVictima]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqTipoVictima; ?>
">
                                        <input type="hidden" id="<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
-seqNivelEducativo" name="hogar[<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
][seqNivelEducativo]" value="<?php echo $this->_tpl_vars['objCiudadano']->seqNivelEducativo; ?>
">
                                    </table>

                                    <!-- TABLA DE DETALLES DEL CIUDADANO -->    
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none;" id="detalles<?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
">
                                        <tr>
                                            <td colspan="6">
                                                <table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999;">
                                                    <tr>
                                                        <td><b>Estado Civil:</b> <?php echo $this->_tpl_vars['arrEstadoCivil'][$this->_tpl_vars['estadoCivil']]; ?>
</td>
                                                        <td><b>Condición Étnica:</b><?php if (isset ( $this->_tpl_vars['arrCondicionEtnica'][$this->_tpl_vars['codicionEtnica']] )): ?> <?php echo $this->_tpl_vars['arrCondicionEtnica'][$this->_tpl_vars['codicionEtnica']]; ?>
 <?php else: ?> Ninguna <?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="50%"><b>Sexo:</b> <?php echo $this->_tpl_vars['arrSexo'][$this->_tpl_vars['sexo']]; ?>
</td>
                                                        <td><b>Condición Especial 1:</b><?php if (isset ( $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial']] )): ?> <?php echo $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial']]; ?>
<?php else: ?>Ninguna<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Fecha de Nacimiento:</b> <?php echo $this->_tpl_vars['objCiudadano']->fchNacimiento; ?>
</td>
                                                        <td><b>Condición Especial 2:</b><?php if (isset ( $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial2']] )): ?> <?php echo $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial2']]; ?>
<?php else: ?>Ninguna<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nivel Educativo:</b> <?php if (isset ( $this->_tpl_vars['arrNivelEducativo'][$this->_tpl_vars['nivelEducativo']] )): ?><?php echo $this->_tpl_vars['arrNivelEducativo'][$this->_tpl_vars['nivelEducativo']]; ?>
<?php else: ?>Ninguno<?php endif; ?></td>
                                                        <td><b>Condición Especial 3:</b> <?php if (isset ( $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial3']] )): ?> <?php echo $this->_tpl_vars['arrCondicionEspecial'][$this->_tpl_vars['condicionEspecial3']]; ?>
<?php else: ?>Ninguna<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>LGTBI:</b> 
                                                            <?php if ($this->_tpl_vars['objCiudadano']->bolLgtb == 1): ?>
                                                                <?php echo $this->_tpl_vars['arrGrupoLgtbi'][$this->_tpl_vars['grupoLgtbi']]; ?>
 
                                                            <?php else: ?> 
                                                                No 
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><b>Tipo de Victima:</b> <?php if (isset ( $this->_tpl_vars['arrTipoVictima'][$this->_tpl_vars['tipoVictima']] )): ?><?php echo $this->_tpl_vars['arrTipoVictima'][$this->_tpl_vars['tipoVictima']]; ?>
<?php else: ?>Ninguno<?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><b>Ocupación:</b> <?php echo $this->_tpl_vars['arrOcupacion'][$this->_tpl_vars['ocupacion']]; ?>
</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                <?php endforeach; endif; unset($_from); ?>
                            </div>

                            <!-- MUESTRA EL TOTAL DE LOS INGRESOS DEL HOGAR -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr bgcolor="#CCCCCC">
                                    <td align="center" height="20px" width="584px">
                                        <b>Total Ingresos Hogar</b>
                                    </td>
                                    <td style="padding-right:7px" align="right" id="valTotalMostrar">
                                        <?php if (intval ( $this->_tpl_vars['objFormulario']->valIngresoHogar ) == 0): ?>
                                            $ <?php echo ((is_array($_tmp=$this->_tpl_vars['valTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                        <?php else: ?>
                                            $ <?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valIngresoHogar)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td width="18px">&nbsp;</td>
                                    <?php if (intval ( $this->_tpl_vars['objFormulario']->valIngresoHogar ) == 0): ?>
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="<?php echo $this->_tpl_vars['valTotal']; ?>
">
                                <?php else: ?>
                                    <input type="hidden" name="valIngresoHogar" id="valIngresoHogar" value="<?php echo $this->_tpl_vars['objFormulario']->valIngresoHogar; ?>
">
                                <?php endif; ?>
                                <td width="18px">&nbsp;</td>
                                </tr>
                            </table>

                            </p></div>

                        <!-- DATOS DEL HOGAR -->				    
                        <div id="hogar" style="height:409px;"><p>
                            <p><table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF"  style="border: 1px dotted #999999; padding:5px">
                                <tr>
                                    <!-- VIVIENDA ACTUAL -->
                                    <td width="130px">Vivienda Actual </td>
                                    <td width="210px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqVivienda" 
                                                id="seqVivienda" 
                                                style="width:260px;"
                                                >
                                            <?php $_from = $this->_tpl_vars['arrVivienda']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqVivienda'] => $this->_tpl_vars['txtVivienda']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqVivienda']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqVivienda == $this->_tpl_vars['seqVivienda']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtVivienda']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>

                                    <!-- SI PAGA ARRIENDO, CUANTO PAGA -->
                                    <td>Valor del Arriendo</td>
                                    <td width="210px">
                                        $ <input type="text" 
                                                 name="valArriendo" 
                                                 id="valArriendo" 
                                                 value="<?php echo $this->_tpl_vars['objFormulario']->valArriendo; ?>
" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';" 
                                                 style="width:249px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- FECHA DESDE LA QUE PAGA ARRIENDO -->
                                    <td>
                                        Paga Arriendo Desde
                                    </td>
                                    <td>
                                        <input type="text" 
                                               name="fchArriendoDesde" 
                                               id="fchArriendoDesde" 
                                               value="<?php if ($this->_tpl_vars['objFormulario']->fchArriendoDesde != '0000-00-00'): ?><?php echo $this->_tpl_vars['objFormulario']->fchArriendoDesde; ?>
<?php endif; ?>" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:80px;" 
                                               readonly
                                               />
                                        <a onClick="calendarioPopUp('fchArriendoDesde')" href="#">Calendario</a>&nbsp;
                                        <a onClick="document.getElementById('fchArriendoDesde').value = '';" href="#">Limpiar</a>
                                    </td>
                                    <td>
                                        Comprobante Arriendo
                                    </td>
                                    <td>
                                        <select name="txtComprobanteArriendo"
                                                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                style="width:260px;"
                                                >
                                            <option value="">SELECCIONE</option>
                                            <option value="no" <?php if ($this->_tpl_vars['objFormulario']->txtComprobanteArriendo == 'no'): ?> selected <?php endif; ?>>No</option>
                                            <option value="si" <?php if ($this->_tpl_vars['objFormulario']->txtComprobanteArriendo == 'si'): ?> selected <?php endif; ?>>Si</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr> 
                                    <!-- DIRECCION DE RESIDENCIA -->
                                    <td>
                                        <a href="#" id="Direccion" onClick="recogerDireccion('txtDireccion', 'objDireccionOculto')">Dirección</a>
                                    </td>
                                    <td colspan="3">
                                        <input	type="text" 
                                               name="txtDireccion" 
                                               id="txtDireccion"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtDireccion; ?>
"
                                               style="width:680px;"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               readonly
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- CIUDAD -->
                                    <td>Ciudad</td>
                                    <td>
                                        <select            
                                            name="seqCiudad" 
                                            id="seqCiudad" 
                                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                            style="width:260px;" 
                                            onChange="cambiarCiudad(this);"
                                            ><option value="">Seleccione</option>
                                            <?php $_from = $this->_tpl_vars['arrCiudad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCiudad'] => $this->_tpl_vars['txtCiudad']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqCiudad']; ?>
" 
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqCiudad == $this->_tpl_vars['seqCiudad']): ?> selected <?php endif; ?>
                                                        > <?php echo $this->_tpl_vars['txtCiudad']; ?>
</option>            
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>    
                                    </td>

                                    <!-- LOCALIDAD -->
                                    <td>Localidad </td>
                                    <td id="tdlocalidad">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="obtenerBarrio(this);"
                                                name="seqLocalidad" 
                                                id="seqLocalidad" 
                                                style="width:260px;"
                                                >
                                            <option value="1" selected>Seleccione</option>
                                            <?php if (intval ( $this->_tpl_vars['objFormulario']->seqCiudad ) != 0): ?>
                                                <?php if (intval ( $this->_tpl_vars['objFormulario']->seqCiudad ) == 149): ?> <!-- BOGOTA -->
                                                    <?php $_from = $this->_tpl_vars['arrLocalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqLocalidad'] => $this->_tpl_vars['txtLocalidad']):
?>
                                                        <?php if (intval ( $this->_tpl_vars['seqLocalidad'] ) != 22): ?>
                                                            <option value="<?php echo $this->_tpl_vars['seqLocalidad']; ?>
"
                                                                    <?php if ($this->_tpl_vars['objFormulario']->seqLocalidad == $this->_tpl_vars['seqLocalidad']): ?> 
                                                                        selected 
                                                                    <?php endif; ?>
                                                                    >                    
                                                                <?php echo $this->_tpl_vars['txtLocalidad']; ?>

                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                <?php else: ?> <!-- FUERA DE BOGOTA -->
                                                    <option value="22"
                                                            <?php if ($this->_tpl_vars['objFormulario']->seqLocalidad == 22): ?> 
                                                                selected 
                                                            <?php endif; ?>
                                                            >                    
                                                        Fuera de Bogotá
                                                    </option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- BARRIO -->
                                    <td valign="top" height="22px">Barrio</td>
                                    <td valign="top" align="left" id="tdBarrio">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onChange="obtenerUpz(this);" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqBarrio" 
                                                id="seqBarrio" 
                                                style="width:260px;"
                                                >
                                            <option value="0">Seleccione</option>
                                            <?php if (intval ( $this->_tpl_vars['objFormulario']->seqLocalidad ) != 0): ?>
                                                <?php $_from = $this->_tpl_vars['arrBarrio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBarrio'] => $this->_tpl_vars['txtBarrio']):
?>
                                                    <option value="<?php echo $this->_tpl_vars['seqBarrio']; ?>
" 
                                                            <?php if ($this->_tpl_vars['objFormulario']->seqBarrio == $this->_tpl_vars['seqBarrio']): ?> 
                                                                selected 
                                                            <?php endif; ?>
                                                            >
                                                        <?php echo $this->_tpl_vars['txtBarrio']; ?>

                                                    </option>            
                                                <?php endforeach; endif; unset($_from); ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td id="tdupz">
                                        &nbsp;<input type='hidden' readonly id='seqUpz' name='seqUpz' value="<?php echo $this->_tpl_vars['objFormulario']->seqUpz; ?>
">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                                <tr> 
                                    <td>Teléfonos</td>
                                    <td>
                                        <input	type="text" 
                                               name="numTelefono1" 
                                               id="numTelefono1" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->numTelefono1; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:122px;" 
                                               /> ó
                                        <input	type="text" 
                                               name="numTelefono2" 
                                               id="numTelefono2" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->numTelefono2; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:122px;" 
                                               />
                                    </td>
                                    <td>Teléfono Celular</td>
                                    <td>
                                        <input type="text" 
                                               name="numCelular" 
                                               id="numCelular" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->numCelular; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="soloNumeros(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:260px;" 
                                               />
                                    </td>
                                </tr>

                                <!-- CORREO ELECTRONICO -->
                                <tr> 
                                    <td>Correo Electr&oacute;nico</td>
                                    <td colspan="3">
                                        <input type="text" 
                                               name="txtCorreo" 
                                               id="txtCorreo" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtCorreo; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:680px;"
                                               class="inputLogin"
                                               />
                                    </td>
                                </tr>

                                <!-- SISBEN y DESPLAZAMIENTO FORZADO -->
                                <tr>
                                    <td>Sisben </td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqSisben" 
                                                id="seqSisben" 
                                                style="width:260px;"
                                                ><option value="0" selected>SELECCIONE</option>
                                            <?php $_from = $this->_tpl_vars['arrSisben']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSisben'] => $this->_tpl_vars['txtSisben']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqSisben']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqSisben == $this->_tpl_vars['seqSisben']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtSisben']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                    <td>Desplazamiento forzado </td>
                                    <td>
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolDesplazado" 
                                                id="bolDesplazado" 
                                                style="width:260px;"
                                                >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolDesplazado != 1): ?> selected <?php endif; ?> disabled>No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolDesplazado == 1): ?> selected <?php endif; ?> disabled>Si</option>
                                        </select>
                                    </td>
                                </tr>
                            </table></p>

                            <!-- TABLA RED DE SERVICIOS -->
                            <p><table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="border: 1px dotted #999999; padding:5px">
                                <tr>
                                    <!-- INTEGRACION SOCIAL -->
                                    <td width="110px">Integraci&oacute;n Social</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIntegracionSocial" 
                                                id="bolIntegracionSocial" 
                                                style="width:100%;"
                                                >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolIntegracionSocial != 1): ?> selected <?php endif; ?> >No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolIntegracionSocial == 1): ?> selected <?php endif; ?> >Si</option>
                                        </select>
                                    </td>

                                    <!-- SEC SALUD -->
                                    <td width="110px" align="right">Sec. Salud</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolSecSalud" 
                                                id="bolSecSalud" 
                                                style="width:100%;"
                                                >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolSecSalud != 1): ?> selected <?php endif; ?> >No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolSecSalud == 1): ?> selected <?php endif; ?> >Si</option>
                                        </select>
                                    </td>

                                    <!-- SEC EDUCACION -->
                                    <td width="110px" align="right">Sec. Educacion</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolSecEducacion" 
                                                id="bolSecEducacion" 
                                                style="width:100%;"
                                                >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolSecEducacion != 1): ?> selected <?php endif; ?> >No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolSecEducacion == 1): ?> selected <?php endif; ?> >Si</option>
                                        </select>
                                    </td>

                                    <!-- IPES -->
                                    <td width="110px" align="right">IPES</td>
                                    <td style="padding-left:10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIpes" 
                                                id="bolIpes" 
                                                style="width:100%;"
                                                >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolIpes != 1): ?> selected <?php endif; ?> >No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolIpes == 1): ?> selected <?php endif; ?> >Si</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- OTRO -->
                                    <td align="right">Otro</td>
                                    <td colspan="8" style="padding-left:10px">
                                        <input	type="text" 
                                               name="txtOtro" 
                                               id="txtOtro" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtOtro; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:100%;" 
                                               />
                                    </td>
                                </tr>
                            </table></p>
                            </p></div>

                        <!-- MODALIDAD Y VIVIENDA -->				        
                        <div id="modalidad" style="height:410px;">
                            <p>
                            <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666;">

                                <!-- PLAN DE GOBIERNO -->
                                <?php if ($this->_tpl_vars['objFormulario']->seqEtapa >= 4): ?> 
                                    <input type="hidden" name="seqPlanGobierno" id="seqPlanGobierno" value="<?php echo $this->_tpl_vars['objFormulario']->seqPlanGobierno; ?>
">
                                <?php else: ?>
                                    <input type="hidden" name="seqPlanGobierno" id="seqPlanGobierno" value="2">
                                <?php endif; ?>

                                <!-- MODALIDAD DEL SUBSIDIO y TIPO DE SOLUCION -->
                                <tr>
                                    <td>Modalidad Solución</td>
                                    <td width="260px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="seqModalidad" 
                                                id="seqModalidad" 
                                                style="width:260px;"
                                                onChange="obtenerTipoSolucion(this);"
                                                >
                                            <option value="0">Seleccione</option>
                                            <?php $_from = $this->_tpl_vars['arrModalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqModalidad'] => $this->_tpl_vars['arrDatos']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqModalidad']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqModalidad == $this->_tpl_vars['seqModalidad']): ?> 
                                                            selected 
                                                        <?php endif; ?>
                                                        <?php if ($this->_tpl_vars['arrDatos']['seqPlanGobierno'] == 1): ?>
                                                            disabled
                                                        <?php endif; ?>
                                                        >
                                                    <?php echo $this->_tpl_vars['arrDatos']['txtModalidad']; ?>

                                                </option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                        <input type='hidden' id='seqPlanGobierno' name='seqPlanGobierno' value='<?php echo $this->_tpl_vars['objFormulario']->seqPlanGobierno; ?>
'>
                                    </td>
                                    <td width="90px">Tipo Solución</td>
                                    <td id="tdTipoSolucion" align="left">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="asignarValorSubsidio(this, 'bolDesplazado');"
                                                name="seqSolucion" 
                                                id="seqSolucion" 
                                                style="width:100%;"
                                                >
                                            <option value="1">NINGUNA</option>
                                            <?php if (intval ( $this->_tpl_vars['objFormulario']->seqModalidad ) != 0): ?>                           
                                                <?php $_from = $this->_tpl_vars['arrSolucion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSolucion'] => $this->_tpl_vars['arrDatos']):
?>
                                                    <?php if ($this->_tpl_vars['objFormulario']->seqModalidad == $this->_tpl_vars['arrDatos']['seqModalidad']): ?>
                                                        <option value="<?php echo $this->_tpl_vars['seqSolucion']; ?>
"
                                                                <?php if ($this->_tpl_vars['objFormulario']->seqSolucion == $this->_tpl_vars['seqSolucion']): ?> 
                                                                    selected 
                                                                <?php endif; ?>
                                                                >
                                                            <?php echo $this->_tpl_vars['arrDatos']['txtSolucion']; ?>

                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; endif; unset($_from); ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                </tr>

                                <!-- PROYECTO -->
                                <tr>
                                    <td>Proyecto</td>
                                    <td id="tdProyecto" colspan="3" align="left">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="obtenerDatosProyecto(this, <?php echo $this->_tpl_vars['objFormulario']->seqPlanGobierno; ?>
);
                                                        obtenerUnidadProyecto(this);
                                                        obtenerConjuntoResidencial(this);"
                                                name="seqProyecto" 
                                                id="seqProyecto" 
                                                style="width:100%"
                                                >
                                            <optgroup label="Bogota Humana">
                                                <option value='0'>Ninguno</option>
                                                <?php $_from = $this->_tpl_vars['arrProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyecto'] => $this->_tpl_vars['txtProyecto']):
?>
                                                    <option value="<?php echo $this->_tpl_vars['seqProyecto']; ?>
"
                                                            <?php if ($this->_tpl_vars['objFormulario']->seqProyecto == $this->_tpl_vars['seqProyecto']): ?> 
                                                                selected 
                                                            <?php endif; ?>
                                                            ><?php echo $this->_tpl_vars['txtProyecto']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </optgroup>
                                        </select>
                                    </td>
                                </tr>

                                <!-- CONJUNTOS RESIDENCIALES (PROYECTOS HIJO) -->
                                <tr>
                                    <td>Conjuntos Residenciales</td>
                                    <td id="tdConjuntoResidencial" colspan="3" align="left">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="obtenerUnidadProyecto(this);"
                                                name="seqProyectoHijo" 
                                                id="seqProyectoHijo" 
                                                style="width:100%"
                                                >
                                            <option value='0'>Ninguno</option>
                                            <?php $_from = $this->_tpl_vars['arrProyectosHijo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyectoHijo'] => $this->_tpl_vars['txtNombreProyecto']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqProyectoHijo']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqProyectoHijo == $this->_tpl_vars['seqProyectoHijo']): ?> 
                                                            selected 
                                                        <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtNombreProyecto']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <!-- DIRECCION SOLUCION -->
                                <!--<tr>
                                        <td width="130px">
                                <?php if ($this->_tpl_vars['objFormulario']->seqEstadoProceso == 43 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 44 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 45 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 46 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 47 || $this->_tpl_vars['objFormulario']->seqEstadoProceso == 48): ?>
                                        Dirección Solución
                                <?php else: ?>
                                        <a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a>
                                <?php endif; ?>
                        </td>
                        <td colspan="3" align="left">
                                <input type="text" 
                                           name="txtDireccionSolucion" 
                                           id="txtDireccionSolucion" 
                                           value="<?php echo $this->_tpl_vars['objFormulario']->txtDireccionSolucion; ?>
" 
                                           style="width:100%;"
                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                           onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                           readonly
                                           />
                        </td>
                </tr>-->
                                <tr>
                                    <td>
                                        <?php if ($this->_tpl_vars['objFormulario']->seqTipoEsquema == 1 || $this->_tpl_vars['objFormulario']->seqTipoEsquema == 2): ?>
                                            <div id="divEsqDefault">Dirección Solución</div>
                                        <?php else: ?>
                                            <div id="divEsqDefault"><a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a></div>
                                        <?php endif; ?>
                                        <div id="divEsqIndiv" style="display:none">Dirección Solución</div>
                                        <div id="divEsqOtros" style="display:none"><a href="#" id="DireccionSolucion" onClick="recogerDireccion('txtDireccionSolucion', 'objDireccionOcultoSolucion')">Dirección Solución</a></div>
                                    </td>
                                    <td colspan="3" align="left">
                                        <input type="text" 
                                               name="txtDireccionSolucion" 
                                               id="txtDireccionSolucion" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtDireccionSolucion; ?>
" 
                                               style="width:100%;"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                               readonly
                                               />
                                    </td>
                                </tr>

                                <!-- NUMERO DE MATRICULA INMOBILIARIA Y CHIP -->
                                <tr>
                                    <td>Matricula Inmobiliaria</td>
                                    <td>
                                        <input type="text" 
                                               name="txtMatriculaInmobiliaria" 
                                               id="txtMatriculaInmobiliaria" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtMatriculaInmobiliaria; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:260px;"
                                               />
                                    </td>
                                    <td>CHIP</td>
                                    <td>
                                        <input type="text" 
                                               name="txtChip" 
                                               id="txtChip" 
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtChip; ?>
" 
                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';" 
                                               style="width:100%;"
                                               />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unidad Residencial</td>
                                    <td id="tdUnidadProyecto" align="left" colspan="3">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                onChange="asignarValorSubsidioUnidadProyecto(this)" 
                                                name="seqUnidadProyecto" 
                                                id="seqUnidadProyecto" 
                                                style="width:100%;"
                                                >
                                            <option value="1">NINGUNA</option>
                                            <?php if (intval ( $this->_tpl_vars['objFormulario']->seqProyecto ) != 0): ?>
                                                <?php if (intval ( $this->_tpl_vars['objFormulario']->seqProyectoHijo ) != ""): ?>
                                                    <?php $_from = $this->_tpl_vars['arrUnidadProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqUnidadProyecto'] => $this->_tpl_vars['arrDatos']):
?>
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqProyectoHijo == $this->_tpl_vars['arrDatos']['seqProyecto']): ?>
                                                            <?php if (( $this->_tpl_vars['arrDatos']['seqFormulario'] == '' ) || ( $this->_tpl_vars['arrDatos']['seqFormulario'] == 0 )): ?>
                                                                <option value="<?php echo $this->_tpl_vars['seqUnidadProyecto']; ?>
"
                                                                        <?php if ($this->_tpl_vars['objFormulario']->seqUnidadProyecto == $this->_tpl_vars['seqUnidadProyecto']): ?> 
                                                                            selected 
                                                                        <?php endif; ?>
                                                                        >
                                                                    <?php echo $this->_tpl_vars['arrDatos']['txtNombreUnidad']; ?>

                                                                </option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $this->_tpl_vars['seqUnidadProyecto']; ?>
"
                                                                        <?php if ($this->_tpl_vars['objFormulario']->seqUnidadProyecto == $this->_tpl_vars['seqUnidadProyecto']): ?> 
                                                                            selected 
                                                                        <?php endif; ?>
                                                                        disabled >
                                                                    <?php echo $this->_tpl_vars['arrDatos']['txtNombreUnidad']; ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                <?php else: ?>
                                                    <?php $_from = $this->_tpl_vars['arrUnidadProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqUnidadProyecto'] => $this->_tpl_vars['arrDatos']):
?>
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqProyecto == $this->_tpl_vars['arrDatos']['seqProyecto']): ?>
                                                            <?php if (( $this->_tpl_vars['arrDatos']['seqFormulario'] == '' ) || ( $this->_tpl_vars['arrDatos']['seqFormulario'] == 0 )): ?>
                                                                <option value="<?php echo $this->_tpl_vars['seqUnidadProyecto']; ?>
"
                                                                        <?php if ($this->_tpl_vars['objFormulario']->seqUnidadProyecto == $this->_tpl_vars['seqUnidadProyecto']): ?> 
                                                                            selected 
                                                                        <?php endif; ?>
                                                                        >
                                                                    <?php echo $this->_tpl_vars['arrDatos']['txtNombreUnidad']; ?>

                                                                </option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $this->_tpl_vars['seqUnidadProyecto']; ?>
"
                                                                        <?php if ($this->_tpl_vars['objFormulario']->seqUnidadProyecto == $this->_tpl_vars['seqUnidadProyecto']): ?> 
                                                                            selected 
                                                                        <?php endif; ?>
                                                                        disabled >
                                                                    <?php echo $this->_tpl_vars['arrDatos']['txtNombreUnidad']; ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table><br>

                            <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">

                                <!-- TIENE PROMESA DE COMPRA VENTA FIRMADA -->
                                <tr>
                                    <td width="350px">¿ Tiene una promesa de compra - venta firmada ?</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolPromesaFirmada" 
                                                id="bolPromesaFirmada" 
                                                style="width:100px;" >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolPromesaFirmada != 1): ?> selected <?php endif; ?>>No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolPromesaFirmada == 1): ?> selected <?php endif; ?>>Si</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- TIENE IDENTIFICADA UNA SOLUCION DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                <tr>
                                    <td>¿ Tiene Identificada una solución Viabilizada por la SDHT ?</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolIdentificada" 
                                                id="bolIdentificada" 
                                                style="width:100px;" >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolIdentificada != 1): ?> selected <?php endif; ?>>No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolIdentificada == 1): ?> selected <?php endif; ?>>Si</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>

                                <!-- PERTENECE A UN PLAN DE VIVIENDA VIABILIZADA POR LA SDHT -->
                                <tr>
                                    <td>Pertenece a un Plan de Vivienda Viabilizada por la SDHT</td>
                                    <td>
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                                name="bolViabilizada" 
                                                id="bolViabilizada" 
                                                style="width:100px;" >
                                            <option value="0" <?php if ($this->_tpl_vars['objFormulario']->bolViabilizada != 1): ?> selected <?php endif; ?>>No</option>
                                            <option value="1" <?php if ($this->_tpl_vars['objFormulario']->bolViabilizada == 1): ?> selected <?php endif; ?>>Si</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table><br>

                            <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border: 1px dotted #666666">
                                <tr>
                                    <!-- VALOR DEL PRESUPUESTO -->
                                    <td width="120px">Presupuesto</td>
                                    <td width="120px">
                                        $ <input type="text" 
                                                 name="valPresupuesto" 
                                                 id="valPresupuesto" 
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valPresupuesto)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, '.', '.') : number_format($_tmp, 0, '.', '.')); ?>
" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotal();" 
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;" />
                                    </td>

                                    <!-- VALOR DEL AVALUO  -->
                                    <td>Aval&uacute;o</td>
                                    <td width="120px">
                                        $ <input type="text" 
                                                 name="valAvaluo" 
                                                 id="valAvaluo" 
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valAvaluo)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, '.', '.') : number_format($_tmp, 0, '.', '.')); ?>
" 
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotal();" 
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;" />
                                    </td>

                                    <!-- VALOR TOTAL  -->
                                    <td>Total</td>
                                    <td  width="134px">
                                        $ <input type="text"
                                                 name="valTotal"
                                                 id="valTotal"
                                                 value="<?php echo $this->_tpl_vars['objFormulario']->valTotal; ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';"
                                                 style="width:90%;"
                                                 readonly />
                                    </td>
                                </tr>
                            </table>
                            </p>
                        </div>

                        <!-- INFORMACION FINANCIERA -->
                        <div id="financiera" style="height:407px;"><p>
                            <table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
                                <!-- TIPO DE FINANCIACION -->
                                <input type="hidden" name="seqTipoFinanciacion" id="seqTipoFinanciacion" value ="<?php echo $this->_tpl_vars['objFormulario']->seqTipoFinanciacion; ?>
">
                                <!--<tr class="tituloTabla">
                                        <td colspan="2">
                                        <td>Tipo de Financiaci&oacute;n</td>
                                        <td style="padding-left:11px;">
                                                <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                                name="seqTipoFinanciacion"
                                                                id="seqTipoFinanciacion"
                                                                style="width:300px;" >
                                <?php $_from = $this->_tpl_vars['arrTipoFinanciacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoFinanciacion'] => $this->_tpl_vars['txtTipoFinanciacion']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqTipoFinanciacion']; ?>
"
                                    <?php if ($this->_tpl_vars['objFormulario']->seqTipoFinanciacion == $this->_tpl_vars['seqTipoFinanciacion']): ?> selected <?php endif; ?>
                                    ><?php echo $this->_tpl_vars['txtTipoFinanciacion']; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                        </select>
                </td>
        </tr>-->

                                <tr style="height:15px"><td colspan="4"></td></tr>

                                <tr><!-- TIENE AHORRO -->
                                    <td>Ahorro 1</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCuentaAhorro"
                                                 id="valSaldoCuentaAhorro"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSaldoCuentaAhorro)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqBancoCuentaAhorro"
                                                id="seqBancoCuentaAhorro"
                                                style="width:300px;" >
                                            <option value="1">Ninguno</option>
                                            <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqBancoCuentaAhorro == $this->_tpl_vars['seqBanco']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtBanco']; ?>

                                                </option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="txtSoporteCuentaAhorro"
                                               id="txtSoporteCuentaAhorro"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteCuentaAhorro; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:195px;"
                                               /> Inmovilizado
                                        <input type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro"
                                               id="bolInmovilizadoCuentaAhorro"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               <?php if ($this->_tpl_vars['objFormulario']->bolInmovilizadoCuentaAhorro == 1): ?> checked <?php endif; ?>
                                               />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APERTURA CUENTA AHORRO -->
                                    <?php if ($this->_tpl_vars['objFormulario']->fchAperturaCuentaAhorro == '0000-00-00'): ?>
                                        <?php $this->assign('fchAperturaCuentaAhorro', ""); ?>
                                    <?php else: ?>
                                        <?php $this->assign('fchAperturaCuentaAhorro', $this->_tpl_vars['objFormulario']->fchAperturaCuentaAhorro); ?>
                                    <?php endif; ?>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAperturaCuentaAhorro"
                                               id="fchAperturaCuentaAhorro"
                                               value="<?php echo $this->_tpl_vars['fchAperturaCuentaAhorro']; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly />
                                        <a href="#" onClick="javascript: calendarioPopUp('fchAperturaCuentaAhorro');">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAperturaCuentaAhorro').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- TIENE OTRO AHORRO -->
                                    <td>Ahorro 2</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCuentaAhorro2"
                                                 id="valSaldoCuentaAhorro2"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSaldoCuentaAhorro2)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL AHORRO -->
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqBancoCuentaAhorro2"
                                                id="seqBancoCuentaAhorro2"
                                                style="width:300px;" >
                                            <option value="1">Ninguno</option>
                                            <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqBancoCuentaAhorro2 == $this->_tpl_vars['seqBanco']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtBanco']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE CUENTA AHORRO E INMOVILIZADA -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="txtSoporteCuentaAhorro2"
                                               id="txtSoporteCuentaAhorro2"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteCuentaAhorro2; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:195px;"
                                               /> Inmovilizado 
                                        <input type="checkbox"
                                               name="bolInmovilizadoCuentaAhorro2"
                                               id="bolInmovilizadoCuentaAhorro2"
                                               value="1"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="this.style.backgroundColor = '#FFFFFF';"
                                               <?php if ($this->_tpl_vars['objFormulario']->bolInmovilizadoCuentaAhorro2 == 1): ?> checked <?php endif; ?>
                                               />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APERTURA CUENTA AHORRO -->
                                    <?php if ($this->_tpl_vars['objFormulario']->fchAperturaCuentaAhorro2 == '0000-00-00'): ?>
                                        <?php $this->assign('fchAperturaCuentaAhorro2', ""); ?>
                                    <?php else: ?>
                                        <?php $this->assign('fchAperturaCuentaAhorro2', $this->_tpl_vars['objFormulario']->fchAperturaCuentaAhorro2); ?>
                                    <?php endif; ?>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Apertura</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAperturaCuentaAhorro2"
                                               id="fchAperturaCuentaAhorro2"
                                               value="<?php echo $this->_tpl_vars['fchAperturaCuentaAhorro2']; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly
                                               />
                                        <a href="#" onClick="javascript: calendarioPopUp('fchAperturaCuentaAhorro2');">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAperturaCuentaAhorro2').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- SUBSIDIO NACIONAL -->
                                    <td>Valor Subsidio: AVC / FOVIS / SFV</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSubsidioNacional"
                                                 id="valSubsidioNacional"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSubsidioNacional)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;"
                                                 />
                                    </td>
                                    <td>Entidad</td>
                                    <td align="center" width="320px">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                name="seqEntidadSubsidio"
                                                id="seqEntidadSubsidio"
                                                style="width:300px;"
                                                >
                                            <?php $_from = $this->_tpl_vars['arrEntidadSubsidio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEntidadSubsidio'] => $this->_tpl_vars['txtEntidadSubsidio']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqEntidadSubsidio']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqEntidadSubsidio == $this->_tpl_vars['seqEntidadSubsidio']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtEntidadSubsidio']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td>Soporte (No.Carta)</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteSubsidioNacional"
                                               id="txtSoporteSubsidioNacional"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteSubsidioNacional; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- APORTE LOTE -->
                                    <td>Acuerdo Pago / Lote / Terreno</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valAporteLote"
                                                 id="valAporteLote"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valAporteLote)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>
                                    <!-- SOPORTE APORTE LOTE -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteLote"
                                               id="txtSoporteLote"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteAporteLote; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- CESANTIAS -->
                                    <td>Cesant&iacute;as</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valSaldoCesantias"
                                                 id="valSaldoCesantias"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSaldoCesantias)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>
                                    <!-- SOPORTE CESANTIAS -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteCesantias"
                                               id="txtSoporteCesantias"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteCesantias; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- APORTE AVANCE DE OBRA -->
                                    <td>Aporte Avance de Obra</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valAporteAvanceObra"
                                                 id="valAporteAvanceObra"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valAporteAvanceObra)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>
                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteAvanceObra"
                                               id="txtSoporteAvanceObra"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteAvanceObra; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- TIENE CREDITO -->
                                    <td>Cr&eacute;dito</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valCredito"
                                                 id="valCredito"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valCredito)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>
                                    <!-- BANCO DONDE TIENE EL CREDITO -->
                                    <td>Entidad</td>
                                    <td align="center">
                                        <select onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="soloNumeros(this);
                                                        this.style.backgroundColor = '#FFFFFF';"
                                                name="seqBancoCredito"
                                                id="seqBancoCredito"
                                                style="width:300px;" >
                                            <option value="1">Sin Credito</option>
                                            <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqBancoCredito == $this->_tpl_vars['seqBanco']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtBanco']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <!-- SOPORTE CREDITO -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteCredito"
                                               id="txtSoporteCredito"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteCredito; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- FECHA APROBACION CREDITO -->
                                    <?php if ($this->_tpl_vars['objFormulario']->fchAprobacionCredito == '0000-00-00'): ?>
                                        <?php $this->assign('fchAprobacionCredito', ""); ?>
                                    <?php else: ?>
                                        <?php $this->assign('fchAprobacionCredito', $this->_tpl_vars['objFormulario']->fchAprobacionCredito); ?>
                                    <?php endif; ?>

                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Fecha Vencimiento</td>
                                    <td style="padding-left:11px;">
                                        <input type="text"
                                               name="fchAprobacionCredito"
                                               id="fchAprobacionCredito"
                                               value="<?php echo $this->_tpl_vars['fchAprobacionCredito']; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:100px;"
                                               maxlength="10"
                                               readonly />
                                        <a onClick="calendarioPopUp('fchAprobacionCredito')" href="#">Calendario</a>&nbsp;&nbsp;
                                        <a onClick="document.getElementById('fchAprobacionCredito').value = '';" href="#">Limpiar</a>
                                    </td>
                                </tr>

                                <tr><!-- APORTE AVANCE DE OBRA -->
                                    <td>Aporte Materiales</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valAporteMateriales"
                                                 id="valAporteMateriales"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valAporteMateriales)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>
                                    <!-- SOPORTE AVANCE OBRA -->
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteAporteMateriales"
                                               id="txtSoporteAporteMateriales"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteAporteMateriales; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr><!-- TIENE DONACIONES -->
                                    <td>Donaci&oacute;n / Rec. Econ&oacute;mico</td>
                                    <td align="right" style="padding-right: 5px;">
                                        $ <input type="text"
                                                 name="valDonacion"
                                                 id="valDonacion"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valDonacion)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px;text-align:right;" />
                                    </td>

                                    <!-- DE DONDE PROVIENE LA DONACION -->
                                    <td>Entidad Donante</td>
                                    <td style="padding-left: 10px;">
                                        <select	onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                onBlur="soloNumeros(this);
                                                        this.style.backgroundColor = '#FFFFFF';"
                                                name="seqEmpresaDonante"
                                                id="seqEmpresaDonante"
                                                style="width:300px;" >
                                            <option value="1">Ninguna</option>
                                            <?php $_from = $this->_tpl_vars['arrDonantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEmpresaDonante'] => $this->_tpl_vars['txtEmpresaDonante']):
?>
                                                <option value="<?php echo $this->_tpl_vars['seqEmpresaDonante']; ?>
"
                                                        <?php if ($this->_tpl_vars['objFormulario']->seqEmpresaDonante == $this->_tpl_vars['seqEmpresaDonante']): ?> selected <?php endif; ?>
                                                        ><?php echo $this->_tpl_vars['txtEmpresaDonante']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr><!-- SOPORTE DONACION -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Soporte</td>
                                    <td align="center">
                                        <input type="text"
                                               name="txtSoporteDonacion"
                                               id="txtSoporteDonacion"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteDonacion; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;" />
                                    </td>
                                </tr>

                                <tr bgcolor="#E0E0E0">
                                    <!-- TOTAL RECURSOS ECONOMICOS -->
                                    <td class="tituloTabla">Total Recursos</td>
                                    <td id="totalRecursosMostrar" align="right" style="padding-right:10px">
                                        <b>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valTotalRecursos)) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', ',') : number_format($_tmp, '0', '.', ',')); ?>
</b>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                <input type="hidden" name="valTotalRecursos" id="valTotalRecursos" value="<?php echo $this->_tpl_vars['objFormulario']->valTotalRecursos; ?>
">
                                </tr>

                                <tr bgcolor="#E0E0E0">

                                    <?php $this->assign('seqModalidad', $this->_tpl_vars['objFormulario']->seqModalidad); ?>
                                    <?php $this->assign('seqSolucion', $this->_tpl_vars['objFormulario']->seqSolucion); ?>

                                    <?php if ($this->_tpl_vars['objFormulario']->valAspiraSubsidio == 0 || $this->_tpl_vars['objFormulario']->valAspiraSubsidio == ""): ?>
                                        <?php $this->assign('valSubsidio', $this->_tpl_vars['arrValorSubsidio'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]); ?>
                                        <?php if ($this->_tpl_vars['valSubsidio'] == ""): ?>
                                            <?php $this->assign('valSubsidio', 0); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php $this->assign('valSubsidio', $this->_tpl_vars['objFormulario']->valAspiraSubsidio); ?>
                                    <?php endif; ?>

                                    <!-- VALOR AL QUE ASPIRA DEL SUBSIDIO -->
                                    <td class="tituloTabla" height="25px" align="top">Valor Subsidio Aspira</td>
                                    <td align="right" style="padding-right:10px" id="tdValSubsidio" height="25px" align="top">
                                        $ <input type="text"
                                                 name="valAspiraSubsidio"
                                                 id="valAspiraSubsidio"
                                                 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['valSubsidio'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '.', '.') : number_format($_tmp, '0', '.', '.')); ?>
"
                                                 onFocus="this.style.backgroundColor = '#ADD8E6';"
                                                 onBlur="soloNumeros(this);
                                                         this.style.backgroundColor = '#FFFFFF';
                                                         sumarTotalRecursos();"
                                                 onKeyUp="formatoSeparadores(this)"
                                                 onChange="formatoSeparadores(this)"
                                                 style="width:100px; text-align:right;"
                                                 <?php if ($this->_tpl_vars['objFormulario']->seqTipoEsquema == 1): ?>
                                                     readonly
                                                 <?php endif; ?>
                                                 />
                                    </td>
                                    <td class="tituloTabla" height="25px" align="top">Soporte Cambio <br>Vr. Subsidio</td>
                                    <td style="padding-left: 10px;" height="25px" align="top">
                                        <input type="text"
                                               name="txtSoporteSubsidio"
                                               id="txtSoporteSubsidio"
                                               value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteSubsidio; ?>
"
                                               onFocus="this.style.backgroundColor = '#ADD8E6';"
                                               onBlur="sinCaracteresEspeciales(this);
                                                       this.style.backgroundColor = '#FFFFFF';"
                                               style="width:300px;"
                                               />
                                    </td>
                                </tr>
                            </table>
                            </p></div>
                    </div>
                </div>
            </div>

            <!-- SEGUIMIENTO AL HOGAR -->
            <div id="seg" style="height:401px; overflow:auto;">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/seguimientoFormulario.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div id="contenidoBusqueda" >
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/buscarSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
            </div>

            <!-- ACTOS ADMINISTRATIVOS -->
            <div id="aad" style="height:401px;">
                <p>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subsidios/actosAdministrativos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </p>
            </div>
        </div>
    </div>
    <input type="hidden" id="seqTipoEsquema" name="seqTipoEsquema" value="<?php echo $this->_tpl_vars['objFormulario']->seqTipoEsquema; ?>
">
    <input type="hidden" id="seqFormulario" name="seqFormulario" value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
">
    <input type="hidden" name="txtArchivo" value="./contenidos/postulacionIndividual/salvarPostulacion.php">
    <input type="hidden" name="numDocumento" value="<?php echo $this->_tpl_vars['numDocumento']; ?>
">
</form>

<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>