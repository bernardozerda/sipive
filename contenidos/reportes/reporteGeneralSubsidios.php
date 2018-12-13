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
            . "<td>" . number_format($array['inscritosAdq'], 0, '.', ',') . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . number_format($array['asignadosAdq'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['valAsignadosAdq'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . number_format($array['legalizadosAdq'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['legalizadosAdqVal'], 0, '.', ',') . "</th>";
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
            . "<th>" . number_format($array['valAsignadosAdqVic'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . $array['legalizadosAdqVic'] . "</td>"
            . "<th>" . number_format($array['legalizadosAdqValVic'], 0, '.', ',') . "</th>";
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
            . "<td>" . number_format($array['inscritosPive'], 0, '.', ',') . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . number_format($array['asignadosPive'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['valAsignadosPive'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . number_format($array['legalizadosPive'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['legalizadosPiveVal'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";

    /*     * *******************************************VICTIMAS PIVE ********************************* */
    $datos .= "<tr>";
    $datos .= "<td rowspan='3'>Victimas</td> "
            . "<th>Inscritos</th>"
            . "<td>" . number_format($array['victimasPive'], 0, '.', ',') . "</td>"
            . "<th>&nbsp;</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Asignados</th>"
            . "<td>" . number_format($array['asignadosPiveVic'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['valAsignadosPiveVic'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td>" . $array['legalizadosPiveVic'] . "</td>"
            . "<th>" . number_format($array['legalizadosPiveValVic'], 0, '.', ',') . "</th>";
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
            . "<td>" . number_format($array['asignadosMiCasaYa'], 0, '.', ',') . "</td>"
            . "<th>" . number_format($array['valAsignadosMiCasaYa'], 0, '.', ',') . "</th>";
    $datos .= "</tr>";
    $datos .= "<tr>"
            . " <th>Legalizados</th>"
            . "<td></td>"
            . "<th></th>";
    $datos .= "</tr>";

    $datos .= "</table>";

    echo $datos;
}
