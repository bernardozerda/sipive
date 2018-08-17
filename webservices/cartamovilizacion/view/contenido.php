<?php

$contenido = "";
$contenido .= "<p>&nbsp;</p><p>Bogota D.C. " . strftime("%d de %B de %Y") . "</p>";
$contenido .= utf8_decode($txtSaludo);
$contenido .= utf8_decode(strtoupper($txtNombre));
$txtParrafo = "<p stroke='0.2' fill='true'  style='text-align:justify;'>
La Secretaria Distrital del Hábitat informa que " . $txtEncabezado . " " . strtoupper($txtNombre1) . " con C.C. " . $_GET['documento'] . ",
    NO se encuentra inscrito (a) en el Sistema
de Información del Programa Integral de Vivienda Efectiva - SIPIVE de la Secretaría Distrital del
Hábitat, por lo tanto no es beneficiario de recursos correspondientes al Aporte Distrital que otorga esta Entidad,
en el marco del Decreto 623 de 2016, <i>\"Por el cual se establece el Programa Integral de Vivienda Efectiva y se
dictan medidas para la generación de vivienda nueva y el mejoramiento de las condiciones de habitabilidad y
estructurales de las viviendas y se dictan otras disposiciones\"</i>.</p>";
$txtParrafo .= "<p>En consideración a lo anterior, esta Secretaría autoriza a  " . $txtEncabezado . " " . strtoupper($txtNombre1) . " con C.C. " . $_GET['documento'] . ", a efectuar la movilización de los recursos "
        . "que se encuentran depositados en la Cuenta de Ahorro Programado.</p>";
$contenido .= utf8_decode($txtParrafo);