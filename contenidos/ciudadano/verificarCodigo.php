<?php

$txtPrefijoRuta = "../../";
session_start();
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
//print_r($_SESSION["arrGrupos"]);
$claCiudadano = new Ciudadano();

$codigo = $_REQUEST['code'];

$code = $claCiudadano->obtenerCodigo($codigo);

$div = '<p><b>Los datos que se generaron para el código <b>' . $codigo . '</b> son:</b></p><table cellpadding="1" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" height="20%">';
if ($code) {
    $usuario = $code[0]['seqUsuario'];
    $user = $claCiudadano->obtenerUsuarioCarta($usuario);

    foreach ($code as $key => $value) {
        $div .='<tr><th>Documento:</th><td>' . $value['numDocumento'] . '</td>';
        $div .='<th>Nombre:</th><td>' . $value['txtNombreCiu'] . '</td></tr>';
        $div .='<tr><th>Entidad:</th><td>' . $value['txtBanco'] . '</td>';
        $div .='<th>Fecha Solicitud:</th><td>' . $value['fchCarta'] . '</td></tr>';
        $div .='<tr><th>Tipo Carta:</th><td>' . $value['txtTipoCarta'] . '</td>';
        $div .='<th>Generado por:</th><td>' . $user['nombre'] . '</td></tr>';
    }
}
echo $div .='</div>';
