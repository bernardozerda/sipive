<html lang="en">    <script src="librerias/javascript/jquery-ui.js"></script>
    <link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
    <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
    <link href="recursos/estilos/contentProyects.css" rel="stylesheet">
    {literal}
        <style>
            .row{
                width: 100% !important;
            }
            .col-sm-12{
                width: 100% !important;
            }
            .title1{
                background: #008FA6; 
                color: #FFF;               
                padding: 2%;
                /*text-align: center;*/
                font-weight: bold;
            }
            #estadoExp_wrapper{
                width: 104% !important;
            }
        </style>
    {/literal}

    <table id="estadoExp" class="table table-striped table-bordered" cellspacing="0" style="width: 104%">
        <div bgcolor="#E4E4E4" class="col-sm-2" style="z-index: 100; float: right; top: 10px">
            <input type="button" name="btn_volver" id="btn_volver" value="Volver" 
                   onclick="cargarContenido('bodyHtml', './index.php', 'proyecto=6', true);" class="btn_volver"/> 
        </div>
        <thead>
            <tr>
                <th class="title1"><div class="title1">ID</div></th>
    <th class="title1"> <div class="title1">PROYECTOS</div></th>
<th class="title1"><div class="title1">CONSTRUCTORA</div></th>
<th class="title1"><div class="title1">LOCALIDAD</div></th>
<th class="title1"><div class="title1">COMPOSICION</div></th>
<th class="title1"><div class="title1">UNIDADES</div></th>
<th class="title1"><div class="title1">X VINCULAR</div></th>
<th class="title1"><div class="title1">LEGALIZADAS</div></th>
<th class="title1"><div class="title1">X LEGALIZAR</div></th>
</tr>
</thead>

{assign var="totalSoluciones" value="0"}
{assign var="totalXVincular" value="0"}
{assign var="totalCant" value="0"}
{assign var="totalUnd" value="0"}
{assign var="totalXLegalizar" value="0"}
{foreach from=$arrProyTableroPal key=seqEstadoProceso item=txtEstadoProceso}   
    {assign var="totalSoluciones" value=$totalSoluciones+$txtEstadoProceso.unidades}
    {assign var="totalSuma" value=$txtEstadoProceso.vinculadas-$txtEstadoProceso.undLegalizadadas}
    {assign var="totalXVincular" value=$totalXVincular+$txtEstadoProceso.pendientes}  
    {assign var="totalLeg" value=$totalLeg+$txtEstadoProceso.undLegalizadadas}  
    {assign var="totalXLegalizar" value=$totalXLegalizar+$totalSuma}
    <tr>
        <th >{$txtEstadoProceso.seqProyecto} </th>
        <td align="center"  style="font-size: 9px;cursor:pointer; cursor: hand" 
            onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosFichaTecnica.php?tipo=2&seqProyecto={$txtEstadoProceso.seqProyecto}&seqPlanGobierno={$txtEstadoProceso.seqPlanGobierno}&seqPryEstadoProceso={$seqPryEstadoProceso}', '', true);">{$txtEstadoProceso.txtNombreProyecto}</td>
        <td align="center" style="font-size: 9px; ">{$txtEstadoProceso.constructor}</td>
        <td align="center">{$txtEstadoProceso.txtLocalidad}</td>
        <td align="center">{$txtEstadoProceso.txtTipoFinanciacion}</td>
        <td align="center">{$txtEstadoProceso.unidades}</td>
        <td align="center">{$txtEstadoProceso.pendientes}</td>
        <td align="center">{$txtEstadoProceso.undLegalizadadas} </td>
        <td align="center">{$txtEstadoProceso.vinculadas-$txtEstadoProceso.undLegalizadadas}</td>
    </tr>
{/foreach}
<tfoot>
    <tr style="text-align: center; font-weight: bold; font-size: 12px">
        <td colspan="5">TOTAL</td>
        <td>{$totalSoluciones}</td>
        <td>{$totalXVincular}</td>
        <td>{$totalLeg}</td>
        <td>{$totalXLegalizar}</td>
    </tr>
 <!--   <tr>
        <th class="title1"><div class="title1">ID</div></th>
<th class="title1"> <div class="title1">PROYECTOS</div></th>
<th class="title1"><div class="title1">CONSTRUCTORA</div></th>
<th class="title1"><div class="title1">LOCALIDAD</div></th>
<th class="title1"><div class="title1">COMPOSICION</div></th>
<th class="title1"><div class="title1">UNIDADES</div></th>
<th class="title1"><div class="title1">X VINCULAR</div></th>
<th class="title1"><div class="title1">A LEGALIZAR</div></th>
<th class="title1"><div class="title1">X LEGALIZAR</div></th>
</tr>
</tfoot>-->
</table>

