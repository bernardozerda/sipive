
	
	<table cellspacing="5" cellpadding="10" border="0" width="100%" >
		
		<tr>
			<td widht="60%" bgcolor="#EFEFEF" valign="top">
				Use este icono para observar los eventos que se han encontrado en el sistema. Los eventos que 
				se pueden encontrar aqui son de dos tipos:
				<ul>
					<li>Hay consignaciones que se registraron de las cuales no hay solicitud de 
						desembolso para el hogar en el periodo seleccionado</li>
					<li>Hay solicitudes de desembolso registradas para el periodo seleccionado
					las de las cuales no se ha encontrado consignación al CAP.</li>
				</ul>
			</td>
			<td bgcolor="#EFEFEF" valign="top">
				Use este icono para exportar el formato de solicitud de pago, aqui encontrará
				los hogares que tienen una solicitud de desembolso y consignación al CAP registrada
				para el periodo seleccionado.
			</td>
		</tr>
		<tr>
			<td align="center">
				<button onClick="someterFormulario( 'mensajes' , 'frmCAP' , './contenidos/desembolso/solicitudesSinConsignacion.php', true , false );">
					Exportar Formato
				</button>
			</td>
			<td align="center">
				<button onClick="someterFormulario( 'mensajes' , 'frmCAP' , './contenidos/desembolso/formatoPago.php', true , false );">
					Exportar Formato
				</button>
			</td>
		</tr>
	</table>
	
	<form id="frmCAP" onSubmit="return false;">
		<input type="hidden" name="fchMes" value="{$fchMes}">
	</form>
	
