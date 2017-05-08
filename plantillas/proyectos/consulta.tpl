<!-- PLANTILLA DE SOLO LECTURA CON PESTAÑAS -->
<form name="frmElegibilidad" id="frmElegibilidad" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

<!-- TAB VIEW DE SOLO LECTURA -->
<div id="elegibilidad" class="yui-navset" style="width:100%; text-align:left;">
	<ul class="yui-nav">
		<li class="selected"><a href="#frm"><em>Formulario</em></a></li>
		<li><a href="#seg"><em>Seguimiento</em></a></li>
	</ul>
	<div class="yui-content">
		<!-- FORMULARIO DE SOLO LECTURA -->
		<div id="frm" style="height:900px;">
			<div id="pestanasProyectosElegibilidad" class="yui-navset" style="width:100%; text-align:left;">
				<ul class="yui-nav">
					<li class="selected"><a href="#datosProyecto"><em>Datos del Proyecto</em></a></li>
					<li><a href="#elegibilidad"><em>Comit&eacute; de Elegibilidad</em></a></li>
				</ul>
				<div class="yui-content">
					<!-- DATOS DEL PROYECTO -->
					<div id="datosProyecto" style="height:850px;">
						<div id="pestanasPostulacion" class="yui-navset" style="width:100%; text-align:left;">
							<ul class="yui-nav">
								<li class="selected"><a href="#datosBasicosProyecto"><em>Datos b&aacute;sicos</em></a></li>
								<li><a href="#datosOferente"><em>Oferente</em></a></li>
								<li><a href="#datosFinancieros"><em>Datos Financieros</em></a></li>
								<li><a href="#datosTiposVivienda"><em>Tipos de Vivienda</em></a></li>
								<li><a href="#datosConjuntosResidenciales"><em>Conjuntos Residenciales</em></a></li>
								<li><a href="#datosCronograma"><em>Cronograma</em></a></li>
							</ul>
							<div class="yui-content">
								<div id="datosBasicosProyecto" style="height:800px;">
									{include file="proyectos/secConsultaProyecto.tpl"}
								</div>
								<div id="datosOferente" style="height:383px;">
									{include file="proyectos/secConsultaOferente.tpl"}
								</div>
								<div id="datosFinancieros" style="height:383px;">
									{include file="proyectos/secConsultaFinancieros.tpl"}
								</div>
								<div id="datosTiposVivienda" style="height:383px;">
									{include file="proyectos/secConsultaTiposVivienda.tpl"}
								</div>
								<div id="datosConjuntosResidenciales" style="height:383px;">
									{include file="proyectos/secConsultaConjuntosResidenciales.tpl"}
								</div>
								<div id="datosCronograma" style="height:383px;">
									{include file="proyectos/secConsultaCronograma.tpl"}
								</div>
							</div>
						</div>
					</div>

					<!-- DATOS DE COMITE DE ELEGIBILIDAD -->
					<div id="elegibilidad" style="height:379px;" >
						<div id="pestanasCronogramaObras" class="yui-navset" style="width:100%; text-align:left;">
								<ul class="yui-nav">
									<li class="selected"><a href="#datosComiteElegibilidad"><em>Comit&eacute; Elegibilidad</em></a></li>
									<li><a href="#datosActas"><em>Actas</em></a></li>
									<li><a href="#datosResoluciones"><em>Resoluciones</em></a></li>
								</ul>
								<div class="yui-content">
									<div id="datosComiteElegibilidad" style="height:383px;">
										{include file="proyectos/secConsultaElegibilidad.tpl"}
									</div>
									<div id="datosActas" style="height:383px;">
										{include file="proyectos/secConsultaActas.tpl"}
									</div>
									<div id="datosResoluciones" style="height:383px;">
										{include file="proyectos/secConsultaResoluciones.tpl"}
									</div>
								</div>
							</div>
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
</form>

<div id="elegibilidadPryTabView"></div>
<div id="cronogramaObrasTabView"></div>
<div id="postulacionTabView"></div>
<div id="desembolsoPryTabView"></div>
<div id="seguimientoPryTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>