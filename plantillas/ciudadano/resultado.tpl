   

<div class="row">
   
   <div class="span12" style="height: 510px;">
      
      <!-- TAB DEL TAB VIEW -->
      <ul id="myTab" class="nav nav-tabs">
         <li class="active"><a href="#estadoProceso" data-toggle="tab">Estado del Proceso</a></li>
         <li><a href="#datosHogar" data-toggle="tab">Datos del Hogar</a></li>
         {if $arrEstado.txtEtapa == "Inscripcion"}
            <li><a href="#otrosServicios" data-toggle="tab">Otros Servicios</a></li>
         {/if}
      </ul>
      
      <!-- COTNENIDO DE LOS TABS -->
      <div id="myTabContent" class="tab-content" style="height: 370px;">
      
         <!-- TAB INFORMACION DEL ESTADO DEL PROCESO -->
         <div class="tab-pane fade in active" id="estadoProceso">
            
            <center>
               <div class="well" style="text-align: justify; width: 1000px">
                  <h1>{$txtSaludo} <small>{$txtNombreConsulta}</small></h1>
                  <p>
                     La Secretar&iacute;a Distrital de H&aacute;bitat le informa que dentro del proceso
                     de candidatura para la obtencion del Subsidio Distrital de Vivienda en Especie, su hogar
                     figura al dia de hoy en el siguiente estado:   
                     <div class="alert alert-info">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                           <tr><td width="180px;"><strong>Etapa:</strong></td><td><small>{$arrEstado.txtEtapa}</small></td></tr>
                           <tr><td><strong>Estado del proceso:</strong></td><td><small>{$arrEstado.txtEstado}</small></td></tr>
                           <tr><td colspan="2"><small>{$arrEstado.txtDescripcion}</small></td></tr>
                        </table>
                     </div>
                  </p>
               </div>
            </center>
            <center>
               <div class="row">
                  <div class="span1">&nbsp;</div>
                  <div class="span1 text-right">
                     <img src="./recursos/imagenes/usuario.png" />
                  </div>
                  <div class="span8"  style="background: url('./recursos/imagenes/atrasProceso.png') no-repeat;">
                     <div class="progress">
                        {assign var=seqEtapa value=$arrEstado.seqEtapa}
                        {math equation="x * 20" x=$seqEtapa assign=numBarra}
                        <div class="bar" style="width: {$numBarra}%"></div>
                     </div>
                  </div>
                  <div class="span1 text-left">
                     <img src="./recursos/imagenes/casa.png" />
                  </div>
                  <div class="span1">&nbsp;</div>
               </div>
                     
            </center>
               
         </div>
         
         <!-- TAB DE DATOS DEL HOGAR -->
         <div class="tab-pane fade" id="datosHogar">

            <!-- ACORDEON DE DATOS DEL HOGAR -->
            <div class="accordion" id="accordion" style="padding-left: 40px; padding-right: 40px;">

               <!-- DATOS FAMILIARES -->
               <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                      Datos Familiares
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                     <div class="accordion-inner">

                        <!-- TABLA DE LOS DATOS FAMILIARES -->
                        <table class="table table-striped">
                           <thead>
                             <tr>
                               <th width="120px" style="text-align: center;">Documento</th>
                               <th width="400px">Nombre</th>
                               <th>Parentesco</th>
                             </tr>
                           </thead>
                           <tbody>
                              {foreach from=$claFormulario->arrCiudadano key=seqCiudadano item=objCiudadano}
                                 <tr>
                                    <td style="text-align: right;">
                                       {$objCiudadano->numDocumento}
                                    </td>
                                    <td>
                                       {$objCiudadano->txtNombre1} {$objCiudadano->txtNombre1}
                                       {$objCiudadano->txtApellido1} {$objCiudadano->txtApellido2}
                                    </td>
                                    <td>
                                       {$objCiudadano->txtParentesco}
                                    </td>
                                 </tr>
                              {/foreach}
                           </tbody>
                         </table>

                     </div>
                  </div>
               </div>

               <!-- DATOS DE CONTACTO -->
               <div class="accordion-group">
                  <div class="accordion-heading">
                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        Datos de Cont&aacute;cto
                     </a>
                  </div>
                  <div id="collapseFour" class="accordion-body collapse">
                     <div class="accordion-inner">

                        <!-- TABLA DE LOS DATOS DE CONTACTO -->
                        <table class="table table-striped" border="0">
                           <tbody>
                              <tr>
                                 <td width="250px"><strong>Direcci&oacute;n de Vivienda Actual:</strong></td>
                                 <td>{$claFormulario->txtDireccion}</td>
                               </tr>
                               <tr>
                                 <td><strong>Tel&eacute;fonos fijos:</strong></td>
                                 <td>
                                    {$claFormulario->numTelefono1} 
                                    {if floatval( $claFormulario->numTelefono2 ) != 0} 
                                       &oacute; {$claFormulario->numTelefono2} 
                                    {/if}
                                 </td>
                               </tr>
                               <tr>
                                 <td><strong>Tel&eacute;fono Celuar:</strong></td>
                                 <td>{$claFormulario->numCelular}</td>
                              </tr>
                           </tbody>
                        </table>

                     </div>
                  </div>
               </div>               

               <!-- DATOS DE LA POSTULACION -->            
               <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                       Datos de la Postulaci&oacute;n
                    </a>
                  </div>
                  <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                     <div class="accordion-inner">

                        <!-- TABLA DE LOS DATOS FAMILIARES -->
                        <table class="table table-striped">
                           <tbody>
                              <tr>
                                 <td width="250px"><strong>Modalidad de la inscripci&oacute;n:</strong></td>
                                 <td>{$claFormulario->txtModalidad}</td>
                                 <td><strong>Vivienda Actual:</strong></td>
                                 <td>{$claFormulario->txtVivienda}</td>
                              </tr>
                              <tr>
                                 <td><strong>Ciudad:</strong></td>
                                 <td>{$claFormulario->txtCiudad}</td>
                                 <td><strong>Localidad:</strong></td>
                                 <td>{$claFormulario->txtLocalidad}</td>
                              </tr>
                              <tr>
                                 <td><strong>Barrio:</strong></td>
                                 <td>{$claFormulario->txtBarrio}</td>
                                 <td></td>
                                 <td></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>

               <!-- DATOS FINANCIEROS -->
               <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                      Datos Financieros
                    </a>
                  </div>
                  <div id="collapseThree" class="accordion-body collapse">
                    <div class="accordion-inner">
                       <table class="table table-striped">
                           <tbody>
                              <tr>
                                 <td width="150px"><strong>Tiene Ahorro:</strong></td>
                                 <td>{if $claFormulario->valSaldoCuentaAhorro > 0} SI {else} NO {/if}</td>
                                 <td width="150px"><strong>Tiene Otro Ahorro:</strong></td>
                                 <td>{if $claFormulario->valSaldoCuentaAhorro2 > 0} SI {else} NO {/if}</td>
                              </tr>
                              <tr>
                                 <td><strong>Tiene Cr&eacute;dito: </strong></td>
                                 <td>{if $claFormulario->valSaldoCuentaAhorro > 0} SI {else} NO {/if}</td>
                                 <td><strong>Cesant&iacute;as: </strong></td>
                                 <td>{if $claFormulario->valSaldoCesantias > 0} SI {else} NO {/if}</td>
                              </tr>
                              <tr>
                                 <td><strong>Subsidio Nacional: </strong></td>
                                 <td>{if $claFormulario->valSubsidioNacional > 0} SI {else} NO {/if}</td>
                                 <td><strong>Donaciones: </strong></td>
                                 <td>{if $claFormulario->valDonacion > 0} SI {else} NO {/if}</td>
                              </tr>
                           </tbody>
                        </table>
                    </div>
                  </div>
               </div>

            </div>
         
            {if $arrEstado.txtEtapa == "Inscripcion"}
               {if $claFormulario->valSaldoCuentaAhorro != 0}
                  <div style="padding-left: 40px; padding-right: 40px">
                     <div class="media">
                        <a class="pull-left" href="#">
                          <img class="media-object" 
                               alt="Exportar" 
                               style="width: 64px; height: 64px;" 
                               src="./recursos/imagenes/pdf.png"                         
                               onClick="cartaMovilizacion('{$objPrincipal->numDocumento}','{$claFormulario->txtBancoCuentaAhorro}',1);"
                          >
                        </a>
                        <div class="media-body">
                           <h4 class="media-heading">Carta Solicitud de Movilizaci&oacute;n de Recursos para {$claFormulario->txtBancoCuentaAhorro}</h4>
                           Esta carta certifica que sus recursos no estan comprometidos con la entidad para la asignacion de un subsidio.
                           Obtenga esta carta para solicitar la movilizacion de los recursos consignados en {$claFormulario->txtBancoCuentaAhorro}
                        </div>
                     </div>
                  </div>
               {/if}<br>
               {if $claFormulario->valSaldoCuentaAhorro2 != 0}
                  <div style="padding-left: 40px; padding-right: 40px">
                     <div class="media">
                        <a class="pull-left" href="#">
                          <img class="media-object" 
                               alt="Exportar" 
                               style="width: 64px; height: 64px;" 
                               src="./recursos/imagenes/pdf.png"                         
                               onClick="cartaMovilizacion('{$objPrincipal->numDocumento}','{$claFormulario->txtBancoCuentaAhorro2}',2);"
                          >
                        </a>
                        <div class="media-body">
                           <h4 class="media-heading">Carta Solicitud de Movilizaci&oacute;n de Recursos  para {$claFormulario->txtBancoCuentaAhorro2}</h4>
                           Esta carta certifica que sus recursos no estan comprometidos con la entidad para la asignacion de un subsidio.
                           Obtenga esta carta para solicitar la movilizacion de los recursos consignados en {$claFormulario->txtBancoCuentaAhorro2}
                        </div>
                     </div>
                  </div>
               {/if}
            {/if}            

         </div>
         
         <!-- TAB DE OTROS SERVICIOS -->
         {if $arrEstado.txtEtapa == "Inscripcion"}
            <div class="tab-pane fade" id="otrosServicios">
               
               <div class="span1">&nbsp;</div>
               <div class="span10">
                  <div class="hero-unit">
                     <h1>Eliminar Inscripci&oacute;n</h1>
                     <p>
                        Haga click en el bot&oacute;n para eliminar su inscripci&oacute;n al subsidio distrital de vivienda, tenga en cuenta
                        que este procedimiento no puede deshacerse y sus datos seran eliminados de nuestro sistema.<br>
                        <center>
                           <button type="button" class="btn btn-danger" onClick="eliminarInscripcion()">
                              Eliminar Datos
                           </button>
                        </center>
                     </p>
                  </div>
               </div>
               <div class="span1">&nbsp;</div>
               
            </div>
         {/if}
         
      </div> <!-- tab content -->
      
      <center><span style="font-size: 75%;">
         El Programa de Subsidios Distritales de Vivienda ha cambiado. En caso que en los ultimos meses no haya actilzado sus 
         datos le invitamos acercarse a punto de atención de la SDHT para recibir infrmación de los nuevos esquemas, requerimientos 
         de información y condiciones para ser beneficiario de un SDVE.
         Si tiene alguna observacion en relaci&oacute;n con la informaci&oacute;n aqui presentada
         comun&iacute;quese con la linea de atenci&oacute;n de la Secretar&iacute;a Distrial del H&aacute;bitat
         al 3581600 extensiones 1006, 1007, 1008 o 1009.
      </span></center>
      
   </div> <!-- span12 -->
</div> <!-- row -->

<!-- POP UP DE CONFIRMACION DE ELIMINAR INSCRIPCION -->
<div id="eliminarInscripcion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
   <form id="frmEliminarInscripcion" class="form-horizontal" onSubmit="return false;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">¿Confirme la Transacci&oacute;n?</h3>
      </div>
      <div class="modal-body">
            <p class="text-center alert alert-danger">
               Est&aacute; a punto de eliminar su inscripci&oacute;n al subsidio distrital de vivienda,
               &eacute;sta acci&oacute;n no puede deshacerse.<br>
               ¿ Desea realmente eliminar sus datos del sistema ?
            </p>
            <input type="hidden" name="formulario" value="{$seqFormulario}">
      </div>
      <div class="modal-footer">    
         <button type="button" class="btn" style="width:100px" onClick="prueba()">
            Si
         </button>
         <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" style="width:100px">
            No
         </button>
      </div>
   </form>
</div>      

