<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$fecha = date("Y-m-d");
$consulta = mysql_query("SELECT seqSeguimiento,seqFormulario,fchMovimiento,seqUsuario,txtComentario,txtCambios,numDocumento,txtNombre
FROM t_seg_seguimiento
WHERE seqUsuario = 21 
AND numDocumento IN 
(21047647,80741124,21133832	,52055672,35600588,51882552	,51679276	,70696303,79511841,2385691	,41763739	,52461576	,93083712,53051260,69087199	,43812236	,52497882,24873271,37945819	,29476969, 52498797,52738314	,1010206711	,80262966	, 80730142,6668009,52222361	,65812795	, 1018408929,1033678748	,52438268,39763570,92215022,1010167818	,38095096	,17346067	,80490615,52729567,24758170	,52547913	,25423678,1012318761	,20613642,51637342,52845512,83235228	,52284201	,41721343	,52868411,83042145,19486680	,16257371	,52420307,19470923	,1106773768,39576442,51894154,51694668	,4890402	,39690123	,20429772,53038321,20963160	,52350901	,79697493,53043414	,1014326517,52242379,41461213,35315073	,80161566	,1058408465	)");

$numrows = mysql_num_rows($consulta);

if ($numrows > 0) {
    $nombreinforme = "Seguimientos21_" . $fecha;
    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition:  filename=" . $nombreinforme . ".xls;");
    header("Pragma: no-cache");
    header("Expires: 0");
    $resultados = $db->get_results($consulta);
    ?>
    <table>    
        <tr>
            <th>seqSeguimiento</th>     
            <th>seqFormulario</th>    
            <th>fchMovimiento</th>    
            <th>seqUsuario</th>    
            <th>txtComentario</th>    
            <th>txtCambios</th>    
            <th>numDocumento</th>    
            <th>txtNombre</th>    
        </tr>    
        <?php
        while ($resultado = mysql_fetch_array ($consulta)){

        echo '<tr>
		<td>' . $Tip_ID . '</td>
		<td>' . $resultado['seqSeguimiento'] . '</td>
		<td>' . $resultado['seqFormulario'] . '</td>
		<td>' . $resultado['fchMovimiento'] . '</td>
		<td>' . $resultado['seqUsuario'] . '</td>
		<td>' . $resultado['txtComentario'] . '</td>
		<td>' . $resultado['txtCambios'] . '</td>
		<td>' . $resultado['numDocumento'] . '</td>
		<td>' . $resultado['txtNombre'] . '</td>
		</tr>';
        }
    } else {
        echo "No existen registros";
    }
    ?>
</table>

