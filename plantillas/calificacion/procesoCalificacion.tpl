	<br>
	<center>
	<table cellpadding="5" cellspacing="0" border="0" width="95%">
		<tr>
			<td class="tituloTabla" align="justify">
				A continuación vera la tabla de hogares con sus calificaciones finales, este es el producto
				de realizar el proceso de calificacion y el proceso de desempates, la lista está ordenada
				de mayor a menor por el puntaje obtenido, para mas detalles de la calificación de estos hogares
				puede descargar el archivo haciendo click en el siguiente enlace
			</td>
		</tr>
		<tr>
			<td align="center">
				<a href="./recursos/descargas/{$txtArchivo}" class="msgOk">[ {$txtArchivo} ]</a>
			</td>
		</tr>
	</table>
	<div id="cargandoTablaCalificacion"><img src="./recursos/imagenes/cargando.gif"></div>
	<div id="tablaCalificacion" style="visibility: hidden;">
		<table id="datosCalificion">
			<thead>
	            <tr>
	                <th>Tipo Documento</th>
	                <th>Documento</th>
	                <th>Nombre</th>
	                <th>Modalidad</th>
	                <th>Calificacion</th>
	            </tr>
	        </thead>
	        <tbody>
				{foreach from=$arrTotales key=seqFormulario item=arrDatos}
					<tr>
						<td>{$arrCalificacion.$seqFormulario.datos.tpoDocumento|utf8_decode|lower|ucwords|utf8_encode}</td>
						<td>{$arrCalificacion.$seqFormulario.datos.numDocumento|number_format:0:'.':','}</td>
						<td>{$arrCalificacion.$seqFormulario.datos.nomPostulante|utf8_decode|lower|ucwords|utf8_encode}</td>
						<td>{$arrCalificacion.$seqFormulario.datos.txtModalidad|utf8_decode|lower|ucwords|utf8_encode}</td>
						<td>{$arrCalificacion.$seqFormulario.calificacion.total|number_format:10:'.':','}</td>
					</tr>
				{/foreach}
			</tbody>	
		</table>
	</div>
	</center>
	<div id="listenerTextoCalificacion"></div>
		