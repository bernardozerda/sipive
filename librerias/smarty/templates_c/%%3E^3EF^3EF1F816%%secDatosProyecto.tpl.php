<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:52
         compiled from proyectos/secDatosProyecto.tpl */ ?>
<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO<img src="recursos/imagenes/blank.gif" onload="escondeTerritorialDirigido(); escondeLineaOpv(); escondetxtDireccion()"></td></tr>
	<tr>
	<!-- NOMBRE DEL PROYECTO -->
		<td width="25%">Nombre Comit&eacute; Elegibilidad (*)</td>
		<td width="25%"><input name="txtNombreProyecto" type="text" id="txtNombreProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreProyecto; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	<!-- PLAN PARCIAL -->
		<td width="25%"><div id="idTituloPlanParcial">Nombre del Plan Parcial</div></td>
		<td width="25%"><?php if ($this->_tpl_vars['arrPrivilegios']['editar'] == 1): ?>
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
					<?php echo $this->_tpl_vars['soloLectura']; ?>

			/>
			<div id="idCampoPlanParcial"><input name="txtNombrePlanParcial" type="text" id="txtNombrePlanParcial" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombrePlanParcial; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></div>
		</td>
	</tr>
	<tr>
	<!-- NOMBRE COMERCIAL DEL PROYECTO -->
		<td width="25%">Nombre Comercial</td>
		<td width="75%" colspan="3"><input name="txtNombreComercial" type="text" id="txtNombreComercial" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreComercial; ?>
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

	<tr id="lineaOpv">
		<!-- NOMBRE DE LA OPV -->
		<td>Nombre de la OPV (*)</td>
		<td colspan="3" >
			<select name="seqOpv"
					id="seqOpv"
					style="width:200px" >
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

	<tr id="lineaTDirigida">
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

	<tr>
		<!-- LOCALIDAD DEL PROYECTO -->
		<td>Localidad (*)</td>
		<td>
			<select name="seqLocalidad"
					id="seqlocalidad"
					onChange="obtenerBarrio(this);"
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
		<td>Barrio</td>
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
		<!-- FEHCA DE REGISTRO DE ENAJENACION -->
		<td>Fecha Registro de Enajenaci&oacute;n (*)</td>
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
		<td valign="top"><div id="idTituloDescEquipamientoComunal" style="display:none">Descripci&oacute;n Equipamiento Comunal</div></td>
		<td><div id="lineaDescEquipamientoComunal" style="display:none">
				<textarea id="txtDescEquipamientoComunal" name="txtDescEquipamientoComunal" type="text" rows="3" style="width:200px;"/><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescEquipamientoComunal; ?>
</textarea>
			</div>
		</td>
	</tr>

	<tr>
		<!-- NUMERO DE SOLUCIONES -->
		<td>N&uacute;mero Soluciones (*)</td>
		<td><input name="valNumeroSoluciones" type="text" id="valNumeroSoluciones" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valNumeroSoluciones; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaSubsidioProyecto();" style="width:101px;"/>
			<input name="valSalarioMinimo" type="hidden" id="valSalarioMinimo" value="<?php echo $this->_tpl_vars['valSalarioMinimo']; ?>
"/>
			<input name="numSubsidios" type="hidden" id="numSubsidios" value="<?php echo $this->_tpl_vars['numSubsidios']; ?>
"/>
		</td>
		<!-- MODALIDAD DEL DESEMBOLSO -->
		<td valign="top">Modalidad del Desembolso </td>
		<td>
			<select name="seqTipoModalidadDesembolso"
				id="seqTipoModalidadDesembolso"
				style="width:200px"
				>
				<option value="0">Seleccione una opción</option>
				<?php $_from = $this->_tpl_vars['arrTipoModalidadDesembolso']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoModalidadDesembolso'] => $this->_tpl_vars['txtTipoModalidadDesembolso']):
?>
					<option value="<?php echo $this->_tpl_vars['seqTipoModalidadDesembolso']; ?>
