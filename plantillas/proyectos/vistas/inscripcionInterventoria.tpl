<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST"  onload="">
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {foreach from=$arrayDatosInterventoria key=key item=value} 

        {include file='proyectos/pedirSeguimiento.tpl'}

        {assign var=styleLic value = "border-radius: 15px 15px 0 0;"}
        {assign var=nav value = "width: 100%"}
        {assign var=nav1 value = "width: 25%"}       
        {assign var=contador value=$arrayTextos|@count}

        <div id="wrapper" class="container tab-content">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist" style="width: 100%">                
                <li class="nav-item active"  style="width: 100%; border-radius: 15px 15px 0 0;">   
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#seg" role="tab" aria-controls="profile" aria-selected="false" style="{$styleLic}" onclick="activarEditorTiny('comentarios', {$contador});"> Informe De Interventoria  <br></a>
                </li>
            </ul>
            <div id="seg" class="tab-pane active"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                <div class="form-group" >
                    <div class="col-md12" style="padding: 20px"> 
                        <fieldset>
                            <legend class="legend">
                                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                                    <b>Informaci&oacute;n del Avance Fisico</b>  </h4>
                            </legend>
                            <p>&nbsp;</p> 
                            <fieldset style="border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;">
                                <div class="form-group"> 

                                    <div class="col-md-5"> 
                                        <label class="control-label" >Titulo Informe</label><br>
                                        <input type="text" id="txtInformeInterventoria" name="txtInformeInterventoria" id="txtInformeInterventoria" value="{$value.txtInformeInterventoria}"  class="form-control required">
                                        <div id="val_txtInformeInterventoria" class="divError">Digite Titulo del Informe</div>
                                    </div>
                                    <div class="col-md-2"> 
                                        <label class="control-label" >Fecha Informe</label>
                                        <input name="fchInformeInterventoria" type="text" id="fchInformeInterventoria" value="{$value.fchInformeInterventoria}" size="12" readonly=""  class="form-control required"  style="width: 67%; position: relative; float: left">
                                        <a href="#" onclick="javascript: calendarioPopUp('fchInformeInterventoria');"><img src="recursos/imagenes/calendar.png" style="cursor: hand;width: 20%; position: relative; float: left; left: 2%"></a>
                                        <div id="val_fchInformeInterventoria" class="divError">Debe diligenciar la fecha del seguimiento</div>                                  
                                    </div>  
                                    <div class="col-md-2"> 
                                        <label class="control-label" > Avance</label><br>
                                        <input name="numPorcentajeEjecucion" type="text" id="numPorcentajeEjecucion" maxlength="4" value="{$value.numPorcentajeEjecucion}" size="5"  class="form-control required"  style="width: 50%; position: relative; float: left;" />
                                        <strong style="width: 10%; position: relative; float: left; font-weight: bold; font-size: 19px ">%</strong>
                                        <div id="val_numPorcentajeEjecucion" class="divError">Digite Porcentaje Ejecutado</div>  
                                        <input type="hidden" id="seqInformeInterventoria" name="seqInformeInterventoria" value="{$value.seqInformeInterventoria}">
                                        <input type="hidden" id="seqProyecto" name="seqProyecto" value="{$seqProyecto}" >                                      
                                        <div id="txtNombreInformadorContenedor1" class="yui-ac-container"></div>
                                        <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarInformeInterventoria.php" />
                                    </div>  
                                    <div class="col-md-3"> 
                                        <label class="control-label" >Valor Ejecuci&oacute;n</label><br>
                                        <strong style="width: 10%; position: relative; float: left; font-weight: bold; font-size: 19px ">$</strong>
                                        <input type="number" name="valEjecutado" id="valEjecutado" value="{$value.valEjecutado}" class="form-control required" />
                                        <div id="val_valEjecutado" class="divError">Digite valor Ejecutado</div> 
                                    </div>
                                    <div class="col-md-12"> 
                                        <label class="control-label" >Archivo del Informe</label>
                                        {if $value.txtNombreArchivo == ""}
                                            <div class="custom-file">
                                                <input type="file" name="txtNombreArchivo" id="txtNombreArchivo"  value="{$value.txtNombreArchivo}" class="custom-file-input required" id="customFile" style="max-width: 100%" >
                                                <label class="custom-file-label" for="customFile" id="nameArchivo" style="margin-top: 0">Seleccione Imagenes</label>
                                                <div id="val_txtNombreArchivo" class="divError">Seleccione Archivo</div> 
                                            </div>
                                        {else}
                                            <br>
                                            <a href="{$prefijo}recursos/proyectos/proyecto-{$seqProyecto}/informes/{$value.txtNombreArchivo}" target="_blank">{$value.txtNombreArchivo}</a>
                                        {/if}
                                        <div id="fileAction"></div>                                       
                                    </div>                                        
                                </div>
                                <p>&nbsp;</p> 
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

                                                <input type="button" value="Adicionar" class="btn_add" onclick="addObsInterventoria();"> 
                                                {if $numSegTexto > 1}
                                                    <input type="button"  value="Eliminar" class="btn_deleted"  onclick="removerOferente(intV{$numSegTexto})"/>
                                                {/if}

                                            </legend>                                            
                                            <div class="col-md-12"> 
                                                <label class="control-label" >Conclusiones Interventoria</label> 
                                                <input type="hidden" name="seqInterventoriaTexto[]" id="seqInterventoriaTexto{$numSegTexto}" value="{$valueTextos.seqInterventoriaTexto}"/>
                                                <textarea rows="10" cols="200" name="txtObservaciones[]" id="comentarios{$numSegTexto}" class="form-control required">{$valueTextos.txtObservaciones}</textarea>
                                                <div id="val_comentarios{$numSegTexto}" class="divError">Digite Conclusiones</div>
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

