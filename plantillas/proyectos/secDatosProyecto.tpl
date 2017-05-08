<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO<img src="recursos/imagenes/blank.gif" onload="escondeTerritorialDirigido(); escondeLineaOpv(); escondetxtDireccion()"></td></tr>
	<tr>
	<!-- NOMBRE DEL PROYECTO -->
		<td width="25%">Nombre Comit&eacute; Elegibilidad (*)</td>
		<td width="25%"><input name="txtNombreProyecto" type="text" id="txtNombreProyecto" value="{$objFormularioProyecto->txtNombreProyecto}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	<!-- PLAN PARCIAL -->
		<td width="25%"><div id="idTituloPlanParcial">Nombre del Plan Parcial</div></td>
		<td width="25%">{if $arrPrivilegios.editar == 1}
				{assign var=soloLectura value=""}
			{else}
				{assign var=soloLectura value="readonly"}
			{/if}
			<input type="hidden" 
					name="numNitProyecto" 
					id="numNitProyecto" 
					value="{$numNitProyecto}"
					onFocus="this.style.backgroundColor = '#ADD8E6';" 
					onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF'; "
					onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
					style="width:100px; text-align: right;"
					{$soloLectura}
			/>
			<div id="idCampoPlanParcial"><input name="txtNombrePlanParcial" type="text" id="txtNombrePlanParcial" value="{$objFormularioProyecto->txtNombrePlanParcial}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></div>
		</td>
	</tr>
	<tr>
	<!-- NOMBRE COMERCIAL DEL PROYECTO -->
		<td width="25%">Nombre Comercial</td>
		<td width="75%" colspan="3"><input name="txtNombreComercial" type="text" id="txtNombreComercial" value="{$objFormularioProyecto->txtNombreComercial}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
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
					{foreach from=$arrTipoEsquema key=seqTipoEsquema item=txtTipoEsquema}
					<option value="{$seqTipoEsquema}" {if $objFormularioProyecto->seqTipoEsquema == $seqTipoEsquema} selected {/if}>{$txtTipoEsquema}</option>
					{/foreach}
			</select>
		</td>

	<!-- TIPO DE MODALIDAD -->
		<td width="25%">Tipo de Modalidad (*)</td>
		<td id="tdModalidad" width="25%">
			<select name="seqPryTipoModalidad"
					id="seqPryTipoModalidad"
					style="width:200px;" >
					<option value="0">Seleccione una opci&oacute;n</option>
					{foreach from=$arrPryTipoModalidad key=seqPryTipoModalidad item=txtPryTipoModalidad}
					<option value="{$seqPryTipoModalidad}" {if $objFormularioProyecto->seqPryTipoModalidad == $seqPryTipoModalidad} selected {/if}>{$txtPryTipoModalidad}</option>
					{/foreach}
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
					{foreach from=$arrOpv key=seqOpv item=txtNombreOpv}
						<option value="{$seqOpv}" {if $objFormularioProyecto->seqOpv == $seqOpv} selected {/if}>{$txtNombreOpv}</option>
					{/foreach}
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
					{foreach from=$arrTipoProyecto key=seqTipoProyecto item=txtTipoProyecto}
						<option value="{$seqTipoProyecto}" {if $objFormularioProyecto->seqTipoProyecto == $seqTipoProyecto} selected {/if}>{$txtTipoProyecto}</option>
					{/foreach}
			</select>
		</td>
		<!-- TIPO DE URBANIZACION ( No va en mejoramiento ) -->
		<td>Tipo de Urbanizaci&oacute;n (*)</td>
		<td><select name="seqTipoUrbanizacion"
					id="seqTipoUrbanizacion"
					style="width:200px" >
					<option value="0">Seleccione una opci&oacute;n</option>
					{foreach from=$arrTipoUrbanizacion key=seqTipoUrbanizacion item=txtTipoUrbanizacion}
						<option value="{$seqTipoUrbanizacion}" {if $objFormularioProyecto->seqTipoUrbanizacion == $seqTipoUrbanizacion} selected {/if}>{$txtTipoUrbanizacion}</option>
					{/foreach}
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
					{foreach from=$arrTipoSolucion key=seqTipoSolucion item=txtTipoSolucion}
						<option value="{$seqTipoSolucion}" {if $objFormularioProyecto->seqTipoSolucion == $seqTipoSolucion} selected {/if}>{$txtTipoSolucion}</option>
					{/foreach}
			</select>
		</td>
		<!-- DESCRIPCION DEL PROYECTO -->
		<td valign="top">Descripci&oacute;n del Proyecto</td>
		<td valign="top"><textarea name="txtDescripcionProyecto" type="text" rows="2" id="txtDescripcionProyecto" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>{$objFormularioProyecto->txtDescripcionProyecto}</textarea>
		</td>
	</tr>

	<tr id="lineaTDirigida">
		<!-- OPERADOR -->
		<td valign="top">Nombre del Operador (*)</td>
		<td valign="top"><input name="txtNombreOperador" id="txtNombreOperador" type="text" value="{$objFormularioProyecto->txtNombreOperador}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		<!-- OBJETO DEL PROYECTO -->
		<td valign="top">Objeto del Proyecto (*)</td>
		<td valign="top"><textarea name="txtObjetoProyecto" type="text" rows="2" id="txtObjetoProyecto" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>{$objFormularioProyecto->txtObjetoProyecto}</textarea>
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
					{foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
						<option value="{$seqLocalidad}" {if $objFormularioProyecto->seqLocalidad == $seqLocalidad} selected {/if}>{$txtLocalidad}</option>
					{/foreach}
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
					{if intval( $objFormularioProyecto->seqLocalidad ) != 0}
						{foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
							<option value="{$seqBarrio}" 
								{if $objFormularioProyecto->seqBarrio == $seqBarrio} 
									selected 
								{/if}
							>{$txtBarrio}</option>            
						{/foreach}
					{/if}
			</select>
		</td>
	</tr>

	<tr>
	<td colspan="2"></td>
	<td>Otros Barrios</td>
	<td><input name="txtOtrosBarrios" type="text" id="txtOtrosBarrios" value="{$objFormularioProyecto->txtOtrosBarrios}" style="width:200px;"/></td>
	</tr>

	<tr id="idLineaDireccion">	
		<!-- SE CONOCE LA DIRECCION? -->
		<td>Se conoce la direcci&oacute;n?</td>
		<td align="left">
			Si <input name="bolDireccion" type="radio" onClick="escondetxtDireccion()" id="bolDireccion" value="1" {if $objFormularioProyecto->bolDireccion == 1} checked {/if} /> 
			No <input name="bolDireccion" type="radio" onClick="escondetxtDireccion()" id="bolDireccion" value="0" {if $objFormularioProyecto->bolDireccion == 0} checked {/if}/> 
		</td>
		<!-- DIRECCION DEL PROYECTO -->
		<td><div id="lineaTituloDireccion" style="display:none"><a href="#" id="DireccionSolucion" onClick="recogerDireccion( 'txtDireccion', 'objDireccionOcultoSolucion' )">Direcci&oacute;n</a></div></td>
		<td><div id="lineaCampoDireccion" style="display:none"><input type="text" 
					name="txtDireccion" 
					id="txtDireccion" 
					value="{$objFormularioProyecto->txtDireccion}" 
					style="width:200px; background-color:#ADD8E6;" 
					readonly />
			</div>
		</td>
	</tr>

	<tr id="idLineaTorres">
		<!-- TORRES -->
		<td>Torres (*)</td>
		<td><input name="valTorres" type="text" id="valTorres" value="{$objFormularioProyecto->valTorres}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/></td>
	</tr>

	<tr id="idLineaAreaLoteConstruida">
		<!-- AREA LOTE -->
		<td>Area Lote (*)</td>
		<td><input name="valAreaLote" type="text" id="valAreaLote" value="{$objFormularioProyecto->valAreaLote}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/>&nbsp;m²</td>
		<!-- AREA CONSTRUIDA -->
		<td>Area a Construir (*)</td>
		<td><input name="valAreaConstruida" type="text" id="valAreaConstruida" value="{$objFormularioProyecto->valAreaConstruida}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:77px;"/>&nbsp;m²</td>
	</tr>

	<tr id="idLineaChipLoteMatricula">
		<!-- CHIP DEL LOTE -->
		<td>Chip Lote</td>
		<td><input name="txtChipLote" type="text" id="txtChipLote" value="{$objFormularioProyecto->txtChipLote}" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/></td>
		<!-- MATRICULA INMOBILIARIA DEL LOTE -->
		<td>Matr&iacute;cula Inmobiliaria Lote (*)</td>
		<td><input name="txtMatriculaInmobiliariaLote" type="text" id="txtMatriculaInmobiliariaLote" value="{$objFormularioProyecto->txtMatriculaInmobiliariaLote}" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/></td>
	</tr>

	<tr id="idLineaRegistroFechaEnajenacion">
		<!-- REGISTRO DE ENAJENACION -->
		<td>Registro de Enajenaci&oacute;n (*)</td>
		<td align="left">
			<input name="txtRegistroEnajenacion" type="text" id="txtRegistroEnajenacion" value="{$objFormularioProyecto->txtRegistroEnajenacion}" onBlur="sinCaracteresEspeciales( this );" style="width:95px;"/>
		</td>
		<!-- FEHCA DE REGISTRO DE ENAJENACION -->
		<td>Fecha Registro de Enajenaci&oacute;n (*)</td>
		<td><input name="fchRegistroEnajenacion" type="text" id="fchRegistroEnajenacion" value="{$objFormularioProyecto->fchRegistroEnajenacion}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchRegistroEnajenacion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr id="idLineaEquipamientoComunal">
		<!-- EQUIPAMIENTO COMUNAL -->
		<td valign="top">Tiene Equipamiento Comunal? </td>
		<td align="left" valign="top">
			Si <input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" value="1" {if $objFormularioProyecto->bolEquipamientoComunal == 1} checked {/if} /> 
			No <input name="bolEquipamientoComunal" type="radio" onClick="escondetxtDescEquipamientoComunal()" id="bolEquipamientoComunal" value="0" {if $objFormularioProyecto->bolEquipamientoComunal == 0} checked {/if}/> 
		</td>
		<!-- DESCRIPCION DE EQUIPAMIENTO COMUNAL -->
		<td valign="top"><div id="idTituloDescEquipamientoComunal" style="display:none">Descripci&oacute;n Equipamiento Comunal</div></td>
		<td><div id="lineaDescEquipamientoComunal" style="display:none">
				<textarea id="txtDescEquipamientoComunal" name="txtDescEquipamientoComunal" type="text" rows="3" style="width:200px;"/>{$objFormularioProyecto->txtDescEquipamientoComunal}</textarea>
			</div>
		</td>
	</tr>

	<tr>
		<!-- NUMERO DE SOLUCIONES -->
		<td>N&uacute;mero Soluciones (*)</td>
		<td><input name="valNumeroSoluciones" type="text" id="valNumeroSoluciones" value="{$objFormularioProyecto->valNumeroSoluciones}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); calculaSubsidioProyecto();" style="width:101px;"/>
			<input name="valSalarioMinimo" type="hidden" id="valSalarioMinimo" value="{$valSalarioMinimo}"/>
			<input name="numSubsidios" type="hidden" id="numSubsidios" value="{$numSubsidios}"/>
		</td>
		<!-- MODALIDAD DEL DESEMBOLSO -->
		<td valign="top">Modalidad del Desembolso </td>
		<td>
			<select name="seqTipoModalidadDesembolso"
				id="seqTipoModalidadDesembolso"
				style="width:200px"
				>
				<option value="0">Seleccione una opción</option>
				{foreach from=$arrTipoModalidadDesembolso key=seqTipoModalidadDesembolso item=txtTipoModalidadDesembolso}
					<option value="{$seqTipoModalidadDesembolso}" {if $objFormularioProyecto->seqTipoModalidadDesembolso == $seqTipoModalidadDesembolso} selected {/if}>{$txtTipoModalidadDesembolso}</option>
				{/foreach}
			</select>
		</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo1">
		<td class="tituloTabla" colspan="4">LICENCIA DE URBANISMO</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo2">
		<!-- LICENCIA DE URBANISMO -->
		<td>N&uacute;mero de Licencia</td>
		<td><input name="txtLicenciaUrbanismo" type="text" id="txtLicenciaUrbanismo" value="{$objFormularioProyecto->txtLicenciaUrbanismo}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		<!-- EXPIDE LICENCIA DE URBANISMO -->
		<td>Expide</td>
		<td><input name="txtExpideLicenciaUrbanismo" type="text" id="txtExpideLicenciaUrbanismo" value="{$objFormularioProyecto->txtExpideLicenciaUrbanismo}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo3">
		<!-- FECHA DE LICENCIA DE URBANISMO -->
		<td>Fecha de Licencia</td>
		<td><input name="fchLicenciaUrbanismo1" type="text" id="fchLicenciaUrbanismo1" value="{$objFormularioProyecto->fchLicenciaUrbanismo1}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo1' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td>Vigencia de Licencia</td>
		<td><input name="fchVigenciaLicenciaUrbanismo" type="text" id="fchVigenciaLicenciaUrbanismo" value="{$objFormularioProyecto->fchVigenciaLicenciaUrbanismo}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
			<!--&nbsp;<span onclick="muestraProrrogaUrbanismo()" style="cursor:hand; width:80px">Ver Pr&oacute;rrogas</span>-->
		</td>
	</tr>

	<tr id="lineaProrrogaUrbanismo">
		<!-- FECHA DE LICENCIA DE URBANISMO (PRORROGA 1)-->
		<td>Fecha Pr&oacute;rroga 1</td>
		<td>
			<input name="fchLicenciaUrbanismo2" type="text" id="fchLicenciaUrbanismo2" value="{$objFormularioProyecto->fchLicenciaUrbanismo2}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo2' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- FECHA DE LICENCIA DE URBANISMO (PRORROGA 2)-->
		<td>Fecha Pr&oacute;rroga 2</td>
		<td>
			<input name="fchLicenciaUrbanismo3" type="text" id="fchLicenciaUrbanismo3" value="{$objFormularioProyecto->fchLicenciaUrbanismo3}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaUrbanismo3' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr id="idLineaLicenciaUrbanismo4">
		<!-- FECHA DE LICENCIA DE URBANISMO -->
		<td>Fecha Ejecutoria</td>
		<td><input name="fchEjecutoriaLicenciaUrbanismo" type="text" id="fchEjecutoriaLicenciaUrbanismo" value="{$objFormularioProyecto->fchEjecutoriaLicenciaUrbanismo}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchEjecutoriaLicenciaUrbanismo' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td>Resoluci&oacute;n Ejecutoria</td>
		<td><input name="txtResEjecutoriaLicenciaUrbanismo" type="text" id="txtResEjecutoriaLicenciaUrbanismo" value="{$objFormularioProyecto->txtResEjecutoriaLicenciaUrbanismo}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
		</td>
	</tr>

	<tr id="idLineaLicenciaConstruccion1">
		<td class="tituloTabla" colspan="4">LICENCIA DE CONSTRUCCION</td>
	</tr>
	<tr id="idLineaLicenciaConstruccion2">
		<!-- LICENCIA DE CONSTRUCCION -->
		<td>N&uacute;mero de Licencia</td>
		<td colspan="2"><input name="txtLicenciaConstruccion" type="text" id="txtLicenciaConstruccion" value="{$objFormularioProyecto->txtLicenciaConstruccion}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr id="idLineaLicenciaConstruccion3">
		<!-- FECHA DE LICENCIA DE CONSTRUCCION -->
		<td>Fecha de Licencia</td>
		<td><input name="fchLicenciaConstruccion1" type="text" id="fchLicenciaConstruccion1" value="{$objFormularioProyecto->fchLicenciaConstruccion1}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion1' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- VIGENCIA DE LICENCIA DE CONSTRUCCION -->
		<td>Vigencia de Licencia</td>
		<td><input name="fchVigenciaLicenciaConstruccion" type="text" id="fchVigenciaLicenciaConstruccion" value="{$objFormularioProyecto->fchVigenciaLicenciaConstruccion}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchVigenciaLicenciaConstruccion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr id="lineaProrrogaConstruccion">
		<!-- FECHA DE LICENCIA DE CONSTRUCCION (PRORROGA 1)-->
		<td>Fecha Pr&oacute;rroga 1</td>
		<td>
			<input name="fchLicenciaConstruccion2" type="text" id="fchLicenciaConstruccion2" value="{$objFormularioProyecto->fchLicenciaConstruccion2}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion2' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
		<!-- FECHA DE LICENCIA DE CONSTRUCCION (PRORROGA 2)-->
		<td>Fecha Pr&oacute;rroga 2</td>
		<td>
			<input name="fchLicenciaConstruccion3" type="text" id="fchLicenciaConstruccion3" value="{$objFormularioProyecto->fchLicenciaConstruccion3}" size="12" readonly /> 
			<a href="#" onClick="javascript: calendarioPopUp( 'fchLicenciaConstruccion3' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
		</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESCRITURACION</td></tr>
	<tr>
		<!-- NOMBRE DEL VENDEDOR -->
		<td>Nombre del vendedor</td>
		<td><input name="txtNombreVendedor" type="text" id="txtNombreVendedor" value="{$objFormularioProyecto->txtNombreVendedor}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
		<!-- NIT VENDEDOR -->
		<td>NIT</td>
		<td><input name="numNitVendedor" type="text" id="numNitVendedor" value="{$objFormularioProyecto->numNitVendedor}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr>
		<!-- CEDULA CATASTRAL -->
		<td>C&eacute;dula Catastral</td>
		<td colspan="3"><input name="txtCedulaCatastral" type="text" id="txtCedulaCatastral" value="{$objFormularioProyecto->txtCedulaCatastral}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr>
		<!-- NUMERO Y FECHA ESCRITURA -->
		<td>No. Escritura</td>
		<td><input name="txtEscritura" type="text" id="txtEscritura" value="{$objFormularioProyecto->txtEscritura}" onBlur="sinCaracteresEspeciales( this );"  style="width:70px;"/> del <input name="fchEscritura" type="text" id="fchEscritura" value="{$objFormularioProyecto->fchEscritura}" size="10" readonly /> <a href="#" onClick="javascript: calendarioPopUp( 'fchEscritura' ); "><img src="recursos/imagenes/calendar_icon.gif"></a></td>
		<!-- NUMERO NOTARIA -->
		<td>No. Notar&iacute;a</td>
		<td><input name="numNotaria" type="text" id="numNotaria" value="{$objFormularioProyecto->numNotaria}" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESTRUCTURADOR DEL PROYECTO</td></tr>
	<tr>
		<td>Nombre del Estructurador (*)</td>
		<td colspan="3">
			<select name="seqTutorProyecto"
					id="seqTutorProyecto" >
					<option value="0">Seleccione una opci&oacute;n</option>
					{foreach from=$arrTutorProyecto key=seqTutorProyecto item=txtTutorProyecto}
						<option value="{$seqTutorProyecto}" {if $objFormularioProyecto->seqTutorProyecto == $seqTutorProyecto} selected {/if}>{$txtTutorProyecto}</option>
					{/foreach}
			</select>
		</td>
	</tr>
</table>