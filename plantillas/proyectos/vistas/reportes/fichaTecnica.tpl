<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div id="wrapper" class="container tab-content">
    <div class="alert alert-danger">
        <h5> <strong>Atenci&oacute;n!!! </strong> <b>Esta informaci&oacute;n esta sujeta a verificaci&oacute;n y actualizacion.</b></h5>
    </div>
    <fieldset>
        {foreach from=$arrProyectos key=key item=value} 
            <div class="form-group" >
                <div class="col-md-12" style="background: #006779; width: 97%; color: #FFF; border-bottom: 3px solid #ffffff"> 
                    <h4 style="color: #FFF">{$value.txtNombreProyecto|upper}</h4>
                </div>
            </div>
            <div class="form-group" >
                <div class="col-md-4" style="background: #006779; border-bottom: 3px solid #ffffff">                 
                    <div class="container" style="width: 100%;  height: 243px">                     
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" >
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                {foreach from=$arrImagenes key=keyImg item=valueImg} 
                                    {if $keyImg ==0}
                                        <li data-target="#myCarousel" data-slide-to="{$keyImg}" class="active"></li>
                                        {else}
                                        <li data-target="#myCarousel" data-slide-to="{$keyImg}" ></li>
                                        {/if}
                                    {/foreach}
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" style="height: 210px">
                                {foreach from=$arrImagenes key=keyImg item=valueImg} 
                                    {if $keyImg ==0}
                                        <div class="item active">
                                            <img src="recursos/proyectos/{$valueImg}" alt="Los Angeles" style="width:100%; height: 90%"  data-toggle="modal" data-target="#{$keyImg}">
                                        </div>
                                    {else}
                                        <div class="item">
                                            <img src="recursos/proyectos/{$valueImg}" alt="Los Angeles" style="width:100%; height: 90%" data-toggle="modal" data-target="#{$keyImg}">
                                        </div>
                                    {/if}
                                    <div class="modal fade" id="{$keyImg}" tabindex="-1" role="dialog" aria-labelledby="{$keyImg}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{$keyImg}">IMAGEN DETALLADA</h5>                                                    
                                                </div>
                                                <div class="modal-body" style="text-align: center">
                                                    <img src="recursos/proyectos/{$valueImg}" alt="Los Angeles" >
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}                               
                            </div>
                            <!-- Modal -->
                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <table id="ejemplo" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                        <!-- <divclass="col-sm-7">                            
                         </div>-->
                        <thead >
                            <tr>
                                <th><b>Constructora</b></th>
                                <th><b>Localidad</b></th>
                                <th><b>Composicion</b></th>
                                <th><b>Unidades Vivienda</b></th>
                                <th><b>Hogares Vinculados</b></th>
                                <th><b>Pendientes por Vincular</b></th>
                                <th><b>Legalizados</b></th>
                                <th><b>Pendientes Por Legalizar</b></th>

                            </tr>
                        </thead>
                        <tr>
                            <td>{$nombreOferente}</td>
                            <td >{$value.txtLocalidad}</td>
                            <td >{$value.txtProyectoGrupo}</td>  
                            <td> {$cantUnidades}</td>
                            <td> {$cantUnidadesVinculadas}</td>
                            <td >{$pendientesPorVincular}</td>
                            <td >{$legalizadas}</td>  
                            <td> {$pendientesPorLegalizar}</td>
                        </tr>
                    </table>
                    <table id="ejemplo" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                        <!-- <divclass="col-sm-7">                            
                         </div>-->
                        <thead >
                            <tr>
                                <th><b>Avance Físico (%)</b></th>
                                <th><b>Fecha Terminación</b></th>
                                <th><b>Permiso de Ocupación</b></th>
                                <th><b>Cer. existencia y Habiltabilidad </b></th>
                                <th><b>(%) Desembolsado</b></th>
                                <th><b>Saldo por Desembolsar </b></th>                                
                            </tr>
                        </thead>
                        <tr>
                            <td>{$avance}</td>
                            <td>{$fechaAvance}</td>
                            <td >{$cantOcupacion} Unidades</td>  
                            <td>{$cantExistencia} Unidades</td>
                            <td>
                                <div class="col-sm-12 text-right">
                                    $ {$arrFinanciera.$seqProyecto.constructor|number_format:0:',':'.'}
                                </div>
                                <div class="col-sm-12 text-right">
                                    {$arrFinanciera.$seqProyecto.porcentajeTotalConstructor|number_format:2:',':'.'}%
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-12 text-right">
                                    $ {$arrFinanciera.$seqProyecto.saldoDesembolso|number_format:0:',':'.'}
                                </div>
                                <div class="col-sm-12 text-right">
                                    {$arrFinanciera.$seqProyecto.porcentajeSaldoDesembolso|number_format:2:',':'.'}%
                                </div>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="form-group" >
                <div class="col-md-4" style="background: #f5f5f5; border: 1px solid #ccc; text-align: justify; max-height: 400px; overflow-y: auto;">                 
                    <h3>Generalidades</h3>
                    <ui style="list-style-image: url('recursos/imagenes/vineta.png');">
                        <li><b>Tipo de agrupación:</b> {$value.txtTipoProyecto}</li>
                        <li><b>Numero de torres V.I.P:</b>{$value.valTorres}</li>
                        <li>Altura en Pisos: 17</li>
                            {foreach from=$arrDatosVivienda key=keyv item=valueV} 
                            <li><b>Apartamentos discapacitados:</b>  {$valueV.totalUdsDisc}</li>
                            <li><b>Apartamentos Residentes:</b>  {$valueV.totalUnidades}</li>
                            <li><b>parqueaderos Residentes:</b>  {$valueV.totalParq}</li>
                            <li><b>Parqueos discapacitados: </b> {$valueV.totalParqDisc}</li>
                            <li><b>Total parqueaderos:</b>   {$valueV.totalParq+$valueV.totalParqDisc}</li>
                            {/foreach}
                        <p>&nbsp;</p>
                        {foreach from=$listaTextosSeguimiento key=keySeg item=txtTexto}
                            {$txtTexto.txtFichaTexto} 
                        {/foreach}
                    </ui>
                    <p>&nbsp;</p>

                </div>
                <div class="col-md-8">
                    <table id="ejemplo" class="table table-striped table-bordered" cellspacing="0" width="100%" >                        
                        <thead>
                            <tr>
                                <th colspan="4" style="border: 1px solid #ccc; font-weight: bold; text-align: center" >Información de Vigencias de Póliza</th>
                            </tr>
                            <tr>                                
                                <th><b>Anticipo </b></th>
                                <th><b>Cumplimiento</b></th>
                                <th><b>Estabilidad</b></th>
                                <th><b>Aseguradora</b></th>    
                            </tr>
                        </thead>
                        <tr>
                            <td>{$vigAnticipo}</td>
                            <td>{$vigCumplimiento}</td>
                            <td>{$vigEstabilidad}</td>  
                            <td>{$nombreAseguradora}</td>

                        </tr>
                    </table>
                    <table id="ejemplo" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                        <!-- <divclass="col-sm-7">                            
                         </div>-->
                        <thead >
                            <tr>
                                <th width="20%"><b>Asignación de Aportes</b></th>
                                <th width="20%"><b>Indexación del Valor del SFV</b></th>
                                <th width="20%"><b>Disminución de Aportes</b></th>
                                <th width="20%"><b>Giro a Encargo Fiduciario</b></th>
                                <th width="20%"><b>Giros Del Encargo Fiduciario Al Oferente</b></th>

                            </tr>
                        </thead>
                        <tr>
                            <td style="text-align: right">
                                Res. {$arrFinanciera.$seqProyecto.aprobado.numero} de {$arrFinanciera.$seqProyecto.aprobado.fecha}<br>
                                {$arrFinanciera.$seqProyecto.aprobado.unidades|@count} SFV por <br>
                                $ {$arrFinanciera.$seqProyecto.aprobado.valor|number_format:0:',':'.'}
                            </td>
                            <td style="text-align: left">
                                {foreach from=$arrFinanciera.$seqProyecto.indexado.detalle key=seqUnidadActo item=arrResolucion}
                                    Res. {$arrResolucion.numero} de {$arrResolucion.fecha}<br>
                                    {$arrResolucion.unidades|@count} SFV por<br>
                                    $ {$arrResolucion.valor|number_format:0:',':'.'}
                                    <br><br>
                                {/foreach}
                                Total de indexaciones por <br>
                                $ {$arrFinanciera.$seqProyecto.indexado.total|number_format:0:',':'.'}
                            </td>
                            <td>
                                {foreach from=$arrFinanciera.$seqProyecto.menor.detalle key=seqUnidadActo item=arrResolucion}
                                    Res. {$arrResolucion.numero} de {$arrResolucion.fecha}<br>
                                    {$arrResolucion.unidades} SFV por<br>
                                    $ {$arrResolucion.valor|number_format:0:',':'.'}
                                    <br><br>
                                {/foreach}
                                Total de disminuciones por<br>
                                $ {$arrFinanciera.$seqProyecto.menor.total|number_format:0:',':'.'}
                            </td>
                            <td style="text-align: right">
                                Total de giros a fiducia por<br>
                                $ {$arrFinanciera.$seqProyecto.fiducia|number_format:0:',':'.'}<br>
                                Recursos girados a: {$arrFinanciera.$seqProyecto.entidadFiducia.txtRazonSocialFiducia}
                                [{$arrFinanciera.$seqProyecto.entidadFiducia.numNitFiducia}]
                            </td>
                            <td>
                                El total de recursos de SDHT es $ {$arrFinanciera.$seqProyecto.actual|number_format:0:',':'.'}
                                {if count($arrListadoGirosConstructor) > 0}
                                    de los cuales se
                                    {if count($arrListadoGirosConstructor) == 1}
                                        autorizó {$arrListadoGirosConstructor|@count} giro así:
                                    {else}
                                        autorizaron {$arrListadoGirosConstructor|@count} giros así:
                                    {/if}
                                {/if}<br><br>
                                {foreach from=$arrListadoGirosConstructor item=arrGiroConstructor}
                                    El {$arrGiroConstructor.porcentajeGiro|number_format:2:',':'.'}% el {$arrGiroConstructor.fecha->format("Y-m-d")} por<br>
                                    $ {$arrGiroConstructor.giro|number_format:0:',':'.'}<br><br>
                                {/foreach}
                                {if $arrFinanciera.$seqProyecto.reintegro != 0}
                                    Total Reintegros por<br>
                                    $ {$arrFinanciera.$seqProyecto.reintegro|number_format:0:',':'.'}
                                {/if}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        {/foreach}
    </fieldset>
</div>