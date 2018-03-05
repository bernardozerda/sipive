&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

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
                <form method="post" onSubmit="return false;" id="frmModificaCruce">
                    <table cellpadding="0" cellspacing="0" class="table table-striped">

                        <tr>
                            <td width="150px"><strong>Tipo de Verificación</strong></td>
                            <td colspan="3">
                                {if $claCruces->arrDatos.numVerificacion == 1}
                                    Primera Verificación
                                {elseif $claCruces->arrDatos.numVerificacion == 2}
                                    Segunda Verificación
                                {else}
                                    Desconocido
                                {/if}
                            </td>
                        </tr>

                        <tr>
                            <td width="150px"><strong>Fecha de Creación</strong></td>
                            <td colspan="3">
                                {$claCruces->arrDatos.fchCreacionCruce->format("Y-m-d")}
                            </td>
                        </tr>
                        <tr>
                            <td width="150px"><strong>Fecha de Actualización</strong></td>
                            <td>
                                {if $claCruces->arrDatos.fchActualizacionCruce != null}
                                    {$claCruces->arrDatos.fchActualizacionCruce->format("Y-m-d")}
                                {/if}
                            </td>
                            <td><strong>Fecha de Publicación</strong></td>
                            <td>
                                <input type="text"
                                       id="fchCruce"
                                       name="fchCruce"
                                       value="{$claCruces->arrDatos.fchCruce->format("Y-m-d")}"
                                       style="width: 100px"
                                       onfocus="calendarioPopUp('fchCruce')"
                                       required
                                >
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
                                <input type="text"
                                       id="txtFirma"
                                       name="txtFirma"
                                       value="{$claCruces->arrDatos.txtFirma}"
                                       style="width:300px"
                                >
                                <div id="txtFirmaContenedor" style="width:300px;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Elaboró</td>
                            <td colspan="3">
                                <input type="text"
                                       id="txtElaboro"
                                       name="txtElaboro"
                                       value="{$claCruces->arrDatos.txtElaboro}"
                                       style="width:300px;"
                                >
                                <div id="txtElaboroContenedor" style="width:300px"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Revisó</td>
                            <td colspan="3">
                                <input type="text"
                                       id="txtReviso"
                                       name="txtReviso"
                                       value="{$claCruces->arrDatos.txtReviso}"
                                       style="width:300px;"
                                >
                                <div id="txtRevisoContenedor" style="width:300px"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Archivo</td>
                            <td colspan="3">
                                <input type="file" name="archivo">
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="seqCruce" value="{$claCruces->arrDatos.seqCruce}">
                </form>
            </div>
            <div class="tab-pane" id="hogares" style="padding: 10px;">
                <table data-order='[[ 0, "asc" ]]' id="listadoCrucesVer" class="table table-condensed table-hover" width="840px">
                    <thead>
                        <tr>
                            <th align="center">Documento</th>
                            <th align="center">Nombre</th>
                            <th align="center">Estado</th>
                            <th align="center">&nbsp;</th>
                            <th align="center">&nbsp;</th>
                            <th align="center">&nbsp;</th>
                            <th align="center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$arrVer key=seqFormulario item=arrResultado}
                            <tr>
                                <td>{$arrResultado.documento}</td>
                                <td>{$arrResultado.nombre}</td>
                                <td>{$arrResultado.estado}</td>
                                <td align="center">
                                    {if $arrResultado.inhabilitar == 1}
                                        <span class="label label-danger"
                                              onClick="popUpPdfCasaMano('exportarPdf.php', 'exportar[]={$seqFormulario}', {$claCruces->arrDatos.seqCruce});"
                                              style="cursor: pointer"
                                        >Pendiente
                                        </span>
                                    {else}
                                        <span class="label label-success">Sin Cruces</span>
                                    {/if}
                                </td>
                                <td>
                                    <a href="#" onClick="location.href='./contenidos/cruces2/exportar.php?seqCruce={$claCruces->arrDatos.seqCruce}&seqFormulario={$seqFormulario}'">
                                        Exportar
                                    </a>
                                </td>
                                <td>
                                    {if isset($smarty.session.arrGrupos.3.20) or isset($smarty.session.arrGrupos.3.13)}
                                        <a href="#" onClick="cargarContenido('contenido','./contenidos/cruces2/adicionar.php','seqCruce={$claCruces->arrDatos.seqCruce}&seqFormulario={$seqFormulario}',true)">
                                            Adicionar
                                        </a>
                                    {/if}
                                </td>
                                <td>
                                    {if isset($smarty.session.arrGrupos.3.20) or isset($smarty.session.arrGrupos.3.13)}
                                        <a href="#" onClick="cargarContenido('contenido','./contenidos/cruces2/levantar.php','seqCruce={$claCruces->arrDatos.seqCruce}&seqFormulario={$seqFormulario}',true)">
                                            Editar
                                        </a>
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
        <button type="button" class="btn btn-primary" style="width: 100px" onClick="someterFormulario('contenido',document.getElementById('frmModificaCruce'),'./contenidos/cruces2/editar.php',true,true);">
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
            Datos Cruce
        </button>&nbsp;
        <button type="button" class="btn btn-success" style="width: 100px"
                onClick="location.href='./contenidos/cruces2/exportarAuditoria.php?seqCruce={$claCruces->arrDatos.seqCruce}'"
        >
            Auditoría
        </button>&nbsp;
        <button type="button" class="btn btn-default" onclick="cargarContenido('contenido','./contenidos/cruces2/cruces.php','',true);" style="width: 100px">
            Volver
        </button>
    </div>
</div>

<div id="listadoCrucesVerListener"></div>