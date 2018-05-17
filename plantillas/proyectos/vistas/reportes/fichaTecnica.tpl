<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div id="wrapper" class="container tab-content">
    <fieldset>
        {foreach from=$arrProyectos key=key item=value} 
            <div class="form-group" >
                <div class="col-md-12" style="background: #006779; width: 97%; color: #FFF; border-bottom: 3px solid #ffffff"> 
                    <h4 style="color: #FFF">{$value.txtNombreProyecto|upper}</h4>
                </div>
            </div>
            <div class="form-group" >
                <div class="col-md-3" style="background: #006779; border-bottom: 3px solid #ffffff">                 
                    <div class="container" style="width: 100%; ">                     
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
                            <div class="carousel-inner" style="height: 190px">
                                {foreach from=$arrImagenes key=keyImg item=valueImg} 
                                    {if $keyImg ==0}
                                        <div class="item active">
                                            <img src="recursos/proyectos/{$valueImg}" alt="Los Angeles" style="width:100%;">
                                        </div>
                                    {else}
                                        <div class="item">
                                            <img src="recursos/proyectos/{$valueImg}" alt="Los Angeles" style="width:100%;">
                                        </div>
                                    {/if}

                                {/foreach}                               
                            </div>

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
                <div class="col-md-9">
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
                            <td>{$value.txtNombreConstructor}</td>
                            <td >{$value.txtLocalidad}</td>
                            <td ></td>  
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
                            <td></td>
                            <td ></td>
                            <td ></td>  
                            <td></td>
                            <td> &nbsp;</td>
                            <td ></td>
                        </tr>
                    </table>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="form-group" >
                <div class="col-md-3" style="background: #f5f5f5; border: 1px solid #ccc; border-bottom: 3px solid #ffffff; text-align: justify">                 
                    <p>&nbsp;</p><h3>Generalidades</h3>
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
                        <li>De acuerdo con el último informe de interventoría de Marzo  2018 se informa un avance de obra de 98.50%. Las obras de viviendas se encuentran terminadas. 
                        </li>
                        <li>La interventoría informa que continúan pendientes las obras de urbanismo externo (Salón comunal y parques). Razón por la cual la alcaldía no ha expedido el permiso de ocupación de 34 VIP. Estas obras se encuentran suspendidas desde enero de 2018 bajo la justificación que no hay flujo de caja y que según lo informado por el constructor, se reiniciaran obras a inicios de mayo de 2018.
                        </li>
                        <li>La Constructora radicó nueva solicitud de prórroga al cronograma bajo radicado 1-2018-06131 del 28-02-2018 con fecha final de entrega el 30/06/2018, con la justificación de que falta la expedición del permiso de ocupación. La solicitud no es presentada dentro de los plazos vigentes del proyecto y no se presenta con el concepto y aval de la interventoría con soportes. Se emitirá un oficio dando a conocer una fecha limite para la culminación de procesos pendientes y entrega de las VIP. Fecha estimada 30-06-2018.
                        </li>                       

                    </ui>
                    <p>&nbsp;</p>

                </div>
                <div class="col-md-9">
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
                            <td>&nbsp;</td>
                            <td >&nbsp;</td>
                            <td ></td>  
                            <td> &nbsp;</td>

                        </tr>
                    </table>
                    <table id="ejemplo" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                        <!-- <divclass="col-sm-7">                            
                         </div>-->
                        <thead >
                            <tr>
                                <th><b>Asignación de Aportes</b></th>
                                <th><b>Giro a Encargo Fiduciario</b></th>
                                <th><b>Indexación del Valor del SFV</b></th>
                                <th><b>Disminución de Aportes</b></th>
                                <th><b>Giros Del Encargo Fiduciario Al Oferente</b></th>

                            </tr>
                        </thead>
                        <tr>
                            <td></td>
                            <td ></td>
                            <td ></td>  
                            <td></td>
                            <td> &nbsp;</td>                           
                        </tr>
                    </table>
                </div>
            </div>
        {/foreach}
    </fieldset>
</div>