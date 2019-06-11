
<div class="modal-wrapper" id="popup">

    <div class="popup-contenedor">
        <div class="panel panel-default" style="padding-bottom: 0px;">
            <div class="panel-heading">
                <div class="col-lg-5 col-md-5" style="top: 10px">
                    <h6 class="panel-title"> SIPIVE - Simulador Aporte SDHT </h6>
                </div>

                <div class="col-lg-3 col-md-3" style="text-align: right; top: 10px">
                    <input type="text"
                           name="buscaCedulaConfirmacion"
                           id="buscaCedulaConfirmacion"
                           value=""
                           style="width:150px; "
                           onfocus="this.style.backgroundColor = '#ADD8E6';"
                           onblur="soloNumeros(this);
                                   this.style.backgroundColor = '#FFFFFF';"
                           onkeyup="formatoSeparadores(this)"
                           onchange="formatoSeparadores(this)"
                           >

                </div>
                <div class="col-lg-2 col-md-2" style="text-align: left; ">
                    <button type="submit" class="pressed" style="width: 80%; background-color: #004080" id="buscarCedula"    onclick="validarCalificacion();">
                        <span class ="glyphicon glyphicon-search" aria-hidden="true" style="cursor: pointer; text-align: left; font-weight: bold;" ></span>&nbsp; Buscar</button>               
                    <input type="hidden" id="txtDivDestino" name="txtDivDestino" value="destino"/>
                </div>

                <div class="col-lg-1 col-md-1" style="text-align: right; ">
                    <a class="popup-cerrar" href="#">X</a>
                </div>
            </div>
        </div>
        <div class="panel-body" style="padding-top: 0px;" >
            <div id="destino" ></div>

        </div>

    </div>
</div>
<!--  <div class="popup-contenedor">
      <div><h6>SiPIVE - Simulador Aporte SDHT </h6>                                  
          <table>
              <tr>
                  <td>
                      <input type="text"
                             name="buscaCedulaConfirmacion"
                             id="buscaCedulaConfirmacion"
                             value=""
                             style="width: 150px"
                             onfocus="this.style.backgroundColor = '#ADD8E6';"
                             onblur="soloNumeros(this);
                                     this.style.backgroundColor = '#FFFFFF';"
                             onkeyup="formatoSeparadores(this)"
                             onchange="formatoSeparadores(this)"
                             >
                  </td>
                  <td>
                      <input type="button" id="buscarCedula" class="buscarCedula" value="Buscar" onclick="validarCalificacion();">
                      <input type="hidden" id="txtDivDestino" name="txtDivDestino" value="destino"/>
                  </td>
              </tr>
          </table> 
          <div id="destino" style="width: 95%; overflow: auto;"></div>
      </div>                                     
      <a class="popup-cerrar" href="#">X</a>
  </div>-->
</div>