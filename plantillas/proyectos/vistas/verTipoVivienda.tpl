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
    <table border="0" cellspacing="2" cellpadding="0"  id="tablaTipoVivienda" style="padding-left: 3px; width: 98%">
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
                                <input type="hidden" name="seqTipoVivienda[]" id="seqTipoVivienda" value="{$arrTipoV.seqTipoVivienda}" >
                                <p>{$arrTipoV.txtNombreTipoVivienda}</p>
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label" >Cantidad</label><br />
                                   <p>{$arrTipoV.numCantidad}</p>
                                            
                                            
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">&Aacute;rea</label><br />
                                    <p>{$arrTipoV.numArea}</p>
                                            
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">A&ntilde;o Venta</label><br />
                                    <p>{$arrTipoV.numAnoVenta}</p>
                                            
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">Precio Venta</label><br />
                                    </p> <strong>$</strong>{$arrTipoV.valPrecioVenta}</p>
                                            
                                            
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">Cierre</label><br />
                                    </p> <strong>$</strong>{$arrTipoV.valCierre}</p>
                                            
                                </div> 
                                <div class="col-md-4"> 
                                    <label class="control-label">Descripci&oacute;n</label><br />
                                    <p>{$arrTipoV.txtDescripcion}</p>
                                </div> 
                                <div class="col-md-2"> 
                                    <label class="control-label">Eliminar</label><br />
                                    <!--<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
                                    <img src="recursos/imagenes/remove.png" width="22px" onclick="return confirmaRemoverLineaFormulario(this);" style="position: relative; float: left; ">-->
                                </div> 
                                <p>&nbsp;</p>
                        </div>
                </td>
            </tr>
        {/foreach}
    </table>
</div>
</p>