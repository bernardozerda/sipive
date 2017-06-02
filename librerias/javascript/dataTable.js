/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function obtenerCssTable() {

    $(document).ready(function () {
        $('#example').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [10, 25, 50, 75, 100]
        });
    });
}

function analizarSimulador() {

    var smmlv = $("#smmlv").val();
    var simRetorno = $('input:checkbox[name=simRetorno]:checked').val();
    var valorRetorno = 35;
    if (simRetorno == 'on') {
        valorRetorno = 26;
    } else {
        valorRetorno = 35;
    }

    var simAhorro = parseInt($('#simAhorro').val().replace(/[.]/g, ''));
    var smmlvAhorro = simAhorro / smmlv;
    $('#simSmmAhorro').html(parseFloat(smmlvAhorro).toFixed(3));
    var simSubsidio = parseInt($('#simValSubsidioNacional').val().replace(/[.]/g, ''));
    var smmlvSubsidio = simSubsidio / smmlv;
    $('#simSmmSubsidio').html(parseFloat(smmlvSubsidio).toFixed(3));
    var simCesantias = parseInt($('#simValCesantias').val().replace(/[.]/g, ''));
    var smmlvCesantias = simCesantias / smmlv;
    $('#simSmmCesantias').html(parseFloat(smmlvCesantias).toFixed(3));
    var simCredito = parseInt($('#simValCredito').val().replace(/[.]/g, ''));
    var smmlvCredito = simCredito / smmlv;
    $('#simSmmCredito').html(parseFloat(smmlvCredito).toFixed(3));
    var simDonacion = parseInt($('#simValDonacion').val().replace(/[.]/g, ''));
    var smmlvDonacion = simDonacion / smmlv;
    $('#simSmmDonacion').html(parseFloat(smmlvDonacion).toFixed(3));
    var simTotalRecP = simAhorro + simCesantias + simCredito;
    $('#simTotalAhorro').html(formatNumber.new(simTotalRecP, "$"));
    var smmTotalRecP = simTotalRecP / smmlv;
    $('#simTotalRecP').html(parseFloat(smmTotalRecP).toFixed(3));
    var simTotalSubsidios = simSubsidio + simDonacion;
    $('#simTotalSubsidios').html(formatNumber.new(simTotalSubsidios, "$"));
    var smmlvTotalSubsidios = simTotalSubsidios / smmlv;
    $('#smmlvTotalSubsidios').html(parseFloat(smmlvTotalSubsidios).toFixed(3));

    var simRecProp = simTotalRecP / smmlv;
    var simRecSubsidios = simTotalSubsidios / smmlv;

    var simPiveAporte = 0;
    if ($("#simVictima").val() == 'true') {
        simPiveAporte = valorRetorno;
//        console.log("*****" + simPiveAporte);
        if ((simPiveAporte + smmlvTotalSubsidios) > 70) {
            var suma = 70 - smmlvTotalSubsidios;
            simPiveAporte = suma;
        }
    } else {
        simPiveAporte = valorRetorno - simRecSubsidios;
        if (simPiveAporte <= 0) {
            simPiveAporte = 0;
        }
    }
    var simCierre = simRecProp + simRecSubsidios + simPiveAporte;

//    console.log("*** operacion**  " + simRecProp + "+" + simRecSubsidios + "+" + simPiveAporte);
//    console.log("*** cierre " + simCierre);
    $('#simTotalAporte').html(formatNumber.new(simPiveAporte * smmlv, "$"));
    $('#smmTotalAporte').html(parseFloat(simPiveAporte).toFixed(3));





    var TotalAdVivienda = simRecProp + simRecSubsidios + simPiveAporte;
    $('#simTotalAdqVivienda').html(formatNumber.new(TotalAdVivienda * smmlv, "$"));
    $('#smmTotalAdqVivienda').html(parseFloat(TotalAdVivienda).toFixed(3));

    var totalPenCierre = 70 - TotalAdVivienda;

    $('#totalPenCierre').html(formatNumber.new(Math.round(totalPenCierre * smmlv), "$"));
    $('#smmPenCierre').html(parseFloat(totalPenCierre).toFixed(3));

    if (totalPenCierre < 0) {
        $("#totalPenCierre").css("color", "red");
        $("#smmPenCierre").css("color", "red");
    } else {
        $("#totalPenCierre").css("color", "#000000");
        $("#smmPenCierre").css("color", "#000000");
    }

//    if ((simPiveAporte * smmlv) == 0) {
//        $('#divLeftP').html('UD puede optar por subsidio nivel central (Mi Casa Ya)');
//    } else 
    if (totalPenCierre < 0) {
        $('#divLeftP').html('UD podrá tomar Menor Valor del Credito o de los Ahorros');
        
    } else if($("#simVictima").val() != 'true' && totalPenCierre >0 && smmlvTotalSubsidios> 0){
            $('#divLeftP').html('UD no dispone de recursos adicionales. Se sugiere optar por un crédito para alcanzar el cierre financiero o en caso de continuar la opción de Leasing no podrá aplicar el Subsidio reportado');
        
    }else if(totalPenCierre <= 0 && simPiveAporte == 0){
        $('#divLeftP').html('UD dispone de recursos y aportes para la solución de vivienda. La SDHT no podrá asignar recursos adicionales en PIVE');
    }else if (totalPenCierre > 0) {
        $('#divLeftP').html('UD no dispone de recursos adicionales, podrá tomar la opción de Leasing');
    } 
}

var formatNumber = {
    separador: ".", // separador para los miles
    sepDecimal: ',', // separador para los decimales
    formatear: function (num) {
        num += '';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft;
        /// return this.simbol + splitLeft + splitRight;
    },
    new : function (num, simbol) {
        this.simbol = simbol || '';
        return this.formatear(num);
    }
}

