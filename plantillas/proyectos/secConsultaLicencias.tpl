<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr><td class="tituloTabla" colspan="4">DATOS PROYECTO</td></tr>
	<tr><!-- NOMBRE DEL PROYECTO -->
		<td>Nombre del Proyecto</td>
		<td colspan="3">{$objFormularioProyecto->txtNombreProyecto}</td>
	</tr>
	<tr><!-- NOMBRE DEL OFERENTE -->
		<td width="25%">Oferente</td>
		<td width="25%">{$objFormularioProyecto->txtNombreOferente}</td>
		<!-- NUMERO DE SOLUCIONES -->
		<td width="25%">N&uacute;mero de Soluciones</td>
		<td width="25%">{$objFormularioProyecto->valNumeroSoluciones}</td>
	</tr>
	<tr><!-- COSTO TOTAL PROYECTO -->
		<td>Costo Total Proyecto</td>
		<td>{$objFormularioProyecto->valTotalCostos}</td>
		<!-- VALOR SDVE -->
		<td>Valor SDVE</td>
		<td>{$objFormularioProyecto->valSDVE}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS LICENCIA DE CONSTRUCCION</td></tr>		
	<tr><!-- LICENCIA DE CONSTRUCCION -->
		<td valign="top">No. Licencia de Construcci&oacute;n</td>
		<td>{$objFormularioProyecto->txtLicenciaConstruccion}</td>
		<!-- OBSERVACIONES LICENCIA DE CONSTRUCCION -->
		<td valign="top">Observaciones</td>
		<td>{$objFormularioProyecto->txtObsLicConstruccion}</td>
	</tr>
	<tr><!-- FECHA EJECUTORIA -->
		<td valign="top">Fecha Ejecutoria</td>
		<td valign="top">{$objFormularioProyecto->fchEjecutaLicConstruccion}</td>
		<!-- FECHA VENCIMIENTO -->
		<td valign="top">Fecha Vencimiento</td>
		<td valign="top">{$objFormularioProyecto->fchVenceLicConstruccion}</td>
	</tr>
	<tr><!-- NO. DE RESOLUCION DE PRORROGA -->
		<td valign="top">No. De Resoluci&oacute;n Pr&oacute;rroga</td>
		<td valign="top">{$objFormularioProyecto->numResolProrrogaLicConstruccion}</td>
		<td valign="top">Observaciones</td>
		<td valign="top">{$objFormularioProyecto->txtObsNumResolProrrogaLicConstruccion}</td>
	</tr>
	<tr><!-- FECHA EJECUTORIA PRORROGA -->
		<td valign="top">Fecha Ejecutoria Pr&oacute;rroga</td>
		<td valign="top">{$objFormularioProyecto->fchEjecutaProrrogaLicConstruccion}</td>
		<!-- FECHA DE VENCIMIENTO PRORROGA -->
		<td valign="top">Fecha de Vencimiento Pr&oacute;rroga</td>
		<td valign="top">{$objFormularioProyecto->fchVenceProrrogaLicConstruccion}</td>
	</tr>
	<tr><!-- NO DE RESOLUCION DE REVALIDACION -->
		<td valign="top">No. De Resoluci&oacute;n de Revalidaci&oacute;n</td>
		<td valign="top">{$objFormularioProyecto->numResolRevalidacionLicConstruccion}</td>
		<td valign="top">Observaciones</td>
		<td valign="top">{$objFormularioProyecto->txtObsNumResolRevalidacionLicConstruccion}</td>
	</tr>
	<tr><!-- FECHA EJECUTORIA REVALIDACION -->
		<td valign="top">Fecha Ejecutoria Revalidaci&oacute;n</td>
		<td valign="top">{$objFormularioProyecto->fchEjecutaRevalidacionLicConstruccion}</td>
		<!-- FECHA DE VENCIMIENTO REVALIDACION -->
		<td valign="top">Fecha Vencimiento Revalidaci&oacute;n</td>
		<td valign="top">{$objFormularioProyecto->fchVenceRevalidacionLicConstruccion}</td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">CRONOGRAMA FECHAS</td></tr>
	<tr><!-- PLAZO DE EJECUCION -->
		<td valign="top">Plazo de Ejecuci&oacute;n </td>
		<td valign="top" colspan="3">{$arrUltimoCronogramaFechas.valPlazoEjecucion}</td>
	</tr>
	<tr><!-- FECHA INICIO OBRA -->
		<td valign="top">Fecha Inicio Obra</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchInicialProyecto}</td>
		<!-- FECHA TERMINACION OBRA -->
		<td valign="top">Fecha Terminaci&oacute;n Obra</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchFinalProyecto}</td>
	</tr>
	<tr><!-- FECHA INICIO VENTAS -->
		<td valign="top">Fecha Inicio Ventas</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchInicialEntrega}</td>
		<!-- FECHA DE FIN VENTAS -->
		<td valign="top">Fecha Fin Ventas</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchFinalEntrega}</td>
	</tr>
	<tr><!-- FECHA INICIO ENTREGA Y ESCRITURACION -->
		<td valign="top">Fecha Inicio Entrega y Escrituraci&oacute;n</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchInicialEscrituracion}</td>
		<!-- FECHA FIN ENTREGA Y ESCRITURACION   -->
		<td valign="top">Fecha Fin Entrega y Escrituraci&oacute;n</td>
		<td valign="top">{$arrUltimoCronogramaFechas.fchFinalEscrituracion}</td>
	</tr>
</table>