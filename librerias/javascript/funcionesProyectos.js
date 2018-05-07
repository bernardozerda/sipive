$(function () {
    $('#myTab li:last-child a').tab('show');
})
function marcarTodos() {
    $("#marcarTodos").click(
            function ($) {
                var marcado = $("#marcarTodos").is(":checked");
                if (!marcado)
                    $("#diasHabilitados :checkbox").attr('checked', true);
                else
                    $("#diasHabilitados :checkbox").attr('checked', false);
            });
}
function  tablas() {
    if ($("#accordion").size() > 0) {
        $(document).ready(function () {
            $("#accordion").accordion();
            $('#example').DataTable({
                "pagingType": "full_numbers"
            });
        });
    } else {
        if ($("#example").size() > 0) {
            $(document).ready(function () {
                $('#example').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "order": [[2, "desc"]],
                    "scrollY": "450px",
                    "scrollCollapse": true
                });
            });

        }
    }
}
// Autora: Liliana Basto
// Funcion que almacena todos los formularios 
function almacenarIncripcion() {
    var valid = true;
    $.each($("#frmProyectos input.required"), function (index, value) {
        $("#val_" + $(this).attr("id")).css("display", "none");
        $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
        console.log("value : " + $("#txtLicenciaConstructor").val());
        if (!$(value).val()) {
            console.log("paso1 : " + $(value).val());
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id") + " input");
            valid = false;
        }

    });
    // console.log($("#frmProyectos select.required"));
    $.each($("#frmProyectos select.required"), function (index, value) {
        $("#val_" + $(this).attr("id")).css("display", "none");
        $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
        if ($(value).val() == 0) {
            // console.log($(value).val()+ " ****** "+index+"  ----- "+value);
            // console.log($(this).attr("id") + "select");
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id") + "select");
            valid = false;
        }
    });
    $.each($("#frmProyectos input[type=email].required"), function (index, value) {
        $("#val_" + $(this).attr("id")).css("display", "none");
        $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
        //console.log(caract.test($(value).val()));
        if (caract.test($(value).val()) == false) {
            $("#val_" + $(this).attr("id")).css("display", "inline");
            $("#val_" + $(this).attr("id")).html("Correo erroneo! ");
            console.log($(this).attr("id") + " input email");
            valid = false;
        }
    });
    $.each($("#frmProyectos textArea.required"), function (index, value) {
        $("#val_" + $(this).attr("id")).css("display", "none");
        $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
        if ($(value).val() == 0) {
            // console.log("paso3");
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id"));
            valid = false;
        }
    });
    $.each($("#frmProyectos input"), function (index, value) {
        if ($(value).val() != 0 && $(value).val() != null) {
            //console.log("value : " + $(value).val() + " index -> " + index);
            var separador = "Tel";
            var num = $(this).attr("id");
            if (num != 'undefined' && num != null && num != "") {
                separador = "Tel";
                num = num.split(separador);
                if (num.length > 1) {
                    $("#val_" + $(this).attr("id")).css("display", "none");
                    $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
                    // console.log("id : " + $(this).attr("id") + " tel: " + $("#" + $(this).attr("id")).val().length);
                    if ($("#" + $(this).attr("id")).val().length != 7 && $("#" + $(this).attr("id")).val().length != 10) {
                        $("#" + $(this).attr("id")).css("border", "1px solid red");
                        $("#val_" + $(this).attr("id")).css("display", "inline");
                        $("#val_" + $(this).attr("id")).html("Debe tener 7 o 10 numeros");
                        valid = false;
                    }
                }
                // console.log("num - > " + num.length + " valid = " + valid);
            }
        }
    });
    if (valid == false) {
        $("#mensajes").html("Por favor verifique todos los campos obligatorios(*) resaltados en rojo");
        $("#mensajes").css("color", "red");
        $("#mensajes").css("padding-top", "10px");
        $("#mensajes").css("font-weight", "bold");
    }
    console.log("valid : " + valid);
    if (valid) {
        var url = $("#txtArchivo").val();
        $("#mensajes").html("");
        // var url = "./contenidos/proyectos/contenidos/datosOferente.php"; // El script a dónde se realizará la petición.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#frmProyectos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function (data)
            {
                $("#contenido").html(data); // Mostrar la respuestas del script PHP.
                tablas();
            }
        });
    }
}

