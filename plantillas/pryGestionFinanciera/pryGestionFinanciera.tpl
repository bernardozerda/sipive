&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Gestión Financiera</h4>
    </div>
    <div class="panel-body">
        <form method="post" onsubmit="return false;">

            <div class="row form-group">
                <div class="col-sm-3">Seleccione proyecto</div>
                <div class="col-sm-9">
                    <select name="seqProyecto" style="width: 100%" onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/pryGestionFinanciera.php',false,true);">
                        <option value="0">Seleccione Proyecto</option>
                        {foreach from=$arrProyectos item=arrProyecto}
                            <option value="{$arrProyecto.seqProyecto}" {if $arrPost.seqProyecto == $arrProyecto.seqProyecto} selected {/if}>
                                {$arrProyecto.txtNombreProyecto}
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <table class="table table-striped form-group">
                {foreach from=$arrDisponible key=seqUnidadActo item=arrActo}

                    <tr>
                        <td class="h6">{$arrActo.resolucion.tipo} {$arrActo.resolucion.numero} del {$arrActo.resolucion.fecha->format(Y)}</td>
                    </tr>

                    {foreach from=$arrActo.registroPresupuestal key=seqRegistroPresupuestal item=arrRegistro}
                        <tr>
                            <td style="padding-left: 30px">

                                <table width="100%" cellpadding="0" cellspacing="0" class="table table-condensed" style="vertical-align: middle">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th style="text-align: center">RP</th>
                                            <th style="text-align: center">Vinculado</th>
                                            <th style="text-align: center">Giros</th>
                                            <th style="text-align: center">Saldo</th>
                                            <th style="text-align: center">Valor</th>
                                            <th style="text-align: center">Viviendas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="30px">
                                                CDP<br>
                                                RP
                                            </td>
                                            <td width="85px" style="text-align: right; vertical-align: middle">
                                                {$arrRegistro.numeroCDP} del {$arrRegistro.fechaCDP->format(Y)}<br>
                                                {$arrRegistro.numeroRP} del {$arrRegistro.fechaRP->format(Y)}
                                            </td>
                                            <td width="90px" style="text-align: right; vertical-align: middle">
                                                $ {$arrRegistro.valorRP|number_format:0:',':'.'}
                                            </td>
                                            <td width="90px" style="text-align: right; vertical-align: middle">
                                                $ {$arrRegistro.valorViviendas|number_format:0:',':'.'}
                                            </td>
                                            <td width="90px" style="text-align: right; vertical-align: middle">
                                                $ {$arrRegistro.valorGiros|number_format:0:',':'.'}
                                            </td>
                                            <td width="90px" style="text-align: right; vertical-align: middle">
                                                $ {$arrRegistro.saldo|number_format:0:',':'.'}
                                            </td>
                                            <td width="100px" style="text-align: center; vertical-align: middle">
                                                <input type="text" style="width: 90px; text-align: right" onkeyup="formatoSeparadores(this)">
                                            </td>
                                            <td>
                                            <td>
                                                {*<input type="file"> *}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    {/foreach}


                {/foreach}
            </table>


        </form>
    </div>
    <div class="panel-footer" align="center">
        Hola
    </div>
</div>
