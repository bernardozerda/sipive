<script src="librerias/javascript/jquery-ui.js"></script>
<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
<link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
{literal}
    <style>
        .row{
            width: 100%;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
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
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
    {if $id != 5 && $id != 2}
        <div bgcolor="#E4E4E4" class="col-sm-1">
            <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=1', '', true);">
                <img src="recursos/imagenes/add.png" width="24px">
            </a>
        </div>
    {/if}
    <thead>
        <tr align="center">
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>          
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1}
                <th bgcolor="#E4E4E4" >Editar</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
                {if $id == 6}
                <th bgcolor="#E4E4E4" >Seguimiento</th>
                {/if}
        </tr>
    </thead>
    <tfoot>
        <tr align="center">
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Proyecto</b></th>           
            <th bgcolor="#E4E4E4" ><b>Oferente</b></th>
                {if $id != 1 }
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {else}
                <th bgcolor="#E4E4E4" >&nbsp;</th>
                {/if}
                {if $id == 6}
                <th bgcolor="#E4E4E4" >Seguimiento</th>
                {/if}
        </tr>
    </tfoot>
    {foreach from=$arrProyectos key=keyProyecto item=value}                    
        <tr>
            <td ><b>{$value.seqProyecto}</b>&nbsp;</td>
            <td nowrap>{$value.txtNombreProyecto|upper}</td>                       
            <td>{$value.oferente}</td>
            {if $id == 1}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=3&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}', '', true);">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
            {elseif $id == 2}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosFichaTecnica.php?tipo=2&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=2', '', true);">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="cursor: pointer"></span></a>
                </td>
            {elseif $id == 3}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosSeguimientoFicha.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=3&id=3', '', true);">
                        <img src="recursos/imagenes/record.png" width="24px"></a>
                </td>
            {elseif $id == 4}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosUnidades.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosUnidades.php?tipo=3&id=4', '', true);">
                        <span class="glyphicon glyphicon-level-up" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
            {elseif $id == 5}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosLiquidacion.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&tipo=3&id=5&page=datosProyecto.php?id=5', '', true);">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
            {elseif $id == 6}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosUnidades.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosUnidades.php?tipo=3&id=6', '', true);">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosUnidades.php?&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosUnidades.php&tipo=2&id=6', '', true);">
                        <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
            {else}
                <td width="5%" align="center"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosProyecto.php?tipo=2&seqProyecto={$value.seqProyecto}&seqPlanGobierno={$value.seqPlanGobierno}&page=datosProyecto.php?tipo=2', '', true);">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true" style="cursor: pointer; text-align: center"></span></a>
                </td>
            {/if}
        </tr>
    {/foreach}
</table>
