<head>
    <meta charset="UTF-8">
    <title>Cartas de Movilización</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!--  <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style type="text/css">@import "../css/habitat.css"</style>
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
    <script src="../js/funciones.js" ></script>
</head>

<?php
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
$numIngresos = 0;

if (isset($_POST['numeroIdentificacion'])) {

    $identificacion = $_POST['numeroIdentificacion'];
    // $cliente = new nusoap_client('http://localhost/sipive/contenidos/ciudadano/ws_cartasMovilizacion.php');
    include 'variable.php';
    $seqBanco = 0;
    if (isset($_POST['seqBanco']) && $_POST['seqBanco'] != "") {
        $seqBanco = $_POST['seqBanco'];
    } else if (isset($_POST['seqBanco2']) && $_POST['seqBanco2'] != "") {
        $seqBanco = $_POST['seqBanco2'];
    } else {
        $seqBanco = $_POST['seqBancoOtro'];
    }
    $cuenta = $_POST['radioBanco'];
    $dirIp = $_POST['dirIp'];

    $datos_persona_entrada = array("datos_persona_entrada" => array(
            'documento' => $_POST['numeroIdentificacion'],
            'nombre' => $_POST['nombre'],
            'banco' => $seqBanco,
            'cuenta' => $cuenta,
            'dirIp' => $dirIp
        )
    );
    $resultado = $cliente->call('obtenerDatosCarta', $datos_persona_entrada);
    // echo json_encode($resultado);

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
    $numIngresos = $resultado['numIngresos'];
    // documento=" + documento + "&cuenta=" + radio + "&tipo=" + tipo + "&banco=" + entidad + "&nombre=" + nombre     
    $data = mb_split("\"", $resultado['mensaje']);
}
?>

<?php if ($numIngresos > 3) {
    ?>
    <div class="content"><?php echo 'Lo sentimos excedio la capacidad de intentos de exportación de cartas'; ?></div>

<?php } else if (isset($msn1) && $msn1 != "" && $msn1 != NULL) { ?>
    <div class="content" id="content">
        <form name="formulario" id="formulario" class="needs-validation" action="clienteWS.php" method="post" >
            <fieldset>
                <legend><h2><?php echo $msn1; ?></h2></legend>
                <h3><?php echo $msn2; ?></h3>
                <div class="form-row"> 
                    <div class="col-md-4 mb-3">
                        <label for="numeroIdentificacion">Nombre Completo *</label>
                        <input id="nombre" name="nombre" title="Digite su nombre Completo." class="form-control" type="text" value="<?php if ($nombreWs != "") echo ucwords(strtolower($nombreWs)) ?>"  size="60" required>
                        <input id="numeroIdentificacion" name="numeroIdentificacion"   type="hidden" value="<?php echo $_POST['numeroIdentificacion'] ?>" maxlength="11">
                        <input id="dirIp" name="dirIp" type="hidden" value="<?php echo $dirIp ?>" />
                        <div class="invalid-tooltip" id="val_nombre">
                            Por Favor Digitar su nombre Completo.
                        </div>
                    </div>
                    <?php if ($ahorro1 > 0) { ?>
                        <div class="col-md-4 mb-3" id="divOculto">
                            <label for="radio">
                                <input type="radio" id="radio" name="radioBanco"  value="1" onclick="if (document.getElementById('divOculto3') != null) {
                                            document.getElementById('divOculto3').remove();
                                            document.getElementById('divOculto3Mov').remove();
                                        }

                                        if (document.getElementById('divOculto2') != null) {
                                            document.getElementById('divOculto2').remove();
                                        }" required="required" /> Banco Cuenta Ahorro  *<br>
                                <b class="invalid-tooltip" id="val_radio" style="position: relative">
                                    Por Favor seleccione una opción.
                                </b>
                            </label>
                            <select id="seqBanco" name="seqBanco" class="form-control" required="required">
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
                            <div class="invalid-tooltip" id="val_seqBanco">
                                Por Favor seleccione una opción.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" id="divOcultoMov">
                            <label for="ahorro1Ws">Recursos A Movilizar</label>
                            <input type="text"  name="ahorro1Ws" id="ahorro1Ws" class="form-control" value="<?php echo $ahorro2 ?>" readonly="true">
                        </div>
                    <?php } ?>
                    <?php if ($ahorro2 > 0) { ?>
                        <div class="col-md-4 mb-3" id="divOculto3">
                            <label>
                                <input type="radio" id="radio_1" name="radioBanco" value="2" onclick="if (document.getElementById('divOculto2') != null) {
                                            document.getElementById('divOculto2').remove();
                                        }
                                        if (document.getElementById('divOculto') != null) {
                                            document.getElementById('divOculto').remove();
                                            document.getElementById('divOcultoMov').remove();
                                        }" required="required"/> Banco Cuenta Ahorro2 *<br>
                                <b class="invalid-tooltip"  id="val_radio_1" style="position: relative">
                                    Por Favor seleccione una opción.
                                </b>
                            </label>
                            <select id="seqBanco" name="seqBanco2" class="form-control required" required="required">
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
                            <div class="invalid-tooltip" id="val_seqBanco" >
                                Por Favor seleccione una opción.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" id="divOculto3Mov">
                            <label for="ahorro1Ws">Recursos A Movilizar</label>
                            <input type="text"  name="ahorro1Ws" id="ahorro1Ws" value="<?php echo $ahorro2 ?>" readonly="true" class="form-control">
                        </div>
                    <?php } ?>
                    <div class="col-md-4 mb-3" id="divOculto2">
                        <label>
                            <input type="radio" name="radioBanco" id="radio_2" value="3" onclick="if (document.getElementById('divOculto') != null) {
                                        document.getElementById('divOculto').remove();
                                        document.getElementById('divOcultoMov').remove();
                                    }
                                    if (document.getElementById('divOculto3') != null) {
                                        document.getElementById('divOculto3').remove();
                                        document.getElementById('divOculto3Mov').remove();
                                    }" required="required"/> Otro<br>
                            <b class="invalid-tooltip"  id="val_radio_2" style="position: relative">
                                Por Favor seleccione una opción.
                            </b>
                        </label>
                        <select id="seqBanco" name="seqBancoOtro" class="form-control required" required="required">
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
                        <div class="invalid-tooltip" id="val_seqBanco">
                            Por Favor seleccione una opción.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>&nbsp;</label><br>
                        <!--<input  class="btn btn-primary" id="guardar" type="button" value="Enviar Solicitud" onclick="if (validar())
                                        ObtenerCarta()">-->

                        <input class="btn btn-primary" class="ocultarSoloLectura" id="guardar" type="submit" value="Enviar Solicitud" onclick="validar()">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
<?php } else if (isset($msn3) && $msn3 != "" && $msn3 != NULL && !isset($data[4])) { ?>
    <div class="content"><?php echo $msn3; ?></div>
<?php } ?>

