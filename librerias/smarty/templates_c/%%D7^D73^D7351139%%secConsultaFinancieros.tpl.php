<?php /* Smarty version 2.6.26, created on 2017-05-05 04:33:38
         compiled from proyectos/secConsultaFinancieros.tpl */ ?>
<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
	<tr><!-- NOMBRE INTERVENTOR -->
		<td>Nombre</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreInterventor; ?>
</td>
		<!-- TELEFONO INTERVENTOR -->
		<td>Tel&eacute;fono</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoInterventor; ?>
</td>
	</tr>

	<tr>
		<!-- DIRECCION INTERVENTOR -->
		<td>Direcci&oacute;n</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionInterventor; ?>
</td>
		<!-- CORREO ELECTRONICO INTERVENTOR -->
		<td>Correo electr&oacute;nico</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoInterventor; ?>
</td>
	</tr>

	<tr>
		<!-- TIPO DE PERSONA INTERVENTOR -->
		<td>Tipo de Persona</td>
		<td align="left" colspan="3">
			<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 1): ?>
				Natural
			<?php else: ?>
				Jur&iacute;dica
			<?php endif; ?>
		</td>
	</tr>
	<?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 1): ?>
		<tr>
			<!-- CEDULA INTERVENTOR (Persona Natural) -->
			<td>C&eacute;dula</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->numCedulaInterventor; ?>
</td>
			<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
			<td>Tarjeta Profesional</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTProfesionalInterventor; ?>
</td>
		</tr>
	<?php else: ?>
		<tr>
			<!-- NIT INTERVENTOR -->
			<td>NIT</td><td colspan="3"><?php echo $this->_tpl_vars['objFormularioProyecto']->numNitInterventor; ?>
</td>
		</tr>
		<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
		<tr>
			<!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Nombre Representante Legal</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreRepLegalInterventor; ?>
</td>
			<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Tel&eacute;fono</td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoRepLegalInterventor; ?>
</td>
		</tr>
		<tr>
			<!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Direcci&oacute;n</a></td><td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionRepLegalInterventor; ?>
</td>
			<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Correo electr&oacute;nico</td>
			<td><?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoRepLegalInterventor; ?>
</td>
		</tr>
	<?php endif; ?>

	<tr><td class="tituloTabla" colspan="4">VENTAS DEL PROYECTO</td></tr>
	<tr><td colspan="2"><img src="recursos/imagenes/blank.gif" onload="calculaUtilidad(); escondeCamposTipoPersona();"></td>
		<!-- VALOR VENTAS -->
		<td><b>INGRESO VENTAS PROYECTADO</b></td>
		<td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalVentas; ?>
</td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
	<tr><!-- COSTOS DIRECTOS -->
		<td width="30%">Costos Directos</td><td width="20%">$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosDirectos; ?>
</td>
		<!-- COSTOS INDIRECTOS -->
		<td width="30%">Costos Indirectos</td><td width="20%">$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosIndirectos; ?>
</td>
	</tr>

	<tr><!-- TERRENO -->
		<td>Terreno</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTerreno; ?>
</td>
		<!-- GASTOS FINANCIEROS -->
		<td>Gastos Financieros</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valGastosFinancieros; ?>
</td>
	</tr>

	<tr><!-- GASTOS DE VENTAS -->
		<td>Gastos de Ventas</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valGastosVentas; ?>
</td>
		<!-- TOTAL COSTO (COSTOS DIRECTOS + COSTOS INDIRECTOS + TERRENO + GASTOS FINANCIEROS + GASTOS VENTAS)-->
		<td><b>COSTO TOTAL DEL PROYECTO</b></td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalCostos; ?>
</td>
	</tr>
	
	<tr><td class="tituloTabla" colspan="4">UTILIDAD DEL PROYECTO</td></tr>
	<tr><td colspan="2"></td>
		<!-- VALOR UTILIDADES -->
		<td><b>TOTAL UTILIDAD</b></td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valUtilidadProyecto; ?>
</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">FUENTES DE FINANCIACI&Oacute;N</td></tr>
	<tr><!-- RECURSOS PROPIOS -->
		<td>Recursos Propios</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valRecursosPropios; ?>
</td>
		<!-- CREDITO ENTIDAD FINANCIERA -->
		<td>Cr&eacute;dito Entidad Financiera</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCreditoEntidadFinanciera; ?>
</td>
	</tr>

	<tr><!-- CREDITO PARTICULARES -->
		<td>Cr&eacute;dito Particulares</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valCreditoParticulares; ?>
</td>
		<!-- VENTAS DEL PROYECTO -->
		<td>Ventas del Proyecto</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valVentasProyecto; ?>
</td>
	</tr>

	<tr><!-- SDVE -->
		<td>SDVE</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valSDVE; ?>
</td>
		<!-- OTROS -->
		<td>Otros</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valOtros; ?>
</td>
	</tr>

	<tr><!-- DEVOLUCION DE IVA -->
		<td>Devoluci&oacute;n de IVA</td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valDevolucionIVA; ?>
</td>
		<!-- TOTAL RECURSOS -->
		<td><b>TOTAL RECURSOS</b></td><td>$ <?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalRecursos; ?>
</td>
	</tr>
</table>