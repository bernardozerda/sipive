<?php
/**
 * VERIFICA SI LA SESSION ES VALIDA Y
 * ESTA VIGENTE, SINO DEBE SACARLO A AUTENTICACION
 * @author bernardo zerda
 * @version 1.0 Abril 2009
 */
session_start();
//var_dump($_SESSION);
if ($_SESSION['seqUsuario'] == 302 || $_SESSION['seqUsuario'] == 348 || $_SESSION['seqUsuario'] == 394 || $_SESSION['seqUsuario'] == 178 || $_SESSION['seqUsuario'] == 251) {
    $tiempoSesion = 7200;
} else {
    $tiempoSesion = 1800;
}

define("TIMEOUT", $tiempoSesion); // Tiempo de valides de la sesion en segundos ( 30 minutos )
// verifica si debe o no matar la sesion
$bolMatarSesion = true;
$_SESSION['sdhtsdv'] = "sdhtsdv";
$sdhtsdv = $_SESSION['sdhtsdv'];
//var_dump($sdhtsdv);
if (isset($sdhtsdv)) {
    if (isset($_COOKIE['sdhtsdv'])) {
        $bolMatarSesion = false;
    }
}

// si debe matar la sesion coloca la cookie vencida y destruye la sesion
if ($bolMatarSesion) {
    setcookie("sdhtsdv", 1, time() - TIMEOUT, "/", null, false, false);
    session_destroy();

    // redirecciona a la pantalla de autenticacion si la encuentra en esta posicion relativa
    // si no coloca un link que obiga al usuario a ir a la autenticacion del aplicativo
    if (file_exists("./autenticacion.php")) {
        header("Location: " . $txtPrefijo . "autenticacion.php");
    } else {
        echo "Sesion Vencida <a href='#' onClick='location.reload();'>Continuar</a>";
        exit(0);
    }
} else {

    // si todo esta en orden se renueva la vigencia de la cookie por los minutos que se hayan defonodo como timeout
    setcookie("sdhtsdv", 1, time() + TIMEOUT, "/", null, false, false); // Cookie Real
    setcookie("validar", time() + TIMEOUT, time() + TIMEOUT, "/", null, false, false); // Cookie para validar el tiempo de vida de la sesion
}
?>
