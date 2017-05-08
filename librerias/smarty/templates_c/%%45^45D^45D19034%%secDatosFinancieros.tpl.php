<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:52
         compiled from proyectos/secDatosFinancieros.tpl */ ?>
<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">
			<tr><td class="tituloTabla" colspan="4">DATOS DEL INTERVENTOR</td></tr>
			<tr>
				<!-- NOMBRE INTERVENTOR -->
				<td>Nombre</td>
				<td><input name="txtNombreInterventor" type="text" id="txtNombreInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
				<!-- TELEFONO INTERVENTOR -->
				<td>Tel&eacute;fono</td>
				<td><input name="numTelefonoInterventor" type="text" id="numTelefonoInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<tr>
				<!-- DIRECCION INTERVENTOR -->
				<td><a href="#" id="DireccionSolucion" onClick="recogerDireccion( 'txtDireccionInterventor', 'objDireccionOcultoSolucion' )">Direcci&oacute;n</a></td>
					<td><input type="text" 
								name="txtDireccionInterventor" 
								id="txtDireccionInterventor" 
								value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionInterventor; ?>
" 
								style="width:200px; background-color:#ADD8E6;" 
								readonly
						/>
				</td>
				<!-- CORREO ELECTRONICO INTERVENTOR -->
				<td>Correo electr&oacute;nico</td>
				<td><input name="txtCorreoInterventor" type="text" id="txtCorreoInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
				</td>
			</tr>
			
			<tr>
				<!-- TIPO DE PERSONA INTERVENTOR -->
				<td>Tipo de Persona</td>
				<td align="left" colspan="3">
				Natural <input name="bolTipoPersonaInterventor" type="radio" id="bolTipoPersonaInterventor" onClick="escondeCamposTipoPersona()" value="1" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 1): ?> checked <?php endif; ?> /> 
				Jur&iacute;dica <input name="bolTipoPersonaInterventor" type="radio" onClick="escondeCamposTipoPersona()" id="bolTipoPersonaInterventor" value="0" <?php if ($this->_tpl_vars['objFormularioProyecto']->bolTipoPersonaInterventor == 0): ?> checked <?php endif; ?>/> 
				</td>
			</tr>

			<tr id="lineaPersonaNatural" name="lineaPersonaNatural" style="display:none">
				<!-- CEDULA INTERVENTOR (Persona Natural) -->
				<td>C&eacute;dula</td>
				<td><input name="numCedulaInterventor" type="text" id="numCedulaInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numCedulaInterventor; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:200px;"/></td>
				<!-- TARJETA PROFESIONAL INTERVENTOR (Persona Natural)-->
				<td>Tarjeta Profesional</td>
				<td><input name="numTProfesionalInterventor" type="text" id="numTProfesionalInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numTProfesionalInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>

			<!-- NIT INTERVENTOR -->
			<tr id="lineaPersonaJuridica" name="lineaPersonaJuridica" style="display:none">
				<td>NIT</td>
				<td colspan="3"><input name="numNitInterventor" type="text" id="numNitInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numNitInterventor; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNit( this );" style="width:200px;"/></td>
			</tr>
			
			<tr><td id="lineaTituloInterventor" name="lineaTituloInterventor" class="tituloTabla" colspan="4">DATOS DEL REPRESENTANTE LEGAL</td></tr>
			<tr id="lineaPersonaJuridica2" name="lineaPersonaJuridica2" style="display:none">
				<!-- NOMBRE REPRESENTANTE LEGAL INTERVENTOR -->
				<td>Nombre Representante Legal</td>
				<td><input name="txtNombreRepLegalInterventor" type="text" id="txtNombreRepLegalInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtNombreRepLegalInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
				<!-- TELEFONO REPRESENTANTE LEGAL INTERVENTOR -->
				<td>Tel&eacute;fono</td>
				<td><input name="numTelefonoRepLegalInterventor" type="text" id="numTelefonoRepLegalInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->numTelefonoRepLegalInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/></td>
			</tr>
			
			<tr id="lineaPersonaJuridica3" name="lineaPersonaJuridica3" style="display:none">
				<!-- DIRECCION REPRESENTANTE LEGAL INTERVENTOR -->
				<td><a href="#" id="DireccionSolucion" onClick="recogerDireccion( 'txtDireccionRepLegalInterventor', 'objDireccionOcultoSolucion' )">Direcci&oacute;n</a></td>
					<td><input type="text" 
								name="txtDireccionRepLegalInterventor" 
								id="txtDireccionRepLegalInterventor" 
								value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtDireccionRepLegalInterventor; ?>
" 
								style="width:200px; background-color:#ADD8E6;" 
								readonly
						/>
				</td>
				<!-- CORREO ELECTRONICO REPRESENTANTE LEGAL INTERVENTOR -->
				<td>Correo electr&oacute;nico</td>
				<td><input name="txtCorreoRepLegalInterventor" type="text" id="txtCorreoRepLegalInterventor" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->txtCorreoRepLegalInterventor; ?>
