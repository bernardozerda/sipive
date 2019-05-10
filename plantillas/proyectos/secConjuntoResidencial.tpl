<p style="width:100%; padding-left: 3%">
<table border="0" cellspacing="2" cellpadding="0">    
    <tr>
        <th class="tituloTabla" colspan="4">CONJUNTO RESIDENCIAL</th>
        <td colspan="3" style="text-align: right"><div onClick="addConjuntoResidencial()" style="cursor: hand">Adicionar Conjunto Residencial&nbsp;
                <img src="recursos/imagenes/add.png"></div></td></tr>
</table>
<div style="width:100%; padding-left: 3%">
    <table border="0" cellspacing="2" cellpadding="0"  id="tablaConjuntoResidencial" style="padding-left: 3px; width: 98%">
        {assign var="num" value="0"}
        {assign var="cont" value="0"}

        {counter start=0 print=false assign=num}
        {counter start=0 print=false assign=cont}

        {foreach from=$arrConjuntoResidencial key=seqProyecto item=arrConjunto}

            {if $cont%2 == 0} <tr class="fila_0">

                {else} 
                <tr class="fila_1">
                {/if}   

                {assign var="actual" value="r_$cont"}               
                <td>
                    <div class="form-group" >
                        <div class="col-md-6"> 
                            <label class="control-label" >Nombre </label><br /> 
                            <input type="hidden" name="seqProyectoHijo[]" id="seqProyectoHijo" value="{$arrConjunto.seqProyecto}" >
                            <input type="hidden" name="seqProyectoPadre[]" id="seqProyectoPadre" value="{$arrConjunto.seqProyectoPadre}" >
                            <input type="text" name="txtNombreProyectoHijo[]" id="txtNombreProyectoHijo" value="{$arrConjunto.txtNombreProyecto}" size='80' onblur="sinCaracteresEspeciales(this);" class="form-control required4">
                            <div id="val_txtNombreProyectoHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" >Nombre Comercial</label><br />
                            <input type="text" name="txtNombreComercialHijo[]" id="txtNombreComercialHijo_{$cont}" value="{$arrConjunto.txtNombreComercial}" size='80' onblur="sinCaracteresEspeciales(this);">
                            <div id="val_txtNombreComercialHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-6"> 
                            <label class="control-label" >Localidad (*)</label>  
                            <select name="seqLocalidadHijo[]"
                                    id="seqlocalidadHijo_{$cont}"
                                    onChange="obtenerBarrioProyecto(this, 'tdBarrioHijo_{$cont}');"
                                    style="width:250px" 
                                    class="form-control ">
                                <option value="0">Seleccione una opci&oacute;n</option>
                                {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                    <option value="{$seqLocalidad}" {if $arrConjunto.seqLocalidad == $seqLocalidad} selected {/if}>{$txtLocalidad}</option>
                                {/foreach}
                            </select>
                            <div id="val_seqlocalidad_{$cont}" class="divError">Debe seleccionar la Localidad</div>
                        </div>
                        <div class="col-md-6" > 
                            <label class="control-label" >Barrio (*)</label> 
                            <span  id="tdBarrioHijo_{$cont}">
                                <select onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                        onBlur="this.style.backgroundColor = '#FFFFFF';" 
                                        name="seqBarrioHijo[]" 
                                        id="seqBarrioHijo_{$cont}" 
                                        style="width:250px;" 
                                        class="form-control ">
                                    <option value="0">Seleccione</option>
                                    {if intval( $arrConjunto.seqLocalidad ) != 0}
                                        {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                            <option value="{$seqBarrio}" 
                                                    {if $arrConjunto.seqBarrio == $seqBarrio} 
                                                        selected 
                                                    {/if}
                                                    >{$txtBarrio}</option>            
                                        {/foreach}
                                    {/if}
                                </select>
                                <div id="val_seqBarrio" class="divError">Debe seleccionar el Barrio</div>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Nombre de Vendedor</label><br />                            
                            <input type="text" name='txtNombreVendedorHijo[]' id="txtNombreVendedorHijo_{$cont}" value="{$arrConjunto.txtNombreVendedor}" size="20"  class="form-control"/>
                            <div id="val_txtNombreVendedorHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Tipo documento</label><br />                            
                            <select name="seqTipoDocumentoVendedorHijo[]"
                                    id="seqTipoDocumentoVendedorHijo_{$cont}"
                                    style="width:200px"
                                    class="form-control">
                                <option value="0">Seleccione una opción</option>
                                {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                    <option value="{$seqTipoDocumento}" {if $arrConjunto.seqTipoDocumentoVendedor == $seqTipoDocumento} selected {/if}>{$txtTipoDocumento}</option>
                                {/foreach}
                            </select>
                            <div id="val_seqTipoDocumentoVendedorHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Nit</label><br />                            
                            <input type="text" name='numNitVendedorHijo[]' id="numNitVendedorHijo_{$cont}" value="{$arrConjunto.numNitVendedor}" size="20"   class="form-control "/>
                            <div id="val_numNitVendedorHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Tel. Vendedor</label><br />                            
                            <input type="text" name='numTelVendedorHijo[]' id="numTelVendedorHijo_{$cont}" value="{$arrConjunto.numTelVendedor}" size="20"    class="form-control "/>
                            <div id="val_numTelVendedorHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Correo Vendedor</label><br />                            
                            <input type="text" name='txtCorreoVendedorHijo[]' id="txtCorreoVendedorHijo_{$cont}" value="{$arrConjunto.txtCorreoVendedor}" size="20"    class="form-control "/>
                            <div id="val_txtCorreoVendedorHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Direcci&oacute;n&nbsp;del&nbsp;Conjunto</label><br />                            
                            <input type="text" name='txtDireccionHijo[]' id="txtDireccionHijo_{$cont}" value="{$arrConjunto.txtDireccion}" size="20" style="background-color:#E4E4E4; width: 90%;position: relative; float: left" readonly  class="form-control required4"/>
                            <a href="#" onClick="recogerDireccion('txtDireccionHijo_{$cont}', 'objDireccionOculto')"><img src="recursos/imagenes/gps.png"></a>
                            <div id="val_txtDireccionHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Unidades</label><br />
                            <input type='text' name='valNumeroSolucionesHijo[]' id='valNumeroSolucionesHijo_{$cont}' value="{$arrConjunto.valNumeroSoluciones}" onBlur='sinCaracteresEspeciales(this);' size='6' class="form-control required4">
                            <div id="val_valNumeroSolucionesHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Torres</label><br />
                            <input type='text' name='valTorresHijo[]' id='valTorresHijo_{$cont}' value="{$arrConjunto.valTorres}" onBlur='sinCaracteresEspeciales(this);' size='6' class="form-control">
                            <div id="val_valTorresHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Area Lote</label><br />
                            <input type='text' name='valAreaLoteHijo[]' id='valAreaLoteHijo_{$cont}' value="{$arrConjunto.valAreaLote}" onBlur='sinCaracteresEspeciales(this);' size='6' class="form-control">
                            <div id="val_valAreaLoteHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Chip</label><br />
                            <input type='text' name='txtChipLoteHijo[]' id='txtChipLoteHijo_{$cont}' value="{$arrConjunto.txtChipLote}" onBlur='sinCaracteresEspeciales(this);' size='13' class="form-control required4">
                            <div id="val_txtChipLoteHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Matr&iacute;cula Inmobiliaria</label><br />            
                            <input type='text' name='txtMatriculaInmobiliariaLoteHijo[]' id='txtMatriculaInmobiliariaLoteHijo_{$cont}' value="{$arrConjunto.txtMatriculaInmobiliariaLote}" size='13' onBlur='sinCaracteresEspeciales(this);' class="form-control required4">
                            <div id="val_txtMatriculaInmobiliariaLoteHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">                            
                            <label class="control-label" >C&eacute;dula Catastral</label><br />
                            <input type='text' name='txtCedulaCatastralHijo[]' id='txtCedulaCatastralHijo_{$cont}' value="{$arrConjunto.txtCedulaCatastral}" onBlur='sinCaracteresEspeciales(this);' size='22' class="form-control required4">
                            <div id="val_txtCedulaCatastralHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Escritura</label><br /> 
                            <input type='text' name='txtEscrituraHijo[]' id='txtEscrituraHijo_{$cont}' value="{$arrConjunto.txtEscritura}" onBlur='sinCaracteresEspeciales(this);' size='12' class="form-control required4">
                            <div id="val_txtEscrituraHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Escritura</label><br /> 
                            <input name="fchEscrituraHijo[]" type="text" id="fchEscrituraHijo_{$cont}" value="{$arrConjunto.fchEscritura}" size="12" style="text-align:center; background-color:#E4E4E4; width: 90%;position: relative; float: left" readonly class="form-control required4"/><a href="#" onClick="javascript: calendarioPopUp('fchEscrituraHijo_{$cont}');"><img src="recursos/imagenes/calendar.png"></a>
                            <div id="val_fchEscrituraHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Notar&iacute;a</label><br />
                            <input type='text' name='numNotariaHijo[]' id='numNotariaHijo_{$cont}' value="{$arrConjunto.numNotaria}" onBlur='sinCaracteresEspeciales(this);' size='12' class="form-control required4">
                            <div id="val_numNotariaHijo_{$cont}" class="divError">Diligenciar Campo</div>
                        </div>

                        <div class="col-md-6">
                            <p>&nbsp;</p>
                        </div>
                    </div>


                    {foreach from=$arraConjuntoLicencias[$num] key=keyLicenciaCon item=valLicConj}
                        {if $valLicConj.seqTipoLicencia == 1}
                            <div class="form-group" >
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend class="legend">
                                            <h4 style="position: relative; float: left; width: 50%; margin: 0px; padding: 5px">
                                                Licencia de urbanismo</h4>
                                        </legend>

                                        <div class="col-md-3">
                                            <label class="control-label" >Lic. Urbanismo</label><br />  
                                            <input type="hidden" name="seqProyectoLicenciaUrbHijo[]" id="seqProyectoLicenciaUrbHijo_{$cont}" value="{$valLicConj.seqProyectoLicencia}" >
                                            <input type='text' name='txtLicenciaUrbanismoHijo[]' id='txtLicenciaUrbanismoHijo_{$cont}' value="{$valLicConj.txtLicencia}" onBlur='sinCaracteresEspeciales(this);' size='18' class="form-control required4">
                                            <div id="val_txtLicenciaUrbanismoHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" >Entidad Expedición</label><br />
                                            <input type='text' name='txtExpideLicenciaUrbanismoHijo[]' id='txtExpideLicenciaUrbanismoHijo_{$cont}' value="{$valLicConj.txtExpideLicencia}" onBlur='sinCaracteresEspeciales(this);' size='13' class="form-control required4">
                                            <div id="val_txtExpideLicenciaUrbanismoHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" >Fecha&nbsp;Licencia</label><br />           
                                            <input name="fchLicenciaUrbanismo1Hijo[]" type="text" id="fchLicenciaUrbanismo1Hijo_{$cont}" value="{$valLicConj.fchLicencia}" size="12" style="background-color:#E4E4E4; width: 60%;position: relative; float: left" readonly class="form-control required4"/><a href="#" onClick="javascript: calendarioPopUp('fchLicenciaUrbanismo1Hijo_{$cont}');"><img src="recursos/imagenes/calendar.png"></a>
                                            <div id="val_fchLicenciaUrbanismo1Hijo_{$cont}" class="divError">Diligenciar Campo</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                                            <input name="fchVigenciaLicenciaUrbanismoHijo[]" type="text" id="fchVigenciaLicenciaUrbanismoHijo_{$cont}" value="{$valLicConj.fchVigenciaLicencia}" size="12" style="background-color:#E4E4E4; width: 60%;position: relative; float: left" readonly class="form-control required4"/><a href="#" onClick="javascript: calendarioPopUp('fchVigenciaLicenciaUrbanismoHijo_{$cont}');" ><img src="recursos/imagenes/calendar.png"></a>
                                            <div id="val_fchVigenciaLicenciaUrbanismoHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        {else}
                            <div class="form-group" >
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend class="legend">
                                            <h4 style="position: relative; float: left; width: 50%; margin: 0px; padding: 5px">
                                                Licencia de Construccion</h4>
                                        </legend>
                                        <div class="form-group" >
                                            <div class="col-md-3">
                                                <label class="control-label" >Lic. Construcci&oacute;n</label><br />  
                                                <input type="hidden" name="seqProyectoLicenciaConsHijo[]" id="seqProyectoLicencia" value="{$valLicConj.seqProyectoLicencia}" >
                                                <input type='text' name='txtLicenciaConstruccionHijo[]' id='txtLicenciaConstruccionHijo_{$cont}' value="{$valLicConj.txtLicencia}" onBlur='sinCaracteresEspeciales(this);' size='18' class="form-control required4">
                                                <div id="val_txtLicenciaConstruccionHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Fecha&nbsp;Licencia</label><br />             
                                                <input name="fchLicenciaConstruccion1Hijo[]" type="text" id="fchLicenciaConstruccion1Hijo_{$cont}" value="{$valLicConj.fchLicencia}" size="12" style="background-color:#E4E4E4; width: 60%;position: relative; float: left" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchLicenciaConstruccion1Hijo[]');" class="form-control required4"><img src="recursos/imagenes/calendar.png"></a>
                                                <div id="val_fchLicenciaConstruccion1Hijo_{$cont}" class="divError">Diligenciar Campo</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                                                <input name="fchVigenciaLicenciaConstruccionHijo[]" type="text" id="fchVigenciaLicenciaConstruccionHijo_{$cont}" value="{$valLicConj.fchVigenciaLicencia}" size="12" style="background-color:#E4E4E4; width: 60%;position: relative; float: left" readonly class="form-control required4"/><a href="#" onClick="javascript: calendarioPopUp('fchVigenciaLicenciaConstruccionHijo_{$cont}');"><img src="recursos/imagenes/calendar.png"></a>
                                                <div id="val_fchVigenciaLicenciaConstruccionHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Eliminar</label><br />     
                                                <img src="recursos/imagenes/remove.png" width="22px" onclick="return confirmaRemoverLineaFormulario(this);" style="position: relative; float: left; width:15% ">

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <p>&nbsp;</p>
                            </div>  
                        {/if} 
                    {/foreach}
                    <p>&nbsp;</p>
                </td>
                <!---->
            </tr>
            {assign var="cont" value=$cont+1}
        {/foreach}
    </table>
</div>
</p>