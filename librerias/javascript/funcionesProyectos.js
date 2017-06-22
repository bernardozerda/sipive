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
    //console.log($("#seqGrupoGestion").select());
    $.each($("#frmProyectos input.required"), function (index, value) {
        if (!$(value).val()) {
            console.log($(this).attr("id"));
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            valid = false;
        }

    });
    $.each($("#frmProyectos select.required"), function (index, value) {

        if ($(value).val() == 0) {
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id"));
            valid = false;
        }
    });
    if (valid) {
        console.log("url -> " + url);
        // var url = "./contenidos/proyectos/contenidos/datosOferente.php"; // El script a dónde se realizará la petición.
        var url = $("#txtArchivo").val();

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



jQuery(function () {
    try {
        jQuery("#accordion").accordion();
    }catch(o){

    }
});

function adicionarOferente() {

    $("#seqProyectoOferente option").each(function () {
        console.log('opcion ' + $(this).text() + ' valor ' + $(this).attr('value'))
    });
    var intId = $("#buildyourform div").length + 1;
    var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
    var fName = "<table id='table"+intId+"'><tr><td width='53%'><label>Oferente(*)</label></td><td>";
    var fType = "<select name=\"seqProyectoOferente[]\" class=\"fieldtype\" >";
    $("#seqProyectoOferente option").each(function () {
        fType += "<option value=" + $(this).attr('value') + ">" + $(this).text() + "</option>";
    });
    fType += "</select>";
    fName += fType + "</td><td>";
    fName += "<img src=\"recursos/imagenes/remove.png\" width=\"20px\" onclick=\"removerOferente(table" + intId + ")\"/>";
    fName += "</td></tr></table>";
    fieldWrapper.append(fName);
    $("#buildyourform").append(fieldWrapper);

}

function removerOferente(id) {
    console.log("paso remover" + id);
    $(id).parent().remove();

}
