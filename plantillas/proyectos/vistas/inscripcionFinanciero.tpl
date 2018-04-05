<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Datos Del Interventor</h4>
    </legend>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Nombre Interventor</label> 
            <input name="txtNombreInterventor" type="text" id="txtNombreInterventor" value="{$value.txtNombreInterventor}" onblur="sinCaracteresEspeciales(this);"  class="form-control">
        </div>        

        <div class="col-md-4"> 
            <label class="control-label"  onclick="recogerDireccion('txtDireccionInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n</label>                         
            <input type="text" name="txtDireccionInterventor" id="txtDireccionInterventor" value="{$value.txtDireccionInterventor}" style="width:120px; background-color:#ADD8E6;" readonly="" class="form-control">
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Correo Electronico</label> 
            <input name="txtCorreoInterventor" type="text" id="txtCorreoInterventor" value="{$value.txtCorreoInterventor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
        <div class="col-md-4">
            Natural <input name="bolTipoPersonaInterventor" type="radio" id="bolTipoPersonaInterventor" onclick="escondeCamposTipoPersona(this.value)" value="1" checked="" > 
            Jurídica <input name="bolTipoPersonaInterventor" type="radio" onclick="escondeCamposTipoPersona(this.value)" id="bolTipoPersonaInterventor1" value="0"> 
        </div>
        <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural"> 
            <label class="control-label" >Numero Identificaci&oacute;n</label> 
            <input name="numCedulaInterventor" type="text" id="numCedulaInterventor" value="{$value.numCedulaInterventor}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" class="form-control">
        </div>
        <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural"> 
            <label class="control-label" >Tarjeta Profesional</label> 
            <input name="numTProfesionalInterventor" type="text" id="numTProfesionalInterventor" value="{$value.numTProfesionalInterventor}" onblur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control">
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >NIT</label>
            <input name="numNitInterventor" type="text" id="numNitInterventor" value="{$value.numNitInterventor}" onblur="sinCaracteresEspeciales(this);
                    soloNit(this);" style="width:200px;" class="form-control">
        </div>       
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none"> 
            <label class="control-label" >Nombre Representante Legal</label>
            <input name="txtNombreRepLegalInterventor" type="text" id="txtNombreRepLegalInterventor" value="{$value.txtNombreRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control"/>
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >Tel&eacute;fono</label>
            <input name="numTelefonoRepLegalInterventor" type="text" id="numTelefonoRepLegalInterventor" value="{$value.numTelefonoRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control"/>
        </div>

        <div class="col-md-4 lineaPersonaJuridica"  style="display: none"> 
            <label class="control-label"  onclick="recogerDireccion('txtDireccionRepLegalInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n </label>                         
            <input type="text" name="txtDireccionRepLegalInterventor" id="txtDireccionRepLegalInterventor" value="{$value.txtDireccionRepLegalInterventor}" style="width:200px; background-color:#ADD8E6;" readonly="" class="form-control">
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >Correo electr&oacute;nico</label>
            <input name="txtCorreoRepLegalInterventor" type="text" id="txtCorreoRepLegalInterventor" value="{$value.txtCorreoRepLegalInterventor}" onBlur="sinCaracteresEspeciales(this);" style="width:200px;" class="form-control"/>
        </div>
    </div>
</fieldset>
<!--<p style="width: 100%; border-bottom: 1px solid #e5e5e5">&nbsp;</p>
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Ventas Del Proyecto</h4>
    </legend>
    <div class="form-group" >
        <div class="col-md-6"> 
            <label class="control-label" >INGRESO VENTAS PROYECTADO</label>
            <input name="valTotalVentas" type="text" id="valTotalVentas" value="13924734720.00000000" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" style="width:180px; text-align:right; font-weight: bold" readonly="" class="form-control"/>
        </div>
    </div> 
