
<center>

<!-- FORMULARIOS POSTULADOS -->	
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Formularios Postulados</th>
		</tr>
		<tr>
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Descargue una lista de los formularios postulados por cada
				usuario del sistema en la fecha seleccionada
			</td>
			<td style="border-bottom: 1px dotted #999999;" align="center">
				<select onChange="cargarContenido( 'mensajes','./contenidos/subsidios/formulariosDigitados.php','fecha='+this.options[ this.selectedIndex ].value,true );">
					<option value="">Seleccione una fecha</option>
					<option value="0">Todas las fechas</option>
					{foreach from=$arrPostulacion key=fchDato item=txtFecha}
						<option value="{$fchDato}">{$txtFecha}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table>
	<br>
	
<!-- MAYORES DE EDAD AL ULTIMO PERIODO DE CORTE -->
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Listado de Mayores de edad</th>
		</tr>
		<tr style="border-bottom: 1px dotted #999999">
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Este exportable le entrega un listado de los mayores de edad de los hogares
				que se encuentran actualmente en la etapa de Postulación - Cosecha que están cerrados
				y que fueron postulados hasta la fecha seleccionada.
			</td>
			<td style="border-bottom: 1px dotted #999999;" align="center">
				<select onChange="cargarContenido( 'mensajes','./contenidos/subsidios/listadoPostulados.php','fecha='+this.options[ this.selectedIndex ].value,true );">
					<option value="">Seleccione una fecha</option>
					<option value="0">Todas las fechas</option>
					{foreach from=$arrPostulacion key=fchDato item=txtFecha}
						<option value="{$fchDato}">{$txtFecha}</option>
					{/foreach}
				</select>
			</td>
		<tr>
	</table>
	<br>	

<!-- REPORTE DIRECTIVA 013 -->
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Reporte Directiva 013 (Beta)</th>
		</tr>
		<tr style="border-bottom: 1px dotted #999999">
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Este reporte es una replica de la directiva 013 en donde se muestra 
				la caracterización de la poblacion por genero y grupos etnicos según edades.<br>
				Cargue en un archivo de texto, en solo una columna las cedulas de los postulantes 
				principales de los hogares a incluir dentro del reporte.
			</td>
			<td style="border-bottom: 1px dotted #999999; padding-left:20px;">
				<form name="sdvCifras" id="sdvCifras" onSubmit="return false;">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td align="center" valign="middle">
								Cedulas Postulante Principal<br>
								<input type="file" name="archivo">			
							</td>
							<td width="50px" align="center" valign="middle">
								<button	type="button" 
										title="Exportar"  
										class="reporteador" 
										onClick="
											someterFormulario( 
												'mensajes' , 
												document.sdvCifras , 
												'./contenidos/subsidios/directiva013.php' , 
												true , 
												false 
											);											
										"
								><img src="./recursos/imagenes/play-icon.jpg" width="21" height="21" alt="Exportar" align="center">
								</button>			
							</td>
						</tr>
					</table>
				</form>
			</td>
		<tr>
	</table>
	<br>

<!-- REPORTE SEGUIMIENTO -->
	<form name="reporteSeguimiento" id="reporteSeguimiento" onSubmit="return false;">
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Reporte de Seguimiento</th>
		</tr>
		<tr>
			<td height="50px" width="400px">
				Obtenga un listado de personas atendidas, clasificaci&oacute;n de la atencion
				y los comentarios que los tutores han hecho a los ciudadanos
			</td>
			<td align="center">
					<a 	href="#" 
						onClick="someterFormulario( 'mensajes' , document.reporteSeguimiento , './contenidos/subsidios/reporteSeguimiento.php' , true , false );"
					>Descargar el reporte</a>
			</td>
		<tr>
		<tr style="border-bottom: 1px dotted #999999" >
			<td colspan="2">
			 {include file='subsidios/pedirSeguimientoExportable.tpl'}
			</td>
		</tr>
	</table>
	</form>
	<br>

