<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaProyecto.tpl */ ?>
<!-- ESTADO DEL PROCESO -->
<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
	<tr bgcolor="#E4E4E4">
		<td width="140px"><b>Estado del proceso</b></td>
		<td width="280px"><?php $_from = $this->_tpl_vars['arrEstadosProceso']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqPryEstadoProceso'] => $this->_tpl_vars['txtPryEstadoProceso']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqPryEstadoProceso == $this->_tpl_vars['seqPryEstadoProceso']): ?> <?php echo $this->_tpl_vars['txtPryEstadoProceso']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		<td width="140px"><b>Fecha de Inscripción</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchInscripcion; ?>
&nbsp;</td>
	</tr>
	<tr><td height="5px"></td></tr>
</table>

<table cellspacing="0" cellpadding="2" border="0" width="100%">

	<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO
	<img src="recursos/imagenes/blank.gif" onload="escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona(); escondeLineaOpv(); escondeOperador();">
	<img src="recursos/imagenes/blank.gif" onload="escondeSeccionAprobacion(); muestraCondicionAprobacion();">
	</td></tr>
	<tr><!-- NOMBRE DEL PROYECTO -->
		<td><b>Nombre del Proyecto</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreProyecto; ?>
</td>
		<!-- PLAN PARCIAL -->
		<td><b>Nombre del Plan Parcial</b></td>
		<td><?php if ($this->_tpl_vars['arrPrivilegios']['editar'] == 1): ?>
				<?php $this->assign('soloLectura', ""); ?>
			<?php else: ?>
				<?php $this->assign('soloLectura', 'readonly'); ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['objFormularioProyecto']->txtNombrePlanParcial == ""): ?>
				Ninguno
			<?php else: ?>
				<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombrePlanParcial; ?>

			<?php endif; ?>
		</td>
	</tr>
	<tr>
	<!-- NOMBRE COMERCIAL DEL PROYECTO -->
		<td><b>Nombre Comercial</b></td>
		<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreComercial; ?>
</td>
	</tr>
	<tr><!-- TIPO DE ESQUEMA -->
		<td width="25%"><b>Tipo de Esquema</b></td>
		<td width="25%"><?php $_from = $this->_tpl_vars['arrTipoEsquema']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoEsquema'] => $this->_tpl_vars['txtTipoEsquema']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoEsquema == $this->_tpl_vars['seqTipoEsquema']): ?> <?php echo $this->_tpl_vars['txtTipoEsquema']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		<!-- TIPO DE MODALIDAD -->
		<td width="25%"><b>Tipo de Modalidad</b></td>
		<td id="tdModalidad" width="25%"><?php $_from = $this->_tpl_vars['arrPryTipoModalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqPryTipoModalidad'] => $this->_tpl_vars['txtPryTipoModalidad']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqPryTipoModalidad == $this->_tpl_vars['seqPryTipoModalidad']): ?> <?php echo $this->_tpl_vars['txtPryTipoModalidad']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
	</tr>
	<?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoEsquema == '2'): ?>
		<tr><!-- NOMBRE DE LA OPV (ESQUEMA: COLECTIVO OPV) -->
			<td><b>Nombre de la OPV</b></td>
			<td colspan="3" ><?php $_from = $this->_tpl_vars['arrOpv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqOpv'] => $this->_tpl_vars['txtNombreOpv']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqOpv == $this->_tpl_vars['seqOpv']): ?> <?php echo $this->_tpl_vars['txtNombreOpv']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoEsquema == '4'): ?>
		<tr><!-- OPERADOR (ESQUEMA: TERRITORIAL DIRIGIDA) -->
			<td><b>Nombre del Operador</b></td>
			<td colspan='3'><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreOperador; ?>
</td>
		</tr>
	<?php endif; ?>
	<tr><!-- TIPO DE PROYECTO -->
		<td><b>Tipo de Proyecto</b></td>
		<td><?php $_from = $this->_tpl_vars['arrTipoProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoProyecto'] => $this->_tpl_vars['txtTipoProyecto']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoProyecto == $this->_tpl_vars['seqTipoProyecto']): ?> <?php echo $this->_tpl_vars['txtTipoProyecto']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		<!-- DESCRIPCION DEL PROYECTO -->
		<td rowspan="3" valign="top"><b>Descripci&oacute;n del Proyecto</b></td>
		<td rowspan="3" valign="top"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescripcionProyecto; ?>
