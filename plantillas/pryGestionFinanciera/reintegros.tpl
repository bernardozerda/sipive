
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

<div class="container-fluid">
    <form id="frmProyecto" onsubmit="someterFormulario('contenido',this,'./contenidos/pryGestionFinanciera/reintegros.php',false,true); return false" class="form-horizontal">

        <!-- proyecto para el giro -->
        <div class="form-group">
            <label for="seqProyecto" class="col-sm-1 control-label text-left">Proyecto</label>
            <div class="col-sm-10">
                <select id="seqProyecto" class="form-control input-sm" name="seqProyecto" {if $bolSalvado == true} disabled {/if}>
                    <option value="0">Seleccione Proyecto</option>
                    {foreach from=$claGestion->arrProyectos key=seqProyecto item=txtNombreProyecto}
                        <option value="{$seqProyecto}" {if $arrPost.seqProyecto == $seqProyecto} selected {/if}>{$txtNombreProyecto}</option>
                    {/foreach}
                </select>
            </div>
        </div>

        <!-- detalle  -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Reintegros y rendimientos</h6>
            </div>
            <div class="panel-body">

                <!-- numero del acta y fecha del arreglo -->
                <div class="form-group">
                    <div class="col-sm-6">
                        <label class="control-label col-sm-4" for="numActa">Numero del Acta</label>
                        <div class="col-sm-8">
                            <input type="number" id="numActa" name="numActa" value="{$arrPost.numActa}" class="form-control input-sm"
                                    {if $bolSalvado == true} disabled {/if}>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label col-sm-4" for="fchActa">Fecha del Acta</label>
                        <div class="col-sm-8">
                            <input type="text" id="fchActa" name="fchActa" value="{$arrPost.fchActa}" class="form-control input-sm"
                            onfocus="calendarioPopUp('fchActa');" readonly {if $bolSalvado == true} disabled {/if}>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">

                    <!-- Reintegros -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">Reintegros</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="seqBanco" class="control-label">Banco</label>
                                    <select name="reintegro[seqBanco]" id="seqBanco" class="form-control input-sm">
                                        <option value="0">Seleccione</option>
                                        {foreach from=$arrBancos key=seqBanco item=txtBanco}
                                            <option value="{$seqBanco}" {if $seqBanco == $arrPost.reintegro.seqBanco} selected {/if}>{$txtBanco}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="numCuenta" class="control-label">Cuenta</label>
                                    <input type="text" id="numCuenta" name="reintegro[numCuenta]" class="form-control input-sm" value="{$arrPost.reintegro.numCuenta}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fchReintegro" class="control-label">Fecha</label>
                                    <input type="text" id="fchReintegro" name="reintegro[fchConsignacion]" class="form-control input-sm"
                                           value="{$arrPost.reintegro.fchConsignacion}" onfocus="calendarioPopUp('fchReintegro')" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="valConsignacion" class="control-label">Valor</label>
                                    <input type="text" id="valConsignacion" name="reintegro[valConsignacion]" class="form-control input-sm"
                                           value="{$arrPost.reintegro.valConsignacion}" onkeyup="formatoSeparadores(this)">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <button type="submit" name="salvar" value="reintegro" class="btn btn-default btn-sm {if $bolSalvado == true} disabled {/if}" {if $bolSalvado == true} disabled {/if}>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar
                            </button>
                        </div>
                    </div>

                </div>

                <div class="col-sm-6">

                    <!-- Rendimientos -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">Rendimientos</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="seqBanco" class="control-label">Banco</label>
                                    <select name="rendimiento[seqBanco]" id="seqBanco" class="form-control input-sm">
                                        <option value="0">Seleccione</option>
                                        {foreach from=$arrBancos key=seqBanco item=txtBanco}
                                            <option value="{$seqBanco}" {if $seqBanco == $arrPost.rendimiento.seqBanco} selected {/if} >{$txtBanco}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="numCuenta" class="control-label">Cuenta</label>
                                    <input type="text" id="numCuenta" name="rendimiento[numCuenta]" class="form-control input-sm" value="{$arrPost.rendimiento.numCuenta}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fchRendimiento" class="control-label">Fecha</label>
                                    <input type="text" id="fchRendimiento" name="rendimiento[fchConsignacion]" class="form-control input-sm"
                                           value="{$arrPost.rendimiento.fchConsignacion}" onfocus="calendarioPopUp('fchRendimiento')" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="valConsignacion" class="control-label">Valor</label>
                                    <input type="text" id="valConsignacion" name="rendimiento[valConsignacion]" class="form-control input-sm"
                                           value="{$arrPost.rendimiento.valConsignacion}" onkeyup="formatoSeparadores(this)">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <button type="submit" name="salvar" value="rendimiento" class="btn btn-default btn-sm {if $bolSalvado == true} disabled {/if}" {if $bolSalvado == true} disabled {/if}>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">

                    <table id="listadoAadPry" data-order='[[ 0, "desc" ]]' class="table table-striped table-condensed table-hover" width="850px">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Banco</th>
                                <th>Cuenta</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$arrPost.registros key=numRegistro item=arrRegistro}
                                <tr>
                                    <td>{$arrRegistro.txtTipo|mb_strtoupper}</td>
                                    <td>
                                        {assign var=seqBanco value=$arrRegistro.seqBanco}
                                        {$arrBancos.$seqBanco}
                                    </td>
                                    <td>{$arrRegistro.numCuenta}</td>
                                    <td>{$arrRegistro.fchConsignacion}</td>
                                    <td>$ {$arrRegistro.valConsignacion|number_format:0:',':'.'}</td>
                                    <td>
                                        {if $bolSalvado == false}
                                            <a href="#"
                                               onclick="
                                                   $('#eliminar').val({$numRegistro});
                                                   $('#frmProyecto').submit();
                                               "
                                            >
                                                <span class="glyphicon glyphicon-trash text-danger" aria-hidden="true" style="cursor: pointer"></span>
                                            </a>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>

                    <div id="listadoAadProyectos"></div>

                    {foreach from=$arrPost.registros key=numRegistro item=arrRegistro}
                        {foreach from=$arrRegistro key=txtClave item=txtValor}
                            <input type="hidden" name="registros[{$numRegistro}][{$txtClave}]" value="{$txtValor}">
                        {/foreach}
                    {/foreach}
                    <input type="hidden" id="eliminar" name="eliminar" value="">

                </div>
            </div>
            <div class="panel-footer text-center">
                <button type="button" name="salvar" value="1" class="btn btn-primary {if $bolSalvado == true} disabled {/if}" style="width: 150px;" {if $bolSalvado == true} disabled {/if}
                        onclick="someterFormulario('contenido',this.form, './contenidos/pryGestionFinanciera/salvarReintegro.php',false,true)">
                    Salvar Registros
                </button>
                <button type="button" name="volver" class="btn btn-default" style="width: 150px;"
                        onclick="cargarContenido('contenido','./contenidos/pryGestionFinanciera/listadoReintegros.php','',true);">Volver</button>
            </div>
        </div>
    </form>
</div>