<!-- PLANTILLA DE POSTULACION CON PESTAÑAS -->
<form name="frmActualizacion" id="frmActualizacion" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >
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
				<input type="submit" name="salvar" id="salvar" value="Salvar Actualizaci&oacute;n">
			</td>
		</tr>
	</table>
	<br>
	<div id="postulacion" class="yui-navset" style="width:100%; text-align:left;">
		<ul class="yui-nav">
			<li class="selected"><a href="#frm"><em>Formulario</em></a></li>
			<li><a href="#seg"><em>Seguimiento</em></a></li>
		</ul>
		<div class="yui-content">
			<!-- FORMULARIO DE ACTUALIZACION -->	    
			<div id="frm" style="height:650px;">
				<div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
					<ul class="yui-nav">
						<li class="selected"><a href="#revPreliminar"><em>Revisi&oacute;n Preliminar</em></a></li>
						<li><a href="#datosHogar"><em>Datos Proyecto</em></a></li>
						<li><a href="#datosCronogramaObras"><em>Cronograma Obras</em></a></li>
						<li><a href="#datosSeguimientoObras"><em>Seguimiento Obras</em></a></li>
					</ul>
					<div class="yui-content">
						<!-- REVISION PRELIMINAR -->
						<div id="datosHogar" style="height:400px;"><p>
							{include file="proyectos/secRevisionPreliminar.tpl"}
						</div>

						<!-- DATOS DEL PROYECTO -->
						<div id="datosHogar" style="height:400px;"><p>
							<!-- ESTADO DEL PROCESO -->
							<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
								<tr bgcolor="#E4E4E4">
									<td align="right"><b>Estado del proceso:</b></td>
									<td>{if $seqPryEstadoProceso == "1"} {$arrEstadosProceso.1} {else} {$arrEstadosProceso.6} {/if}
										<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="6">
									</td>
									<td align="right"><b>Fecha de Inscripci&oacute;n:</b></td>
									<td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
									<td align="right"><b>Fecha de Actualizaci&oacute;n:</b></td>
									<td>{$objFormularioProyecto->fchUltimaActualizacion}&nbsp;</td>
								</tr>
								<tr><td height="5px"></td></tr>
							</table>
							{include file="proyectos/secDatosProyectoTecnicos.tpl"}
						</div>

						<!-- CRONOGRAMA DE OBRAS -->
						<div id="datosCronogramaObras" style="height:420px;">
							<div id="pestanasCronogramaObras" class="yui-navset" style="width:100%; text-align:left;">
								<ul class="yui-nav">
									<li class="selected"><a href="#datosTerreno"><em>Terreno</em></a></li>
									<li><a href="#datosConstruccion"><em>Construcci&oacute;n</em></a></li>
									<li><a href="#datosConstruccionUrbanismo"><em>Construcci&oacute;n Urbanismo</em></a></li>
									<li><a href="#datosControlHitos"><em>Control Hitos</em></a></li>
								</ul>
								<div class="yui-content">
									<!-- DATOS TERRENO -->
									<div id="datosTerreno" style="height:383px;">
										{include file="proyectos/secCronoObrasTerreno.tpl"}
									</div>
									<!-- DATOS CONSTRUCCION -->
									<div id="datosConstruccion" style="height:383px;">
										{include file="proyectos/secCronoObrasConstruccion.tpl"}
									</div>
									<!-- DATOS CONSTRUCCION URBANISMO-->
									<div id="datosConstruccionUrbanismo" style="height:383px;">
										{include file="proyectos/secCronoObrasConstruccionUrb.tpl"}
									</div>
									<!-- TRAMITES DE LICENCIA-->
									<div id="datosControlHitos" style="height:383px;">
										{include file="proyectos/secControlHitos.tpl"}
									</div>
								</div>
							</div>
						</div>
						
						<!-- SEGUIMIENTO A OBRAS -->
						<div id="datosSeguimientoObras" style="height:400px;">
							{include file="proyectos/secSeguimientoObras.tpl"}
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
	<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarSeguimientoObras.php">
</form>

<div id="postulacionTabView"></div>
<div id="cronogramaObrasTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>