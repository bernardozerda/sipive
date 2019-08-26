&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
      >
{literal}
    <style>
        .row{
            padding: 0;
            margin: 0;
            width: 100% !important;
        }
    </style>
{/literal}
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Lista de Informes de Legalización Mi Casa Ya!</h6>
    </div>
    <div class="panel-body">
        <div id="mensajes"></div>
        <table id="example"  class="table table-striped table-hover" width="100%" data-order="[[ 1, &quot;asc&quot; ]]">
            <thead>
                <tr>
                    <th class="col-sm-2">Consecutivo</th>
                    <th class="col-sm-3">Fecha Autorización</th>
                    <th class="col-sm-2">N° Hogares</th>
                    <th class="col-sm-3">Valor</th>
                    <th class="col-sm-2">Detalles</th>
                    <th class="col-sm-2">Archivo</th>
                        {if isset($smarty.session.arrGrupos.6.20)}
                        <th class="col-sm-2">Eliminar</th>  
                        {/if}
                </tr>
            </thead>
            {foreach from=$listaReportes item=arrDatos}
                {assign var=fecha value=$arrDatos.fchCreacion} 

                <tr>
                    <td class="col-sm-2">
                        {$arrDatos.txtConsecutivo}
                    </td>
                    <td class="col-sm-3">
                        {$arrDatos.fchOrden}
                    </td>
                    <td class="col-sm-2">
                        {$arrDatos.Cantidad}
                    </td>
                    <td class="col-sm-3" nowrap>
                        <b>$</b>{$arrDatos.valor|number_format:0:',':'.'}
                    </td>
                    <td class="col-sm-2" nowrap>
                        <span class="btn btn-default btn-sm" >
                            <a href="contenidos/legalizacionMCY/detalles.php?fchCreacion={$arrDatos.fchCreacion}">
                                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                        </span>
                    </td>
                    <td class="col-sm-2">
                        <span class="btn btn-default btn-sm" >
                            <a href="recursos/informesMCY/ReporteMCY_{$fecha|date_format:"%b"|capitalize|replace:".":""}_{$fecha|replace:":":""}.xlsx">
                                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span></a>
                        </span>

                    </td>
                    {if isset($smarty.session.arrGrupos.6.20)}
                        <td class="col-sm-2">
                            <span class="btn btn-default btn-sm"  onClick="if (confirm('Esta seguro que desea eliminar el registro?'))
                                        cargarContenido('contenido', './contenidos/legalizacionMCY/eliminar.php', 'fchCreacion={$arrDatos.fchCreacion}', true);" class="text-danger"> 
                                <a href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </span>

                        </td>
                    {/if}
                </tr>
            {/foreach}
        </table>
    </div>
    <div class="panel-footer text-center" style="height: 55px;">

    </div>
</div>