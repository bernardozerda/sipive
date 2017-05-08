
<!--
	
	LISTADO GENERICO QUE FUNCIONA PARA LAS OPCIONES DE MENU DEL 
	PANEL DE CONTROL EXCEPTO PARA LAS OPCIONES DE MENU

	@author Bernardo Zerda 
	@version 1.0 Abil de 2009
	@version 1.1 Septiembre de 2009
	
-->	

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px">{$txtTitulo}</td></tr>
	</table>
	<br>	
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td>
				<div style="width:100%; height: 580px; overflow: auto;">
			
					<table cellspacing="2" cellpadding="0" border="0" width="100%">
					
						<!-- PARA CADA OPCION DEL LISTADO COLOCA LA PRESENTACION UNIFORME -->
						{foreach from=$arrListado key=seqListado item=arrInformacion}
							<tr bgcolor="{cycle name=c1 values="#FFFFFF,#F9F9F9"}"
								style="cursor:pointer"
								onMouseOver="this.style.background='#e0e0e0'"
								onMouseOut="this.style.background='{cycle name=c2 values="#FFFFFF,#F9F9F9"}'"
								onClick="cargarContenido( 'formulario' , '{$txtEditar}' , 'seqEditar={$seqListado}' , true);"
							>
	
								{if $arrInformacion.estado != "inactivo"}
									<td align="center" widht="15px"><img src="./recursos/imagenes/bullet.jpg" /></td> 
								{else}
									<td align="center" widht="15px"><img src="./recursos/imagenes/bulletRojo.png" /></td>
								{/if}
														
								<td style="padding-left:5px;">{$arrInformacion.nombre}</td> <!-- FORMATEA LA CADENA DE CARACTERES -->
	
	
								
								<td><a href="#" onClick="eliminarRegistro( {$seqListado} , '{$txtPregunta}' , '{$txtBorrar}' ); document.getElementById('seqEditar').value = ''; ">Borrar</td>
							</tr>
						{/foreach}					
					</table>
					
				</div>
					
			</td>
		</tr>
		

		
	</table>
