
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="SIPIVE">
		<meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
		<meta name="description" content="Programa Integral de Vivienda Efectiva">
		<meta name="robots" content="index,  nofollow" />
		<title>Formulario de Postulacion</title>
	</head>
	<body onLoad="window.print();">
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
			<tr>
				<td width="150px" height="90px" align="center" valign="middle"><img src="../../recursos/imagenes/escudo.png"></td>
				<td align="center" valign="middle" style="padding:10px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 12px; ">
					<b>ALCALDIA MAYOR DE BOGOTA</b><br>
					SECRETARIA DEL HABITAT<br>
					PROGRAMA INTEGRAL DE VIVIENDA EFECTIVA (PIVE)<br>
					FORMULARIO DE POSTULACIÓN<hr>
					<span style="font-size: 9px;">Fecha de Radicaci&oacute;n: {$fchImpresion}</span>
				</td>
				<td width="150px" align="center" valign="middle"><img src="../../recursos/imagenes/bta_positiva_carta.jpg"></td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tr>
				<td bgcolor="#E4E4E4" style="padding-left:10px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
					<b>No.Formulario:</b> {$objFormulario->txtFormulario}
				</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
			<tr><td bgcolor="#CECECE" style="padding-left:10px;" align="center"><b>DATOS DE LOS MIEMBROS DEL HOGAR</b></td></tr>
			{foreach from=$objFormulario->arrCiudadano item=objCiudadano}
				
				{assign var=seqTipoDocumento value=$objCiudadano->seqTipoDocumento}
				{assign var=seqParentesco value=$objCiudadano->seqParentesco}
				{assign var=seqCondicionEspecial1 value=$objCiudadano->seqCondicionEspecial}
				{assign var=seqCondicionEspecial2 value=$objCiudadano->seqCondicionEspecial2}
				{assign var=seqCondicionEspecial3 value=$objCiudadano->seqCondicionEspecial3}
				{assign var=seqSexo value=$objCiudadano->seqSexo}
				{assign var=seqEstadoCivil value=$objCiudadano->seqEstadoCivil}
				{assign var=seqOcupacion value=$objCiudadano->seqOcupacion}
				{assign var=seqNivelEducativo value=$objCiudadano->seqNivelEducativo}
				{assign var=seqEtnia value=$objCiudadano->seqEtnia}
				{assign var=seqCajaCompensacion value=$objCiudadano->seqCajaCompensacion}
				{assign var=seqSalud value=$objCiudadano->seqSalud}
				{assign var=seqTipoVictima value=$objCiudadano->seqTipoVictima}
				{assign var=seqEtnia value=$objCiudadano->seqEtnia}
				{assign var=seqGrupoLgtbi value=$objCiudadano->seqGrupoLgtbi}

				<tr>
					<td bgcolor="#E4E4E4">
						<b>{$objCiudadano->txtNombre1} {$objCiudadano->txtNombre2} 
						{$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}</b>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 8px; border-bottom: 1px solid #999999;">
							<tr>
								<td><b>Documento:</b> {$arrTipoDocumento.$seqTipoDocumento} {$objCiudadano->numDocumento|number_format:0:',':'.'}</td>
								<td><b>Fecha de Nacimiento:</b> {$objCiudadano->fchNacimiento}</td>
								<td><b>Parentesco:</b> {$arrParentesco.$seqParentesco}</td>
							</tr>
							<tr>
								<td><b>Estado Civil:</b> {$arrEstadoCivil.$seqEstadoCivil}</td>
								<td><b>Sexo:</b> {$arrSexo.$seqSexo}</td>
								<td><b>LGTBI:</b> {if $objCiudadano->bolLgtb == 1} Si {else} No {/if}</td>
							</tr>
							<tr>
								<td><b>Grupo LGTBI:</b>{$arrGrupoLgtbi.$seqGrupoLgtbi}</td>
								<td><b>Tipo de Victima:</b> {$arrTipoVictima.$seqTipoVictima}</td>
								<td><b>Condición Etnica:</b> {$arrCondicionEtnica.$seqEtnia}</td>
							</tr>
							<tr>
								<td><b>Condici&oacute;n Especial 1:</b> {$arrCondicionEspecial.$seqCondicionEspecial1}</td>
								<td><b>Condici&oacute;n Especial 2:</b> {$arrCondicionEspecial.$seqCondicionEspecial2}</td>
								<td><b>Condici&oacute;n Especial 3:</b> {$arrCondicionEspecial.$seqCondicionEspecial3}</td>
							</tr>
							<tr>
								<td><b>Ocupaci&oacute;n:</b> {$arrOcupacion.$seqOcupacion}</td>
								<td><b>Nivel Educativo:</b> {$arrNivelEducativo.$seqNivelEducativo}</td>
								<td><b>Años aprobados:</b> {$objCiudadano->numAnosAprobados}</td>

							</tr>
							<tr>
								<td><b>Salud:</b> {$arrSalud.$seqSalud}</td>
								<td><b>Beneficiario:</b> {if $objCiudadano->bolBeneficiario == 1} Si {else} No {/if}</td>
							</tr>
							<tr>
								<td><b>Ingresos:</b> $ {$objCiudadano->valIngresos|number_format:0:',':'.'}</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			{/foreach}


		</table>

        {assign var=seqCiudad value=$objFormulario->seqCiudad}
        {assign var=seqSisben value=$objFormulario->seqSisben}
        {assign var=seqBarrio value=$objFormulario->seqBarrio}
        {assign var=seqLocalidad value=$objFormulario->seqLocalidad}
        {assign var=seqVivienda value=$objFormulario->seqVivienda}
        {assign var=seqModalidad value=$objFormulario->seqModalidad}
        {assign var=seqSolucion value=$objFormulario->seqSolucion}
        {assign var=seqProyecto value=$objFormulario->seqProyecto}
        {assign var=seqBancoCuentaAhorro value=$objFormulario->seqBancoCuentaAhorro}
        {assign var=seqBancoCuentaAhorro2 value=$objFormulario->seqBancoCuentaAhorro2}
        {assign var=seqBancoCredito value=$objFormulario->seqBancoCredito}
        {assign var=seqEntidadDonante value=$objFormulario->seqEmpresaDonante}
        {assign var=seqTipoEsquema value=$objFormulario->seqTipoEsquema}
        {assign var=seqBancoLeasing value=$objFormulario->seqBancoLeasing}

		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
			<tr><td bgcolor="#CECECE" style="padding-left:10px;" align="center"><b>DATOS DEL HOGAR</b></td></tr>
			<tr>
				<td bgcolor="#E4E4E4">
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 8px;">
						<tr>
							<td width="44%"><b>Total Ingresos del Hogar:</b> $ {$objFormulario->valIngresoHogar|number_format:0:',':'.'}</td>
							<td width="30%"><strong>Condición del hogar: </strong>
                                {if $objFormulario->bolDesplazado == 1}
									Victima
                                {else}
									Vulnerable
                                {/if}
							</td>
							<td><b>Sisben:</b> {$arrSisben.$seqSisben}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 8px;">
			<tr>
				<td><b>Ciudad:</b> {$arrCiudad.$seqCiudad}</td>
				<td><b>Dirección:</b> {$objFormulario->txtDireccion|strtoupper}</td>
				<td><b>Localidad:</b> {$arrLocalidad.$seqLocalidad|strtoupper}</td>
			</tr>
			<tr>
				<td><b>Barrio:</b> {$arrBarrio.$seqBarrio}</td>
				<td><b>Vivienda actual:</b> {$arrVivienda.$seqVivienda|strtoupper}</td>
				<td><b>Valor del Arriendo (Si Aplica):</b> $ {$objFormulario->valArriendo|number_format:0:',':'.'}</td>
			</tr>
			<tr>
				<td><b>Para arriendo desde:</b> {$objFormulario->fchArriendoDesde}</td>
				<td><b>Comprobante arriendo:</b> {$objFormulario->txtComprobanteArriendo}</td>
				<td><b>Correo Elect&oacute;nico:</b> {$objFormulario->txtCorreo}</td>
			</tr>
			<tr>
				<td><b>Tel&eacute;fono fijo:</b> {$objFormulario->numTelefono1}</td>
				<td><b>Teléfono fijo:</b> {$objFormulario->numTelefono2}</td>
				<td><b>Tel&eacute;fonos celular:</b> {$objFormulario->numCelular}</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
			<tr><td bgcolor="#CECECE" colspan="3" style="padding-left:10px;" align="center"><b>MODALIDAD Y LOCALIZACION DE LA SOLUCION A LA QUE SE ASPIRA</b></td></tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 8px;">	
			<tr>
				<td><b>Modalidad:</b> {$arrModalidad.$seqModalidad}</td>
				<td><b>Esquema:</b> {$arrTipoEsquema.$seqTipoEsquema}</td>
				<td><b>Soluci&oacute;n</b> {$arrSolucion.$seqModalidad.$seqSolucion}</td>
			</tr>
			<tr>
                {if $objFormulario->seqPlanGobierno == 2}
					<td><b>Valor Subsidio:</b> $ {$objFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
                {else}
					<td><b>Valor Estimado Aporte:</b> $ {$objFormulario->valAspiraSubsidio|number_format:0:',':'.'}</td>
                {/if}
				<td><b>Direcci&oacute;n de Soluci&oacute;n:</b> {$objFormulario->txtDireccionSolucion|strtoupper}</td>
				<td><b>Matr&iacute;cula Inmobilliaria:</b> {$objFormulario->txtMatriculaInmobiliaria|strtoupper}</td>
			</tr>
			<tr>
				<td><b>CHIP:</b> {$objFormulario->txtChip|strtoupper}</td>
				<td><b>Proyecto:</b> {$arrProyecto.$seqProyecto|strtoupper}</td>
				<td><b>Conjunto Residencial:</b> {$nombreConjuntoResidencial|strtoupper}</td>

			</tr>
			<tr>
				<td><b>Unidad Proyecto:</b> {if $nombreUnidadProyecto != 'NINGUNA'}{$nombreUnidadProyecto|strtoupper}{else}&nbsp;{/if}</td>
				<td><b>Tiene Separación / Promesa de compra-venta:</b> {if $objFormulario->bolPromesaFirmada == 1} Si {else} No {/if}</td>
				<td><b>Tiene Idetificada una soluci&oacute;n:</b> {if $objFormulario->bolIdentificada == 1} Si {else} No {/if}</td>

			</tr>
			<tr>
				<td><b>Plan de Vivienda Viabilizada:</b> {if $objFormulario->bolViabilizada == 1} Si {else} No {/if}</td>
				<td><b>Presupuesto:</b> $ {$objFormulario->valPresupuesto|number_format:0:',':'.'}</td>
				<td><b>Aval&uacute;o:</b> $ {$objFormulario->valAvaluo|number_format:0:',':'.'}</td>
			</tr>
			<tr>
				<td><b>Total:</b> $ {$objFormulario->valTotal|number_format:0:',':'.'}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
			<tr><td bgcolor="#CECECE" colspan="3" style="padding-left:10px;" align="center"><b>DATOS FINANCIEROS</b></td></tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 8px;">		
			<tr>
				<td><b>Ahorro 1:</b> {$arrBanco.$seqBancoCuentaAhorro}</td>
				<td><b>Valor:</b> $ {$objFormulario->valSaldoCuentaAhorro|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteCuentaAhorro|strtoupper}</td>
				<td><b>Fecha Apertura:</b> {$objFormulario->fchAperturaCuentaAhorro}</td>
				<td><b>Valor Inmobilizado:</b> {if $objFormulario->bolInmovilizadoCuentaAhorro == 1} Si {else} No {/if}</td>
			</tr>
			<tr>
				<td><b>Ahorro 2:</b> {$arrBanco.$seqBancoCuentaAhorro2}</td>
				<td><b>Valor:</b> $ {$objFormulario->valSaldoCuentaAhorro2|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteCuentaAhorro2|strtoupper}</td>
				<td><b>Fecha Apertura:</b> {$objFormulario->fchAperturaCuentaAhorro2}</td>
				<td><b>Valor Inmobilizado:</b> {if $objFormulario->bolInmovilizadoCuentaAhorro2 == 1} Si {else} No {/if}</td>
			</tr>
			<tr>
				<td><b>Cr&eacute;dito:</b> {$arrBanco.$seqBancoCredito}</td>
				<td><b>Valor:</b> $ {$objFormulario->valCredito|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteCredito|strtoupper}</td>
				<td><b>Fecha Vencimiento:</b> {$objFormulario->fchAprobacionCredito}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><b>Subsidio Nacional</b></td>
				<td><b>Valor:</b> $ {$objFormulario->valSubsidioNacional|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteSubsidioNacional|strtoupper}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><b>Cesant&iacute;as</b></td>
				<td><b>Valor:</b> $ {$objFormulario->valSaldoCesantias|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteCesantias|strtoupper}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><b>Donaci&oacute;n / VUR: {$arrDonantes.$seqEntidadDonante}</b></td>
				<td><b>Valor:</b> $ {$objFormulario->valDonacion|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteDonacion|strtoupper}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><b>Entidad Leasing:</b> $ {$arrBanco.$seqBancoLeasing}</td>
				<td><b>Valor:</b> $ {$objFormulario->valCartaLeasing|number_format:0:',':'.'}</td>
				<td><b>Soporte:</b> {$objFormulario->txtSoporteLeasing}</td>
				<td><b>Fecha Aprobación:</b> {$objFormulario->fchAprobacionLEasing}</td>
				<td><b>Duración:</b> {$objFormulario->numDuracionLeasing} Meses</td>
			</tr>
			<tr>

				<td><b>Viabilidad Leasing (Si aplica): {if $objFormulario->bolViabilidadLeasing == 1} Si {else} No {/if} </b></td>
			</tr>

			<tr>
				<td bgcolor="#E4E4E4"><b>Total Recursos Econ&oacute;micos</b></td>
				<td bgcolor="#E4E4E4" align="right" style="padding-right:17px;">$ {$objFormulario->valTotalRecursos|number_format:0:',':'.'}</td>
				<td bgcolor="#E4E4E4">&nbsp;</td>
				<td bgcolor="#E4E4E4">&nbsp;</td>
				<td bgcolor="#E4E4E4">&nbsp;</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
			<tr>
				<td bgcolor="#CECECE" align="center" width="10%"><b>&nbsp;</b></td>
				<td bgcolor="#CECECE" align="center" width="20%"><b>Firma del Hogar</b></td>
				<td bgcolor="#CECECE" align="center" width="20%"><b>Firma del Tutor</b></td>
			</tr>
			<tr><td colspan="4">
				<table cellspacing="3" cellpadding="0" border="1" width="100%" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 9px;">
					<tr>
						<td width="10%" rowspan="2" height="10px" style="border: 1px dotted #000000;">&nbsp;</td>
						<td width="20%" height="50px" style="border: 1px dotted #000000;">&nbsp;</td>
						<td width="20%" height="50px" style="border: 1px dotted #000000;">&nbsp;</td>
					</tr>
					<tr>
						<td width="25%" height="20px" style="border: 1px dotted #999999;">{$arrBeneficiario.nombre}<br> C.C.</td>
						<td width="25%" height="20px" style="border: 1px dotted #999999;" valign="top">
							{$txtUsuarioSistema}
						</td>
					</tr>
				</table>
			</td></tr>
			
			<tr><td style="font-size: 7px;" align="justify" colspan="4">
				La Secretaria Distrital del Hábitat asume de parte del hogar postulante que:
					*Toda información suministrada es verídica y es bajo la gravedad del juramento.
					*Autoriza para que, por cualquier medio, se verifique la información aquí contenida.
					*Autoriza de manera previa, explicita e inequívoca a la Secretaria Distrital del Hábitat para el
					tratamiento de los datos personales suministrados, dentro de sus finalidades legales y desarrollo de las funciones propias
					de la entidad. Ley 1581 de 2012.
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td style="font-size: 7px;" align="justify" colspan="4">
				Si en el proceso de validación y/o revalidación el hogar resulta con una inconsistencia con la información
				reportada, la continuidad en el proyecto y la unidad habitacional para el cual se postuló dependerá de
				la disponibilidad de cupos y conforme con lo establecido en el Reglamento Operativo vigente para el otorgamiento
				de los aportes del Distrito Capital para la generación de vivienda de interés prioritario en el marco
				del Programa Integral de Vivienda Efectiva.
				El diligenciamiento de este formulario representa la postulación al sistema de información para soluciones
				de vivienda de la Secretaria Distrital del Hábitat y no implica el otorgamiento del Aporte Distrital.
			</td></tr>
			
		</table>
		
		
	</body>
	</html>
