<div class="modal-wrapper" id="popup">
    <div class="popup-contenedor">
        <div><h1>SiPIVE - Simulador Aporte SDHT </h1>                                  
            <table>
                <tr>

                    <td>
                        <input type="text" name="buscaCedulaConfirmacion" id="buscaCedulaConfirmacion" value="" style="width: 150px" onfocus="this.style.backgroundColor = '#ADD8E6';" onblur="soloNumeros(this);
                                this.style.backgroundColor = '#FFFFFF';" onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)">
                    </td>
                    <td>
                        <input type="button" id="buscarCedula" class="buscarCedula" value="Buscar" onclick="validarCalificacion();">
                        <input type="hidden" id="txtDivDestino" name="txtDivDestino" value="destino"/>
                    </td>
                </tr>
            </table> 
            <div id="destino">
            </div>
        </div>                                     
        <a class="popup-cerrar" href="#">X</a>
    </div>
</div>