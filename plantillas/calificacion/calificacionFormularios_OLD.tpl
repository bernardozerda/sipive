
	<center>
	<table cellpadding="5" cellspacing="0" border="0" width="95%">
		<tr>
			<td bgcolor="#E4E4E4" align="center">
				<b>Este es un Resumen del estado de los formularios, por modalidad y por tutor.<br> 
				A continuacion vera una lista de formularios que estan abiertos y cerrados segun la modalidad o el tutor.</b>
				<span class="msgError">Hasta este momento no se ha surtido ningún proceso en la calificación, para continuar
				con la calificación por favor de click en continuar.</span>
			</td>
		</tr>
	</table>
	<br>
	<table cellpadding="2" cellspacing="0" border="0" width="50%">
		<td align="center">
			<input type="button" 
				   name="continuar" 
				   id="continuar" 
				   value="Proceder a Calificar"
				   onClick="continuarCalificacion();"
			/>
		</td>
		<td align="center">
			{if $txtArchivo != ""}
				<a href="./recursos/descargas/{$txtArchivo}">Exportar este reporte a un archivo</a>
			{else}
				<span class="msgError">Lo sentimos, no se ha podido crear el archivo</span>
			{/if}
		</td>
	</table>
	<br>
	<table cellpadding="2" cellspacing="0" border="0" width="50%">
		<tr>
			<td bgcolor="#E4E4E4" class="tituloTabla" align="center" width="250px">Modalidad</td>
			<td bgcolor="#E4E4E4" class="tituloTabla" align="center">Total</td>
		</tr>
		{foreach from=$arrModalidad key=seqModalidad item=txtModalidad}
			<tr>
				<td style="border-bottom: 1px dotted #999999;"><b>{$txtModalidad|utf8_decode|lower|ucwords|utf8_encode}</b></td>
				<td align="center" style="border-bottom: 1px dotted #999999;">
					{if $arrTotales.0.modalidad.$seqModalidad }
						{$arrTotales.0.modalidad.$seqModalidad|number_format:0:'.':','}
					{else}
						0
					{/if}
				</td>
			</tr>
		{/foreach}
		<tr>
			<td class="tituloTabla">Total</td>
			<td bgcolor="#E4E4E4" align="center" style="border-bottom: 1px dotted #999999;">
				{if $arrTotales.0.total }
					{$arrTotales.0.total|number_format:0:'.':','}
				{else}
					0
				{/if}
			</td>
		</tr>
	</table>
	<br>
	<table cellpadding="2" cellspacing="0" border="1" width="50%">
		<tr>
			<td bgcolor="#E4E4E4" align="center" width="250px"><b>Fecha Calificación</b></td>
			<td bgcolor="#E4E4E4" align="center"><b>Total Calificados</b></td>
		</tr>
		{foreach from=$arrFchCalifica key=fechaCalificacion item=cuantos}
			<!-- <a href="contenidos/calificacion/pdfCalifica.php?fchCal={$fechaCalificacion}" target='_blank'>PDF</a>&nbsp; -->
			<tr><td style="border-bottom: 1px dotted #999999;" align="center"><b>{$fechaCalificacion}</b>&nbsp;<a href="contenidos/calificacion/xlsCalifica.php?fchCal={$fechaCalificacion}" target='_blank'>XLS</a></td>
				<td style="border-bottom: 1px dotted #999999;" align="center">{$cuantos}</td></tr>
		{/foreach}
	</table>
	</center>