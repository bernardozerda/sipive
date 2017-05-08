<?php /* Smarty version 2.6.26, created on 2017-05-05 09:03:05
         compiled from desembolso/pestanaDatosHogar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'desembolso/pestanaDatosHogar.tpl', 86, false),array('modifier', 'ucwords', 'desembolso/pestanaDatosHogar.tpl', 86, false),array('modifier', 'utf8_encode', 'desembolso/pestanaDatosHogar.tpl', 86, false),array('modifier', 'utf8_decode', 'desembolso/pestanaDatosHogar.tpl', 103, false),array('modifier', 'lower', 'desembolso/pestanaDatosHogar.tpl', 103, false),array('modifier', 'upper', 'desembolso/pestanaDatosHogar.tpl', 106, false),array('modifier', 'number_format', 'desembolso/pestanaDatosHogar.tpl', 134, false),)), $this); ?>
	
<!-- 
        CONTENIDO DE LA PESTA�A "DATOS DEL HOGAR"
        MUESTRA INFORMACION BASICA DEL HOGAR Y
        CONTIENE EL SELECT DE CAMBIOS DE ESTADO DEL PROCESO
-->

<!-- 
        TABLA PARA ESTADO DEL PROCESO Y DATOS DEL REGISTRO 
-->

	<!-- VARIABLES PARA FACILITAR EL ACCESO A LOS DATOS -->
	<?php $this->assign('txtFlujo', $this->_tpl_vars['arrFlujoHogar']['flujo']); ?>
	<?php $this->assign('txtFase', $this->_tpl_vars['arrFlujoHogar']['fase']); ?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	    <tr>
	        <td width="140px" valign="middle"><b>Estado del Proceso:</b></td>
	        <td valign="middle" width="315px" align="center">
                <?php if (in_array ( $this->_tpl_vars['claFormulario']->seqEstadoProceso , $this->_tpl_vars['claFlujoDesembolsos']->arrFases[$this->_tpl_vars['txtFlujo']][$this->_tpl_vars['txtFase']]['adelante'] )): ?>
                    <select name="seqEstadoProceso" 
                            id="seqEstadoProceso"
                            onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';"
                            style="width:305px"
                    >    
                        <!-- ESTADOS DEL PROCESO DE RETORNO -->
                        <?php if (! empty ( $this->_tpl_vars['claFlujoDesembolsos']->arrFases[$this->_tpl_vars['txtFlujo']][$this->_tpl_vars['txtFase']]['atras'] )): ?>
                            <optgroup label="Retorno">
                                <?php $_from = $this->_tpl_vars['claFlujoDesembolsos']->arrFases[$this->_tpl_vars['txtFlujo']][$this->_tpl_vars['txtFase']]['atras']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstado']):
?>
                                    <option value="<?php echo $this->_tpl_vars['seqEstado']; ?>
"><?php echo $this->_tpl_vars['arrEstados'][$this->_tpl_vars['seqEstado']]; ?>
</option>	
                                <?php endforeach; endif; unset($_from); ?>
                            </optgroup>
                        <?php endif; ?>

                        <!-- ESTADOS DEL PROCESO DE AVANCE -->
                        <optgroup label="Avance">
                            <?php $_from = $this->_tpl_vars['claFlujoDesembolsos']->arrFases[$this->_tpl_vars['txtFlujo']][$this->_tpl_vars['txtFase']]['adelante']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstado']):
?>
                                <option value="<?php echo $this->_tpl_vars['seqEstado']; ?>
"
                                    <?php if ($this->_tpl_vars['seqEstado'] == $this->_tpl_vars['claFormulario']->seqEstadoProceso): ?> selected <?php endif; ?>
                                >
                                    <?php echo $this->_tpl_vars['arrEstados'][$this->_tpl_vars['seqEstado']]; ?>

                                </option>
                            <?php endforeach; endif; unset($_from); ?>
                        </optgroup>
                    </select>
				<?php else: ?>
                    <?php $this->assign('seqEstado', $this->_tpl_vars['claFormulario']->seqEstadoProceso); ?>
                    <div style="width:100%; text-align: left;">
                        <?php echo $this->_tpl_vars['arrEstados'][$this->_tpl_vars['seqEstado']]; ?>

                        <input	type="hidden" 
                                name="seqEstadoProceso" 
                                id="seqEstadoProceso" 
                                value="<?php echo $this->_tpl_vars['seqEstado']; ?>
"
                         />
                    </div>
                <?php endif; ?>
			</td>
			<td>
			    <?php if ($this->_tpl_vars['txtFase'] == 'busquedaOferta'): ?>
			        <?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->fchCreacionBusquedaOferta); ?>
			        <?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->fchActualizacionBusquedaOferta); ?>
			    <?php endif; ?>
			    <?php if ($this->_tpl_vars['txtFase'] == 'revisionJuridica'): ?>
			    	<?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->arrJuridico['fchCreacion']); ?>
			        <?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->arrJuridico['fchActualizacion']); ?>
			    <?php endif; ?>
			    <?php if ($this->_tpl_vars['txtFase'] == 'revisionTecnica'): ?>
			    	<?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->arrTecnico['fchCreacion']); ?>
			        <?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->arrTecnico['fchActualizacion']); ?>
			    <?php endif; ?>
			    <?php if ($this->_tpl_vars['txtFase'] == 'escrituracion'): ?>
			    	<?php if (esFechaValida ( $this->_tpl_vars['claDesembolso']->fchCreacionEscrituracion )): ?>
			        	<?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->fchCreacionEscrituracion); ?>
			        <?php endif; ?>
			        <?php if (esFechaValida ( $this->_tpl_vars['claDesembolso']->fchActualizacionEscrituracion )): ?>
			        	<?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->fchActualizacionEscrituracion); ?>
			        <?php endif; ?>	        
			    <?php endif; ?>
			    <?php if ($this->_tpl_vars['txtFase'] == 'estudioTitulos'): ?>
			    	<?php $this->assign('fchCreacion', $this->_tpl_vars['claDesembolso']->arrTitulos['fchCreacion']); ?>
			        <?php $this->assign('fchActualizacion', $this->_tpl_vars['claDesembolso']->arrTitulos['fchActualizacion']); ?>
			    <?php endif; ?>
			    
			    <!-- FECHAS DE CREACION Y ACTUALIZACION DE CADA FASE DE DESEMBOLSO -->
			    <?php $this->assign('txtFormatoFecha', "%d de %B de %Y a las %H:%M:%S"); ?>
		        <b>Creado en:</b>      <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['fchCreacion'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['txtFormatoFecha']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['txtFormatoFecha'])))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
     <br>
		        <b>Actualizado en:</b> <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['fchActualizacion'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['txtFormatoFecha']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['txtFormatoFecha'])))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
<br>
			    <b>Tutor Asignado:</b> <?php echo $this->_tpl_vars['txtTutor']; ?>

			</td>
		</tr>
	</table>

<!--
	TABLA PARA LOS DATOS BASICOS DEL FORMULARIO
-->

	<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	    <tr><td colspan="6" class="tituloTabla">DATOS BASICOS DEL FORMULARIO</td></tr>
	    <tr align="left">
	        <th width="110px">No Formulario</th>
	        <td width="80px"><?php echo $this->_tpl_vars['claFormulario']->txtFormulario; ?>
</td>
	        <th width="80px">Modalidad</th>
	        <td width="180px"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrModalidad'][$this->_tpl_vars['seqModalidad']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	        <th width="80px">Soluci&oacute;n</th>
	        <td>
	        	<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>

	            (<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrSolucion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
)
	        </td>
	    </tr>
	    <tr align="left">
	        <th>Tel&eacute;fono 1</th>
	        <td><?php echo $this->_tpl_vars['claFormulario']->numTelefono1; ?>
</td>
	        <th>Tel&eacute;fono 2</th>
	        <td><?php echo $this->_tpl_vars['claFormulario']->numTelefono2; ?>
</td>
	        <th>Celular</th>
	        <td><?php echo $this->_tpl_vars['claFormulario']->numCelular; ?>
</td>
	    </tr>
	    <tr align="left">
	        <th>Barrio</th>
	        <td colspan="3"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['claFormulario']->txtBarrio)) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	        <th>Localidad</th>
	        <td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrLocalidad'][$this->_tpl_vars['seqLocalidad']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	    </tr>
	    <tr align="left">
	        <th>Direcci&oacute;n</th>
	        <td colspan="5"><?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->txtDireccion)) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
	    </tr>
	    <tr align="left">
			<th>Correo Electr&oacute;nico</th>
			<td colspan="5"><?php echo $this->_tpl_vars['claFormulario']->txtCorreo; ?>
</td>
	    </tr>
		<tr align="left">
	        <th>Valor Subsidio</th>
	        <td colspan="5">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAspiraSubsidio)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		</tr>
		<tr align="left">
            <th>Vigencia Subsidio</th>
            <td colspan="5">
            	<?php $this->assign('txtFormatoFecha', "%d de %B de %Y"); ?>
                <?php if ($this->_tpl_vars['claFormulario']->fchVigencia != '0000-00-00'): ?>
            	<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['claFormulario']->fchVigencia)) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['txtFormatoFecha']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['txtFormatoFecha'])))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>

                <?php else: ?><?php echo $this->_tpl_vars['claFormulario']->fchVigencia; ?>

				<?php endif; ?>
                
            </td>
	    </tr>
		<tr align="left">
			<th>Desplazamiento Forzado</th>
			<td colspan="5">
				<?php if ($this->_tpl_vars['claFormulario']->bolDesplazado == 0): ?> 
					NO
				<?php else: ?>
					SI
				<?php endif; ?>
			</td>
	    </tr>
	</table>

<!--
	DATOS DEL HOGAR 
-->		
	<table cellpadding="2" cellspacing="0" border="0" width="100%"  bgcolor="#FFFFFF">
	    <tr><td colspan="6" class="tituloTabla">DATOS DEL HOGAR</td></tr>
	    <tr align="left">
	        <th bgcolor="#F0F0F0">Parentesco</td>
	        <th bgcolor="#F0F0F0">Tipo Documento</td>
	        <th bgcolor="#F0F0F0">Documento</td>
	        <th bgcolor="#F0F0F0">Nombre</td>
	    </tr>
	    <?php $_from = $this->_tpl_vars['claFormulario']->arrCiudadano; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqCiudadano'] => $this->_tpl_vars['objCiudadano']):
?>
	        <?php $this->assign('seqTipoDocumento', $this->_tpl_vars['objCiudadano']->seqTipoDocumento); ?>
	        <?php $this->assign('seqParentesco', $this->_tpl_vars['objCiudadano']->seqParentesco); ?>
	        <tr>
	            <td><?php echo $this->_tpl_vars['arrParentesco'][$this->_tpl_vars['seqParentesco']]; ?>
</td>
	            <td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['seqTipoDocumento']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>
</td>
	            <td>
	                <?php echo $this->_tpl_vars['objCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtNombre2; ?>

	                <?php echo $this->_tpl_vars['objCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtApellido2; ?>

	            </td>
	        </tr>
	    <?php endforeach; endif; unset($_from); ?>
	</table>

<!-- 
        DATOS FINANCIEROS 
-->		
	<table cellpadding="2" cellspacing="0" border="0" width="100%"  bgcolor="#FFFFFF">
	    <tr>
	    	<td colspan="6" class="tituloTabla">DATOS FINANCIEROS</td>
	    </tr>
	    <tr>
	        <td width="200px"><b>Valor del Ahorro 1</b> <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBanco'][$this->_tpl_vars['seqBancoCuentaAhorro']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	        <td width="150px" align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valSaldoCuentaAhorro)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td width="20px">&nbsp;</td>
	        <td width="200px"><b>Valor del Ahorro 2</b> <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBanco'][$this->_tpl_vars['seqBancoCuentaAhorro2']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	        <td width="150px" align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valSaldoCuentaAhorro2)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Valor del Cr&eacute;dito</b> <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBanco'][$this->_tpl_vars['seqBancoCredito']])) ? $this->_run_mod_handler('utf8_decode', true, $_tmp) : utf8_decode($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)))) ? $this->_run_mod_handler('utf8_encode', true, $_tmp) : utf8_encode($_tmp)); ?>
</td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valCredito)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	        <td><b>Subsidio Nacional</b></td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valSubsidioNacional)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Valor de Cesant&iacute;as</b></td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valSaldoCesantias)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	        <td><b>Aporte Lote o Terreno</b></td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAporteLote)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Aporte Avance Obra</b></td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAporteAvanceObra)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	        <td><b>Aporte Materiales</b></td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valAporteMateriales)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td><b>Donaci&oacute;n</b> <?php echo $this->_tpl_vars['arrDonantes'][$this->_tpl_vars['seqEntidadDonante']]; ?>
</td>
	        <td align="right">$ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valDonacion)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td bgcolor="#E4E4E4" colspan="6">
	        	<b>Total Recursos Econ&oacute;micos:</b> $ <?php echo ((is_array($_tmp=$this->_tpl_vars['claFormulario']->valTotalRecursos)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

	        </td>
	    </tr>
	</table>