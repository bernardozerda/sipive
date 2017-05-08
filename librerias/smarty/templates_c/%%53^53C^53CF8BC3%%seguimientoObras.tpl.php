<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/seguimientoObras.tpl */ ?>
<!-- PLANTILLA DE POSTULACION CON PESTAÑAS -->
<form name="frmActualizacion" id="frmActualizacion" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >
	<!-- CODIGO PARA EL POP UP DE SEGUIMIENTO -->
	<?php $this->assign('seqPryEstadoProceso', $this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'proyectos/pedirSeguimiento.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secRevisionPreliminar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</div>

						<!-- DATOS DEL PROYECTO -->
						<div id="datosHogar" style="height:400px;"><p>
							<!-- ESTADO DEL PROCESO -->
							<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
								<tr bgcolor="#E4E4E4">
									<td align="right"><b>Estado del proceso:</b></td>
									<td><?php if ($this->_tpl_vars['seqPryEstadoProceso'] == '1'): ?> <?php echo $this->_tpl_vars['arrEstadosProceso']['1']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['arrEstadosProceso']['6']; ?>
 <?php endif; ?>
										<input type="hidden" name="seqPryEstadoProceso" id="seqPryEstadoProceso" value="6">
									</td>
									<td align="right"><b>Fecha de Inscripci&oacute;n:</b></td>
									<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchInscripcion; ?>
&nbsp;</td>
									<td align="right"><b>Fecha de Actualizaci&oacute;n:</b></td>
									<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchUltimaActualizacion; ?>
&nbsp;</td>
								</tr>
								<tr><td height="5px"></td></tr>
							</table>
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secDatosProyectoTecnicos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secCronoObrasTerreno.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
									<!-- DATOS CONSTRUCCION -->
									<div id="datosConstruccion" style="height:383px;">
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secCronoObrasConstruccion.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
									<!-- DATOS CONSTRUCCION URBANISMO-->
									<div id="datosConstruccionUrbanismo" style="height:383px;">
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secCronoObrasConstruccionUrb.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
									<!-- TRAMITES DE LICENCIA-->
									<div id="datosControlHitos" style="height:383px;">
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secControlHitos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
								</div>
							</div>
						</div>
						
						<!-- SEGUIMIENTO A OBRAS -->
						<div id="datosSeguimientoObras" style="height:400px;">
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "proyectos/secSeguimientoObras.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</div>
					</div>
				</div>
			</div>
			<!-- SEGUIMIENTO AL PROYECTO -->
			<div id="seg" style="height:401px; overflow:auto">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimientoProyectos/seguimientoFormulario.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<div id="contenidoBusqueda" >
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimientoProyectos/buscarSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="seqProyectoEditar" name="seqProyectoEditar" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->seqProyecto; ?>
">
	<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarSeguimientoObras.php">
</form>

<div id="postulacionTabView"></div>
<div id="cronogramaObrasTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>