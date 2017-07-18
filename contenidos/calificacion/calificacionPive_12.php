<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $txtPrefijoRuta = "../../";
        //include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
        include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        //include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=INFORME_CONTENCIÓN.xls");

        $BLE = 0.126068530021477;
        $RSA = 0.056714663235212;
        $COH = 0.0257404623225348;
        $HACN = 0.0140357946404073;
        $IPC = 0.104725855763458;
        $TDE = 0.119735280461787;
        $HN12 = 0.103783693112852;
        $MCF = 0.0580534449590349;
        $HAMY = 0.176583828666114;
        $CDISC = 0.115289225123407;
        $HPGE = 0.00741477557908034;
        $HN18 = 0.0535747453719212;
        $HCF = 0.00559338877519907;
        $PLGTBI = 0.00306882008097353;
        $PPGD = 0.0296174918865405;

        $sql = "SELECT frm.seqFormulario, numDocumento,  count(seqCiudadano) as cant, concat(txtNombre1, ' ',  txtNombre2, ' ', txtApellido1, ' ', txtApellido2 ) as nombre,
                group_concat(concat('<tr><td>',ucwords(txtNombre1), ' ',  txtNombre2, ' ', txtApellido1, ' ', txtApellido2, '</td> <td>', YEAR(CURDATE())-YEAR(fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(fchNacimiento,'%m-%d'), 0, -1) ),'</td></tr>')  AS edades, 
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) >=15 and hog1.seqFormulario = hog.seqFormulario ) AS cantMayor,
                (SELECT count(*)
                FROM t_ciu_ciudadano    ciu1
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE       YEAR(CURDATE())
                  - YEAR(ciu1.fchNacimiento)
                  + IF(
                       DATE_FORMAT(CURDATE(), '%m-%d') >
                          DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                       0,
                       -1) >= 15 and 
                        YEAR(CURDATE())
                  - YEAR(ciu1.fchNacimiento)
                  + IF(
                       DATE_FORMAT(CURDATE(), '%m-%d') >
                          DATE_FORMAT(ciu1.fchNacimiento, '%m-%d'),
                       0,
                       -1) < 60
              AND hog1.seqFormulario = hog.seqFormulario)
          AS adultos,
          (SELECT sum(numAnosAprobados)
        FROM t_ciu_ciudadano    ciu1
             LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
        WHERE      hog1.seqParentesco =1 
              AND hog1.seqFormulario = hog.seqFormulario)
          AS aprobadosJefe,
                (SELECT sum(numAnosAprobados) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) >15 and hog1.seqFormulario = hog.seqFormulario ) AS aprobados,
                (select count(*) FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where hog1.seqFormulario = hog.seqFormulario and seqSalud in(1, 2) ) as afiliacion, 
                numHabitaciones as cohabitacion, numHacinamiento as dormitorios, sum(valIngresos) as ingresos,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) <= 12 and hog1.seqFormulario = hog.seqFormulario ) AS cantMenores,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where seqParentesco = 3 and hog1.seqFormulario = hog.seqFormulario ) AS cantHijos,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                 WHERE     seqSexo = 2
              AND hog1.seqFormulario = hog.seqFormulario)
              AND ( seqCondicionEspecial IN (1)
                   OR seqCondicionEspecial2 IN (1)
                   OR seqCondicionEspecial3 IN (1)) AS mujerCabHogar,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where seqParentesco = 2 and hog1.seqFormulario = hog.seqFormulario ) AS conyugueHogar,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) > 59 and hog1.seqFormulario = hog.seqFormulario ) AS cantadultoMayor,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where  hog1.seqFormulario = hog.seqFormulario and (seqCondicionEspecial in( 3 ) or seqCondicionEspecial2 in( 3 )  or seqCondicionEspecial3 in(3 ))) AS cantCondEspecial,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where seqEtnia > 1 and hog1.seqFormulario = hog.seqFormulario ) AS condicionEtnica,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) > 12 and  YEAR(CURDATE())-YEAR(ciu1.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(ciu1.fchNacimiento,'%m-%d'), 0, -1) < 19 and hog1.seqFormulario = hog.seqFormulario ) AS adolecentes,
                 (SELECT count(*)
        FROM t_ciu_ciudadano    ciu1
             LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
        WHERE  seqSexo = 1
        AND (   seqCondicionEspecial IN (1)
                   OR seqCondicionEspecial2 IN (1)
                   OR seqCondicionEspecial3 IN (1))
              AND hog1.seqFormulario = hog.seqFormulario)
          AS hombreCabHogar,
                (SELECT count(*) 
                FROM t_ciu_ciudadano ciu1 left join t_frm_hogar hog1 using(seqCiudadano)
                where seqGrupoLgtbi > 0 and hog1.seqFormulario = hog.seqFormulario ) AS grupoLgtbi,
                bolIntegracionSocial, bolSecEducacion, bolSecMujer, bolSecSalud, bolAltaCon, bolIpes
                FROM t_frm_formulario frm 
                left join t_frm_hogar hog using(seqFormulario)
                left join t_ciu_ciudadano ciu using(seqCiudadano)
                #where seqPlanGobierno = 3
                where frm.seqFormulario in (4708	,
12189	,
21128	,
37426	,
79925	,
139478	,
177853	,
177936	,
198056	,
205057	,
215494	,
216171	,
216482	,
219422	,
222573	,
225974	,
238569	,
240440	,
240790	,
242243	,
244747	,
245319	,
245499	,
250415	,
251003	,
253368	,
253380	,
253428	,
254772	,
257215	,
259598	,
265048	,
267936	,
269402	,
273274	,
276497	,
278325	,
279172	,
280232	,
280343	,
280627	,
283678	,
286337	,
298000	,
298270	,
305524	,
308994	,
311265	,
326179	,
329563	,
334199	,
336506	,
336530	,
336534	,
336536	,
336542	,
336544	,
336547	,
336551	,
336566	,
336567	,
336569	,
336571	,
336572	,
336573	,
336574	,
336577	,
336588	,
336589	,
336591	,
336592	,
216176	
) 
 group by frm.seqFormulario  order by  frm.seqFormulario";

        //echo $sql . "<br>";
        $objRes1 = $aptBd->execute($sql);
        //var_dump($objRes1);
        $int = 0;
        ?>
        <table border="1">
            <tr>
                <th colspan="6">Datos Básicos</th>
                <th colspan="3">Datos Educación</th>
                <th colspan="4">Habitabilidad</th>
                <th>Ingresos</th> 
                <th colspan="2">Dependencia economica</th>
                <th colspan="2">Nivel I</th>
                <th colspan="3">Nivel II</th>
                <th colspan="4">Nivel III</th>
                <th >Total</th>
            </tr>
            <tr>
                <th>Documento</th>
                <th>Formulario</th>
                <th>Postulante Principal</th>
                <th>Información del hogar</th>
                <th>Cant Integrantes</th>
                <th>Ingresos <br>Hogar</th>               
                <th> <b>> </b>15 Años</th>
                <th>Suma Educación</th>
                <th <?= $style ?>>Educación</th>
                <th>Integrantes <br/> Con Regimen <br/> Subsidiado</th>
                <th >Total<br/>Regimen<br/>Subsidiado</th>
                <th>Cohabitación</th>
                <th>Hacinamiento</th>
                <th>Ingresos</th> 
                <th>Personas entre <br> 15-59 años</th>
                <th>Total</th>
                <th>Hogar con <br>menores</th>
                <th>Mujer cabeza<br>de hogar </th>
                <th>Adulto Mayor</th>
                <th>Discapacidad</th>
                <th>Etnia</th>
                <th>Cant Adolecentes</th>
                <th>Hombre cabeza<br>de hogar </th>
                <th>Población <br>LGTBI</th>
                <th>Programas<br>Gobierno<br>Distrital</th>
                <th>Total</th>
            </tr>
            <?php
            $cont = 1;
            while ($objRes1->fields) {
                if ($objRes1->fields['cant'] != 0) {
                    $educacion = number_format($objRes1->fields['aprobados'] / $objRes1->fields['cantMayor']);
                    if ($educacion < 9 || $objRes1->fields['cantMayor'] == 0) {
                        $educacion = 1;
                    } else {
                        $educacion = 0;
                    }
                    $style = " style='color: red; font-weight: bold; text-align: center;' ";
                    /*                     * ************************************Calculo Regimen Subsidiado*********************************************** */
                    $saludSubsidiados = 0;

                    $saludSubsidiados = ($objRes1->fields['afiliacion'] / $objRes1->fields['cant']);

                    /*                     * ******************************************* Cohabitacion **************************************************** */
                    $cohabitacion = 0;
                    if ($objRes1->fields['cohabitacion'] > 0 && $objRes1->fields['cant'] >= 2) {
                        $cohabitacion = 1;
                    }
                    /*                     * ****************************************** Hacinamaoento **************************************************** */

                    $dormitorios = $objRes1->fields['dormitorios'];
                    if ($dormitorios != 0) {
                        $hacinamiento = ($objRes1->fields['cant'] / $dormitorios);
                        if ($hacinamiento > 3) {
                            $hacinamiento = 1;
                        } else {
                            $hacinamiento = 0;
                        }
                    } else
                        $hacinamiento = 1;

                    /*                     * *************************************Ingresos********************************************* */
                    $ingresos = $objRes1->fields['ingresos'] / $objRes1->fields['cant'];
                    $arrConfiguracion['constantes']['salarioMinimo'] . "/" . ($ingresos + 1000);
                    $totalIngresos = ($arrConfiguracion['constantes']['salarioMinimo']) / ($ingresos + 1000);
                    /*                     * *************************************Dependencia Economica********************************************* */

                    $dependenciaEcon = 0;
                    $adultos = $objRes1->fields['adultos'] / $objRes1->fields['cant'];
                    //echo "<br>".$objRes1->fields['aprobadosJefe']; 
                    if ($adultos > 2 && $objRes1->fields['aprobadosJefe'] < 3) {
                        $dependenciaEcon = 1;
                    }
                    /*                     * *************************************Nivel I Menores********************************************* */
                    $menores = $objRes1->fields['cantMenores'] / $objRes1->fields['cant'];

                    /*                     * *************************************Nivel I ********************************************* */
                    $monoparentalFem = 0;
                    // echo "<br>".$objRes1->fields['mujerCabHogar']." == 1 &&". $objRes1->fields['conyugueHogar']." == 0 && ".$objRes1->fields['cantHijos']." > 0";
                    if ($objRes1->fields['mujerCabHogar'] == 1 && $objRes1->fields['conyugueHogar'] == 0 && $objRes1->fields['cantHijos'] > 0) {
                        $monoparentalFem = 1;
                    }

                    /*                     * ************************************Nivel II ********************************************* */
                    $cantAdultoMayor = $objRes1->fields['cantadultoMayor'] / $objRes1->fields['cant'];
                    $discapacidad = $objRes1->fields['cantCondEspecial'] / $objRes1->fields['cant'];
                    $grupoEtnico = 0;
                    if ($objRes1->fields['condicionEtnica'] > 0) {
                        $grupoEtnico = 1;
                    }
                    /*                     * ************************************Nivel III ********************************************* */
                    $cantAdolecentes = $objRes1->fields['adolecentes'] / $objRes1->fields['cant'];

                    $monoparentalMasc = 0;
                    if ($objRes1->fields['hombreCabHogar'] == 1 && $objRes1->fields['conyugueHogar'] == 0 && $objRes1->fields['cantHijos'] > 0) {
                        $monoparentalMasc = 1;
                    }
                    $grupoLGTBI = 0;
                    if ($objRes1->fields['grupoLgtbi'] > 0) {
                        $grupoLGTBI = 1;
                    }

                    $programa = 0;

                    if ($objRes1->fields['bolIntegracionSocial'] > 0 || $objRes1->fields['bolSecMujer'] > 0 || $objRes1->fields['bolIpes'] > 0) {
                        $programa = 1;
                    }
                    $formula = ($BLE * ($educacion * 100)) + ($RSA * ($saludSubsidiados * 100)) + ($COH * ($cohabitacion * 100)) + ($HACN * ($hacinamiento * 100)) + (100 * (1 - exp(-$totalIngresos / 52.05))) + ($TDE * ($dependenciaEcon * 100)) + ($HN12 * ($menores * 100)) + ($MCF * ($monoparentalFem * 100)) + ($HAMY * ($cantAdultoMayor * 100)) + ($CDISC * ($discapacidad * 100)) + ($HPGE * ($grupoEtnico * 100)) + ($HN18 * ($cantAdolecentes * 100)) + ($HCF * ($monoparentalMasc * 100)) + ($PLGTBI * ($grupoLGTBI * 100)) + ($PPGD * ($programa * 100));
                    ?>
                    <tr style="text-align: center">
                        <td><?= $objRes1->fields['numDocumento'] ?></td>
                        <td><?= $objRes1->fields['seqFormulario'] ?></td>
                        <td><?= $objRes1->fields['nombre'] ?></td>
                        <td>
                            <table>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                </tr>
                                    <?= ucwords(strtolower(str_replace(",", "", $objRes1->fields['edades']))) ?>
                            </table>
                        </td>

                        <td><?= $objRes1->fields['cant'] ?></td>
                        <td><?= $objRes1->fields['ingresos'] ?></td>
                        <td><?= $objRes1->fields['cantMayor'] ?></td>
                        <td><?= $objRes1->fields['aprobados'] ?></td>
                        <td <?= $style ?>><?= $educacion ?></td>
                        <td><?= $objRes1->fields['afiliacion'] ?></td>
                        <td <?= $style ?>><?= $saludSubsidiados ?></td>
                        <td <?= $style ?>><?= $cohabitacion ?></td>
                        <td <?= $style ?>><?= $hacinamiento ?></td>
                        <td <?= $style ?>><?= $totalIngresos ?></td>
                        <td <?= $style ?>><?= $objRes1->fields['adultos'] ?></td>
                        <td <?= $style ?>><?= $dependenciaEcon ?></td>
                        <td <?= $style ?>><?= $menores ?></td>            
                        <td <?= $style ?>><?= $monoparentalFem ?></td>  
                        <td <?= $style ?>><?= $cantAdultoMayor ?></td>
                        <td <?= $style ?>><?= $discapacidad ?></td>
                        <td <?= $style ?>><?= $grupoEtnico ?></td>
                        <td <?= $style ?>><?= $cantAdolecentes ?></td>
                        <td <?= $style ?>><?= $monoparentalMasc ?></td>
                        <td <?= $style ?>><?= $grupoLGTBI ?></td>
                        <td <?= $style ?>><?= $programa ?></td>
                       <!-- <td><?= ($BLE * ($educacion * 100)) ?></td>
                        <td><?= ($RSA * ($saludSubsidiados * 100)) ?></td>
                        <td><?= ($COH * ($cohabitacion * 100)) ?></td>
                         <td><?= ($HACN * ($hacinamiento * 100)) ?></td>
                         <td><?= (100 * (1 - exp(-$totalIngresos / 52.05))) ?></td>
                         <td><?= ($TDE * ($dependenciaEcon * 100)) ?></td>
                         <td><?= ($HN12 * ($menores * 100)) ?></td>
                         <td><?= ($MCF * ($monoparentalFem * 100)) ?></td>
                         <td><?= ($HAMY * ($cantAdultoMayor * 100)) ?></td>
                         <td><?= ($CDISC * ($discapacidad * 100)) ?></td>
                         <td><?= ($HPGE * ($grupoEtnico * 100)) ?></td>
                         <td><?= ($HN18 * ($cantAdolecentes * 100)) ?></td>
                         <td><?= ($HCF * ($monoparentalMasc * 100)) ?></td>
                          <td><?= ($PLGTBI * ($grupoLGTBI * 100)) ?></td>
                         <td><?= ($PPGD * ($programa * 100)) ?></td>-->

                        <td <?= $style ?>><?= $formula ?></td>
                    </tr>
        <?php
        // echo "<br>" . $objRes1->fields['seqFormulario'];
    }
    $cont++;
    $objRes1->MoveNext();
}
?>
        </table>
    </body>
</html>
