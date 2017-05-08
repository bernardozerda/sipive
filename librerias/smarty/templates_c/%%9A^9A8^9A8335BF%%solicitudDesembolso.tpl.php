<?php /* Smarty version 2.6.26, created on 2017-05-05 09:03:05
         compiled from desembolso/solicitudDesembolso.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'desembolso/solicitudDesembolso.tpl', 17, false),array('function', 'cycle', 'desembolso/solicitudDesembolso.tpl', 114, false),array('modifier', 'number_format', 'desembolso/solicitudDesembolso.tpl', 40, false),array('modifier', 'date_format', 'desembolso/solicitudDesembolso.tpl', 125, false),)), $this); ?>
<?php $this->assign('seqModalidad', $this->_tpl_vars['claFormulario']->seqModalidad); ?>
<?php $this->assign('seqSolucion', $this->_tpl_vars['claFormulario']->seqSolucion); ?>		
<?php $this->assign('seqLocalidad', $this->_tpl_vars['claFormulario']->seqLocalidad); ?>
<?php $this->assign('seqEstadoProceso', $this->_tpl_vars['claFormulario']->seqEstadoProceso); ?>

<?php $this->assign('seqBancoCuentaAhorro', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro); ?>
<?php $this->assign('seqBancoCuentaAhorro2', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro2); ?>
<?php $this->assign('seqBancoCredito', $this->_tpl_vars['claFormulario']->seqBancoCredito); ?>
<?php $this->assign('seqEntidadDonante', $this->_tpl_vars['claFormulario']->seqEmpresaDonante); ?>

<?php $this->assign('seqBancoVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['seqBanco']); ?>

<?php $this->assign('tipoDocCiudadano', $this->_tpl_vars['claCiudadano']->seqTipoDocumento); ?>
<?php $this->assign('tipoDocVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['seqTipoDocumento']); ?>

<?php $this->assign('numAltura', 550); ?>
<?php echo smarty_function_math(array('equation' => "x-50",'x' => $this->_tpl_vars['numAltura'],'assign' => 'numAlturaInterna'), $this);?>

<div id="revTecGen" class="yui-navset" style="width:98%; height:<?php echo $this->_tpl_vars['numAltura']; ?>
; text-align:left;">
    <ul class="yui-nav">
        <li class="selected"><a href="#dho"><em>Datos del Hogar</em></a></li>
        <li><a href="#sde"><em>Solicitud Desembolso</em></a></li>
        <?php if ($this->_tpl_vars['seqModalidad'] == 5): ?> <li><a href="#cap"><em>Consignaciones CAP</em></a></li> <?php endif; ?>
        <li><a href="#seg"><em>Seguimiento</em></a></li>
        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
    </ul>  
    <div class="yui-content">
        <!-- PESTANA DE DATOS DEL HOGAR -->
        <div id="dho" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
;">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "desembolso/pestanaDatosHogar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>				
        </div>
        <!-- PESTANA SOLICITUD DE DESEMBOLSOS -->
        <div id="sde" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
;">

            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="150px" valign="top">
                        <table cellpadding="2" cellspacing="0" border="0" width="100%" id="tablaResumen">
                            <tr><td class="tituloTabla">Valor Subsidio</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAspiraSubsidio)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                </td></tr>
                            <tr><td class="tituloTabla">Valor Solicitudes</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrSolicitud['resumen']['valSolicitudes'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                </td></tr>
                            <tr><td class="tituloTabla">Valor Ordenes Pago</td></tr>
                            <tr><td style="padding-right:10px" align="right">
                                    $ <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrSolicitud['resumen']['valOrdenes'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                </td></tr>
                            <tr><td class="tituloTabla">Saldo Subsidio</td></tr>
                            <tr><td style="padding-right:10px; padding-bottom:5px; border-bottom: 1px solid #999999;" align="right">
                                    <?php $this->assign('valOrdenesPago', 0); ?>
                                    <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['resumen']['valSolicitudes'] != ""): ?>
                                        <?php $this->assign('valOrdenesPago', $this->_tpl_vars['claDesembolso']->arrSolicitud['resumen']['valSolicitudes']); ?>
                                    <?php endif; ?>
                                    <?php echo smarty_function_math(array('equation' => "x - y",'x' => $this->_tpl_vars['claFormulario']->valAspiraSubsidio,'y' => $this->_tpl_vars['valOrdenesPago'],'assign' => 'valSaldo'), $this);?>

                                    $ <?php echo ((is_array($_tmp=$this->_tpl_vars['valSaldo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

                                </td></tr>

                            <?php $_from = $this->_tpl_vars['claDesembolso']->arrSolicitud['resumen']['fechas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['solicitud'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['solicitud']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['seqSolicitud'] => $this->_tpl_vars['fchSolicitud']):
        $this->_foreach['solicitud']['iteration']++;
?>
                                <tr id="<?php echo $this->_tpl_vars['claDesembolso']->seqFormulario; ?>
#<?php echo $this->_tpl_vars['seqSolicitud']; ?>
"><td
                                        <?php if (($this->_foreach['solicitud']['iteration'] <= 1)): ?> 
                                            style="padding-top:5px; cursor:pointer;"
                                        <?php else: ?> 
                                            style="cursor:pointer;"
                                        <?php endif; ?>
                                        onMouseOver="this.style.background = '#e0e0e0'"
                                        onMouseOut="this.style.background = '#F9F9F9'"
                                        onClick="cargarRegistroDesembolso(<?php echo $this->_tpl_vars['claDesembolso']->seqFormulario; ?>
, <?php echo $this->_tpl_vars['seqSolicitud']; ?>
);"
                                        >	

                                        <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                             onMouseOver="this.style.backgroundColor = '#ADD8E6';"
                                             onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                             onClick="desembolsoSolicitud(<?php echo $this->_tpl_vars['claDesembolso']->seqFormulario; ?>
, <?php echo $this->_tpl_vars['seqSolicitud']; ?>
);"
                                             >I</div>
                                        <div style="text-align:center; width:3px; height:14px; float:left"></div>
                                        <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                             onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                             onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                             onClick="eliminarRegistro(
                                                             '<?php echo $this->_tpl_vars['claDesembolso']->seqFormulario; ?>
#<?php echo $this->_tpl_vars['seqSolicitud']; ?>
',
                                                                             '<center>Esta a punto de eliminar una solicitud de desembolso. Tenga en cuenta que esta acción no se podra deshacer.<br><b>¿ Desea Continuar con la Operación ?</b><br><br><span class=\'msgError\'><input type=\'checkbox\' id=\'borrarAAD\'>&nbsp;Borrar el registro de actos administrativos tambi&eacute;n.</span></center>',
                                                                             './contenidos/desembolso/eliminarSolicitud.php');"
                                             >X</div>
                                        <div style="text-align:center; width:5px; height:14px; float:left"></div>
                                        <div style="widht:15px; padding-top:4px; float:left;">
                                            <img id="imagen-<?php echo $this->_tpl_vars['seqSolicitud']; ?>
" src="./recursos/imagenes/bulletRojo.png"/>
                                        </div>

                                        <?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->arrSolicitud['detalles'][$this->_tpl_vars['seqSolicitud']]['fchCreacion']); ?>
                                        <?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->arrSolicitud['detalles'][$this->_tpl_vars['seqSolicitud']]['fchActualizacion']); ?>

                                        <div style="width:102px; float:right;" 
                                             onMouseOver="mostrarTooltipSolicitud(this, '<?php echo $this->_tpl_vars['fchCreacion']; ?>
', '<?php echo $this->_tpl_vars['fchActualizacion']; ?>
')"
                                             ><?php echo $this->_tpl_vars['fchSolicitud']; ?>
</div>
                                    </td></tr>
                                <?php endforeach; endif; unset($_from); ?>
                        </table>
                    </td>
                    <td>
                        <div id="revTecVivUsa" class="yui-navset" style="width:100%; text-align:left;">
                            <ul class="yui-nav">
                                <li class="selected"><a href="#bsu"><em>Datos del Subsidio</em></a></li>
                                <li><a href="#doc"><em>Documentos</em></a></li> 
                            </ul>            
                            <div class="yui-content">

                                <!-- DATOS DEL SUBSIDIO -->
                                <div id="bsu" style="height:<?php echo $this->_tpl_vars['numAlturaInterna']; ?>
; overflow:auto">
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr><td class="tituloTabla" colspan="2">Datos del Subsidio</td></tr>

                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="230px">Modalidad:</td>
                                            <td><?php echo $this->_tpl_vars['arrModalidad'][$this->_tpl_vars['seqModalidad']]; ?>
</td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Tipo de Vivienda:</td>
                                            <td><?php echo $this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
 ( <?php echo $this->_tpl_vars['arrSolucion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
 )</td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Fecha de Asignación:</td>
                                            <td>
                                                <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrJuridico['fchResolucion'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>

                                                <input type="hidden" name="fchResolucion" value="<?php echo $this->_tpl_vars['claDesembolso']->arrJuridico['fchResolucion']; ?>
">
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Número de Resolución:</td>
                                            <td>
                                                <?php echo $this->_tpl_vars['claDesembolso']->arrJuridico['numResolucion']; ?>

                                                <input type="hidden" name="numResolucion" value="<?php echo $this->_tpl_vars['claDesembolso']->arrJuridico['numResolucion']; ?>
">
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>Fecha de Vigencia</td>
                                            <td><?php echo $this->_tpl_vars['claFormulario']->fchVigencia; ?>
</td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Valor de la Resolución:</td>
                                            <td>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrJuridico['valResolucion'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td valign="top">Proyecto de inversión:</td>

                                            <td>
                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto488"
                                                            value="488"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 488: <?php echo $this->_tpl_vars['arrNombreProyectos']['488']; ?>

                                                </div>

                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto644"
                                                            value="644"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 644: <?php echo $this->_tpl_vars['arrNombreProyectos']['644']; ?>

                                                </div>


                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto435"
                                                            value="435"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 435: <?php echo $this->_tpl_vars['arrNombreProyectos']['435']; ?>

                                                </div>

                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto801"
                                                            value="801"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 801: <?php echo $this->_tpl_vars['arrNombreProyectos']['801']; ?>

                                                </div>
                                                <div style="position:relative;">
                                                    <input  type="radio"
                                                            name="numProyectoInversion"
                                                            id="proyecto1075"
                                                            value="1075"
                                                            />
                                                </div>
                                                <div style="position:relative; padding:3px">
                                                    Proyecto 1075: <?php echo $this->_tpl_vars['arrNombreProyectos']['1075']; ?>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
" valign="top">
                                            <td>Registro presupuestal:</td>
                                            <td>
                                                <u><i><a href="#" id="registro1" onClick="recogerValor(['registro1'], 'numero', 'variables')">
                                                            Número Registro
                                                        </a></i></u> del 
                                                <u><i><a href="#" id="fecha1" onClick="calendarioDesembolso(['fecha1'], 'variables');" >
                                                            Fecha Registro
                                                        </a></i></u> <br>
                                                <u><i><a href="#" id="registro2" onClick="recogerValor(['registro2'], 'numero', 'variables')">
                                                            Número Registro
                                                        </a></i></u> del 
                                                <u><i><a href="#" id="fecha2" onClick="calendarioDesembolso(['fecha2'], 'variables');" >
                                                            Fecha Registro
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                        <?php if (! empty ( $this->_tpl_vars['arrResolucionIndexacion'] )): ?>
                                            <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                                <td>Fecha de Resolución de Indexación:</td>
                                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['arrResolucionIndexacion']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>
</td>
                                            </tr>
                                            <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                                <td>Número de Resolución de Indexación:</td>
                                                <td><?php echo $this->_tpl_vars['arrResolucionIndexacion']['numero']; ?>
</td>
                                            </tr>
                                            <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                                <td>Valor de la Resolución de Indexación:</td>
                                                <td>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['arrResolucionIndexacion']['valor'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                                            </tr>
                                            <tr>
                                                <td>Proyecto de Inversión Indexación:</td>
                                                <td>
                                                    <?php echo $this->_tpl_vars['arrNombreProyectos']['488']; ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Número del Proyecto Indexación:</td>
                                                <td>488</td>
                                            </tr>
                                            <tr>
                                                <td>Registro Presupuestal Indexación:</td>
                                                <td><?php echo $this->_tpl_vars['arrResolucionIndexacion']['rp']; ?>
 del <?php echo ((is_array($_tmp=$this->_tpl_vars['arrResolucionIndexacion']['fechaRp'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>
</td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Total Valor del Subsidio:</td>
                                            <td>$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAspiraSubsidio)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
                                        </tr>

                                    </table><br>

                                    <!-- BENEFICIARIO DEL PAGO -->
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr><td class="tituloTabla" colspan="2">Beneficiario del Pago</td></tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">Nombre del Vendedor:</td>
                                            <td>
                                                <?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['txtNombreVendedor'] != ''): ?>
                                                    <?php echo $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtNombreVendedor']; ?>

                                                <?php else: ?>
                                                    <?php echo $this->_tpl_vars['claDesembolso']->txtNombreVendedor; ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Documento:</td>
                                            <td>
                                                <?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['numDocumentoVendedor'] != 0): ?>
                                                    <?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocVendedor']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrEscrituracion['numDocumentoVendedor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
 
                                                <?php else: ?>
                                                    <?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocVendedor']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->numDocumentoVendedor)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
 
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table><br>

                                    <!-- BENEFICIARIO DEL GIRO -->
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">	
                                        <tr><td class="tituloTabla" colspan="2">Beneficiario del Giro</td></tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">Nombre Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtNombreBeneficiarioGiro" 
                                                       id="txtNombreBeneficiarioGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">Documento Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numDocumentoBeneficiarioGiro" 
                                                       id="numDocumentoBeneficiarioGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">
                                                <a href="#" id="Direccion" onClick="recogerDireccion('txtDireccionBeneficiarioGiro', 'objDireccionOcultoBeneficiarioGiro')">Dirección Beneficiario Giro:</a>
                                            </td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtDireccionBeneficiarioGiro" 
                                                       id="txtDireccionBeneficiarioGiro"
                                                       style="width:200px;"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       readonly
                                                       />

                                                <div id="objDireccionOcultoBeneficiarioGiro" style="display:none" />

                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">Teléfono Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numTelefonoGiro" 
                                                       id="numTelefonoGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td width="180px">Correo Beneficiario Giro:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCorreoGiro" 
                                                       id="txtCorreoGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">

                                            <td width="180px">Número de Cuenta:</td>
                                            <td>
                                                <input	type="text" 
                                                       name="numCuentaGiro" 
                                                       id="numCuentaGiro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: soloNumeros(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:200px"
                                                       />
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Tipo de Cuenta:</td>
                                            <td>
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                        name="txtTipoCuentaGiro" 
                                                        id="txtTipoCuentaGiro"
                                                        style="width:200px"
                                                        >
                                                    <option value="">Ninguno</option>
                                                    <option value="ahorros">Cuenta de Ahorros</option>
                                                    <option value="corriente">Cuenta Corriente</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="deposito judicial">Dep&oacute;sito Judicial</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Banco de la Cuenta:</td>
                                            <td>
                                                <select	onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                        onBlur="this.style.backgroundColor = '#FFFFFF';"  
                                                        name="seqBancoGiro" 
                                                        id="seqBancoGiro"
                                                        style="width:300px"
                                                        >
                                                    <option value="1">Ninguno</option>
                                                    <?php $_from = $this->_tpl_vars['arrBanco']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBanco'] => $this->_tpl_vars['txtBanco']):
?>
                                                        <option value="<?php echo $this->_tpl_vars['seqBanco']; ?>
"><?php echo $this->_tpl_vars['txtBanco']; ?>
</option>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#F0F0F0"), $this);?>
">
                                            <td>Valor del Desembolso:</td>
                                            <td>
                                                <u><i><a href="#" id="valor" onClick="recogerValor(['valor'], 'numero', 'variables')">
                                                            Valor Solicitado
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                    </table>							    		
                                </div>

                                <!-- DOCUMENTOS RADICADOS -->
                                <div id="doc" style="height:<?php echo $this->_tpl_vars['numAlturaInterna']; ?>
; overflow:auto">

                                    <table cellpadding="1" cellspacing="0" border="0" width="100%">

                                        <!-- DOCUMENTO DEL BENEFICIARIO -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolCedulaBeneficiario" 
                                                       id="bolCedulaBeneficiario"
                                                       value="1"
                                                       <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCedulaBeneficiario'] == 1): ?> checked <?php endif; ?>
                                                       />
                                            </td>
                                            <td>Copia del documento del beneficiario</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCedulaBeneficiario" 
                                                       id="txtCedulaBeneficiario"
                                                       value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCedulaBeneficiario']; ?>
"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        <?php if ($this->_tpl_vars['claDesembolso']->txtTipoDocumentos != 'persona' && $this->_tpl_vars['claDesembolso']->txtTipoDocumentos != ""): ?>

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolRut" 
                                                           id="bolRut"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolRut'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>RUT</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtRut" 
                                                           id="txtRut"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtRut']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            <!-- <tr>
                                                    <td align="center">
                                                            <input	type="checkbox" 
                                                                            name="bolNit" 
                                                                            id="bolNit"
                                                                            value="1"
                                            <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolNit'] == 1): ?> checked <?php endif; ?>
                    />
            </td>
            <td>NIT</td>
            <td>
                    <input	type="text" 
                                    name="txtNit" 
                                    id="txtNit"
                                    value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtNit']; ?>
"
                                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                    onBlur="javascript: sinCaracteresEspeciales( this ); this.style.backgroundColor = '#FFFFFF';"
                                    style="width:300px"
                                    class="inputLogin"
                    />
            </td>
    </tr> --> 

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCedulaRepresentante" 
                                                           id="bolCedulaRepresentante"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCedulaRepresentante'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Cedula Representante Legal</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCedulaRepresentante" 
                                                           id="txtCedulaRepresentante"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCedulaRepresentante']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCamaraComercio" 
                                                           id="bolCamaraComercio"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCamaraComercio'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Camara de Comercio</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCamaraComercio" 
                                                           id="txtCamaraComercio"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCamaraComercio']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>


                                        <?php else: ?>

                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCedulaVendedor" 
                                                           id="bolCedulaVendedor"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCedulaVendedor'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Copia del documento del <?php if ($this->_tpl_vars['seqModalidad'] != 5): ?> vendedor <?php else: ?> arrendador <?php endif; ?></td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCedulaVendedor" 
                                                           id="txtCedulaVendedor"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCedulaVendedor']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>


                                        <?php endif; ?>

                                        <!-- COPIA DE LA CARTA DE ASIGNACION -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolCartaAsignacion" 
                                                       id="bolCartaAsignacion"
                                                       value="1"
                                                       <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCartaAsignacion'] == 1): ?> checked <?php endif; ?>
                                                       />
                                            </td>
                                            <td>Copia de la carta de asignacion</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtCartaAsignacion" 
                                                       id="txtCartaAsignacion"
                                                       value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCartaAsignacion']; ?>
"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        <!-- AUTORIZACION DE GIRO A TERCEROS -->
                                        <tr>
                                            <td align="center">
                                                <input	type="checkbox" 
                                                       name="bolGiroTercero" 
                                                       id="bolGiroTercero"
                                                       value="1"
                                                       <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolGiroTercero'] == 1): ?> checked <?php endif; ?>
                                                       />
                                            </td>
                                            <td>Autorización de Giro a Terceros</td>
                                            <td>
                                                <input	type="text" 
                                                       name="txtGiroTercero" 
                                                       id="txtGiroTercero"
                                                       value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtGiroTercero']; ?>
"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:300px"
                                                       class="inputLogin"
                                                       />
                                            </td>
                                        </tr>

                                        <!-- MODALIDADES DIFERENTES A SCA -->
                                        <?php if ($this->_tpl_vars['seqModalidad'] != 5): ?> 

                                            <!-- CERTIFICACION BANCARIA -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolCertificacionBancaria" 
                                                           id="bolCertificacionBancaria"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolCertificacionBancaria'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Certificación bancaria</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtCertificacionBancaria" 
                                                           id="txtCertificacionBancaria"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtCertificacionBancaria']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            <!-- ORIGINAL DE LA AUTORIZACION DE DESEMBOLSO -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolAutorizacion" 
                                                           id="bolAutorizacion"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolAutorizacion'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Original autorizacion de desembolso</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtAutorizacion" 
                                                           id="txtAutorizacion"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtAutorizacion']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                            <?php if ($this->_tpl_vars['seqModalidad'] == 3 || $this->_tpl_vars['seqModalidad'] == 4): ?>
                                                <tr>
                                                    <td align="center">
                                                        <input	type="checkbox" 
                                                               name="bolActaEntregaFisica" 
                                                               id="bolActaEntregaFisica"
                                                               value="1"
                                                               <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolActaEntregaFisica'] == 1): ?> checked <?php endif; ?>
                                                               />
                                                    </td>
                                                    <td>Acta entrega física de la obra</td>
                                                    <td>
                                                        <input	type="text" 
                                                               name="txtActaEntregaFisica" 
                                                               id="txtActaEntregaFisica"
                                                               value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtActaEntregaFisica']; ?>
"
                                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                               onBlur="javascript: sinCaracteresEspeciales(this);
                                                                       this.style.backgroundColor = '#FFFFFF';"
                                                               style="width:300px"
                                                               class="inputLogin"
                                                               />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="center">
                                                        <input	type="checkbox" 
                                                               name="bolActaLiquidacion" 
                                                               id="bolActaLiquidacion"
                                                               value="1"
                                                               <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolActaLiquidacion'] == 1): ?> checked <?php endif; ?>
                                                               />
                                                    </td>
                                                    <td>Acta de liquidación</td>
                                                    <td>
                                                        <input	type="text" 
                                                               name="txtActaLiquidacion" 
                                                               id="txtActaLiquidacion"
                                                               value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtActaLiquidacion']; ?>
"
                                                               onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                               onBlur="javascript: sinCaracteresEspeciales(this);
                                                                       this.style.backgroundColor = '#FFFFFF';"
                                                               style="width:300px"
                                                               class="inputLogin"
                                                               />
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php else: ?>

                                            <!-- CERTIFICACION BANCARIA DEL ARRENDADOR -->
                                            <tr>
                                                <td align="center">
                                                    <input	type="checkbox" 
                                                           name="bolBancoArrendador" 
                                                           id="bolBancoArrendador"
                                                           value="1"
                                                           <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolBancoArrendador'] == 1): ?> checked <?php endif; ?>
                                                           />
                                                </td>
                                                <td>Certificación Bancaria del Arrendador</td>
                                                <td>
                                                    <input	type="text" 
                                                           name="txtBancoArrendador" 
                                                           id="txtBancoArrendador"
                                                           value="<?php echo $this->_tpl_vars['claDesembolso']->arrSolicitud['txtBancoArrendador']; ?>
"
                                                           onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                           onBlur="javascript: sinCaracteresEspeciales(this);
                                                                   this.style.backgroundColor = '#FFFFFF';"
                                                           style="width:300px"
                                                           class="inputLogin"
                                                           />
                                                </td>
                                            </tr>

                                        <?php endif; ?>

                                    </table>
                                    <br>
                                    <table cellpadding="1" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td class="tituloTabla" colspan="2">Subsecretaria de Gestión Financiera</td>
                                            <td class="tituloTabla" colspan="2">Subdirección de Recursos Públicos</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px; padding-top:5px;" width="70px">Nombre</td>
                                            <td style="padding-left:5px; padding-top:2px;" >
                                                <input type="text"
                                                       name="txtSubsecretaria"
                                                       id="txtSubsecretaria"
                                                       value="Mauricio Cortés Garzón"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       />
                                            </td>


                                            <td style="padding-left:10px; padding-top:5px;" width="70px">Nombre</td>
                                            <td style="padding-left:5px; padding-top:5px;">
                                                <input type="text"
                                                       name="txtSubdireccion"
                                                       id="txtSubdireccion"
                                                       value="Guillermo Eduardo Alfaro"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       /> 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-left:10px">	
                                                Encargado 
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                       name="bolSubsecretariaEncargado"
                                                       id="bolSubsecretariaEncargado"
                                                       value="1"
                                                       <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolSubsecretariaEncargado'] == 1): ?> checked <?php endif; ?>
                                                       />
                                            </td>

                                            <td style="padding-left:10px">
                                                Encargado
                                            </td>
                                            <td> 
                                                <input type="checkbox"
                                                       name="bolSubdireccionEncargado"
                                                       id="bolSubdireccionEncargado"
                                                       value="1"
                                                       <?php if ($this->_tpl_vars['claDesembolso']->arrSolicitud['bolSubdireccionEncargado'] == 1): ?> checked <?php endif; ?>
                                                       />	
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Elaboró:</td>
                                            <td style="padding-left:5px;">
                                                <input type="text"
                                                       name="txtRevisoSubsecretaria"
                                                       id="txtRevisoSubsecretaria"                                                                       
                                                       value="---"
                                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                                       onBlur="javascript: sinCaracteresEspeciales(this);
                                                               this.style.backgroundColor = '#FFFFFF';"
                                                       style="width:90%"
                                                       />
                                                <input type="hidden" name="usuario" value="<?php echo $this->_tpl_vars['txtUsuarioSesion']; ?>
">
                                            </td>
                                        </tr>
                                    </table>							    		
                                    <br>
                                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td class="tituloTabla" colspan="6">
                                                Datos de Radicación
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50px">Número</td>
                                            <td width="120px">
                                                <u><i><a href="#" id="numeroRadicado" onClick="recogerValor(['numeroRadicado'], 'numero', 'variables')">
                                                            Número Radicación
                                                        </a></i></u>
                                            </td>
                                            <td width="40px">Fecha</td>
                                            <td colspan="3">
                                                <u><i><a href="#" id="fechaRadicado" onClick="calendarioDesembolso(['fechaRadicado'], 'variables');" >
                                                            Fecha Radicación
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                        <tr><td colspan="6">&nbsp;</td></tr>
                                        <tr>
                                            <td class="tituloTabla" colspan="6">
                                                Datos de Orden de Pago
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Número</td>
                                            <td>
                                                <u><i><a href="#" id="numeroOrden" onClick="recogerValor(['numeroOrden'], 'numero', 'variables')">
                                                            Número Pago
                                                        </a></i></u>
                                            </td>
                                            <td>Fecha</td>
                                            <td>
                                                <u><i><a href="#" id="fechaOrden" onClick="calendarioDesembolso(['fechaOrden'], 'variables');" >
                                                            Fecha Pago
                                                        </a></i></u>
                                            </td>
                                            <td width="40px">Monto</td>
                                            <td width="120px">
                                                <u><i><a href="#" id="monto" onClick="recogerValor(['monto'], 'numero', 'variables')">
                                                            Valor Pagado
                                                        </a></i></u>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

        <!-- PESTANA CONSIGNACIONES CAP (CUENTA DE AHORRO PROGRAMADO) --> 			
        <?php if ($this->_tpl_vars['seqModalidad'] == 5): ?>
            <div id="cap" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
; overflow:auto">

                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td class="tituloTabla">
                            Relación de las consignaciones realizadas por el hogar a la cuenta de ahorro programado
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table cellpadding="2" cellspacing="0" border="0" width="100%" id="datosConsignacion">
                                <?php $_from = $this->_tpl_vars['claDesembolso']->arrConsignaciones; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqConsignacion'] => $this->_tpl_vars['arrConsignacion']):
?>
                                    <?php $this->assign('seqBancoConsignacion', $this->_tpl_vars['arrConsignacion']['seqBancoConsignacion']); ?>
                                    <tr id="<?php echo $this->_tpl_vars['seqConsignacion']; ?>
">
                                        <td valign="top">
                                            <div style="text-align:center; width:10px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
                                                 onMouseOver="this.style.backgroundColor = '#FFA4A4';"
                                                 onMouseOut="this.style.backgroundColor = '#F9F9F9'"
                                                 onClick="eliminarRegistro(
                                                                 '<?php echo $this->_tpl_vars['claDesembolso']->seqFormulario; ?>
#<?php echo $this->_tpl_vars['seqConsignacion']; ?>
',
                                                                                 '<center>Esta a punto de eliminar un registro de consignacion. Tenga en cuenta que esta acción no se podra deshacer.<br><b>¿ Desea Continuar con la Operación ?</b></center>',
                                                                                 './contenidos/desembolso/eliminarConsignacion.php');"
                                                 >X</div>
                                        </td>
                                        <td>
                                            <b>A Nombre de:</b> <?php echo $this->_tpl_vars['arrConsignacion']['txtNombreConsignacion']; ?>
<br>
                                            <b>Fecha:</b> <?php echo $this->_tpl_vars['arrConsignacion']['fchConsignacion']; ?>
<br>
                                            <b>Valor:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['arrConsignacion']['valConsignacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
<br>
                                            <b>Banco:</b> <?php echo $this->_tpl_vars['arrBanco'][$this->_tpl_vars['seqBancoConsignacion']]; ?>
<br>
                                            <b>No Cuenta:</b> <?php echo $this->_tpl_vars['arrConsignacion']['numCuenta']; ?>
<br>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; unset($_from); ?>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>
        <?php endif; ?>

        <!-- PESTANA DE SEGUIMIENTO -->			
        <div id="seg" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
; overflow:auto;"><p>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/seguimientoFormulario.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <p><div id="contenidoBusqueda">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/buscarSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div></p>
            </p></div>	

        <!-- PESTAÑA ACTOS ADMINISTRATIVOS -->	        
        <div id="aad" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
;"><p>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subsidios/actosAdministrativos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </p></div>

    </div>
</div>

<div id="listenerRevisionTecnica"></div>		
<div id="variables"></div>	
<input type="hidden" id="seqSolicitudEditar" name="seqSolicitudEditar" value=""> 