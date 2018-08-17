<html>
    <style type="text/css">@import "../css/habitat.css"</style>
    <header>
       
    </header>



    <?php
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */


    require_once('../lib/nusoap.php');
    include '../lib/tcpdf/tcpdf.php';

    $identificacion = 0;
    $arrBanco = Array();
    $msn1 = '';
    $msn2 = '';
    $msn3 = '';
    $ahorro1 = 0;
    $ahorro2 = 0;
    $cuenta = 0;
    $cuenta1 = 0;
    $cuenta2 = 0;
    $nombreWs = '';
    if (isset($_POST['numeroIdentificacion'])) {


        $identificacion = $_POST['numeroIdentificacion'];
        $cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_cartasMovilizacion.php');
        $seqBanco = 0;
        if (isset($_POST['seqBanco']) && $_POST['seqBanco'] != "") {
            $seqBanco = $_POST['seqBanco'];
        } else if (isset($_POST['seqBanco2']) && $_POST['seqBanco2'] != "") {
            $seqBanco = $_POST['seqBanco2'];
        } else {
            $seqBanco = $_POST['seqBancoOtro'];
        }
        $cuenta = $_POST['radioBanco'];

        $datos_persona_entrada = array("datos_persona_entrada" => array(
                'documento' => $_POST['numeroIdentificacion'],
                'nombre' => $_POST['nombre'],
                'banco' => $seqBanco,
                'cuenta' => $cuenta
            )
        );


        $resultado = $cliente->call('obtenerDatosCarta', $datos_persona_entrada);
        //var_dump($resultado);
        $arrBanco = $resultado['banco'];
        $seqFormulario = trim($resultado['formulario']);
        $msn1 = $resultado['msn1'];
        $msn2 = $resultado['msn2'];
        $msn3 = $resultado['msn3'];
        $nombreWs = $resultado['nombre'];

        $ahorro1 = $resultado['ahorro1'];
        $cuenta1 = $resultado['cuenta1'];
        $ahorro2 = $resultado['ahorro2'];
        $cuenta2 = $resultado['cuenta2'];
        // documento=" + documento + "&cuenta=" + radio + "&tipo=" + tipo + "&banco=" + entidad + "&nombre=" + nombre     
        $data = mb_split("\"", $resultado['mensaje']);
        if (isset($data[4])) {
            header('Content-Type: application/pdf');
            echo trim(base64_decode($data[4]));
        }
    }
    ?>
    <?php if (isset($msn1) && $msn1 != "" && $msn1 != NULL) { ?>

        <div class="content">
            <!-- target="framename"-->
            <form action=""  method="post">          

                <fieldset>
                    <legend><h2><?php echo $msn1; ?></h2></legend>
                    <h3><?php echo $msn2; ?></h3>
                    <table>
                        <tr>
                            <td>Nombre Completo *<input id="nombre" name="nombre" title="Digite su nombre Completo." class="required" type="text" value="<?php if ($nombreWs != "") echo ucwords(strtolower($nombreWs)) ?>"  size="60" required="required">
                                <input id="numeroIdentificacion" name="numeroIdentificacion"   type="hidden" value="<?php echo $_POST['numeroIdentificacion'] ?>" maxlength="11">

                            </td>
                        </tr>
                        <?php if ($ahorro1 > 0) { ?>
                            <tr> 
                                <td>
                                    <div id="divOculto">
                                        <table>
                                            <tr>
                                                <th> <input type="radio" id="radio" name="radioBanco"  value="1" onclick="if (document.getElementById('divOculto3') != null) {
                                                                    document.getElementById('divOculto3').remove()
                                                                }
                                                                ;
                                                                if (document.getElementById('divOculto2') != null) {
                                                                    document.getElementById('divOculto2').remove();
                                                                }" required="required"/> Banco Cuenta Ahorro  *</th>
                                                <td>
                                                    <select id="seqBanco" name="seqBanco" required="required">
                                                        <option value="">Seleccione</option>
                                                        <?php
                                                        $banc = Array();
                                                        foreach ($arrBanco as $key => $value) {
                                                            foreach ($value as $value2) {
                                                                $valor = explode('*', $value2);
                                                                ?>
                                                                <option <?php if ($cuenta1 == $valor[1]) echo "selected" ?> value="<?php echo $valor[1] ?>"><?php echo $valor[0] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <th>Recursos A Movilizar</th>
                                                <td><input type="text"  name="ahorro1Ws" id="ahorro1Ws" value="<?php echo $ahorro1 ?>" readonly="true"></td> 
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($ahorro2 > 0) { ?>
                            <tr> 
                                <td>
                                    <div id="divOculto3">
                                        <table>
                                            <tr>
                                                <th> <input type="radio" id="radio_1" name="radioBanco" value="2" onclick="if (document.getElementById('divOculto2') != null) {
                                                                    document.getElementById('divOculto2').remove();
                                                                }
                                                                if (document.getElementById('divOculto') != null) {
                                                                    document.getElementById('divOculto').remove();
                                                                }" required="required"/> Banco Cuenta Ahorro 2 *</th>
                                                <td>
                                                    <select id="seqBanco" name="seqBanco2" required="required">
                                                        <option value="">Seleccione</option>
                                                        <?php
                                                        $banc = Array();
                                                        foreach ($arrBanco as $key => $value) {
                                                            foreach ($value as $value2) {
                                                                $valor = explode('*', $value2);
                                                                ?>
                                                                <option <?php if ($cuenta2 == $valor[1]) echo "selected" ?> value="<?php echo $valor[1] ?>"><?php echo $valor[0] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <th>Recursos A Movilizar</th>
                                                <td><input type="text"  name="ahorro1Ws" id="ahorro1Ws" value="<?php echo $ahorro2 ?>" readonly="true"></td> 
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr> 
                            <td>
                                <div id="divOculto2">
                                    <table>
                                        <tr>
                                            <td><input type="radio" name="radioBanco" id="radio_2" value="3" onclick="if (document.getElementById('divOculto') != null) {
                                                            document.getElementById('divOculto').remove();
                                                        }
                                                        if (document.getElementById('divOculto3') != null) {
                                                            document.getElementById('divOculto3').remove();
                                                        }" required="required"/> Otro</td>
                                            <th>Banco *</th>
                                            <td>
                                                <select id="seqBanco" name="seqBancoOtro" required="required">
                                                    <option value="">Seleccione</option>
                                                    <?php
                                                    $banc = Array();
                                                    foreach ($arrBanco as $key => $value) {
                                                        foreach ($value as $value2) {
                                                            $valor = explode('*', $value2);
                                                            ?>
                                                            <option value="<?php echo $valor[1] ?>"><?php echo $valor[0] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><p>&nbsp;</p></td>
                        </tr>
                        <tr>
                            <td><input  title="De click en registrar peticionario para guardar la información en el sistema. Recuerde verificar la información antes de guardar." class="ocultarSoloLectura" id="guardar" type="submit" value="Enviar Solicitud"></td>
                        </tr>
                    </table>        
                </fieldset>
            </form>
        </div>

        <!-- hasta aca llega -->
    <?php } else if (isset($msn3) && $msn3 != "" && $msn3 != NULL) { ?>
        <div class="content"><?php echo $msn3; ?></div>
    <?php } else { ?>
        <script>
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
                document.getElementById("dirIp").value = ip;
            });
        </script>
        <div class="content">
            <!-- target="framename"-->
            <form action=""  method="post" > 
                <fieldset>
                    <table>
                        <tr>
                            <th>Número de Identificación *</th>
                            <td><input id="numeroIdentificacion" name="numeroIdentificacion" title="Registre su número de identificación sin puntos, sin comas, ni espacios." class="required" type="text" value="" maxlength="11" required="required">
                                <input id="dirIp" name="dirIp" type="hidden" value="" />
                            </td>
                            <td><input  title="De click en registrar peticionario para guardar la información en el sistema. Recuerde verificar la información antes de guardar." class="ocultarSoloLectura" id="guardar" type="submit" value="Enviar Solicitud"></td>
                        </tr>
                    </table>        
                </fieldset>
            </form>
        </div>
    <?php } ?>
</html>