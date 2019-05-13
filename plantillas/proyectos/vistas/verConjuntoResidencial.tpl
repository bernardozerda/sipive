<p style="width:100%; padding-left: 3%">
<table border="0" cellspacing="2" cellpadding="0">    
    <tr>
        <th class="tituloTabla" colspan="4">CONJUNTO RESIDENCIAL</th>
    </tr>
</table>
<div style="width:100%; padding-left: 3%">
    <table border="0" cellspacing="2" cellpadding="0"  id="tablaConjuntoResidencial" style="padding-left: 3px; width: 98%">
        {assign var="num" value="0"}
        {counter start=0 print=false assign=num}
        {foreach from=$arrConjuntoResidencial key=seqProyecto item=arrConjunto}
            {if $num++%2 == 0} <tr class="fila_0">
                {else} 
                <tr class="fila_1">
                {/if}             
                {counter print=false}
                {assign var="actual" value="r_$num"}               
                <td>
                    <div class="form-group" >
                        <div class="col-md-3"> 
                            <label class="control-label" >Nombre </label><br /> 
                            <input type="hidden" name="seqProyectoHijo[]" id="seqProyectoHijo" value="{$arrConjunto.seqProyecto}" >
                            <input type="hidden" name="seqProyectoPadre[]" id="seqProyectoPadre" value="{$arrConjunto.seqProyectoPadre}" >
                            <p>{$arrConjunto.txtNombreProyecto}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Nombre Comercial</label><br />
                            <p>{$arrConjunto.txtNombreComercial}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Direcci&oacute;n&nbsp;del&nbsp;Conjunto</label><br />                            
                            <p>{$arrConjunto.txtDireccion}</p>

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Localidad</label><br />                                                              
                            {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                {if $arrConjunto.seqLocalidad == $seqLocalidad}  
                                    <p>{$txtLocalidad|upper}&nbsp;</p> 
                                {/if}
                            {/foreach}    
                        </div>
                        <div class="col-md-3" > 
                            <label class="control-label" >Barrio </label> 
                            {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                {if $arrConjunto.seqBarrio == $seqBarrio} 
                                    <p>{$txtBarrio|upper}&nbsp;</p>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="col-md-3"> 
                            <label class="control-label" >Nombre Vendedor</label><br /> 
                            <p>{$arrConjunto.txtNombreVendedor}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Tipo Documento</label><br />
                            {foreach from=$arrTipoDocumento key=seqTipoDocumento item=txtTipoDocumento}
                                {if $arrConjunto.seqTipoDocumentoVendedor == $seqTipoDocumento} 
                                    <p>{$txtTipoDocumento}</p>
                                {/if}
                            {/foreach}

                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >NIT Vendedor</label><br />
                            <p>{$arrConjunto.numNitVendedor}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Telefono Vendedor</label><br />
                            <p>{$arrConjunto.numTelVendedor}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Correo Vendedor</label><br />
                            <p>{$arrConjunto.txtCorreoVendedor}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Unidades</label><br />
                            <p>{$arrConjunto.valNumeroSoluciones}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Torres</label><br />
                            <p>{$arrConjunto.valTorres}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Chip</label><br />
                            <p>{$arrConjunto.txtChipLote}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Matr&iacute;cula Inmobiliaria</label><br />            
                            <p>{$arrConjunto.txtMatriculaInmobiliariaLote}</p>
                        </div>
                        <div class="col-md-3">                            
                            <label class="control-label" >C&eacute;dula Catastral</label><br />
                            <p>{$arrConjunto.txtCedulaCatastral}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Escritura</label><br /> 
                            <p>{$arrConjunto.txtEscritura}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Escritura</label><br /> 
                            <p>{$arrConjunto.fchEscritura}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Notar&iacute;a</label><br />
                            <p>{$arrConjunto.numNotaria}</p>
                        </div>
                        {foreach from=$arraConjuntoLicencias[0] key=keyLicenciaCon item=valLicConj}
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
                                                <p>{$valLicConj.seqProyectoLicencia}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Entidad Expedición</label><br />
                                                <p>{$valLicConj.txtExpideLicencia}</p>
                                                <div id="val_txtExpideLicenciaUrbanismoHijo_{$cont}" class="divError">Diligenciar Campo</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Fecha&nbsp;Licencia</label><br />           
                                                <p>{$valLicConj.fchLicencia}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                                                <p>{$valLicConj.fchVigenciaLicencia}</p>
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
                                                    <p>{$valLicConj.txtLicencia}</p>                                                   
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label" >Fecha&nbsp;Licencia</label><br />             
                                                    <p>{$valLicConj.fchLicencia}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                                                    <p>{$valLicConj.fchVigenciaLicencia}</p>
                                                </div>

                                            </div>
                                        </fieldset>
                                    </div>
                                    <p>&nbsp;</p>
                                </div>  
                            {/if} 
                        {/foreach}
                        <p>&nbsp;</p>
                    </div>
                </td>
                <!---->
            </tr>

        {/foreach}
    </table>
</div>
</p>