
	<form id="frmAsignacionFormsUsuariosInformacion">
	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr height="20px" />
		<tr>
			<td width="40%" valign="top">
				<table cellspacing="0" cellpadding="0" border="0" width="95%">
					<tr>
						<td width="20px" />
						<td>
							<div id="txtDivTutoresInformacion" style="display:none">{$txtTutoresInformacionJS}</div>
							<div id="treeDivArbolMostrarTutoresInformacion"  class="ygtv-checkbox"/>
						</td>
					</tr>
					<tr height="15px" />
					<tr>
						<td colspan="2">
							<button type="button" id="descargaHogaresTutor" title="Exportar" class="reporteadorExport" >
								Descargar Lista Hogares Tutor
							</button>
							<button type="button" id="descargaHogaresTotal" title="Exportar" class="reporteadorExport" >
								Descargar Lista Hogares NO Asignados
							</button>
						</td>
					</tr>
					<!-- 
					<tr height="15px" />
					<tr>
						<td colspan="2">
							<a href="#" id="descargaHogaresTotal">Descargar Lista de hogares NO Asignados</a>
						</td>
					</tr> -->
				</table>
			</td>
			<td valign="top">
				<table cellspacing="0" cellpadding="0" border="0" width="95%">
					<tr>
						<td width="20px" />
						<td><b>TABLA HOGARES TUTOR</b></td>
					</tr>
					<tr>
						<td width="20px" />
						<td>
							<div id="divTablasUsuariosFormularios" >
								{include file="asignacionFormularios/dataTableFormulario.tpl"}
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
			
	</table>
	
	</form>