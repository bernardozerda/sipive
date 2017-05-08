{php}
    date_default_timezone_set("America/Bogota");
    setlocale(LC_TIME , 'spanish' );
{/php}
<div style="padding:5px;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
            <td width="80px"><b>Proyecto</b></td>
            <td>{$arrProyecto.nombre|upper}</td>
        </tr>
        <tr>
            <td width="80px"><b>Oferente</b></td>
            <td>{$arrProyecto.oferente|upper}</td>
        </tr>
		<tr>
            <td width="80px"><b>Soluciones</b></td>
            <td>{$arrProyecto.soluciones}</td>
        </tr>
    </table>
</div>
<div>
	{include file="unidadProyecto/listosUnidad.tpl"}
</div>