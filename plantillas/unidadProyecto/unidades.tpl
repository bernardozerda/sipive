{php}
		date_default_timezone_set("America/Bogota");
		setlocale(LC_TIME , 'spanish' );
{/php}

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="630px">
	<tr>
		<!-- LISTADO DE PROYECTOS -->
		<td width="150px" valign="top" style="padding-right:5px; border-right: 1px dotted #999999;">
			<div style="padding:5px; border-bottom: 1px dotted #999999;">
				<strong>Listado de Proyectos</strong>
			</div>
			<div style="padding:5px; height:94%; overflow:auto;">
				{foreach from=$arrProyectos key=seqProyecto item=arrInfo}
					<li style="cursor: pointer; padding-bottom: 2px; border-bottom: 1px dotted #999999;"
						onMouseOver="this.style.background='#e4e4e4';"
						onMouseOut="this.style.background='#f9f9f9';"
						onClick="cargarContenido('listado','./contenidos/unidadProyecto/leerUnidad.php','seqProyecto={$seqProyecto}',true);" >
						{$arrInfo.nombre|upper}
					</li>
				{/foreach}
			</div>
		</td>
		<!-- FORMULARIO DE PROYECTOS -->
		<td valign="top">
			<div style="padding-top:0px; padding-left: 10px" id="estados">
				<div style="padding:5px;">
					<button onclick="exportarUnidadesProyectoExcel( 'undListadoListos' );" style="width:70px;">
						<img src="./recursos/imagenes/excel.gif" width="25px" height="25px"><br>
						<span style="font-size: 10px; font-weight: bold;">Exportar<br>a Excel</span>
					</button>
					<button onClick="cargarUnidadesProyecto();"	style="width:70px;">
						<img src="./recursos/imagenes/subir.png" width="25x" height="25px"><br>
						<span style="font-size: 10px; font-weight: bold;">Cargar<br>Unidades</span>
					</button>
				</div>
			</div>
			<div style="padding:5px; height:460px; overflow:auto;" id="listado">
				{include file="unidadProyecto/listosUnidad.tpl"}
			</div>
		</td>
	</tr>
</table>

<div id="dlgCargaUnidades" class="yui-pe-content" hidden>
	<div class="hd">Formulario para carga de unidades</div>
	<div class="bd">
		<form method="POST" 
			action="./contenidos/unidadProyecto/salvarUnidades.php" 
			enctype="multipart/form-data"
			id="frmCargaUnidades"
			onSubmit="return false;" >
			<table border="0" cellpadding="3" cellspacing="0" width="100%">
				<!-- ARCHIVO DE UNIDADES -->
				<tr><td><label for="archivo"><b>Archivo de Unidades:</b></label></td>
					<td><input type="file" name="archivo"></td>
				</tr>
			</table>
		</form>
	</div>
</div>