<script src="librerias/javascript/jquery-ui.js"></script>
<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
<link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
    <div bgcolor="#E4E4E4" class="col-sm-1">
        <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=1', '', true);">
            <img src="recursos/imagenes/add.png" width="24px">
        </a>
    </div>
    <thead>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>          
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id ----{$id}</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>           
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
        </tr>
    </tfoot>
    {foreach from=$arrProyectos key=keyProyecto item=value}                    
        <tr>
            <td  align="center"><b>{$value.seqProyecto}</b>&nbsp;</td>
            <td nowrap>{$value.txtNombreProyecto|upper}</td>                       
            <td >{$value.oferente}</td>
            {if $id == 1}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=3&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}', '', true);">
                        <img src="recursos/imagenes/Show.png" width="24px"></a>
                </td>
            {elseif $id == 2}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosFichaTecnica.php?tipo=2&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=2', '', true);">
                        <img src="recursos/imagenes/report.png" width="24px"></a>
                </td>
            {elseif $id == 3}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=3&id=3', '', true);">
                        <img src="recursos/imagenes/record.png" width="24px"></a>
                </td>
            {elseif $id == 4}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosUnidades.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosUnidades.php?tipo=3&id=4', '', true);">
                        <img src="recursos/imagenes/unity.png" width="24px"></a>
                </td>
            {elseif $id == 5}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosLiquidacion.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosLiquidacion.php?tipo=3&id=5', '', true);">
                        <img src="recursos/imagenes/liquidate.png" width="24px"></a>
                </td>
            {elseif $id == 6}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosUnidades.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosUnidades.php?tipo=3&id=6', '', true);">
                        <img src="recursos/imagenes/unity.png" width="24px"></a>
                </td>
            {else}
                <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=2&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=2', '', true);">
                        <img src="recursos/imagenes/list.png" width="24px"></a>
                </td>
            {/if}
        </tr>
    {/foreach}
</table>
