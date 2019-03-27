
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
        {literal}
            <style>
                .row{
                    width: 100%;
                }
                .tablero>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
                {
                    padding: 5px;
                }
                .dataTables_scrollHeadInner{
                    width: 100% !important;
                }
                div.dataTables_scrollHead table.table-bordered{
                    width: 100% !important;
                }

                .dataTables_scrollFootInner{
                    width: 100% !important;
                }       
                div.dataTables_scrollFoot table{
                    width: 100% !important;
                }
                .col-sm-1{
                    right: 10%;
                }
            </style>

        {/literal}

    </head>
    <body onload="tablas()">

        <div id="accordion" style="width: 85%">
            <h3>Información General de Proyectos </h3>
            <div>
                <p>
                    {foreach from=$arrGroupProyecto key=seqProyectos item=datos}
                    <table class="tablero" cellspacing="0" width="85%" >

                        <tr>
                            <th bgcolor="#008FA6" style="font-weight: bold; color: #fff"><b>Procesos</b> </th>                
                            <th bgcolor="#E4E4E4" style="text-align: center; font-weight: bold"><b>TOTAL</b></th>
                        </tr>
                        {assign var="totalCon" value=0}
                        {assign var="totalSin" value=0}
                        {foreach from=$arrEstados key=seqEstado item=txtEstado}
                            {assign var="nombreEstado" value=$txtEstado}
                            {assign var="txtEstado" value=$txtEstado|replace:" ":""}
                            {assign var="txtEstado" value=$txtEstado|replace:"ó":"o"}
                            {assign var="txtEstado" value=$txtEstado|replace:"í":"i"}
                            {assign var="txtEstado" value=$txtEstado|replace:"é":"e"}
                            {assign var="txtEstadoVal" value=$txtEstado|replace:$txtEstado:"val$txtEstado"}

                            {assign var="totalNoProy" value=0 scope="global"}
                        {if $seqEstado == 26}{if $arraNoProyectos[$seqEstado].cantSin != "" || $arraNoProyectos[28].cantSin != "" }{assign var="totalNoProy" value=$arraNoProyectos[$seqEstado].cantSin+$arraNoProyectos[28].cantSin}{/if}
                        {elseif $seqEstado == 62}
                            {if $arraNoProyectos[$seqEstado].cantSin != "" || $arraNoProyectos[19].cantSin != "" }
                                {assign var="totalNoProy" value=$arraNoProyectos[$seqEstado].cantSin+$arraNoProyectos[19].cantSin}
                            {/if}
                        {elseif $seqEstado == 29}
                            {if $arraNoProyectos[$seqEstado].cantSin != "" || $arraNoProyectos[30].cantSin != "" || $arraNoProyectos[32].cantSin != "" }                                    
                                {assign var="totalNoProy" value=$arraNoProyectos[$seqEstado].cantSin+$arraNoProyectos[30].cantSin+$arraNoProyectos[32].cantSin}
                            {/if}
                        {else}
                            {if $arraNoProyectos[$seqEstado].cantSin != ""}                                
                                {assign var="totalNoProy" value=$arraNoProyectos[$seqEstado].cantSin}
                            {/if}
                        {/if}
                        {assign var="totalCon" value=$totalCon+$datos.$txtEstadoVal}
                        {assign var="totalSin" value=$totalSin+$totalNoProy}
                        <tr>
                            <th>{$nombreEstado}</th>                            
                           
                            <td align="center"><div class="grey" style="cursor:pointer; cursor: hand" onclick="exportarExcel({$seqEstado}, '', 1, 'reporteTableroExcelNo')">{$totalNoProy}</div></td>
                           
                        </tr>

                    {/foreach}   
                    <tr>
                        <th bgcolor="#008FA6" style="text-align: center; font-weight: bold; color: #fff">Total</th>                       
                        <th bgcolor="#008FA6" style="text-align: center; font-weight: bold; color: #fff">{$totalSin}</th>
                      </th>
                    </tr>
                </table>
            {/foreach} 
            </p>
        </div>       
    </div>

</body>

</html>
