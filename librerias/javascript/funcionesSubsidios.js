function confirmarCartaMovilizacion(documento, tipo, nombre) {
    if (nombre == '') {
        nombre = $('#valPostulado1').val();
    }
    var radio = $('input:radio[name=radio]:checked').val();

    var entidad = $('#seqBancoCuentaAhorro_' + radio + ' :selected').text();

    var objFormulario = YAHOO.util.Dom.get("frmPostulacion");
    //var objEstadoProceso = YAHOO.util.Dom.get("seqEstadoProceso");
    if (radio != "" && radio != null && nombre != "" && nombre != null && entidad != "" && entidad != 'Ninguno') {

        var txtMensaje = "<div style='text-align:left'>";
        txtMensaje += "<span class='msgError' style='font-size:12px';>Desea Modificar el nombre del ciudadano?</span>";
        txtMensaje += "</div>";

        // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
        var handleYes = function () {
            modificarNombre(documento, tipo, nombre, radio, entidad);
            this.cancel();
        }

        // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
        var handleNo = function () {
            generarCarta(documento, tipo, nombre, radio, entidad)
            this.cancel();
        }

        var objAtributos = {
            width: "330px",
            effect: {
                effect: YAHOO.widget.ContainerEffect.FADE,
                duration: 0.75
            },
            fixedcenter: true,
            zIndex: 1,
            visible: false,
            modal: true,
            draggable: true,
            close: false,
            text: txtMensaje,
            buttons: [
                {
                    text: "Si",
                    handler: handleYes
                },
                {
                    text: "No",
                    handler: handleNo,
                    isDefault: true
                }
            ]
        }
        var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

        // Muestra el cuadro de dialogo
        objDialogo1.setHeader("Atención");
        objDialogo1.render(document.body);
        objDialogo1.show();

        // INSTANCIA EL OBJETO DIALOGO

    } else {
        var txtMensaje = "<div style='text-align:left'><span class='msgError' style='font-size:12px';>";
        if (nombre == "" || nombre == null) {
            txtMensaje += "Por favor Digite el nombre del ciudadano al cual se le generará la Carta de Movilización";
        } else if (radio == "undefined" || radio == null) {
            txtMensaje += "Por favor seleccione el tipo de Ahorro al que desea generar la Carta de Movilización";
        } else if (entidad == 'Ninguno' || entidad == null) {
            txtMensaje += "Por favor seleccione la entidad a la cual se le va a generar la Carta de Movilización";
        }
        txtMensaje += "</span></div>";
        var objAviso =
                new YAHOO.widget.SimpleDialog(
                        "aviso",
                        {
                            width: "400px",
                            fixedcenter: true,
                            close: true,
                            draggable: false,
                            modal: true,
                            visible: false,
                            icon: YAHOO.widget.SimpleDialog.ICON_WARN
                        }
                );

        objAviso.setHeader("ATENCI&Oacute;N");
        objAviso.setBody(txtMensaje);
        objAviso.render(document.body);
        objAviso.show();
        //alert("por favor selecione un tipo de Ahorro");
    }
}

function modificarNombre(documento, tipo, nombre, radio, entidad) {

    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgError' style='font-size:12px';><input type='text' name='namePostulado1' id='valPostulado1' value='" + nombre + "' onfocus=\"this.style.backgroundColor = '#ADD8E6';\"  onblur=\"soloLetras(this); this.style.backgroundColor = '#FFFFFF';\" size='40' /></span>";
    txtMensaje += "</div>";
    var handleYes = function () {
        var nombre = $('#valPostulado1').val();
        generarCarta(documento, tipo, nombre, radio, entidad);
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        this.cancel();
    }

    var objAtributos = {
        width: "450px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        zIndex: 1,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Modificar",
                handler: handleYes
            },
            {
                text: "Cancelar",
                handler: handleNo,
                isDefault: true
            }
        ]
    }
    var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo1.setHeader("Carta de Movilización");
    objDialogo1.render(document.body);
    objDialogo1.show();
}

function generarCarta(documento, tipo, nombre, radio, entidad) {
    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgError' style='font-size:12px';>Esta seguro que desea generar la carta de movilizacion de la entidad:" + entidad + "</span>";
    txtMensaje += "</div>";

    var handleYes = function () {
        var url = "contenidos/ciudadano/pdfCartaMovilizacion.php?documento=" + documento + "&cuenta=" + radio + "&tipo=" + tipo + "&banco=" + entidad + "&nombre=" + nombre;
        window.open(url, "", "width=1002,height=700,location=0,menubar=0,scrollbars=1,status=1,resizable=0");
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        this.cancel();
    }

    var objAtributos = {
        width: "450px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        zIndex: 1,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Generar Carta",
                handler: handleYes
            },
            {
                text: "No Generar Carta",
                handler: handleNo,
                isDefault: true
            }
        ]
    }
    var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo1.setHeader("Carta de Movilización");
    objDialogo1.render(document.body);
    objDialogo1.show();
}

