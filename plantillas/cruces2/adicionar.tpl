<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">[{$claCruces->arrDatos.seqCruce}] {$claCruces->arrDatos.txtNombre}</h4>
    </div>
    <div class="panel-body">

        <form method="post" action="return false;" id="frmAdicionarCruce">

            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <td width="120px">Miembro del Hogar</td>
                    <td colspan="4" align="left">
                        <select name="numDocumento" id="numDocumento" style="width: 300px">
                            <option value="0">Seleccione uno</option>
                            {foreach from=$arrMiembros key=numDocumento item=txtNombre}
                                <option value="{$numDocumento}" {if $arrPost.numDocumento == $numDocumento} selected {/if}>
                                    [{$numDocumento}] {$txtNombre}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fuente</td>
                    <td >
                        <select name="seqFuente" id="seqFuente" style="width: 200px" onChange="cambiarFuenteInhabilidad(this)">
                            <option value="">Seleccione una</option>
                            {foreach from=$arrFuentes key=seqFuente item=txtFuente}
                                <option value="{$seqFuente}" {if $arrPost.seqFuente == $seqFuente} selected {/if}>
                                    {$txtFuente}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                    <td>Causa</td>
                    <td colspan="3">
                        <select name="seqCausa" id="seqCausa" style="width: 400px">
                            <option value="no">Seleccione una</option>
                            {foreach from=$arrCausas key=seqCausa item=txtCausa}
                                <option value="{$seqCausa}" {if $arrPost.seqCausa == $seqCausa} selected {/if}>
                                    {$txtCausa}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Detalle</td>
                    <td colspan="4">
                        <textarea name="txtDetalles" style="width: 500px; height: 80px">{$arrPost.txtDetalles}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Observaciones</td>
                    <td colspan="4">
                        <textarea name="txtObservaciones" style="width: 500px; height: 80px">{$arrPost.txtObservaciones}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Inhabilitar</td>
                    <td colspan="4">
                        <select name="bolInhabilitar" id="bolInhabilitar" style="width: 120px;">
                            <option value="">Seleccione una</option>
                            <option value="si" {if $arrPost.bolInhabilitar === 'si'} selected {/if}>SI</option>
                            <option value="no" {if $arrPost.bolInhabilitar === 'no'} selected {/if}>NO</option>
                        </select>
                    </td>
                </tr>

            </table>
            <input type="hidden" name="adicionar" value="1">
            <input type="hidden" name="seqCruce" value="{$arrPost.seqCruce}">
            <input type="hidden" name="seqFormulario" value="{$arrPost.seqFormulario}">
        </form>

    </div>
    <div class="panel-footer" align="center">
        <button type="button" class="btn btn-primary" style="width: 100px" onClick="someterFormulario('contenido',document.getElementById('frmAdicionarCruce'),'./contenidos/cruces2/adicionar.php',true,true);">
            Salvar
        </button>&nbsp;
        <button type="button" class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/cruces2/ver.php','seqCruce={$claCruces->arrDatos.seqCruce}',true);" style="width: 100px">
            Volver
        </button>
    </div>
</div>