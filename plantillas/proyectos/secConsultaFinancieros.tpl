<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
	<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
	<tr><!-- NOMBRE INTERVENTOR -->
		<td>Nombre</td><td>{$objFormularioProyecto->txtNombreInterventor}</td>
		<!-- TELEFONO INTERVENTOR -->
		<td>Tel&eacute;fono</td><td>{$objFormularioProyecto->numTelefonoInterventor}</td>
	</tr>

	<tr>
		<!-- DIRECCION INTERVENTOR -->
		<td>Direcci&oacute;n</td><td>{$objFormularioProyecto->txtDireccionInterventor}</td>
		<!-- CORREO ELECTRONICO INTERVENTOR -->
		<td>Correo electr&oacute;nico</td><td>{$objFormularioProyecto->txtCorreoInterventor}</td>
	</tr>

	<tr>
		<!-- TIPO DE PERSONA INTERVENTOR -->
		<td>Tipo de Persona</td>
		<td align="left" colspan="3">
			{if $objFormularioProyecto->bolTipoPersonaInterventor == 1}
				Natural
			{else}
				Jur&iacute;dica
			{/if}
		</td>
	</tr>
	{if $objFormularioProyecto->bolTipoPersonaInterventor == 1}
		<tr>
			<!-- CEDULA INTERVENTOR (Persona Natural) -->
			<td>C&eacute;dula</td><td>{$objFormularioProyecto->numCedulaInterventor}</td>
			<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
			<td>Tarjeta Profesional</td><td>{$objFormularioProyecto->numTProfesionalInterventor}</td>
		</tr>
	{else}
		<tr>
			<!-- NIT INTERVENTOR -->
			<td>NIT</td><td colspan="3">{$objFormularioProyecto->numNitInterventor}</td>
		</tr>
		<tr><td class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
		<tr>
			<!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Nombre Representante Legal</td><td>{$objFormularioProyecto->txtNombreRepLegalInterventor}</td>
			<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Tel&eacute;fono</td><td>{$objFormularioProyecto->numTelefonoRepLegalInterventor}</td>
		</tr>
		<tr>
			<!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Direcci&oacute;n</a></td><td>{$objFormularioProyecto->txtDireccionRepLegalInterventor}</td>
			<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
			<td>Correo electr&oacute;nico</td>
			<td>{$objFormularioProyecto->txtCorreoRepLegalInterventor}</td>
		</tr>
	{/if}

	<tr><td class="tituloTabla" colspan="4">VENTAS DEL PROYECTO</td></tr>
	<tr><td colspan="2"><img src="recursos/imagenes/blank.gif" onload="calculaUtilidad(); escondeCamposTipoPersona();"></td>
		<!-- VALOR VENTAS -->
		<td><b>INGRESO VENTAS PROYECTADO</b></td>
		<td>$ {$objFormularioProyecto->valTotalVentas}</td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
	<tr><!-- COSTOS DIRECTOS -->
		<td width="30%">Costos Directos</td><td width="20%">$ {$objFormularioProyecto->valCostosDirectos}</td>
		<!-- COSTOS INDIRECTOS -->
		<td width="30%">Costos Indirectos</td><td width="20%">$ {$objFormularioProyecto->valCostosIndirectos}</td>
	</tr>

	<tr><!-- TERRENO -->
		<td>Terreno</td><td>$ {$objFormularioProyecto->valTerreno}</td>
		<!-- GASTOS FINANCIEROS -->
		<td>Gastos Financieros</td><td>$ {$objFormularioProyecto->valGastosFinancieros}</td>
	</tr>

	<tr><!-- GASTOS DE VENTAS -->
		<td>Gastos de Ventas</td><td>$ {$objFormularioProyecto->valGastosVentas}</td>
		<!-- TOTAL COSTO (COSTOS DIRECTOS + COSTOS INDIRECTOS + TERRENO + GASTOS FINANCIEROS + GASTOS VENTAS)-->
		<td><b>COSTO TOTAL DEL PROYECTO</b></td><td>$ {$objFormularioProyecto->valTotalCostos}</td>
	</tr>
	
	<tr><td class="tituloTabla" colspan="4">UTILIDAD DEL PROYECTO</td></tr>
	<tr><td colspan="2"></td>
		<!-- VALOR UTILIDADES -->
		<td><b>TOTAL UTILIDAD</b></td><td>$ {$objFormularioProyecto->valUtilidadProyecto}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">FUENTES DE FINANCIACI&Oacute;N</td></tr>
	<tr><!-- RECURSOS PROPIOS -->
		<td>Recursos Propios</td><td>$ {$objFormularioProyecto->valRecursosPropios}</td>
		<!-- CREDITO ENTIDAD FINANCIERA -->
		<td>Cr&eacute;dito Entidad Financiera</td><td>$ {$objFormularioProyecto->valCreditoEntidadFinanciera}</td>
	</tr>

	<tr><!-- CREDITO PARTICULARES -->
		<td>Cr&eacute;dito Particulares</td><td>$ {$objFormularioProyecto->valCreditoParticulares}</td>
		<!-- VENTAS DEL PROYECTO -->
		<td>Ventas del Proyecto</td><td>$ {$objFormularioProyecto->valVentasProyecto}</td>
	</tr>

	<tr><!-- SDVE -->
		<td>SDVE</td><td>$ {$objFormularioProyecto->valSDVE}</td>
		<!-- OTROS -->
		<td>Otros</td><td>$ {$objFormularioProyecto->valOtros}</td>
	</tr>

	<tr><!-- DEVOLUCION DE IVA -->
		<td>Devoluci&oacute;n de IVA</td><td>$ {$objFormularioProyecto->valDevolucionIVA}</td>
		<!-- TOTAL RECURSOS -->
		<td><b>TOTAL RECURSOS</b></td><td>$ {$objFormularioProyecto->valTotalRecursos}</td>
	</tr>
</table>