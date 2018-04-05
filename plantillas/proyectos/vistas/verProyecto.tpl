<!-- FORMULARIO DE INSCRIPCION CON SEGUIMIENTO -->


<form name="frmProyectos" id="frmProyectos" onSubmit="return false;" method="$_POST" >
    <!-- CODIGO PARA EL POPUP DE SEGUIMIENTO -->
    {foreach from=$arrProyectos key=key item=value} 
        {assign var=seqPryEstadoProceso value=$value.seqPryEstadoProceso}

        {if $value.seqPryEstadoProceso != "" }
            {assign var=seqPryEstadoProceso value=$value.seqPryEstadoProceso}
        {else}
            {assign var=seqPryEstadoProceso value = 1}
        {/if}

        <div id="wrapper" class="container tab-content">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item" >
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="home" aria-selected="true" >Datos Básicos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#licencias" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 0 0 0;">Oferentes <br></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#financiero" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 0 0 0;">Datos <br>Financieros</a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tiposVivienda" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 0 0 0;"><em>Tipos<br> Vivienda</em></a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#conjuntosResidenciales" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 0 0 0;"><em>Conjuntos Residenciales</em></a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#datosCronograma" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 0 0 0;"><em>Cronograma <br></em></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#seg" role="tab" aria-controls="profile" aria-selected="false" style="border-radius: 0 15px 0 0;">Seguimientos <br></a>
                </li>
            </ul>
            <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="home-tab">
                <fieldset>
                    <legend style="text-align: left" class="legend">
                        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                            Datos del Proyecto 
                        </h4>
                        <h6 style="position: relative; float: right; width: 50%; margin: 0; padding: 0;">
                            <input type="hidden" id="seqProyecto" name="seqProyecto" value="{if $value.seqProyecto != ""}{$value.seqProyecto}{else}0{/if}" > 
                            <input type="hidden" id="seqUsuario" name="seqUsuario" value="{$seqUsuario}" >               
                            <input type="hidden" id="txtArchivo" name="txtArchivo" value="./contenidos/administracionProyectos/salvarProyecto.php">
                        </h6>
                    </legend>
                    <div id="divContent">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label">Nombre Comit&eacute; Elegibilidad </label>
                                <p>{$value.txtNombreProyecto}&nbsp;</p>                               
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label" ><div id="idTituloPlanParcial">Nombre del Plan Parcial</div></label>    
                                {if $arrPrivilegios.editar == 1}
                                    {assign var=soloLectura value=""}
                                {else}
                                    {assign var=soloLectura value="readonly"}
                                {/if}
                                <input type="hidden" 
                                       name="numNitProyecto" 
                                       id="numNitProyecto" 
                                       value="{if $value.numNitProyecto == ""}0{else}{$value.numNitProyecto}{/if}"
                                       onFocus="this.style.backgroundColor = '#ADD8E6';" 
                                       onBlur="soloNumeros(this);
                                               this.style.backgroundColor = '#FFFFFF';"
                                       onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
                                       style="width:100px; text-align: right;"
                                       readonly
                                       />

                                <p>{$value.txtNombrePlanParcial|upper}&nbsp;</p>

                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Nombre Comercial</label>   
                                <p>{$value.txtNombreComercial|upper}&nbsp;</p>
                            </div>
                        </div>
                        <div class="form-group"  id="idLineaTipoSolucionDescripcion">
                            <div class="col-md-3"> 
                                <label class="control-label" >Descripci&oacute;n del Proyecto</label>
                                <p>{$value.txtDescripcionProyecto|upper}&nbsp;</p>
                            </div>
                        </div> 
                        <!-- TIPO DE MODALIDAD -->
                        <div class="form-group" >
                            <div class="col-md-3" > 
                                <label class="control-label" >Tipo de Modalidad </label>                              
                                {foreach from=$arrPryTipoModalidad key=seqPryTipoModalidad item=txtPryTipoModalidad}
                                    {if $value.seqPryTipoModalidad == $seqPryTipoModalidad}
                                        <p>{$txtPryTipoModalidad|upper}&nbsp;</p> 
                                    {/if}

                                {/foreach}                                   
                            </div>
                        </div>
                        <!-- NOMBRE DE LA OPV -->
                        <div class="form-group" id="lineaOpv" style="display:none" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Nombre de la OPV </label> 
                                {foreach from=$arrOpv key=seqOpv item=txtNombreOpv}
                                    {if $value.seqOpv == $seqOpv} 
                                        <p>{$txtNombreOpv|upper}&nbsp;</p>
                                    {/if}
                                {/foreach}                              
                            </div>
                        </div>
                        <div class="form-group"  id="lineaTDirigida" style="display:none">
                            <div class="col-md-3"> 
                                <label class="control-label" >Nombre del Operador </label>    
                                <p>{$value.txtNombreOperador|upper}&nbsp;</p>
                            </div>
                        </div>             
                        <div class="form-group"  id="lineaTDirigida" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Objeto del Proyecto </label>   
                                <p>{$value.txtObjetoProyecto|upper}&nbsp;</p>                             
                            </div>
                        </div>
                        <div class="form-group" id="idLineaProyectoUrbanizacion">
                            <div class="col-md-3"> 
                                <label class="control-label" >Tipo de Proyecto </label>                                
                                {foreach from=$arrTipoProyecto key=seqTipoProyecto item=txtTipoProyecto}
                                    {if $value.seqTipoProyecto == $seqTipoProyecto} 
                                        <p>{$txtTipoProyecto}&nbsp;</p>
                                    {/if}
                                {/foreach}            
                            </div>
                        </div>
                        <div class="form-group" id="idLineaProyectoUrbanizacion" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Tipo de Urbanizaci&oacute;n </label>                                   
                                {foreach from=$arrTipoUrbanizacion key=seqTipoUrbanizacion item=txtTipoUrbanizacion}
                                    {if $value.seqTipoUrbanizacion == $seqTipoUrbanizacion} 
                                        <p>{$txtTipoUrbanizacion|upper}&nbsp;</p>
                                    {/if}                                        
                                {/foreach}
                            </div>
                        </div> 
                        <div class="form-group" id="idLineaTipoSolucionDescripcion">
                            <div class="col-md-3"> 
                                <label class="control-label" >Tipo de Soluci&oacute;n </label>                                
                                {foreach from=$arrTipoSolucion key=seqTipoSolucion item=txtTipoSolucion}
                                    {if $value.seqTipoSolucion == $seqTipoSolucion} 
                                        <p>{$txtTipoSolucion|upper}&nbsp;</p>
                                    {/if}
                                {/foreach}                       
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Localidad </label>                                 
                                {foreach from=$arrLocalidad key=seqLocalidad item=txtLocalidad}
                                    {if $value.seqLocalidad == $seqLocalidad}  
                                        <p>{$txtLocalidad|upper}&nbsp;</p> 
                                    {/if}
                                {/foreach}
                            </div>
                        </div>  
                        <div class="form-group" >
                            <div class="col-md-3" > 
                                <label class="control-label" >Barrio </label> 
                                {foreach from=$arrBarrio key=seqBarrio item=txtBarrio}
                                    {if $value.seqBarrio == $seqBarrio} 
                                        <p>{$txtBarrio|upper}&nbsp;</p>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Otros Barrios</label> 
                                <p>{$value.txtOtrosBarrios|upper}&nbsp;</p>
                            </div>
                        </div>                            
                        <div class="form-group"  id="lineaTituloDireccion" {if $value.bolDireccion == 0} style="display: none"{/if}>
                            <div class="col-md-3"> 
                                <label class="control-label">Direcci&oacute;n</label>                         
                                <p>{$value.txtDireccion|upper}&nbsp;</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"> 
                                <label class="control-label" >N&uacute;mero Soluciones </label>    
                                <p>{$value.valNumeroSoluciones|upper}&nbsp;</p>                                      
                                <input name="valSalarioMinimo" type="hidden" id="valSalarioMinimo" value="{$valSalarioMinimo}"  class="form-control"/>
                                <input name="numSubsidios" type="hidden" id="numSubsidios" value="{$numSubsidios}"  class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Torres </label> 
                                <p>{$value.valTorres}&nbsp;</p>

                            </div>
                        </div> 
                        <div class="form-group" id="idLineaAreaLoteConstruida">
                            <div class="col-md-3"> 
                                <label class="control-label" >Area Lote en <b>m²</b> </label> 
                                <p>{$value.valAreaLote}&nbsp;</p>
                            </div>
                        </div>
                        <div class="form-group" id="idLineaAreaLoteConstruida">
                            <div class="col-md-3"> 
                                <label class="control-label" >Area a Construir en <b>m²</b> </label> 
                                <p>{$value.valAreaConstruida}&nbsp;</p>

                            </div>
                        </div> 
                        <div class="form-group" id="idLineaChipLoteMatricula" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Chip Lote</label>
                                <p>{$value.txtChipLote|upper}&nbsp;</p>
                            </div>
                        </div>
                        <div class="form-group" id="idLineaChipLoteMatricula"  >
                            <div class="col-md-3"> 
                                <label class="control-label" >Matr&iacute;cula Inmobiliaria Lote </label>  
                                <p>{$value.txtMatriculaInmobiliariaLote|upper}&nbsp;</p>

                            </div>
                        </div>  
                        <div class="form-group" id="idLineaRegistroFechaEnajenacion">
                            <div class="col-md-3"> 
                                <label class="control-label" >Registro de Enajenaci&oacute;n </label> 
                                <p>{$value.txtRegistroEnajenacion|upper}&nbsp;</p>

                            </div>
                        </div>  
                        <div class="form-group" id="idLineaRegistroFechaEnajenacion">
                            <div class="col-md-3"> 
                                <label class="control-label" >Fecha Registro de Enajenaci&oacute;n  </label>  
                                <p>{$value.fchRegistroEnajenacion}&nbsp;</p>

                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Nombre del Tutor </label>
                                {foreach from=$arrTutorProyecto key=seqTutorProyecto item=txtTutorProyecto}
                                    {if $value.seqTutorProyecto == $seqTutorProyecto} 
                                        <p>{$txtTutorProyecto|upper}&nbsp;</p>
                                    {/if}
                                {/foreach}          
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-md-3"> 
                                <label class="control-label" >Constructor </label>                                     
                                {foreach from=$arrConstructor key=seqConstructor item=txtNombreConstructor}
                                    {if $value.seqConstructor == $txtNombreConstructor.seqConstructor}
                                        <p>{$txtNombreConstructor.txtNombreConstructor|upper}&nbsp;</p>
                                    {/if}                                           
                                {/foreach}
                            </div>
                        </div>

                        <div class="form-group"  id="idTituloDescEquipamientoComunal" {if $value.bolEquipamientoComunal == 0} style="display: none" {/if}>
                            <div class="col-md-3"> 
                                <label class="control-label" >Descripci&oacute;n Equipamiento Comunal</label> 
                                <p>{$value.txtDescEquipamientoComunal|upper}&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <p>&nbsp;</p>
                {foreach from=$arrayLicencias key=keyLic item=valueLic}
                    {if $valueLic.seqTipoLicencia == 1 || $valueLic.seqTipoLicencia =="" }
                        <fieldset>
                            <legend class="legend">
                                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                                    Licencia de Urbanismo</h4>
                            </legend>
                            <div class="form-group">
                                <div class="col-md-4"> 
                                    <label class="control-label">N&uacute;mero de Licencia</label> 
                                    <p>{$valueLic.txtLicencia}</p>
                                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="1" >
                                </div>        

                                <div class="col-md-4"> 
                                    <label class="control-label">Entidad Expedici&oacute;n</label>                         
                                    <p>{$valueLic.txtExpideLicencia}</p>
                                </div>
                                <div class="col-md-4"> 
                                    <label class="control-label">Fecha de Licencia</label> 
                                    <p>{$valueLic.fchLicencia}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Vigencia de Licencia</label> 
                                    <p>{$valueLic.fchVigenciaLicencia}</p>
                                </div>
                                <div class="col-md-4"> 
                                    <label class="control-label">Fecha Ejecutoria</label> 
                                    <p>{$valueLic.fchEjecutoriaLicencia}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                                    <p>{$valueLic.txtResEjecutoria}</p>
                                </div>   
                                <div class="col-md-4"> 
                                    <label class="control-label">Fecha Prórroga</label> 
                                    <p>{$valueLic.fchProrroga}</p> 
                                </div>
                            </div>
                        </fieldset>
                    {/if}
                    <br/>    
                    {if $valueLic.seqTipoLicencia == 2 || $valueLic.seqTipoLicencia ==""}
                        <fieldset>
                            <legend class="legend">
                                <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                                    Licencia de Contrucci&oacute;n</h4>
                            </legend>
                            <div class="form-group">
                                <div class="col-md-4"> 
                                    <label class="control-label">N&uacute;mero de Licencia</label> 
                                    <p>{$valueLic.txtLicencia}</p>
                                    <input type="hidden" name="seqProyectoLicencia[]" id="seqProyectoLicencia[]" value="{$valueLic.seqProyectoLicencia}" >
                                    <input type="hidden" name="seqTipoLicencia[]" id="seqTipoLicencia[]" value="2" >
                                </div>
                                <div class="col-md-4" style="display: none"> 
                                    <label class="control-label">Entidad Expedici&oacute;n</label>                         
                                    <p>{$valueLic.txtExpideLicencia}</p>
                                </div>
                                <div class="col-md-4"> 
                                    <label class="control-label">Fecha de Licencia</label> 
                                    <p>{$valueLic.fchLicencia}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Vigencia de Licencia</label> 
                                    <p>{$valueLic.fchVigenciaLicencia}</p>
                                </div>

                                <div class="col-md-4"  style="display: none"> 
                                    <label class="control-label">Fecha Ejecutoria</label> 
                                    <p>{$valueLic.fchEjecutoriaLicencia}</p>
                                </div>
                                <div class="col-md-4"  style="display: none">
                                    <label class="control-label">Resoluci&oacute;n Ejecutoria</label>
                                    <p>{$valueLic.txtResEjecutoria}</p>
                                </div>   
                                <div class="col-md-4"> 
                                    <label class="control-label">Fecha Prórroga</label> 
                                    <p>{$valueLic.fchProrroga}</p>
                                </div>
                            </div>
                        </fieldset>
                    {/if}
                {/foreach}
                <p style="width: 100%;">&nbsp;</p>
                <fieldset>
                    <legend class="legend">
                        <h4 style="position: relative; float: left; width: 50%; margin: 0; padding: 5px;">
                            Escrituraci&oacute;n</h4>
                    </legend>
                    <div class="form-group">
                        <div class="col-md-8"> 
                            <label class="control-label">Nombre del vendedor</label> 
                            <p>{$value.txtNombreVendedor}</p>
                        </div>
                        <div class="col-md-3"> 
                            <label class="control-label">Nit</label>                         
                            <p>{$value.numNitVendedor}</p>
                        </div>
                        <div class="col-md-3"> 
                            <label class="control-label">Cédula Catastral</label> <br>
                            <p>{$value.txtCedulaCatastral}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">No. Escritura</label><br> 
                            <p>{$value.txtEscritura} Del {$value.fchEscritura}<p>

                        </div>  
                        <div class="col-md-3"> 
                            <label class="control-label">No. Notaría</label> 
                            <p>{$value.numNotaria}</p>
                        </div>
                    </div>
                </fieldset>

            </div>
            <div id="seg" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                <div class="form-group" >
                    <div class="col-md12" style="padding: 20px"> 
                        {include file="seguimientoProyectos/seguimientoFormulario.tpl"}
                        <div id="contenidoBusqueda" >
                            {include file="seguimientoProyectos/buscarSeguimiento.tpl"}
                        </div>                 
                    </div>
                </div> 
            </div>
            <div id="licencias" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                {include file="proyectos/vistas/verOferente.tpl"}
            </div> 
            <div id="financiero" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                {include file="proyectos/vistas/verDatosFinancieros.tpl"}                
            </div> 
            <!-- TIPOS DE VIVIENDA (ESTRUCTURA DEL PROYECTO) -->
            <div id="tiposVivienda" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                {include file="proyectos/vistas/verTipoVivienda.tpl"}
            </div>

            <!-- CONJUNTOS RESIDENCIALES (SUBPROYECTOS) -->
            <div id="conjuntosResidenciales" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                {include file="proyectos/vistas/verConjuntoResidencial.tpl"}
            </div>

            <!-- CRRONOGRAMA DE OBRAS -->
            <div id="datosCronograma" class="tab-pane"  role="tabpanel" aria-labelledby="profile-tab" style="max-height: 550px; overflow-y: scroll">
                {include file="proyectos/secCronogramaFechas.tpl"}
            </div>
        {/foreach}
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">HISTORIAL DE SEGUIMIENTOS</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 45%">
                        {foreach from=$arrayDocumentos key=keyDoc item=valueDoc}
                            <div class="form-group" >                       
                                <div class="col-md-8" style="text-align: left"> 
                                    <label class="control-label" >{$valueDoc.txtNombreDocumento}</label>  
                                </div>
                                <div class="col-md-3" style="text-align: left; ">                            
                                    <input type="file" id="file" name="file">
                                    <input type="hidden" name="documentId_{$value.seqProyecto}[{$valueDoc.seqDocumento}]" value="{$valueDoc.seqDocumento}" />
                                </div> 
                                <div class="col-md-1" style="text-align: left"> 
                                    <input type="checkbox" name="document_{$value.seqProyecto}[{$valueDoc.seqDocumento}]"  value="{$valueDoc.seqDocumento}" {if $valueDoc.bolEstado == 1 } checked {/if}/>                           
                                </div>
                            </div>  
                        {/foreach}
                    </div>                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="postulacionTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>
<!-- ******************************************** INICIO DE MODALES INFORMATIVOS ********************************* -->

<!-- Modal -->

