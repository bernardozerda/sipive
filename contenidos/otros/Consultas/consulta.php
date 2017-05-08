<?php

include_once "./mysqli/shared/ez_sql_core.php";
include_once "./mysqli/ez_sql_mysqli.php";

//$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');

function timequery() {
    static $querytime_begin;
    list($usec, $sec) = explode(' ', microtime());

    if (!isset($querytime_begin)) {
        $querytime_begin = ((float) $usec + (float) $sec);
    } else {
        $querytime = (((float) $usec + (float) $sec)) - $querytime_begin;
        echo sprintf('<br />La consulta tardó %01.5f segundos.- <br />', $querytime);
    }
}

function mostrarTablas() {
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');

    $my_tables = $db->get_results("SHOW TABLES", ARRAY_N);
    return $db->debug();
}

function consultarTabla($consulta) {

    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');

    if ($db->get_results($consulta)) {
        echo " - consulto";
    } else {
        echo " - noconsulto";
    }
}

function consultarTabla2($consulta) {

    $db2 = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sipive', 'localhost');

    if ($db2->get_results($consulta)) {
        echo " - consulto";
    } else {
        echo " - noconsulto";
    }
}

//mostrarTablas();
//consultarTabla($consulta1);
function estresarBase() {
    include './querys.php';
    $i = 1;
    while ($i <= 50) {
        echo ' <fieldset>
    <legend>Intento' . $i . ':</legend>';
	timequery();
        consultarTabla($consulta1);
        consultarTabla2($consulta2);
        consultarTabla($consulta3);
        consultarTabla2($consulta4);
        consultarTabla($consulta5);
        consultarTabla2($consulta6);
        consultarTabla($consulta7);
        consultarTabla2($consulta8);
        consultarTabla($consulta9);
        consultarTabla2($consulta10);
        consultarTabla($consulta11);
        consultarTabla2($consulta12);
        consultarTabla($consulta13);
        consultarTabla2($consulta14);
        consultarTabla($consulta16);
        consultarTabla2($consulta17);
        consultarTabla($consulta18);
        consultarTabla2($consulta19);
        consultarTabla($consulta20);
        consultarTabla2($consulta21);
        consultarTabla2($consulta22);
        consultarTabla($consulta23);
        consultarTabla2($consulta24);
        consultarTabla($consulta25);
        consultarTabla2($consulta26);
		timequery();

        $i++;
        echo '</fieldset>';
    }
}

estresarBase();
