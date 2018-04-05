<!-- ESTADO DEL PROCESO -->
<table cellspacing="0" cellpadding="2" border="0" width="100%" height="25px">
	<tr bgcolor="#E4E4E4">
		<td width="140px"><b>Estado del proceso</b></td>
		<td width="280px">{foreach from=$arrEstadosProceso key=seqPryEstadoProceso item=txtPryEstadoProceso}{if $objFormularioProyecto->seqPryEstadoProceso == $seqPryEstadoProceso} {$txtPryEstadoProceso} {/if}{/foreach}</td>
		<td width="140px"><b>Fecha de Inscripci�n</b></td>
		<td>{$objFormularioProyecto->fchInscripcion}&nbsp;</td>
	</tr>
	<tr><td height="5px"></td></tr>
</table>

<table cellspacing="0" cellpadding="2" border="0" width="100%">

	<tr><td class="tituloTabla" colspan="4">DATOS DEL PROYECTO
	<img src="recursos/imagenes/blank.gif" onload="escondetxtDescEquipamientoComunal(); escondeLineaConstructor(); escondeCamposTipoPersona(); escondeLineaOpv();">
	<img src="recursos/imagenes/blank.gif" onload="escondeSeccionAprobacion(); muestraCondicionAprobacion();">
	</td></tr>
	<tr><!-- NOMBRE DEL PROYECTO -->
		<td><b>Nombre del Proyecto</b></td>
		<td>{$objFormularioProyecto->txtNombreProyecto}</td>
		<!-- PLAN PARCIAL -->
		<td><b>Nombre del Plan Parcial</b></td>
		<td>{if $arrPrivilegios.editar == 1}
				{assign var=soloLectura value=""}
			{else}
				{assign var=soloLectura value="readonly"}
			{/if}
			{if $objFormularioProyecto->txtNombrePlanParcial == ""}
				Ninguno
			{else}
				{$objFormularioProyecto->txtNombrePlanParcial}
			{/if}
		</td>
	</tr>
	<tr>
	<!-- NOMBRE COMERCIAL DEL PROYECTO -->
		<td><b>Nombre Comercial</b></td>
		<td colspan="3">{$objFormularioProyecto->txtNombreComercial}</td>
	</tr>
	<tr><!-- TIPO DE ESQUEMA -->
		<td width="25%"><b>Tipo de Esquema</b></td>
		<td width="25%">{foreach from=$arrTipoEsquema key=seqTipoEsquema item=txtTipoEsquema}{if $objFormularioProyecto->seqTipoEsquema == $seqTipoEsquema} {$txtTipoEsquema} {/if}{/foreach}</td>
		<!-- TIPO DE MODALIDAD -->
		<td width="25%"><b>Tipo de Modalidad</b></td>
		<td id="tdModalidad" width="25%">{foreach from=$arrPryTipoModalidad key=seqPryTipoModalidad item=txtPryTipoModalidad}{if $objFormularioProyecto->seqPryTipoModalidad == $seqPryTipoModalidad} {$txtPryTipoModalidad} {/if}{/foreach}</td>
	</tr>
	{if $objFormularioProyecto->seqTipoEsquema == "2"}
		<tr><!-- NOMBRE DE LA OPV (ESQUEMA: COLECTIVO OPV) -->
			<td><b>Nombre de la OPV</b></td>
			<td colspan="3" >{foreach from=$arrOpv key=seqOpv item=txtNombreOpv}{if $objFormularioProyecto->seqOpv == $seqOpv} {$txtNombreOpv} {/if}{/foreach}</td>
		</tr>
	{/if}
	{if $objFormularioProyecto->seqTipoEsquema == "4"}
		<tr><!-- OPERADOR (ESQUEMA: TERRITORIAL DIRIGIDA) -->
			<td><b>Nombre del Operador</b></td>
			<td colspan='3'>{$objFormularioProyecto->txtNombreOperador}</td>
		</tr>
	{/if}
	<tr><!-- TIPO DE PROYECTO -->
		<td><b>Tipo de Proyecto</b></td>
		<td>{foreach from=$arrTipoProyecto key=seqTipoProyecto item=txtTipoProyecto}{if $objFormularioProyecto->seqTipoProyecto == $seqTipoProyecto} {$txtTipoProyecto} {/if}{/foreach}</td>
		<!-- DESCRIPCION DEL PROYECTO -->
		<td rowspan="3" valign="top"><b>Descripci&oacute;n del Proyecto</b></td>
		<td rowspan="3" valign="top">{$objFormularioProyecto->txtDescripcionProyecto}</td>
	</tr>
	<tr><!-- TIPO DE URBANIZACION -->
		<td><b>Tipo de Urbanizaci&oacute;n</b></td>
		<td>{foreach from=$arrTipoUrbanizacion key=seqTipoUrbanizacion item=txtTipoUrbanizacion}{if $objFormularioProyecto->seqTipoUrbanizacion == $seqTipoUrbanizacion} {$txtTipoUrbanizacion} {/if}{/foreach}</td>
	</tr>
	<tr><!-- TIPO DE SOLUCION -->
		<td><b>Tipo de Soluci&oacute;n</b></td>
		<td>{foreach from=$arrTipoSolucion key=seqTipoSolucion item=txtTipoSolucion}{if $objFormularioProyecto->seqTipoSolucion == $seqTipoSolucion} {$txtTipoSolucion} {/if}{/foreach}</td>
	</tr>
	<tr><!-- LOCALIDAD DEL PROYECTO -->
		<td><b>Localidad</b></td>
		<td>{foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}{if $objFormularioProyecto->seqLocalidad == $seqLocalidad} {$txtLocalidad} {/if}{/foreach}</td>
		<!-- DIRECCION DEL PROYECTO -->
		<td><b>Direcci&oacute;n</b></td>
		<td>{$objFormularioProyecto->txtDireccion}</td>
	</tr>
	<tr><!-- BARRIO -->
		<td><b>Barrio</b></td>
		<td>{foreach from=$arrBarrio key=seqBarrio item=txtBarrio}{if $objFormularioProyecto->seqBarrio == $seqBarrio} {$txtBarrio} {/if}{/foreach}</td>
		<!-- TORRES -->
		<td><b>Torres</b></td>
		<td>{$objFormularioProyecto->valTorres}</td>
	</tr>
	<tr><!-- NUMERO DE SOLUCIONES -->
		<td><b>N&uacute;mero Soluciones</b></td>
		<td>{$objFormularioProyecto->valNumeroSoluciones}</td>
		<!-- AREA CONSTRUIDA -->
		<td><b>Area a construir</b></td>
		<td>{$objFormularioProyecto->valAreaConstruida}&nbsp;m�</td>
	</tr>
	<tr><!-- AREA LOTE -->
		<td><b>Area Lote</b></td>
		<td>{$objFormularioProyecto->valAreaLote}&nbsp;m�</td>
		<td colspan="2"></td>
	</tr>

	<tr><!-- COSTO DEL PROYECTO -->
		<td><b>Costo estimado del Proyecto</b></td>
		<td>$ {$objFormularioProyecto->valCostoProyecto}</td>
		<!-- VALOR CIERRE FINANCIERO -->
			<td><b>Valor Cierre Financiero</b></td>
			<td>$ {$objFormularioProyecto->valCierreFinanciero}</td>
	</tr>
	<tr><!-- CHIP DEL PROYECTO -->
		<td><b>Chip Lote</b></td>
		<td>{$objFormularioProyecto->txtChipLote}</td>
		<!-- MATRICULA INMOBILIARIA DEL PROYECTO -->
		<td><b>Matr&iacute;cula Inmobiliaria Lote</b></td>
		<td>{$objFormularioProyecto->txtMatriculaInmobiliariaLote}</td>
	</tr>
	<tr><!-- REGISTRO DE ENAJENACION -->
		<td><b>Registro de Enajenaci�n</b></td>
		<td align="left">{$objFormularioProyecto->txtRegistroEnajenacion}</td>
		<!-- FECHA REGISTRO DE ENAJENACION -->
		<td><b>Fecha Registro de Enajenaci�n</b></td>
		<td>{$objFormularioProyecto->fchRegistroEnajenacion}</td>
	<tr><!-- EQUIPAMIENTO COMUNAL -->
		<td valign="top"><b>Tiene Equipamiento Comunal?</b></td>
		<td valign="top" align="left">
			{if $objFormularioProyecto->bolEquipamientoComunal == 1} Si {/if} 
			{if $objFormularioProyecto->bolEquipamientoComunal == 0} No {/if} 
		</td>
		{if $objFormularioProyecto->bolEquipamientoComunal == 1}
			<!-- DESCRIPCION DE EQUIPAMIENTO COMUNAL -->
			<td valign="top"><b>Descripci&oacute;n Equipamiento Comunal</b></td>
			<td>{$objFormularioProyecto->txtDescEquipamientoComunal}</td>
		{/if}
	</tr>

	<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
		<tr><!-- VALOR COSTOS DIRECTOS -->
			<td><b>Valor Costos Directos</b></td>
			<td>$ {$objFormularioProyecto->valCostosDirectos}</td>
			<!-- VALOR COSTOS INDIRECTOS -->
			<td><b>Valor Costos Indirectos</b></td>
			<td>$ {$objFormularioProyecto->valCostosIndirectos}</td>
		</tr>
		<tr><!-- VALOR TERRENO -->
			<td><b>Valor Terreno</b></td>
			<td>$ {$objFormularioProyecto->valTerreno}</td>
			<!-- VALOR TOTAL PROYECTO VIP -->
			<td><b>Valor Total Proyecto VIP</b></td>
			<td>$ {$objFormularioProyecto->valTotalCostos}</td>
		</tr>

	<tr><td class="tituloTabla" colspan="4">LICENCIA DE URBANISMO</td></tr>
	<tr><!-- LICENCIA DE URBANISMO -->
		<td><b>N&uacute;mero de Licencia</b></td>
		<td>{$objFormularioProyecto->txtLicenciaUrbanismo}</td>
		<!-- EXPIDE LICENCIA DE URBANISMO -->
		<td><b>Expide</b></td>
		<td>{$objFormularioProyecto->txtExpideLicenciaUrbanismo}</td>
	</tr>

	<tr><!-- FECHA DE LICENCIA DE URBANISMO -->
		<td><b>Fecha de Licencia</b></td>
		<td>{$objFormularioProyecto->fchLicenciaUrbanismo1}</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td><b>Vigencia de Licencia</b></td>
		<td>{$objFormularioProyecto->fchVigenciaLicenciaUrbanismo}</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE URBANISMO (PRIMERA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 1</b></td>
		<td>{$objFormularioProyecto->fchLicenciaUrbanismo2}</td>
		<!-- FECHA DE LICENCIA DE URBANISMO (SEGUNDA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 2</b></td>
		<td>{$objFormularioProyecto->fchLicenciaUrbanismo3}</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE URBANISMO -->
		<td><b>Fecha Ejecutoria</b></td>
		<td>{$objFormularioProyecto->fchEjecutoriaLicenciaUrbanismo}</td>
		<!-- VIGENCIA DE LICENCIA DE URBANISMO -->
		<td><b>Resoluci&oacute;n Ejecutoria</b></td>
		<td>{$objFormularioProyecto->txtResEjecutoriaLicenciaUrbanismo}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">LICENCIA DE CONSTRUCCION</td></tr>
	<tr><!-- LICENCIA DE CONSTRUCCION -->
		<td><b>N&uacute;mero de Licencia</b></td>
		<td colspan="2">{$objFormularioProyecto->txtLicenciaConstruccion}</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE CONSTRUCCION -->
		<td><b>Fecha de Licencia</b></td>
		<td>{$objFormularioProyecto->fchLicenciaConstruccion1}</td>
		<!-- VIGENCIA DE LICENCIA DE CONSTRUCCION -->
		<td><b>Vigencia de Licencia</b></td>
		<td>{$objFormularioProyecto->fchVigenciaLicenciaConstruccion}</td>
	</tr>
	<tr><!-- FECHA DE LICENCIA DE CONSTRUCCION (PRIMERA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 1</b></td>
		<td>{$objFormularioProyecto->fchLicenciaConstruccion2}</td>
		<!-- FECHA DE LICENCIA DE COSNTRUCCION (SEGUNDA AMPLIACION)-->
		<td><b>Fecha Pr&oacute;rroga 2</b></td>
		<td>{$objFormularioProyecto->fchLicenciaConstruccion3}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">ESCRITURACION</td></tr>
	<tr>
		<!-- NOMBRE DEL VENDEDOR -->
		<td>Nombre del vendedor</td>
		<td>{$objFormularioProyecto->txtNombreVendedor}</td>
		<!-- NIT VENDEDOR -->
		<td>NIT</td>
		<td>{$objFormularioProyecto->numNitVendedor}</td>
	</tr>

	<tr>
		<!-- CEDULA CATASTRAL -->
		<td>C&eacute;dula Catastral</td>
		<td colspan="3">{$objFormularioProyecto->txtCedulaCatastral}</td>
	</tr>

	<tr>
		<!-- NUMERO Y FECHA ESCRITURA -->
		<td>No. Escritura</td>
		<td>{$objFormularioProyecto->txtEscritura} del {$objFormularioProyecto->fchEscritura}</td>
		<!-- NUMERO NOTARIA -->
		<td>No. Notar&iacute;a</td>
		<td>{$objFormularioProyecto->numNotaria}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
	<tr><!-- NOMBRE INTERVENTOR -->
		<td><b>Nombre</b></td>
		<td>{$objFormularioProyecto->txtNombreInterventor}</td>
		<!-- TELEFONO INTERVENTOR -->
		<td><b>Tel&eacute;fono</b></td>
		<td>{$objFormularioProyecto->numTelefonoInterventor}</td>
	</tr>
	<tr><!-- DIRECCION INTERVENTOR -->
		<td><b>Direcci&oacute;n</b></td>
		<td>{$objFormularioProyecto->txtDireccionInterventor}</td>
		<!-- CORREO ELECTRONICO INTERVENTOR -->
		<td><b>Correo Electr&oacute;nico</b></td>
		<td>{$objFormularioProyecto->txtCorreoInterventor}</td>
	</tr>
	<tr><!-- TIPO DE PERSONA INTERVENTOR -->
		<td><b>Tipo de Persona</b></td>
		<td align="left" colspan="3">
		{if $objFormularioProyecto->bolTipoPersonaInterventor == 1} Natural {/if}
		{if $objFormularioProyecto->bolTipoPersonaInterventor == 0} Jur&iacute;dica {/if}
		</td>
	</tr>
	{if $objFormularioProyecto->bolTipoPersonaInterventor == 1}
		<tr><!-- CEDULA INTERVENTOR (Persona Natural) -->
			<td><b>C&eacute;dula</b></td>
			<td>{$objFormularioProyecto->numCedulaInterventor}</td>
			<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
			<td><b>Tarjeta Profesional</b></td>
			<td>{$objFormularioProyecto->numTProfesionalInterventor}</td>
		</tr>
	{/if}
	{if $objFormularioProyecto->bolTipoPersonaInterventor == 0}
		<tr><!-- NIT INTERVENTOR (Persona Juridica)-->
			<td><b>NIT</b></td>
			<td colspan="3">{$objFormularioProyecto->numNitInterventor}</td>
		</tr>
	{/if}
	<tr><!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Nombre Representante Legal</b></td>
		<td>{$objFormularioProyecto->txtNombreRepLegalInterventor}</td>
		<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Tel&eacute;fono</b></td>
		<td>{$objFormularioProyecto->numTelefonoRepLegalInterventor}</td>
	</tr>
	<tr><!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Direcci&oacute;n</b></td>
		<td>{$objFormularioProyecto->txtDireccionRepLegalInterventor}</td>
		<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
		<td><b>Correo Electr&oacute;nico</b></td>
		<td>{$objFormularioProyecto->txtCorreoRepLegalInterventor}</td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">TUTOR DEL PROYECTO</td></tr>
	<tr><!-- TUTOR DEL PROYECTO -->
		<td><b>Nombre del Tutor</b></td>
		<td colspan="3">
			{foreach from=$arrTutorProyecto key=seqTutorProyecto item=txtTutorProyecto}{if $objFormularioProyecto->seqTutorProyecto == $seqTutorProyecto} {$txtTutorProyecto} {/if}{/foreach}
		</td>
	</tr>
</table>