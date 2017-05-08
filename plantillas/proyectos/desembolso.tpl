<!-- PLANTILLA DE DESEMBOLSO CON PESTAÑAS -->
<form name="frmDesembolso" id="frmDesembolso" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

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
<!-- TAB VIEW DE DESEMBOLSO -->
<div id="desembolso" class="yui-navset" style="width:100%; text-align:left;">
	<ul class="yui-nav">
		<li class="selected"><a href="#frm"><em>Formulario</em></a></li>
		<li><a href="#seg"><em>Seguimiento</em></a></li>
		<!--<li><a href="#aad"><em>Actos Administrativos</em></a></li>-->
	</ul>
	<div class="yui-content">
		<!-- FORMULARIO DE DESEMBOLSO -->
		<div id="frm" style="height:970px;">
		<div id="pestanasProyectosDesembolso" class="yui-navset" style="width:100%; text-align:left;">
			<ul class="yui-nav">
				<li class="selected"><a href="#datosProyecto"><em>Proyecto</em></a></li>
				<li><a href="#desembolsos"><em>Desembolso</em></a></li>
				<li><a href="#docsConstructora"><em>Documentos Constructora</em></a></li>
				<li><a href="#docsEntidadFinanciera"><em>Documentos Fiduciaria</em></a></li>
				<li><a href="#docsProyecto"><em>Documentos Proyecto</em></a></li>
				<!--<li><a href="#cronogramaObras"><em>Cronograma</em></a></li>
				<li><a href="#seguimientoObras"><em>Seguimiento Obras</em></a></li>-->
			</ul>
			<div class="yui-content">
				<!-- DATOS DEL PROYECTO -->
				<div id="datosProyecto" style="height:920px;"><p>
				<!-- ESTADO DEL PROCESO -->
					<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
						<tr bgcolor="#E4E4E4">
							<td width="140px"><b>Estado del proceso</b></td>
							<td width="280px">{if $seqPryEstadoProceso == "1"} {$arrEstadoProceso.2} {else} {$arrEstadoProceso.$seqPryEstadoProceso} {/if}
								<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="5">Desembolso
							</td>
							<td width="140px"><b>Fecha de Inscripción</b></td>
							<td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
						</tr>
						<tr><td height="5px"></td></tr>
					</table>
					{include file="proyectos/secDatosProyectoLectura.tpl"}
				</div>
	
	<div id="desembolsos" style="height:850px;" >
	{include file="proyectos/secGirosDesembolsos.tpl"}
	</div>

	<div id="docsConstructora" style="height:550px;" ><p>
		<table border="0">
			<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DE LA CONSTRUCTORA PARA EL PRIMER DESEMBOLSO</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center"></th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemConstructor1" name="chkDocDesemConstructor1">
						{if $objFormularioProyecto->chkDocDesemConstructor1 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia C&eacute;dula de Ciudadan&iacute;a del Representante Legal.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemConstructor1" name="txtDocDesemConstructor1">{$objFormularioProyecto->txtDocDesemConstructor1}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemConstructor2" name="chkDocDesemConstructor2">
						{if $objFormularioProyecto->chkDocDesemConstructor2 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del Registro &Uacute;nico Tributario - RUT.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemConstructor2" name="txtDocDesemConstructor2">{$objFormularioProyecto->txtDocDesemConstructor2}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemConstructor3" name="chkDocDesemConstructor3">
						{if $objFormularioProyecto->chkDocDesemConstructor3 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del Registro de Identificaci&oacute;n Tributaria - RIT.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemConstructor3" name="txtDocDesemConstructor3">{$objFormularioProyecto->txtDocDesemConstructor3}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemConstructor4" name="chkDocDesemConstructor4">
						{if $objFormularioProyecto->chkDocDesemConstructor4 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">C&aacute;mara y Comercio</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemConstructor4" name="txtDocDesemConstructor4">{$objFormularioProyecto->txtDocDesemConstructor4}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemConstructor5" name="chkDocDesemConstructor5">
						{if $objFormularioProyecto->chkDocDesemConstructor5 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del contrato de obra celebrado con el constructor, salvo que en el contrato de fiducia se encuentren las obligaciones de cada una de las partes respecto de la construcci&oacute;n de las viviendas.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemConstructor5" name="txtDocDesemConstructor5">{$objFormularioProyecto->txtDocDesemConstructor5}</textarea></td>
			</tr>
		</table>
	</p></div>

	<div id="docsEntidadFinanciera" style="height:550px;" ><p>
		<table border="0">
			<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DE LA ENTIDAD FINANCIERA CON LA CUAL SE CONSTITUY&Oacute; EL FIDEICOMISO DE ADMINISTRACI&Oacute;N INMOBILIARIA PARA EL PRIMER DESEMBOLSO</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center"></th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>

			<tr id="lineaFiduciario1" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad1" name="chkDocDesemEntidad1">
						{if $objFormularioProyecto->chkDocDesemEntidad1 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del contrato de encargo fiduciario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad1" name="txtDocDesemEntidad1">{$objFormularioProyecto->txtDocDesemEntidad1}</textarea></td>
			</tr>
			
			<tr id="lineaFiduciario2" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad2" name="chkDocDesemEntidad2">
						{if $objFormularioProyecto->chkDocDesemEntidad2 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Certificaci&oacute;n de Constituci&oacute;n de la respectiva modalidad para el manejo de los recursos.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad2" name="txtDocDesemEntidad2">{$objFormularioProyecto->txtDocDesemEntidad2}</textarea></td>
			</tr>

			<tr id="lineaBancario1" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad3" name="chkDocDesemEntidad3">
						{if $objFormularioProyecto->chkDocDesemEntidad3 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del contrato de Aval Bancario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad3" name="txtDocDesemEntidad3">{$objFormularioProyecto->txtDocDesemEntidad3}</textarea></td>
			</tr>

			<tr id="lineaFideicomiso1" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad4" name="chkDocDesemEntidad4">
						{if $objFormularioProyecto->chkDocDesemEntidad4 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia de contrato de fideicomiso de administraci&oacute;n inmobiliaria.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad4" name="txtDocDesemEntidad4">{$objFormularioProyecto->txtDocDesemEntidad4}</textarea></td>
			</tr>

			<tr id="lineaFideicomiso2" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad5" name="chkDocDesemEntidad5">
						{if $objFormularioProyecto->chkDocDesemEntidad5 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del Certificado de existencia y representaci&oacute;n legal expedido por la C&aacute;mara de Comercio.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad5" name="txtDocDesemEntidad5">{$objFormularioProyecto->txtDocDesemEntidad5}</textarea></td>
			</tr>

			<tr id="lineaFideicomiso3" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad6" name="chkDocDesemEntidad6">
						{if $objFormularioProyecto->chkDocDesemEntidad6 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del Registro &Uacute;nico Tributario - RUT de la entidad financiera.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad6" name="txtDocDesemEntidad6">{$objFormularioProyecto->txtDocDesemEntidad6}</textarea></td>
			</tr>

			<tr id="lineaFideicomiso4" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad7" name="chkDocDesemEntidad7">
						{if $objFormularioProyecto->chkDocDesemEntidad7 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">RUT del Patrimonio.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad7" name="txtDocDesemEntidad7">{$objFormularioProyecto->txtDocDesemEntidad7}</textarea></td>
			</tr>
			
			<tr id="lineaFiduciarioFideicomiso" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad8" name="chkDocDesemEntidad8">
						{if $objFormularioProyecto->chkDocDesemEntidad8 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia de la P&oacute;liza de Seguro aprobada, que amparen el buen manejo de los recursos de subsidio, el cumplimiento del contrato, la estabilidad de la obra y dem&aacute;s obligaciones que implican la entrega de las viviendas, cuyos montos y vigencias serán definidos por la SDHT (Solo para el encargo Fiduciario o Fideicomiso de Admon. Inmobiliaria)</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad8" name="txtDocDesemEntidad8">{$objFormularioProyecto->txtDocDesemEntidad8}</textarea></td>
			</tr>
			
			<tr id="lineaGenericaDocEntidadFinanciera" style="display:none">
				<td valign="top" align="center">
					<select id="chkDocDesemEntidad9" name="chkDocDesemEntidad9">
						{if $objFormularioProyecto->chkDocDesemEntidad9 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia del Certificado de existencia y representaci&oacute;n legal expedido por la Superintendencia Financiera.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemEntidad9" name="txtDocDesemEntidad9">{$objFormularioProyecto->txtDocDesemEntidad9}</textarea></td>
			</tr>
		</table>
	</p></div>

	<div id="docsProyecto" style="height:550px;" ><p>
		<table border="0">
			<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DEL PROYECTO PARA EL PRIMER DESEMBOLSO</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center"></th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto1" name="chkDocDesemProyecto1">
						{if $objFormularioProyecto->chkDocDesemProyecto1 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia de Acta Comit&eacute; de elegibilidad</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto1" name="txtDocDesemProyecto1">{$objFormularioProyecto->txtDocDesemProyecto1}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto2" name="chkDocDesemProyecto2">
						{if $objFormularioProyecto->chkDocDesemProyecto2 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia Resolución Aprobación Comité de Elegibilidad</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto2" name="txtDocDesemProyecto2">{$objFormularioProyecto->txtDocDesemProyecto2}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto3" name="chkDocDesemProyecto3">
						{if $objFormularioProyecto->chkDocDesemProyecto3 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia de Contrato de Interventor&iacute;a, con una persona natural o jur&iacute;dica de la lista de profesionales inscritos en el Consejo Profesional Nacional de Ingenier&iacute;a y Arquitectura, para estos efectos, el contrato de interventor&iacute;a, podr&aacute; se rel mismo de los desembolsos de recursos del cr&eacute;dito constructor o hipotecario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto3" name="txtDocDesemProyecto3">{$objFormularioProyecto->txtDocDesemProyecto3}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto4" name="chkDocDesemProyecto4">
						{if $objFormularioProyecto->chkDocDesemProyecto4 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Certificado de Tradici&oacute;n  y Libertad del terreno en el que se verifique la propiedad y que se encuentre libre de cualquier tipo de gravamen, excepto por la hipoteca a favor de la entidad que financia el proyecto, en caso tal que se encunetre con cr&eacute;dito hipotecario constructor.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto4" name="txtDocDesemProyecto4">{$objFormularioProyecto->txtDocDesemProyecto4}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto5" name="chkDocDesemProyecto5">
						{if $objFormularioProyecto->chkDocDesemProyecto5 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Los estudios de factibilidad y el presupuesto del proyecto, en el formato que para el efecto disponga la Subsecretar&iacute;a de Coordinaci&oacute;n operativa a trav&eacute;s de la Subdirecci&oacute;n de Apoyo a la Construcci&oacute;n.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto5" name="txtDocDesemProyecto5">{$objFormularioProyecto->txtDocDesemProyecto5}</textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<select id="chkDocDesemProyecto6" name="chkDocDesemProyecto6">
						{if $objFormularioProyecto->chkDocDesemProyecto6 == "1"}
							<option value="0">No</option><option value="1" selected>Si</option>
						{else}
							<option value="0" selected>No</option><option value="1">Si</option>
						{/if}
					</select>
				</td>
				<td valign="top" align="justify">Copia contrato encargo fiduciario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocDesemProyecto6" name="txtDocDesemProyecto6">{$objFormularioProyecto->txtDocDesemProyecto6}</textarea></td>
			</tr>
		</table>
	</p></div>

	<!--<div id="cronogramaObras" style="height:850px;" >
	{include file="proyectos/secCronogramaObras.tpl"}
	</div>
	
	<div id="seguimientoObras" style="height:850px;" ><p>
		
			<table border="0"  width="860">
				<tr><td class="tituloTabla" colspan="7">SEGUIMIENTO A OBRAS</td></tr>
				<tr><td colspan="5" align="right"><div onClick="addSeguimientoActividad('{$optActividadesCronograma}', '{$optEstadoActividades}')" style="cursor: hand"=>Adicionar Seguimiento&nbsp;<img src="recursos/imagenes/plus_icon.gif"></div></td><td colspan="2"></td></tr>
			</table>
			<div style="width:860px; overflow: scroll;">
				<table  width="1125" border="0" cellspacing="2" cellpadding="0">
					<tr class="tituloTabla">
						<th align="center" width="5%" style="padding:6px;">No.</th>
						<th align="center" width="17%" style="padding:6px;">Actividad</th>
						<th align="center" width="20%" style="padding:6px;">Descripci&oacute;n seguimiento</th>
						<th align="center" width="10%" style="padding:6px;">Estado</th>
						<th align="center" width="13%" style="padding:6px;">Fecha</th>
						<th align="center" width="17%" style="padding:6px;">Usuario</th>
						<th align="center" width="8%" style="padding:6px;"></th>
					</tr>
				</table>
			<table  width="1125" border="0" cellspacing="2" cellpadding="0" id="tablaSeguimientoActividades">
				{assign var="num" value="0"}
				{counter start=0 print=false assign=num}
				{foreach from=$arrSeguimientoActividad key=seqActividadCronograma item=arrSeguimiento}
					{if $num++%2 == 0} <tr class="fila_0">
					{else} <tr class="fila_1">
					{/if}
						<td align="center" width="5%" valign="top" style="padding:6px;">{$arrSeguimiento.seqSeguimientoActividad}</td>
						<td width="17%" valign="top" style="padding:6px;">{$arrSeguimiento.txtNombreActividad}</td>
						<td width="20%" valign="top" style="padding:6px;">{$arrSeguimiento.txtDescripcionSeguimiento}</td>
						<td align="center" width="10%" valign="top" style="padding:6px;">{$arrSeguimiento.txtEstadoActividad}</td>
						<td align="center" width="13%" valign="top" style="padding:6px;">{$arrSeguimiento.fchSeguimientoActividad}</td>
						<td width="17%" valign="top" style="padding:6px;">{$arrSeguimiento.txtNombreCompleto}
						{foreach from=$arrSeguimiento key=seqUsuario item=txtNombreCompleto}{if $objFormularioProyecto->seqUsuario == $seqUsuario} {$txtNombreCompleto} {/if}{/foreach}</td>
						<td align="center" width="8%" valign="top" style="padding:6px;"></td>
					</tr>
				{/foreach}
			</table>
		</div>
	</div>-->
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
<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarDesembolso.php">
<input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
<input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="desembolsoPryTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>