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
                            <input type="text" name="txtNombreProyectoHijo[]" id="txtNombreProyectoHijo" value="{$arrConjunto.txtNombreProyecto}" size='28' onblur="sinCaracteresEspeciales(this);">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Nombre Comercial</label><br />
                            <input type="text" name="txtNombreComercialHijo[]" id="txtNombreComercialHijo" value="{$arrConjunto.txtNombreComercial}" size='28' onblur="sinCaracteresEspeciales(this);">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Direcci&oacute;n&nbsp;del&nbsp;Conjunto</label><br />                            
                            <input type="text" name='txtDireccionHijo[]' id="txtDireccionHijo[]" value="{$arrConjunto.txtDireccion}" size="20" style="background-color:#E4E4E4;" readonly />
                            <a href="#" onClick="recogerDireccion('txtDireccionHijo[]', 'objDireccionOculto')"><img src="recursos/imagenes/icono_lupa.gif"></a>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Unidades</label><br />
                            <input type='text' name='valNumeroSolucionesHijo[]' id='valNumeroSolucionesHijo' value="{$arrConjunto.valNumeroSoluciones}" onBlur='sinCaracteresEspeciales(this);' size='6' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Chip</label><br />
                            <input type='text' name='txtChipLoteHijo[]' id='txtChipLoteHijo' value="{$arrConjunto.txtChipLote}" onBlur='sinCaracteresEspeciales(this);' size='13' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Matr&iacute;cula Inmobiliaria</label><br />            
                            <input type='text' name='txtMatriculaInmobiliariaLoteHijo[]' id='txtMatriculaInmobiliariaLoteHijo' value="{$arrConjunto.txtMatriculaInmobiliariaLote}" size='13' onBlur='sinCaracteresEspeciales(this);' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Lic. Urbanismo</label><br />             
                            <input type='text' name='txtLicenciaUrbanismoHijo[]' id='txtLicenciaUrbanismoHijo' value="{$arrConjunto.txtLicenciaUrbanismo}" onBlur='sinCaracteresEspeciales(this);' size='18' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Licencia</label><br />           
                            <input name="fchLicenciaUrbanismo1Hijo[]" type="text" id="fchLicenciaUrbanismo1Hijo[]" value="{$arrConjunto.fchLicenciaUrbanismo1}" size="12" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchLicenciaUrbanismo1Hijo[]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                            <input name="fchVigenciaLicenciaUrbanismoHijo[]" type="text" id="fchVigenciaLicenciaUrbanismoHijo[]" value="{$arrConjunto.fchVigenciaLicenciaUrbanismo}" size="12" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchVigenciaLicenciaUrbanismoHijo[]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Curadur&iacute;a</label><br />

                            <input type='text' name='txtExpideLicenciaUrbanismoHijo[]' id='txtExpideLicenciaUrbanismoHijo' value="{$arrConjunto.txtExpideLicenciaUrbanismo}" onBlur='sinCaracteresEspeciales(this);' size='13' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Lic. Construcci&oacute;n</label><br />            
                            <input type='text' name='txtLicenciaConstruccionHijo[]' id='txtLicenciaConstruccionHijo' value="{$arrConjunto.txtLicenciaConstruccion}" onBlur='sinCaracteresEspeciales(this);' size='18' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Licencia</label><br />             
                            <input name="fchLicenciaConstruccion1Hijo[]" type="text" id="fchLicenciaConstruccion1Hijo[]" value="{$arrConjunto.fchLicenciaConstruccion1}" size="12" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchLicenciaConstruccion1Hijo[]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                            <input name="fchVigenciaLicenciaConstruccionHijo[]" type="text" id="fchVigenciaLicenciaConstruccionHijo[]" value="{$arrConjunto.fchVigenciaLicenciaConstruccion}" size="12" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchVigenciaLicenciaConstruccionHijo[]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3"> 
                            <label class="control-label" >Vendedor</label><br /> 
                            <input type='text' name='txtNombreVendedorHijo[]' id='txtNombreVendedorHijo' value="{$arrConjunto.txtNombreVendedor}" onBlur='sinCaracteresEspeciales(this);' size='20' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >NIT Vendedor</label><br />
                            <input type='text' name='numNitVendedorHijo[]' id='numNitVendedorHijo' value="{$arrConjunto.numNitVendedor}" onBlur='sinCaracteresEspeciales(this);' size='12' >
                        </div>
                        <div class="col-md-3">                            
                            <label class="control-label" >C&eacute;dula Catastral</label><br />
                            <input type='text' name='txtCedulaCatastralHijo[]' id='txtCedulaCatastralHijo' value="{$arrConjunto.txtCedulaCatastral}" onBlur='sinCaracteresEspeciales(this);' size='22' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Escritura</label><br /> 
                            <input type='text' name='txtEscrituraHijo[]' id='txtEscrituraHijo' value="{$arrConjunto.txtEscritura}" onBlur='sinCaracteresEspeciales(this);' size='12' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Escritura</label><br /> 
                            <input name="fchEscrituraHijo[]" type="text" id="fchEscrituraHijo[]" value="{$arrConjunto.fchEscritura}" size="12" style="text-align:center; background-color:#E4E4E4" readonly /><a href="#" onClick="javascript: calendarioPopUp('fchEscrituraHijo[]');"><img src="recursos/imagenes/calendar.png"></a>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >No. Notar&iacute;a</label><br />
                            <input type='text' name='numNotariaHijo[]' id='numNotariaHijo' value="{$arrConjunto.numNotaria}" onBlur='sinCaracteresEspeciales(this);' size='12' >
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Eliminar</label><br />     
                            <img src="recursos/imagenes/remove.png" width="22px" onclick="return confirmaRemoverLineaFormulario(this);" style="position: relative; float: left; width:15% ">

                        </div>
                        <p>&nbsp;</p>
                    </div>
                </td>
                <!---->
            </tr>

        {/foreach}
    </table>
</div>
</p>