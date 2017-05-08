<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:05
         compiled from proyectos/secDatosProyectoInscripcion.tpl */ ?>
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
		<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO</td></tr>
		<tr>
			<!-- NOMBRE DEL PROYECTO -->
			<td>Nombre Comit&eacute; Elegibilidad (*)</td>
			<td><input name="txtNombreProyecto" type="text" id="txtNombreProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreProyecto; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			<!-- NIT DEL PROYECTO -->
			<td width="25%"><div id="idTituloPlanParcial">Nombre del Plan Parcial</div></td>
			<td><?php if ($this->_tpl_vars['arrPrivilegios']['editar'] == 1): ?>
					<?php $this->assign('soloLectura', ""); ?>
				<?php else: ?>
					<?php $this->assign('soloLectura', 'readonly'); ?>
				<?php endif; ?>
				<input type="hidden" 
						name="numNitProyecto" 
						id="numNitProyecto" 
						value="<?php echo $this->_tpl_vars['numNitProyecto']; ?>
"
						onFocus="this.style.backgroundColor = '#ADD8E6';" 
						onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; "
						onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
						style="width:100px; text-align: right;"
						readonly
				/>
				<div id="idCampoPlanParcial"><input name="txtNombrePlanParcial" type="text" id="txtNombrePlanParcial" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombrePlanParcial; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></div>
			</td>
		</tr>
		<tr>
			<!-- NOMBRE DEL PROYECTO -->
			<td>Nombre Comercial</td>
			<td colspan=3><input name="txtNombreComercial" type="text" id="txtNombreComercial" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreComercial; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		</tr>
		<tr>
			<!-- TIPO DE ESQUEMA -->
				<td width="25%">Tipo de Esquema (*)</td>
				<td width="25%">
					<select name="seqTipoEsquema"
							id="seqTipoEsquema"
							style="width:200px"
							onChange="obtenerModalidad(this); escondeLineaOpv(); escondeTerritorialDirigido()">
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrTipoEsquema']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoEsquema'] => $this->_tpl_vars['txtTipoEsquema']):
?>
							<option value="<?php echo $this->_tpl_vars['seqTipoEsquema']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoEsquema == $this->_tpl_vars['seqTipoEsquema']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTipoEsquema']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>

			<!-- TIPO DE MODALIDAD -->
				<td width="25%">Tipo de Modalidad (*)</td>
				<td id="tdModalidad" width="25%">
					<select name="seqPryTipoModalidad"
							id="seqPryTipoModalidad"
							style="width:200px;" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrPryTipoModalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqPryTipoModalidad'] => $this->_tpl_vars['txtPryTipoModalidad']):
?>
							<option value="<?php echo $this->_tpl_vars['seqPryTipoModalidad']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqPryTipoModalidad == $this->_tpl_vars['seqPryTipoModalidad']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtPryTipoModalidad']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>

			<tr id="lineaOpv" style="display:none">
				<!-- NOMBRE DE LA OPV -->
				<td>Nombre de la OPV (*)</td>
				<td colspan="3">
					<select name="seqOpv"
							id="seqOpv"
							style="width:200px">
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrOpv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqOpv'] => $this->_tpl_vars['txtNombreOpv']):
?>
								<option value="<?php echo $this->_tpl_vars['seqOpv']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqOpv == $this->_tpl_vars['seqOpv']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtNombreOpv']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>

			<tr id="lineaTDirigida" style="display:none">
				<!-- OPERADOR -->
				<td valign="top">Nombre del Operador (*)</td>
				<td valign="top"><input name="txtNombreOperador" id="txtNombreOperador" type="text" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreOperador; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
				<!-- OBJETO DEL PROYECTO -->
				<td valign="top">Objeto del Proyecto (*)</td>
				<td valign="top"><textarea name="txtObjetoProyecto" type="text" rows="2" id="txtObjetoProyecto" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/><?php echo $this->_tpl_vars['objFormularioProyecto']->txtObjetoProyecto; ?>
</textarea>
				</td>
			</tr>

			<tr id="idLineaProyectoUrbanizacion">
				<!-- TIPO DE PROYECTO ( No va en mejoramiento ) -->
				<td>Tipo de Proyecto (*)</td>
				<td><select name="seqTipoProyecto"
							id="seqTipoProyecto"
							style="width:200px" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrTipoProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoProyecto'] => $this->_tpl_vars['txtTipoProyecto']):
?>
								<option value="<?php echo $this->_tpl_vars['seqTipoProyecto']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoProyecto == $this->_tpl_vars['seqTipoProyecto']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTipoProyecto']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
				<!-- TIPO DE URBANIZACION ( No va en mejoramiento ) -->
				<td>Tipo de Urbanizaci&oacute;n (*)</td>
				<td><select name="seqTipoUrbanizacion"
							id="seqTipoUrbanizacion"
							style="width:200px" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrTipoUrbanizacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoUrbanizacion'] => $this->_tpl_vars['txtTipoUrbanizacion']):
