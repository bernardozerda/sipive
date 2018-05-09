&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

{if not empty($claGestion->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claGestion->arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claGestion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claGestion->arrMensajes.0}
    </div>
{/if}

<!-- detalle del giro -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Listado de Giros a Constructor</h6>
    </div>
    <div class="panel-body">

        <table id="listadoAadPry" data-order='[[ 0, "desc" ]]' class="table table-striped table-condensed table-hover" width="100%">
            <thead>
            <tr>
                <th align="center">Identificador</th>
                <th align="center">Proyecto</th>
                <th align="center">Unidades</th>
                <th align="center">Valor</th>
                <th align="center"></th>
                <th align="center"></th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$arrListado key=seqGiroConstructor item=arrItemGiro}
                <tr>
                    <td class="text-center">{$seqGiroConstructor}</td>
                    <td class="text-left">{$arrItemGiro.proyecto}</td>
                    <td class="text-right">{$arrItemGiro.unidades|number_format:0:',':'.'}</td>
                    <td class="text-right">$ {$arrItemGiro.giro|number_format:0:',':'.'}</td>
                    <td class="text-center">
                        <a href="#" onClick="cargarContenido('contenido','./contenidos/pryGestionFinanciera/giroConstructor.php','seqGiroConstructor={$seqGiroConstructor}',true);">
                            <span class="glyphicon glyphicon-zoom-in" aria-hidden="true" style="cursor: pointer"></span>
                        </a>
                    </td>
                    <td class="text-center">
                        {if isset($smarty.session.arrGrupos.6.20)}
                            <a href="#" onclick="cargarContenido('contenido','./contenidos/pryGestionFinanciera/eliminarGiroConstructor.php','seqGiroConstructor={$seqGiroConstructor}',true);">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true" style="cursor: pointer"></span>
                            </a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <div class="col-sm-12 text-center">
            <button type="button" class="btn btn-primary" onclick="cargarContenido('contenido','./contenidos/pryGestionFinanciera/giroConstructor.php','',true);">Nuevo Giro</button>
        </div>
    </div>
</div>

<div id="listadoAadProyectos"></div>