" <?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoModalidadDesembolso == $this->_tpl_vars['seqTipoModalidadDesembolso']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['txtTipoModalidadDesembolso']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo1">
		<td class="tituloTabla" colspan="4">LICENCIA DE URBANISMO</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo2">
		<!-- LICENCIA DE URBANISMO -->
		<td>N&uacute;mero de Licencia</td>
		<td><input name="txtLicenciaUrbanismo" type="text" id="txtLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtLicenciaUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		<!-- EXPIDE LICENCIA DE URBANISMO -->
		<td>Expide</td>
		<td><input name="txtExpideLicenciaUrbanismo" type="text" id="txtExpideLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtExpideLicenciaUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo3">
		<!-- FECHA DE LICENCIA DE URBANISMO -->
		<td>Fecha de Licencia</td>
		<td><input name="fchLicenciaUrbanismo1" type="text" id="fchLicenciaUrbanismo1" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo1; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo1' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td>Vigencia de Licencia</td>
		<td><input name="fchVigenciaLicenciaUrbanismo" type="text" id="fchVigenciaLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchVigenciaLicenciaUrbanismo; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
			<!--&nbsp;<span onclick="muestraProrrogaUrbanismo()" style="cursor:hand; width:80px">Ver Pr&oacute;rrogas</span>-->
		</td>
	</tr>

	<tr id="lineaProrrogaUrbanismo">
		<!-- FECHA DE LICENCIA DE URBANISMO (PRORROGA 1)-->
		<td>Fecha Pr&oacute;rroga 1</td>
		<td>
			<input name="fchLicenciaUrbanismo2" type="text" id="fchLicenciaUrbanismo2" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo2; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo2' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- FECHA DE LICENCIA DE URBANISMO (PRORROGA 2)-->
		<td>Fecha Pr&oacute;rroga 2</td>
		<td>
			<input name="fchLicenciaUrbanismo3" type="text" id="fchLicenciaUrbanismo3" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo3; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo3' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo4">
		<!-- FECHA DE LICENCIA DE URBANISMO -->
		<td>Fecha Ejecutoria</td>
		<td><input name="fchEjecutoriaLicenciaUrbanismo" type="text" id="fchEjecutoriaLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchEjecutoriaLicenciaUrbanismo; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutoriaLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td>Resoluci&oacute;n Ejecutoria</td>
		<td><input name="txtResEjecutoriaLicenciaUrbanismo" type="text" id="txtResEjecutoriaLicenciaUrbanismo" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtResEjecutoriaLicenciaUrbanismo; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
		</td>
	</tr>

	<tr id="idLineaLicenciaConstruccion1">
		<td class="tituloTabla" colspan="4">LICENCIA DE CONSTRUCCION</td>
	</tr>
	<tr id="idLineaLicenciaConstruccion2">
		<!-- LICENCIA DE CONSTRUCCION -->
		<td>N&uacute;mero de Licencia</td>
		<td colspan="2"><input name="txtLicenciaConstruccion" type="text" id="txtLicenciaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtLicenciaConstruccion; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr id="idLineaLicenciaConstruccion3">
		<!-- FECHA DE LICENCIA DE CONSTRUCCION -->
		<td>Fecha de Licencia</td>
		<td><input name="fchLicenciaConstruccion1" type="text" id="fchLicenciaConstruccion1" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion1; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion1' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE CONSTRUCCION -->
		<td>Vigencia de Licencia</td>
		<td><input name="fchVigenciaLicenciaConstruccion" type="text" id="fchVigenciaLicenciaConstruccion" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchVigenciaLicenciaConstruccion; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaConstruccion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr id="lineaProrrogaConstruccion">
		<!-- FECHA DE LICENCIA DE CONSTRUCCION (PRORROGA 1)-->
		<td>Fecha Pr&oacute;rroga 1</td>
		<td>
			<input name="fchLicenciaConstruccion2" type="text" id="fchLicenciaConstruccion2" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion2; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion2' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- FECHA DE LICENCIA DE CONSTRUCCION (PRORROGA 2)-->
		<td>Fecha Pr&oacute;rroga 2</td>
		<td>
			<input name="fchLicenciaConstruccion3" type="text" id="fchLicenciaConstruccion3" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion3; ?>
" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion3' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESCRITURACION</td></tr>
	<tr>
		<!-- NOMBRE DEL VENDEDOR -->
		<td>Nombre del vendedor</td>
		<td><input name="txtNombreVendedor" type="text" id="txtNombreVendedor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreVendedor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		<!-- NIT VENDEDOR -->
		<td>NIT</td>
		<td><input name="numNitVendedor" type="text" id="numNitVendedor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numNitVendedor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr>
		<!-- CEDULA CATASTRAL -->
		<td>C&eacute;dula Catastral</td>
		<td colspan="3"><input name="txtCedulaCatastral" type="text" id="txtCedulaCatastral" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtCedulaCatastral; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr>
		<!-- NUMERO Y FECHA ESCRITURA -->
		<td>No. Escritura</td>
		<td><input name="txtEscritura" type="text" id="txtEscritura" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtEscritura; ?>
" onBlur="sinCaracteresEspeciales( this );"  style="width:70px;"/> del <input name="fchEscritura" type="text" id="fchEscritura" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->fchEscritura; ?>
" size="10" readonly /> <a href="#" onClick="javascript: calendarioPopUp( 'fchEscritura' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
		<!-- NUMERO NOTARIA -->
		<td>No. Notar&iacute;a</td>
		<td><input name="numNotaria" type="text" id="numNotaria" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numNotaria; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESTRUCTURADOR DEL PROYECTO</td></tr>
	<tr>
		<td>Nombre del Estructurador (*)</td>
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