?>
								<option value="<?php echo $this->_tpl_vars['seqTipoUrbanizacion']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoUrbanizacion == $this->_tpl_vars['seqTipoUrbanizacion']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTipoUrbanizacion']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>

			<tr id="idLineaTipoSolucionDescripcion">
				<!-- TIPO DE SOLUCION -->
				<td valign="top">Tipo de Soluci&oacute;n (*)</td>
				<td valign="top"><select name="seqTipoSolucion"
							id="seqTipoSolucion"
							style="width:200px" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrTipoSolucion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoSolucion'] => $this->_tpl_vars['txtTipoSolucion']):
?>
								<option value="<?php echo $this->_tpl_vars['seqTipoSolucion']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoSolucion == $this->_tpl_vars['seqTipoSolucion']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTipoSolucion']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
				<!-- DESCRIPCION DEL PROYECTO -->
				<td valign="top">Descripci&oacute;n del Proyecto</td>
				<td valign="top"><textarea name="txtDescripcionProyecto" type="text" rows="2" id="txtDescripcionProyecto" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescripcionProyecto; ?>
</textarea>
				</td>
			</tr>

			<tr>
				<!-- LOCALIDAD DEL PROYECTO -->
				<td>Localidad (*)</td>
				<td>
					<select name="seqLocalidad"
							id="seqlocalidad"
							onChange="obtenerBarrioProyecto(this);"
							style="width:200px" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrLocalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqLocalidad'] => $this->_tpl_vars['txtLocalidad']):
?>
								<option value="<?php echo $this->_tpl_vars['seqLocalidad']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqLocalidad == $this->_tpl_vars['seqLocalidad']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtLocalidad']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
				<!-- BARRIO -->
				<td>Barrio (*)</td>
				<td valign="top" align="left" id="tdBarrio">
					<select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                            onBlur="this.style.backgroundColor = '#FFFFFF';" 
                            name="seqBarrio" 
                            id="seqBarrio" 
                            style="width:200px;" >
                            <option value="0">Seleccione</option>
							<?php if (intval ( $this->_tpl_vars['objFormularioProyecto']->seqLocalidad ) != 0): ?>
								<?php $_from = $this->_tpl_vars['arrBarrio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBarrio'] => $this->_tpl_vars['txtBarrio']):
?>
									<option value="<?php echo $this->_tpl_vars['seqBarrio']; ?>
" 
										<?php if ($this->_tpl_vars['objFormularioProyecto']->seqBarrio == $this->_tpl_vars['seqBarrio']): ?> 
											selected 
										<?php endif; ?>
                                    ><?php echo $this->_tpl_vars['txtBarrio']; ?>
</option>            
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
					</select>
				</td>
			</tr>
			
			<tr>
			<td colspan="2"></td>
			<td>Otros Barrios</td>
			<td><input name="txtOtrosBarrios" type="text" id="txtOtrosBarrios" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtOtrosBarrios; ?>
" style="width:200px;"/></td>
			</tr>

			<tr id="idLineaDireccion">	
				<!-- SE CONOCE LA DIRECCION? -->
				<td>Se conoce la direcci&oacute;n?</td>
				<td align="left">
					Si <input name="bolDireccion" type="radio" onClick="escondetxtDireccion()" id="bolDireccion" value="1" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolDireccion == 1): ?> checked <?php endif; ?> /> 
					No <input name="bolDireccion" type="radio" onClick="escondetxtDireccion()" id="bolDireccion" value="0" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolDireccion == 0): ?> checked <?php endif; ?>/> 
				</td>
				<!-- DIRECCION DEL PROYECTO -->
				<td><div id="lineaTituloDireccion" style="display:none"><a href="#" id="DireccionSolucion" onClick="recogerDireccion( 'txtDireccion', 'objDireccionOcultoSolucion' )">Direcci&oacute;n</a></div></td>
				<td><div id="lineaCampoDireccion" style="display:none"><input type="text" 
							name="txtDireccion" 
							id="txtDireccion" 
							value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccion; ?>
" 
							style="width:200px; background-color:#ADD8E6;" 
							readonly />
					</div>
				</td>
			</tr>

			<tr>
				<!-- NUMERO DE SOLUCIONES -->
				<td>N&uacute;mero Soluciones (*)</td>
				<td colspan="3"><input name="valNumeroSoluciones" type="text" id="valNumeroSoluciones" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valNumeroSoluciones; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaSubsidioProyecto();" style="width:101px;"/>
					<input name="valSalarioMinimo" type="hidden" id="valSalarioMinimo" value="<?php echo $this->_tpl_vars['valSalarioMinimo']; ?>
