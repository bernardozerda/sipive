<?php
$txtNombreArchivo = "cargueEscrituracion_" . date("Ymd_His") . ".xls";
header("Content-disposition: attachment; filename=$txtNombreArchivo");
header("Content-Type: application/force-download");
header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 1");
?>
<table>
    <tr>
        <th>Documento</th>
        <th>Desembolso</th>
        <th>Formulario</th>
        <th>Link</th>
    </tr>
    <?php
    
    $int = 1;
    foreach ($_POST['array']['seqFormulario'] as $key => $value) {
        if ($_POST['array']['seqDesembolso'][$int] != "") {
            ?>

            <tr>
                <td><?php echo $_POST['array']['numDocumento'][$int] ?></td>
                <td><?php echo  $_POST['array']['seqDesembolso'][$int] ?></td>
                <td><?php echo  $_POST['array']['seqFormulario'][$int] ?></td>
                <td><a href="https://<?= $_SERVER['HTTP_HOST'] ?>/sipive/contenidos/desembolso/formatoBusquedaOferta.php?seqCasaMano=0&bolEscrituracion=1&seqFormulario=<?php echo $_POST['array']['seqFormulario'][$int] ?>">https://<?php echo $_SERVER['HTTP_HOST'] ?>/sipive/contenidos/desembolso/formatoBusquedaOferta.php?seqCasaMano=0&bolEscrituracion=1&seqFormulario=<?php echo  $_POST['array']['seqFormulario'][$int] ?></a></td>
            </tr>

            <?php
        }
        $int++;
    }
    ?>?>
</table>
