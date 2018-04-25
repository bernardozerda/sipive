&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Actos administrativos de unidades</h4>
    </div>
    <div class="panel-body">
        <form id="frmSalvar" onsubmit="return false;">

            <div class="row form-group">
                <div class="col-sm-2">
                    <strong>Tipo de acto</strong>
                </div>
                <div class="col-sm-3">
                    <select id="seqTipoActoUnidad" name="seqTipoActoUnidad">
                        <option value="0">Seleccione uno</option>
                        {foreach from=$arrTipos item=arrTipo}
                            <option value="{$arrTipo.seqTipoActoUnidad}" {if $arrPost.seqTipoActoUnidad == $arrTipo.seqTipoActoUnidad} selected {/if}>
                                {$arrTipo.txtTipoActoUnidad|upper}
                            </option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-sm-2">
                    <strong>Identificación</strong>
                </div>
                <div class="col-sm-5">
                    <input class="input-form"
                           type="number"
                           id="numActo"
                           name="numActo"
                           value="{$arrPost.numActo}"
                           style="width: 100px"
                    >
                    &nbsp; del &nbsp;
                    <input class="input-form"
                           type="text"
                           id="fchActo"
                           name="fchActo"
                           value="{$arrPost.fchActo}"
                           onfocus="calendarioPopUp('fchActo')"
                           style="width: 100px"
                           readonly
                    >
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-2">
                    <strong>Descripción</strong>
                </div>
                <div class="col-sm-10">
                    <textarea id="txtDescripcion" name="txtDescripcion" style="width: 90%; height: 60px;">{$arrPost.txtDescripcion}</textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-2">
                    <strong>Archivo de unidades</strong>
                </div>
                <div class="col-sm-10">
                    <input type="file" name="archivo" id="archivo" style="width: 300px;">
                </div>
            </div>

        </form>
    </div>
    <div class="panel-footer" align="center">
        <div class="row form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <button class="btn btn-primary" onclick="someterFormulario('contenido','frmSalvar','./contenidos/aadProyectos/salvar.php',true,true)" style="width: 90px">
                    Guardar
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-success" onclick="plantillaAADProyectos();" style="width: 90px">
                    Plantilla
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-warning" data-toggle="modal" data-target="#admincdp" style="width: 90px">
                    CDP y RP
                </button>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/aadProyectos/aadProyectos.php','',true);" style="width: 90px">
                    Volver
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="admincdp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 950px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Listado de CDP y RP</h4>
            </div>
            <div class="modal-body">
                {include file="./aadProyectos/bodyCDP.tpl"}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onClick="$('#salvar').val(1); $('#frmCDP').submit();">Salvar</button>
            </div>
        </div>
    </div>
</div>