"/>
					<input name="numSubsidios" type="hidden" id="numSubsidios" value="<?php echo $this->_tpl_vars['numSubsidios']; ?>
"/>
				</td>
			</tr>
			
			<tr id="idLineaTorres">
				<!-- TORRES -->
				<td>Torres (*)</td>
				<td><input name="valTorres" type="text" id="valTorres" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTorres; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/></td>
			</tr>

			<tr id="idLineaAreaLoteConstruida">
				<!-- AREA LOTE -->
				<td>Area Lote (*)</td>
				<td><input name="valAreaLote" type="text" id="valAreaLote" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valAreaLote; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/>&nbsp;m²</td>
				<!-- AREA CONSTRUIDA -->
				<td>Area a Construir (*)</td>
				<td><input name="valAreaConstruida" type="text" id="valAreaConstruida" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valAreaConstruida; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/>&nbsp;m²</td>
			</tr>
			
			<tr id="idLineaChipLoteMatricula">
				<!-- CHIP DEL LOTE -->
				<td>Chip Lote</td>
				<td><input name="txtChipLote" type="text" id="txtChipLote" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtChipLote; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/></td>
				<!-- MATRICULA INMOBILIARIA DEL LOTE -->
				<td>Matr&iacute;cula Inmobiliaria Lote (*)</td>
				<td><input name="txtMatriculaInmobiliariaLote" type="text" id="txtMatriculaInmobiliariaLote" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtMatriculaInmobiliariaLote; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/></td>
			</tr>

			<tr id="idLineaRegistroFechaEnajenacion">
				<!-- REGISTRO DE ENAJENACION -->
				<td>Registro de Enajenaci&oacute;n (*)</td>
				<td align="left">
					<input name="txtRegistroEnajenacion" type="text" id="txtRegistroEnajenacion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtRegistroEnajenacion; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/>
				</td>
				<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
				<td>Fecha Registro de Enajenaci&oacute;n</td>
				<td><input name="fchRegistroEnajenacion" type="text" id="fchRegistroEnajenacion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchRegistroEnajenacion; ?>
" size="12" readonly /> 
					<a href="#" onClick="javascript: calendarioPopUp( 'fchRegistroEnajenacion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>

			<tr id="idLineaEquipamientoComunal">
				<!-- EQUIPAMIENTO COMUNAL -->
				<td valign="top">Tiene Equipamiento Comunal? </td>
				<td align="left" valign="top">
					Si <input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" value="1" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolEquipamientoComunal == 1): ?> checked <?php endif; ?> /> 
					No <input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" value="0" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolEquipamientoComunal == 0): ?> checked <?php endif; ?>/> 
				</td>
				<!-- DESCRIPCION DE EQUIPAMIENTO COMUNAL -->
				<td id="idTituloDescEquipamientoComunal" name="idTituloDescEquipamientoComunal" valign="top">Descripci&oacute;n Equipamiento Comunal</td>
				<td id="lineaDescEquipamientoComunal" name="lineaDescEquipamientoComunal" style="display:none">
					<textarea id="txtDescEquipamientoComunal" name="txtDescEquipamientoComunal" type="text" rows="3" style="width:200px;"/><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescEquipamientoComunal; ?>
</textarea>
				</td>
			</tr>

			<tr id="idLineaLicenciaUrbanismo1" style="display:none"></tr>
			<tr id="idLineaLicenciaUrbanismo2" style="display:none"></tr>
			<tr id="idLineaLicenciaUrbanismo3" style="display:none"></tr>
			<tr id="lineaProrrogaUrbanismo" style="display:none"></tr>
			<tr id="idLineaLicenciaUrbanismo4" style="display:none"></tr>
			
			<tr id="idLineaLicenciaConstruccion1" style="display:none"></tr>
			<tr id="idLineaLicenciaConstruccion2" style="display:none"></tr>
			<tr id="idLineaLicenciaConstruccion3" style="display:none"></tr>
			<tr id="lineaProrrogaConstruccion" style="display:none"></tr>

			<tr><td class="tituloTabla" colspan="4">TUTOR DEL PROYECTO</td></tr>
			<tr>
				<td>Nombre del Tutor (*)</td>
				<td colspan="3">
					<select name="seqTutorProyecto"
							id="seqTutorProyecto" >
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php $_from = $this->_tpl_vars['arrTutorProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTutorProyecto'] => $this->_tpl_vars['txtTutorProyecto']):
?>
								<option value="<?php echo $this->_tpl_vars['seqTutorProyecto']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTutorProyecto == $this->_tpl_vars['seqTutorProyecto']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTutorProyecto']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>
	</table>