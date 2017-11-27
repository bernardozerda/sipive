&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
      integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">[{$claCruces->arrDatos.seqCruce}] {$claCruces->arrDatos.txtNombre}</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datos" data-toggle="tab">Datos del Cruce</a></li>
            <li><a href="#hogares" data-toggle="tab">Hogares Vinculados</a></li>
        </ul>
        <div class="tab-content" style="border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD;">
            <div class="tab-pane active" id="datos" style="padding: 10px;">
                <table cellpadding="0" cellspacing="0" class="table table-striped">
                    <tr>
                        <td><strong>Fecha del cruce</strong></td>
                        <td colspan="3">
                            {$claCruces->arrDatos.fchCruce->format("Y-m-d")}
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><strong>Fecha de Creación</strong></td>
                        <td>
                            {$claCruces->arrDatos.fchCreacionCruce->format("Y-m-d")}
                        </td>
                        <td width="150px"><strong>Fecha de Actualización</strong></td>
                        <td>
                            {$claCruces->arrDatos.fchActualizacionCruce->format("Y-m-d")}
                        </td>
                    </tr>
                    <tr>
                        <td width="150px"><strong>Usuario de Creación</strong></td>
                        <td>
                            {$claCruces->arrDatos.txtUsuario}
                        </td>
                        <td width="150px"><strong>Usuario de Actualización</strong></td>
                        <td>
                            {$claCruces->arrDatos.txtUsuarioActualiza}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Cuerpo</strong></td>
                        <td colspan="3">
                            {$claCruces->arrDatos.txtCuerpo}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Pie</strong></td>
                        <td colspan="3">
                            {$claCruces->arrDatos.txtPie}
                        </td>
                    </tr>
                    <tr>
                        <td>Firma</td>
                        <td colspan="3">
                            {$claCruces->arrDatos.txtFirma}
                        </td>
                    </tr>
                    <tr>
                        <td>Elaboró</td>
                        <td colspan="3">
                            {$claCruces->arrDatos.txtElaboro}
                        </td>
                    </tr>
                    <tr>
                        <td>Revisó</td>
                        <td colspan="3">
                            {$claCruces->arrDatos.txtReviso}
                        </td>
                    </tr>
                    <tr>
                        <td>Archivo</td>
                        <td colspan="3">
                            <input type="file" name="archivo" required>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="hogares" style="padding: 10px;">
                <table data-order='[[ 0, "asc" ]]' id="listadoCruces" class="table table-condensed table-hover" width="840px">
                    <thead>
                        <tr>
                            <th align="center">Principal</th>
                            <th align="center">Documento</th>
                            <th align="center">Ciudadano</th>
                            <th align="center">Estado</th>
                            <th align="center">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$claCruces->arrDatos.arrResultado key=seqResultado item=arrResultado}
                            <tr>
                                <td>{$arrResultado.numDocumentoPrincipal}</td>
                                <td>{$arrResultado.numDocumento}</td>
                                <td>{$arrResultado.txtNombre}</td>
                                <td>{$arrResultado.txtEstado}</td>
                                <td align="center">
                                    {if $arrResultado.bolInhabilitar == 1}
                                        <a class="label label-danger"
                                           onClick="popUpPdfCasaMano('exportarPdf.php', 'exportar[]={$arrResultado.seqFormulario}', {$claCruces->arrDatos.seqCruce});"
                                        >Pendiente
                                        </a>
                                    {else}
                                        <span class="label label-success">Sin Cruces</span>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-footer" align="center">
        <button type="submit" class="btn btn-primary" style="width: 100px">
            Salvar
        </button>&nbsp;
        <button type="button" class="btn btn-danger" style="width: 100px"
                onClick="popUpPdfCasaMano('exportarPdf.php', '', {$claCruces->arrDatos.seqCruce});"
        >
            Cartas PDF
        </button>&nbsp;
        <button type="button" class="btn btn-success" style="width: 100px"
                onClick="location.href='./contenidos/cruces2/exportar.php?seqCruce={$claCruces->arrDatos.seqCruce}'"
        >
            Excel
        </button>&nbsp;
        <button type="button" class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/cruces2/cruces.php','',true);" style="width: 100px">
            Volver
        </button>
    </div>
</div>

<div id="listadoCrucesListener"></div>


