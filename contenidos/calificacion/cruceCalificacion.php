<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );

include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "calificacion.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

$claCalificacion = new calificacion();
$claEncuestas = new Encuestas();
$documento = "53011856, 40050787,
        31585726,
        1070730111,
        6667609,
        41447360,
        36295344,
        1026565837,
        26477999,
        69802473,
        52437407,
        57428319,
        93470944,
        10563020192";

$formularios = $claCalificacion->obtenerFormulario($documento);
?>
<table border="1">
    <tr>
        <th>Hogar</th>
        <th>Miembros Encuesta</th>
        <th>Miembros Sipive</th>
        <th>Cant Miembros<br>(Encuesta VS Sipive)</th>
        <th>Ingresos<br>(Encuesta VS Sipive)</th>
    </tr>

    <?php
    foreach ($formularios as $keyF => $valueF) {
        $arrayDatosEncuentas = Array();

        $arrayDatosEncuentas = $claEncuestas->obtenerVariablesCalificacion($valueF['numDocumento']);
        $datosCal = $claCalificacion->obtenerDatosCalificacion(true, $valueF['seqFormulario'], false);
        $cantMiembros = '';
        print_r($arrayDatosEncuentas);
        $cantMiembros = $arrayDatosEncuentas['variables']['cant'] . ' VS ';
        $ingresos =  '$'.number_format($arrayDatosEncuentas['variables']['ingresos'], 0, '.', ',') . ' VS ';
        $style = 'color: #000; text-align: center; font-weight:bold;';
        ?> 
        <tr>
            <td><?= $valueF['seqFormulario'] ?></td>
            <td>
                <?php foreach ($arrayDatosEncuentas['variables']['edades'] as $keyMiembros => $valueMiembros) { ?>
                    <?= $keyMiembros ?> - <?= utf8_encode($arrayDatosEncuentas['variables']['nombres'][$keyMiembros]) ?>- <?= $arrayDatosEncuentas['variables']['edades'][$keyMiembros] ?><br>

                <?php } ?>
            </td>
            <td>
                <?php
                foreach ($datosCal as $keyCal => $valueCal) {
                    $hog = str_replace(",", "<br>", $valueCal['edades']);
                    if ($arrayDatosEncuentas['variables']['cant'] != $valueCal['cant']) {
                        $style = 'color: red; text-align: center; font-weight:bold; ';
                    }
                    $cantMiembros .= $valueCal['cant'];
                    $ingresos .= '$'.number_format($valueCal['ingresos'], 0, '.', ',');
                    ?>
                    <?= $hog; ?> <br>

    <?php } ?>
            </td>
            <td style="<?= $style ?>"><?= $cantMiembros ?></td>
            <td><?= $ingresos ?></td>
        </tr>
<?php } ?>

</table>