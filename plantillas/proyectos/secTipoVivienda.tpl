<p style="width:100%; padding-left: 3%">
<table border="0" cellspacing="2" cellpadding="0">

    <tr><th class="tituloTabla" colspan="4">TIPO VIVIENDA</th>
        <td colspan="3" style="text-align: right"><div onClick="addTipoVivienda()" style="cursor: hand">Adicionar Tipo de Vivienda&nbsp;
                <img src="recursos/imagenes/add.png">
            </div> 
        </td>

    </tr>
</table>
<div style="width:100%; padding-left: 3%">
    <table border="0" cellspacing="2" cellpadding="0"  id="tablaTipoVivienda" style="padding-left: 3px;">
        {assign var="num" value="0"}
        {counter start=0 print=false assign=num}
        {foreach from=$arrTipoVivienda key=seqTipoVivienda item=arrTipoV}
            {if $num++%2 == 0} <tr class="fila_0">
            {else} <tr class="fila_1">
                {/if}
                <td>
                    <div class="form-group" >
                        <div class="col-md-3"> 
                            <label class="control-label" >Nombre</label><br />
                            {counter print=false}
                            {assign var="actual" value="r_$num"}
                            <input type="hidden" name="seqTipoVivienda[]" id="seqTipoVivienda_{$num}" value="{$arrTipoV.seqTipoVivienda}" >
                            <!--<input type="text" name="txtNombreTipoVivienda[]" id="txtNombreTipoVivienda" value="{$arrTipoV.txtNombreTipoVivienda}" style="width:150px;" onblur="sinCaracteresEspeciales(this);">-->
                            <select name="txtNombreTipoVivienda[]" id="txtNombreTipoVivienda"
                                    style="width:150px"
                                    class="form-control">
                                <option value="">Seleccione Tipo Vivienda</option>
                                {if $arrTipoV.txtNombreTipoVivienda != ""} 
                                    <option value="{$arrTipoV.txtNombreTipoVivienda}" {if $arrTipoV.txtNombreTipoVivienda != ""} selected{/if}>{$arrTipoV.txtNombreTipoVivienda}</option>
                                {/if}
                                <option value="Apartamento tipo VIS">Apartamento tipo VIS</option>
                                <option value="Apartamento tipo VIP">Apartamento tipo VIP</option>
                                <option value="Casa tipo VIS">Casa tipo VIS</option>
                                <option value="Casa tipo VIP">Casa tipo VIP</option>
                                <option value="Otro tipo NO VIS/VIP">Otro tipo NO VIS/VIP</option>                      
                            </select>
                        </div> 
                        <div class="col-md-3"> 
                            <label class="control-label" >Total Uds</label><br />
                            <input type="text" name="numCantidad[]" id="numCantidad_{$num}" value="{$arrTipoV.numCantidad}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);
                                    sumaVentas();">
                        </div>                        
                        <div class="col-md-3"> 
                            <label class="control-label">Uds. Discapacitados</label><br />
                            <input type="text" name="numCantUdsDisc[]" id="numCantParqDisc_{$num}" value="{$arrTipoV.numCantUdsDisc}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">
                        </div> 
                        <div class="col-md-3"> 
                            <label class="control-label">Total Parq.</label><br />
                            <input type="text" name="numTotalParq[]" id="numTotalParq_{$num}" value="{$arrTipoV.numTotalParq}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">
                        </div> 
                        <div class="col-md-3"> 
                            <label class="control-label">Cant. Parq Discapacitados</label><br />
                            <input type="text" name="numCantParqDisc[]" id="numCantParqDisc_{$num}" value="{$arrTipoV.numCantParqDisc}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">
                        </div> 

                        <div class="col-md-3"> 
                            <label class="control-label">&Aacute;rea</label><br />
                            <input type="text" name="numArea[]" id="numArea_{$num}" value="{$arrTipoV.numArea}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">&nbsp;m²
                        </div> 
                        <div class="col-md-3"> 
                            <label class="control-label">A&ntilde;o Venta</label><br />
                            <input type="text" name="numAnoVenta[]" id="numAnoVenta_{$num}" value="{$arrTipoV.numAnoVenta}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">
                        </div>    
                        <div class="col-md-3"> 
                            <label class="control-label">Precio Venta</label><br />
                            $ <input type="text" name="valPrecioVenta[]" id="valPrecioVenta_{$num}" value="{$arrTipoV.valPrecioVenta}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);
                                    sumaVentas();">
                        </div> 
                        <div class="col-md-3"> 
                            <label class="control-label">Cierre</label><br />
                            $ <input type="text" name="valCierre[]" id="valCierre_{$num}" value="{$arrTipoV.valCierre}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                    soloNumeros(this);">
                        </div> 
                        <div class="col-md-6"> 
                            <label class="control-label">Descripci&oacute;n</label><br />
                            <textarea name="txtDescripcion[]" id="txtDescripcion_{$num}" style="width:380px" >{$arrTipoV.txtDescripcion}</textarea>
                        </div> 
                        <div class="col-md-2"> 
                            <label class="control-label">Eliminar</label><br />
                            <!--<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>-->
                            <img src="recursos/imagenes/remove.png" width="22px" onclick="return confirmaRemoverLineaFormulario(this);" style="position: relative; float: left; ">
                        </div> 
                        <p>&nbsp;</p>
                    </div>
                </td>
            </tr>
        {/foreach}
    </table>
</div>
</p>