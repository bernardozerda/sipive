
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Accordion - Default functionality</title>
        <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">       
         <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
        <script src="librerias/javascript/jquery-ui.js"></script>
        <link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
        <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 


    </head>
    <body onload="tablas()">
        <div>
            <p>
            <table class="table table-striped table-bordered" style="width: 85%; text-align: center">
                <tr>
                    <th>Unidades y Hogares Vinculados</th>
                    <th>Total Unidades</th>
                    <th>Pendiente por Vincular</th>
                    <th>Postulación</th>
                    <th>Vinculadas</th>
                    <th>Total Legalizadas</th>
                    <th>Proceso Legalización</th>
                    <th>Devolución Expedientes</th>
                    <th>Pendientes Por legalizar</th>
                </tr>
                <tr >
                    <th><h6 style="font-weight: bolder;text-align: center">Total Proyectos</h6></th>
                <td><h4 style="font-weight: bolder">{$totalUnidades}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalUnidades-$totalPostuladas-$totalVinculadas}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalPostuladas}
                        <img src="recursos/imagenes/excel-48.png" style="cursor: pointer; cursor: hand; "width="18" onclick="exportarExcel(47, '', 0)"/></h4></td>
                <td><h4 style="font-weight: bolder">{$totalVinculadas}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalLegalizadas}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalProcesoLeg}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalDevExpedientes}</h4></td>
                <td><h4 style="font-weight: bolder">{$totalVinculadas-$totalLegalizadas-$totalProcesoLeg}</h4></td>
                </tr>
            </table>
        </p>
    </div>
    <div id="accordion" style="width: 85%">
        <h3>Información General de Proyectos </h3>
        <div>
            <p>
                {foreach from=$arrGroupProyecto key=seqProyectos item=datos}
                <table class="tablero"  width="100%">
                    <tr>
                        <th style="background: #008FA6; color: #FFF; ">&nbsp;&nbsp;&nbsp;Procesos</th>
                        <th style="width: 10%; padding-left:3%; padding-right:3%"><img src="recursos/imagenes/Green.png" width="30px"></th>
                        <th style="width: 10%; padding-left: 3%; padding-right:3%"><img src="recursos/imagenes/Yellow.png" width="30px"></th>
                        <th style="width: 10%; padding-left: 3%; padding-right:3%"><img src="recursos/imagenes/Red.png" width="30px"></th>
                        <th  style="width: 10%; padding-left: 3%; padding-right:3%"><h4><b>Total</b></h4></th>
                    </tr>
                    {foreach from=$arrEstados key=seqEstado item=txtEstado}
                        {assign var="nombreEstado" value=$txtEstado}
                        {assign var="txtEstado" value=$txtEstado|replace:" ":""}
                        {assign var="txtEstado" value=$txtEstado|replace:"ó":"o"}
                        {assign var="txtEstado" value=$txtEstado|replace:"í":"i"}
                        {assign var="txtEstado" value=$txtEstado|replace:"é":"e"}
                        {assign var="txtEstadoVal" value=$txtEstado|replace:$txtEstado:"val$txtEstado"}
                        {assign var="txtEstadoV" value=$txtEstado|replace:$txtEstado:"v$txtEstado"}
                        {assign var="txtEstadoA" value=$txtEstado|replace:$txtEstado:"a$txtEstado"}
                        {assign var="txtEstadoR" value=$txtEstado|replace:$txtEstado:"r$txtEstado"}
                        <tr>
                            <th>{$nombreEstado} </th>
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="verde" onclick="exportarExcel({$seqEstado}, '', 1, 'reporteTableroExcel')">{$datos.$txtEstadoV}</div></td>
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="amarillo" onclick="exportarExcel({$seqEstado}, '', 2, 'reporteTableroExcel')">{$datos.$txtEstadoA}</div></td>
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="rojo"  onclick="exportarExcel({$seqEstado}, '', 3, 'reporteTableroExcel')">{$datos.$txtEstadoR}</div></td>
                            <td align="center"><h4 style="font-weight: bolder;">{$datos.$txtEstadoVal}</h4></td>
                        </tr>
                    {/foreach}   
                </table>
            {/foreach} 
            </p>
        </div>
        <h3>Información especifica por Proyecto</h3>
        <div>
            <p>
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                <thead>
                    <tr>
                        <th>Proyecto</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Proyecto</th>
                    </tr>
                </tfoot>

                {foreach from=$arrProyecto key=seqProyecto item=dato}  
                    {assign var="totalVal" value="0"}
                    <tr>
                        <td>
                            <table class="tablero " width="100%">
                                <tr>
                                    <th>
                                <div style="background: #008FA6; color: #FFF; width: 100%; padding: 2%">{$dato.seqProyecto} - {$dato.txtNombreProyecto} </div>
                                <th style="width: 10%; padding: 3%"><img src="recursos/imagenes/Green.png" width="30px"></th>
                                <th style="width: 10%; padding: 3%"><img src="recursos/imagenes/Yellow.png" width="30px"></th>
                                <th style="width: 10%; padding: 3%"><img src="recursos/imagenes/Red.png" width="30px"></th>
                                <th><h4><b>Total</b></h4></th>
                    </tr>
                    {foreach from=$arrEstados key=seqEstado item=txtEstado}
                        <tr>
                            <th>{$txtEstado} </th>                              
                                {assign var="txtEstado" value=$txtEstado|replace:" ":""}
                                {assign var="txtEstado" value=$txtEstado|replace:"ó":"o"}
                                {assign var="txtEstado" value=$txtEstado|replace:"í":"i"}
                                {assign var="txtEstado" value=$txtEstado|replace:"é":"e"}
                                {assign var="txtEstadoVal" value=$txtEstado|replace:$txtEstado:"val$txtEstado"}
                                {assign var="txtEstadoV" value=$txtEstado|replace:$txtEstado:"v$txtEstado"}
                                {assign var="txtEstadoA" value=$txtEstado|replace:$txtEstado:"a$txtEstado"}
                                {assign var="txtEstadoR" value=$txtEstado|replace:$txtEstado:"r$txtEstado"}
                                {assign var="totalVal" value=$totalVal+$dato.$txtEstadoVal}
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="verde" onclick="exportarExcel({$seqEstado}, {$dato.seqProyecto}, 1, 'reporteTableroExcel')">{$dato.$txtEstadoV}</div></td>
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="amarillo" onclick="exportarExcel({$seqEstado}, {$dato.seqProyecto}, 2, 'reporteTableroExcel')">{$dato.$txtEstadoA}</div></td>
                            <td align="center" style="cursor:pointer; cursor: hand"><div class="rojo"  onclick="exportarExcel({$seqEstado}, {$dato.seqProyecto}, 3, 'reporteTableroExcel')">{$dato.$txtEstadoR}</div></td>
                            <td align="center"><h4 style="font-weight: bolder">{$dato.$txtEstadoVal}</h4></td> 
                            {/foreach} 
                    </tr>
                    <tr>
                        <td>

                        </td>
                    </tr>
                </table>
                <div style="width: 100%; text-align: center;">
                    <table class="table table-striped table-bordered" width="100%" border='1'  style="border: 1px #7F7F7F">
                        <tr >
                            <th >Total Unidades</th>
                            <th>Pendiente por Vincular</th>
                            <th>Postulación</th>
                            <th>Vinculadas</th>
                            <th>Legalizadas</th>
                            <th>Proceso <br> Legalización</th>
                            <th>Devolución</th>
                            <th>Pendientes Por <br>Legalizar </th>
                        </tr>
                        <tr style="text-align: center;">
                            {assign var="pendLegXProy" value=0}
                            <td>                                           
                                {foreach name=outer1 item=contact1 from=$totalUnidadesXProy}
                                    {if $dato.seqProyecto == $contact1.seqProyecto}   
                                        {foreach key=key1 item=item1 from=$contact1}
                                            {if $key1 == 'cant'}  
                                                {$item1} <br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;
                            </td>
                            <td>
                                {foreach name=outer item=contact from=$totalPorVincularXProy}
                                    {if $dato.seqProyecto == $contact.seqProyecto}   
                                        {foreach key=key item=item from=$contact}
                                            {if $key == 'cant'}  
                                                {$item} <br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;

                            </td>
                            <td>
                                {foreach name=outer2 item=contact2 from=$totalPostuladasXProy}
                                    {if $dato.seqProyecto == $contact2.seqProyecto}   
                                        {foreach key=key2 item=item2 from=$contact2}
                                            {if $key2 == 'cant'}  

                                                {$item2}<br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;
                            </td>
                            <td>
                                {foreach name=outer3 item=contact3 from=$totalVinculadasXProy}
                                    {if $dato.seqProyecto == $contact3.seqProyecto}   
                                        {foreach key=key3 item=item3 from=$contact3}
                                            {if $key3 == 'cant'}
                                                {assign var="pendLegXProy" value=$item3}
                                                {$item3}<br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;
                            </td>
                            <td>
                                {foreach name=outer4 item=contact4 from=$totalLegalizadasXProy}
                                    {if $dato.seqProyecto == $contact4.seqProyecto}   
                                        {foreach key=key4 item=item4 from=$contact4}
                                            {if $key4 == 'cant'}  
                                                {assign var="pendLegXProy" value=$pendLegXProy-$item4}
                                                {$item4}<br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;
                            </td>
                            <td>{$totalVal}</td>
                            <td>
                                {foreach name=outer5 item=contact5 from=$totalDevExpedientesXProy}
                                    {if $dato.seqProyecto == $contact5.seqProyecto}   
                                        {foreach key=key5 item=item5 from=$contact5}
                                            {if $key5 == 'cant'}  

                                                {$item5}  <br>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                &nbsp;
                            </td>
                            <td>{$pendLegXProy-$totalVal}</td>
                        </tr>
                    </table>
                </div>
                </td>
                </tr> 
            {/foreach}
            </table>
            </p>
        </div>
    </div>
</body>
</html>
