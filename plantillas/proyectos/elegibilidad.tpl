<!-- PLANTILLA DE COMITE DE ELEGIBILIDAD CON PESTAÑAS -->
<form name="frmElegibilidad" id="frmElegibilidad" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

<!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
	{assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
	{include file='proyectos/pedirSeguimiento.tpl'}
	<br>
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
	<tr>
		<td style='display: none' width="150px" align="center">
		</td>
		<td></td><td></td><td></td>
		<td align="right" style="padding-right: 10px;" width="250px">
			<!--<input type="submit" name="salvar" id="salvar" value="Salvar Proyecto" onClick="preguntarAntes()">-->
			<input type="submit" name="salvar" id="salvar" value="Salvar Proyecto">
		</td>
	</tr>
</table>
<br>
<!-- TAB VIEW DE ELEGIBILIDAD -->
<div id="elegibilidad" class="yui-navset" style="width:100%; text-align:left;">
	<ul class="yui-nav">
		<li class="selected"><a href="#frm"><em>Formulario</em></a></li>
		<li><a href="#seg"><em>Seguimiento</em></a></li>
	</ul>
	<div class="yui-content">
		<!-- FORMULARIO DE ELEGIBILIDAD -->
		<div id="frm" style="height:1030px;">
		<div id="pestanasProyectosElegibilidad" class="yui-navset" style="width:100%; text-align:left;">
			<ul class="yui-nav">
				<li class="selected"><a href="#datosProyecto"><em>Datos del Proyecto</em></a></li>
				<li><a href="#datosOferente"><em>Datos Oferente</em></a></li>
				<li><a href="#elegibilidad"><em>Comit&eacute; de Elegibilidad</em></a></li>
				<li><a href="#actas"><em>Actas</em></a></li>
				<li><a href="#resoluciones"><em>Resoluciones</em></a></li>
				<li><a href="#datosCronograma"><em>Cronograma</em></a></li>
			</ul>
			<div class="yui-content">
				<!-- DATOS DEL PROYECTO -->
				<div id="datosProyecto" style="height:980px;"><p>

		<!-- ESTADO DEL PROCESO -->
		<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
			<tr bgcolor="#E4E4E4">
				<td align="right"><b>Estado del proceso:</b></td>
				<td>{if $seqPryEstadoProceso == "4"} {$arrEstadosProceso.4} {/if}
					<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="4">
				</td>
				<td align="right"><b>Fecha de Inscripci&oacute;n:</b></td>
				<td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
				<td align="right"><b>Fecha de Actualizaci&oacute;n:</b></td>
				<td>{$objFormularioProyecto->fchUltimaActualizacion}&nbsp;</td>
			</tr>
			<tr><td height="5px"></td></tr>
		</table>

		<!-- DATOS BASICOS DEL PROYECTO-->
		{include file="proyectos/secDatosProyecto.tpl"}	
	</div>
	
	<!-- DATOS DEL OFERENTE -->
	<div id="datosOferente" style="height:400px;">
		{include file="proyectos/secDatosOferente.tpl"}
	</div>

	<div id="elegibilidad" style="height:379px;" ><p>
		<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
			<tr><td width="25%">N&uacute;mero de Radicado Jur&iacute;dico</td>
				<td width="25%"><input name="numRadicadoJuridico" type="text" id="numRadicadoJuridico" value="{$objFormularioProyecto->numRadicadoJuridico}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td width="5%">Fecha</td>
				<td><input name="fchRadicadoJuridico" type="text" id="fchRadicadoJuridico" value="{$objFormularioProyecto->fchRadicadoJuridico}" size="12" readonly /> 
					<a href="#" onClick="javascript: calendarioPopUp( 'fchRadicadoJuridico' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr><td>N&uacute;mero de Radicado T&eacute;cnico</td>
				<td><input name="numRadicadoTecnico" type="text" id="numRadicadoTecnico" value="{$objFormularioProyecto->numRadicadoTecnico}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td>Fecha</td>
				<td><input name="fchRadicadoTecnico" type="text" id="fchRadicadoTecnico" value="{$objFormularioProyecto->fchRadicadoTecnico}" size="12" readonly /> 
					<a href="#" onClick="javascript: calendarioPopUp( 'fchRadicadoTecnico' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr><td>N&uacute;mero de Radicado Financiero</td>
				<td><input name="numRadicadoFinanciero" type="text" id="numRadicadoFinanciero" value="{$objFormularioProyecto->numRadicadoFinanciero}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td>Fecha</td>
				<td><input name="fchRadicadoFinanciero" type="text" id="fchRadicadoFinanciero" value="{$objFormularioProyecto->fchRadicadoFinanciero}" size="12" readonly /> 
					<a href="#" onClick="javascript: calendarioPopUp( 'fchRadicadoFinanciero' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr><td class="tituloTabla" colspan="4">APROBACI&Oacute;N DEL PROYECTO<img src="recursos/imagenes/blank.gif" onload="escondeSeccionAprobacion(); muestraCondicionAprobacion();"></td></tr>
			<tr>
				<td width="25%">Se aprueba el proyecto?</td>
				<td width="25%"colspan="3">
					Si <input name="bolAprobacion" type="radio" onClick="escondeSeccionAprobacion()" id="bolAprobacion" value="1" {if $objFormularioProyecto->bolAprobacion == 1} checked {/if}/> 
					No <input name="bolAprobacion" type="radio" onClick="escondeSeccionAprobacion()" id="bolAprobacion" value="0" {if $objFormularioProyecto->bolAprobacion == 0} checked {/if} /> 
				</td>
			</tr>
		</table>

		<table id="tblSeccionAprobacion" name="tblSeccionAprobacion" cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="display:none">
			<tr>
				<td width="25%">N&uacute;mero de Acta</td>
				<td width="25%"><input name="numActaAprobacion" type="text" id="numActaAprobacion" value="{$objFormularioProyecto->numActaAprobacion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td width="25%">Fecha de Acta</td>
				<td>
						<input name="fchActaAprobacion" type="text" id="fchActaAprobacion" value="{$objFormularioProyecto->fchActaAprobacion}" size="12" readonly /> 
						<a href="#" onClick="javascript: calendarioPopUp( 'fchActaAprobacion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr>
				<td width="25%" valign="top">Observaci&oacute;n</td>
				<td colspan="3"><textarea name="txtActaResuelve" id="txtActaResuelve" rows="4" onBlur="sinCaracteresEspeciales( this );" style="width:610px;" />{$objFormularioProyecto->txtActaResuelve}</textarea></td>
			</tr>
			<tr>
				<td width="25%"	>N&uacute;mero de Resoluci&oacute;n</td>
				<td width="25%"><input name="numResolucionAprobacion" type="text" id="numResolucionAprobacion" value="{$objFormularioProyecto->numResolucionAprobacion}" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;" /></td>
				<td width="25%">Fecha de Resoluci&oacute;n</td>
				<td width="25%">
						<input name="fchResolucionAprobacion" type="text" id="fchResolucionAprobacion" value="{$objFormularioProyecto->fchResolucionAprobacion}" size="12" readonly /> 
						<a href="#" onClick="javascript: calendarioPopUp( 'fchResolucionAprobacion' ); "><img src="recursos/imagenes/calendar_icon.gif"></a>
				</td>
			</tr>
			<tr><td width="25%">Se aprueba condicionado?</td>
				<td width="75%" colspan="3">
					Si <input name="bolCondicionAprobacion" type="radio" onClick="muestraCondicionAprobacion()" id="bolCondicionAprobacion" value="1" {if $objFormularioProyecto->bolCondicionAprobacion == 1} checked {/if}/> 
					No <input name="bolCondicionAprobacion" type="radio" onClick="muestraCondicionAprobacion()" id="bolCondicionAprobacion" value="0" {if $objFormularioProyecto->bolCondicionAprobacion == 0} checked {/if} /> 
				</td>
			</tr>
			<tr id="tblSeccionCondicionado" name="tblSeccionCondicionado" style="display:none">
				<td width="25%" valign="top">Condiciones de aprobación</td>
				<td colspan="3">
					<textarea name="txtCondicionAprobacion" rows="4" id="txtCondicionAprobacion" onBlur="sinCaracteresEspeciales( this );" style="width:610px;" />{$objFormularioProyecto->txtCondicionAprobacion}</textarea>
				</td>
			</tr>
		</table>

		<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" >
			<tr>
				<td valign="top" width="25%">Observaciones</td>
				<td colspan="3"><textarea name="txtObservacionAprobacion" id="txtObservacionAprobacion" rows="4" onBlur="sinCaracteresEspeciales( this );" style="width:610px;" />{$objFormularioProyecto->txtObservacionAprobacion}</textarea></td>
			</tr>
		</table>
	</p></div>

	<div id="actas" style="height:852px;" ><p>
		<table border="0" width="100%" id="tablaFormularioActas">
			<tr><td class="tituloTabla" colspan="5">ACTAS DEL PROYECTO</td></tr>
			<tr><td colspan="5" align="right">Adicionar Acta&nbsp;<img src="recursos/imagenes/plus_icon.gif" onClick="addActaProyecto()" style="cursor: hand"></td></tr>
			<tr class="tituloTabla">
				<th align="center" width="10%">Acta</th>
				<th align="center" width="15%">Fecha</th>
				<th align="center" width="65%">Observaciones</th>
				<th align="center" width="10%"></th>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrActaProyecto key=seqActaProyecto item=arrActa}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="center" width="10%" valign="top" style="padding:6px;">
					{counter print=false}
					{assign var="actual" value="r_$num"}
					<input type="hidden" name="seqActaProyecto[{$actual}]" id="seqActaProyecto" value="{$arrActa.seqActaProyecto}" >
					<input type="text" name="numActaProyecto[{$actual}]" id="numActaProyecto" value="{$arrActa.numActaProyecto}" style="width:70px; text-align:center" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
					<td align="center" width="15%" valign="top" style="padding:3px;"><input name="fchActaProyecto[{$actual}]" type="text" id="fchActaProyecto[{$actual}]" value="{$arrActa.fchActaProyecto}" style="width:80px; text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchActaProyecto[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
					<td align="center" width="65%" valign="top" style="padding:6px;"><textarea name="txtEpigrafe[{$actual}]" id="txtEpigrafe" cols="102" rows="4" >{$arrActa.txtEpigrafe}</textarea></td>
					<td align="center" valign="top" style="padding:6px;"><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>
				</tr>
			{/foreach}
		</table>	
	</div>	

	<div id="resoluciones" style="height:852px;" ><p>
		<table border="0" width="100%" id="tablaFormularioRes">
			<tr><td class="tituloTabla" colspan="5">RESOLUCIONES DEL PROYECTO</td></tr>
			<tr><td colspan="5" align="right">Adicionar Resoluci&oacute;n&nbsp;<img src="recursos/imagenes/plus_icon.gif" onClick="addResolucionProyecto()" style="cursor: hand"></td></tr>
			<tr class="tituloTabla">
				<th align="center" width="10%">Resoluci&oacute;n</th>
				<th align="center" width="15%">Fecha</th>
				<th align="center" width="65%">Resuelve</th>
				<th align="center" width="10%"></th>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			{assign var="num" value="0"}
			{counter start=0 print=false assign=num}
			{foreach from=$arrResolucionProyecto key=seqResolucionProyecto item=arrResolucion}
				{if $num++%2 == 0} <tr class="fila_0">
				{else} <tr class="fila_1">
				{/if}
					<td align="center" width="10%"valign="top" style="padding:6px;">
					{counter print=false}
					{assign var="actual" value="r_$num"}
					<input type="hidden" name="seqResolucionProyecto[{$actual}]" id="seqResolucionProyecto" value="{$arrResolucion.seqResolucionProyecto}" >
					<input type="text" name="numResolucionProyecto[{$actual}]" id="numResolucionProyecto" value="{$arrResolucion.numResolucionProyecto}" style="width:70px; text-align:center" onblur="sinCaracteresEspeciales( this ); soloNumeros( this );"></td>
					<td align="center" width="15%"valign="top" style="padding:3px;"><input name="fchResolucionProyecto[{$actual}]" type="text" id="fchResolucionProyecto[{$actual}]" value="{$arrResolucion.fchResolucionProyecto}" style="width:80px; text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUp( 'fchResolucionProyecto[{$actual}]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>
					<td align="center" width="65%"valign="top" style="padding:6px;"><textarea name="txtResuelve[{$actual}]" id="txtResuelve" cols="102" rows="4" >{$arrResolucion.txtResuelve}</textarea></td>
					<td align="center" valign="top" style="padding:6px;"><input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'></td>
				</tr>
			{/foreach}
		</table>
	</div>
	
	<!-- CRRONOGRAMA DE OBRAS -->
	<div id="datosCronograma" style="height:400px;">
		{include file="proyectos/secCronogramaFechas.tpl"}
	</div>
</div>
</div>
</div>

<!-- SEGUIMIENTO AL PROYECTO -->
<div id="seg" style="height:401px; overflow:auto">
	{include file="seguimientoProyectos/seguimientoFormulario.tpl"}
	<div id="contenidoBusqueda" >
		{include file="seguimientoProyectos/buscarSeguimiento.tpl"}
	</div>
</div>

</div>
</div>
<input type="hidden" id="seqProyectoEditar" name="seqProyectoEditar" value="{$objFormularioProyecto->seqProyecto}">
<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarElegibilidad.php">
<input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
<input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="elegibilidadPryTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>