</td>
	</tr>
	<tr><!-- TIPO DE URBANIZACION -->
		<td><b>Tipo de Urbanizaci&oacute;n</b></td>
		<td><?php $_from = $this->_tpl_vars['arrTipoUrbanizacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoUrbanizacion'] => $this->_tpl_vars['txtTipoUrbanizacion']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoUrbanizacion == $this->_tpl_vars['seqTipoUrbanizacion']): ?> <?php echo $this->_tpl_vars['txtTipoUrbanizacion']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
	</tr>
	<tr><!-- TIPO DE SOLUCION -->
		<td><b>Tipo de Soluci&oacute;n</b></td>
		<td><?php $_from = $this->_tpl_vars['arrTipoSolucion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoSolucion'] => $this->_tpl_vars['txtTipoSolucion']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqTipoSolucion == $this->_tpl_vars['seqTipoSolucion']): ?> <?php echo $this->_tpl_vars['txtTipoSolucion']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
	</tr>
	<tr><!-- LOCALIDAD DEL PROYECTO -->
		<td><b>Localidad</b></td>
		<td><?php $_from = $this->_tpl_vars['arrLocalidad']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqLocalidad'] => $this->_tpl_vars['txtLocalidad']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqLocalidad == $this->_tpl_vars['seqLocalidad']): ?> <?php echo $this->_tpl_vars['txtLocalidad']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		<!-- DIRECCION DEL PROYECTO -->
		<td><b>Direcci&oacute;n</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccion; ?>
</td>
	</tr>
	<tr><!-- BARRIO -->
		<td><b>Barrio</b></td>
		<td><?php $_from = $this->_tpl_vars['arrBarrio']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqBarrio'] => $this->_tpl_vars['txtBarrio']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqBarrio == $this->_tpl_vars['seqBarrio']): ?> <?php echo $this->_tpl_vars['txtBarrio']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?></td>
		<!-- TORRES -->
		<td><b>Torres</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valTorres; ?>
</td>
	</tr>
	<tr><!-- NUMERO DE SOLUCIONES -->
		<td><b>N&uacute;mero Soluciones</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valNumeroSoluciones; ?>
</td>
		<!-- AREA CONSTRUIDA -->
		<td><b>Area a construir</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valAreaConstruida; ?>
&nbsp;m²</td>
	</tr>
	<tr><!-- AREA LOTE -->
		<td><b>Area Lote</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->valAreaLote; ?>
&nbsp;m²</td>
		<td colspan="2"></td>
	</tr>

	<tr><!-- COSTO DEL PROYECTO -->
		<td><b>Costo estimado del Proyecto</b></td>
		<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCostoProyecto; ?>
</td>
		<!-- VALOR CIERRE FINANCIERO -->
			<td><b>Valor Cierre Financiero</b></td>
			<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCierreFinanciero; ?>
</td>
	</tr>
	<tr><!-- CHIP DEL PROYECTO -->
		<td><b>Chip Lote</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtChipLote; ?>
</td>
		<!-- MATRICULA INMOBILIARIA DEL PROYECTO -->
		<td><b>Matr&iacute;cula Inmobiliaria Lote</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtMatriculaInmobiliariaLote; ?>
</td>
	</tr>
	<tr><!-- REGISTRO DE ENAJENACION -->
		<td><b>Registro de Enajenación</b></td>
		<td align="left"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtRegistroEnajenacion; ?>
</td>
		<!-- FECHA REGISTRO DE ENAJENACION -->
		<td><b>Fecha Registro de Enajenación</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchRegistroEnajenacion; ?>
</td>
	<tr><!-- EQUIPAMIENTO COMUNAL -->
		<td valign="top"><b>Tiene Equipamiento Comunal?</b></td>
		<td valign="top" align="left">
			<?php if ($this->_tpl_vars['objFormularioProyecto']->bolEquipamientoComunal == 1): ?> Si <?php endif; ?> 
			<?php if ($this->_tpl_vars['objFormularioProyecto']->bolEquipamientoComunal == 0): ?> No <?php endif; ?> 
		</td>
		<?php if ($this->_tpl_vars['objFormularioProyecto']->bolEquipamientoComunal == 1): ?>
			<!-- DESCRIPCION DE EQUIPAMIENTO COMUNAL -->
			<td valign="top"><b>Descripci&oacute;n Equipamiento Comunal</b></td>
			<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDescEquipamientoComunal; ?>
</td>
		<?php endif; ?>
	</tr>

	<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
		<tr><!-- VALOR COSTOS DIRECTOS -->
			<td><b>Valor Costos Directos</b></td>
			<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosDirectos; ?>
</td>
			<!-- VALOR COSTOS INDIRECTOS -->
			<td><b>Valor Costos Indirectos</b></td>
			<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosIndirectos; ?>
</td>
		</tr>
		<tr><!-- VALOR TERRENO -->
			<td><b>Valor Terreno</b></td>
			<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTerreno; ?>
</td>
			<!-- VALOR TOTAL PROYECTO VIP -->
			<td><b>Valor Total Proyecto VIP</b></td>
			<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalCostos; ?>
</td>
		</tr>

	<tr><td class="tituloTabla" colspan="4">LICENCIA DE URBANISMO</td></tr>
	<tr><!-- LICENCIA DE URBANISMO -->
		<td><b>N&uacute;mero de Licencia</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtLicenciaUrbanismo; ?>
</td>
		<!-- EXPIDE LICENCIA DE URBANISMO -->
		<td><b>Expide</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtExpideLicenciaUrbanismo; ?>
