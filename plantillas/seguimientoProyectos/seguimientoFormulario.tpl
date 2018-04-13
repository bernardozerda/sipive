<div class="form-group">
    <div class="col-md-2" >
        <label class="control-label" for="nome"><b>No.Registro</b>  <br></label>
        <input type="input"
               id="referencia"
               onFocus="this.style.backgroundColor = '#ADD8E6';"
               onBlur="soloNumeros(this);
                       this.style.backgroundColor = '#FFFFFF';"
               maxlength="8"
               style="width:70px;"
               class="form-control"
               />
    </div>
    <div class="col-md-3" >
        <label class="control-label" for="nome"><b>Grupo Gestión</b>  <br></label>
        <select id="grupoGestion" 
                class="form-control"
                onFocus="this.style.backgroundColor = '#ADD8E6';" 
                onBlur="this.style.backgroundColor = '#FFFFFF';"
                onChange="obtenerGestionProyectos(this, 'tdGestion2', 'gestion');">
            >
            <option value="0">Seleccione Grupo</option>
            {foreach from=$arrGrupoGestion key=seqGrupoGestion item=txtGrupoGestion}
                <option value="{$seqGrupoGestion}">{$txtGrupoGestion}</option>
            {/foreach}
        </select>
    </div>
    <div class="col-md-4" >
        <label class="control-label" for="nome"><b>Seguimiento</b>  <br></label>
        <div id="tdGestion2">
            <select id="gestion" 

                    class="form-control"
                    onFocus="this.style.backgroundColor = '#ADD8E6';" 
                    onBlur="this.style.backgroundColor = '#FFFFFF';"
                    >
                <option value="0">Seleccione Gesti&oacute;n</select>
            </select>
        </div>
    </div>
    <div class="col-md-3" >
        <label class="control-label" for="nome">&nbsp; <br></label>
        <input type="button" src="recursos/imagenes/search.png" name="btn_volver" id="btn_volver" value="Buscar" onclick="buscarSeguimientoProyectos('contenidoBusqueda', './contenidos/seguimientoProyectos/buscarSeguimiento.php');" 
               class="btn_volver" 
               style="cursor: hand;margin-top: 10px; background-image: url('recursos/imagenes/search.png'); background-repeat: no-repeat; text-align: left; width: 85px; background-position-x: 90%;background-position-y: 32%;padding: 7px;  margin-top: 26px"/>

    </div>

    <div class="form-group">
        <div class="col-md-5" >
            <label class="control-label" for="nome">&nbsp; <br></label>
            <input type="button" src="recursos/imagenes/search.png" name="masbusquedaAvanzada" id="masbusquedaAvanzada" value="B&uacute;squeda Avanzada" onclick="cuadroBusquedaAvanzada('busquedaAvanzada');" 
                   class="btn_volver" 
                   style="cursor: hand;margin-top: 10px; background-image: url('recursos/imagenes/openMenu.png'); background-repeat: no-repeat; text-align: center; width: 200px; background-position-x: 1%;background-position-y: 37%;padding: 7px;  margin-top: 26px"/>

        </div>
        <div class="col-md-6" style="text-align: right" >
            <label class="control-label" for="nome">&nbsp; <br></label>
            <input type="button" name="btn_volver" id="btn_volver" value="Limpiar B&uacute;squeda" onclick="limpiarBusqueda();" 
                   class="btn_volver" 
                   style="cursor: hand;margin-top: 10px; background-image: url('recursos/imagenes/clear.png'); background-repeat: no-repeat; text-align: center; width: 180px; background-position-x: 1%;background-position-y: 80%;padding: 7px;  margin-top: 26px"/>

        </div>

    </div>
</div>
<div><p>&nbsp;</p></div>
<div id="cuadrobusquedaAvanzada" style="display: none; border: 1px solid #CCC; margin: 2%" class="col-md-11" >
    <div class="form-group">
        <div class="col-md-3" >
            <label><b>Desde:</b></label><br>
            <input	type="text" 
                   id="inicial" 
                   value=""                                 
                   maxlength="10"
                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                   class="form-control" style="width: 66%; position: relative; float: left"
                   readonly 
                   /> <img src="recursos/imagenes/calendar.png" onClick="javascript: calendarioPopUp('inicial');" style="cursor: hand; position: relative; float: right; width: 12%;right:10%"/>
        </div>
        <div class="col-md-3" >
            <label><b>Hasta:</b></label><br>
            <input	type="text" 
                   id="final" 
                   value=""                                 
                   maxlength="10"
                   onFocus="this.style.backgroundColor = '#ADD8E6';" 
                   onBlur="this.style.backgroundColor = '#FFFFFF';"
                   class="form-control" style="width: 66%; position: relative; float: left"
                   readonly />
            <img src="recursos/imagenes/calendar.png" onClick="javascript: calendarioPopUp('final');" style="cursor: hand; position: relative; float: right; width: 12%;right:10%"/>
        </div>
        <div><p>&nbsp;</p></div>
        <div class="col-md-5" >
            <label><b>Comentarios del tutor:</b></label><br>
            <textarea id="comentario"
                      style="width:100%"
                      onFocus="this.style.backgroundColor = '#ADD8E6';" 
                      onBlur="sinCaracteresEspeciales(this);
                                  this.style.backgroundColor = '#FFFFFF';"
                      /></textarea>    
        </div>
        <div class="col-md-6" >
            <input type="radio" id="cambiosSi" onClick="limpiarRadio(this, ['cambiosSi', 'cambiosNo', 'cambiosAmbos']);" value="si" style="height: 13px;"> Con Modificaciones
            <input type="radio" id="cambiosNo" onClick="limpiarRadio(this, ['cambiosSi', 'cambiosNo', 'cambiosAmbos']);" value="no" style="height: 13px;"> Sin Modifiacioes 
            <input type="radio" id="cambiosAmbos" onClick="limpiarRadio(this, ['cambiosSi', 'cambiosNo', 'cambiosAmbos']);" value="ambos" style="height: 13px;"> Ambos 
        </div>
        <div class="col-md-6" >
            <input type="radio" id="criterioTextoInicia" onClick="limpiarRadio(this, ['criterioTextoInicia', 'criterioTextoTermina', 'criterioTextoContiene'])" value="inicia" style="height: 13px;"> Inicia Con 
            <input type="radio" id="criterioTextoTermina" onClick="limpiarRadio(this, ['criterioTextoInicia', 'criterioTextoTermina', 'criterioTextoContiene'])" value="termina" style="height: 13px;"> Termina Con 
            <input type="radio" id="criterioTextoContiene" onClick="limpiarRadio(this, ['criterioTextoInicia', 'criterioTextoTermina', 'criterioTextoContiene'])" value="contiene" style="height: 13px;"> Contienes 
            <input type="radio" id="cambiosAmbos" onClick="limpiarRadio(this, ['cambiosSi', 'cambiosNo', 'cambiosAmbos']);" value="ambos" style="height: 13px;"> Ambos 
        </div>
    </div>
</div>

