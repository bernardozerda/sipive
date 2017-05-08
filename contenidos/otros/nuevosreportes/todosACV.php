<?php
include_once "librerias/ezSQL/shared/ez_sql_core.php";
include_once "librerias/ezSQL/pdo/ez_sql_pdo.php";
require 'librerias/DbConnection/configDB.php';
$db = new ezSQL_pdo(dsn, db_user, db_password);

$fecha = date("Y-m-d");
$consulta = ("SELECT t_ciu_ciudadano.seqCiudadano AS IdPersona,
       UPPER(t_ciu_ciudadano.txtNombre1) AS Nombre_1,
       UPPER(t_ciu_ciudadano.txtNombre2) AS Nombre_2,
       UPPER(t_ciu_ciudadano.txtApellido1) AS Apellido_1,
       UPPER(t_ciu_ciudadano.txtApellido2) AS Apellido_2,
       t_ciu_ciudadano.fchNacimiento AS Fec_nac,
       t_ciu_ciudadano.seqTipoDocumento AS Tip_ID,
       t_ciu_ciudadano.numDocumento AS Num_ID,
       t_ciu_ciudadano.seqTipoVictima AS TipoVictima,
       t_frm_hogar.seqFormulario AS IdFamilia
  FROM sipive.t_frm_hogar t_frm_hogar
       LEFT JOIN sipive.t_ciu_ciudadano t_ciu_ciudadano
          ON (t_frm_hogar.seqCiudadano = t_ciu_ciudadano.seqCiudadano) where t_ciu_ciudadano.seqCiudadano in (140532,100,10256,25879,14789)");

$numrows = $db->get_var($consulta);

if ($numrows > 0) {
    $nombreinforme = "informe_ACV_" . $fecha;
    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition:  filename=" . $nombreinforme . ".xls;");
    header("Pragma: no-cache");
    header("Expires: 0");
    $resultados = $db->get_results($consulta);
    ?>
    <table>    
        <tr>
            <th>Tip_ID</th>     
            <th>Num_ID</th>    
            <th>Nombre_1</th>    
            <th>Nombre_2</th>    
            <th>Apellido_1</th>    
            <th>Apellido_2</th>    
            <th>Fec_nac</th>    
            <th>IdPersona</th>    
            <th>IdFamilia</th>
            <th>TipoVictima</th>
        </tr>    
        <?php
        foreach ($resultados as $resultado) {
            $Tip_ID = $resultado->Tip_ID;
            $TipoVictima = $resultado->TipoVictima;

            //Conversion del sequencial tipo documento al formato de la ACV

            switch ($Tip_ID) {
                case 1:
                    $Tip_ID = "CC";
                    break;

                case 2:
                    $Tip_ID = "CE";
                    break;
                case 3:
                    $Tip_ID = "TI";
                    break;
                case 4:
                    $Tip_ID = "RC";
                    break;
                case 5:
                    $Tip_ID = "PA";
                    break;
                case 6:
                    $Tip_ID = "CC";
                    break;
            }

            /* Conversion del sequencial tipo de victima al texto correspondiente
             * se hace la conversion en php para disminuir la carga del servidor mysql
             */


            switch ($TipoVictima) {
                case 0:
                    $TipoVictima = "Ninguno";
                    break;
                case 1:
                    $TipoVictima = "Desaparición Forzada";
                    break;
                case 2:
                    $TipoVictima = "Desplazamiento Forzado";
                    break;
                case 3:
                    $TipoVictima = "Homicidio";
                    break;
                case 4:
                    $TipoVictima = "Libertad e Integridad Sexual";
                    break;
                case 5:
                    $TipoVictima = "Lesiones Personales con Incapacidad";
                    break;
                case 6:
                    $TipoVictima = "Lesiones Personales sin Incapacidad";
                    break;
                case 7:
                    $TipoVictima = "Reclutamiento Ilegal";
                    break;
                case 8:
                    $TipoVictima = "Secuestro";
                    break;
            }



            echo '<tr>
		<td>' . $Tip_ID . '</td>
		<td>' . $resultado->Num_ID . '</td>
		<td>' . $resultado->Nombre_1 . '</td>
		<td>' . $resultado->Nombre_2 . '</td>
		<td>' . $resultado->Apellido_1 . '</td>
		<td>' . $resultado->Apellido_2 . '</td>
		<td>' . $resultado->Fec_nac . '</td>
		<td>' . $resultado->IdPersona . '</td>
		<td>' . $resultado->IdFamilia . '</td>
                <td>' . $TipoVictima . '</td>
		</tr>';
        }
    } else {
        echo "No existen registros";
    }
    ?>
</table>

