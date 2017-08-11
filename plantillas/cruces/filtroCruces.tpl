<!-- PAGINADOR -->
<div class="control-group">
	<div class="col-sm-9 col-sm-offset-3">
		<nav aria-label="Paginacion">
			<ul id="paginadorCruces" class="pagination">
				<li onClick="paginadorCruces('anterior')"
					id="anterior"
				>
					<a href="#" aria-label="Anterior">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
				{math equation="x + 1" x=$numPaginaFinal assign=numFinalIteracion}
				{math equation="x - y" x=$numPaginaInicial y=$numPaginador assign=numInicioIteracion}
				{section name=paginas loop=$numFinalIteracion start=$numPaginaInicial}
                    {if $numPaginaInicial > $numPaginador}
                        {if $smarty.section.paginas.first}
							<li onClick="paginadorCruces({$numInicioIteracion})"><a href="#">...</a></li>
                        {/if}
                    {/if}
					<li class="{if $smarty.section.paginas.index == $numPaginaActiva}active{/if}"
						onClick="paginadorCruces({$smarty.section.paginas.index})"
						id="{$smarty.section.paginas.index}"
					>
						<a href="#">{$smarty.section.paginas.index}</a>
					</li>
					{if $numFinalIteracion < $numTotalPaginas}
						{if $smarty.section.paginas.last}
							<li onClick="paginadorCruces({$numFinalIteracion})"><a href="#">...</a></li>
						{/if}
					{/if}
				{/section}
				<li onClick="paginadorCruces('siguiente')"
					id="siguiente"
				>
					<a href="#" aria-label="Siguiente">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
			</ul>
		</nav>
		<input type="hidden" id="txtCampoOrden" value="{$txtCampoOrden}">
		<input type="hidden" id="txtDireccionOrden" value="{$txtDireccionOrden}">
	</div>
</div>

<!-- ESTADO DE LOS REGISTROS -->
<div class="control-group">
	<div class="col-sm-8 col-sm-offset-4">
		{math equation="x + 1" x=$numOffSet    assign=numDesde}
		{math equation="x + 1" x=$numRegistros assign=numHasta}
		Mostrando registros desde el {$numDesde} hasta {$numHasta} de un total de {$arrCruces|@count}
	</div>
</div>

<!-- RESULTADOS DE LA CONSULTA -->
<div class="control-group">
	<div class="col-sm-11 col-sm-offset-1">
		<table width="100%" cellpadding="5" cellspacing="0">
			<tr>
				<td class="tituloTabla"
					style="cursor: hand;"
					onclick="paginadorCruces('orden','nombre');"
				>
					Nombre del Cruce
					{if $txtCampoOrden == "nombre"}
						{if $txtDireccionOrden == "asc"}
							<img src="./recursos/imagenes/up.png" width="10px" height="10px">
						{else}
							<img src="./recursos/imagenes/down.png" width="10px" height="10px">
						{/if}
					{/if}
				</td>
				<td class="tituloTabla"
					style="cursor: hand;"
					onclick="paginadorCruces('orden','fecha');"
					width="120px"
				>
					Fecha Creación
                    {if $txtCampoOrden == "fecha"}
                        {if $txtDireccionOrden == "asc"}
							<img src="./recursos/imagenes/up.png" width="10px" height="10px">
                        {else}
							<img src="./recursos/imagenes/down.png" width="10px" height="10px">
                        {/if}
                    {/if}
				</td>
				<td width="15px" class="tituloTabla">&nbsp;</td>
			</tr>
            {foreach name=listadoCruces from=$arrCruces key=seqCruce item=arrDatos}
                {if $smarty.foreach.listadoCruces.index >= $numOffSet && $smarty.foreach.listadoCruces.index <= $numRegistros}
					<tr style="cursor: hand;"
						onMouseOver="this.style.backgroundColor='#E5E5E5'"
						onMouseOut="this.style.backgroundColor='#F9F9F9'"
						onClick="cargarContenido(
						    'verCruces',
							'./contenidos/cruces/leerCruce.php',
							'seqCruce={$seqCruce}',
							true
						);"
					>
						<td style="padding-left:10px;">{$arrDatos.txtNombre}</td>
						<td style="padding-left:10px;">{$arrDatos.fchCreacionCruce}</td>
						<td align="center"><img src="./recursos/imagenes/modify.png" width="10px" height="10px"></img></td>
					</tr>
                {/if}
            {/foreach}
		</table>
	</div>
</div>