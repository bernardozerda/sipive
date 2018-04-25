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

<!-- formulario para el giro -->
<form id="frmGirosProyectos" class="form-horizontal" onsubmit="someterFormulario('contenido',this,'./contenidos/pryGestionFinanciera/salvarGiroFiducia.php',false,false); return false;">

    <!-- proyecto para el giro -->
    <div class="form-group">
        <label for="seqProyecto" class="col-sm-1 control-label text-left">Proyecto</label>
        <div class="col-sm-10">
            <select id="seqProyecto" class="form-control input-sm" name="seqProyecto" onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroFiducia.php',true,true);">
                <option value="0">Seleccione Proyecto</option>
                {foreach from=$claGestion->arrProyectos key=seqProyecto item=txtNombreProyecto}
                    <option value="{$seqProyecto}" {if $arrPost.seqProyecto == $seqProyecto} selected {/if}>{$txtNombreProyecto}</option>
                {/foreach}
            </select>
        </div>
    </div>

    <!-- detalle del giro -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Giros a Fiducia</h6>
        </div>
        <div class="panel-body">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#giro" aria-controls="giro" role="tab" data-toggle="tab">Datos del Giro</a>
                </li>
                <li role="presentation"
                    onclick="
                        autocompletar( 'txtSubdirector'   , 'txtSubdirectorContenedor'   , './contenidos/cruces2/nombres.php' , '' ); $('#txtSubdirector').removeClass('yui-ac-input');
                        autocompletar( 'txtSubsecretario' , 'txtSubsecretarioContenedor' , './contenidos/cruces2/nombres.php' , '' ); $('#txtSubsecretario').removeClass('yui-ac-input');
                        autocompletar( 'txtReviso'        , 'txtRevisoContenedor'        , './contenidos/cruces2/nombres.php' , '' ); $('#txtReviso').removeClass('yui-ac-input');
                    ">
                    <a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos</a>
                </li>
            </ul>

            <!-- nav content -->
            <div class="tab-content col-sm-12" style="padding-top: 20px;">

                <!-- pestaña para el giro -->
                <div role="tabpanel" class="tab-pane fade in active" id="giro">

                    <div class="form-group">

                        <!-- resoluciones de las que se puedan tomar giros -->
                        <label for="seqUnidadActo" class="col-sm-1 control-label">Resolución</label>
                        <div class="col-sm-4">
                            <select id="seqUnidadActo" class="form-control input-sm" name="seqUnidadActo"
                                    onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroFiducia.php',true,true);">
                                <option value="0">Seleccione Resolución</option>
                                {foreach from=$claGestion->arrResoluciones key=seqUnidadActo item=arrResolucion}
                                    {if $arrResolucion.total > 0}
                                        <option value="{$seqUnidadActo}" {if $arrPost.seqUnidadActo == $seqUnidadActo} selected {/if}>
                                            {$arrResolucion.tipo} {$arrResolucion.numero} de {$arrResolucion.fecha->format(Y)}
                                        </option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>

                        <!-- RP asociados a la resolucion seleccionada -->
                        <label for="seqRegistroPresupuestal" class="col-sm-2 control-label">Registro Presupuestal</label>
                        <div class="col-sm-3">
                            <select id="seqRegistroPresupuestal" class="form-control input-sm" name="seqRegistroPresupuestal"
                                    onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroFiducia.php',true,true);">
                                <option value="0">Seleccione RP</option>
                                {if intval($arrPost.seqUnidadActo) != 0}
                                    {assign var=seqUnidadActo value=$arrPost.seqUnidadActo}
                                    {foreach from=$claGestion->arrResoluciones.$seqUnidadActo.cdp key=seqRegistroPresupuestal item=arrCDP}
                                        <option value="{$seqRegistroPresupuestal}" {if $arrPost.seqRegistroPresupuestal == $seqRegistroPresupuestal} selected {/if}>
                                            {$arrCDP.numeroRP} del {$arrCDP.fechaRP->format(Y)}
                                        </option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>

                        <!-- plantilla de unidades a seleccionar -->
                        <div class="col-sm-2">
                            <button class="btn btn-success btn-sm" type="button"
                                    onclick="location.href='./contenidos/pryGestionFinanciera/plantillaUnidades.php?seqProyecto={$arrPost.seqProyecto}&seqUnidadActo={$arrPost.seqUnidadActo}&seqRegistroPresupuestal={$arrPost.seqRegistroPresupuestal}'"
                                    {if $bolHabilitar == false} disabled="disabled" {/if}>
                                <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Plantilla
                            </button>
                        </div>

                    </div>

                    <div class="form-group">

                        <!-- input para carga del archivo -->
                        <label for="seqProyecto" class="col-sm-1 control-label">Unidades</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-sm">
                                <label class="input-group-btn">
                            <span class="btn btn-default {if $bolHabilitar == false} disabled {/if}">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                <input class="pryFile" type="file" name="archivo" style="display: none;" {if $bolHabilitar == false} disabled="disabled" {/if}
                                       onchange="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/giroFiducia.php',true,true);">
                            </span>
                                </label>
                                <input type="text" id="pryFileContent" class="form-control" readonly="" value="">
                            </div>
                        </div>

                        <!-- ver las unidades cargdas -->
                        <label for="seqProyecto" class="col-sm-2 control-label">Unidades a procesar</label>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm">
                                <label class="input-group-btn" data-toggle="modal" data-target="#modalUnidades">
                            <span class="btn btn-default {if $bolHabilitar == false} disabled {/if}">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </span>
                                </label>
                                <input type="text" class="form-control input-sm" value="{$numTotalUnidades}" readonly>
                            </div>
                        </div>

                        <!-- unidades cargadas -->
                        {assign var=seqProyecto value=$arrPost.seqProyecto}
                        {assign var=seqUnidadActo value=$arrPost.seqUnidadActo}
                        {assign var=seqRegistroPresupuestal value=$arrPost.seqRegistroPresupuestal}
                        {foreach from=$arrUnidades.$seqProyecto.$seqUnidadActo.$seqRegistroPresupuestal key=seqUnidadProyecto item=valGiro}
                            <input type="hidden" name="unidades[{$seqProyecto}][{$seqUnidadActo}][{$seqRegistroPresupuestal}][{$seqUnidadProyecto}]" value="{$valGiro}">
                        {/foreach}

                    </div>

                    <!-- tabla para el giro -->
                    {if not empty($arrTablaCDP)}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        VALOR A GIRAR
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped" width="100%">
                                            <thead>
                                            <tr>
                                                <th>CDP y RP</th>
                                                <th>Valor RP</th>
                                                <th>Giros</th>
                                                <th>Liberaciones</th>
                                                <th>Valor a Girar</th>
                                                <th>Saldo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    CDP: {$arrTablaCDP.numeroCDP} de {$arrTablaCDP.fechaCDP->format(Y)}<br>
                                                    RP: {$arrTablaCDP.numeroRP} de {$arrTablaCDP.fechaRP->format(Y)}
                                                </td>
                                                <td style="vertical-align: middle">$ {$arrTablaCDP.valorRP|number_format:0:',':'.'}</td>
                                                <td style="vertical-align: middle">$ {$arrTablaCDP.giros|number_format:0:',':'.'}</td>
                                                <td style="vertical-align: middle">$ {$arrTablaCDP.liberaciones|abs|number_format:0:',':'.'}</td>
                                                <td>
                                                    <input type="text" class="form-control input-sm"
                                                           id="valGiro" value="{$numTotalGiro|@doubleval|number_format:0:',':'.'}"
                                                           style="width: 110px"
                                                           readonly>
                                                </td>
                                                <td  style="vertical-align: middle" {if $arrTablaCDP.saldo < 0} class="text-danger" {/if}>
                                                    $ {$arrTablaCDP.saldo|number_format:0:',':'.'}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    {/if}

                </div>

                <!-- pestaña para los documentos -->
                <div role="tabpanel col-sm-12" class="tab-pane fade" id="documentos" style="padding-top: 10px;">

                    <!-- certificacion -->
                    <div class="form-group">
                        <label for="txtCertificacion" class="col-sm-2 control-label">Certificación</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="txtCertificacion" name="txtCertificacion" rows="3">{$arrPost.txtCertificacion}</textarea>
                        </div>
                    </div>

                    <div class="form-group">

                        <!-- checklist de documentos -->
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Del Oferente
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">

                                        <!-- cedula del oferente -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolCedulaOferente]" value="1"
                                                            {if isset($arrPost.documentos.bolCedulaOferente) } checked {/if}> Copia Cédula de Ciudadanía
                                                </label>
                                            </div>
                                        </div>

                                        <!-- rit -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolRitOferente]" value="1"
                                                            {if isset($arrPost.documentos.bolRitOferente) } checked {/if}> Copia del Registro de Información Tributaria - RIT
                                                </label>
                                            </div>
                                        </div>

                                        <!-- rut -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolRutOferente]" value="1"
                                                            {if isset($arrPost.documentos.bolRutOferente) } checked {/if}> Copia del Registro Único Tributario – RUT
                                                </label>
                                            </div>
                                        </div>

                                        <!-- representacion legal -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolExistenciaOferente]" value="1"
                                                            {if isset($arrPost.documentos.bolExistenciaOferente) } checked {/if}> Copia del Certificado de existencia y representación legal<br>&nbsp;
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">

                                        <!-- constitucion del encargo fiduciario -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolConstitucionFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolConstitucionFiducia) } checked {/if}> Copia constitución Encargo Fiduciario
                                                </label>
                                            </div>
                                        </div>

                                        <!-- cedula de ciudadania entidad financiera -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolCedulaFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolCedulaFiducia) } checked {/if}> Copia cedula de ciudadanía
                                                </label>
                                            </div>
                                        </div>

                                        <!-- certificacion bancaria fiducia -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolBancariaFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolBancariaFiducia) } checked {/if}>  Certificación Bancaria de la cuenta en la cual se va a realizar el giro
                                                </label>
                                            </div>
                                        </div>

                                        <!-- representacion legal fiducia-->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolSuperintendenciaFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolSuperintendenciaFiducia) } checked {/if}> Copia del Certificado de existencia y representación legal expedido por la Superintendencia Financiera
                                                </label>
                                            </div>
                                        </div>

                                        <!-- camara y comercop -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolCamaraFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolCamaraFiducia) } checked {/if}> Copia del Certificado de existencia y representación legal expedido por la Cámara de Comercio
                                                </label>
                                            </div>
                                        </div>

                                        <!-- RUT financiera -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolRutFiducia]" value="1"
                                                            {if isset($arrPost.documentos.bolRutFiducia) } checked {/if}> Copia del Registro Único Tributario – RUT de la entidad financiera
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- forma del formulario y datos de documentos del proyecto -->
                        <div class="col-sm-6">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Del proyecto
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">

                                        <!-- resolucion -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolResolucionProyecto]" value="1"
                                                            {if isset($arrPost.documentos.bolResolucionProyecto) } checked {/if}> Copia Resolución 488 de 2016 y 541 de 2016
                                                </label>
                                            </div>
                                        </div>

                                        <!-- memorando -->
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="documentos[bolMemorandoProyecto]" value="1"
                                                            {if isset($arrPost.documentos.bolMemorandoProyecto) } checked {/if}> Copia memorando de solicitud de aprobación póliza de cumplimiento mediante radicado No. 3-2015-35230- con fecha del 05 junio de 2015
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="checkbox"><label></label></div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox"><label></label></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- firmas -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Firmas del documento
                                </div>
                                <div class="panel-body">

                                    <div class="col-sm-12">

                                        <!--- subsecretario -->
                                        <div class="form-group">
                                            <label for="txtSubsecretario" class="col-sm-12">Subsecretario</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="txtSubsecretario" id="txtSubsecretario" class="form-control input-sm" value="{$arrPost.txtSubsecretario}">
                                                <div class="col-sm-12">
                                                    <div id="txtSubsecretarioContenedor"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="checkbox" name="bolEncargoSubsecretario" class="checkbox"
                                                        {if isset($arrPost.bolEncargoSubsecretario) } checked {/if}>
                                            </div>
                                        </div>

                                        <!--- subdirector -->
                                        <div class="form-group">
                                            <label for="txtSubdirector" class="col-sm-12">Subdirector</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="txtSubdirector" id="txtSubdirector" class="form-control input-sm" value="{$arrPost.txtSubdirector}">
                                                <div class="col-sm-12">
                                                    <div id="txtSubdirectorContenedor"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="checkbox" name="bolEncargoSubdirector" class="checkbox"
                                                        {if isset($arrPost.bolEncargoSubdirector) } checked {/if}>
                                            </div>
                                        </div>

                                        <!--- reviso -->
                                        <div class="form-group">
                                            <label for="txtReviso" class="col-sm-12">Revisó</label>
                                            <div class="col-sm-12">
                                                <input type="text" name="txtReviso" id="txtReviso" class="form-control input-sm" value="{$arrPost.txtReviso}">
                                                <div class="col-sm-12">
                                                    <div id="txtRevisoContenedor"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer" align="center">&nbsp;

            {*<button type="button" name="volver" class="btn btn-danger" style="width: 100px;">PDF</button>*}
            {**}
            &nbsp;
            <button type="button" name="salvar" value="1" class="btn btn-primary" style="width: 100px;"
                    {if $bolPendientes == false}
                        onclick="someterFormulario('contenido',this.form,'./contenidos/pryGestionFinanciera/salvarGiroFiducia.php',false,true);"
                    {else}
                        data-toggle="modal" data-target="#modalPendientes"
                    {/if}
            >
                Salvar Giro
            </button>
            &nbsp;
            <button type="button" name="volver" class="btn btn-default" style="width: 100px;">Volver</button>

        </div>
    </div>

