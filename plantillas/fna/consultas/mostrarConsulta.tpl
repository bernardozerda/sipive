	
	<center>
	<div id="cargandoTablaFNA"><img src="./recursos/imagenes/cargando.gif"></div>
	<div class="msgOk">
		Puede descargar la tabla de este reporte haciendo click 
		<a href="./{$txtArchivo}">Aqui</a>
	</div>
	<div id="tablaFNA" style="visibility: hidden;">
		<table id="datosFNA">
			<thead>
	            <tr>
	            	{foreach from=$arrTabla.0 item=txtColumna}
	                <th>{$txtColumna}</th>
	                {/foreach}
	            </tr>
	        </thead>
	        <tbody>
	        	{foreach name=tabla from=$arrTabla item=arrLinea}
	        		{if $smarty.foreach.tabla.index > 0 }
		        		<tr>
						{foreach from=$arrLinea key=keyDato item=txtDato}
							{if $keyDato eq "ActoAdministrativo"}
								<td>{$txtDato|utf8_encode|ucwords}</td>
							{else}
								<td>{$txtDato|utf8_decode|ucwords|utf8_encode}</td>
							{/if}
						{/foreach}
						</tr>
					{/if}
				{/foreach}
			</tbody>	
		</table>
	</div>
	<div class="msgOk">Se han procesado para este reporte {$txtContador}</div>
	</center>
	<div id="listenerReporteFNA"></div>
