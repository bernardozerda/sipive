<center>

<form id="exportarArriendo" onSubmit="return false;">
	
	<a  href="#" 
		onClick="someterFormulario(
					'mensajes',
					document.getElementById('exportarArriendo'),
					'./contenidos/subsidios/exportarHogaresArriendo.php',
					true,
					false 
				);"
	>Exportar a un archivo</a>
	
	{foreach name=arriendo from=$arrDatosPostulados key=seqFormulario item=arrDatos}
		<input type="hidden"
			   name="postulados[{$seqFormulario}][TipoDocumento]"
			   value="{$arrDatos.TipoDocumento}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Documento]"
			   value="{$arrDatos.Documento}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Nombre]"
			   value="{$arrDatos.Nombre}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Direccion]"
			   value="{$arrDatos.Direccion}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Telefono1]"
			   value="{$arrDatos.Telefono1}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Telefono2]"
			   value="{$arrDatos.Telefono2}"
		/>
		<input type="hidden"
			   name="postulados[{$seqFormulario}][Celular]"
			   value="{$arrDatos.Celular}"
		/>
	{/foreach}
	
</form>

<div id="contenedorhogaresSeleccionadosArrendamiento">
	<table id="hogaresSeleccionadosArrendamiento">
		<thead>
	        <tr>
	        	<th>Item</th>
	            <th>Tipo Documento</th>
	            <th>Documento</th>
	            <th>Nombre</th>
	            <th>Dirección</th>
	            <th>Teléfono 1</th>
	            <th>Teléfono 2</th>
	            <th>Celular</th>
	        </tr>
	    </thead>
	    <tbody>
			{foreach name=arriendo from=$arrDatosPostulados key=seqFormulario item=arrDatos}
				{math equation="x + y" x=$smarty.foreach.arriendo.index y=1 assign=numItem}
				<tr>
					<td>{$numItem}</td>
					<td>{$arrDatos.TipoDocumento|utf8_decode|lower|ucwords|utf8_encode}</td>
					<td>{$arrDatos.Documento}</td>
					<td>{$arrDatos.Nombre|utf8_decode|lower|ucwords|utf8_encode}</td>
					<td>{$arrDatos.Direccion|utf8_decode|upper|utf8_encode}</td>
					<td>{$arrDatos.Telefono1}</td>
					<td>{$arrDatos.Telefono2}</td>
					<td>{$arrDatos.Celular}</td>
				</tr>
			{/foreach}
		</tbody>	
	</table>
</div>
</center>
<div id="listenerhogaresSeleccionadosArrendamiento"></div>