function adicionarOferente() {
    var intId = $("#buildyourform select").length + 1;
    var fieldWrapper = $("<div class=\"form-group\" id=\"field" + intId + "\" />");
    var fName = "<div id=\"table" + intId + "\"><div class=\"col-md-3\"><label>Oferente(*)</label>";
    var fType = "<select name=\"seqOferente[]\" id=\"seqOferente_" + intId + "\" class=\"form-control required\"   onchange=\"limpiarOferente(" + intId + ");\" style=\"position: relative;float: left; width: 85%\">";
    $("#seqOferente_" + (intId - 1) + " option").each(function () {
        fType += "<option value=" + $(this).attr('value') + ">" + $(this).text() + "</option>";
    });
    fType += "</select></div>";
    fType += "<div class=\"col-md-3\"><label class=\"control-label\" >Nombre Contaco Oferente</label>";
    fType += "<input name=\"txtNombreContactoOferente[]\" type=\"text\" id=\"txtNombreContactoOferente_" + intId + "\" onBlur=\"sinCaracteresEspeciales(this);\" class=\"form-control\" style=\"width:160px;\"/>";
    fType += "</div>";
    fType += "<div class=\"col-md-3\">";
    fType += "<label class=\"control-label\" >Correo Contacto</label> ";
    fType += "<input name=\"txtCorreoOferente[]\" type=\"text\" id=\"txtCorreoOferente\" value=\"\" onBlur=\"sinCaracteresEspeciales(this);\" class=\"form-control\" style=\"width:140px;\"/></div>";
    fType += "<div class=\"col-md-2\"><label class=\"control-label\" >Telefono Oferente</label>";
    fType += "<input name=\"numTelContactoOferente[]\" type=\"text\" id=\"numTelContactoOferente_" + intId + "\" value=\"\" onBlur=\"sinCaracteresEspeciales(this); soloNumeros(this);\" class=\"form-control\" style=\"position: relative; float: left;width:70%;\"/>";
    fType += "<img src=\"recursos/imagenes/remove.png\" width=\"22px\" onclick=\"removerOferente(table" + intId + ")\" style=\"position: relative; float: left; width:20% \"/>";
    fType += "<div id='val_numTelContactoOferente_" + intId + "' class='divError'>Debe diligenciar el numero de contacto del Oferente</div></div></div>";
    fName += fType;
    fName += "</div></div>";
    fieldWrapper.append(fName);
    $("#buildyourform").append(fieldWrapper);
}

function removerOferente(id) {
    $(id).remove();
}

