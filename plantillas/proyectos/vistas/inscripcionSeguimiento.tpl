<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->

<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST"  onload="">
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {foreach from=$arraSegFicha key=key item=value} 

        {include file='proyectos/pedirSeguimiento.tpl'}

        {assign var=styleLic value = "border-radius: 15px 15px 0 0;"}
        {assign var=nav value = "width: 100%"}
        {assign var=nav1 value = "width: 25%"}       
        {assign var=contador value=$arrayTextos|@count}

        <div id="wrapper" class="container tab-content">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                
                <li class="nav-item active"  style="width: 100%; border-radius: 15px 15px 0 0;">   
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#seg" role="tab" aria-controls="profile" aria-selected="false" style="{$styleLic}" onclick="activarEditorTiny('comentarios', {$contador});"> Historial de Seguimiento Ficha <br></a>
                </li>
            </ul>
            <div id="seg" class="tab-pane active"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                <div class="form-group" >
                    <div class="col-md12" style="padding: 20px"> 
                        <fieldset>
                            <legend class="legend">
                                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                                    Informe Ficha T&eacute;cnica</h4>
                            </legend>
                            <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">
                                <div class="form-group">
                                    <div class="col-md-4"> 
                                        <label class="control-label" >Consecutivo </label> 
                                        <input name="numSeguimientoFicha" type="text" id="numSeguimientoFicha" value="{$value.numSeguimientoFicha}"  onkeyup="sinCaracteresEspeciales(this);
                                                soloNumeros(this);" {if $value.bolCerrar == 1} readonly="true"{/if} class="form-control required">
                                        <input type="hidden" id="seqSeguimientoFicha" name="seqSeguimientoFicha" value="{$value.seqSeguimientoFicha}">
                                        <input type="hidden" id="seqProyecto" name="seqProyecto" value="{$seqProyecto}" >                                      
                                        <div id="txtNombreInformadorContenedor1" class="yui-ac-container"></div>
                                        <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarSeguimientoFicha.php" />
                                        <div id="val_numSeguimientoFicha" class="divError">Debe diligenciar el consecutivo del seguimiento</div>
                                    </div>
                                    <div class="col-md-4"> 
                                        <label class="control-label" >Fecha De Reporte</label>
                                        <input name="fchSeguimientoFicha" type="text" id="fchSeguimientoFicha" value="{$value.fchSeguimientoFicha}" size="12" readonly=""  class="form-control required"  style="width: 60%; position: relative; float: left">
                                        {if $value.bolCerrar!= 1}  <a href="#" onclick="javascript: calendarioPopUp('fchSeguimientoFicha');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 9%; position: relative; float: left; left: 2%"></a>{/if}
                                        <div id="val_fchSeguimientoFicha" class="divError">Debe diligenciar la fecha del seguimiento</div>                                  
                                    </div>  
                                    <div class="col-md-4"> 
                                        <label class="control-label" >Cerrar</label> <br>
                                        <input type="checkbox" name="bolCerrar" id="bolCerrar"  {if $value.bolCerrar == 1}checked="true" readonly="true"{/if} />
                                    </div>
                                </div>
                            </fieldset>
                            <div id="ficha">
                                {assign var="numSegTexto" value="1"}
                                {counter start=1 print=false assign=numSegTexto}
                                {foreach from=$arrayTextos key=keyTextos item=valueTextos} 
                                    <div class="form-group"  id="intV{$numSegTexto}" >
                                        {if $value.bolCerrar != 1}  
                                            {assign var=nav value = "width: 25%"}
                                        {else}
                                            {assign var=nav value = "width: 2%"}
                                        {/if}
                                        <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">

                                            <legend style="text-align: left; cursor: hand;{$nav}; text-align: right"><p>&nbsp;</p>
                                                {if $value.bolCerrar!= 1}  
                                                    <input type="button" value="Adicionar" class="btn_add" onclick="addSeguimientoFicha();"> 
                                                    {if $numSegTexto > 1}
                                                        <input type="button"  value="Eliminar" class="btn_deleted"  onclick="removerOferente(intV{$numSegTexto})"/>
                                                    {/if}
                                                {/if}
                                            </legend>     

                                            <div class="col-md-12"> 
                                                <label class="control-label" >Seguimientos</label> 
                                                <input type="hidden" name="seqFichaTexto[]" id="seqFichaTexto{$numSegTexto}" value="{$valueTextos.seqFichaTexto}"/>
                                                <textarea rows="10" cols="200" name="txtFichaTexto[]" id="comentarios{$numSegTexto}"  {if $value.bolCerrar == 1} readonly="true"{/if}>{$valueTextos.txtFichaTexto}</textarea>
                                            </div> 
                                            <p>&nbsp;</p> 

                                        </fieldset>
                                    </div>

                                    {assign var="numSegTexto" value=$numSegTexto+1}
                                {/foreach}
                            </div>
                            <p>&nbsp;</p> 
                        </fieldset>   
                    </div>
                </div> 
            </div>
        </div>
    {/foreach}

</form>
<div id="segOcultoSeg">{$contador}</div>


<!-- ******************************************** INICIO DE MODALES INFORMATIVOS ********************************* -->

<!-- Modal -->

