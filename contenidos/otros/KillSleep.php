<?php

function matarConsultasSleep() {
    $mysql_host = "localhost";
    $mysql_user = "sdht_usuario";
    $mysql_pass = "Ochochar*1";

//Definimos el tiempo limite para una query en sleep in seconds
    $mysql_query_sleep_limit = 250;

//Definimos contra que comando monitorearemos
    $mysql_query_name = "Sleep";

//Definimos un array con el usuario/base a monitorear
    $mysql_query_user_db_monitoring = array(
        array('sdht_usuario', 'sipive')
    );

//Definimos las variables para el envio de e-mails

    $conn = mysql_connect($mysql_host, $mysql_user, $mysql_pass);

    If ($conn) {
        $result = mysql_query("show full processlist", $conn);
        while ($Record = mysql_fetch_array($result)) {
            $Ret[] = $Record;
        }


        while (list(, $val) = each($Ret)) {
            if ($val['Command'] == $mysql_query_name AND $val['Time'] >= $mysql_query_sleep_limit AND in_array(array($val['User'], $val['db']), $mysql_query_user_db_monitoring)) {
                //Eliminamos la query
                mysql_query("KILL $val[Id]", $conn);
                echo "consulta con ID:$val[Id]<br>";
            }
        }
    } else {
        echo "Unable to connect - Mysql Error: " . mysql_error() . "\n";
    }
}
?>