function obtenerModalidadProyecto(value) {

    var parametros = {
        "valor": value
    };
    $.ajax({
        data: parametros,
        url: 'contenidos/proyectos/contenidos/datosSelect.php',
        type: 'post',
        dataType: "json",
        success: function (response) {

            var select = $('#seqPryTipoModalidad');
            $('#seqPryTipoModalidad').empty();
            var options = select.attr('options');
            var selectedOption = '';
            $("#seqPryTipoModalidad").append('<option value="0">Seleccione</option>');
            $.each(response, function (val, text) {

                $("#seqPryTipoModalidad").append('<option value=' + val + '>' + text + '</option>');
            });
        }
    });
}
function showMenu() {
    $(document).ready(function () {
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
            //console.log("paso2" + event.preventDefault());
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
}

function limpiarOferente(int) {
    $("#txtNombreContactoOferente_" + int).val("");
    $("#txtCorreoOferente_" + int).val("");
    $("#numTelContactoOferente_" + int).val("");
}

function addAmparos() {
    var intId = $("#idAmparos select").length + 1;
    var fieldWrapper = $("<div class=\"form-group\" id=\"amp" + intId + "\" />");
    var fType = " <fieldset style=\"border: 1px dotted #024457; width: 95%;margin-left: 10px; padding: 5px;\"> <legend style=\"text-align: right\"><p><h5>&nbsp;<img src=\"recursos/imagenes/add.png\" width=\"20px\" onclick=\"addAmparos();\"  /><b>&nbsp; Adicionar  Amparo</b>&nbsp; <img src=\"recursos/imagenes/remove.png\" width=\"20px\"  onclick='removerOferente(amp" + intId + ")'/><b style=\"text-align: right\">&nbsp; Eliminar Amaparo</b></h5></p></legend>";
    fType += "<div class=\"col-md-3\"> <input name=\"seqAmparo[]\" type=\"hidden\" id=\"seqAmparo\" value=\"\" onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\"><label class=\"control-label\" >Tipo de Amparo</label><input name=\"seqAmparoPadre[]\" type=\"hidden\" id=\"seqAmparoPadre\" value='' onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\"><select id=\"seqTipoAmparo_" + intId + "\" name=\"seqTipoAmparo[]\" class=\"form-control\" style=\"width: 75%\">";
    $("#seqTipoAmparo_1" + " option").each(function () {
        fType += "<option value=" + $(this).attr('value') + ">" + $(this).text() + "</option> ";
    });
    fType += "</select></div><div class=\"col-md-2\"><label class=\"control-label\" >Vigencia Desde:</label><input name=\"fchVigenciaIni[]\" type=\"text\" id=\"fchVigenciaIni_" + intId + "\" value=\"\" size=\"12\" readonly=\"\"  class=\"form-control\"  style=\"width: 70%; position: relative; float: left\"><a href=\"#\" onclick=\"javascript: calendarioPopUp('fchVigenciaIni_" + intId + "');\"><img src=\"recursos/imagenes/calendar.png\" style=\"cursor: hand;width: 18%; position: relative; float: right; right:10%\"></a></div>";
    fType += "<div class=\"col-md-2\"><label class=\"control-label\" >Vigencia Hasta:</label><input name=\"fchVigenciaFin[]\" type=\"text\" id=\"fchVigenciaFin_" + intId + "\" value=\"\" size=\"12\" readonly=\"\"  class=\"form-control\"  style=\"width: 70%; position: relative; float: left\"><a href=\"#\" onclick=\"javascript: calendarioPopUp('fchVigenciaFin_" + intId + "');\"><img src=\"recursos/imagenes/calendar.png\" style=\"cursor: hand;width: 18%; position: relative; float: right; right:10%\"></a></div>";
    fType += "<div class=\"col-md-3\"><label class=\"control-label\" >Valor Asegurado</label><input name=\"valAsegurado[]\" type=\"text\" id=\"valAsegurado_" + intId + "\" value=\"\" onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\"></div> ";
    fType += "<div class=\"col-md-2\"><br><br></div>";
    fType += "<p>&nbsp;</p></fieldset><p>&nbsp;</p></div>";
    fieldWrapper.append(fType);
    $("#idAmparos").append(fieldWrapper);
}

function addProrroga(idPadre, usuario) {
    //$("#demo" + idPadre).addClass("collapse in");
    $("#demo" + idPadre).css({"display": "block"});

    var intIdHijo = $("#demo" + idPadre + " select").length + 1;

    var fieldWrapper = $("<div class=\"form-group\" id=\"ampHijo" + idPadre + "_" + intIdHijo + "\" />");
    var fType = "<div class=\"col-md-3\"><label class=\"control-label\" >Porroga " + intIdHijo + "</label><select id=\"seqTipoAmparo" + idPadre + "_" + intIdHijo + "\" name=\"seqTipoAmparo[]\" class=\"form-control\" style=\"width: 75%\">";
    fType += "<option value='6'>Prorroga</option>  <input name=\"seqAmparo[]\" type=\"hidden\" id=\"seqAmparo\" value=\"\" onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\"><input name=\"seqAmparoPadre[]\" type=\"hidden\" id=\"seqAmparoPadre\" value=\"" + idPadre + "\" onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\">";
    fType += "</select></div><div class=\"col-md-2\"><label class=\"control-label\" >Vigencia Desde:</label><input name=\"fchVigenciaIni[]\" type=\"text\" id=\"fchVigenciaIni" + idPadre + "_" + intIdHijo + "\" value=\"\" size=\"12\" readonly=\"\"  class=\"form-control\"  style=\"width: 70%; position: relative; float: left\"><a href=\"#\" onclick=\"javascript: calendarioPopUp('fchVigenciaIni" + idPadre + "_" + intIdHijo + "');\"><img src=\"recursos/imagenes/calendar.png\" style=\"cursor: hand;width: 18%; position: relative; float: right; right:10%\"></a></div>";
    fType += "<div class=\"col-md-2\"><label class=\"control-label\" >Vigencia Hasta:</label><input name=\"fchVigenciaFin[]\" type=\"text\" id=\"fchVigenciaFin" + idPadre + "_" + intIdHijo + "\" value=\"\" size=\"12\" readonly=\"\"  class=\"form-control\"  style=\"width: 70%; position: relative; float: left\"><a href=\"#\" onclick=\"javascript: calendarioPopUp('fchVigenciaFin" + idPadre + "_" + intIdHijo + "');\"><img src=\"recursos/imagenes/calendar.png\" style=\"cursor: hand;width: 18%; position: relative; float: right; right:10%\"></a></div>";
    fType += "<div class=\"col-md-2\"><label class=\"control-label\" >Valor Asegurado</label><input name=\"valAsegurado[]\" type=\"text\" id=\"valAsegurado" + idPadre + "_" + intIdHijo + "\" value=\"\" onblur=\"sinCaracteresEspeciales(this);\"  class=\"form-control\"></div> ";
    fType += " <div class=\"col-md-2\" style=\"width: 5.5%\"><label class=\"control-label\" >Aprobo</label> <br><input name=\"bolAproboAmparo[]\" type=\"checkbox\" id=\"bolAprobo" + idPadre + "_" + intIdHijo + "\"  value=\"1\"  style=\"height: 15px; text-align: center\" onclick=\"selectUsuario(this.id, " + usuario + ")\">&nbsp;&nbsp;<input type=\"hidden\" name=\"seqUsuario[]\" id=\"seqUsuario" + idPadre + "_" + intIdHijo + "\" value=\"'0'\"></div>";
    fType += "<div class=\"col-md-2\"><br><br><input type=\"button\"  value=\"Prorroga\" class=\"btn_deleted\"  onclick='removerOferente(ampHijo" + idPadre + "_" + intIdHijo + ")'/></div>";
    fType += "<p>&nbsp;</p></fieldset><p>&nbsp;</p></div>";
    fieldWrapper.append(fType);
    $("#demo" + idPadre).append(fieldWrapper);
}


var fncActivarMenuNietos = function () {
    $('.dropdown-submenu a.test').on("click", function (e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
    eliminarObjeto("divNietos");
    YAHOO.util.Event.onContentReady(
            "divNietos",
            fncActivarMenuNietos
            );
}

YAHOO.util.Event.onContentReady(
        "divNietos",
        fncActivarMenuNietos
        );

function selectUsuario(valor, user) {
    var id = valor.split("bolAprobo");
    if ($("#" + valor).is(':checked')) {
        // console.log("paso");
        $("input[id=seqUsuario" + id[1] + "]:hidden").val(user);
    } else {
        $("input[id=seqUsuario" + id[1] + "]:hidden").val('0');

    }
}