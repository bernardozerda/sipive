<head>
    <meta charset="UTF-8">
    <title>Cartas de Movilización</title>

</head>

<?php
require_once('../lib/nusoap.php');
include '../lib/tcpdf/tcpdf.php';

$resultado;

if (isset($_POST['codeVerificador'])) {

    include 'variable.php';

    $datos_persona_entrada = array("datos_persona_entrada" => array(
            'code' => $_POST['codeVerificador']
        )
    );
    $resultado = $cliente->call('obtenerDatosCode', $datos_persona_entrada);
}
?>
<div class="content">
    <h5>Datos Generados para la Carta con codigo <?= strtoupper($_POST['codeVerificador']) ?></h5>
    <p>&nbsp;</p>
    <div class="form-row" >

        <?php
        if ($resultado['datos'] != null) {
            setlocale(LC_TIME, 'spanish');

            foreach ($resultado['datos'] as $key => $value) {
                ?>
                <div class="col-md-5 mb-3"><b>Documento</b></div>
                <div class="col-md-7 mb-3"><?= $value['numDocumento'] ?></div>
                <div class="col-md-5 mb-3"><b>Nombre</b></div>
                <div class="col-md-7 mb-3"><?= $value['txtNombreCiu'] ?></div>
                <div class="col-md-5 mb-3"><b>Generado al banco</b></div>
                <div class="col-md-7 mb-3"><?= $value['txtBanco'] ?></div>
                <div class="col-md-5 mb-3"><b>Expedido en:</b></div>
                <div class="col-md-7 mb-3"><?= strftime("%d de %B de %Y", strtotime($value['fchCarta'])) ?></div>
                <div class="col-md-5 mb-3"><b>Confirmación del codigo:</b></div>
                <div class="col-md-7 mb-3"><?= $value['txtCodigo'] ?></div>      
            <?php } ?>
        <?php } else { ?>
            <div class="col-md-12 mb-3">No se registran datos para el codigo suministrado Por favor verificar directamente con la entidad </div>
        <?php } ?>
    </div>
</div>



