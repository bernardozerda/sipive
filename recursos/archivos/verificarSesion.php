<?php
/**
 * VERIFICA SI LA SESSION ES VALIDA Y
 * ESTA VIGENTE, SINO DEBE SACARLO A AUTENTICACION
 * @author bernardo zerda
 * @version 1.0 Abril 2009
 */
session_start();

// solo funciona bajo https
define("HTTPS_ONLY", true);

// Tiempo de valides de la sesion en segundos
define("TIMEOUT", 1800);

// verifica si debe o no matar la sesion
$bolMatarSesion = true;
if (isset($_SESSION["sdhtsdv"]) and isset($_COOKIE['sdhtsdv'])) {
    $bolMatarSesion = false;
}

// si debe matar la sesion coloca la cookie vencida y destruye la sesion
if ($bolMatarSesion) {

    setcookie(
        "sdhtsdv",
        time() - TIMEOUT,
        time() - TIMEOUT,
        "/",
        null,
        HTTPS_ONLY,
        false
    );
    session_destroy();

    // redirecciona a la pantalla de autenticacion
    $txtRuta  = (HTTPS_ONLY == true)? "https://" : "http://";
    $txtRuta .=  $_SERVER['SERVER_NAME'] . "/" . mb_split("/",$_SERVER['REQUEST_URI'])[1] . "/autenticacion.php";

    header("Location: " . $txtRuta);

} else {

    // si esta las cosas bien se renueva la vigencia de la cookie por los minutos que se hayan definido como timeout
    setcookie(
        "sdhtsdv",
        time() + TIMEOUT,
        time() + TIMEOUT,
        "/",
        null,
        HTTPS_ONLY,
        false
    );
}

?>
