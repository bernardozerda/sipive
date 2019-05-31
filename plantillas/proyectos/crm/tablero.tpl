<html lang="en">
    <head>     
        <link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 
        <link href="./recursos/estilos/inputFile.css" rel="stylesheet" />
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
            .panel-heading{
                min-height: 50px
            }
            .row{
                width: 100% !important;
            }
        </style>
    {/literal}
    <br><br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-lg-9 col-md-9" style="top: 10px">
                <h6 class="panel-title">ESTADO DE LOS PROYECTOS 
                    {if $seqProyectoGrupo > 1}
                        SUBDIRECCIÓN DE RECURSOS PRIVADOS
                    {else}
                        SUBDIRECCIÓN DE RECURSOS PÚBLICOS
                    {/if}
                    &nbsp;&nbsp;</h6>
            </div>
            <div class="col-lg-3 col-md-3" style="text-align: right;">
                <button type="submit" class="pressed" style="width: 50%; background-color: #004080" name="enviar"   
                        onclick="location.reload(true)" >
                    <span class ="glyphicon glyphicon-arrow-left" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>&nbsp; Volver</button>
            </div>

        </div>
        <div class="panel-body" style="text-align: center">
            <table id="example" class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <td class="title1">ID</td>
                        <td class="title1">ESTADO</td>
                        <td class="title1"># DE PROYECTOS</td>
                        <td class="title1">UNIDADES DE VIVIENDA VIP CON SDVE</td>
                        <td class="title1">DETALLE</td>
                    </tr>
                </thead>

                {assign var="totalCant" value="0"}
                {assign var="totalUnd" value="0"}
                {foreach from=$arrProyTableroPal key=seqEstadoProceso item=txtEstadoProceso}      
                    {assign var="totalCant" value=$totalCant+$txtEstadoProceso.cantidad}
                    {assign var="totalUnd" value=$totalUnd+$txtEstadoProceso.unidades}
                    <tr>      
                        <td align="center" >{$txtEstadoProceso.seqPryEstadoProceso}</td>
                        <th >{$txtEstadoProceso.txtPryEstadoProceso} </th>
                        <td align="center" >{$txtEstadoProceso.cantidad}</td>
                        <td align="center" >{$txtEstadoProceso.unidades}</td>
                        <td align="center"> 
                            <a href="#"
                               onclick="cargarContenido('contenido', './contenidos/proyectos/crm/indicadoresEstado.php?seqPryEstadoProceso={$txtEstadoProceso.seqPryEstadoProceso}&seqProyGrupo={$seqProyectoGrupo}', '', true);" >
                                <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
                            </a></td>
                    </tr>
                {/foreach}
                <tfoot>
                    <tr style="text-align: center; font-weight: bold; font-size: 12px">
                        <td >&nbsp;</td>
                        <td>TOTAL</td>
                        <td>{$totalCant}</td>
                        <td>{$totalUnd}</td>
                        <td >&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</html>