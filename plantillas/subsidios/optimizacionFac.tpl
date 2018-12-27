&nbsp;
<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
      >

<div id="div1" >
    <form id="frmFac1" method="post" action="./contenidos/subsidios/exportarFac.php">
        <input type="hidden" name="tipo" id="tipo" value="1" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Lista de Estados de Hogares Asignados</h6>
            </div>  
            <div class="panel-body">
                {foreach from=$arrEstados item=arrEstado}
                    <div class="row form-group">
                        <div class="col-sm-1">
                            <input type="checkbox" id="estados" name="estados[]" value="{$arrEstado.seqEstado}">
                        </div>
                        <div class="col-sm-11">
                            {$arrEstado.txtEstado}
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="panel-footer text-center" style="padding: 1px;">
                <ul class="pager">
                    <li class="page-item disabled"><a href="#div1" onclick="salvarFAC('div1', 'div2', 'div2', 2, 'frmFac1');">← Anterior</a></li>
                    <li><a href="#div2" onclick="salvarFAC('div2', 'div2', 'div1', 1, 'frmFac1');">Siguiente →</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div id="div2" style="display: none">
    <form id="frmFac2" method="post" action="./contenidos/subsidios/exportarFac.php">
        <input type="hidden" name="tipo" id="tipo" value="2" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Lista de Estados de Hogares Inhabilitados</h6>
            </div>
            <div class="panel-body">                
                <div class="row form-group">
                    <div class="col-sm-1">
                        <input type="checkbox" id="estados" name="estados[]" value="52">
                    </div>
                    <div class="col-sm-11">
                        Inscripcion -inhabilitado
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-1">
                        <input type="checkbox" id="estados" name="estados[]" value="8">
                    </div>
                    <div class="col-sm-11">
                        Postulacion -inhabilitado
                    </div>
                </div>

            </div>
            <div class="panel-footer text-center" style="padding: 1px;">
                <ul class="pager">
                    <li><a href="#div2" onclick="salvarFAC('div1', 'div2', 'div3', 2, 'frmFac2');">← Anterior</a></li>
                    <li><a href="#div2" onclick="salvarFAC('div3', 'div2', 'div1', 1, 'frmFac2');">Siguiente →</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>

