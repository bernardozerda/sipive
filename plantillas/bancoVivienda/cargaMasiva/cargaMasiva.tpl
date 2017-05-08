
<div id="frmVivienda" style="float: left; width:55%;">
	
	<form id="bvuCargaMasiva" onSubmit="return false;">
		
		Archivo <input type="file" name="archivo"> <br>
		
		<button onClick="someterFormulario( 
							'resultados' , 
							'bvuCargaMasiva' , 
							'./contenidos/bancoVivienda/cargaMasiva/salvarCargaMasiva.php' ,
							true ,
							true  
						);"
		> Cargar Viviendas </button>
		
	</form>

</div>

<div id="frmImagenes" style="float: left; width:40%;">
	
	<form id="bvuCargaImagenes" onSubmit="return false;">
		
		Archivo <input type="file" name="archivo"> <br>
		
		<button onClick="someterFormulario( 
							'resultados' , 
							'bvuCargaImagenes' , 
							'./contenidos/bancoVivienda/cargaMasiva/salvarImagenes.php' ,
							true ,
							true  
						);"
		> Cargar Imagenes </button>
		
	</form>

</div>

	
	<div id="resultados" style="float: left; width:55%;">
	
<table border=1 cellpadding=0 cellspacing=0 width=461 style='border-collapse:
 collapse;table-layout:fixed;width:346pt'>
 <col width=163 style='mso-width-source:userset;mso-width-alt:6954;width:122pt'>
 <col width=72 style='width:54pt'>
 <col width=226 style='mso-width-source:userset;mso-width-alt:9642;width:170pt'>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 width=163 style='height:12.0pt;width:122pt'>Tipo de Documento * </td>
  <td class=xl6329828 width=72 style='border-left:none;width:54pt'>Numero</td>
  <td class=xl6329828 width=226 style='border-left:none;width:170pt'><font
  color="#000000">1 Cedula de ciudadania; 2 Cedula de extrangeria; 6 NIT</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Numero de Documento * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Primer Nombre * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Segundo Nombre</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Primer Apellido * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Segundo Apellido</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Telefono 1 * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Telefono 2</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Celular</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Correo</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Estado del proceso * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>1 Inscrito 2
  Disponible 3 No Disponible</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Fecha de Creación * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Fecha</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>aaaa-mm-dd</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Fecha de Actualización * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Fecha</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>aaaa-mm-dd</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Área Construida * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Número de Baños * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Estrato</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Garajes</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Número de Habitaciones * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Piso</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">Para apartamentos</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Pisos</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">Para Casas</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Localidad * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000"><i>Ver listado adjunto</i></font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Tipo de Inmueble * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Numero</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>1 Casa 2
  Apartamento</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Servicio Agua * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">'No existe' , 'Provisional' , 'Definitivo'</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Baño Servicio</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Barrio</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Chip</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Cocina * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">Si o No</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Descripción</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Dirección Inmueble * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Servicio Energía * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">'No existe' , 'Provisional' , 'Definitivo'</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Espacio Múltiple * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">Si o No</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Servicio Gas</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">'No existe' , 'Provisional' , 'Definitivo'</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Habitación Servicio</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Instalación Calentador</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Instalación Cocina</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Lavandería * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Matrícula Inmobiliaria</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Piso Cocina</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Piso Comedor</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Piso Habitaciones</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Piso Sala</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Servicio Teléfono</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">'No existe' , 'Provisional' , 'Definitivo'</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Tipo Vista</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Precio Venta * </td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Fecha Revision</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Fecha</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>aaaa-mm-dd</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Fecha Viabilizacion</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Fecha</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>aaaa-mm-dd</td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Barrio Legalizado</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Remocion Masa</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Reserva Vial</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Zona Proteccion Ambiental</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
 <tr height=16 valign=bottom style='height:12.0pt'>
  <td height=16 class=xl6329828 style='height:12.0pt;border-top:none'>Zona Riesgo</td>
  <td class=xl6329828 style='border-top:none;border-left:none'>Texto</td>
  <td class=xl6329828 style='border-top:none;border-left:none'><font
  color="#000000">&nbsp;</font></td>
 </tr>
</table>
	
	
	</div>
	
	<div id="instrucciones" style="float: left; width:40%; height:150px;">
		Instrucciones del archivo zip<br>
		<ul>
			<li>El archivo zip no debe contener carpetas</li>
			<li>El archivo zip debe contener un archivo llamado tabla.txt en donde relacione:
				<ul><li>El identificador del inmueble</li>
				<li>Imagen asociada al inmueble</li></ul>
				El archivo puede contener mas de una imagen por inmueble y hasta cinco imagenes
			</li>
			<li>Cada imagen debe tener un tamaño máximo de 200K</li>
		</ul>
	</div>
	
<div id="localidades" style="float: left; width:40%;">
	<table border=1 cellpadding=0 cellspacing=0 width=461 style='border-collapse:collapse;table-layout:fixed;'>
		<tr>
			<td width="100px">
				<b>Id. Localidad</b>
			</td>
			<td>
				<b>Localidad</b>
			</td>
		</tr>
		{foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
			<tr>
				<td>
					{$seqLocalidad}
				</td>
				<td>
					{$txtLocalidad}
				</td>
			</tr>
		{/foreach}		
	</table>
</div>