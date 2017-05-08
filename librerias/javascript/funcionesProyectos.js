function marcarTodos() {
    jQuery("#marcarTodos").click(
            function ($) {
                var marcado = $("#marcarTodos").is(":checked");

                if (!marcado)
                    $("#diasHabilitados :checkbox").attr('checked', true);
                else
                    $("#diasHabilitados :checkbox").attr('checked', false);
            }
    );
}

jQuery(function () {
    jQuery("#accordion").accordion();
});

$(document).ready(function () {
    $('#example').DataTable({
        "pagingType": "full_numbers"
    });
});


     