&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($claMenu->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claMenu->arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claMenu->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claMenu->arrMensajes.0}
    </div>
{/if}

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Ayudas en línea</h6>
    </div>
    <div class="panel-body">

        <table width="100%" class="table">
            <tr>
                <td width="30%" height="50px">
                    <div class="form-group">
                        <select class="form-control input-sm col-sm-12"
                                name="proyecto"
                                onchange="cargarContenido('contenido','./contenidos/ayuda/textosAyuda.php','seqProyecto='+$(this).val(),'true')"
                        >
                            {foreach from=$arrProyectos key=seqProyectoItem item=objProyecto}
                                <option value="{$seqProyectoItem}" {if $seqProyectoItem == $seqProyecto} selected {/if}>{$objProyecto->txtProyecto|mb_strtoupper}</option>
                            {/foreach}
                        </select>
                    </div>
                </td>
                <td rowspan="2" id="formularioAyuda">
                    {include file='ayuda/formulario.tpl'}
                </td>
            </tr>
            <tr>
                <td>
                    {$claMenu->imprimirArbolMenuAyuda($arrMenu,$seqProyecto)}
                </td>
            </tr>
        </table>

    </div>
</div>

<div id="arbolAyuda"></div>

