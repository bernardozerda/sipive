<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<br>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">[{$claCruces->arrDatos.seqCruce}] {$claCruces->arrDatos.txtNombre}</h4>
    </div>
    <div class="panel-body">

        <form method="post" action="return false;" id="frmLevantarCruce">
            <table cellpadding="0" cellspacing="0" class="table table-striped" border="0" id="listadoCrucesVer" width="100%">
                <thead>
                    <th width="100px">Documento</th>
                    <th width="250px">Descripción</th>
                    <th width="100px">Inhabilitar</th>
                    <th>Observaciones</th>
                </thead>
                {foreach from=$claCruces->arrDatos.arrResultado key=seqResultado item=arrDatos}
                    <tr>
                        <td>{$arrDatos.numDocumento}</td>
                        <td>
                            <strong>Nombre:</strong> {$arrDatos.txtNombre}<br>
                            <strong>Entidad:</strong> {$arrDatos.txtEntidad}<br>
                            <strong>Causa:</strong> {$arrDatos.txtTitulo}<br>
                            <strong>Detalle:</strong> {$arrDatos.txtDetalle}
                        </td>
                        <td>
                            <select name="resultado[{$seqResultado}][bolInhabilitar]" style="width:80px">
                                <option value="1" {if $arrDatos.bolInhabilitar == 1} selected {/if}>SI</option>
                                <option value="0" {if $arrDatos.bolInhabilitar == 0} selected {/if}>NO</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="resultado[{$seqResultado}][txtObservaciones]" style="width: 100%; height: 50px;">{$arrDatos.txtObservaciones}</textarea>
                        </td>
                    </tr>

                {/foreach}
            </table>
            <input type="hidden" name="levantar" value="1">
            <input type="hidden" name="seqCruce" value="{$claCruces->arrDatos.seqCruce}">
            <input type="hidden" name="seqFormulario" value="{$seqFormulario}">
        </form>

    </div>
    <div class="panel-footer" align="center">
        <button type="button" class="btn btn-primary" style="width: 100px" onClick="someterFormulario('contenido',document.getElementById('frmLevantarCruce'),'./contenidos/cruces2/levantar.php',true,true);">
            Salvar
        </button>&nbsp;
        <button type="button" class="btn btn-success" style="width: 100px"
                onClick="location.href='./contenidos/cruces2/exportar.php?seqCruce={$claCruces->arrDatos.seqCruce}&seqFormulario={$seqFormulario}'"
        >
            Datos Cruce
        </button>&nbsp;
        <button type="button" class="btn btn-success" style="width: 100px"
                onClick="location.href='./contenidos/cruces2/exportarAuditoria.php?seqCruce={$claCruces->arrDatos.seqCruce}&seqFormulario={$seqFormulario}'"
        >
            Auditoría
        </button>&nbsp;
        <button type="button" class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/cruces2/ver.php','seqCruce={$claCruces->arrDatos.seqCruce}',true);" style="width: 100px">
            Volver
        </button>
    </div>
</div>
<div id="listadoCrucesVerListener"></div>