<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function reporteGeneralsubsidios($array) {

    $txtNombreArchivo = "IndicadoresSubsidiosSSGF" . date("Ymd_His") . ".xls";
    header("Content-disposition: attachment; filename=$txtNombreArchivo");
    header("Content-Type: application/force-download");
    header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
    header("Content-Transfer-Encoding: binary");
    header("Pragma: no-cache");
    header("Expires: 1");

    $datos = "<table border='1'>";
    $datos .= "<tr>";
    $datos .= "<th colspan='4' style='background: #CFCFCF;'>Subsidio Familiar de Vivienda en Especie</th>";
    $datos .= "</tr>";
    $datos .= "<tr>";
    $datos .= "<td colspan='2' >&nbsp;</td> "
            . "<th>Numero</th>"
            . "<th>Valor</th>";
    $datos .= "</tr>";
    $datos .= "<td rowspan='3'>Total</td> "
            . "<th>Inscritos</th>"
            . "<td>" . $array['inscritosAdq'] . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . $array['asignadosAdq']. "</td>"
            . "<th>" . $array['valAsignadosAdq'] . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>". $array['legalizadosAdq'] . "</td>"
            . "<th>". $array['legalizadosAdqVal'] . "</th>";
    $datos .= "</tr>";
    /*     * *******************************************VICTIMAS ADQUISICION ********************************* */
    $datos .= "<tr>";
    $datos .= "<td rowspan='3'>Victimas</td> "
            . "<th>Inscritos</th>"
            . "<td>" . $array['victimasAdq'] . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . $array['asignadosAdqVic'] . "</td>"
            . "<th>" . $array['valAsignadosAdqVic'] . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . $array['legalizadosAdqVic'] . "</td>"
            . "<th>" . $array['legalizadosAdqValVic'] . "</th>";
    $datos .= "</tr>";

    $datos .= "<tr>";
    $datos .= "<th colspan='4' style='background: #CFCFCF;'>PIVE</th>";
    $datos .= "</tr>";
    $datos .= "<tr>";
    $datos .= "<td colspan='2' >&nbsp;</td> "
            . "<th>Numero</th>"
            . "<th>Valor</th>";
    $datos .= "</tr>";
    $datos .= "<td rowspan='3'>Total</td> "
            . "<th>Inscritos</th>"
            . "<td>" . $array['inscritosPive'] . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . $array['asignadosPive'] . "</td>"
            . "<th>" . $array['valAsignadosPive'] . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" .$array['legalizadosPive'] . "</td>"
            . "<th>" . $array['legalizadosPiveVal'] . "</th>";
    $datos .= "</tr>";

    /*     * *******************************************VICTIMAS PIVE ********************************* */
    $datos .= "<tr>";
    $datos .= "<td rowspan='3'>Victimas</td> "
            . "<th>Inscritos</th>"
            . "<td>" . $array['victimasPive'] . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . $array['asignadosPiveVic'] . "</td>"
            . "<th>" . $array['valAsignadosPiveVic'] . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . $array['legalizadosPiveVic'] . "</td>"
            . "<th>" . $array['legalizadosPiveValVic'] . "</th>";
    $datos .= "</tr>";

    /*     * ************************** MI CASA YA! ************************************************ */

    $datos .= "<tr>";
    $datos .= "<th colspan='4' style='background: #CFCFCF;'>MI CASA YA!</th>";
    $datos .= "</tr>";
    $datos .= "<tr>";
    $datos .= "<td colspan='2' >&nbsp;</td> "
            . "<th>Numero</th>"
            . "<th>Valor</th>";
    $datos .= "</tr>";
    $datos .= "<td rowspan='3'>Total</td> "
            . "<th>Inscritos</th>"
            . "<td>N/A</td>"
            . "<th>N/A</th>";
    $datos .= "</tr>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . $array['asignadosMiCasaYa'] . "</td>"
            . "<th>" . $array['valAsignadosMiCasaYa'] . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td></td>"
            . "<th></th>";
    $datos .= "</tr>";

    $datos .= "</table>";

    echo $datos;
}