</fieldset>-->
<p style="width: 100%; border-bottom: 1px solid #e5e5e5">&nbsp;</p>
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Costos del Proyecto</h4>                                 
    </legend>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Costos Directos</label>  
            <b>$</b><input name="valCostosDirectos" type="text" id="valCostosDirectos" value="{$value.valCostosDirectos}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalCostos();" style="width:180px; text-align:right" class="form-control" />
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Costos Indirectos</label>  
            <b>$</b><input name="valCostosIndirectos" type="text" id="valCostosIndirectos" value="{$value.valCostosIndirectos}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalCostos();" style="width:180px; text-align:right" class="form-control" />
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Terreno</label> 
            <b>$</b><input name="valTerreno" type="text" id="valTerreno" value="{$value.valTerreno}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalCostos();" style="width:180px; text-align:right" class="form-control"/>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Gastos financieros</label>
            <b>$</b><input name="valGastosFinancieros" type="text" id="valGastosFinancieros" value="{$value.valGastosFinancieros}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalCostos();" style="width:180px; text-align:right" class="form-control" />
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Gastos de Ventas</label> 
            <b>$</b><input name="valGastosVentas" type="text" id="valGastosVentas" value="{$value.valGastosVentas}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalCostos();" style="width:180px; text-align:right" class="form-control"/>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >COSTO TOTAL DEL PROYECTO</label>  
            <b>$</b><input name="valTotalCostos" type="text" id="valTotalCostos" value="{$value.valTotalCostos}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" style="width:180px; text-align:right; font-weight: bold" readonly="" class="form-control"/>
        </div>
    </div> 
</fieldset>
<p style="width: 100%; border-bottom: 1px solid #e5e5e5">&nbsp;</p>
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Fuentes de Financiaci&oacute;n</h4>                                 
    </legend>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Recursos Propios</label> 
            <input name="valRecursosPropios" type="text" id="valRecursosPropios" value="{$value.valRecursosPropios}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control" />
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Crédito Entidad Financiera</label>
            <input name="valCreditoEntidadFinanciera" type="text" id="valCreditoEntidadFinanciera" value="{$value.valCreditoEntidadFinanciera}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control"/>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Crédito Particulares</label>
            <input name="valCreditoParticulares" type="text" id="valCreditoParticulares" value="{$value.valCreditoParticulares}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control" />
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Ventas del Proyecto</label>
            <input name="valVentasProyecto" type="text" id="valVentasProyecto" value="{$value.valVentasProyecto}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right"class="form-control" />
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >SDVE</label> 
            <input name="valSDVE" type="text" id="valSDVE" value="{$value.valSDVE}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control" />
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Otros</label>
            <input name="valOtros" type="text" id="valOtros" value="{$value.valOtros}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control" />
        </div>
    </div>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Devoluci&oacute;n de IVA</label>
            <input name="valDevolucionIVA" type="text" id="valDevolucionIVA" value="{$value.valDevolucionIVA}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);
                    sumaTotalRecursos();" style="width:150px; text-align:right" class="form-control" />
        </div>
    </div>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Total Recursos</label>
            <input name="valTotalRecursos" type="text" id="valTotalRecursos" value="{$value.valTotalRecursos}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" style="width:150px; text-align:right; font-weight: bold" readonly="" class="form-control" />
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >INGRESO VENTAS PROYECTADO</label>
            <input name="valTotalVentas" type="text" id="valTotalVentas" value="{if $value.valTotalVentas == ""}0{else}{$value.valTotalVentas}{/if}" onblur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" style="width:180px; text-align:right; font-weight: bold" readonly="" class="form-control"/>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" > TOTAL UTILIDAD</label>
            $ <input name="valUtilidadProyecto" type="text" id="valUtilidadProyecto" value="{if $value.valUtilidadProyecto == ""}0{else}{$value.valUtilidadProyecto}{/if}" onBlur="sinCaracteresEspeciales(this);
                    soloNumeros(this);" style="width:90px; text-align:right; font-weight: bold" readonly />
        </div>
    </div>
</fieldset>
<p style="width: 100%;">&nbsp;</p>
