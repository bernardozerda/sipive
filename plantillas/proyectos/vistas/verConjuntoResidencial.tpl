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
                            <label class="control-label" >Unidades</label><br />
                            <p>{$arrConjunto.valNumeroSoluciones}</p>
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
                            <label class="control-label" >Lic. Urbanismo</label><br />             
                            <p>{$arrConjunto.txtLicenciaUrbanismo}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Licencia</label><br />           
                            <p>{$arrConjunto.fchLicenciaUrbanismo1}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                            <p>{$arrConjunto.fchVigenciaLicenciaUrbanismo}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Curadur&iacute;a</label><br />

                           <p>{$arrConjunto.txtExpideLicenciaUrbanismo}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Lic. Construcci&oacute;n</label><br />            
                            <p>{$arrConjunto.txtLicenciaConstruccion}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Fecha&nbsp;Licencia</label><br />             
                            <p>{$arrConjunto.fchLicenciaConstruccion1}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >Vigencia&nbsp;Licencia</label><br />            
                            <p>{$arrConjunto.fchVigenciaLicenciaConstruccion}</p>
                        </div>
                        <div class="col-md-3"> 
                            <label class="control-label" >Vendedor</label><br /> 
                            <p>{$arrConjunto.txtNombreVendedor}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" >NIT Vendedor</label><br />
                            <p>{$arrConjunto.numNitVendedor}</p>
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
                        <!--<div class="col-md-3">
                            <label class="control-label" >Eliminar</label><br />     
                            <img src="recursos/imagenes/remove.png" width="22px" onclick="return confirmaRemoverLineaFormulario(this);" style="position: relative; float: left; width:15% ">

                        </div>-->
                        <p>&nbsp;</p>
                    </div>
                </td>
                <!---->
            </tr>

        {/foreach}
    </table>
</div>
</p>