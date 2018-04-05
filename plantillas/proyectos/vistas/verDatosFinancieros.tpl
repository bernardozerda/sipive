
<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Datos Del Interventor</h4>
    </legend>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Nombre Interventor</label> 
            <p>{$value.txtNombreInterventor}</p>
        </div>        

        <div class="col-md-4"> 
            <label class="control-label"  onclick="recogerDireccion('txtDireccionInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n</label>                         
            <p>{$value.txtDireccionInterventor}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Correo Electronico</label> 
            <p>{$value.txtCorreoInterventor}</p>
        </div>
        <div class="col-md-4">
            Natural <input name="bolTipoPersonaInterventor" type="radio" id="bolTipoPersonaInterventor" onclick="escondeCamposTipoPersona(this.value)" value="1" checked="" > 
            Jurídica <input name="bolTipoPersonaInterventor" type="radio" onclick="escondeCamposTipoPersona(this.value)" id="bolTipoPersonaInterventor1" value="0"> 
        </div>
        <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural"> 
            <label class="control-label" >Numero Identificaci&oacute;n</label> 
            <p>{$value.numCedulaInterventor}</p>
        </div>
        <div class="col-md-4 lineaPersonaNatural" id="lineaPersonaNatural"> 
            <label class="control-label" >Tarjeta Profesional</label> 
            <p>$value.numTProfesionalInterventor}</p>
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >NIT</label>
            <p>{$value.numNitInterventor}</p>
        </div>       
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none"> 
            <label class="control-label" >Nombre Representante Legal</label>
           <p>{$value.txtNombreRepLegalInterventor}</p>
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >Tel&eacute;fono</label>
            <p>{$value.numTelefonoRepLegalInterventor}</p>
        </div>

        <div class="col-md-4 lineaPersonaJuridica"  style="display: none"> 
            <label class="control-label"  onclick="recogerDireccion('txtDireccionRepLegalInterventor', 'objDireccionOcultoSolucion');" style="cursor: hand; text-decoration-line: underline">Direcci&oacute;n </label>                         
           <p>{$value.txtDireccionRepLegalInterventor}</p>
        </div>
        <div class="col-md-4 lineaPersonaJuridica"  style="display: none">
            <label class="control-label" >Correo electr&oacute;nico</label>
           <p>{$value.txtCorreoRepLegalInterventor}</p>
        </div>
    </div>
</fieldset>

<p style="width: 100%; border-bottom: 1px solid #e5e5e5">&nbsp;</p>
<fieldset>
    <legend class="legend">
        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
            Costos del Proyecto</h4>                                 
    </legend>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Costos Directos</label>  
            <p><b>$</b> {$value.valCostosDirectos}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Costos Indirectos</label>  
            <p><b>$</b> {$value.valCostosIndirectos}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Terreno</label> 
            <p><b>$</b> {$value.valTerreno}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Gastos financieros</label>
            <p><b>$</b> {$value.valGastosFinancieros}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >Gastos de Ventas</label> 
            <p><b>$</b> {$value.valGastosVentas}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >COSTO TOTAL DEL PROYECTO</label>  
            <p><b>$</b> {$value.valTotalCostos}</p>
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
           <p>{$value.valRecursosPropios}</p>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Crédito Entidad Financiera</label>
           <p>{$value.valCreditoEntidadFinanciera}</p>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Crédito Particulares</label>
            <p>{$value.valCreditoParticulares}</p>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Ventas del Proyecto</label>
            <p>{$value.valVentasProyecto}</p>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >SDVE</label> 
           <p>{$value.valSDVE}</p>
        </div>
    </div>   
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Otros</label>
           <p>{$value.valOtros}</p>
        </div>
    </div>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Devoluci&oacute;n de IVA</label>
            <p>{$value.valDevolucionIVA}</p>
        </div>
    </div>
    <div class="form-group" >
        <div class="col-md-4"> 
            <label class="control-label" >Total Recursos</label>
            <p>{$value.valTotalRecursos}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" >INGRESO VENTAS PROYECTADO</label>
           <p>{if $value.valTotalVentas == ""}0{else}{$value.valTotalVentas}{/if}</p>
        </div>
        <div class="col-md-4"> 
            <label class="control-label" > TOTAL UTILIDAD</label>
            <p><b>$</b> {if $value.valUtilidadProyecto == ""}0{else}{$value.valUtilidadProyecto}{/if}</p>
        </div>
    </div>
</fieldset>
<p style="width: 100%;">&nbsp;</p>