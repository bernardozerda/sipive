
	<!-- TABLA PARA INTRODUCIR LOS DATOS
	QUE VIENEN DEL BANCO RELACIONANDO LAS CONSIGNACIONES
	A LAS CUENTAS DE AHORRO PROGRAMADO DEL SCA -->


<form id="frmSolicitudesCAP" onSubmit="return false;">
	
	<table cellspacing="0" cellpadding="5" border="0" width="100%">
	
		<!-- TITULO DE LA CARGA MASIVA -->
		<tr>
			<td class="tituloTabla" colspan="4">
				Subsidio condicionado de arrendamiento <br>
				Carga masiva de solicitudes de desembolso
			</td>
		</tr>
		
		<!-- INSTRUCCIONES -->
		<tr><td style="border: 1px solid #999999;" colspan="4">
			<p>Cargue un archivo de texto plano, separado por tabulaciones, en donde la primera fila
			sean los titulos de las columnas.  Las columnas que deben ir como sigue:</p>
			<ul>
				<li>Nùmero de documento del Postulante Principal</li>
				<li>Fecha de la solicitud (aaaa-mm-dd)</li>
				<li>Número del Proyecto de Inversion</li>
				<li>Número Registro Presupuesta 1</li>
				<li>Fecha Registro Presupuesta 1 (aaaa-mm-dd)</li>
				<li>Número Registro Presupuesta 2 </li>
				<li>Fecha Registro Presupuesta 2 (aaaa-mm-dd)</li>
				<li>Nombre del Beneficiario del giro</li>
				<li>Documento del Beneficiario del giro</li>
				<li>Dirección del Beneficiario del giro</li>
				<li>Teléfono del Beneficiario del giro</li>
				<li>Número de Cuenta del Beneficiario del giro</li>
				<li>Tipo de Cuenta del Beneficiario del giro (Ahorros, Corriente, Cheque)</li>
				<li>Banco de la Cuenta del Beneficiario del giro</li>
				<li>Valor de la solicitud (sin comas ni simbolos de moneda ni puntos "$")</li>
				<li>Nombre Firma Subsecretaría</li>
				<li>Subsecretaría Encargado (Si o No)</li>
				<li>Nombre Firma Subdireccion Recursos Publicos</li>
				<li>Subdireccion Encargado (Si o No)</li>
				<li>Nombre Elaboró</li>
				<li>Numero de Radicacion</li>
				<li>Fecha de Radicacion (aaaa-mm-dd)</li>
				<li>Numero de Orden de Pago</li>
				<li>Fecha de Orden de Pago (aaaa-mm-dd)</li>
				<li>Valor Pagado</li>
			</ul>
			 <p>Los documentos que aqui se carguen deben pertenecer a cualquier mayor de edad registrado
			 en el formulario de posutlación, pero no necesariamente debe ser el postulante principal.</p>
		</td></tr>
		
		<!-- CAMPO PARA CARGAR EL ARCHIVO -->
		<tr>
			<td width="160px" class="tituloTabla"><b>Archivo de documentos</b></td>
			<td class="tituloTabla">
				<input type="file"
					   name="archivo"
				/>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<input  type="button"
						value="Procesar Archivo"
						onClick="someterFormulario('mensajes', 'frmSolicitudesCAP' , './contenidos/desembolso/salvarSolicitudesCAP.php', true, true );"
				/>
			</td>
		</tr>
		
	</table>
	
</form>





	
<form id="frmConsignacionesCAP" onSubmit="return false;">
	
	<table cellspacing="0" cellpadding="5" border="0" width="100%">
		
		<!-- TITULO DE LA CARGA MASIVA -->
		<tr>
			<td class="tituloTabla" colspan="4">
				Subsidio condicionado de arrendamiento <br>
				Carga masiva de consignaciones en cuenta de ahorro programado
			</td>
		</tr>
		
		<!-- INSTRUCCIONES -->
		<tr><td style="border: 1px solid #999999;" colspan="4">
			<p>Cargue un archivo de texto plano, separado por tabulaciones, en donde la primera fila
			sean los titulos de las columnas.  Las columnas que deben ir como sigue:</p>
			<ul>
				<li>Nùmero de documento</li>
				<li>Fecha de la consignación</li>
				<li>Valor de la consignación (sin comas ni simbolos de moneda ni puntos "$")
				<li>Numero de cuenta</li>
			</ul>
			 <p>Los documentos que aqui se carguen deben pertenecer a cualquier mayor de edad registrado
			 en el formulario de posutlación, pero no necesariamente debe ser el postulante principal.</p>
		</td></tr>
		
		<!-- CAMPO PARA CARGAR EL ARCHIVO -->
		<tr>
			<td width="150px" class="tituloTabla"><b>Periodo del archivo</b></td>
			<td align="center" width="210px" class="tituloTabla">
				<select name="fchMes" style="width:200px;">
					<option value="">Seleccione un periodo</option>
					{foreach from=$arrMeses key=fchMes item=txtMes}
						<option value="{$fchMes}">{$txtMes}</option>
					{/foreach}
				</select>
			</td>
			<td width="160px" class="tituloTabla"><b>Archivo de documentos</b></td>
			<td class="tituloTabla">
				<input type="file"
					   name="archivo"
				/>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<input  type="button"
						value="Procesar Archivo"
						onClick="someterFormulario('resultados', 'frmConsignacionesCAP' , './contenidos/desembolso/salvarConsignacionesCAP.php', true, true );"
				/>
			</td>
		</tr>
	</table>
	
</form>
	
<div id="resultados" style="width:100%; height:250px; overflow:auto;"></div>
	