<div id="div3" style="display: none">
    <form id="frmFac3" method="post" action="./contenidos/subsidios/exportarFac.php">
        <input type="hidden" name="tipo" id="tipo" value="3" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Lista de Estados de Hogares Sancionados</h6>
            </div>
            <div class="panel-body">
                {foreach from=$arrEstados1 item=arrEstado1}
                    <div class="row form-group">
                        <div class="col-sm-1">
                            <input type="checkbox" id="estados" name="estados[]" value="{$arrEstado1.seqEstado}">
                        </div>
                        <div class="col-sm-11">
                            {$arrEstado1.txtEstado}
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="panel-footer text-center" style="padding: 1px;">
                <ul class="pager">
                    <li class="page-item"><a href="#div" onclick="salvarFAC('div2', 'div3', 'div4', 2, 'frmFac3');">← Anterior</a></li>
                    <li class="page-item "><a href="#div3" onclick="salvarFAC('div4', 'div3', 'div3', 1, 'frmFac3');">Siguiente →</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div id="div4" style="display: none">
    <form  id="frmFac4" onsubmit="return false;" enctype="multipart/form-data">
        <input type="hidden" name="tipo" id="tipo" value="4" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Actualizacion Archivo Emberas</h6>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" style="padding-top: 8px;">Elegir tipo de Archivo</label>
                    <div class="col-sm-4 input-group">
                        <select name="tipo" id="tipo" onchange="limpiarCampFile()"  class="form-control">
                            <option value="0">Seleccione</option>
                            <option value="4">Emberas</option>
                            <option value="5">Molinos</option>
                            <option value="6">Metrovivienda</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="archivo" class="col-sm-2 control-label" style="padding-top: 8px;">Archivo de carga</label>
                    <div class="col-sm-8">
                        <div class="input-group input-group-sm">
                            <label class="input-group-btn">
                                <span class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                    <input type="file" name="archivo" id="fileupload" style="display: none">
                                </span>
                            </label>
                            <input id="archivo" type="text" class="form-control" readonly>
                            <div id="fileSelect"></div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="button"
                                class="btn btn-primary btn-sm"
                                data-toggle="modal"
                                data-target="#help"
                                onclick="salvarFACFiles('div4', 'div3', 'div3', 1, 'frmFac4');"
                                >
                            <span class="glyphicon glyphicon glyphicon-cloud-upload"></span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="panel-footer text-center" style="padding: 1px;">
                <ul class="pager">
                    <li class="page-item"><a href="#div" onclick="salvarFAC('div3', 'div4', 'div5', 2, 'frmFac4');">← Anterior</a></li>
                    <li class="page-item "><a href="#div3" onclick="salvarFACFiles('div5', 'div4', 'div3', 1, 'frmFac4');">Siguiente →</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div id="div5" style="display: none">
    <form  id="frmFac5">
        <input type="hidden" name="tipo" id="tipo" value="7" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Listado de Estado de postulacion</h6>
            </div>
            <div class="panel-body">
                <input type="hidden" name="tipo" id="tipo" value="7" />
                <div class="panel-body">
                    {foreach from=$arrEstados2 item=arrEstado2}
                        <div class="row form-group">
                            <div class="col-sm-1">
                                <input type="checkbox" id="estados" name="estados[]" value="{$arrEstado2.seqEstado}">
                            </div>
                            <div class="col-sm-11">
                                {$arrEstado2.txtEstado}
                            </div>
                        </div>
                    {/foreach}
                </div>             
            </div>
            <div class="panel-footer text-center" style="padding: 1px;">
                <ul class="pager">
                    <li class="page-item"><a href="#div" onclick="salvarFAC('div4', 'div5', 'div6', 2, 'frmFac5');">← Anterior</a></li>
                    <li class="page-item "><a href="#div3" onclick="salvarFAC('div6', 'div5', 'div4', 1, 'frmFac5');">Siguiente →</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div id="div6" style="display: none">
    <form  id="frmFac6">
        <input type="hidden" name="tipo" id="tipo" value="8" />
        Desea Generar Reporte!!!
        {*<div class="panel panel-default">
        <div class="panel-heading">
        <h6 class="panel-title">Actualizacion Archivo Metrovivienda</h6>
        </div>
        <div class="panel-body">
        <div class="form-group">
        <label for="archivo" class="col-sm-2 control-label" style="padding-top: 8px;">Archivo de carga</label>
        <div class="col-sm-8">
        <div class="input-group input-group-sm">
        <label class="input-group-btn">
        <span class="btn btn-default btn-sm">
        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <input type="file" name="archivo" style="display: none;">
        </span>
        </label>
        <input id="archivo" type="text" class="form-control" readonly>
        <div id="fileSelect"></div>
        </div>
        </div>
        <div class="col-sm-1">
        <button type="button"
        class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#help"
        >
        <span class="glyphicon glyphicon-question-sign"></span>
        </button>
        </div>
        </div>

        </div>*}
        <div class="panel-footer text-center" style="padding: 1px;">
            <ul class="pager">
                <li class="page-item"><a href="#div" onclick="salvarFAC('div5', 'div6', 'div7', 2, 'frmFac6');">← Anterior</a></li>
                <li class="page-item "><a href="#div3" onclick="location.href = 'contenidos/administracion/salvarFAC.php?volver=1&tipo=8';">Generar Reporte →</a></li>
            </ul>
        </div>
</div>
</form>
</div>
<div id="div7" style="display: none">
    Reporteeeee
</div>
<!--<ul class="pager">
    <li><a href="#div1" onclick="$('#div1').show();
            $('#div2').hide();">← Anterior</a></li>
    <li><a href="#div2" onclick="$('#div2').show();
            $('#div1').hide();">Siguiente →</a></li>
</ul>-->