</form>

<!-- Modal de unidades seleccionadas -->
<div class="modal fade" id="modalUnidades" tabindex="-1" role="dialog" aria-labelledby="modalUnidadesLabel">
    <div class="modal-dialog" role="document" style="width: 900px; height: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalUnidadesLabel">Unidades a procesar</h4>
            </div>
            <div class="modal-body">
                {assign var=seqProyecto value=$arrPost.seqProyecto}
                {assign var=seqUnidadActo value=$arrPost.seqUnidadActo}
                {assign var=seqRegistroPresupuestal value=$arrPost.seqRegistroPresupuestal}
                <table id="listadoAadPry" class="table table-striped" style="width: 100%;">
                    <thead style="width: 100%;">
                        <tr>
                            <th style="width: 25%;">Proyecto</th>
                            <th style="width: 25%;">Conjunto</th>
                            <th style="width: 25%;">Unidad</th>
                            <th>Giro</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$arrUnidades.$seqProyecto.$seqUnidadActo.$seqRegistroPresupuestal key=seqUnidadProyecto item=valGiro}
                            <tr>
                                <td>{$claGestion->arrResoluciones.$seqUnidadActo.cdp.$seqRegistroPresupuestal.unidades.$seqUnidadProyecto.proyecto}</td>
                                <td>{$claGestion->arrResoluciones.$seqUnidadActo.cdp.$seqRegistroPresupuestal.unidades.$seqUnidadProyecto.conjunto}</td>
                                <td>{$claGestion->arrResoluciones.$seqUnidadActo.cdp.$seqRegistroPresupuestal.unidades.$seqUnidadProyecto.unidad}</td>
                                <td style="text-align: right">$ {$valGiro|number_format:0:',':'.'}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
                <div id="listadoAadProyectos"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de confirmacion si tiene pendientes de liberacion -->
<div class="modal fade" id="modalPendientes" tabindex="-1" role="dialog" aria-labelledby="modalPendientesLabel">
    <div class="modal-dialog" role="document" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalPendientesLabel">Atención !!</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-1">
                        <table width="100%" border="0">
                            <tr>
                                <td style="padding: 30px;" class="h1">
                                    <span class="glyphicon glyphicon-warning-sign text-warning"></span>
                                </td>
                                <td class="h4">
                                        <p>Aún tiene saldos pendientes en las resoluciones de liberación</p>
                                        <small>¿Desea continuar?</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#frmGirosProyectos').submit()">Continuar</button>
            </div>
        </div>
    </div>
</div>
