{php}
    date_default_timezone_set("America/Bogota");
    setlocale(LC_TIME , 'spanish' );
{/php}

<div style="padding:5px;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
            <td width="130px"><b>Nombre del Cruce</b></td>
            <td>
                {$arrCruce.nombre|upper} 
                [ <a href="#" onClick="mostrarOcultar('detalleCruce');">Ver Detalles</a> ]
            </td>
        </tr>
        <tr>
            <td width="130px"><b>Fecha del Cruce</b></td>
            <td>
                {$arrCruce.creacion|date_format|upper}
            </td>
        </tr>
		<tr>
            <td width="130px"><b>Fecha Actualizaci&oacute;n</b></td>
            <td>
                {$arrCruce.fecha|date_format|upper}
            </td>
        </tr>
        <tr>
            <td><b>Firma de la carta</b></td>
            <td>{$arrCruce.firma|upper}</td>
        </tr>
        <tr>
            <td><b>Elaboraci&oacute;n</b></td>
            <td>{$arrCruce.elaboro|upper}</td>
        </tr>
        <tr>
            <td><b>Revisi&oacute;n</b></td>
            <td>{$arrCruce.reviso|upper}</td>
        </tr>
    </table>
    <div id="detalleCruce" style="display: none">
        <table border="0" cellpadding="2" cellspacing="0" width="100%" >
            <tr>
                <td valign="top" width="130px"><b>Cuerpo de la carta</b></td>
                <td valign="top" align="justify" style="padding:5px;">{$arrCruce.cuerpo}</td>
            </tr>
            <tr>
                <td valign="top"><b>Pie de la carta</b></td>
                <td align="justify" style="padding:5px;">{$arrCruce.pie}</td>
            </tr>
        </table>
    </div>
</div>
<div>
    {include file="cruces/listosCruce.tpl"}
</div>


