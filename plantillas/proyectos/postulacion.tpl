<!-- PLANTILLA DE POSTULACION CON PESTAÑAS -->
<form name="frmPostulacion" id="frmPostulacion" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

	<!-- CODIGO PARA EL POP UP DE SEGUIMIENTO -->
	{assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
	{include file='proyectos/pedirSeguimiento.tpl'}
	<br>
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="z-index:999999;">
	<tr>
		<td style='display: none' width="150px" align="center">
		</td>
		<td></td><td></td><td></td>
		<td align="right" style="padding-right: 10px;" width="250px">
            <!--<input type="submit" name="salvar" id="salvar" value="Salvar Postulaci&oacute;n" onClick="preguntarAntes()">-->
            <input type="submit" name="salvar" id="salvar" value="Salvar Postulaci&oacute;n">
        </td>
    </tr>
</table>
<br>
<!-- TAB VIEW DE POSTULACION -->
<div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
    <ul class="yui-nav">
        <li class="selected"><a href="#frm"><em>Formulario</em></a></li>
        <li><a href="#seg"><em>Seguimiento</em></a></li>
    </ul>
    <div class="yui-content">
        <!-- FORMULARIO DE POSTULACION -->
        <div id="frm" style="height:1020px;">
			<div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
				<ul class="yui-nav">
					<li class="selected"><a href="#datosHogar"><em>Proyecto</em></a></li>
					<li><a href="#datosOferente"><em>Oferente</em></a></li>
					<li><a href="#datosFinancieros"><em>Datos Financieros</em></a></li>
					<li><a href="#tiposVivienda"><em>Tipos Vivienda</em></a></li>
					<li><a href="#conjuntosResidenciales"><em>Conjuntos Residenciales</em></a></li>
					<li><a href="#datosCronograma"><em>Cronograma</em></a></li>
					<li><a href="#documentosConstructor"><em>Doc. Constructor</em></a></li>
					<li><a href="#documentosProyecto"><em>Doc.	 Proyecto</em></a></li>
				</ul>
				<div class="yui-content">
					<!-- DATOS DEL PROYECTO -->
					<div id="datosHogar" style="height:970px;"><p>
						<!-- ESTADO DEL PROCESO -->
						<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
							<tr bgcolor="#E4E4E4">
								<td align="right"><b>Estado del proceso:</b></td>
								<td>{if $seqPryEstadoProceso == "1"} {$arrEstadosProceso.1} {else} {$arrEstadosProceso.2} {/if}
									<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="3">
								</td>
								<td align="right"><b>Fecha de Inscripci&oacute;n:</b></td>
								<td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
								<td align="right"><b>Fecha de Actualizaci&oacute;n:</b></td>
								<td>{$objFormularioProyecto->fchUltimaActualizacion}&nbsp;</td>
							</tr>
							<tr><td height="5px"></td></tr>
						</table>
						{include file="proyectos/secDatosProyecto.tpl"}
					</div>

					<!-- DATOS DEL OFERENTE -->
					<div id="datosOferente" style="height:400px;">
						{include file="proyectos/secDatosOferente.tpl"}
					</div>
					
					<!-- DATOS FINANCIEROS -->
					<div id="datosFinancieros" style="height:450px;">
						{include file="proyectos/secDatosFinancieros.tpl"}
					</div>
					
					<!-- TIPOS DE VIVIENDA (ESTRUCTURA DEL PROYECTO) -->
					<div id="tiposVivienda" style="height:400px;">
						{include file="proyectos/secTipoVivienda.tpl"}
					</div>
			
					<!-- CONJUNTOS RESIDENCIALES (SUBPROYECTOS) -->
					<div id="conjuntosResidenciales" style="height:400px;">
						{include file="proyectos/secConjuntoResidencial.tpl"}
					</div>
					
					<!-- CRRONOGRAMA DE OBRAS -->
					<div id="datosCronograma" style="height:400px;">
						{include file="proyectos/secCronogramaFechas.tpl"}
					</div>

					<!-- DOCUMENTOS REQUERIDOS DEL CONSTRUCTOR PARA PRESENTACION A COMITE DE ELEGIBILIDAD -->
					<div id="documentosConstructor" style="height:600px;">
						<p><table border="0">
							<tr><td class="tituloTabla" colspan="3">DOCUMENTOS REQUERIDOS DEL CONSTRUCTOR PARA PRESENTAR A COMIT&Eacute; DE ELEGIBILIDAD</td></tr>
							<tr class="tituloTabla">
								<th width="5%" align="center"></th>
								<th width="70%" align="center">Documento</th>
								<th width="25%" align="center">Observac&oacute;n</th>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor1" name="chkDocConstructor1">
										{if $objFormularioProyecto->chkDocConstructor1 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Fotocopia del Certificado de Existencia y Representaci&oacute;n Legal.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor1" name="txtDocConstructor1">{$objFormularioProyecto->txtDocConstructor1}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor2" name="chkDocConstructor2">
										{if $objFormularioProyecto->chkDocConstructor2 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Fotocopia de la C&eacute;dula del Representante Legal.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor2" name="txtDocConstructor2">{$objFormularioProyecto->txtDocConstructor2}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor3" name="chkDocConstructor3">
										{if $objFormularioProyecto->chkDocConstructor3 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Fotocopia del RUT.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor3" name="txtDocConstructor3">{$objFormularioProyecto->txtDocConstructor3}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor4" name="chkDocConstructor4">
										{if $objFormularioProyecto->chkDocConstructor4 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Fotocopia del RIT.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor4" name="txtDocConstructor4">{$objFormularioProyecto->txtDocConstructor4}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor5" name="chkDocConstructor5">
										{if $objFormularioProyecto->chkDocConstructor5 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Registro de Enajenador expedido por la Subsecretaria de Inspecci&oacute;n, Vigilancia y Control de Vivienda.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor5" name="txtDocConstructor5">{$objFormularioProyecto->txtDocConstructor5}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor6" name="chkDocConstructor6">
										{if $objFormularioProyecto->chkDocConstructor6 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Portafolio de Proyectos constru&iacute;dos y Tecnolog&iacute;as utilizadas, si existieran proyectos.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor6" name="txtDocConstructor6">{$objFormularioProyecto->txtDocConstructor6}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor7" name="chkDocConstructor7">
										{if $objFormularioProyecto->chkDocConstructor7 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Estados Financieros comparativos de los ultimos dos años gravables, con las notas que acompañan los estados financieros.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor7" name="txtDocConstructor7">{$objFormularioProyecto->txtDocConstructor7}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocConstructor8" name="chkDocConstructor8">
										{if $objFormularioProyecto->chkDocConstructor8 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option><option value="2">N/A</option>
										{elseif $objFormularioProyecto->chkDocConstructor8 == "0"}
											<option value="0" selected>No</option><option value="1">Si</option><option value="2">N/A</option>
										{else}
											<option value="0">No</option><option value="1">Si</option><option value="2" selected>N/A</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Declaraci&oacute;n de renta de los ultimos dos años gravables, si el oferente es declarante.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocConstructor8" name="txtDocConstructor8">{$objFormularioProyecto->txtDocConstructor8}</textarea></td>
							</tr>
						</table></p>
					</div>

					<!-- DOCUMENTOS REQUERIDOS DEL PROYECTO PARA PRESENTACION A COMITE DE ELEGIBILIDAD -->
					<div id="documentosProyecto" style="height:600px;">
						<p><table border="0">
							<tr><td class="tituloTabla" colspan="3" align="center">DOCUMENTOS REQUERIDOS DEL PROYECTO PARA PRESENTAR A COMIT&Eacute; DE ELEGIBILIDAD</td></tr>
							<tr class="tituloTabla">
								<th width="5%" align="center"></th>
								<th width="70%" align="center">Documento</th>
								<th width="25%" align="center">Observac&oacute;n</th>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto1" name="chkDocProyecto1">
										{if $objFormularioProyecto->chkDocProyecto1 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option><option value="2">N/A</option>
										{elseif $objFormularioProyecto->chkDocProyecto1 == "0"}
											<option value="0" selected>No</option><option value="1">Si</option><option value="2">N/A</option>
										{else}
											<option value="0">No</option><option value="1">Si</option><option value="2" selected>N/A</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Licencia de Urbanismo del Proyecto aprobada y vigente, con los planos presentados para la expedici&oacute;n.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto1" name="txtDocProyecto1">{$objFormularioProyecto->txtDocProyecto1}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto2" name="chkDocProyecto2">
										{if $objFormularioProyecto->chkDocProyecto2 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Certificado de Tradici&oacute;n y Libertad del predio de mayor extensi&oacute;n en el que se desarrollar&aacute; el proyecto inmobiliario, en caso de que no se hayan segregado los folios correspondientes a las unidades habitacionales independientes, con fecha de expedici&oacute;n no mayor a 30 d&iacute;as calendario, que certifique que la propiedad est&aacute; libre de embargos e hipotecas, excepto la constitu&iacute;da a favor de la entidad que financie el proyecto.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto2" name="txtDocProyecto2">{$objFormularioProyecto->txtDocProyecto2}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto3" name="chkDocProyecto3">
										{if $objFormularioProyecto->chkDocProyecto3 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Copia de la escritura p&uacute;blica del predio de mayor extensi&oacute;n en caso que no se hayan segregado los folios correspondientes a las unidades habitacionales independientes.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto3" name="txtDocProyecto3">{$objFormularioProyecto->txtDocProyecto3}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto4" name="chkDocProyecto4">
										{if $objFormularioProyecto->chkDocProyecto4 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Paz y Salvo por el pago del impuesto predial, de contribuci&oacute;n de valorizaci&oacute;n y de cualquier otro tributo que grave la propiedad inmueble.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto4" name="txtDocProyecto4">{$objFormularioProyecto->txtDocProyecto4}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto5" name="chkDocProyecto5">
										{if $objFormularioProyecto->chkDocProyecto5 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Ficha General del Proyecto que incluya: (i) Memoria, (ii) Planos de localizaci&oacute;n, implantaci&oacute;n urbana, (iii) Cuadro de &Aacute;reas y (iv) N&uacute;mero aproximado de soluciones de vivienda ofrecidas por tipo de unidad.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto5" name="txtDocProyecto5">{$objFormularioProyecto->txtDocProyecto5}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto6" name="chkDocProyecto6">
										{if $objFormularioProyecto->chkDocProyecto6 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Presupuesto y/o factibilidad del proyecto ajustado a las licencias.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto6" name="txtDocProyecto6">{$objFormularioProyecto->txtDocProyecto6}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto7" name="chkDocProyecto7">
										{if $objFormularioProyecto->chkDocProyecto7 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Flujo de Caja.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto7" name="txtDocProyecto7">{$objFormularioProyecto->txtDocProyecto7}</textarea></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<select id="chkDocProyecto8" name="chkDocProyecto8">
										{if $objFormularioProyecto->chkDocProyecto8 == "1"}
											<option value="0">No</option><option value="1" selected>Si</option>
										{else}
											<option value="0" selected>No</option><option value="1">Si</option>
										{/if}
									</select>
								</td>
								<td valign="top" align="justify">Cronograma General del Proyecto en la que se incluya fecha estimada de escrituraci&oacute;n y entrega.</td>
								<td valign="top"><textarea cols="38" rows="2" id="txtDocProyecto8" name="txtDocProyecto8">{$objFormularioProyecto->txtDocProyecto8}</textarea></td>
							</tr>
						</table></p>
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
<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarPostulacion.php">
<input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
<input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>