</td>
	</tr>

	<tr><!-- FECHA DE LICENCIA DE URBANISMO -->
		<td><b>Fecha de Licencia</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo1; ?>
</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td><b>Vigencia de Licencia</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchVigenciaLicenciaUrbanismo; ?>
</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE URBANISMO (PRIMERA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 1</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo2; ?>
</td>
		<!-- FECHA DE LICENCIA DE URBANISMO (SEGUNDA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 2</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaUrbanismo3; ?>
</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE URBANISMO -->
		<td><b>Fecha Ejecutoria</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchEjecutoriaLicenciaUrbanismo; ?>
</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td><b>Resoluci&oacute;n Ejecutoria</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtResEjecutoriaLicenciaUrbanismo; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">LICENCIA DE CONSTRUCCION</td></tr>
	<tr><!-- LICENCIA DE CONSTRUCCION -->
		<td><b>N&uacute;mero de Licencia</b></td>
		<td colspan="2"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtLicenciaConstruccion; ?>
</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE CONSTRUCCION -->
		<td><b>Fecha de Licencia</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion1; ?>
</td>
		<!-- VIGENCIA DE LICENCIA DE CONSTRUCCION -->
		<td><b>Vigencia de Licencia</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchVigenciaLicenciaConstruccion; ?>
</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE CONSTRUCCION (PRIMERA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 1</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion2; ?>
</td>
		<!-- FECHA DE LICENCIA DE COSNTRUCCION (SEGUNDA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 2</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->fchLicenciaConstruccion3; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESCRITURACION</td></tr>
	<tr>
		<!-- NOMBRE DEL VENDEDOR -->
		<td>Nombre del vendedor</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreVendedor; ?>
</td>
		<!-- NIT VENDEDOR -->
		<td>NIT</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numNitVendedor; ?>
</td>
	</tr>

	<tr>
		<!-- CEDULA CATASTRAL -->
		<td>C&eacute;dula Catastral</td>
		<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCedulaCatastral; ?>
</td>
	</tr>

	<tr>
		<!-- NUMERO Y FECHA ESCRITURA -->
		<td>No. Escritura</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtEscritura; ?>
 del <?php echo $this->_tpl_vars['objFormularioProyecto']->fchEscritura; ?>
</td>
		<!-- NUMERO NOTARIA -->
		<td>No. Notar&iacute;a</td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numNotaria; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
	<tr><!-- NOMBRE INTERVENTOR -->
		<td><b>Nombre</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreInterventor; ?>
</td>
		<!-- TELEFONO INTERVENTOR -->
		<td><b>Tel&eacute;fono</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoInterventor; ?>
</td>
	</tr>
	<tr><!-- DIRECCION INTERVENTOR -->
		<td><b>Direcci&oacute;n</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionInterventor; ?>
</td>
		<!-- CORREO ELECTRONICO INTERVENTOR -->
		<td><b>Correo Electr&oacute;nico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoInterventor; ?>
</td>
	</tr>
	<tr><!-- TIPO DE PERSONA INTERVENTOR -->
		<td><b>Tipo de Persona</b></td>
		<td align="left" colspan="3">
		<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 1): ?> Natural <?php endif; ?>
		<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 0): ?> Jur&iacute;dica <?php endif; ?>
		</td>
	</tr>
	<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 1): ?>
		<tr><!-- CEDULA INTERVENTOR (Persona Natural) -->
			<td><b>C&eacute;dula</b></td>
			<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numCedulaInterventor; ?>
</td>
			<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
			<td><b>Tarjeta Profesional</b></td>
			<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTProfesionalInterventor; ?>
</td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 0): ?>
		<tr><!-- NIT INTERVENTOR (Persona Juridica)-->
			<td><b>NIT</b></td>
			<td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->numNitInterventor; ?>
</td>
		</tr>
	<?php endif; ?>
	<tr><!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Nombre Representante Legal</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreRepLegalInterventor; ?>
</td>
		<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Tel&eacute;fono</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoRepLegalInterventor; ?>
</td>
	</tr>
	<tr><!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Direcci&oacute;n</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionRepLegalInterventor; ?>
</td>
		<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Correo Electr&oacute;nico</b></td>
		<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoRepLegalInterventor; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">TUTOR DEL PROYECTO</td></tr>
	<tr><!-- TUTOR DEL PROYECTO -->
		<td><b>Nombre del Tutor</b></td>
		<td colspan="3">
			<?php $_from = $this->_tpl_vars['arrTutorProyecto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTutorProyecto'] => $this->_tpl_vars['txtTutorProyecto']):
?><?php if ($this->_tpl_vars['objFormularioProyecto']->seqTutorProyecto == $this->_tpl_vars['seqTutorProyecto']): ?> <?php echo $this->_tpl_vars['txtTutorProyecto']; ?>
 <?php endif; ?><?php endforeach; endif; unset($_from); ?>
		</td>
	</tr>
</table>