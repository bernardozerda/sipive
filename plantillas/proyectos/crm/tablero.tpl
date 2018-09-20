<html lang="en">
    <head>

        <script src="librerias/javascript/jquery-ui.js"></script>
        <link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
        <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
    </head>
    {literal}
        <style>
            .title1{
                background: #008FA6; 
                color: #FFF;               
                padding: 2%;
                /*text-align: center;*/
                font-weight: bold;
            }
        </style>
    {/literal}
    <body>
        <table id="estadoExp" class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <td class="title1">ID</td>
                    <td class="title1">ESTADO</td>
                    <td class="title1"># DE PROYECTOS</td>
                    <td class="title1">UNIDADES DE VIVIENDA VIP CON SDVE</td>
                </tr>
            </thead>

            {assign var="totalCant" value="0"}
            {assign var="totalUnd" value="0"}
            {foreach from=$arrProyTableroPal key=seqEstadoProceso item=txtEstadoProceso}      
                {assign var="totalCant" value=$totalCant+$txtEstadoProceso.cantidad}
                {assign var="totalUnd" value=$totalUnd+$txtEstadoProceso.unidades}
                <tr>      
                    <td align="center" >{$txtEstadoProceso.seqPryEstadoProceso}</td>
                    <th style="cursor:pointer; cursor: hand" onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?seqPryEstadoProceso={$txtEstadoProceso.seqPryEstadoProceso}', '', true);">{$txtEstadoProceso.txtPryEstadoProceso} </th>
                    <td align="center" >{$txtEstadoProceso.cantidad}</td>
                    <td align="center" >{$txtEstadoProceso.unidades}</td>
                </tr>
            {/foreach}
            <tfoot>
                <tr style="text-align: center; font-weight: bold; font-size: 12px">
                    <td colspan="2">TOTAL</td>
                    <td>{$totalCant}</td>
                    <td>{$totalUnd}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>