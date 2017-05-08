<?php /* Smarty version 2.6.26, created on 2017-05-04 21:34:13
         compiled from subsidios/inscripcion.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'subsidios/inscripcion.tpl', 690, false),)), $this); ?>

<form name="frmInscripcion" id="frmInscripcion" onSubmit="return false;" autocomplete=off>

    <!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'subsidios/pedirSeguimiento.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <!-- BOTON PARA SALVAR EL FORMULARIO -->
    <table cellspacing="0" cellpadding="2" border="0" width="100%" bgcolor="#E4E4E4">
        <tr> 
            <td height="25px" valign="middle" align="right" style="padding-right:10px; padding-left:10px;" bgcolor="#E4E4E4" colspan="4">
                <?php if ($_SESSION['privilegios']['crear'] == 1 || $_SESSION['privilegios']['editar'] == 1): ?>
                    <input type="submit" 
                           name="salvar" 
                           id="salvar" 
                           value="Salvar Inscripci&oacute;n" 
                           onClick="preguntarGrupoFamiliar()"
                           />
                <?php endif; ?>
                <input type="hidden" 
                       id="seqFormulario" 
                       name="seqFormulario" 
                       value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
"
                       >
                <input type="hidden" 
                       id="txtArchivo" 
                       name="txtArchivo" 
                       value="./contenidos/subsidios/salvarInscripcion.php"
                       >
            </td>
        </tr>
    </table>

    <!-- INICIO TAB VIEW -->
    <div id="inscripcion" class="yui-navset" style="width:100%; text-align:left;">
        <ul class="yui-nav" style="background:#E4E4E4;">
            <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
            <li><a href="#seg"><em>Seguimiento</em></a></li>
            <li><a href="#aad"><em>Actos Administrativos</em></a></li>
        </ul>            
        <div class="yui-content">

            <!-- FORMULARIO -->	    
            <div id="frm" style="height:490px;">

                <!-- ESTADO DEL PROCESO -->
                <table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
                    <tr bgcolor="#E4E4E4"> 
                        <td width="140px"><b>Estado del proceso</b></td>
                        <td width="280px">
                            <?php if (intval ( $this->_tpl_vars['objFormulario']->seqEstadoProceso ) == 0): ?> 
                                <?php $this->assign('seqEstadoProceso', '36'); ?>
                            <?php else: ?> 
                                <?php $this->assign('seqEstadoProceso', $this->_tpl_vars['objFormulario']->seqEstadoProceso); ?>
                            <?php endif; ?>
                            <?php echo $this->_tpl_vars['arrEstado'][$this->_tpl_vars['seqEstadoProceso']]; ?>
 
                            <input type="hidden" name="seqEstadoProceso" id="seqEstadoProceso" value="<?php echo $this->_tpl_vars['seqEstadoProceso']; ?>
">
                        </td>
                        <td width="140px"><b>Fecha de Inscripción</b></td>
                        <td><input type='hidden' id='fchInscripcion' name='fchInscripcion' value="<?php echo $this->_tpl_vars['objFormulario']->fchInscripcion; ?>
"><?php echo $this->_tpl_vars['objFormulario']->fchInscripcion; ?>
&nbsp;</td>
                    </tr>
                </table><br>
                <table cellspacing="0" cellpadding="2" border="0" width="100%">

                    <!-- TIPO DOCUMENTO Y NUMERO DE DOCUMENTO -->
                    <tr>    
                        <td width="150px">No. Documento</td>
                        <td>
                            <input type="text" 
                                   name="numDocumento" 
                                   id="numDocumento" 
                                   value="<?php echo $this->_tpl_vars['numDocumento']; ?>
"
                                   onFocus="
                                           this.style.backgroundColor = '#ADD8E6';
                                           ponerPlaceholder('numTelefono1', 'Fijo 1');
                                           ponerPlaceholder('numTelefono2', 'Fijo 2');
                                           ponerPlaceholder('numCelular', 'Celular');
                                   " 
                                   onBlur="
                                           soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';
                                   "
                                   style="
                                   width:100px; 
                                   text-align: right;
                                   "

                                   />
                        </td>
                        <td width="120px">Tipo Documento</td>
                        <td width="210px">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqTipoDocumento" 
                                    id="seqTipoDocumento" 
                                    style="width:260px;"
                                    >
                                <?php $_from = $this->_tpl_vars['arrTipoDocumento']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoDocumento'] => $this->_tpl_vars['txtTipoDocumento']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqTipoDocumento']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqTipoDocumento == $this->_tpl_vars['seqTipoDocumento']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['seqTipoDocumento'] != 1 && $this->_tpl_vars['seqTipoDocumento'] != 2 && $this->_tpl_vars['seqTipoDocumento'] != 5): ?>
                                                disabled
                                            <?php endif; ?>   
                                            >
                                        <?php echo $this->_tpl_vars['txtTipoDocumento']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>            
                        </td>
                    </tr>

                    <!-- PRIMER APELLIDO Y SEGUNDO APELLIDO -->	
                    <tr> 
                        <td>Primer Apellido</td>
                        <td>
                            <input type="text" 
                                   name="txtApellido1" 
                                   id="txtApellido1" 
                                   value="<?php echo $this->_tpl_vars['objCiudadano']->txtApellido1; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                        <td>Segundo Apellido</td>
                        <td>
                            <input type="text" 
                                   name="txtApellido2" 
                                   id="txtApellido2" 
                                   value="<?php echo $this->_tpl_vars['objCiudadano']->txtApellido2; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                    </tr>	

                    <!-- PRIMER NOMBRE Y SEGUNDO NOMBRE -->
                    <tr> 
                        <td>Primer Nombre</td>
                        <td>
                            <input type="text" 
                                   name="txtNombre1" 
                                   id="txtNombre1" 
                                   value="<?php echo $this->_tpl_vars['objCiudadano']->txtNombre1; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetrasEspacio(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                        <td>Segundo Nombre</td>
                        <td>
                            <input type="text" 
                                   name="txtNombre2" 
                                   id="txtNombre2" 
                                   value="<?php echo $this->_tpl_vars['objCiudadano']->txtNombre2; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloLetras(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   />
                        </td>
                    </tr>

                    <!-- SEXO  Y ESTADO CIVIL -->
                    <tr> 
                        <td>Sexo</td>
                        <td>
                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqSexo" 
                                    id="seqSexo" 
                                    style="width:260px;"
                                    >
                                <?php $_from = $this->_tpl_vars['arrSexo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSexo'] => $this->_tpl_vars['txtSexo']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqSexo']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqSexo == $this->_tpl_vars['seqSexo']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtSexo']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td>Estado Civil </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                                    name="seqEstadoCivil" 
                                    id="seqEstadoCivil" 
                                    style="width:260px;"
                                    >
                                <?php $_from = $this->_tpl_vars['arrEstadoCivil']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstadoCivil'] => $this->_tpl_vars['txtEstadoCivil']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqEstadoCivil']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqEstadoCivil == $this->_tpl_vars['seqEstadoCivil']): ?> 
                                                selected 
                                            <?php endif; ?>
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

                    <!-- CONDICION ETNICA Y CONDICION ESPECIAL 1 -->
                    <tr>
                        <td>Condici&oacute;n Étnica</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqEtnia"
                                    name="seqEtnia" 
                                    style="width:260px;"
                                    >
                                <option value="1">NINGUNA</option>
                                <?php $_from = $this->_tpl_vars['arrCondicionEtnica']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEtnia'] => $this->_tpl_vars['txtEtnia']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqEtnia']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqEtnia == $this->_tpl_vars['seqEtnia']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtEtnia']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td>Condici&oacute;n Especial 1</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial"
                                    name="seqCondicionEspecial" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqCondicionEspecial == $this->_tpl_vars['seqCondicionEspecial']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>

                    <!-- CONDICION ESPECIAL 2 y CONDICION ESPECIAL 3 -->
                    <tr>
                        <td>Condici&oacute;n Especial 2</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial2"
                                    name="seqCondicionEspecial2" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqCondicionEspecial2 == $this->_tpl_vars['seqCondicionEspecial']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td>Condici&oacute;n Especial 3</td>
                        <td>
                            <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqCondicionEspecial3"
                                    name="seqCondicionEspecial3" 
                                    style="width:260px;"
                                    >
                                <option value="6">Ninguna</option>
                                <?php $_from = $this->_tpl_vars['arrCondicionEspecial']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCondicionEspecial'] => $this->_tpl_vars['txtCondicionEspecial']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqCondicionEspecial']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqCondicionEspecial3 == $this->_tpl_vars['seqCondicionEspecial']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtCondicionEspecial']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>

                    <!-- NIVEL EDUCATIVO y CORREO -->
                    <tr>
                        <td>Nivel Educativo</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqNivelEducativo"
                                    id="seqNivelEducativo" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguno</option>
                                <?php $_from = $this->_tpl_vars['arrNivelEducativo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqNivelEducativo'] => $this->_tpl_vars['txtNivelEducativo']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqNivelEducativo']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqNivelEducativo == $this->_tpl_vars['seqNivelEducativo']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtNivelEducativo']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td>Correo Electr&oacute;nico</td>
                        <td>
                            <input type="text" 
                                   name="txtCorreo" 
                                   id="txtCorreo" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->txtCorreo; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:260px;"
                                   class="inputLogin"
                                   />
                        </td>
                    </tr>

                    <!-- LGTBI Y HOGAR VICTIMA (DESPLAZADO) -->
                    <tr>
                        <td>Grupo LGTBI </td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqGrupoLgtbi" 
                                    name="seqGrupoLgtbi"
                                    onChange="cambiaLgtbi()"
                                    style="width:260px;"
                                    >
                                <option value="0">Ninguno</option>
                                <?php $_from = $this->_tpl_vars['arrGrupoLgtbi']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqGrupoLgtbi'] => $this->_tpl_vars['txtGrupoLgtbi']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqGrupoLgtbi']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqGrupoLgtbi == $this->_tpl_vars['seqGrupoLgtbi']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtGrupoLgtbi']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td valign='top'>Hecho Victimizante</td>
                        <td valign='top'>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqTipoVictima" 
                                    name="seqTipoVictima"
                                    onchange="cambiaTipoSegunHecho();"
                                    style="width:260px;"
                                    >
                                <option value="0">Ninguno</option>
                                <?php $_from = $this->_tpl_vars['arrTipoVictima']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoVictima'] => $this->_tpl_vars['txtTipoVictima']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqTipoVictima']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqTipoVictima == $this->_tpl_vars['seqTipoVictima']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtTipoVictima']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>

                        </td>
                    </tr>

                    <!-- GRUPO LGTBI Y HOGAR VICTIMA -->
                    <tr>
                        <td>LGTBI</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="bolLgtb" 
                                    name="bolLgtb"
                                    style="width:260px;"
                                    >
                                <option value="0" <?php if ($this->_tpl_vars['objCiudadano']->bolLgtb == 0): ?> selected <?php endif; ?> disabled>No</option>
                                <option value="1" <?php if ($this->_tpl_vars['objCiudadano']->bolLgtb == 1): ?> selected <?php endif; ?> disabled>Si</option>
                            </select>
                        </td>
                        <td>Hogar Victima</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="bolDesplazado" 
                                    name="bolDesplazado"
                                    style="width:260px;"
                                    >
                                <option value="0" <?php if (intval ( $this->_tpl_vars['objFormulario']->bolDesplazado ) == 0): ?> selected <?php endif; ?> disabled>No</option>
                                <option value="1" <?php if (intval ( $this->_tpl_vars['objFormulario']->bolDesplazado ) == 1): ?> selected <?php endif; ?> disabled>Si</option>
                            </select>
                        </td>
                    </tr>

                    <!-- OCUPACION -->          
                    <tr> 
                        <td>Ocupación</td>
                        <td colspan="3">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    id="seqOcupacion"
                                    name="seqOcupacion" 
                                    style="width:100%;"
                                    >
                                <option value="20">NINGUNA</option>
                                <?php $_from = $this->_tpl_vars['arrOcupacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqOcupacion'] => $this->_tpl_vars['txtOcupacion']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqOcupacion']; ?>
"
                                            <?php if ($this->_tpl_vars['objCiudadano']->seqOcupacion == $this->_tpl_vars['seqOcupacion']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtOcupacion']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>

                    <!-- DIRECCION -->
                    <tr> 
                        <td><a href="#" id="Direccion" onClick="recogerDireccion('txtDireccion', 'objDireccionOculto');">Dirección </a></td>
                        <td colspan="3">
                            <input type="text" 
                                   name="txtDireccion" 
                                   id="txtDireccion" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->txtDireccion; ?>
"
                                   style="width:100%;"
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';"
                                   readonly
                                   />
                            <input type='hidden' id='seqTipoDireccion' name='seqTipoDireccion' value="0">
                            <div id="objDireccionOculto" style="display:none" />
                        </td>
                    </tr>

                    <!-- CIUDAD Y LOCALIDAD -->
                    <tr>
                        <td>Ciudad</td>
                        <td id="tdCiudad">
                            <select name="seqCiudad" 
                                    id="seqCiudad" 
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    style="width:260px;"
                                    onChange="cambiarCiudad(this);"
                                    > 
                                <option value="0">Seleccione</option>
                                <?php $_from = $this->_tpl_vars['arrCiudad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCiudad'] => $this->_tpl_vars['txtCiudad']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqCiudad']; ?>
" 
                                            <?php if ($this->_tpl_vars['objFormulario']->seqCiudad == $this->_tpl_vars['seqCiudad']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            > 
                                        <?php echo $this->_tpl_vars['txtCiudad']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td>Localidad </td>
                        <td id="tdlocalidad" align="left">
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

                    <!-- BARRIO -->
                    <tr id='lineaBarrio'>
                        <td>Barrio</td>
                        <td id='tdBarrio'>
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
                        <td id="tdupz" colspan="2">
                            <input type='hidden' readonly id='seqUpz' name='seqUpz' value="<?php echo $this->_tpl_vars['objFormulario']->seqUpz; ?>
">
                        </td>
                    </tr>

                    <!-- TELEFONO 1 TELEFONO 2 Y CELULAR -->
                    <tr> 
                        <td>Telefonos</td>
                        <td colspan="3">
                            <input type="text" 
                                   name="numTelefono1" 
                                   id="numTelefono1" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->numTelefono1; ?>
" 
                                   maxlength="7" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:78px;" 
                                   placeholder="Fijo 1"
                                   >
                            <input type="text" 
                                   name="numTelefono2" 
                                   id="numTelefono2" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->numTelefono2; ?>
" 
                                   maxlength="10" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:78px;" 
                                   placeholder="Fijo 2"
                                   >
                            <input type="text"          
                                   name="numCelular" 
                                   id="numCelular" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->numCelular; ?>
" 
                                   maxlength="10" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   style="width:96px;" 
                                   placeholder="Celular"
                                   >    
                        </td>
                    </tr>

                    <!-- VIVIENDA ACTUAL  Y VALOR ARRENDAMIENTO -->
                    <tr>
                        <td>Vivienda Actual </td>
                        <td>
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
                                            <?php if ($this->_tpl_vars['objFormulario']->seqVivienda == $this->_tpl_vars['seqVivienda']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtVivienda']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                        <td height="25px" valign="bottom">Valor Arriendo</td>
                        <td height="25px" valign="bottom" align="left">$
                            <input type="text"
                                   name="valArriendo" 
                                   id="valArriendo" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->valArriendo; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="soloNumeros(this);
                                           this.style.backgroundColor = '#FFFFFF';" 
                                   onKeyUp="formatoSeparadores(this)" 
                                   onChange="formatoSeparadores(this)"
                                   style="width:100px; text-align:right"
                                   >
                        </td>
                    </tr>

                    <!-- MODALIDAD DEL SUBSIDIO Y TIPO DE SOLUCION-->
                    <tr> 
                        <td>Modalidad</td>
                        <td> 
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    name="seqModalidad" 
                                    id="seqModalidad" 
                                    style="width:260px;"
                                    onChange="obtenerTipoSolucion(this)"
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
                                            <?php if ($this->_tpl_vars['arrDatos']['seqPlanGobierno'] == 2): ?>
                                                disabled
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['arrDatos']['txtModalidad']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                            <input type='hidden' id='seqPlanGobierno' name='seqPlanGobierno' value='3'>
                        </td>
                        <td>Solución</td>
                        <td id="tdTipoSolucion">
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                    onChange="asignarValorSubsidio(this, 'bolDesplazado');"
                                    name="seqSolucion" 
                                    id="seqSolucion" 
                                    style="width:260px;"
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
                            <input type="hidden" name="seqUnidadProyecto" id="seqUnidadProyecto" value="1" >
                        </td>
                    </tr>

                    <!-- INGRESOS DEL HOGAR -->
                    <tr> 
                        <td>Ingresos </td>
                        <td align="left" colspan="3">
                            $ <input type="text" 
                                     name="valIngresoHogar" 
                                     id="valIngresoHogar" 
                                     value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valIngresoHogar)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right"
                                     >
                        </td>
                    </tr>

                    <!-- TIENE AHORRO y DONDE TIENE EL AHORRO -->
                    <tr> 
                        <TD>Valor Ahorro </TD>
                        <td align="left">
                            $ <input type="text" 
                                     name="valSaldoCuentaAhorro" 
                                     id="valSaldoCuentaAhorro" 
                                     value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSaldoCuentaAhorro)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Banco Ahorro</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqBancoCuentaAhorro" 
                                    id="seqBancoCuentaAhorro" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguno</option>
                                <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"
                                            <?php if ($this->_tpl_vars['objFormulario']->seqBancoCuentaAhorro == $this->_tpl_vars['seqBanco']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtBanco']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                            <input type="hidden" name="seqBancoCuentaAhorro2" id="seqBancoCuentaAhorro2" value ="<?php echo $this->_tpl_vars['objFormulario']->seqBancoCuentaAhorro2; ?>
">
                            <input type="hidden" name="seqEntidadSubsidio" id="seqEntidadSubsidio" value ="<?php echo $this->_tpl_vars['objFormulario']->seqEntidadSubsidio; ?>
">
                        </td>
                    </tr>

                    <!-- TIENE CREDITO Y DONDE TIENE EL CREDITO -->
                    <tr> 
                        <td>Valor Credito </td>
                        <td align="left">
                            $ <input type="text" 
                                     name="valCredito" 
                                     id="valCredito" 
                                     value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valCredito)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"  
                                     onKeyUp="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Banco Credito</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this);
                                            this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqBancoCredito" 
                                    id="seqBancoCredito" 
                                    style="width:260px;"
                                    >
                                <option value="1">Sin Credito</option>
                                <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"
                                            <?php if ($this->_tpl_vars['objFormulario']->seqBancoCredito == $this->_tpl_vars['seqBanco']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtBanco']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>

                    <!-- TIENE SUBSIDIO -->
                    <tr>
                        <td>Valor Subsidio: AVC / FOVIS / SFV</td>
                        <td align="left">
                            $ <input type="text" 
                                     name="valSubsidioNacional" 
                                     id="valSubsidioNacional" 
                                     value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valSubsidioNacional)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"
                                     onKeyUp="formatoSeparadores(this)" 
                                     onChange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right"
                                     >
                        </td>
                        <td>Soporte (No. Carta)</td>
                        <td>
                            <input type="text" 
                                   name="txtSoporteSubsidioNacional" 
                                   id="txtSoporteSubsidioNacional" 
                                   value="<?php echo $this->_tpl_vars['objFormulario']->txtSoporteSubsidioNacional; ?>
" 
                                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                   onBlur="sinCaracteresEspeciales(this);
                                           this.style.backgroundColor = '#FFFFFF';"  
                                   style="width:260px;"
                                   >
                        </td>
                    </tr>

                    <!-- TIENE DONACIONES Y DONDE TIENE LA DONACION -->
                    <tr> 
                        <td>Donaci&oacute;n / Rec. Econ&oacute;mico </td>
                        <td align="left">
                            $ <input	type="text" 
                                     name="valDonacion" 
                                     id="valDonacion" 
                                     value="<?php echo ((is_array($_tmp=$this->_tpl_vars['objFormulario']->valDonacion)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
" 
                                     onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                     onBlur="soloNumeros(this);
                                             this.style.backgroundColor = '#FFFFFF';"  
                                     onKeyUp="formatoSeparadores(this)" 
                                     onChange="formatoSeparadores(this)"
                                     style="width:100px; text-align:right" 
                                     >
                        </td>
                        <td>Entidad</td>
                        <td>
                            <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="soloNumeros(this); this.style.backgroundColor = '#FFFFFF';"  
                                    name="seqEmpresaDonante" 
                                    id="seqEmpresaDonante" 
                                    style="width:260px;"
                                    >
                                <option value="1">Ninguna</option>
                                <?php $_from = $this->_tpl_vars['arrDonantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEmpresaDonante'] => $this->_tpl_vars['txtEmpresaDonante']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqEmpresaDonante']; ?>
"
                                            <?php if ($this->_tpl_vars['objFormulario']->seqEmpresaDonante == $this->_tpl_vars['seqEmpresaDonante']): ?> 
                                                selected 
                                            <?php endif; ?>
                                            >
                                        <?php echo $this->_tpl_vars['txtEmpresaDonante']; ?>

                                    </option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- SEGUIMIENTO -->	        
            <div id="seg" style="height:490px;">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/seguimientoFormulario.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <p>
                <div id="contenidoBusqueda" style="height:410px; overflow:auto;">
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/buscarSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
                </p>
            </div>    

            <!-- ACTOS ADMINISTRATIVOS -->        
            <div id="aad" style="height:490px;">
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
</form>
<div id="inscripcionTabView"></div>
<div id="objDireccionOcultoListener"></div>


