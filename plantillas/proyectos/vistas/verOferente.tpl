<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->
<link href="./recursos/estilos/contentProyects.css" rel="stylesheet">

{foreach from=$arrOferentesProy key=seqOferentesProy item=valueOferentesProy}
    <div>
        <fieldset>
            <legend class="legend">
                <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 5px; text-transform: capitalize">
                    Datos del Oferente {$valueOferentesProy.txtNombreOferente|capitalize|lower}
                </h4>
            </legend>
            <div  id="buildyourform">
                <div class="form-group" >
                    <div class="col-md-3"> 
                        <label class="control-label" >Nit Oferente </label> 
                        <p>{$valueOferentesProy.numNitOferente}&nbsp;</p>
                    </div>

                    <div class="col-md-3"> 
                        <label class="control-label" >Celular Oferente</label> 
                        <p>{$valueOferentesProy.numCelularOferente}&nbsp;</p>
                    </div>
                </div>
                <div class="form-group"  >
                    <div class="col-md-4"> 
                        <label class="control-label" >Correo Oferente</label> 
                        <p>{$valueOferentesProy.txtCorreoOferente}&nbsp;</p>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-3"> 
                        <label class="control-label" >Telefono-Ext</label> 
                        <p>{$valueOferentesProy.numTelefonoOferente} - {$valueOferentesProy.numExtensionOferente}&nbsp;</p>
                    </div>
                </div>

                <legend class="legend">
                    <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 2px;">
                        &nbsp;
                    </h4>
                </legend>
                <div class="form-group" >
                    <div class="col-md-5"> 
                        <label class="control-label" >Nombre Representante Legal</label> 
                        <p>{$valueOferentesProy.txtRepresentanteLegalOferente|upper}&nbsp;</p>
                    </div>

                    <div class="col-md-3"> 
                        <label class="control-label" >Nit  </label> 
                        <p>{$valueOferentesProy.numNitRepresentanteLegalOferente}&nbsp;</p>
                    </div>

                    <div class="col-md-3"> 
                        <label class="control-label" >Telefono  - Extensi&oacute;n</label> 
                        <p>{$valueOferentesProy.numTelefonoRepresentanteLegalOferente} - {$valueOferentesProy.numExtensionRepresentanteLegalOferente}&nbsp;</p>
                    </div>
                </div>
                <div class="form-group"  >
                    <div class="col-md-5"> 
                        <label class="control-label" >Correo </label> 
                        <p>{$valueOferentesProy.txtCorreoRepresentanteLegalOferente|upper}&nbsp;</p>
                    </div>

                    <div class="col-md-3"> 
                        <label class="control-label" >Celular </label> 
                        <p>{$valueOferentesProy.numCelularRepresentanteLegalOferente}&nbsp;</p>
                    </div>

                    <div class="col-md-3"> 
                        <label class="control-label" >Direcci&oacute;n</label> 
                        <p>{$valueOferentesProy.txtDireccionRepresentanteLegalOferente|upper}&nbsp;</p>
                    </div>
                </div> 
                <legend class="legend">
                    <h4 style="position: relative; float: left; width: 100%; margin: 0; padding: 2px;">
                        &nbsp;
                    </h4>
                </legend>
                <div class="form-group" >
                    <div class="col-md-5"> 
                        <label class="control-label" >Nombre de Contacto Oferente</label> 
                        <p>{$valueOferentesProy.txtNombreContactoOferente|upper}&nbsp;</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3"> 
                        <label class="control-label" >Correo Contacto Oferente</label> 
                        <p>{$valueOferentesProy.txtCorreoOferente}&nbsp;</p>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-3"> 
                        <label class="control-label" >Telefono  Contacto Oferente</label> 
                        <p>{$valueOferentesProy.numTelContactoOferente}&nbsp;</p>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <p>&nbsp;</p>
{/foreach}