<!-- PARA LLAMAR (PROVISIONAL MIENTRAS ESTA EL REPORTEADOR) -->
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Reporte de Inscritos</th>
		</tr>
		<tr style="border-bottom: 1px dotted #999999">
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Reporte de los hogares listos para ser contactados, puede seleccionar las
				fechas de inscripci&oacute;n del hogar para filtrar los resultados
			</td>
			<td style="border-bottom: 1px dotted #999999;" align="center" valign="bottom">
				<form name="llamadas" id="llamadas" onSubmit="return false;">
				<table cellpadding="1" cellspacing="0" border="0" width="100%">
					<tr>
						<td width="80px">Fecha Inicial</td>
						<td>
							<select name="inicial" id="inicial" onChange="fechasFuturas( this , 'final' );" style="width:200px;">
								<option value="">Seleccione una fecha</option>
								{foreach from=$arrInscripcion key=fchInscripcion item=txtFechaInscripcion}
									<option value="{$fchInscripcion}">{$txtFechaInscripcion}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Fecha Final</td>
						<td>
							<select name="final" id="final"  style="width:200px;">
								<option value="">Seleccione una fecha</option>
								{foreach from=$arrInscripcion key=fchInscripcion item=txtFechaInscripcion}
									<option value="{$fchInscripcion}">{$txtFechaInscripcion}</option>
								{/foreach}
							</select>
							
						</td>
					</tr>
				</table>
				</form>
				<table cellpadding="1" cellspacing="0" border="0" width="100%">
					<tr>
						<td colspan="2" align="right" style="padding-right:10px">
							<a 	href="#"
								onClick="someterFormulario( 
											'mensajes' , 
											document.llamadas , 
											'./contenidos/subsidios/reporteLlamadas.php' , 
											true , 
											false 
										);"
							>Descargar Reporte</a>
						</td>
					</tr>
				</table>
			</td>
		<tr>
	</table>
	<br />
	
<!-- REPORTE CATALINA --> 
	<form name="reporteDesembolsoTrasladoFin" id="reporteDesembolsoTrasladoFin" onSubmit="return false;">
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Reporte Desembolsos. Tramites Administrativos</th>
		</tr>
		<tr>
			<td height="50px" width="400px">
				Reporte de los hogares en proceso de desembolso con tramite del Grupo Administrativo
			</td>
			<td align="center">
					<a 	href="#" 
						onClick="someterFormulario( 'mensajes' , 'reporteDesembolsoTrasladoFin' , './contenidos/subsidios/reporteDesembolsoTrasladoFin.php' , true , false );"
					>Descargar el reporte</a>
			</td>
		<tr>
		<tr style="border-bottom: 1px dotted #999999" >
			<td colspan="2">
			 {include file='subsidios/pedirSeguimientoExportableDesembolso.tpl'}
			</td>
		</tr>

	</table>
	</form>
	<br>
	

<!-- REPORTE CATALINA --> 
	<form name="reporteDesembolsoTrasladoFin" id="reporteDesembolsoTecnica" onSubmit="return false;">
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Reporte Tecnico</th>
		</tr>
		<tr>
			<td height="50px" width="400px">
			</td>
			<td align="center">
					<a 	href="#" 
						onClick="someterFormulario( 'mensajes' , 'reporteDesembolsoTecnica' , './contenidos/subsidios/reporteDesembolsoTecnica.php' , true , false );"
					>Descargar el reporte</a>
			</td>
		<tr>
		<tr style="border-bottom: 1px dotted #999999" >
			<td colspan="2">
			 {include file='subsidios/pedirSeguimientoExportableTecnico.tpl'}
			</td>
		</tr>
	</table>
	</form>
	<br>
	
	
	


<!-- PARA LLAMAR (PROVISIONAL MIENTRAS ESTA EL REPORTEADOR) -->
<!-- 
	<table cellspacing="0" cellpadding="3" border="0" width="90%">
		<tr>
			<th style="border-bottom: 1px dotted #999999" align="left" colspan="2">Resumen SDV. Metrovivienda y SDHT</th>
		</tr>
		<tr style="border-bottom: 1px dotted #999999">
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Reporte que resume las cifras de hogares asignados por grupo poblacional (independientes y desplazados)
			</td>
			<td style="border-bottom: 1px dotted #999999;" align="center" valign="bottom">
				<a href="./descargas/RESUMEN SUBSIDIOS JUN.xlsx">Descargar Resumen</a>
			</td>
		<tr>
		<tr style="border-bottom: 1px dotted #999999">
			<td height="50px" width="400px" style="border-bottom: 1px dotted #999999;">
				Analisis programa SDV Marzo 2009-2010
			</td>
			<td style="border-bottom: 1px dotted #999999;" align="center" valign="bottom">
				<a href="./descargas/Resumen SUBSIDIOS DE SDV.xlsx">Descargar Resumen</a>
			</td>
		<tr>
	</table>
-->
	
</center>