" onBlur="sinCaracteresEspeciales( this );" style="width:200px;"/>
				</td>
			</tr>

	<tr><td class="tituloTabla" colspan="4">VENTAS DEL PROYECTO</td></tr>
	<tr><td colspan="2"><img src="recursos/imagenes/blank.gif" onload="calculaUtilidad(); escondeCamposTipoPersona();"></td>
		<!-- VALOR VENTAS -->
		<td><b>INGRESO VENTAS PROYECTADO</b></td>
		<td>$ <input name="valTotalVentas" type="text" id="valTotalVentas" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalVentas; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px; text-align:right; font-weight: bold" readonly /></td>
	</tr>
	<tr><td class="tituloTabla" colspan="4">COSTOS DEL PROYECTO</td></tr>
	<tr><!-- COSTOS DIRECTOS -->
		<td width="30%">Costos Directos</td>
		<td width="20%">$ <input name="valCostosDirectos" type="text" id="valCostosDirectos" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosDirectos; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalCostos();" style="width:90px; text-align:right"/></td>
		<!-- COSTOS INDIRECTOS -->
		<td width="30%">Costos Indirectos</td>
		<td width="20%">$ <input name="valCostosIndirectos" type="text" id="valCostosIndirectos" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valCostosIndirectos; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalCostos();" style="width:90px; text-align:right"/></td>
	</tr>

	<tr><!-- TERRENO -->
		<td>Terreno</td>
		<td>$ <input name="valTerreno" type="text" id="valTerreno" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTerreno; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalCostos();" style="width:90px; text-align:right"/></td>
		<!-- GASTOS FINANCIEROS -->
		<td>Gastos Financieros</td>
		<td>$ <input name="valGastosFinancieros" type="text" id="valGastosFinancieros" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valGastosFinancieros; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalCostos();" style="width:90px; text-align:right"/></td>
	</tr>

	<tr><!-- GASTOS DE VENTAS -->
		<td>Gastos de Ventas</td>
		<td>$ <input name="valGastosVentas" type="text" id="valGastosVentas" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valGastosVentas; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalCostos();" style="width:90px; text-align:right"/></td>
		<!-- TOTAL COSTO (COSTOS DIRECTOS + COSTOS INDIRECTOS + TERRENO + GASTOS FINANCIEROS + GASTOS VENTAS)-->
		<td><b>COSTO TOTAL DEL PROYECTO</b></td>
		<td>$ <input name="valTotalCostos" type="text" id="valTotalCostos" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalCostos; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px; text-align:right; font-weight: bold" readonly /></td>
	</tr>
	
	<tr><td class="tituloTabla" colspan="4">UTILIDAD DEL PROYECTO</td></tr>
	<tr><td colspan="2"></td>
		<!-- VALOR UTILIDADES -->
		<td><b>TOTAL UTILIDAD</b></td>
		<td>$ <input name="valUtilidadProyecto" type="text" id="valUtilidadProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valUtilidadProyecto; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px; text-align:right; font-weight: bold" readonly /></td>
	</tr>

	<tr><td class="tituloTabla" colspan="4">FUENTES DE FINANCIACI&Oacute;N</td></tr>
	<tr><!-- RECURSOS PROPIOS -->
		<td>Recursos Propios</td>
		<td>$ <input name="valRecursosPropios" type="text" id="valRecursosPropios" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valRecursosPropios; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
		<!-- CREDITO ENTIDAD FINANCIERA -->
		<td>Cr&eacute;dito Entidad Financiera</td>
		<td>$ <input name="valCreditoEntidadFinanciera" type="text" id="valCreditoEntidadFinanciera" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valCreditoEntidadFinanciera; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
	</tr>

	<tr><!-- CREDITO PARTICULARES -->
		<td>Cr&eacute;dito Particulares</td>
		<td>$ <input name="valCreditoParticulares" type="text" id="valCreditoParticulares" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valCreditoParticulares; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
		<!-- VENTAS DEL PROYECTO -->
		<td>Ventas del Proyecto</td>
		<td>$ <input name="valVentasProyecto" type="text" id="valVentasProyecto" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valVentasProyecto; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
	</tr>

	<tr><!-- SDVE -->
		<td>SDVE</td>
		<td>$ <input name="valSDVE" type="text" id="valSDVE" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valSDVE; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
		<!-- OTROS -->
		<td>Otros</td>
		<td>$ <input name="valOtros" type="text" id="valOtros" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valOtros; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
	</tr>

	<tr><!-- DEVOLUCION DE IVA -->
		<td>Devoluci&oacute;n de IVA</td>
		<td>$ <input name="valDevolucionIVA" type="text" id="valDevolucionIVA" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valDevolucionIVA; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); sumaTotalRecursos();" style="width:90px; text-align:right"/></td>
		<!-- TOTAL RECURSOS -->
		<td><b>TOTAL RECURSOS</b></td>
		<td>$ <input name="valTotalRecursos" type="text" id="valTotalRecursos" value="<?php echo $this->_tpl_vars['objFormularioProyecto']->valTotalRecursos; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" style="width:90px; text-align:right; font-weight: bold" readonly /></td>
	</tr>
</table>