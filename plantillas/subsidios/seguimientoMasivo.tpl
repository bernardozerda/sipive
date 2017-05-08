
	<form id="frmSeguimientoMasivo" >
	{include file='subsidios/pedirSeguimiento.tpl'} <br />
	<table cellspacing="0" cellpadding="2" border="0" width="100%">
	
		<tr>
			<td class="tituloTabla" colspan="2">Seguimiento Masivo</td>
		</tr>
		
		<tr width="200px" >
			<td height="20px" align="center" valign="top"
				style="padding-top:5px; border-left: 1px dotted #999999; border-right: 1px dotted #999999; border-bottom: 1px dotted #999999" >
			
				<table cellpadding="0" cellspacing="2" border="0" width="99%" align="justify">
				
					<tr
						<td>Archivo:</td>
						<td height="30px" align="left" valign="top" style="padding-top: 8px; " > 
							<input type="file" name="archivo" />
						</td> 
					</tr>
					<!-- BOTON -->
					<tr>
						<td colspan="2" height="25px" align="right" style="padding-right:20px;" bgcolor="#F9F9F9">
							<input  type="button" 
									value="Seguimiento Masivo" 
									onClick="someterFormulario( 
											'mensajes', 
											this.form, 
											'./contenidos/subsidios/seguimientoMasivo.php', 
											true, 
											true
										); 
									"
							/><input type="hidden" id="txtEnvio" name="txtEnvio" value="envio" />
						</td>
					</tr>	
				
				</table>
			
			</td>
			
			<td width="400px" align="center" valign="top"
				style="padding-top:5px; border-left: 1px dotted #999999; border-right: 1px dotted #999999; border-bottom: 1px dotted #999999" >
				<table cellpadding="0" cellspacing="2" border="0" width="99%" align="justify">
					
					<tr><td><b>Para el Seguimiento Masivo</b></td></tr>
					<tr><td style="padding-left: 15px">
						<li>El <b>Formato del Archivo</b> debe ser texto plano separado por tabulaciones.</li>
					</td></tr>
					<tr><td style="padding-left: 15px">
						<li>Las <b>Columnas del archivo</b> son "Documento" y "Comentario"</li>
					</tsd></tr>
					<tr><td style="padding-left: 15px">
						<li>La primera linea del archivo deben ser los titulos de las columnas.</li>
					</td></tr>
					<tr><td style="padding-left: 15px">
						<li>Los documentos consignados deben corresponder al postulante principal del hogar.</li>
					</td></tr>
				</table>
				
			</td>
		</tr>
	
	</table>
	</form>
	