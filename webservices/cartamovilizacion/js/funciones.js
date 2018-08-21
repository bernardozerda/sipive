
function paginaPrincipal(){
  // location.href = 'http://localhost/CartasMovilizacion/samples/Cliente.php';
	location.href = 'http://sdv.habitatbogota.gov.co/CartasMovilizacion/samples/Cliente.php';
  //  $(location).href('http://localhost/CartasMovilizacion/samples/Cliente.php');
//  var url = "samples/Cliente.php"; // El script a dónde se realizará la petición.
//    $.ajax({
//        type: "POST",
//        url: url,
//        data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
//        success: function (data) {
//            //console.log(data);
//            $("#content").html(data); // Mostrar la respuestas del script PHP.
//        }
//    });
}
var variable = 0;
function validar() {

    var valid = true;
    $('form#formulario').find('input[type="text"]').each(function () {
        if ($(this).prop('required') == true) {
            // console.log("NR***" + $(this).val());
            if (!$(this).val()) {
                // console.log("NR" + $(this));
                $("#" + $(this).attr("id")).css("border", "1px solid red");
                $(".invalid-tooltip").show();
                $("#val_" + $(this).attr("id")).show();
                valid = false;
            } else if ($(this).attr("id") == "codigo") {
                var codigo = ObtenerCodigo(variable);
                // console.log(codigo + " => " + $("#codigo").val());
                if (codigo != $("#codigo").val()) {
                    variable++;
                    $("#valCaptcha").val(variable);
                    if(variable > 2){
                        validaCaptcha();
                    }
                    $("#val_codigo").show();
                    $("#val_codigo").html("El Codigo no coincide Por favor Verifique!!");
                    valid = false;
                }
            }

        }
    });
    $('form#formulario').find('input[type="radio"]').each(function () {
        if ($(this).prop('required') == true) {
            // console.log("NR***" + $(this).val());
            if (!$(this).is(':checked')) {
                //console.log("NR!!!" + $(this).attr("id"));
                $("#" + $(this).attr("id")).css("border", "1px solid red");
                $("#val_" + $(this).attr("id")).show();
                valid = false;
            }
            // console.log($('input[name="radioBanco"]').is(':checked'));
        }
    });
    $.each($("#formulario select.required"), function (index, value) {
        $("#val_" + $(this).attr("id")).css("display", "none");
        $("#" + $(this).attr("id")).css("border", "1px solid #ccc");
        if ($(value).val() == '') {
            $("#" + $(this).attr("id")).css("border", "1px solid red");
            $("#val_" + $(this).attr("id")).show();
            //$("#val_" + $(this).attr("id")).css("display", "inline");
            console.log($(this).attr("id") + "select");
            valid = false;
        }
    });



    return valid;
}

function enviarDatos() {
    //document.write('<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>');

    var url = "callWS.php"; // El script a dónde se realizará la petición.
    $.ajax({
        type: "POST",
        url: url,
        data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
        success: function (data) {
            //console.log(data);
            $("#content").html(data); // Mostrar la respuestas del script PHP.
        }
    });
}

function ObtenerCodigo(valor) {
    var url = "code.php?variable="+valor;
    var result = false;
    //alert("paso => " + $("#numeroIdentificacion").val());
    $.ajax({
        type: "POST",
        url: url,
        async: false,
        success: function (data) {
            result = data;
        }
    });
    console.log(result);
    return result;
}

function validaCaptcha() {
    var url = "code.php";
    var result = false;
    //alert("paso => " + $("#numeroIdentificacion").val());
    $.ajax({
        type: "POST",
        url: url,
        async: false,
        success: function (data) {
            result = data;
        }
    });
    console.log(result);
    return result;
}

function getUserIP(onNewIP) { //  onNewIp - your listener function for new IPs
    //compatibility for firefox and chrome
    var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new myPeerConnection({
        iceServers: []
    }),
            noop = function () {
            },
            localIPs = {},
            ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
            key;

    function iterateIP(ip) {
        if (!localIPs[ip])
            onNewIP(ip);
        localIPs[ip] = true;
    }

    //create a bogus data channel
    pc.createDataChannel("");

    // create offer and set local description
    pc.createOffer().then(function (sdp) {
        sdp.sdp.split('\n').forEach(function (line) {
            if (line.indexOf('candidate') < 0)
                return;
            line.match(ipRegex).forEach(iterateIP);
        });

        pc.setLocalDescription(sdp, noop, noop);
    }).catch(function (reason) {
        // An error occurred, so handle the failure to connect
    });

    //listen for candidate events
    pc.onicecandidate = function (ice) {
        if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex))
            return;
        ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
    };
}
// Usage
getUserIP(function (ip) {
    // document.getElementById("dirIp").value = ip;
});

function cambiarImagenCaptcha(txtRutaCaptcha) {

    // Obtiene el objeto que contendra la imagen generada
    var objImagen = document.getElementById("imagenCaptcha");

    // esta parte se usa para hacer creer al navegador que es una imagen nueva
    // sin esto, algunos navegadores como firefox cachean la imagen y no muestra
    // la nueva imagen generada
    objImagen.src = txtRutaCaptcha + "&" + Math.random() + "=" + Math.random();

}


