$(function () {
    $('#myTab li:last-child a').tab('show')
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
    console.log("paso");
    //console.log($("#seqGrupoGestion").select());
    $.each($("#frmProyectos input.required"), function (index, value) {
        if (!$(value).val()) {
            console.log($(this).attr("id") + " ");
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id") + "input");
            valid = false;
        }

    });
    $.each($("#frmProyectos select.required"), function (index, value) {

        if ($(value).val() == 0) {
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id") + "select");
            valid = false;
        }
    });
    $.each($("#frmProyectos input[type=email].required"), function (index, value) {
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
        console.log(caract.test($(value).val()));
        if (caract.test($(value).val()) == false) {
            $("#val_" + $(this).attr("id")).css("display", "inline");
            $("#val_" + $(this).attr("id")).html("Correo erroneo! ");
            console.log($(this).attr("id") + " input email");
            valid = false;
        }
    });
    $.each($("#frmProyectos textArea.required"), function (index, value) {

        if ($(value).val() == 0) {
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
           // console.log($(this).attr("id"));
            valid = false;
        }
    });
    //console.log("paso " + valid);
    if (valid) {
        var url = $("#txtArchivo").val();
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
    var fType = "<select name=\"seqOferente[]\" id=\"seqOferente_" + intId + "\" class=\"form-control required\"   style=\"position: relative;float: left; width: 85%\">";
    $("#seqOferente option").each(function () {
        fType += "<option value=" + $(this).attr('value') + ">" + $(this).text() + "</option>";
    });
    fType += "</select></div>";
    fType += "<div class=\"col-md-3\"><label class=\"control-label\" >Nombre Contaco Oferente</label>";
    fType += "<input name=\"txtNombreContactoOferente[]\" type=\"text\" id=\"txtNombreContactoOferente\" onBlur=\"sinCaracteresEspeciales(this);\" class=\"form-control\" style=\"width:160px;\"/>";
    fType += "</div>";
    fType += "<div class=\"col-md-3\">";
    fType += "<label class=\"control-label\" >Correo Contacto</label> ";
    fType += "<input name=\"txtCorreoOferente[]\" type=\"text\" id=\"txtCorreoOferente\" value=\"\" onBlur=\"sinCaracteresEspeciales(this);\" class=\"form-control\" style=\"width:140px;\"/></div>";
    fType += "<div class=\"col-md-2\"><label class=\"control-label\" >Telefono Oferente</label>";
    fType += "<input name=\"numTelContactoOferente[]\" type=\"text\" id=\"numTelContactoOferente\" value=\"\" onBlur=\"sinCaracteresEspeciales(this);\" class=\"form-control\" style=\"position: relative; float: left;width:70%;\"/>";
    fType += "<img src=\"recursos/imagenes/remove.png\" width=\"22px\" onclick=\"removerOferente(table" + intId + ")\" style=\"position: relative; float: left; width:20% \"/>";
    fType += "</div></div>";
    fName += fType;
    // fName += "<img src=\"recursos/imagenes/remove.png\" width=\"22px\" onclick=\"removerOferente(table" + intId + ")\"/>";
    fName += "</div></div>";
    fieldWrapper.append(fName);
    $("#buildyourform").append(fieldWrapper);
}

function removerOferente(id) {
    $(id).parent().remove();
}

