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
                                <input type="text" name="txtNombreTipoVivienda[]" id="txtNombreTipoVivienda" value="{$arrTipoV.txtNombreTipoVivienda}" style="width:150px;" onblur="sinCaracteresEspeciales(this);">
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label" >Cantidad</label><br />
                                    <input type="text" name="numCantidad[]" id="numCantidad" value="{$arrTipoV.numCantidad}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);
                                            sumaVentas();">
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">&Aacute;rea</label><br />
                                    <input type="text" name="numArea[]" id="numArea" value="{$arrTipoV.numArea}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);">&nbsp;m²
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">A&ntilde;o Venta</label><br />
                                    <input type="text" name="numAnoVenta[]" id="numAnoVenta" value="{$arrTipoV.numAnoVenta}" style="width:50px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);">
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">Precio Venta</label><br />
                                    $ <input type="text" name="valPrecioVenta[]" id="valPrecioVenta" value="{$arrTipoV.valPrecioVenta}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);
                                            sumaVentas();">
                                </div> 
                                <div class="col-md-3"> 
                                    <label class="control-label">Cierre</label><br />
                                    $ <input type="text" name="valCierre[]" id="valCierre" value="{$arrTipoV.valCierre}" style="width:80px; text-align:right" onblur="sinCaracteresEspeciales(this);
                                            soloNumeros(this);">
                                </div> 
                                <div class="col-md-4"> 
                                    <label class="control-label">Descripci&oacute;n</label><br />
                                    <textarea name="txtDescripcion[]" id="txtDescripcion" style="width:260px" >{$arrTipoV.txtDescripcion}</textarea>
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