function mostrarDiv() {
    $(".ocultarDiv").show();
}
function ocultarDiv() {
    $(".ocultarDiv").hide();
}

function obtenerCodigo() {
    var codigo = $("#codeVerificacion").val();
    if (codigo != "") {
        var objCargando = obtenerObjetoCargando();
        var parametros = {
            "code": codigo
        };
        $.ajax({
            data: parametros,
            url: './contenidos/ciudadano/verificarCodigo.php',
            type: 'post',
            beforeSend: function () {
                objCargando.show();
            },
            success: function (response) {
                $("#mostrarInformacion").html(response);
                objCargando.hide();
                ("#codeVerificacion").value('');

            }
        });
    } else {
        var txtMensaje = "<div style='text-align:left'><span class='msgError' style='font-size:12px';> Por favor digite el código";

        txtMensaje += "</span></div>";
        var objAviso =
                new YAHOO.widget.SimpleDialog(
                        "aviso",
                        {
                            width: "400px",
                            fixedcenter: true,
                            close: true,
                            draggable: false,
                            modal: true,
                            visible: false,
                            icon: YAHOO.widget.SimpleDialog.ICON_WARN
                        }
                );

        objAviso.setHeader("ATENCI&Oacute;N");
        objAviso.setBody(txtMensaje);
        objAviso.render(document.body);
        objAviso.show();

    }
}
function validarEntidad(valor) {

    var txtMensaje = "<div style='text-align:left'><span class='msgError' style='font-size:12px';>";
    var entidad1 = $('#seqBancoCuentaAhorro_1 :selected').val();
    var entidad2 = $("#seqBancoCuentaAhorro_2 :selected").val();


    if (valor != 1) {
        if (valor == entidad1) {
            txtMensaje += "Esta entidad ya esta asociada al ahorro 1 por favor seleccione el Ahorro 1";

            txtMensaje += "</span></div>";
            var objAviso =
                    new YAHOO.widget.SimpleDialog(
                            "aviso",
                            {
                                width: "400px",
                                fixedcenter: true,
                                close: true,
                                draggable: false,
                                modal: true,
                                visible: false,
                                icon: YAHOO.widget.SimpleDialog.ICON_WARN
                            }
                    );

            objAviso.setHeader("ATENCI&Oacute;N");
            objAviso.setBody(txtMensaje);
            objAviso.render(document.body);
            objAviso.show();
            $('#seqBancoCuentaAhorro_3 option[value=1]').attr('selected', 'selected');
        } else if (valor == entidad2) {
            txtMensaje += "Esta entidad ya esta asociada al ahorro 2 por favor seleccione el Ahorro 2";

            txtMensaje += "</span></div>";
            var objAviso =
                    new YAHOO.widget.SimpleDialog(
                            "aviso",
                            {
                                width: "400px",
                                fixedcenter: true,
                                close: true,
                                draggable: false,
                                modal: true,
                                visible: false,
                                icon: YAHOO.widget.SimpleDialog.ICON_WARN
                            }
                    );

            objAviso.setHeader("ATENCI&Oacute;N");
            objAviso.setBody(txtMensaje);
            objAviso.render(document.body);
            objAviso.show();
            $('#seqBancoCuentaAhorro_3 option[value=1]').attr('selected', 'selected');
        }
    }

    //$("#seqBancoCuentaAhorro_3 :selected").val("1");


}
function modificarActo(txtNombreArchivo, seqFormulario, seqFormularioActo) {

    var txtMensaje = "<div style='text-align:left'>";
    txtMensaje += "<span class='msgError' style='font-size:12px';>Desea Actualizar la informacion del Acto Administrativo?</span>";
    txtMensaje += "</div>";

    // COMPORTAMIENTO SI SE PRESIONA -- SI -- EN EL CUADRO
    var handleYes = function () {
        var objCedula = document.getElementById("buscaCedula");
        var objCedulaConfirmacion = document.getElementById("buscaCedulaConfirmacion");

        cargarContenido("formulario", "contenidos/" + txtNombreArchivo + ".php", "cedula=" + objCedula.value + "&seqForm=" + seqFormulario + "&seqFormularioActo=" + seqFormularioActo, true);
        this.cancel();
    }

    // COMPORTAMIENTO SI SE PRESIONA -- NO -- EN EL CUADRO
    var handleNo = function () {
        this.cancel();
    }

    var objAtributos = {
        width: "330px",
        effect: {
            effect: YAHOO.widget.ContainerEffect.FADE,
            duration: 0.75
        },
        fixedcenter: true,
        zIndex: 1,
        visible: false,
        modal: true,
        draggable: true,
        close: false,
        text: txtMensaje,
        buttons: [
            {
                text: "Si",
                handler: handleYes
            },
            {
                text: "No",
                handler: handleNo,
                isDefault: true
            }
        ]
    }
    var objDialogo1 = new YAHOO.widget.SimpleDialog("dlg", objAtributos);

    // Muestra el cuadro de dialogo
    objDialogo1.setHeader("Atención");
    objDialogo1.render(document.body);
    objDialogo1.show();
}

