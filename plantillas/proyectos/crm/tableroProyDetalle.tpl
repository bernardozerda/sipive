<html lang="en">    <script src="librerias/javascript/jquery-ui.js"></script>
    <link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
    <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
    <link href="recursos/estilos/contentProyects.css" rel="stylesheet">
    <link href="./recursos/estilos/inputFile.css" rel="stylesheet" />
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
                width: 100% !important;
            }
            .panel-heading{
                min-height: 50px
            }
            .row {
                margin-right: 0 !important; 
                margin-left: 0 !important;
            }
        </style>
    {/literal}
    <br><br>
    <div class="panel panel-default" style="padding: 1%">
        <div class="panel-heading">
            <div class="col-lg-9 col-md-9" style="top: 10px">
                <h6 class="panel-title">  
                    {if $seqProyectoGrupo > 1}
                        SUBDIRECCIÓN DE RECURSOS PRIVADOS <b style="color: #800000">"{$nombrePadre|upper}"</b>
                    {else}
                        SUBDIRECCIÓN DE RECURSOS PÚBLICOS <b style="color: #800000">"{$nombrePadre|upper}"</b>
                    {/if}
                    &nbsp;&nbsp;</h6>
            </div>
            <div class="col-lg-3 col-md-3" style="text-align: right;">
                <button type="submit" class="pressed" style="width: 50%; background-color: #004080" name="enviar"   
                        onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?seqPryEstadoProceso={$seqPryEstadoProceso}&seqProyGrupo={$seqProyectoGrupo}', '', true);" onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?&seqProyGrupo={$seqProyectoGrupo}', '', true);" >
                    <span class ="glyphicon glyphicon-arrow-left" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>&nbsp; Volver</button>
            </div>
        </div>
        <div class="panel-body">  <br>

            <table id="estadoExp" class="table table-striped table-bordered" cellspacing="0" style="width: 98%">               
                <thead>
                    <tr>
                        <th class="title1"><div class="title1">ID</div></th>
                <th class="title1"> <div class="title1">PROYECTOS</div></th>
                <th class="title1"><div class="title1">CONSTRUCTORA</div></th>
                <th class="title1"><div class="title1">LOCALIDAD</div></th>
                <th class="title1"><div class="title1">COMPOSICION</div></th>
                <th class="title1"><div class="title1">UNIDADES</div></th>
                <th class="title1"><div class="title1">NO VINCULADAS</div></th>
                <th class="title1"><div class="title1">LEGALIZADAS</div></th>
                <th class="title1"><div class="title1">X LEGALIZAR</div></th>
                {*<td class="title1"><div class="title1">DETALLE</div></td>
                <td class="title1"><div class="title1">&nbsp;</div></td>*}
                </tr>
                </thead>

                {assign var="totalSoluciones" value="0"}
                {assign var="totalXVincular" value="0"}
                {assign var="totalCant" value="0"}
                {assign var="totalUnd" value="0"}
                {assign var="totalXLegalizar" value="0"}
                {foreach from=$arrDatosProy key=seqProyecto item=datoProy}   
                    {assign var="totalSoluciones" value=$totalSoluciones+$datoProy.unidades}
                    {assign var="totalSuma" value=$datoProy.vinculadas-$datoProy.legalizadas}
                    {assign var="totalXVincular" value=$totalXVincular+$datoProy.pendientes+$datoProy.postuladas}  
                    {assign var="totalLeg" value=$totalLeg+$datoProy.legalizadas}  
                    {assign var="totalXLegalizar" value=$totalXLegalizar+$totalSuma}
                    <tr>
                        <th >{$datoProy.seqProyecto} </th>
                        <td align="left"  ><b>{$datoProy.txtNombreProyecto|upper}</b></td>
                        <td align="left" style="font-size: 9px; ">{$datoProy.txtNombreConstructor|upper}</td>
                        <td align="left" >{$datoProy.txtLocalidad}</td>
                        <td align="center">{$datoProy.txtTipoFinanciacion}</td>
                        <td align="center">{$datoProy.unidades}</td>
                        <td align="center">{$datoProy.pendientes+$datoProy.postuladas}</td>
                        <td align="center">{$datoProy.legalizadas} </td>
                        <td align="center">{$datoProy.vinculadas-$datoProy.legalizadas}</td>
                        {*  <td align="center">
                        <a href="#"
                        onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosFichaTecnica.php?tipo=2&seqProyecto={$txtEstadoProceso.seqProyecto}&seqPlanGobierno={$txtEstadoProceso.seqPlanGobierno}&seqPryEstadoProceso={$seqPryEstadoProceso}', '', true);" >
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </a></td>
                        <td align="center">
                        {if $txtEstadoProceso.cantHijos > 0}
                        <a href="#"
                        onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresProyectos.php?tipo=2&seqProyecto={$txtEstadoProceso.seqProyecto}&seqPlanGobierno={$txtEstadoProceso.seqPlanGobierno}&seqPryEstadoProceso={$seqPryEstadoProceso}', '', true);" >
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        </a>
                        {/if}
                        </td>*}

                    </tr>
                {/foreach}
                <tfoot>
                    <tr style="text-align: center; font-weight: bold; font-size: 12px">
                        <td colspan="5">TOTAL</td>
                        <td>{$totalSoluciones}</td>
                        <td>{$totalXVincular}</td>
                        <td>{$totalLeg}</td>
                        <td>{$totalXLegalizar}</td>
                        {*  <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
    
                        </tfoot>*}
            </table>
        </div>
    </div>
