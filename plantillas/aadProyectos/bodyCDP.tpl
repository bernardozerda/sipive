<div id="formularioCDP">

    {if $arrErrores.generico != ""}
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Atención!</strong> {$arrErrores.generico}
        </div>
    {elseif $txtMensaje != ""}
        <div class="alert alert-success alert-dismissible" role="alert" style="font-size:11px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Hecho!</strong> {$txtMensaje}
        </div>
    {/if}

    <form id="frmCDP" onsubmit="someterFormulario('formularioCDP',this,'./contenidos/aadProyectos/tablaCDP.php',false,false); return false;">
        <div class="row form-group">
            <div class="col-sm-1">Proyecto</div>
            <div class="col-sm-11">
                <input class="input-control"
                       id="numProyectoInversionCDP"
                       name="numProyectoInversionCDP"
                       type="text"
                       style="width:50px; {if isset($arrErrores.numProyectoInversionCDP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.numProyectoInversionCDP}"
                >
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-1 text-center">CDP</div>
            <div class="col-sm-1 text-center">
                <input class="input-control"
                       id="numNumeroCDP"
                       name="numNumeroCDP"
                       type="text"
                       style="width:50px; {if isset($arrErrores.numNumeroCDP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.numNumeroCDP}"
                >
            </div>
            <div class="col-sm-1 text-center">Fecha</div>
            <div class="col-sm-2 text-center">
                <input class="input-control"
                       id="fchFechaCDP"
                       name="fchFechaCDP"
                       type="date"
                       style="width:130px; {if isset($arrErrores.fchFechaCDP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.fchFechaCDP}"
                >
            </div>
            <div class="col-sm-1 text-center">Valor</div>
            <div class="col-sm-3 text-center">
                <input class="input-control"
                       id="valValorCDP"
                       name="valValorCDP"
                       type="text"
                       style="width:130px; {if isset($arrErrores.valValorCDP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onkeyup="formatoSeparadores(this)"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.valValorCDP|number_format:0:'.':'.'}"
                >
            </div>
            <div class="col-sm-1 text-center">Vigencia</div>
            <div class="col-sm-2 text-center">
                <input class="input-control"
                       id="numVigenciaCDP"
                       name="numVigenciaCDP"
                       type="text"
                       style="width:50px; {if isset($arrErrores.numVigenciaCDP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.numVigenciaCDP}"
                >
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-1 text-center">RP</div>
            <div class="col-sm-1 text-center">
                <input class="input-control"
                       id="numNumeroRP"
                       name="numNumeroRP"
                       type="text"
                       style="width:50px; {if isset($arrErrores.numNumeroRP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.numNumeroRP}"
                >
            </div>
            <div class="col-sm-1 text-center">Fecha</div>
            <div class="col-sm-2 text-center">
                <input class="input-control"
                       id="fchFechaRP"
                       name="fchFechaRP"
                       type="date"
                       style="width:130px; {if isset($arrErrores.fchFechaRP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.fchFechaRP}"
                >
            </div>
            <div class="col-sm-1 text-center">Valor</div>
            <div class="col-sm-3 text-center">
                <input class="input-control"
                       id="valValorRP"
                       name="valValorRP"
                       type="text"
                       style="width:130px; {if isset($arrErrores.valValorRP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onkeyup="formatoSeparadores(this)"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.valValorRP|number_format:0:'.':'.'}"
                >
            </div>
            <div class="col-sm-1 text-center">Vigencia</div>
            <div class="col-sm-2 text-center">
                <input class="input-control"
                       id="numVigenciaRP"
                       name="numVigenciaRP"
                       type="text"
                       style="width:50px; {if isset($arrErrores.numVigenciaRP)} background-color: #FFCCCC; {/if}"
                       onfocus="this.style.backgroundColor=''"
                       onblur="
                         $('#salvar').val(0);
                         someterFormulario('tablaCDP',this.form,'./contenidos/aadProyectos/tablaCDP.php',false,false);
                       "
                       value="{$arrPost.numVigenciaRP}"
                >
            </div>
        </div>
        <input type="hidden" id="salvar" name="salvar" value="{$arrPost.salvar}">
        <input type="hidden" id="eliminar" name="eliminar" value="0">
    </form>
    <hr>
    <div id="tablaCDP">
        {include file="./aadProyectos/tablaCDP.tpl"}
    </div>

</div>