function verCambiosFormularioActos(seqFormulario, seqFormularioActo, seqSeguimiento) {

    var numAncho = YAHOO.util.Dom.getClientWidth() - 100;
    var numAlto = YAHOO.util.Dom.getClientHeight() - 50;

    // Objeto de respuesta si es satisfactoria la carga
    var handleSuccess =
            function (o) {
                if (o.responseText !== undefined) {

                    var objConfiguracion = {
                        width: numAncho,
                        height: numAlto,
                        fixedcenter: true,
                        close: true,
                        draggable: true,
                        modal: true,
                        visible: false
                    }

                    var objPanel = new YAHOO.widget.Panel(
                            "cambios",
                            objConfiguracion
                            );

                    objPanel.setHeader("Ver Cambios en el Formulario");
                    objPanel.setBody(o.responseText);

                    objPanel.render(document.body);
                    objPanel.show();

                }
            };

    // Objeto de respuesta si la carga falla
    var handleFailure =
            function (o) {
                if (o.responseText !== undefined) {

                    // Cuando se vence la sesion la respuesta es HTTP 401 = Not Authorized
                    if (o.status == "401") {
                        document.location = 'index.php';
                    } else {

                        // Mensaje cuando la pagina no es encontrada
                        var htmlCode = "";
                        htmlCode = +o.status + " " + o.statusText;

                        // Otros mensajes de error son mostrados directamente en el div
                        document.getElementById("mensajes").innerHTML = htmlCode;
                    }
                    return false;
                }
            };

    // Objeto de respuestas
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };

    // peticion asincrona al servidor
    var callObj = YAHOO.util.Connect.asyncRequest("POST", "./contenidos/seguimiento/verCambiosFormularioActos.php", callback, "seqFormularioActo=" + seqFormulario + "&seqSeguimiento=" + seqSeguimiento + "&alto=" + numAlto);

}

function obtenerDatos(seqProyecto) {
    if (seqProyecto != "") {
        var objCargando = obtenerObjetoCargando();
        var parametros = {
            "seqProyecto": seqProyecto
        };
        $.ajax({
            data: parametros,
            url: './contenidos/proyectos/reportes/fichaTecnicaProyectos.php',
            type: 'post',
            beforeSend: function () {
                objCargando.show();
            },
            success: function (response) {
                objCargando.hide();
                $("#divDatos").html(response);
            }
        });


    }
}
function exportarExcel(estado, proyecto, tipo) {
    location.href = './contenidos/crm/reportes/reporteTableroExcel.php?seqEstado=' + estado + '&seqProyecto=' + proyecto + '&tipo=' + tipo;
}
function validarCalificacion() {
    // var url = $("#txtArchivo").val();
    var documento = $("#buscaCedulaConfirmacion").val();
    var url = "./contenidos/calificacion/datosCalificacion.php"; // El script a dónde se realizará la petición.
    $.ajax({
        type: "POST",
        url: url,
        data: {
            "documento": documento
        }, // Adjuntar los campos del formulario enviado.
        success: function (data)
        {
            $("#destino").html(data); // Mostrar la respuestas del script PHP.

        }
    });
}

function exportableExcel(array){

    var url = "../../migracionesIndividual/generarLinks.php"; // El script a dónde se realizará la petición.
    $.ajax({
        type: "POST",
        url: url,
        data: {
            "array": array
        }, // Adjuntar los campos del formulario enviado.
        success: function (data)
        {
            $("#destino").html(data); // Mostrar la respuestas del script PHP.

        }
    });
}